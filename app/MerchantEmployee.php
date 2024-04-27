<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;

class MerchantEmployee extends Authenticatable
{

    use Notifiable;

    protected $guard = "merchantemp";
    protected $table = "merchant_employee";
    protected $jointableone = "app_option";

    public $timestamps = false;

    /**
     * Get the password for the Merchant Employee.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->employee_password;
    }

    public function get_merchant_empcount(){

        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT count(1) AS emp_count FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function add_merchant_employee($employee_data){

        return DB::table($this->table)->insert($employee_data);
    }

    public function get_merchant_employees(){

        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT $this->table.id,employee_gid,employee_name,employee_email,employee_mobile,$this->jointableone.option_value AS employee_type,employee_status,
        is_account_locked,
        DATE_FORMAT(created_date,'%Y-%m-%d %H:%i:%s %p') AS created_date 
        FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.employee_type
        WHERE $where_condition ORDER BY $this->table.created_date DESC";


        return DB::select($query,$apply_condition);
    }

    public function get_merchant_employee_info($id){

        $where_condition = "created_merchant=:merchantid AND id=:id";
        $apply_condition["merchantid"] = Auth::user()->id;
        $apply_condition["id"] = $id;

        $query = "SELECT id,employee_name,employee_email,employee_mobile,employee_type
        FROM $this->table
        WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }
    

    public function update_merchant_employee($employee_id,$employee_data){

           $s= DB::table($this->table)->where($employee_id)->update($employee_data);
          
        return $s;
    }

    public function unlock_merchant_employee($employee_id){

        return DB::table($this->table)->where("id",$employee_id)->update(["is_account_locked"=>"N"]);
    }
}
