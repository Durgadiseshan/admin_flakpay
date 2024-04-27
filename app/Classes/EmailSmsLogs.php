<?php

namespace App\Classes;

use Illuminate\Http\Request;
use App\RyapayEmailLog;
use App\RyapaySmsLog;

class EmailSmsLogs
{
    protected $date_time;

    public function __construct(){
        $this->date_time = date("Y-m-d H:i:s");
    }

    public function email_logs($app="",$module="",$email_to="",$email_cc="",$email_bcc="",$email_status=""){
        $email_log = [
            "app"=>$app,
            "module"=>$module,
            "email_to"=>$email_to,
            "email_cc"=>$email_cc,
            "email_bcc"=>$email_bcc,
            "email_status"=>$email_status,
            "created_date"=>$this->date_time
        ];

        $emailLogObject = new RyapayEmailLog();
        $emailLogObject->insert_email_log($email_log);
    }

    public function sms_logs($app="",$module="",$sms_to="",$sms_status=""){

        $sms_log = [
            "app"=>$app,
            "module"=>$module,
            "sms_to"=>$sms_to,
            "sms_cc"=>$sms_cc,
            "sms_bcc"=>$sms_bcc,
            "sms_status"=>$sms_status,
            "created_date"=>$this->date_time
        ];

        $smsLogObject = new RyapaySmsLog();
        $smsLogObject->insert_sms_log($sms_log);
    }
}

?>