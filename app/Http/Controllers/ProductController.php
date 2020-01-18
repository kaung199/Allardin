<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Pstore;
use App\Http\Requests\uPstore;
use Illuminate\Support\Facades\Storage;
use Spatie\Searchable\Search;
use App\Product;
use App\Category;
use App\User;
use Excel;
use App\Order;
use Auth;
use App\Township;
use App\ProductsPhoto;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('products.index',compact('products'));
    }
    public function cart_product($id)
    {
        $cart = session()->get('order_cart');
        session()->put('order_cart', $id);
        $products = Product::latest()->paginate(15);
        if(Auth()->user()->role_id ==2) {
            return view('products.adminindex',compact('products'));
        } else {
            return view('products.index',compact('products'));
        }

    }
    public function adminindex()
    {
        $products = Product::latest()->paginate(10);
        return view('products.adminindex',compact('products'));
    }
    public function searchproducts(Request $request)
    {
       $search =$request->search;
       $products = Product::where('name', 'LIKE', '%' . $search . '%')->get();
       $count = count($products);
       return view('products.search', compact('products','count'));       

    }
    public function productssearch(Request $request)
    {
       $search =$request->search;
       $products = Product::where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('price', 'LIKE', '%' . $search . '%')->get();
       $count = count($products);
       return view('products.userindex', compact('products','count'));       

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
        $category = Category::pluck('name', 'id')->all();

        $id = Product::latest()->first();

        if (isset($id)){
            $code = $id->id + 1;
            return view('products.create',compact('category', 'code'));
        }
        return view('products.create', compact('category'));

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
        if(Auth::user()->role_id == 1) {
            $category = Category::pluck('name', 'id')->all();
            $product = Product::find($id);
            return view('products.edit', compact('product', 'page', 'category'));
        } else {
            return redirect()->back()->with('permission', 'Permission Deny');
        }
                
        
    }
    public function editdetail($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    public function update(uPstore $request,Product $product)
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
        if(Auth::user()->role_id == 1) {
            $product->delete();
            return redirect()->route('products.index');
        } else {
            return redirect()->back()->with('permission', 'Permission Deny');
        }
        
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

    public function product_export() 
    {
        $products = Product::select('products.id', 'products.code', 'products.category_id', 'products.name', 'products.price', 'products.description')->get()->toArray(); 
        return Excel::create('Aladdin(Products)', function($excel) use ($products) {
            $excel->sheet('Aladdin', function($sheet) use ($products) {
                $sheet->fromArray($products);
            });
        })->download('xlsx'); 
    }
}
