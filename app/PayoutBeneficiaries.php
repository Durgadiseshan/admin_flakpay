<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutBeneficiaries extends Model
{
    protected $table = 'payout_benificiary';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'beneficiary_id', 'upi_id', 'account_number', 'ifsc_code', 'group_id', 'contact_id', 'merchant_id'
    ];


    public function contacts()
    {
        return $this->hasOne('App\PayoutContacts', 'id', 'contact_id');
    }

    public function group()
    {
        return $this->hasOne('App\PayoutBeneficiaryGroup', 'id', 'group_id');
    }
}
