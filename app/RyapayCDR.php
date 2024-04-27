<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayCDR extends Model 
{
    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){
        $this->table = "ryapay_cdr";
        $this->jointableone = "app_option";
        $this->jointabletwo = "ryapay_adjustment_trans";
    }

    public function add_cdr_transaction($cdr_data){
        return DB::table($this->table)->insert($cdr_data);
    }

    public function get_cdr_transactions(){

        $query = "SELECT $this->table.id,$this->jointableone.option_value as trans_type,$this->table.transaction_gid,$this->table.transaction_date,$this->jointabletwo.transaction_gid as adjustment_id,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %h:%i:%s %p') as created_date FROM $this->table 
        LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.cdr_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.adjustment_trans_id
        ORDER BY $this->table.created_date DESC";

        return DB::select($query);
    }

    public function get_cdr_transaction($id){
        
        $where_condition = "id=:id";
        $apply_condition["id"] = $id;

        $query = "SELECT $this->table.id,cdr_id,cdr_desc,transaction_gid,transaction_date,adjustment_trans_id,total_amount,remarks FROM $this->table WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }

    public function update_cdr_transaction($id,$cdr_data){
        return DB::table($this->table)->where($id)->update($cdr_data);
    }


}
