<?php

namespace App\Http\Controllers;

use App\AdvertiseProduct;
use App\AdvertiseProductPhoto;
use App\Product;
use App\ProductsPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertiseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('id', 'desc')->get();
        $adv_product = AdvertiseProduct::orderBy('id', 'desc')->get();
        return view('adv_products.index', compact('product', 'adv_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::where('id', $request->product)->first();
        $photo = ProductsPhoto::where('product_id', $product->id)->get();

        $adv_product = new AdvertiseProduct();
        $adv_product->category_id = $product->category_id;
        $adv_product->name = $product->name;
        $adv_product->code = $product->code;
        $adv_product->quantity = $product->quantity;
        $adv_product->price = $product->price;
        $adv_product->description = $product->description;
        $adv_product->save();

        if (count($photo) != 0){
            foreach ($photo as $items){
                $adv_photo = new AdvertiseProductPhoto();
                $adv_photo->filename = $items->filename;
                $adv_photo->product_id = $adv_product->id;
                $adv_photo->save();
            }
        }

        return redirect()->route('adv_products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adv_product = AdvertiseProduct::where('id', $id)->first();
        $adv_product->delete();
        $photo = AdvertiseProductPhoto::where('product_id', $adv_product->id)->get();
        if (count($photo)!= 0){
            foreach ($photo as $items){
                $items->delete();
            }
        }
        return redirect()->route('adv_products.index');
    }
}
