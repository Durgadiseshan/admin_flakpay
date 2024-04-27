<?php

namespace App\Http\Controllers\EmployeeAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Classes\ValidationMessage;
use App\Mail\SendMail;
use App\Employee;


class ForgotPasswordController extends Controller
{


    private $datetime="";

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function admin_forget_password(Request $request){
        return view('employeeauth.adminforgetpassword');
    }

    function verify_email(Request $request){
        if($request->ajax()){

            $rules = [
                'official_email'=> 'required|string',
            ];
    
            $messages = [
                "official_email.required"=>"Email is required",
            ];
    
            $validator = Validator::make($request->all(), $rules,$messages);
    
            if($validator->fails())
            {
                echo json_encode(["status"=>FALSE,"error"=>$validator->errors()]);
    
            }else{
    
                $employee_credentials = $request->except('_token');
                $employee = Employee::where('official_email',$request['official_email'])->first();
                if(isset($employee))
                {
                    if($employee->user_type == '1' && $employee->employee_status = "active")
                    {
                        session(["login_employee_id"=>$employee->id]);
                        session(["employee_credentials"=>$employee_credentials]);
                        session(["employee_details"=>$employee]);
                        echo json_encode(['status'=>TRUE]);

                    }
                }else{

                    //GenerateLogs::login_failed();
                    echo json_encode(['status'=>FALSE,'message'=>'You entered wrong email']);

                }
            }
        }
    }

    public function load_email_form(Request $request){

        $employee = Employee::where('id',$request->session()->get("login_employee_id"))->first();

        $OTP = mt_rand(99999,1000000);

        $full_name = $employee->first_name." ".$employee->last_name;

        $data = array(
            "from"=>env("MAIL_USERNAME", ""),
            "subject"=>"Rockpay Admin Password Reset",
            "view"=>"maillayouts.forgetalert",
            "htmldata"=>array(
                "employee_name"=>$full_name,
                "otp"=>wordwrap($OTP, 2 ,'-',true)
            )
        );
        session(['rupayapay-email-verify'=>$OTP]);
        
        Mail::to($employee->official_email)->send(new SendMail($data));

        return View::make("employeeauth.employeemodal")->with(["email_auth"=>'Y'])->render();
    }

    public function load_mobile_form(Request $request){

        $employee = Employee::where('id',$request->session()->get("login_employee_id"))->first();

        $OTP = mt_rand(99999,1000000);

        $full_name = $employee->first_name." ".$employee->last_name;

        $message = "Hi ".$employee->first_name." ".$employee->last_name.", Use this OTP ".wordwrap($OTP, 2 ,'-',true)." for changing Neopay account password. -Neopay";
        
        $sms = new SmsController($message,$employee->mobile_no,"1307164793075795400");

        $sms->sendMessage();
        

        session(['rupayapay-mobile-verify'=>$OTP]);

        return View::make("employeeauth.employeemodal")->with(["mobile_auth"=>"Y"])->render();

    }

    public function load_reset_password_form(){

        return View::make("employeeauth.employeemodal")->with(["reset_password_form"=>"Y"])->render(); 
    }


    public function verify_email_otp(Request $request)
    {
        if(str_ireplace("-","",$request->email_otp) == session('rupayapay-email-verify'))
        {
            
            if($request->session()->get("employee_details")["user_type"] == "1")
            {
                echo json_encode(["status"=>TRUE,"load_mobile_form"=>TRUE]); 
            }

        }else{

            echo json_encode(["status"=>FALSE,"message"=>ValidationMessage::$validation_messages['rupayapay_wrong_otp']]);
        }
    }

    public function verify_mobile_otp(Request $request)
    {
        if(str_ireplace("-","",$request->mobile_otp) == session('rupayapay-mobile-verify'))
        {
           
            $request->session()->forget('rupayapay-email-verify');
            $request->session()->forget('rupayapay-mobile-verify');
            $request->session()->forget('employee_credentials');
            $request->session()->forget('employee_details'); 
            echo json_encode(["status"=>TRUE]);
  
        }else{

            echo json_encode(["status"=>FALSE,"message"=>ValidationMessage::$validation_messages['rupayapay_wrong_otp']]);
        }
    }

    public function verify_empmobile_OTP(Request $request){

        if(session("firsttimepasswordOTP") == $request->firsttimepasswordOTP)
        {
            $request->session()->forget('firsttimepasswordOTP');
            echo json_encode(["status"=>TRUE]);
        }else{

            $message = ValidationMessage::$validation_messages["wrong_OTP"];
            echo json_encode(["status"=>FALSE,"message"=>$message]);
        }
    }
}
