<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmpContactDetail extends Model
{
    protected $table;

    public function __construct(){

        $this->table = "emp_contact_detail";
    }

    public function add_emp_contact_detail($emp_contact_detail){

        return DB::table($this->table)->insert($emp_contact_detail);
    }
}
