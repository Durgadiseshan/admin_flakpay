<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmpDetail extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "emp_detail";
    }

    public function add_emp_details($emp_details){

        return DB::table($this->table)->insert($emp_details);
    }
}
