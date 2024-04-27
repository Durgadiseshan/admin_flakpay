<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Dispute extends Model
{
    protected $table;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public function __construct(){
        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table = $this->table_prefix."_dispute";
    }


    public function get_all_disputes($filters=array()){


        $where_condition = 'dispute.created_merchant=:id';
        $apply_condition['id'] = Auth::user()->id;

        if(!empty($filters))
        {
            if(!empty($filters["dispute_gid"]))
            {
                $where_condition.= ' AND dispute.dispute_gid =:dispute_gid';
                $apply_condition['dispute_gid'] = $filters["dispute_gid"];
            }

            if(!empty($filters["payment_gid"]))
            {
                $where_condition.= ' AND payment.transaction_gid =:payment_gid';
                $apply_condition['payment_gid'] = $filters["payment_gid"];
            }

            if(!empty($filters["dispute_type"]))
            {
                $where_condition.= ' AND dispute.dispute_type =:dispute_type';
                $apply_condition['dispute_type'] = $filters["dispute_type"];
            }

            if(!empty($filters["dispute_status"]))
            {
                $where_condition.= ' AND dispute.dispute_status =:dispute_status';
                $apply_condition['dispute_status'] = $filters["dispute_status"];
            }
        }

        return DB::select("SELECT dispute_gid,IFNULL(payment.transaction_gid,'') as payment_gid,dispute_amount,dispute_type,dispute_status,dispute.created_date FROM ".$this->table_prefix.
        "_dispute dispute LEFT JOIN ".$this->table_prefix."_payment payment on 
        payment.id = dispute.payment_id where ".$where_condition." ORDER BY dispute.created_date DESC",$apply_condition);


    }
}
