<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Navigation extends Model
{
    
    protected $table;

    protected $empGuard;

    private $user_type;

    private $department_type;

    public function __construct(){

        $this->table = "navigation";
        $this->empGuard = auth()->guard("employee")->user();
        $this->user_type = "1";
        $this->department_type = "1";
    }

    public function navigator($parent_id="0")
    {   
        
        $apply_condition = array(
            "parent_id"=>$parent_id,
            "user_type" => $this->user_type,
            "department_id"=>$this->department_type,
            "nav_status"=>"active"
        );
        //DB::enableQueryLog();
        $result = Navigation::with('sublinks')->where($apply_condition)->select("id","link_name","hyperlink","parent_id","hyperlinkid")->get();
        //dd(DB::getQueryLog());
        return $result;
    }



    public function sublinks()
    {
        return $this->hasMany('App\Navigation','parent_id')->where(["user_type"=>$this->user_type,"department_id"=>$this->department_type,"nav_status"=>"active"])->select("id","link_name","hyperlink","parent_id","hyperlinkid");
    }

    public function get_sub_links($parent_id)
    {   
        $where_condition = "user_type=:user_id AND department_id=:depart_id  AND nav_status='active'
                            AND hyperlinkid=:main_link_id";
        $apply_condition = array(
            "user_id" => "1",
            "depart_id"=>"1",
            "main_link_id"=>$parent_id
        );
        $query = "SELECT id,TRIM(link_name) as link_name,hyperlink FROM $this->table WHERE";
        
        //DB::enableQueryLog();
        $result = DB::select($query." ".$where_condition,$apply_condition);
        //dd(DB::getQueryLog());
        return $result;
    }

    public function get_app_navigation_links(){ 

        $query="SELECT t1.link_name as level1,t1.id as level1id,t2.id as leve2id,t2.hyperlink as link2,t2.link_name as level2 FROM $this->table t1
        LEFT JOIN $this->table t2 ON t2.parent_id = t1.id
        WHERE t1.user_type='1' AND t2.user_type='1' AND t1.nav_status='active' AND t2.nav_status='active' 
        ORDER BY t1.id,t2.id ASC";

        return DB::select($query); 
    }
}
