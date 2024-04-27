<?php

namespace App\Http\Controllers\EmployeeAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SmsController;
use App\Classes\ValidationMessage;
use App\Mail\SendMail;
use App\Employee;
use App\EmpPasswordHistory;

class ResetPasswordController extends Controller
{
    private $datetime="";
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/rockpay/login';

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

    protected function guard()
    {
        return auth()->guard('employee');
    }

    public function reset_admin_password(Request $request)
    {
        $data = $request->all();
        $rules = [
            "password"=>['required','string','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
        ];
        $messages = ['password.regex'=>'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)'];
        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails())
        {
            echo json_encode(["status"=>FALSE,"errors"=>$validator->errors()]);

        }else{

            $employee = [];
            $employeeObject =  new Employee();
            $password_history = new EmpPasswordHistory();
            $password_exists =  false;

            $employee_existing_passwords = $password_history->get_password_history($request->session()->get("login_employee_id"));
 
            if(!empty($employee_existing_passwords))
            {
                
                foreach ($employee_existing_passwords as $key => $value) {
                    if(Hash::check($request->password,$value->password))
                    {
                        $password_exists = true;
                    }
                }

                if($password_exists){

                    $message = ValidationMessage::$validation_messages["password_same"];
                    echo json_encode(["status"=>FALSE,"message"=>$message]);

                }else{

                    $employee["password"] = bcrypt($request->password);
                    $employee["ft_login"] = "N";
                    $employee["last_password_change"] = $this->datetime;
                    $employee["failed_attempts"] = 0;

                    $update_status = $employeeObject->update_my_details($employee,$request->session()->get("login_employee_id"));
                    
                    $password_array = [
                        'employee_id'=>$request->session()->get("login_employee_id"),
                        'password'=>bcrypt($request->password),
                        'password_change_at'=>$this->datetime,
                    ];
                    $password_history->add_password_history($password_array);

                    if ($update_status) {
                        $request->session()->forget("login_employee_id");
                        $message = ValidationMessage::$validation_messages["ftpassword_update_success"];
                        $request->session()->flash('success',$message);
                        echo json_encode(["status"=>TRUE,"message"=>$message,"redirect"=>$this->redirectTo]);

                    } else {

                        $message = ValidationMessage::$validation_messages["password_update_failed"];
                        echo json_encode(["status"=>FALSE,"message"=>$message]);
                    }

                }

            }else{

                $employee["password"] = bcrypt($request->password);
                $employee["ft_login"] = "N";
                $employee["last_password_change"] = $this->datetime;
                $employee["failed_attempts"] = 0;
                
                $update_status = $employeeObject->update_my_details($employee,$request->session()->get("login_employee_id"));
                
                $password_array = [
                    'employee_id'=>$request->session()->get("login_employee_id"),
                    'password'=>bcrypt($request->password),
                    'password_change_at'=>$this->datetime,
                ];
                $password_history->add_password_history($password_array);

                if ($update_status) {
                    $request->session()->forget("login_employee_id");
                    $message = ValidationMessage::$validation_messages["ftpassword_update_success"];
                    $request->session()->flash('success',$message);
                    echo json_encode(["status"=>TRUE,"message"=>$message,"redirect"=>$this->redirectTo]);

                } else {

                    $message = ValidationMessage::$validation_messages["password_update_failed"];
                    echo json_encode(["status"=>FALSE,"message"=>$message]);
                }
            }
            
        }
    }
}
