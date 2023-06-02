<?php

namespace App\Http\Controllers;
use App\guest_type;
use App\customer;
use App\trans_relations;
use App\exports\checkouts;
use App\exports\occupancy;
use App\membership;
use App\room_check_out;
use App\finance_payment_methods; $data['payment_methods']=finance_payment_methods::where('status',1)->get();
use App\room_booking;
use App\transactions;
use Carbon\Carbon;
use DataTables;
use App\room;
use App\mem_family;
use App\room_type;
use App\room_charges_type;
use Illuminate\Http\Request;
use App\room_category;
use App\room_category_charges;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\bookingsub;
use App\fnb_sale;
use DB;
use function foo\func;

class RoomCheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, room_check_out $room_check_out)
    {
         $r = room_booking::where('check_out_status', 1)->where('check_out_date','>=',settings('rooms_due'));
        $data['totalcharges']=0;
        $data['totalroomcharges']= 0;
        $data['totaldiscount']= 0;
        $data['totalgrandtotal']= 0;
        return view('backend/room-management/room-check-out/room-check-out',$data);

    }


    public function index_vue(Request $request, room_check_out $room_check_out)
    {

        return view('backend/room-management/room-check-out/room-check-out-vue');

    } 

       public function checkout_init(Request $request)
    {
    $start_date=settings('rooms_due');

  $data['bookings'] =\Illuminate\Support\Facades\DB::select(
      'select room_bookings.*, memberships.mem_no as mem_no, st.desc as activity,sum((transactions.trans_amount) ) as paid_amount , GROUP_CONCAT((transactions.receipt_id)) as reciept_id,(t1.is_active) as is_active,(t1.id) as transid,
        users.name as cashiername,  corporate_memberships.mem_no as co_mem_no, stt.desc as coactivity,
          media.url as image,
        room_bookings.grand_total as invoice_total,
        room_bookings.food_bill_charges as food_bills_total,
        (room_bookings.grand_total - room_bookings.food_bill_charges) AS grand_total,
if(room_bookings.member_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC,
CONCAT_WS(" ",corporate_memberships.title,corporate_memberships.first_name,corporate_memberships.middle_name,corporate_memberships.applicant_name) as  nameMOCC,
rooms.room_no as room

from room_bookings

left outer join rooms on rooms.id =room_bookings.room and rooms.status=1
left outer join users on users.id =room_bookings.created_by and users.status=1
left outer join transactions as t1 on t1.trans_type=1 and t1.trans_type_id=room_bookings.id and t1.debit_or_credit=1 and t1.type=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=1 and transactions.trans_type_id=room_bookings.id and transactions.debit_or_credit=0 and transactions.type=2 and transactions.deleted_at is null
left outer join memberships on memberships.id = room_bookings.member_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id = room_bookings.corporate_id and corporate_memberships.deleted_at is null and room_bookings.booking_type=6
left outer join mem_statuses st on st.id=memberships.active and st.status=1
left outer join mem_statuses stt on stt.id=corporate_memberships.active and stt.status=1
left outer join customers on customers.id =room_bookings.customer_id and customers.deleted_at is null

left outer join 
( select trans_type_id,url
    from media
    left outer join room_bookings as b on b.id = media.trans_type_id
    group by media.trans_type_id
    order by media.updated_at desc
) as media on room_bookings.id = media.trans_type_id

where room_bookings.check_out_status=1  and room_bookings.deleted_at is null and room_bookings.check_out_date>="'.$start_date.'" group by room_bookings.id order by room_bookings.check_out_date desc');
// left outer join media on media.trans_type=1 and media.trans_type_id=room_bookings.id and media.deleted_at is null
$data['roomnos']=room::where('status',1)->get();

     return $data;

}





    public function unpaid_vue(Request $request, room_check_out $room_check_out)
    {
        return view('backend/room-management/room-check-out/room-check-out-unpaid-vue');
    }

       public function unpaid_init(Request $request)
    {

  $data['bookings'] =\Illuminate\Support\Facades\DB::select(
      'select room_bookings.*, memberships.mem_no as mem_no, mem_statuses.desc as activity,sum(transactions.trans_amount ) as paid_amount , GROUP_CONCAT(transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,(t1.id) as transid,
        users.name as cashiername,
if(room_bookings.member_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC,
rooms.room_no as room

from room_bookings

left outer join rooms on rooms.id =room_bookings.room and rooms.status=1
left outer join users on users.id =room_bookings.created_by and users.status=1
left outer join transactions as t1 on t1.trans_type=1 and t1.trans_type_id=room_bookings.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=1 and transactions.trans_type_id=room_bookings.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join memberships on memberships.id = room_bookings.member_id and memberships.deleted_at is null
left outer join mem_statuses on mem_statuses.id=memberships.active and mem_statuses.status=1
left outer join customers on customers.id =room_bookings.customer_id and customers.deleted_at is null
where room_bookings.check_out_status=1  and room_bookings.deleted_at is null group by room_bookings.id order by room_bookings.check_out_date desc');

 $data['roomnos']=room::where('status',1)->get();
 
     return $data;
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
     public function indexdt(Request $request, room_booking $room_booking)
    {

        $r = room_booking::where('check_out_status', 1);
        if($request->get('mog')==0){
            if($request->get('customer')){
                $x=$request->get('customer');

              //  dd($r->member_id);

               $r->where('member_id',$x);

            }
        }
        else{
            if($request->get('customer')){
                $x=$request->get('customer');

                  $r->where('customer_id',$x);

            }

        }

        if($request->get('start_date')){
            $r->where('check_out_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('check_out_date','<=',formatDate($request->get('end_date')));

        }
        if($request->get('receipt')){
            $r->where('booking_no','=',$request->get('receipt'));

        }


        if(!(
        $request->get('customer')!=''||
$request->get('start_date')!=''||
$request->get('end_date')!=''||
$request->get('receipt')!='' ||$request->get('mog')!=''||$request->get('status')!='') ){

//            $date=Carbon::now()->subDays(2)->format('Y-m-d');
//            $r->where('check_out_date','>=',$date);
        }
       //echo $r->toSql();
         $room_bookings=$r->with(['invoices','invoices.receipts','invoices.receipts.receiptDetails'])->get();

        $data['totalcharges']= $room_bookings->sum('charges');
        $data['totalroomcharges']= $room_bookings->sum('total_room_charges');
        $data['totaldiscount']= $room_bookings->sum('discount_amount');
        $data['totalgrandtotal']= $room_bookings->sum('grand_total');
        $data['totalgrandtotalInvoices']= $room_bookings->pluck('invoices')->sum('trans_amount');
        $dvv= $room_bookings->pluck('invoices.receipts');
        $data['totalgrandtotalRecepts']=0;
        foreach($dvv as $c){
            if($c){

                $data['totalgrandtotalRecepts']=$data['totalgrandtotalRecepts']+$c->pluck('receiptDetails')->sum('trans_amount');
            }
        }
        $data['totalgrandtotalBalance']=$data['totalgrandtotalInvoices']-$data['totalgrandtotalRecepts'];
//        $data['totalgrandtotalReceipts']= $room_bookings->invoices->receipts->sum('receiptDetails.paid_amount');

        $dx= DataTables::of($room_bookings)


        ->addColumn('balancestatus', function ($room_bookings) {
            if($room_bookings->invoices){


$x=0;
            foreach ($room_bookings->invoices->receipts as $v){
     $x=$x+$v->receiptDetails->trans_amount;
            }


            $resultant = $room_bookings->invoices->trans_amount-$x;

               if($resultant==0){
return '<button class=" btn btn-outline-success active">Paid</button>';
               }

               else{
                if($room_bookings->booking_type==0){
                return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?'. 'memid='. $room_bookings->member_id . '">Unpaid</a></button>';
                }
                else if($room_bookings->booking_type==1){
                  return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?'. 'guestid='. $room_bookings->customer_id . '">Unpaid</a></button>';
                }


               }
            }

            })


  ->addColumn('details_d', function ($room_bookings) {
      if($room_bookings->invoices){
      $x=0;
      $m='';
      foreach ($room_bookings->invoices->receipts as $v){
          $c=$v->receiptDetails->type->name;
          $d=$v->receiptDetails;
          $m=$m. "   <a target='_blank' href='".route('cash.receipt.print',$d['receipt_id'])."'>($d[receipt_id] - $c)</a><br>";
      }
      return $m;
      }

           })


           ->addColumn('amountpaid', function ($room_bookings) {
               $x=0;
               if($room_bookings->invoices) {

                   foreach ($room_bookings->invoices->receipts as $v) {
                       $x = $x + $v->receiptDetails->trans_amount;
                   }
               }
            return $x;

           })

           ->addColumn('finalbalance', function ($room_bookings) {
               $x=0;
               if($room_bookings->invoices) {

                   foreach ($room_bookings->invoices->receipts as $v) {
                       $x = $x + $v->receiptDetails->trans_amount;
                   }
               }
            return $room_bookings->grand_total-$x;

           })

            ->addColumn('type', function ($room_bookings) {
                if($room_bookings->booking_type==1){
                     return "Guest ($room_bookings->customer_id)";
                }
                else{
                     return "Member"." "."(".($room_bookings->member?$room_bookings->member->mem_no:'').")";
                 }


                })

           ->addColumn('dtotal', function ($room_bookings) {
             return 1;

            })
            ->addColumn('ctotal', function ($room_bookings) {
             return 1;




            })
            ->addColumn('room', function ($room_bookings) {
              return roomtypename($room_bookings->room).- roomno($room_bookings->room) ;


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
                    return [
                        'display' =>($room_bookings->check_out_date &&$room_bookings->check_out_date != '0000-00-00 00:00:00') ? with(new \Illuminate\Support\Carbon($room_bookings->check_out_date))->format('d/m/Y') : '',
                        'timestamp' =>($room_bookings->check_out_date && $room_bookings->check_out_date != '0000-00-00 00:00:00') ? with(new Carbon($room_bookings->check_out_date))->timestamp : ''
                    ];
//              return formatDateToShow($room_bookings->check_out_date);


                })

              ->addColumn('status', function ($room_bookings) {
                return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-invoice/') . '/' . $room_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;


            })

              ->addColumn('editbutton', function ($room_bookings) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-check-out/room-check-out-edit/') . '/' . $room_bookings->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('paid', function ($room_bookings) {
                $d=$room_bookings->invoices;

                if($d){


                    if($d->is_active==1){
                        return "<button type='button' class='btn btn-success btn-sm'>INV</button>";
                    }
                    else{
                        return "<button type='button' onclick='$.get(`".route('transActive',$d->id)."`,(a)=>{location.reload();})' class='btn btn-danger btn-sm'>GEN</button>";

                    }

                }
                else{
                    return "123";
                }
            })

            ->rawColumns(['details_d','editbutton', 'room','room_charges_type', 'room_booking','bookingsub', 'room_category', 'status','paid', 'mem_family', 'amountpaid', 'finalbalance', 'balancestatus'])
        ->addIndexColumn();
           $ddm=$dx->toArray();
        $x= array_filter($ddm['data'],function ($val) use($request){
            if($request->get('status')==1){
//                dd($val);
              return  $val['finalbalance']==0;
            }
            elseif($request->get('status')==2){
                return  $val['finalbalance']!=0;

            }
            else{
                return true;
            }
        });
//        $x= $x;
        $x=array_map(function ($a){
           return (array) $a;
        },$x);
         $ddm['amountpaidT']=number_format($data['totalgrandtotalRecepts']);
         $ddm['finalbalanceT']=number_format($data['totalgrandtotalBalance']);
         $ddm['totalcharges']=number_format($data['totalcharges']);
         $ddm['totalroomcharges']=number_format($data['totalroomcharges']);
         $ddm['totaldiscount']= number_format($data['totaldiscount']);
         $ddm['totalgrandtotal']=number_format($data['totalgrandtotal']);

        $x = array_values($x);

        $ddm['data']=(array)$x;
       return $ddm;

    }

  public function create(room_booking $room_booking,Request $request)
    {     $id=$request->segment(4);
         $data['roombooking']=room_booking::where('id',$id)->first();
 $data['room']=room::with('roomtypes')->get();
        $data['roomtype']=$data['room'];
         $data['room_category']=room_category::get();
         $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
    $data['room_charges_type']=room_charges_type::get();
$data['init']                = 1;

if($data['roombooking'] && $data['roombooking']->room && $data['roombooking']->check_in_date && $data['roombooking']->check_out_date){
  $living =room::where('id',$data['roombooking']->room)->get()->pluck('table_definition');
  $curtable =$living[0];


 $data['invoices'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_sales.id,
      fnb_sales.date,
      fnb_sales.type as mog,
      fnb_sales.customer_id,
fnb_sales.grand_total,
sum(distinct transactions.trans_amount ) as paid_amount,
( transactions.trans_moc),
 ( transactions.trans_moc_type),
  customers.customer_name as customer,
     hr_employments.name as employee,
     memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
      customers.guest_type as cgt,
      guest_types.desc as guesttype,
      memberships.mem_no as mem_no

from fnb_sales

left outer join transactions on transactions.trans_type_id=fnb_sales.id  and transactions.trans_type=5 and transactions.type=2 and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join memberships on memberships.id = fnb_sales.customer_id and memberships.deleted_at is null
left outer join customers on customers.id =fnb_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type and guest_types.deleted_at is null
left outer join hr_employments on hr_employments.id=fnb_sales.customer_id

where fnb_sales.restaurant_location=2 and fnb_sales.table_definition="'.$curtable.'" and
                                           str_to_date(concat(fnb_sales.`date`," ",fnb_sales.`time`),"%Y-%m-%d %h:%i:%s %p")  <= "'.($data['roombooking']->check_out_time?$data['roombooking']->check_out_date.' '.$data['roombooking']->check_out_time.':00':date('Y-m-d H:i:s',time())).'" and
                                           str_to_date(concat(fnb_sales.`date`," ",fnb_sales.`time`),"%Y-%m-%d %h:%i:%s %p")  >= "'.($data['roombooking']->check_in_time?$data['roombooking']->check_in_date.' '.$data['roombooking']->check_in_time.':00':da1070te('Y-m-d H:i:s',time())).'"  and fnb_sales.deleted_at is null group by fnb_sales.id order by fnb_sales.id asc');

/*$data['invoices']=fnb_sale::where('completed',2)->where('amount_received',0)->where('restaurant_location',2)->where('date','>=',formatDate($data['roombooking']->check_in_date))->where('date','<=',formatDate($data['roombooking']->check_out_date))->where('table_definition',$curtable)->get();*/
}else{
   $data['invoices']=[];
}

/*dd($data['invoices']);
*/


/*
     if($data['roombooking']->booking_type==1){
      $customerdata=customer::where('id',$data['roombooking']->customer_id)->first();
      }
      else{
        $customerdata=membership::with(['family:id,title,first_name,middle_name,name,fam_relationship,member_id','family.relationship_name:id,desc'])->where('id',$data['roombooking']->member_id)->first();
      }

    if($request->get('r')){
        $s=transactions::where('receipt_id',$request->get('r'))->where('trans_type',5)->get()->pluck('id');
        $v=trans_relations::whereIn('receipt',$s)->get()->pluck('invoice');


        $b = ($customerdata->transactions()->where('trans_type',5)->withTrashed()->whereIn('id',$v)->with(['receipts'=>function ($query) use ($s) {
            $query->whereNotIn('receipt',$s);
//           dd($query->toSql());
        },'receipts2'=>function ($query) use ($s) {
            $query->whereIn('receipt',$s);
//           dd($query->toSql());
        },'receipts.receiptDetails','receipts2.receiptDetails'])->where('is_active',1)->where('debit_or_credit', 1)->get()->toArray(1));


    }
    else {
        $b = ($customerdata->transactions()->where('trans_type',5)->where('is_active',1)->with('receipts', 'receipts.receiptDetails')->where('debit_or_credit', 1)->get()->toArray(1));

    }
    $data['invoices']=$b;*/


//dd( $data['invoices']);



$memberfmid=$data['roombooking']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();
 $data['gts']=guest_type::where('status',1)->get();

         return view('backend/room-management.room-check-out.room-check-out-aeu',$data);
    }

   /* public function create(Request $request)
    {
        $id=$request->segment(4);
        $data['room_booking_update'] = room_booking::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_booking_update']->code;
        $data['room']=room::get();
        $data['room']=room::with('roomtypes')->get();
        $data['roomtype']=$data['room'];

        $data['bookingsub']=room_booking::with('bookings')->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];

        $data['room_check_in']=room_booking::with('checkinstatus')->get();
        $data['room_check_in']=$data['room_check_in'];

        $data['room_category']=room_category::get();
        $data['room_charges_type']=room_charges_type::get();
        $data['room_category_charges']=room_category_charges::get();
         return view('backend/room-management.room-check-out.room-check-out-aeu', $data);
    }
*/
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
         //dd($request->all());
       $this->validate($request, [

           ]);

        $check_out = room_check_out::create([

        ]);



        if ($check_out) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$check_out->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }


        if(empty($save))
            {
              return redirect('room-management/room-invoice/'.$getlastinsert);
            }else{
                return redirect('room-management/room-check-out');
            }


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
    $data['check_out_update'] = room_check_out::where('id', $id)->first();
     $data['init']                = 1;
      $data['increment_number']    = $data['check_out_update']->code;

 $data['room_book']=room_check_out::with('checkout')->get();
        $data['room_book']=$data['room_book'];

    //     $data['room_booking_update'] = room_check_out::where('id', $id)->first();
     //   $data['init']                = 1;
     //   $data['increment_number']    = $data['room_booking_update']->code;
       $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
     $data['room']=room::get();
        $data['room']=room::with('roomtypes')->get();
        $data['roomtype']=$data['room'];

$memberfmid=$data['check_out_update']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

        $data['room_category']=room_category::get();
    $data['room_charges_type']=room_charges_type::get();

        return view('backend/room-management.room-check-out.room-check-out-aeu', $data);
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
        $typo=null;
      $save=$request->save;

           $validation=[
            'check_out_time' => 'required',

            //'payment_mode' => 'required',

            //'amount_paid' => 'required',

          ];

        $this->validate($request, $validation);

          if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
            $typo=1;
          }
          else if($request->get('booking_type')==6){
            $typo=6;
          }
          else{
            $typo=0;
          }

        $checkout = room_booking::where('id', $id)->updateWithUserstamps([

            'check_out_time'     =>  $request->check_out_time,

            'booking_no' =>  $request->booking_no,
            'booking_date'     =>  formatDate($request->booking_date),
            'check_in_date'     =>  formatDate($request->check_in_date),
            'arrival_details' =>  $request->arrival_details,
            'check_out_date'     =>  formatDate($request->check_out_date),
            'departure_details' =>  $request->departure_details,
            'first_name'     => $request->first_name,
            'last_name' =>  $request->last_name,
            'guest_company'     =>  $request->guest_company,
            'guest_address' =>  $request->guest_address,
            'guest_country'     =>  $request->guest_country,
            'guest_city' =>  $request->guest_city,
            'guest_mob'     =>  $request->guest_mob,
            'guest_email' =>  $request->guest_email,
            'guest_cnic'     =>  $request->guest_cnic,
           'accompained_guest' =>  $request->accompained_guest,
           'acc_relationship'     =>  $request->acc_relationship,
           'acc_cnic' =>  $request->acc_cnic,
           'ledger_amount' => $request->ledger_amount,
           'family' => $request->family,
            'booked_by'     =>  $request->booked_by,
            'booking_type' => $typo,
            //'moc_id'     =>  $request->moc_id,
            'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
             'corporate_id'     =>  $request->corporate_id,
         'moc_name' =>  $request->moc_name,
         'moc_address' =>  $request->moc_address,
         'moc_cnic' =>  $request->moc_cnic,
          'moc_mob'     =>  $request->moc_mob,
          'moc_email'     =>  $request->moc_email,
            'room' =>  $request->room,
            'category'     =>  $request->category,
            'pday_charges_id' =>  $request->pday_charges_id,
            'nights'     =>  $request->nights,
            'charges' =>  $request->charges,
             'security'     =>  $request->security,
          // 'charges_type' =>  $request->charges_type,
          // 'charges_amount'     =>  $request->charges_amount,
          // 'complementary' => 1, //$request->complementary,
            'food_bill_charges'     =>  $request->food_bill_charges,

            'total_room_charges'     =>  $request->total_room_charges,
            'total_charges' =>  $request->total_charges,
            'discount_amount' =>  $request->discount_amount,
            'discount_details' => $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'payment_mode' =>  $request->payment_mode,
            'payment_mode_details' =>  $request->payment_mode_details,
            'advance_paid' =>  $request->advance_paid,
            'total_balance' => $request->total_balance,
           'additional_notes'   => $request->additional_notes,
           'grand_balance'   => $request->grand_balance,
           'amount_paid'   => $request->amount_paid,
           'check_out_status' => 1,


        ]);


   $roomdelete= bookingsub::where('booking_id', $id)->deleteWithUserstamps();

if($roomdelete){

    $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;
        $complementary=$request->complementary;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new bookingsub;
             $ta->booking_id=$id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->iscomplementary=$complementary[$i];
            $ta->save();
            $i++;
        }
    }

 if($request->booking_type==0){

    $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->where('type',1)->updateWithUserstamps([

        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total-$request->food_bill_charges,
        'trans_moc_type' =>  0,
        'trans_moc' =>  $request->member_id,
         'trans_moc_category'=> memcategoryname($request->member_id),
        'date' =>  formatDate($request->check_out_date)
        ]);
}
elseif($request->booking_type==6){

    $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->where('type',1)->updateWithUserstamps([

        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total-$request->food_bill_charges,
        'trans_moc_type' =>  6,
        'trans_moc' =>  $request->corporate_id,
         'trans_moc_category'=> comemcategoryname($request->corporate_id),
        'date' =>  formatDate($request->check_out_date)
        ]);
}

  elseif($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
/*elseif($request->booking_type=='01' || $request->booking_type=='02'){*/

  $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->where('type',1)->updateWithUserstamps([

        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total-$request->food_bill_charges,
        'trans_moc_type' =>  1,
        'trans_moc' =>  $request->customer_id,
        'date' =>  formatDate($request->check_out_date)
        ]);
}

        if ($checkout) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');

        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }


        if(empty($save))
            {
                return redirect('room-management/room-invoice/'.$id);
            }else{
                return redirect('room-management/room-check-out-vue');
            }

    }


    function searchbookingno($id){
     if($id!=''){
        $bookings=room_booking::where('check_out_status',1)->where('booking_no',$id)->get();
     }
     else{
         $bookings=room_booking::where('check_out_status',1)->get();
     }

        return $bookings;
    }

    function searchstartdate($id){
     if($id!=''){
        $bookings=room_booking::where('check_out_status',1)->where('check_out_date', '>=',$id)->get();
     }
     else{
        $bookings=room_booking::where('check_out_status',1)->get();
     }
        return $bookings;
    }

    function searchenddate($id){
     if($id!=''){
        $bookings=room_booking::where('check_out_status',1)->where('check_out_date', '<=',$id)->get();
     }
     else{
        $bookings=room_booking::where('check_out_status',1)->get();
     }
        return $bookings;
    }

    function searchname($id){
     if($id!=''){
        $bookings=room_booking::where('check_out_status',1)->where('moc_name',$id)->get();
     }
     else{
        $bookings=room_booking::where('check_out_status',1)->get();
     }
        return $bookings;
    }


     public function docs(room_check_out $room_check_out,$id)
    {
         $data['receiptdata']=room_booking::with('customer')->with('member')->where('id',$id)->first();

        return view('backend/room-management.room-check-out.room-check-out-documents', $data);
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
}
