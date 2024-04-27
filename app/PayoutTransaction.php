<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class PayoutTransaction extends Model
{
    protected $table = 'payout_transactions';

    public $primarykey = 'id';

    public $timestamps = FALSE;

    public function beneficiary()
    {
        return $this->hasOne('App\PayoutBeneficiaries', 'beneficiary_id', 'ben_id');
    }

    protected $fillable = [
        "merchant_id",
        "reference_id",
        "utr",
        "transfer_id",
        "ben_id",
        "ben_name",
        "ben_phone",
        "ben_email",
        "ben_upi",
        "ben_card_no",
        "ben_ifsc",
        "ben_bank_acc",
        "amount",
        "transfer_mode",
        "status",
        "remarks",
        "purpose",
        "vendor_charges",
        "goods_service_tax",
        "created_at",
        "transfer_type",
    ];
}
