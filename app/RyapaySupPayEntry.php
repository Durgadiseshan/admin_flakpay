<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapaySupPayEntry extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;
    protected $jointablefour;
    protected $jointablefive;
    protected $jointablesix;

    public function __construct(){
        $this->table="ryapay_sup_payentry";
        $this->jointableone="ryapay_supplier";
        $this->jointabletwo="ryapay_bank_info";
        $this->jointablethree="app_option";
        $this->jointablefour="ryapay_suporder_invoice";
        $this->jointablefive="ryapay_supexp_invoice";
        $this->jointablesix="ryapay_supplier_cdnote";

    }
    
    public function add_sup_payentry($sup_payentrydata){
        return DB::table($this->table)->insert($sup_payentrydata);
    }

    public function get_sup_entries(){

        $query = "SELECT $this->table.id,batch_no,batch_pay_date,$this->jointableone.supplier_name,batch_invtype,batch_invno,$this->jointabletwo.bank_name,$this->jointablethree.option_value as payment_mode,
        DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table 
        LEFT JOIN $this->jointableone ON $this->jointableone.id=$this->table.supplier_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id=$this->table.bank_id
        LEFT JOIN $this->jointablethree ON $this->jointablethree.id=$this->table.payment_mode
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_sup_entry($id){

        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,batch_no,batch_pay_date,supplier_id,batch_invtype,batch_invno,bank_id,payment_mode,payment_amount,remarks
        FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_sup_payentry($id,$sup_payentrydata){
        return DB::table($this->table)->where($id)->update($sup_payentrydata);
    }
}
