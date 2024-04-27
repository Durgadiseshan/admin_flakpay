<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayCareer extends Model
{
    protected $table;
    protected $jointablone;

    public function __construct(){
        $this->table = "ryapay_job";
        $this->jointablone = "app_option";
    }

    public function get_jobs(){

        $query = "SELECT $this->table.id,job_title,$this->jointablone.option_value as job_category,job_location,job_status,DATE_FORMAT(created_date,'%Y-%m-%d %H:%i:%s %p') as created_date
        FROM $this->table INNER JOIN $this->jointablone ON $this->jointablone.id = $this->table.job_category ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function add_job($jobdetails){
        return DB::table($this->table)->insert($jobdetails);
    }

    public function get_job($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,job_title,job_category,job_description,job_location FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function get_posted_jobs(){

        $query = "SELECT id,job_title,job_description,job_category,job_location FROM $this->table
        WHERE job_status='active' ORDER BY created_date DESC";
        return DB::select($query);
    }

    public function get_job_description($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT job_title,job_description,job_location FROM $this->table WHERE $where_condition";
        return DB::select($query,$apply_condition);
    }

    public function update_job($id,$jobdetails){
        return DB::table($this->table)->where($id)->update($jobdetails);
    }
}
