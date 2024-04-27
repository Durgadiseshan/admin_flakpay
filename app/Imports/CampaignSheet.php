<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CampaignSheet implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public $excel_data = [];

    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) 
        {
            foreach ($row as $key => $value) {
                if($value!=null)
                {
                    $import_data[$index][$key] = $value;
                }else{
                    break;
                }
            }
            
        }
        
        $this->excel_data = $import_data;
    }
}
