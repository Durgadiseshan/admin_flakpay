<?php

namespace App\Http\Middleware;

use Closure;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$quard='employee')
    {
        if(!auth()->guard($quard)->check())
        {
            return redirect("/flakpay/login");
        }

        return $next($request);
    }
}
