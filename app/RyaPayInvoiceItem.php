<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class RyaPayInvoiceItem extends Model  
{
    protected $table;

    private $empGuard;

    public function __construct(){

        $this->table_prefix = "ryapay";
        
        $this->table =  $this->table_prefix."_invoice_item";

        $this->empGuard = auth()->guard("employee")->user();
    }



    public function add_invoice_item($invoiceitems)
    {
       return DB::table($this->table)->insert($invoiceitems);
    }


    public function get_invoice_item($id)
    {
        return DB::table($this->table)
        ->select('item_id','item_amount','item_quantity','item_total')
                ->where(['invoice_id'=>$id,'created_merchant'=>$this->empGuard->id])
        ->get();
    }

    public function delete_invoice_items($id)
    {
        return DB::table($this->table)->where($id)->delete();
    }
}
