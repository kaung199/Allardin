<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Order_detail;

class VoucherController extends Controller
{

    public function index()
    {
        //
        $data = session()->get('voucher_data');

        if(empty($data))
        {
            $session_data = array();
        }
        else
        {
            if(is_array($data))
            {
                $session_data = $data;
            }
            else
            {
                $session_data = array();
            }
        }
        return view('voucher.index', compact('session_data'));
    }

    public function order_search(Request $request) 
    {
        $data = $request->session()->get('voucher_data');
        
        if(empty($data))
        {
            $session_data = array();
        }
        else
        {
            if(is_array($data))
            {
                $session_data = $data;
            }
            else
            {
                $session_data = array();
            }
        }

        $order = Order::where('order_id', $request->order_id)->first();

        if($order != null)
        {
            if($order->dname == null) {
                return json_encode(array('sales_table'=>array(),'msg'=>'This order has no Delivery!'));
            }
            $id = $order->id;
            $count = count(session('voucher_data'));
            $order_id = $order->order_id;
            $total_qty = $order->totalquantity;
            $d_name = $order->dname;
            $cus_name = $order->user->name;
            $d_date = $order->deliverydate;
            $grand_total = $order->grandtotal;

            foreach($session_data as $key => $sd){
                if($sd['order_id'] == $order_id){
                    return json_encode(array('sales_table'=>array(),'msg'=>'Aready Exists!'));
                
                }
            }
            $session_data[] = array('id'=>$id,'count'=>$count,'order_id'=>$order_id,'total_qty'=>$total_qty,'d_name'=>$d_name,'d_date'=>$d_date,'grand_total'=>$grand_total,'cus_name'=>$cus_name);
            $request->session()->put('voucher_data', $session_data); 
            $count = count(session('voucher_data'));
            return json_encode(array('sales_table'=>$session_data,'msg'=>'', 'count'=>$count));
           
        } else
        {
            return json_encode(array('sales_table'=>array(),'msg'=>'Not Found!'));
        }
    }

    public function confirm(Request $request)
    {
        $data = $request->session()->get('voucher_data');
        
        if(empty($data))
        {
            $session_data = array();
        }
        else
        {
            if(is_array($data))
            {
                $session_data = $data;
            }
            else
            {
                $session_data = array();
            }
        }
        foreach($session_data as $key => $sd){
            $order = Order::find($sd['id']);
            $order->update([
                'deliverystatus' => 4
            ]);
        }
        $request->session()->forget('voucher_data');
        return json_encode(array('sales_table'=> '','msg'=>'Status Updated Successfully!'));
    }
    public function destroy(Request $request)
    {
        $request->session()->forget('voucher_data');
        return json_encode(array('msg'=>'Removed Successfully!'));
    }
}
