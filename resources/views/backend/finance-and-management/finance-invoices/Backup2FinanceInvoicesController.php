<?php

namespace App\Http\Controllers;

use App\finance_invoice;
use App\transactions;
use App\trans_relations;
use App\finance_invoice_charges_type;
use Illuminate\Http\Request;
use DataTables;
use App\admin_company_profile;
use App\customer;
use App\membership;
use App\mem_family;
use App\sports_subscription;
use Session;
use App\room_booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\trans_type;
use Spatie\Permission\Models\Permission;

class FinanceInvoicesController extends Controller
{

    public function index_vue(Request $request, finance_invoice $finance_invoice)
    {

        return view('backend/finance-and-management/finance-invoices/finance-invoices-vue');

    }

       public function invoices_init(Request $request)
    {


  $data['invoices'] =\Illuminate\Support\Facades\DB::select('select finance_invoices.*, memberships.title as tname, memberships.applicant_name as lname,memberships.first_name as fname,memberships.middle_name as mname,memberships.mem_no as mem_no, if(sum(transactions.trans_amount )>0,sum(transactions.trans_amount ),0) as paid_amount , GROUP_CONCAT(transactions.receipt_id) as reciept_id, trans_types.name as type_name,mem_families.title as tfamily,mem_families.first_name as ffamily,mem_families.middle_name as mfamily,mem_families.name as lfamily from finance_invoices
left outer join transactions on transactions.trans_type=finance_invoices.charges_type and transactions.trans_type_id=finance_invoices.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join memberships on memberships.id=finance_invoices.member_id and memberships.deleted_at is null
left outer join trans_types on trans_types.id=finance_invoices.charges_type
left outer join mem_families on mem_families.id=finance_invoices.family
where finance_invoices.deleted_at is null group by finance_invoices.id order by finance_invoices.id desc');


        $data['mains']=   [];
        $data['charges']=   [];
        
        $data['subscriptions']=   [];
        $dx=trans_type::where('type','<=',3)->get();
        foreach ($dx as $cm){
           $fixed="Invoice";
            $dcm=$cm->name;
            $dcm2=$cm->mod_id;
            if($cm->type==1){
                 $ans = $cm->id;
            }
            else{
              $ans = $dcm.' '.$dcm2;
            }
            if(auth()->user()->can($fixed.' '.$ans)){
                if($cm->type==1){
                    $data['mains'][]=$cm;
                }elseif($cm->type==2){
                    $data['charges'][]=$cm;

                }elseif($cm->type==3){
                    $data['subscriptions'][]=$cm;

                }
              
            }
        }

/*$data['mains']=   trans_type::where('type',1)->get();
     $data['charges']=   trans_type::where('type',2)->get();
    $data['subscriptions']=   trans_type::where('type',3)->get();*/
  $invoicesYears=finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated',1)->get();
      $data['invoicesYears']=$invoicesYears;

     return $data;

}


    public function index(Request $request, finance_invoice $finance_invoice)
    {
     $data['mains']=   trans_type::where('type',1)->get();
     $data['charges']=   trans_type::where('type',2)->get();
    $data['subscriptions']=   trans_type::where('type',3)->get();
    	$data['receiptstatus']   = 1;
    	$invoicesYears=finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated',1)->get();
    	$data['invoicesYears']=$invoicesYears;
        return view('backend/finance-and-management/finance-invoices/finance-invoices', $data);
    }

    public function indexdt(Request $request, finance_invoice $finance_invoice)
    {
        $r=finance_invoice::where('deleted_at');
        if($request->get('mog')==0){
            if($request->get('customer')){
                $x=$request->get('customer');

                $c=membership::where('applicant_name','like',"%$x%")->first();
                $r=membership::find($c->id)->invoices();

            }
        }
        else{
            if($request->get('customer')){
            $x=$request->get('customer');

            $c=customer::where('customer_name','like',"%$x%")->first();
            $r=customer::find($c->id)->invoices();

        }

        }

        if($request->get('start_date')){
            $r->where('invoice_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('invoice_date','<=',formatDate($request->get('end_date')));

        }

        if($request->get('receipt')){
            $r->where('invoice_no','=',$request->get('receipt'));

        }

        if($request->get('details')){
            $r->where('charges_type',$request->get('details'));

        }


//        dd($r->toSql());

        $invoices = $r->get();

        $dx= DataTables::of($invoices)


          ->addColumn('chargestype', function ($invoices) {
            if($invoices->charges_type){
                  return transTypesChargesTypes($invoices->charges_type);
                  }
                else{
                    return '';
                }

           })

            ->addColumn('details_d', function ($invoices) {
                $s=transactions::where('debit_or_credit',1)->where('trans_type',$invoices->charges_type)->where('trans_type_id',$invoices->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get());
                foreach($b as $d){
//                    dd($d->type);
                    $c=$d->type->name;
                    return "   <a target='_blank' href='".route('cash.receipt.print',$d['receipt_id'])."'>($d[receipt_id] - $c)</a><br>";
                }
           })

         ->addColumn('amountpaid', function ($invoices) {
             $s=transactions::where('debit_or_credit',1)->where('trans_type',$invoices->charges_type)->where('trans_type_id',$invoices->id)->get()->pluck('id');
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

           ->addColumn('finalbalance', function ($invoices) {
             $s=transactions::where('debit_or_credit',1)->where('trans_type',$invoices->charges_type)->where('trans_type_id',$invoices->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                      $x = $v['trans_amount']+$x;
             }
            }

            return $invoices->grand_total-$x;

           })

           ->addColumn('balancestatus', function ($invoices) {

          $s=transactions::where('debit_or_credit',1)->where('trans_type',$invoices->charges_type)->where('trans_type_id',$invoices->id)->get()->pluck('id');
                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                      $x = $v['trans_amount']+$x;
             }
            }


            $resultant = $invoices->grand_total-$x;

               if($resultant==0){
return '<button class=" btn btn-outline-success active">Paid</button>';
               }
               else{
                if($invoices->invoice_type==0){
                return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?'. 'memid='. $invoices->member_id . '">Unpaid</a></button>';
                }
                else if($invoices->invoice_type==1){
                   return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?'. 'guestid='. $invoices->customer_id . '">Unpaid</a></button>';
                }


               }
            })




            ->addColumn('editbutton', function ($invoices) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-invoices/finance-invoices-aeu/') . '/' . $invoices->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })


            ->addColumn('deletebutton', function ($invoices) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-invoices/delete') . '/' . $invoices->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


            ->addColumn('type', function ($invoices) {
                if($invoices->invoice_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })

  ->addColumn('dtotal', function ($r) {
                $request=Request::capture();
                $r=finance_invoice::where('deleted_at');
                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

                        $c=membership::where('applicant_name','like',"%$x%")->first();
                        $r=membership::find($c->id)->invoices();

                    }
                }
                else{
                    if($request->get('customer')){
                        $x=$request->get('customer');

                        $c=customer::where('customer_name','like',"%$x%")->first();
                        $r=customer::find($c->id)->invoices();

                    }

                }
                if($request->get('start_date')){
                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('receipt')){
                    $r->where('invoice_no','=',$request->get('receipt'));

                }
                if($request->get('details')){
            $r->where('charges_type',$request->get('details'));

        }

              return number_format( $r->sum('grand_total')) ;


                })

  ->addColumn('ctotal', function ($invoices) {
                $request=Request::capture();
                $r=finance_invoice::where('deleted_at');
                if($request->get('mog')==0){
                    if($request->get('customer')){
                        $x=$request->get('customer');

                        $c=membership::where('applicant_name','like',"%$x%")->first();
                        $r=membership::find($c->id)->invoices();

                    }
                }
                else{
                    if($request->get('customer')){
                        $x=$request->get('customer');

                        $c=customer::where('customer_name','like',"%$x%")->first();
                        $r=customer::find($c->id)->invoices();

                    }

                }
                if($request->get('start_date')){
                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('receipt')){
                    $r->where('invoice_no','=',$request->get('receipt'));

                }
                if($request->get('details')){
            $r->where('charges_type',$request->get('details'));

        }

                return number_format( $r->count('id')) ;


                })

               ->addColumn('invoice_date', function ($invoices) {
              return formatDateToShow($invoices->invoice_date);
})

               ->addColumn('customer_id', function ($invoices) {
                if($invoices->invoice_type==1){
                return    $invoices->customer_id;
                }
                else if($invoices->invoice_type==0){
            //        return "Member";

                  return $invoices->mem_no;

                }
          //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


                })

             ->addColumn('status', function ($receipts) {
                 return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-invoices/invoice/') . '/' . $receipts->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

            ->rawColumns(['editbutton',
                'details_d', 'editfinancebutton', 'deletebutton', 'sports_subscription','payment_receipts_sub', 'finance_invoice_charges_type', 'status', 'customer', 'membership', 'mem_address', 'admin_company_profile', 'finance_payment_methods', 'amountpaid', 'finalbalance', 'balancestatus', 'chargestype'])
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


public function index_deleted(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/finance-invoices/finance-invoices-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_invoice $finance_invoice)
    {

        $deleted = finance_invoice::onlyTrashed()->get();
        return DataTables::of($deleted)

       ->addColumn('chargestype', function ($deleted) {
            if($deleted->charges_type){
                  return transTypesChargesTypes($deleted->charges_type);
                  }
                else{
                    return '';
                }

           })


         ->addColumn('type', function ($invoices) {
                if($invoices->invoice_type==1){
                     return "Guest";
                }
                else{
                     return "Member";
                 }


                })

    ->addColumn('invoice_date', function ($invoices) {
              return formatDateToShow($invoices->invoice_date);
})

              ->addColumn('customer_id', function ($invoices) {
                if($invoices->invoice_type==1){
                return    $invoices->customer_id;
                }
                else if($invoices->invoice_type==0){
            //        return "Member";

                  return $invoices->mem_no;

                }
          //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


                })

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-invoices/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

 public function print(Request $request, finance_invoice $finance_invoice)
    {
 $data['receiptdata']=finance_invoice::get();
        $view=View::make('backend/finance-and-management/finance-invoices/invoice',$data)->renderSections()['page-content'];
        return $view;

    }

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
 $data['receiptstatus']   = 1;

        return view('backend/finance-and-management.finance-invoices.finance-invoices-aeu', $data);
    }



      public function store(Request $request)
    {
        $addmore=$request->addmore;
        $addmore2=$request->addmore2;
        $saveandreceive=$request->saveandreceive;
        $getlastinsert=0;
          $validation=[

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'invoice_type' => 'required',
            'name' => 'required',
            //'mem_no' => 'required',
          'address' => 'required',
         // 'ledger_amount' => 'required',
          //  'cnic' => 'required',
            //'contact' => 'required',
            //'email' => 'required',

           'final_total' => 'required',

            'grand_total'=> 'required',
             'amount_in_words'=> 'required',


              'charges_type' => 'required',
            'charges_amount'=> 'required',
             'qty'=> 'required',
              'sub_total'=> 'required'

               ];
        if($request->get('invoice_type')==0){
            $validation['mem_no']='required';
            $validation['member_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }
        $this->validate($request, $validation);


         $invoices = finance_invoice::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'invoice_type' => $request->invoice_type,
            'name' => $request->name,
             'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
            'mem_no' => $request->mem_no,

            'address' => $request->address,
            'ledger_amount' => $request->ledger_amount,
            'cnic' => $request->cnic,
           'contact' => $request->contact,
           'email' => $request->email,
           'family' => $request->family,
         'total' => $request->final_total,
            'discount_amount' => $request->discount_amount,
            'discount_percentage' => $request->discount_percentage,

           'discount_details' => $request->discount_details,

           'extra_charges' => $request->extra_charges,
           'extra_percentage' => $request->extra_percentage,

           'extra_details' => $request->extra_details,

           'tax_charges' => $request->tax_charges,
           'tax_percentage' => $request->tax_percentage,

           'tax_details' => $request->tax_details,

            'grand_total' => $request->grand_total,
            'amount_in_words' => $request->amount_in_words,
            'comments' => $request->comments,
            'member'=>1,

            'charges_type' => $request->charges_type,
           'charges_amount' => $request->charges_amount,
            'start_date' => formatDate($request->start_date),
            'end_date' => formatDate($request->end_date),
            'days' => $request->days,
            'qty' => $request->qty,
            'sub_total' => $request->sub_total

        ]);

/*
         $chargestypes=$request->charges_type;
         $startdate=$request->start_date;
          $enddate=$request->end_date;
           $days=$request->days;
           $qty=$request->qty;
        $chargesamount=$request->charges_amount;
        $total=$request->total;


          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new finance_invoice_subs;
            $ta->invoice_id = $invoices->id;
             $ta->start_date = formatDate($startdate[$i]);
             $ta->end_date = formatDate($enddate[$i]);
             $ta->days = $days[$i];
             $ta->qty = $qty[$i];
             $ta->total = $total[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i][2];
            $ta->charges_type=$chargestypes[$i][0];
            $ta->created_by=Auth::user()->id;
             $ta->updated_by=Auth::user()->id;
            $ta->save();
            $i++;
        }*/


if($request->invoice_type==0){
     $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $request->charges_type,
        'trans_type_id' =>  $invoices->id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  0,
        'trans_moc' =>  $request->member_id,
         'is_active' =>  1,
         'date' =>  $request->start_date!=null?formatDate($request->start_date):formatDate($request->invoice_date)
        ]);
}
elseif($request->invoice_type==1){

  $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $request->charges_type,
        'trans_type_id' =>  $invoices->id,
        'trans_amount' =>  $request->grand_total,
        'trans_moc_type' =>  1,
        'trans_moc' =>  $request->customer_id,
        'is_active' =>  1,
        'date' =>  $request->start_date!=null?formatDate($request->start_date):formatDate($request->invoice_date)
        ]);
}

        if ($invoices) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$invoices->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(!empty($addmore2)){
            return redirect('finance-and-management/finance-invoices/finance-invoices-aeu');
        }
        if(!empty($addmore))
            {
                return redirect('finance-and-management/finance-invoices/invoice/'.$getlastinsert);
            }
          else if(!empty($saveandreceive)){
               if($request->invoice_type==0){
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'memid='. $request->member_id);
              }
              else if($request->invoice_type==1){
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'guestid='. $request->customer_id);
              }
            }
            else{
                return redirect('finance-and-management/finance-invoices-vue');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(room_payment_receipt $room_payment_receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */

public function edit(finance_invoice $finance_invoice,$id)
    {
         $data['invoice_update'] = finance_invoice::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['invoice_update']->code;

$data['main_types']=trans_type::where('type',1)->get();
$data['finance_invoice_charges_type']=trans_type::where('type',2)->get();
$data['subscription_type']=trans_type::where('type',3)->get();

        $memberfmid=$data['invoice_update']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();

$data['receiptstatus']   = 1;

        return view('backend/finance-and-management.finance-invoices.finance-invoices-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $saveandreceive=$request->saveandreceive;
         $validation=[
            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'invoice_type' => 'required',
            'name' => 'required',
            //'mem_no' => 'required',
          'address' => 'required',
        // 'ledger_amount' => 'required',
          //  'cnic' => 'required',
         //   'contact' => 'required',
           // 'email' => 'required',

           'final_total' => 'required',

            'grand_total'=> 'required',
            'amount_in_words'=> 'required',
              'charges_type' => 'required',
            'charges_amount'=> 'required',
             'qty'=> 'required',
              'sub_total'=> 'required'
        ];
        if($request->get('invoice_type')==0){
            $validation['mem_no']='required';
            $validation['member_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }
        $this->validate($request, $validation);
        $f= finance_invoice::find( $id);
        if($request->invoice_type==0){

            $transaction = transactions::where('trans_type_id', $id)->where('trans_type',  $f->charges_type)->where('debit_or_credit',1)->updateWithUserstamps([
                'debit_or_credit' =>  1,
                'trans_type' =>  $request->charges_type,
                'trans_type_id' =>  $id,
                'trans_amount' =>  $request->grand_total,
                'trans_moc_type' =>  0,
                'trans_moc' =>  $request->member_id,
                'is_active' =>  1,
                'date' =>  $request->start_date!=null?formatDate($request->start_date):formatDate($request->invoice_date)
            ]);

        }
        elseif($request->invoice_type==1){

            $transaction = transactions::where('trans_type_id', $id)->where('trans_type',  $f->charges_type)->where('debit_or_credit',1)->updateWithUserstamps([
                'debit_or_credit' =>  1,
                'trans_type' =>  $request->charges_type,
                'trans_type_id' =>  $id,
                'trans_amount' =>  $request->grand_total,
                'trans_moc_type' =>  1,
                'trans_moc' =>  $request->customer_id,
                'is_active' =>  1,
                'date' =>  $request->start_date!=null?formatDate($request->start_date):formatDate($request->invoice_date)
            ]);
        }

        $x=transactions::where('trans_type_id', $id)->where('trans_type', $request->charges_type)->where('debit_or_credit',1)->first();
        if($x){

            $t=trans_relations::where('invoice',$x->id)->get();


            if($t){
//                dd($t);
                foreach ($t as $c){

//                    dd(transactions::find($c->receipt));
                    $transaction_d = transactions::where('id',$c->receipt)->updateWithUserstamps([
                        'debit_or_credit' =>  0,
                        'trans_type' =>  $request->charges_type,
                        'trans_type_id' =>  $id,
//                        'trans_amount' =>  $request->grand_total,
//                        'trans_moc_type' =>  $request->invoice_type,
//                        'trans_moc' => $request->invoice_type==1? $request->customer_id:$request->member_id,
//                        'is_active' =>  1,
//                        'date' => formatDate($request->invoice_date)
                    ]);
                }
            }
        }
        $invoices = finance_invoice::where('id', $id)->updateWithUserstamps([
         'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'invoice_type' => $request->invoice_type,
            'name' => $request->name,
             'customer_id'     =>  $request->customer_id,
            'member_id'     =>  $request->member_id,
            'mem_no' => $request->mem_no,

            'address' => $request->address,
            'ledger_amount' => $request->ledger_amount,
            'cnic' => $request->cnic,
           'contact' => $request->contact,
           'email' => $request->email,
           'family' => $request->family,

         'total' => $request->final_total,
             'discount_amount' => $request->discount_amount,
            'discount_percentage' => $request->discount_percentage,

           'discount_details' => $request->discount_details,

           'extra_charges' => $request->extra_charges,
           'extra_percentage' => $request->extra_percentage,

           'extra_details' => $request->extra_details,

           'tax_charges' => $request->tax_charges,
           'tax_percentage' => $request->tax_percentage,

           'tax_details' => $request->tax_details,

            'grand_total' => $request->grand_total,
            'amount_in_words' => $request->amount_in_words,
            'comments' => $request->comments,

            'charges_type' => $request->charges_type,
           'charges_amount' => $request->charges_amount,
              'start_date' => formatDate($request->start_date),
            'end_date' => formatDate($request->end_date),
            'days' => $request->days,
            'qty' => $request->qty,
            'sub_total' => $request->sub_total
        ]);

/*
   $subdelete= finance_invoice_subs::where('invoice_id', $id)->deleteWithUserstamps();

if($subdelete){

    $chargestypes=$request->charges_type;
         $startdate=$request->start_date;
          $enddate=$request->end_date;
           $days=$request->days;
           $qty=$request->qty;
        $chargesamount=$request->charges_amount;
        $total=$request->total;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new finance_invoice_subs;
            $ta->invoice_id = $id;
             $ta->start_date = formatDate($startdate[$i]);
             $ta->end_date = formatDate($enddate[$i]);
             $ta->days = $days[$i];
             $ta->qty = $qty[$i];
             $ta->total = $total[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->charges_type_id=$chargestypes[$i][2];
            $ta->charges_type=$chargestypes[$i][0];
             $ta->updated_by=Auth::user()->id;
            $ta->save();
            $i++;
        }
    }
*/



    if ($invoices) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }


         if(empty($saveandreceive))
            {
              return redirect('finance-and-management/finance-invoices/finance-invoices-aeu/'.$id);
            }else{
              if($request->invoice_type==0){
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'memid='. $request->member_id);
              }
              else if($request->invoice_type==1){
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'guestid='. $request->customer_id);
              }
            }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */

    public function destroy(finance_invoice $finance_invoice,$id)
    {
        $recipt=$finance_invoice::where('id', $id)->deleteWithUserstamps();
         $chargestpe= $finance_invoice::where('id', $id)->get()->pluck('charges_type');
  $transaction = transactions::where('trans_type_id', $id)->where('trans_type', $chargestpe)->where('debit_or_credit',1)->deleteWithUserstamps();

        if($recipt){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-invoices');
    }

     function calculateextracharges($id){
      $charges=trans_type::where('type',2)->where('mod_id',$id)->first();
      return $charges->charges;

     }

    function calculatesportscharges($memid,$id){
     $modid=trans_type::where('id',$id)->get()->pluck('mod_id');


    $type=trans_type::where('id',$id)->get()->pluck('type');
    if($type[0]=='1' && $id==3){
      $charges=membership::where('id',$memid)->get()->first();
       return $charges->total;
    }

    else if($type[0]=='1' && $id==4){
      $charges=membership::where('id',$memid)->get()->first();
       return $charges->total_maintenance;
    }
    else if($type[0]=='2'){
      $charges=finance_invoice_charges_type::where('status',1)->where('id',$modid)->first();
       return $charges->charges;
    }
    else if($type[0]=='3'){
      $charges=sports_subscription::where('status',1)->where('id',$modid)->first();
   return $charges->charges;
    }



    }



    public function invoice(finance_invoice $finance_invoice,$id)
    {

         $data['receiptdata']=finance_invoice::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();

     $data['finance_invoice_charges_type']=finance_invoice_charges_type::where('status',1)->get();
$data['subscription_type']=sports_subscription::where('status',1)->get();

  $s=transactions::where('debit_or_credit',1)->where('trans_type',$data['receiptdata']->charges_type)->where('trans_type_id',$data['receiptdata']->id)->get()->pluck('id');
        $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
        $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

           $data['resultant'] = $data['receiptdata']->grand_total-$x;

        return view('backend/finance-and-management.finance-invoices.invoice', $data);
    }


public function restore(finance_invoice $finance_invoice,$id)
    {
        $restore = finance_invoice::onlyTrashed()->find($id)->restore();
         $chargestpe= $finance_invoice::where('id', $id)->get()->pluck('charges_type');
  $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$chargestpe)->where('debit_or_credit',1)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-invoices/deleted');

}

}
