<?php

namespace App\Http\Controllers;
use App\media;
use App\coa_transactions;
use Illuminate\Http\Request;
use App\store_purchases;
use App\store_purchases_subs;
use App\store_issue_notes;
use App\store_issue_notes_subs;
use App\store_sales;
use App\store_sales_subs;
use App\store_location;
use DB;
use Carbon\Carbon;
use App\transactions;
use Session;
use DataTables;
use App\fnb_item_definition;
use App\fnb_item_sub_category;
use App\fnb_item_category;
use App\finance_account_head;
use App\finance_account_type;
use App\admin_company_profile;
use App\fnb_restaurant_location;
use App\store_department;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\trans_relations;
use App\store_transactions;
use App\fnb_predefined_value;
use App\User;
use App\store_cancellation_remark;
use App\fnb_measurement_unit;
use App\coa_account;
use App\guest_type;
use App\finance_ledger_person;
use App\customer;
use App\hr_employment;
use App\membership;
use App\SalesTermsandConditions;

class StoreManagementController extends Controller
{ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // STORE ISSUE NOTE
      public function issue_note_index_vue(Request $request, store_issue_notes $store_issue_notes)
    {
      return view('backend/store-management/store-issue-note/store-issue-note-vue');
    } 

    public function issue_note_init_vue(Request $request)
    {
$data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select store_issue_notes.*,
      store_issue_notes.department as dep,

        users.name as cashiername,
        fnb_item_categories.desc as location,
        store_departments.desc as department,
          coas.code as unitcode,
     coas.name as unit,
     coaz.name as company

from store_issue_notes


  left outer join coa_accounts coas on coas.code =store_issue_notes.unit
  left outer join coa_accounts coaz on coaz.code=coas.desc
left outer join users on users.id =store_issue_notes.created_by and users.status=1
left outer join fnb_item_categories on fnb_item_categories.id = store_issue_notes.store_location 
left outer join store_departments on store_departments.id = store_issue_notes.department and store_departments.status=1 and store_departments.deleted_at is null

where store_issue_notes.deleted_at is null group by store_issue_notes.id order by store_issue_notes.id desc');

  $data['ccs']=coa_account::get();
    $data['locations']= fnb_item_category::where('status',1)->get();
   // $data['locations']=fnb_restaurant_location::where('status',1)->where('restaurant',1)->orWhere('store',1)->get();
   $data['departments']=store_department::where('status',1)->get();
      $data['locspermit']=Auth::user()->getAllPermissions()->where('category',25)->pluck('name');
     return $data;
}
public function issue_note_create(Request $request)
    {
        return view('backend/store-management.store-issue-note.store-issue-note-aeu');
    }

         public function issue_note_init(Request $request){
         $lastval=[];
          $lastid=[];

           if($request->get('r')){
            $lastid=store_issue_notes::find($request->get('r'));
            $num=0;
      if($lastid){
        $num=$lastid->id;
        $lastid['increment_number']=$num;

      }else{
        $num=0;
        $lastid['increment_number']=$num;
      }
  }

        if($request->get('r')){
            $lastval=store_issue_notes::find($request->get('r'));
        }
        else{
            $lastval = store_issue_notes::withTrashed()->latest('id')->first();

        }

//        echo 123;
        if(Auth::user()->can('Add Item Category')){
        $lastval['add_cat']=Permission::where('name','Add Item Category')->get();
}
if(Auth::user()->can('Add Item Sub-Category')){
        $lastval['add_sub']=Permission::where('name','Add Item Sub-Category')->get();
}
if(Auth::user()->can('Add Item Definition')){
        $lastval['add_item']=Permission::where('name','Add Item Definition')->get();
}
if(Auth::user()->can('Cancel Store Issue Note')){
$lastval['cancel_permit']=Permission::where('name','Cancel Store Issue Note')->get();
            }
                $lastval['measurement_units']=fnb_measurement_unit::where('status',1)->get();   
  $lastval['cancelled_remarks']=store_cancellation_remark::where('status',1)->get();
        $lastval['mains']=fnb_item_category::where('status',1)->orderBy('desc')->get();
        $lastval['subcats']=fnb_item_sub_category::where('status',1)->get();
         $lastval['predefined']=fnb_predefined_value::get()->first();

          $lastval['itemdefs'] =DB::table('fnb_item_definitions')
              ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->selectRaw('fnb_item_definitions.*, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock')
              ->where('fnb_item_definitions.status',1)->where('store_transactions.is_active',1)->groupBy('fnb_item_definitions.id')
              ->get();


/*  $lastval['locations']=fnb_restaurant_location::where('status',1)->where('restaurant',1)->orWhere('store',1)->get();*/
  $lastval['locations']= fnb_item_category::where('status',1)->get();

   $lastval['departments']=store_department::where('status',1)->get();
    if($request->get('r')){
           /* $lastval['selected_items'] =DB::table('store_issue_notes_subs')
            ->leftJoin('store_transactions', function ($join) {
              $join->on('store_transactions.item_code', '=', 'store_issue_notes_subs.item_code')->where('store_transactions.is_active',1);
            })
            ->selectRaw('store_issue_notes_subs.*,0 as product, 1 as hid, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock')
              ->where('store_issue_notes_subs.issue_id',$num)->groupBy('store_issue_notes_subs.id')
              ->get();
*/

$thedate =store_issue_notes::where('id',$request->get('r'))->get()->pluck('invoice_date');
$datu = $thedate[0];

$unitu =store_issue_notes::where('id',$request->get('r'))->get()->pluck('unit');
$unita = $unitu[0];

$locu =store_issue_notes::where('id',$request->get('r'))->get()->pluck('store_location');
$loca = $locu[0];
//    (if(st.in_or_out = 1,st.purchase_price,0)) as old_purchase_price
               $lastval['selected_items']  =\Illuminate\Support\Facades\DB::select(
      'select store_issue_notes_subs.*,0 as product, 1 as hid, 0 as hide, sum(case when ll.in_or_out=1 then ll.qty else -ll.qty end) as opening_stock,
        sum(case when slt.in_or_out=1 then slt.qty else -slt.qty end) as current_stock
          
from store_issue_notes_subs


 LEFT OUTER JOIN store_transactions ll ON ll.item_code = store_issue_notes_subs.item_code and ll.is_active=1 and (ll.type=3 || ll.type=4) and ll.store_location="'.$loca.'" and ll.unit="'.$unita.'"

  LEFT OUTER JOIN store_transactions slt ON slt.item_code = store_issue_notes_subs.item_code and slt.is_active=1 and slt.type!=3 and slt.type!=4 and slt.unit="'.$unita.'"

 LEFT OUTER JOIN store_transactions st ON st.item_code = store_issue_notes_subs.item_code and st.is_active=1
    and st.id =
    (SELECT st1.id from store_transactions st1 where st1.item_code = store_issue_notes_subs.item_code and st1.is_active=1
     and st1.date is not null and  DATE(st1.date) <= "'.$datu.'"
     order by st1.date desc limit 1)

where store_issue_notes_subs.issue_id="'.$num.'" group by store_issue_notes_subs.id order by store_issue_notes_subs.id asc ');
              // ->where('store_transactions.is_active',1)
 }
        $lastval['catspermit']=Auth::user()->getAllPermissions()->where('category',24)->pluck('name');
        $lastval['locspermit']=Auth::user()->getAllPermissions()->where('category',25)->pluck('name');
//        dd(trans_type::all());

          $lastval['ccs']=coa_account::get();
          $lastval['companies']=coa_account::wherenotnull('desc')->get();

        return ['invoice_no'=>$lastval];
    }

      public function issue_note_save(Request $request){
//        dd($request->all());
             $lastval=store_issue_notes::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }
 

if(store_issue_notes::where('id',$num)->count() == 0){
        $d=[];
       //  $d['unit']=$request->get('unitsearchid');
          $d['unit']=$request->get('company');
        $d['store_location']=$request->get('store_location');
        $d['department']=$request->get('department'); 
        $d['amount_in_words']=$request->get('amount_in_words');

        $d['remarks']=$request->get('remarks');
        $d['gross']=$request->get('gross');
        $d['discount']=$request->get('dis');
        $d['tax']=$request->get('taxx');
        $d['additional_charges']=$request->get('adds');
        $d['grand_total']=$request->get('grand_total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));
  $d['gross']=$request->get('gross');
        $id=  store_issue_notes::create($d);
//      dd();

}

// SAVING SUBS
      foreach($request->get('selected_items') as $inv){
        if(!isset($inv['instructions'])){
            $inv['instructions']=null;
            }
       
            $m=  store_issue_notes_subs::create([
               'issue_id'=>$id->id,
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
               'purchase_price'=>0,
           
             //  'purchase_price'=>$inv['purchase_price'],
              'sub_total_price'=>$inv['product'],
            'old_purchase_price'=>$inv['old_purchase_price'],
   
               'qty'=>$inv['qty'],
                'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
  
               'date'=>formatDate($request->get('invoice_date')),
               'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
            ]);

             $stt =  store_transactions::create([
              'type_id'=>$id->id,
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>1,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                'issue_price'=>$inv['old_purchase_price'],
               'store_location'=>$request->get('store_location'),
               'department'=>$request->get('department'),
               'type'=>3, //for issue note
               'unit'=>$request->get('company'),
            ]);

            $opp_stt =  store_transactions::create([
              'type_id'=>$id->id,
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>0,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                'issue_price'=>$inv['old_purchase_price'],
               'store_location'=>$request->get('store_location'),
               'department'=>$request->get('department'),
               'type'=>2, //for issue note
               'unit'=>$request->get('company'),
            ]);
        }
// SAVING SUBS

         return $id->id;

    }

        public function issue_note_updated(Request $request){
//        dd($request->all());
        $d=[];
       // $d['unit']=$request->get('unitsearchid');
        $d['unit']=$request->get('company');
      $d['store_location']=$request->get('store_location');
        $d['department']=$request->get('department'); 
        $d['amount_in_words']=$request->get('amount_in_words');
  $d['gross']=$request->get('gross');
        $d['remarks']=$request->get('remarks');
        $d['gross']=$request->get('gross');
        $d['discount']=$request->get('dis');
        $d['tax']=$request->get('taxx');
        $d['additional_charges']=$request->get('adds');
        $d['grand_total']=$request->get('grand_total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));

      $id=  store_issue_notes::where('id',$request->get('id'))->updateWithUserstamps($d);
//      dd();


// SAVING SUBS
    foreach($request->get('selected_items') as $inv){
      if(!isset($inv['instructions'])){
            $inv['instructions']=null;
            }


if(isset($inv['hid']) && $inv['hid']!=0){

     $m =store_issue_notes_subs::where('id',$inv['id'])->updateWithUserstamps([
               'issue_id'=>$request->get('id'),
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
                'purchase_price'=>0,
               
              /* 'purchase_price'=>$inv['purchase_price'],*/
               'sub_total_price'=>$inv['product'],
               'qty'=>$inv['qty'],
 
               'old_purchase_price'=>$inv['old_purchase_price'],

                'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
         
               'date'=>formatDate($request->get('invoice_date')),
               'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
        ]);

  $stt =store_transactions::where('type',3)->where('in_or_out',1)->where('type_id',$request->get('id'))->where('sub_id',$inv['id'])->updateWithUserstamps([
               'type_id'=>$request->get('id'),
               'sub_id'=>$inv['id'],
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>1,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                 'issue_price'=>$inv['old_purchase_price'],
              'store_location'=>$request->get('store_location'),
               'department'=>$request->get('department'),
               'type'=>3, //for issue notes
                'unit'=>$request->get('company'),
        ]);

   $opp_stt =store_transactions::where('type',3)->where('in_or_out',0)->where('type_id',$request->get('id'))->where('sub_id',$inv['id'])->updateWithUserstamps([
               'type_id'=>$request->get('id'),
               'sub_id'=>$inv['id'],
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>0,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                 'issue_price'=>$inv['old_purchase_price'],
              'store_location'=>$request->get('store_location'),
               'department'=>$request->get('department'),
               'type'=>2, //for issue notes
                'unit'=>$request->get('company'),
        ]);

        }
        else{

      $m=  store_issue_notes_subs::create([
            'issue_id'=>$request->get('id'),
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
                'purchase_price'=>0,
             
 
              /* 'purchase_price'=>$inv['purchase_price'],*/
               'sub_total_price'=>$inv['product'],
               'qty'=>$inv['qty'],
               'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
            
               'date'=>formatDate($request->get('invoice_date')),
              'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
            ]);

        $stt =  store_transactions::create([
              'type_id'=>$request->get('id'),
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>1,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                 'issue_price'=>$inv['old_purchase_price'],
           'store_location'=>$request->get('store_location'),
               'department'=>$request->get('department'),
               'type'=>3, //for issue notes
                'unit'=>$request->get('company'),
            ]);

         $opp_stt =  store_transactions::create([
              'type_id'=>$request->get('id'),
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>0,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                 'issue_price'=>$inv['old_purchase_price'],
            'store_location'=>$request->get('store_location'),
               'department'=>$request->get('department'),
               'type'=>2, //for issue notes
                'unit'=>$request->get('company'),
            ]);
}

}
// SAVING SUBS

}

  public function issue_note_edit(store_issue_notes $store_issue_notes,$id)
    {
     $data['id']=$id;
     $data['init']=0;
  return view('backend/store-management.store-issue-note.store-issue-note-aeu', $data);
    }

  public function issue_note_invoice(store_issue_notes $store_issue_notes,$id)
    {
        $data['receiptdata']=store_issue_notes::where('id',$id)->first();


        $data['salesub']=store_issue_notes::with('issuenotesubs')->where('id', $id)->get();
        $data['bookingsubdata']=$data['salesub'][0]['issuenotesubs'];
        $data['profiledata']=admin_company_profile::get()->first();

        return view('backend/store-management.store-issue-note.store-issue-note-invoice', $data);
    }

 
    public function issue_note_print(store_issue_notes $store_issue_notes,$id)
    {
        $data['receiptdata']=store_issue_notes::where('id',$id)->first();
        $data['salesub']=store_issue_notes::with('issuenotesubs')->where('id', $id)->get();

          $data['activeuser']=Auth::id();
        
        $data['bookingsubdata']=$data['salesub'][0]['issuenotesubs'];
        $data['profiledata']=admin_company_profile::get()->first();

        return view('backend/store-management.store-issue-note.store-issue-note-print', $data);
    }

  public function issue_note_index_deleted(Request $request, store_issue_notes $store_issue_notes)
    {
        return view('backend/store-management/store-issue-note/store-issue-note-deleted');
    }

    public function issue_note_indexdt_deleted(Request $request, store_issue_notes $store_issue_notes)
    {

        $table = store_issue_notes::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('store-management/store-issue-note/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

               ->addColumn('invoice_date', function ($table) {
              return formatDateToShow($table->invoice_date);
                })

               
               ->addColumn('deleted_at', function ($table) {
              return formatDateToShow($table->deleted_at);
                })


  ->addColumn('store_location', function ($table) {
    if($table->store_location){
           return salescategory($table->store_location);
    }
           else{
            return '';
           }
            })


             ->addColumn('department', function ($table) {
    if($table->department){
           return storeDepartmentName($table->department);
    }
           else{
            return '';
           }

                })

    ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }


/* public function issue_note_destroy(store_issue_notes $store_issue_notes,$id)
    {
        $destroy=$store_issue_notes::where('id', $id)->deleteWithUserstamps();

    store_transactions::where('type',3)->where('in_or_out',1)->where('type_id', $id)->deleteWithUserstamps();
    store_transactions::where('type',3)->where('in_or_out',0)->where('type_id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }
         else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
         }

 return redirect('store-management/store-issue-note-vue');
    }*/

    public function issue_note_destroy(Request $request,store_issue_notes $store_issue_notes,$id)
    {
     $update= store_issue_notes::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$store_issue_notes::where('id', $id)->deleteWithUserstamps();
    store_transactions::where('type',3)->where('in_or_out',1)->where('type_id', $id)->deleteWithUserstamps();
    store_transactions::where('type',2)->where('in_or_out',0)->where('type_id', $id)->deleteWithUserstamps();
    }

    public function issue_note_restore(store_issue_notes $store_issue_notes,$id)
    {
        $restore = store_issue_notes::onlyTrashed()->find($id)->restore();

      store_transactions::onlyTrashed()->where('type',3)->where('type_id',$id)->where('in_or_out',1)->restore();
      store_transactions::onlyTrashed()->where('type',2)->where('type_id',$id)->where('in_or_out',0)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/store-issue-note/deleted');
}

function issuenoteitems($id){
       $items= DB::table('fnb_item_definitions')
              ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->selectRaw('fnb_item_definitions.*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock')
              ->where('fnb_item_definitions.sub_category',$id)->where('fnb_item_definitions.status',1)->orderBy('fnb_item_definitions.item_details')->where('store_transactions.is_active',1)->groupBy('fnb_item_definitions.id')
              ->get();
        return $items;
    }

     public function issue_approve(Request $request,$id){
  $d=[];
      $d['approved']=1;
     store_issue_notes::where('id',$id)->updateWithUserstamps($d);

       $codes =store_issue_notes_subs::where('issue_id',$id)->get();

  foreach($codes as $cod){

  store_transactions::where('type',3)->where('in_or_out',1)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>1, //for approved or active store transactions
        ]);

  store_transactions::where('type',2)->where('in_or_out',0)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>1, //for approved or active store transactions
        ]);

        }

