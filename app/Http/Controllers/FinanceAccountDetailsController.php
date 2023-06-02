<?php

namespace App\Http\Controllers;

use App\finance_account_details;
use App\membership;
use App\room_booking;
use App\room;
use App\room_type;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\View;
use Session;
use App\customer;
use App\room_payment_receipt;
use DB;

class FinanceAccountDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request, finance_account_details $finance_account_details)
   {
      $data['member']=1;
        $customer=membership::where('deleted_at');
        if($request->get('mog')==1) {

            $customer = customer::where('deleted_at');
            $data['member']=0;
            if($request->get('customer')){
                $customer->where('customer_name',$request->get('customer'));
//            $members->where('applicant_name',$request->get('customer'));
            }
        }
        else{
            $customer = membership::where('deleted_at');

            if($request->get('customer')){
                $customer->where('applicant_name',$request->get('customer'));
//            $members->where('applicant_name',$request->get('customer'));
            }
        }


         $data['accdetailstatus']   = 0;
        $limit='10000';
//        $data['customers']=$customer->orderBy('applicant_name', 'asc')->get();
        if($request->get('mog')){
            if($request->get('mog')==1){

                $data['customers']=$customer->orderBy('customer_name','asc')->limit($limit)->get();

            }
            else{
                $data['customers']=$customer->orderBy('applicant_name', 'asc')->limit($limit)->get();

            }
        }
        else{
            $data['customers']=$customer->orderBy('applicant_name', 'asc')->limit($limit)->get();

        }

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');
         $data['mog']=$request->get('mog');
//dd($data);

         return view('backend/finance-and-management/finance-account-details/finance-account-details',$data);
   }

     public function index_room(Request $request, finance_account_details $finance_account_details)
    {
        $data['member']=1;
        $customer=membership::where('deleted_at');
        if($request->get('mog')==1) {

            $customer = customer::where('deleted_at');
            $data['member']=0;
            if($request->get('customer')){
                $customer->where('customer_name',$request->get('customer'));
//            $members->where('applicant_name',$request->get('customer'));
            }
        }
        else{
            $customer = membership::where('deleted_at');

            if($request->get('customer')){
                $customer->where('applicant_name',$request->get('customer'));
//            $members->where('applicant_name',$request->get('customer'));
            }
        }


         $data['accdetailstatus']   = 1;
        $limit='10000';
//        $data['customers']=$customer->orderBy('applicant_name', 'asc')->get();
        if($request->get('mog')){
            if($request->get('mog')==1){

                $data['customers']=$customer->orderBy('id','asc')->limit($limit)->get();

            }
            else{
                $data['customers']=$customer->orderBy('id', 'asc')->limit($limit)->get();

            }
        }
        else{
            $data['customers']=$customer->orderBy('id', 'asc')->limit($limit)->get();

        }

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');
         $data['mog']=$request->get('mog');
//dd($data);

         return view('backend/finance-and-management/finance-account-details/finance-account-details',$data);
    }


     public function print(Request $request, finance_account_details $finance_account_details)
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
        $data['accdetailstatus']   = 0;
        $data['customer']=$request->get('customer');
        $data['start_date']=$request->get('start_date');
        $data['end_date']=$request->get('end_date');

        $data['booking_no']=$request->get('booking_no');
        $data['receipt']=$request->get('receipt');




        $view=View::make('backend/finance-and-management/finance-account-details/finance-account-details',$data)->renderSections()['page-content'];
        return $view;

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
     * @param  \App\finance_account_details  $finance_account_details
     * @return \Illuminate\Http\Response
     */
    public function show(finance_account_details $finance_account_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_account_details  $finance_account_details
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_account_details $finance_account_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_account_details  $finance_account_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, finance_account_details $finance_account_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_account_details  $finance_account_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_account_details $finance_account_details)
    {
        //
    }
}
