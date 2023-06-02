<?php


namespace App\exports;
use App\customer;
use App\membership;
use App\room_booking;
use App\room_charges_type;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class checkouts implements FromView
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
        if($request->get('booking')){
            $r->where('booking_no','=',$request->get('booking'));

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
       $b= $room_bookings[0]->bookings;
        $b=$b->keyBy('charges_type_id');
        $charges_type=room_charges_type::orderBy('id')->get();
//        dd($room_bookings->toArray());
//        dd($b->toArray());
//dd(array_diff_key($b->toArray(),[1=>1,2=>1,9=>1,8=>1,5=>1]));
        return view('exports/checkout', [
            'data' => $room_bookings,
            'charges_type' => $charges_type,
            'start_date'=>$request->get('start_date'),
            'end_date'=>$request->get('end_date'),
            'advanced'=>$request->get('type')==2
        ]);
    }
}
