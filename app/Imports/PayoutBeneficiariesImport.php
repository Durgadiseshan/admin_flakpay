<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use App\PayoutContacts;
use App\PayoutBeneficiaries;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;



class PayoutBeneficiariesImport implements ToCollection,  WithHeadingRow, WithColumnFormatting
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function  __construct($user_id)
    {
        $this->user = $user_id;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            //creating beneficiary id
            $max_id = PayoutBeneficiaries::max('id');

            $beneficiary_id = "";
            if ($max_id === null) {
                $beneficiary_id = 'BEN1001';
            } else {
                $getmaxBenid = PayoutBeneficiaries::where('id', $max_id)->first();
                // $createBenid = substr($max_id->beneficiary_id, 4);
                preg_match_all('!\d+!', $getmaxBenid->beneficiary_id, $createBenid);
                $converttonumber = (int)$createBenid[0][0];
                $increment = $converttonumber + 1;
                $beneficiary_id = "BEN" . $increment;
            }
            //end

            //handlingmobilenumber
            $mobile = strval($row['mobile']);
            //end

            $check = PayoutContacts::where('mobile', $mobile)->first();

            if ($check != null) {

                $insert = PayoutBeneficiaries::create([
                    "beneficiary_id" => $beneficiary_id,
                    "upi_id" => $row['upi_id'],
                    "account_number" => $row['account_no'],
                    "ifsc_code" => $row['ifsc_code'],
                    "group_id" =>  null,
                    "contact_id" => $check->id,
                    "merchant_id" => $this->user
                ]);
            } else {




                $newContacts = PayoutContacts::create([
                    'name' => $row['name'],
                    'mobile' => $row['mobile'],
                    'contact' => $row['contact'],
                    'address' => $row['address'],
                    'state' => $row['state'],
                    'pincode' => $row['pincode'],
                    'merchant_id' => $this->user

                ]);



                $insert = PayoutBeneficiaries::create([
                    "beneficiary_id" => $beneficiary_id,
                    "upi_id" => $row['upi_id'],
                    "account_number" => $row['account_no'],
                    "ifsc_code" => $row['ifsc_code'],
                    "group_id" =>  null,
                    "contact_id" => $newContacts->id,
                    "merchant_id" => $this->user
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }


    public function columnFormats(): array
    {
        return [
            'mobile' => NumberFormat::FORMAT_TEXT

        ];
    }
}
