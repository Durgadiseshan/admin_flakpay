<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayBankInfo extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "ryapay_bank_info";

    }

    public function add_bank_info($bank_data){
        return DB::table($this->table)->insert($bank_data);
    }

    public function get_banks_info(){

        //DB::enableQueryLog();
        //dd(DB::getQueryLog());

        $query = "SELECT id,bank_name,bank_accno,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_bank_info($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,bank_name,bank_accno FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_bank_info($id,$bank_data){
        return DB::table($this->table)->where("id",$id)->update($bank_data);
    }

    public static function get_bank_option(){
        return DB::table("ryapay_bank_info")->select("id","bank_name")->get();
    }
}
