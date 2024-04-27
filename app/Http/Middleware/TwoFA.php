<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class TwoFA
{


    protected $merGuard;

    protected $empGuard;


    public function __construct(){

        $this->merGuard = auth()->user();

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
        if(Auth::guard()->check())
        {
            // dd('test');
            // if ($this->merGuard->is_email_verified == "Y") {

            //     if ($this->merGuard->merchant_business == "N") {
    
            //         return redirect('/business-details');
    
            //     }
            // }else{
    
            //     return redirect('/account-locked');
            // }
            
        }else if(Auth::guard('employee')->check()){

            $OTP = mt_rand(99999,1000000);
            $full_name = $this->empGuard->first_name." ".$this->empGuard->last_name;

            if($this->empGuard->ft_login == 'Y')
            {
                return redirect()->route('rupayapay-ft-password');

            }else if($this->empGuard->twofa == 'N' && $this->empGuard->ft_login == 'N'){

                $data = array(
                    "from"=>env("MAIL_USERNAME", ""),
                    "subject"=>"Neopay Login Alert",
                    "view"=>"maillayouts.loginalert",
                    "htmldata"=>array(
                        "employee_name"=>$full_name,
                        "otp"=>$OTP
                    )
                );
                session(['rupayapay-email-verify'=>$OTP]);
                $mail_status = Mail::to($this->empGuard->official_email)->send(new SendMail($data));
                return redirect()->route('rupayapay-email');
            }
        }
        return $next($request);
        
    }
}
