<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyapayTaxSettlement extends Model
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){
        $this->table = "ryapay_tax_settlement";
        $this->jointableone = "app_option";
        $this->jointabletwo = "chart_of_account";
    }

    public function add_taxsettlement($tax_settlement_data){
        return DB::table($this->table)->insert($tax_settlement_data);
    }

    public function get_all_taxsettlement(){

        $query = "SELECT $this->table.id,app_option.option_value as tax_type,tax_settlement_no,
        tax_date_from,tax_date_to,debit.account_code as debitcode,credit.account_code creditcode,tax_total,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i%s %p') as created_date
        FROM $this->table 
        INNER JOIN $this->jointableone ON $this->jointableone.id=$this->table.tax_type
        INNER JOIN $this->jointabletwo AS debit ON debit.id = $this->table.debit_account_code
        INNER JOIN $this->jointabletwo AS credit ON credit.id = $this->table.credit_account_code
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }
}
