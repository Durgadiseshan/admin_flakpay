<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/merchant/dashboard');
        }else if(Auth::guard('employee')->check()){
            return redirect('/flakpay/dashboard');
        }else if(Auth::guard('merchantemp')->check()){
          //return redirect('/merchant/employee/transactions');
            return redirect('/merchant/dashboard');
        }

        return $next($request);
    }
}
