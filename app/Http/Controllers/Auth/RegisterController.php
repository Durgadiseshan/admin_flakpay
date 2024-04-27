<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ContactUs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Classes\GenerateLogs;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Http\Controllers\SmsController;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public $send_messages_count = 0;

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/business-details';


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $date_time;

    public function __construct()
    {
        $this->middleware('guest');
        $this->date_time = date("Y-m-d H:i:s");
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register')->with("loadcss","register");
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:merchant',
            'mobile_no' => 'required|max:10|unique:merchant',
            'password' => ['required','string','min:8','max:20','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'captcha'=> 'required|captcha',
        ],['password.regex'=>'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $userObject = new User();

        $merchant_count = $userObject->getLastUserIndex();
        $merchant_gid = preg_replace('/[^0-9]/', '', $merchant_count[0]->merchant_count);
        if($merchant_count[0]->merchant_count == 0)
        {
            $nextuserid = 01;

        }else{
            
            $nextuserid = (1+$merchant_gid);
        }
        
        $virtual_id='ABCD_'.Str::random(4);

        $user = User::create([
            'merchant_gid' => "Flakpay-".$nextuserid,
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' =>$data['mobile_no'],
            'password' => bcrypt($data['password']),
            'verify_token'=>Str::random(25),
            'is_mobile_verified'=>'Y',
            'i_agree'=>'Y',
            'created_date'=>$this->date_time,
            'virtual_id'=>$virtual_id,
            
        ]);
        

        $user->sendAccountVerificationEmail();
        
        return $user;
    }

    public function register(Request $request)
    {

        if(session('0TP') == $request->otp_number)
        {
            // dd($this->redirectTo);

            event(new Registered($user = $this->create(session('register_data'))));

            $registration_status = ['status'=>TRUE,'redirect'=>$this->redirectTo];
            session()->forget(['OTP','register_data']);
            session()->flash('register-message', 'You have register successfully Please Login');
            $data = array(
                "from" => env("MAIL_USERNAME", ""),
                "subject" => "Flakpay New Merchant Registration Details:",
                "view" => "/maillayouts/newregistration",
                "htmldata" => array(
                    "name" => $user->name,
                    "mobile" => $user->mobile_no,
                    "email" => $user->email,
                    "MID" => $user->merchant_gid,
                ),
            );

            // Mail::to("edgetechmediawork@gmail.com")->send(new SendMail($data));
            return $this->registered($request, $user)
                            ?: $registration_status;
            
        }else{
            echo json_encode(['status'=>FALSE,'message'=>'You entered wrong OTP']);
        }
       
    }

    public function mobile_register(Request $request){

        // dd($request);

        if($request->ajax())
        {

            if($request->has('i_agree'))
            {
                $validator = Validator::make($request->all(), [
                    'name' => ['required','string','max:50','regex:/^[a-zA-Z ]+$/'],
                    'email' => 'required|string|email|max:50|unique:merchant',
                    'mobile_no' => 'required|digits:10|numeric|unique:merchant',
                    'password' => ['required','string','min:8','max:20','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
                ],['name.regex'=>'The name should not contain special character and numbers',
                    'password.regex'=>'Password should contain at least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)',
                    'email.unique'=>'The email has already been taken.',
                    'mobile.unique'=>'The mobile no has already been taken.',
                ]
                );
    
                if($validator->fails())
                {
                    echo json_encode(array("status"=>FALSE,"errors"=>$validator->errors())); 
    
                }else{
                    $register_data = $request->except('_token','captcha','password_confirmation');
                    
                    
                    $OTP = mt_rand(99999,1000000);
                    $data = array( 
                        "from" => env("MAIL_USERNAME", ""),
                        "subject" => "Flakpay Login OTP",
                        "view" => "/maillayouts/loginalert",
                        "htmldata" => array(
                            "employee_name" =>$register_data['name'],
                            "otp"=>$OTP,
                            "email"=>$register_data['email'],
                        ),
                    );


                    // dd($data);
                    session()->forget('wrong_otp_enter');
                    session(['0TP'=>$OTP,'register_data'=>$register_data]);

                    
                   Mail::to($register_data['email'])->send(new SendMail($data));
                    
                //    dd($register_data['email']);
                
                // $merchant = User::where('email', $register_data['email'])->first();
                // dd($merchant);
                
                // if ($merchant) {
                //     User::where('id', $merchant->id)->update(['user_register' => 'Y']);
                // }

                    // User::where('email', $register_data['email'])->update(['user_register' => 'Y']);
                
                    echo json_encode(['status'=>TRUE,'message'=>'Complete your registration by verifying your gmail']);
                }   
            }else{
                echo json_encode(array("status"=>FALSE,"message"=>"Please check the box for registering with FinXpay.")); 
            }
            
        }

    }

    public function resend_mobileOTP(Request $request)
    {
        if($request->ajax())
        {

            $OTP = mt_rand(99999,1000000);

            $message = "Dear ".session('register_data')['name'].", ".$OTP." is the OTP for verifying your mobile with Flakpay. Warm Regards, Flakpay";
            
            $sms = new SmsController($message,session('register_data')['mobile_no'], "1707165208022665169");
            //session()->forget('send_messages_count');
            if(!session('send_messages_count'))
            {
                session(['send_messages_count'=>$this->send_messages_count+1,'0TP'=>$OTP]);
                $sms->sendMessage();
                echo json_encode(['status'=>true,'message'=>'Sent an OTP to your mobile again']);

            }else{

                if(session('send_messages_count') < 3)
                {
                    session(['send_messages_count'=>session('send_messages_count')+1]);
                    $sms->sendMessage();

                    echo json_encode(['status'=>true,'message'=>'Sent an OTP to your mobile again']);

                }else if(session('send_messages_count') == 3){

                    $contact_data = Arr::except(session('register_data'),'password');
                    $contact_data["created_date"] = $this->date_time;
                    $contact_data["lead_from"] = 'registration';

                    $contactus = new ContactUs();

                    $insert_status = $contactus->add_contactus($contact_data);

                    if($insert_status)
                    {
                        echo json_encode(['status'=>true,'message'=>'You have exceeded sms limit, <br> please contact our customer support mobile no is 9087711911']);
                    }

                }else{
                    echo json_encode(['status'=>true,'message'=>'You have exceeded sms limit, <br> please contact our customer support mobile no is 9087711911']);
                }
            } 
            
        }
    }
    
}
