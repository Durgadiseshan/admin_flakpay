<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Merchant extends Model
{
    protected $table;
    public function __construct(){

        
        $this->table = "merchant";
        
    }


    


    
}
