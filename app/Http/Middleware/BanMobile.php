<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\Detect;

class BanMobile
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

        // if(Detect::systemInfo()['device'] == 'MOBILE')
        // {
        //     return redirect('flakpay/login');
        // }
        return $next($request);
    }
}
