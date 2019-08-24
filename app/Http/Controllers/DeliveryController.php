<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dstore;
use Illuminate\Support\Facades\Hash;
use App\Delivery;
use App\User;
use Auth;

class DeliveryController extends Controller
{
   
    public function index()
    {
        $deliveries = User::where('role_id', 3)->get();
        return view('delivery.index', \compact('deliveries'));
    }

    public function create()
    {
        return view('delivery.create');
    }
    
    public function store(Dstore $request)
    {
        if(Auth::user()->role_id == 1) {
            if($request->role == Admin) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'role_id' => 2,
                    'password' => Hash::make($request->password),
                ]);
                return redirect('admin');
            }
            if($request->role == Order) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'role_id' => 4,
                    'password' => Hash::make($request->password),
                ]);
                return redirect('admin');
            }
            if($request->role == Delivery) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'role_id' => 3,
                    'password' => Hash::make($request->password),
                ]);
                return redirect('deliveries');
            }
        }
         return abort(404);
    }

    public function destroy(User $delivery)
    {
        $delivery->delete();
        return redirect('deliveries');
    }
}
