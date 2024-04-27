<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class MerchantPayoutVendor extends Model
{
    protected $table = 'merchant_payout_vendor';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'merchant_id', 'imps', 'neft', 'rtgs', 'upi', 'paytm', 'amazon', 'udf1', 'udf2', 'udf3', 'udf4', 'type'
    ];


    public function merchant()
    {
        return $this->hasOne('App\User', 'id', 'merchant_id');
    }

   
}
