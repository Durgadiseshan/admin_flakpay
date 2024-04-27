<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class InvoiceItem extends Model
{
    protected $table;

    public $table_prefix = "test";

    public function __construct(){

        if(Auth::user()->app_mode)
        {
            $this->table_prefix = "live";
        }
        $this->table =  $this->table_prefix."_invoice_item";
    }



    public function add_invoice_item($invoiceitems)
    {
       return DB::table($this->table)->insert($invoiceitems);
    }


    public function get_invoice_item($id)
    {
        return DB::table($this->table)
        ->select('item_id','item_amount','item_quantity','item_total')
                ->where(['invoice_id'=>$id,'created_merchant'=>Auth::user()->id])
        ->get();
    }

    public function delete_invoice_items($id)
    {
        return DB::table($this->table)->where($id)->delete();
    }

}
