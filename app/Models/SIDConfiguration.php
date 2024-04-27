<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SIDConfiguration extends Model
{
    use HasFactory;

    protected $table= "sid_configuration";

    public $primarykey = 'id';

}
