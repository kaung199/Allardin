<?php

namespace App\Http\Controllers\Api;

use App\Favorite;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function favoritePost(Request $request){
        $users = User::where('id', $request->user_id)->get();
        $products = Product::where('id', $request->product_id)->get();

        if (count($users)>0){
            if (count($products)>0){
                $data = Favorite::where('user_id', $request->user_id)
                    ->where('product_id', $request->product_id)->get();

                if (count($data)>0){
                    return response()->json([
                        'message' => 'Not Found Favorites, please try again.',
                    ], 401);
                }else{
                    $favorite = new Favorite();
                    $favorite->user_id = $request->user_id;
                    $favorite->product_id = $request->product_id;
                    $favorite->save();
                    return response()->json([
                        'message'      => 'Success'
                    ], 200);
                }
            }else{
                return response()->json([
                    'message' => 'Not Found Products, please try again.',
                ], 401);
            }
        }else{
            return response()->json([
                'message' => 'Not Found Users, please try again.',
            ], 401);
        }

    }

    public function myFavorites($user_id){
        $id = Favorite::where('user_id', $user_id)->get();
        if (count($id)>0){
            return response()->json($id);
        }else{
            return response()->json($id);
        }
    }

    public function unFavoritePost(Request $request){
        $users = User::where('id', $request->user_id)->get();
        $products = Product::where('id', $request->product_id)->get();

        if (count($users)>0) {
            if (count($products) > 0) {
                $id = Favorite::where('user_id', $request->user_id)
                    ->where('product_id', $request->product_id)->first();
                if ($id != null){
                    $id->delete();
                    return response()->json([
                        'message'      => 'Success'
                    ],200);
                }else{
                    return response()->json([
                        'message' => 'Not Found Favorites, please try again.',
                    ], 401);
                }
            }else{
                return response()->json([
                    'message' => 'Not Found Products, please try again.',
                ], 401);
            }
        }else{
            return response()->json([
                'message' => 'Not Found Users, please try again.',
            ], 401);
        }
    }
}
