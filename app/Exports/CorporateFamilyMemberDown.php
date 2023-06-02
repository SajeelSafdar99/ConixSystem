<?php

namespace App\exports;
use App\corporateMemFamily;
use App\membership;
use App\mem_relation;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CorporateFamilyMemberDown implements FromView
{
    public function view(): View
    {
         $request=Request::capture();
            $columns=$request->get('columns');
            $data=corporateMemFamily::select(($columns))->get();
        return view('exports/corporate-familymember', [
            'data' => $data,
            'columns' => $columns,

        ]);
    }
}
