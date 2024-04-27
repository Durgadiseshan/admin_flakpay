<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MerchantServices extends Model
{

    protected $table;

    protected $primarykey = 'id';


    public function __construct(){

        $this->table = 'merchant_services';
    }


    
}
