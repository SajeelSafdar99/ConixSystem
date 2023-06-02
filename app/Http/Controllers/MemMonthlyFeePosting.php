<?php

namespace App\Http\Controllers;
use App\Illuminate\Pagination\Paginator;
use App\Illuminate\Pagination\LengthAwarePaginator;
use App\finance_invoice;
use App\finance_invoice_charges_type;
use App\mem_status;
use Illuminate\Http\Request;
use DataTables;
use App\admin_company_profile;
use App\customer;
use App\membership;
use App\mem_family;
use App\finance_invoice_subs;
use App\sports_subscription;
use Illuminate\Support\Facades\Response;
use Session;
use App\room_booking;
use App\transactions;
use App\trans_type;
use App\trans_relations;
use App\finance_cash_receipt;
use App\fnb_predefined_value;
use DB;
use Carbon\Carbon;

class MemMonthlyFeePosting extends Controller
{
    public function create(Request $request)
    {
        $lastval = finance_invoice::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['invoice_update'] = '';


 $customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
$data['main_types']=trans_type::where('type',1)->get();
$data['subscription_type']=trans_type::where('type',3)->get();
$data['finance_invoice_charges_type']=trans_type::where('type',2)->get();
$data['status']=mem_status::all();

 $data['receiptstatus']   = 1;
        return view('backend/finance-and-management.maintenance-fee-posting.maintenance-fee-posting-aeu', $data);
    }



