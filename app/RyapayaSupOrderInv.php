<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayaSupOrderInv extends Model
{

    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;

    public function __construct(){

        $this->table = "ryapay_suporder_invoice";
        $this->jointableone = "ryapay_supplier";
        $this->jointabletwo = "ryapay_porder";
        $this->jointablethree = "ryapay_suporder_item";
    }

    public function add_suporder_invoice($suporder_invoice){
        return DB::table($this->table)->insertGetId($suporder_invoice);
    }


    public function get_all_suporder(){

        $query = "SELECT $this->table.id,supplier.supplier_company company,supplier.supplier_name supname,
        supplier.supplier_email email,porder.porder_no,suporder_due,suporder_total,suporder_status
        ,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        INNER JOIN $this->jointableone supplier ON supplier.id = $this->table.supplier_id
        INNER JOIN $this->jointabletwo porder ON porder.id = $this->table.porder_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }


    public function edit_suporder($id){

        $where_condition = " $this->table.id=:id";
        $apply_condition["id"] = $id;


        $query = "SELECT $this->table.id,supplier_id,IFNULL(suporder_due,'') as suporder_due,
        IFNULL(suporder_payterms,'') as suporder_payterms,IFNULL(suporder_invdate,'') as suporder_invdate,
        porder_id,IFNULL(suporder_invno,'') as suporder_invno,suporder_subtotal,suporder_tax,
        suporder_total,suporder_remarks,item_id,item_amount,item_quantity,item_total
        FROM $this->table
        LEFT JOIN $this->jointablethree item ON item.suporder_id = $this->table.id
        WHERE $where_condition";
        
        return DB::select($query,$apply_condition);
    }
    
    public function update_supporder($suporder_id,$suporder_data){
        return DB::table($this->table)->where("id",$suporder_id)->update($suporder_data);
    }

    public static function suporder_invoice_options(){
        return DB::table("ryapay_suporder_invoice")->select("id",DB::raw("IFNULL(suporder_invno,'') AS option_value"))->get();
    }

    public static function suporder_option($id){
        return DB::table("ryapay_suporder_invoice")->where("id",$id)->select(DB::raw("IFNULL(suporder_invno,'') AS inv_no"))->value('inv_no');
    }

}
