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
class ReportGstExport implements FromCollection, WithMapping, WithHeadings
{


    public $reportData;
    public $srno=1;


    public function __construct($reportData){
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $filter=$this->reportData;
        $db = Settlement::
        select(
                "id" ,
                "settlement_receiptno",
                DB::raw("(sum(settlement_fee)) as total_fee"),
                DB::raw("(sum(settlement_tax)) as total_tax"),
                DB::raw("(DATE_FORMAT(settlement_date, '%d-%m-%Y')) as my_date")
                            )
        ->where('created_merchant',Auth::user()->id);

        if ($filter['from'] != null) {
           $db->whereDate('settlement_date', '>=', $filter['from']);

                }

        if ($filter['to'] != null) {

           $db->whereDate('settlement_date', '<=', $filter['to']);
         }

        $db->groupBy(DB::raw("DATE_FORMAT(settlement_date, '%d-%m-%Y')"));
          
         return $db->get();   

    }

    public function headings(): array
    {
        return [
            "sr no",
            "Taxable Value", 
            "Tax (18% GST)", 
        "Total Amount",
        "Settlement Date",
        "Invoice"
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
            $row->total_fee,
            $row->total_tax,
            $row->total_fee+$row->total_tax,
            $t_date,
            $row->settlement_receiptno);

         return $data;
    }

    
}
