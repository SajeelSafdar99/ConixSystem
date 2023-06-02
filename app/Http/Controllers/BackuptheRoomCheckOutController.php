<?php

namespace App\Http\Controllers;

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
use DB;
use function foo\func;

class BackuptheRoomCheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room_check_out $room_check_out)
    {
        return view('backend/room-management/room-check-out/room-check-out');
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

       /* if($request->get('status')){
         $rid = $r->get()->pluck('id');
          $s=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$rid)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }

            if($request->get('status')==1){
               $r->where('grand_total','=',$x);
            }
            else if($request->get('status')==2){
               $r->where('grand_total','!=',$x);
            }
        }*/

        if(!(
        $request->get('customer')!=''||
$request->get('start_date')!=''||
$request->get('end_date')!=''||
$request->get('receipt')!='' ||$request->get('mog')!=''||$request->get('status')!='') ){

            $date=Carbon::now()->subDays(2)->format('Y-m-d');
            $r->where('check_out_date','>=',$date);
        }
       //echo $r->toSql();
         $room_bookings=$r->get();
 
        return DataTables::of($room_bookings)

        
        ->addColumn('balancestatus', function ($room_bookings) {

          $s=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$room_bookings->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }


            $resultant = $room_bookings->grand_total-$x;

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
          
            })
        

           /* ->addColumn('button', function ($room_bookings) {
                return //'<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('room-management/room-check-out/room-check-out-aeu/') . '/' . $room_checkout->id . '"><i class="fas fa-edit"></i></a></button>'.
               // '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-check-out/delete') . '/' . $room_checkout->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'.
                 '<button class="buttoncolor" title="Print"><a style="color:#000000;" href="' . url('room-management/room-invoice') . '/' . $room_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;
            })
*/

           ->addColumn('amountpaid', function ($room_bookings) {
             $s=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$room_bookings->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }

            return $x;
           })

           ->addColumn('finalbalance', function ($room_bookings) {
             $s=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$room_bookings->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
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

            ->addColumn('dtotal', function ($r) {
                $request=Request::capture();
                $r=       room_booking::where('check_out_status', 1);

                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

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
                if(!($request->get('mog')!='undefined'||
                    $request->get('customer')!=''||
                    $request->get('start_date')!=''||
                    $request->get('end_date')!=''||
                    $request->get('receipt')!='')){

                    $date=Carbon::now()->subDays(2)->format('Y-m-d');
                    $r->where('check_out_date','>=',$date);
                }
              /*  $food=0;
                $mini_bar=0;
                $laundry=0;
                $services=0;
                $mattress=0;
                $misc=0;*/

//                $ids=array_column($r->get()->toArray(),'id');

               /* foreach($r->get() as $m){
//                    $food+=$m->bookings()->where('charges_type_id',1)->sum('charges_amount');
//                    $mini_bar+=$m->bookings()->where('charges_type_id',2)->sum('charges_amount');
//                    $laundry+=$m->bookings()->where('charges_type_id',9)->sum('charges_amount');
//                    $services+=$m->bookings()->where('charges_type_id',8)->sum('charges_amount');
//                    $mattress+=$m->bookings()->where('charges_type_id',5)->sum('charges_amount');
//                    $misc+=$m->bookings()->where('charges_type_id',6)->sum('charges_amount');
                    $x=$m->bookings()->select('charges_type_id','charges_amount')->get()->keyBy('charges_type_id');
                    $food+=isset($x[1])?$x[1]['charges_amount']:'0';
                    $mini_bar+=isset($x[2])?$x[2]['charges_amount']:'0';
                    $laundry+=isset($x[9])?$x[9]['charges_amount']:'0';
                    $services+=isset($x[8])?$x[8]['charges_amount']:'0';
                    $mattress+=isset($x[5])?$x[5]['charges_amount']:'0';
                    $misc+=isset($x[6])?$x[6]['charges_amount']:'0';

                }*/
               return [
                   'totalBill'=>number_format( $r->sum('total_charges')),
                   'totalDiscount'=>number_format( $r->sum('discount_amount')),
                   'totalRoomRent'=>number_format( $r->sum('charges')),
                   'totalAdvance'=>number_format( $r->sum('advance_paid')),
                   /*'totalFood'=>number_format( $food),
                   'totalMiniBar'=>number_format( $mini_bar),
                   'totalLaundry'=>number_format( $laundry),
                   'totalService'=>number_format( $services),
                   'totalMattress'=>number_format( $mattress),
                   'totalMISC'=>number_format( $misc),*/
                   'totalBalance'=>number_format( $r->sum('total_balance')),
//                   'totalBill'=>number_format( $r->sum('grand_total')),
//                   'totalC'=>number_format( $r->sum('grand_total')),

                   ] ;


            })
            ->addColumn('ctotal', function ($receipts) {
                $request=Request::capture();
                $r=  room_booking::where('check_out_status', 1);
                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

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
                if(!($request->get('mog')!='undefined'||
                    $request->get('customer')!=''||
                    $request->get('start_date')!=''||
                    $request->get('end_date')!=''||
                    $request->get('receipt')!='')){
                    $date=Carbon::now()->subDays(2)->format('Y-m-d');
                    $r->where('check_out_date','>=',$date);
                }
                return number_format($r->count('id')) ;


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
              return formatDateToShow($room_bookings->check_out_date);


                })
           /* ->addColumn('food', function ($room_bookings) {

              return ($r=$room_bookings->bookings()->where('charges_type_id',1)->first())?$r->charges_amount:'-';


                })
            ->addColumn('mini_bar', function ($room_bookings) {
              return ($r=$room_bookings->bookings()->where('charges_type_id',2)->first())?$r->charges_amount:'-';


                })
            ->addColumn('laundry', function ($room_bookings) {
              return ($r=$room_bookings->bookings()->where('charges_type_id',9)->first())?$r->charges_amount:'-';


                })
            ->addColumn('services', function ($room_bookings) {
              return ($r=$room_bookings->bookings()->where('charges_type_id',8)->first())?$r->charges_amount:'-';


                })
            ->addColumn('mattress', function ($room_bookings) {
              return ($r=$room_bookings->bookings()->where('charges_type_id',5)->first())?$r->charges_amount:'-';


                })
            ->addColumn('misc', function ($room_bookings) {
              return ($r=$room_bookings->bookings()->where('charges_type_id',6)->first())?$r->charges_amount:'-';


                })*/

              ->addColumn('status', function ($room_bookings) {
                return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-invoice/') . '/' . $room_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;


            })

              ->addColumn('editbutton', function ($room_bookings) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-check-out/room-check-out-edit/') . '/' . $room_bookings->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('paid', function ($room_bookings) {
                $d=transactions::where('debit_or_credit',1)->where('trans_type',1)->where('trans_type_id',$room_bookings->id)->first();

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


            ->rawColumns(['editbutton', 'room','room_charges_type', 'room_booking','bookingsub', 'room_category', 'status','paid', 'mem_family', 'amountpaid', 'finalbalance', 'balancestatus'])
        ->addIndexColumn()
            ->make(true);
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


$memberfmid=$data['roombooking']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

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
      $save=$request->save;

           $validation=[
            'check_out_time' => 'required',

            //'payment_mode' => 'required',

            //'amount_paid' => 'required',

          ];

        $this->validate($request, $validation);

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
            'booking_type' => $request->booking_type,
            //'moc_id'     =>  $request->moc_id,
            'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
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


   $roomdelete= bookingsub::where('booking_id', $id)->delete();

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

    $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->updateWithUserstamps([

        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  0,
        'trans_moc' =>  $request->member_id,
        'date' =>  formatDate($request->check_out_date)
        ]);
}
elseif($request->booking_type==1){

  $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->updateWithUserstamps([

        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
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
                return redirect('room-management/room-check-out');
            }

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
