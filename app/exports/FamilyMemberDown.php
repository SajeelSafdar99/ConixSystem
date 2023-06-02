<?php

namespace App\exports;
use App\mem_family;
use App\membership;
use App\mem_relation;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FamilyMemberDown implements FromView
{
    public function view(): View
    {
         $request=Request::capture();
            $columns=$request->get('columns');
            $data=mem_family::select(($columns))->get();
        return view('exports/familymember', [
            'data' => $data,
            'columns' => $columns,

        ]);
    }
}
