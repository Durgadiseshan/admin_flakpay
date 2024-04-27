<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmpPayslip extends Model
{
    protected $table;
    protected $jointable1;

    public function __construct()
    {
        $this->table = "emp_payslip";
        $this->jointable1 = "employee";
        $this->jointable2 = "emp_earn_deduct";
        $this->jointable3 = "payslip_element";
    }

    public function add_payslip($payslip)
    {
        return DB::table($this->table)->insertGetId($payslip);
    }

    public function get_payslip()
    {

        $query = "SELECT $this->table.id,CONCAT_WS(' ',$this->jointable1.first_name,$this->jointable1.last_name) full_name, payslip_month, total_addition, total_deduction,
         net_salary,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
        JOIN $this->jointable1 ON $this->jointable1.id = $this->table.employee_id ORDER BY $this->table.created_date";

        return DB::select($query);
    }

    public function get_employee_payslip($id)
    {
        $where_condition = "$this->table.id=:payslip_id";
        $apply_condition["payslip_id"] = $id;

        $query = "SELECT $this->table.id,employee_id,CONCAT_WS(' ',$this->jointable1.first_name,$this->jointable1.last_name) full_name,$this->jointable1.designation,payslip_month,total_addition,total_deduction, net_salary,check_number,bank_name,DATE_FORMAT(payslip_gdate,'%d-%m-%Y') payslip_gdate,employee_sign,director_sign, $this->jointable2.element_id,
        $this->jointable3.element_type,$this->jointable2.element_value FROM $this->table JOIN $this->jointable1 ON $this->jointable1.id = $this->table.employee_id LEFT JOIN $this->jointable2 ON $this->jointable2.emp_payslip_id = $this->table.id
        LEFT JOIN $this->jointable3 ON $this->jointable3.id = $this->jointable2.element_id WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

}
