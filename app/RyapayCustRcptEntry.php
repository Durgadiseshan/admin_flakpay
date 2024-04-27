<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayCustRcptEntry extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;

    public function __construct(){
        $this->table = "ryapay_cust_rcptentry";
        $this->jointableone = "ryapay_customer";
        $this->jointabletwo = "ryapay_bank_info";
        $this->jointablethree = "app_option";
    }

    public function add_custrcpt_entry($custrcpt_data){
        return DB::table($this->table)->insert($custrcpt_data);
    }

    public function get_custrcpt_entries(){

        $query = "SELECT $this->table.id,receipt_no,receipt_date,$this->jointableone.customer_name,receipt_invtype,receipt_invno,$this->jointabletwo.bank_name,$this->jointablethree.option_value as receipt_mode,
        DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.customer_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.bank_id
        LEFT JOIN $this->jointablethree ON $this->jointablethree.id = $this->table.receipt_mode
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_custrcpt_entry($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,receipt_no,receipt_date,customer_id,receipt_invtype,receipt_invno,bank_id,receipt_mode,receipt_amount,remarks FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_custrcpt_entry($id,$custrcpt_data){
        return DB::table($this->table)->where($id)->update($custrcpt_data);
    }
}
