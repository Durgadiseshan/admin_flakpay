<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySorderItem extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "ryapay_sorder_item";
    }

    public function add_sorder_item($sorder_item_data){
        return DB::table($this->table)->insert($sorder_item_data);
    }

    public function remove_sorder_item($id){
        return DB::table($this->table)->where("sorder_id",$id)->delete();
    }

    public function get_sorder_items($sorder_id){
        return DB::table($this->table)->where("sorder_id",$sorder_id)->select("item_id","item_amount","item_quantity","item_total")->get();
    }
}
