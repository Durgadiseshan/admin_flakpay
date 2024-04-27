<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayaCustCDNote extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){

        $this->table = "ryapay_customer_cdnote";
        $this->jointableone = "ryapay_customer";
    }

    public function add_customer_note($customer_note){
        return DB::table($this->table)->insert($customer_note);
    }

    public function get_all_customer_note(){

        $query = "SELECT $this->table.id,customer.customer_name,
        customer.customer_email,note_number,note_due,note_amount
        ,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        INNER JOIN $this->jointableone customer ON customer.id = $this->table.customer_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function edit_custnote($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,customer_id,note_date,note_number,note_payterms,note_expense_code,note_due,note_amount,note_remarks
        FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_customer_note($custnote_id,$customer_note){
        return DB::table($this->table)->where("id",$custnote_id)->update($customer_note);
    }

    public static function custnote_options(){
        return DB::table("ryapay_customer_cdnote")->select("id",DB::raw("IFNULL(note_number,'') AS option_value"))->get();
    }
    public static function custnote_option($id){
        return DB::table("ryapay_customer_cdnote")->where("id",$id)->select(DB::raw("IFNULL(note_number,'')"))->value('note_number');
    }
}
