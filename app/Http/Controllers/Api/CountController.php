<?php

namespace App\Http\Controllers\Api;

use App\Favorite;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    public function count_favorite($user_id){
        $favorite = Favorite::where('user_id', $user_id)->get();
        if (count($favorite)>0){
            return response()->json(["message" => count($favorite)]);
        }else{
            return response()->json([
                'message' => 'not found favorite, please try again.',
            ], 404);
        }
    }

    public function count_cart($user_id){
        $session = Session::where('user_id', $user_id)->get();
        if (count($session)>0){
            return response()->json(["count" => count($session)]);
        }else{
            return response()->json([
                'message' => 'not found add to cart, please try again.',
            ], 404);
        }
    }
}
