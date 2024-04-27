<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\PayoutContacts;


class PayoutContactsImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function  __construct($user_id)
    {
        $this->user= $user_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = PayoutContacts::create([
                'name' => $row[0],
                'mobile' => $row[1],
                'contact' => $row[2],
                'address' => $row[3],
                'state' => $row[4],
                'pincode' => $row[5],
                'merchant_id'=> $this->user

            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
