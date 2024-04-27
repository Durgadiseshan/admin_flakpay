<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EmpDocument extends Model
{
    protected $table;
    protected $jointable1;

    public function __construct(){
        $this->table = "emp_document";
        $this->jointable1 = "employee";
    }

    public function get_employee_nda_document($emp_id)
    {
        $where_condition = "employee_id=:emp_id AND doc_belongs_to='nda'";
        $apply_condition["emp_id"] = $emp_id;
        $query = "SELECT id,employee_docs FROM $this->table WHERE";

        return DB::select($query." ". $where_condition, $apply_condition);
        
    }

    public function get_employee_ca_document($emp_id)
    {
        $where_condition = "employee_id=:emp_id AND doc_belongs_to='ca'";
        $apply_condition["emp_id"] = $emp_id;
        $query = "SELECT id,employee_docs FROM $this->table WHERE";

        return DB::select($query." ". $where_condition, $apply_condition);
        
    }

    public function get_all_documents($doc_type)
    {
        $where_condition = "doc_belongs_to='$doc_type'";
        $query = "SELECT employee_docs,CONCAT_WS(' ',$this->jointable1.first_name,$this->jointable1.last_name) as full_name,
        DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table JOIN $this->jointable1 on 
        $this->jointable1.id = $this->table.employee_id 
        WHERE";
        //DB::enableQueryLog();
        return DB::select($query." ".$where_condition);
       // dd(DB::getQueryLog());
        //exit;
        
    }

    public function upload_employee_document($document)
    {
       return DB::table($this->table)->insert($document);
    }

    public function update_employee_document($where_cond,$document)
    {
        return DB::table($this->table)->where($where_cond)->update($document);
        
    }

}
