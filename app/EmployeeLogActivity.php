<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class EmployeeLogActivity extends Model
{
    protected $table;

    public function __construct()
    { 
        $this->table = "employee_login_activity";
    }


    public function add_employee_log($log_data){
        return DB::table($this->table)->insert($log_data);
    }

    public function get_employee_log($from_date="",$to_date=""){
        $where_condition = " log_employee=:id";
        $apply_condition["id"] = Auth::guard("employee")->user()->id;

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

        return DB::select($query." ".$where_condition." ORDER BY $this->table.log_time DESC",$apply_condition);
        
    } 
}
