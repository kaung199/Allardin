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
        return response()->json(["count" => count($favorite)]);
    }

    public function count_cart($user_id){
        $session = Session::where('user_id', $user_id)->get();
        return response()->json(["count" => count($session)]);
    }
}