 return redirect('store-management/store-issue-note-vue');
    }


    public function issue_unapprove(Request $request,$id){
 $d=[];
      $d['approved']=0;
 store_issue_notes::where('id',$id)->updateWithUserstamps($d);

       $codes =store_issue_notes_subs::where('issue_id',$id)->get();


  foreach($codes as $cod){

 store_transactions::where('type',3)->where('in_or_out',1)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>0, //for unapproved or inactive store transactions
        ]);

 store_transactions::where('type',2)->where('in_or_out',0)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>0, //for unapproved or inactive store transactions
        ]);

        }

 return redirect('store-management/store-issue-note-vue');
    }


// STORE ISSUE NOTE






// STORE SALES
      public function sales_index_vue(Request $request, store_sales $store_sales)
    {
      return view('backend/store-management/store-sales/store-sales-vue');
    }

       public function sales_init_vue(Request $request)
    {
$data['sales'] =\Illuminate\Support\Facades\DB::select(
/*   'select store_sales.*, 
     coas.code as unitcode,
     coas.name as unit,
     coaz.name as company,
     coa_accounts_controls.name as account,
        users.name as cashiername
from store_sales

left outer join users on users.id =store_sales.created_by and users.status=1

  left outer join coa_accounts coas on coas.code =store_sales.unit
  left outer join coa_accounts coaz on coaz.code=coas.desc
 
 left outer join coa_accounts_controls on coa_accounts_controls.code =store_sales.account

where store_sales.deleted_at is null group by store_sales.id order by store_sales.id desc'*/
       'select store_sales.*,
        coas.code as unitcode,      customers.guest_type                                  as cgt,
        guest_types.desc as guesttype,
     coas.name as unit,
     coaz.name as company,
      memberships.mem_no as mem_no,
      mem_statuses.desc as activity,
      customer_name as customer,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
   finance_ledger_people.person_name as person_name,
      finance_ledger_people.id as person_id,
      sum(distinct transactions.trans_amount ) as paid_amount , GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,
        users.name as cashiername,
        sum(distinct store_sales_subs.discount) as discount,
        sum(distinct store_sales_subs.tax) as tax,
        sum(distinct store_sales_subs.sale_price) as sgross,
        media.url as image
from store_sales


  left outer join coa_accounts coas on coas.code =store_sales.unit
  left outer join coa_accounts coaz on coaz.code=coas.desc

left outer join users on users.id =store_sales.created_by and users.status=1
left outer join transactions as t1 on t1.trans_type=8 and t1.trans_type_id=store_sales.id and t1.debit_or_credit=1 and t1.type=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=8 and transactions.trans_type_id=store_sales.id and transactions.debit_or_credit=0 and transactions.type=2 and transactions.deleted_at is null

left outer join media on media.trans_type=8 and media.trans_type_id=store_sales.id and media.deleted_at is null

left outer join hr_employments on hr_employments.id=store_sales.customer_id
left outer join store_sales_subs on store_sales_subs.sale_id=store_sales.id
left outer join memberships on memberships.id = store_sales.customer_id and memberships.deleted_at is null
left outer join mem_statuses on mem_statuses.id=memberships.active and mem_statuses.status=1
left outer join customers on customers.id =store_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type
  left outer join finance_ledger_people on finance_ledger_people.id = store_sales.customer_id

where store_sales.deleted_at is null group by store_sales.id order by store_sales.id desc' );
 

  $data['ccs']=coa_account::get();
$data['gts']=guest_type::where('status',1)->get();
     return $data;
}
  public function sales_create(Request $request)
    {
        return view('backend/store-management.store-sales.store-sales-aeu');
    }

 public function sales_init(Request $request){
         $lastval=[];
          $lastid=[];

           if($request->get('r')){
            $lastid=store_sales::find($request->get('r'));
            $num=0;
      if($lastid){
        $num=$lastid->id;
        $lastid['increment_number']=$num;

      }else{
        $num=0;
        $lastid['increment_number']=$num;
      }
  }

        if($request->get('r')){
            $lastval=store_sales::find($request->get('r'));
        }
        else{
            $lastval = store_sales::withTrashed()->latest('id')->first();

        }

//        echo 123;

if(Auth::user()->can('Add Item Category')){
        $lastval['add_cat']=Permission::where('name','Add Item Category')->get();
}
if(Auth::user()->can('Add Item Sub-Category')){
        $lastval['add_sub']=Permission::where('name','Add Item Sub-Category')->get();
}
if(Auth::user()->can('Add Item Definition')){
        $lastval['add_item']=Permission::where('name','Add Item Definition')->get();
}
if(Auth::user()->can('Add Customer')){
        $lastval['add_guest']=Permission::where('name','Add Customer')->get();
}
if(Auth::user()->can('Cancel Store Sale')){
$lastval['cancel_permit']=Permission::where('name','Cancel Store Sale')->get();
            }
    $lastval['measurement_units']=fnb_measurement_unit::where('status',1)->get();   
  $lastval['cancelled_remarks']=store_cancellation_remark::where('status',1)->get();
        $lastval['mains']=fnb_item_category::where('status',1)->orderBy('desc')->get();
        $lastval['subcats']=fnb_item_sub_category::where('status',1)->get();
      /*  $lastval['itemdefs']=fnb_item_definition::where('status',1)->where('salable',1)->get();*/
     /*   $lastval['locations']=store_location::where('status',1)->get();*/
   /*
        if($request->get('r')){
            $lastval['selected_items'] =DB::table('store_sales_subs')

                ->join('fnb_item_definitions','store_sales_subs.item_code', '=', 'fnb_item_definitions.item_code')
                 ->selectRaw('store_sales_subs.*,0 as product, 1 as hid, fnb_item_definitions.opening_stock as opening_stock,fnb_item_definitions.purchase_price as purchase_price')
              ->where('sale_id',$num)
              ->get();
 }*/
  $lastval['gts']=guest_type::where('status',1)->get();
          $lastval['itemdefs'] =DB::table('fnb_item_definitions')
              ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->selectRaw('fnb_item_definitions.*, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.sale_price+0) as old_sale_price')
              ->where('fnb_item_definitions.status',1)->where('store_transactions.is_active',1)->where('fnb_item_definitions.salable',1)->groupBy('fnb_item_definitions.id')
              ->get();


  $lastval['locations']=fnb_restaurant_location::where('status',1)->where('restaurant',1)->orWhere('store',1)->get();
   $lastval['departments']=store_department::where('status',1)->get();

                $ikd=$lastval->customer_id;
    $lastval['documents']=media::where('type_id',$ikd)->where('trans_type',8)->where('trans_type_id',$lastval->id)->get();

       /* if($request->get('r')){
            $lastval['selected_items'] =DB::table('store_sales_subs')

              ->join('fnb_item_definitions','store_sales_subs.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->join('store_transactions','store_sales_subs.item_code', '=', 'store_transactions.item_code', 'left outer')

              ->selectRaw('store_sales_subs.*,0 as product, 1 as hid, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,fnb_item_definitions.purchase_price as purchase_price')

              ->where('store_sales_subs.sale_id',$num)->where('store_transactions.is_active',1)->groupBy('store_sales_subs.id')
              ->get();
 }*/
  if($request->get('r')){
    
   $unitu =store_sales::where('id',$request->get('r'))->get()->pluck('unit');
   $unita=$unitu[0];
            $lastval['selected_items'] =DB::table('store_sales_subs')
             ->join('fnb_item_definitions','store_sales_subs.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
            ->leftJoin('store_transactions', function ($join) use( $unita) {
              $join->on('store_transactions.item_code', '=', 'store_sales_subs.item_code')->where('store_transactions.is_active',1)->where('store_transactions.type','!=',3)->where('store_transactions.type','!=',4)->where('store_transactions.unit', $unita);
            })
            ->selectRaw('store_sales_subs.*,if(store_sales_subs.service_charges = 0,null,store_sales_subs.service_charges) as service_charges,0 as product, 1 as hid, 0 as hide, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,fnb_item_definitions.purchase_price as purchase_price,fnb_item_definitions.coa_code as coa_code,(fnb_item_definitions.sale_price+0) as old_sale_price')
              ->where('store_sales_subs.sale_id',$num)->groupBy('store_sales_subs.id')
              ->get();
 }

  $lastval['ccs']=coa_account::get();

        $lastval['catspermit']=Auth::user()->getAllPermissions()->where('category',24)->pluck('name');
        $lastval['locspermit']=Auth::user()->getAllPermissions()->where('category',25)->pluck('name');

         $lastval['companies']=coa_account::wherenotnull('desc')->get();

//        dd(trans_type::all());
        return ['invoice_no'=>$lastval];
    }

    public function sales_save(Request $request){
//        dd($request->all());

            $size['width'] = 300;
    $size['height'] = 200;
             $lastval=store_sales::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }



 
  $magi=fnb_predefined_value::first()->pluck('cost_center');
    
  /*  if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }*/

      $ccc =$request->get('company');
  
  $typo=null;  

   /* if($request->get('type')=='01' || $request->get('type')=='1'){
      $typo=1;
    }
    else if($request->get('type')=='02' || $request->get('type')=='2'){
      $typo=1;
    }*/
      if($request->get('type')>10){
      $typo=1;
    }
    else if($request->get('type')==1){
      $typo=1;
    }
     else if($request->get('type')==0){
       $typo=0;
    }
     else if($request->get('type')==3){
       $typo=3;
    }

        $d=[];
         $dd='';
         $cati ='';
           
 $d['coa_code']=null;
 
        if($typo==0){
          $dd=$request->get('customer_id');
            
        if(membership::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('customer_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $d['coa_code']=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
            $d['coa_code']=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
       
      }

        else if($typo==1){
          $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $d['coa_code']=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
             $d['coa_code']=null;
           $cati =  null;
         
          }
        }
 

        }
        else if($typo==3){
             
   $dd=$request->get('customer_id');
       

   if(hr_employment::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=hr_employment::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
             $d['coa_code']=$coa;
           //  $dd=$d['coa_code'];
           
           $cati =  coaparent($coa);
        
          }else{
              $d['coa_code']=null;
           $cati =  null;
        
          }
        }
        
        }



if(store_sales::where('id',$num)->count() == 0){

      $d['purchase_ref']=$request->get('purchase_ref');
         
           $d['unit']=$request->get('company');
         $d['account']=$request->get('accsearchid');
        $d['family']=$request->get('family');
        $d['amount_in_words']=$request->get('amount_in_words');


  $d['customer_id']=$request->get('customer_id');
        $d['type']=$typo;

        $d['remarks']=$request->get('remarks');
        $d['gross']=$request->get('gross');
        $d['discount']=$request->get('dis');
        $d['tax']=$request->get('taxx');
        $d['additional_charges']=$request->get('adds');
        $d['grand_total']=$request->get('grand_total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));

        $id=  store_sales::create($d);
//      dd();



if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
             $createimg=sendStoreSalesDocs($file,$size,['type'=>$typo,'trans_type'=>8,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]);  // type =115
            
          }


   }
       


}

