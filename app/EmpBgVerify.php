<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EmpBgVerify extends Model
{
    protected $table;

    protected $jointable1;

    public function __construct(){

        $this->table = "emp_bgverify";
        $this->jointable1 = "employee";
    }

    public function add_emp_bgverify($emp_details){

        return DB::table($this->table)->insert($emp_details);
    }

    public function get_emp_bgvstatus(){

        $query = "SELECT $this->table.id, CONCAT_WS(' ',empname.first_name,empname.last_name) as emp_name, emp_details, emp_contact_detail, emp_reference, emp_academic, emp_history, DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date,IFNULL(last_updated,' ') last_updated,CONCAT_WS(' ',createduser.first_name,createduser.last_name) as created_user 
        FROM $this->table 
        JOIN $this->jointable1 empname on empname.id = $this->table.emp_id
        JOIN $this->jointable1 createduser on createduser.id = $this->table.created_user";
        //DB::EnableQueryLog();
        return DB::select($query);
        //dd(DB::getQueryLog());
        //exit;
    }
}


