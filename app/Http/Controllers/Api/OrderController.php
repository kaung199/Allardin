<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\Order;
use App\Order_detail;
class OrderController extends Controller
{         	


            public function store(Request $request)

            {

              $gtotalprice = 0;
              $gtotalquantity = 0;

              $data = $request->json()->all();
              $id = $data['product_id'];
              $name = $data['name'];
              $quantity = $data['quantity'];
              $price = $data['price'];
              $totalprice = $data['totalprice'];
              $user_id = $data['user_id'];
              $township_id = $data['township_id'];


              for($i=0; $i<$quantity; $i++) {
                $products = new Order_detail();
                $products->name = $name;
                $products->quantity = $quantity;
                $products->price = $price;
                $products->user_id = $user_id;
                $products->product_id = $id;
                $products->save();

                // $product = Product::find($id);
                // $grandqty = $product->quantity - $quantity;
                
                // $product->update([
                //     'quantity' => $grandqty,
                // ]);

                // $gtotalprice += $totalprice * $quantity;
                // $gtotalquantity += $quantity;


              }

              // $order = Order::create([
              //   'totalquantity' => $gtotalquantity,
              //   'totalprice' =>  $gtotalprice,
              //   'orderdate' => date('d-m-y'),
              //   'user_id' => $user_id,
              //   'township_id' => $township_id,
              //   'deliverystatus' => 1,

              // ]);
              // $dataorder = $order->toArray(); 
              // $dataproduct = $product->toArray(); 
              // $data = $products->toArray();
              // return response()->json([$data,$dataorder,$dataproduct], 200);

              $data = $products->toArray();
              return response()->json($data, 200);
            }


            public function show()
            {
              $order_detail = Order_detail::all();
              $data = $order_detail->toArray();
              return response()->json($data, 200);
            }


         
}
