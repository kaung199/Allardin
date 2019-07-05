<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\Order;
use App\Township;
use App\Order_detail;

class OrderController extends Controller
{         	


    public function store(Request $request)
    {

      $gtotalprice = 0;
      $gtotalquantity = 0;
      $products = $request->json()->all();

      foreach($products as $product) {
        
        $productt = Product::find($product['product_id']);               
        $productt->update([
             'quantity' => $productt->quantity - $product['quantity'],
         ]);

        $gtotalprice += $product['totalprice'];
        $gtotalquantity += $product['quantity'];

      }

      $userlocation = User::find($product['user_id']);
      $deliveryprice = $userlocation->township['deliveryprice'];

      $order = Order::create([
        'totalquantity' => $gtotalquantity,
        'totalprice' =>  $gtotalprice + $deliveryprice,
        'user_id' => $product['user_id'],
        'deliverystatus' => 1,
      ]);

      foreach($products as $product) {
        $pro = Order_detail::create([
          'name' => $product['name'],
          'quantity' => $product['quantity'],
          'price' => $product['price'],
          'totalprice' => $product['totalprice'],
          'user_id' => $product['user_id'],
          'order_id' => $product['id'],
        ]);

      }

      $data1 = $order->toArray();
      $data2 = $pro->toArray();
      $data3 = $productt->toArray();
      return response()->json([$data1,$data2,$data3], 200);
     
    }


    public function orderdetail($id)
    {

      $order = Order::find($id);         
      $order->orderdetails;  
      $order->user;     
      $order->user->township;          
      return response()->json($order, 200);

    }


    public function orders()
    {

      $orders = Order::latest()->get();
      foreach($orders as $od) {        
        $od->user;
        $od->user['township'];          
      }

      return response()->json($orders, 200);
      
    }


         
}
