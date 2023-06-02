<?php

namespace App\Http\Controllers;

use App\room_ledger;
use App\room_booking;
use App\membership;
use App\room;
use App\room_type;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\View;
use Session;
use App\customer;
use App\room_payment_receipt;
use DB;

class RoomLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request, room_ledger $room_ledger)
    {
        $data['ledgerstatus']   = 0;

        $bookings=room_booking::where('check_out_status', 1);
        $room_payment_receipt=room_payment_receipt::where('deleted_at');
        if($request->get('start_date')){

            $bookings->where('check_out_date','>=',formatDate($request->get('start_date')));
            $room_payment_receipt->where('invoice_date','>=',formatDate($request->get('start_date')));

        }
        if($request->get('end_date')){
            $bookings->where('check_out_date','<=',formatDate($request->get('end_date')));
            $room_payment_receipt->where('invoice_date','<=',formatDate($request->get('end_date')));
        }
        if($request->get('booking_no')){
        $room_payment_receipt->where('id','=',0);

        $bookings->where('booking_no','=',$request->get('booking_no'));
        }
        if($request->get('receipt')){
        $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);

        }
        if($request->get('customer')){

            $x=$request->get('customer');
//            $bookings->whereRaw("moc_name = '$x'");
//        $room_payment_receipt->where("guest_name",$x);
        }

            if($request->get('mog')==1){
                $room_payment_receipt->where('mem_number',$request->get('mog_id'));
                $bookings->where('member_id',$request->get('mog_id'));
            }
            else{
                $room_payment_receipt->where('customer_id',$request->get('mog_id'));
                $bookings->where('customer_id',$request->get('mog_id'));

            }


        $data['bookingdata']=$bookings->get();
      // dd($data['bookingdata']);
        $data['receiptdata']=$room_payment_receipt->get();
//        $data['receiptdata']=[];
        $data['customers']=customer::orderBy('customer_name', 'asc')->get();
        
         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');

         $data['booking_no']=$request->get('booking_no');
         $data['receipt']=$request->get('receipt');
         $data['mog_id']=$request->get('mog_id');
        if($request->get('start_date')) {
            $oBooking=room_booking::where('check_out_status', 1)->where('check_out_date','<',formatDate($request->get('start_date')));
            $oReceipt=room_payment_receipt::where('invoice_date','<',formatDate($request->get('start_date')));

                if($request->get('mog')==0){
                    $oReceipt->where('mem_number',$request->get('mog_id'));
                    $oBooking->where('member_id',$request->get('mog_id'));
                }
                else{
                    $oReceipt->where('customer_id',$request->get('mog_id'));
                    $oBooking->where('customer_id',$request->get('mog_id'));

                }


//            if($request->get('customer')){
//
//                $x=$request->get('customer');
//                $oBooking->whereRaw("moc_name = '$x'");
//                $oReceipt->where("guest_name",$x);
//            }


            $oBalance=$oReceipt->get()->sum('total')-$oBooking->get()->sum('grand_total');
            $data['openingBalance']=$oBalance;

        }

         return view('backend/room-management/room-ledgers/room-ledgers',$data);
    }

    public function print(Request $request, room_ledger $room_ledger)
    {
        $bookings=room_booking::where('check_out_status', 1);
        $room_payment_receipt=room_payment_receipt::where('deleted_at');
        if($request->get('start_date')){

            $bookings->where('check_out_date','>=',formatDate($request->get('start_date')));
            $room_payment_receipt->where('invoice_date','>=',formatDate($request->get('start_date')));

        }
        if($request->get('end_date')){
            $bookings->where('check_out_date','<=',formatDate($request->get('end_date')));
            $room_payment_receipt->where('invoice_date','<=',formatDate($request->get('end_date')));
        }if($request->get('booking_no')){
        $room_payment_receipt->where('id','=',0);

        $bookings->where('booking_no','=',$request->get('booking_no'));
    }
        if($request->get('receipt')){
            $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);

        }if($request->get('customer')){

        $x=$request->get('customer');
        $bookings->whereRaw("moc_name = '$x'");
        $room_payment_receipt->where("guest_name",$x);
    }
        $data['bookingdata']=$bookings->get();
        // dd($data['bookingdata']);
        $data['receiptdata']=$room_payment_receipt->get();
