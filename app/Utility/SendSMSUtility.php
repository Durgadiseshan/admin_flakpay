<?php

namespace App\Utility;
use Illuminate\Support\Facades\Http;


class SendSMSUtility
{

	 public static function sendSMS($to, $text, $template_id)
    { 

    	 $APIKey = "XSLpB0kzl0eJwFcb7t5fwg";
        $channel = "Trans";
        $message = urlencode($text);
        $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$APIKey&senderid=PAYFLA&channel=$channel&DCS=0&flashsms=0&number=$to&text=$message&route=0";
       
           $ch = curl_init($url);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $curl_scraped_page = curl_exec($ch);
           curl_close($ch);
            //GenerateLogs::sms_sent_log($url, $ret);
			return true;
    }

}