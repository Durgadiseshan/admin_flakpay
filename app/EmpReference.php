<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmpReference extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "emp_reference";
    }

    public function add_emp_reference($emp_reference_detail){

        return DB::table($this->table)->insert($emp_reference_detail);
    }
}
