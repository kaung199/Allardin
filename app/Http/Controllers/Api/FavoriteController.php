<?php

namespace App\Http\Controllers\Api;

use App\AppUser;
use App\Favorite;
use App\Product;
use App\ProductsPhoto;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function favoritePost(Request $request){
        $users = AppUser::where('id', $request->user_id)->get();
        $products = Product::where('id', $request->product_id)->get();

        if (count($users)>0){
            if (count($products)>0){
                $data = Favorite::where('user_id', $request->user_id)
                    ->where('product_id', $request->product_id)->get();

                if (count($data)>0){
                    $id = Favorite::where('user_id', $request->user_id)
                        ->where('product_id', $request->product_id)->first();
                    if ($id != null){
                        $id->delete();
                        return response()->json([
                            'message'      => 'Unfavorite',
                            'status' => 0
                        ],200);
                    }else{
                        return response()->json([
                            'message' => 'Not Found Favorites, please try again.',
                        ], 401);
                    }
                }else{
                    $favorite = new Favorite();
                    $favorite->user_id = $request->user_id;
                    $favorite->product_id = $request->product_id;
                    $favorite->status = 1;
                    $favorite->save();
                    return response()->json([
                        'message'      => 'Favorite',
                        'status' => $favorite->status
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
        $id = Favorite::with('products')
            ->select('id', 'product_id', 'status')
            ->where('user_id', $user_id)->get();
        foreach ($id as $key => $value){
            $photo = ProductsPhoto::where('product_id', $value->product_id)->first();
            $id[$key]["photo"] = $photo->filename;
        }

        if (count($id)>0){
            return response()->json($id);
        }else{
            return response()->json($id, 404);
        }
    }
}
