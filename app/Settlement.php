<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Settlement extends Model
{
    protected $table = "live_settlement";

    public $primarykey = "id";

    protected $table_prefix = "live_settlement";


    public function __construct($prefix=''){
       if(Auth::check()){


        if(!Auth::guard("employee")->user())
        {
            if(Auth::user()->app_mode)
            {
                $this->table_prefix = "live";
            }

            $this->table = $this->table_prefix."_settlement";
        }
      }

        if($prefix){
             $this->table = $prefix."_settlement";
            
        }
        
    }

    public function get_all_settlements($filters=array()){
        
        $where_condition = "settlement.created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;
        if(!empty($filters))
        {
            if(!empty($filters["settlement_gid"]))
            {
                $where_condition.= ' AND settlement.settlement_gid =:set_gid';
                $apply_condition["set_gid"] = $filters["settlement_gid"];
            }
        }

        return DB::select("SELECT settlement_gid,settlement_amount,settlement_fee,settlement_tax,created_date,'Processed' `status` FROM ".$this->table." settlement WHERE ".$where_condition." ORDER BY created_date DESC",$apply_condition);
    }

    public function get_dashboard_settlements($from_date="",$to_date=""){

        $where_condition = "settlement.created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        if(!empty($from_date))
        {
            $where_condition .=  ' AND DATE_FORMAT(created_date,"%Y-%m-%d")>=:from_date';
            $apply_condition['from_date'] = $from_date;
        }
        if(!empty($to_date))
        {
            $where_condition .=  ' AND DATE_FORMAT(created_date,"%Y-%m-%d")<=:to_date';
            $apply_condition['to_date'] = $to_date;
        }


        $query = "SELECT settlement_gid,settlement_amount,settlement_status,DATEDIFF(now(),created_date) as date_diff FROM ".$this->table." settlement WHERE";

        return DB::select($query." ".$where_condition." ORDER BY created_date DESC LIMIT 0,5",$apply_condition);
    }


    public function graph_no_of_settlements($from_date="",$to_date=""){


        $where_condition = "settlement.created_merchant=:id";
        $apply_condition['id'] =  Auth::user()->id;

        if(!empty($from_date))
        {
            $where_condition .=  " AND DATE_FORMAT(settlement.created_date,'%Y-%m-%d')>=:from_date";
            $apply_condition['from_date'] = $from_date;
        }
        if(!empty($to_date))
        {
            $where_condition .=  " AND DATE_FORMAT(settlement.created_date,'%Y-%m-%d')<=:to_date";
            $apply_condition['to_date'] = $to_date;
        }

        //DB::enableQueryLog();

        $total_payments_amount = "SELECT COUNT(1) as no_of_settlements,MONTHNAME(created_date) as month FROM $this->table as settlement WHERE";

        return DB::select($total_payments_amount." ".$where_condition." GROUP BY MONTH(created_date)",$apply_condition);
        
        //dd(DB::getQueryLog());
        //exit;

    }

    public function get_all_merchant_adjustments(){

        $query="SELECT settlement_gid,settlement_amount,settlement_fee,settlement_tax,DATE_FORMAT(created_date,'%d-%m-%Y %h:%i:%s %p') created_date FROM live_settlement ORDER BY created_date DESC";

        return DB::select($query);
    }

    public function add_live_settlement($adjustment_data){

        return DB::table("live_settlement")->insert($adjustment_data);
    }

     public function merchant()
    {
        return $this->belongsTo(Merchant::class,'created_merchant','id');
    }
}
