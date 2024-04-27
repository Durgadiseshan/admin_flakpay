<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class VendorBankInfo extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "vendor_bank_info";
    }

    public function get_vendor_bank_detail($category_id,$vendor_id){

        $where_condition = "FIND_IN_SET(".$category_id.",category_id) AND vendor_id=:vendor_id";
        $apply_condition["vendor_id"] = $vendor_id;

        $query = "SELECT vendor_id, vendor_name,vendor_adjustment_url,vendor_secure_key,vendor_product,vendor_mode,category_id FROM 
        $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }
}

