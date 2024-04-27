<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutWallet extends Model
{
    protected $table = 'payout_wallet';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'merchant_id','balance','updated_at'
    ];


   
    public function merchant()
    {
        return $this->hasOne('App\User', 'id', 'merchant_id');
    }


 
}
