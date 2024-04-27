<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Refund extends Model
{
    protected $table;

    public $primarykey = 'id';

    protected $table_prefix = "test";

    public function __construct(){
        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table = $this->table_prefix."_refund";
    }

    public function get_payment_refund_count($payment_id,$filters=array()){
         $where_condition = 'refund.payment_id=:payment_id';
          $apply_condition['payment_id'] = $payment_id;

       $row= DB::select("SELECT refund_gid,IFNULL(payment.transaction_gid,'') as payment_gid,refund_amount,refund.refund_status,refund.created_date FROM ".$this->table_prefix.
        "_refund refund LEFT JOIN ".$this->table_prefix."_payment payment on 
        payment.id = refund.payment_id where ".$where_condition." ORDER BY refund.created_date DESC",$apply_condition);

       return count($row);

    }

     public function get_payment_refund_detail($payment_id,$filters=array()){
         $where_condition = 'refund.payment_id=:payment_id';
          $apply_condition['payment_id'] = $payment_id;

       $row= DB::select("SELECT refund_gid,IFNULL(payment.transaction_gid,'') as payment_gid,refund_amount,refund.refund_status,refund.created_date FROM ".$this->table_prefix.
        "_refund refund LEFT JOIN ".$this->table_prefix."_payment payment on 
        payment.id = refund.payment_id where ".$where_condition." ORDER BY refund.created_date DESC",$apply_condition);

       return ($row);

    }


    public function get_all_refunds($filters=array()){


        $where_condition = 'refund.created_merchant=:id';
        $apply_condition['id'] = Auth::user()->id;

        if(!empty($filters))
        {
            if(!empty($filters["refund_gid"]))
            {
                $where_condition.= ' AND refund.refund_gid =:refund_gid';
                $apply_condition['refund_gid'] = $filters["refund_gid"];
            }

            if(!empty($filters["payment_gid"]))
            {
                $where_condition.= ' AND payment.payment_gid =:payment_gid';
                $apply_condition['payment_gid'] = $filters["payment_gid"];
            }
        }

        return DB::select("SELECT refund_gid,IFNULL(payment.transaction_gid,'') as payment_gid,refund_amount,refund.refund_status,refund.created_date FROM ".$this->table_prefix.
        "_refund refund LEFT JOIN ".$this->table_prefix."_payment payment on 
        payment.id = refund.payment_id where ".$where_condition." ORDER BY refund.created_date DESC",$apply_condition);


    }

    public function get_dashboard_refunds($from_date="",$to_date="")
    {
        $where_condition = 'refund.created_merchant=:id';
        $apply_condition['id'] = Auth::user()->id;


        if(!empty($from_date))
        {
            $where_condition .=  ' AND DATE_FORMAT(refund.created_date,"%Y-%m-%d")>=:from_date';
            $apply_condition['from_date'] = $from_date;
        }
        if(!empty($to_date))
        {
            $where_condition .=  ' AND DATE_FORMAT(refund.created_date,"%Y-%m-%d")<=:to_date';
            $apply_condition['to_date'] = $to_date;
        }

        $query="SELECT refund_gid,IFNULL(payment.transaction_gid,'') as payment_gid,refund_amount,refund.refund_status,DATEDIFF(now(),refund.created_date) as date_diff FROM ".$this->table_prefix.
        "_refund refund LEFT JOIN ".$this->table_prefix."_payment payment on 
        payment.id = refund.payment_id where";

        return DB::select($query." ".$where_condition." ORDER BY refund.created_date DESC LIMIT 0,5",$apply_condition);
    }

     public function merchant()
    {
        return $this->belongsTo(Merchant::class,'created_merchant','id');
    }

    public function add_refund($refund)
    {
        return DB::table($this->table)->insert($refund);
    }

}
