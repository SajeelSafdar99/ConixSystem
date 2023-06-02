<?php
 
namespace App\Http\Controllers;

use App\room_invoice;
use App\room_booking;
use DataTables;
use App\room;
use App\room_type;
use App\room_charges_type;
use Illuminate\Http\Request;
use App\room_category;
use App\room_category_charges;
use Session;
use App\bookingsub;
use App\admin_company_profile;
use DB; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\trans_relations;
use App\transactions;

class RoomInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room_invoice $room_invoice)
    {
        return view('backend/room-management/room-invoice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\room_invoice  $room_invoice
     * @return \Illuminate\Http\Response
     */
    public function show(room_invoice $room_invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_invoice  $room_invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(room_booking $room_booking,$id)
    {

         $data['roombooking']=room_booking::where('id',$id)->first();
        
        if($data['roombooking']->check_out_status==0){
            if(Auth::user()->can('Print Check Out Invoice')) abort(404);

        }


         $roomid=$data['roombooking']->room;
         $categoryid=$data['roombooking']->category;
    $data['room']=room::with('roomtypes')->where('id',$roomid)->first();
        $data['roomtype']=$data['room'];
        

         $data['room_category']=room_category::where('id',$categoryid)->first();

           $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
     
    $data['room_charges_type']=room_charges_type::get();
        $data['profiledata']=admin_company_profile::get()->first();

        $s=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$data['roombooking']->id)->get()->pluck('id');
        $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
        $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }

 $data['amount_paid'] = $x;
           $data['resultant'] = $data['roombooking']->grand_total-$x;
           //dd( $data['resultant']);
        
        return view('backend/room-management.room-invoice', $data);
    } 


     public function edit_booking(room_booking $room_booking,$id)
    {
        
         $data['roombooking']=room_booking::where('id',$id)->first();

    if($data['roombooking']->check_out_status==1){
            if(Auth::user()->can('Print Booking Details')) abort(404);

        }

         $roomid=$data['roombooking']->room;
         $categoryid=$data['roombooking']->category;
    $data['room']=room::with('roomtypes')->where('id',$roomid)->first();
        $data['roomtype']=$data['room'];
        

         $data['room_category']=room_category::where('id',$categoryid)->first();

           $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
     
    $data['room_charges_type']=room_charges_type::get();
        $data['profiledata']=admin_company_profile::get()->first();

        return view('backend/room-management.room-booking-invoice', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_invoice  $room_invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, room_invoice $room_invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_invoice  $room_invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(room_invoice $room_invoice)
    {
        //
    }
}
