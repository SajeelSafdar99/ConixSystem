<?php

namespace App\Http\Controllers;

use App\finance_invoice;
use App\room_payment_receipt;
use Illuminate\Http\Request;
use DataTables;
use App\sports_subscription;
use App\finance_payment_receivable;
use App\customer;
use App\finance_payment_methods;
use App\membership;
use App\mem_family;
use App\mem_address;
use App\payment_receipts_sub;
use App\admin_company_profile;
use Illuminate\Support\Facades\Auth;
use Session;

class RoomPaymentReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room_payment_receipt $room_payment_receipt)
    {
        $data['receiptstatus']   = 0;
        return view('backend/room-management/room-payment-receipts/room-payment-receipts', $data);
    }

     public function index_finance(Request $request, room_payment_receipt $room_payment_receipt)
    {
        $data['receiptstatus']   = 1;
        return view('backend/room-management/room-payment-receipts/room-payment-receipts', $data);
    }

     public function index_events(Request $request, room_payment_receipt $room_payment_receipt)
    {
        $data['receiptstatus']   = 2;
        return view('backend/room-management/room-payment-receipts/room-payment-receipts', $data);
    }


     public function indexdt(Request $request, room_payment_receipt $room_payment_receipt)
    {
        $r=room_payment_receipt::where('deleted_at');
        if($request->get('mog')==0){
            if($request->get('customer')){
                $x=$request->get('customer');

//                $c=membership::where('applicant_name','like',"%$x%")->first();
                $r=membership::find($x)->receipts();

            }
        }
        else{
            if($request->get('customer')){
            $x=$request->get('customer');

//            $c=customer::where('customer_name','like',"%$x%")->first();
            $r=customer::find($x)->receipts();

        }

        }

        if($request->get('start_date')){
            $r->where('invoice_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('invoice_date','<=',formatDate($request->get('end_date')));

        }
        if($request->get('receipt')){
            $r->where('invoice_no','=',$request->get('receipt'));

        }

        $reID=[];
        foreach(finance_payment_receivable::all() as $rs){

        if(Auth::user()->can($rs->desc.' '.$rs->id)){

        $reID[]=$rs->id;

        }
        }
        $receipts = $r->whereIn('payment_received_for',$reID)->get();

//        $receipts = $r->orWwhere('payment_received_for',0)->get();

        $data= DataTables::of($receipts)


            ->addColumn('editbutton', function ($receipts) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-payment-receipts/room-payment-receipts-aeu/') . '/' . $receipts->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

            ->addColumn('editfinancebutton', function ($receipts) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/payment-receipts/payment-receipts-aeu/') . '/' . $receipts->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('editeventbutton', function ($receipts) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/payment-receipts/payment-receipts-aeu/') . '/' . $receipts->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

            ->addColumn('deletebutton', function ($receipts) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-payment-receipts/delete') . '/' . $receipts->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
             ->addColumn('deleteeventbutton', function ($receipts) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/payment-receipts/delete') . '/' . $receipts->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
              ->addColumn('deletefinancebutton', function ($receipts) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/payment-receipts/delete') . '/' . $receipts->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


            ->addColumn('type', function ($receipts) {
                if($receipts->receipt_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })

              ->addColumn('payment_received_for', function ($receipts) {
              return paymentreceivedfor($receipts->payment_received_for);


                }) ->addColumn('payment_details', function ($receipts) {
              return $receipts->payment_details ;


                })
//            ->addColumn('dtotal', function ($r) {
//                $request=Request::capture();
//                $r=room_payment_receipt::where('deleted_at');
//                if($request->get('mog')==0){
//                    if($request->get('customer')){
//                        $x=$request->get('customer');
//
////                        $c=membership::where('applicant_name','like',"%$x%")->first();
//                        $r=membership::find($x)->receipts();
//
//                    }
//                }
//                else{
//                    if($request->get('customer')){
//                        $x=$request->get('customer');
//
////                        $c=customer::where('customer_name','like',"%$x%")->first();
//                        $r=customer::find($x)->receipts();
//
//                    }
//
//                }
//                if($request->get('start_date')){
//                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
//                }
//                if($request->get('end_date')){
//                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));
//
//                }
//                if($request->get('receipt')){
//                    $r->where('invoice_no','=',$request->get('receipt'));
//
//                }
//              return number_format( $r->where('payment_received_for',2)->sum('total_amount')) ;
//
//
//                })
//            ->addColumn('ctotal', function ($receipts) {
//                $request=Request::capture();
//                $r=room_payment_receipt::where('deleted_at');
//                if($request->get('mog')==0){
//                    if($request->get('customer')){
//                        $x=$request->get('customer');
//
////                        $c=membership::where('applicant_name','like',"%$x%")->first();
//                        $r=membership::find($x)->receipts();
//
//                    }
//                }
//                else{
//                    if($request->get('customer')){
//                        $x=$request->get('customer');
//
////                        $c=customer::where('customer_name','like',"%$x%")->first();
//                        $r=customer::find($x)->receipts();
//
//                    }
//
//                }
//                if($request->get('start_date')){
//                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
//                }
//                if($request->get('end_date')){
//                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));
//
//                }
//                if($request->get('receipt')){
//                    $r->where('invoice_no','=',$request->get('receipt'));
//
//                }
//                return number_format( $r->where('payment_received_for',2)->count('id')) ;
//
//
//                })

               ->addColumn('invoice_date', function ($receipts) {
              return formatDateToShow($receipts->invoice_date);


                }) ->addColumn('payment_details', function ($receipts) {
              return wordwrap($receipts->payment_details,40,"\n");


                }) ->addColumn('customer_id', function ($receipts) {
                if($receipts->receipt_type==1){
                return    $receipts->customer_id;
                }
                else{
            //        return "Member";
              if($receipts->member){
                  return $receipts->member->mem_no;
              }
                }
          //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


                })

             ->addColumn('status', function ($receipts) {
                 return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-payment-receipts/room-payment-receipts-invoice/') . '/' . $receipts->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

             ->addColumn('status_finance', function ($receipts) {
                 return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-payment-receipts/finance-payment-receipts-invoice/') . '/' . $receipts->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

             ->addColumn('status_events', function ($receipts) {
                 return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('events-management/events-payment-receipts/events-payment-receipts-invoice/') . '/' . $receipts->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

            ->rawColumns(['editbutton', 'editfinancebutton', 'editeventbutton', 'deletebutton', 'sports_subscription','payment_receipts_sub', 'finance_payment_receivable', 'status', 'status_finance', 'status_events', 'customer', 'membership', 'mem_address', 'admin_company_profile', 'finance_payment_methods', 'mem_family','deleteeventbutton', 'deletefinancebutton'])
             ->addIndexColumn()
            ->make(true)->getData(true);
        $data['cTotal']=number_format($receipts->count('id'));
        $data['dTotal']=number_format($receipts->sum('total_amount'));
        return $data;
    }


     public function index_deleted(Request $request, room_payment_receipt $room_payment_receipt)
    {
       $data['receiptstatus']   = 0;
        return view('backend/room-management/room-payment-receipts/room-payment-receipts-deleted',$data);
    }


     public function index_deleted_finance(Request $request, room_payment_receipt $room_payment_receipt)
    {
       $data['receiptstatus']   = 1;
        return view('backend/room-management/room-payment-receipts/room-payment-receipts-deleted',$data);
    }

    public function index_deleted_events(Request $request, room_payment_receipt $room_payment_receipt)
    {
       $data['receiptstatus']   = 2;
        return view('backend/room-management/room-payment-receipts/room-payment-receipts-deleted',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, room_payment_receipt $room_payment_receipt)
    {

        $receipts = room_payment_receipt::onlyTrashed()->get();
        return DataTables::of($receipts)


          ->addColumn('type', function ($receipts) {
                if($receipts->receipt_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })

              ->addColumn('payment_received_for', function ($receipts) {
              return paymentreceivedfor($receipts->payment_received_for);


                }) ->addColumn('payment_details', function ($receipts) {
              return $receipts->payment_details ;


                })->addColumn('dtotal', function ($r) {
                $request=Request::capture();
                $r=room_payment_receipt::where('deleted_at');
                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

//                        $c=membership::where('applicant_name','like',"%$x%")->first();
                        $r=membership::find($x)->receipts();

                    }
                }
                else{
                    if($request->get('customer')){
                        $x=$request->get('customer');

//                        $c=customer::where('customer_name','like',"%$x%")->first();
                        $r=customer::find($x)->receipts();

                    }

                }
                if($request->get('start_date')){
                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('receipt')){
                    $r->where('invoice_no','=',$request->get('receipt'));

                }
              return number_format( $r->where('payment_received_for',2)->sum('total_amount')) ;


                })->addColumn('ctotal', function ($receipts) {
                $request=Request::capture();
                $r=room_payment_receipt::where('deleted_at');
                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

//                        $c=membership::where('applicant_name','like',"%$x%")->first();
                        $r=membership::find($x)->receipts();

                    }
                }
                else{
                    if($request->get('customer')){
                        $x=$request->get('customer');

//                        $c=customer::where('customer_name','like',"%$x%")->first();
                        $r=customer::find($x)->receipts();

                    }

                }
                if($request->get('start_date')){
                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('receipt')){
                    $r->where('invoice_no','=',$request->get('receipt'));

                }
                return number_format( $r->where('payment_received_for',2)->count('id')) ;


                })

               ->addColumn('invoice_date', function ($receipts) {
              return formatDateToShow($receipts->invoice_date);


                }) ->addColumn('payment_details', function ($receipts) {
              return wordwrap($receipts->payment_details,40,"\n");


                }) ->addColumn('customer_id', function ($receipts) {
                if($receipts->receipt_type==1){
                return    $receipts->customer_id;
                }
                else{
            //        return "Member";
              if($receipts->member){
                  return $receipts->member->mem_no;
              }
                }
          //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


                })

            ->addColumn('restorebutton', function ($receipts) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room-payment-receipts/restore/') . '/' . $receipts->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })
            
            ->addColumn('restoreeventbutton', function ($receipts) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/payment-receipts/restore/') . '/' . $receipts->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->addColumn('restorefinancebutton', function ($receipts) {
             return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/payment-receipts/restore/') . '/' . $receipts->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })


        ->rawColumns(['restorebutton', 'restoreeventbutton', 'restorefinancebutton'])
        ->addIndexColumn()
        ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        dd(123);

        $lastval = room_payment_receipt::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['payment_update'] = '';

         $data['sports_subscription']=sports_subscription::get();
         $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();

 $data['receiptstatus']   = 0;
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
 $data['profiledata']=admin_company_profile::get()->first();

  $customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
        if($request->get('invoice_no')){
            $invoice=finance_invoice::find($request->get('invoice_no'));
            $data['invoice']=$invoice;
        }

        return view('backend/room-management.room-payment-receipts.room-payment-receipts-aeu', $data);
    }

    public function create_finance(Request $request)
    {
        $lastval = room_payment_receipt::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['payment_update'] = '';

         $data['sports_subscription']=sports_subscription::get();
         $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();
 $data['receiptstatus']   = 1;
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
 $data['profiledata']=admin_company_profile::get()->first();

 $customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
        return view('backend/room-management.room-payment-receipts.room-payment-receipts-aeu', $data);
    }

    public function create_events(Request $request)
    {
        $lastval = room_payment_receipt::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['payment_update'] = '';

         $data['sports_subscription']=sports_subscription::get();
         $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();
 $data['receiptstatus']   = 2;
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
 $data['profiledata']=admin_company_profile::get()->first();

 $customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
        return view('backend/room-management.room-payment-receipts.room-payment-receipts-aeu', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save=$request->save;
        $getlastinsert=0;
        $this->validate($request, [

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            //'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


         'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);

        $receipts = room_payment_receipt::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
             'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks

        ]);


/*
         $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new payment_receipts_sub;
            $ta->payment_receipt_id = $receipts->id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->save();
            $i++;
        }*/

        if ($receipts) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$receipts->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('room-management/room-payment-receipts/room-payment-receipts-invoice/'.$getlastinsert);
            }else{
                return redirect('room-management/room-payment-receipts');
            }


    }

public function store_events(Request $request)
    {
        $save=$request->save;
        $getlastinsert=0;
        $this->validate($request, [

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            //'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


         'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);

        $receipts = room_payment_receipt::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
             'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks

        ]);


/*
         $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new payment_receipts_sub;
            $ta->payment_receipt_id = $receipts->id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->save();
            $i++;
        }*/

        if ($receipts) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$receipts->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/events-payment-receipts/events-payment-receipts-invoice/'.$getlastinsert);
            }else{
                return redirect('events-management/payment-receipts');
            }


    }

    public function store_finance(Request $request)
    {
        $save=$request->save;
        $getlastinsert=0;
        $this->validate($request, [

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            //'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


         'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);

        $receipts = room_payment_receipt::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
             'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks

        ]);


/*
         $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new payment_receipts_sub;
            $ta->payment_receipt_id = $receipts->id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->save();
            $i++;
        }*/

        if ($receipts) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$receipts->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-payment-receipts/finance-payment-receipts-invoice/'.$getlastinsert);
            }else{
                return redirect('finance-and-management/payment-receipts');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(room_payment_receipt $room_payment_receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
     public function edit(room_payment_receipt $room_payment_receipt,$id)
    {
         $data['payment_update'] = room_payment_receipt::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['payment_update']->code;

         $data['sports_subscription']=sports_subscription::get();
         $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();

$memberfmid=$data['payment_update']->mem_number;
$data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

  $data['payment_receipts_sub']=room_payment_receipt::with('subscriptions')->where('id', $id)->get();
       $data['subscriptionsdata']=$data['payment_receipts_sub'][0]['subscriptions'];
$data['profiledata']=admin_company_profile::get()->first();
$data['receiptstatus']   = 0;
$data['payment_methods']=finance_payment_methods::where('status',1)->get();
        return view('backend/room-management.room-payment-receipts.room-payment-receipts-aeu', $data);
    }



public function edit_finance(room_payment_receipt $room_payment_receipt,$id)
    {
         $data['payment_update'] = room_payment_receipt::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['payment_update']->code;

         $data['sports_subscription']=sports_subscription::get();
         $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();

$memberfmid=$data['payment_update']->mem_number;
$data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

  $data['payment_receipts_sub']=room_payment_receipt::with('subscriptions')->where('id', $id)->get();
       $data['subscriptionsdata']=$data['payment_receipts_sub'][0]['subscriptions'];
$data['profiledata']=admin_company_profile::get()->first();
$data['receiptstatus']   = 1;
$data['payment_methods']=finance_payment_methods::where('status',1)->get();
        return view('backend/room-management.room-payment-receipts.room-payment-receipts-aeu', $data);
    }

public function edit_events(room_payment_receipt $room_payment_receipt,$id)
    {
         $data['payment_update'] = room_payment_receipt::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['payment_update']->code;

         $data['sports_subscription']=sports_subscription::get();
         $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();

$memberfmid=$data['payment_update']->mem_number;
$data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

  $data['payment_receipts_sub']=room_payment_receipt::with('subscriptions')->where('id', $id)->get();
       $data['subscriptionsdata']=$data['payment_receipts_sub'][0]['subscriptions'];
$data['profiledata']=admin_company_profile::get()->first();
$data['receiptstatus']   = 2;
$data['payment_methods']=finance_payment_methods::where('status',1)->get();
        return view('backend/room-management.room-payment-receipts.room-payment-receipts-aeu', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [


            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
            //'mem_number' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


     'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);
        $receipt = room_payment_receipt::where('id', $id)->updateWithUserstamps([
           'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
            'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks
        ]);


/*
   $subdelete= payment_receipts_sub::where('payment_receipt_id', $id)->delete();

if($subdelete){

    $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new payment_receipts_sub;
             $ta->payment_receipt_id=$id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->save();
            $i++;
        }
    }
         */

    if ($receipt) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-payment-receipts/room-payment-receipts-aeu/'.$id);

    }

     public function update_events(Request $request, $id)
    {
        $this->validate($request, [


            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
            //'mem_number' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


     'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);
        $receipt = room_payment_receipt::where('id', $id)->updateWithUserstamps([
           'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
            'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks
        ]);


/*
   $subdelete= payment_receipts_sub::where('payment_receipt_id', $id)->delete();

if($subdelete){

    $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new payment_receipts_sub;
             $ta->payment_receipt_id=$id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->save();
            $i++;
        }
    }
         */

    if ($receipt) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/payment-receipts/payment-receipts-aeu/'.$id);

    }

     public function update_finance(Request $request, $id)
    {
        $this->validate($request, [


            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
            //'mem_number' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


     'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);
        $receipt = room_payment_receipt::where('id', $id)->updateWithUserstamps([
           'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
            'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks
        ]);


/*
   $subdelete= payment_receipts_sub::where('payment_receipt_id', $id)->delete();

if($subdelete){

    $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new payment_receipts_sub;
             $ta->payment_receipt_id=$id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->save();
            $i++;
        }
    }
         */

    if ($receipt) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/payment-receipts/payment-receipts-aeu/'.$id);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(room_payment_receipt $room_payment_receipt,$id)
    {
        $recipt=$room_payment_receipt::where('id', $id)->deleteWithUserstamps();
        if($recipt){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('room-management/room-payment-receipts');
    }

    public function destroy_events(room_payment_receipt $room_payment_receipt,$id)
    {
        $recipt=$room_payment_receipt::where('id', $id)->deleteWithUserstamps();
        if($recipt){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('events-management/payment-receipts');
    }

    public function destroy_finance(room_payment_receipt $room_payment_receipt,$id)
    {
        $recipt=$room_payment_receipt::where('id', $id)->deleteWithUserstamps();
        if($recipt){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/payment-receipts');
    }




     function calculateextracharges($id){
      $charges=sports_subscription::where('id',$id)->first();
      return $charges->charges;
    }


public function restore(room_payment_receipt $room_payment_receipt,$id)
    {
        $restore = room_payment_receipt::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room-payment-receipts/deleted');

}
public function restore_finance(room_payment_receipt $room_payment_receipt,$id)
    {
        $restore = room_payment_receipt::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/payment-receipts/deleted');

}
public function restore_events(room_payment_receipt $room_payment_receipt,$id)
    {
        $restore = room_payment_receipt::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/payment-receipts/deleted');

}

}
