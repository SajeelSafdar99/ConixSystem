<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\finance_cash_flow;
use DB;
use Session;
use DataTables;
use App\transactions;
use App\trans_type;
use App\trans_relations;
use App\room_booking;
use App\membership;
use App\fnb_sale;
use App\finance_cash_receipt;
use Carbon\Carbon;
use App\finance_account_head;
use App\finance_account_type;

 class FinanceCashFlowController extends Controller
{
    public function index(Request $request, finance_cash_flow $finance_cash_flow)
    {
    $data['types'] =trans_type::get();

      $data['start_date'] =$request->get('start_date');
      $data['end_date'] =$request->get('end_date');
        $ttype='';
        $date1='';
        $date2='';
        $date3='';
        $date4='';
if($request->get('type')){
  $data['tarray'] =$request->get('type');
}
else{
  $data['tarray']=[];
}

if($request->get('type')){
   $ttype=' and trans_types.id in ('.implode(',',$request->get('type')).')';
}




if($request->get('start_date')){
  $date1=' and t1.`date`>="'.formatDate($request->get('start_date')).'"';
  $date2=' and t2.`date`>="'.formatDate($request->get('start_date')).'"';
//    $date2=' and t1.`date`<="'.formatDate($request->get('end_date')).'"';

}
 if($request->get('end_date')){
     $date3=' and t1.`date`<="'.formatDate($request->get('end_date')).'"';
     $date4=' and t2.`date`<="'.formatDate($request->get('end_date')).'"';

 }

 
//echo "SELECT trans_types.*,
//(select sum(trans_amount) from transactions as t1 where trans_types.id=t1.trans_type and (t1.debit_or_credit=0 and trans_types.cash_or_payment=0) and t1.deleted_at is null $date1 $date3) as debit,
//(select sum(trans_amount) from transactions as t2 where trans_types.id=t2.trans_type and (t2.debit_or_credit=1 and  trans_types.cash_or_payment=1) and t2.deleted_at is null $date2 $date4) as credit,
// ((select group_concat(id) from transactions as t1 where trans_types.id=t1.trans_type and (t1.debit_or_credit=0 and trans_types.cash_or_payment=0) and t1.deleted_at is null $date1 $date3) ) as ddd
// FROM trans_types
//
//
//WHERE 1=1 ";
// die();
 
$data['data']=\Illuminate\Support\Facades\DB::select("SELECT trans_types.*,
(select sum(trans_amount) from transactions as t1 where trans_types.id=t1.trans_type and (t1.type in (2,4,6) and t1.debit_or_credit=0 and trans_types.cash_or_payment=0) and t1.deleted_at is null $date1 $date3) as debit,
(select sum(trans_amount) from transactions as t2 where trans_types.id=t2.trans_type and (t2.type in (1,5) and t2.debit_or_credit=1 and  trans_types.cash_or_payment=1) and t2.deleted_at is null $date2 $date4) as credit
  FROM trans_types


WHERE 1=1 $ttype having debit>0 or credit>0");
        return view('backend/finance-and-management/finance-cash-flow/finance-cash-flow',$data);
    }



      public function salesreport(Request $request, finance_cash_flow $finance_cash_flow)
    {

$data['start_date'] =$request->get('start_date');
$data['end_date'] =$request->get('end_date');


$data['types'] =trans_type::get();
$data['paid_rooms']=transactions::where('debit_or_credit',0)->where('trans_type',1)->sum('trans_amount');
$receipts=transactions::where('debit_or_credit',0)->where('trans_type',1)->get()->pluck('receipt_id');
//dd($receipts);

 $Cash = finance_account_head::where('desc','Cash')->get()->pluck('id');
 $acctype = finance_account_type::where('desc',$Cash)->get()->pluck('id');
$data['acccash'] = finance_account_type::where('desc',$Cash)->get()->pluck('id')->toArray();
//dd($data['acccash']);

 $Credit = finance_account_head::where('desc','Bank')->get()->pluck('id');
 $acctype2 = finance_account_type::where('desc',$Credit)->get()->pluck('id');
  $data['acccredit']  = finance_account_type::where('desc',$Credit)->get()->pluck('id')->toArray();
//dd($acctype);
$data['cashreceipts'] =finance_cash_receipt::whereIn('id',$receipts)->where('account',$acctype)->get()->sum('total');
$data['cashreceipts2'] =finance_cash_receipt::whereIn('id',$receipts)->where('account',$acctype2)->get()->sum('total');
//dd($data['cashreceipts']);

  $data['rooms'] =room_booking::where('check_out_status', 1)->get();
  $data['members'] =membership::get();
  $data['sales'] =fnb_sale::where('completed','!=',0)->get();

     return view('backend/finance-and-management/finance-sales-report/finance-sales-report',$data);
    }



    public function salesreport_vue(Request $request, fnb_sale $fnb_sale)
    {
       return view('backend/finance-and-management/finance-sales-report/finance-sales-report-vue');
    }

       public function salesreport_init_vue(Request $request)
    {
         $start_date=date('Y-m-d');
        $end_date=date('Y-m-d');
        if($request->start_date){
            $start_date=formatDate($request->start_date);
        }
        if($request->end_date){
            $end_date=formatDate($request->end_date);

        }
        $search ='';
        $search2 ='';
        $search3 ='';
        if($request->transtype){
            $search2.=' and trans_types.id in ('.$request->transtype.') ';
        } 
        
        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select trans_types.*,

    sum(if(fnb_sales.gross is not null,fnb_sales.gross,0)) as grosssale,
       (sum(fnb_sales.discount))                as diss,
         (sum(fnb_sales.sub_total))               as netsale,
         (sum(fnb_sales.tax))                  as taxx,
          (sum(fnb_sales.covers))                 as netcovers,
          (sum(fnb_sales.grand_total))                 as grandd,
     sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
      sum(if(fnb_sales.account_type not in (22,24),fnb_sales.grand_total,0)) as othergross,
  sum(transactions.trans_amount ) as paid_amount,


 sum(DISTINCT if(room_bookings.total_charges is not null,room_bookings.total_charges,0)) as booking_gross,
  sum(DISTINCT if(room_bookings.discount_amount is not null,room_bookings.discount_amount,0)) as booking_diss,
          (sum(DISTINCT room_bookings.nights))                 as booking_nights,
          (sum( DISTINCT room_bookings.grand_total))                 as booking_grand,
  sum(t3.trans_amount ) as booking_paid,


 sum(DISTINCT if(event_bookings.total_charges is not null,event_bookings.total_charges,0)) as events_gross,
  sum(DISTINCT if(event_bookings.discount_amount is not null,event_bookings.discount_amount,0)) as events_diss,
        (sum( DISTINCT event_bookings.surcharge))                as events_surcharge,
          sum(if(event_bookings.guests is not null,event_bookings.guests,0)) as events_guests,
          sum(if(event_bookings.extra_guests is not null,event_bookings.extra_guests,0)) as extra_guests,
          (sum( DISTINCT event_bookings.grand_total))                 as events_grand,
  sum(t4.trans_amount ) as events_paid,

 sum(if(finance_invoices.sub_total is not null,finance_invoices.sub_total,0)) as invoices_gross,
  sum(if(finance_invoices.discount_amount is not null,finance_invoices.discount_amount,0)) as invoices_diss,
         (sum(finance_invoices.tax_percentage))                  as invoices_taxx,
          (sum(finance_invoices.days))                 as invoices_days,
          (sum(finance_invoices.grand_total))                 as invoices_grand,
  sum(t1.trans_amount ) as invoices_paid,
 


  group_concat(DISTINCT trans_types.`id`) as transid,
  group_concat(DISTINCT trans_types.`name`) as cat,
  group_concat(DISTINCT trans_types.`type`) as ttypo

from trans_types


left outer join fnb_sales on fnb_sales.completed!=0 and fnb_sales.id is not null and  fnb_sales.deleted_at is null  '.$search.'  and DATE(fnb_sales.date) <= "'.$end_date.'" and
                                           DATE(fnb_sales.date) >= "'.$start_date.'" '.$search3.' and trans_types.id=5


left outer join room_bookings on room_bookings.check_out_status=1 and room_bookings.id is not null and  room_bookings.deleted_at is null  '.$search.'  and DATE(room_bookings.check_out_date) <= "'.$end_date.'" and
                                           DATE(room_bookings.check_out_date) >= "'.$start_date.'" '.$search3.' and trans_types.id=1

left outer join event_bookings on event_bookings.check_out_status=1 and event_bookings.id is not null and  event_bookings.deleted_at is null  '.$search.'  and DATE(event_bookings.event_date) <= "'.$end_date.'" and
                                           DATE(event_bookings.event_date) >= "'.$start_date.'" '.$search3.' and trans_types.id=2

left outer join finance_invoices on finance_invoices.id is not null and  finance_invoices.deleted_at is null  '.$search.'  and DATE(finance_invoices.invoice_date) <= "'.$end_date.'" and
                                           DATE(finance_invoices.invoice_date) >= "'.$start_date.'" '.$search3.' and finance_invoices.charges_type=trans_types.id



left outer join transactions t1 on t1.trans_type=trans_types.id and t1.type in (1,2) and t1.trans_type_id=finance_invoices.id and t1.debit_or_credit=0 and t1.deleted_at is null


left outer join transactions on transactions.trans_type=trans_types.id and transactions.type in (1,2) and transactions.trans_type_id=fnb_sales.id and transactions.debit_or_credit=0 and transactions.deleted_at is null


left outer join transactions t3 on t3.trans_type=trans_types.id and t3.type in (1,2) and t3.trans_type_id=room_bookings.id and t3.debit_or_credit=0 and t3.deleted_at is null


left outer join transactions t4 on t4.trans_type=trans_types.id and t4.type in (1,2) and t4.trans_type_id=event_bookings.id and t4.debit_or_credit=0 and t4.deleted_at is null


where trans_types.cash_or_payment=0 and trans_types.id!=6 '.$search2.' and trans_types.deleted_at is null  group by trans_types.id 
                                           
');
        }





 /*sum(if(t2.trans_type_id = 22,t2.trans_amount,0)) as invoices_cash,
     sum(if(t2.trans_type_id = 24,t2.trans_amount,0)) as invoices_credit,
    sum(if(t2.trans_type_id not in (22,24),t2.trans_amount,0)) as invoices_other,



left outer join transactions as t2 on t2.trans_type=90 and t2.debit_or_credit=0 and t2.receipt_id=t1.receipt_id and t2.date=finance_invoices.invoice_date and t2.deleted_at is null


*/



/*  'select trans_types.*,

    sum(if(fnb_sales.gross is not null,fnb_sales.gross,0)) as grosssale,
       (sum(fnb_sales.discount))                as diss,
         (sum(fnb_sales.sub_total))               as netsale,
         (sum(fnb_sales.tax))                  as taxx,
          (sum(fnb_sales.covers))                 as netcovers,
          (sum(fnb_sales.grand_total))                 as grandd,
     sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
      sum(if(fnb_sales.account_type not in (22,24),fnb_sales.grand_total,0)) as othergross,
  sum(transactions.trans_amount ) as paid_amount,


 sum(DISTINCT if(room_bookings.total_charges is not null,room_bookings.total_charges,0)) as booking_gross,
       (sum( DISTINCT room_bookings.discount_amount))                as booking_diss,
          (sum(DISTINCT room_bookings.nights))                 as booking_nights,
          (sum( DISTINCT room_bookings.grand_total))                 as booking_grand,
  sum(t3.trans_amount ) as booking_paid,


 sum(DISTINCT if(event_bookings.total_charges is not null,event_bookings.total_charges,0)) as events_gross,
       (sum( DISTINCT event_bookings.discount_amount))                as events_diss,
        (sum( DISTINCT event_bookings.surcharge))                as events_surcharge,
          sum(if(event_bookings.guests is not null,event_bookings.guests,0)) as events_guests,
          sum(if(event_bookings.extra_guests is not null,event_bookings.extra_guests,0)) as extra_guests,
          (sum( DISTINCT event_bookings.grand_total))                 as events_grand,
  sum(t4.trans_amount ) as events_paid,

 sum(if(finance_invoices.sub_total is not null,finance_invoices.sub_total,0)) as invoices_gross,
       (sum(finance_invoices.discount_amount))                as invoices_diss,
         (sum(finance_invoices.tax_percentage))                  as invoices_taxx,
          (sum(finance_invoices.days))                 as invoices_days,
          (sum(finance_invoices.grand_total))                 as invoices_grand,
  sum(t1.trans_amount ) as invoices_paid,
 


  group_concat(DISTINCT trans_types.`id`) as transid,
  group_concat(DISTINCT trans_types.`name`) as cat,
  group_concat(DISTINCT trans_types.`type`) as ttypo

from trans_types


left outer join fnb_sales on fnb_sales.completed!=0 and fnb_sales.id is not null and  fnb_sales.deleted_at is null  '.$search.'  and DATE(fnb_sales.date) <= "'.$end_date.'" and
                                           DATE(fnb_sales.date) >= "'.$start_date.'" '.$search3.' and trans_types.id=5


left outer join room_bookings on room_bookings.check_out_status=1 and room_bookings.id is not null and  room_bookings.deleted_at is null  '.$search.'  and DATE(room_bookings.check_out_date) <= "'.$end_date.'" and
                                           DATE(room_bookings.check_out_date) >= "'.$start_date.'" '.$search3.' and trans_types.id=1

left outer join event_bookings on event_bookings.check_out_status=1 and event_bookings.id is not null and  event_bookings.deleted_at is null  '.$search.'  and DATE(event_bookings.event_date) <= "'.$end_date.'" and
                                           DATE(event_bookings.event_date) >= "'.$start_date.'" '.$search3.' and trans_types.id=2

left outer join finance_invoices on finance_invoices.id is not null and  finance_invoices.deleted_at is null  '.$search.'  and DATE(finance_invoices.invoice_date) <= "'.$end_date.'" and
                                           DATE(finance_invoices.invoice_date) >= "'.$start_date.'" '.$search3.' and finance_invoices.charges_type=trans_types.id



left outer join transactions t1 on t1.trans_type=trans_types.id and t1.trans_type!=90 and t1.trans_type_id=finance_invoices.id and t1.debit_or_credit=0 and t1.deleted_at is null


left outer join transactions on transactions.trans_type=trans_types.id and transactions.trans_type!=90 and transactions.trans_type_id=fnb_sales.id and transactions.debit_or_credit=0 and transactions.deleted_at is null


left outer join transactions t3 on t3.trans_type=trans_types.id and t3.trans_type!=90 and t3.trans_type_id=room_bookings.id and t3.debit_or_credit=0 and t3.deleted_at is null


left outer join transactions t4 on t4.trans_type=trans_types.id and t4.trans_type!=90 and t4.trans_type_id=event_bookings.id and t4.debit_or_credit=0 and t4.deleted_at is null


where trans_types.cash_or_payment=0 and trans_types.id!=6 '.$search2.' and trans_types.deleted_at is null  group by trans_types.id 
                                           
'*/

  $data['transtypes']= trans_type::where('cash_or_payment',0)->get();

     return $data;
}


}
