<?php

namespace App\Http\Controllers\flakpayCMSAuth;

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

class CMSRegController extends Controller
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
    protected $redirectTo = '/login';

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
        ],
        ['password.regex'=>'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function websiteinsertapi(Request $request)
    {

    // dd($request);
        // Validate the incoming request data
        $validator = $this->validator($request->all());
// dd($validator);
        

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Generate a unique merchant ID
        $userObject = new User();

        $merchant_count = $userObject->getLastUserIndex();
        $merchant_gid = preg_replace('/[^0-9]/', '', $merchant_count[0]->merchant_count);
        $nextuserid = ($merchant_count[0]->merchant_count == 0) ? 1 : (1 + $merchant_gid);
        $merchantId = "flakpay" . str_pad($nextuserid, 4, '0', STR_PAD_LEFT);
        // dd($request->all());
        $virtual_id='ABCD_'.Str::random(4);
        
        // Create the user
        $user = User::create([
            'merchant_gid' => $merchantId,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile_no' => $request->input('mobile_no'),
            'password' => bcrypt($request->input('password')),
            'verify_token' => Str::random(25),
            'is_mobile_verified' => 'Y',
            'i_agree' => 'Y',
            'virtual_id'=>$virtual_id,
            'created_date' => now(),
        ]);
// dd($user);
        // You can add additional logic or send verification emails here

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    
  

   

    
}
