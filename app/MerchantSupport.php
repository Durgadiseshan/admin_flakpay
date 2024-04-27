<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class MerchantSupport extends Model
{
    protected $table;

    protected $jointable1;

    protected $jointable2;

    public function __construct()
    { 
        $this->table = "merchant_support";
        $this->jointable1 = "merchant";
        $this->jointable2 = "employee";
    }


    public function add_support($support_data){
        return DB::table($this->table)->insert($support_data);
    }

    public function get_support_details(){

        $where_condition = "merchant_id =:id AND created_by='merchant'";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT sup_gid,sup_category,title,IFNULL(sup_description,'') sup_description,sup_status,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_all_merchant_support()
    {
        $query = "SELECT sup_gid,sup_category,title,sup_description,sup_status,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date,$this->jointable1.merchant_gid,
        $this->jointable1.`name`, $this->jointable1.email, $this->jointable1.mobile_no,created_by FROM $this->table
        LEFT JOIN $this->jointable1 on $this->jointable1.id = $this->table.merchant_id";
        return DB::select($query);
    }
}
