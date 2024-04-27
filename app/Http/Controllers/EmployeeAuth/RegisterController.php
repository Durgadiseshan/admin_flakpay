<?php

namespace App\Http\Controllers\EmployeeAuth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Http\Controllers\SmsController;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/email-verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $data_time;

    public function __construct()
    {
        $this->middleware('guest');
        $this->data_time = date("Y-m-d H:i:s");
    }

    protected function guard()
    {
        return auth()->guard('employee');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchant',
            'mobile_no' => 'required|max:10|unique:merchant',
            'password' => ['required','string','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
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

        $userid = User::orderBy('id','desc')->first()->id;

        if($userid == null)
        {
            $nextuserid = 2021;

        }else{
            $nextuserid = 2021+$userid;
        }

        $user = User::create([
            'merchant_gid' => "pf".$nextuserid,
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' =>$data['mobile_no'],
            'password' => bcrypt($data['password']),
            'verify_token'=>Str::random(25),
            'created_date'=>$this->data_time
        ]);

        $user->sendAccountVerificationEmail();
        
        $OTP = mt_rand(99999,1000000);

        $message = "Dear ".$data['name'].", ".$OTP." is the OTP for verifying your mobile with NeoPay. Warm Regards, Rockpay";
        
        $sms = new SmsController($message,$data['mobile_no'],"1307164793014633860");

        $sms->sendMessage();

        session(['merchant_gid' => "pf".$nextuserid,"OTP"=>$OTP]);

        return $user;
    }
}
