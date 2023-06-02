<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use App\room_invoice;
use App\room_booking;
use DataTables;
use App\room;
use App\room_type;
use App\bookingsub;
use App\room_category;
use App\room_category_charges;
use App\room_charges_type;
use App\admin_company_profile;

class PdfController extends Controller
{
    public function pdfinvoice($id)
    {

    	$data['roombooking']=room_booking::where('id',$id)->first();

         $data['profiledata']=admin_company_profile::get()->first();
         $roomid=$data['roombooking']->room;
         $categoryid=$data['roombooking']->category;
    $data['room']=room::with('roomtypes')->where('id',$roomid)->first();
        $data['roomtype']=$data['room'];
        

         $data['room_category']=room_category::where('id',$categoryid)->first();

       $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
     
    $data['room_charges_type']=room_charges_type::get();


    //return view('backend.pdf.roombooking-invoice',$data);
	$pdf = PDF::loadView('backend.pdf.roombooking-invoice', $data);
   
	return $pdf->stream('invoice.pdf');

    }

    public function pdfinvoicetwo($id)
    {

        $data['roombooking']=room_booking::where('id',$id)->first();

         $data['profiledata']=admin_company_profile::get()->first();
         $roomid=$data['roombooking']->room;
         $categoryid=$data['roombooking']->category;
    $data['room']=room::with('roomtypes')->where('id',$roomid)->first();
        $data['roomtype']=$data['room'];
        

         $data['room_category']=room_category::where('id',$categoryid)->first();

       $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
     
    $data['room_charges_type']=room_charges_type::get();


    //return view('backend.pdf.roombooking-invoice',$data);
    $pdf = PDF::loadView('backend.pdf.roomcheckout-invoice', $data);
   
    return $pdf->stream('invoice.pdf');

    }
}