// SAVING SUBS
      foreach($request->get('selected_items') as $inv){
        if(!isset($inv['instructions'])){
            $inv['instructions']=null;
            }

               if(!isset($inv['coa_code'])){
            $inv['coa_code']=null;
            }
if(!isset($inv['service_charges'])){
            $inv['service_charges']=0;
            }
            $m=  store_sales_subs::create([
            'sale_id'=>$id->id,
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
               
               'purchase_price'=>$inv['purchase_price'],
               'sale_price'=>$inv['sale_price'],
               'sub_total_price'=>$inv['product'],
               'qty'=>$inv['qty'],
               'discount'=>$inv['discount'],
               'tax'=>$inv['tax'],
                'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'date'=>formatDate($request->get('invoice_date')),
               'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
                  'service_charges'=>$inv['service_charges'],
            ]);

             $stt =  store_transactions::create([
                'purchase_ref'=>$request->get('purchase_ref'),
              'type_id'=>$id->id,
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>0,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
               'purchase_price'=>$inv['purchase_price'],
               'sale_price'=>$inv['sale_price'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'type'=>2, //for sales
               'item_coa_code'=>$inv['coa_code'],
                'unit'=>$request->get('company'),
            ]);
        }
// SAVING SUBS


//sending into COA transactions table
/*if(coa_transactions::where('debit_or_credit',1)->where('trans_type',8)->where('trans_type_id',$id->id)->where('amount',$request->get('grand_total'))->count() == 0)
{
 $t=[];
        $t['debit_or_credit']= 1;
        $t['trans_type']=8;
        $t['trans_type_id']=$id->id;
        $t['unit']=$request->get('unitsearchid');
        $t['account']=$request->get('accsearchid');
        $t['amount']=$request->get('grand_total');
        $t['is_active']=1;
        $t['date']=formatDate($request->get('invoice_date'));
    $tid=  coa_transactions::create($t);
}*/
//sending into COA transactions table
 
if(transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type',8)->where('trans_type_id',$id->id)->count() == 0)
{
     
       $t=[];


  $t['type']= 1;
        $t['debit_or_credit']= 1;
        $t['trans_type']=8;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$dd;
        $t['trans_moc_category']=$cati;
         
        $t['trans_moc_type']=$typo;
        $t['is_active']=0;
        $t['date']=formatDate($request->get('invoice_date'));
          $t['account']=transTypesCoa(8);
          $t['trans_coa']=$d['coa_code'];
         $t['unit']=$ccc;


      $tid=  transactions::create($t);
}
 

         return $id->id;

    }
     public function sales_edit(store_sales $store_sales,$id)
    {
     $data['id']=$id;
     $data['init']=0;
  return view('backend/store-management.store-sales.store-sales-aeu', $data);

    }

        public function sales_updated(Request $request){
//        dd($request->all());


 $size['width'] = 300;
    $size['height'] = 200;
 $typo=null;

    /*if($request->get('type')=='01' || $request->get('type')=='1'){
      $typo=1;
    }
    else if($request->get('type')=='02' || $request->get('type')=='2'){
      $typo=1;
    }*/
       if($request->get('type')>10){
      $typo=1;
    }
    else if($request->get('type')==1){
      $typo=1;
    }
     else if($request->get('type')==0){
       $typo=0;
    }
     else if($request->get('type')==3){
       $typo=3;
    }
/*
$magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }*/


 $ccc =$request->get('company');
        $d['coa_code']=null;
  $d=[];
         $dd='';
         $cati ='';

        if($typo==0){
          $dd=$request->get('customer_id');
            
        if(membership::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('customer_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $d['coa_code']=$coa;
        //    $dd=$d['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
            $d['coa_code']=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
       
      }

        else if($typo==1){
          $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $d['coa_code']=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
             $d['coa_code']=null;
           $cati =  null;
         
          }
        }
 

        }
        else if($typo==3){
             
   $dd=$request->get('customer_id');
       

   if(hr_employment::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=hr_employment::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
             $d['coa_code']=$coa;
           //  $dd=$d['coa_code'];
           
           $cati =  coaparent($coa);
        
          }else{
              $d['coa_code']=null;
           $cati =  null;
        
          }
        }
        
        }



 if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
             $createimg=sendStoreSalesDocs($file,$size,['type'=>$typo,'trans_type'=>8,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]);   
            
          }


   }

  $d['purchase_ref']=$request->get('purchase_ref');
        $d['unit']=$request->get('company');
         $d['account']=$request->get('accsearchid');
        $d['family']=$request->get('family');
        $d['amount_in_words']=$request->get('amount_in_words');



  $d['customer_id']=$request->get('customer_id');
        $d['type']=$typo;

        $d['remarks']=$request->get('remarks');
        $d['gross']=$request->get('gross');
        $d['discount']=$request->get('dis');
        $d['tax']=$request->get('taxx');
        $d['additional_charges']=$request->get('adds');
        $d['grand_total']=$request->get('grand_total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));

      $id=  store_sales::where('id',$request->get('id'))->updateWithUserstamps($d);
//      dd();


// SAVING SUBS
    foreach($request->get('selected_items') as $inv){
if(!isset($inv['instructions'])){
            $inv['instructions']=null;
            }

   if(!isset($inv['coa_code'])){
            $inv['coa_code']=null;
            }
            if(!isset($inv['service_charges'])){
            $inv['service_charges']=0;
            }
if(isset($inv['hid']) && $inv['hid']!=0){

     $m =store_sales_subs::where('id',$inv['id'])->updateWithUserstamps([
             'sale_id'=>$request->get('id'),
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
               'purchase_price'=>$inv['purchase_price'],
               'sale_price'=>$inv['sale_price'],
               'sub_total_price'=>$inv['product'],
               'qty'=>$inv['qty'],
            
                'discount'=>$inv['discount'],
               'tax'=>$inv['tax'],
             'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'date'=>formatDate($request->get('invoice_date')),
              'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
                  'service_charges'=>$inv['service_charges'],
        ]);

  $stt =store_transactions::where('type',2)->where('in_or_out',0)->where('type_id',$request->get('id'))->where('sub_id',$inv['id'])->updateWithUserstamps([
       'purchase_ref'=>$request->get('purchase_ref'),
               'type_id'=>$request->get('id'),
               'sub_id'=>$inv['id'],
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>0,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
               'purchase_price'=>$inv['purchase_price'],
               'sale_price'=>$inv['sale_price'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'type'=>2, //for sales
                 'item_coa_code'=>$inv['coa_code'],
                  'unit'=>$request->get('company'),
        ]);

        }
        else{

      $m=  store_sales_subs::create([
            'sale_id'=>$request->get('id'),
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
              
               'purchase_price'=>$inv['purchase_price'],
               'sale_price'=>$inv['sale_price'],
               'sub_total_price'=>$inv['product'],
               'qty'=>$inv['qty'],
                'discount'=>$inv['discount'],
               'tax'=>$inv['tax'],
               'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'date'=>formatDate($request->get('invoice_date')),
               'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
                  'service_charges'=>$inv['service_charges'],
            ]);

        $stt =  store_transactions::create([
               'purchase_ref'=>$request->get('purchase_ref'),
              'type_id'=>$request->get('id'),
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>0,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
               'purchase_price'=>$inv['purchase_price'],
               'sale_price'=>$inv['sale_price'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'type'=>2, //for sales
                 'item_coa_code'=>$inv['coa_code'],
                  'unit'=>$request->get('company'),
            ]);
}

}
// SAVING SUBS



//sending into COA transactions table
 /*$t=[];

       $t['debit_or_credit']= 1;
        $t['trans_type']=8;
        $t['trans_type_id']=$id->id;
        $t['unit']=$request->get('unitsearchid');
        $t['account']=$request->get('accsearchid');
        $t['amount']=$request->get('grand_total');
          $t['is_active']=1;
          $t['date']=formatDate($request->get('invoice_date'));

    $tid= transactions::where('debit_or_credit',1)->where('trans_type',8)->where('trans_type_id',$request->get('id'))->updateWithUserstamps($t);*/
//sending into COA transactions table

    $t=[];
  

        $t['type']= 1;
        $t['debit_or_credit']= 1;
        $t['trans_type']=8;
       $t['trans_type_id']=$request->get('id');
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$dd;
        $t['trans_moc_category']=$cati;
         
        $t['trans_moc_type']=$typo;
      
        $t['date']=formatDate($request->get('invoice_date'));
          $t['account']=transTypesCoa(8);
          $t['trans_coa']=$d['coa_code'];
         $t['unit']= $ccc;
       
 
    $tid= transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type', 8)->where('trans_type_id',$request->get('id'))->updateWithUserstamps($t); 

    


}

      public function sales_index_deleted(Request $request, store_sales $store_sales)
    {
        return view('backend/store-management/store-sales/store-sales-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sales_indexdt_deleted(Request $request, store_sales $store_sales)
    {

        $table = store_sales::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('store-management/store-sales/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

               ->addColumn('invoice_date', function ($table) {
              return formatDateToShow($table->invoice_date);
                })


               ->addColumn('deleted_at', function ($table) {
              return formatDateToShow($table->deleted_at);
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
                })

                 ->addColumn('name', function ($table) {
                if($table->type==0 && $table->customer_id!=null){
                    return $table->member->title.' '.$table->member->first_name.' '.$table->member->middle_name.' '.$table->member->applicant_name;
                }
                else if($table->type==1 && $table->customer_id!=null){
                    return $table->customer->customer_name;
                }
                else if($table->type==3 && $table->customer_id!=null){
                    return $table->employee->name;
                }
                })


/*  ->addColumn('store_location', function ($table) {
    if($table->store_location){
           return storelocs($table->store_location);
    }
           else{
            return '';
           }

                })*/

    ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }


public function sales_destroy(Request $request,store_sales $store_sales,$id)
    {
     $update= store_sales::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$store_sales::where('id', $id)->deleteWithUserstamps();
  transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type',8)->where('trans_type_id', $id)->deleteWithUserstamps();

      store_transactions::where('type',2)->where('in_or_out',0)->where('type_id', $id)->deleteWithUserstamps();
    }
   /*  public function sales_destroy(store_sales $store_sales,$id)
    {

        $destroy=$store_sales::where('id', $id)->deleteWithUserstamps();
        $transaction = transactions::where('debit_or_credit',1)->where('trans_type',8)->where('trans_type_id', $id)->deleteWithUserstamps();

         store_transactions::where('type',2)->where('in_or_out',0)->where('type_id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('store-management/store-sales-vue');
    }*/

    public function sales_restore(store_sales $store_sales,$id)
    {
        $restore = store_sales::onlyTrashed()->find($id)->restore();
      transactions::onlyTrashed()->where('type',1)->where('trans_type_id', $id)->where('trans_type',8)->where('debit_or_credit',1)->restore();

      store_transactions::onlyTrashed()->where('type',2)->where('type_id',$id)->where('in_or_out',0)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/store-sales/deleted');

}


public function sales_invoice(store_sales $store_sales,$id)
    {
        $data['receiptdata']=store_sales::where('id',$id)->first();

        $data['terms']=SalesTermsandConditions::first();

        $data['salesub']=store_sales::with('storesubs')->where('id', $id)->get();
        $data['bookingsubdata']=$data['salesub'][0]['storesubs'];


  $data['profiledata']=admin_company_profile::where('cost_center',$data['receiptdata']->unit)->first();
      //  $data['profiledata']=admin_company_profile::get()->first();



 $summe=store_sales::where('id',$id)->get()->sum('grand_total');
 
  $s=transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',8)->where('trans_type_id',$id)->get()->pluck('id');
        $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
        $b = (transactions::whereIn('id',$v)->where('debit_or_credit',0)->where('type',2)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

           $data['resultant'] = $summe-$x;
            $data['amount_paid'] = $x; 

        return view('backend/store-management.store-sales.store-sales-invoice', $data);
    }


     function salesitems($id){
       $items= DB::table('fnb_item_definitions')
              ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->selectRaw('fnb_item_definitions.*,0 as service_charges,0 as discount,0 as tax,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.sale_price+0) as old_sale_price')
              ->where('fnb_item_definitions.sub_category',$id)->where('fnb_item_definitions.status',1)->where('fnb_item_definitions.salable',1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
              ->get();

/*->where('store_transactions.is_active',1)*/


     /*   $items=fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('sub_category',$id)->where('status',1)->where('purchasable',1)->orderBy('item_details')->get();*/
        return $items;
    }


     public function sales_approve(Request $request,$id){
  $d=[];
      $d['approved']=1;
     store_sales::where('id',$id)->updateWithUserstamps($d);

       $codes =store_sales_subs::where('sale_id',$id)->get();

  foreach($codes as $cod){
 /*   $openin = fnb_item_definition::where('item_code',$cod['item_code'])->get()->pluck('opening_stock');
    $stock= $openin[0];
           $m=  fnb_item_definition::where('item_code',$cod['item_code'])->updateWithUserstamps([
            //'opening_stock'=> $stock+$cod['qty'],
            'purchase_price'=>$cod['purchase_price'],
            ]);*/

  store_transactions::where('type',2)->where('in_or_out',0)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>1, //for approved or active store transactions
        ]);

        }

  transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type_id',$id)->where('trans_type', 8)->updateWithUserstamps([
               'is_active'=>1, 
        ]);

 return redirect('store-management/store-sales-vue');
    }


    public function sales_unapprove(Request $request,$id){
 $d=[];
      $d['approved']=0;
 store_sales::where('id',$id)->updateWithUserstamps($d);

       $codes =store_sales_subs::where('sale_id',$id)->get();


  foreach($codes as $cod){
    /*$openin = fnb_item_definition::where('item_code',$cod['item_code'])->get()->pluck('opening_stock');
    $stock= $openin[0];
           $m=  fnb_item_definition::where('item_code',$cod['item_code'])->updateWithUserstamps([
            'opening_stock'=> $stock-$cod['qty'],
            'purchase_price'=>$cod['purchase_price'],
            ]);*/

 store_transactions::where('type',2)->where('in_or_out',0)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>0, //for unapproved or inactive store transactions
        ]);


        }

transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type_id',$id)->where('trans_type', 8)->updateWithUserstamps([
               'is_active'=>0, 
        ]);

 return redirect('store-management/store-sales-vue');
    }


