<?php

namespace App\Http\Controllers;

use App\bookingcalender;
use Illuminate\Http\Request;
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

use App\hr_employment;
use App\hr_department;
use App\coa_account;
use App\hr_sub_department;

class BookingcalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function calendar_vue(Request $request, hr_employment $hr_employment)
    {
       return view('backend/room-management/room-calender/calendar-vue');
    }

       public function calendar_init_vue(Request $request)
    {
        $data=[];
 $employees=room::select('code','room_no','id');
        $count=0;
  

   
    $data['employees']= $employees->with('visits')->get();

     return $data;
}




    public function index(Request $request)
    {







        $data = room_booking::all();




$rooms=room::select('code','room_no','id')->get();
foreach ($rooms as  $key =>$room){
    $rooms[$key]['name']='Room no: '.$room->room_no;
    $rooms[$key]['id']='R'.$room->id;
    unset($rooms[$key]['room_no']);
    unset($rooms[$key]['code']);
    }
foreach($data as $key=> $x){
    $data[$key]['check_in_date']=str_replace('/','-',$x->check_in_date);
    $data[$key]['check_in_date']=date('Y-m-d',strtotime($x->check_in_date));
    $data[$key]['check_out_date']=date('Y-m-d',strtotime($x->check_out_date));
}
$month='';
    if($request->get('month')){
        $month=$request->get('month');
    }
    $year='';
    if($request->get('year')){
        $year=$request->get('year');
    }
    //dd($data->toArray());
    return view('backend/room-management/room-calender/calender')->withRooms($rooms)->withBooking($data)->withMonth($month)->withYear($year);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(room_booking $room_booking,Request $request)
    {
        $id=$request->segment(4);
         $data['roombooking']=room_booking::where('id',$id)->first();
 $data['room']=room::with('roomtypes')->get();
        $data['roomtype']=$data['room'];
         $data['room_category']=room_category::get();
         $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];

    $data['room_charges_type']=room_charges_type::get();
        return view('backend/room-management.room-calender.calender-aeu',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bookingcalender  $bookingcalender
     * @return \Illuminate\Http\Response
     */
    public function show(bookingcalender $bookingcalender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bookingcalender  $bookingcalender
     * @return \Illuminate\Http\Response
     */
    public function edit(bookingcalender $bookingcalender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bookingcalender  $bookingcalender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bookingcalender $bookingcalender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bookingcalender  $bookingcalender
     * @return \Illuminate\Http\Response
     */
    public function destroy(bookingcalender $bookingcalender)
    {
        //
    }
}
