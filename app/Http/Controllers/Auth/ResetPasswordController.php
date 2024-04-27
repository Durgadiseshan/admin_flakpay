<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Classes\GenerateLogs;
use App\Mail\SendMail;
use App\Notification;
use App\Custom;
use DB;

class ResetPasswordController extends Controller
{
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
    protected $redirectTo = '/login';

    protected $datetime = "";

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

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        $email = $this->getResetEmail($token);
        
        if(!empty($email)){
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $email,'loadcss'=>"reset-password"]
            );
        }else{
            return redirect('/');
        }
        
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required','string','min:8','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'], 
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return ['password.regex'=>'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)'];
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {

        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(

            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function getResetEmail($token){
        $customObject = new Custom("password_resets");

        $table_data = $customObject->get_all_resetpswd_records();

        foreach ($table_data as $index => $object) {
            if(Hash::check($token, $object->token)){
                $email = $object->email;
            }
        }
    
        return $email;
    }

    protected function resetPassword($user, $password)
    {

        $app_mode = $user->app_mode;

        if($app_mode)
        {
            $notification =  new Notification("live_notification");
        }else{
            $notification =  new Notification("test_notification");
        }

        GenerateLogs::password_reset($user->name,"Forget password");

        $notify_password_change = [
            "message"=>"Your password has been reset successfully",
            "notify_type"=>"password-reset",
            "created_date"=>$this->datetime,
            "notify_to"=>$user->id
        ];

        $notification->insert_query($notify_password_change);

        $data = array(
            "from" => env("MAIL_USERNAME", ""),
            "subject" => "Password Reset Successfull",
            "view" => "/maillayouts/passresetsuccess",
            "htmldata" => array(
                "name" => $user->name,
            ),
        );
        Mail::to($user->email)->send(new SendMail($data));

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        session()->flash('password-reset-message', 'Your password has been reset successfully! Please Login');
    }

}
