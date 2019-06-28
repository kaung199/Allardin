<?php

namespace App\Http\Controllers\Api;
use App\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
        {
            $products = Product::latest()->get();
            $data = $products->toArray();
            return response()->json($data, 200);
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
                'quantity' => 'required',
                'price' => 'required',
                'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($request->photo){
                $file = $request->photo;
                $filepath = $file->getClientOriginalName();
                Storage::disk('public')->put($filepath, file_get_contents($file));
                $input['photo'] = $filepath;
            }

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
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
            $product = Product::find($id);
            $data = $product->toArray();

            if (is_null($product)) {
                $response = [
                    'success' => false,
                    'data' => 'Empty',
                    'message' => 'Product not found.'
                ];
                return response()->json($response, 404);
            }

            return response()->json($data, 200);
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
                'quantity' => 'required',
                'price' => 'required',
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
                return response()->json($response, 404);
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
