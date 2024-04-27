<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Auth;
use DB;

class MerchantApi extends Model
{
    protected $table;

    public $primarykey = 'id';

    public $api_prefix = "ryapay_test_";

    private $table_prefix = "test";

    private $date_time = "";

    public function __construct(){

        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
            $this->api_prefix = "ryapay_live_";
        }
        $this->date_time = date("Y-m-d h:i:s");

        $this->table = $this->table_prefix."_merchantapi";
    }


    public function add_newapi()
    {
        $newapi = array(
            "api_key" => $this->api_prefix.Str::random(16),
            "api_secret"=>Str::random(16),
            "request_hashkey"=>Str::random(16),
            "request_salt_key"=>Str::random(16),
            "response_salt_key"=>Str::random(16),
            "response_hashkey"=>Str::random(16),
            "encryption_request_key"=>Str::random(16),
            "encryption_response_key"=>Str::random(16),
            "created_date"=>$this->date_time,
            "created_merchant"=>Auth::user()->id
        );
        return DB::table($this->table)->insertGetId($newapi);
    }


    public function get_merchant_api()
    {
         
        return DB::table($this->table)->where("created_merchant",Auth::user()->id)->select("id","api_key","created_date")->get();
    }

    

   

    public function edit_merchant_api($api_id)
    {
        $where_condition = "id=:id AND created_merchant=:mtid";
        $apply_condition["id"] = $api_id;
        $apply_condition["mtid"] = Auth::user()->id;

        $query =  "SELECT id,api_secret,api_key,request_hashkey,request_salt_key,response_salt_key,encryption_request_key,encryption_response_key,response_hashkey from $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }

    public function update_merchant_api($api_id)
    {
        $updateapi = array(
            "api_key" => $this->api_prefix.Str::random(16),
            "api_secret"=>Str::random(16),
            "request_hashkey"=>Str::random(16),
            "request_salt_key"=>Str::random(16),
            "response_salt_key"=>Str::random(16),
            "response_hashkey"=>Str::random(16),
            "encryption_request_key"=>Str::random(16),
            "encryption_response_key"=>Str::random(16),
            "created_date"=>$this->date_time,
        );

        return DB::table($this->table)->where(["id"=>$api_id,"created_merchant"=>Auth::user()->id])->update($updateapi);
    }


}
