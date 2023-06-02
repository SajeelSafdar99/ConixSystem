<?php

namespace App\Http\Controllers;
use App\fnb_sale;
use App\finance_reports;
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

use App\exports\checkouts;
use App\exports\occupancy;
use App\room_check_out;

use App\room_booking;
use Carbon\Carbon;
use App\room_charges_type;
use App\room_category;
use App\room_category_charges;
use Maatwebsite\Excel\Facades\Excel;
use App\bookingsub;
use function foo\func;

class FinanceReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_reports $finance_reports)
    {
 $rooms=room::select('id','room_no','room_type')->with('roomtypes:id,desc')->get();

      $data['reportstatus']   = 0;
      $data['rooms']   = $rooms->toArray();
      $data['subs'] = room_charges_type::select('id','type')->get();
         return view('backend/finance-and-management/finance-reports/finance-reports',$data);
    }


     public function index_room(Request $request, finance_reports $finance_reports)
    {
        $rooms=room::select('id','room_no','room_type')->with('roomtypes:id,desc')->get();

      $data['reportstatus']   = 1;
      $data['rooms']   = $rooms->toArray();
      $data['subs'] = room_charges_type::select('id','type')->get();
         return view('backend/finance-and-management/finance-reports/finance-reports',$data);
    }



      public function indexdt(Request $request, room_booking $room_booking)
    {
//select('booking_id,room,check_in_date,check_out_date,moc_name,customer_id,booking_type,member_id')
          $dateF=$request->get('dateF');

        $r = room_booking::where('check_out_status', 1);
        if($request->get('mog')==0){
            if($request->get('customer')){
                $x=$request->get('customer');

                $c=membership::where('applicant_name','like',"%$x%")->first();
                $r=membership::find($c->id)->bookings()->where('check_out_status', 1);

            }
        }
        else{
            if($request->get('customer')){
                $x=$request->get('customer');

                $c=customer::where('customer_name','like',"%$x%")->first();
                $r=customer::find($c->id)->bookings()->where('check_out_status', 1);

            }

        }

        if($request->get('start_date')){
            $start_date=$request->get('start_date');
            if(strtotime($start_date)<=strtotime(settings('rooms_due'))){
                $start_date=settings('rooms_due');
            }
            $r->where($dateF,'>=',formatDate($start_date));
        }
         if($request->get('end_date')){
            $r->where($dateF,'<=',formatDate($request->get('end_date')));

        }
        
        if($request->get('room')){
//            dd($request->get('room'));
            if($request->get('room')!="null"){

            $r->where('room',($request->get('room')));
            }
        } if($request->get('cType')){
//            dd($request->get('room'));
            if($request->get('cType')!="null"){
                $cType=$request->get('cType');
            $r->whereHas('bookings',function($query) use ($cType){
                return  $query->where('charges_type_id',$cType);
                });
            }
        }
       
        if($request->get('receipt')){
            $r->where('booking_no','=',$request->get('receipt'));

        }
        if($request->get('paymentF')){
            if($request->get('paymentF')!="null") {
                $r->where($request->get('paymentF'), '>', 0);
            }
        }   if($request->get('payment_mode')){
          if($request->get('payment_mode')!="null") {
              $r->where('payment_mode', $request->get('payment_mode'));
          }
        }


        if(!($request->get('mog')!='undefined'||
        $request->get('customer')!=''||
$request->get('start_date')!=''||
$request->get('end_date')!=''||
$request->get('receipt')!='')){

            $date=Carbon::now()->subDays(2)->format('Y-m-d');
//            $r->where('check_out_date','>=',$date);
        }
       // dd($request->post('length'));
        $room_bookings=$r->select('member_id','customer_id','booking_no','id','charges','check_in_date','room','check_out_date','booking_type','nights','advance_paid','total_balance','total_charges','discount_amount','first_name','last_name','moc_name','pday_charges_id')->with('bookings');
        $room_bookings=$room_bookings->get();
//dd($room_bookings);
        $cc=0;

        return DataTables::of($room_bookings)

           /* ->addColumn('button', function ($room_bookings) {
                return //'<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('room-management/room-check-out/room-check-out-aeu/') . '/' . $room_checkout->id . '"><i class="fas fa-edit"></i></a></button>'.
               // '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-check-out/delete') . '/' . $room_checkout->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'.
                 '<button class="buttoncolor" title="Print"><a style="color:#000000;" href="' . url('room-management/room-invoice') . '/' . $room_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;
            })
*/

            ->addColumn('type', function ($room_bookings) {
                if($room_bookings->booking_type==1){
                     return "Guest ($room_bookings->customer_id)";
                }
                else{
                     return "Member ($room_bookings->member_id)";
                 }


                }) 

            ->addColumn('dtotal', function ($rx) use($room_bookings){


                $food=0;
                $mini_bar=0;
                $laundry=0;
                $services=0;
                $mattress=0;
                $misc=0;
$md=$room_bookings->toArray();
//dd(($rx->toArray()));
//                if(end($md)['id']==$rx->id){


                foreach($room_bookings as $m){

                    $x=$m->bookings->keyBy('charges_type_id');

                    $food+=isset($x[1])?$x[1]['charges_amount']:'0';
                    $mini_bar+=isset($x[2])?$x[2]['charges_amount']:'0';
                    $laundry+=isset($x[9])?$x[9]['charges_amount']:'0';
                    $services+=isset($x[8])?$x[8]['charges_amount']:'0';
                    $mattress+=isset($x[5])?$x[5]['charges_amount']:'0';
                    $misc+=isset($x[6])?$x[6]['charges_amount']:'0';

                }

//                }
               return [

                   'totalBill'=>number_format( $room_bookings->sum('total_charges')),
                   'totalDiscount'=>number_format( $room_bookings->sum('discount_amount')),
                   'totalRoomRent'=>number_format( $room_bookings->sum('charges')),
                   'totalAdvance'=>number_format( $room_bookings->sum('advance_paid')),
                   'totalFood'=>number_format( $food),
                   'totalMiniBar'=>number_format( $mini_bar),
                   'totalLaundry'=>number_format( $laundry),
                   'totalService'=>number_format( $services),
                   'totalMattress'=>number_format( $mattress),
                   'totalMISC'=>number_format( $misc),
                   'totalBalance'=>number_format( $room_bookings->sum('total_balance')),
//                   'totalBill'=>number_format( $r->sum('grand_total')),
//                   'totalC'=>number_format( $r->sum('grand_total')),

                   ] ;


            })
            ->addColumn('ctotal', function ($receipts) use ($room_bookings) {

                return number_format($room_bookings->count('id')) ;


            })
            ->addColumn('room', function ($room_bookings) {
                if($room_bookings->room && $room_bookings->room!=null && is_numeric($room_bookings->room) && $room_bookings->room!=''){
                     return  roomno($room_bookings->room) ;
                 }else{
                     return  roomno($room_bookings->room) ;
                 }
             


                })

            ->addColumn('name', function ($room_bookings) {
              return $room_bookings->first_name .' '. $room_bookings->last_name;

                })

              ->addColumn('booking_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->booking_date);


                })
                ->addColumn('check_in_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_in_date);


                })
                ->addColumn('check_out_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_out_date);


                })
            ->addColumn('food', function ($room_bookings) {
                $bookings=$room_bookings->bookings->keyBy('charges_type_id');
                return isset($bookings[1])?$bookings[1]->charges_amount:'-';



                })
            ->addColumn('mini_bar', function ($room_bookings) {
                $bookings=$room_bookings->bookings->keyBy('charges_type_id');

                return isset($bookings[2])?$bookings[2]->charges_amount:'-';



                })
            ->addColumn('laundry', function ($room_bookings) {
                                $bookings=$room_bookings->bookings->keyBy('charges_type_id');

                return isset($bookings[9])?$bookings[9]->charges_amount:'-';




                })
            ->addColumn('services', function ($room_bookings) {
                                $bookings=$room_bookings->bookings->keyBy('charges_type_id');

                return isset($bookings[8])?$bookings[8]->charges_amount:'-';








                })
            ->addColumn('mattress', function ($room_bookings) {
                                $bookings=$room_bookings->bookings->keyBy('charges_type_id');

                return isset($bookings[5])?$bookings[5]->charges_amount:'-';




                })
            ->addColumn('misc', function ($room_bookings) {
                                $bookings=$room_bookings->bookings->keyBy('charges_type_id');

                return isset($bookings[6])?$bookings[6]->charges_amount:'-';




                })

              ->addColumn('status', function ($room_bookings) {
                return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-invoice/') . '/' . $room_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;


            })

            ->rawColumns(['room','room_charges_type', 'room_booking','bookingsub', 'room_category', 'status'])
        ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(room_booking $room_booking,Request $request)
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\room_check_out  $room_check_out
     * @return \Illuminate\Http\Response
     */
    public function show(room_check_out $room_check_out)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_check_out  $room_check_out
     * @return \Illuminate\Http\Response
     */
    public function edit(room_check_out $room_check_out,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_check_out  $room_check_out
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_check_out  $room_check_out
     * @return \Illuminate\Http\Response
     */


  /*    public function destroy(room_check_out $room_check_out,$id)
    {
        $roomcheckout= $room_check_out ::where('id', $id)->delete();
        if($roomcheckout){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('room-management/room-check-out');
    }*/

    public function export(Request $request,  room_booking $room_booking){
        if($request->get('type')==1){
     ob_end_clean(); 
     ob_start();
     return Excel::download(new occupancy,'occupancy.xlsx');
        }
        else{
     ob_end_clean();  
     ob_start();
            return Excel::download(new checkouts,'checkout.xlsx');

        }
    }




           public function book_vue(Request $request, fnb_sale $fnb_sale)
    {
         return view('backend/finance-and-management/finance-books/transaction-book-vue');
    }

       public function book_init_vue(Request $request)
    {
  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select
       fnb_item_categories.desc                               as cat,
       sum( fnb_sales_subs.item_discount)              as discount,

    sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
     sum(if(fnb_sales.ent = 1 or fnb_sales.type=3,fnb_sales.grand_total,0)) as entgross

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null) and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
  
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0  
group by cat
order by cat');

     return $data;
}

    public function cash_vue(Request $request, fnb_sale $fnb_sale)
    {
         return view('backend/finance-and-management/finance-books/cash-book-vue');
    }
 
       public function cash_init_vue(Request $request)
    {

         $data=[];


         $search='';
         $search2='';
if($request->get('start_date')){
    $search.=" and transactions.date >= '$request->start_date' ";
   //  $search2.=" and coa_transactions.date >= '$request->start_date' ";
}if($request->get('end_date')){
    $search.=" and transactions.date <= '$request->end_date' ";
   // $search2.=" and coa_transactions.date <= '$request->end_date' ";
}

 $data['inflows'] =\Illuminate\Support\Facades\DB::select(
      'select
    coas.name                               as detailname,
    if(coas.parent is null,coas.name,coaz.name) as cat,
  
    sum(if(transactions.payment_method = 22,transactions.trans_amount,0)) as cashgross,
    sum(if(transactions.payment_method = 24,transactions.trans_amount,0)) as creditgross,
    sum(if(transactions.payment_method = 23 or transactions.payment_method = 25,transactions.trans_amount,0)) as othergross

from transactions
       
    left outer join trans_types on (trans_types.id = transactions.trans_type or trans_types.id = transactions.pos_location)
    left outer join coa_accounts_controls coas on coas.code=trans_types.account
    left outer join coa_accounts_controls coaz on coaz.code=coas.parent
  
where transactions.deleted_at is null and transactions.id is not null and transactions.debit_or_credit=1 and transactions.type=3 and transactions.payment_method is not null and trans_types.account is not null  '.$search.'
group by cat,transactions.id
order by cat,transactions.id asc');


  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select
    coas.name                               as detailname,
    if(coas.parent is null,coas.name,coaz.name) as cat,
    
    sum(if(transactions.payment_method = 22,transactions.trans_amount,0)) as cashgross,
    sum(if(transactions.payment_method = 24,transactions.trans_amount,0)) as creditgross,
    sum(if(transactions.payment_method = 23 or transactions.payment_method = 25,transactions.trans_amount,0)) as othergross

from finance_expense
       
    left outer join transactions on transactions.trans_type=9
    and transactions.trans_type_id=finance_expense.id and
                              transactions.debit_or_credit=0 and
                              transactions.type=3 and transactions.deleted_at is null
    left outer join coa_accounts_controls coas on coas.code=transactions.account
    left outer join coa_accounts_controls coaz on coaz.code=coas.parent
  
where finance_expense.deleted_at is null and finance_expense.id is not null '.$search.'
group by cat,transactions.id
order by cat,transactions.id asc');

 /* $data['inflows'] =\Illuminate\Support\Facades\DB::select(
      'select
    coas.name                               as detailname,
    if(coas.parent is null,coas.name,coaz.name) as cat,
  
    sum(if(transactions.payment_method = 22,transactions.trans_amount,0)) as cashgross,
    sum(if(transactions.payment_method = 24,transactions.trans_amount,0)) as creditgross,
    sum(if(transactions.payment_method = 23 or transactions.payment_method = 25,transactions.trans_amount,0)) as othergross

from transactions
       
    left outer join trans_types on (trans_types.id = transactions.trans_type or trans_types.id = transactions.pos_location)
    left outer join coa_accounts_controls coas on coas.code=trans_types.account
    left outer join coa_accounts_controls coaz on coaz.code=coas.parent
  
where transactions.deleted_at is null and transactions.id is not null and transactions.debit_or_credit=0 and transactions.payment_method is not null and trans_types.account is not null '.$search.'
group by cat,transactions.id
order by cat,transactions.id asc');


  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select
    coas.name                               as detailname,
    if(coas.parent is null,coas.name,coaz.name) as cat,
    
    sum(if(coa_transactions.payment_method = 1,coa_transactions.amount,0)) as cashgross,
    sum(if(coa_transactions.payment_method = 3,coa_transactions.amount,0)) as creditgross,
    sum(if(coa_transactions.payment_method = 2 or coa_transactions.payment_method = 4,coa_transactions.amount,0)) as othergross

from payment_finance_sheets
       
    left outer join coa_transactions on coa_transactions.trans_type=35
    and coa_transactions.trans_type_id=payment_finance_sheets.id and
                              coa_transactions.debit_or_credit=1 and coa_transactions.deleted_at is null
    left outer join coa_accounts_controls coas on coas.code=coa_transactions.account
    left outer join coa_accounts_controls coaz on coaz.code=coas.parent
  
where payment_finance_sheets.deleted_at is null and payment_finance_sheets.id is not null '.$search2.'
group by cat,coa_transactions.id
order by cat,coa_transactions.id asc');*/

     return $data;
}


public function bank_vue(Request $request, fnb_sale $fnb_sale)
    {
         return view('backend/finance-and-management/finance-books/bank-ledger-vue');
    }

       public function bank_init_vue(Request $request)
{
  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select
       fnb_item_categories.desc                               as cat,
       sum( fnb_sales_subs.item_discount)              as discount,

    sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
     sum(if(fnb_sales.ent = 1 or fnb_sales.type=3,fnb_sales.grand_total,0)) as entgross

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null) and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
  
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0  
group by cat
order by cat');

     return $data;
}


}
