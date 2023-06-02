<?php

namespace App\Http\Controllers;

use App\event_booking;
use App\transactions;
use App\trans_relations;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\event_bookingsub;
use App\event_bookingmenusub;
use App\event_bookingaddonsub;
use App\event_charges_type;
use App\event_menu_add_on;
use App\event_venue;
use App\event_menu;
use App\event_rate_category;
use App\finance_payment_methods;
use App\mem_family;
use App\admin_company_profile;
use App\User;
use App\fnb_predefined_value;
use App\membership;
use App\customer;
class EventBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function index_vue(Request $request, event_booking $event_booking)
    {
        return view('backend/events-management/event-booking/event-booking-vue');
    }

       public function init_vue(Request $request)
    {
  $data['collection'] =\Illuminate\Support\Facades\DB::select(

      'select event_bookings.id,
        event_bookings.customer_id,
          event_bookings.member_id,
      event_bookings.booking_no,
      event_bookings.booking_date,
      event_bookings.booking_type,
      event_bookings.venue,
      event_bookings.event_date,
      event_bookings.menu,
      event_bookings.from,
      event_bookings.to,
      event_bookings.grand_total,
      event_bookings.created_by,
      event_bookings.additional_notes,

      memberships.mem_no as mem_no,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
        customer_name as customer,

  users.name as user,
  event_venues.desc as venue,
  event_bookings.cancel_details,
  sum(transactions.trans_amount ) as paid_amount , GROUP_CONCAT(transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,(t1.id) as transid

FROM event_bookings

left outer join users on users.id =event_bookings.created_by and users.status=1
left outer join transactions as t1 on t1.trans_type=2 and t1.trans_type_id=event_bookings.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=2 and transactions.trans_type_id=event_bookings.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join memberships on memberships.id = event_bookings.member_id and memberships.deleted_at is null
left outer join customers on customers.id =event_bookings.customer_id and customers.deleted_at is null
 left outer join event_venues on event_venues.id = event_bookings.venue
                      
where event_bookings.deleted_at is null and event_bookings.check_out_status=0 group by event_bookings.id order by event_bookings.id desc');

 $data['users']= User::where('status',1)->get();
 $data['venues']=event_venue::where('status',1)->get();
if(Auth::user()->can('Export Event Booking')){
 $data['exported']=1;
 }
     return $data;
}


      public function checkout_vue(Request $request, event_booking $event_booking)
    {
        return view('backend/events-management/event-booking/event-checkout-vue');
    }

       public function init_checkout(Request $request)
    {
  $data['collection'] =\Illuminate\Support\Facades\DB::select(

      'select event_bookings.id,
        event_bookings.customer_id,
          event_bookings.member_id,
      event_bookings.booking_no,
      event_bookings.booking_date,
      event_bookings.booking_type,
      event_bookings.venue,
      event_bookings.event_date,
      event_bookings.menu,
      event_bookings.from,
      event_bookings.to,
      event_bookings.grand_total,
      event_bookings.created_by,
      event_bookings.additional_notes,

      memberships.mem_no as mem_no,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname, 
  memberships.middle_name as mname,
        customer_name as customer,

  users.name as user,
  event_venues.desc as venue,
  event_bookings.cancel_details,
  sum(transactions.trans_amount ) as paid_amount , GROUP_CONCAT(transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,(t1.id) as transid


FROM event_bookings

left outer join users on users.id =event_bookings.created_by and users.status=1
left outer join memberships on memberships.id = event_bookings.member_id and memberships.deleted_at is null
left outer join customers on customers.id =event_bookings.customer_id and customers.deleted_at is null
 left outer join event_venues on event_venues.id = event_bookings.venue
left outer join transactions as t1 on t1.trans_type=2 and t1.trans_type_id=event_bookings.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=2 and transactions.trans_type_id=event_bookings.id and transactions.debit_or_credit=0 and transactions.deleted_at is null


where event_bookings.deleted_at is null and event_bookings.check_out_status=1 group by event_bookings.id order by event_bookings.id desc');

 $data['users']= User::where('status',1)->get();
 $data['venues']=event_venue::where('status',1)->get();
if(Auth::user()->can('Export Event Check Out')){
 $data['exported']=1;
 }
     return $data;
}



    public function cancelled_vue(Request $request, event_booking $event_booking)
    {
        return view('backend/events-management/event-booking/event-booking-cancelled-vue');
    }

       public function init_cancelled(Request $request)
    {
  $data['collection'] =\Illuminate\Support\Facades\DB::select(

      'select event_bookings.id,
        event_bookings.customer_id,
          event_bookings.member_id,
      event_bookings.booking_no,
      event_bookings.booking_date,
      event_bookings.booking_type,
      event_bookings.venue,
      event_bookings.event_date,
      event_bookings.menu,
      event_bookings.from,
      event_bookings.to,
      event_bookings.grand_total,
    event_bookings.cancel_details,
      event_bookings.updated_by,
      memberships.mem_no as mem_no,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
        customer_name as customer,
  users.name as user,
  event_venues.desc as venue


FROM event_bookings

left outer join users on users.id =event_bookings.updated_by and users.status=1
left outer join memberships on memberships.id = event_bookings.member_id and memberships.deleted_at is null
left outer join customers on customers.id =event_bookings.customer_id and customers.deleted_at is null
 left outer join event_venues on event_venues.id = event_bookings.venue
                      
where event_bookings.deleted_at is null and event_bookings.check_out_status=2 group by event_bookings.id order by event_bookings.id desc');

 $data['users']= User::where('status',1)->get();
 $data['venues']=event_venue::where('status',1)->get();
     return $data;
}








   public function index(Request $request, event_booking $event_booking)
    {
       return view('backend/events-management/event-booking/event-booking');
    }

     public function indexdt(Request $request, event_booking $event_booking)
    {

        $event_bookings = event_booking::where('check_out_status',0)->get();

        $x= DataTables::of($event_bookings)

            ->addColumn('editbutton', function ($event_bookings) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-booking/event-booking-aeu/') . '/' . $event_bookings->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($event_bookings) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/event-booking/delete') . '/' . $event_bookings->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


 ->addColumn('cancel', function ($event_bookings) {
                return '<button class="buttoncolor" title="Cancel"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-booking/event-cancel/') . '/' . $event_bookings->id . '"><i class="fas fa-times"></i></a></button>'
                ;
            })


  ->addColumn('invoice', function ($event_bookings) {
                return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-booking/invoice/') . '/' . $event_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

         ->addColumn('status', function ($event_bookings) {

                return '<a target="_blank" href="' . url('events-management/event-booking/event-checkout-aeu/') . '/' . $event_bookings->id . '"><button style="cursor:pointer;" class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Check Out Event">Done</button></a>'
                ;

            })


               ->addColumn('type', function ($event_bookings) {
                if($event_bookings->booking_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })


                ->addColumn('booking_date', function ($col) {
                    return [
                        'display' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->format('d/m/Y') : '',
                        'timestamp' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->timestamp : ''
                    ];

                })

               ->addColumn('customer_id', function ($event_bookings) {
//                    dd($event_bookings->member);
              return $event_bookings->booking_type==0?$event_bookings->member?$event_bookings->member->mem_no:'':$event_bookings->customer_id;


                })
                ->addColumn('event_date', function ($event_bookings) {
              return formatDateToShow($event_bookings->event_date);


                })



                ->addColumn('venue', function ($event_bookings) {
              return eventvenue($event_bookings->venue);


                })

                ->addColumn('menu', function ($event_bookings) {
              return eventmenu($event_bookings->menu);


                })

            ->rawColumns(['editbutton','deletebutton', 'status','event_bookingsub', 'event_venue','event_charges_type', 'event_menu', 'event_rate_category', 'finance_payment_methods', 'mem_family', 'venue', 'menu', 'cancel', 'invoice'])

            ->addIndexColumn()
            ->make(true);
               return $x;
    }




    public function index_deleted(Request $request, event_booking $event_booking)
    {
        return view('backend/events-management/event-booking/event-booking-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_booking $event_booking)
    {
        $event_bookings = event_booking::onlyTrashed()->get();
        return DataTables::of($event_bookings)


               ->addColumn('type', function ($event_bookings) {
                if($event_bookings->booking_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })


                ->addColumn('booking_date', function ($col) {
                    return [
                        'display' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->format('d/m/Y') : '',
                        'timestamp' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->timestamp : ''
                    ];

                })

               ->addColumn('customer_id', function ($event_bookings) {
//                    dd($event_bookings->member);
              return $event_bookings->booking_type==0?$event_bookings->member?$event_bookings->member->mem_no:'':$event_bookings->customer_id;


                })
                ->addColumn('event_date', function ($event_bookings) {
              return formatDateToShow($event_bookings->event_date);


                })

                
                  ->addColumn('deleted_at', function ($event_bookings) {
              return formatDateToShow($event_bookings->deleted_at);


                }) 

                ->addColumn('venue', function ($event_bookings) {
              return eventvenue($event_bookings->venue);


                })

                ->addColumn('menu', function ($event_bookings) {
              return eventmenu($event_bookings->menu);


                })

            ->addColumn('restorebutton', function ($event_bookings) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/event-booking/restore/') . '/' . $event_bookings->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton','event_bookingsub', 'event_venue','event_charges_type', 'event_menu', 'event_rate_category', 'finance_payment_methods', 'mem_family','venue', 'menu'])
        ->addIndexColumn()
        ->make(true);
    }


    public function index_cancelled(Request $request, event_booking $event_booking)
    {
        return view('backend/events-management/event-booking/event-booking-cancelled');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_cancelled(Request $request, event_booking $event_booking)
    {
        $event_bookings = event_booking::where('check_out_status',2)->get();
        return DataTables::of($event_bookings)


               ->addColumn('type', function ($event_bookings) {
                if($event_bookings->booking_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })

                ->addColumn('booking_date', function ($col) {
                    return [
                        'display' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->format('d/m/Y') : '',
                        'timestamp' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->timestamp : ''
                    ];

                })

               ->addColumn('customer_id', function ($event_bookings) {
//                    dd($event_bookings->member);
              return $event_bookings->booking_type==0?$event_bookings->member?$event_bookings->member->mem_no:'':$event_bookings->customer_id;


                })
                ->addColumn('event_date', function ($event_bookings) {
              return formatDateToShow($event_bookings->event_date);


                })

                ->addColumn('venue', function ($event_bookings) {
              return eventvenue($event_bookings->venue);


                })

                ->addColumn('menu', function ($event_bookings) {
              return eventmenu($event_bookings->menu);


                })

                  ->addColumn('re-confirm', function ($event_bookings) {

                return '<a href="' . url('events-management/event-booking/reconfirm/') . '/' . $event_bookings->id . '"><button style="cursor:pointer;" class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Re-Confirm Event">Re-Confirm</button></a>'
                ;

            })

        ->rawColumns(['event_bookingsub', 'event_venue','event_charges_type', 'event_menu', 'event_rate_category', 'finance_payment_methods', 'mem_family','venue', 'menu','re-confirm'])
        ->addIndexColumn()
        ->make(true);
    }


  /*   public function reconfirm(Request $request, $id)
    {

        $reconfirm = event_booking::where('id', $id)->updateWithUserstamps([
 
            'check_out_status' => 0
        ]);
        $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->restore();

        if ($reconfirm) {
            Session::flash('message', 'Booking Re-Confimed Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Booking Not Re-Confimed !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/event-booking/cancelled-vue');

    }*/
     public function reconfirm(Request $request,event_booking $event_booking,$id)
    {
     $update= event_booking::where('id',$id)->updateWithUserstamps([
        'check_out_status' => 0,
     ]);

      $transaction = transactions::onlyTrashed()->where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id', $id)->restore();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Get the last record id and pass to the view
        $lastval = event_booking::withTrashed()->latest('id')->first();

        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['event_booking_update'] = '';

        $data['venue']=event_venue::where('status',1)->get();
        $data['menu']=event_menu::where('status',1)->get();
 $data['add_on']=event_menu_add_on::where('status',1)->get();
        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['charges_type']=event_charges_type::where('status',1)->get();
        $data['menu_category']=event_rate_category::where('status',1)->get();


$customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
      /*  $data['roombooking']=room_booking::where('id',$id)->first();*/
        return view('backend/events-management.event-booking.event-booking-aeu', $data);
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

        else if($request->get('booking_type')==1){
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
    'booking_type' => 'required',
 'moc_name' =>  'required',
    'booked_by'     => 'required',
    'nature_of_event'     => 'required',
    'event_date'     => 'required',
    'from'     => 'required',
    'to' => 'required',

    'venue' => 'required',
    'menu'     => 'required',
    //'menu_category' => 'required',
    'menu_charges' => 'required',
    'total_per_person_charges' => 'required',

    'guests'     => 'required',
    'total_food_charges' => 'required',
    'grand_guest_charges' => 'required',

   // 'total_other_charges' => 'required',
    'total_charges' => 'required',

   // 'surcharge_total' => 'required',

    'grand_total' => 'required',
    //'payment_mode' => 'required',

    //'total_balance' => 'required',
'amount_in_words' => 'required',
  //'grand_balance' => 'required',
    //'booking_docs' => 'required'
];
        if($request->get('booking_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

         //dd($request->all());
       $this->validate($request, $validation);

        $Event_Booking = event_booking::create([

            'booking_no' =>  $request->booking_no,
            'booking_date'     =>  formatDate($request->booking_date),
            'booking_type' => $request->booking_type,
              'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
         'moc_name' =>  $request->moc_name,
         'moc_address' =>  $request->moc_address,
         'moc_cnic' =>  $request->moc_cnic,
          'moc_mob'     =>  $request->moc_mob,
          'moc_email'     =>  $request->moc_email,
          'ledger_amount' => $request->ledger_amount,
             'family' => $request->family,
           'booked_by'     =>  $request->booked_by,
           'nature_of_event'     =>  $request->nature_of_event,
            'event_date'     =>  formatDate($request->event_date),
            'from'     =>  $request->from,
            'to'     =>  $request->to,
            'venue' =>  $request->venue,
            'menu'     => $request->menu,
            'menu_category' =>  $request->menu_category,
            'menu_charges'     =>  $request->menu_charges,
            'total_addon_charges'     =>  $request->total_addon_charges,
            'total_per_person_charges'     =>  $request->total_per_person_charges,

            'guests' =>  $request->guests,
            'total_food_charges'     =>  $request->total_food_charges,
            'extra_guests' =>  $request->extra_guests,
            'extra_food_charges'     =>  $request->extra_food_charges,
            'grand_guest_charges'     =>  $request->grand_guest_charges,

            'total_other_charges' =>  $request->total_other_charges,
            'total_charges' =>  $request->total_charges,

            'surcharge' =>  $request->surcharge,
            'surcharge_percentage' =>  $request->surcharge_percentage,
            'surcharge_details'=> $request->surcharge_details,
           // 'surcharge_total' =>  $request->surcharge_total,
            'discount_amount' =>  $request->discount_amount,
            'discount_percentage' =>  $request->discount_percentage,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'amount_in_words' => $request->amount_in_words,
            'amount_paid' => $request->amount_paid,
            'grand_balance' => $request->grand_balance,

           /* 'discount_amount' =>  $request->discount_amount,
            'discount_percentage' =>  $request->discount_percentage,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'payment_mode' =>  $request->payment_mode,
            'payment_mode_details' =>  $request->payment_mode_details,
           'advance_paid' =>  $request->advance_paid,
            'total_balance' => $request->total_balance,
            'amount_in_words' => $request->amount_in_words,*/
         //   'booking_docs'=>$createimg,
           'additional_notes'   => $request->additional_notes,
           'check_out_status' => 0,
             'coa_code'   => $coa_code,
        ]);

        if($request->hasFile('booking_docs')) {

           $files = $request->file('booking_docs');
           foreach($files as $file){
             // dd($file);

            if($request->booking_type==1){ //for Guest/Customer
              $createimg=sendEventDocs($file,$size,['type'=>1,'trans_type'=>2,'trans_type_id'=>$Event_Booking->id,'moc_id'=>$request->post('customer_id')]);   // type = 61
            }
            else{// for Member
              $createimg=sendEventDocs($file,$size,['type'=>0,'trans_type'=>2,'trans_type_id'=>$Event_Booking->id,'moc_id'=>$request->post('member_id')]);     // type = 62
            }

          }
       }



        $itemname=$request->item_name;
          $i=0;
        foreach ($itemname as $itemnames => $item) {
            $ta = new event_bookingmenusub;
            $ta->booking_id = $Event_Booking->id;
            $ta->item_name=$itemname[$i];
            $ta->save();
            $i++;
        }



        $name=$request->add_on_name;
         $details=$request->addon_bill_details;
        $charges=$request->add_on_charges;
        $com=$request->complementarytwo;

          $i=0;
        foreach ($charges as $chargesamttwo => $char_amt_two) {

            $ta = new event_bookingaddonsub;
            $ta->booking_id = $Event_Booking->id;
             $ta->addon_bill_details = $details[$i];
            $ta->add_on_charges = $charges[$i];
            $ta->add_on_name=$name[$i];
            $ta->addoncomplementary=$com[$i];
            $ta->save();
            $i++;
        }



         $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;
        $complementary=$request->complementary;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new event_bookingsub;
            $ta->booking_id = $Event_Booking->id;
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
        'trans_type' =>  2,
        'trans_type_id' =>  $Event_Booking->id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(2),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);  


        if ($Event_Booking) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
            $getlastinsert=$Event_Booking->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        if(empty($save))
            {
                return redirect('room-management/event-booking/event-booking-aeu');
            }else{
                return redirect('events-management/event-booking-vue');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_booking  $event_booking
     * @return \Illuminate\Http\Response
     */
    public function show(event_booking $event_booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_booking  $event_booking
     * @return \Illuminate\Http\Response
     */
    public function edit(event_booking $event_booking,$id)
    {

        $data['event_booking_update'] = event_booking::where('id', $id)->first();

        $data['init']                = 1;
        $data['increment_number']    = $data['event_booking_update']->code;

           $data['eventsub']=event_booking::with('menus')->where('id', $id)->get();
       $data['eventsubdata']=$data['eventsub'][0]['menus'];

        $data['bookingsub']=event_booking::with('eventBookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['eventBookings'];

        $data['addonsub']=event_booking::with('eventAddOns')->where('id', $id)->get();
       $data['menuaddons']=$data['addonsub'][0]['eventAddOns'];

        $data['venue']=event_venue::where('status',1)->get();
        $data['menu']=event_menu::where('status',1)->get();

        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['charges_type']=event_charges_type::where('status',1)->get();
        $data['add_on']=event_menu_add_on::where('status',1)->get();
        $data['menu_category']=event_rate_category::where('status',1)->get();

         $memberfmid=$data['event_booking_update']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

        return view('backend/events-management.event-booking.event-booking-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_booking  $event_booking
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

        else if($request->get('booking_type')==1){
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

if($request->booking_type==1){
     $s=event_booking::find($id)->eventDocs;
           foreach($s as $m){
               $m->delete();
    }
}
            else{
           $s=event_booking::find($id)->eventDocs;
           foreach($s as $m){
               $m->delete();
           }
           }


           foreach($files as $file){
             // dd($file);
            if($request->booking_type==1){
              $updateimg=sendEventDocs($file,$size,['type'=>1,'trans_type'=>2,'trans_type_id'=>$id,'moc_id'=>$request->post('customer_id')]);
            }
            else{
              $updateimg=sendEventDocs($file,$size,['type'=>0,'trans_type'=>2,'trans_type_id'=>$id,'moc_id'=>$request->post('member_id')]);
            }

          }
       }

       $validation=[
              'booking_no' => 'required',
    'booking_date'     => 'required',
    'booking_type' => 'required',
 'moc_name' =>  'required',
    'booked_by'     => 'required',
    'nature_of_event'     => 'required',
    'event_date'     => 'required',
    'from'     => 'required',
    'to' => 'required',

    'venue' => 'required',
    'menu'     => 'required',
    //'menu_category' => 'required',
    'menu_charges' => 'required',
    'total_per_person_charges' => 'required',

    'guests'     => 'required',
    'total_food_charges' => 'required',
    'grand_guest_charges' => 'required',

   // 'total_other_charges' => 'required',
    'total_charges' => 'required',

   // 'surcharge_total' => 'required',

    'grand_total' => 'required',
    //'payment_mode' => 'required',

    //'total_balance' => 'required',
'amount_in_words' => 'required',
  //'grand_balance' => 'required',
    //'booking_docs' => 'required'
        ];
        if($request->get('booking_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

        $this->validate($request, $validation);

        $Event_Booking = event_booking::where('id', $id)->updateWithUserstamps([

            'booking_no' =>  $request->booking_no,
            'booking_date'     =>  formatDate($request->booking_date),
            'booking_type' => $request->booking_type,
              'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
         'moc_name' =>  $request->moc_name,
         'moc_address' =>  $request->moc_address,
         'moc_cnic' =>  $request->moc_cnic,
          'moc_mob'     =>  $request->moc_mob,
          'moc_email'     =>  $request->moc_email,
          'ledger_amount' => $request->ledger_amount,
             'family' => $request->family,
           'booked_by'     =>  $request->booked_by,
           'nature_of_event'     =>  $request->nature_of_event,
            'event_date'     =>  formatDate($request->event_date),
            'from'     =>  $request->from,
            'to'     =>  $request->to,
            'venue' =>  $request->venue,
            'menu'     => $request->menu,
            'menu_category' =>  $request->menu_category,
            'menu_charges'     =>  $request->menu_charges,
            'total_addon_charges'     =>  $request->total_addon_charges,
            'total_per_person_charges'     =>  $request->total_per_person_charges,

            'guests' =>  $request->guests,
            'total_food_charges'     =>  $request->total_food_charges,
            'extra_guests' =>  $request->extra_guests,
            'extra_food_charges'     =>  $request->extra_food_charges,
            'grand_guest_charges'     =>  $request->grand_guest_charges,

            'total_other_charges' =>  $request->total_other_charges,
            'total_charges' =>  $request->total_charges,

             'surcharge' =>  $request->surcharge,
            'surcharge_percentage' =>  $request->surcharge_percentage,
            'surcharge_details'=> $request->surcharge_details,
            //'surcharge_total' =>  $request->surcharge_total,
            'discount_amount' =>  $request->discount_amount,
            'discount_percentage' =>  $request->discount_percentage,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'amount_in_words' => $request->amount_in_words,
             'amount_paid' => $request->amount_paid,
            'grand_balance' => $request->grand_balance,
/*
            'discount_amount' =>  $request->discount_amount,
            'discount_percentage' =>  $request->discount_percentage,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'payment_mode' =>  $request->payment_mode,
            'payment_mode_details' =>  $request->payment_mode_details,
           'advance_paid' =>  $request->advance_paid,
            'total_balance' => $request->total_balance,
            'amount_in_words' => $request->amount_in_words,*/
     //       'booking_docs'=>$updateimg,
           'additional_notes'   => $request->additional_notes,
           'check_out_status' => 0,
            'coa_code'   => $coa_code,
        ]);

 $menudelete= event_bookingmenusub::where('booking_id', $id)->delete();

if($menudelete){

    $itemname=$request->item_name;
          $i=0;
        foreach ($itemname as $itemnames => $item) {

            $ta = new event_bookingmenusub;
             $ta->booking_id=$id;
            $ta->item_name=$itemname[$i];
            $ta->save();
            $i++;
        }
    }


  $addondelete= event_bookingaddonsub::where('booking_id', $id)->delete();

if($addondelete){

        $name=$request->add_on_name;
         $details=$request->addon_bill_details;
        $charges=$request->add_on_charges;
        $com=$request->complementarytwo;

          $i=0;
        foreach ($charges as $chargesamttwo => $char_amt_two) {

            $ta = new event_bookingaddonsub;
            $ta->booking_id=$id;
             $ta->addon_bill_details = $details[$i];
            $ta->add_on_charges = $charges[$i];
            $ta->add_on_name=$name[$i];
            $ta->addoncomplementary=$com[$i];
            $ta->save();
            $i++;
        }
    }



   $eventdelete= event_bookingsub::where('booking_id', $id)->delete();

if($eventdelete){

    $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;
        $complementary=$request->complementary;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new event_bookingsub;
             $ta->booking_id=$id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->iscomplementary=$complementary[$i];
            $ta->save();
            $i++;
        }
    }



if(transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->exists()){
    transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->updateWithUserstamps([
        'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  2,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(2),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}else{
    transactions::create([
       'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  2,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(2),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}

        if ($Event_Booking) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/event-booking/event-booking-aeu/'.$id);

    }



public function edit_cancel(event_booking $event_booking,$id)
    {

        $data['cancel_update'] = event_booking::where('id', $id)->first();

        $data['init']                = 1;
        $data['increment_number']    = $data['cancel_update']->code;

        return view('backend/events-management.event-booking.event-booking-cancel', $data);
    }

    public function update_cancel(Request $request, $id)
    {

       $validation=[
              'cancel_details' => 'required',
        ];
    
        $this->validate($request, $validation);

        $Event_Booking = event_booking::where('id', $id)->updateWithUserstamps([

            'cancel_details' =>  $request->cancel_details,
            'check_out_status' => 2
            
        ]);

        $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->deleteWithUserstamps();


        if ($Event_Booking) {
            Session::flash('message', 'Booking Cancelled Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Booking Not Cancelled !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/event-booking-vue');

    }


 function calculateextracharges($id){
      $charges=event_charges_type::where('id',$id)->first();
      return $charges->charges;
    }

    function calculateaddoncharges($id){
      $addons=event_menu_add_on::where('id',$id)->first();
      return $addons->charges;
    }


 function calculatemenucharges($id){
      $menu=event_menu::with(['menus','menus.item'])->where('id',$id)->first();
      return $menu;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_booking  $event_booking
     * @return \Illuminate\Http\Response
     */
 public function cancel(Request $request,event_booking $event_booking,$id)
    {
     $update= event_booking::where('id',$id)->updateWithUserstamps([
        'cancel_details' => $request->cancel_details,
        'check_out_status' => 2,
     ]);

      $transaction = transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id', $id)->deleteWithUserstamps();
    }

        public function destroy(Request $request,event_booking $event_booking,$id)
    {
     $update= event_booking::where('id',$id)->updateWithUserstamps([
        'additional_notes' => $request->remarks,
     ]);

      $delete=$event_booking::where('id', $id)->deleteWithUserstamps();
      $transaction = transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id', $id)->deleteWithUserstamps();
    }
 /*   public function destroy(event_booking $event_booking,$id)
    {
        $bookings= $event_booking::where('id', $id)->deleteWithUserstamps();
        $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->deleteWithUserstamps();

        if($bookings){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('events-management/event-booking');
    }
*/

public function restore(event_booking $event_booking,$id)
    {
        $restore = event_booking::onlyTrashed()->find($id)->restore();
        $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->restore();

        if($restore){
            Session::flash('message', 'Data Restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to Restore Data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/event-booking/deleted');

}





public function index_checkout(Request $request, event_booking $event_booking)
    {
        return view('backend/events-management/event-booking/event-checkout');
    }

public function indexdt_checkout(Request $request, event_booking $event_booking)
    {

        $r = event_booking::where('check_out_status', 1);
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
            $r->where('booking_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('booking_date','<=',formatDate($request->get('end_date')));

        }
        if($request->get('receipt')){
            $r->where('booking_no','=',$request->get('receipt'));

        }

       /* if($request->get('status')){
         $rid = $r->get()->pluck('id');
          $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$rid)->get()->pluck('id');
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

           $r->where('booking_date','=','00/00/0000');
        }
      
       //echo $r->toSql();
         $event_bookings=$r->get();
 
        $dx=  DataTables::of($event_bookings)

->addColumn('dtotal', function ($r) {
                $request=Request::capture();
                $r=  event_booking::where('check_out_status', 1);

                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

                          $r->where('customer_id',$x);

                    }
                }
                else{
                    if($request->get('customer')){
                        $x=$request->get('customer');

                         $r->where('customer_id',$x);

                    }

                }
                if($request->get('start_date')){
                    $r->where('booking_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('booking_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('receipt')){
                    $r->where('booking_no','=',$request->get('receipt'));

                }

                  $rid = $r->get()->pluck('id');
            $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }

              

               return [
                   'GrandTotal'=>number_format( $r->sum('grand_total')),
                   'AmountPaid'=>number_format( $x),
                   'Balance'=>number_format( $r->sum('grand_total')-$x)
                   
                   ] ;


            })
 ->addColumn('ctotal', function ($receipts) {
                $request=Request::capture();
                $r=  event_booking::where('check_out_status', 1);

                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

                          $r->where('customer_id',$x);

                    }
                }
                else{
                    if($request->get('customer')){
                        $x=$request->get('customer');

                         $r->where('customer_id',$x);

                    }

                }
                if($request->get('start_date')){
                    $r->where('booking_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('booking_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('receipt')){
                    $r->where('booking_no','=',$request->get('receipt'));

                }
                if(!($request->get('mog')!='undefined'||
                    $request->get('customer')!=''||
                    $request->get('start_date')!=''||
                    $request->get('end_date')!=''||
                    $request->get('receipt')!='')){
                   
                    $r->where('check_out_date','>=','00/00/0000');
                }
                return number_format($r->count('id')) ;


            })


            ->addColumn('editbutton', function ($event_bookings) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-checkout/edit/') . '/' . $event_bookings->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })


            ->addColumn('status', function ($event_bookings) {
                return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-checkout/invoice/') . '/' . $event_bookings->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })


               ->addColumn('type', function ($event_bookings) {
                if($event_bookings->booking_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })


                ->addColumn('booking_date', function ($col) {
                    return [
                        'display' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->format('d/m/Y') : '',
                        'timestamp' =>($col->booking_date && $col->booking_date != '0000-00-00 00:00:00') ? with(new Carbon($col->booking_date))->timestamp : ''
                    ];

                })

               ->addColumn('customer_id', function ($event_bookings) {
//                    dd($event_bookings->member);
              return $event_bookings->booking_type==0?$event_bookings->member?$event_bookings->member->mem_no:'':$event_bookings->customer_id;


                })
                ->addColumn('event_date', function ($event_bookings) {
              return formatDateToShow($event_bookings->event_date);


                })



                ->addColumn('venue', function ($event_bookings) {
              return eventvenue($event_bookings->venue);


                })

                ->addColumn('menu', function ($event_bookings) {
              return eventmenu($event_bookings->menu);


                })

                ->addColumn('details_d', function ($event_bookings) {
                $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$event_bookings->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get());
                foreach($b as $d){
//                    dd($d->type);
                    $c=$d->type->name;
                    return "   <a target='_blank' href='".route('cash.receipt.print',$d['receipt_id'])."'>($d[receipt_id] - $c)</a><br>";
                }
           })

                 ->addColumn('amountpaid', function ($event_bookings) {
             $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$event_bookings->id)->get()->pluck('id');
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

           ->addColumn('finalbalance', function ($event_bookings) {
             $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$event_bookings->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }

             return $event_bookings->grand_total-$x;

           })

            ->addColumn('balancestatus', function ($event_bookings) {

          $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$event_bookings->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }


            $resultant = $event_bookings->grand_total-$x;

               if($resultant==0){
return '<button class=" btn btn-outline-success active">Paid</button>';
               }
               else{
                if($event_bookings->booking_type==0){
                return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?'. 'memid='. $event_bookings->member_id . '">Unpaid</a></button>';
                }
                else if($event_bookings->booking_type==1){
                     return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?'. 'guestid='. $event_bookings->customer_id . '">Unpaid</a></button>';
                }

               }
            })

             ->addColumn('paid', function ($event_bookings) {
                $d=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$event_bookings->id)->first();
                if($d){

                    if($d->is_active==1){
                        return "<button type='button' class='btn btn-success btn-sm'>INV</button>";
                    }
                    else{
                        return "<button type='button' onclick='$.get(`".route('transActive',$d->id)."`,(a)=>{location.reload();})' class='btn btn-danger btn-sm'>GEN</button>";

                    }

                }
                else{
                    return '';
                }
            })

            ->rawColumns(['editbutton', 'status','event_bookingsub', 'event_venue','event_charges_type', 'event_menu', 'event_rate_category', 'finance_payment_methods', 'mem_family', 'venue', 'menu', 'amountpaid', 'finalbalance', 'balancestatus', 'paid', 'details_d'])

            ->addIndexColumn()
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
        $x = array_values($x);

        $ddm['data']=(array)$x;
       return $ddm;

    }


    public function create_checkout(event_booking $event_booking,Request $request)
    {     $id=$request->segment(4);
         $data['eventbooking']=event_booking::where('id',$id)->first();

    $data['eventsub']=event_booking::with('menus')->where('id', $id)->get();
       $data['eventsubdata']=$data['eventsub'][0]['menus'];

        $data['bookingsub']=event_booking::with('eventBookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['eventBookings'];

        $data['addonsub']=event_booking::with('eventAddOns')->where('id', $id)->get();
       $data['menuaddons']=$data['addonsub'][0]['eventAddOns'];

        $data['venue']=event_venue::where('status',1)->get();
        $data['menu']=event_menu::where('status',1)->get();

        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['charges_type']=event_charges_type::where('status',1)->get();
        $data['add_on']=event_menu_add_on::where('status',1)->get();
        $data['menu_category']=event_rate_category::where('status',1)->get();

$data['init']                = 1;

$data['checkout']                = 0;

$memberfmid=$data['eventbooking']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

         return view('backend/events-management.event-booking.event-checkout-aeu',$data);
    }

     public function store_checkout(Request $request, $id)
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

        else if($request->get('booking_type')==1){
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

      $save=$request->save;

           $validation=[
'booking_no' => 'required',
    'booking_date'     => 'required',
    'booking_type' => 'required',
 'moc_name' =>  'required',
    'booked_by'     => 'required',
    'nature_of_event'     => 'required',
    'event_date'     => 'required',
    'from'     => 'required',
    'to' => 'required',

    'venue' => 'required',
    'menu'     => 'required',
    //'menu_category' => 'required',
    'menu_charges' => 'required',
    'total_per_person_charges' => 'required',

    'guests'     => 'required',
    'total_food_charges' => 'required',
    'grand_guest_charges' => 'required',

  //  'total_other_charges' => 'required',
    'total_charges' => 'required',

   // 'surcharge_total' => 'required',

    'grand_total' => 'required',
    //'payment_mode' => 'required',

    //'total_balance' => 'required',
'amount_in_words' => 'required',
  //'grand_balance' => 'required',
    //'booking_docs' => 'required'
          ];

        $this->validate($request, $validation);

        $checkout = event_booking::where('id', $id)->updateWithUserstamps([

            'booking_no' =>  $request->booking_no,
            'booking_date'     =>  formatDate($request->booking_date),
            'booking_type' => $request->booking_type,
              'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
         'moc_name' =>  $request->moc_name,
         'moc_address' =>  $request->moc_address,
         'moc_cnic' =>  $request->moc_cnic,
          'moc_mob'     =>  $request->moc_mob,
          'moc_email'     =>  $request->moc_email,
          'ledger_amount' => $request->ledger_amount,
             'family' => $request->family,
           'booked_by'     =>  $request->booked_by,
           'nature_of_event'     =>  $request->nature_of_event,
            'event_date'     =>  formatDate($request->event_date),
            'from'     =>  $request->from,
            'to'     =>  $request->to,
            'venue' =>  $request->venue,
            'menu'     => $request->menu,
            'menu_category' =>  $request->menu_category,
            'menu_charges'     =>  $request->menu_charges,
            'total_addon_charges'     =>  $request->total_addon_charges,
            'total_per_person_charges'     =>  $request->total_per_person_charges,

            'guests' =>  $request->guests,
            'total_food_charges'     =>  $request->total_food_charges,
            'extra_guests' =>  $request->extra_guests,
            'extra_food_charges'     =>  $request->extra_food_charges,
            'grand_guest_charges'     =>  $request->grand_guest_charges,

            'total_other_charges' =>  $request->total_other_charges,
            'total_charges' =>  $request->total_charges,

             'surcharge' =>  $request->surcharge,
            'surcharge_percentage' =>  $request->surcharge_percentage,
            'surcharge_details'=> $request->surcharge_details,
          //  'surcharge_total' =>  $request->surcharge_total,
            'discount_amount' =>  $request->discount_amount,
            'discount_percentage' =>  $request->discount_percentage,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'amount_in_words' => $request->amount_in_words,
             'amount_paid' => $request->amount_paid,
            'grand_balance' => $request->grand_balance,
/*
            'discount_amount' =>  $request->discount_amount,
            'discount_percentage' =>  $request->discount_percentage,
            'discount_details'=> $request->discount_details,
            'grand_total' =>  $request->grand_total,
            'payment_mode' =>  $request->payment_mode,
            'payment_mode_details' =>  $request->payment_mode_details,
           'advance_paid' =>  $request->advance_paid,
            'total_balance' => $request->total_balance,
            'amount_in_words' => $request->amount_in_words,*/
           'additional_notes'   => $request->additional_notes,
           'check_out_status' => 1,
             'coa_code'=>$coa_code,

        ]);

 $menudelete= event_bookingmenusub::where('booking_id', $id)->delete();

if($menudelete){

    $itemname=$request->item_name;
          $i=0;
        foreach ($itemname as $itemnames => $item) {

            $ta = new event_bookingmenusub;
             $ta->booking_id=$id;
            $ta->item_name=$itemname[$i];
            $ta->save();
            $i++;
        }
    }


  $addondelete= event_bookingaddonsub::where('booking_id', $id)->delete();

if($addondelete){

        $name=$request->add_on_name;
         $details=$request->addon_bill_details;
        $charges=$request->add_on_charges;
        $com=$request->complementarytwo;

          $i=0;
        foreach ($charges as $chargesamttwo => $char_amt_two) {

            $ta = new event_bookingaddonsub;
            $ta->booking_id=$id;
             $ta->addon_bill_details = $details[$i];
            $ta->add_on_charges = $charges[$i];
            $ta->add_on_name=$name[$i];
            $ta->addoncomplementary=$com[$i];
            $ta->save();
            $i++;
        }
    }



   $eventdelete= event_bookingsub::where('booking_id', $id)->delete();

if($eventdelete){

    $chargestypes=$request->charges_type;
         $billdetails=$request->bill_details;
        $chargesamount=$request->charges_amount;
        $complementary=$request->complementary;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new event_bookingsub;
             $ta->booking_id=$id;
             $ta->bill_details = $billdetails[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i];
            $ta->iscomplementary=$complementary[$i];
            $ta->save();
            $i++;
        }
    }


if(transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->exists()){
    transactions::where('type',1)->where('trans_type_id', $id)->where('trans_type', 2)->where('debit_or_credit',1)->updateWithUserstamps([
        'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  2,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(2),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
        ]);
}else{
    transactions::create([
       'type' =>  1,
        'debit_or_credit' =>  1,
        'trans_type' =>  2,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  $request->booking_type,
        'trans_moc' =>  $dd,
        'trans_moc_category'=> $cati,
        'date' =>  formatDate($request->booking_date),
         'account' => transTypesCoa(2),
           'trans_coa' => $coa_code,
            'unit' => $ccc,
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
                return redirect('events-management/event-checkout-vue');
            }else{
                return redirect('events-management/event-checkout-vue');
            }

    }

    public function edit_checkout(event_booking $event_booking,$id)
    {

        $data['eventbooking'] = event_booking::where('id', $id)->first();

        $data['init']                = 1;
        $data['checkout']                = 1;
        $data['increment_number']    = $data['eventbooking']->code;

        $data['eventsub']=event_booking::with('menus')->where('id', $id)->get();
       $data['eventsubdata']=$data['eventsub'][0]['menus'];

        $data['bookingsub']=event_booking::with('eventBookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['eventBookings'];

        $data['addonsub']=event_booking::with('eventAddOns')->where('id', $id)->get();
       $data['menuaddons']=$data['addonsub'][0]['eventAddOns'];

        $data['venue']=event_venue::where('status',1)->get();
        $data['menu']=event_menu::where('status',1)->get();

        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['charges_type']=event_charges_type::where('status',1)->get();
        $data['add_on']=event_menu_add_on::where('status',1)->get();
        $data['menu_category']=event_rate_category::where('status',1)->get();


         $memberfmid=$data['eventbooking']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

        return view('backend/events-management.event-booking.event-checkout-aeu', $data);
    }


     public function invoice(event_booking $event_booking,$id)
    {
         $data['invoicestatus']                = 1;

         $data['eventbooking']=event_booking::where('id',$id)->first();

        $data['profiledata']=admin_company_profile::get()->first();

          $data['eventsub']=event_booking::with('menus')->where('id', $id)->get();
       $data['eventsubdata']=$data['eventsub'][0]['menus'];

        $data['bookingsub']=event_booking::with('eventBookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['eventBookings'];

        $data['addonsub']=event_booking::with('eventAddOns')->where('id', $id)->get();
       $data['menuaddons']=$data['addonsub'][0]['eventAddOns'];

        $data['venue']=event_venue::where('status',1)->get();
        $data['menu']=event_menu::where('status',1)->get();

        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['charges_type']=event_charges_type::where('status',1)->get();
        $data['add_on']=event_menu_add_on::where('status',1)->get();
        $data['menu_category']=event_rate_category::where('status',1)->get();
 
           $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$data['eventbooking']->id)->get()->pluck('id');
            $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
            $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }


           $data['resultant'] = $data['eventbooking']->grand_total-$x;
            $data['amount_paid'] = $x;

        return view('backend/events-management.event-booking.invoice', $data);
    }

     public function invoice_booking(event_booking $event_booking,$id)
    {

         $data['invoicestatus']                = 0;

         $data['eventbooking']=event_booking::where('id',$id)->first();

        $data['profiledata']=admin_company_profile::get()->first();

          $data['eventsub']=event_booking::with('menus')->where('id', $id)->get();
       $data['eventsubdata']=$data['eventsub'][0]['menus'];

        $data['bookingsub']=event_booking::with('eventBookings')->where('id', $id)->get();
       $data['bookingsubdata']=$data['bookingsub'][0]['eventBookings'];

        $data['addonsub']=event_booking::with('eventAddOns')->where('id', $id)->get();
       $data['menuaddons']=$data['addonsub'][0]['eventAddOns'];

        $data['venue']=event_venue::where('status',1)->get();
        $data['menu']=event_menu::where('status',1)->get();

        $data['payment_methods']=finance_payment_methods::where('status',1)->get();
        $data['charges_type']=event_charges_type::where('status',1)->get();
        $data['add_on']=event_menu_add_on::where('status',1)->get();
        $data['menu_category']=event_rate_category::where('status',1)->get();


         $s=transactions::where('debit_or_credit',1)->where('trans_type',2)->where('trans_type_id',$data['eventbooking']->id)->get()->pluck('id');
            $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
            $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                    $x = $v['trans_amount']+$x;
             }
            }


           $data['resultant'] = $data['eventbooking']->grand_total-$x;
            $data['amount_paid'] = $x;

        return view('backend/events-management.event-booking.invoice', $data);
    }

public function fetchVenue(Request $request){
        //echo str_replace('/','-',str_replace(['AM','PM'],'',$request->get('time')));
        $time=date('Y-m-d H:i:s',strtotime(str_replace('/','-',str_replace(['AM','PM'],'',$request->get('time')))));
      $x=  event_venue::whereRaw("id NOT IN(select DISTINCT venue from event_bookings where TIMESTAMP('$time') BETWEEN TIMESTAMP(concat(event_date,' ',`from`)) AND TIMESTAMP(concat(event_date,' ',`to`))) and status=1 and deleted_at is null")
;
//     echo $x->toSql();
//      dd(123);
    $x=  $x->get();

      $html='';
      foreach($x as $y){
          $html.="<option value='$y->id'>$y->desc</option>";
      }
      return $html;
    }
}

