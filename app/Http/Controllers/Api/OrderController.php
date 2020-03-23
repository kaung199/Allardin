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
use App\AppUser;
use App\Order_detail;
use App\Session;
use DateTime;
use App\Cart_product;
use App\Cart;
use DB;

class OrderController extends Controller
{         	

    public function stor(Request $request)
    {
      $gtotalprice = 0;
      $gtotalquantity = 0;
      $products = $request->json()->all();
      foreach($products[1] as $product) {
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
      $userlocation = User::find($products[0]['user_id']);
      $deliveryprice = $userlocation['township']['deliveryprice'];
      $order = Order::create([
        'totalquantity' => $gtotalquantity,
        'totalprice' =>  $gtotalprice + $deliveryprice,
        'orderdate' =>  date('Y-m-d'),
        'monthly' =>  date('Y-m'),
        'yearly' =>  date('Y'),
        'user_id' => $products[0]['user_id'],
        'deliverystatus' => 1,
      ]);
      foreach($products[1] as $product) {
        $pro = Order_detail::create([
          'name' => $product['name'],
          'quantity' => $product['quantity'],
          'price' => $product['price'],
          'totalprice' => $product['totalprice'],
          'user_id' => $products[0]['user_id'],
          'order_id' => $order['id'],
        ]);
      }
      $response = [ 'success' => true ];
      return response()->json($response, 200);
    }

    public function session(Request $request)
    {
      $product_v = $request->all();
      $validator = Validator::make($product_v, [
        'product_id' => 'required',
        'quantity' => 'required',
        'user_id' => 'required',
      ]);

      if ($validator->fails()) {
        $response = [
            'success' => false,
            'data' => 'Validation Error.',
            'message' => $validator->errors()
        ];
        return response()->json($response, 404);
      }
    $product = Product::find($request->product_id);
    $user_null = AppUser::find($request->user_id);
    if($user_null == null) {
      $response = [
        'success' => false,
        'data' => 'Users Not Found',
    ];
      return response()->json([$response, 404]);
    }
    if($product == null) {
      $response = [
        'success' => false,
        'data' => 'Product Not Found',
    ];
      return response()->json([$response, 404]);
    }
    if($product->quantity < $request->quantity)
    {
      $response = [
        'success' => false,
        'data' => 'Out of Stock!',
    ];
      return response()->json($response, 404);
    }
    $session_user_id = Session::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
    if($session_user_id == null) {
      $session_table = Session::create([
        'product_id' => $request->product_id,
        'user_id' => $request->user_id,
        'name' => $product->name,
        'quantity' => $request->quantity,
        'price' => $product->price,
        'total_price' => $request->quantity * $product->price
      ]);

      return response()->json(['message' => "Success", 'status' => 200 ]);
    }
    $session_user_id->update([
      'quantity' => $request->quantity,
      'total_price' => $request->quantity * $product->price
    ]);
    return response()->json(['message' => "Success", 'status' => 200 ]);
    }

    public function remove_cart(Request $request)
    {
      $product_v = $request->all();
      $validator = Validator::make($product_v, [
        'product_id' => 'required',
        'user_id' => 'required',
      ]);

      if ($validator->fails()) {
        $response = [
            'success' => false,
            'data' => 'Validation Error.',
            'message' => $validator->errors()
        ];
        return response()->json($response, 404);
      }
    $session_user_id = Session::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
    $session_user_id->delete();
    return response()->json(['message'=> 'Success', 'status' => 200]);

    }

    public function show_cart(Request $request)
    {
      $user_v = $request->all();
      $validator = Validator::make($user_v, [
        'user_id' => 'required',
      ]);

      if ($validator->fails()) {
        $response = [
            'success' => false,
            'data' => 'Validation Error.',
            'message' => $validator->errors()
        ];
        return response()->json($response, 404);
      }
      $session_user_id = Session::where('user_id', $request->user_id)->get();
      if(collect($session_user_id)->isEmpty()) {
        return response()->json(['message'=>'Empty-cart', 'status'=>400 ]);
      }
      return response()->json($session_user_id, 200);




    }

    public function store(Request $request)
    {      
        $product = $request->json()->all();      

        $validator = Validator::make($product, [
          'name' => 'required',
          'phone' => 'required',
          'address' => 'required',
          'user_id' => 'required',
          'township_id' => 'required'
        ]);

        if($product['user_id'] == 0) {
          $required = 'user_id required!';
          return response()->json($required, 404); 
        }

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }


        $sessions = Session::where('user_id', $product['user_id'])->get()->toArray();

        if($sessions == null) {
          return response()->json([ 'message' => 'cart-is-empty','status' => 404]);
        }
        $datetime = new DateTime('tomorrow');
        $delivery_date= $datetime->format('Y-m-d');

        $order_cart =  Cart::create([
          'name' => $product['name'],
          'customer_status' => 1,
          'phone' => $product['phone'],
          'address' => $product['address'],
          'township_id' => $product['township_id'],
          'delivery_date' => $delivery_date,
        
        ]);
        foreach($sessions as $s) {
          $cart_product = Cart_product::create([
            'product_id' => $s['product_id'],
            'name' => $s['name'],
            'price' => $s['price'],
            'quantity' => $s['quantity'],
            'cart_id' => $order_cart->id,
          ]);
        }
        Session::where('user_id', $product['user_id'])->delete();
        return response()->json([ 'message' => 'Success','status' => 200]);
        
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
                ->latest()->get();

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
      $order = Order::where('deliverystatus', 1)
              ->join('users', 'users.id', '=', 'orders.user_id')
              ->join('townships', 'townships.id', '=', 'users.township_id')
              ->latest()
              ->select('orders.id as order_id',
                'orders.totalquantity',
                'orders.totalprice',
                'orders.deliverystatus',
                'orders.created_at',
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
      $order = Order::where('deliverystatus', 2)
              ->join('users', 'users.id', '=', 'orders.user_id')
              ->join('townships', 'townships.id', '=', 'users.township_id')
              ->latest()
              ->select('orders.id as order_id',
                'orders.totalquantity',
                'orders.totalprice',
                'orders.deliverystatus',
                'orders.created_at',
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
      $order = Order::where('deliverystatus', 3)
              ->join('users', 'users.id', '=', 'orders.user_id')
              ->join('townships', 'townships.id', '=', 'users.township_id')
              ->latest()
              ->select('orders.id as order_id',
                'orders.totalquantity',
                'orders.totalprice',
                'orders.created_at',
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
      $order = Order::where('deliverystatus', 4)
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('townships', 'townships.id', '=', 'users.township_id')
                ->latest()
                ->select('orders.id as order_id',
                  'orders.totalquantity',
                  'orders.totalprice',
                  'orders.created_at',
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
      foreach($order['orderdetails'] as $orderdetail) {
        $product = Product::find($orderdetail['product_id']);
        $product->update([
          'quantity' => $product['quantity'] + $orderdetail['quantity']
        ]);
      }
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

    public function monthlyorder() 
    {
      $today = Carbon::now()->format('Y-m');
      $todayorder = Order::where('monthly', $today)
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->join('townships', 'townships.id', '=', 'users.township_id')
                    ->select('orders.id as order_id',
                      'orders.totalquantity',
                      'orders.totalprice',
                      'orders.deliverystatus',
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

    public function yearlyorder() 
    {
      $today = Carbon::now()->format('Y');
      $todayorder = Order::where('yearly', $today)
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->join('townships', 'townships.id', '=', 'users.township_id')
                    ->select('orders.id as order_id',
                      'orders.totalquantity',
                      'orders.totalprice',
                      'orders.deliverystatus',
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

    public function search(Request $request) 
    {
      $product_search = $request->search;
      $products = Order::where('deliverystatus', 4)
                  ->where(function ($gg) {
                          global $product_search;
                          $gg->where('orderdate', 'LIKE', '%' . $product_search . '%')
                          ->orWhere('monthly', 'LIKE', '%' . $product_search . '%')
                          ->orWhere('yearly', 'LIKE', '%' . $product_search . '%');
                  })            
                  ->join('users', 'users.id', '=', 'orders.user_id')
                  ->join('townships', 'townships.id', '=', 'users.township_id')
                  ->select('orders.id as order_id',
                    'orders.totalquantity',
                    'orders.totalprice',
                    'orders.deliverystatus',
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
      return response()->json($products, 200);     
    }
         
}
