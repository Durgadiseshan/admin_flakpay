<?php

namespace App\Exports;

use App\Settlement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Auth;
use DB;
class ReportGstDetailsExport implements FromCollection, WithMapping, WithHeadings
{


    public $reportData;
    public $srno=1;


    public function __construct($reportData){
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $filter=$this->reportData;
        $db = Settlement::where('created_merchant',Auth::user()->id);
    
        if ($filter['date'] != null) {
           $db->whereDate('settlement_date', Carbon::parse($filter['date'])->format('Y-m-d'));

                }

        $data=$db->get();
          
         return $data;   

    }

    public function headings(): array
    {
        return [
            "sr no",
            "Settlement Gid", 
            "Current Balance", 
            "Settlement Amount",
           "Settlement Fee",
            "Settlement Tax",
            "Settlement Total", 
            "Settlement Status",
           "Merchant",
           "Settlement Date"
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
        $t_date='';
         if($row->my_date != null)
           $t_date=\Carbon\Carbon::parse($row->my_date)->format('j F, Y');

        $data=array(
            $sr_no,
            $row->settlement_gid,
            $row->current_balance,
            $row->settlement_amount,
            $row->settlement_fee,
            $row->settlement_tax,
            $row->settlement_tax + $row->settlement_fee,
           $row->settlement_status,
          $row->merchant->name,
          \Carbon\Carbon::parse($row->settlement_date)->format('j F, Y')

            );

         return $data;
    }

    
}
