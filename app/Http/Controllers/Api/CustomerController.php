<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
        {
            $users = User::orderBy('name', 'ASC')->get();
            $data = $users->toArray();

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
                'phone' => 'required|max:40',
                'address' => 'required|max:2048',
                'township_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }

            $users = User::create($input);
            $data = $users->toArray();

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
            $user = User::find($id);
            $data = $user->toArray();

            if (is_null($user)) {
                $response = [
                    'success' => false,
                    'data' => 'Empty',
                    'message' => 'User not found.'
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
        public function update(Request $request, $id)
        {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required|max:50',
                'phone' => 'required|max:40',
                'address' => 'required|2048',
                'township_id' => 'required'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }

            $user = User::find($id);
            $user->update($input);
            $data = $user->toArray();

            return response()->json($data, 200);
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $user = User::find($id);
            $user->delete();
            $data = $user->toArray();
            return response()->json($data, 200);
        }
}