public function sales_docs(store_sales $store_sales,$id)
    { 
        $data['receiptdata']=store_sales::where('id',$id)->first();
        return view('backend/store-management.store-sales.store-sales-documents', $data);
    }

// STORE SALES








    // STORE PURCHASES
    public function index_vue(Request $request, store_purchases $store_purchases)
    {


         return view('backend/store-management/store-purchases/store-purchases-vue');

    }

       public function purchases_init_vue(Request $request)
    {

$data['purchases'] =\Illuminate\Support\Facades\DB::select(
  /*   'select store_purchases.*, 
     coas.code as unitcode,
     coas.name as unit,
     coaz.name as company,
     coa_accounts_controls.name as account,
        users.name as cashiername
from store_purchases

left outer join users on users.id =store_purchases.created_by and users.status=1

  left outer join coa_accounts coas on coas.code =store_purchases.unit
  left outer join coa_accounts coaz on coaz.code=coas.desc
 
 left outer join coa_accounts_controls on coa_accounts_controls.code =store_purchases.account

where store_purchases.deleted_at is null group by store_purchases.id order by store_purchases.id desc'*/
     'select store_purchases.*, finance_ledger_people.person_name as supplier,
      sum(distinct transactions.trans_amount ) as paid_amount , GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,
       media.url as image,
        users.name as cashiername,
         coas.code as unitcode,
     coas.name as unit,
     coaz.name as company,
        sum( distinct store_purchases_subs.discount) as discount,
        sum( distinct store_purchases_subs.tax) as tax,
        sum( distinct store_purchases_subs.purchase_price) as sgross
from store_purchases

left outer join users on users.id =store_purchases.created_by and users.status=1
left outer join transactions as t1 on t1.trans_type=7 and t1.trans_type_id=store_purchases.id and t1.debit_or_credit=0 and t1.type=4 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=7 and transactions.trans_type_id=store_purchases.id and transactions.debit_or_credit=1 and transactions.type=5 and transactions.deleted_at is null

left outer join media on media.trans_type=7 and media.trans_type_id=store_purchases.id and media.deleted_at is null

left outer join finance_ledger_people on finance_ledger_people.id =store_purchases.customer_id and finance_ledger_people.deleted_at is null
left outer join store_purchases_subs on store_purchases_subs.purchase_id =store_purchases.id
  left outer join coa_accounts coas on coas.code =store_purchases.unit
  left outer join coa_accounts coaz on coaz.code=coas.desc
where store_purchases.deleted_at is null group by store_purchases.id order by store_purchases.id desc' );

  $data['ccs']=coa_account::get();
     return $data;
}

  public function index_deleted(Request $request, store_purchases $store_purchases)
    {
        return view('backend/store-management/store-purchases/store-purchases-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, store_purchases $store_purchases)
    {

        $table = store_purchases::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('store-management/store-purchases/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

               ->addColumn('invoice_date', function ($table) {
              return formatDateToShow($table->invoice_date);
                })


               ->addColumn('deleted_at', function ($table) {
              return formatDateToShow($table->deleted_at);
                })

              ->addColumn('supplier', function ($table) {
                if($table->customer_id!=null){
                   return $table->ledgerperson->person_name;
                }
                else{
                    return '';
                }

                })

/*  ->addColumn('store_location', function ($table) {
    if($table->store_location){
           return storelocs($table->store_location);
    }
           else{
            return '';
           }

                })*/

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
        return view('backend/store-management.store-purchases.store-purchases-aeu');
    }

 public function init(Request $request){
         $lastval=[];
          $lastid=[];

           if($request->get('r')){
            $lastid=store_purchases::find($request->get('r'));
            $num=0;
      if($lastid){
        $num=$lastid->id;
        $lastid['increment_number']=$num;

      }else{
        $num=0;
        $lastid['increment_number']=$num;
      }
  }

        if($request->get('r')){
            $lastval=store_purchases::find($request->get('r'));
        }
        else{
            $lastval = store_purchases::withTrashed()->latest('id')->first();

        }
 
//        echo 123;

 
        if(Auth::user()->can('Add Item Category')){
        $lastval['add_cat']=Permission::where('name','Add Item Category')->get();
}
if(Auth::user()->can('Add Item Sub-Category')){
        $lastval['add_sub']=Permission::where('name','Add Item Sub-Category')->get();
}
if(Auth::user()->can('Add Item Definition')){
        $lastval['add_item']=Permission::where('name','Add Item Definition')->get();
}
if(Auth::user()->can('Add Ledger Persons')){
        $lastval['add_sup']=Permission::where('name','Add Ledger Persons')->get();
}
if(Auth::user()->can('Cancel Store Purchase')){
$lastval['cancel_permit']=Permission::where('name','Cancel Store Purchase')->get();
            }
      $lastval['measurement_units']=fnb_measurement_unit::where('status',1)->get();       
  $lastval['cancelled_remarks']=store_cancellation_remark::where('status',1)->get();
        $lastval['mains']=fnb_item_category::where('status',1)->orderBy('desc')->get();
        $lastval['subcats']=fnb_item_sub_category::where('status',1)->get();
        $lastval['predefined']=fnb_predefined_value::get()->first();

      //  $lastval['itemdefs']=fnb_item_definition::where('status',1)->where('purchasable',1)->get();
         $lastval['itemdefs'] =DB::table('fnb_item_definitions')
              ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->selectRaw('fnb_item_definitions.*, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.purchase_price+0) as old_purchase_price')
              ->where('fnb_item_definitions.status',1)->where('fnb_item_definitions.purchasable',1)->where('store_transactions.is_active',1)->groupBy('fnb_item_definitions.id')
              ->get();

  $lastval['locations']=fnb_restaurant_location::where('status',1)->where('restaurant',1)->orWhere('store',1)->get();
   $lastval['departments']=store_department::where('status',1)->get();
        if($request->get('r')){

             $ikd=$lastval->customer_id;
    $lastval['documents']=media::where('type_id',$ikd)->where('trans_type',7)->where('trans_type_id',$lastval->id)->get();


          /*  $lastval['selected_items'] =DB::table('store_purchases_subs')
           
            ->leftJoin('store_transactions', function ($join) {
              $join->on('store_transactions.item_code', '=', 'store_purchases_subs.item_code')->where('store_transactions.is_active',1);
            })
            ->selectRaw('store_purchases_subs.*,0 as product, 1 as hid, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock')
              ->where('store_purchases_subs.purchase_id',$num)->groupBy('store_purchases_subs.id')
              ->get();*/
              // ->where('store_transactions.is_active',1)


   $unitu =store_purchases::where('id',$request->get('r'))->get()->pluck('unit');
   $unita=$unitu[0];

$lastval['selected_items'] =DB::table('store_purchases_subs')
             ->join('fnb_item_definitions','store_purchases_subs.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
            ->leftJoin('store_transactions', function ($join) use ($unita){
              $join->on('store_transactions.item_code', '=', 'store_purchases_subs.item_code')->where('store_transactions.is_active',1)->where('store_transactions.type','!=',3)->where('store_transactions.type','!=',4)->where('store_transactions.unit',$unita);
            })
            ->selectRaw('store_purchases_subs.*,if(store_purchases_subs.service_charges = 0,null,store_purchases_subs.service_charges) as service_charges,0 as product, 1 as hid,  0 as hide, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,fnb_item_definitions.coa_code as coa_code,(fnb_item_definitions.purchase_price+0) as old_purchase_price')
               ->where('store_purchases_subs.purchase_id',$num)->groupBy('store_purchases_subs.id')
              ->get();



/*$lastval['selected_items']=store_purchases_subs::selectRaw('store_purchases_subs.*,0 as product')->where('purchase_id',$num)->get();*/
 }

  $lastval['ccs']=coa_account::get();
        $lastval['catspermit']=Auth::user()->getAllPermissions()->where('category',24)->pluck('name');
        $lastval['locspermit']=Auth::user()->getAllPermissions()->where('category',25)->pluck('name');

 $lastval['companies']=coa_account::wherenotnull('desc')->get();

//        dd(trans_type::all());
        return ['invoice_no'=>$lastval];
    }

    public function save(Request $request){
//        dd($request->all());
    

    $size['width'] = 300;
    $size['height'] = 200;
             $lastval=store_purchases::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }




 /* $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }*/

     $ccc =$request->get('company');
 $typo=2;
 
 $d['coa_code']=null;
        $d=[];
         $dd='';
         $cati ='';

       if($typo==2){
          $dd=$request->get('customer_id');

             if(finance_ledger_person::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $d['coa_code']=$coa;
           //  $dd=$d['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
             $d['coa_code']=null;
           $cati =  null;
         
          }
        }

        }
       


if(store_purchases::where('id',$num)->count() == 0){



       
     

        $d['unit']=$request->get('company');
         $d['account']=$request->get('accsearchid');
        $d['amount_in_words']=$request->get('amount_in_words');


  $d['customer_id']=$request->get('customer_id');
        $d['remarks']=$request->get('remarks');
        $d['gross']=$request->get('gross');
        $d['discount']=$request->get('dis');
        $d['tax']=$request->get('taxx');
        $d['additional_charges']=$request->get('adds');
        $d['grand_total']=$request->get('grand_total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));

        $id=  store_purchases::create($d);
//      dd();



if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
             $createimg=sendStorePurchaseDocs($file,$size,['type'=>2,'trans_type'=>7,'trans_type_id'=>$id->id,'moc_id'=>$request->post('customer_id')]);  // type =115
            
          }


   }
       


}

// SAVING SUBS
      foreach($request->get('selected_items') as $inv){
        if(!isset($inv['instructions'])){
            $inv['instructions']=null;
            }
              if(!isset($inv['coa_code'])){
            $inv['coa_code']=null;
            }
             if(!isset($inv['service_charges'])){
            $inv['service_charges']=0;
            }
            $m=  store_purchases_subs::create([
            'purchase_id'=>$id->id,
               'item_code'=>$inv['item_code'],
               'item_details'=>$inv['item_details'],
               'unit'=>$inv['unit'],
               'purchase_price'=>$inv['purchase_price'],
               'sub_total_price'=>$inv['product'],
           
               'qty'=>$inv['qty'],
                'discount'=>$inv['discount'],
               'tax'=>$inv['tax'],
             'instructions'=>$inv['instructions']=='null'?null:$inv['instructions'],
              /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'date'=>formatDate($request->get('invoice_date')),
             'remark'=>$inv['remark']=='null'?null:$inv['remark'],
               'aftercancel'=>$inv['aftercancel']=='null'?null:$inv['aftercancel'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
                'service_charges'=>$inv['service_charges'],
            ]);

            $stt =  store_transactions::create([
              'type_id'=>$id->id,
               'sub_id'=>$m->id,
               'date'=>formatDate($request->get('invoice_date')),
               'in_or_out'=>1,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
               'purchase_price'=>$inv['purchase_price'],
               /*'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
               'type'=>1, //for purchases
                 'item_coa_code'=>$inv['coa_code'],
                  'unit'=>$request->get('company'),
            ]);



/*
        fnb_item_definition::where('item_code',$inv['item_code'])->updateWithUserstamps([
            'opening_stock'=>(int)$inv['opening_stock']+(int)$inv['qty'],
            'purchase_price'=>$inv['purchase_price'],
        ]);*/

        }
// SAVING SUBS



//sending into COA transactions table
/*if(coa_transactions::where('debit_or_credit',0)->where('trans_type',7)->where('trans_type_id',$id->id)->where('amount',$request->get('grand_total'))->count() == 0)
{

 $t=[];

        $t['debit_or_credit']= 0;
        $t['trans_type']=7;
        $t['trans_type_id']=$id->id;
        $t['unit']=$request->get('unitsearchid');
        $t['account']=$request->get('accsearchid');
        $t['amount']=$request->get('grand_total');
          $t['is_active']=1;
          $t['date']=formatDate($request->get('invoice_date'));

      $tid=  coa_transactions::create($t);
}*/
//sending into COA transactions table


if(transactions::where('debit_or_credit',0)->where('type',4)->where('trans_type',7)->where('trans_type_id',$id->id)->count() == 0)
{
     
       $t=[];


  $t['type']= 4;
        $t['debit_or_credit']= 0;
        $t['trans_type']=7;
        $t['trans_type_id']=$id->id;
        $t['trans_amount']=$request->get('grand_total');
        $t['trans_moc']=$dd;
        $t['trans_moc_category']=$cati;
         
        $t['trans_moc_type']=$typo;
        $t['is_active']=0;
        $t['date']=formatDate($request->get('invoice_date'));
          $t['account']=transTypesCoa(7);
          $t['trans_coa']=$d['coa_code'];
         $t['unit']=$ccc;


      $tid=  transactions::create($t);
}

         return $id->id;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(store_purchases $store_purchases,$id)
    {
     $data['id']=$id;
     $data['init']=0;
  return view('backend/store-management.store-purchases.store-purchases-aeu', $data);

    }

  public function updated(Request $request)
  {

    $size['width'] = 300;
    $size['height'] = 200;
    $typo = 2;

    /*$magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }
*/
    $ccc = $request->get('company');
    $d['coa_code'] = null;

    $d = [];
    $dd = '';
    $cati = '';

    if ($typo == 2) {
      $dd = $request->get('customer_id');

      if (finance_ledger_person::where('id', $request->get('customer_id'))->exists()) {
        $arr_coa = finance_ledger_person::where('id', $request->get('customer_id'))->get()->pluck('account');
        if ($arr_coa[0]) {
          $coa = $arr_coa[0];
          $d['coa_code'] = $coa;
          //  $dd=$d['coa_code'];
          $cati =  coaparent($coa);
        } else {
          $d['coa_code'] = null;
          $cati =  null;
        }
      }
    }


    if ($request->hasFile('images')) {

      $files = $request->file('images');
      foreach ($files as $file) {
        // dd($file);
        $createimg = sendStorePurchaseDocs($file, $size, ['type' => 2, 'trans_type' => 7, 'trans_type_id' => $request->get('id'), 'moc_id' => $request->post('customer_id')]);
      }
    }


    /*  if($request->get('document')) {
           $files = $request->get('document');
           foreach($files as $file){
             // dd($file);
              
                $updateimg=sendStorePurchaseDocs($file,$size,['type'=>2,'trans_type'=>7,'trans_type_id'=>$request->get('id'),'moc_id'=>$request->post('customer_id')]);
             
          }
       }*/




    $d['unit'] = $request->get('company');
    $d['account'] = $request->get('accsearchid');
    $d['amount_in_words'] = $request->get('amount_in_words');

    $d['customer_id'] = $request->get('customer_id');
    $d['remarks'] = $request->get('remarks');
    $d['gross'] = $request->get('gross');
    $d['discount'] = $request->get('dis');
    $d['tax'] = $request->get('taxx');
    $d['additional_charges'] = $request->get('adds');
    $d['grand_total'] = $request->get('grand_total');
    $d['invoice_date'] = formatDate($request->get('invoice_date'));

    store_purchases::where('id', $request->get('id'))->updateWithUserstamps($d);

	// $all_store_sub = store_purchases_subs::where('purchase_id', $request->get('id'))->get();

	// foreach($all_store_sub){
		
	// }

	$updated_ids = [];
    // SAVING SUBS
    foreach ($request->get('selected_items') as $inv) {

      if (!isset($inv['instructions'])) {
        $inv['instructions'] = null;
      }

      if (!isset($inv['coa_code'])) {
        $inv['coa_code'] = null;
      }
      if (!isset($inv['service_charges'])) {
        $inv['service_charges'] = 0;
      }
      if (isset($inv['hid']) && $inv['hid'] != 0) {
		array_push($updated_ids,$inv['id']);
        store_purchases_subs::where('id', $inv['id'])->updateWithUserstamps([
          'purchase_id' => $request->get('id'),
          'item_code' => $inv['item_code'],
          'item_details' => $inv['item_details'],
          'unit' => $inv['unit'],

          'purchase_price' => $inv['purchase_price'],
          'sub_total_price' => $inv['product'],
          'qty' => $inv['qty'],
          'discount' => $inv['discount'],
          'tax' => $inv['tax'],
          'instructions' => $inv['instructions'] == 'null' ? null : $inv['instructions'],
          /*  'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
          'date' => formatDate($request->get('invoice_date')),
          'remark' => $inv['remark'] == 'null' ? null : $inv['remark'],
          'aftercancel' => $inv['aftercancel'] == 'null' ? null : $inv['aftercancel'],
          'status' => $inv['status'] == 'null' ? null : $inv['status'],
          'service_charges' => $inv['service_charges'],
        ]);


        $stt = store_transactions::where('type', 1)->where('in_or_out', 1)->where('type_id', $request->get('id'))->where('sub_id', $inv['id'])->updateWithUserstamps([
          'type_id' => $request->get('id'),
          'sub_id' => $inv['id'],
          'date' => formatDate($request->get('invoice_date')),
          'in_or_out' => 1,
          'item_code' => $inv['item_code'],
          'qty' => $inv['qty'],
          'purchase_price' => $inv['purchase_price'],
          /* 'store_location'=>$inv['store_location'],
               'department'=>$inv['department'],*/
          'type' => 1, //for purchases
          'item_coa_code' => $inv['coa_code'],
          'unit' => $request->get('company'),
        ]);
      } else {

			/*     fnb_item_definition::where('item_code',$inv['item_code'])->updateWithUserstamps([
				'opening_stock'=>(int)$inv['opening_stock']+(int)$inv['qty'],
				'purchase_price'=>$inv['purchase_price'],
			]);*/

			$m =  store_purchases_subs::create([
			'purchase_id' => $request->get('id'),
			'item_code' => $inv['item_code'],
			'item_details' => $inv['item_details'],
			'unit' => $inv['unit'],
			'purchase_price' => $inv['purchase_price'],

			'sub_total_price' => $inv['product'],
			'qty' => $inv['qty'],
			'discount' => $inv['discount'],
			'tax' => $inv['tax'],

			'instructions' => $inv['instructions'] == 'null' ? null : $inv['instructions'],

			/* 'store_location'=>$inv['store_location'],
				'department'=>$inv['department'],*/
			'date' => formatDate($request->get('invoice_date')),
			'remark' => $inv['remark'] == 'null' ? null : $inv['remark'],
			'aftercancel' => $inv['aftercancel'] == 'null' ? null : $inv['aftercancel'],
			'status' => $inv['status'] == 'null' ? null : $inv['status'],
			'service_charges' => $inv['service_charges'],
			]);
			array_push($updated_ids,$m->id);
			$stt =  store_transactions::create([
			'type_id' => $request->get('id'),
			'sub_id' => $m->id,
			'date' => formatDate($request->get('invoice_date')),
			'in_or_out' => 1,
			'item_code' => $inv['item_code'],
			'qty' => $inv['qty'],
			'purchase_price' => $inv['purchase_price'],
			/* 'store_location'=>$inv['store_location'],
				'department'=>$inv['department'],*/
			'type' => 1, //for purchases
			'item_coa_code' => $inv['coa_code'],
			'unit' => $request->get('company'),
			]);
      }
    }

	store_purchases_subs::where('purchase_id',$request->get('id'))->whereNotIn('id', $updated_ids)->delete();
    // SAVING SUBS

    $t = [];


    $t['type'] = 4;
    $t['debit_or_credit'] = 0;
    $t['trans_type'] = 7;
    $t['trans_type_id'] = $request->get('id');
    $t['trans_amount'] = $request->get('grand_total');
    $t['trans_moc'] = $dd;
    $t['trans_moc_category'] = $cati;

    $t['trans_moc_type'] = $typo;

    $t['date'] = formatDate($request->get('invoice_date'));
    $t['account'] = transTypesCoa(7);
    $t['trans_coa'] = $d['coa_code'];
    $t['unit'] = $ccc;


    $tid = transactions::where('type', 4)->where('debit_or_credit', 0)->where('trans_type', 7)->where('trans_type_id', $request->get('id'))->updateWithUserstamps($t);
    //sending into COA transactions table
    /* $t=[];

       $t['debit_or_credit']= 0;
        $t['trans_type']=7;
        $t['trans_type_id']=$id->id;
        $t['unit']=$request->get('unitsearchid');
        $t['account']=$request->get('accsearchid');
        $t['amount']=$request->get('grand_total');
          $t['is_active']=1;
          $t['date']=formatDate($request->get('invoice_date'));

    $tid= transactions::where('debit_or_credit',0)->where('trans_type',7)->where('trans_type_id',$request->get('id'))->updateWithUserstamps($t);*/
    //sending into COA transactions table


  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,store_purchases $store_purchases,$id)
    {
     $update= store_purchases::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$store_purchases::where('id', $id)->deleteWithUserstamps();
  /*    $transaction = coa_transactions::where('debit_or_credit',0)->where('trans_type',7)->where('trans_type_id', $id)->deleteWithUserstamps();*/

      store_transactions::where('type',1)->where('in_or_out',1)->where('type_id', $id)->deleteWithUserstamps();
      transactions::where('type',4)->where('trans_type',7)->where('debit_or_credit',0)->where('trans_type_id', $id)->deleteWithUserstamps();
    }
   /* public function destroy(store_purchases $store_purchases,$id)
    {

        $destroy=$store_purchases::where('id', $id)->deleteWithUserstamps();
        $transaction = transactions::where('debit_or_credit',0)->where('trans_type',7)->where('trans_type_id', $id)->deleteWithUserstamps();

         store_transactions::where('type',1)->where('in_or_out',1)->where('type_id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('store-management/store-purchases-vue');
    }*/

    public function restore(store_purchases $store_purchases,$id)
    {
        $restore = store_purchases::onlyTrashed()->find($id)->restore();
    /*    $transaction = coa_transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',7)->where('debit_or_credit',0)->restore();*/

         store_transactions::onlyTrashed()->where('type',1)->where('type_id',$id)->where('in_or_out',1)->restore();
         transactions::onlyTrashed()->where('type',4)->where('trans_type',7)->where('debit_or_credit',0)->where('trans_type_id', $id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/store-purchases/deleted');

}

public function invoice(store_purchases $store_purchases,$id)
    {
        $data['receiptdata']=store_purchases::where('id',$id)->first();

        $data['salesub']=store_purchases::with('storesubs')->where('id', $id)->get();
        $data['bookingsubdata']=$data['salesub'][0]['storesubs'];


 $data['profiledata']=admin_company_profile::where('cost_center',$data['receiptdata']->unit)->first();
      //  $data['profiledata']=admin_company_profile::get()->first();



 $summe=store_purchases::where('id',$id)->get()->sum('grand_total');

     $s=transactions::where('debit_or_credit',0)->where('type',4)->where('trans_type',7)->where('trans_type_id',$id)->get()->pluck('id');
        $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
        $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 1)->where('debit_or_credit', 5)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

           $data['resultant'] = $summe-$x;
            $data['amount_paid'] = $x; 

        return view('backend/store-management.store-purchases.store-purchases-invoice', $data);
    }


     function items($id){
       $items= DB::table('fnb_item_definitions')
              ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
              ->selectRaw('fnb_item_definitions.*,0 as service_charges,0 as discount,0 as tax,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.purchase_price+0) as old_purchase_price')
              ->where('fnb_item_definitions.sub_category',$id)->where('fnb_item_definitions.status',1)->where('fnb_item_definitions.purchasable',1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
              ->get();

              /*->where('store_transactions.is_active',1)*/

     /*   $items=fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('sub_category',$id)->where('status',1)->where('purchasable',1)->orderBy('item_details')->get();*/
        return $items;
    }


  public function approve(Request $request,$id){

      $d=[];
      $d['approved']=1;
     store_purchases::where('id',$id)->updateWithUserstamps($d);

       $codes =store_purchases_subs::where('purchase_id',$id)->get();

  foreach($codes as $cod){
    $openin = fnb_item_definition::where('item_code',$cod['item_code'])->get()->pluck('opening_stock');
    $stock= $openin[0];
           $m=  fnb_item_definition::where('item_code',$cod['item_code'])->updateWithUserstamps([
            //'opening_stock'=> $stock+$cod['qty'],
            'unit'=>$cod['unit'],
            'purchase_price'=>$cod['purchase_price'],
            ]);

  store_transactions::where('type',1)->where('in_or_out',1)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>1, //for approved or active store transactions
        ]);

        }


transactions::where('type',4)->where('debit_or_credit',0)->where('trans_type_id',$id)->where('trans_type',7)->updateWithUserstamps([
               'is_active'=>1, 
        ]);

 return redirect('store-management/store-purchases-vue');
    }


    public function unapprove(Request $request,$id){

      $d=[];
      $d['approved']=0;
 store_purchases::where('id',$id)->updateWithUserstamps($d);

       $codes =store_purchases_subs::where('purchase_id',$id)->get();


  foreach($codes as $cod){
    /*$openin = fnb_item_definition::where('item_code',$cod['item_code'])->get()->pluck('opening_stock');
    $stock= $openin[0];
           $m=  fnb_item_definition::where('item_code',$cod['item_code'])->updateWithUserstamps([
            'opening_stock'=> $stock-$cod['qty'],
            'purchase_price'=>$cod['purchase_price'],
            ]);*/

 store_transactions::where('type',1)->where('in_or_out',1)->where('type_id',$id)->where('sub_id',$cod['id'])->updateWithUserstamps([
               'is_active'=>0, //for unapproved or inactive store transactions
        ]);

        }

transactions::where('type',4)->where('debit_or_credit',0)->where('trans_type_id',$id)->where('trans_type',7)->updateWithUserstamps([
               'is_active'=>0, 
        ]);

 return redirect('store-management/store-purchases-vue');
    }




     function department($id){
     if($id!=0){
        $name=store_department::where('location',$id)->orderBy('desc')->where('status',1)->get();
     }
     else{
         $name=store_department::orderBy('desc')->where('status',1)->get();
     }
        return $name;
    }

// STORE PURCHASES


 public function temp_upload(Request $request){
//dd($request->file('file'));

      $file=$request->file('file');

       //return $file;

    $ext = $file->getClientOriginalName();

     if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'storepurchasedocs';
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

 



     public function docs(store_purchases $store_purchases,$id)
    { 
        $data['receiptdata']=store_purchases::where('id',$id)->first();
        return view('backend/store-management.store-purchases.store-purchases-documents', $data);
    }

// REPORTS
 public function dishbreakdownpurchase_vue(Request $request, store_purchases $store_purchases)
    {
         return view('backend/finance-and-management/store-management/dish-breakdown-purchases-summary-vue');
    }

       public function dishbreakdownpurchase_init_vue(Request $request)
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
        if($request->cashier){
            $search.=' and store_purchases.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }if($request->mem){
        $search.=' and store_purchases.customer_id in ('.$request->mem.') ';
        }
        if($request->discounted==1){
        $search.=' and store_purchases.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_purchases.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_purchases.approved=1 ';
        }if($request->status==2){
        $search.=' and store_purchases.approved=0 ';
        }
         if($request->location){
          $search3.=' and store_purchases_subs.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search3.=' and store_purchases_subs.department in ('.$request->department.') ';
        }

        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.purchase_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       (sum(store_purchases_subs.qty))                          as qty,
        (sum( store_purchases_subs.sub_total_price ))     as sub_total

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_purchases_subs on store_purchases_subs.item_code = fnb_item_definitions.item_code  and store_purchases_subs.purchase_id in (select id from store_purchases where  deleted_at is null '.$search.' ) and
                                           DATE(store_purchases_subs.date) <= "'.$end_date.'" and
                                           DATE(store_purchases_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_purchases on store_purchases.id = store_purchases_subs.purchase_id
where fnb_item_definitions.deleted_at is null and store_purchases.id is not null '.$search2.'
group by fnb_item_definitions.id,store_purchases_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc');
        }

  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Dish Breakdown Purchase Summary')){
 $data['exported']=1;
 }

     return $data;
}


  public function closingpurchases_vue(Request $request, store_purchases $store_purchases)
    {
       return view('backend/finance-and-management/store-management/closing-purchases-report-vue');
    }

       public function closingpurchases_init_vue(Request $request)
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
       if($request->cashier){
            $search.=' and store_purchases.created_by in ('.$request->cashier.') ';
        }
        if($request->mem){
        $search.=' and store_purchases.customer_id in ('.$request->mem.') ';
        }
        if($request->discounted==1){
        $search.=' and store_purchases.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_purchases.tax >0 ';
        }
          if($request->status==1){
        $search.=' and store_purchases.approved=1 ';
        }if($request->status==2){
        $search.=' and store_purchases.approved=0 ';
        }
        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select store_purchases.id,

       (sum(store_purchases.gross))                     as gross,
       (sum(store_purchases.discount))                as disc,
         (sum(store_purchases.tax))                  as tax,
          (sum(store_purchases.grand_total))                 as grand,

  sum(transactions.trans_amount ) as paid_amount


from store_purchases

left outer join transactions on transactions.trans_type=7 and transactions.type=5 and transactions.trans_type_id=store_purchases.id and transactions.debit_or_credit=1 and transactions.deleted_at is null


where store_purchases.id is not null and store_purchases.deleted_at is null '.$search.'  and
                                           DATE(store_purchases.invoice_date) <= "'.$end_date.'" and
                                           DATE(store_purchases.invoice_date) >= "'.$start_date.'" '.$search3.'


');
 }

    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Closing Purchases Report')){
 $data['exported']=1;
 }

     return $data;
}

 public function itemsummary_vue(Request $request, store_purchases $store_purchases)
    {
       return view('backend/finance-and-management/store-management/items-purchases-summary-vue');
    }

       public function itemsummary_init_vue(Request $request)
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
       if($request->cashier){
        $search.=' and store_purchases.created_by in ('.$request->cashier.') ';
    }if($request->category){
        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
    }if($request->sub_category){
        $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
    }
     if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }  if($request->inv){
            $search2.=' and store_purchases.id in ('.$request->inv.') ';
        }if($request->mem){
        $search.=' and store_purchases.customer_id in ('.$request->mem.') ';
    }
     if($request->discounted==1){
        $search.=' and store_purchases.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_purchases.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_purchases.approved=1 ';
        }if($request->status==2){
        $search.=' and store_purchases.approved=0 ';
        }
         if($request->location){
          $search3.=' and store_purchases_subs.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search3.=' and store_purchases_subs.department in ('.$request->department.') ';
        }

        if($request->r){

            $data['sales'] =\Illuminate\Support\Facades\DB::select(
                'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.purchase_price,

     concat("Invoice#: ",group_concat(DISTINCT store_purchases.id))        as cat,
             finance_ledger_people.person_name as sub,

      (store_purchases.grand_total)     as gtotal,
      (store_purchases.discount)     as disc,
       (store_purchases.tax)     as tax,
        (sum( store_purchases_subs.sub_total_price ))     as sub_total_price,
       (sum(store_purchases_subs.qty))                          as qty,
       group_concat(DISTINCT store_purchases.invoice_date)       as dda


from fnb_item_definitions
 left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_purchases_subs on store_purchases_subs.item_code = fnb_item_definitions.item_code  and store_purchases_subs.purchase_id in (select id from store_purchases where   deleted_at is null '.$search.' ) and
                                           DATE(store_purchases_subs.date) <= "'.$end_date.'" and
                                           DATE(store_purchases_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_purchases on store_purchases.id = store_purchases_subs.purchase_id

         left outer join finance_ledger_people on finance_ledger_people.id = store_purchases.customer_id

          where fnb_item_definitions.deleted_at is null and store_purchases.id is not null '.$search2.'
group by fnb_item_definitions.id, store_purchases.id
order by store_purchases.id,sub,fnb_item_definitions.item_details asc');
        }

 $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Purchases Summary With Items')){
 $data['exported']=1;
 }

     return $data;
}


