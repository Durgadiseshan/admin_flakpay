<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyaPaySale extends Model
{
    protected $table;
    protected $jointable1;
    protected $jointable2;
    protected $jointable3;

    private $empGuard;

    public function __construct()
    {
        $this->table = "ryapay_sale";
        $this->jointable1 = "ryapay_service";
        $this->jointable2 = "business_category";
        $this->jointable3 = "state";
        $this->empGuard = auth()->guard('employee')->user();
    }

    public function get_lead_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='lead' AND sales_from='inside'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->table.remark,$this->jointable2.category_name,company_address, city, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,sale_status, 
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id AND $this->jointable1.status='active'
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_field_lead_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='lead' AND sales_from='field'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->jointable2.category_name,DATE_FORMAT(visited,'%d-%m-%Y') visited, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,merchant_status,sale_status,
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }


    public function get_daily_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='daily' AND sales_from='inside'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->jointable2.category_name,company_address, city, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,sale_status, 
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_field_daily_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='daily' AND sales_from='field'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->jointable2.category_name,DATE_FORMAT(visited,'%d-%m-%Y') visited, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,merchant_status,sale_status,
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='sales' AND sales_from='inside'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->jointable2.category_name,company_address, city, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,sale_status, 
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_field_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='sales' AND sales_from='field'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->jointable2.category_name,DATE_FORMAT(visited,'%d-%m-%Y') visited, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,merchant_status,sale_status,
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    
    public function get_a_lead_sale($id){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='lead' AND id=:id";
        $apply_condition["user_id"] = $this->empGuard->id;
        $apply_condition["id"] = $id;

        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email,`service_id`, company_name, 
                  business_category,company_address, city, `state`,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,sale_status, 
                  remark FROM $this->table
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    
    public function get_a_daily_sale($id){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='daily' AND id=:id";
        $apply_condition["user_id"] = $this->empGuard->id;
        $apply_condition["id"] = $id;

        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email,`service_id`, company_name, 
                  business_category,company_address, city, `state`,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,sale_status, 
                  remark FROM $this->table
                  WHERE";
        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition,$apply_condition);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function get_a_sale($id){

        $where_condition = "$this->table.created_user=:user_id AND sale_status='sales' AND id=:id";
        $apply_condition["user_id"] = $this->empGuard->id;
        $apply_condition["id"] = $id;

        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email,`service_id`, company_name, 
                  business_category,company_address, city, `state`,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,sale_status, 
                  remark FROM $this->table
                  WHERE";

        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition,$apply_condition);
        //dd(DB::getQueryLog());
    }

    public function get_all_field_sales(){

        $where_condition = "$this->table.created_user=:user_id AND sales_from='field' AND sale_status='sale'";
        $apply_condition["user_id"] = $this->empGuard->id;


        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email, $this->jointable1.`service_name`, company_name, 
                  $this->jointable2.category_name,DATE_FORMAT(visited,'%d-%m-%Y') visited, $this->jointable3.state_name,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,merchant_status,sale_status,
                  DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
                  LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.service_id
                  LEFT JOIN $this->jointable2 on $this->jointable2.id = $this->table.business_category
                  LEFT JOIN $this->jointable3 on $this->jointable3.id = $this->table.`state`
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_a_field_sales($id)
    {
        $where_condition = "$this->table.created_user=:user_id AND sales_from='field' AND id=:id";
        $apply_condition["user_id"] = $this->empGuard->id;
        $apply_condition["id"] = $id;

        $query = "SELECT  $this->table.id,merchant_name, merchant_mobile, merchant_email,service_id
                  ,company_name, business_category,company_address,city,`state`,sale_status,
                  DATE_FORMAT(visited,'%d-%m-%Y') visited,
                  DATE_FORMAT(next_call,'%d-%m-%Y') next_call,merchant_status,remark
                  FROM $this->table
                  WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function add_sale($salesdata)
    {
        return DB::table($this->table)->insert($salesdata);
    }

    public function update_sale($id,$salesdata)
    {
        return DB::table($this->table)->where($id)->update($salesdata);
    }
}
