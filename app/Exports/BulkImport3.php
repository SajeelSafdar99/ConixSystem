<?php

namespace App\Exports;


use App\employment_in_out;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BulkImport3 implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            "employee_id",
            "in",
            "out",

        ];
    }

    public function query()
    {
        return employment_in_out::query()->where('created_at', 2);
        /*you can use condition in query to get required result
         return Bulk::query()->whereRaw('id > 5');*/
    }

    public function map($employment_in_out): array
    {

        return [
            $employment_in_out->employee_id,
            $employment_in_out->in,
            $employment_in_out->out,

        ];
    }

}
