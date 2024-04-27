<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BusinessCategory extends Model
{
    protected $table;

    public $primarykey = 'id';

    public function __construct(){
        
        $this->table = "business_category";
    }

    public $timestamps = FALSE;

    public function get_business_category(){

        $query = "SELECT id,category_name FROM $this->table";

        return DB::select($query);
    }

    public static function get_category(){

        $query = "SELECT id,category_name FROM business_category";

        return DB::select($query);
    }
}
