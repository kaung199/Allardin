<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }

    public function redirectTo(){
        
        // User role
        $role = Auth::user()->role_id; 
        
        // Check user role
        switch ($role) {
            case 1:
                    return '/admin';
                break;
            case 2:
                    return '/admin';
                break; 
            case 3:
                    return '/deliverydd';
                break;
            case 4:
                    return '/orderpreparep';
                break;
            default:
                    return '/login'; 
                break;
        }
    }

}
