<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SmsController;
use App\Mail\SendMail;
use App\User;
use App\Custom;
use App\MerchantBusiness;
use DateTime;

class PaylinksWithOutExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rpaylinkswithoutexpiry:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily rpaylinks emails and sms to all the merchant customers which are not having any expiry date';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $todaydate;

    public function __construct()
    {
        parent::__construct();
        $this->todaydate = date('Y-m-d');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $merchant = new User();
        $custom = new Custom();
        $merchants =$merchant->get_active_merchants();

        foreach ($merchants as $row => $merchantrow) {
            
            if($merchantrow->is_reminders_enabled == "Y")
            {
                if($merchantrow->app_mode == "1")
                {
                    $paylinks_list = $custom->get_all_live_paylinks_without_expiry($merchantrow->id);

                    $reminders = $custom->get_all_live_reminders_without_expiry($merchantrow->id);

                    if(!empty($paylinks_list))
                    {
                        foreach ($paylinks_list as $row => $paylink) {

                            if(!empty($reminders))
                            {
                                foreach ($reminders as $row => $reminder) {
                                
                                    $datetime1 = new DateTime($paylink->created_date);
                                    $datetime2 = new DateTime($this->todaydate);
                                    $interval = $datetime1->diff($datetime2);
                                    $days = $interval->format('%a'); //now do whatever you like with $days
    
                                    if($days == $reminder->reminder_days){

                                        if($reminder->send_email == "Y")
                                        {
                                            $business_name = MerchantBusiness::get_merchant_business_name($merchantrow->id);
                                            $data = array(
                                                "from" => env("MAIL_USERNAME", ""),
                                                "subject" => "Requesting payment of INR ".number_format($paylink->paylink_amount,2)." From ".ucfirst($business_name),
                                                "view" => "/maillayouts/rpaylinkmail",
                                                "htmldata" => array(
                                                    "paylink_for"=>$paylink->paylink_for,
                                                    "amount"=>$paylink->paylink_amount,
                                                    "email"=>$paylink->paylink_customer_email,
                                                    "paylink_url"=>$paylink->paylink_link,
                                                    "business_name"=>$business_name,
                                                    "paylink_id"=>$paylink->paylink_payid
                                                ),
                                            );
                                            Mail::to($paylink->paylink_customer_email)->send(new SendMail($data));
                                        }

                                        if($reminder->send_sms == "Y")
                                        {   
                                            $message = ucfirst($merchantrow->name)." has requesting payment for INR ".number_format($paylink->paylink_amount,2)." You can pay through this link ".$paylink->paylink_link." -NeoFin";
            
                                            $sms = new SmsController($message,$paylink->paylink_customer_mobile,"1307164802052353612");
                                    
                                            $sms->sendMessage();
                                        }
                                        //$this->info('send mail successfully to this email id '.$paylink->paylink_customer_email);

                                    }else{

                                        //$this->info('No Mail Sent');
                                    }
    
                                }
                            }else{
                                //$this->info('No Live reminders exits');
                            }
                        }
                    }else{

                        //$this->info('No Live paylinks exits');
                    }

                }else{

                    $paylinks_list = $custom->get_all_test_paylinks_without_expiry($merchantrow->id);

                    $reminders = $custom->get_all_test_reminders_without_expiry($merchantrow->id);

                    if(!empty($paylinks_list))
                    {
                        foreach ($paylinks_list as $row => $paylink) {

                            if(!empty($reminders))
                            {
                                foreach ($reminders as $row => $reminder) {
                                
                                    $datetime1 = new DateTime($paylink->created_date);
                                    $datetime2 = new DateTime($this->todaydate);
                                    $interval = $datetime1->diff($datetime2);
                                    $days = $interval->format('%a'); //now do whatever you like with $days

                                    //$this->info('days '.$days.' reminder_days '.$reminder->reminder_days);
                                    //$this->info('datetime1 '.$paylink->created_date.'- datetime2 '.$this->todaydate." : ".$days);
                                    if($days == $reminder->reminder_days){

                                        if($reminder->send_email == "Y")
                                        {
                                            $business_name = MerchantBusiness::get_merchant_business_name($merchantrow->id);
                                            $data = array(
                                                "from" => env("MAIL_USERNAME", ""),
                                                "subject" => "Requesting payment of INR ".number_format($paylink->paylink_amount,2)." From ".ucfirst($business_name),
                                                "view" => "/maillayouts/rpaylinkmail",
                                                "htmldata" => array(
                                                    "paylink_for"=>$paylink->paylink_for,
                                                    "amount"=>$paylink->paylink_amount,
                                                    "email"=>$paylink->paylink_customer_email,
                                                    "paylink_url"=>$paylink->paylink_link,
                                                    "business_name"=>$business_name,
                                                    "paylink_id"=>$paylink->paylink_payid
                                                ),
                                            );
                                            Mail::to($paylink->paylink_customer_email)->send(new SendMail($data));
                                        }

                                        if($reminder->send_sms == "Y")
                                        {
                                            $message = ucfirst($merchantrow->name)." has requesting payment for INR ".number_format($paylink->paylink_amount,2)." You can pay through this link ".$paylink->paylink_link." -NeoFin";
            
                                            $sms = new SmsController($message,$paylink->paylink_customer_mobile,"1307164802052353612");
                                    
                                            $sms->sendMessage();
                                        }
                                        
                                        //$this->info('send mail successfully to this email id '.$paylink->paylink_customer_email);

                                    }else{

                                        //$this->info('merchant '.$merchantrow->id.' with paylink '.$paylink->id.' Test Mail not Sent');
                                    }
    
                                }
                            }else{
                                //$this->info('No Test reminders exits');
                            }
                        }
                    }else{

                        //$this->info('No Test paylinks exits');
                    }
                }
            }
        }
    }
}
