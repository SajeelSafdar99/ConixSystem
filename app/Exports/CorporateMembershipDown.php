<?php


namespace App\exports;
use App\customer;
use App\corporateMembership;
use App\room_booking;
use App\room_charges_type;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CorporateMembershipDown implements FromView
{
    public function view(): View
    {
         $request=Request::capture();
            $columns=$request->get('columns');
            $data=corporateMembership::select(($columns))->get();
        return view('exports/corporate-membership', [
            'data' => $data,
            'columns' => $columns,

        ]);
    }
}
