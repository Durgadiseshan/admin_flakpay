<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayCustOrderInv extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;

    public function __construct(){

        $this->table = "ryapay_custorder_invoice";
        $this->jointableone = "ryapay_customer";
        $this->jointabletwo = "ryapay_sorder";
        $this->jointablethree = "ryapay_custorder_item";
    }

    public function add_custorder_invoice($custorder_invoice){
        return DB::table($this->table)->insertGetId($custorder_invoice);
    }


    public function get_all_custorder(){

        $query = "SELECT $this->table.id,customer.customer_name,
        customer.customer_email,sorder.sorder_no,custorder_due,custorder_total,custorder_status
        ,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        INNER JOIN $this->jointableone customer ON customer.id = $this->table.customer_id
        INNER JOIN $this->jointabletwo sorder ON sorder.id = $this->table.sorder_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }


    public function edit_custorder($id){

        $where_condition = " $this->table.id=:id";
        $apply_condition["id"] = $id;


        $query = "SELECT $this->table.id,customer_id,IFNULL(custorder_due,'') as custorder_due,
        IFNULL(custorder_payterms,'') as custorder_payterms,IFNULL(custorder_invdate,'') as custorder_invdate,
        sorder_id,IFNULL(custorder_invno,'') as custorder_invno,custorder_subtotal,custorder_tax,
        custorder_total,custorder_remarks,item_id,item_amount,item_quantity,item_total
        FROM $this->table
        LEFT JOIN $this->jointablethree item ON item.custorder_id = $this->table.id
        WHERE $where_condition";
        
        return DB::select($query,$apply_condition);
    }
    
    public function update_custorder($custorder_id,$custorder_data){
        return DB::table($this->table)->where("id",$custorder_id)->update($custorder_data);
    }

    public static function custorder_options(){
        return DB::table("ryapay_custorder_invoice")->select("id",DB::raw("IFNULL(custorder_invno,'') AS option_value"))->get();
    }

    public static function custorder_option($id){
        return DB::table("ryapay_custorder_invoice")->where("id",$id)->select(DB::raw("IFNULL(custorder_invno,'')"))->value('custorder_invno');
    }
}