      public function store( $request)
    {


//dd($request);
        $invoice_no=finance_invoice::get()->last();
//        dd($invoice_no->toArray());
        if($invoice_no){
          $invoice_no=  $invoice_no->id+1;
        }
        else{
            $invoice_no=1;
        }

        $is_membership=array_search('3',$request['charges_type']);
        $is_maintenance=array_search('4',$request['charges_type']);
if($is_membership!==false){
    $days=$request['days'][$is_membership];
    if(!$days){
      $thedays = 1;
    }
    else{
      $thedays = $days;
    }
    $qty=$request['qty'][$is_membership];
     if(!$qty){
      $theqty = 1;
    }
    else{
      $theqty = $qty;
    }
    $request['totalM']=$request['totalM']==''?0:$request['totalM'];
    $request['totalM']=$request['totalM']==null?0:$request['totalM'];

    /*$membershipfee=round(abs(($request['totalM']/30)*$thedays*$theqty));*/
    $membershipfee=round(((abs(($request['totalM']/30)*$thedays*$theqty)/30)*100)/100);

    $request['final_total']=$request['final_total']+$membershipfee;
    $request['grand_total']=$request['grand_total']+$membershipfee;
    $request['total'][$is_membership]=$membershipfee;
    $request['charges_amount'][$is_membership]=$request['totalM'];
}

if($is_maintenance!==false){
    $days=$request['days'][$is_maintenance];
    if(!$days){
      $thedays = 1;
    }
    else{
      $thedays = $days;
    }
    $qty=$request['qty'][$is_maintenance];
     if(!$qty){
      $theqty = 1;
    }
    else{
      $theqty = $qty;
    }
    $request['total_maintenance']=$request['total_maintenance']==''?0:$request['total_maintenance'];
    $request['total_maintenance']=$request['total_maintenance']==null?0:$request['total_maintenance'];

    $membershipfee=round(((abs((str_replace(',','',$request['total_maintenance']))*$thedays*$theqty)/30)*100)/100);
//    dd($membershipfee);
    $request['final_total']=$request['final_total']+$membershipfee;
    $request['grand_total']=$request['grand_total']+$membershipfee;
    $request['total'][$is_maintenance]=$membershipfee;
    $request['charges_amount'][$is_maintenance]=$request['total_maintenance'];
    $request['per_day_amount'][$is_maintenance]=(($request['total_maintenance']/30)*100)/100;

}
          $chargestypes=$request['charges_type'];
          $startdate=$request['start_date'];
          $enddate=$request['end_date'];
          $days=$request['days'];
          $chargesamount=$request['charges_amount'];
          $perdayamount=$request['per_day_amount'];
          $dis=0;
              if($request['discount_amount']){
                $dis=$request['discount_amount'];
              }
              if($request['discount_percentage']){
                $dis=$request['total'][0]*($request['discount_percentage']/100);
              }$ov=0;
              if($request['extra_charges']){
                  $ov=$request['extra_charges'];
              }
              if($request['extra_percentage']){
                  $ov=$request['total'][0]*($request['extra_percentage']/100);

                  $request['extra_charges']=$ov;
              }
          $total=(float) $request['total'][0]+ (float) $ov- (float) $dis;
              $tax=0;
              if($request['tax_charges']){
                  $tax=$request['tax_charges'];
              }
              if($request['tax_percentage']){
                  $tax=$request['total'][0]*($request['tax_percentage']/100);
              }
               if(!$request['invoice_date']){
              $request['invoice_date']= Carbon::now()->format('d-m-Y');
              }
          $total=$total+ (float) $tax;
          $qty=$request['qty'];


          $i=0;

 
        $data=[

            'invoice_no' =>  $invoice_no,
            'invoice_date' => formatDate($request['invoice_date']),
            'invoice_type' => 0,
            'name' => $request['name'],

            'member_id'     =>  $request['member_id'],
            'mem_no' => $request['mem_no'],

            'address' => $request['address'],
            'cnic' => $request['cnic'],
            'contact' => $request['contact'],
            'email' => $request['email'],

            'total' => $request['final_total'],
            'discount_amount' => $request['discount_amount'],

             'discount_percentage' => $request['discount_percentage'],

            'discount_details' => $request['discount_details'],

            'extra_charges' => $request['extra_charges'],

             'extra_percentage' => $request['extra_percentage'],

            'extra_details' => $request['extra_details'],

            'tax_charges' => $request['tax_charges'],

             'tax_percentage' => $request['tax_percentage'],

            'tax_details' => $request['tax_details'],

            'grand_total' => $request['grand_total'],
/*
             'amount_in_words' => $request['amount_in_words'],*/

//            'amount_in_words' amount_in_words$request['->'],
            'comments' => $request['comments'],
            'is_auto_generated' => 1,
            'charges_type'=>$chargestypes[$i],
            'charges_amount'=>$chargesamount[$i],
            'per_day_amount'=>$perdayamount[$i],
            'start_date'=>formatDate($startdate[$i]),
            'end_date'=>formatDate($enddate[$i]),
            'days'=>$days[$i],
            'qty'=>$qty[$i],
            'sub_total'=> $request['final_total'],
//            'member'=>1

        ];
          $curMonth = date("m", strtotime(formatDate($startdate[$i])));
          $curYear = date("Y", strtotime($startdate[$i]));
          $curQuarter = ceil($curMonth/3);
          $alreadyexist=finance_invoice::whereRaw("quarter(start_date)=$curQuarter and year(start_date)=$curYear and  charges_type=4  and member_id=".$request['member_id'])->first();
          if(!$alreadyexist){

              $invoices = finance_invoice::create($data);

//dd($request);

//sending into transactions table
        $coa_code='';
         $cati='';
          $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }
       

       if(membership::where('id',$request['member_id'])->exists()){
           $arr_coa=membership::where('id',$request['member_id'])->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa_code=$arr_coa[0];
            $cati =  coaparent($coa_code);
          }else{
            $coa_code=null;
            $cati = memcategoryname($request['member_id']);
          }
        }

              $tdata=[
            'type'=>1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $invoices['charges_type'],
            'trans_type_id' =>  $invoices['id'],
            'trans_amount' =>  $request['grand_total'],
            'trans_moc_type' =>  0,
            'trans_moc' =>  $request['member_id'],
            'is_active' =>  1,
            'date' => $startdate[$i]!=null?formatDate($startdate[$i]): formatDate($request['invoice_date']),
            'trans_moc_category' => $cati,
            'account'=>transTypesCoa($invoices['charges_type']),
               'trans_coa'=>$coa_code,
               'unit'=>$ccc,

              ];

