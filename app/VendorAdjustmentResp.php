<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class VendorAdjustmentResp extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){
        $this->table = "vendor_adjustment_resp";
        $this->jointableone = "merchant";
    }

    public function get_vendor_adjustments($fromdate,$todate){

        $where_condition = "DATE_FORMAT($this->table.created_date,'%Y-%m-%d')>=:fromdate AND DATE_FORMAT($this->table.created_date,'%Y-%m-%d')<=:todate AND ryapay_adjustment_status='N'";
        $apply_condition["fromdate"] = $fromdate;
        $apply_condition["todate"] = $todate;

        $query="SELECT  $this->table.id,$this->jointableone.merchant_gid,merchant_traxn_id,amount,settlement_amount,settlement_date,vendor_from,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %h:%i:%s %p') as created_date FROM 
        $this->table LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.merchant_id
        WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function get_vendor_adjustment($id){

        $where_condition = "id IN(".implode(",",$id).")";

        $query="SELECT  $this->table.id,merchant_id,merchant_traxn_id,descriminator,amount,transaction_type,settlement_amount,settlement_date,vendor_from,$this->table.created_date FROM 
        $this->table WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function update_vendor_adjustment($id,$update){

        return DB::table($this->table)->where("id",$id)->update($update);
    }
}
