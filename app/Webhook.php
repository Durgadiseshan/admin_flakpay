<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;


class Webhook extends Model
{
    protected $table;

    protected $table_prefix = "test";

    public function __construct(){
        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }

        $this->table = $this->table_prefix."_webhook";
    }

    protected $fillable = [ "webhook_url","secret_key","is_active","payment_failed","payment_captured","transfer_processed",
        "refund_processed","refund_created","refund_speed_changed","order_paid","dispute_created","dispute_won","dispute_lost",
        "dispute_closed","settlement_processed","invoice_paid","invoice_partially_paid","invoice_expired","paylink_paid",
        "paylink_partially_paid","paylink_expired","paylink_cancelled",
    ];

    protected $hidden = [
        "created_date","created_merchant",
    ];


    public function add_webhook($webhook_data){
        return DB::table( $this->table)->insert($webhook_data);
    }

    public function update_webhook($webhook_id,$webhook_data)
    {
        return DB::table( $this->table)->where("id",$webhook_id)->update($webhook_data);
    }

    public function get_merchant_webhook(){

        $where_condition = "created_merchant=:id";
        $apply_condition["id"] = Auth::user()->id;

        $query = "SELECT id,webhook_url,secret_key,is_active,payment_failed,payment_captured,transfer_processed,
        refund_processed,refund_created,refund_speed_changed,order_paid,dispute_created,dispute_won,dispute_lost,
        dispute_closed,settlement_processed,invoice_paid,invoice_partially_paid,invoice_expired,paylink_paid,
        paylink_partially_paid,paylink_expired,paylink_cancelled,created_date FROM $this->table WHERE";

        return DB::select($query." ".$where_condition,$apply_condition);
    }
}
