<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class RyaPayItem extends Model
{
    protected $table;

    public $primarykey = 'id';


    public function __construct(){

        $this->table_prefix = "ryapay";
        
        $this->table = $this->table_prefix."_item";

        $this->empGuard = auth()->guard("employee")->user();
    }

    public $timestamps = FALSE;

    public function get_all_items($filters=array()){

        $where_condition = "created_user=:id AND item_status='active'";
        $apply_condition["id"] = $this->empGuard->id;
        
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
        $query = "SELECT id,item_gid,item_name,item_amount,created_date FROM $this->table WHERE";

        return DB::select($query." ".$where_condition." ORDER BY created_date DESC",$apply_condition);
    }

    public function get_dropdown_items(){
        $where_condition = "created_user=:id AND item_status='active'";
        $apply_condition["id"] = $this->empGuard->id;

        $query = "SELECT id,item_name,item_amount FROM $this->table WHERE";
        return DB::select($query." ".$where_condition." ORDER BY created_date DESC",$apply_condition);
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

    public function update_item($fileds_data)
    {       
        return DB::table($this->table)->where("created_user",$this->empGuard->id)->update($fileds_data);
    }

    public function remove_item($data){
        return DB::table($this->table)->where($data)->update(["item_status"=>"inactive"]);
    }
}
