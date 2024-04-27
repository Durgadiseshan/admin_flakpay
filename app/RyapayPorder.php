<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayPorder extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){
        $this->table = "ryapay_porder";
        $this->jointableone = "ryapay_supplier"; 
        $this->jointabletwo = "ryapay_porder_item";
        $this->jointablethree = "state";
    }

    public function get_all_porder(){ 
        
        $query = "SELECT $this->table.id,IFNULL(porder_no,'') AS porder_no,porder_total,porder_due,supplier_company,
        supplier_email,supplier_phone,porder_status,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table 
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.supplier_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function add_porder($porder_data){
        return DB::table($this->table)->insertGetId($porder_data);
    }


    public function edit_porder($id){ 
        
        $query = "SELECT $this->table.id,IFNULL(porder_no,'') AS porder_no,porder_total,porder_due,supplier_id,supplier_company,
        supplier_name,supplier_email,supplier_phone,CONCAT_WS(' ',supplier_address,supplier_city,supplier_pincode,$this->jointablethree.state_name) as supplier_address,porder_bill_street,porder_bill_city,porder_bill_state,porder_total,porder_subtotal,porder_tax,IFNULL(porder_terms_cond,'') as porder_terms_cond,IFNULL(porder_description,'') as porder_description,
        porder_bill_country,porder_ship_street,porder_ship_city,porder_date,porder_ship_state,porder_ship_country,item_id,item_amount,item_quantity,item_total,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.supplier_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.porder_id = $this->table.id
        LEFT JOIN $this->jointablethree ON $this->jointablethree.id = $this->jointableone.supplier_state

        WHERE $this->table.id='$id'";

        return DB::select($query);
    }

    public function update_porder($porder_id,$porder_data){
        return DB::table($this->table)->where("id",$porder_id)->update($porder_data);
    }
    
    public static function porder_options(){
        return DB::table("ryapay_porder")->select("id",DB::raw("IFNULL(porder_no,'') AS porder_no"))->get();
    }
}
