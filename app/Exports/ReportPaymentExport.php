<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Auth;

class ReportPaymentExport implements FromCollection, WithMapping, WithHeadings
{


    public $reportData;
    public $srno=1;


    public function __construct($reportData){
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $filter=$this->reportData;
        $db=Payment::where('created_merchant',Auth::user()->id);
        if ($filter['mode'] != null) {
           $db->where('transaction_mode',$filter['mode']);
        }
         if ($filter['status'] != null) {
           $db->where('transaction_status',$filter['status']);
        }

         if ($filter['from'] != null) {
           $db->whereDate('created_date', '>=', Carbon::parse($filter['from'])->format('Y-m-d'));

                }

        if ($filter['to'] != null) {

           $db->whereDate('created_date', '<=', Carbon::parse($filter['to'])->format('Y-m-d'));
         }
           
         return $db->get();   

    }

    public function headings(): array
    {
        return [
            "sr no",
            "Transaction ID", 
            "Transaction Response", 
        "Transaction Type",
        "Merchant",
        "Username",
        "Email",
        "Contact",
        "Amount",
        "Status",
        "Payment Mode",
        "Description",
        "Transaction Date Time"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return collect($this->reportData);
    // }


     public function map($row): array
    {
            
        $sr_no=$this->srno++;
        $t_date='';
         if($row->transaction_date != null)
           $t_date=\Carbon\Carbon::parse($row->transaction_date)->format('j F, Y');

        $data=array(
            $sr_no,
            $row->order_id,
            $row->transaction_response,
            $row->transaction_type,
            $row->merchant->name,
            $row->transaction_username,
            $row->transaction_email,
            $row->transaction_contact,
            $row->transaction_amount,
            $row->transaction_status,
            $row->transaction_mode,
            $row->transaction_description,
            $t_date);

         return $data;
    }

    
}
