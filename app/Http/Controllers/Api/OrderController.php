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

              $products = $request->json()->all();
              $rqall = $products['products'];
              $arrays = json_decode($rqall, true);

              // if($products) {

                foreach($arrays as $id => $product) {

                  $order_detail = new Order_detail();
                  $order_detail->name = $product['name'];
                  $order_detail->quantity = (int)$product['quantity'];
                  $order_detail->price = (int)$product['price'];
                  $order_detail->user_id = (int)$product['user_id'];
                  $order_detail->save();

                  $data = $order_detail->toArray();


                }
                return response()->json($data, 200);
              // }
              
              
                //   $product = $request->products;
                //   $order_detail = new Order_detail();
                //   $order_detail->name = $product['name'];
                //   $order_detail->quantity = (int)$product['quantity'];
                //   $order_detail->price = (int)$product['price'];
                //   $order_detail->user_id = (int)$product['user_id'];                      
                //   $order_detail->save();

                //   $data = $order_detail->toArray();

                // return response()->json($data, 200);
            }


            public function show()
            {
              $order_detail = Order_detail::all();
              $data = $order_detail->toArray();
              return response()->json($data, 200);
            }


      //   	  //for Order table
      //   	  $totalprice = 0;
      //       $totalquantity = 0;

      //       //for Order_detail
      //       $totalq = 0;
      //       $totalp = 0;

      //       $user = User::find($id);

      //       foreach( $request->products as $pid => $product) {

      //   	    Order_detail::create([
      //   	            'name' => $product->name,
      //   	            'quantity' =>  $totalq += $product->quantity,
      //   	            'price' =>  $totalp += $product->price,
      //   	            'user_id' => $user->id,

      //   	        ]);

      //     		$totalprice += $product->price * $product->quantity;
      //     		$totalquantity += $product->quantity;


      //     		$productt = Product::find($pid);
      //     		$grandqty = $productt->quantity - $product->quantity;

          		
      //     		$productt->update([
      //     		    'quantity' => $grandqty,
      //     		]);

      //       }
            
      //       $order = Order::create([
      // 			'totalquantity' => $totalquantity,
      // 			'totalprice' =>  $totalprice,
      //       'deliverystatus' =>  $request->deliverystatus,
      //       'orderdate' => $request->orderdate,
      // 			'user_id' => $user->id,

    		// ]);
            

            // foreach(session('cart') as $cart => $details) {

            //     $totalq = 0;
            //     $totalp = 0;

            //     Orderdetail::create([
            //         'name' => $details['name'],
            //         'quantity' =>  $totalq += $details['quantity'],
            //         'price' =>  $totalp += $details['price'],
            //         'user_id' => Auth()->user()->id,

            //     ]);

            //     $total += $details['price'] * $details['quantity'];
            //     $totalquantity += $details['quantity'];


            //     $product = Product::find($cart);
            //     $grandqty = $product->quantity - $details['quantity'];

                
            //     $product->update([
            //         'quantity' => $grandqty,
            //     ]);
            // }    	
            

    		// $checkout = Checkout::create([
    		// 	'totalquantity' => $totalquantity,
    		// 	'totalprice' =>  $total,
      //           'orderdate' => $_POST['orderdate'],
    		// 	'user_id' => Auth()->user()->id,

    		// ]);

            
      //   	$user = User::find($id);
      //   	$user->name = $_POST['name'];
      //   	$user->phone = $_POST['phone'];
      //   	$user->address = $_POST['address'];
      //   	$user->save();

      //       session()->forget('cart');


      //       //mail
      //       $today = Carbon::now()->toDateString();

      //       $todayorder = Checkout::where('orderdate', $today)->get();

      //       $pdf = PDF::loadView('pdf', compact('todayorder'));

      //       Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)use($pdf)
      //       {
      //           $message->subject('Thanks You for your purcheses!');
      //           $message->from('Online_Shopping@website.com', 'Online_Shopping');
      //           $message->to('kaunghtetzaw.khz9@gmail.com');
      //           $message->attachData($pdf->output(), 'pdf.pdf');
      //       });

      //   	return redirect('/')->with('email', 'Checkout Successfully check you email!');       


        
}
