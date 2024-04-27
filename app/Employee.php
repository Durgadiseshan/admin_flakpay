<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Employee extends Authenticatable
{
    use Notifiable;

    protected $table = 'employee';
    protected $guard = 'employee';
    protected $jointable1 = 'user_type';
    protected $jointable2 = 'department';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_username', 'first_name','last_name','designation','personal_email','official_email',
        'mobile_no','department','user_type','last_seen_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_date'
    ];

    public static function get_employee_list()
    {
        $query = "SELECT id,CONCAT_WS(' ',first_name,last_name) full_name FROM employee WHERE employee_status='active' AND user_type='8'";
        return DB::select($query);
    }


    public function get_all_employees()
    {
        if(auth()->guard($this->guard)->user()->user_type == '1')
        {
            $where_condition = "employee_status='active' AND $this->table.user_type<>'1'";
        }else{
            $where_condition = "employee_status='active' AND $this->table.user_type NOT IN ('1','2','3','5','6','".auth()->guard($this->guard)->user()->user_type."')";
        }
        

        $query = "SELECT $this->table.id,employee_username, CONCAT_WS(' ',first_name,last_name) full_name,$this->table.designation,personal_email, official_email,mobile_no,$this->jointable2.department_name,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p')created_date,employee_status FROM $this->table JOIN $this->jointable1 on $this->jointable1.id = $this->table.user_type JOIN $this->jointable2 on $this->jointable2.id = $this->table.department WHERE";

        return DB::select($query." ".$where_condition);

    }

    public function get_employee_details($id)
    {
        $where_condition = "employee_status='active' AND $this->table.id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,$this->table.department,$this->table.user_type,employee_username,first_name,last_name,$this->table.designation,personal_email,official_email,mobile_no,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p')created_date,DATE_FORMAT($this->table.last_seen_at,'%d-%m-%Y %h:%i:%s %p') last_seen_at,$this->jointable1.designation,$this->jointable2.department_name FROM $this->table JOIN $this->jointable1 on $this->jointable1.id = $this->table.user_type JOIN $this->jointable2 on $this->jointable2.id = $this->table.department WHERE";

        $result =  DB::select($query." ".$where_condition,$apply_condition);
        return $result[0];
    }

    public function add_employee($employee)
    {
       return DB::table($this->table)->insertGetId($employee);
    }

    public function update_employee_details($details,$where){

        return DB::table($this->table)->where($where)->update($details);
    }

    public function update_my_details($details,$id){

        return DB::table($this->table)->where("id",$id)->update($details);
    }
    
}
