<?php

namespace App\Exports;

use Illuminate\Support\Carbon; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class SuccessRatiosExport implements FromCollection, WithHeadings, WithTitle
{

    protected $successRatios;

    public function __construct($successRatios)
    {
        $this->successRatios = $successRatios;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    
    public function collection()
    {
        // return $this->successRatios;
        return $this->successRatios->map(function ($item) {
            return [
                'Start Time'=>Carbon::parse($item->start_time)->format('d-m-Y H:i') ,
                'End Time' =>Carbon::parse($item->end_time)->format('d-m-Y H:i'),
                'Total Transaction' => $item->total_transactions,
                'Success Transaction' => $item->success_transactions,
                'Success Ratio' => $item->success_ratio . '%',
                
            ];
        });
    }


    public function headings(): array
    {
        return [
            
            'Start Time',
            'End Time',
            'Total Transactions',
            'Success Transactions',
            'Success Ratio',
            
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
       
        return 'Success Ratios Report';
    }




    
}
