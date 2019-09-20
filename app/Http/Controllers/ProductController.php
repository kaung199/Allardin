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
    public function adminindex()
    {
        $products = Product::latest()->paginate(40);
        return view('products.adminindex',compact('products'));
    }
    public function searchproducts(Request $request)
    {
       $search =$request->search;
       $products = Product::where('name', 'LIKE', '%' . $search . '%')->get();
       $count = count($products);
       return view('products.search', compact('products','count'));       

    }

    public function productdetail($id)
    {
       $product = Product::find($id);
       return view('products.detail', compact('product'));       
    }
    
    public function userindex()
    {
        $products = Product::orderByRaw("RAND()")->get();
        return view('products.userindex',compact('products'));
    }
    public function userdetail($id) 
    {
        $product = Product::find($id);
        return view('products.usershow', compact('product'));
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

    public function edit($id, $page)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product', 'page'));
    }
    public function editdetail($id)
    {
        $product = Product::find($id);
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
        $page = $request->page_on;
        return redirect('products?page='. $page);
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
