<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash; 
use App\Http\Controllers\Auth\LoginMerchantEmployee;
use App\User;
use App\MerchantEmployee;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/merchant/dashboard';

    protected $redirectTopage = '/business-details';


    private $login_attempts_count = 3;

    private $todaydate = "";

    private $datetime="";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         //echo get_auth_user_id();die();
        $this->middleware('guest')->except('logout');
    }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login')->with("loadcss","login");
    }

    public function verifyLogin(Request $request)
    {   

        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha'=> 'required|captcha',
        ];

        $messages = [
            "email.required"=>"Username field is required",
            "password.required"=>"Password field is required",
            'captcha.captcha'=>'Invalid captcha code.Please try again.'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);


        if($validator->fails())
        {
            echo json_encode(["status"=>FALSE,"errors"=>$validator->errors()]);

        }else{

            $credentials = $request->except('_token');
            $merchant = User::where('email',$request['email'])->first();
            // dd($merchant); 

            $meremployee = MerchantEmployee::where('employee_email',$request['email'])->first();

            if(isset($merchant))
            {
                $validCredentials = Hash::check($request['password'],$merchant->getAuthPassword());

                if ($validCredentials) {

                    if($merchant->is_account_locked == 'Y')
                    {
                        $message = "Your account got lock temporary due to multiple login attempts <br>contact our customer support to unlock";
                        echo json_encode(['status'=>FALSE,'message'=>$message]);

                    }else if($merchant->merchant_status == 'inactive'){
                        $message = "Your account has deactivated for some reasons<br>contact our customer support to activate your account";
                        echo json_encode(['status'=>FALSE,'message'=>$message]);
                    }else if ($merchant->is_verified == 'Y'){

                        User::where('id',$merchant->id)->update(['failed_attempts'=>0]);

                        $this->attemptLogin($request);
                        echo json_encode(['status'=>TRUE,'redirect'=>$this->redirectTo]);
                    }
                    else if ($merchant->user_register !== 'N'){
                        // User::where('id',$merchant->id)->update(['failed_attempts'=>0]);
                        // $this->attemptLogin($request);
                        // echo json_encode(['status'=>TRUE,'redirect'=>$this->redirectTo]);

                        $message = "Admin not verified.Please Contact Admin!";
                        echo json_encode(['status'=>FALSE,'message'=>$message]);
                        
                    }
                    
                    
                    // if($merchant->is_verified == 'Y'){

                    //     User::where('id',$merchant->id)->update(['failed_attempts'=>0]);
                    //     $this->attemptLogin($request);
                    //     echo json_encode(['status'=>TRUE,'redirect'=>$this->redirectTo]);
                    // }
                    else{
                        $message = "Admin not verified";
                        echo json_encode(['status'=>FALSE,'message'=>$message]);
                    }

                }else{

                    if($merchant->failed_attempts < $this->login_attempts_count)
                    {
                        User::where('id',$merchant->id)->update(['failed_attempts'=>$merchant->failed_attempts+1]);
                        switch ($merchant->failed_attempts) {
                            case '0':
                                $message = "Only ".($merchant->failed_attempts+1)."/3 Passwords Attempts left";
                                break;
                            case '1':
                                $message = "Only ".($merchant->failed_attempts+1)."/3 Passwords Attempts left";
                                break;
                            case '2':
                                $message = "Account will get lock temporary, If you fail this time";
                                break;
                        }
                        echo json_encode(['status'=>FALSE,'message'=>'You entered wrong credentials <br>'.$message]);
                    }else{

                        User::where('id',$merchant->id)->update(['is_account_locked'=>'Y']);
                        $message = "Your account got lock temporarily,contact our customer support to unlock";
                        echo json_encode(['status'=>FALSE,'message'=>$message]); 
                    
                    }
                }
            }else{
                if($meremployee){
                    
                    $validCredentials = Hash::check($request['password'],$meremployee->getAuthPassword());
                    
                    if ($validCredentials) {


                        if($meremployee->is_account_locked == 'Y')
                        {
                            $message = "Your account got lock temporary due to multiple login attempts <br>contact merchant to unlock";
                            echo json_encode(['status'=>FALSE,'message'=>$message]);

                        }else if($meremployee->employee_status == 'inactive'){

                            $message = "Your account has been deactivated <br>contact merchant to activate";
                            echo json_encode(['status'=>FALSE,'message'=>$message]);

                        }else{

                            $loginmerchantemp = new LoginMerchantEmployee();
                            $login_status = $loginmerchantemp->verifyLogin($credentials,$request);
                            echo json_encode(['status'=>$login_status["status"],'redirect'=>$login_status["redirect"]]);
                        }
                        
    
                    }else{
    
                        if($meremployee->failed_attempts < $this->login_attempts_count)
                        {
                            MerchantEmployee::where('id',$meremployee->id)->update(['failed_attempts'=>$meremployee->failed_attempts+1]);
                            switch ($meremployee->failed_attempts) {
                                case '0':
                                    $message = "Only ".($meremployee->failed_attempts+1)."/3 Passwords Attempts left";
                                    break;
                                case '1':
                                    $message = "Only ".($meremployee->failed_attempts+1)."/3 Passwords Attempts left";
                                    break;
                                case '2':
                                    $message = "Account will get lock temporary, If you fail this time";
                                    break;
                            }
                            echo json_encode(['status'=>FALSE,'message'=>'You entered wrong credentials <br>'.$message]);
                        }else{
    
                            MerchantEmployee::where('id',$meremployee->id)->update(['is_account_locked'=>'Y']);
                            $message = "Your account got lock temporarily,contact your merchant to unlock";
                            echo json_encode(['status'=>FALSE,'message'=>$message]); 
                        
                        }
                    }

                }else{
                    echo json_encode(['status'=>FALSE,'message'=>'You entered wrong credentials']);
                }
                
            }
            
            
        }
    
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

}
