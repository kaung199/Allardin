<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Cart_product;
use App\Cart;

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

    public function cartadd_cart_order($id, $o_id)
    {
        $product = Product::find($id);
        if($product->quantity <= 0) {
            return redirect()->back()->with('outofstock', 'Product Out of Stock!');
        }
        $cart_product = Cart_product::where('product_id', $id)->where('cart_id',$o_id)->first();
        $product->update([
            'quantity' => $product->quantity - 1,
        ]);
        if($cart_product != null) {
            $cart_product->update([
                'price' => $product->price,
                'quantity' => $cart_product->quantity + 1,
            ]);
        } else {
            Cart_product::create([
                'product_id' => $id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
                'cart_id' => $o_id,
            ]);
        }
        
        session()->forget('order_cart');
        return redirect()->route('orders.order_cart_editp', $o_id);
    }

    public function cartview(Request $request)
    {
        return view('cartview');
    }
    public function admincartview(Request $request)
    {
        return view('admincartview');
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
    public function update_order_cart(Request $request)
    {
        if($request->id and $request->quantity and $request->pid)
        {
            $product = Product::find($request->pid);

            if($product->quantity <= $request->quantity) { 
                return session()->flash('outofstock', 'Product Out Of Stock');

            } else {
 
               $cart_product = Cart_product::find($request->id);
               $product = Product::find($request->pid);

               if($cart_product->quantity >  $request->quantity) {
                   
                    $balance = $cart_product->quantity -  $request->quantity;
                    $product->update([
                        'quantity' => $product->quantity - $balance,
                    ]);

               } else {

                    $bal= $request->quantity -  $cart_product->quantity;
                    $pb = $product->quantity - $bal;
                    $product->update([
                        'quantity' => $pb,
                    ]);

               }

               $cart_product->update([
                   'quantity' => $request->quantity,
               ]);
    
            }

            
        }
    }

    public function updatesub(Request $request)
    {
        
        if($request->id and $request->quantity and $request->pid)
        {
            $product = Product::find($request->pid);

            if($product->quantity <= $request->quantity) { 
                return session()->flash('outofstock', 'Product Out Of Stock');

            } else {
                $cart = session()->get('cart');

                $cart[$request->id]["quantity"] = $request->quantity;
    
                session()->put('cart', $cart);

                session()->flash('success', 'Cart updated successfully');
            }

            
        }
    }
    public function update_order_cart_sub(Request $request)
    {
        
        if($request->id and $request->quantity and $request->pid)
        {
            $product = Product::find($request->pid);

            if($product->quantity <= $request->quantity) { 
                return session()->flash('outofstock', 'Product Out Of Stock');

            } else {
                $cart_product = Cart_product::find($request->id);

                if($cart_product->quantity >  $request->quantity) {
                        $balance = $cart_product->quantity -  $request->quantity;
                        $product->update([
                            'quantity' => $product->quantity + $balance,
                        ]);
                } else {
                        $bal= $request->quantity -  $cart_product->quantity;
                        $product->update([
                            'quantity' => $product->quantity + $bal,
                        ]);
                }
                $cart_product->update([
                    'quantity' => $request->quantity,
                ]);
            }

            
            
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
    public function remove_order_cart(Request $request)
    {
       
       if($request->id) {

        $cart_product = Cart_product::find($request->id);
        $cart_product->delete();
           session()->flash('remove_order_cart', 'Product removed successfully');
       }
    }

}
