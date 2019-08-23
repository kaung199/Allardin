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

    public function deliverystatusd($id)
    {
        
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2
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
                'deliverystatus' => 1
            ]); 
            return redirect('orderd')->with('deliverystatus', 'Status Change successful');
        }        
    }

    public function orderdelivery(Request $request, $id)
    {
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2,
                'delivery_id' => $request->delivery_id
            ]);
            return redirect()->back()->with('deliverystatus', 'Status Change successful');
        }
    }

    public function orderdeliveryp(Request $request, $id)
    {
        $deliverystatus = Order::find($id);
        if($deliverystatus->deliverystatus == 1) {
            $deliverystatus->update([
                'deliverystatus' => 2,
                'delivery_id' => $request->delivery_id
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
