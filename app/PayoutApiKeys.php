<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutApiKeys extends Model
{
    protected $table = 'merchant_payout_apikeys';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'merchant_id','client_id','secret_key'
    ];
    
}
