<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Session;

class CartController extends Controller
{
     public function cartadd($id)
    {
        $product = Product::find($id);
        if($product->quantity < 1) {
            return redirect()->back()->with('outofstock', 'Out of Stock');
        }
    	if(!$product) {
    		abort (404);
    	}
    	$cart = session()->get('cart');
    	if(!$cart) {
    		$cart = [
    				$id => [
    						"id" => $product->id,
    						"name" => $product->name,
    						"price" => $product->price,
    						"quantity" => 1,
    						"image" => $product->photos[0][filename],
    				]
    		];
    		session()->put('cart', $cart);
    		return redirect()->back()->with('success', "Product Added Successfully!");
        }
        
        
    	if(isset($cart[$id])) {
            if($product->quantity <= $cart[$id]['quantity']) {
                return redirect()->back()->with('outofstock', 'Out of Stock');
            }
    		$cart[$id]['quantity']++;
    		session()->put('cart', $cart);
    		return redirect()->back()->with('success', "Product Added Successfully!");
    	}
    	$cart[$id] = [
            "id" => $product->id,
    		"name" => $product->name,
    		"price" => $product->price,
    		"quantity" => 1,
    		"image" => $product->photos[0][filename],
    	];
    	session()->put('cart', $cart);
    	return redirect()->back()->with('success', "Product Added Successfully!");
    }

    public function cartview(Request $request)
    {
        return view('cartview');
    }

    public function update(Request $request)
    {
        
        if($request->id and $request->quantity and $request->pid)
        {
            $product = Product::find($request->pid);
            $cart = session()->get('cart');

            if($product->quantity <= $cart[$request->id]["quantity"]) {

                $cart[$request->id]["quantity"] = $product->quantity; 
                session()->put('cart', $cart);
                
                session()->flash('outofstock', 'Product Out Of Stock'); 
            } else {
                $cart[$request->id]["quantity"] = $request->quantity;
 
                session()->put('cart', $cart);
    
                session()->flash('success', 'Cart updated successfully');
            }

            
        }
    }

    public function updatesub(Request $request)
    {
        
        if($request->id and $request->quantity and $request->pid)
        {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;
 
            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');

            
        }
    }

    public function alldelete()
    {

        if (session('cart') != null) {
            session()->forget('cart');
        }

        return redirect()->back()->with('remove', 'All Removed successfully!');
    }

    public function remove(Request $request)
    {
       
       if($request->id) {

           $cart = session()->get('cart');

           if(isset($cart[$request->id])) {

               unset($cart[$request->id]);

               session()->put('cart', $cart);
           }

           session()->flash('success', 'Product removed successfully');
       }
    }

}
