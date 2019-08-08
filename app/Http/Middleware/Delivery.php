<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Delivery
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
            if(Auth::user()->role_id == 3) {
                return $next($request);
            }
            if(Auth::user()->role_id == 1) {
                return $next($request);
            }
            if(Auth::user()->role_id == 2) {
                return $next($request);
            }

            return abort(404);
        }
    }
}
