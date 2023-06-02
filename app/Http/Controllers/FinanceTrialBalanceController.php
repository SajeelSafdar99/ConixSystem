<?php

namespace App\Http\Controllers;

use App\finance_trial_balance;
use App\membership;
use App\room_booking;
use App\room;
use App\room_type;
use App\trans_type;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Session;
use App\customer;
use App\room_payment_receipt;
use App\hr_company;
use App\hr_department;
use App\hr_sub_department;
use App\hr_employment;
use App\coa_account;

class FinanceTrialBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function supplier_vue(Request $request, finance_trial_balance $finance_trial_balance)
    {
       return view('backend/finance-and-management/finance-trial-balance/finance-supplier-trial-balance-vue');
    }

       public function supplier_init_vue(Request $request)
    {
$search='';
if($request->get('start_date')){
    $search.=" and trans.date >= '$request->start_date' ";
}if($request->get('end_date')){
    $search.=" and trans.date <= '$request->end_date' ";
}if($request->get('filter')!=0){
    $search.=" and trans.trans_type = '$request->filter' ";
}
/*if($request->get('ent')=='Include ENT and CTS'){
   $search.=" and trans.ent is not null  ";
}
if($request->get('ent')=='Exclude ENT and CTS'){
    $search.=" and trans.ent = 0 ";
}
if($request->get('ent')=='Only ENT'){
    $search.=" and trans.ent = 1 ";
}
if($request->get('ent')=='Only CTS'){
    $search.=" and trans.ent = 2 ";
}*/
  $data['trials'] =\Illuminate\Support\Facades\DB::select("select t.name,t.type,t.id,t.no_id,sum(if(trans.debit_or_credit=0,trans.trans_amount,0)) as credit,sum(if(trans.debit_or_credit=1,trans.trans_amount,0)) as debit,t.designation as designation,t.company as company,t.department as department,t.subdepartment as subdepartment from (
   
         select person_name as name, 2 as type, id, id as no_id,0 as designation,0 as company,0 as department,0 as subdepartment
         from finance_ledger_people
         where deleted_at is null
    ) as t
    inner join transactions  trans on trans.trans_moc_type=t.type and trans.trans_moc=t.id and trans.type in (4,5,6,7) and trans.deleted_at is null and (trans.is_active=1 || trans.debit_or_credit=1) $search
where 1=1 group by t.id,t.type order by id, type");

 $data['filters']=trans_type::all();
 $data['departments']=hr_department::where('status',1)->get();
$data['companies']=hr_company::where('status',1)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['employees']=hr_employment::where('active',1)->get();


/* select  CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name, 0 as type,id,mem_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from memberships where deleted_at is null and active!=7
    union all
    select customer_name as name, 1 as type, id,customer_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from customers where deleted_at is null
    union all
    select name,3 as type,id,application_no as no_id,designation as designation,company as company,department as department,subdepartment as subdepartment from hr_employments where deleted_at is null
    union all*/
/*

    select name,3 as type,id,application_no as no_id,designation,company,department,subdepartment from hr_employments where deleted_at is null*/
     return $data;
}





      public function index_vue(Request $request, finance_trial_balance $finance_trial_balance)
    {
       return view('backend/finance-and-management/finance-trial-balance/finance-trial-balance-vue');
    }

       public function trial_init_vue(Request $request)
    {
$search='';
if($request->get('start_date')){
    $search.=" and trans.date >= '$request->start_date' ";
}if($request->get('end_date')){
    $search.=" and trans.date <= '$request->end_date' ";
}if($request->get('filter')!=0){
    $search.=" and trans.trans_type = '$request->filter' ";
}
if($request->get('ent')=='Include ENT and CTS'){
   $search.=" and trans.ent is not null  ";
}
if($request->get('ent')=='Exclude ENT and CTS'){
    $search.=" and trans.ent = 0 ";
}
if($request->get('ent')=='Only ENT'){
    $search.=" and trans.ent = 1 ";
}
if($request->get('ent')=='Only CTS'){
    $search.=" and trans.ent = 2 ";
}
  $data['trials'] =\Illuminate\Support\Facades\DB::select("select t.name,t.type,t.id,t.no_id,sum(if(trans.debit_or_credit=0,trans.trans_amount,0)) as credit,sum(if(trans.debit_or_credit=1,trans.trans_amount,0)) as debit,t.designation as designation,t.company as company,t.department as department,t.subdepartment as subdepartment from (
    select  CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name, 0 as type,id,mem_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from memberships where deleted_at is null and active!=7
    
    union all
                select  CONCAT(coalesce(corporate_memberships.title, ''), ' ', coalesce(corporate_memberships.first_name, ''), ' ',
              coalesce(corporate_memberships.middle_name, ''), ' ',
              coalesce(corporate_memberships.applicant_name, '')) as name, 6 as type,id,mem_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from corporate_memberships where deleted_at is null and active!=7
    union all
    select customer_name as name, 1 as type, id,customer_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from customers where deleted_at is null
    union all
    select name,3 as type,id,application_no as no_id,designation as designation,company as company,department as department,subdepartment as subdepartment from hr_employments where deleted_at is null
    
    ) as t
    inner join transactions  trans on trans.trans_moc_type=t.type and trans.trans_moc=t.id and trans.type in (1,2,7) and trans.deleted_at is null and (trans.is_active=1 || trans.debit_or_credit=0) $search
where 1=1 group by t.id,t.type order by id, type");


   //union all
   //      select person_name as name, 2 as type, id, id as no_id,0 as designation,0 as company,0 as department,0 as subdepartment
   //      from finance_ledger_people
   //     where deleted_at is null
 $data['filters']=trans_type::all();
$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['employees']=hr_employment::where('active',1)->get();
/*

    select name,3 as type,id,application_no as no_id,designation,company,department,subdepartment from hr_employments where deleted_at is null*/
     return $data;

}

   public function index(Request $request, finance_trial_balance $finance_trial_balance)
   {

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');
         $data['mog']=$request->get('mog');
         $data['types']=trans_type::all();
//dd($data);

         $data['roomtrialbalance']=0;

         return view('backend/finance-and-management/finance-trial-balance/finance-trial-balance',$data);
   }
   public function indexdt(Request $request,finance_trial_balance $finance_trial_balance){
       $data['member']=1;
       $whereBooking='';
       $whereBooking2='';
       $whereinvoice='';
       $filter='';
       $fname='All';
       if($request->get('start_date')){
           $whereBooking=' AND `transactions`.`date` '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
//           $whereinvoice='AND date '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
       }
       if($request->get('end_date')){
           $whereBooking2=' AND `transactions`.`date` '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');
//           $whereinvoice='AND date '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');

       }
       if($request->get('filter')){
          $filter=' and trans_type = '.$request->get('filter');
            $fname=trans_type::find($request->get('filter'))->name;
       }
       $moc=membership::selectRaw('memberships.applicant_name as name,
memberships.mem_no as num,
memberships.id as id,

    (select sum(trans_amount) from transactions where debit_or_credit=1 and trans_moc_type=0 and  trans_moc=memberships.id and is_active=1 '.$filter.$whereBooking.$whereBooking2.' and trans_type In(select id from trans_types )) as credit,
    (select sum(trans_amount) from transactions where debit_or_credit=0 and trans_moc_type=0 and trans_moc=memberships.id '.$filter.$whereBooking.$whereBooking2.' and trans_type In(select id from trans_types )) as debit

    ');

       if($request->get('mog')==1){
           $moc=customer::selectRaw('customers.customer_name as name,
customers.customer_no as num,
customers.id as id,
     (select sum(trans_amount) from transactions where debit_or_credit=1 and trans_moc_type=1 and trans_moc=customers.id and is_active=1 '.$filter.$whereBooking.' and trans_type In(select id from trans_types )) as credit,
    (select sum(trans_amount) from transactions where debit_or_credit=0 and trans_moc_type=1 and trans_moc=customers.id '.$filter.$whereBooking.' and trans_type In(select id from trans_types )) as debit


    ');

           if($request->get('member_id')){
               $moc->whereRaw('customers.id ='.$request->get('member_id').'');

           }
           $moc->groupBy(DB::raw('customers.id'));
       }
       else{
           if($request->get('member_id')){

               $moc->whereRaw('memberships.id ='.$request->get('member_id').'');

           }
           $moc->groupBy(DB::raw('memberships.id'));
       }


       if($request->get('paid')){
           if($request->get('paid')==1){
               $moc->havingRaw("(IFNULL(debit,0)-IFNULL(credit,0))<0");

           }
           if($request->get('paid')==2){
//               $moc->havingRaw("credit > 0 or debit>0");
               $moc->havingRaw("(IFNULL(debit,0)-IFNULL(credit,0))>0");

           }

       }
       else{
           $moc->havingRaw("credit > 0 or debit>0");
       }
        $moc->orderBy("id",'asc');
        //dd($moc->toSql());
       if(1==1){
           $d=$moc->get();

       }
else{
    $d=[];
}
$s=0;
$s2=0;
        foreach($d as $x){
            $s=$s+$x->credit;
            $s2=$s2+$x->debit;
        }
       return DataTables::of($d)


           ->addColumn('detail', function ($table) use($fname) {
               return $fname;

           })   ->addColumn('type', function ($table) use ($request) {
               return $request->get('mog')==1?'Customer':'Member';

           })->addColumn('type', function ($table) use ($request) {
               return $request->get('mog')==1?'Customer':'Member';

           })
           ->with('credit', $s)
           ->with('debit', $s2)
           ->addIndexColumn()
           ->make(true);

   }


   public function index_room(Request $request, finance_trial_balance $finance_trial_balance)
   {
      $data['member']=1;
      $whereBooking='';
      $whereinvoice='';
                     if($request->get('start_date')){
                  $whereBooking='AND check_out_date '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
                         $whereinvoice='AND invoice_date '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
              }
              if($request->get('end_date')){
                  $whereBooking='AND check_out_date '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');
                  $whereinvoice='AND invoice_date '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');

              }
        $moc=membership::selectRaw('memberships.applicant_name as name,
memberships.mem_no as num,
memberships.id as id,
concat(
(select if(sum(grand_total)>0,sum(grand_total),0)  from room_bookings where check_out_status=1  and deleted_at is null  and member_id=memberships.id  '.$whereBooking.')+
(select if(sum(grand_total)>0,sum(grand_total),0) from finance_invoices where member_id=memberships.id '.$whereinvoice.' and deleted_at is null )

) as credit,

    (select if(sum(total)>0,sum(total),0) from room_payment_receipts where mem_number=memberships.id '.$whereinvoice.' and deleted_at is null ) AS debit');
//        $moc=membership::selectRaw('memberships.applicant_name as name,
//memberships.mem_no as num,
//memberships.id as id,
//IF(SUM( DISTINCT room_bookings.grand_total)>0,SUM( DISTINCT room_bookings.grand_total),0)
//+
//IF(SUM( DISTINCT finance_invoices.grand_total)>0,SUM( DISTINCT finance_invoices.grand_total),0)
// as credit,
//IF(SUM( DISTINCT room_payment_receipts.total)>0,SUM( DISTINCT room_payment_receipts.total),0) as debit');
//        $moc->leftJoin('room_bookings',function($join) use ($request){
//           $join->on('room_bookings.member_id','=','memberships.id');
//            $join->on('room_bookings.check_out_status', '=', DB::raw(1));
//            if($request->get('start_date')){
//                $join->on('room_bookings.check_out_date','>=',DB::raw('"'.formatDate($request->get('start_date')).'"'));
//            }
//            if($request->get('end_date')){
//                $join->on('room_bookings.check_out_date','<=',DB::raw('"'.formatDate($request->get('end_date')).'"'));
//            }
//
//
//
//        });
//        $moc->leftJoin('room_payment_receipts',function($join) use ($request){
//           $join->on('room_payment_receipts.mem_number','=','memberships.id');
//            if($request->get('start_date')){
//                $join->on('room_payment_receipts.invoice_date','>=',DB::raw('"'.formatDate($request->get('start_date')).'"'));
//
////                $join->on(DB::raw('room_payment_receipts.invoice_date >= "'.DB::raw('"'.formatDate($request->get('start_date')).'"').'"'));
//
//            }
//            if($request->get('end_date')){
////                $join->on(DB::raw('room_payment_receipts.invoice_date <= "'.formatDate($request->get('end_date')).'"'));
//                $join->on('room_payment_receipts.invoice_date','<=',DB::raw('"'.formatDate($request->get('end_date')).'"'));
//
//
//            }
//        });
//        $moc->leftJoin('finance_invoices',function($join) use ($request){
//           $join->on('finance_invoices.member_id','=','memberships.id');
//            if($request->get('start_date')){
////                $join->on(DB::raw('finance_invoices.invoice_date >= "'.DB::raw('"'.formatDate($request->get('start_date')).'"').'"'));
//                $join->on('finance_invoices.invoice_date','>=',DB::raw('"'.formatDate($request->get('start_date')).'"'));
//
//            }
//            if($request->get('end_date')){
////                $join->on(DB::raw('finance_invoices.invoice_date <= "'.DB::raw('"'.formatDate($request->get('end_date')).'"').'"'));
//                $join->on('finance_invoices.invoice_date','<=',DB::raw('"'.formatDate($request->get('end_date')).'"'));
//
//            }
//        });

      if($request->get('mog')==1){
          $moc=customer::selectRaw('customers.customer_name as name,
customers.customer_no as num,
customers.id as id,
 concat(
 (select if(sum(grand_total)>0,sum(grand_total),0)  from room_bookings where check_out_status=1  and customer_id=customers.id '.$whereBooking.' and deleted_at is null )+
 (select if(sum(grand_total)>0,sum(grand_total),0) from finance_invoices where customer_id=customers.id '.$whereinvoice.' and deleted_at is null )
 ) as credit,

    (select if(sum(total)>0,sum(total),0) from room_payment_receipts where customer_id=customers.id '.$whereinvoice.' and deleted_at is null ) AS debit');
//          $moc=customer::selectRaw('customers.customer_name as name,
//customers.customer_no as num,
//customers.id as id,
//IF(SUM( DISTINCT room_bookings.grand_total)>0,SUM( DISTINCT room_bookings.grand_total),0)
//+
//IF(SUM( DISTINCT finance_invoices.grand_total)>0,SUM( DISTINCT finance_invoices.grand_total),0)
// as credit,
//IF(SUM( DISTINCT room_payment_receipts.total)>0,SUM( DISTINCT room_payment_receipts.total),0) as debit');
//          $moc->leftJoin('room_bookings',function($join) use ($request){
//              $join->on('room_bookings.customer_id','=','customers.id');
//              $join->on('room_bookings.check_out_status', '=', DB::raw(1));
//              if($request->get('start_date')){
//                  $join->on('room_bookings.check_out_date','>=',DB::raw('"'.formatDate($request->get('start_date')).'"'));
//              }
//              if($request->get('end_date')){
//                  $join->on('room_bookings.check_out_date','<=',DB::raw('"'.formatDate($request->get('end_date')).'"'));
//              }
//
//
//
//          });
//          $moc->leftJoin('room_payment_receipts',function($join) use ($request){
//              $join->on('room_payment_receipts.customer_id','=','customers.id');
//              if($request->get('start_date')){
//                  $join->on('room_payment_receipts.invoice_date','>=',DB::raw('"'.formatDate($request->get('start_date')).'"'));
//
////                $join->on(DB::raw('room_payment_receipts.invoice_date >= "'.DB::raw('"'.formatDate($request->get('start_date')).'"').'"'));
//
//              }
//              if($request->get('end_date')){
////                $join->on(DB::raw('room_payment_receipts.invoice_date <= "'.formatDate($request->get('end_date')).'"'));
//                  $join->on('room_payment_receipts.invoice_date','<=',DB::raw('"'.formatDate($request->get('end_date')).'"'));
//
//
//              }
//          });
//          $moc->leftJoin('finance_invoices',function($join) use ($request){
//              $join->on('finance_invoices.customer_id','=','customers.id');
//              if($request->get('start_date')){
////                $join->on(DB::raw('finance_invoices.invoice_date >= "'.DB::raw('"'.formatDate($request->get('start_date')).'"').'"'));
//                  $join->on('finance_invoices.invoice_date','>=',DB::raw('"'.formatDate($request->get('start_date')).'"'));
//
//              }
//              if($request->get('end_date')){
////                $join->on(DB::raw('finance_invoices.invoice_date <= "'.DB::raw('"'.formatDate($request->get('end_date')).'"').'"'));
//                  $join->on('finance_invoices.invoice_date','<=',DB::raw('"'.formatDate($request->get('end_date')).'"'));
//
//              }
//          });
          if($request->get('customer')){
              $moc->whereRaw('customers.customer_name LIKE "%'.$request->get('customer').'%"');

          }
          $moc->groupBy(DB::raw('customers.id'));
      }
      else{
          if($request->get('customer')){

          $moc->whereRaw('memberships.applicant_name LIKE "%'.$request->get('customer').'%"');
          }
          $moc->groupBy(DB::raw('memberships.id'));
      }
//      $moc->sum(\DB::raw('roomBooking + invoices'));


         $data['rows']=$moc->get();
//        foreach($data['rows'] as $key=>$x){
//            $x=(object)$x;
//           $dm= $x->roomBooking + $x->invoices;
//           $data['rows'][$key]=(object)$data['rows'][$key];
//           $data['rows'][$key]->credit=$dm;
//   }
      //  dd($data['rows']);

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');
         $data['mog']=$request->get('mog');
//dd($data);
         $data['roomtrialbalance']=1;

         return view('backend/finance-and-management/finance-trial-balance/finance-trial-balance',$data);
   }


     public function print(Request $request, finance_trial_balance $finance_trial_balance)
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




        $view=View::make('backend/finance-and-management/finance-trial-balance/finance-trial-balance',$data)->renderSections()['page-content'];
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
    public function show(finance_trial_balance $finance_trial_balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_account_details  $finance_account_details
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_trial_balance $finance_trial_balance)
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
    public function update(Request $request, finance_trial_balance $finance_trial_balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_account_details  $finance_account_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_trial_balance $finance_trial_balance)
    {
        //
    }
}
