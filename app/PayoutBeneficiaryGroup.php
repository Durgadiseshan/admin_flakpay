<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutBeneficiaryGroup extends Model
{
    protected $table = 'payout_benificiary_group';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'group_name', 'merchant_id'
    ];


    public function beneficiaries()
    {
        return $this->hasMany('App\PayoutBeneficiaries', 'group_id', 'id');
    }
}
