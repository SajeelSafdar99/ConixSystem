<?php


namespace App\exports;

use App\crm_lead;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CrmLeadDown implements FromView
{
    public function view(): View
    {
         $request=Request::capture();
            $columns=$request->get('columns');
            $data=crm_lead::select(($columns))->get();
        return view('exports/leads', [
            'data' => $data,
            'columns' => $columns,

        ]);
    }
}
