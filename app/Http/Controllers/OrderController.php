<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Requests\Ostore;
use App\Township;
use App\User;
use App\Order_detail;
use App\Order;
use Auth;
use App\Product;
use Carbon\Carbon;

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

            $today = date("Ymd");
            $rand = sprintf("%04d", rand(0,9999));
            $unique = $today . $rand;
            $order = Order::create([
                'order_id' => $unique,
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

        // get previous user id
        $previous = Order_detail::where('order_id', '<', $id)->max('order_id');

        // get next user id
        $next = Order_detail::where('order_id', '>', $id)->min('order_id');

        return view('orders.orderdetail', compact('orderdetails','previous','next'));
    }

    public function destroy($id)
    {
        if(Auth::user()->id == 1) {
            $order = Order::find($id);
            foreach($order->orderdetails as $orderproduct) {
                $product = Product::find($orderproduct->product_id);
                $product->update([
                    'quantity' => $product->quantity + $orderproduct->quantity,
                ]);
            }
            User::find($order->user->id)->delete();
            $order->delete();
            return redirect()->back();
        }
        return redirect()->back()->with('permission', 'Permission Deny');
    }
    public function deliverystatus($id)
    {
        
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2
            ]);
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 2) {
            $deliverystatus->update([
                'deliverystatus' => 3
            ]);  
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 3) {
            $deliverystatus->update([
                'deliverystatus' => 4
            ]); 
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 4) {
            $deliverystatus->update([
                'deliverystatus' => 1
            ]); 
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }        
    }
    public function deliverystatussearch($id)
    {
        
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2
            ]);
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 2) {
            $deliverystatus->update([
                'deliverystatus' => 3
            ]);  
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 3) {
            $deliverystatus->update([
                'deliverystatus' => 4
            ]); 
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 4) {
            $deliverystatus->update([
                'deliverystatus' => 1
            ]); 
            return redirect()->route('order')->with('deliverystatus', 'Status Change successful');
        }        
    }

    // all order
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

    //daily order
    public function orderprepared()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 1],
            ['orderdate', $today]
            ])->get();
        return view('orders.daily.orderprepare', compact('orders', 'today'));
    }
    public function deliveryd()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 2],
            ['orderdate', $today]
            ])->get();
        return view('orders.daily.delivery', compact('orders', 'today'));  
    }
    public function paymentd()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 3],
            ['orderdate', $today]
            ])->get();
        return view('orders.daily.payment', compact('orders', 'today'));
    }
    public function completed()
    {
        $today = Carbon::now()->toDateString();
        $orders = Order::where([ 
            [deliverystatus, 4],
            ['orderdate', $today]
            ])->get();
        return view('orders.daily.complete', compact('orders', 'today'));
    }


    //monthly order
    public function orderpreparem()
    {
        $thismonth = Carbon::now()->format('Y-m');
        $orders = Order::where([ 
            [deliverystatus, 1],
            ['monthly', $thismonth]
            ])->get();
        return view('orders.daily.orderprepare', compact('orders', 'thismonth'));
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
        return view('orders.daily.orderprepare', compact('orders', 'thisyear'));
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
      $orders = Order::where('orderdate', $today)->get();

      return view('orders.daily', compact('orders'));    
    }

    public function monthlyorder() 
    {
      $thismonth = Carbon::now()->format('Y-m');
      $orders = Order::where('monthly', $thismonth)->get();
      return view('orders.monthly', compact('orders'));    

    }

    public function yearlyorder() 
    {
      $thisyear = Carbon::now()->format('Y');
      $orders = Order::where('yearly', $thisyear)->get();
      return view('orders.yearly', compact('orders'));    
    }


    public function search(Request $request) 
    {
        $from = $request->from;
        $to = $request->to;
        // $orders = Order::whereBetween('orderdate', 'LIKE', '%' . $order_search . '%')->get();
        $orders = Order::whereBetween('orderdate', [$from, $to])->get();
        return view('orders.searchbydate', \compact('orders'));  
    }
    
}
