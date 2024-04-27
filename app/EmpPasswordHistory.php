<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EmpPasswordHistory extends Model
{

    protected $table = "emp_password_history";

    public function add_password_history($password_history){

        return DB::table($this->table)->insert($password_history);
    }

    public function get_password_history($id){

        $where_codition = "employee_id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT `password` FROM $this->table WHERE";

        return DB::select($query." ".$where_codition." ORDER BY password_change_at DESC limit 0,3",$apply_condition);

    }
}
