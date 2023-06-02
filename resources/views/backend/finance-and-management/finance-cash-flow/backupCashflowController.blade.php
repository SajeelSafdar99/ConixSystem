<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\finance_cash_flow;
use DB;
use Session;
use DataTables;
use App\room_payment_receipt;
use App\finance_expense;
use App\room_booking;
use Carbon\Carbon;

class FinanceCashFlowControllerzz extends Controller
{
    public function index(Request $request, finance_cash_flow $finance_cash_flow)
    {

//dd(room_payment_receipt::selectRaw('total as cashdebit')->where('payment_method', 1)->get()->toArray());
//dd(room_payment_receipt::selectRaw('total as cheaquedebit')->where('payment_method', 2)->get()->toArray());
//dd(room_payment_receipt::selectRaw('total as creditdebit')->where('payment_method', 3)->get()->toArray());
//dd(room_payment_receipt::selectRaw('total as bankdebit')->where('payment_method', 4)->get()->toArray());

        $cash=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, total as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit,  "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit')->where('payment_method', 1);


        $cheaque=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, total as cheaquedebit, "0" as bankdebit,  "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit')->where('payment_method', 2);

        $credit=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, total as creditdebit, "0" as cheaquedebit, "0" as bankdebit,  "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit')->where('payment_method', 3);

        $bank=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, total as bankdebit,  "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit')->where('payment_method', 4);
       

    	  $room_payment_receipt=room_payment_receipt::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        total as debit,"Room Payment Receipt" as Mtype, "1" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit, "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit');
        $expenses=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE, total as credit,
        id,
        0 as debit,"Expense" as Mtype, "0" as Qnt, "1" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit, "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit');



        $expcash=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit,  total as cashcredit, "0" as cardcredit, "0" as cheaquecredit, "0" as bankcredit')->where('payment_method', 1);


        $expcheaque=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit,  "0" as cashcredit, "0" as cardcredit, total as cheaquecredit, "0" as bankcredit')->where('payment_method', 2);

        $expcredit=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit,  "0" as cashcredit, total as cardcredit, "0" as cheaquecredit, "0" as bankcredit')->where('payment_method', 3);

        $expbank=finance_expense::selectRaw('invoice_date as dateS, invoice_date as dateE,
  0 as credit,
        id,
        "0" as debit,"Room Payment Receipt" as Mtype, "0" as Qnt, "0" as Eqnt, "0" as cashdebit, "0" as creditdebit, "0" as cheaquedebit, "0" as bankdebit,  "0" as cashcredit, "0" as cardcredit, "0" as cheaquecredit, total as bankcredit')->where('payment_method', 4);
       


        $output_room_payment_receipt=[];
        $output_cash=[];
        $output_cheaque=[];
        $output_credit=[];
         $output_bank=[];

         $output_expcash=[];
        $output_expcheaque=[];
        $output_expcredit=[];
         $output_expbank=[];
        $output_expenses=[];
 	
 if($request->get('start_date')){

            $room_payment_receipt->where('invoice_date','>=',formatDate($request->get('start_date')));
            $cash->where('invoice_date','>=',formatDate($request->get('start_date')));
            $cheaque->where('invoice_date','>=',formatDate($request->get('start_date')));
            $credit->where('invoice_date','>=',formatDate($request->get('start_date')));
            $bank->where('invoice_date','>=',formatDate($request->get('start_date')));

            $expcash->where('invoice_date','>=',formatDate($request->get('start_date')));
            $expcheaque->where('invoice_date','>=',formatDate($request->get('start_date')));
            $expcredit->where('invoice_date','>=',formatDate($request->get('start_date')));
            $expbank->where('invoice_date','>=',formatDate($request->get('start_date')));
            $expenses->where('invoice_date','>=',formatDate($request->get('start_date')));

        }
        if($request->get('end_date')){
            $room_payment_receipt->where('invoice_date','<=',formatDate($request->get('end_date')));
            $cash->where('invoice_date','<=',formatDate($request->get('end_date')));
            $cheaque->where('invoice_date','<=',formatDate($request->get('end_date')));
            $credit->where('invoice_date','<=',formatDate($request->get('end_date')));
            $bank->where('invoice_date','<=',formatDate($request->get('end_date')));

            $expcash->where('invoice_date','<=',formatDate($request->get('end_date')));
            $expcheaque->where('invoice_date','<=',formatDate($request->get('end_date')));
            $expcredit->where('invoice_date','<=',formatDate($request->get('end_date')));
            $expbank->where('invoice_date','<=',formatDate($request->get('end_date')));
            $expenses->where('invoice_date','<=',formatDate($request->get('end_date')));
        }

        if($request->get('start_date')||
			$request->get('end_date')){

        $output_room_payment_receipt=$room_payment_receipt->get()->toArray();
        $output_cash=$cash->get()->toArray();
        $output_cheaque=$cheaque->get()->toArray();
        $output_credit=$credit->get()->toArray();
        $output_bank=$bank->get()->toArray();

        $output_expcash=$expcash->get()->toArray();
        $output_expcheaque=$expcheaque->get()->toArray();
        $output_expcredit=$expcredit->get()->toArray();
        $output_expbank=$expbank->get()->toArray();
        $output_expenses=$expenses->get()->toArray();
}

$data['start_date']=$request->get('start_date');
$data['end_date']=$request->get('end_date');


 if($request->get('start_date') ) {
           
            $oReceipt=room_payment_receipt::where('invoice_date','<',formatDate($request->get('start_date')));
            $oExpense=finance_expense::where('invoice_date','<',formatDate($request->get('start_date')));

   




            $tBalance=$oReceipt->get()->sum('total')-$oExpense->get()->sum('total');
            $data['totalBalance']=$tBalance;

        }

$data['data']=array_merge($output_expenses,$output_room_payment_receipt,$output_cash,$output_cheaque,$output_credit,$output_bank,$output_expcash,$output_expcheaque,$output_expcredit,$output_expbank);
        usort($data['data'],function($element1,$element2){
            $datetime1 = strtotime($element1['dateS']);
            $datetime2 = strtotime($element2['dateE']);
            return -$datetime2+$datetime1  ;
        });

        return view('backend/finance-and-management/finance-cash-flow/finance-cash-flow',$data);
    }



   
}
