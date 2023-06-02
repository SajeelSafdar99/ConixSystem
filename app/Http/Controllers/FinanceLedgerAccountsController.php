<?php

namespace App\Http\Controllers;

use App\finance_invoice;
use App\finance_ledger_accounts;
use App\room_booking;
use App\membership;
use App\room;
use App\room_type;
use App\trans_type;
use App\transactions;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\View;
use Session;
use App\customer;
use App\room_payment_receipt;
use DB;
use App\hr_company;
use App\hr_department;
use App\hr_sub_department;
use App\coa_account;
use App\coa_accounts_control;

class FinanceLedgerAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function supplier_vue(Request $request, finance_ledger_accounts $finance_ledger_accounts)
    {

         return view('backend/finance-and-management/finance-ledger-accounts/finance-supplier-ledgers-vue');
    }
 
       public function supplier_init_vue(Request $request)
    {
        $search='';
        $search2='';
        if($request->get('start_date')){
            $search.=" and transactions.date >= '$request->start_date' ";
            $search2.=" and transactions.date < '$request->start_date' ";
        }
        else{
            $search2.=" and 1=2 ";
        }if($request->get('end_date')){
        $search.=" and transactions.date <= '$request->end_date' ";
    }
        if($request->get('filter')!=0){
        $search.=" and transactions.trans_type = '$request->filter' ";
        $search2.=" and transactions.trans_type = '$request->filter' ";
    }  if($request->get('mocid')!=0){
        $search.=" and transactions.trans_moc = '$request->mocid' ";
        $search2.=" and transactions.trans_moc = '$request->mocid' ";
    }
    if($request->get('ent')=='Exclude Advance'){
    $search.=" and transactions.ent !=4 ";
    $search2.=" and transactions.ent !=4 ";
}
if($request->get('ent')=='Include Advance'){
    $search.=" and transactions.ent in (0,4) ";
    $search2.=" and transactions.ent in (0,4) ";
}
 /*   if($request->get('ent')=='Include ENT and CTS'){
   $search.=" and transactions.ent is not null  ";
   $search2.=" and transactions.ent is not null  ";
}
if($request->get('ent')=='Exclude ENT and CTS'){
    $search.=" and transactions.ent = 0 ";
    $search2.=" and transactions.ent = 0 ";
}
if($request->get('ent')=='Only ENT'){
    $search.=" and transactions.ent = 1 ";
    $search2.=" and transactions.ent = 1 ";
}
if($request->get('ent')=='Only CTS'){
    $search.=" and transactions.ent = 2 ";
    $search2.=" and transactions.ent = 2 ";
}*/
    
        $search.=" and transactions.trans_moc_type = '$request->moc' ";
        $search2.=" and transactions.trans_moc_type = '$request->moc' ";

  $data['ledgers'] =\Illuminate\Support\Facades\DB::select("select transactions.id as mainid, transactions.date,
    transactions.unit,
    transactions.account,
       transactions.trans_type_id,
       transactions.trans_amount,
       transactions.debit_or_credit,transactions.type as maintype,
       transactions.receipt_id,

       if(transactions.trans_moc_type = 0,
          CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
                 coalesce(memberships.middle_name, ''), ' ',
                 coalesce(memberships.applicant_name, '')), if(transactions.trans_moc_type = 1,
          customers.customer_name, if(transactions.trans_moc_type = 2, finance_ledger_people.person_name,hr_employments.name))) as name,

          hr_employments.designation as designation,
          coa_accounts.name as company,
       transactions.trans_moc_type                      as type
        ,
       trans_types.name                                 as type_name
from transactions

         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join memberships on memberships.id = transactions.trans_moc and transactions.trans_moc_type = 0
         left outer join customers on customers.id = transactions.trans_moc and transactions.trans_moc_type = 1
        left outer join finance_ledger_people on finance_ledger_people.id = transactions.trans_moc and transactions.trans_moc_type=2
         left outer join hr_employments
                         on hr_employments.id = transactions.trans_moc and transactions.trans_moc_type = 3
    left outer join coa_accounts
                         on coa_accounts.code = hr_employments.company

where transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 1) and transactions.type in (4,5,6,7) $search  group by transactions.id order by `date` asc");
//        echo "select (sum(if(debit_or_credit=0,trans_amount,0))-sum(if(debit_or_credit=1,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.trans_type<90 $search2  ";
        $data['opening'] =\Illuminate\Support\Facades\DB::select("select (sum(if(debit_or_credit=1,trans_amount,0))-sum(if(debit_or_credit=0,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 1) and transactions.type in (4,5,6,7) $search2  ")[0];
        $data['filters']=trans_type::all();

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['units']=coa_account::get();
$data['coaaccounts']=coa_accounts_control::all();

     return $data;

}







      public function index_vue(Request $request, finance_ledger_accounts $finance_ledger_accounts)
    {

         return view('backend/finance-and-management/finance-ledger-accounts/finance-ledger-accounts-vue');
    }
 
       public function legders_init_vue(Request $request)
    {
        $search='';
        $search2='';
        if($request->get('start_date')){
            $search.=" and transactions.date >= '$request->start_date' ";
            $search2.=" and transactions.date < '$request->start_date' ";
        }
        else{
            $search2.=" and 1=2 ";
        }if($request->get('end_date')){
        $search.=" and transactions.date <= '$request->end_date' ";
    }
        if($request->get('filter')!=0){
        $search.=" and transactions.trans_type = '$request->filter' ";
        $search2.=" and transactions.trans_type = '$request->filter' ";
    }  if($request->get('mocid')!=0){
        $search.=" and transactions.trans_moc = '$request->mocid' ";
        $search2.=" and transactions.trans_moc = '$request->mocid' ";
    }
    if($request->get('ent')=='Include ENT and CTS'){
   $search.=" and transactions.ent is not null and transactions.ent not in (3,5) ";
   $search2.=" and transactions.ent is not null  and transactions.ent not in (3,5)";
}
if($request->get('ent')=='Exclude ENT and CTS'){
    $search.=" and transactions.ent not in (1,2) ";
    $search2.=" and transactions.ent not in (1,2) ";
}
if($request->get('ent')=='Only ENT'){
    $search.=" and transactions.ent = 1 ";
    $search2.=" and transactions.ent = 1 ";
}
if($request->get('ent')=='Only CTS'){
    $search.=" and transactions.ent = 2 ";
    $search2.=" and transactions.ent = 2 ";
}
if($request->get('ent')=='Include Discount and Advance'){
    $search.=" and transactions.ent is not null";
    $search2.=" and transactions.ent is not null";
}
    
        $search.=" and transactions.trans_moc_type = '$request->moc' ";
        $search2.=" and transactions.trans_moc_type = '$request->moc' ";

  $data['ledgers'] =\Illuminate\Support\Facades\DB::select("select transactions.id as mainid,
    transactions.date,
    transactions.unit,
    transactions.account,
       transactions.trans_type_id,
       transactions.trans_amount,
       transactions.debit_or_credit,

     
 CONCAT(coalesce(corporate_memberships.title, ''), ' ', coalesce(corporate_memberships.first_name, ''), ' ',
                 coalesce(corporate_memberships.middle_name, ''), ' ',
                 coalesce(corporate_memberships.applicant_name, '')) as  cname,



       transactions.receipt_id,

       if(transactions.trans_moc_type = 0,
          CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
                 coalesce(memberships.middle_name, ''), ' ',
                 coalesce(memberships.applicant_name, '')), if(transactions.trans_moc_type = 1,
          customers.customer_name, if(transactions.trans_moc_type = 2, finance_ledger_people.person_name,hr_employments.name))) as name,




          hr_employments.designation as designation,
          coa_accounts.name as company,
       transactions.trans_moc_type                      as type
        ,
       trans_types.name                                 as type_name
from transactions

         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join memberships on memberships.id = transactions.trans_moc and transactions.trans_moc_type = 0
          left outer join corporate_memberships on corporate_memberships.id = transactions.trans_moc and transactions.trans_moc_type = 6
         left outer join customers on customers.id = transactions.trans_moc and transactions.trans_moc_type = 1
        left outer join finance_ledger_people on finance_ledger_people.id = transactions.trans_moc and transactions.trans_moc_type=2
         left outer join hr_employments
                         on hr_employments.id = transactions.trans_moc and transactions.trans_moc_type = 3
    left outer join coa_accounts
                         on coa_accounts.code = hr_employments.company

where transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.type in (1,2,7) $search  group by transactions.id order by `date` asc");
//        echo "select (sum(if(debit_or_credit=0,trans_amount,0))-sum(if(debit_or_credit=1,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.trans_type<90 $search2  ";
        $data['opening'] =\Illuminate\Support\Facades\DB::select("select (sum(if(debit_or_credit=0,trans_amount,0))-sum(if(debit_or_credit=1,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.type in (1,2,7) $search2  ")[0];
        $data['filters']=trans_type::all();

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['units']=coa_account::get();
$data['coaaccounts']=coa_accounts_control::all();

     return $data;

}


    public  function index(Request $request, finance_ledger_accounts $finance_ledger_accounts)
    {

        $transactions = transactions::query();
        if ($request->get('filter')) {
            $transactions->where('trans_type', $request->get('filter'));
        }
        if ($request->get('mog')) {
            $transactions->where('trans_moc_type', $request->get('mog'));

        } else {
            $transactions->where('trans_moc_type', 0);

        }
        if ($request->get('mog_id')) {
            $transactions->where('trans_moc', $request->get('mog_id'));

        }
        if ($request->get('start_date')) {
            $transactions->where('date', '>=', formatDate($request->get('start_date')));

        }
        if ($request->get('end_date')) {
            $transactions->where('date', '<=', formatDate($request->get('end_date')));

        }
        if ($request->get('receipt')) {
            $transactions->where('receipt_id', ($request->get('receipt')));


        }
        if ($request->get('booking_no')) {
            $transactions->where('trans_type_id', ($request->get('booking_no')));


        }
//        dd($transactions->toSql());
//        $transactions->where('debit_or_credit', 1);
//dd($transactions->with('type')->orderBy('date','asc')->whereRaw('(is_active =1 OR debit_or_credit=0)')->toSql());
        if ($request->get('start_date') ||
            $request->get('end_date') ||
            $request->get('filter') ||
            $request->get('mog') ||
            $request->get('mog_id') || $request->get('receipt') ||
            $request->get('booking_no')) {
if($request->get('start_date') ){
    $mmm=$request->get('mog')?$request->get('mog'):0;
    $dopen=transactions::where('date', '<', formatDate($request->get('start_date')))->where('trans_moc', $request->get('mog_id'))->where('trans_moc_type', $mmm)->whereRaw('debit_or_credit=0')->has('type')->get()->sum('trans_amount');
    $copen=transactions::where('date', '<', formatDate($request->get('start_date')))->where('trans_moc', $request->get('mog_id'))->where('trans_moc_type', $mmm)->whereRaw('debit_or_credit=1 and is_active=1')->has('type')->get()->sum('trans_amount');
//    dd($dopen);
//    dd($copen);

    $data['opening']=$dopen-$copen;

}
        $t = $transactions->with('type')->orderBy('date', 'asc')->whereRaw('(is_active =1 OR debit_or_credit=0)')->has('type')->get()->toArray();
    }
    else {
    $t=[];
        $data['opening']=0;
    }
//        dd($t[58]);


        $data['data']=$t;
        $data['types']=trans_type::all();
        $data['roomledgeraccounts']=0;
        $data['customer']=$request->get('customer');
        $data['start_date']=$request->get('start_date');
        $data['end_date']=$request->get('end_date');

        $data['booking_no']=$request->get('booking_no');
        $data['receipt']=$request->get('receipt');
        $data['mog_id']=$request->get('mog_id');
        $data['mog']=$request->get('mog');
        $data['filter']=$request->get('filter');
        return view('backend/finance-and-management/finance-ledger-accounts/finance-ledger-accounts',$data);

    }
     public function indexd(Request $request, finance_ledger_accounts $finance_ledger_accounts)
    {
//dd(123);

        $bookings=room_booking::selectRaw('check_out_date as dateN,
        booking_no as no,
        moc_name as name,
        IF(customer_id IS NULL,"Member","Customer") as type,
        IF(member_id IS NULL,customer_id,member_id) as mog_id,
        room as details,grand_total as credit,
        id,
        0 as debit,"Room Booking" as Mtype')->where('check_out_status', 1);
        $room_payment_receipt=room_payment_receipt::selectRaw('invoice_date as dateN,
        invoice_no as no,
        guest_name as name,
        IF(customer_id IS NULL,"Member","Customer") as type,
        IF(mem_number IS NULL,customer_id,mem_number) as mog_id,
        payment_details as details,total as debit,
        id,
        0 as credit,"Room Payment Receipt" as Mtype');
        $invoices=finance_invoice::selectRaw('invoice_date as dateN,        invoice_no as no,
        name as name,
        IF(customer_id IS NULL,"Member","Customer") as type,
        IF(member_id IS NULL,customer_id,member_id) as mog_id,
        comments as details,grand_total as credit,
        id,
        0 as debit,"Invoice" as Mtype');
        $output_Booking=[];
        $output_room_payment_receipt=[];
        $output_invoices=[];
        if($request->get('start_date')){

            $bookings->where('check_out_date','>=',formatDate($request->get('start_date')));
            $room_payment_receipt->where('invoice_date','>=',formatDate($request->get('start_date')));
            $invoices->where('invoice_date','>=',formatDate($request->get('start_date')));

        }
        if($request->get('end_date')){
            $bookings->where('check_out_date','<=',formatDate($request->get('end_date')));
            $room_payment_receipt->where('invoice_date','<=',formatDate($request->get('end_date')));
            $invoices->where('invoice_date','<=',formatDate($request->get('end_date')));
        }
        if($request->get('booking_no')){
        $room_payment_receipt->where('id','=',0);
            $invoices->where('id','=',0);

        $bookings->where('booking_no','=',$request->get('booking_no'));
        }
        if($request->get('receipt')){
        $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);
            $invoices->where('id','=',0);

        } if($request->get('invoice')){
//        $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
        $invoices->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);
        $room_payment_receipt->where('id','=',0);

        }
        if($request->get('customer')){

            $x=$request->get('customer');
//            $bookings->whereRaw("moc_name = '$x'");
//        $room_payment_receipt->where("guest_name",$x);
        }

            if($request->get('mog')==1 && $request->get('mog_id')!=''){
                $room_payment_receipt->where('customer_id',$request->get('mog_id'));
                $invoices->where('customer_id',$request->get('mog_id'));

                $bookings->where('customer_id',$request->get('mog_id'));
            }
            elseif($request->get('mog')==0 && $request->get('mog_id')!=''){

                $room_payment_receipt->where('mem_number',$request->get('mog_id'));
                $invoices->where('member_id',$request->get('mog_id'));
                $bookings->where('member_id',$request->get('mog_id'));

            }
            elseif($request->get('mog')==0 ){
                $room_payment_receipt->where('customer_id',$request->get('mog_id'));
                $invoices->where('customer_id',$request->get('mog_id'));

                $bookings->where('customer_id',$request->get('mog_id'));

                    }
            elseif($request->get('mog')==1 ){
                $room_payment_receipt->where('mem_number',$request->get('mog_id'));
                $invoices->where('member_id',$request->get('mog_id'));
                $bookings->where('member_id',$request->get('mog_id'));

            }

if($request->get('start_date')||
$request->get('end_date')||
$request->get('booking_no')||
$request->get('receipt')||
$request->get('invoice')||
$request->get('customer')||
$request->get('mog')||$request->get('mog')===0){


        $output_Booking=$bookings->get()->toArray();

        $output_room_payment_receipt=$room_payment_receipt->get()->toArray();
        $output_invoices=$invoices->get()->toArray();
}
        $data['customers']=customer::orderBy('customer_name', 'asc')->get();

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');

         $data['booking_no']=$request->get('booking_no');
         $data['receipt']=$request->get('receipt');
         $data['mog_id']=$request->get('mog_id');
         $data['mog']=$request->get('mog');
        if($request->get('start_date') || $request->get('mog_id') ) {
            $oBooking=room_booking::where('check_out_status', 1)->where('check_out_date','<',formatDate($request->get('start_date')));
            $oReceipt=room_payment_receipt::where('invoice_date','<',formatDate($request->get('start_date')));
            $oInvoice=finance_invoice::where('invoice_date','<',formatDate($request->get('start_date')));

                if($request->get('mog')==0){
                    $oReceipt->where('mem_number',$request->get('mog_id'));
                    $oBooking->where('member_id',$request->get('mog_id'));
                    $oInvoice->where('member_id',$request->get('mog_id'));
                }
                else{
                    $oReceipt->where('customer_id',$request->get('mog_id'));
                    $oBooking->where('customer_id',$request->get('mog_id'));
                    $oInvoice->where('customer_id',$request->get('mog_id'));

                }
//dd($oInvoice->toSql());




            $oBalance=$oReceipt->get()->sum('total')-$oBooking->get()->sum('grand_total')-$oInvoice->get()->sum('grand_total');
            $data['openingBalance']=$oBalance;

        }
        $data['data']=array_merge($output_Booking,$output_invoices,$output_room_payment_receipt);
      //  dd($data['data']);
        usort($data['data'],function($element1,$element2){
            $datetime1 = strtotime($element1['dateN']);
            $datetime2 = strtotime($element2['dateN']);
            return -$datetime2+$datetime1  ;
        });
$data['roomledgeraccounts']=0;

         return view('backend/finance-and-management/finance-ledger-accounts/finance-ledger-accounts',$data);
    }

    public function print(Request $request, finance_ledger_accounts $finance_ledger_accounts)
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




        $view=View::make('backend/finance-and-management/finance-ledger-accounts/finance-ledger-accounts',$data)->renderSections()['page-content'];
        return $view;

    }



     public function index_rooms(Request $request, finance_ledger_accounts $finance_ledger_accounts)
    {


        $bookings=room_booking::selectRaw('check_out_date as dateN,
        booking_no as no,
        moc_name as name,
        IF(customer_id IS NULL,"Member","Customer") as type,
        IF(member_id IS NULL,customer_id,member_id) as mog_id,
        room as details,grand_total as credit,
        id,
        0 as debit,"Room Booking" as Mtype')->where('check_out_status', 1);
        $room_payment_receipt=room_payment_receipt::selectRaw('invoice_date as dateN,
        invoice_no as no,
        guest_name as name,
        IF(customer_id IS NULL,"Member","Customer") as type,
        IF(mem_number IS NULL,customer_id,mem_number) as mog_id,
        payment_details as details,total as debit,
        id,
        0 as credit,"Room Payment Receipt" as Mtype');
        $invoices=finance_invoice::selectRaw('invoice_date as dateN,        invoice_no as no,
        name as name,
        IF(customer_id IS NULL,"Member","Customer") as type,
        IF(member_id IS NULL,customer_id,member_id) as mog_id,
        comments as details,grand_total as credit,
        id,
        0 as debit,"Invoice" as Mtype');
        $output_Booking=[];
        $output_room_payment_receipt=[];
        $output_invoices=[];
        if($request->get('start_date')){

            $bookings->where('check_out_date','>=',formatDate($request->get('start_date')));
            $room_payment_receipt->where('invoice_date','>=',formatDate($request->get('start_date')));
            $invoices->where('invoice_date','>=',formatDate($request->get('start_date')));

        }
        if($request->get('end_date')){
            $bookings->where('check_out_date','<=',formatDate($request->get('end_date')));
            $room_payment_receipt->where('invoice_date','<=',formatDate($request->get('end_date')));
            $invoices->where('invoice_date','<=',formatDate($request->get('end_date')));
        }
        if($request->get('booking_no')){
        $room_payment_receipt->where('id','=',0);
            $invoices->where('id','=',0);

        $bookings->where('booking_no','=',$request->get('booking_no'));
        }
        if($request->get('receipt')){
        $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);
            $invoices->where('id','=',0);

        } if($request->get('invoice')){
//        $room_payment_receipt->where('invoice_no','=',$request->get('receipt'));
        $invoices->where('invoice_no','=',$request->get('receipt'));
            $bookings->where('id','=',0);
        $room_payment_receipt->where('id','=',0);

        }
        if($request->get('customer')){

            $x=$request->get('customer');
//            $bookings->whereRaw("moc_name = '$x'");
//        $room_payment_receipt->where("guest_name",$x);
        }

            if($request->get('mog')==1 && $request->get('mog_id')!=''){
                $room_payment_receipt->where('customer_id',$request->get('mog_id'));
                $invoices->where('customer_id',$request->get('mog_id'));

                $bookings->where('customer_id',$request->get('mog_id'));
            }
            elseif($request->get('mog')==0 && $request->get('mog_id')!=''){

                $room_payment_receipt->where('mem_number',$request->get('mog_id'));
                $invoices->where('member_id',$request->get('mog_id'));
                $bookings->where('member_id',$request->get('mog_id'));

            }
            elseif($request->get('mog')==0 ){
                $room_payment_receipt->where('customer_id',$request->get('mog_id'));
                $invoices->where('customer_id',$request->get('mog_id'));

                $bookings->where('customer_id',$request->get('mog_id'));

                    }
            elseif($request->get('mog')==1 ){
                $room_payment_receipt->where('mem_number',$request->get('mog_id'));
                $invoices->where('member_id',$request->get('mog_id'));
                $bookings->where('member_id',$request->get('mog_id'));

            }

if($request->get('start_date')||
$request->get('end_date')||
$request->get('booking_no')||
$request->get('receipt')||
$request->get('invoice')||
$request->get('customer')||
$request->get('mog')||$request->get('mog')===0){


        $output_Booking=$bookings->get()->toArray();

        $output_room_payment_receipt=$room_payment_receipt->get()->toArray();
        $output_invoices=$invoices->get()->toArray();
}
        $data['customers']=customer::orderBy('customer_name', 'asc')->get();

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');

         $data['booking_no']=$request->get('booking_no');
         $data['receipt']=$request->get('receipt');
         $data['mog_id']=$request->get('mog_id');
         $data['mog']=$request->get('mog');
        if($request->get('start_date') || $request->get('mog_id') ) {
            $oBooking=room_booking::where('check_out_status', 1)->where('check_out_date','<',formatDate($request->get('start_date')));
            $oReceipt=room_payment_receipt::where('invoice_date','<',formatDate($request->get('start_date')));
            $oInvoice=finance_invoice::where('invoice_date','<',formatDate($request->get('start_date')));

                if($request->get('mog')==0){
                    $oReceipt->where('mem_number',$request->get('mog_id'));
                    $oBooking->where('member_id',$request->get('mog_id'));
                    $oInvoice->where('member_id',$request->get('mog_id'));
                }
                else{
                    $oReceipt->where('customer_id',$request->get('mog_id'));
                    $oBooking->where('customer_id',$request->get('mog_id'));
                    $oInvoice->where('customer_id',$request->get('mog_id'));

                }
//dd($oInvoice->toSql());




            $oBalance=$oReceipt->get()->sum('total')-$oBooking->get()->sum('grand_total')-$oInvoice->get()->sum('grand_total');
            $data['openingBalance']=$oBalance;

        }
        $data['data']=array_merge($output_Booking,$output_invoices,$output_room_payment_receipt);
      //  dd($data['data']);
        usort($data['data'],function($element1,$element2){
            $datetime1 = strtotime($element1['dateN']);
            $datetime2 = strtotime($element2['dateN']);
            return -$datetime2+$datetime1  ;
        });

     $data['roomledgeraccounts']=1;

         return view('backend/finance-and-management/finance-ledger-accounts/finance-ledger-accounts',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastval = finance_ledger_accounts::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }

         $data['customer']=customer::get();

        return view('backend/finance-and-management.finance-ledger-accounts.finance-ledger-accounts', $data);
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
     * @param  \App\finance_ledger_accounts  $finance_ledger_accounts
     * @return \Illuminate\Http\Response
     */
    public function show(finance_ledger_accounts $finance_ledger_accounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_ledger_accounts  $finance_ledger_accounts
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_ledger_accounts $finance_ledger_accounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_ledger_accounts  $finance_ledger_accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, finance_ledger_accounts $finance_ledger_accounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_ledger_accounts  $finance_ledger_accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_ledger_accounts $finance_ledger_accounts)
    {
        //
    }
}
