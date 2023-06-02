<?php

namespace App\Http\Controllers;

use App\room_check_in;
use App\room_booking;
use App\transactions;
use DataTables;
use Illuminate\Http\Request;
use App\room_type;
use App\room;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;


class RoomCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request, room_check_in $room_check_in)
    {
        return view('backend/room-management/room-check-in/room-check-in');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function indexdt(Request $request, room_booking $room_booking)
    {

        $room_bookings = room_booking::where('status',1)->whereNull('check_out_time')->get();


        return DataTables::of($room_bookings)

          ->addColumn('button', function ($room_bookings) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-booking/room-check-in-aeu/') . '/' . $room_bookings->id . '"><i class="fas fa-edit"></i></a></button>'

                //.
                //'<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-check-in/delete') . '/' . $room_checkin->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

          ->addColumn('type', function ($room_bookings) {
                if($room_bookings->booking_type==1){
                     return "Guest";
                }
                else if($room_bookings->booking_type==6){
                     return "Corporate Member";
                }
                else{
                     return "Member";
                 }


                })

           ->addColumn('room', function ($room_bookings) {
              return roomtypename($room_bookings->room).- roomno($room_bookings->room) ;


                })

           ->addColumn('name', function ($room_bookings) {
              return $room_bookings->first_name .' '. $room_bookings->last_name;

                })

             ->addColumn('booking_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->booking_date);


                })
                ->addColumn('check_in_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_in_date);


                })
            ->addColumn('customer_id', function ($room_bookings) {
                  if($room_bookings->booking_type==0){
                     return  $room_bookings->member_id?$room_bookings->member->mem_no:'';
                }
                else if($room_bookings->booking_type==6){
                     return $room_bookings->corporate_id?$room_bookings->corporateMember->mem_no:'';
                }
                else{
                     return  $room_bookings->customer_id;
                 }


              //  return $room_bookings->booking_type==0?$room_bookings->member->mem_no:$room_bookings->customer_id;


            })
                ->addColumn('check_out_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_out_date);


                })

             ->addColumn('status', function ($room_bookings) {
                return '<a target="_blank" href="' . url('room-management/room-check-out/room-check-out-aeu/') . '/' . $room_bookings->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Check-Out">Check Out</button></a>'
                ;

            })
              ->addColumn('paid', function ($room_bookings) {
              $d=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$room_bookings->id)->first();

             if($d){


                if($d->is_active==1){
                    return "<button type='button' class='btn btn-success btn-sm'>INV</button>";
                }
                else{
                    return "<button type='button' onclick='$.get(`".route('transActive',$d->id)."`,(a)=>{location.reload();})' class='btn btn-danger btn-sm'>GEN</button>";

                }

             }
             else{
                 return "123";
             }
                })

            ->rawColumns(['button', 'room_booking','status', 'paid'])
        ->addIndexColumn()
            ->make(true);
    }


    public function create(room_booking $room_booking,Request $request)
    {     $id=$request->segment(4);
         $data['roombooking']=room_booking::where('id',$id)->first();
          $data['init']                = 0;
         return view('backend/room-management.room-check-in.room-check-in-aeu',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=$request->segment(4);
         $save=$request->save;

       $this->validate($request, [
            'check_in_date' => 'required',
            'check_in_time'     => 'required'

           ]);

        $check_in = room_check_in::create([

            'check_in_date' =>  formatDate($request->check_in_date),
            'check_in_time'     =>  $request->check_in_time,
            'status' => 1,
            'booking_id'=>$id
        ]);



        if ($check_in) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }


        if(empty($save))
            {
                return redirect('room-management/room-check-in/room-check-in-aeu');
            }else{
                return redirect('room-management/room-check-in');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_check_in  $room_check_in
     * @return \Illuminate\Http\Response
     */
    public function show(room_check_in $room_check_in)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_check_in  $room_check_in
     * @return \Illuminate\Http\Response
     */

     public function edit(room_booking $room_booking,$id)
    {

         $data['roombooking'] = room_booking::where('id', $id)->first();


         $data['init']                = 1;
        $data['increment_number']    = $data['roombooking']->code;
        return view('backend/room-management.room-check-in.room-check-in-aeu', $data);
    }

      public function update_edit(Request $request, $id)
    {
        $this->validate($request, [
            'check_in_date' => 'required',
            'check_in_time'     => 'required'

        ]);

        $checkin = room_booking::where('id', $id)->updateWithUserstamps([
            'check_in_date' =>  formatDate($request->check_in_date),
            'check_in_time'     =>  $request->check_in_time,
            'status'=>1


        ]);

        if ($checkin) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-check-in');

    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_check_in  $room_check_in
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {


        $this->validate($request, [
            'check_in_date' => 'required',
            'check_in_time'     => 'required'

        ]);

        $checkin = room_booking::where('id', $id)->updateWithUserstamps([
            'check_in_date' => formatDate( $request->check_in_date),
            'check_in_time'     =>  $request->check_in_time,
            'status'=>1


        ]);

        if ($checkin) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-check-in');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_check_in  $room_check_in
     * @return \Illuminate\Http\Response
     */
     public function destroy(room_check_in $room_check_in,$id)
    {
        $checkin= $room_check_in ::where('id', $id)->delete();
        if($checkin){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('room-management/room-check-in');
    }

}
