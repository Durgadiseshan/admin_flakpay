<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SettlementSuccessTxnExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Merchant Name',
            'Customer Name',
            'Mobile NO',
            'Email',
            'Amount',
            'Merchant Order Id',
            'FLAKPAY TXN Id',
            'EVOK TXN Id',
            'UTR_no',
            'Bank_TXN_Id',
            'created_at',
            'updated_at',
            'merchant_Id',
            'mid'
        ];
    }
}
