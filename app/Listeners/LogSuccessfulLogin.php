<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\Classes\Detect;
use App\User;
use App\Employee;
use App\MerchantLogActivity;
use App\EmployeeLogActivity; 
use App\Custom;
use Auth;

class LogSuccessfulLogin
{

    public $loggedin_time;

    public $last_seen_at;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->$request = $request;
        $this->last_seen_at = date("Y-m-d H:i:s");
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        
        if(auth()->guard()->check())
        {
            $user = new User();
            $user->update_merchant(["last_seen_at"=>$this->last_seen_at]);
            $user->enable_showmodal(["show_modal"=>"Y"]);


            $log =  new MerchantLogActivity();

            $logdetails = array(
                'log_ipaddress' =>Detect::ipAddress(),
                'log_device'=>Detect::systemInfo()["device"],
                'log_os'=>Detect::systemInfo()["os"],
                'log_browser'=>Detect::browser(),
                'log_time'=>$this->last_seen_at,
                'log_merchant'=>Auth::user()->id
            );

            $log->add_merchant_log($logdetails);

        }else if(auth()->guard("merchantemp")->check()){

            $log =  new Custom();

            $logdetails = array(
                'log_ipaddress' =>Detect::ipAddress(),
                'log_device'=>Detect::systemInfo()["device"],
                'log_os'=>Detect::systemInfo()["os"],
                'log_browser'=>Detect::browser(),
                'log_time'=>$this->last_seen_at,
                'log_merchantemp'=>Auth::guard('merchantemp')->user()->id
            );

            $log->add_merchantemp_log($logdetails);

        }else if(auth()->guard("employee")->check())
        {

            $employee = new Employee();
            $employee->update_employee_details(["last_seen_at"=>$this->last_seen_at],["id"=>auth()->guard("employee")->user()->id]);


            $log =  new EmployeeLogActivity();

            $logdetails = array(
                'log_ipaddress' =>Detect::ipAddress(),
                'log_device'=>Detect::systemInfo()["device"],
                'log_os'=>Detect::systemInfo()["os"],
                'log_browser'=>Detect::browser(),
                'log_time'=>$this->last_seen_at,
                'log_employee'=>auth()->guard("employee")->user()->id
            );

            $log->add_employee_log($logdetails);


            if(auth()->guard("employee")->user()->user_type  == '1')
            {
                Employee::where('id',auth()->guard('employee')->user()->id)->update(['twofa'=>'Y','threefa'=>'Y']);

            }else{

                Employee::where('id',auth()->guard('employee')->user()->id)->update(['twofa'=>'Y']);
            }
            
        }
    }

}
