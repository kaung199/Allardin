<?php

namespace App\Http\Controllers\Api;
use App\Favorite;
use App\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
{
        public function index()
        {
            $products = Product::join('products_photos', 'products.id', '=', 'products_photos.product_id')
                ->select('products.id as product_id', 'products.name as product_name', 'price', 'products_photos.filename as photo')
                ->inRandomOrder()
                ->where('quantity', '!=', 0)
                ->paginate(10);
            return response()->json($products, 200);
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
            $product = Product::with('photos')->find($id);
            $favorite = Favorite::where('product_id', $id)->first();
            $product["status"] = $favorite->status;

            if (is_null($product)) {
                $response = [
                    'success' => false,
                    'data' => 'Empty',
                    'message' => 'Product not found.'
                ];
                return response()->json($response, 401);
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
