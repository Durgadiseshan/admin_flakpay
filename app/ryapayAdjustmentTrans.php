<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ryapayAdjustmentTrans extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "ryapay_adjustment_trans";
    }

    public function add_adjustment_transaction($adjustment_data){

        return DB::table($this->table)->insertGetId($adjustment_data);
    }

    public static function get_ryapay_transactions()
   {    
        return DB::table("ryapay_adjustment_trans")->select("id","transaction_gid")->get();
   }
}
