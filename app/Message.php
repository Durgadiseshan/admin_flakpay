<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Message extends Model
{
    public $table;

    public function __construct($table){
        $this->table = $table;
    }

    public function select_query($select,$where){
        //DB::enableQueryLog();
        return DB::table($this->table)->select($select)->where($where)->get();
        //DB::getQueryLog();
    }

    public function insert_query($insert_data)
    {
         //DB::enableQueryLog();
         return DB::table($this->table)->insert($insert_data);
         //DB::getQueryLog();
    }
}
