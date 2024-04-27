<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notification;
use Auth;

class NotiMessController extends Controller
{

    public $date_time;

    public function __construct(){

        $this->date_time = date("Y-m-d H:i:s");
    }


    public function get_merchant_appmode($user_appmode){

        if($user_appmode)
        {
            $notification = new Notification("live_notification");
        }else{
            $notification = new Notification("test_notification");
        }

        return $notification;
    }


    public function store_case_notification($merchant_id,$request)
    {
        $user_appmode = User::where('id',$merchant_id)->first()->app_mode;

        $notification = $this->get_merchant_appmode($user_appmode);

        $notification_array = array(
            "message"=>"Customer ".$request->customer_name." has lodged a case against you for the transaction ".$request->transaction_gid,
            "notify_type"=>"Case",
            "created_date"=>$this->date_time,
            "notify_to"=>$merchant_id
        );

        $notification->insert_query($notification_array);

    }

    public function get_notifications()
    {
        $user = new User();

        $notification = $this->get_merchant_appmode(Auth::user()->app_mode);

        //return $notification->select_query(["id","message","notify_type","seen","created_date"],["notify_to"=>Auth::user()->id,'category'=>'notification']);

        return $notification->get_lastest_notifications();

    }

    public function get_messages()
    {
        $user = new User();

        $notification = $this->get_merchant_appmode(Auth::user()->app_mode);

        //return $notification->select_query(["id","message","notify_type","seen","created_date"],["notify_to"=>Auth::user()->id,'category'=>'message']);

        return $notification->get_lastest_messages();
    }

    public function update_notification($merchant_id,$id)
    {
        $user = new User();
        $user_appmode = $user->select_query(["app_mode"],["id"=>$merchant_id])[0];

        $notification = $this->get_merchant_appmode($user_appmode->app_mode);

        return $notification->update_query(["seen"=>"Y"],["id"=>$id]);

    }

    public function get_table_notifications(){

        $notification = $this->get_merchant_appmode(Auth::user()->app_mode);
        return $notification->get_merchant_notifications();
    }

    public function get_table_messages()
    {
        $notification = $this->get_merchant_appmode(Auth::user()->app_mode);
        return $notification->get_merchant_messagess();
    }
    
    public function view_all_notifications()
    {
        $notification = $this->get_merchant_appmode(Auth::user()->app_mode);
        return $notification->update_merchant_notifications();
    }
    
    public function view_all_messages()
    {
        $notification = $this->get_merchant_appmode(Auth::user()->app_mode);
        return $notification->update_merchant_messages();
    }

    public function password_change_notification(){

        $user_appmode = Auth::user()->app_mode;

        $notification = $this->get_merchant_appmode($user_appmode);

        $notification_array = array(
            "message"=>"Your password has been reset successfully",
            "notify_type"=>"password-reset",
            "created_date"=>$this->date_time,
            "notify_to"=>Auth::user()->id
        );

        $notification->insert_query($notification_array);
    }

}
