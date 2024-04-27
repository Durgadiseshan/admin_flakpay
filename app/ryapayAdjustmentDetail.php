<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ryapayAdjustmentDetail extends Model
{
    protected $table;
    protected $jointablone;

    public function __construct(){

        $this->table = "ryapay_adjustment_detail";
        $this->jointablone = "merchant";
    }

    public function add_adjustment_detail($adjustment_detail){

        return DB::table($this->table)->insert($adjustment_detail);
    }

    public function get_adjustment_detail($fromdate,$todate){

        $where_condition = "DATE_FORMAT($this->table.created_date,'%Y-%m-%d')>=:fromdate AND DATE_FORMAT($this->table.created_date,'%Y-%m-%d')<=:todate";
        $apply_condition["fromdate"] = $fromdate;
        $apply_condition["todate"] = $todate;

        $query = "SELECT $this->jointablone.merchant_gid,merchant_transaction_id,transaction_amount, charges_per, charges_on_transaction,adjustment_amount, gst_per, gst_on_transaction, total_amt_charged,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %h:%i:%s %p') as created_date FROM $this->table 
        LEFT JOIN $this->jointablone ON $this->jointablone.id = $this->table.merchant_id WHERE $where_condition ORDER BY $this->table.created_date DESC";

        //DB::enableQueryLog();
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
    }
}
