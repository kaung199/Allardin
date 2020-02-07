<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function barcode(Request $request){
        $products = Product::orderBy('id', 'desc')->get();
        $pds = Product::whereBetween('id', [$request->from_product, $request->to_product])->get();
        return view('barcodes.index', compact('products', 'pds'));
    }
}
