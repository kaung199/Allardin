<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use App\Sale;
use App\SaleDetail;
use Auth;
use App\Stock;
use DB;

class PosSaleController extends Controller
{


    function load_data(Request $request){
        $product = Product::pluck('name', 'id')->get();
        dd($product);
    }

    public function pageload(Request $request)
    {
        $data = $request->session()->get('sales_table');

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

        $grand_total = 0;
        foreach($session_data as $sd)
        {
            $grand_total +=  $sd['total'];
        }
        $request->session()->put('sales_table', $session_data);
        return json_encode(array('sales_table'=>$session_data,'msg'=>'',
            'grand_total'=>$grand_total));

    }

    public function pos()
    {
        //
        $data = session()->get('session_data');

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
        $product = Product::pluck('name', 'id')->all();
        return view('pos.index', compact('product', 'session_data'));
    }

    public function data(Request $request)
    {
        $data = $request->session()->get('sales_table');
        
        if(empty($data))
        {
            $session_data = array();
        }
        else
        {
            if(is_array($data))
            {
                $session_data = $data;
                //print_r($session_data);exit;
            }
            else
            {
                $session_data = array();
            }
        }

        if($request->id) {
            $product = Product::find($request->id);
        }
        if($request->code) {
            $product = Product::where('code', $request->code)->first();
        }
        //  return json_encode(array('product_code'=>$product,'msg'=>'found'));
        if($product != null)
        {
            $product_id = $product->id;
            $code = $product->code;
            $name = $product->name;
            $quantity = $product->quantity;
            $price = $product->price;
            if($quantity > 0)
            {
                foreach($session_data as $key =>$sd)
                {
                    if($sd['product_id']==$product_id)
                    {
                        if( $quantity <= $session_data[$key]['quantity'] ) {
                            return json_encode(array('sales_table'=>array(),'msg'=>'Out Of Stock!'));
                        }

                        $session_data[$key]['quantity'] =  $sd['quantity'] +1;
                        $session_data[$key]['total']    = $session_data[$key]['quantity'] * $sd['price'];
                        $grand_total = 0;
                        foreach($session_data as $sd)
                        {
                            $grand_total +=  $sd['total'];
                        }
                        $request->session()->put('sales_table', $session_data);
                        return json_encode(array('sales_table'=>$session_data,'msg'=>'',
                            'grand_total'=>$grand_total));
                        break;
                    }

                }
                $session_data[] = array('product_id'=>$product_id,'code'=>$code,'name'=>$name,'quantity'=>1,'price'=>$price, 'total'=>1*$price);
                // return json_encode(array('success'=>'Added Successfully!'));

                $grand_total = 0;
                foreach($session_data as $sd)
                {
                    $grand_total +=  $sd['total'];
                }
                
                $request->session()->put('sales_table', $session_data);
                return json_encode(array('sales_table'=>$session_data,'msg'=>'',
                    'grand_total'=>$grand_total));
            }
            else
            {
                return json_encode(array('sales_table'=>array(),'msg'=>'Out of stock...!'));
            }
        } else
        {
            return json_encode(array('sales_table'=>array(),'msg'=>'Not Found(404)!'));
        }

    }


    public function remove(Request $request)
    {
       
        $id = $request->id;
        //return json_encode(array('product_code'=>$code,'msg'=>'found'));

        $data = $request->session()->get('sales_table');

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
            if($sd['product_id'] == $id){
                unset($session_data[$key]);
                break;
            }
        }

        $grand_total = 0;
        foreach($session_data as $sd)
        {
            $grand_total +=  $sd['total'];
        }
        // $request->session()->put('sales_table', $session_data);
        // return json_encode(array('sales_table'=>$session_data,'msg'=>'',
        //     'grand_total'=>$grand_total));  

        $request->session()->put('sales_table', $session_data);
        return json_encode(array('msg'=>'', 'grand_total'=>$grand_total,'id'=>$id));  
    }
    public function allremove(Request $request)
    {
        $request->session()->forget('sales_table');
        $grand_total = 0;
        $request->session()->put('sales_table', '');
        return json_encode(array('sales_table'=> '','msg'=>'Removed Successfully!',
            'grand_total'=>$grand_total));
        
    }
