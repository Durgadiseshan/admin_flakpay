<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Payout extends Model
{
    protected $table = 'payout_transactions';

    public $primarykey = 'id';

    public $timestamps = FALSE;


    protected $fillable = [
        'reference_id', 'transfer_id', 'ben_id', 'ben_name', 'ben_phone', 'ben_email', 'ben_upi','ben_card_no','ben_ifsc',
        'ben_bank_acc','amount','transfer_mode','status','remarks','purpose','transfer_desc','vendor_charges','goods_service_tax,
        ','transfer_type'
    ];
}
