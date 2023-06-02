<?php

namespace App\Imports;

use App\crm_lead;
use App\employment_in_out;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BulkImport3 implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
//       dd();
        return new employment_in_out([
            //
            "employee_id"=>$row[0],
            "in"=>Date::excelToDateTimeObject($row[1]),
            "out"=>Date::excelToDateTimeObject($row[2]),

        ]);
    }
}
