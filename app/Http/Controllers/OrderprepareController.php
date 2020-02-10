<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order_detail;
use App\Order;
use App\User;

class OrderprepareController extends Controller
{
    public function index($id)
    {
        $orderdetails = Order_detail::where('order_id', $id)->get();
        return view('orderprepare.index', \compact('orderdetails'));
    }

    public function barcode(Request $request)
    {
        $orderdetails = Order_detail::where('order_id', $request->id)
                        ->where('code', $request->code)->first();
        if($orderdetails != null) {
            
            if($orderdetails->quantity == $orderdetails->check) {
                return json_encode(array('msg'=>'Already Checked!!'));
            } else {
                $orderdetails->update([
                    'check' => $orderdetails->check + 1
                ]);
            }
            
            $code = $orderdetails->code;
            return json_encode(array('msg'=> '', 'p_code' => $code));
        } else {
            return json_encode(array('msg'=>'Check your code!'));
        }
    }

    public function confirm(Request $request)
    {
        if($request->id) {
            $order = Order::find($request->id);
            $order->update([
                'checkstatus' => 1
            ]);
            return json_encode(array('msg'=>''));
        } else {
            return json_encode(array('msg'=>'Order ID Not Found!!'));
        }  
    }

    public function remove(Request $request)
    {
        $order = Order::find($request->id);
        $order->update([
            'checkstatus' => null
        ]);

        $orderdetails = Order_detail::where('order_id', $request->id)->get();

        foreach($orderdetails as $o) {
            $o->update([
                'check' => 0
            ]);
        }
        return json_encode(array('msg'=>'')); 
    }
}
