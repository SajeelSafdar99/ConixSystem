<?php


namespace App\exports;
use App\customer;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerDown implements FromView
{
    public function view(): View
    {
         $request=Request::capture();
            $columns=$request->get('columns');
            $data=customer::select(($columns))->get();
        return view('exports/customer', [
            'data' => $data,
            'columns' => $columns,

        ]);
    }
}
