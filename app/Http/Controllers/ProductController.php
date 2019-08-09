<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Pstore;
use Illuminate\Support\Facades\Storage;
use Spatie\Searchable\Search;
use App\Product;
use App\User;
use App\Order;
use App\Township;
use App\ProductsPhoto;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('products.index',compact('products'));
    }

    public function userindex()
    {
        $products = Product::latest()->get();
        return view('products.userindex',compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Pstore $request)
    {         
        $product = Product::create($request->all());
        if($request->photos) {
            foreach ($request->photos as $photo) {
                $filename = $photo->getClientOriginalName();
                Storage::disk('public')->put($filename, file_get_contents($photo));
                ProductsPhoto::create([
                    'product_id' => $product->id,
                    'filename' => $filename
                ]);
            }
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
        $product->update($request->all());      

        if($request->photos) {
            foreach($product->photos as $product_photo) {
                Storage::disk('public')->delete($product_photo->filename);
            }
            $product_photos = ProductsPhoto::where('product_id', $product->id);
            $product_photos->delete();
            
            foreach ($request->photos as $photo) {
                $filename = $photo->getClientOriginalName();
                Storage::disk('public')->put($filename, file_get_contents($photo));
                ProductsPhoto::create([
                    'product_id' => $product->id,
                    'filename' => $filename
                ]);
            }
        }
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Product::class, ['name','price'])
            ->registerModel(Township::class, ['name'])
            ->registerModel(Order::class, ['order_id', 'orderdate'])
            ->registerModel(User::class, ['name', 'phone'])
            ->perform($request->input('query'));

        return view('search', compact('searchResults'));
    }
}
