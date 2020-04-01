<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\ProductsPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class POSProductController extends Controller
{
    public function index(){
        $product = Product::paginate(10);
        foreach ($product as $key => $value){
            $photo = ProductsPhoto::where('product_id', $value->id)->first();
            $product[$key]["image"] = $photo->filename;
        }
        return response()->json($product);
    }
}