public function purchaseserrors_vue(Request $request, store_purchases $store_purchases)
    {
       return view('backend/finance-and-management/store-management/purchases-errors-vue');
    }

       public function purchaseserrors_init_vue(Request $request)
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
       if($request->cashier){
        $search.=' and store_purchases.created_by in ('.$request->cashier.') ';
    }if($request->category){
        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
    }if($request->sub_category){
        $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
    }
     if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }  if($request->inv){
            $search2.=' and store_purchases.id in ('.$request->inv.') ';
        }if($request->mem){
        $search.=' and store_purchases.customer_id in ('.$request->mem.') ';
    }
     if($request->discounted==1){
        $search.=' and store_purchases.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_purchases.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_purchases.approved=1 ';
        }if($request->status==2){
        $search.=' and store_purchases.approved=0 ';
        }
         if($request->location){
          $search3.=' and store_purchases_subs.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search3.=' and store_purchases_subs.department in ('.$request->department.') ';
        }

        if($request->r){

            $data['sales'] =\Illuminate\Support\Facades\DB::select(
                'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,

     concat("Invoice#: ",group_concat(DISTINCT store_purchases.id))        as cat,
             finance_ledger_people.person_name as sub,

       group_concat(DISTINCT store_purchases.id)                    as purchase_id,
       (store_purchases.gross)     as gross,
     (store_purchases.grand_total)     as gtotal,

      (store_purchases.discount)     as disc,
       (store_purchases.tax)     as tax,
        (sum( store_purchases_subs.purchase_price ))     as purchase_price,
        (sum( store_purchases_subs.sub_total_price ))     as sub_total_price,
       (sum(store_purchases_subs.qty))                          as qty,
       group_concat(DISTINCT store_purchases.invoice_date)       as dda


from fnb_item_definitions
 left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_purchases_subs on store_purchases_subs.item_code = fnb_item_definitions.item_code  and store_purchases_subs.purchase_id in (select id from store_purchases where   deleted_at is null '.$search.' ) and
                                           DATE(store_purchases_subs.date) <= "'.$end_date.'" and
                                           DATE(store_purchases_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_purchases on store_purchases.id = store_purchases_subs.purchase_id

         left outer join finance_ledger_people on finance_ledger_people.id = store_purchases.customer_id

          where fnb_item_definitions.deleted_at is null and store_purchases.id is not null '.$search2.'
group by fnb_item_definitions.id, store_purchases.id
order by store_purchases.id,sub,fnb_item_definitions.item_details asc');
        }

 $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Purchases Errors')){
 $data['exported']=1;
 }
     return $data;
}




 public function dishbreakdownsale_vue(Request $request, store_sales $store_sales)
    {
         return view('backend/finance-and-management/store-management/dish-breakdown-store-sale-summary-vue');
    }

       public function dishbreakdownsale_init_vue(Request $request)
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
        if($request->cashier){
            $search.=' and store_sales.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }if($request->mem){
        $search.=' and store_sales.customer_id in ('.$request->mem.') ';
        }
        if($request->discounted==1){
        $search.=' and store_sales.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_sales.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_sales.approved=1 ';
        }if($request->status==2){
        $search.=' and store_sales.approved=0 ';
        }
         if($request->location){
          $search3.=' and store_sales_subs.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search3.=' and store_sales_subs.department in ('.$request->department.') ';
        }

        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.sale_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       (sum(store_sales_subs.qty))                          as qty,
        (sum( store_sales_subs.sub_total_price ))     as sub_total

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_sales_subs on store_sales_subs.item_code = fnb_item_definitions.item_code  and store_sales_subs.sale_id in (select id from store_sales where  deleted_at is null '.$search.' ) and
                                           DATE(store_sales_subs.date) <= "'.$end_date.'" and
                                           DATE(store_sales_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_sales on store_sales.id = store_sales_subs.sale_id
where fnb_item_definitions.deleted_at is null and store_sales.id is not null '.$search2.'
group by fnb_item_definitions.id,store_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc');
        }

  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Dish Breakdown Store Sale Summary')){
 $data['exported']=1;
 }
     return $data;
}


  public function closingstoresales_vue(Request $request, store_sales $store_sales)
    {
       return view('backend/finance-and-management/store-management/closing-store-sales-report-vue');
    }

       public function closingstoresales_init_vue(Request $request)
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
       if($request->cashier){
            $search.=' and store_sales.created_by in ('.$request->cashier.') ';
        }
        if($request->mem){
        $search.=' and store_sales.customer_id in ('.$request->mem.') ';
        }
        if($request->discounted==1){
        $search.=' and store_sales.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_sales.tax >0 ';
        }
          if($request->status==1){
        $search.=' and store_sales.approved=1 ';
        }if($request->status==2){
        $search.=' and store_sales.approved=0 ';
        }
        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select store_sales.id,

       (sum(store_sales.gross))                     as gross,
       (sum(store_sales.discount))                as disc,
         (sum(store_sales.tax))                  as tax,
          (sum(store_sales.grand_total))                 as grand,

  sum(transactions.trans_amount ) as paid_amount