// gg
    public function confirm(Request $request)
    {
        
        $validatedData = $request->validate([
            'grand_total' => 'required|gt:0',
            'change_amount' => 'required',
            'paid' => 'required',
        ]);
        // dd($request->all());
        if($request->paid < $request->grand_total) {
            return redirect()->back()->with('price_error', 'Please Paid Full!');
        }  
        $data = $request->session()->get('sales_table');
        // print_r($data);exit;

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
        $totalqty = 0;
        
        foreach($session_data as $key => $sd){
            $product = Product::find($sd['product_id']);

            if($product->quantity < $sd['quantity'])
            {
                return redirect()->back()->with('price_error', $product->name . ' is not enough quantity!');
            }

            $product->update([
                'quantity' => $product->quantity - $sd['quantity']
            ]);
            
            $totalqty += $sd['quantity'];
            
        }

        $y = date('y');
        $m = date('m');
        $d = date('d');
        $h = date('h');
        $i = date('i');
        $s = date('s');
        $random = $y.$m.$d.$h.$i.$s;
        $shuffled = str_shuffle($random);
        $sale = Sale::create([
            'user_id' => Auth::user()->id,
            'invoice_no' => $shuffled,
            'qty' => $totalqty,
            'total_price' => $request->grand_total,
            'paid' => $request->paid,
            'r_change' => $request->change_amount,
            'date' => date('Y-m-d'),
        ]);
        foreach($session_data as $key => $sd) {
            $saleDetails = SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $sd['product_id'],
                'code' => $sd['code'],
                'qty' => $sd['quantity'],
                'total_price' => $sd['price'] * $sd['quantity']

            ]);
            
            $stock_checks = Stock::where('product_id', $sd['product_id'])->get();
            foreach($stock_checks as $stock_check)
            {
                $stock_check->update([
                    'r_qty' => $stock_check->r_qty - $sd['quantity']
                ]);
            }
        }
        

        $sale = Sale::find($sale->id);
        // $saleDetail = $sale->saleDetail;

        $saleDetail = SaleDetail::where('sale_id', $sale->id)
                                ->select('product_id', DB::raw("SUM(qty) as tqty"), DB::raw("SUM(total_price) as tp"))
                                ->groupBy('product_id')->get();
                                
        // dd($saleDetail);
        $request->session()->forget('sales_table');
        $data = session()->get('session_data');

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
        $product = Product::pluck('name', 'id')->all();
        // return json_encode(array('sale'=> $sale, 'saleDetails'=> $saleDetails, 'msg'=>'Success!'));
        return view('pos.index', \compact('product', 'sale', 'session_data', 'saleDetail'))->with('saleSuccess', 'Successfully!');
        
    }

    public function qtyadd(Request $request)
    {
        $change_qty = $request->qty;
        $id       = $request->id;

        $product = Product::find($id);

        if($product->quantity >= $change_qty)

        {
            $data = $request->session()->get('sales_table');

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
                if($sd['product_id'] == $id){
                    $session_data[$key]['quantity'] = $change_qty;
                    $session_data[$key]['total']    = $change_qty * $sd['price'];
                    break;
                }
            }

            $grand_total = 0;
            foreach($session_data as $sd)
            {
                $grand_total +=  $sd['total'];
            }
            $request->session()->put('sales_table', $session_data);
            return json_encode(array('sales_table'=>$session_data,
            'id'=>$id,
            'msg'=>'',
                'grand_total'=>$grand_total));
        }
        else
        {
            $data = $request->session()->get('sales_table');

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
                if($sd['product_id'] == $id){
                    $session_data[$key]['quantity'] = $product->quantity;
                    $session_data[$key]['total']    = $product->quantity * $sd['price'];
                    break;
                }
            }

            $grand_total = 0;
            foreach($session_data as $sd)
            {
                $grand_total +=  $sd['total'];
            }
            $request->session()->put('sales_table', $session_data);
            return json_encode(array('sales_table'=>$session_data,
            'id'=>$id,
            'msg'=>'Out of stock! Maximum = '.$product->quantity,
                'grand_total'=>$grand_total));
        }


    }

}
