<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MerchantTransactionExport implements FromCollection , WithHeadings
{


    public $transactionData;


    public function __construct($transactiondata){
        $this->transactionData = $transactiondata;
    }

    public function headings(): array
    {
        // return ["Transaction ID", 
        // "Transaction Type", 
        // "Name",
        // "Email",
        // "Contact",
        // "Amount",
        // "Status",
        // "Payment Mode",
        // "Date Time"];
        return [
            "Customer Name", 
        "Mobile No", 
        "Amount",
        "Email",
        "Upi Id",
        "Order Id",
        "Transaction Id",
        "Transaction status",
        "Created Date",
        "Updated Date",
    ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->transactionData);
    }

    
}
