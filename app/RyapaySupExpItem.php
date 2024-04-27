<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySupExpItem extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "ryapay_supexp_item";
    }

    public function add_supexp_item($supexp_item){
        return DB::table($this->table)->insert($supexp_item);
    }

    public function remove_supexp_item($supexp_id){
        return DB::table($this->table)->where("supexp_id",$supexp_id)->delete();
    }
}
