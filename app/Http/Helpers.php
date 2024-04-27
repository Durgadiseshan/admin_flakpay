<?php 
use App\Utility\SendSMSUtility;

if (!function_exists('get_auth_user_id')) {
    function get_auth_user_id()
    {
        return 1233;;
    }
}



if (!function_exists('sendSMS')) {
    function sendSMS($to, $text, $template_id)
    {
        return SendSMSUtility::sendSMS($to, $text, $template_id);
    }
}
?>