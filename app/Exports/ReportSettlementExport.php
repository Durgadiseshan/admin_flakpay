<?php

namespace App\Exports;

use App\Settlement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Auth;

class ReportSettlementExport implements FromCollection, WithMapping, WithHeadings
{


    public $reportData;
    public $srno=1;


    public function __construct($reportData){
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $filter=$this->reportData;
        $db=Settlement::where('created_merchant',Auth::user()->id);
        // if ($filter['mode'] != null) {
        //    $db->where('transaction_mode',$filter['mode']);
        // }
        //  if ($filter['status'] != null) {
        //    $db->where('settlement_status',$filter['status']);
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
            "Settlement ID", 
            "Current Balance", 
        "Settlement Amount",
        "Settlement Fee",
        "Settlement Tax",
        "Settlement Status",
        "Settlement Date",
        "Date",
        "Merchant"
        ];
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
       

        $data=array(
            $sr_no,
            $row->settlement_gid,
            $row->current_balance,
            $row->settlement_amount,
            $row->settlement_fee,
            $row->settlement_tax,
            $row->settlement_status,
            \Carbon\Carbon::parse($row->settlement_date)->format('j F, Y'),
            \Carbon\Carbon::parse($row->created_date)->format('j F, Y'),
            $row->merchant->name
            );

         return $data;
    }

    
}
