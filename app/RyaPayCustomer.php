<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyaPayCustomer extends Model
{
    protected $table;

    public $primarykey = 'id';

    protected $fillable = ['customer_name,customer_email,customer_phone,customer_gstno']; 

    public $timestamps = FALSE;

    private $empGuard;

    public function __construct(){

        $this->table_prefix = "ryapay";
        $this->table = $this->table_prefix."_customer";
        $this->empGuard = auth()->guard("employee")->user();
    }

    public function get_all_customers(){

        $query = "SELECT id,customer_gid,customer_name,customer_email,customer_phone,`status`,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
        WHERE `status`='active'";

        return DB::select($query);
    }

    public function add_customer($customer_data)
    {
        return DB::table($this->table)->insert($customer_data);
    }

    public function edit_customer_info($customer_id){


        // $where_condition = "customer.created_user=:id";
        // $apply_condition["id"] =  $this->empGuard->id;
        $where_condition ="customer.id=:customer_id";
        $apply_condition["customer_id"] = $customer_id;

        $query = "SELECT id,customer_name,customer_email,customer_phone,customer_gstno FROM $this->table customer WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_customer_info($customer_data,$customer_id)
    {
        return DB::table($this->table)->where($customer_id)->update($customer_data);
    }

    public function get_selected_customer_info($customer_id){

        // $where_condition = "customer.created_user=:id";
        // $apply_condition["id"] =  $this->empGuard->id;

        $where_condition ="customer.id=:customer_id";
        $apply_condition["customer_id"] = $customer_id;

        $query = "SELECT customer_email,customer_phone,customer_gstno FROM $this->table customer WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public static function get_cust_opts(){

        $query = "SELECT id,customer_name FROM ryapay_customer WHERE `status`='active'";

        return DB::select($query);
    }

    public function get_sales_customer_info($customer_id){

        $where_condition = "";
        if(!empty($customer_id))
        {
            $where_condition.=" AND customer.id=:customer_id";
            $apply_condition["customer_id"] = $customer_id;
        }

        $query = "SELECT id,customer_name,customer_email,customer_phone FROM $this->table customer
        WHERE `status`='active' $where_condition";

        return DB::select($query,$apply_condition);
    }

}
