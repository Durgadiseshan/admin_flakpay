<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BusinessType extends Model
{
    protected $table;

    public $primarykey = 'id';
    public $jointableone;

    public function __construct(){
        
        $this->table = "business_type";
        $this->jointableone = "merchant_business";
    }

    public $timestamps = FALSE;

    public function get_business_type(){

        $query = "SELECT id,type_name FROM $this->table LIMIT 0,9";

        return DB::select($query);
    }

    public static function business_type(){

        return DB::table("business_type")->select("id","type_name")->limit(9)->get();
    }

    public function business_typename($id){

        $where_condition = "created_merchant=:merchant_id";
        $apply_condition["merchant_id"] = $id;

        $query = "SELECT $this->table.id FROM $this->table INNER JOIN $this->jointableone ON business_type_id= $this->table.id 
        WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

}
