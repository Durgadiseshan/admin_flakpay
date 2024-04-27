<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayJournalVoucher extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){

        $this->table = "ryapay_journal_voucher";
        $this->jointableone = "chart_of_account";

    }

    public function get_all_vouchers(){

        $where_condition = "status='active' ORDER BY $this->table.created_date DESC";
        
        $query = "SELECT $this->table.id,voucher_no,debit_account.account_code as debit_account_code,$this->table.debit_amount,
        credit_account.account_code as credit_account_code,$this->table.credit_amount,voucher_total,remark,voucher_date,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date FROM $this->table
        LEFT JOIN $this->jointableone debit_account ON debit_account.id = $this->table.debit_account_code
        LEFT JOIN $this->jointableone credit_account ON credit_account.id = $this->table.credit_account_code WHERE";

        return DB::select($query." ".$where_condition);
    }

    public function add_voucher($voucher_data){
        return DB::table($this->table)->insert($voucher_data);
    }

    public function edit_voucher_info($id){

        $where_condition = "id=:id AND status='active'";
        $apply_condition["id"] = $id;

        $query = "SELECT id,voucher_no,debit_account_code,debit_amount,
        credit_account_code,credit_amount,voucher_total,remark,voucher_date FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);

    }

    public function update_voucher_info($voucher_data,$voucher_id){
        return DB::table($this->table)->where($voucher_id)->update($voucher_data);
    }
}
