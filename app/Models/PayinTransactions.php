<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Auth;
use DateTime;

class PayinTransactions extends Model
{

    protected $table= "payin_transactions";

    public $primarykey = 'id';

    protected $table_prefix = "payin_transactions";

    protected $requestresp = "atom_response";

    protected $merchantId;

    protected $empId;

    public function __construct()
    {

        if (Auth::guard("merchantemp")->check()) {

            $this->table_prefix = "payin";

            $this->merchantId = Auth::guard("merchantemp")->user()->created_merchant;

            $this->empId = Auth::guard("merchantemp")->user()->id;
        } else {

            if (Auth::check() && Auth::user()->app_mode == 1) {
                $this->table_prefix = "live";
                $this->merchantId = Auth::user()->id;
            }
        }

    }
}