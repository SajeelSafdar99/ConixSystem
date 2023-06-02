<?php


namespace App\exports;


use App\customer;
use App\membership;
use App\room_booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class occupancy implements FromView
{
    public function view(): View
    {
        $request=Request::capture();
        $r = room_booking::where('check_out_status', 1);
        if($request->get('mog')==0){
            if($request->get('customer')){
                $x=$request->get('customer');

                $c=membership::where('applicant_name','like',"%$x%")->first();
                $r=membership::find($c->id)->bookings();

            }
        }
        else{
            if($request->get('customer')){
                $x=$request->get('customer');

                $c=customer::where('customer_name','like',"%$x%")->first();
                $r=customer::find($c->id)->bookings();

            }

        }

        if($request->get('start_date')){
            $r->where('check_out_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('check_out_date','<=',formatDate($request->get('end_date')));

        }
        if($request->get('receipt')){
            $r->where('booking_no','=',$request->get('receipt'));

        }
        if($request->get('sort') && $request->get('direction')){
//            $r->orderBy($request->get('sort') ,$request->get('direction'));

        }
        if($request->get('room')){
//            dd($request->get('room'));
            if($request->get('room')!="null"){

                $r->where('room',($request->get('room')));
            }
        } if($request->get('cType')){
//            dd($request->get('room'));
        if($request->get('cType')!="null"){
            $cType=$request->get('cType');
            $r->whereHas('bookings',function($query) use ($cType){
                return  $query->where('charges_type_id',$cType);
            });
        }
    }
        $room_bookings=$r->with('bookings')->get();
//       $b= $room_bookings[0]->bookings;
//        $b=$b->keyBy('charges_type_id');
//dd($b->toArray());
        return view('exports/occupancy', [
            'data' => $room_bookings,
            'start_date'=>$request->get('start_date'),
            'end_date'=>$request->get('end_date'),
        ]);
    }
}
