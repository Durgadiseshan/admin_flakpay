<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySorder extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){
        $this->table = "ryapay_sorder";
        $this->jointableone = "ryapay_customer"; 
        $this->jointabletwo = "ryapay_sorder_item";
        $this->jointablethree = "state";
    }

    public function get_all_sorder(){ 
        
        $query = "SELECT $this->table.id,IFNULL(sorder_no,'') AS sorder_no,sorder_total,sorder_due,
        customer_email,customer_phone,sorder_status,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table 
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.customer_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function add_sorder($sorder_data){
        return DB::table($this->table)->insertGetId($sorder_data);
    }


    public function edit_sorder($id){ 
        
        $where_condition = "$this->table.id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,IFNULL(sorder_no,'') AS sorder_no,sorder_total,sorder_due,customer_id,
        customer_name,customer_email,customer_phone,sorder_bill_street,sorder_bill_city,sorder_bill_state,sorder_total,sorder_subtotal,sorder_tax,IFNULL(sorder_terms_cond,'') as sorder_terms_cond,IFNULL(sorder_description,'') as sorder_description,
        sorder_bill_country,sorder_ship_street,sorder_ship_city,sorder_date,sorder_ship_state,sorder_ship_country,item_id,item_amount,item_quantity,item_total,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.customer_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.sorder_id = $this->table.id
        WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_sorder($sorder_id,$sorder_data){
        return DB::table($this->table)->where("id",$sorder_id)->update($sorder_data);
    }
    
    public static function sorder_options(){
        return DB::table("ryapay_sorder")->select("id",DB::raw("IFNULL(sorder_no,'') AS sorder_no"))->get();
    }
}
