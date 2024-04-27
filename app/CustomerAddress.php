<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class CustomerAddress extends Model
{
    protected $table;

    protected $join_table1;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public function __construct(){

        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table = $this->table_prefix."_customer_address";
        $this->join_table1 = "state";
    }

    protected $fillable = ['address,pincode,city'];

    public function get_customer_address($customer_id){

        $where_condition = "$this->table.created_merchant=:id AND $this->table.status='active'";
        $apply_condition["id"] = Auth::user()->id;


        if(!empty($customer_id))
        {
            $where_condition.= " AND $this->table.customer_id=:customer_id";
            $apply_condition["customer_id"] = $customer_id;
        }

        $query = "SELECT $this->table.id as id,CONCAT_WS(' ',`address`,pincode,city,state_name) as `address`,`address` as customer_address,pincode,city,state_name,customer_id,state_id FROM $this->table LEFT JOIN $this->join_table1
        on $this->join_table1.id = $this->table.state_id WHERE";

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
