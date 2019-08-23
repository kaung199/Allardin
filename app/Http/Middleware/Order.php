<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Order
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            if(Auth::user()->role_id == 4 ) {
                return $next($request);
            }

            return abort(404);
        }
    }
}
