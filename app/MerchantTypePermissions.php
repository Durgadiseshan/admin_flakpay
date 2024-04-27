<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;
use DB;

class MerchantTypePermissions extends Model
{
   protected $table;

   

    public function __construct(){

       

        $this->table = "merchant_type_permissions";
    }


     public function saveData($data){
        return DB::table($this->table)->insert($data);
    }

    


}
