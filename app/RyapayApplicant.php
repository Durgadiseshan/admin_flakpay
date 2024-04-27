<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayApplicant extends Model
{

    protected $table;
    protected $jointableone;

    public function __construct(){
        $this->table = "ryapay_applicant";
        $this->jointableone = "ryapay_job";
    }


    public function get_applicants(){

        $query = "SELECT $this->table.id,$this->jointableone.job_title,applicant_name,applicant_email,applicant_mobile,applicant_status,applicant_resume,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date
        FROM $this->table LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.job_id
        ORDER BY $this->table.created_date DESC";
        
        return DB::select($query);
    }

    public function add_applicant($applicant_data){

        return DB::table($this->table)->insert($applicant_data);
    }

    public function update_applicant($applicant_id,$applicant_data){
        return DB::table($this->table)->where($applicant_id)->update($applicant_data);
    }

}