from store_sales

left outer join transactions on transactions.trans_type=8 and transactions.type=2 and transactions.trans_type_id=store_sales.id and transactions.debit_or_credit=0 and transactions.deleted_at is null


where store_sales.id is not null and store_sales.deleted_at is null '.$search.'  and
                                           DATE(store_sales.invoice_date) <= "'.$end_date.'" and
                                           DATE(store_sales.invoice_date) >= "'.$start_date.'" '.$search3.'


');
 }

    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Closing Store Sales Report')){
 $data['exported']=1;
 }
     return $data;
}


 public function itemsalesummary_vue(Request $request, store_sales $store_sales)
    {
       return view('backend/finance-and-management/store-management/items-store-sale-summary-vue');
    }

       public function itemsalesummary_init_vue(Request $request)
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
       if($request->cashier){
        $search.=' and store_sales.created_by in ('.$request->cashier.') ';
    }if($request->category){
        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
    }if($request->sub_category){
        $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
    }
     if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }  if($request->inv){
            $search2.=' and store_sales.id in ('.$request->inv.') ';
        }if($request->mem){
        $search.=' and store_sales.customer_id in ('.$request->mem.') ';
    }
    if($request->mog!=2 && $request->mog!=null){
        $search.=' and store_sales.type='.$request->mog.' ';
    }
     if($request->discounted==1){
        $search.=' and store_sales.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_sales.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_sales.approved=1 ';
        }if($request->status==2){
        $search.=' and store_sales.approved=0 ';
        }
         if($request->location){
          $search3.=' and store_sales_subs.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search3.=' and store_sales_subs.department in ('.$request->department.') ';
        }

        if($request->r){

            $data['sales'] =\Illuminate\Support\Facades\DB::select(
                'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
        fnb_item_definitions.sale_price,

     concat("Invoice#: ",group_concat(DISTINCT store_sales.id))        as cat,

store_sales.type as type,
      hr_employments.name as employee,
      customers.customer_name as guest,
      concat(coalesce(memberships.first_name, ""), " ", coalesce(memberships.middle_name, ""), " ",
                 coalesce(memberships.applicant_name, "")) as member,

      (store_sales.grand_total)     as gtotal,
      (store_sales.discount)     as disc,
       (store_sales.tax)     as tax,
        (sum( store_sales_subs.sub_total_price ))     as sub_total_price,
       (sum(store_sales_subs.qty))                          as qty,
       group_concat(DISTINCT store_sales.invoice_date)       as dda


from fnb_item_definitions
 left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_sales_subs on store_sales_subs.item_code = fnb_item_definitions.item_code  and store_sales_subs.sale_id in (select id from store_sales where   deleted_at is null '.$search.' ) and
                                           DATE(store_sales_subs.date) <= "'.$end_date.'" and
                                           DATE(store_sales_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_sales on store_sales.id = store_sales_subs.sale_id

        left outer join memberships on memberships.id = store_sales.customer_id
        left outer join customers on customers.id = store_sales.customer_id
        left outer join hr_employments on hr_employments.id=store_sales.customer_id

          where fnb_item_definitions.deleted_at is null and store_sales.id is not null '.$search2.'
group by fnb_item_definitions.id, store_sales.id
order by store_sales.id,fnb_item_definitions.item_details asc');
        }

 $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Store Sales Summary With Items')){
 $data['exported']=1;
 }

     return $data;
}


