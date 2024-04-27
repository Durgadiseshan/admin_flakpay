<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class RyapayDOCCheck extends Model
{
    protected $table;

    public function __construct(){
        $this->table = "ryapay_docscheck";
    }

    public function add_doccheck($add_docdata){
        return DB::table($this->table)->insert($add_docdata);
    }

    public function update_bulkdoccheck($id,$update_docdata){
        return DB::table($this->table)->where($id)->update($update_docdata);
    }

    public function get_docheck($id){
        return DB::table($this->table)->where(['merchant_id'=>$id])->select("id","merchant_id","doc_name","file_name","file_ext","doc_verified")->get();
    }


    public function get_corrections_docs($where_condition){
        return DB::table($this->table)->where($where_condition)->select("doc_name","file_ext")->get();
    }

    public function update_doccheck($id,$status){
        return DB::table($this->table)->where('id',$id)->update(["doc_verified"=>$status]);
    }


    public function check_existing_record($id){

        return DB::table($this->table)->where('merchant_id',$id)->select(DB::Raw("COUNT(1) as no_of_rows"))->value("no_of_rows");
    }

    public function remove_doccheck($id){
        return DB::table($this->table)->where('merchant_id',$id)->delete();
    }
}
