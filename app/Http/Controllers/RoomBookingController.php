<?php

namespace App\Http\Controllers;
use App\guest_type;
use App\room_booking;
use DataTables;
use App\membership;
use App\finance_payment_methods;
use Illuminate\Http\Request;
use App\room;
use App\room_type;
use App\bookingsub;
use App\transactions;
use App\room_category;
use App\room_charges_type;
use App\mem_family;
use App\room_category_charges;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\customer;
use App\room_check_in;
use App\trans_relations;
use App\fnb_sale;
use App\fnb_predefined_value;
use App\corporateMembership;

class RoomBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function booking_vue(Request $request, room_booking $room_booking)
    {
       return view('backend/room-management/room-booking/room-booking-vue');
    }

    public function booking_ini(Request $request)
    {
$data['bookings'] =\Illuminate\Support\Facades\DB::select(
      'select room_bookings.*, memberships.mem_no as mem_no, st.desc as activity,sum(transactions.trans_amount ) as paid_amount , GROUP_CONCAT(transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,(t1.id) as transid,
        users.name as cashiername, corporate_memberships.mem_no as co_mem_no, stt.desc as coactivity,
if(room_bookings.member_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC
,
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
where room_bookings.check_in_time is null  and room_bookings.deleted_at is null group by room_bookings.id order by room_bookings.booking_date asc');

 $data['roomnos']=room::where('status',1)->get();

     return $data;
}


    public function index(Request $request, room_booking $room_booking)
    {
       return view('backend/room-management/room-booking/room-booking');
    }

     public function indexdt(Request $request, room_booking $room_booking)
    {

  /*$room_bookings = room_booking::where('booking_date','>=',settings('rooms_due'))->wherenull('check_in_time')->get();*/
      $room_bookings = room_booking::wherenull('check_in_time')->get();

       //dd($room_bookings);
        /*$room_bookings=DB::table('room_bookings')->select('room_bookings.*',DB::raw('room_check_ins.status as newstatus'))->leftJoin('room_check_ins','room_check_ins.booking_id','=','room_bookings.id')->get();*/
//DB::raw('room_bookings.id as bkid'),DB::raw('*')


        $x= DataTables::of($room_bookings)

            ->addColumn('editbutton', function ($room_bookings) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-booking/room-booking-aeu/') . '/' . $room_bookings->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($room_bookings) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-booking/delete') . '/' . $room_bookings->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


         ->addColumn('status', function ($room_bookings) {

                return '<a target="_blank" href="' . url('room-management/room-check-in/room-check-in-aeu/') . '/' . $room_bookings->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Check-In">Check In</button></a>'
                ;

            })

            /*->addColumn('status', function ($room_booking) {


            if ($room_booking->status!=null || $room_booking->status==1) {

                    return '<a href="' . url('room-management/room-check-in/room-check-in-aeu/') . '/' . $room_booking->id . '"><button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Check-In" disabled>Check In</button></a>';
                }
                else{
                   return '<a href="' . url('room-management/room-check-in/room-check-in-aeu/') . '/' . $room_booking->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Check-In">Check In</button></a>';

                }

               }) */
               ->addColumn('type', function ($room_bookings) {
                if($room_bookings->booking_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })

              ->addColumn('room', function ($room_bookings) {
              return roomtypename($room_bookings->room).- roomno($room_bookings->room) ;


                })

              ->addColumn('name', function ($room_bookings) {
              return $room_bookings->first_name .' '. $room_bookings->last_name;

                })
->addColumn('balance', function ($room_bookings) {
              return 123;

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

                ->addColumn('booking_date', function ($col) {
                    return [
                        'display' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->format('d/m/Y') : '',
                        'timestamp' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->timestamp : ''
                    ];
            //  return formatDateToShow($room_bookings->booking_date);


                })
                ->addColumn('check_in_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_in_date);


                })   ->addColumn('customer_id', function ($room_bookings) {
//                    dd($room_bookings->member);
              return $room_bookings->booking_type==0?$room_bookings->member?$room_bookings->member->mem_no:'':$room_bookings->customer_id;


                })
                ->addColumn('check_out_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_out_date);


                })


             ->addColumn('booking_docs', function ($room_bookings) {
                return '<img style="width: 100px;" src="'.url('/').'/'.$room_bookings->booking_docs.'"/>';
            })



            ->addColumn('invoice', function ($room_bookings) {
                 return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-booking-invoice/') . '/' . $room_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })


            ->rawColumns(['editbutton','deletebutton', 'status', 'paid','invoice','room','bookingsub', 'room_category','room_charges_type', 'room_category_charges', 'room_check_in', 'finance_payment_methods', 'mem_family','amountpaid', 'finalbalance', 'details_d'])

            ->addIndexColumn()
            ->make(true);
               return $x;
    }


    public function index_deleted(Request $request, room_booking $room_booking)
    {
        return view('backend/room-management/room-booking/room-booking-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, room_booking $room_booking)
    {
        $Room_Booking = room_booking::onlyTrashed()->wherenull('check_in_time')->get();
        return DataTables::of($Room_Booking)

                        ->addColumn('type', function ($room_bookings) {
                if($room_bookings->booking_type==0){
                     return "Member"; 
                }
                else if($room_bookings->booking_type==6){
                     return "Corporate Member"; 
                }
                else{
                    return "Guest";
                 }


                })

              ->addColumn('room', function ($room_bookings) {
              return roomtypename($room_bookings->room).- roomno($room_bookings->room) ;


                })

              ->addColumn('name', function ($room_bookings) {
              return $room_bookings->first_name .' '. $room_bookings->last_name;

                })

                ->addColumn('booking_date', function ($col) {
                    return [
                        'display' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->format('d/m/Y') : '',
                        'timestamp' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->timestamp : ''
                    ];
            //  return formatDateToShow($room_bookings->booking_date);


                })


                  ->addColumn('deleted_at', function ($room_bookings) {
              return formatDateToShow($room_bookings->deleted_at);


                }) 

                  
                ->addColumn('check_in_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_in_date);


                })   ->addColumn('customer_id', function ($room_bookings) {
//                    dd($room_bookings->member);

                       if($room_bookings->booking_type==0){
                     return  $room_bookings->member_id?$room_bookings->member->mem_no:'';
                }
                else if($room_bookings->booking_type==6){
                     return $room_bookings->corporate_id?$room_bookings->corporateMember->mem_no:'';
                }
                else{
                     return  $room_bookings->customer_id;
                 }


          //    return $room_bookings->booking_type==0?$room_bookings->member?$room_bookings->member->mem_no:'':$room_bookings->customer_id;


                })
                ->addColumn('check_out_date', function ($room_bookings) {
              return formatDateToShow($room_bookings->check_out_date);


                })

            ->addColumn('restorebutton', function ($Room_Booking) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room-booking/restore/') . '/' . $Room_Booking->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Get the last record id and pass to the view
        $lastval = room_booking::withTrashed()->latest('id')->first();

        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_booking_update'] = '';
        $bookingroomarray=room_booking::select('room')->get()->toarray();
$bookingroomarray=array_column($bookingroomarray, 'room');

        $data['room']=room::where('status',1)->whereNotIn('rooms.id',$bookingroomarray)->get();

        $data['roomtype']=$data['room'];

        $data['checkinedit']   = 0;

       //   $data['bookingsub']=room_booking::with('bookings')->get();
      // $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];

       // $data['bookingsub']=bookingsub::with('bookings')->get();
       // $data['bookings']=$data['bookingsub'];
    /*   $data['room_check_in']=room_booking::with('checkinstatus')->get();
        $data['room_check_in']=$data['room_check_in'];*/


        $data['room_category']=room_category::where('status',1)->get();

        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['room_charges_type']=room_charges_type::where('status',1)->get();
        $data['room_category_charges']=room_category_charges::get();
 $data['gts']=guest_type::where('status',1)->get();

$customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
      /*  $data['roombooking']=room_booking::where('id',$id)->first();*/
        return view('backend/room-management.room-booking.room-booking-aeu', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {

 $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }

       
         $dd='';
         $cati ='';

         if($request->get('booking_type')==0){
          $dd=$request->get('member_id');
            
        if(membership::where('id',$request->get('member_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('member_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
       
      }   
     else if($request->get('booking_type')==6){
          $dd=$request->get('corporate_id');
            
        if(corporateMembership::where('id',$request->get('corporate_id'))->exists()){
           $arr_coa=corporateMembership::where('id',$request->get('corporate_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = comemcategoryname($dd);
           
          
          }
        }
       
      }   

       /* else if($request->get('booking_type')=='01' || $request->get('booking_type')=='02'){*/
         else if($request->get('booking_type')>10 || $request->get('booking_type')==1){

            $request->booking_type=1;
          $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
              $coa_code=null;
           $cati =  null;
         
          }
        }
 

        }

    $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;

     $createimg='';




         $save=$request->save;
$validation=[
    'booking_no' => 'required',
    'booking_date'     => 'required',
    'check_in_date'     => 'required',
    //'arrival_details' => 'required',
    'check_out_date'     => 'required',
    //'departure_details' => 'required',
    'first_name'     => 'required',
    'last_name' => 'required',
    'guest_company'     => 'required',
    'guest_address' => 'required',
    'guest_country'     => 'required',
    'guest_city' => 'required',
    'guest_mob'     => 'required',
    'guest_email' => 'required',
    'guest_cnic'     => 'required',
      //'ledger_amount' => 'required',
    // 'accompained_guest' => 'required',
    // 'acc_relationship'     => 'required',
    // 'acc_cnic' => 'required',
    'booked_by'     => 'required',
    'booking_type' => 'required',

    // 'moc_number'     =>  'required',

    'moc_name' =>  'required',
    // 'moc_address' =>  'required',
    // 'moc_cnic' => 'required',
    // 'moc_mob'     =>  'required',
    // 'moc_email'     => 'required',

    'room' => 'required',
    'category'     => 'required',
    'pday_charges_id' => 'required',
    'nights'     => 'required',
    'charges' => 'required',
    //'security'     => 'required',
    //'charges_type' => 'required',
    // 'charges_amount'     => 'required',
    //'complementary' => 'required',
    // 'total_room_charges'     => 'required',

    'total_charges' => 'required',
    //'discount_amount' => 'required',
    // 'discount_details' => 'required',
    'grand_total' => 'required',
   // 'payment_mode' => 'required',
    'booking_docs' => 'required',
    // 'advance_paid' => 'required',
   // 'total_balance' => 'required'
];
        if($request->get('booking_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else if($request->get('booking_type')==6){
            $validation['corporate_code']='required';
            $validation['corporate_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

         //dd($request->all());
       $this->validate($request, $validation);

        $Room_Booking = room_booking::create([

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
             'ledger_amount' => $request->ledger_amount,
             'family' => $request->family,
           'accompained_guest' =>  $request->accompained_guest,
           'acc_relationship'     =>  $request->acc_relationship,
           'acc_cnic' =>  $request->acc_cnic,
            'booked_by'     =>  $request->booked_by,
            'booking_type' => $request->booking_type,
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
          //   'charges_amount'     =>  $request->charges_amount,
          //  'complementary' => 1, //$request->complementary,
             'total_room_charges'     =>  $request->total_room_charges,

            'total_charges' =>  $request->total_charges,
            'discount_amount' =>  $request->discount_amount,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'payment_mode' =>  $request->payment_mode,
            'payment_mode_details' =>  $request->payment_mode_details,
           'advance_paid' =>  $request->advance_paid,
            'total_balance' => $request->total_balance,
          //  'booking_docs'=>$createimg,
           'additional_notes'   => $request->additional_notes,
           'member'=>1,
           'coa_code'   => $coa_code,
        ]);


if($request->hasFile('booking_docs')) {

           $files = $request->file('booking_docs');
           foreach($files as $file){
             // dd($file);
            /*      if($request->booking_type=='01' || $request->booking_type=='02'){*/
   if($request->get('booking_type')>10 || $request->get('booking_type')==1){ //for Guest/Customer
              $createimg=sendDocs($file,$size,['type'=>1,'trans_type'=>1,'trans_type_id'=>$Room_Booking->id,'moc_id'=>$request->post('customer_id')]);  // type = 2
            }
             else if($request->get('booking_type')==6){// for Corporate Member
              $createimg=sendDocs($file,$size,['type'=>6,'trans_type'=>1,'trans_type_id'=>$Room_Booking->id,'moc_id'=>$request->post('corporate_id')]);   // type = 12
            }

            else{// for Member
              $createimg=sendDocs($file,$size,['type'=>0,'trans_type'=>1,'trans_type_id'=>$Room_Booking->id,'moc_id'=>$request->post('member_id')]);   // type = 12
            }

          }
       }



         $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;
        $complementary=$request->complementary;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new bookingsub;
            $ta->booking_id = $Room_Booking->id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->iscomplementary=$complementary[$i];
            $ta->save();
            $i++;
        }



     transactions::create([
       'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $Room_Booking->id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
 
 


        if ($Room_Booking) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
            $getlastinsert=$Room_Booking->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

            //echo $message;

       /* if($getlastinsert==0){
          return redirect('room-management/room-booking/room-booking-aeu');
          }else{
          return redirect('room-management/room-booking-invoice/'.$getlastinsert);
          }*/

        if(empty($save))
            {
                return redirect('room-management/room-booking-invoice/'.$getlastinsert);
            }else{
                return redirect('room-management/room-booking-vue');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_booking  $room_booking
     * @return \Illuminate\Http\Response
     */
    public function show(room_booking $room_booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_booking  $room_booking
     * @return \Illuminate\Http\Response
     */

     public function edit(room_booking $room_booking,$id)
    {

        $data['room_booking_update'] = room_booking::where('id', $id)->first();

        if($data['room_booking_update']->check_out_status==1){
            if(!Auth::user()->can('editCheckOut')) abort(404);

        }
        $data['init']                = 1;
        $data['increment_number']    = $data['room_booking_update']->code;

        $data['checkinedit']   = 0;

        $data['room']=room::with('roomtypes')->where('status',1)->get();

        $data['roomtype']=$data['room'];

        $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
 $data['gts']=guest_type::where('status',1)->get();

 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
 /*       $data['room_check_in']=room_booking::with('checkinstatus')->get();
        $data['room_check_in']=$data['room_check_in'];*/

        $data['room_category']=room_category::where('status',1)->get();
        $data['room_charges_type']=room_charges_type::where('status',1)->get();
        $data['room_category_charges']=room_category_charges::get();
        $data['roombooking']=room_booking::find($id);

         $memberfmid=$data['room_booking_update']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

        return view('backend/room-management.room-booking.room-booking-aeu', $data);
    }

 public function edit_checkin(room_booking $room_booking,$id)
    {
        $data['room_booking_update'] = room_booking::where('id', $id)->first();

        if($data['room_booking_update']->check_out_status==1){
            if(!Auth::user()->can('editCheckOut')) abort(404);
        }

        $data['init']                = 1;
        $data['increment_number']    = $data['room_booking_update']->code;

        $data['checkinedit']   = 1;

        $data['room']=room::with('roomtypes')->where('status',1)->get();

        $data['roomtype']=$data['room'];

        $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];
 $data['gts']=guest_type::where('status',1)->get();

 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
   /*     $data['room_check_in']=room_booking::with('checkinstatus')->get();
        $data['room_check_in']=$data['room_check_in'];*/

        $data['room_category']=room_category::where('status',1)->get();
        $data['room_charges_type']=room_charges_type::where('status',1)->get();
        $data['room_category_charges']=room_category_charges::get();
        $data['roombooking']=room_booking::find($id);


         $memberfmid=$data['room_booking_update']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

        return view('backend/room-management.room-booking.room-booking-aeu', $data);
    }


     public function edit_checkout(room_booking $room_booking,Request $request,$id)
    {
        $data['roombooking'] = room_booking::where('id', $id)->first();

        if($data['roombooking']->check_out_status==1){
            if(!Auth::user()->can('editCheckOut')) abort(404);

        }
        $data['init']                = 1;
        $data['increment_number']    = $data['roombooking']->code;

        $data['checkinedit']   = 1;

        $data['room']=room::with('roomtypes')->where('status',1)->get();

        $data['roomtype']=$data['room'];

        $data['bookingsub']=room_booking::with('bookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['bookings'];

 $data['gts']=guest_type::where('status',1)->get();
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
      /*  $data['room_check_in']=room_booking::with('checkinstatus')->get();
        $data['room_check_in']=$data['room_check_in'];*/

        $data['room_category']=room_category::where('status',1)->get();
        $data['room_charges_type']=room_charges_type::where('status',1)->get();
        $data['room_category_charges']=room_category_charges::get();
        $data['roombooking']=room_booking::find($id);


         $memberfmid=$data['roombooking']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();


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
transactions.trans_moc as trans_moc,
 transactions.trans_moc_type as trans_moc_type,
  customers.customer_name as customer,
    hr_employments.name as employee,
    memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
      customers.guest_type as cgt,
      memberships.mem_no as mem_no,
      guest_types.desc as guesttype

from fnb_sales

left outer join transactions on transactions.trans_type=5 and transactions.trans_type_id=fnb_sales.id and transactions.debit_or_credit=0 and transactions.type=2 and transactions.deleted_at is null
left outer join memberships on memberships.id = fnb_sales.customer_id and memberships.deleted_at is null
left outer join customers on customers.id =fnb_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type  
left outer join hr_employments on hr_employments.id=fnb_sales.customer_id

where fnb_sales.restaurant_location=2 and fnb_sales.table_definition="'.$curtable.'" and
                                           str_to_date(concat(fnb_sales.`date`," ",fnb_sales.`time`),"%Y-%m-%d %h:%i:%s %p")  <= "'.($data['roombooking']->check_out_date?$data['roombooking']->check_out_date.' '.$data['roombooking']->check_out_time.':00':date('Y-m-d H:i:s',time())).'" and
                                                    str_to_date(concat(fnb_sales.`date`," ",fnb_sales.`time`),"%Y-%m-%d %h:%i:%s %p")  >= "'.($data['roombooking']->check_in_time?$data['roombooking']->check_in_date.' '.$data['roombooking']->check_in_time.':00':date('Y-m-d H:i:s',time())).'"  and fnb_sales.deleted_at is null group by fnb_sales.id order by fnb_sales.id asc');


 /*$data['invoices']=fnb_sale::where('completed',2)->where('amount_received',0)->where('restaurant_location',2)->where('date','>=',formatDate($data['roombooking']->check_in_date))->where('date','<=',formatDate($data['roombooking']->check_out_date))->where('table_definition',$curtable)->get();*/
}else{
   $data['invoices']=[];
}
/*dd($data['invoices']);
*/




/* if($data['roombooking']->booking_type==1){
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
    $data['invoices']=$b;
*/

        return view('backend/room-management.room-check-out.room-check-out-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_booking  $room_booking
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {


 $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }

       
         $dd='';
         $cati ='';

      if($request->get('booking_type')==0 ){
          $dd=$request->get('member_id');
            
        if(membership::where('id',$request->get('member_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('member_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
       
      }

      else if($request->get('booking_type')==6 ){
          $dd=$request->get('corporate_id');
            
        if(corporateMembership::where('id',$request->get('corporate_id'))->exists()){
           $arr_coa=corporateMembership::where('id',$request->get('corporate_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = comemcategoryname($dd);
           
          
          }
        }
       
      }

       
      /*  else if($request->get('booking_type')=='01' || $request->get('booking_type')=='02'){*/
       else if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
         $request->booking_type=1;

          $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
              $coa_code=null;
           $cati =  null;
         
          }
        }
 

        }

          $size['width'] = 300;
    $size['height'] = 200;
        $updateimg='';

if($request->hasFile('booking_docs')) {

           $files = $request->file('booking_docs');

if($request->booking_type==0){
  /* $s=room_booking::find($id)->member->bookingDocs;*/
   $s=room_booking::find($id)->bookingDocs;
           foreach($s as $m){
               $m->delete();
           }
   
}

            else{


            /*    $s=room_booking::find($id)->customer->bookingDocs;*/
             $s=room_booking::find($id)->bookingDocs;
           foreach($s as $m){
               $m->delete();
    }
           }


        foreach($files as $file){
             // dd($file);
             if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
/*            if($request->booking_type=='01' || $request->booking_type=='02'){*/
              $updateimg=sendDocs($file,$size,['type'=>1,'trans_type'=>1,'trans_type_id'=>$id,'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->get('booking_type')==6){
              $updateimg=sendDocs($file,$size,['type'=>6,'trans_type'=>1,'trans_type_id'=>$id,'moc_id'=>$request->post('corporate_id')]);
            }
            else{
              $updateimg=sendDocs($file,$size,['type'=>0,'trans_type'=>1,'trans_type_id'=>$id,'moc_id'=>$request->post('member_id')]);
            }

          }


       }

       $validation=[
            'booking_type'=>'required',
            'booking_no' => 'required',
            'booking_date'     => 'required',
            'check_in_date'     => 'required',
            //'arrival_details' => 'required',
            'check_out_date'     => 'required',
            //'departure_details' => 'required',
            'first_name'     => 'required',
            'last_name' => 'required',
            'guest_company'     => 'required',
            'guest_address' => 'required',
            'guest_country'     => 'required',
            'guest_city' => 'required',
            'guest_mob'     => 'required',
            'guest_email' => 'required',
            'guest_cnic'     => 'required',
            // 'accompained_guest' => 'required',
            // 'acc_relationship'     => 'required',
            // 'acc_cnic' => 'required',
            'booked_by'     => 'required',
            'booking_type' => 'required',
            // 'moc_number'     =>  'required',

             'moc_name' =>  'required',
            //'moc_address' =>  'required',
            // 'moc_cnic' => 'required',
            // 'moc_mob'     =>  'required',
            // 'moc_email'     => 'required',

            'room' => 'required',
            'category'     => 'required',
            'pday_charges_id' => 'required',
            'nights'     => 'required',
            'charges' => 'required',
            //'security'     => 'required',
            //'charges_type' => 'required',
            // 'charges_amount'     => 'required',
            //'complementary' => 'required',
            //  'total_room_charges'     => 'required',

            'total_charges' => 'required',
            //'discount_amount' => 'required',
            // 'discount_details' => 'required',
            'grand_total' => 'required',
           // 'payment_mode' => 'required',
            // 'advance_paid' => 'required',
           // 'total_balance' => 'required'
            // 'additional_notes'   => 'required',
            // 'booking_docs' => 'required'

        ];
    if($request->get('booking_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
       else if($request->get('booking_type')==6){
            $validation['corporate_code']='required';
            $validation['corporate_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

        $this->validate($request, $validation);

        $Room_Booking = room_booking::where('id', $id)->updateWithUserstamps([

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
        //   'booking_docs'=>$updateimg,
           'coa_code'=>$coa_code,
           //'member'=>1
        ]);

//        if($request->hasFile('booking_docs')){
//            $files=$request->file('booking_docs');
//
//            if(is_array($files)){
//                $size['width'] = 300;
//                $size['height'] = 200;
//                foreach($files as $file){
//sendDocs($file,$size,['type'=>2,'moc_id'=>$id]);
//
//                }
//            }
//        }



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


if(transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->exists()){
    transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->updateWithUserstamps([
        'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}else{
    transactions::create([
       'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}


        if ($Room_Booking) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-booking/room-booking-aeu/'.$id);

    }


     public function update_checkin(Request $request, $id)
    {


 $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }

       
         $dd='';
         $cati ='';

      if($request->get('booking_type')==0){
          $dd=$request->get('member_id');
            
        if(membership::where('id',$request->get('member_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('member_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
       
      }

     else if($request->get('booking_type')==6){
          $dd=$request->get('corporate_id');
            
        if(corporateMembership::where('id',$request->get('corporate_id'))->exists()){
           $arr_coa=corporateMembership::where('id',$request->get('corporate_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = comemcategoryname($dd);
           
          
          }
        }
       
      }

      /*  else if($request->get('booking_type')=='01' || $request->get('booking_type')=='02'){*/
        else if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
             $request->booking_type=1;

          $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
              $coa_code=null;
           $cati =  null;
         
          }
        }
 

        }

   $size['width'] = 300;
    $size['height'] = 200;
        $updateimg='';

if($request->hasFile('booking_docs')) {

           $files = $request->file('booking_docs');

  $s=room_booking::find($id)->bookingDocs;
           foreach($s as $m){
               $m->delete();
           }


   foreach($files as $file){
             // dd($file);
             if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
/*            if($request->booking_type=='01' || $request->booking_type=='02'){*/
              $updateimg=sendDocs($file,$size,['type'=>1,'trans_type'=>1,'trans_type_id'=>$id,'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->get('booking_type')==6){
              $updateimg=sendDocs($file,$size,['type'=>6,'trans_type'=>1,'trans_type_id'=>$id,'moc_id'=>$request->post('corporate_id')]);
            }
            else{
              $updateimg=sendDocs($file,$size,['type'=>0,'trans_type'=>1,'trans_type_id'=>$id,'moc_id'=>$request->post('member_id')]);
            }

          }


        /*   foreach($files as $file){
             // dd($file);
            
             if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
              $updateimg=sendDocs($file,$size,['type'=>2,'moc_id'=>$request->post('customer_id')]);
            }
            else{
              $updateimg=sendDocs($file,$size,['type'=>12,'moc_id'=>$request->post('member_id')]);
            }

          }*/
       }

       $validation=[
            'booking_type'=>'required',
            'booking_no' => 'required',
            'booking_date'     => 'required',
            'check_in_date'     => 'required',
            //'arrival_details' => 'required',
            'check_out_date'     => 'required',
            //'departure_details' => 'required',
            'first_name'     => 'required',
            'last_name' => 'required',
            'guest_company'     => 'required',
            'guest_address' => 'required',
            'guest_country'     => 'required',
            'guest_city' => 'required',
            'guest_mob'     => 'required',
            'guest_email' => 'required',
            'guest_cnic'     => 'required',
            // 'accompained_guest' => 'required',
            // 'acc_relationship'     => 'required',
            // 'acc_cnic' => 'required',
            'booked_by'     => 'required',
            'booking_type' => 'required',
            // 'moc_number'     =>  'required',

            // 'moc_name' =>  'required',
            //'moc_address' =>  'required',
            // 'moc_cnic' => 'required',
            // 'moc_mob'     =>  'required',
            // 'moc_email'     => 'required',

            'room' => 'required',
            'category'     => 'required',
            'pday_charges_id' => 'required',
            'nights'     => 'required',
            'charges' => 'required',
            //'security'     => 'required',
            //'charges_type' => 'required',
            // 'charges_amount'     => 'required',
            //'complementary' => 'required',
            //  'total_room_charges'     => 'required',

            'total_charges' => 'required',
            //'discount_amount' => 'required',
            // 'discount_details' => 'required',
            'grand_total' => 'required',
            //'payment_mode' => 'required',
            // 'advance_paid' => 'required',
            //'total_balance' => 'required'
            // 'additional_notes'   => 'required',
            // 'booking_docs' => 'required'

        ];
       if($request->get('booking_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
       else if($request->get('booking_type')==6){
            $validation['corporate_code']='required';
            $validation['corporate_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

        $this->validate($request, $validation);

        $Room_Booking = room_booking::where('id', $id)->updateWithUserstamps([

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
            'family' => $request->family,
            'booked_by'     =>  $request->booked_by,
            'booking_type' => $request->booking_type,
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
           'booking_docs'=>$updateimg,
           'coa_code'   => $coa_code,
           //'member'=>1
        ]);

//        if($request->hasFile('booking_docs')){
//            $files=$request->file('booking_docs');
//
//            if(is_array($files)){
//                $size['width'] = 300;
//                $size['height'] = 200;
//                foreach($files as $file){
//sendDocs($file,$size,['type'=>2,'moc_id'=>$id]);
//
//                }
//            }
//        }



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

if(transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->exists()){
    transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->updateWithUserstamps([
        'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}else{
    transactions::create([
       'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}

        if ($Room_Booking) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-booking/room-check-in-aeu/'.$id);

    }



     public function update_checkout(Request $request, $id)
    {


 $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }

       
         $dd='';
         $cati ='';

      if($request->get('booking_type')==0){
          $dd=$request->get('member_id');
            
        if(membership::where('id',$request->get('member_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('member_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
       
      }

  else if($request->get('booking_type')==6){
          $dd=$request->get('corporate_id');
            
        if(corporateMembership::where('id',$request->get('corporate_id'))->exists()){
           $arr_coa=corporateMembership::where('id',$request->get('corporate_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
             $coa_code=null;
            
            $cati = comemcategoryname($dd);
           
          
          }
        }
       
      }   


 else if($request->get('booking_type')>10 || $request->get('booking_type')==1){ 
       /* else if($request->get('booking_type')=='01' || $request->get('booking_type')=='02'){*/

         $request->booking_type=1;
         
          $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
              $coa_code=null;
           $cati =  null;
         
          }
        }
 

        }

       $validation=[
            'booking_type'=>'required',
            'booking_no' => 'required',
            'booking_date'     => 'required',
            'check_in_date'     => 'required',
            //'arrival_details' => 'required',
            'check_out_date'     => 'required',
             'check_out_time'     => 'required',
            //'departure_details' => 'required',
            'first_name'     => 'required',
            'last_name' => 'required',
            'guest_company'     => 'required',
            'guest_address' => 'required',
            'guest_country'     => 'required',
            'guest_city' => 'required',
            'guest_mob'     => 'required',
            'guest_email' => 'required',
            'guest_cnic'     => 'required',
            // 'accompained_guest' => 'required',
            // 'acc_relationship'     => 'required',
            // 'acc_cnic' => 'required',
            'booked_by'     => 'required',
            'booking_type' => 'required',
            // 'moc_number'     =>  'required',

            // 'moc_name' =>  'required',
            //'moc_address' =>  'required',
            // 'moc_cnic' => 'required',
            // 'moc_mob'     =>  'required',
            // 'moc_email'     => 'required',

            'room' => 'required',
            'category'     => 'required',
            'pday_charges_id' => 'required',
            'nights'     => 'required',
            'charges' => 'required',
            //'security'     => 'required',
            //'charges_type' => 'required',
            // 'charges_amount'     => 'required',
            //'complementary' => 'required',
            //  'total_room_charges'     => 'required',

            'total_charges' => 'required',
            //'discount_amount' => 'required',
            // 'discount_details' => 'required',
            'grand_total' => 'required',
         //   'payment_mode' => 'required',
            // 'advance_paid' => 'required',
           // 'total_balance' => 'required'
            // 'additional_notes'   => 'required',
            // 'booking_docs' => 'required'

        ];
     if($request->get('booking_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else if($request->get('booking_type')==6){
            $validation['corporate_code']='required';
            $validation['corporate_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

        $this->validate($request, $validation);

        $Room_Booking = room_booking::where('id', $id)->updateWithUserstamps([

            'booking_no' =>  $request->booking_no,
            'booking_date'     =>  formatDate($request->booking_date),
            'check_in_date'     =>  formatDate($request->check_in_date),
            'arrival_details' =>  $request->arrival_details,
            'check_out_date'     =>  formatDate($request->check_out_date),
            'check_out_time'     =>  $request->check_out_time,
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
            'family' => $request->family,
            'booked_by'     =>  $request->booked_by,
            'booking_type' => $request->booking_type,
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
            'amount_paid' => $request->amount_paid,
            'grand_balance' => $request->grand_balance,
           'additional_notes'   => $request->additional_notes,

          'check_out_status' => 1,
          'coa_code'   => $coa_code,

           //'member'=>1
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

if(transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->exists()){
    transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->updateWithUserstamps([
        'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}else{
    transactions::create([
       'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  1,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(1),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}


        if ($Room_Booking) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

       return redirect('room-management/room-check-out/room-check-out-edit/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_booking  $room_booking
     * @return \Illuminate\Http\Response
     */
     public function destroy(Request $request,room_booking $room_booking,$id)
    {
     $update= room_booking::where('id',$id)->updateWithUserstamps([
        'additional_notes' => $request->remarks,
     ]);

      $delete=$room_booking::where('id', $id)->deleteWithUserstamps();
$transaction=transactions::where('trans_type_id',$id)->where('trans_type',1)->where('debit_or_credit',1)->deleteWithUserstamps();

    }
/*    public function destroy(room_booking $room_booking,$id)
    {
        $roombookings= $room_booking::where('id', $id)->deleteWithUserstamps();

        $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 1)->where('debit_or_credit',1)->deleteWithUserstamps();

        if($roombookings){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('room-management/room-booking-vue');
    }*/

    function calculatecharges(Request $request){
        $roomid=$request->roomid;
        $roomtypeid=$request->roomtypeid;
        $roomcategoryid=$request->roomcategoryid;
        $charges=DB::table('rooms')->select('charges')->join('room_category_charges','room_category_charges.room_id','=','rooms.id')->where('room_category_charges.room_id',$roomid)->where('room_category_charges.room_category_id',$roomcategoryid)->where('rooms.room_type',$roomtypeid)->first();
        if(!empty($charges)){
          return $charges->charges;
        }else{
          return 0;
        }      
    }

    function calculateextracharges($id){
      $charges=room_charges_type::where('id',$id)->first();
      return $charges->charges;
    }



    function roomallocation(request $request){



     $updatecheck=$request->updatecheck;
     $checkindate=$request->pdate;
     $checkOutdate=$request->odate;
     if($checkOutdate==''){
         $checkOutdate=$checkindate;
     }
     $checkindate=date('Y-m-d',strtotime(str_replace('/','-',$checkindate)));
        $checkOutdate=date('Y-m-d',strtotime(str_replace('/','-',$checkOutdate)));
    if($updatecheck!='insert'){
        $bookingroomarray=room_booking::select('room')->where('check_out_date','>',$checkindate)->where('check_in_date','<=',$checkindate)->where('id','!=',$updatecheck)->get()->toArray();

    }else{
//        $bookingroomarray=room_booking::select('room')->whereBetween('check_in_date',[$checkindate,$checkOutdate])->orWhereBetween('check_out_date',[$checkindate,$checkOutdate])->toSql();

        $bookingroomarray=room_booking::select('room')->where('check_out_date','>',$checkindate)->where('check_in_date','<=',$checkindate)->get()->toArray();  }
//    dd($bookingroomarray);
      // DB::enableQueryLog(); // Enable query log

// Your Eloquent query executed by using get()

       // dd($bookingroomarray);
      $data['room']=room::with('roomtypes')->whereNotIn('rooms.id',$bookingroomarray)->where('status',1)->get();
      $data['roomtype']=$data['room'];

      return json_encode($data);

    }


public function restore(room_booking $room_booking,$id)
    {
        $restore = room_booking::onlyTrashed()->wherenull('check_in_time')->find($id)->restore();
        $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',1)->where('debit_or_credit',1)->restore();

        if($restore){



            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room-booking/deleted');

}

}

