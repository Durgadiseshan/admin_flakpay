<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CharOfAccount extends Model
{
    protected $table;

    public function __construct()
    {
        $this->table = "chart_of_account";
    }

    public function get_account_details()
    {
        //DB::enableQueryLog();

        $query = "SELECT id,account_code,description,currency,account_group,main_grouping,note_no,note_description,DATE_FORMAT(created_date,'%d-%m-%Y %h:%s:%i %p') as created_date FROM $this->table ORDER BY $this->table.created_date DESC";

        return DB::select($query);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function get_chart_details($chart_id)
    {
        //DB::enableQueryLog();
        return DB::table($this->table)->where("id",$chart_id)->select("id","account_code","description","account_group","main_grouping","note_no","note_description")->get();
        //dd(DB::getQueryLog());
        //exit;
    }

    public function update_chart_details($updater_array,$record_id)
    {
        return DB::table($this->table)->where($record_id)->update($updater_array);
    }

    public function add_account_chart($chart_data){
        return DB::table($this->table)->insert($chart_data);
    }

    public static function get_code_options()
    {
        return DB::table("chart_of_account")->select("id","account_code","description")->get();
    }
}
