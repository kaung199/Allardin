<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Requests\Ostore;
use Excel;
use App\Township;
use App\Delivery;
use App\User;
use App\Cart;
use App\Cart_product;
use App\Order_detail;
use App\Order;
use App\Stock;
use Auth;
use DB;
use App\Product;
use App\Totalsaleproduct;
use App\Totalsaledetail;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function checkoutform() 
    {
        $townships = Township::pluck('name', 'id')->all();
        return view('orders.admincheckoutform', \compact('townships'));
    }
    public function admincheckoutform() 
    {
        $townships = Township::pluck('name', 'id')->all();
        return view('orders.admincheckoutform2', \compact('townships'));
    }

    public function cart_checkout(Ostore $request) 
    {
        $cart = session()->get('cart');
        
        $order_cart =  Cart::create($request->all());

        foreach(session('cart') as $cart => $details) {

            $product = Product::find($details['id']);
            $product->update([
                'quantity' => $product->quantity - $details['quantity'],
            ]); 
            $cart_product = Cart_product::create([
                    'product_id' => $details['id'],
                    'name' => $details['name'],
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                    'image' => $details['image'],
                    'cart_id' => $order_cart->id,
            ]);

        }            
           
        session()->forget('cart');                
        return redirect()->route('order_cart')->with('ordersuccess', 'Order Success!'); 
    }

    public function checkout(Ostore $request) 
    {
        $cart = session()->get('cart');
        $total = 0;
        $totalquantity = 0;
        $totalsaleproduct = 0;
        $totalsaleprice = 0;

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

            $today = date("Ymd");
            $rand = sprintf("%04d", rand(0,9999));
            $unique = $today . $rand;
            $order = Order::create([
                'order_id' => $unique,
                'totalquantity' => $totalquantity,
                'totalprice' =>  $total - $request->discount,
                'grandtotal' =>  $total - $request->discount + $customer->township->deliveryprice,
                'discount' =>  $request->discount,
                'orderdate' =>  date('Y-m-d'),
                'deliverydate' =>  $request->deliverydate,
                'orderby' =>  Auth::user()->name,
                'remark' =>  $request->remark,
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

            //start
            $totalsale_pid = Totalsaleproduct::where('product_id', $details['id'])->where('date', date('Y-m-d'))->get();

            if($totalsale_pid[0] == null) {
                $totalsale = Totalsaleproduct::create([
                    'product_id' => $details['id'],
                    'totalqty' => $details['quantity'],
                    'totalprice' =>  $details['price'] * $details['quantity'],
                    'date' => date('Y-m-d'),
                    'deliveryprice' =>  $order->user->township->deliveryprice,
        
                ]);

                Totalsaledetail::create([
                    'user_id' => $order->user->id,
                    'product_id' => $details['id'],
                    'totalqty' => $details['quantity'],
                    'totalprice' => $details['price'] * $details['quantity'],
                    'date' =>  date('Y-m-d'),
                    'tsp_id' => $totalsale->id,
                    'order_id' => $order->id,
    
                ]);

            } else {
                if($totalsale_pid[0]->date == date('Y-m-d')) {    
                    foreach($totalsale_pid as $tsp)  {
                        $tsp->update([
                            'totalqty' => $totalsale_pid[0]->totalqty + $details['quantity'],
                            'totalprice' => $totalsale_pid[0]->totalprice + $details['price'] * $details['quantity'],
                            'deliveryprice' => $totalsale_pid[0]->deliveryprice +  $order->user->township->deliveryprice,
                
                        ]);  
                        
                        Totalsaledetail::create([
                            'user_id' => $order->user->id,
                            'product_id' => $details['id'],
                            'totalqty' => $details['quantity'],
                            'totalprice' => $details['price'] * $details['quantity'],
                            'date' =>  date('Y-m-d'),
                            'tsp_id' => $tsp->id,
                            'order_id' => $order->id,
            
                        ]);
                    }           

                    

                } else {

                    $totalsalee = Totalsaleproduct::create([
                        'product_id' => $details['id'],
                        'totalqty' => $details['quantity'],
                        'totalprice' =>  $details['price'] * $details['quantity'],
                        'date' => date('Y-m-d'),
                        'deliveryprice' =>  $order->user->township->deliveryprice,
            
                    ]);
    
                    Totalsaledetail::create([
                        'user_id' => $order->user->id,
                        'product_id' => $details['id'],
                        'totalqty' => $details['quantity'],
                        'totalprice' => $details['price'] * $details['quantity'],
                        'date' =>  date('Y-m-d'),
                        'tsp_id' => $totalsalee->id,
                        'order_id' => $order->id,
        
                    ]);
                }
           

            }
           
        //end  
        

            
        }   
        session()->forget('cart'); 

        if(Auth::user()->role_id == 2) {
        return redirect()->route('adminorders')->with('ordersuccess', 'Order Success!'); 
        } else {                
            return redirect()->route('order')->with('ordersuccess', 'Order Success!'); 
        }
    }

    public function order_cart()
    {
        $orders = Cart::orderBy('id', 'desc')->paginate(15);
        $count = count($orders);
        if(Auth::user()->role_id == 2) {
            return view('orders.admin_order_cart', compact('orders', 'count'));
        } else {
            return view('orders.order_cart', compact('orders', 'count'));

        }
    }

    public function admin_cart_detail($id)
    {
        $order = Cart::find($id);
        return view('orders.admin_cart_detail', compact('order'));
        
    }

    public function order_cart_confirm($id)
    {

        $cart = Cart::find($id);
        if($cart->delivery_date == date('Y-m-d')) {
            return redirect()->back()->with('d_date_error', "Delivery Date Can't Equal to Today!!");
        }
        $total = 0;
        $totalquantity = 0;
        $totalsaleproduct = 0;
        $totalsaleprice = 0;

        //customer create
       $customer =  User::create([
            'name' => $cart->name,
            'phone' => $cart->phone,
            'address' => $cart->address,
            'township_id' => $cart->township_id,
       ]);

        foreach($cart->cart_products as  $details) {

            $totalq = 0;
            $totalp = 0;

            $total += $details['price'] * $details['quantity'];
            $totalquantity += $details['quantity'];


            $product = Product::find($details['product_id']);
            $grandqty = $product->quantity - $details['quantity'];
            
            // $product->update([
            //     'quantity' => $grandqty,
            // ]);

        }

            $today = date("Ymd");
            $rand = sprintf("%04d", rand(0,9999));
            $unique = $today . $rand;
            $order = Order::create([
                'order_id' => $unique,
                'totalquantity' => $totalquantity,
                'totalprice' =>  $total - $cart->discount,
                'grandtotal' =>  $total - $cart->discount + $customer->township->deliveryprice,
                'discount' =>  $cart->discount,
                'orderdate' =>  date('Y-m-d'),
                'deliverydate' =>  $cart->delivery_date,
                'orderby' =>  Auth::user()->name,
                'remark' =>  $cart->remark,
                'monthly' =>  date('Y-m'),
                'yearly' =>  date('Y'),
                'deliverystatus' => 1,
                'user_id' => $customer->id, 
                'app_user_id' => $cart->app_user_id,
                'customer_status' => $cart->customer_status
    
            ]);
                
            

        foreach($cart->cart_products as  $details) {
            $product = Product::find($details['product_id']);
            Order_detail::create([
                'product_id' => $details['product_id'],
                'name' => $details['name'],
                'code' => $product->code,
                'quantity' =>   $details['quantity'],
                'price' =>  $details['price'],
                'totalprice' => $details['price'] * $details['quantity'],
                'user_id' => $customer->id,
                'order_id' => $order->id,

            ]);

            $stock_checks = Stock::where('product_id', $details['product_id'])->get();
            foreach($stock_checks as $stock_check)
            {
                $stock_check->update([
                    'r_qty' => $stock_check->r_qty - $details['quantity']
                ]);
            }

            //start
            $totalsale_pid = Totalsaleproduct::where('product_id', $details['product_id'])->where('date', date('Y-m-d'))->get();

            if($totalsale_pid[0] == null) {
                $totalsale = Totalsaleproduct::create([
                    'product_id' => $details['product_id'],
                    'totalqty' => $details['quantity'],
                    'totalprice' =>  $details['price'] * $details['quantity'],
                    'date' => date('Y-m-d'),
                    'deliveryprice' =>  $order->user->township->deliveryprice,
        
                ]);

                Totalsaledetail::create([
                    'user_id' => $order->user->id,
                    'product_id' => $details['product_id'],
                    'totalqty' => $details['quantity'],
                    'totalprice' => $details['price'] * $details['quantity'],
                    'date' =>  date('Y-m-d'),
                    'tsp_id' => $totalsale->id,
                    'order_id' => $order->id,
    
                ]);

            } else {
                if($totalsale_pid[0]->date == date('Y-m-d')) {    
                    foreach($totalsale_pid as $tsp)  {
                        $tsp->update([
                            'totalqty' => $totalsale_pid[0]->totalqty + $details['quantity'],
                            'totalprice' => $totalsale_pid[0]->totalprice + $details['price'] * $details['quantity'],
                            'deliveryprice' => $totalsale_pid[0]->deliveryprice +  $order->user->township->deliveryprice,
                
                        ]);  
                        
                        Totalsaledetail::create([
                            'user_id' => $order->user->id,
                            'product_id' => $details['product_id'],
                            'totalqty' => $details['quantity'],
                            'totalprice' => $details['price'] * $details['quantity'],
                            'date' =>  date('Y-m-d'),
                            'tsp_id' => $tsp->id,
                            'order_id' => $order->id,
            
                        ]);
                    }           

                    

                } else {

                    $totalsalee = Totalsaleproduct::create([
                        'product_id' => $details['product_id'],
                        'totalqty' => $details['quantity'],
                        'totalprice' =>  $details['price'] * $details['quantity'],
                        'date' => date('Y-m-d'),
                        'deliveryprice' =>  $order->user->township->deliveryprice,
            
                    ]);
    
                    Totalsaledetail::create([
                        'user_id' => $order->user->id,
                        'product_id' => $details['product_id'],
                        'totalqty' => $details['quantity'],
                        'totalprice' => $details['price'] * $details['quantity'],
                        'date' =>  date('Y-m-d'),
                        'tsp_id' => $totalsalee->id,
                        'order_id' => $order->id,
        
                    ]);
                }
           

            }
           
        //end  
        

            
        }   
        session()->forget('cart'); 
        session()->forget('order_cart');

        Cart_product::where('cart_id', $id)->delete();
        $cart->delete(); 

        if(Auth::user()->role_id == 2) {
        return redirect()->route('adminorders')->with('ordersuccess', 'Order Success!'); 
        } else {                
            return redirect()->route('order')->with('ordersuccess', 'Order Success!'); 
        }
    }

    public function order_cart_edit($id)
    {
        $order = Cart::find($id);
        $townships = Township::pluck('name', 'id')->all();
        $selected_township = $order->township->pluck('id')->all();
        if(Auth::user()->role_id == 2) {
            return view('orders.admin_order_cart_edit', compact('order', 'townships'));
        } else {
            return view('orders.order_cart_edit', compact('order', 'townships'));
        }
    }

    public function order_cart_editp($id)
    {
        session()->forget('order_cart');
        $orders = Cart_product::where('cart_id', $id)->get();
        if(Auth()->user()->role_id == 2) {
            return view('orders.admin_cart_edit_product', compact('orders'));
        } else {
            return view('orders.order_cart_edit_product', compact('orders'));
        }
    }

    public function order_cart_update(Ostore $request, $id)
    {
        $order = Cart::find($id);
        $order->update($request->all());
        if(Auth::user()->role_id == 2) {
            return redirect()->route('admin_cart_detail', $id)->with('order_cart_updated', 'Order_cart Updated Successfully!');
        } else {            
            return redirect()->route('order_cart')->with('order_cart_updated', 'Order_cart Updated Successfully!');
        }
    }

    public function order_cart_delete($id)
    {
        $cart = Cart::find($id);
        $cart_products = Cart_product::where('cart_id', $id)->get();

        foreach($cart_products as $cp) {
            $product = Product::find($cp->product_id);
            $product->update([
                'quantity' => $product->quantity + $cp->quantity,
            ]);
            $cp->delete();
        }

        
        $cart->delete();
        return redirect()->back()->with('deleted', 'Order_cart Deleted Successfully');
    }
    
    public function order()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(15);
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.index', compact('orders', 'deliveries'));
    }

    public function orderdetail($id)
    {
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orderdetails = Order_detail::where(order_id, $id)->get();
        $d_id = $orderdetails[0]->order->delivery_id;
        $delivery = User::find($d_id);

        // get previous user id 
        $previous = Order_detail::where('order_id', '<', $id)->max('order_id');

        // get next user id 
        $next = Order_detail::where('order_id', '>', $id)->min('order_id');

        return view('orders.orderdetail', compact('orderdetails','previous','next','delivery', 'deliveries'));
    }

    public function editOrderDetail(Request $request)
    {
        $update = Order::where('id', $request->order_id)->first();
        $update->remark = $request->remark;
        $update->save();

        $user_update = User::where('id', $update->user_id)->first();
        $user_update->phone = $request->phone;
        $user_update->address = $request->address;
        $user_update->save();

        return redirect()->back();
    }
    public function orderdetailsimple($id)
    {
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orderdetails = Order_detail::where(order_id, $id)->get();
        $d_id = $orderdetails[0]->order->delivery_id;
        $delivery = User::find($d_id);
        return view('orders.orderdetail', compact('orderdetails','delivery', 'deliveries'));
    }
    public function deliveryorderdetail($id)
    {
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orderdetails = Order_detail::where(order_id, $id)->get();
        $d_id = $orderdetails[0]->order->delivery_id;
        $delivery = User::find($d_id);
        return view('delivery.deliveryorderdetail', compact('orderdetails','delivery', 'deliveries'));
    }
    public function destroy($id)
    {
        $totalsaledetais = Totalsaledetail::where(order_id, $id)->get();
        foreach($totalsaledetais as $totalsaledetail) {
            $totalsaleproduct = Totalsaleproduct::find($totalsaledetail->tsp_id);
            $totalsaleproduct->update([
                'totalqty' => $totalsaleproduct->totalqty - $totalsaledetail->totalqty,
                'totalprice' => $totalsaleproduct->totalprice - $totalsaledetail->totalprice - $totalsaledetail->user->township->deliveryprice,
                'deliveryprice' => $totalsaleproduct->deliveryprice - $totalsaledetail->user->township->deliveryprice,
            ]);
            if($totalsaleproduct->totalqty == 0) {
                $totalsaleproduct->delete();
            }
            $totalsaledetail->delete();
        }
        
        if(Auth::user()->id == 1) {
            $order = Order::find($id);
            foreach($order->orderdetails as $orderproduct) {
                $product = Product::find($orderproduct->product_id);
                $product->update([
                    'quantity' => $product->quantity + $orderproduct->quantity,
                ]);

            $stock_checks = Stock::where('product_id', $orderproduct->product_id)->get();
            foreach($stock_checks as $stock_check)
            {
                $stock_check->update([
                    'r_qty' => $stock_check->r_qty + $orderproduct->quantity
                ]);
            }
                
            }
            User::find($order->user->id)->delete();
            $order->delete();
            return redirect()->back();
        }
        return redirect()->route('order')->with('permission', 'Permission Deny');
    }

    public function deliverystatus($id)
    {
        if(Auth::user()->role_id != 2) {
            $deliverystatus = Order::find($id);
            if($deliverystatus->deliverystatus == 1) {
                $deliverystatus->update([
                    'deliverystatus' => 2,
                    'orderdate' =>  date('Y-m-d'),
                    'monthly' =>  date('Y-m'),
                    'yearly' =>  date('Y'),
                ]);
                return redirect()->back()->with('deliverystatus', 'Status Change successful');
            }
            // if($deliverystatus->deliverystatus == 2) {
            //     $deliverystatus->update([
            //         'deliverystatus' => 3
            //     ]);  
            //     return redirect()->back()->with('deliverystatus', 'Status Change successful');
            // }
            if($deliverystatus->deliverystatus == 2) {
                $deliverystatus->update([
                    'deliverystatus' => 4
                ]); 
                return redirect()->back()->with('deliverystatus', 'Status Change successful');
            }
            if($deliverystatus->deliverystatus == 4) {
                $deliverystatus->update([
                    'deliverystatus' => 1,
                    'delivery_id' => null,
                    'dname' => null,
                    'dphone' => null,
                ]);                

                return redirect()->back()->with('deliverystatus', 'Status Change successful');
            }
        }
                
    }
    public function deliverystatusxls($id)
    {
        if(Auth::user()->role_id != 2) {
            $deliverystatus = Order::find($id);
            if($deliverystatus->deliverystatus == 1) {
                $deliverystatus->update([
                    'deliverystatus' => 2,
                    'orderdate' =>  date('Y-m-d'),
                    'monthly' =>  date('Y-m'),
                    'yearly' =>  date('Y'),
                ]);
                return redirect()->back()->with('deliverystatus', 'Status Change successful');
            }
            // if($deliverystatus->deliverystatus == 2) {
            //     $deliverystatus->update([
            //         'deliverystatus' => 3
            //     ]);  
            //     return redirect()->back()->with('deliverystatus', 'Status Change successful');
            // }
            if($deliverystatus->deliverystatus == 2) {
                $deliverystatus->update([
                    'deliverystatus' => 4
                ]); 
                return redirect()->back()->with('deliverystatus', 'Status Change successful');
            }
            if($deliverystatus->deliverystatus == 4) {
                $deliverystatus->update([
                    'deliverystatus' => 1,
                    'delivery_id' => null,
                    'dname' => null,
                    'dphone' => null,
                ]);                

                return redirect()->back()->with('deliverystatus', 'Status Change successful');
            }
        }
                
    }
    public function orderdelivery(Request $request, $id)
    {
        if($request->delivery_id == null) {
            return redirect()->back();
        }
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1 || $deliverystatus->deliverystatus == 2) {
            $delivery = User::find($request->delivery_id);
            $deliverystatus->update([
                'deliverystatus' => 2,
                'delivery_id' => $request->delivery_id,
                'dname' => $delivery->name,
                'dphone' => $delivery->phone,
                'orderdate' =>  date('Y-m-d'),
                'monthly' =>  date('Y-m'),
                'yearly' =>  date('Y'),
            ]);
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }
    }

    public function orderdeliverysearch(Request $request, $id)
    {
        if($request->delivery_id == null) {
            return redirect()->back();
        }
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $delivery = User::find($request->delivery_id);
            $deliverystatus->update([
                'deliverystatus' => 2,
                'orderdate' =>  date('Y-m-d'),
                'monthly' =>  date('Y-m'),
                'yearly' =>  date('Y'),
                'delivery_id' => $request->delivery_id,
                'dname' => $delivery->name,
                'dphone' => $delivery->phone,
            ]);
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }
    }

    public function deliverystatussearch($id)
    {
        
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2,
                'orderdate' =>  date('Y-m-d'),
                'monthly' =>  date('Y-m'),
                'yearly' =>  date('Y'),
            ]);
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }
        // if($deliverystatus->deliverystatus == 2) {
        //     $deliverystatus->update([
        //         'deliverystatus' => 3
        //     ]);  
        //     return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        // }
        if($deliverystatus->deliverystatus == 2) {
            $deliverystatus->update([
                'deliverystatus' => 4
            ]); 
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 4) {
            $deliverystatus->update([
                'deliverystatus' => 1,
                'delivery_id' => null,
                'dname' => null,
                'dphone' => null,
            ]); 
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }        
    }

    // all order
    public function orderprepare()
    {
        $orders = Order::where(deliverystatus, 1)->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.orderprepare', compact('orders', 'deliveries'));
    }
    public function delivery()
    {
        $orders = Order::where(deliverystatus, 2)->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.delivery', compact('orders', 'deliveries'));  
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
    // all orderf
    public function orderpreparef($from, $to)
    {
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 1)->orderBy('dname')->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.orderprepare', compact('orders', 'deliveries', 'from', 'to'));
    }
    public function deliveryf($from, $to)
    {
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 2)->orderBy('dname')->get();
        return view('orders.delivery', compact('orders', 'from', 'to'));  
    }
    public function paymentf($from, $to)
    {
        $orders = Order::whereBetween('orderdate', [$from, $to])
                    ->where(deliverystatus, 3)->orderBy('dname')->get();
        return view('orders.payment', compact('orders', 'from', 'to'));
    }
    public function completef($from, $to)
    {
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 4)->orderBy('dname')->get();
        return view('orders.complete', compact('orders', 'from', 'to'));
    }

    //daily order
    public function orderprepared()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 1],
            ['orderdate', $today]
            ])->orderBy('dname')->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.daily.orderprepare', compact('orders', 'today', 'deliveries'));
    }
    public function deliveryd()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 2],
            ['orderdate', $today]
            ])->orderBy('dname')->get();
        return view('orders.daily.delivery', compact('orders', 'today'));  
    }
    public function paymentd()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 3],
            ['orderdate', $today]
            ])->orderBy('dname')->get();
        return view('orders.daily.payment', compact('orders', 'today'));
    }
    public function completed()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 4],
            ['orderdate', $today]
            ])->orderBy('dname')->get();
        return view('orders.daily.complete', compact('orders', 'today'));
    }
    //daily order filterbydate
    public function orderpreparedf($from, $to)
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 1)->orderBy('dname')->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.daily.orderprepare', compact('orders', 'today', 'deliveries', 'from', 'to'));
    }
    public function deliverydf($from, $to)
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 2)->orderBy('dname')->get();
        return view('orders.daily.delivery', compact('orders', 'today', 'from', 'to'));  
    }
    public function paymentdf($from, $to)
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 3)->orderBy('dname')->get();
        return view('orders.daily.payment', compact('orders', 'today', 'from', 'to'));
    }
    public function completedf($from, $to)
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where(deliverystatus, 4)->orderBy('dname')->get();
        return view('orders.daily.complete', compact('orders', 'today', 'from', 'to'));
    }


    //monthly order
    public function orderpreparem()
    {
        $thismonth = Carbon::now()->format('Y-m');
        $orders = Order::where([ 
            [deliverystatus, 1],
            ['monthly', $thismonth]
            ])->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.daily.orderprepare', compact('orders', 'thismonth', 'deliveries'));
    }
    public function deliverym()
    {
        $thismonth = Carbon::now()->format('Y-m');
        $orders = Order::where([ 
            [deliverystatus, 2],
            ['monthly', $thismonth]
            ])->get();
        return view('orders.daily.delivery', compact('orders', 'thismonth'));  
    }
    public function paymentm()
    {
        $thismonth = Carbon::now()->format('Y-m');
        $orders = Order::where([ 
            [deliverystatus, 3],
            ['monthly', $thismonth]
            ])->get();
        return view('orders.daily.payment', compact('orders', 'thismonth')); 
    }
    public function completem()
    {
        $thismonth = Carbon::now()->format('Y-m');
        $orders = Order::where([ 
            [deliverystatus, 4],
            ['monthly', $thismonth]
            ])->get();
        return view('orders.daily.complete', compact('orders', 'thismonth')); 
    }

    //yearly order
    public function orderpreparey()
    {
        $thisyear = Carbon::now()->format('Y');
        $orders = Order::where([ 
            [deliverystatus, 1],
            ['yearly', $thisyear]
            ])->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.daily.orderprepare', compact('orders', 'thisyear', 'deliveries'));
    }
    public function deliveryy()
    {
        $thisyear = Carbon::now()->format('Y');
        $orders = Order::where([ 
            [deliverystatus, 2],
            ['yearly', $thisyear]
            ])->get();
        return view('orders.daily.delivery', compact('orders', 'thisyear')); 
    }
    public function paymenty()
    {
        $thisyear = Carbon::now()->format('Y');
        $orders = Order::where([ 
            [deliverystatus, 3],
            ['yearly', $thisyear]
            ])->get();
        return view('orders.daily.payment', compact('orders', 'thisyear'));
    }
    public function completey()
    {
        $thisyear = Carbon::now()->format('Y');
        $orders = Order::where([ 
            [deliverystatus, 4],
            ['yearly', $thisyear]
            ])->get();
        return view('orders.daily.complete', compact('orders', 'thisyear'));
    }


   
    public function dailyorder() 
    {
      $today = Carbon::now()->toDateString();
      $orderso = Order::where('orderdate', $today)
                    ->where('deliverystatus', 1)->orderBy('dname')->get();
      $ordersd = Order::where('orderdate', $today)
                    ->where('deliverystatus', 2)->orderBy('dname')->get();
      $ordersp = Order::where('orderdate', $today)
                    ->where('deliverystatus', 3)->orderBy('dname')->get();
      $ordersc = Order::where('orderdate', $today)
                    ->where('deliverystatus', 4)->orderBy('dname')->get();
      $deliveries = User::where('role_id', 3)->pluck('name', 'id');
      return view('orders.daily', compact('orderso','ordersd','ordersp','ordersc', 'deliveries'));    
    }

    public function monthlyorder() 
    {
      $thismonth = Carbon::now()->format('Y-m');
      $orders = Order::where('monthly', $thismonth)->get();
      $deliveries = User::where('role_id', 3)->pluck('name', 'id');
      return view('orders.monthly', compact('orders', 'deliveries'));    

    }

    public function yearlyorder() 
    {
      $thisyear = Carbon::now()->format('Y');
      $orders = Order::where('yearly', $thisyear)->get();
      $deliveries = User::where('role_id', 3)->pluck('name', 'id');
      return view('orders.yearly', compact('orders', 'deliveries'));    
    }


    public function search(Request $request) 
    {
        // dd($request->all());
        $from = $request->from;
        $to = $request->to;
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        if($request->search_by == 'delivery_date') {            
            $orders = Order::whereBetween('deliveryDate', [$from, $to])->orderBy('dname')->paginate(15);
        }
        if($request->search_by == 'order_date') {
            $orders = Order::whereBetween('orderdate', [$from, $to])->orderBy('dname')->paginate(15);
        }
        return view('orders.index', \compact('orders', 'deliveries', 'from', 'to'));  
    }
    public function searcho(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orders = Order::whereBetween('orderdate', [$from, $to])
                            ->where('deliverystatus', 1)->orderBy('dname')->get();
        return view('orders.orderprepare', \compact('orders', 'deliveries', 'from', 'to'));  
    }
    public function searchd(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $orders = Order::whereBetween('deliverydate', [$from, $to])
                        ->where('deliverystatus', 2)->orderBy('dname')->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orders.delivery', \compact('orders', 'from', 'to', 'deliveries'));  
    }
    public function searchp(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 3)->orderBy('dname')->get();
        return view('orders.payment', \compact('orders', 'from', 'to'));  
    }
    public function searchc(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $orders = Order::whereBetween('deliverydate', [$from, $to])
                        ->where('deliverystatus', 4)->get();
        return view('orders.complete', \compact('orders', 'from', 'to'));  
    }
    public function searchbydateo(Request $request) 
    {
        $today = Carbon::now()->toDateString();
        $from = $request->from;
        $to = $request->to;
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 1)->orderBy('dname')->get();
        return view('orders.daily.orderprepare', \compact('orders','today', 'deliveries', 'from', 'to'));  
    }
    public function searchbydated(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 2)->orderBy('dname')->get();
        return view('orders.daily.delivery', \compact('orders', 'today', 'from', 'to'));  
    }
    public function searchbydatep(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 3)->orderBy('dname')->get();
        return view('orders.daily.payment', \compact('orders', 'today', 'from', 'to'));  
    }
    public function searchbydatec(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $today = Carbon::now()->toDateString();
        $orders = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 4)->orderBy('dname')->get();
        return view('orders.daily.complete', \compact('orders', 'today', 'from', 'to'));  
    }

    public function ddsearch(Request $request) 
    {       
        $ddfrom = $request->ddfrom;
        $ddto = $request->ddto;
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orderso = Order::whereBetween('deliverydate', [$ddfrom, $ddto])
                        ->where('deliverystatus', 1)
                        ->orderBy('dname')->get();
        $ordersd = Order::whereBetween('deliverydate', [$ddfrom, $ddto])
                        ->where('deliverystatus', 2)
                        ->orderBy('dname')->get();
        $ordersp = Order::whereBetween('deliverydate', [$ddfrom, $ddto])
                        ->where('deliverystatus', 3)
                        ->orderBy('dname')->get();
        $ordersc = Order::whereBetween('deliverydate', [$ddfrom, $ddto])
                        ->where('deliverystatus', 4)
                        ->orderBy('dname')->get();
        return view('orders.daily', compact('orderso','ordersd','ordersp','ordersc', 'deliveries', 'ddfrom', 'ddto')); 

    }
    public function ddadminsearch(Request $request) 
    {       
        $ddfrom = $request->ddfrom;
        $ddto = $request->ddto;
        $orders = Order::whereBetween('deliverydate', [$ddfrom, $ddto])
                        ->orderBy('dname')->get();
        $count = $orders->count();
        return view('orders.ddadminsearch', compact('orders', 'ddfrom', 'ddto', 'count')); 

    }
    public function searchxls(Request $request) 
    {       
        $from = $request->from;
        $to = $request->to;
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $orderso = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 1)
                        ->orderBy('dname')->get();
        $ordersd = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 2)
                        ->orderBy('dname')->get();
        $ordersp = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 3)
                        ->orderBy('dname')->get();
        $ordersc = Order::whereBetween('orderdate', [$from, $to])
                        ->where('deliverystatus', 4)
                        ->orderBy('dname')->get();
        return view('orders.exportxls', compact('orderso','ordersd','ordersp','ordersc', 'deliveries', 'from', 'to')); 

    }
  
    public function searchdaily(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        if($request->search == 'deliverydate') {
            $orders = Order::whereBetween('deliverydate', [$from, $to])
                                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                                ->select('order_details.product_id',
                                'order_details.name as product_name',
                                'order_details.price as product_price',
                                'order_details.product_id',
                                 DB::raw("SUM(order_details.quantity) as tqty"),
                                  DB::raw("SUM(order_details.totalprice) as tp"))
                                ->groupBy('order_details.product_id')
                                ->groupBy('order_details.name')
                                ->groupBy('order_details.price')
                                ->get();
            $deliverydate = 'deliverydate';
            return view('orders.totalsale', \compact('orders','deliverydate', 'from', 'to'));
        }
        if($request->search == 'orderdate') {
            $orders = Order::whereBetween('orderdate', [$from, $to])
                                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                                ->select('order_details.product_id',
                                'order_details.name as product_name',
                                'order_details.price as product_price',
                                'order_details.product_id',
                                 DB::raw("SUM(order_details.quantity) as tqty"),
                                  DB::raw("SUM(order_details.totalprice) as tp"))
                                ->groupBy('order_details.product_id')
                                ->groupBy('order_details.name')
                                ->groupBy('order_details.price')
                                ->get();
            $orderdate = 'orderdate';
            return view('orders.totalsale', \compact('orders','orderdate', 'from', 'to'));
        } else {
            $totalsales = null;
            return view('orders.totalsale', \compact('totalsales', 'from', 'to'));
        }
    }
  
    public function searchdelivery(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $id = $request->delivery_id;
        $delivery = User::find($id);
        $orders = Order::whereBetween('deliverydate', [$from, $to])
                ->where('delivery_id', $id)
                ->where('deliverystatus', 2)
                ->orderBy('dname')->get();
        $completed = Order::whereBetween('deliverydate', [$from, $to])
                ->where('delivery_id', $id)
                ->where('deliverystatus', 4)
                ->orderBy('dname')->get();
        if(collect($orders)->isEmpty() && collect($completed)->isEmpty() ) {
            return redirect()->back()->with('idNull', 'No Data');
        }
        return view('delivery.orders', \compact('orders', 'delivery', 'completed'));  
    }

    public function deliverydetail($id)
    {
        $delivery = User::find($id);
        $orders = Order::where('delivery_id', $id)->where('deliverystatus', 2)->get();
        $completed = Order::where('delivery_id', $id)->where('deliverystatus', 4)->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('delivery.orders', compact('orders', 'deliveries', 'delivery', 'completed')); 
    }

    public function totalsale() {
        return view('orders.totalsale');
    }

    public function totalsaledetail($id) {
        $totalsales = Totalsaledetail::where('tsp_id', $id)->get();
        $product = Totalsaleproduct::find($id);
        return view('orders.totalsaledetail', compact('totalsales', 'product'));
    }

    public function totalsalebydate($id, $from, $to) {
        $totalsales = Totalsaledetail::where('product_id', $id)
                    ->whereBetween('date', [$from, $to])
                    ->get();
        $productid = Product::find($id);
        return view('orders.totalsaledetail', compact('totalsales', 'productid'));
    }

    public function searchtotal(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        $id = $request->p_id;
        $product = Totalsaleproduct::find($id);
        $totalsales = Totalsaledetail::whereBetween('date', [$from, $to])->where('product_id', $id)->paginate(15);
        return view('orders.searchtotal', \compact('totalsales', 'product'));  
    }

    public function export($from , $to) 
    {
        $orders = Order::whereBetween('orderdate', [$from, $to])
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select('orders.order_id as Order_id', 
                        'users.name as CustomerName','users.phone as Phone','users.address as Address', 'orders.totalquantity as TotalQty',
                        'orders.grandtotal as TotalPrice', 'orders.created_at as Order_date',
                        'orders.deliverydate as DeliveryDate','orders.dname as Delivery','orders.dphone as DePhone', 'orders.remark as Remark', 
                        'orders.deliverystatus as DeliveryStatus')->orderBy('dname')->get()->toArray(); 
        return Excel::create($from.'/'.$to.'-aladdin(OrderDate)', function($excel) use ($orders) {
            $excel->sheet('Aladdin', function($sheet) use ($orders) {
                $sheet->fromArray($orders);
            });
        })->download('xls'); 
    }
    public function ddexport($ddfrom , $ddto) 
    {
        $orders = Order::whereBetween('deliverydate', [$ddfrom, $ddto])
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select('orders.order_id as Order_id', 
                        'users.name as CustomerName', 'users.phone as Phone', 'users.address as Address', 'orders.totalquantity as TotalQty',
                        'orders.grandtotal as TotalPrice', 'orders.orderdate as Order_date',
                        'orders.deliverydate as DeliveryDate','orders.dname as Delivery','orders.dphone as DeliveryPhone', 'orders.remark as Remark', 
                        'orders.deliverystatus as DeliveryStatus')->orderBy('dname')->get()->toArray(); 
        return Excel::create($ddfrom.'/'.$ddto.'-aladdin(DeliveryDate)', function($excel) use ($orders) {
            $excel->sheet('Aladdin', function($sheet) use ($orders) {
                $sheet->fromArray($orders);
            });
        })->download('xls'); 
    }
    
}
