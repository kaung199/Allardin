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
            $users = User::all();
            $data = $users->toArray();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'User retrieved successfully.'
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
                'phone' => 'required',
                'address' => 'required',
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

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Township stored successfully.'
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


            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'User retrieved successfully.'
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
        public function update(Request $request, User $user)
        {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required'
            ]);

            if ($validator->fails()) {
                $response = [
                    'success' => false,
                    'data' => 'Validation Error.',
                    'message' => $validator->errors()
                ];
                return response()->json($response, 404);
            }
            
            $user->update($input);
            $data = $user->toArray();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'User updated successfully.'
            ];

            return response()->json($response, 200);
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(User $user)
        {
            $user->delete();
            $data = $user->toArray();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'User deleted successfully.'
            ];

            return response()->json($response, 200);
        }
}
