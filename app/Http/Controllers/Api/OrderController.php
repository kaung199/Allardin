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
        $pro = Order_detail::create([
          'name' => $product['name'],
          'quantity' => $product['quantity'],
          'price' => $product['price'],
          'totalprice' => $product['totalprice'],
          'user_id' => $product['user_id']
        ]);
        
        $productt = Product::find($product['id']);               
        $productt->update([
             'quantity' => $productt->quantity - $product['quantity'],
         ]);

        $gtotalprice += $product['totalprice'];
        $gtotalquantity += $product['quantity'];

      }

      $order = Order::create([
        'totalquantity' => $gtotalquantity,
        'totalprice' =>  $gtotalprice,
        'user_id' => $product['user_id'],
        'deliverystatus' => 1,
      ]);

      $data1 = $order->toArray();
      $data2 = $pro->toArray();
      $data3 = $productt->toArray();
      return response()->json([$data1,$data2,$data3], 200);
     
    }


    public function orderdetail($id)
    {

      $user = User::find($id);     
      foreach($user->orderdetails as $order) {
        $userdetail = [
          'username' => $user['name'],
          'productname' => $order['name'],
          'quantity' => $order['quantity'],
          'price' => $order['price'],
          'totalprice' => $order['totalprice'],
          'deliveryprice' => $user->township['deliveryprice'],
          'grandtotal' => $order['totalprice'] + $user->township['deliveryprice'],
          'address' => $user['address'],
          'phone' => $user['phone'],
        ];
      }      
      return response()->json($userdetail, 200);

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
