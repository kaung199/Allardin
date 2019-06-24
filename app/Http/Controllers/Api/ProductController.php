<?php

namespace App\Http\Controllers\Api;
use App\Product;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
        {
            $products = Product::all();
            $data = $products->toArray();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Product retrieved successfully.'
            ];

            return response()->json($response, 200);
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
                'name' => 'required',
                'quantity' => 'required',
                'price' => 'required'
            ]);

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

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Product stored successfully.'
            ];

            return response()->json($response, 200);
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


            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Product retrieved successfully.'
            ];

            return response()->json($response, 200);
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
                'name' => 'required',
                'quantity' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }

            // $product->name = $input['name'];
            // $product->decription = $input['decription'];
            // $product->save();
            $product->update($input);
            $data = $product->toArray();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Product updated successfully.'
            ];

            return response()->json($response, 200);
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

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Product deleted successfully.'
            ];

            return response()->json($response, 200);
        }
}
