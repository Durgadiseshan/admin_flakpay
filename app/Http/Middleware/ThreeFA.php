<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Controllers\SmsController;

class ThreeFA
{


    protected $empGuard;

    public function __construct(){

        $this->empGuard = auth()->guard('employee')->user();
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::guard('employee')->check())
        {
            $OTP = mt_rand(99999,1000000);
            $full_name = $this->empGuard->first_name." ".$this->empGuard->last_name;

            if($this->empGuard->twofa == 'Y' && $this->empGuard->user_type == '1' && $this->empGuard->threefa == 'N')
            {

                $message = "Your OTP for this sessions is ".$OTP." -NeoFin";
                
                $sms = new SmsController($message,$this->empGuard->mobile_no,"1307164802055109977");

                $sms->sendMessage();

                session(['rupayapay-mobile-verify'=>$OTP]);
                
                return redirect()->route('rupayapay-mobile');
            }
        }
        return $next($request);
    }
}
