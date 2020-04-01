<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class POSProductController extends Controller
{
    public function index(){
        $product = Product::get();
        return response()->json($product);
    }
}
