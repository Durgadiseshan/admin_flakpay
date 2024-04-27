<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserType extends Model
{
    
    protected $table;
    public function __consrtuct(){
        $this->table="user_type";
    }

    public static function get_user_options()
    {
        
        $query = "SELECT id,designation FROM user_type";
        return DB::select($query);
    }

    public static function get_hruser_options(){
        $query = "SELECT id,designation FROM user_type WHERE id NOT IN(1,2,3,5,6)";
        return DB::select($query);
    }
}
