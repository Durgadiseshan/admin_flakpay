<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PayslipElement extends Model
{
    protected $table;
    public function __construct()
    {
        $this->table = "payslip_element";
    }

    public static function get_payslip_elements()
    {
        $query = "SELECT id,element_label,element_name,element_type FROM payslip_element";

        return DB::select($query);
    }
}
