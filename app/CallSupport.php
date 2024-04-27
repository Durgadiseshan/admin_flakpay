<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class CallSupport extends Model
{
    protected $table;

    protected $empGuard;

    public function __construct()
    {
        $this->table = "call_support";
        $this->empGuard = auth()->guard("employee")->user();
    }

    public function add_call_support($supportdata){

        return DB::table($this->table)->insert($supportdata);
    }

    public function get_all_callsupportt(){

        $where_condition = "created_user=:user_id";
        $apply_condition["user_id"] = $this->empGuard->id;

        $query = "SELECT sup_category, sup_title,DATE_FORMAT(next_call,'%d-%m-%Y') next_call,
         sup_status, merchant_id, merchant_mobile, marchant_email,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p')
         created_date
         FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }
}
