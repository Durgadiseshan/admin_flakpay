<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayAdjustmentCharge extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){
        $this->table = "ryapay_adjustment_charge";
        $this->jointableone = "merchant";
        $this->jointabletwo = "business_type";
    }

    public function add_adjustment_charge($charge_details){
        return DB::table($this->table)->insert($charge_details);
    }

    public function get_adjustment_charges(){

        $query = "SELECT $this->table.id,$this->table.merchant_id,$this->jointableone.merchant_gid, $this->jointableone.name,
        $this->jointabletwo.type_name,
        DATE_FORMAT($this->table.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->table 
        INNER JOIN $this->jointableone ON $this->jointableone.id = $this->table.merchant_id
        INNER JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.business_type_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function adjustment_charge_exist($merchant_id){

        $where_condition="merchant_id=:merchant_id";
        $apply_condition["merchant_id"] = $merchant_id;

        $query="SELECT COUNT(1) as charge_exist FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_adjustment_charge_by_card($merchant_id,$column){
        
        return DB::table($this->table)->where("merchant_id",$merchant_id)->value($column);
    }
}