//        $data['receiptdata']=[];
        $data['customers']=customer::orderBy('customer_name', 'asc')->get();
        $data['ledgerstatus']   = 0;
        $data['customer']=$request->get('customer');
        $data['start_date']=$request->get('start_date');
        $data['end_date']=$request->get('end_date');

        $data['booking_no']=$request->get('booking_no');
        $data['receipt']=$request->get('receipt');




        $view=View::make('backend/room-management/room-ledgers/room-ledgers',$data)->renderSections()['page-content'];
        return $view;

    }
      public function index_finance(Request $request, room_ledger $room_ledger)
    {
        $data['ledgerstatus']   = 1;

        $bookings=room_booking::where('check_out_status', 1);
        $room_payment_receipt=room_payment_receipt::where('deleted_at');
        if($request->get('start_date')){

            $bookings->where('check_out_date','>=',formatDate($request->get('start_date')));
            $room_payment_receipt->where('invoice_date','>=',formatDate($request->get('start_date')));

        }
        if($request->get('end_date')){
            $bookings->where('check_out_date','<=',formatDate($request->get('end_date')));
            $room_payment_receipt->where('invoice_date','<=',formatDate($request->get('end_date')));
        }
        if($request->get('booking_no')){
        $room_payment_receipt->where('id','=',0);

        $bookings->where('booking_no','=',$request->get('booking_no'));
        }
        if($request->get('receipt')){
        $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);

        }
        if($request->get('customer')){

            $x=$request->get('customer');
//            $bookings->whereRaw("moc_name = '$x'");
//        $room_payment_receipt->where("guest_name",$x);
        }

            if($request->get('mog')==1){
                $room_payment_receipt->where('mem_number',$request->get('mog_id'));
                $bookings->where('member_id',$request->get('mog_id'));
            }
            else{
                $room_payment_receipt->where('customer_id',$request->get('mog_id'));
                $bookings->where('customer_id',$request->get('mog_id'));

            }


        $data['bookingdata']=$bookings->get();
      // dd($data['bookingdata']);
        $data['receiptdata']=$room_payment_receipt->get();
//        $data['receiptdata']=[];
        $data['customers']=customer::orderBy('customer_name', 'asc')->get();
        
         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');

         $data['booking_no']=$request->get('booking_no');
         $data['receipt']=$request->get('receipt');
         $data['mog_id']=$request->get('mog_id');
        if($request->get('start_date')) {
            $oBooking=room_booking::where('check_out_status', 1)->where('check_out_date','<',formatDate($request->get('start_date')));
            $oReceipt=room_payment_receipt::where('invoice_date','<',formatDate($request->get('start_date')));

                if($request->get('mog')==0){
                    $oReceipt->where('mem_number',$request->get('mog_id'));
                    $oBooking->where('member_id',$request->get('mog_id'));
                }
                else{
                    $oReceipt->where('customer_id',$request->get('mog_id'));
                    $oBooking->where('customer_id',$request->get('mog_id'));

                }


//            if($request->get('customer')){
//
//                $x=$request->get('customer');
//                $oBooking->whereRaw("moc_name = '$x'");
//                $oReceipt->where("guest_name",$x);
//            }


            $oBalance=$oReceipt->get()->sum('total')-$oBooking->get()->sum('grand_total');
            $data['openingBalance']=$oBalance;

        }

         return view('backend/room-management/room-ledgers/room-ledgers',$data);
    }

   /*  public function indexdt(Request $request, room_booking $room_booking)
    {


        //$bookings = room_booking::get();
    $bookings=DB::table('room_bookings')->LeftJoin('room_payment_receipts','room_payment_receipts.booking_id','=','room_bookings.id')
            ->get();
            //dd($bookings);
        return DataTables::of($bookings)

             ->addColumn('room', function ($bookings) {
              return roomtypename($bookings->room).- roomno($bookings->room) ;
                })
              ->addColumn('debit', function ($bookings) {
              return 0;


                })
               ->addColumn('receipt_credit', function ($bookings) {
              return 0;


                })


              ->addColumn('booking', function ($bookings) {
              return "Booking";


                })
              ->addColumn('receipt', function ($bookings) {
              return "Receipt";


                })




               ->addColumn('button', function ($bookings) {
                return '<a target="_blank" href="' . url('room-management/room-invoice/') . '/' . $bookings->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Print Voucher">Print</button></a>'
                ;

            })
                ->addColumn('receipt_button', function ($bookings) {
                return '<a target="_blank" href="' . url('room-management/room-payment-receipts/room-payment-receipts-invoice/') . '/' . $bookings->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Print Voucher">Print</button></a>'
                ;

            })


            ->rawColumns(['customer','button', 'room_booking', 'room_payment_receipt'])
            ->addIndexColumn()
            ->make(true);
    }*/



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastval = room_ledger::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }

         $data['customer']=customer::get();

        return view('backend/room-management.room-ledgers.room-ledgers', $data);
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
     * @param  \App\room_ledger  $room_ledger
     * @return \Illuminate\Http\Response
     */
    public function show(room_ledger $room_ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_ledger  $room_ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(room_ledger $room_ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_ledger  $room_ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, room_ledger $room_ledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_ledger  $room_ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(room_ledger $room_ledger)
    {
        //
    }
}
