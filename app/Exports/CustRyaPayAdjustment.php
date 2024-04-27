<?php

namespace App\Exports;

//use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CustRyaPayAdjustment implements FromView //FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // public function collection()
    // {
    //    return collect($this->data);
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Transaction Type',
    //         'Basic Amount',
    //         'Charge on Basic Amount',
    //         'Charges',
    //         'GST on Charges',
    //         'GST Amount',
    //         'Total Amount Charged (Charges + GST Amt)'
    //     ];
    // }

    public function view(): View
    {
        return view('employee.pagination', [
            "module"=>"adjustment_report",
            "adjustment_reports" => $this->data
        ]);
    }
        
}
