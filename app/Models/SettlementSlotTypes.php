<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementSlotTypes extends Model
{
    use HasFactory;
    protected $table= "settlement_slot_types";

    public $primarykey = 's_no';
}
