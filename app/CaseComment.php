<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CaseComment extends Model
{
    protected $table;

    public function __construct()
    {
        $this->table = "case_comment";
    }

    protected $fillable = ["case_id","`comment`",""];

    public function add_comment($commentdata){
        return DB::table($this->table)->insert($commentdata);
    }

    public function get_comment($caseid){

        $where_condition = "case_id=:caseid";
        $apply_condition["caseid"] = $caseid;


        $query = "SELECT `comment`,commented_user,user_type,DATE_FORMAT(commented_date,'%d-%m-%Y %h:%i:%s %p') as commented_date  FROM $this->table WHERE";
        return DB::select($query." ".$where_condition,$apply_condition);
    }
}
