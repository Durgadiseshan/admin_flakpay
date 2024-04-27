<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySupExpInv extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;

    public function __construct(){

        $this->table = "ryapay_supexp_invoice";
        $this->jointableone = "ryapay_supplier";
        $this->jointabletwo = "ryapay_porder";
        $this->jointablethree = "ryapay_supexp_item";
    }

    public function add_supexp_invoice($supexp_invoice){
        return DB::table($this->table)->insertGetId($supexp_invoice);
    }


    public function get_all_supexp(){

        $query = "SELECT $this->table.id,supplier.supplier_company company,supplier.supplier_name supname,
        supplier.supplier_email email,supexp_invno,supexp_due,supexp_total,supexp_status
        ,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        INNER JOIN $this->jointableone supplier ON supplier.id = $this->table.supplier_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }


    public function edit_supexp($id){

        $where_condition = " $this->table.id=:id";
        $apply_condition["id"] = $id;


        $query = "SELECT $this->table.id,supplier_id,IFNULL(supexp_due,'') as supexp_due,
        IFNULL(supexp_payterms,'') as supexp_payterms,IFNULL(supexp_invdate,'') as supexp_invdate,
        IFNULL(supexp_invno,'') as supexp_invno,supexp_subtotal,supexp_tax,
        supexp_total,supexp_remarks,expense_code,item_id,item_amount,item_quantity,item_total
        FROM $this->table
        LEFT JOIN $this->jointablethree item ON item.supexp_id = $this->table.id
        WHERE $where_condition";
        
        return DB::select($query,$apply_condition);
    }
    
    public function update_supexp($supexp_id,$supexp_data){ 
        return DB::table($this->table)->where("id",$supexp_id)->update($supexp_data);
    }

    public static function supexp_options(){
        return DB::table("ryapay_supexp_invoice")->select("id",DB::raw("IFNULL(supexp_invno,'') AS option_value"))->get();
    }

    public static function supexp_option($id){
        return DB::table("ryapay_supexp_invoice")->where("id",$id)->select(DB::raw("IFNULL(supexp_invno,'') AS invoice_no"))->value('invoice_no');
    }

    
}
