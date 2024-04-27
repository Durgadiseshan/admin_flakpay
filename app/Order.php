<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Order extends Model
{
    protected $table;

    protected $jointable1;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public function __construct(){
        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table = $this->table_prefix."_order";
        $this->jointable1 = $this->table_prefix."_payment";
    }


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function get_all_orders($filters=array()){
        
        $where_condition = 'created_merchant=:id';
        $apply_condition['id'] = Auth::user()->id;

        if(!empty($filters["order_gid"]))
        {
            $where_condition.= ' AND order_gid=:gid';
            $apply_condition['gid'] = $filters["order_gid"];

        }if(!empty($filters["order_receipt"])){

            $where_condition.= ' AND order_receipt=:receipt';
            $apply_condition['receipt']=$filters["order_receipt"];
        }

        $query = "select id,order_gid,order_amount,order_attempts,order_receipt,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date,order_status from $this->table WHERE $where_condition ORDER BY $this->table.created_date DESC";

        return DB::select($query,$apply_condition);
    }

    public function get_order($id)
    {

        $where_condition = '`order`.id=:id AND `order`.created_merchant=:merchant_id';
        $apply_condition['id'] = $id;
        $apply_condition['merchant_id'] = Auth::user()->id;

        $query = "SELECT `order`.order_gid,payment.transaction_gid,IFNULL(`order`.order_receipt,'') order_receipt,`order`.order_attempts,`order`.order_amount,`order`.order_status,DATE_FORMAT(`order`.created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM $this->table `order`
        LEFT JOIN $this->jointable1 payment on payment.order_id = `order`.id WHERE $where_condition";

        return DB::select($query,$apply_condition);
    }
}
