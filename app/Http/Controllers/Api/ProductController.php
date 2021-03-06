<?php

namespace App\Http\Controllers\Api;
use App\AdvertiseProduct;
use App\Favorite;
use App\Product;
use App\ProductsPhoto;
use App\Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
{
        public function index(Request $request)
        {
            $products = Product::select('id as product_id', 'name as product_name', 'price');
            $adv_products = AdvertiseProduct::select('id as product_id', 'name as product_name', 'price')
                ->union($products)
                ->inRandomOrder()
                ->where('quantity', '!=', 0)
                ->paginate(20);

            foreach ($adv_products as $key=>$value){
                $photo = ProductsPhoto::where('product_id', $value->product_id)->first();
                $adv_products[$key]["photo"] = $photo->filename;
            }
            foreach ($adv_products as $key=>$value){
                $favorite = Favorite::where('product_id', $value->product_id)
                    ->where('user_id', $request->user_id)
                    ->first();
                if ($favorite->status == null){
                    $adv_products[$key]["status"] = 0;
                }else{
                    $adv_products[$key]["status"] = $favorite->status;
                }
            }

            return response()->json($adv_products,200);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $input = $request->all();


            $validator = Validator::make($input, [
                'name' => 'required|max:50',
                'quantity' => 'required|max:100',
                'price' => 'required|max:100',
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($request->photo){
                $file = $request->photo;
                $filepath = $file->getClientOriginalName();
                Storage::disk('public_uploads')->put($filepath, file_get_contents($file));
                $input['photo'] = $filepath;
            }

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 401);
            }

            $products = Product::create($input);
            $data = $products->toArray();

            return response()->json($data, 200);
        }


        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
//
        }

        public function productDetail(Request $request){

            $product = Product::select('id', 'name', 'quantity', 'price', 'description')
                ->with('api_photo')->find($request->product_id);

            $favorite = Favorite::where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();

            if (is_null($product)) {
                $response = [
                    'message' => 'product is required, please try again.'
                ];
                return response()->json($response, 404);
            }

            if ($favorite->status == 1){
                $product["status"] = $favorite->status;
            }else{
                $product["status"] = 0;
            }
            return response()->json($product, 200);
        }

        

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Product $product)
        {
            $input = $request->all();            
            
            $validator = Validator::make($input, [
                'name' => 'required|max:50',
                'quantity' => 'required|max:100',
                'price' => 'required|max:100',
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($request->photo){
                $file = $request->photo;
                $filepath = $file->getClientOriginalName();
                Storage::disk('public_uploads')->put($filepath, file_get_contents($file));
                $input['photo'] = $filepath;
            }

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 401);
            }

            $product->update($input);
            $data = $product->toArray();

            return response()->json($data, 200);
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Product $product)
        {
            $product->delete();
            $data = $product->toArray();

            return response()->json($data, 200);
        }
}
