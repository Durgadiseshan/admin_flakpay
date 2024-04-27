<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmpWorkStatus extends Model
{

    protected $table;

    public function __construct(){
        $this->table = "emp_workstatus";
    }


    public function add_work_status($workstatus){

        return DB::table($this->table)->insert($workstatus);
    }

    public function get_work_status($empId){

        $where_condition = "created_user=:emp_id";
        $apply_condition["emp_id"] = $empId;

        $query = "SELECT id,DATE_FORMAT(today_date,'%d-%m-%Y') as today_date,today_work,nextday_work,DATE_FORMAT(created_date,'%Y-%m-%d') as created_date,
        IFNULL(DATE_FORMAT(modified_date,'%Y-%m-%d'),'') as modified_date,IF(DATE_FORMAT($this->table.created_date,'%d-%m-%Y') < DATE_FORMAT(now(),'%d-%m-%Y'),'not-edit','edit') as allow_edit FROM  $this->table WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
        
    }

    public function get_work_info($recordId){

        $where_condition = "id=:id";
        $apply_condition["id"] = $recordId;

        $query = "SELECT id,DATE_FORMAT(today_date,'%Y-%m-%d') as today_date,today_work,nextday_work FROM  $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_work_status($record_id,$workstatus){

        return DB::table($this->table)->where($record_id)->update($workstatus);
    }
}
