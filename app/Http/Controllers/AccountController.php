<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Order_detail;
use App\Delivery;
use App\User;
use Auth;

class AccountController extends Controller
{
    public function order()
    {
        $orders = Order::latest()->paginate(9);
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orderprepare.orders', compact('orders', 'deliveries'));
    }
    public function adminorders()
    {
        $orders = Order::latest()->paginate(40);
        return view('orders.adminorders', compact('orders'));
    }
    public function orderd()
    {
        $d_id = Auth::user()->id;
        $orders = Order::where('delivery_id', $d_id)->orderBy('orders.id', 'desc')->paginate(9);
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orderprepare.orders', compact('orders', 'deliveries'));
    }
    public function orderdetail($id)
    {
        $orderdetails = Order_detail::where(order_id, $id)->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        $d_id = $orderdetails[0]->order->delivery_id;
        $delivery = User::find($d_id);
        return view('orderprepare.orderdetail', compact('orderdetails','delivery','deliveries'));
    }
    public function adminorderdetail($id)
    {
        $orderdetails = Order_detail::where(order_id, $id)->get();
        $d_id = $orderdetails[0]->order->delivery_id;
        $delivery = User::find($d_id);
        return view('orders.adminorderdetail', compact('orderdetails','delivery'));
    }
    public function orderdetailo($id)
    {
        $orderdetails = Order_detail::where(order_id, $id)->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        // get previous user id
        $previous = Order::where([
            ['orders.id', '<', $id],
            ['deliverystatus', 1]
            ])->max('orders.id');
        // get next user id
        $next = Order::where([
            ['orders.id', '>', $id],
            ['deliverystatus', 1]
            ])->max('orders.id');
        $d_id = $orderdetails[0]->order->delivery_id;
        $delivery = User::find($d_id);
        return view('orderprepare.orderdetail', compact('orderdetails','deliveries','delivery', 'previous', 'next'));
    }
    public function deliverystatus($id)
    {
        
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
                'deliverystatus' => 1,
                'dname' => '',
                'dphone' => '',
            ]); 
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }        
    }

    public function deliverystatusd($id)
    {
        
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2,
                'orderdate' =>  date('Y-m-d'),
                'monthly' =>  date('Y-m'),
                'yearly' =>  date('Y'),
            ]);
            return redirect('orderd')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 2) {
            $deliverystatus->update([
                'deliverystatus' => 3
            ]);  
            return redirect('orderd')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 3) {
            $deliverystatus->update([
                'deliverystatus' => 4
            ]); 
            return redirect('orderd')->with('deliverystatus', 'Status Change successful');
        }
        if($deliverystatus->deliverystatus == 4) {
            $deliverystatus->update([
                'deliverystatus' => 1,
                'dname' => null,
                'dphone' => null,
            ]); 
            return redirect('orderd')->with('deliverystatus', 'Status Change successful');
        }        
    }

    public function orderdelivery(Request $request, $id)
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
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }
    }

    public function orderdeliveryp(Request $request, $id)
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
            return redirect('orderp')->with('deliverystatus', 'Status Change successful');
        }
    }

    public function delivery()
    {
        $id = Auth::user()->id;
        $orders = Order::where([
            ['delivery_id', $id],
            ['deliverystatus', 2]
            ])->get();
        return view('delivery.delivery', compact('orders'));  
    }

    public function orderprepare()
    {
        $orders = Order::where(deliverystatus, 1)->orderBy('orders.id', 'desc')->get();
        $deliveries = User::where('role_id', 3)->pluck('name', 'id');
        return view('orderprepare.orderprepare', compact('orders', 'deliveries'));
    }

    public function searchp(Request $request)
    {
       $search =$request->search;
       $orders = Order::where('order_id', '=', $search)
                ->orWhere('orderdate', '=', $search)
                ->get();
       $count = count($orders);
       $deliveries = User::where('role_id', 3)->pluck('name', 'id');
       return view('orderprepare.search', compact('orders', 'deliveries','count'));

       

    }
}
