<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MerchantChargeDetail extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){
        $this->table = "merchant_charge_detail";
        $this->jointableone = "merchant";
        $this->jointabletwo = "business_type";
    }

    public function add_charge($charge_details){
        return DB::table($this->table)->insert($charge_details);
    }

    public function get_charges(){

        $query = "SELECT $this->table.id,$this->table.merchant_id,$this->jointableone.merchant_gid, $this->jointableone.name,
        $this->jointabletwo.type_name,
        DATE_FORMAT($this->table.created_date,'%Y-%m-%d %h:%i:%s %p') as created_date FROM $this->table 
        INNER JOIN $this->jointableone ON $this->jointableone.id = $this->table.merchant_id
        INNER JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.business_type_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_merchant_charge($id){

        $where_condition = "$this->table.id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id, merchant_id, dc_visa, dc_master, dc_rupay, cc_visa, cc_master, cc_rupay, amex, upi,wallet,dap,qrcode, net_sbi, net_hdfc, net_axis, net_icici, net_yes_kotak, net_others,business_type_id,
        $this->jointableone.charge_enabled FROM $this->table INNER JOIN $this->jointableone ON $this->jointableone.id = $this->table.merchant_id  WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_charges($id,$charge_details){

        return DB::table($this->table)->where($id)->update($charge_details);
    }

    public function get_adjustment_charge_by_card($merchant_id,$column){
        
        return DB::table($this->table)->where("merchant_id",$merchant_id)->value($column);
    }
}
