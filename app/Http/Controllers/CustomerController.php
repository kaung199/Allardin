<?php

namespace App\Http\Controllers;
use App\User;
use App\Order;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $users = User::whereNull('role_id')->get();
        return view('customers.index',compact('users'));
    }

    public function customerdetail($id)
    {
        $orders = Order::where('user_id', $id)->get();
        return view('customers.customerdetail',compact('orders'));
    }

    public function dashboard()
    {
        $users = User::whereNull('role_id')->get();
        $countusers = count($users);
        
        // daily order
        $today = Carbon::now()->toDateString();
        $orderso = Order::where([ 
            [deliverystatus, 1],
            ['orderdate', $today]
            ])->get();

        $ordersd = Order::where([ 
            [deliverystatus, 2],
            ['orderdate', $today]
            ])->get();

        $ordersp = Order::where([ 
            [deliverystatus, 3],
            ['orderdate', $today]
            ])->get();

        $ordersc = Order::where([ 
            [deliverystatus, 4],
            ['orderdate', $today]
            ])->get();

        $allorderd = Order::where('orderdate', $today)->get();

        $countallorderd = count($allorderd);
        $countorderso = count($orderso);
        $countordersd = count($ordersd);
        $countordersp = count($ordersp);
        $countordersc = count($ordersc);

    // monthly order
        $thismonth = Carbon::now()->format('Y-m');
        $ordersmo = Order::where([ 
            [deliverystatus, 1],
            ['monthly', $thismonth]
            ])->get();

        $ordersmd = Order::where([ 
            [deliverystatus, 2],
            ['monthly', $thismonth]
            ])->get();
        
        $ordersmp = Order::where([ 
            [deliverystatus, 3],
            ['monthly', $thismonth]
            ])->get();

        $ordersmc = Order::where([ 
            [deliverystatus, 4],
            ['monthly', $thismonth]
            ])->get();
        
        $allorderm = Order::where('monthly', $thismonth)->get();
        

        $countallorderm = count($allorderm);
        $countordersmo = count($ordersmo);
        $countordersmd = count($ordersmd);
        $countordersmp = count($ordersmp);
        $countordersmc = count($ordersmc);
    
    // Yearly orders
        $thisyear = Carbon::now()->format('Y');
            $ordersyo = Order::where([ 
                [deliverystatus, 1],
                ['yearly', $thisyear]
                ])->get();
            
            $ordersyd = Order::where([ 
                [deliverystatus, 2],
                ['yearly', $thisyear]
                ])->get();

            $ordersyp = Order::where([ 
                [deliverystatus, 3],
                ['yearly', $thisyear]
                ])->get();

            $ordersyc = Order::where([ 
                [deliverystatus, 4],
                ['yearly', $thisyear]
                ])->get();
        
        $allordery = Order::where('yearly', $thisyear)->get();

        $countallordery = count($allordery);
        $countordersyo = count($ordersyo);
        $countordersyd = count($ordersyd);
        $countordersyp = count($ordersyp);
        $countordersyc = count($ordersyc);


        return view('dashboard', \compact('countallorderd','countallorderm','countallordery','countusers','countorderso','countordersd','countordersp','countordersc','countordersmo','countordersmd','countordersmp','countordersmc','countordersyo','countordersyd','countordersyp','countordersyc'));
    }
}
