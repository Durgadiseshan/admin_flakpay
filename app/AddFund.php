<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class AddFund extends Model
{
    
    protected $table = 'payout_add_fund';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'amount', 'mode', 'status', 'credit_date','merchant_id','prev_balance','current_balance'
    ];


    public function merchant()
    {
        return $this->hasOne('App\User', 'id', 'merchant_id');
    }

}