public function storesaleserrors_vue(Request $request, store_sales $store_sales)
    {
       return view('backend/finance-and-management/store-management/store-sales-errors-vue');
    }

       public function storesaleserrors_init_vue(Request $request)
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
       if($request->cashier){
        $search.=' and store_sales.created_by in ('.$request->cashier.') ';
    }if($request->category){
        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
    }if($request->sub_category){
        $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
    }
     if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }  if($request->inv){
            $search2.=' and store_sales.id in ('.$request->inv.') ';
        }if($request->mem){
        $search.=' and store_sales.customer_id in ('.$request->mem.') ';
    }
    if($request->mog!=2 && $request->mog!=null){
        $search.=' and store_sales.type='.$request->mog.' ';
    }
     if($request->discounted==1){
        $search.=' and store_sales.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_sales.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_sales.approved=1 ';
        }if($request->status==2){
        $search.=' and store_sales.approved=0 ';
        }
         if($request->location){
          $search3.=' and store_sales_subs.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search3.=' and store_sales_subs.department in ('.$request->department.') ';
        }

        if($request->r){

            $data['sales'] =\Illuminate\Support\Facades\DB::select(
                'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
        fnb_item_definitions.sale_price,

     concat("Invoice#: ",group_concat(DISTINCT store_sales.id))        as cat,

    store_sales.type as type,
      hr_employments.name as employee,
      customers.customer_name as guest,

      concat(coalesce(memberships.first_name, ""), " ", coalesce(memberships.middle_name, ""), " ",
                 coalesce(memberships.applicant_name, "")) as member,

     group_concat(DISTINCT store_sales.id)                    as sale_id,
       (store_sales.gross)     as gross,
      (store_sales.grand_total)     as gtotal,
      (store_sales.discount)     as disc,
       (store_sales.tax)     as tax,
        (sum( store_sales_subs.sub_total_price ))     as sub_total_price,
       (sum(store_sales_subs.qty))                          as qty,
       group_concat(DISTINCT store_sales.invoice_date)       as dda


from fnb_item_definitions
 left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_sales_subs on store_sales_subs.item_code = fnb_item_definitions.item_code  and store_sales_subs.sale_id in (select id from store_sales where   deleted_at is null '.$search.' ) and
                                           DATE(store_sales_subs.date) <= "'.$end_date.'" and
                                           DATE(store_sales_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_sales on store_sales.id = store_sales_subs.sale_id

        left outer join memberships on memberships.id = store_sales.customer_id
        left outer join customers on customers.id = store_sales.customer_id
         left outer join hr_employments on hr_employments.id=store_sales.customer_id

          where fnb_item_definitions.deleted_at is null and store_sales.id is not null '.$search2.'
group by fnb_item_definitions.id, store_sales.id
order by store_sales.id,fnb_item_definitions.item_details asc');
        }

 /*   if(group_concat(DISTINCT store_sales.type) = 0,
          concat(coalesce(memberships.first_name, ""), " ", coalesce(memberships.middle_name, ""), " ",
                 coalesce(memberships.applicant_name, "")), customers.customer_name) as sub,*/

 $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Store Sales Errors')){
 $data['exported']=1;
 }

     return $data;
}




 public function issuenotesummary_vue(Request $request, store_issue_notes $store_issue_notes)
    {
         return view('backend/finance-and-management/store-management/issue-note-summary-vue');
    }

       public function issuenotesummary_init_vue(Request $request)
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
        if($request->cashier){
            $search.=' and store_issue_notes.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }
        if($request->discounted==1){
        $search.=' and store_issue_notes.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_issue_notes.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_issue_notes.approved=1 ';
        }if($request->status==2){
        $search.=' and store_issue_notes.approved=0 ';
        }
         if($request->location){
          $search.=' and store_issue_notes.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search.=' and store_issue_notes.department in ('.$request->department.') ';
        }

        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.purchase_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       store_departments.desc                      as department,
       fnb_restaurant_locations.desc as location,
       coa_accounts.name as unit,
       (sum(store_issue_notes_subs.qty))                          as qty,
        (sum( store_issue_notes_subs.sub_total_price ))     as sub_total

from fnb_item_definitions

         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_issue_notes_subs on store_issue_notes_subs.item_code = fnb_item_definitions.item_code  and store_issue_notes_subs.issue_id in (select id from store_issue_notes where  deleted_at is null '.$search.' ) and
                                           DATE(store_issue_notes_subs.date) <= "'.$end_date.'" and
                                           DATE(store_issue_notes_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_issue_notes on store_issue_notes.id = store_issue_notes_subs.issue_id
         left outer join store_departments on store_departments.id = store_issue_notes.department
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = store_issue_notes.store_location
         left outer join coa_accounts on coa_accounts.code = store_issue_notes.unit
         
where fnb_item_definitions.deleted_at is null and store_issue_notes.id is not null '.$search2.'
group by store_departments.id
order by store_departments.desc asc');
        }

  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();


if(Auth::user()->can('Export Store Issue Note Summary')){
 $data['exported']=1;
 }

     return $data;
}

    public function itemissuesummary_vue(Request $request, store_issue_notes $store_issue_notes)
    {
         return view('backend/finance-and-management/store-management/item-issue-summary-vue');
    }

       public function itemissuesummary_init_vue(Request $request)
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
        if($request->cashier){
            $search.=' and store_issue_notes.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }
        if($request->discounted==1){
        $search.=' and store_issue_notes.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_issue_notes.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_issue_notes.approved=1 ';
        }if($request->status==2){
        $search.=' and store_issue_notes.approved=0 ';
        }
         if($request->location){
          $search.=' and store_issue_notes.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search.=' and store_issue_notes.department in ('.$request->department.') ';
        }

        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.purchase_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       (sum(store_issue_notes_subs.qty))                          as qty,
        (sum( store_issue_notes_subs.sub_total_price ))     as sub_total

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_issue_notes_subs on store_issue_notes_subs.item_code = fnb_item_definitions.item_code and store_issue_notes_subs.issue_id in (select id from store_issue_notes where  deleted_at is null '.$search.' ) and
                                           DATE(store_issue_notes_subs.date) <= "'.$end_date.'" and
                                           DATE(store_issue_notes_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_issue_notes on store_issue_notes.id = store_issue_notes_subs.issue_id
where fnb_item_definitions.deleted_at is null and store_issue_notes.id is not null '.$search2.'
group by fnb_item_definitions.id,store_issue_notes_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc');
        }

  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Item Issue Summary')){
 $data['exported']=1;
 }
 

     return $data;
}

public function issuesummarydetail_vue(Request $request, store_issue_notes $store_issue_notes)
    {
         return view('backend/finance-and-management/store-management/issue-note-summary-detail-vue');
    }

       public function issuesummarydetail_init_vue(Request $request)
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
        if($request->cashier){
            $search.=' and store_issue_notes.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }
        if($request->discounted==1){
        $search.=' and store_issue_notes.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_issue_notes.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_issue_notes.approved=1 ';
        }if($request->status==2){
        $search.=' and store_issue_notes.approved=0 ';
        }
         if($request->location){
          $search.=' and store_issue_notes.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search.=' and store_issue_notes.department in ('.$request->department.') ';
        }

        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.purchase_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       (sum(store_issue_notes_subs.qty))                          as qty,
        (sum( store_issue_notes_subs.sub_total_price ))     as sub_total

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_issue_notes_subs on store_issue_notes_subs.item_code = fnb_item_definitions.item_code  and store_issue_notes_subs.issue_id in (select id from store_issue_notes where  deleted_at is null '.$search.' ) and
                                           DATE(store_issue_notes_subs.date) <= "'.$end_date.'" and
                                           DATE(store_issue_notes_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_issue_notes on store_issue_notes.id = store_issue_notes_subs.issue_id
where fnb_item_definitions.deleted_at is null and store_issue_notes.id is not null '.$search2.'
group by fnb_item_definitions.id,store_issue_notes_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc');
        }

  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Issue Note Summary Detail')){
 $data['exported']=1;
 }
 

     return $data;
}


       public function itemissuedetail_vue(Request $request, store_issue_notes $store_issue_notes)
    {
         return view('backend/finance-and-management/store-management/item-issue-detail-vue');
    }

       public function itemissuedetail_init_vue(Request $request)
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
        if($request->cashier){
            $search.=' and store_issue_notes.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }
        if($request->discounted==1){
        $search.=' and store_issue_notes.discount >0 ';
        }if($request->discounted==2){
        $search.=' and store_issue_notes.tax >0 ';
        }
         if($request->status==1){
        $search.=' and store_issue_notes.approved=1 ';
        }if($request->status==2){
        $search.=' and store_issue_notes.approved=0 ';
        }
         if($request->location){
          $search.=' and store_issue_notes.store_location in ('.$request->location.') ';
        }
        if($request->department){
          $search.=' and store_issue_notes.department in ('.$request->department.') ';
        }

        if($request->r){

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.purchase_price,
       fnb_restaurant_locations.desc                               as cat,
       store_restaurant_section_definitions.desc                         as sub,
       (sum(store_issue_notes_subs.qty))                          as qty,
       (sum( store_issue_notes_subs.sub_total_price ))     as sub_total,
        store_departments.desc                      as department

      from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join store_issue_notes_subs on store_issue_notes_subs.item_code = fnb_item_definitions.item_code  and store_issue_notes_subs.issue_id in (select id from store_issue_notes where  deleted_at is null '.$search.' ) and
                                           DATE(store_issue_notes_subs.date) <= "'.$end_date.'" and
                                           DATE(store_issue_notes_subs.date) >= "'.$start_date.'" '.$search3.'
         left outer join store_issue_notes on store_issue_notes.id = store_issue_notes_subs.issue_id
left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = store_issue_notes.store_location
 left outer join store_departments on store_departments.id = store_issue_notes.department
         left outer join store_restaurant_section_definitions on store_restaurant_section_definitions.id = store_departments.section
where fnb_item_definitions.deleted_at is null and store_issue_notes.id is not null '.$search2.'
group by cat,sub,store_departments.id
order by sub,store_departments.desc asc');
        }

  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
   $data['locations']= fnb_restaurant_location::where('status',1)->get();
  $data['departments']= store_department::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

if(Auth::user()->can('Export Item Issue Detail')){
 $data['exported']=1;
 }
 
     return $data;
}



    // MONTHLY REPORT
       public function monthly_index_vue(Request $request, store_transactions $store_transactions)
    {
         return view('backend/finance-and-management/store-management/monthly-report-vue');
    }

       public function monthly_init_vue(Request $request)
    {
      $data=[];
        $search='';
        $search2='';
        $search3='';


    if($request->get('start_date')){
        $search.=' and Date(store_purchases_subs.date)>="'.$request->get('start_date').'" ';
        $search2.=' and Date(store_sales_subs.date)>="'.$request->get('start_date').'" ';
        $search3.=' and Date(finance_expense.expense_date)>="'.$request->get('start_date').'" ';

        }
        if($request->get('end_date')){
            $search.=' and Date(store_purchases_subs.date)<="'.$request->get('end_date').'" ';
            $search2.=' and Date(store_sales_subs.date)<="'.$request->get('end_date').'" ';
            $search3.=' and Date(finance_expense.expense_date)<="'.$request->get('end_date').'" ';

        }
        if($request->get('unitsearch')){
    $search.=' and coa_accounts.code ="'.$request->get('unitsearch').'"';
    $search2.=' and coa_accounts.code ="'.$request->get('unitsearch').'"';
    $search3.=' and coa_accounts.code ="'.$request->get('unitsearch').'"';

        }


if($request->get('start_date') && $request->get('end_date')){


        $data['purchases'] =\Illuminate\Support\Facades\DB::select(
      'select store_purchases_subs.*,
        coa_accounts.name                      as unit,
        coa_accounts_controls.name as account
,
finance_ledger_people.person_name as supplier,
store_purchases.customer_id

      from store_purchases_subs


         left outer join store_purchases on store_purchases.id = store_purchases_subs.purchase_id
         left outer join coa_accounts on coa_accounts.code = store_purchases.unit
          left outer join coa_accounts_controls on coa_accounts_controls.code = store_purchases.account
         left outer join finance_ledger_people on finance_ledger_people.id =store_purchases.customer_id 

where store_purchases.deleted_at is null and store_purchases_subs.purchase_id is not null '.$search.'
group by store_purchases_subs.id
order by store_purchases_subs.id asc');
     
  
  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select store_sales_subs.*,
        coa_accounts.name                      as unite,
        coa_accounts_controls.name as account,
             customers.guest_type                                  as cgt,
 guest_types.desc as guesttype,
      memberships.mem_no as mem_no,
      mem_statuses.desc as activity,
      customer_name as customer,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
   finance_ledger_people.person_name as person_name,
      finance_ledger_people.id as person_id,
      store_sales.*

      from store_sales_subs


         left outer join store_sales on store_sales.id = store_sales_subs.sale_id
         left outer join coa_accounts on coa_accounts.code = store_sales.unit
          left outer join coa_accounts_controls on coa_accounts_controls.code = store_sales.account
        


left outer join hr_employments on hr_employments.id=store_sales.customer_id
left outer join memberships on memberships.id = store_sales.customer_id and memberships.deleted_at is null
left outer join mem_statuses on mem_statuses.id=memberships.active and mem_statuses.status=1
left outer join customers on customers.id =store_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type
  left outer join finance_ledger_people on finance_ledger_people.id = store_sales.customer_id


where store_sales.deleted_at is null and store_sales_subs.sale_id is not null '.$search2.'
group by store_sales_subs.id
order by store_sales_subs.id asc');


   $data['expenses'] =\Illuminate\Support\Facades\DB::select(
      'select finance_expense.*,
        coa_accounts.name                      as unit,
        coa_accounts_controls.name as account,
         finance_ledger_people.person_name as supplier


      from finance_expense


     
         left outer join coa_accounts on coa_accounts.code = finance_expense.unit
          left outer join coa_accounts_controls on coa_accounts_controls.code = finance_expense.code
         left outer join finance_ledger_people on finance_ledger_people.id=finance_expense.supplier_id

where finance_expense.deleted_at is null and finance_expense.status is null '.$search3.'
group by finance_expense.id
order by finance_expense.id asc');


     }



      $data['ccs']=coa_account::get();
  $data['searchedunits']=coa_account::whereNotNull('desc')->get();

     return $data;
}
    // MONTHLY REPORT








     public function issue_closing_stock_vue(Request $request, fnb_item_definition $fnb_item_definition)
    {
       return view('backend/finance-and-management/store-management/item-issue-closing-stock-vue');
    }

       public function issue_closing_stock(Request $request)
    {
 $search='';
 

if($request->get('start_date')){
    $search.=' and store_transactions.date >="'.$request->get('start_date').'"';
}
if($request->get('end_date')){
    $search.=' and store_transactions.date <="'.$request->get('end_date').'"';

}
if($request->get('unitsearch')){
    $search.=' and store_transactions.unit ="'.$request->get('unitsearch').'"';

}
 
//   
  //sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.issue_price,0)) as purchases,
//  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.issue_price,0)) as sales,


/*


  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.issue_price,0)) *  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.qty,0)) as purchases,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.issue_price,0)) *   sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sales,
  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.qty,0)) as pqty,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sqty,*/
         $data['items'] =\Illuminate\Support\Facades\DB::select(

      'select 
      store_transactions.*,
     group_concat( store_transactions.unit)               as unitcode,
      fnb_item_definitions.id,
 
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
 
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
        fnb_item_definitions.purchase_price,
        fnb_item_definitions.sale_price,
      
        fnb_item_definitions.status as activestatus,
   

  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.issue_price*store_transactions.qty,0)) as purchases,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.issue_price*store_transactions.qty,0)) as sales,
  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.qty,0)) as pqty,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sqty,

        store_departments.desc as department,
        fnb_restaurant_locations.desc as store_location

