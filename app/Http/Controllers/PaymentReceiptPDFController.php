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
use PDF;

class PaymentReceiptPDFController extends Controller
{
 public function pdfinvoice($id)
    {

      $data['receiptdata']=room_payment_receipt::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();
           $rid=$data['receiptdata']->payment_received_for;
         $data['finance_payment_receivable']=finance_payment_receivable::where('id',$rid)->first(); 
         $rid=$data['receiptdata']->payment_method;
         $data['finance_payment_methods']=finance_payment_methods::where('id',$rid)->first(); 

    //return view('backend.pdf.roombooking-invoice',$data);
	$pdf = PDF::loadView('backend.pdf.paymentreceipt-invoice', $data);
   
	return $pdf->stream('invoice.pdf');

    }
}
