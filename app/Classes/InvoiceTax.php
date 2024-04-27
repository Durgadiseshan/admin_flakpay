<?php

namespace App\Classes;

use Illuminate\Http\Request;

class InvoiceTax{

    public static $igst = "18";
    public static $sgst = "9";
    public static $cgst = "9";

    public static function outer_state()
    {
        return InvoiceTax::$igst;
    }

    public static function inner_state()
    {
        return InvoiceTax::$sgst+InvoiceTax::$cgst;
    }

}


?>