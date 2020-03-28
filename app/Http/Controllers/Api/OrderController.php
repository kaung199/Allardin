<?php

namespace App\Http\Controllers\Api;

use App\AppCard;
use App\AppCardProduct;
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
          return response()->json($response, 401);
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
        $required = 'user_id required!!';
        return response()->json(['message' => $required ], 401); 
      }
      if($product_v['product_id'] == null) {
        $required = 'product_id required!!';
        return response()->json(['message' => $required ], 401); 
      }
      if($product_v['quantity'] == null) {
        $required = 'quantity required!!';
        return response()->json(['message' => $required ], 401); 
      }
      $product = Product::find($request->product_id);
      $user_null = AppUser::find($request->user_id);
      if($user_null == null) {
        return response()->json(['message' => 'User Not Found!!'], 401);
      }
      if($product == null) {
        return response()->json(['message' => "Product Not Found!"], 401);
      }
      if( $request->quantity == 0)
      {
        return response()->json(['message' => 'Quantity must be greather than zero!'], 401);
      }
      if($product->quantity < $request->quantity)
      {
        return response()->json(['message' => 'Out Of Stock!'], 401);
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

        return response()->json(['message' => "Success", 'cart_status' => 1], 200);
      }
      if(isset($request->status)) {
        $session_user_id->update([
          'quantity' => $request->quantity,
          'total_price' => $request->quantity * $product->price
        ]);
        return response()->json(['message' => "Success", 'cart_status' => 1], 200);
      } else {
        $session_user_id->update([
          'quantity' => $session_user_id->quantity + $request->quantity,
          'total_price' => $session_user_id->total_price + $request->quantity * $product->price
        ]);
        return response()->json(['message' => "Success", 'cart_status' => 1], 200);
      }
      
    }

    public function remove_cart(Request $request)
    {
      $product_v = $request->all();
      if($product_v['user_id'] == null) {
        $required = 'user_id required!!';
        return response()->json(['message' => $required ], 401); 
      }
      if($product_v['product_id'] == null) {
        $required = 'product_id required!!';
        return response()->json(['message' => $required ], 401); 
      }

      $product = Product::find($request->product_id);
      $user_null = AppUser::find($request->user_id);
      if($user_null == null) {
        return response()->json(['message' => 'User Not Found!!'], 401);
      }
      if($product == null) {
        return response()->json(['message' => "Product Not Found!"],401);
      }
      $session_user_id = Session::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
      if($session_user_id == null) {
        return response()->json(['message' => "Not Found!"],401);
      }
      $session_user_id->delete();
      return response()->json(['message'=> 'Success'],200);

    }

    public function show_cart(Request $request)
    {
      $user_v = $request->all();

      if($user_v['user_id'] == null) {
        $required = 'user_id required!!';
        return response()->json(['message' => $required ], 401); 
      }

      $user_null = AppUser::find($request->user_id);
      if($user_null == null) {
        return response()->json(['message' => 'User Not Found!!'], 401);
      }

      $session_user_id = Session::join('products_photos', 'session.product_id', '=', 'products_photos.product_id')
                        ->where('user_id', $request->user_id)->get();
      return response()->json($session_user_id, 200);

    }

    public function store(Request $request)
    {      
        $product = $request->all();   
        if($product['user_id'] == null) {
          $required = 'user_id required!!';
          return response()->json(['message' => $required ], 401); 
        }
        if($product['name'] == null) {
          $required = 'name required!!';
          return response()->json(['message' => $required ], 401); 
        }
        if($product['phone'] == null) {
          $required = 'phone required!!';
          return response()->json(['message' => $required ], 401); 
        }
        if($product['address'] == null) {
          $required = 'address required!!';
          return response()->json(['message' => $required ], 401); 
        }

        if($product['township_id'] == null) {
          $required = 'township_id required!!';
          return response()->json(['message' => $required ], 401); 
        }

        $user_null = AppUser::find($product['user_id']);
        $t_null = Township::find($product['township_id']);
        if($user_null == null) {
          return response()->json(['message' => 'User Not Found!!'],401);
        } 

        if($t_null == null) {
          return response()->json(['message' => 'Township Not Found!!'], 401);
        }

        $sessions = Session::where('user_id', $product['user_id'])->get()->toArray();

        if($sessions == null) {
          return response()->json([ 'message' => 'cart-is-empty'], 401);
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
         
        
        return response()->json([ 'message' => 'Success'],200);
        
    }

    public function orderdetail($id)
    {
      $order_null = Order::find($id);
      if($order_null == null) {
        return response()->json(['message' => 'Order Not Found!!'],401);
      } 

      $order = Order::where('orders.id', $id)
                  ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                  ->select('order_details.name as product_name',
                    'order_details.quantity',
                    'order_details.price', 
                    'order_details.totalprice')
                  ->get();
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
        $required = 'user_id required!!';
        return response()->json(['message' => $required ], 401); 
      }
      $user_null = AppUser::find($request->user_id);

      if($user_null == null) {
        return response()->json(['message' => 'User Not Found!!'],401);
      } 

      $orders = Order::orderBy('orders.id', 'desc')
                      ->where('orders.app_user_id', $request->user_id)
                      ->select('id',
                        'order_id',
                        'totalquantity',
                        'totalprice',
                        'created_at as order_date'
                        )
                      ->get();
      return response()->json($orders, 200);    
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
