<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantSettlementMode extends Model
{
    use HasFactory;

    protected $table = 'merchant_settlement_modes'; // specify the table name if it's different

    protected $fillable = ['id', 'name', 'type', 'duration'];

    public $timestamps = true; // Laravel automatically manages created_at and updated_at timestamps

    // Additional model logic or relationships can be defined here
}
