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
          'order_id' => $order['id'],
        ]);
      }

      $response = [ 'success' => true ];
      return response()->json($response, 200);
     
    }


    public function orderdetail($id)
    {

      $order = Order::find($id)->join('users', 'users.id', '=', 'orders.user_id')
                  ->join('townships', 'townships.id', '=', 'users.township_id')
                  ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                  ->select('order_details.name as product_name',
                    'order_details.quantity',
                    'order_details.price', 
                    'order_details.totalprice', 
                    'users.name',  
                    'users.address',  
                    'users.phone',  
                    'townships.deliveryprice')
                  ->get();  
               
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


    public function deliverystatus(Request $request, $id)
    {

      $order = Order::find($id);
      $order->update([
        'deliverystatus' => $request->deliverystatus
      ]);
      $response = [ 'success' => true ];
      return response()->json($response, 200);
    }

    public function orderprepare()
    {
      $order = Order::where('deliverystatus', 1)->latest()->get();
      return response()->json($order, 200);
    }

    public function delivery()
    {
      $order = Order::where('deliverystatus', 2)->latest()->get();
      return response()->json($order, 200);
    }

    public function payment()
    {
      $order = Order::where('deliverystatus', 3)->latest()->get();
      return response()->json($order, 200);
    }

    public function complete()
    {
      $order = Order::where('deliverystatus', 4)->latest()->get();
      return response()->json($order, 200);
    }


         
}
