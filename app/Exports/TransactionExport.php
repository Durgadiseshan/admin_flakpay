<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection , WithHeadings
{


    public $transactionData;


    public function __construct($transactiondata){
        $this->transactionData = $transactiondata;
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
