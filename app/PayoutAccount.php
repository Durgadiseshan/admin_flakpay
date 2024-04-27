<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutAccount extends Model
{
    protected $table = 'payout_account';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'merchant_id', 'bank_name', 'account_holder_name', 'account_number', 'ifsc_code', 'account_id'
    ];
}
