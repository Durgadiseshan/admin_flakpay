<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySubscribe extends Model
{

    protected $table;

    public function __construct(){
        $this->table = "ryapay_subscribe";
    }

    public function get_subscribe_list(){

        $query = "SELECT email,send_mail,DATE_FORMAT('created_date','%Y-%m-%d %H:%i:%s %p') as created_date 
        FROM $this->table ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }
}
