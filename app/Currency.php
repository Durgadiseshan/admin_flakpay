<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Currency extends Model
{

    protected $table;

    public function __construct()
    {
        $this->table = "currency";
    }

    public function get_currency()
    {
        $query = "SELECT id,currency FROM $this->table";
        return DB::select($query);
    }
}
