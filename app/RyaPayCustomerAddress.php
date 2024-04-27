<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyaPayCustomerAddress extends Model
{
    protected $table;

    protected $join_tableone;

    public $primarykey = 'id';

    public function __construct(){

        $this->table_prefix = "ryapay";
        $this->table = $this->table_prefix."_address";
        $this->join_tableone = "state";
        $this->empGuard = auth()->guard("employee")->user();
    }

    protected $fillable = ['address,pincode,city'];

    public function get_customer_address($customer_id){

        $where_condition = "$this->table.created_user=:id AND $this->table.status='active' AND address_module = 'customer'";
        $apply_condition["id"] = $this->empGuard->id;


        if(!empty($customer_id))
        {
            $where_condition.= " AND $this->table.address_id=:customer_id";
            $apply_condition["customer_id"] = $customer_id;
        }

        $query = "SELECT $this->table.id as id,CONCAT_WS(' ',`address`,pincode,city,state_name) as `address`,`address` as customer_address,pincode,city,state_name,address_id,state_id FROM $this->table LEFT JOIN $this->join_tableone
        on $this->join_tableone.id = $this->table.state_id WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);

    }

    public function add_customer_address($customer_address)
    {
        return DB::table($this->table)->insert($customer_address);
    }


    public function update_customer_address($customer_address,$id)
    {
        return DB::table($this->table)->where($id)->update($customer_address);
    }
}
