<?php

namespace App\Http\Controllers;

use App\payment_receipts_invoice;
use Illuminate\Http\Request; 
use Session;
use App\room_payment_receipt;
use App\finance_payment_receivable;
use App\finance_payment_methods;
use App\admin_company_profile;
use DataTables;
use DB; 

class PaymentReceiptsInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, payment_receipts_invoice $payment_receipts_invoice)
    {
        return view('backend/room-management/room-payment-receipts/room-payment-receipts-invoice');
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
     * @param  \App\payment_receipts_invoice  $payment_receipts_invoice
     * @return \Illuminate\Http\Response
     */
    public function show(payment_receipts_invoice $payment_receipts_invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\payment_receipts_invoice  $payment_receipts_invoice
     * @return \Illuminate\Http\Response
     */

     public function edit(room_payment_receipt $room_payment_receipt,$id)
    { 
        $data['receiptstatus']=0;
         $data['receiptdata']=room_payment_receipt::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();
           $rid=$data['receiptdata']->payment_received_for;
         $data['finance_payment_receivable']=finance_payment_receivable::where('id',$rid)->first(); 

         $rid=$data['receiptdata']->payment_method;
         $data['finance_payment_methods']=finance_payment_methods::where('id',$rid)->first(); 

        return view('backend/room-management.room-payment-receipts.room-payment-receipts-invoice', $data);
    }



     public function edit_finance(room_payment_receipt $room_payment_receipt,$id)
    { 
        $data['receiptstatus']=1;
         $data['receiptdata']=room_payment_receipt::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();
           $rid=$data['receiptdata']->payment_received_for;
         $data['finance_payment_receivable']=finance_payment_receivable::where('id',$rid)->first(); 

         $rid=$data['receiptdata']->payment_method;
         $data['finance_payment_methods']=finance_payment_methods::where('id',$rid)->first(); 

        return view('backend/room-management.room-payment-receipts.room-payment-receipts-invoice', $data);
    }

    public function edit_events(room_payment_receipt $room_payment_receipt,$id)
    { 
        $data['receiptstatus']=2;
         $data['receiptdata']=room_payment_receipt::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();
           $rid=$data['receiptdata']->payment_received_for;
         $data['finance_payment_receivable']=finance_payment_receivable::where('id',$rid)->first(); 

         $rid=$data['receiptdata']->payment_method;
         $data['finance_payment_methods']=finance_payment_methods::where('id',$rid)->first(); 

        return view('backend/room-management.room-payment-receipts.room-payment-receipts-invoice', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\payment_receipts_invoice  $payment_receipts_invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payment_receipts_invoice $payment_receipts_invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\payment_receipts_invoice  $payment_receipts_invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(payment_receipts_invoice $payment_receipts_invoice)
    {
        //
    }
}
