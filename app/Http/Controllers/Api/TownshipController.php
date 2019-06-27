<?php

namespace App\Http\Controllers\Api;

use App\Township;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TownshipController extends Controller
{
    public function index()
        {
            $townships = Township::orderBy('name', 'ASC')->get();
            $data = $townships->toArray();

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
                'name' => 'required',
                'deliveryprice' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }

            $townships = Township::create($input);
            $data = $townships->toArray();

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
            $township = Township::find($id);
            $data = $township->toArray();

            if (is_null($township)) {
                $response = [
                    'success' => false,
                    'data' => 'Empty',
                    'message' => 'Township not found.'
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
        public function update(Request $request, Township $township)
        {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'deliveryprice' => 'required'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }
            
            $township->update($input);
            $data = $township->toArray();
            
            return response()->json($data, 200);
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Township $township)
        {
            $township->delete();
            $data = $township->toArray();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Township deleted successfully.'
            ];

            return response()->json($response, 200);
        }
}
