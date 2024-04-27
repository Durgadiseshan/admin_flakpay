<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CouponOption extends Model
{

    protected $table;

    public function __construct()
    {
        $this->table = "coupon_option";
    }


    public function get_types_subtypes(){

        $query = "SELECT id,coupon_option,option_type FROM $this->table";
        return DB::select($query);
    }
}
