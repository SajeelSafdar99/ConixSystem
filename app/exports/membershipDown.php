<?php


namespace App\exports;
use App\customer;
use App\membership;
use App\room_booking;
use App\room_charges_type;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class membershipDown implements FromView
{
    public function view(): View
    {
         $request=Request::capture();
            $columns=$request->get('columns');
            $data=membership::select(($columns))->get();
        return view('exports/membership', [
            'data' => $data,
            'columns' => $columns,

        ]);
    }
}
