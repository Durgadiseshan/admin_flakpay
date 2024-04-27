<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class RyapayAdjustment extends Model
{
    protected $table;

    protected $jointableone;

    public function __construct(){
        $this->table = "ryapay_adjustment";
        $this->jointableone = "merchant";
    }

    public function add_adjustment($response){
        return DB::table($this->table)->insert($response);
    }

    public function get_adjustment(){

        $query="SELECT id,merchant_id,merchant_traxn_id,traxn_amount,bankname,merchant_traxn_method,adjustment_charges_per,adjustment_charges,adjustment_gst_per,adjustment_gst,total_charge,adjustment_amount,
        DATE_FORMAT(adjustment_date,'%Y-%m-%d') as adjustment_date,DATE_FORMAT(created_date,'%Y-%m-%d %H:%i:%s %p') as created_date,adjustment_status FROM $this->table ORDER BY created_date DESC";

        return DB::select($query);
    }


    public function get_adjustment_row($id){

        $query="SELECT id,merchant_id,merchant_traxn_id,traxn_amount,bankname,merchant_traxn_method,adjustment_charges_per,adjustment_charges,adjustment_gst_per,adjustment_gst,total_charge,adjustment_amount
        FROM $this->table WHERE id=:row_id AND adjustment_status='save'";

        $apply_condition["row_id"] = $id;

        DB::table($this->table)->where(["id"=>$id])->update(["adjustment_status"=>"processed"]);

        return DB::select($query,$apply_condition);
    }


    public function get_all_adjustments($filter){

        $where_condition = "";
        $apply_condition = [];

        if(!empty($filter["transaction_date"])){
            $where_condition .=" AND DATE_FORMAT(traxn_date,'%Y-%m-%d')=:d";
            $apply_condition["d"] = $filter["transaction_date"];
        }

        if(!empty($filter["merchant_id"])){
            $where_condition .=" AND merchant_id=:mid";
            $apply_condition["mid"] = $filter["merchant_id"];
        }

        if(!empty($filter["transaction_gid"])){
            $where_condition .=" AND merchant_traxn_id=:tid";
            $apply_condition["tid"] = $filter["transaction_gid"];
        }


        $query="SELECT SUM(traxn_amount) as transaction_amount,merchant_traxn_method as transaction_mode
        FROM $this->table WHERE adjustment_status='NODATA' $where_condition GROUP BY merchant_traxn_method";

        return DB::select($query,$apply_condition);
    }
}
