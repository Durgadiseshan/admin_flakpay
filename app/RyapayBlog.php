<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class RyapayBlog extends Model
{
    protected $table;
    protected $jointable1;
    protected $post_from;

    protected $jointable2;

    public function __construct($postform=""){

        $this->table="ryapay_blog";
        $this->jointable1="app_option";
        $this->jointable2="employee";
        $this->post_from = "blog";

        if(!empty($postform)){
            $this->post_from = $postform;
        }
    }

    public function add_post($insert_data){
        return DB::table($this->table)->insert($insert_data);
    }

    public function get_all_post(){
        
        $where_condition = "post_status='active' AND post_from='$this->post_from'";

        $query = "SELECT $this->table.id,title,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date,CONCAT_WS(' ',employee.first_name,employee.last_name) as created_user FROM $this->table JOIN employee ON employee.id = ryapay_blog.created_user WHERE $where_condition ORDER BY $this->table.created_date DESC";
        
        return DB::select($query);
    }

    public function get_post($id){
        
        $where_condition = "id=:id AND post_from='$this->post_from'";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,title,description,post_gid,post_category,image FROM $this->table WHERE";
        
        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_all_posts(){

        $where_condition = "post_status='active' AND post_from='$this->post_from'";

        $query = "SELECT $this->table.id,title,image,description,post_gid,DATE_FORMAT($this->table.created_date,'%M %d,%Y') as created_date,DATE_FORMAT($this->table.created_date,'%d') as created_day,DATE_FORMAT($this->table.created_date,'%M ,%Y') as created_monthyear,CONCAT_WS(' ',employee.first_name,employee.last_name) as created_user FROM $this->table JOIN employee ON employee.id = ryapay_blog.created_user WHERE
        $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_recent_posts(){

        $where_condition = "post_status='active' AND post_from='$this->post_from'";

        $query = "SELECT $this->table.id,title,image,post_gid,DATE_FORMAT($this->table.created_date,'%M %d,%Y') as created_date FROM $this->table WHERE";
        return DB::select($query." ".$where_condition." ORDER BY $this->table.created_date DESC LIMIT 0,4");
    }

    public function show_post($id){

        $where_condition = "post_gid=:postid AND post_status='active' AND post_from='$this->post_from'";
        $apply_condition["postid"] = $id;


        $query = "SELECT $this->table.id,title,post_gid,image,description,$this->jointable1.option_value AS category_name,DATE_FORMAT($this->table.created_date,'%M %d,%Y') as created_date,CONCAT_WS(' ',employee.first_name,employee.last_name) as created_user FROM $this->table
        LEFT JOIN $this->jointable2 ON $this->jointable2.id = $this->table.created_user
        LEFT JOIN $this->jointable1 ON $this->jointable1.id = $this->table.post_category WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    
    public function update_post($id,$update){

        return DB::table($this->table)->where($id)->update($update);
    }

    public function get_post_description(){
        return DB::table($this->table)->where($id)->value("description");
    }
}
