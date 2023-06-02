<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\finance_cash_flow;
use DB;
use Session;
use DataTables;
use App\room_payment_receipt;
use App\finance_expense;
use App\finance_invoice;
use App\finance_invoice_subs;
use App\room_booking;
use Carbon\Carbon;

class SecondBackupFinanceCashFlow extends Controller
{
    public function index(Request $request, finance_cash_flow $finance_cash_flow)
    {

    	  $room_payment_receipt=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit,
  0 as credit_one,0 as credit_two, 0 as invoice_debit,
        id, 0 as debit_one, 0 as debit_two, 0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        total as debit,"Room Payment Receipt" as Mtype, "0" as qnt_one, "0" as qnt_two, "0" as qnt_ent, "0" as qnt_invoice_sub_one, "0" as qnt_bills, "0" as qnt_invoice_one, "0" as qnt_invoice_two,payment_method
        ,invoice_no as ReceiptNo,receipt_type as Type,guest_name as Name,customer_id as MorGnumber,mem_number ,guest_address as Address,guest_contact as Contact,payment_received_for as receivable,"0" as payable,payment_details as Details,total as TotalAmt,
"0" as VoucherNo,"0" as PersonNo,"0" as PersonName,"0" as PersonAddress,"0" as PersonContact,"0" as ExpenseDetails
        ');

          $receipt_one=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit,
  0 as credit_one,0 as credit_two, 0 as invoice_debit,
        id, total as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Room Booking Receipt" as Mtype, "1" as qnt_one, "0" as qnt_two, "0" as qnt_ent, "0" as qnt_bills, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, payment_method,invoice_no as ReceiptNo,receipt_type as Type,guest_name as Name,customer_id as MorGnumber,mem_number ,guest_address as Address,guest_contact as Contact,payment_received_for as receivable,"0" as payable,payment_details as Details,total as TotalAmt,
"0" as VoucherNo,"0" as PersonNo,"0" as PersonName,"0" as PersonAddress,"0" as PersonContact,"0" as ExpenseDetails')->with('member')->where('payment_received_for',2);

          $receipt_one_b=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit,
  0 as credit_one,0 as credit_two, 0 as invoice_debit,
        id, total as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Room Booking Receipt" as Mtype, "1" as qnt_one, "0" as qnt_two, "0" as qnt_ent, "0" as qnt_bills, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, payment_method,invoice_no as ReceiptNo,receipt_type as Type,guest_name as Name,customer_id as MorGnumber,mem_number ,guest_address as Address,guest_contact as Contact,payment_received_for as receivable,"0" as payable,payment_details as Details,total as TotalAmt,
"0" as VoucherNo,"0" as PersonNo,"0" as PersonName,"0" as PersonAddress,"0" as PersonContact,"0" as ExpenseDetails')->with('member')->where('payment_received_for',2);


          $receipt_two=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit,
  0 as credit_one,0 as credit_two, 0 as invoice_debit,
        id,0 as debit_one, total as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Maintenance Receipt" as Mtype, "0" as qnt_one, "1" as qnt_two, "0" as qnt_ent, "0" as qnt_bills,"0" as qnt_invoice_one, "0" as qnt_invoice_two, "0" as qnt_invoice_sub_one, payment_method,invoice_no as ReceiptNo,receipt_type as Type,guest_name as Name,customer_id as MorGnumber,mem_number,guest_address as Address,guest_contact as Contact,payment_received_for as receivable,"0" as payable,payment_details as Details,total as TotalAmt,
"0" as VoucherNo,"0" as PersonNo,"0" as PersonName,"0" as PersonAddress,"0" as PersonContact,"0" as ExpenseDetails')->with('member')->where('payment_received_for',3);

           $receipt_two_b=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit,
  0 as credit_one,0 as credit_two, 0 as invoice_debit,
        id,0 as debit_one, total as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Maintenance Receipt" as Mtype, "0" as qnt_one, "1" as qnt_two, "0" as qnt_ent, "0" as qnt_bills,"0" as qnt_invoice_one, "0" as qnt_invoice_two, "0" as qnt_invoice_sub_one, payment_method,invoice_no as ReceiptNo,receipt_type as Type,guest_name as Name,customer_id as MorGnumber,mem_number,guest_address as Address,guest_contact as Contact,payment_received_for as receivable,"0" as payable,payment_details as Details,total as TotalAmt,
"0" as VoucherNo,"0" as PersonNo,"0" as PersonName,"0" as PersonAddress,"0" as PersonContact,"0" as ExpenseDetails')->with('member')->where('payment_received_for',3);

  


        $expenses=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE, total as credit, 0 as credit_one,0 as credit_two,
        id, 0 as invoice_debit,0 as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Expense" as Mtype, "0" as qnt_one, "0" as qnt_two, "0" as qnt_bills, "0" as qnt_ent, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, account_head,
        "0" as ReceiptNo,"0"  as Type,"0"  as Name,"0"  as MorGnumber,"0"  as Address,"0"  as Contact,0 as receivable,expense_paid_for as payable,"0"  as Details,"0"  as TotalAmt,
invoice_no as VoucherNo,person_id as PersonNo,person_name as PersonName,person_address as PersonAddress,person_contact as PersonContact,expense_details as ExpenseDetails
        ');

        $bills_expenses=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit, total as credit_one,0 as credit_two,
        id, 0 as invoice_debit,0 as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Utility Bills Expense" as Mtype, "0" as qnt_one, "0" as qnt_two, "1" as qnt_bills, "0" as qnt_ent, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, account_head,
         "0" as ReceiptNo,"0"  as Type,"0"  as Name,"0"  as MorGnumber,"0"  as Address,"0"  as Contact,0 as receivable,expense_paid_for as payable,"0"  as Details,"0"  as TotalAmt,
invoice_no as VoucherNo,person_id as PersonNo,person_name as PersonName,person_address as PersonAddress,person_contact as PersonContact,expense_details as ExpenseDetails')->where('expense_paid_for',1);

        $bills_expenses_b=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit, total as credit_one,0 as credit_two,
        id, 0 as invoice_debit,0 as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Utility Bills Expense" as Mtype, "0" as qnt_one, "0" as qnt_two, "1" as qnt_bills, "0" as qnt_ent, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, account_head,
         "0" as ReceiptNo,"0"  as Type,"0"  as Name,"0"  as MorGnumber,"0"  as Address,"0"  as Contact,0 as receivable,expense_paid_for as payable,"0"  as Details,"0"  as TotalAmt,
invoice_no as VoucherNo,person_id as PersonNo,person_name as PersonName,person_address as PersonAddress,person_contact as PersonContact,expense_details as ExpenseDetails')->where('expense_paid_for',1);

        $entertainment_expenses=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit, total as credit_two,0 as credit_one,
        id, 0 as invoice_debit,0 as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Entertainment Expense" as Mtype, "0" as qnt_one, "0" as qnt_two, "0" as qnt_bills, "1" as qnt_ent, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, account_head,
         "0" as ReceiptNo,"0"  as Type,"0"  as Name,"0"  as MorGnumber,"0"  as Address,"0"  as Contact,0 as receivable,expense_paid_for as payable,"0"  as Details,"0"  as TotalAmt,
invoice_no as VoucherNo,person_id as PersonNo,person_name as PersonName,person_address as PersonAddress,person_contact as PersonContact,expense_details as ExpenseDetails')->where('expense_paid_for',2);

        $entertainment_expenses_b=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE, 0 as credit, total as credit_two,0 as credit_one,
        id, 0 as invoice_debit,0 as debit_one, 0 as debit_two,0 as invoice_db_one, 0 as invoice_db_two,0 as invoice_db_sub_one,
        0 as debit,"Entertainment Expense" as Mtype, "0" as qnt_one, "0" as qnt_two, "0" as qnt_bills, "1" as qnt_ent, "0" as qnt_invoice_one, "0" as qnt_invoice_two,"0" as qnt_invoice_sub_one, account_head,
         "0" as ReceiptNo,"0"  as Type,"0"  as Name,"0"  as MorGnumber,"0"  as Address,"0"  as Contact,0 as receivable,expense_paid_for as payable,"0"  as Details,"0"  as TotalAmt,
invoice_no as VoucherNo,person_id as PersonNo,person_name as PersonName,person_address as PersonAddress,person_contact as PersonContact,expense_details as ExpenseDetails')->where('expense_paid_for',2);


        $output_room_payment_receipt=[];
        $output_receipt_one=[];
        $output_receipt_two=[];

//the b ones just to show the text in headings and overview etc.
        $output_receipt_one_b=[];
        $output_receipt_two_b=[];
        $output_bills_expenses_b=[];
        $output_entertainment_expenses_b=[];
//the b ones just to show the text in headings and overview etc.

        $output_bills_expenses=[];
        $output_expenses=[];
        $output_entertainment_expenses=[];

       

        $cheaquedebit=[];
        $cashdebit=[];
        $carddebit=[];
        $bankdebit=[];

        $bankcredit=[];
        $cardcredit=[];
        $cashcredit=[];

          $start_date='NOW()';
          $end_date='NOW()';
 if($request->get('start_date')){
            $start_date="'".formatdate($request->get('start_date'))."'";
          }
            $room_payment_receipt->where('invoice_date','>=',DB::raw($start_date));
            $receipt_one->where('invoice_date','>=',DB::raw($start_date));
            $receipt_two->where('invoice_date','>=',DB::raw($start_date));
            
            $bills_expenses->where('invoice_date','>=',DB::raw($start_date));
            $expenses->where('invoice_date','>=',DB::raw($start_date));
            $entertainment_expenses->where('invoice_date','>=',DB::raw($start_date));
//echo $room_payment_receipt->toSql();
        
        if($request->get('end_date')){
            $end_date="'".formatdate($request->get('end_date'))."'";
            }

            $room_payment_receipt->where('invoice_date','<=',DB::raw($end_date));
            $receipt_one->where('invoice_date','<=',DB::raw($end_date));
            $receipt_two->where('invoice_date','<=',DB::raw($end_date));
           
            $expenses->where('invoice_date','<=',DB::raw($end_date));
            $bills_expenses->where('invoice_date','<=',DB::raw($end_date));
            $entertainment_expenses->where('invoice_date','<=',DB::raw($end_date));
       // echo $room_payment_receipt->toSql();

        if($request->get('start_date')||
			$request->get('end_date') || 1==1){
// dd(123);
        $output_room_payment_receipt=$room_payment_receipt->get()->toArray();
    $output_receipt_one=$receipt_one->get()->toArray();
    $output_receipt_two=$receipt_two->get()->toArray();

//the b ones just to show the text in headings and overview etc.
    $output_receipt_one_b=$receipt_one_b->get()->toArray();
    $output_receipt_two_b=$receipt_two_b->get()->toArray();
    $output_bills_expenses_b=$bills_expenses_b->get()->toArray();
   $output_entertainment_expenses_b=$entertainment_expenses_b->get()->toArray();
//the b ones just to show the text in headings and overview etc.
   

//dd($output_receipt_two);
      $output_expenses=$expenses->get()->toArray();
    $output_bills_expenses=$bills_expenses->get()->toArray();
   $output_entertainment_expenses=$entertainment_expenses->get()->toArray();
     /*$cashdebit=$room_payment_receipt->where('payment_method', 1)->get()->toArray();
     $cheaquedebit=$room_payment_receipt->where('payment_method', 2)->get()->toArray(); 
     $carddebit=$room_payment_receipt->where('payment_method', 3)->get()->toArray();    
     $bankdebit=$room_payment_receipt->where('payment_method', 4)->get()->toArray();  */  


     $cashdebit=array_filter($output_room_payment_receipt,function($a){return $a['payment_method']==1;});

     $cheaquedebit=array_filter($output_room_payment_receipt,function($a){return $a['payment_method']==2;});
//     dd($cheaquedebit);
     $carddebit=array_filter($output_room_payment_receipt,function($a){return $a['payment_method']==3;});
     $bankdebit=array_filter($output_room_payment_receipt,function($a){return $a['payment_method']==4;});



      $bankcredit=array_filter($output_expenses,function($a){return $a['account_head']==1;});
     $cardcredit=array_filter($output_expenses,function($a){return $a['account_head']==2;});
//     dd($cheaquedebit);
     $cashcredit=array_filter($output_expenses,function($a){return $a['account_head']==3;});
      
}

$data['start_date']=$request->get('start_date')?$request->get('start_date'):date('d/m/Y',time());
$data['end_date']=$request->get('end_date')?$request->get('end_date'):date('d/m/Y',time());


 
$data['bills_expenses']=$output_bills_expenses;
$data['ent_expenses']=$output_entertainment_expenses;
$data['receipts']=$output_room_payment_receipt;
$data['receipt_one']=$output_receipt_one;
$data['receipt_two']=$output_receipt_two;

//the b ones just to show the text in headings and overview etc.
$data['receipt_one_b']=$output_receipt_one_b;
$data['receipt_two_b']=$output_receipt_two_b;
$data['bills_expenses_b']=$output_bills_expenses_b;
$data['ent_expenses_b']=$output_entertainment_expenses_b;
//the b ones just to show the text in headings and overview etc.


$data['cashdebit']=$cashdebit;
$data['cheaquedebit']=$cheaquedebit;
$data['carddebit']=$carddebit;
$data['bankdebit']=$bankdebit;

$data['bankcredit']=$bankcredit;
$data['cardcredit']=$cardcredit;
$data['cashcredit']=$cashcredit;
// dd($data['invoices_two']->toArray());

$data['data']=array_merge($output_expenses,$output_bills_expenses,$output_entertainment_expenses,$output_room_payment_receipt,$output_receipt_one,$output_receipt_two);

//function to get the data in descending order
        usort($data['data'],function($element1,$element2){
          $element1=(array) $element1;
          $element2=(array) $element2;
            $datetime1 = strtotime($element1['dateS']);
            $datetime2 = strtotime($element2['dateE']);
            return -$datetime2+$datetime1  ;
        });

        return view('backend/finance-and-management/finance-cash-flow/finance-cash-flow',$data);
    }




}
