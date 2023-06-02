<?php

namespace App\Exports;

use App\crm_lead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BulkImport2 implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            "name",
"email",
"contact",
"designation",
"company",
"company_number",
"created_by",
        ];
    }
    public function query()
    {
        return crm_lead::query()->where('created_at',2);
        /*you can use condition in query to get required result
         return Bulk::query()->whereRaw('id > 5');*/
    }
    public function map($crm_lead): array
    {
        return [
            $crm_lead->name,
$crm_lead->email,
$crm_lead->contact,
$crm_lead->designation,
$crm_lead->company,
$crm_lead->company_number,
$crm_lead->created_by,
        ];
    }

}