              $tid=  transactions::create($tdata);
//sending into transactions table
          }











    }


     function calculateextracharges($id){
      $charges=finance_invoice_charges_type::where('id',$id)->first();
      return $charges->charges;

      $charges=sports_subscription::where('id',$id)->first();
      return $charges->charges;
    }

    public function storeall(Request $request){
   //     dd(12323);
        $_members=membership::select('mem_no','id','cur_address','cnic','mob_a','personal_email','applicant_name','total','total_maintenance');
        if($request->get('to')!=''){
            $_members->where('id','<=',$request->get('to'));
        }
        if($request->get('from')!=''){
            $_members->where('id','>=',$request->get('from'));

        } if($request->get('status')){
            $_members->whereIn('active',$request->get('status'));

        }
        $members=$_members->get();
        $count=count($members);
        Session::put('progress', 0);
        Session::save(); // Remember to call save()
        $i=0;
        foreach($members as $member){
            $i++;
          $r=[];
          $r['mem_no']=$member->mem_no;
          $r['member_id']=$member->id;
          $r['address']=$member->cur_address;
          $r['cnic']=$member->cnic;
          $r['contact']=$member->mob_a;
          $r['email']=$member->personal_email;
          $r['name']=$member->applicant_name;
          $r['totalM']=$member->total;
          $r['total_maintenance']=$member->total_maintenance;
          $d=array_merge($r,$request->except('_token'));
            $this->store($d);
            Session::put('progress', (($i/$count)*100).'-'.$count.'-'.$i);
            Session::save();
//          dd($d);
        }

    }public function previewAll(Request $request){
   //     dd(12323);
    $lastval = finance_invoice::withTrashed()->latest('id')->first();
    $num     = 0;

    if ($lastval) {
        $num                      = $lastval->id + 1;
        $data['increment_number'] = $num;

    } else {
        $num                      = 1;
        $data['increment_number'] = $num;
    }
    $data['init']                = 0;
    $data['invoice_update'] = '';


    $customernumber=$request->customerid;
    $MOC=$request->MOC;
    if($MOC==1){
        //
    }
    else{
        $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

    }

    $data['main_types']=trans_type::where('type',1)->get();
    $data['subscription_type']=trans_type::where('type',3)->get();
    $data['finance_invoice_charges_type']=trans_type::where('type',2)->get();
    $data['status']=mem_status::all();

    $data['receiptstatus']   = 1;
        $_members=membership::select('mem_no','id','cur_address','cnic','mob_a','personal_email','applicant_name','total','total_maintenance','active')->with('mem_status');
        if($request->get('to')!=''){
            $_members->where('id','<=',$request->get('to'));
        }
        if($request->get('from')!=''){
            $_members->where('id','>=',$request->get('from'));

        } if($request->get('status')){
            $_members->whereIn('active',$request->get('status'));

        }
        $members=$_members->get();
        $count=count($members);

        $i=0;
        $d=[];

        foreach($members as $member){

            $curMonth = date("m", strtotime(formatDate($request->start_date[0])));
          //  dd($curMonth);
            $curYear = date("Y", strtotime($request->start_date[0]));
            $curQuarter = ceil($curMonth/3);
            $i++;

            $alreadyexist=finance_invoice::whereRaw("quarter(start_date)=$curQuarter and year(start_date)=$curYear and charges_type=4 and  member_id=".$member->id)->first();
            if($alreadyexist){

                continue;
            }
            else{
                $r=[];

                $r['mem_no']=$member->mem_no;
                $r['member_id']=$member->id;
                $r['address']=$member->cur_address;
                $r['cnic']=$member->cnic;
                $r['contact']=$member->mob_a;
                $r['email']=$member->personal_email;
                $r['name']=$member->applicant_name;
                $r['active']=$member->mem_status;
                $r['totalM']=$member->total;
                $r['total_maintenance']=$member->total_maintenance;
                $d[]=array_merge($r,$request->except('_token'));

            }

//
        }
        $data['r']=$d;
                return view('backend/finance-and-management.maintenance-fee-posting.maintenance-fee-posting-preview', $data);

    }

    public function progress() {
        return Response::json(array(Session::get('progress')));
    }

    public function invoice(finance_invoice $finance_invoice,$id)
    {

         $data['receiptdata']=finance_invoice::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();


        return view('backend/finance-and-management.finance-invoices.invoice', $data);
    }
