<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class MerchantLogActivity extends Model
{
    protected $table;

    public function __construct()
    { 
        $this->table = "merchant_login_activity";
    }


    public function add_merchant_log($log_data){
        return DB::table($this->table)->insert($log_data);
    }

    public function get_merchant_log($from_date="",$to_date=""){
        $where_condition = " log_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        if(!empty($from_date))
        {
            $where_condition .=  ' AND DATE_FORMAT(log_time, "%Y-%m-%d") >=:from_date';
            $apply_condition['from_date'] = $from_date;
        }
        if(!empty($to_date))
        {
            $where_condition .=  ' AND DATE_FORMAT(log_time, "%Y-%m-%d") <= :to_date';
            $apply_condition['to_date'] = $to_date;
        }



        $query = "SELECT log_ipaddress,log_device,log_os,log_browser,DATE_FORMAT(log_time,'%d-%m-%Y %h:%i:%s %p') as log_time FROM  $this->table WHERE";

        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition." ORDER BY $this->table.log_time DESC",$apply_condition);
       // dd(DB::getQueryLog());
        
    }
}
