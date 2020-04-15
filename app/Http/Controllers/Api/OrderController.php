<?php

namespace App\Http\Controllers\Api;

use App\AppCard;
use App\AppCardProduct;
use App\ProductsPhoto;
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
          $response = "out of stock, please try again.";
          return response()->json($response, 404);
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
      if($product_v['user_id'] == null) {
        $required = 'user is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      if($product_v['product_id'] == null) {
        $required = 'product is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      if($product_v['quantity'] == null) {
        $required = 'quantity is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      $product = Product::find($request->product_id);
      $user_null = AppUser::find($request->user_id);
      if($user_null == null) {
        return response()->json(['message' => 'not found users, please try again.'], 404);
      }
      if($product == null) {
        return response()->json(['message' => "not found products, please try again."], 404);
      }
      if( $request->quantity == 0)
      {
        return response()->json(['message' => 'quantity must be greather than zero!'], 404);
      }

      $session_user_id = Session::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();

        if(isset($request->status)) {
            $sum = $request->quantity + $session_user_id->quantity;
            if($product->quantity < $sum){
                return response()->json(
                    [
                        'quantity' => $session_user_id->quantity,
                        'price' => $session_user_id->price,
                        'total_price' => $session_user_id->total_price,
                        'message' => 'out of stock, please try again.'
                    ], 404);
            }
        }else{
            if($product->quantity < $request->quantity){
                return response()->json(
                    [
                        'message' => 'out of stock, please try again.'
                    ], 404);
            }
        }

      if($session_user_id == null) {
        $session_table = Session::create([
          'product_id' => $request->product_id,
          'user_id' => $request->user_id,
          'name' => $product->name,
          'quantity' => $request->quantity,
          'price' => $product->price,
          'total_price' => $request->quantity * $product->price
        ]);

        return response()->json([
            'message' => "add to cart"
        ], 200);
      }else{
          if(isset($request->status)) {
              $session_user_id->update([
                  'quantity' => $request->quantity,
                  'total_price' => $request->quantity * $product->price
              ]);
              return response()->json([
                  'quantity' => $request->quantity,
                  'price' => $product->price,
                  'total_price' => $request->quantity * $product->price
              ], 200);
          } else {
              $session_user_id->update([
                  'quantity' => $session_user_id->quantity + $request->quantity,
                  'total_price' => $session_user_id->total_price + $request->quantity * $product->price
              ]);
              return response()->json([
                  'message' => "add to cart"
              ], 200);
          }
      }

    }

    public function remove_cart(Request $request)
    {
      $product_v = $request->all();
      if($product_v['user_id'] == null) {
        $required = 'user is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      if($product_v['product_id'] == null) {
        $required = 'product is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }

      $product = Product::find($request->product_id);
      $user_null = AppUser::find($request->user_id);
      if($user_null == null) {
        return response()->json(['message' => 'not found users, please try again.'], 404);
      }
      if($product == null) {
        return response()->json(['message' => "not found products, please try again."],404);
      }
      $session_user_id = Session::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
      if($session_user_id == null) {
        return response()->json(['message' => "Your cart is empty, please try again."],404);
      }
      $session_user_id->delete();
      return response()->json(['message'=> 'success'],200);

    }

    public function show_cart(Request $request)
    {
      $user_v = $request->all();

      if($user_v['user_id'] == null) {
        $required = 'user is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }

      $user_null = AppUser::find($request->user_id);
      if($user_null == null) {
        return response()->json(['message' => 'not found users, please try again.'], 404);
      }

      $session_user_id = Session::select('id', 'product_id', 'name', 'quantity', 'price', 'total_price')
            ->where('user_id', $request->user_id)->get();
        foreach ($session_user_id as $key => $value){
            $photo = ProductsPhoto::where('product_id', $value->product_id)->first();
            $session_user_id[$key]["photo"] = $photo->filename;
        }

        if (count($session_user_id)>0){
            return response()->json($session_user_id);

        }else{
            return response()->json([
                'message' => 'Your cart is empty, please try again.',
            ], 404);
        }

    }

    public function store(Request $request)
    {      
        $product = $request->all();   
        if($product['user_id'] == null) {
          $required = 'user is required, please try again.';
          return response()->json(['message' => $required ], 404);
        }
        if($product['name'] == null) {
          $required = 'name is required, please try again.';
          return response()->json(['message' => $required ], 404);
        }
        if($product['phone'] == null) {
          $required = 'phone is required, please try again.';
          return response()->json(['message' => $required ], 404);
        }
        if($product['address'] == null) {
          $required = 'address is required, please try again.';
          return response()->json(['message' => $required ], 404);
        }

        if($product['township_id'] == null) {
          $required = 'township is required, please try again.';
          return response()->json(['message' => $required ], 404);
        }

        $user_null = AppUser::find($product['user_id']);
        $t_null = Township::find($product['township_id']);
        if($user_null == null) {
          return response()->json(['message' => 'not found users, please try again.'],404);
        } 

        if($t_null == null) {
          return response()->json(['message' => 'not found township, please try again.'], 404);
        }

        $sessions = Session::where('user_id', $product['user_id'])->get()->toArray();

        if($sessions == null) {
          return response()->json([ 'message' => 'Your cart is empty, please try again.'], 404);
        }
        foreach($sessions as $s) {

          $product_qv = Product::find($s['product_id']);
          if($s['quantity'] > $product_qv->quantity) {
            return response()->json([ 'message' => $s['name']. ' quantity must be less than '. $product_qv->quantity],401);
          }
          
        }
        $datetime = new DateTime('tomorrow');
        $delivery_date= $datetime->format('Y-m-d');

        $order_cart =  Cart::create([  
          'name' => $product['name'],
          'app_user_id' => $product['user_id'],
          'customer_status' => 1,
          'phone' => $product['phone'],
          'address' => $product['address'],
          'township_id' => $product['township_id'],
          'delivery_date' => $delivery_date,
        ]);

        foreach($sessions as $s) {
          $cart_product = Cart_Product::create([
            'product_id' => $s['product_id'],
            'name' => $s['name'],
            'price' => $s['price'],
            'quantity' => $s['quantity'],
            'cart_id' => $order_cart->id,
          ]);

          $product_q = Product::find($s['product_id']);
          $grandqty = $product_q->quantity - $s['quantity'];
          
          $product_q->update([
              'quantity' => $grandqty,
          ]);
        }
        Session::where('user_id', $product['user_id'])->delete();
         
        
        return response()->json([ 'message' => 'success'],200);
        
    }

    public function orderdetail(Request $request)
    {
      if($request->order_id == null) {
        $required = 'order_id is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }

      $order_null = Order::find($request->order_id);
      if($order_null == null) {
        return response()->json(['message' => 'not found orders, please try again.'],404);
      } 

      $order = Order::where('orders.id', $request->order_id)
                  ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                  ->select('order_details.name as product_name',
                    'order_details.quantity',
                    'order_details.product_id',
                    'order_details.price', 
                    'order_details.totalprice')
                  ->get();

      foreach ($order as $key=>$value){
        $photo = ProductsPhoto::where('product_id', $value->product_id)->first();
        $order[$key]["photo"] = $photo->filename;
      }

      $grand_total = 0;
      foreach($order as $o) {
        $grand_total += $o->totalprice ;
      }
      
      $user = User::find($order_null->user_id);
      $user_info   = [
        'delivery_price' => $user->township->deliveryprice,
        'name' => $user->name,
        'phone' => $user->phone,
        'address' => $user->address,
      ];
      $grand_total_price   = $grand_total + $user->township->deliveryprice;

      
               
      return response()->json([
        'order_details' =>  $order, 
        'user_info'  =>  $user_info,
        'grand_total_price'  =>  $grand_total_price
      ], 200);
    }

    public function orders(Request $request)
    {
      if($request->user_id == null) {
        $required = 'user is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      $user_null = AppUser::find($request->user_id);

      if($user_null == null) {
        return response()->json(['message' => 'not found users, please try again.'],404);
      } 

      $orders = Order::orderBy('orders.id', 'desc')
                      ->where('orders.app_user_id', $request->user_id)
                      ->select('id',
                        'order_id',
                        'user_id as order_user_id',
                        'totalquantity',
                        'totalprice',
                        'created_at as order_date'
                        )
                      ->get();
      foreach ($orders as $key=>$value){
        $user = User::where('id', $value->order_user_id)->first();
        $orders[$key]['user_name'] = $user->name;
        $orders[$key]['phone'] = $user->phone;
        $orders[$key]['address'] = $user->address;
        $orders[$key]['deliveryprice'] = $user->township->deliveryprice;
        $value->totalprice += $user->township->deliveryprice;
      }
      if (count($orders)>0){
          return response()->json($orders, 200);
      }else{
          return response()->json(['message' => 'Your order is empty, please try again.'],404);
      }

    }

    public function ordersPending(Request $request)
    {
      if($request->user_id == null) {
        $required = 'user is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      $user_null = AppUser::find($request->user_id);

      if($user_null == null) {
        return response()->json(['message' => 'not found users, please try again.'],404);
      } 

      $orders = Cart::orderBy('cart.id', 'desc')
                      ->where('cart.app_user_id', $request->user_id)
                      ->join('cart_product', 'cart.id', '=', 'cart_product.cart_id')
                      ->join('townships', 'cart.township_id', '=', 'townships.id')
                      ->select(
                        'cart.id as cart_id','cart.created_at as order_date', 'townships.deliveryprice', 
                        DB::raw("SUM(cart_product.quantity) as quantity"), 
                        DB::raw("SUM(cart_product.price * cart_product.quantity) + townships.deliveryprice as totalprice"))
                      ->groupBy('cart.id')
                      ->groupBy('townships.deliveryprice')
                      ->groupBy('cart.created_at')->get();
        foreach ($orders as $key=>$value){
          $user = Cart::where('id', $value->cart_id)->first();
          $orders[$key]['user_name'] = $user->name;
          $orders[$key]['phone'] = $user->phone;
          $orders[$key]['address'] = $user->address;
          $orders[$key]['deliveryprice'] = $user->township->deliveryprice;
          $value->totalprice += $user->deliveryprice;
        }
      if (count($orders)>0){
        return response()->json($orders, 200);
      }else{
          return response()->json(['message' => 'Your order-pending is empty, please try again.'],404);
      }   
    }
    public function ordersPendingDetail(Request $request)
    {
      if($request->cart_id == null) {
        $required = 'cart_id is required, please try again.';
        return response()->json(['message' => $required ], 404);
      }
      $cart_null = Cart::find($request->cart_id);
      if($cart_null == null) {
        return response()->json(['message' => 'not found cart, please try again.'],404);
      } 
      $orders = Cart_product::where('cart_product.cart_id', $request->cart_id)
                    ->join('products', 'cart_product.product_id', '=', 'products.id')
                      ->select(
                        'products.id as product_id',
                        'cart_product.name as product_name',
                        'cart_product.quantity as product_quantity',
                        'cart_product.price as product_price',
                        DB::raw("cart_product.quantity * cart_product.price as totalprice"))->get();
      foreach ($orders as $key=>$value){
        $photo = ProductsPhoto::where('product_id', $value->product_id)->first();
        $orders[$key]["photo"] = $photo->filename;
      }

      $grand_total = 0;
      foreach($orders as $o) {
        $grand_total += $o->totalprice;
      }

      $township = Township::find($cart_null->township_id);
                      
      $user_info   = [
        'delivery_price' => $township->deliveryprice,
        'name' => $cart_null->name,
        'phone' => $cart_null->phone,
        'address' => $cart_null->address,
      ];
      $grand_total_price   = $township->deliveryprice + $grand_total;

      
      
      return response()->json([
        'orders'  =>  $orders, 
        'user_info' =>  $user_info, 
        'grand_total' =>$grand_total_price], 200);    
    }





    //unneeded
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