public function printall(Request $request){
//        dd($request->get('invoice_Date'));
    $_members=membership::select('mem_no','id','cur_address','cnic','mob_a','personal_email','applicant_name','total','total_maintenance')->whereHas('invoices',function($q) use ($request){
          if($request->get('invoice_Date')!=''){
              $q->where('invoice_date',$request->get('invoice_Date'));
//              $f2->where('invoice_date',$request->get('invoice_Date'));

          }
    })->with(['invoices'=>function($q) use ($request){
        if($request->get('invoice_Date')!=''){
            $q->where('invoice_date',$request->get('invoice_Date'));
//              $f2->where('invoice_date',$request->get('invoice_Date'));

        }
    }]);

    if($request->get('toMember')!=''){
        $_members->where('id','<=',$request->get('toMember'));
    }
    if($request->get('fromMember')!=''){
        $_members->where('id','>=',$request->get('fromMember'));

    }
    $members=$_members->get();

    $data=[];

    foreach($members as $key=> $member){
        if($request->get('invoice_Date')==''){

$f=finance_invoice::where('member_id',$member->id)->latest('id')->first()->toArray();

        }
        else{
            $f=$member->invoices[0];
        }
//dd($f2);
$data[$key]=[
        'member'=>$member->toArray(),
        'receiptdata'=>$f

    ];

    }
//    dd($data);
$data['profiledata']=  admin_company_profile::get()->first()->toArray();

    return view('backend/finance-and-management.finance-invoices.invoicesprint', ['s'=>$data]);
}
 

    

public function printall2(Request $request){
//        dd($request->get('invoice_Date'));
 

    $data=[];
$links=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get();

$d=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get();
//dd($d);
 $data['majorx']=0;

 $tts=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get()->pluck('charges_type');
  $tids=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get()->pluck('id');
    $data['majorx']=transactions::where('debit_or_credit',0)->where('type',2)->whereIn('trans_type',$tts)->whereIn('trans_type_id',$tids)->sum('trans_amount');

    foreach($d as $key=> $member){
//echo $member->id;

$f=membership::where('id',$member->member_id)->get();




  $s=transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$member->charges_type)->where('trans_type_id',$member->id)->get()->pluck('id');
        $b = (transactions::whereIn('id',$s)->where('debit_or_credit', 0)->where('type', 2)->get()->toArray(1));
                
$x=0;
//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

            
 $storein[]=[];
            foreach($b as $rv){
                if(!empty($rv['receipt_id'])) {
                  $accu=finance_cash_receipt::where('id',$rv['receipt_id'])->get()->pluck('account');
                  $storein[]=$accu[0];
             }

            }

if($storein){
      $storage=$storein;
}
   else{
      $storage=[];
   }

//dd($data['storage']);

           $result = $member->grand_total-$x;
           $amt = $x;




//dd($f2);
$data[$key]=[
        'member'=>$f->toArray(),
        'receiptdata'=>$member,
        'resultant'=>$result,
        'amount_paid'=>$amt,
        'storage'=>$storage

    ];
 
    }

 
 
//    dd($data);
$data['profiledata']=  admin_company_profile::get()->first()->toArray();
$data['bookingsubdata']=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get();

    return view('backend/finance-and-management.finance-invoices.invoicesprint', ['s'=>$data])->withLinks($links);
}

