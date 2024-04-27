<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayVendorBank extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "vendor_bank";
    }


    public static function get_vendorbank(){

        $query = "SELECT id,bank_name FROM vendor_bank";

        return DB::select($query);
    }
}
