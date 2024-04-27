<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayEmailLog extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "ryapay_emails_log";
    }

    public function insert_email_log($email_log){
        return DB::table($this->table)->insert($email_log);
    }
}