public function printall3(Request $request){
//        dd($request->get('invoice_Date'));
 

    $data=[];
$links=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get();

$d=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get();
//dd($d);
 $data['majorx']=0;

 $tts=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get()->pluck('charges_type');
  $tids=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->whereIn('charges_type',[4,49])->whereNull('status')->get()->pluck('id');
    $data['majorx']=transactions::where('debit_or_credit',0)->where('type',2)->whereIn('trans_type',$tts)->whereIn('trans_type_id',$tids)->sum('trans_amount');

    foreach($d as $key=> $member){
//echo $member->id;

$f=membership::where('id',$member->member_id)->get();


 

  $s=transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$member->charges_type)->where('trans_type_id',$member->id)->get()->pluck('id');
        $b = (transactions::whereIn('id',$s)->where('debit_or_credit', 0)->where('type', 2)->get()->toArray(1));
                
$x=0;
//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

             
 $storein[]=[];
            foreach($b as $rv){
                if(!empty($rv['receipt_id'])) {
                  $accu=finance_cash_receipt::where('id',$rv['receipt_id'])->get()->pluck('account');
                  $storein[]=$accu[0];
             }

            }

if($storein){
      $storage=$storein;
}
   else{
      $storage=[];
   }

//dd($data['storage']);

           $result = $member->grand_total-$x;
           $amt = $x;




//dd($f2);
$data[$key]=[
        'member'=>$f->toArray(),
        'receiptdata'=>$member,
        'resultant'=>$result,
        'amount_paid'=>$amt,
        'storage'=>$storage

    ];
 
    }

 
 
//    dd($data);
$data['profiledata']=  admin_company_profile::get()->first()->toArray();
/*$data['bookingsubdata']=finance_invoice::whereIn('invoice_no',explode(',',$request->get('ids')))->get();

*/
/*$data['bookingsubdata']=finance_invoice::with('transactions')->whereIn('invoice_no',explode(',',$request->get('ids')))->where('charges_type',4)->whereNull('status')->get();*/
 
$data['bookingsubdata']= DB::table('finance_invoices')
            ->leftJoin('transactions', function ($join) use ($tids) {
                $join->on('transactions.trans_type_id', '=', 'finance_invoices.id')->on('transactions.trans_type', '=', 'finance_invoices.charges_type')->where('transactions.debit_or_credit',0)->where('transactions.type',2)->where('transactions.deleted_at',null);
            })
            ->selectRaw('finance_invoices.*,sum(transactions.trans_amount) as amount_paid')->
           whereIn('finance_invoices.invoice_no',explode(',',$request->get('ids')))->whereIn('finance_invoices.charges_type',[4,49])->whereNull('finance_invoices.status')->orderBy('finance_invoices.invoice_no')->groupBy('finance_invoices.id')
            ->get();
   //dd($data['bookingsubdata']);
    return view('backend/finance-and-management.finance-invoices.unpaidinvoicesprint', ['s'=>$data])->withLinks($links);
}


public function old_printall(Request $request){
//        dd($request->get('invoice_Date'));
    $_members=membership::select('mem_no','id','cur_address','cnic','mob_a','personal_email','applicant_name','total','total_maintenance')->whereHas('invoices',function($q) use ($request){
          if($request->get('invoice_Date')!=''){
              $q->where('invoice_date',$request->get('invoice_Date'));
//              $f2->where('invoice_date',$request->get('invoice_Date'));

          }
    })->with(['invoices'=>function($q) use ($request){
        if($request->get('invoice_Date')!=''){
            $q->where('invoice_date',$request->get('invoice_Date'));
//              $f2->where('invoice_date',$request->get('invoice_Date'));

        }
    },'invoices.subs']);

    if($request->get('toMember')!=''){
        $_members->where('id','<=',$request->get('toMember'));
    }
    if($request->get('fromMember')!=''){
        $_members->where('id','>=',$request->get('fromMember'));

    }
    $members=$_members->get();

    $data=[];

    foreach($members as $key=> $member){
        if($request->get('invoice_Date')==''){

$f=finance_invoice::where('member_id',$member->id)->latest('id')->first()->toArray();
$f2=finance_invoice::with('subs')->where('member_id',$member->id)->latest('id')->first()->toArray();

        }
        else{
            $f=$member->invoices[0];
            $f2=$member->invoices[0];
        }
//dd($f2);
$data[$key]=[
        'member'=>$member->toArray(),
        'receiptdata'=>$f,

        'invoicesubs'=>$f2
        ,

    ];
    $data[$key]['subdata']=$data[$key]['invoicesubs']['subs'];

    }
//    dd($data);
$data['profiledata']=  admin_company_profile::get()->first()->toArray();

    return view('backend/finance-and-management.finance-invoices.invoicesprint', ['s'=>$data]);
}

}
