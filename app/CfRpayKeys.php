<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class CfRpayKeys extends Model
{

    protected $table;
    protected $jointableone;
    protected $jointabletwo;

    public function __construct(){

        $this->table = "cf_rpay_keys";
        $this->jointableone = "merchant_business";
        $this->jointabletwo = "merchant";
    }

    public function ad_cf_keys($keys_data){
        return DB::table($this->table)->insert($keys_data);
    }

    public function get_cf_keys(){
        
        $query = "SELECT $this->table.id,IF($this->jointableone.business_name<>'',$this->jointableone.business_name,$this->jointabletwo.name) as business_name,app_id,secret_key,DATE_FORMAT($this->table.created_date,'%d-%m-%Y %H:%i:%s %p') as created_date  FROM $this->table
        LEFT JOIN $this->jointableone ON $this->jointableone.created_merchant = $this->table.merchant_id
        LEFT JOIN $this->jointabletwo ON $this->jointabletwo.id = $this->table.merchant_id";

        return DB::select($query);
    }

    public function get_cf_key($id){
        
        return DB::table($this->table)->where("id",$id)->select("id","merchant_id","app_id","secret_key")->get();
    }

    public function update_cf_keys($id,$keys_data){
        return DB::table($this->table)->where($id)->update($keys_data);
    }

}
