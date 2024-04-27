<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySupplier extends Model
{
    protected $table;

    public $primarykey = 'id';

    protected $fillable = ['supplier_company,supplier_name,supplier_email,supplier_phone,supplier_gstno']; 

    public $timestamps = FALSE;

    private $empGuard;

    protected $jointableone;

    public function __construct(){

        $this->table_prefix = "ryapay";
        $this->table = $this->table_prefix."_supplier";
        $this->empGuard = auth()->guard("employee")->user();
        $this->jointableone = "state";
    }

    public function get_all_suppliers(){

        $query = "SELECT id,supplier_company,supplier_gid,supplier_name,supplier_email,supplier_phone,`status`,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table
        WHERE `status`='active' ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function add_supplier($supplier_data)
    {
        return DB::table($this->table)->insert($supplier_data);
    }

    public function edit_supplier_info($supplier_id){


        // $where_condition = "supplier.created_user=:id";
        // $apply_condition["id"] =  $this->empGuard->id;

        if(!empty($supplier_id))
        {
            $where_condition ="supplier.id=:supplier_id";
            $apply_condition["supplier_id"] = $supplier_id;
        }

        $query = "SELECT id,supplier_company,supplier_name,supplier_email,supplier_phone,supplier_gstno,supplier_address,supplier_city,supplier_pincode,supplier_state FROM $this->table supplier WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function update_supplier_info($supplier_data,$supplier_id)
    {
        return DB::table($this->table)->where($supplier_id)->update($supplier_data);
    }

    public function get_selected_supplier_info($supplier_id){


        // $where_condition = "supplier.created_user=:id";
        // $apply_condition["id"] =  $this->empGuard->id;

        if(!empty($supplier_id))
        {
            $where_condition ="supplier.id=:supplier_id";
            $apply_condition["supplier_id"] = $supplier_id;
        }

        $query = "SELECT supplier.id,supplier_company,supplier_name,supplier_email,supplier_phone,supplier_gstno,CONCAT_WS(' ',supplier_address,supplier_city,supplier_pincode,$this->jointableone.state_name) as supplier_address FROM $this->table supplier LEFT JOIN $this->jointableone ON $this->jointableone.id = supplier.supplier_state WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public static function get_sup_opts(){

        $query = "SELECT id,supplier_name FROM ryapay_supplier WHERE `status`='active'";

        return DB::select($query);
    }
}
