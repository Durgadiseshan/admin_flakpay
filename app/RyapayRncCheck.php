<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayRncCheck extends Model
{

    protected $table;

    public function __construct(){

        $this->table = "ryapay_rnccheck";
    }

    public function add_rnccheck($add_rncdata){
        return DB::table($this->table)->insert($add_rncdata);
    }

    public function get_rnccheck($id){
        return DB::table($this->table)->where(['merchant_id'=>$id])->select("id","merchant_id","field_name","field_label","field_value","field_verified")->get();
    }

    public function update_bulkrnccheck($id,$update_rncdata){
        return DB::table($this->table)->where($id)->update($update_rncdata);
    }

    public function update_detailscheck($id,$status){
        return DB::table($this->table)->where('id',$id)->update(["field_verified"=>$status]);
    }

    public function get_corrections_details($where_condition){
        return DB::table($this->table)->where($where_condition)->select("field_name","field_value")->get();
    }

    public function check_existing_record($id){

        return DB::table($this->table)->where('merchant_id',$id)->select(DB::Raw("COUNT(1) as no_of_rows"))->value("no_of_rows");
    }
}
