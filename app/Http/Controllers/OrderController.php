<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Ostore;
use App\Township;
use App\User;
use App\Order_detail;
use App\Order;
use App\Product;

class OrderController extends Controller
{
    public function checkoutform() 
    {
        $townships = Township::pluck('name', 'id')->all();
        return view('orders.admincheckoutform', \compact('townships'));
    }

    public function checkout(Ostore $request) 
    {
        $cart = session()->get('cart');
        $total = 0;
        $totalquantity = 0;

       $customer =  User::create($request->all());

        foreach(session('cart') as $cart => $details) {

            $totalq = 0;
            $totalp = 0;

            $total += $details['price'] * $details['quantity'];
            $totalquantity += $details['quantity'];


            $product = Product::find($details['id']);
            $grandqty = $product->quantity - $details['quantity'];
            
            $product->update([
                'quantity' => $grandqty,
            ]);

        }

            $order = Order::create([
                'totalquantity' => $totalquantity,
                'totalprice' =>  $total,
                'orderdate' =>  date('Y-m-d'),
                'monthly' =>  date('Y-m'),
                'yearly' =>  date('Y'),
                'deliverystatus' => 1,
                'user_id' => $customer->id,
    
            ]);

        foreach(session('cart') as $cart => $details) {
        
            Order_detail::create([
                'product_id' => $details['id'],
                'name' => $details['name'],
                'quantity' =>   $details['quantity'],
                'price' =>  $details['price'],
                'totalprice' => $details['price'] * $details['quantity'],
                'user_id' => $customer->id,
                'order_id' => $order->id,

            ]);

            
        }   
        session()->forget('cart'); 

        return redirect()->route('order')->with('ordersuccess', 'Order Success!'); 
    }

    public function order()
    {
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function orderdetail($id)
    {
        $orderdetails = Order_detail::where(order_id, $id)->get();
        return view('orders.orderdetail', compact('orderdetails'));
    }

    public function destroy($id)
    {
        
    }
    public function deliverystatus($id)
    {
        // dd($id);
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2
            ]);
            return redirect()->back();
        }
        if($deliverystatus->deliverystatus == 2) {
            $deliverystatus->update([
                'deliverystatus' => 3
            ]);  
            return redirect()->back();
        }
        if($deliverystatus->deliverystatus == 3) {
            $deliverystatus->update([
                'deliverystatus' => 4
            ]); 
            return redirect()->back();
        }
        if($deliverystatus->deliverystatus == 4) {
            $deliverystatus->update([
                'deliverystatus' => 1
            ]); 
            return redirect()->back();
        }        
    }

    public function orderprepare()
    {
        $orders = Order::where(deliverystatus, 1)->get();
        return view('orders.orderprepare', compact('orders'));
    }
    public function delivery()
    {
        $orders = Order::where(deliverystatus, 2)->get();
        return view('orders.delivery', compact('orders'));  
    }
    public function payment()
    {
        $orders = Order::where(deliverystatus, 3)->get();
        return view('orders.payment', compact('orders'));
    }
    public function complete()
    {
        $orders = Order::where(deliverystatus, 4)->get();
        return view('orders.complete', compact('orders'));
    }
}
