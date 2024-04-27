<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayTaxPayment extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){
        $this->table = "ryapay_tax_payment";
        $this->jointableone = "app_option";
        $this->jointabletwo = "chart_of_account";
    }

    public function add_taxpayment($tax_payment_data){
        return DB::table($this->table)->insert($tax_payment_data);
    }

    public function get_all_taxpayment(){

        $query = "SELECT $this->table.id,option_value as tax_type,tax_payment_no,
        tax_payment_date,debit.account_code as debitcode,credit.account_code as creditcode,tax_total,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i%s %p') as created_date
        FROM $this->table 
        INNER JOIN $this->jointableone ON $this->jointableone.id=$this->table.tax_type
        INNER JOIN $this->jointabletwo AS debit ON debit.id = $this->table.debit_document
        INNER JOIN $this->jointabletwo AS credit ON credit.id = $this->table.credit_document
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }
}
