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


              $data = $request->json()->all();
              $name = $data['name'];
              $quantity = $data['quantity'];
              $price = $data['price'];
              $user_id = $data['user_id'];


              for($i=0; $i<$quantity; $i++){
                $products = new Order_detail();
                $products->name = $name;
                $products->quantity = $quantity;
                $products->price = $price;
                $products->user_id = $user_id;
                $products->save();

                $data = $products->toArray();

                }

               
                return response()->json($data, 200);




              // $products = $request->json()->all();
              // $rqall = $products['products'];
              // $arrays = json_decode($rqall, true);

              // // if($products) {

              //   foreach($request->products as $id => $product) {

              //     $order_detail = new Order_detail();
              //     $order_detail->name = $product->name;
              //     $order_detail->quantity = (int)$product->quantity;
              //     $order_detail->price = (int)$product->price;
              //     $order_detail->user_id = (int)$product->user_id;
              //     $order_detail->save();

              //     $data = $order_detail->toArray();


              //   }
              //   return response()->json($data, 200);

              // // }
              
              
                //   $products = $request->products;

                //   foreach($products as $product) {
                //     $order_detail = new Order_detail();
                //     $order_detail->name = $product['name'];
                //     $order_detail->quantity = (int)$product['quantity'];
                //     $order_detail->price = (int)$product['price'];
                //     $order_detail->user_id = (int)$product['user_id'];                      
                //     $order_detail->save();

                //   }
                  

                // $data = $order_detail->toArray();

                // return response()->json($data, 200);
            }


            public function show()
            {
              $order_detail = Order_detail::all();
              $data = $order_detail->toArray();
              return response()->json($data, 200);
            }


         
}
