<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapaySundRcptEntry extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;
    protected $jointablethree;
    protected $jointablefour;

    public function __construct(){
        $this->table = "ryapay_sund_rcptentry";
        $this->jointableone="ryapay_customer";
        $this->jointabletwo="ryapay_bank_info";
        $this->jointablethree="app_option";
        $this->jointablefour = "chart_of_account";
    }

    public function add_sundrcpt_entry($sundrcpt_data){
        return DB::table($this->table)->insert($sundrcpt_data);
    }

    public function get_sund_rcpt_entries(){
        
        $query = "SELECT $this->table.id,sundry_rcpt_no,receipt_date,$this->jointableone.customer_name,$this->jointablefour.account_code as revenue_code,$this->jointabletwo.bank_name,$this->jointablethree.option_value as payment_mode,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table 
        LEFT JOIN $this->jointableone ON $this->jointableone.id=$this->table.customer_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id=$this->table.bank_id
        LEFT JOIN $this->jointablethree ON $this->jointablethree.id=$this->table.receipt_mode
        LEFT JOIN $this->jointablefour ON $this->jointablefour.id=$this->table.revenue_code
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_sund_rcpt_entry($id){
        
        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT id,sundry_rcpt_no,receipt_date,customer_id,revenue_code,bank_id,receipt_mode,receipt_amount,remarks FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_sundrcpt_entry($id,$sundrcpt_data){
        return DB::table($this->table)->where($id)->update($sundrcpt_data);
    }
}
