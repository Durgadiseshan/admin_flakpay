<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Department extends Model
{

    protected $table;
    public function __consrtuct(){
        $this->table="department";
    }

    public static function get_dept_options()
    {

        $query = "SELECT id,department_name FROM department";

        return DB::select($query);
    }


    public static function get_hrdept_options()
    {

        $query = "SELECT id,department_name FROM department WHERE id<>'1'";

        return DB::select($query);
    }
}
