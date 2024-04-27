<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayPorderItem extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "ryapay_porder_item";
    }

    public function add_porder_item($porder_item_data){
        return DB::table($this->table)->insert($porder_item_data);
    }

    public function remove_porder_item($id){
        return DB::table($this->table)->where("porder_id",$id)->delete();
    }

    public function get_porder_items($porder_id){
        return DB::table($this->table)->where("porder_id",$porder_id)->select("item_id","item_amount","item_quantity","item_total")->get();
    }
}
