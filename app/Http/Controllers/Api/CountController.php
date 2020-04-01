<?php

namespace App\Http\Controllers\Api;

use App\AppUser;
use App\Favorite;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    public function count_favorite(Request $request){
        if ($request->user_id == null){
            return response()->json([
                'message' => 'user is required, please try again.'
            ], 404);
        }
        $users = AppUser::where('id', $request->user_id)->get();
        if (count($users)>0){
            $favorite = Favorite::where('user_id', $request->user_id)->get();
            if (count($favorite)>0){
                return response()->json(["count" => count($favorite)]);
            }else{
                return response()->json([
                    'count' => 0,
                ], 404);
            }
        }else{
            return response()->json([
                'message' => 'not found users, please try again.',
            ], 404);
        }
    }

    public function count_cart(Request $request){
        if ($request->user_id == null){
            return response()->json([
                'message' => 'user is required, please try again.'
            ], 404);
        }
        $users = AppUser::where('id', $request->user_id)->get();
        if (count($users)>0){
            $session = Session::where('user_id', $request->user_id)->get();
            if (count($session)>0){
                return response()->json(["count" => count($session)]);
            }else{
                return response()->json([
                    'count' => 0,
                ], 404);
            }
        }else{
            return response()->json([
                'message' => 'not found users, please try again.',
            ], 404);
        }

    }
}
