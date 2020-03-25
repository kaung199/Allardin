<?php

namespace App\Http\Controllers\Api;

use App\AppUser;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
        public function index()
        {
            $users = AppUser::latest()->get();

            return response()->json($users, 200);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $users = AppUser::where('phone', $request->phone)->get();
            if (count($users)>0){
                return response()->json(['message' => 'Phone is duplicate'], 401);
            }else{
                $user = new AppUser();
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->address = $request->address;
                $user->save();
//                $file = $request->file('image');
//                if (isset($file)){
//                    $extension = $file->getClientOriginalExtension();
//                    $filename = time() . '.' . $extension;
//                    $request->image->storeAs('public/user/', $filename);
//                    $user->image = $filename;
//                }
                if($user) {
                    return response()->json([
                        'id'         => $user->id,
                        'message'      => 'Success',
                    ],200);
                } else {
                    return response()->json([
                        'message' => 'Registration failed, please try again.',
                    ], 401);
                }
            }
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $user = AppUser::find($id);

            if (is_null($user)) {
                $response = [
                    'success' => false,
                    'data' => 'Empty',
                    'message' => 'User not found.'
                ];
                return response()->json($response, 401);
            }

            return response()->json($user, 200);
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
