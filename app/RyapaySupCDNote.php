<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySupCDNote extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){

        $this->table = "ryapay_supplier_cdnote";
        $this->jointableone = "ryapay_supplier";
    }

    public function add_supplier_note($supplier_note){
        return DB::table($this->table)->insert($supplier_note);
    }

    public function get_all_supplier_note(){

        $query = "SELECT $this->table.id,supplier.supplier_company company,supplier.supplier_name supname,
        supplier.supplier_email email,note_number,note_due,note_amount
        ,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        INNER JOIN $this->jointableone supplier ON supplier.id = $this->table.supplier_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function edit_supnote($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,supplier_id,note_date,note_number,note_payterms,note_expense_code,note_due,note_amount,note_remarks
        FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_supplier_note($supnote_id,$supplier_note){
        return DB::table($this->table)->where("id",$supnote_id)->update($supplier_note);
    }

    public static function supplier_note_options(){
        return DB::table("ryapay_supplier_cdnote")->select("id",DB::raw("IFNULL(note_number,'') AS option_value"))->get();
    }

    public static function supplier_option(){
        return DB::table("ryapay_supplier_cdnote")->select(DB::raw("IFNULL(note_number,'') AS invoice_no"))->value('invoice_no');
    }
}
