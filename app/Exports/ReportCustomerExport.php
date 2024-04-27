<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Auth;

class ReportCustomerExport implements FromCollection, WithMapping, WithHeadings
{


    public $reportData;
    public $srno=1;


    public function __construct($reportData){
        $this->reportData = $reportData;
    }

    public function collection()
    {
        $filter=$this->reportData;
        $db=Customer::where('created_merchant',Auth::user()->id);
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
            "Customer Id", 
            "Name", 
            "Email",
            "Phone",
            "GST No",
                "Status",
            "Created At"
            
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
         if($row->created_date != null)
           $t_date=\Carbon\Carbon::parse($row->created_date)->format('j F, Y');

        $data=array(
            $sr_no,
            $row->customer_gid,
            $row->customer_name,
            
            $row->customer_email,
            $row->customer_phone,
            $row->customer_gstno,
            $row->status,
            $t_date
            );

         return $data;
    }

    
}
