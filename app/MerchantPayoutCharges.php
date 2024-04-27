<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class MerchantPayoutCharges extends Model
{
    protected $table = 'merchant_payout_charges';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'merchant_id','min_range','max_range', 'IMPS', 'NEFT', 'RTGS', 'UPI', 'PAYTM', 'AMAZON', 'udf1', 'udf2', 'udf3', 'udf4', 'type'
    ];


    public function merchant()
    {
        return $this->hasOne('App\User', 'id', 'merchant_id');
    }

   
}
