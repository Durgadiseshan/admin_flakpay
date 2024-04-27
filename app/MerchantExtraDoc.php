<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MerchantExtraDoc extends Model
{
    protected $table;
    protected $jointableone;

    public function __construct(){
        $this->table = "merchant_extra_doc";
        $this->jointableone = "merchant";
    }

    public function add_extra_doc($extra_doc){
        return DB::table($this->table)->insert($extra_doc);
    }

    public function get_merchant_docs(){

        $query = "SELECT $this->jointableone.id,$this->jointableone.name,doc_name,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->table LEFT JOIN $this->jointableone ON $this->jointableone.id = $this->table.merchant_id
        group by $this->table.merchant_id ORDER BY $this->table.created_date desc";

        return DB::select($query);
    }

    public function get_merchant_docs_list($id){

        $where_condition = "merchant_id=:id";
        $apply_condition["id"] = $id;

        $query="SELECT doc_name,doc_file,DATE_FORMAT($this->table.created_date,'%Y-%m-%d %H:%i:%s %p') as created_date FROM $this->table WHERE $where_condition ORDER BY created_date DESC";

        return DB::select($query,$apply_condition);
    }
}
