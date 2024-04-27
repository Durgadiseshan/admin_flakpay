<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\GenerateLogs;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{   
    
    //Sender ID,While using Promo or Trans sender id should be 6 characters long.
    private $senderId = "PAYFLA";
	
	//Your Service Name(PROMO or TRANS)
    private $service = "Trans";
    

    //Your message to send, Add URL encoding here.
    public $message = "";

    //Multiple mobiles numbers separated by comma
    public $mobileNumber = "";

    //dlt template id of approved templates
    public $tempID = "";


    public function __construct($message ,$mobileNumber, $tempID=''){
        $this->message = $message;
        $this->mobileNumber = $mobileNumber;
        $this->tempID = $tempID;
    }
    
    
    public function sendMessage()
    {
        $APIKey = "XSLpB0kzl0eJwFcb7t5fwg";
        $channel = "Trans";
        $message = urlencode($this->message);
        $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$APIKey&senderid=PAYFLA&channel=$channel&DCS=0&flashsms=0&number=$this->mobileNumber&text=$message&route=0";
        // echo $url ;die();
        $ret = file_get_contents($url);  
        //GenerateLogs::sms_sent_log($url, $ret);
        return $ret;

    }


    
    
    
}
