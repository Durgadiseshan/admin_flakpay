<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class NavPermission extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "nav_permission";
    }

    public function get_employee_navpermissions(){
        
        $where_condition = "employee_id =:id";
        $apply_condition["id"] = auth()->guard("employee")->user()->id;

        $query = "SELECT account,account,finance,settlement,technical,networking,support,marketing,sales,risk_complaince,legal,hrm,
        merchant,payout FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }
}
