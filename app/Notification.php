<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Notification extends Model
{
    public $table;

    public function __construct($table){
        $this->table = $table;
    }

    public function select_query($select,$where){
        //DB::enableQueryLog();
        return DB::table($this->table)->select($select)->where($where)->get();
        //DB::getQueryLog();
    }

    public function insert_query($insert_data)
    {
         //DB::enableQueryLog();
         return DB::table($this->table)->insert($insert_data);
         //DB::getQueryLog();
    }

    public function update_query($update_data,$id)
    {
        return DB::table($this->table)->where($id)->update($update_data);
    }


    public function get_merchant_notifications(){

        $where_condition = "notify_to =:id AND category='notification' ORDER BY $this->table.created_date desc";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id, message, notify_type,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);

    }

    public function get_merchant_messagess(){

        $where_condition = "notify_to =:id AND category='message' ORDER BY $this->table.created_date desc";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id, message,notify_type,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);

    }

    public function get_lastest_notifications(){

        $where_condition = "notify_to =:id AND category='notification' ORDER BY $this->table.created_date desc LIMIT 0,4 ";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,`message`,seen,notify_type,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }


    public function get_lastest_messages(){

        $where_condition = "notify_to =:id AND category='message' ORDER BY $this->table.created_date desc LIMIT 0,4 ";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,`message`,seen,notify_type,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date 
        FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }
    
    public function update_merchant_notifications()
    {
        //DB::enableQueryLog();
        return DB::table($this->table)->where(["notify_to"=>Auth::user()->id,"seen"=>"N",'category'=>'notification'])->update(["seen"=>'Y']);
        //dd(DB::getQueryLog());
        //exit;
    }

    public function update_merchant_messages()
    {
        //DB::enableQueryLog();
        return DB::table($this->table)->where(["notify_to"=>Auth::user()->id,"seen"=>"N",'category'=>'message'])->update(["seen"=>'Y']);
        //dd(DB::getQueryLog());
        //exit;
    }
}
