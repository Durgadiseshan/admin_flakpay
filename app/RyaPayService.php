<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyaPayService extends Model
{
    protected $table;

    public function __construct()
    {
        $this->table = "ryapay_service";
    }

    public static function get_services()
    {
        $query = "SELECT id,service_name FROM ryapay_service WHERE status = 'active'";

        return DB::select($query);
    }
}
