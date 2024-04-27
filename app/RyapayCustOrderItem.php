<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayCustOrderItem extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "ryapay_custorder_item";
    }

    public function add_custorder_item($custorder_item){
        return DB::table($this->table)->insert($custorder_item);
    }

    public function remove_custorder_item($custorder_id){
        return DB::table($this->table)->where("custorder_id",$custorder_id)->delete();
    }
}
