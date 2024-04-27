<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayContEntry extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){
        $this->table = "ryapay_contra_entry";
        $this->jointableone = "ryapay_bank_info";
        $this->jointabletwo = "app_option";
    }

    public function add_contra_entry($contra_data){
        return DB::table($this->table)->insert($contra_data);
    }

    public function get_contras_info(){

        $query = "SELECT $this->table.id,contra_no,contra_date,dbank.bank_name as dbank_name,cbank.bank_name cbank_name,$this->jointabletwo.option_value,payment_amount,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table 
        LEFT JOIN $this->jointableone dbank ON dbank.id = $this->table.debit_bank_id
        LEFT JOIN $this->jointableone cbank ON cbank.id = $this->table.credit_bank_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.payment_mode
        ORDER BY $this->table.created_date DESC";
        //DB::enableQueryLog();
        //dd(DB::getQueryLog());
        return DB::select($query);
    }

    public function get_contra_info($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,contra_no,contra_date,debit_bank_id,credit_bank_id,payment_mode,payment_amount,remarks FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_contra_info($id,$contra_data){
        return DB::table($this->table)->where($id)->update($contra_data);
    }

    public static function get_bank_option(){
        return DB::table("ryapay_bank_info")->select("id","bank_name")->get();
    }
}
