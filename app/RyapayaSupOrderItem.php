<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayaSupOrderItem extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "ryapay_suporder_item";
    }

    public function add_suporder_item($suporder_item){
        return DB::table($this->table)->insert($suporder_item);
    }

    public function remove_suporder_item($suporder_id){
        return DB::table($this->table)->where("suporder_id",$suporder_id)->delete();
    }
}
