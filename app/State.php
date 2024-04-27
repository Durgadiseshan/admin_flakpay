<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class State extends Model
{
    protected $table;

    public function __construct(){

        $this->table="state";
    }

    public $timestamps= FALSE;


    public function get_state_list(){

        $query = "SELECT id,state_name FROM $this->table ORDER BY state_name ASC";
        return DB::select($query);
    }

    public static function state_list(){

        $query = "SELECT id,state_name,gst_code FROM state ORDER BY state_name ASC";
        return DB::select($query);
    }

    public static function state_gstcode($id){
        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,gst_code FROM state WHERE";
        return DB::select($query." ".$where_condition,$apply_condition);
    }
}
