<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class TransactionReportLog extends Model
{
    protected $table;
    public function __construct(){

        
        $this->table = "transaction_report_log";
        
    }

    public function add_transaction_log($data)
    {
        return DB::table($this->table)->insert($data);
    }

    
}
