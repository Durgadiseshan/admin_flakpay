<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class CustomerCase extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){

        $this->table = "customer_case";
        $this->jointableone = "app_option";
    }

    public function add_case($case_data){

        return DB::table($this->table)->insert($case_data);
    }

    public function get_case(){

        $where_condition = "merchant_id=:merchant_id";
        $apply_condition["merchant_id"] = Auth::user()->id;

        $query = "SELECT id,case_gid,transaction_gid,transaction_amount,customer_name,customer_reason,`status`,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,merchant_url FROM $this->table
        WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function get_all_cases(){

        $query = "SELECT id,case_gid,transaction_gid,transaction_amount,customer_name,customer_reason,`status`,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,rupayapay_caseid FROM $this->table
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_case_details($id){

        $where_condition = "merchant_id=:merchant_id AND id=:id";
        $apply_condition["merchant_id"] = Auth::user()->id;
        $apply_condition["id"] = $id;

        $query = "SELECT case_gid,case_type,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,customer_reason FROM $this->table
        WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_custcase_merchant($id){

        $where_condition = "merchant_id=:merchant_id AND merchant_caseid=:merchant_caseid";
        $apply_condition["merchant_id"] = Auth::user()->id;
        $apply_condition["merchant_caseid"] = $id;

        $query = "SELECT $this->table.id,case_gid,app_option.option_value,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,customer_reason,`status`,created_date FROM $this->table LEFT JOIN $this->jointableone app_option ON app_option.id = $this->table.case_type WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_custcase_customer($id){

        $where_condition = "customer_caseid=:customer_caseid";
        $apply_condition["customer_caseid"] = $id;

        $query = "SELECT $this->table.id,case_gid,app_option.option_value,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,customer_reason,`status`,created_date FROM $this->table LEFT JOIN $this->jointableone app_option ON app_option.id = $this->table.case_type WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_custcase_rupayapay($id){

        $where_condition = "rupayapay_caseid=:rupayapay_caseid";
        $apply_condition["rupayapay_caseid"] = $id;

        $query = "SELECT $this->table.id,case_gid,app_option.option_value,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,customer_reason,`status`,created_date FROM $this->table LEFT JOIN $this->jointableone app_option ON app_option.id = $this->table.case_type WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_all_case_details(){
        
        $query = "SELECT case_gid,case_type,transaction_gid,transaction_amount,customer_name,customer_email,customer_mobile,customer_reason FROM $this->table";

        return DB::select($query);
    }

    public function update_case($id,$update_data){
        return DB::table($this->table)->where($id)->update($update_data);
    }


}
