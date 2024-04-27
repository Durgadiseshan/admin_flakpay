<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutContacts extends Model
{
    protected $table = 'payout_contacts';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'name', 'mobile', 'contact', 'address', 'state', 'pincode', 'merchant_id'
    ];

    public function statedata()
    {
        return $this->hasOne('App\State', 'id', 'state');
    }

    public function beneficiaries()
    {
        return $this->hasMany('App\PayoutBeneficiaries', 'contact_id', 'id');
    }
}
