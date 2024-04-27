<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PaymentSettlementResponse extends Model
{
    
    protected $table = 'payment_settlement_response';

    public function merchant()
    {
        return $this->hasOne('App\User', 'id', 'merchant_id');
    }

}
