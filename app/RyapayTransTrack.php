<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class RyapayTransTrack extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "ryapay_trans_track";
    }

    public function add_trans_tracking($response){
        return DB::table($this->table)->insert($response);
    }
}
