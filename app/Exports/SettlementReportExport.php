<?php
namespace App\Exports;

use Illuminate\Support\Carbon; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;


class SettlementReportExport implements FromCollection, WithHeadings
{

// public function createExcel()
// {
//     $data = [
//         ['Kousy', 'kousy@example.com'],
//         ['Test', 'test@example.com'],
//         // Add more data as needed
//     ];

//     $excelFileName = 'Example_excel.xlsx';

//     // Store the file in the project's public storage directory
//     $filePath = 'excel/' . $excelFileName;

//     // Generate the Excel file
//     Excel::store(new class($data) implements FromArray, WithHeadings {
//         protected $data;

//         public function __construct($data)
//         {
//             $this->data = $data;
//         }

//         public function array(): array
//         {
//             return $this->data;
//         }

//         public function headings(): array
//         {
//             return ['Name', 'Email'];
//         }
//     }, $filePath, 'public');

//     // Now, generate the URL to access the file
//     $excelFilePath = 'download-excel/' . $excelFileName;

    
//     // Return the URL to download the Excel sheet
//     return url($excelFilePath);
// }

    
// public function downloadExcel($filename)
// {
//     $file = storage_path('app/public/excel/' . $filename);

//     return response()->download($file); 
// }

public $settlementTransactionData;


    public function __construct($settlementTransactionData)
    {
        $this->settlementTransactionData = $settlementTransactionData;
    }

    public function headings(): array
    {
        return [
        "S.No", 
        "Merchant id", 
        "Merchant Name",
        "Customer Name",
        "Transaction Amount",
        "Mobile No",
        "Email",
        "Upi Id",
        "Order Id",
        "FPay Transaction Id",
        "EVOK Transaction Id",
        "RRN No",
        "Bank Transaction Id",
        "Transaction Status",
        "Transaction Initiated at",
        "Transaction Updated at"
    ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return collect($this->transactionData);
    // }
    public function collection()
    {
        $serialNumber = 1;

        return collect($this->transactionData)->map(function ($transaction) use (&$serialNumber) {
            // Include the automatically generated S.No
            $transaction->S_No = $serialNumber++;
            $rrnNo = property_exists($transaction, 'rrn_no') ? $transaction->rrn_no : '';
            $evoktxnid = property_exists($transaction, 'evok_txnid') ? $transaction->evok_txnid : '';
            $acqrbanktxnid = property_exists($transaction, 'acqrbank_txnid') ? $transaction->acqrbank_txnid : '';

            $txnStatus = ($transaction->txn_status == 1) ? 'TXN not initiated' :
            (($transaction->txn_status == 2) ? 'Success' :
            (($transaction->txn_status == 0) ? 'Failed' :
            (($transaction->txn_status == 3) ? 'Tampered' : '')));


            return [
                $transaction->S_No,
                $transaction->merchant_id,
               
                $transaction->name,
                $transaction->customer_name,
                
                $transaction->amount,
                $transaction->mobile_no,
                $transaction->email,
                $transaction->upi_id,
                $transaction->order_id,
                $transaction->fpay_trxnid,
                $evoktxnid,
                $rrnNo,
                $acqrbanktxnid,
                $txnStatus,
                $transaction->created_at,
                $transaction->updated_at
            ];
        });
    }


}


?>