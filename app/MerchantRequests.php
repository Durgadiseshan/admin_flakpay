<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MerchantRequests extends Model
{

    protected $table;

    protected $primarykey = 'id';


    public function __construct(){
		$this->table = 'merchant_requests';
    }

    public function get_request_count($merchant_id,$requestfor){
        $where_condition = "merchant_id=:merchant_id AND request=:request";
        $apply_condition["merchant_id"] = $merchant_id;
        $apply_condition["request"] = $requestfor;

        $query="SELECT * FROM $this->table
        WHERE $where_condition";

        $row= DB::select($query,$apply_condition);

       return count($row);

    }


    
}
