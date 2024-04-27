<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;
use DB;

class MerchantMenus extends Model
{
   protected $table;

   

    public function __construct(){

       

        $this->table = "merchant_menus";
    }

    


}
