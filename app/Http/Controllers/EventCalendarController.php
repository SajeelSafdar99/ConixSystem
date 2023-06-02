<?php

namespace App\Http\Controllers;

use App\event_venue;
use Illuminate\Http\Request;
use App\event_booking;

use App\bookingcalender;
use Calendar;
use App\room_booking;
use DataTables;
use App\room;
use App\room_type;
use App\room_charges_type;
use App\room_category;
use App\room_category_charges;
use Session;
use App\bookingsub;
use DB;

class EventCalendarController extends Controller
{
     public function index(Request $request)
    {

        $data = event_booking::all();


$rooms=event_venue::select('code','desc','id')->get()->toArray() ;

foreach ($rooms as  $key =>$room){
    $rooms[$key]['name']=''.$room['desc'];
    $rooms[$key]['id']='R'.$room['id'];

    unset($rooms[$key]['code']);
    }
//dd($rooms);
foreach($data as $key=> $x){
//    $data[$key]['check_in_date']=str_replace('/','-',$x->event_date.' '.$x->from);
    $data[$key]['check_in_date']=date('Y-m-d h:i:s a',strtotime($x->event_date.' '.$x->from));
    $data[$key]['check_out_date']=date('Y-m-d h:i:s a',strtotime($x->event_date.' '.$x->to));
}
$month='';
    if($request->get('month')){
        $month=$request->get('month');
    }
    $year='';
    if($request->get('year')){
        $year=$request->get('year');
    }

    return view('backend/events-management/event-calendar/event-calendar')->withRooms($rooms)->withBooking($data)->withMonth($month)->withYear($year);
    }
}
