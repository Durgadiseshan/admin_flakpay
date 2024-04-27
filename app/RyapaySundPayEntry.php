<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySundPayEntry extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;
    protected $jointablefour;

    public function __construct(){
        $this->table="ryapay_sund_payentry";
        $this->jointableone="ryapay_supplier";
        $this->jointabletwo="ryapay_bank_info";
        $this->jointablethree="app_option";
        $this->jointablefour = "chart_of_account";
    }
    
    public function add_sund_payentry($sundry_payentrydata){
        return DB::table($this->table)->insert($sundry_payentrydata);
    }

    public function get_sund_payentries(){

        $query = "SELECT $this->table.id,sund_pay_no,sund_pay_date,$this->jointableone.supplier_name,$this->jointablefour.account_code,$this->jointabletwo.bank_name,$this->jointablethree.option_value as payment_mode,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table 
        LEFT JOIN $this->jointableone ON $this->jointableone.id=$this->table.supplier_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id=$this->table.bank_id
        LEFT JOIN $this->jointablethree ON $this->jointablethree.id=$this->table.payment_mode
        LEFT JOIN $this->jointablefour ON $this->jointablefour.id=$this->table.expense_code
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_sund_payentry($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,sund_pay_no,sund_pay_date,supplier_id,expense_code,bank_id,payment_mode,payment_amount,remarks FROM $this->table 
        ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function update_sund_payentry($id,$sund_payentrydata){
        return DB::table($this->table)->where($id)->update($sund_payentrydata);
    }
}
