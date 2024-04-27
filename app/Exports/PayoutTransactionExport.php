<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use App\PayoutTransaction;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PayoutTransactionExport implements FromCollection, WithHeadings
{

    public function __construct(string $from, string $to, int $merchantId)
    {
        $this->from = $from;
        $this->to = $to;
        $this->merchantId = $merchantId;
    }

    public function collection()
    {
        
        return PayoutTransaction::where('merchant_id', $this->merchantId)->whereDate('created_at', '>=',$this->from)->whereDate('created_at', '<=',$this->to)->select('reference_id', 'utr', 'transfer_id', 'ben_id', 'ben_name', 'ben_phone', 'ben_email', 'ben_ifsc', 'ben_bank_acc', 'amount', 'transfer_mode', 'status', 'remarks', 'created_at')->get();
    }


    public function headings(): array
    {
        return [
            'reference_id', 'utr', 'transfer_id', 'ben_id', 'ben_name', 'ben_phone', 'ben_email', 'ben_ifsc', 'ben_bank_acc', 'amount', 'transfer_mode', 'status', 'remark', 'created_at'
        ];
    }
}
