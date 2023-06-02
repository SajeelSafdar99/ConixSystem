<?php

namespace App\Imports;

use App\crm_lead;
use Maatwebsite\Excel\Concerns\ToModel;

class BulkImport2 implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
//        dd($row);
        return new crm_lead([
            //
            "name"=>$row[0],
            "email"=>$row[1],
            "contact"=>$row[2],
            "designation"=>$row[3],
            "company"=>$row[4],
            "company_number"=>$row[5],
            "status"=>1,
            "created_by"=>$row[6],
            "assigned_to"=>$row[6],
            "source"=>1,
            "lead_date"=>date('Y-m-d',time()),
        ]);
    }
}
