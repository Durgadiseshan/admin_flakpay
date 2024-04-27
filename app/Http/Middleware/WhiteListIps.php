<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\Detect;

class WhiteListIps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $white_list_ips;

    public function handle($request, Closure $next)
    {
        $this->white_list_ips = [
            "157.48.187.14",
            "106.208.70.74",
            "123.201.77.5"
        ];

        if(!in_array(Detect::ipAddress(),$this->white_list_ips))
        {
            return redirect('/login');
        }

        return $next($request);
    }
}
