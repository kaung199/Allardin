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
        if ($request->user_id == null){
            return response()->json([
                'message' => 'user is required, please try again.'
            ], 404);
        }elseif ($request->product_id == null){
            return response()->json([
                'message' => 'product is required, please try again.'
            ], 404);
        }
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
                            'message'      => 'unfavorite',
                            'status' => 0
                        ],200);
                    }else{
                        return response()->json([
                            'message' => 'not found favorites, please try again.',
                        ], 404);
                    }
                }else{
                    $favorite = new Favorite();
                    $favorite->user_id = $request->user_id;
                    $favorite->product_id = $request->product_id;
                    $favorite->status = 1;
                    $favorite->save();
                    return response()->json([
                        'message'      => 'favorite',
                        'status' => $favorite->status
                    ], 200);
                }
            }else{
                return response()->json([
                    'message' => 'not found products, please try again.',
                ], 404);
            }
        }else{
            return response()->json([
                'message' => 'not found users, please try again.',
            ], 404);
        }

    }

    public function myFavorites(Request $request){
        if ($request->user_id == null){
            return response()->json([
                'message' => 'user is required, please try again.'
            ], 404);
        }
        $users = AppUser::where('id', $request->user_id)->get();
        if (count($users)>0){
            $id = Favorite::with('products')
                ->select('id', 'product_id', 'status')
                ->where('user_id', $request->user_id)->get();
            foreach ($id as $key => $value){
                $photo = ProductsPhoto::where('product_id', $value->product_id)->first();
                $id[$key]["photo"] = $photo->filename;
            }

            if (count($id)>0){
                return response()->json($id);
            }else{
                return response()->json([
                    'message' => 'Your favorite is empty, please try again.',
                ], 404);
            }
        }else{
            return response()->json([
                'message' => 'not found users, please try again.',
            ], 404);
        }
    }
}
