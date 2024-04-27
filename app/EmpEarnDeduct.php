<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmpEarnDeduct extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "emp_earn_deduct";
    }

    public function add_emp_earn_deduct($earn_deduct_data)
    {
        return DB::table($this->table)->insert($earn_deduct_data);
    }
}
