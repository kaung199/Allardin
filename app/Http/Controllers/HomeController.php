<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        // User role
        $role = Auth::user()->role_id; 
        
        // Check user role
        switch ($role) {
            case 1:
                    return redirect('/admin');

                break;
            case 2:
                    return redirect('/adminindex');
                break; 
            case 3:
                    return redirect('/deliverydd');
                break;
            case 4:
                    return redirect('/orderpreparep');
                break;
            case 5:
                    return redirect('/pos');
                break;
            default:
                    return '/admin'; 
                break;
        }
    }
}