FROM store_transactions


left outer join fnb_item_definitions on fnb_item_definitions.item_code=store_transactions.item_code
 left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category

 left outer join store_departments on store_departments.id = store_transactions.department
 left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = store_transactions.store_location

where store_transactions.deleted_at is null   and store_transactions.is_active=1  and store_transactions.type in (3,2)  '.$search.' group by fnb_item_definitions.id order by fnb_item_definitions.id desc ');


 /* $data['items'] =\Illuminate\Support\Facades\DB::select(

      'select fnb_item_definitions.id,
      fnb_item_definitions.remarks,
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
      fnb_item_manufacturers.desc as manufacturer ,
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
         fnb_item_definitions.purchase_price,
        fnb_item_definitions.sale_price,
         fnb_product_classifications.desc as product,
        fnb_item_definitions.status as activestatus,
        sum(store_transactions.issue_price) as purchases,
         sum(st.issue_price) as sales

FROM fnb_item_definitions


left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category
left outer join fnb_item_manufacturers on fnb_item_manufacturers.id=fnb_item_definitions.manufacturer
left outer join fnb_product_classifications on fnb_product_classifications.id=fnb_item_definitions.product_classification
left outer join store_transactions on store_transactions.item_code=fnb_item_definitions.item_code and store_transactions.in_or_out=1 and store_transactions.type=3 and store_transactions.is_active=1
left outer join store_transactions st on st.item_code=fnb_item_definitions.item_code and st.in_or_out=0 and store_transactions.type=2 and store_transactions.is_active=1

where fnb_item_definitions.deleted_at is null group by fnb_item_definitions.id order by fnb_item_definitions.id desc');*/

  $data['cats']=fnb_item_category::where('status',1)->get();
  $data['subcats']=fnb_item_sub_category::where('status',1)->get();
  $data['item_defs']=fnb_item_definition::get();
$data['ccs']=coa_account::get();
  $data['searchedunits']=coa_account::whereNotNull('desc')->get();
  

     return $data;
}



    public function details_closing_stock_vue(Request $request, fnb_item_definition $fnb_item_definition)
    {
       return view('backend/finance-and-management/store-management/item-issue-closing-stock-details-vue');
    }

       public function details_closing_stock(Request $request)
    {


        //  store_transactions.purchase_price,
//        store_transactions.sale_price,


 $data['items'] =\Illuminate\Support\Facades\DB::select(

      'select 
      store_transactions.*,
    group_concat( store_transactions.unit)               as unitcode,
 
      fnb_item_definitions.id,
 
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
 
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
      
 store_transactions.purchase_price as pap,


 sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.issue_price,0)) * sum(if(store_transactions.in_or_out = 1 and store_transactions.type=3,store_transactions.qty,0))  as purchase_price,
 sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.issue_price,0)) *   sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sale_price,

   coa_accounts.name as company,
        store_transactions.qty as qty,
      
        fnb_item_definitions.status as activestatus,
        store_transactions.issue_price as price,
        store_departments.desc as department,
        stu.desc as store_location

FROM store_transactions


left outer join fnb_item_definitions on fnb_item_definitions.item_code=store_transactions.item_code
 left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category

 left outer join store_departments on store_departments.id = store_transactions.department
 left outer join fnb_item_categories stu on stu.id = store_transactions.store_location 
 left outer join coa_accounts on coa_accounts.code = store_transactions.unit


where store_transactions.deleted_at is null   and store_transactions.is_active=1  and store_transactions.type in (3,2) group by store_transactions.id order by store_transactions.id ASC ');
 
  $data['locations']= fnb_item_category::where('status',1)->get();
   $data['departments']=store_department::where('status',1)->get();
  $data['cats']=fnb_item_category::where('status',1)->get();
  $data['subcats']=fnb_item_sub_category::where('status',1)->get();
  $data['item_defs']=fnb_item_definition::get();
$data['ccs']=coa_account::get();
  $data['searchedunits']=coa_account::whereNotNull('desc')->get();
  
  
     return $data;
}



   public function sale_closing_details_vue(Request $request, fnb_item_definition $fnb_item_definition)
    {
       return view('backend/finance-and-management/store-management/item-sale-closing-stock-details-vue');
    }

       public function sale_closing_details(Request $request)
    {

 $data['items'] =\Illuminate\Support\Facades\DB::select(

      'select 
      store_transactions.*,
    group_concat( store_transactions.unit)               as unitcode,
 
      fnb_item_definitions.id as id,
 
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
 
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
        store_transactions.purchase_price as pap,




 sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.purchase_price,0)) * sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.qty,0))  as purchase_price,
 sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.sale_price,0)) *   sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sale_price,


  
        store_transactions.qty as qty,
      
        fnb_item_definitions.status as activestatus,
       
        coa_accounts.name as company,
if(store_transactions.type=2,store_sales.type,2) as mogtype,
  customers.guest_type                                  as cgt,
        guest_types.desc as guesttype,
      memberships.mem_no as mem_no,
       memberships.id as memid,
       mem_statuses.desc as activity,
      customers.customer_name as customer,
        customers.id as customerid,
      hr_employments.name as employee,
       hr_employments.name as employeeid,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  finance_ledger_people.person_name as person_name,
  finance_ledger_people.id as personid



FROM store_transactions

left outer join store_sales on store_sales.id=store_transactions.type_id and store_transactions.type=2
left outer join store_purchases on store_purchases.id=store_transactions.type_id   and store_transactions.type=1 

left outer join hr_employments on hr_employments.id=store_sales.customer_id
left outer join memberships on memberships.id = store_sales.customer_id and memberships.deleted_at is null
left outer join customers on customers.id =store_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type
left outer join finance_ledger_people on finance_ledger_people.id = store_purchases.customer_id
left outer join mem_statuses on mem_statuses.id=memberships.active 


left outer join fnb_item_definitions on fnb_item_definitions.item_code=store_transactions.item_code
 left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category

 left outer join coa_accounts on coa_accounts.code = store_transactions.unit


where store_transactions.deleted_at is null   and store_transactions.is_active=1 and store_transactions.type in (1,2) group by store_transactions.id order by store_transactions.id ASC ');

  $data['companies']=coa_account::wherenotnull('desc')->get();
  $data['cats']=fnb_item_category::where('status',1)->get();
  $data['subcats']=fnb_item_sub_category::where('status',1)->get();
  $data['item_defs']=fnb_item_definition::get();
 $data['ccs']=coa_account::get();
  $data['searchedunits']=coa_account::whereNotNull('desc')->get();
  

     return $data;
}


     public function sale_closing_stock_vue(Request $request, fnb_item_definition $fnb_item_definition)
    {
       return view('backend/finance-and-management/store-management/item-sale-closing-stock-vue');
    }

       public function sale_closing_stock(Request $request)
    {
 
   $search='';
 

if($request->get('start_date')){
    $search.=' and store_transactions.date >="'.$request->get('start_date').'"';
}
if($request->get('end_date')){
    $search.=' and store_transactions.date <="'.$request->get('end_date').'"';

}
if($request->get('mog')==2){
    $search.=' and store_transactions.type =1';

}
if($request->get('unitsearch')){
    $search.=' and store_transactions.unit ="'.$request->get('unitsearch').'"';

}
if($request->get('mog')!=2 && $request->get('mog')!=6){
    $search.=' and store_sales.type <="'.$request->get('mog').'"';

}
if($request->get('mog')==6){
    $search.=' and store_transactions.deleted_at is null';

}

if($request->get('mgid')){
if($request->get('mog')==2){
     $search.=' and store_purchases.customer_id <="'.$request->get('mgid').'"';

}
if($request->get('mog')!=2 && $request->get('mog')!=6){
    $search.=' and store_sales.customer_id <="'.$request->get('mgid').'"';

}
}


//
  //sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.purchase_price,0)) as purchases,
 // sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.sale_price,0)) as sales,


//sum(fnb_item_definitions.purchase_price)* sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.qty,0))  as purchases,
 // sum(fnb_item_definitions.sale_price) *   sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sales,
 $data['items'] =\Illuminate\Support\Facades\DB::select(
 
      'select 
      store_transactions.*,
        group_concat( store_transactions.unit)               as unitcode,
 

      fnb_item_definitions.id as id,
 
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
 
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
fnb_item_definitions.purchase_price,



 sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.purchase_price*store_transactions.qty,0)) as purchases,
 sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.sale_price*store_transactions.qty,0)) as sales,
 
  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.qty,0)) as pqty,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sqty,

    
        fnb_item_definitions.status as activestatus,
       
        store_departments.desc as department,
        fnb_restaurant_locations.desc as store_location,

        if(store_transactions.type=2,store_sales.type,2) as mogtype,
  customers.guest_type                                  as cgt,
        guest_types.desc as guesttype,
      memberships.mem_no as mem_no,
       memberships.id as memid,
       mem_statuses.desc as activity,
      customers.customer_name as customer,
        customers.id as customerid,
      hr_employments.name as employee,
       hr_employments.name as employeeid,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  finance_ledger_people.person_name as person_name,
  finance_ledger_people.id as personid

FROM store_transactions


left outer join store_sales on store_sales.id=store_transactions.type_id and store_transactions.type=2
left outer join store_purchases on store_purchases.id=store_transactions.type_id   and store_transactions.type=1 

left outer join hr_employments on hr_employments.id=store_sales.customer_id
left outer join memberships on memberships.id = store_sales.customer_id and memberships.deleted_at is null
left outer join customers on customers.id =store_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type
left outer join finance_ledger_people on finance_ledger_people.id = store_purchases.customer_id
left outer join mem_statuses on mem_statuses.id=memberships.active 


left outer join fnb_item_definitions on fnb_item_definitions.item_code=store_transactions.item_code
 left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category

 left outer join store_departments on store_departments.id = store_transactions.department
 left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = store_transactions.store_location

where store_transactions.deleted_at is null   and store_transactions.is_active=1 and store_transactions.type in (1,2) '.$search.'  group by fnb_item_definitions.id order by fnb_item_definitions.id desc '); 
/* $data['items'] =\Illuminate\Support\Facades\DB::select(

      'select store_transactions.*,  
      fnb_item_definitions.id,
      fnb_item_definitions.remarks,
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
      fnb_item_manufacturers.desc as manufacturer ,
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
         fnb_item_definitions.purchase_price,
        fnb_item_definitions.sale_price,
         fnb_product_classifications.desc as product,
        fnb_item_definitions.status as activestatus,
     sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.purchase_price,0)) as purchases,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.sale_price,0)) as sales,
  sum(if(store_transactions.in_or_out = 1 and store_transactions.type=1,store_transactions.qty,0)) as pqty,
  sum(if(store_transactions.in_or_out = 0 and store_transactions.type=2,store_transactions.qty,0)) as sqty

FROM fnb_item_definitions


left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category
left outer join fnb_item_manufacturers on fnb_item_manufacturers.id=fnb_item_definitions.manufacturer
left outer join fnb_product_classifications on fnb_product_classifications.id=fnb_item_definitions.product_classification
left outer join store_transactions on store_transactions.item_code=fnb_item_definitions.item_code   and store_transactions.type in (1,2) and store_transactions.is_active=1
 

where fnb_item_definitions.deleted_at is null and store_transactions.id is not null group by store_transactions.item_code order by fnb_item_definitions.id desc'); 
*/
  $data['cats']=fnb_item_category::where('status',1)->get();
  $data['subcats']=fnb_item_sub_category::where('status',1)->get();
  $data['item_defs']=fnb_item_definition::get();
  $data['ccs']=coa_account::get();
  $data['searchedunits']=coa_account::whereNotNull('desc')->get();
  
     return $data;
}


// REPORTS


}
