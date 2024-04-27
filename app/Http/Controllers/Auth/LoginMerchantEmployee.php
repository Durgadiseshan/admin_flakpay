<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginMerchantEmployee extends Controller
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
    
    // protected $empredirectTo = '/merchant/employee/transactions';
    protected $empredirectTo = '/merchant/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:merchantemp')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('merchantemp');
    }


    public function verifyLogin($credentails,$request){

        if (Auth::guard('merchantemp')->attempt(['employee_email' => $request->email,'password' => $request->password], $request->get('remember'))) {
            
            return ["status"=>TRUE,"redirect"=>$this->empredirectTo];

        }else{
            
            return ["status"=>FALSE,"redirect"=>$this->empredirectTo];
        }
    }

    public function logout(Request $request)
    {
        $this->guard('merchantemp')->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}
