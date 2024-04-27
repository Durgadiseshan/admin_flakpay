<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Item extends Model
{
    protected $table;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public function __construct($prefix=0){

      if(Auth::check()){
        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
      }

       if($prefix){
             $this->table_prefix = "live";
            
        }
        
        $this->table = $this->table_prefix."_item";
    }

    protected $casts = [
        'item_amount' => 'double(16,2)',
    ];

    public $timestamps = FALSE;

    public function get_all_items($filters=array()){

        $where_condition = "created_merchant=:id AND item_status='active' ORDER BY $this->table.created_date DESC";
        $apply_condition["id"] = Auth::user()->id;
        
        if(!empty($filters))
        {
            if(!empty($filters["item_gid"]))
            {
                $where_condition .= " AND item_gid=:gid";
                $apply_condition["gid"] = $filters["item_gid"];
            }
            if(!empty($filters["item_name"]))
            {
                $where_condition .= " AND item_name=:it_name";
                $apply_condition["it_name"] = $filters["item_name"];
            }
        }
        $query = "SELECT id,item_gid,item_name,item_amount,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function get_dropdown_items(){
        $where_condition = "created_merchant=:id AND item_status='active'";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,item_name,item_amount FROM $this->table WHERE";
        return DB::select($query." ".$where_condition." ORDER BY $this->table.created_date DESC",$apply_condition);
    }

    public function add_item($data){
        return DB::table($this->table)->insert($data);
    }

    public function edit_item($itemid)
    {
        $apply_condition["id"] = $itemid;
        $query="SELECT id,item_name,item_amount,IFNULL(item_description,'') as item_description FROM $this->table WHERE id=:id AND item_status='active'";

        return DB::select($query,$apply_condition);
    }

    public function update_item($where_data,$fileds_data)
    {
       
        return DB::table($this->table)->where($where_data)->update($fileds_data);
    }

    public function remove_item($data){
        return DB::table($this->table)->where($data)->update(["item_status"=>"inactive"]);
    }
}
