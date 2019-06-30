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

              $products = $request->json()->all();
              foreach($products as $product) {
                $pro = Order_detail::create([
                  'name' => $product['name'],
                  'quantity' => $product['quantity'],
                  'price' => $product['price'],
                  'totalprice' => $product['totalprice'],
                  'user_id' => $product['user_id'],
                  'product_id' => $product['id'],
                ]);
                
                $productt = Product::find($product['id']);               
                $productt->update([
                     'quantity' => $productt->quantity - $product['quantity'],
                 ]);

                $gtotalprice += $product['totalprice'];
                $gtotalquantity += $product['quantity'];


              }

              $order = Order::create([
                'totalquantity' => $gtotalquantity,
                'totalprice' =>  $gtotalprice,
                'user_id' => $product['user_id'],
                'township_id' => $product['township_id'],
                'deliverystatus' => 1,

              ]);
              $data1 = $order->toArray();
              $data2 = $pro->toArray();
              $data3 = $productt->toArray();

              return response()->json([$data1,$data2,$data3], 200);
             

            }


            public function show()
            {
              $order_detail = Order_detail::latest()->get();
              $data = $order_detail->toArray();
              return response()->json($data, 200);
            }

            public function orders()
            {

              $order_detail = Order::latest()->get();
              $data = $order_detail->toArray();
              return response()->json($data, 200);
            }


         
}
