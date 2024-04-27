<?php

namespace App\Exports;

use App\Refund;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Auth;

class ReportRefundExport implements FromCollection, WithMapping, WithHeadings
{


    public $reportData;
    public $srno=1;


    public function __construct($reportData){
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $filter=$this->reportData;
        $db=Refund::where('created_merchant',Auth::user()->id);
        // if ($filter['mode'] != null) {
        //    $db->where('transaction_mode',$filter['mode']);
        // }
        //  if ($filter['status'] != null) {
        //    $db->where('transaction_status',$filter['status']);
        // }

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
            "Gid", 
            "Payment Id", 
        "Refund Amount",
        "Refund Notes",
        "Refund Status",
        "Date",
        "Merchant"];
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
            $row->refund_gid,
            $row->payment_id,
            $row->refund_amount,
            $row->refund_notes,
            $row->refund_status,
            
            \Carbon\Carbon::parse($row->created_date)->format('j F, Y'),
           $row->merchant->name);

         return $data;
    }

    
}
