<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Customer extends Model
{
    protected $table;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public function __construct($prefix=0){
        if(Auth::check()){
            if(Auth::user()->app_mode)
            {
                $this->table_prefix = "live";
            }
        }

         if($prefix){
             $this->table_prefix = "live";
            
        }
        $this->table = $this->table_prefix."_customer";
    }

    protected $fillable = ['customer_name,customer_email,customer_phone,customer_gstno'];

    public $timestamps = FALSE;

    public function get_all_customers(){

        $where_condition = "`status`='active' AND created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,customer_gid,IFNULL(customer_name,'') as customer_name,customer_email,customer_phone,`status`,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table
        WHERE";

        return DB::select($query." ".$where_condition." ORDER BY $this->table.created_date DESC",$apply_condition);
    }

    public function add_customer($customer_data)
    {
        return DB::table($this->table)->insert($customer_data);
    }

    public function edit_customer_info($customer_id){


        $where_condition = "customer.created_merchant=:id";
        $apply_condition["id"] =  Auth::user()->id;

        if(!empty($customer_id))
        {
            $where_condition.=" AND customer.id=:customer_id";
            $apply_condition["customer_id"] = $customer_id;
        }

        $query = "SELECT id,customer_name,customer_email,customer_phone,customer_gstno FROM $this->table customer WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function update_customer_info($customer_data,$customer_id)
    {
        return DB::table($this->table)->where($customer_id)->update($customer_data);
    }

    public function get_selected_customer_info($customer_id){


        $where_condition = "customer.created_merchant=:id";
        $apply_condition["id"] =  Auth::user()->id;

        if(!empty($customer_id))
        {
            $where_condition.=" AND customer.id=:customer_id";
            $apply_condition["customer_id"] = $customer_id;
        }

        $query = "SELECT customer_email,customer_phone,customer_gstno FROM $this->table customer WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_customer_by_fields($where,$merchant_id=''){

        $where_condition = "customer.created_merchant=:id AND (customer_email=:email OR customer_phone=:phone OR customer_gstno=:gstno) AND status='active'";
        if($merchant_id){
            $apply_condition["id"] =  $merchant_id;
        }else{
            $apply_condition["id"] =  Auth::user()->id;
        }
        
        $apply_condition["email"] = $where["customer_email"];
        $apply_condition["phone"] = $where["customer_phone"];
        $apply_condition["gstno"] = $where["customer_gstno"];

        $query = "SELECT count(1) customer_count FROM $this->table customer WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }


       public function merchant()
    {
        return $this->belongsTo(Merchant::class,'created_merchant','id');
    }
    
}
