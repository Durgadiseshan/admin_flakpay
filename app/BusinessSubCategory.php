<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BusinessSubCategory extends Model
{
    protected $table;

    public $primarykey = 'id';

    public function __construct(){
        
        $this->table = "business_sub_category";
    }

    public $timestamps = FALSE;

    public function get_business_subcategory($category){

        $where_condition = "category_id=:id";
        $apply_condition["id"] = $category["id"];
        //DB::enableQueryLog();
        $query = "SELECT id,sub_category_name FROM $this->table WHERE $where_condition";
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
    }

    public function get_sel_business_subcategory($category_id){
       
        $where_condition = "category_id=:id";
        $apply_condition["id"] = $category_id;
        //DB::enableQueryLog();
        $query = "SELECT id,sub_category_name FROM $this->table WHERE $where_condition";
        return DB::select($query,$apply_condition);
        //dd(DB::getQueryLog());
    }

}
