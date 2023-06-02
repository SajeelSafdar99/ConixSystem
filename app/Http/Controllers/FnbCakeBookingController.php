<?php

namespace App\Http\Controllers;

use App\fnb_cake_booking;
use Illuminate\Http\Request;
use App\fnb_cake_type;
use App\media;
// use File;

use App\customer;
use App\User;
use Carbon\Carbon;
use App\fnb_sale;
use App\fnb_shifts;
use App\mem_family;
use App\finance_cash_receipt;
use App\transactions;
use Session;
use DataTables;
use App\membership;
use App\fnb_item_definition;
use App\fnb_restaurant_location;
use App\fnb_currency;
use App\fnb_item_sub_category;
use App\fnb_item_category;
use App\fnb_item_manufacturer;
use App\fnb_measurement_unit;
use App\fnb_product_classification;
use App\fnb_waitor_definition;
use App\fnb_table_definition;
use App\fnb_predefined_value;
use App\mem_status;
use App\finance_account_head;
use App\finance_account_type;
use App\finance_payment_methods;
use App\fnb_sales_subs;
use App\admin_company_profile;
use App\fnb_cancelled_item_remark;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\trans_relations;
use App\trans_type;


use App\finance_payment_receivable;
use App\room_payment_receipt;

class FnbCakeBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function cakebooking_dt(Request $request, fnb_cake_booking $fnb_cake_booking)
    {
         return view('backend/food-and-beverage/cake-booking/cake-booking-vue');
    }

       public function cakebooking_init_dt(Request $request)
    {
  $data['sales'] =\Illuminate\Support\Facades\DB::select(
     'select fnb_cake_bookings.*, memberships.mem_no as mem_no,
      st.desc as activity,
        stt.desc as coactivity,
      customer_name as customer,
      customers.guest_type                                  as cgt,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  users.name as cashiername,
       media.url as image,


          corporate_memberships.title as ctname,
  corporate_memberships.applicant_name as clname,
  corporate_memberships.first_name as cfname,
  corporate_memberships.middle_name as cmname,
  corporate_memberships.mem_no as co_mem_no,

  memberships.mem_no as mem_no,
if(fnb_cake_bookings.customer_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC
from fnb_cake_bookings

left outer join users on users.id =fnb_cake_bookings.created_by and users.status=1
left outer join hr_employments on hr_employments.id=fnb_cake_bookings.customer_id
left outer join memberships on memberships.id = fnb_cake_bookings.customer_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id = fnb_cake_bookings.customer_id and corporate_memberships.deleted_at is null
 
left outer join mem_statuses st on st.id=memberships.active and st.status=1
left outer join mem_statuses stt on stt.id=corporate_memberships.active and stt.status=1

left outer join customers on customers.id =fnb_cake_bookings.customer_id and customers.deleted_at is null
left outer join media on media.trans_type=6 and media.trans_type_id=fnb_cake_bookings.id and media.deleted_at is null

where fnb_cake_bookings.deleted_at is null and fnb_cake_bookings.status=0 group by fnb_cake_bookings.id order by fnb_cake_bookings.id desc'
     /* 'select fnb_cake_bookings.*, memberships.mem_no as mem_no,
      customer_name as customer,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  users.name as cashiername,

  memberships.mem_no as mem_no,
  sum(distinct transactions.trans_amount ) as paid_amount , GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,
if(fnb_cake_bookings.customer_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC
from fnb_cake_bookings
left outer join transactions as t1 on t1.trans_type=6 and t1.trans_type_id=fnb_cake_bookings.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=6 and transactions.trans_type_id=fnb_cake_bookings.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join users on users.id =fnb_cake_bookings.created_by and users.status=1
left outer join hr_employments on hr_employments.id=fnb_cake_bookings.customer_id
left outer join memberships on memberships.id = fnb_cake_bookings.customer_id and memberships.deleted_at is null
left outer join customers on customers.id =fnb_cake_bookings.customer_id and customers.deleted_at is null
where fnb_cake_bookings.deleted_at is null and fnb_cake_bookings.status=0 group by fnb_cake_bookings.id order by fnb_cake_bookings.id desc'*/);

  $data['users']= User::where('status',1)->get();
     return $data;
}

// CANCELLED CAKE BOOKINGS
public function cancelled_cakebooking_dt(Request $request, fnb_cake_booking $fnb_cake_booking)
    {
         return view('backend/food-and-beverage/cake-booking/cancelled-cake-booking-vue');
    }


       public function cancelled_cakebooking_init_dt(Request $request)
    {
  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_cake_bookings.*, memberships.mem_no as mem_no,
      st.desc as activity,
      stt.desc as coactivity,
      customer_name as customer,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,


    corporate_memberships.title as ctname,
  corporate_memberships.applicant_name as clname,
  corporate_memberships.first_name as cfname,
  corporate_memberships.middle_name as cmname,
  corporate_memberships.mem_no as co_mem_no,


  users.name as cashiername,

  memberships.mem_no as mem_no,

if(fnb_cake_bookings.customer_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC
from fnb_cake_bookings

left outer join users on users.id =fnb_cake_bookings.created_by and users.status=1
left outer join hr_employments on hr_employments.id=fnb_cake_bookings.customer_id
left outer join memberships on memberships.id = fnb_cake_bookings.customer_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id = fnb_cake_bookings.customer_id and corporate_memberships.deleted_at is null

left outer join mem_statuses st on st.id=memberships.active and st.status=1
left outer join mem_statuses stt on stt.id=corporate_memberships.active and stt.status=1

left outer join customers on customers.id =fnb_cake_bookings.customer_id and customers.deleted_at is null
where fnb_cake_bookings.deleted_at is null and fnb_cake_bookings.status=2 group by fnb_cake_bookings.id order by fnb_cake_bookings.id desc'
    /*  'select fnb_cake_bookings.*, memberships.mem_no as mem_no,
      customer_name as customer,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  users.name as cashiername,

  memberships.mem_no as mem_no,
  sum(distinct transactions.trans_amount ) as paid_amount , GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,
if(fnb_cake_bookings.customer_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC
from fnb_cake_bookings
left outer join transactions as t1 on t1.trans_type=6 and t1.trans_type_id=fnb_cake_bookings.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=6 and transactions.trans_type_id=fnb_cake_bookings.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join users on users.id =fnb_cake_bookings.created_by and users.status=1
left outer join hr_employments on hr_employments.id=fnb_cake_bookings.customer_id
left outer join memberships on memberships.id = fnb_cake_bookings.customer_id and memberships.deleted_at is null
left outer join customers on customers.id =fnb_cake_bookings.customer_id and customers.deleted_at is null
where fnb_cake_bookings.deleted_at is null and fnb_cake_bookings.status=2 group by fnb_cake_bookings.id order by fnb_cake_bookings.id desc'*/);

  $data['users']= User::where('status',1)->get();
     return $data;

}
// CANCELLED CAKE BOOKINGS

     public function cakebooking()
    {
     return view('backend/food-and-beverage.cake-booking.cake-booking-aeu-vue');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cakebooking_init(Request $request)
    {
    
        if($request->get('r')){
            $lastval=fnb_cake_booking::find($request->get('r'));
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }

if($lastval->type==0){
 $familyid=$lastval->customer_id;
 $lastval['families']=mem_family::where('member_id',$familyid)->with('relationship_name')->get();
}
 /*$ikd=$lastval->customer_id;
    $lastval['documents']=media::where('type_id',$ikd)->where(function($query){
          $query->orWhere('type',100)->orWhere('type',101)->orWhere('type',103);
    })->get();
*/
  $lastval['documents']=media::where('trans_type_id',$request->get('r'))->where('trans_type',6)->get();

      $lastval['cake_types']=fnb_item_definition::where('status',1)->where('salable',1)->get();
      $lastval['acctypes']= trans_type::where('cash_or_payment',2)->where('type',7)->get();
       $lastval['accpermit']=Auth::user()->getAllPermissions()->where('category',23)->pluck('name');
       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $lastval=fnb_cake_booking::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['cake_types']=fnb_item_definition::where('status',1)->where('salable',1)->get();
/* $data['cake_types']=fnb_cake_type::where('status',1)->get();*/
 $data['acctypes']= trans_type::where('cash_or_payment',2)->where('type',7)->get();
  $data['accpermit']=Auth::user()->getAllPermissions()->where('category',23)->pluck('name');
     return $data;
 }


}

      public function cakebooking_save(Request $request){
//        dd($request->all());

         $size['width'] = 300;
         $size['height'] = 200;
         $files=[];

        $lastval=fnb_cake_booking::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }

if($request->get('hiddenforguest')==1){

  $this->validate($request, [
            'name' => 'unique:customers,customer_name',
            'contact' => 'unique:customers,customer_contact'
        ]);

    $Customer =  customer::create([
            'customer_no' =>  $request->get('customer_id'),
            'customer_name' => $request->get('customer'),
            'customer_contact' => $request->get('contact'),
        ]);
}

if(fnb_cake_booking::where('booking_no',$data['increment_number'])->count() == 0){



        $d=[];

        $d['booking_no']= $data['increment_number'];
        $d['booking_date']=formatDate($request->get('booking_date'));
      
        $d['order_taker']=$request->get('order_taker');
         $d['cake_type']=$request->get('cake_type');
          $d['flavor']=$request->get('flavor');
           $d['topping']=$request->get('topping');
            $d['filling']=$request->get('filling');
             $d['icing']=$request->get('icing');
              $d['color']=$request->get('color');
               $d['weight']=$request->get('weight');

                $d['instructions']=$request->get('instructions');
              $d['attachment']=$request->get('attachment');
               $d['special_display']=$request->get('special_display');
                $d['delivery_date']=formatDate($request->get('delivery_date'));
              $d['pickup_time']=$request->get('pickup_time');
               $d['receiver']=$request->get('receiver');
                $d['delivery_address']=$request->get('delivery_address');
              $d['note']=$request->get('note');
               $d['total_amount']=$request->get('total_amount');

        $d['discount']=$request->get('discount');
        $d['tax']=$request->get('tax');
         $d['grand_total']=$request->get('grand_total');
           $d['advance_paid']=$request->get('advance_paid');
        $d['balance_amount']=$request->get('balance_amount');
      $d['customer_id']=$request->get('customer_id');
        $d['name']=$request->get('customer');
        $d['type']=$request->get('type');
        $d['ledger_amount']=$request->get('ledger_amount');
        $d['family']=$request->get('family');
        $d['status']=0;
         $d['payment_method']=$request->get('payment_method');

      $id=  fnb_cake_booking::create($d);

  

if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
            if($request->type==1){ //for Guest/Customer
              $createimg=sendCakeBookingDocs($file,$size,['type'=>1,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =101
            }
            else if($request->type==0){// for Member
              $createimg=sendCakeBookingDocs($file,$size,['type'=>0,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =100
            }
            else if($request->type==6){// for Cor Member
              $createimg=sendCakeBookingDocs($file,$size,['type'=>6,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =100
            }
             else if($request->type==3){// for Employee
               $createimg=sendCakeBookingDocs($file,$size,['type'=>3,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =103
            }

          }
   }

 
}

/*
if($request->get('document')) {

           $files = $request->get('document');
           foreach($files as $file){
             // dd($file);

            if($request->type==1){ //for Guest/Customer
              $createimg=sendCakeBookingDocs($file,$size,['type'=>1,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =101
            }
            else if($request->type==0){// for Member
              $createimg=sendCakeBookingDocs($file,$size,['type'=>0,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =100
            }
             else if($request->type==3){// for Employee
               $createimg=sendCakeBookingDocs($file,$size,['type'=>3,'trans_type'=>6,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]); // type =103
            }

          }


   }*/




/*
//sending into transactions table
if(transactions::where('debit_or_credit',1)->where('trans_type',6)->where('trans_type_id',$id->id)->where('trans_amount',$request->get('grand_total'))->count() == 0)
{
    if($request->get('type')==0){
       $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('member_id');
        $t['trans_moc_type']=0;
        $t['is_active']=1;
        $t['date']=formatDate($request->get('booking_date'));
}
else if($request->get('type')==1){
 $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=1;
          $t['is_active']=1;
          $t['date']=formatDate($request->get('booking_date'));
}
else if($request->get('type')==3){
 $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=3;
          $t['is_active']=1;
          $t['date']=formatDate($request->get('booking_date'));
}
      $tid=  transactions::create($t);
}
//sending into transactions table
*/

return $id->id;
       
    }




    public function updated(Request $request){


    $size['width'] = 300;
    $size['height'] = 200;
        $lastval=fnb_cake_booking::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }


if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
            if($request->type==1){ //for Guest/Customer
              $createimg=sendCakeBookingDocs($file,$size,['type'=>1,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]); // type =101
            }
            else if($request->type==0){// for Member
              $createimg=sendCakeBookingDocs($file,$size,['type'=>0,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]); // type =100
            }
            else if($request->type==6){// for Cor Member
              $createimg=sendCakeBookingDocs($file,$size,['type'=>6,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]); // type =100
            }
             else if($request->type==3){// for Employee
               $createimg=sendCakeBookingDocs($file,$size,['type'=>3,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]); // type =103
            }

          }
   }

   

/*if($request->hasFile('document')) {

           $files = $request->file('document');
 
      $s=fnb_cake_booking::find($request->get('id'))->CakeBookingDocs;
           foreach($s as $m){
               $m->delete();
           }
 


          foreach($files as $file){
             // dd($file);
            if($request->type==1){
              $updateimg=sendCakeBookingDocs($file,$size,['type'=>1,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->type==0){
              $updateimg=sendCakeBookingDocs($file,$size,['type'=>0,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->type==3){ 
              $updateimg=sendCakeBookingDocs($file,$size,['type'=>3,'trans_type'=>6,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]);
            }

          }


       }*/
      

        $d=[];

    
      
        $d['order_taker']=$request->get('order_taker');
         $d['cake_type']=$request->get('cake_type');
          $d['flavor']=$request->get('flavor');
           $d['topping']=$request->get('topping');
            $d['filling']=$request->get('filling');
             $d['icing']=$request->get('icing');
              $d['color']=$request->get('color');
               $d['weight']=$request->get('weight');

                $d['instructions']=$request->get('instructions');
              $d['attachment']=$request->get('attachment');
               $d['special_display']=$request->get('special_display');
                $d['delivery_date']=formatDate($request->get('delivery_date'));
              $d['pickup_time']=$request->get('pickup_time');
               $d['receiver']=$request->get('receiver');
                $d['delivery_address']=$request->get('delivery_address');
              $d['note']=$request->get('note');
               $d['total_amount']=$request->get('total_amount');

        $d['discount']=$request->get('discount');

        $d['tax']=$request->get('tax');
         $d['grand_total']=$request->get('grand_total');
          $d['advance_paid']=$request->get('advance_paid');
        $d['balance_amount']=$request->get('balance_amount');
  $d['payment_method']=$request->get('payment_method');

      $id=  fnb_cake_booking::where('id',$request->get('id'))->updateWithUserstamps($d);

 /*//sending into transactions table
if($request->get('type')==0){
       $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$request->get('id');
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=0;
         $t['is_active']=1;
         $t['date']=formatDate($request->get('booking_date'));
}
else if($request->get('type')==1){
 $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$request->get('id');
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=1;
         $t['is_active']=1;
         $t['date']=formatDate($request->get('booking_date'));
}
else if($request->get('type')==3){
 $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$request->get('id');
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=3;
         $t['is_active']=1;
         $t['date']=formatDate($request->get('booking_date'));
}

    $tid= transactions::where('debit_or_credit',1)->where('trans_type',6)->where('trans_type_id',$request->get('id'))->updateWithUserstamps($t);
//sending into transactions table*/



    }




     public function cakebooking_cancel(Request $request,$id){

        $lastval=fnb_cake_booking::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }


        $d=[];

    
      $d['reason']=$request->get('reason');
        $d['status']=2;
        
      $id=  fnb_cake_booking::where('id',$id)->updateWithUserstamps($d);
return redirect('food-and-beverage/cake-booking-vue');


    }

 public function cakebooking_reconfirm(Request $request,$id){

        $lastval=fnb_cake_booking::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }


        $d=[];

    
      
        $d['status']=0;
        
      $id=  fnb_cake_booking::where('id',$id)->updateWithUserstamps($d);
return redirect('food-and-beverage/cancelled-cake-booking-vue');


    }




 public function index_deleted(Request $request, fnb_cake_booking $fnb_cake_booking)
    {
        return view('backend/food-and-beverage/cake-booking/cake-booking-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_cake_booking $fnb_cake_booking)
    {
        $table = fnb_cake_booking::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/cake-booking/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

              ->addColumn('deleted_at', function ($table) {
              return formatDateToShow($table->deleted_at);
                })

               ->addColumn('booking_date', function ($table) {
              return formatDateToShow($table->booking_date);
                })

              ->addColumn('type', function ($table) {
                if($table->type==0){
                    return "Member";
                }
                else if($table->type==1){
                    return "Guest";
                }
                else if($table->type==3){
                    return "Employee";
                }
                  else if($table->type==6){
                    return "Corporate Member";
                }
                })

 
    ->rawColumns(['restorebutton', 'type', 'date'])
        ->addIndexColumn()
        ->make(true);
    }


   

    public function index()
    {
        //
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
     * @param  \App\fnb_cake_booking  $fnb_cake_booking
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_cake_booking $fnb_cake_booking)
    {
        //
    }


 public function invoice(fnb_cake_booking $fnb_cake_booking,$id,Request $request){
     $data['receiptstatus']=0;
         $data['receiptdata']=fnb_cake_booking::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();
           $rid=$data['receiptdata']->payment_received_for;
/*         $data['finance_payment_receivable']=finance_payment_receivable::where('id',$rid)->first(); 
*/
         $rid=$data['receiptdata']->payment_method;
         $data['finance_payment_methods']=finance_payment_methods::where('id',$rid)->first(); 

        return view('backend/food-and-beverage.cake-booking.cake-booking-invoice', $data);
 }
    




 public function invoicep(fnb_cake_booking $fnb_cake_booking,$id,Request $request)
    {
        $data['saledata']=fnb_cake_booking::where('id',$id)->first();

        $data['taxandservice']=fnb_predefined_value::get()->first();
        $data['mains']=fnb_item_category::where('status',1)->get();
        $data['subcats']=fnb_item_sub_category::where('status',1)->get();
        $data['itemdefs']=fnb_item_definition::where('status',1)->where('salable',1)->get();
        $data['waiters']=fnb_waitor_definition::where('status',1)->get();
        $data['tables']=fnb_table_definition::where('status',1)->get();
        $data['restaurants']=fnb_restaurant_location::where('status',1)->get();
        $data['currencies']=fnb_predefined_value::first();
        $data['discountables']=fnb_item_definition::where('status',1)->where('salable',1)->get()->first();
        $data['accheads']=finance_account_head::where('status',1)->get();
/*        $data['acctypes']=finance_account_type::where('status',1)->get();*/
 $data['acctypes']= trans_type::where('cash_or_payment',2)->where('type',7)->get();

        $data['salesub']=fnb_sale::with(['salesubs'=>function($query){
           $query->selectRaw('sales_id,sum(qty) as qty,sum(sub_total_price) as sub_total_price,sale_price,item_details')->where('status',NULL)->groupBy('item_code');
        }])->where('id', $id)->get();
       // dd($data['salesub'][0]->toArray());
        $data['salesubdata']=$data['salesub'][0]['salesubs'];
 $data['defaultprinter']=fnb_predefined_value::get()->first()->pluck('printer');
  $data['defaultprintqty']=fnb_predefined_value::get()->first()->pluck('print_limit');

        $data['profiledata']=admin_company_profile::get()->first();

        return view('backend/food-and-beverage.cake-booking.cake-booking-invoice', $data);
    }


 public function temp_upload(Request $request){
//dd($request->file('file'));

      $file=$request->file('file');

       //return $file;

    $ext = $file->getClientOriginalName();

     if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'tempcakebookingdocs';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;

            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            
            return $finalPath;
        } else {
            return '';
        }

    }


    public function temp_remove(Request $request){
dd($request->get('document'));

      $file=$request->file('file');

     
     File::delete(public_path($file));
          

    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_cake_booking  $fnb_cake_booking
     * @return \Illuminate\Http\Response
     */
   public function cakebooking_edit(fnb_cake_booking $fnb_cake_booking,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/food-and-beverage.cake-booking.cake-booking-aeu-vue', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_cake_booking  $fnb_cake_booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fnb_cake_booking $fnb_cake_booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_cake_booking  $fnb_cake_booking
     * @return \Illuminate\Http\Response
     */

    public function received(Request $request){


        //        dd($request->all());
        $lastval=fnb_cake_booking::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }


if(fnb_cake_booking::where('booking_no',$data['increment_number'])->count() == 0){


if($request->get('document')) {

           $files = $request->get('document');
           foreach($files as $file){
             // dd($file);

            if($request->type==1){ //for Guest/Customer
              $createimg=sendCakeBookingDocs($file,$size,['type'=>101,'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->type==1){// for Member
              $createimg=sendCakeBookingDocs($file,$size,['type'=>100,'moc_id'=>$request->post('customer_id')]);
            }
             else if($request->type==3){// for Employee
              $createimg=sendCakeBookingDocs($file,$size,['type'=>103,'moc_id'=>$request->post('customer_id')]);
            }

          }
       }

        $d=[];

        $d['booking_no']= $data['increment_number'];
        $d['booking_date']=formatDate($request->get('booking_date'));
      
        $d['order_taker']=$request->get('order_taker');
         $d['cake_type']=$request->get('cake_type');
          $d['flavor']=$request->get('flavor');
           $d['topping']=$request->get('topping');
            $d['filling']=$request->get('filling');
             $d['icing']=$request->get('icing');
              $d['color']=$request->get('color');
               $d['weight']=$request->get('weight');

                $d['instructions']=$request->get('instructions');
              $d['attachment']=$request->get('attachment');
               $d['special_display']=$request->get('special_display');
                $d['delivery_date']=formatDate($request->get('delivery_date'));
              $d['pickup_time']=$request->get('pickup_time');
               $d['receiver']=$request->get('receiver');
                $d['delivery_address']=$request->get('delivery_address');
              $d['note']=$request->get('note');
               $d['total_amount']=$request->get('total_amount');

        $d['discount']=$request->get('discount');

        $d['tax']=$request->get('tax');
         $d['grand_total']=$request->get('grand_total');
      $d['customer_id']=$request->get('customer_id');
        $d['name']=$request->get('customer');
        $d['type']=$request->get('type');

        $d['ledger_amount']=$request->get('ledger_amount');

        $d['family']=$request->get('family');
       

      $id=  fnb_cake_booking::create($d);
}
 

//sending into transactions table
if(transactions::where('debit_or_credit',1)->where('trans_type',6)->where('trans_type_id',$id->id)->where('trans_amount',$request->get('grand_total'))->count() == 0)
{
    if($request->get('type')==0){
       $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
         $t['trans_moc_category']=memcategoryname($request->customer_id);
        $t['trans_moc_type']=0;
        $t['is_active']=1;
        $t['date']=formatDate($request->get('booking_date'));
}
else if($request->get('type')==1){
 $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=1;
          $t['is_active']=1;
          $t['date']=formatDate($request->get('booking_date'));
}
else if($request->get('type')==3){
 $t=[];

        $t['debit_or_credit']= 1;
        $t['trans_type']=6;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$request->get('customer_id');
        $t['trans_moc_type']=3;
          $t['is_active']=1;
          $t['date']=formatDate($request->get('booking_date'));
}
      $tid=  transactions::create($t);
}
//sending into transactions table




$lastcashreceipt=finance_cash_receipt::withTrashed()->latest('id')->first();
      $numtwo=0;
      if($lastcashreceipt){
        $numtwo=$lastcashreceipt->id+1;
        $cashrec['increment_number']=$numtwo;

      }else{
        $numtwo=1;
        $cashrec['increment_number']=$numtwo;
      }


if(transactions::where('debit_or_credit',0)->where('trans_type',6)->where('trans_type_id',$id->id)->where('trans_amount',$request->get('amount_received')+$request->get('return_value'))->count() == 0)
 {
//sending into cash receipts table
      if($request->get('amount_received')>0){
if($request->get('type')==0){
       $r=[];

        $r['invoice_no']= $cashrec['increment_number'];
        $r['invoice_date']= formatDate($request->get('booking_date'));
        $r['receipt_type']=0;
        $r['family']=$request->get('family');
        $r['mem_number']=$request->get('customer_id');
        $r['total_amount']=$request->get('cash_receipt_amt');
        $r['total']=$request->get('cash_receipt_amt');
        $r['account']=$request->get('sAccType');
        $r['remarks']=$request->get('remarks');
        $r['amount_in_words']=$request->get('amount_in_words');


}
else if($request->get('type')==1){
 $r=[];

        $r['invoice_no']= $cashrec['increment_number'];
        $r['invoice_date']= formatDate($request->get('booking_date'));
        $r['receipt_type']=1;
        $r['family']=$request->get('family');
        $r['customer_id']=$request->get('customer_id');
        $r['total_amount']=$request->get('cash_receipt_amt');
        $r['total']=$request->get('cash_receipt_amt');
        $r['account']=$request->get('sAccType');
        $r['remarks']=$request->get('remarks');
        $r['amount_in_words']=$request->get('amount_in_words');
}
else if($request->get('type')==3){
 $r=[];

       $r['invoice_no']= $cashrec['increment_number'];
        $r['invoice_date']=formatDate($request->get('booking_date'));
        $r['receipt_type']=3;
        $r['family']=$request->get('family');
        $r['employee_id']=$request->get('customer_id');
        $r['total_amount']=$request->get('cash_receipt_amt');
        $r['total']=$request->get('cash_receipt_amt');
        $r['account']=$request->get('sAccType');
        $r['remarks']=$request->get('remarks');
        $r['amount_in_words']=$request->get('amount_in_words');
}
      $rid=  finance_cash_receipt::create($r);
    }
//sending into cash receipts table



//sending into transactions table
 if((int)($request->get('amount_received'))>0){
if($request->get('type')==0){
       $trans=[];

        $trans['debit_or_credit']= 0;
        $trans['trans_type']=6;
        $trans['trans_type_id']=$id->id;
        $trans['trans_amount']=$request->get('cash_receipt_amt');
        $trans['trans_moc']=$request->get('customer_id');
         $trans['trans_moc_category']=memcategoryname($request->customer_id);
        $trans['trans_moc_type']=0;
        $trans['is_active']=1;
        $trans['receipt_id']=$rid->id;
        $trans['date']=formatDate($request->get('booking_date'));
        $trans['payment_method']=$request->get('sAccType');


         $acc=  transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>90,
               'trans_type_id'=> $request->get('sAccType'),
               'trans_amount'=>$request->get('cash_receipt_amt'),
               'trans_moc'=> $request->get('customer_id'),
                'trans_moc_category'=> memcategoryname($request->get('customer_id')),
               'trans_moc_type'=>0,
               'receipt_id'=>$rid->id,
               'date'=>formatDate($request->get('booking_date')),
               'is_active'=>1

            ]);
}
else if($request->get('type')==1){
 $trans=[];

        $trans['debit_or_credit']= 0;
        $trans['trans_type']=6;
        $trans['trans_type_id']=$id->id;
        $trans['trans_amount']=$request->get('cash_receipt_amt');
        $trans['trans_moc']=$request->get('customer_id');
        $trans['trans_moc_type']=1;
          $trans['is_active']=1;
          $trans['receipt_id']=$rid->id;
          $trans['date']=formatDate($request->get('booking_date'));
          $trans['payment_method']=$request->get('sAccType');

            $acc=  transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>90,
               'trans_type_id'=> $request->get('sAccType'),
               'trans_amount'=>$request->get('cash_receipt_amt'),
               'trans_moc'=> $request->get('customer_id'),
               'trans_moc_type'=>1,
               'receipt_id'=>$rid->id,
               'date'=>formatDate($request->get('booking_date')),
               'is_active'=>1

            ]);
} 
else if($request->get('type')==3){
 $trans=[];

        $trans['debit_or_credit']= 0;
        $trans['trans_type']=6;
        $trans['trans_type_id']=$id->id;
        $trans['trans_amount']=$request->get('cash_receipt_amt');
        $trans['trans_moc']=$request->get('customer_id');
        $trans['trans_moc_type']=3;
          $trans['is_active']=1;
          $trans['receipt_id']=$rid->id;
          $trans['date']=formatDate($request->get('booking_date'));
          $trans['payment_method']=$request->get('sAccType');

            $acc=  transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>90,
               'trans_type_id'=> $request->get('sAccType'),
               'trans_amount'=>$request->get('cash_receipt_amt'),
               'trans_moc'=> $request->get('customer_id'),
               'trans_moc_type'=>3,
               'receipt_id'=>$rid->id,
               'date'=>formatDate($request->get('booking_date')),
               'is_active'=>1

            ]);
}
      $tidd=  transactions::create($trans);
    }

//sending into transactions table


//sending into trans relations
     if((int)($request->get('amount_received'))>0){



    $inv=transactions::where('debit_or_credit',1)->where('trans_type',6)->where('trans_type_id',$id->id)->get()->pluck('id');
if($inv){
   if((int)($request->get('amount_received'))>0){

             trans_relations::create([
               'receipt'=>$tidd->id,
                'invoice'=> $inv[0],
                'account' =>  $acc->id
            ]);
    }
}
  /* else{
     if($request->get('amount_received')>0){
            trans_relations::create([
                'receipt'=>$tid->id,
                'invoice'=> 0,
            ]);
    }
   }*/
}
//sending into trans relations
}


    }
   

   public function docs(fnb_cake_booking $fnb_cake_booking,$id)
    { 
        $data['receiptdata']=fnb_cake_booking::where('id',$id)->first();
       
        return view('backend/food-and-beverage.cake-booking.cake-booking-documents', $data);
    }


  public function destroy(Request $request,fnb_cake_booking $fnb_cake_booking,$id)
    {
     $update= fnb_cake_booking::where('id',$id)->updateWithUserstamps([
        'note' => $request->remarks,
     ]);
     $delete=$fnb_cake_booking::where('id',$id)->deleteWithUserstamps();
    }

/*    public function destroy(fnb_cake_booking $fnb_cake_booking,$id)
    {

        $destroy=$fnb_cake_booking::where('id', $id)->deleteWithUserstamps();
        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('food-and-beverage/cake-booking-vue');
    }*/

public function restore(fnb_cake_booking $fnb_cake_booking,$id)
    {
        $restore = fnb_cake_booking::onlyTrashed()->find($id)->restore();
       /* $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',6)->where('debit_or_credit',1)->restore();*/

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/cake-booking/deleted');

}


}
