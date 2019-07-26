<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Pstore;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\ProductsPhoto;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index',compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Pstore $request)
    {         
        $product = Product::create($request->all());
        foreach ($request->photos as $photo) {
            $filename = $photo->getClientOriginalName();
            Storage::disk('public')->put($filename, file_get_contents($photo));
            ProductsPhoto::create([
                'product_id' => $product->id,
                'filename' => $filename
            ]);
        }
        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        return view('products.show',\compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Pstore $request,Product $product)
    {
        if($request->photo){
            $file = $request->photo;
            $filepath = $file->getClientOriginalName();
            Storage::disk('public_uploads')->put($filepath, file_get_contents($file));
            $request->photo = $filepath;
        }
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
