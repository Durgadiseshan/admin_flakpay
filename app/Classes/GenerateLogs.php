<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Classes\Detect;

class GenerateLogs{

    public static function login_failed(){

        $log = ['message' => 'Login attempts from this ip address '.Detect::ipAddress(). ' failed'];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('LoginFailed');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/invalidlogins.log')),Logger::INFO);
        $invalidLog->info('InvalidLogin',$log);
    }

    public static function employee_login_failed($employee_name){

        $log = ['message' => 'This '.$employee_name.' has made a Login attempt from this ip address '.Detect::ipAddress().' but it failed'];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('LoginFailed');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/invalidlogins.log')),Logger::INFO);
        $invalidLog->info('InvalidLogin',$log);
    }

    public static function login_success($employee_name){

        $log = ['message' => 'This '.$employee_name.' has logged in successfully from this '.Detect::ipAddress()];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('LoginSuccess');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/validlogins.log')),Logger::INFO);
        $invalidLog->info('ValidLogin',$log);
    }

    public static function logout($employee_name){

        $log = ['message' => $employee_name.' has logged out successfully from this '.Detect::ipAddress()];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('LogoutSuccess');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/validlogouts.log')),Logger::INFO);
        $invalidLog->info('ValidLogout',$log);
    }


    public static function new_employee_created($employee_name){

        $log = ['message' => $employee_name.' has created successfully from this '.Detect::ipAddress()];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('CreateEmployeeSuccess');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/newemployee.log')),Logger::INFO);
        $invalidLog->info('NewEmployee',$log);
    }

    public static function password_reset($name,$module){
        $log = ['message' => 'Module '.$module.' Merchant '.$name.' has reset his password having ip address '.Detect::ipAddress().',from device '.Detect::systemInfo()["device"].',using operating system '.Detect::systemInfo()["os"].',browser '.Detect::browser()];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('PassResetSuccess');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/passreset.log')),Logger::INFO);
        $invalidLog->info('PasswordReset',$log);
    }

    public static function atom_adjustment_url($url,$postdata){

        $log = ['message' => 'An adjustment request sent to atom '.$url.$postdata.' having ip address '.Detect::ipAddress().',from device '.Detect::systemInfo()["device"].',using operating system '.Detect::systemInfo()["os"].',browser '.Detect::browser()];
        //first parameter passed to Monolog\Logger sets the logging channel name
        $invalidLog = new Logger('AtomAdjustmentRequest');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/atomadjustmentrequest.log')),Logger::INFO);
        $invalidLog->info('AtomAdjustment',$log);
    }
    /*public static function sms_sent_log($url, $output){
        $log = ['SMS Link:-'.$url.' Response:-'.$output];
        $invalidLog = new Logger('SMSResponse');
        $invalidLog->pushHandler(new StreamHandler(storage_path('logs/smssent.log')),Logger::INFO);
        $invalidLog->info('SMSResponse',$output);
    }*/
}

?>