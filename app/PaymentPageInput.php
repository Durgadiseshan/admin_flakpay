<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PaymentPageInput extends Model 
{
    protected $table;
    protected $table_prefix = "test";

    public function __construct(){

        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table = $this->table_prefix."_payment_page_input";
    }

    public function add_page_inputs($page_inputs){
        return DB::table($this->table)->insert($page_inputs);
    }

    public function get_page_inputs_count($id){

        $where_condition = "payment_page_id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT count(1) as no_of_inputs FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function remove_page_inputs($id){

        return DB::table($this->table)->where(["payment_page_id"=>$id])->delete();
    }
}
