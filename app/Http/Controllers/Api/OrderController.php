<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
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

        $validator = Validator::make($product, [
            'name' => 'required|max:50',
            'quantity' => 'required|max:100',
            'price' => 'required|max:100',
            'totalprice' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }
        
        $productt = Product::find($product['product_id']);

        if( $productt->quantity < $product['quantity'] ) {
          $response = "Out Of Stock";
          return response()->json($response, 400);
        }  

        $productt->update([
          'quantity' => $productt->quantity - $product['quantity'],
        ]);

        $gtotalprice += $product['totalprice'];
        $gtotalquantity += $product['quantity'];

      }

      $userlocation = User::find($product['user_id']);
      $deliveryprice = $userlocation['township']['deliveryprice'];
      $order = Order::create([
        'totalquantity' => $gtotalquantity,
        'totalprice' =>  $gtotalprice + $deliveryprice,
        'orderdate' =>  date('Y-m-d'),
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
                  'orders.created_at',
                  'orders.orderdate',
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

    public function dailyorder() 
    {

        $today = Carbon::now()->toDateString();

        $todayorder = Order::where('orderdate', $today)
                      ->join('users', 'users.id', '=', 'orders.user_id')
                      ->join('townships', 'townships.id', '=', 'users.township_id')
                      ->select('orders.id as order_id',
                        'orders.totalquantity',
                        'orders.totalprice',
                        'orders.deliverystatus',
                        'orders.created_at',
                        'orders.orderdate',
                        'users.id as user_id',
                        'users.name',
                        'users.phone',
                        'users.address',
                        'townships.id as township_id',
                        'townships.name as township_name',
                        'townships.deliveryprice',
                        'townships.deliveryman')
                      ->get();

            return response()->json($todayorder, 200);    
    }

         
}
