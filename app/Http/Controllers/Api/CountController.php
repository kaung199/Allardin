<?php

namespace App\Http\Controllers\Api;

use App\Favorite;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    public function count_favorite(){
        $favorite = Favorite::get();
        return response()->json(["count" => count($favorite)]);
    }

    public function count_cart(){
        $session = Session::get();
        return response()->json(["count" => count($session)]);
    }
}
