<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BarcodeController extends Controller
{
    public function barcode(Request $request){
        $products = Product::orderBy('id', 'desc')->get();
        $number = (int)$request->number;
        $barcode = Product::where('id',$request->product)->get();
        for($i=1; $i <= $number; $i++){
            foreach ( $barcode as $item ) {
                $barcode[] = $item;
            }
        }
        return view('barcodes.index', compact('products', 'barcode', 'number'));
    }
}
