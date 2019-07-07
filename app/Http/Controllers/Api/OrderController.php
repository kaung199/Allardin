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

      $order = Order::where('orders.id', $id)
                  ->join('users', 'users.id', '=', 'orders.user_id')
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

      $orders = Order::orderBy('orders.id', 'desc')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('townships', 'townships.id', '=', 'users.township_id')
                ->select('orders.id as order_id',
                  'orders.totalquantity',
                  'orders.totalprice',
                  'orders.deliverystatus',
                  'users.id as user_id',
                  'users.name',
                  'users.phone',
                  'users.address',
                  'townships.id as township_id',
                  'townships.name as township_name',
                  'townships.deliveryprice',
                  'townships.deliveryman')
                ->get();

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
      $order = Order::orderBy('orders.id', 'desc')->where('deliverystatus', 1)
              ->join('users', 'users.id', '=', 'orders.user_id')
              ->join('townships', 'townships.id', '=', 'users.township_id')
              ->select('orders.id as order_id',
                'orders.totalquantity',
                'orders.totalprice',
                'orders.deliverystatus',
                'users.id as user_id',
                'users.name',
                'users.phone',
                'users.address',
                'townships.id as township_id',
                'townships.name as township_name',
                'townships.deliveryprice',
                'townships.deliveryman')
              ->get();
              
      return response()->json($order, 200);
    }

    public function delivery()
    {
      $order = Order::orderBy('orders.id', 'desc')->where('deliverystatus', 2)
              ->join('users', 'users.id', '=', 'orders.user_id')
              ->join('townships', 'townships.id', '=', 'users.township_id')
              ->select('orders.id as order_id',
                'orders.totalquantity',
                'orders.totalprice',
                'orders.deliverystatus',
                'users.id as user_id',
                'users.name',
                'users.phone',
                'users.address',
                'townships.id as township_id',
                'townships.name as township_name',
                'townships.deliveryprice',
                'townships.deliveryman')
              ->get();
      return response()->json($order, 200);
    }

    public function payment()
    {
      $order = Order::orderBy('orders.id', 'desc')->where('deliverystatus', 3)
              ->join('users', 'users.id', '=', 'orders.user_id')
              ->join('townships', 'townships.id', '=', 'users.township_id')
              ->select('orders.id as order_id',
                'orders.totalquantity',
                'orders.totalprice',
                'orders.deliverystatus',
                'users.id as user_id',
                'users.name',
                'users.phone',
                'users.address',
                'townships.id as township_id',
                'townships.name as township_name',
                'townships.deliveryprice',
                'townships.deliveryman')
              ->get();
      return response()->json($order, 200);
    }

    public function complete()
    {
      $order = Order::orderBy('orders.id', 'desc')->where('deliverystatus', 4)
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('townships', 'townships.id', '=', 'users.township_id')
                ->select('orders.id as order_id',
                  'orders.totalquantity',
                  'orders.totalprice',
                  'orders.deliverystatus',
                  'users.id as user_id',
                  'users.name',
                  'users.phone',
                  'users.address',
                  'townships.id as township_id',
                  'townships.name as township_name',
                  'townships.deliveryprice',
                  'townships.deliveryman')
                ->get();
      return response()->json($order, 200);
    }

    public function deleteorder($id)
    {
      $order = Order::find($id);
      $order->delete();
      $response = [ 'success' => true ];
      return response()->json($response, 200);
    }


         
}
