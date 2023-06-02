<?php

namespace App\Http\Controllers;
use App\finance_cash_receipt;
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
use App\guest_type;
use App\coa_accounts_control;
use App\fnb_predefined_value;
use App\corporateMembership;

class BackupNewFinanceInvoicesController extends Controller
{

    public function index_vue(Request $request, finance_invoice $finance_invoice)
    {
$data['iam']=0;
        return view('backend/finance-and-management/finance-invoices/finance-new-invoices-vue', $data);

    }

  public function index_new_vue(Request $request, finance_invoice $finance_invoice)
    {
$data['iam']=1;
        return view('backend/finance-and-management/finance-invoices/finance-new-invoices-vue', $data);

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
                else {
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
              if($invoices->invoice_type==0){
                  return $invoices->mem_no;
               
                }
                else {
            //        return "Member";
 return    $invoices->customer_id;

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
                if($invoices->invoice_type==0){
                   return $invoices->mem_no;
                
                }
                else  {
            //        return "Member";
                  return    $invoices->customer_id;
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
 $data['receiptdata']=finance_invoice::with('member')->get();
        $view=View::make('backend/finance-and-management/finance-invoices/invoice',$data)->renderSections()['page-content'];
        return $view;

    }

    public function create(Request $request)
    {
      $lastval = finance_invoice::withTrashed()->latest('id')->first();
      $num     = 0;

        if ($lastval) {
            $num                      = $lastval->invoice_no;
            $data['increment_number'] = $num+1;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num+1;
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
    $data['gts']=guest_type::where('status',1)->get();
  $data['main_types']=trans_type::where('type',1)->get();
  $data['subscription_type']=trans_type::where('type',3)->orderby('name', 'ASC')->get();
  $data['finance_invoice_charges_type']=trans_type::where('type',2)->orderby('name', 'ASC')->get();
  $data['receiptstatus']   = 1;
 $data['accounts']=coa_accounts_control::whereIn('cost_center',['1','2'])->get();
  $data['account_types']= trans_type::where('cash_or_payment',2)->where('type',7)->get();
   return view('backend/finance-and-management.finance-invoices.finance-invoices-aeu', $data);
    }



      public function store(Request $request)
    {
      $tago=0;
if(finance_invoice::where('invoice_no',$request->invoice_no)->count() != 0){
  $tago=1;
}else{
  $tago=0;
}

$exists='';
       $lastcashreceipt=finance_cash_receipt::withTrashed()->latest('id')->first();
      $numtwo=0;
      if($lastcashreceipt){
        $numtwo=$lastcashreceipt->id+1;
        $cashrec['increment_numbers']=$numtwo;

      }else{
        $numtwo=1;
        $cashrec['increment_numbers']=$numtwo;

      }

   $receiveme=$request->receive;
        $addmore=$request->addmore;
        $addmore2=$request->addmore2;
        $saveandreceive=$request->saveandreceive;


if($request->get('hiddenforguest')==1){
   $validation=[
            'invoice_no' => 'required',
       'invoice_date' => 'required',
            'invoice_type' => 'required',
           'name' => 'required',
//  'contact' => 'required',
              'my_final_total'=> 'required',

           'charges_type.*' =>'required',
        'charges_amount.*' => 'required',
      //  'qty.*' => 'required',
        'sub_total.*' => 'required',
        'total.*' => 'required',

               ];
}
else{
   $validation=[

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'invoice_type' => 'required',
           'name' => 'required',
//            //'mem_no' => 'required',
//          'address' => 'required',
//         // 'ledger_amount' => 'required',
//          //  'cnic' => 'required',
//            //'contact' => 'required',
//            //'email' => 'required',
//
//           'final_total' => 'required',
//
//            'grand_total'=> 'required',
//             'amount_in_words'=> 'required',
//
//
//              'charges_type' => 'required',
//            'charges_amount'=> 'required',
//             'qty'=> 'required',
//              'sub_total'=> 'required'

              'my_final_total'=> 'required',

           'charges_type.*' =>'required',
        'charges_amount.*' => 'required',

      //  'qty.*' => 'required',
        'sub_total.*' => 'required',
        'total.*' => 'required',

               ];
}
         
        if($request->get('invoice_type')==0){
            $validation['mem_no']='required';
            $validation['member_id']='required';
        }

        else if($request->get('invoice_type')==6){
          //  $validation['cop_no']='required';
            $validation['corporate_id']='required';
        }

        else{
            $validation['customer_id']='required';
        }

          if($request->get('my_final_total')==0){
            $validation['comments']='required';
        }


         if($request->get('receive')){
            $validation['account_type']='required';
            $validation['amount_received']='required';
        }

        $this->validate($request, $validation);


       if(in_array(4, $request->charges_type) && $request->member_id){
     $curMonthd = date("m", strtotime(formatDate($request->start_date[0])));
            $curYeard= date("Y", strtotime($request->start_date[0]));
            $curQuarterd = ceil($curMonthd/3);
            $alreadyexisted =finance_invoice::whereRaw("quarter(start_date)=$curQuarterd and year(start_date)=$curYeard and charges_type=4 and deleted_at is null and status is null and  member_id=".$request->get('member_id'))->first();

         //   dd($alreadyexisted );
          }
          else if(in_array(4, $request->charges_type) && $request->corporate_id){
     $curMonthd = date("m", strtotime(formatDate($request->start_date[0])));
            $curYeard= date("Y", strtotime($request->start_date[0]));
            $curQuarterd = ceil($curMonthd/3);
            $alreadyexisted =finance_invoice::whereRaw("quarter(start_date)=$curQuarterd and year(start_date)=$curYeard and charges_type=4 and deleted_at is null and status is null and  corporate_id=".$request->get('corporate_id'))->first();

         //   dd($alreadyexisted );
          }
          else{
             $alreadyexisted = null;
          }
      
 $r=[];
 $dd='';
       
        $cati ='';
    
        if($request->get('member_id')){
           $r['mem_number']=$request->get('member_id');
                $dd=$r['mem_number'];

        if(membership::where('id',$request->get('member_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('member_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $r['coa_code']=$coa;
           // $dd=$r['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
            $r['coa_code']=null;
            
            $cati = memcategoryname($dd);
           
          
          }
        }
        else{
          $r['coa_code']=null;
           $cati =  null;
        }
       
      }
      else if($request->get('corporate_id')){
           $r['mem_number']=$request->get('corporate_id');
                $dd=$r['mem_number'];

        if(corporateMembership::where('id',$request->get('corporate_id'))->exists()){
           $arr_coa=corporateMembership::where('id',$request->get('corporate_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $r['coa_code']=$coa;
           // $dd=$r['coa_code'];
           $cati =  coaparent($coa);
         

          }else{
            $r['coa_code']=null;
            
            $cati = comemcategoryname($dd);
           
          
          }
        }
        else{
          $r['coa_code']=null;
           $cati =  null;
        }
       
      }
        else if($request->get('customer_id')){
         
       $r['customer_id']=$request->get('customer_id');
            $dd=$r['customer_id'];

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $r['coa_code']=$coa;
           //  $dd=$r['coa_code'];
           $cati =  coaparent($coa);
            
          }else{
             $r['coa_code']=null;
           $cati =  null;
         
          }
        }else{
          $r['coa_code']=null;
           $cati =  null;
        }
 

        }
       






if(finance_invoice::where('invoice_no',$request->invoice_no)->count() == 0 && $alreadyexisted==null){

if($request->receive){

  if($request->get('amount_received')>0){
if($request->get('invoice_type')==0){
        $r['coa_trans_type']=$request->get('account');
        $r['invoice_no']= $cashrec['increment_numbers'];
        $r['invoice_date']= formatDate($request->get('invoice_date'));
        $r['receipt_type']=0;
        $r['mem_number']=$request->get('member_id');
        $r['total_amount']=$request->get('amount_received')+$request->get('return_value');
        $r['total']=$request->get('amount_received')+$request->get('return_value');
        $r['account']=$request->get('account_type');
        $r['remarks']=$request->get('remarks');

}
else if($request->get('invoice_type')==6){
        $r['coa_trans_type']=$request->get('account');
        $r['invoice_no']= $cashrec['increment_numbers'];
        $r['invoice_date']= formatDate($request->get('invoice_date'));
        $r['receipt_type']=6;
        $r['corporate_id']=$request->get('corporate_id');
        $r['total_amount']=$request->get('amount_received')+$request->get('return_value');
        $r['total']=$request->get('amount_received')+$request->get('return_value');
        $r['account']=$request->get('account_type');
        $r['remarks']=$request->get('remarks');

}
else  {
        $r['coa_trans_type']=$request->get('account');
        $r['invoice_no']= $cashrec['increment_numbers'];
        $r['invoice_date']= $request->get('invoice_date');
        $r['receipt_type']=1;
        $r['customer_id']=$request->get('customer_id');
        $r['total_amount']=$request->get('amount_received')+$request->get('return_value');
        $r['total']=$request->get('amount_received')+$request->get('return_value');
        $r['account']=$request->get('account_type');
        $r['remarks']=$request->get('remarks');

}
      $rid=  finance_cash_receipt::create($r);
    }
}


if($request->get('hiddenforguest')==1){

  $this->validate($request, [
            'name' => 'unique:customers,customer_name',
      //      'contact' => 'unique:customers,customer_contact'
        ]);


    $Customer =  customer::create([
            'customer_no' =>  $request->customer_id,
            'customer_name' => $request->name,
            'customer_contact' => $request->contact,
             'guest_type' => $request->invoice_type-10,  
           //  'guest_type' => ltrim($request->invoice_type, $request->invoice_type[0]),
        ]);
}

        $lastin=finance_invoice::withTrashed()->latest('id')->first();
        $invoice_no=$lastin->invoice_no+1;

foreach($request->charges_type as $key=>$c){


    $charges=$request->sub_total[$key];



    $curMonth = date("m", strtotime(formatDate($request->start_date[$key])));
          //  dd($curMonth);
            $curYear = date("Y", strtotime($request->start_date[$key]));
            $curQuarter = ceil($curMonth/3);

if($request->member_id && $request->charges_type[$key]==4){
    $alreadyexist=finance_invoice::whereRaw("quarter(start_date)=$curQuarter and year(start_date)=$curYear and charges_type=4 and deleted_at is null and status is null and  member_id=".$request->member_id)->first();
   
}
else if($request->corporate_id && $request->charges_type[$key]==4){
    $alreadyexist=finance_invoice::whereRaw("quarter(start_date)=$curQuarter and year(start_date)=$curYear and charges_type=4 and deleted_at is null and status is null and  corporate_id=".$request->corporate_id)->first();
   
}
else{
   $alreadyexist= null;
}
          

            if($alreadyexist!=null){
 $invoices='';
  $exists=1;

            }
            else{








    $cm=[
'coa_code' => $r['coa_code'],
        'invoice_no' =>  $invoice_no,
        'invoice_date' => formatDate($request->invoice_date),
        'invoice_type' => $request->invoice_type>10?1:$request->invoice_type,
        'name' => $request->name,
        'customer_id'     =>  $request->customer_id,
        'member_id'     =>  $request->member_id,
        'mem_no' => $request->mem_no,

     'corporate_id'     =>  $request->corporate_id,
    

        'address' => $request->address,
        'ledger_amount' => $request->ledger_amount,
        'cnic' => $request->cnic,
        'contact' => $request->contact,
        'email' => $request->email,
        //'family' => $request->family,
        //'total' => $request->final_total[$key],
 

        'discount_details' => $request->discount_details,

 /*       'extra_charges' => $request->extra_charges[$key],*/


        'extra_details' => $request->extra_details,

     /*   'tax_charges' => $request->tax_charges[$key],*/


        'tax_details' => $request->tax_details,


//        'amount_in_words' => $request->amount_in_words,
        'comments' => $request->comments,
        'member'=>1,

      'discount_amount' => isset($request->discount_amount[$key])?$request->discount_amount[$key]:null,
       'discount_percentage' => isset($request->discount_percentage[$key])?$request->discount_percentage[$key]:null,
       'extra_percentage' => isset($request->extra_percentage[$key])?$request->extra_percentage[$key]:null,
        'extra_charges' => isset($request->extra_charges[$key])?$request->extra_charges[$key]:null,
      'tax_percentage' => isset($request->tax_percentage[$key])?$request->tax_percentage[$key]:null,
      'grand_total' => isset($request->grand_total[$key])?$request->grand_total[$key]:null,
        'charges_type' => isset($request->charges_type[$key])?$request->charges_type[$key]:null,
        'charges_amount' => isset($request->charges_amount[$key])?$request->charges_amount[$key]:null,
         'per_day_amount' => isset($request->per_day_amount[$key])?$request->per_day_amount[$key]:null,
        'start_date' => isset($request->start_date[$key])?formatDate($request->start_date[$key]):null,
        'end_date' => isset($request->end_date[$key])?formatDate($request->end_date[$key]):null,
        'days' => isset($request->days[$key])?$request->days[$key]:null,
        'qty' => isset($request->qty[$key])?$request->qty[$key]:1,
        'sub_total' => isset($request->sub_total[$key])?$request->sub_total[$key]:null,
        'total' => isset($request->sub_total[$key])?$request->sub_total[$key]:null,
        'family' => isset($request->family[$key])?$request->family[$key]:null,

    ];

    $invoices = finance_invoice::create($cm);


    $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }

    if($request->invoice_type==0){
        $transaction = transactions::create([
            'type'=>1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $invoices->id,
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  0,
            'trans_moc' =>  $dd,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date),
            'trans_moc_category' => $cati,
            'account'=>transTypesCoa($request->charges_type[$key]),
               'trans_coa'=>$r['coa_code'],
               'unit'=>$ccc,
        ]);
    }
    else if($request->invoice_type==6){
        $transaction = transactions::create([
            'type'=>1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $invoices->id,
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  6,
            'trans_moc' =>  $dd,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date),
            'trans_moc_category' => $cati,
            'account'=>transTypesCoa($request->charges_type[$key]),
               'trans_coa'=>$r['coa_code'],
               'unit'=>$ccc,
        ]);
    }
    else {

        $transaction = transactions::create([
            'type'=>1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $invoices->id,
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  1,
            'trans_moc' =>  $dd,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date),
             'trans_moc_category' =>$cati,
             'account'=>transTypesCoa($request->charges_type[$key]),
               'trans_coa'=>$r['coa_code'],
                'unit'=>$ccc,
        ]);

        /*'trans_moc_category' => ltrim($request->invoice_type, $request->invoice_type[0]),*/
    }




if($request->receive){
//sending into transactions table
 if($request->get('amount_received')>0){
if($request->get('invoice_type')==0){
       $t=[];
        $t['type']= 2;
        $t['debit_or_credit']= 0;
        $t['trans_type']=$request->charges_type[$key];
        $t['trans_type_id']=$invoices->id;
        $t['trans_amount']= $request->grand_total[$key];
        $t['trans_moc']=$dd;
         $t['trans_moc_category']=$cati;
     
        $t['trans_moc_type']=0;
        $t['is_active']=1;
        $t['receipt_id']=$rid->id;
        $t['date']=formatDate($request->get('invoice_date'));
        $t['payment_method']=$request->get('account_type');
$t['unit']= $ccc;
 $t['account']= transTypesCoa($request->charges_type[$key]);
   $t['trans_coa']= $r['coa_code'];

           $acc=  transactions::create([
               'type'=>3,
               'debit_or_credit'=>1,
               'trans_type'=>$request->charges_type[$key],
               'trans_type_id'=> $invoices->id,
               'trans_amount'=>$request->grand_total[$key],
               'trans_moc'=> $dd,
               'trans_moc_category' => $cati,
                 // 'trans_moc_category' =>  memcategoryname($request->member_id),
               'trans_moc_type'=>0,
               'receipt_id'=>$rid->id,
               'date'=>formatDate($request->get('invoice_date')),
                
                 'payment_method'=>$request->get('account_type'),
               'unit'=>$ccc,
               'is_active'=>1,
               'account'=>$request->get('account'),
                 'trans_coa'=>$r['coa_code'],
            ]);
}
else if($request->get('invoice_type')==6){
       $t=[];
        $t['type']= 2;
        $t['debit_or_credit']= 0;
        $t['trans_type']=$request->charges_type[$key];
        $t['trans_type_id']=$invoices->id;
        $t['trans_amount']= $request->grand_total[$key];
        $t['trans_moc']=$dd;
         $t['trans_moc_category']=$cati;
     
        $t['trans_moc_type']=6;
        $t['is_active']=1;
        $t['receipt_id']=$rid->id;
        $t['date']=formatDate($request->get('invoice_date'));
        $t['payment_method']=$request->get('account_type');
$t['unit']= $ccc;
 $t['account']= transTypesCoa($request->charges_type[$key]);
   $t['trans_coa']= $r['coa_code'];

           $acc=  transactions::create([
               'type'=>3,
               'debit_or_credit'=>1,
               'trans_type'=>$request->charges_type[$key],
               'trans_type_id'=> $invoices->id,
               'trans_amount'=>$request->grand_total[$key],
               'trans_moc'=> $dd,
               'trans_moc_category' => $cati,
                 // 'trans_moc_category' =>  memcategoryname($request->member_id),
               'trans_moc_type'=>6,
               'receipt_id'=>$rid->id,
               'date'=>formatDate($request->get('invoice_date')),
                
                 'payment_method'=>$request->get('account_type'),
               'unit'=>$ccc,
               'is_active'=>1,
               'account'=>$request->get('account'),
                 'trans_coa'=>$r['coa_code'],
            ]);
}
else  {
 $t=[];
$t['type']= 2;
        $t['debit_or_credit']= 0;
        $t['trans_type']=$request->charges_type[$key];
        $t['trans_type_id']= $invoices->id;
        $t['trans_amount']= $request->grand_total[$key];
        $t['trans_moc']=$dd;
       // $t['trans_moc']=$request->get('customer_id');
         $t['trans_moc_category']=$cati;
        // $t['trans_moc_category']=ltrim($request->invoice_type, $request->invoice_type[0]);
         
        $t['trans_moc_type']=1;
          $t['is_active']=1;
          $t['receipt_id']=$rid->id;
          $t['date']=formatDate($request->get('invoice_date'));
          $t['payment_method']=$request->get('account_type');
          $t['unit']= $ccc;
          $t['account']= transTypesCoa($request->charges_type[$key]);
            $t['trans_coa']= $r['coa_code'];
          

           $acc=  transactions::create([
                'type'=>3,
               'debit_or_credit'=>1,
               'trans_type'=>$request->charges_type[$key],
               'trans_type_id'=> $invoices->id,
               'trans_amount'=>$request->grand_total[$key],
                     'trans_moc'=> $dd,
                  'trans_moc_category' => $cati,
         /*      'trans_moc'=> $request->get('customer_id'),
                  'trans_moc_category' => ltrim($request->invoice_type, $request->invoice_type[0]),*/
               'trans_moc_type'=>1,
               'receipt_id'=>$rid->id,
               'date'=>formatDate($request->get('invoice_date')),
                
                'payment_method'=>$request->get('account_type'),
               'unit'=> $ccc,
               'is_active'=>1,
               'account'=>$request->get('account'),
                 'trans_coa'=>$r['coa_code'],
            ]);
}

      $tid=  transactions::create($t);
    }

//sending into transactions table


    //sending into trans relations
if($request->get('amount_received')>0){
    $inv=transactions::where('debit_or_credit',1)->where('trans_type',$request->charges_type[$key])->where('trans_type_id', $invoices->id)->get()->pluck('id');
if($inv){
            trans_relations::create([
                'receipt'=>$tid->id,
                'invoice'=> $inv[0],
                 'account' =>  $acc->id
            ]);
}
}
//sending into trans relations

}

}

}


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

}
else{
  $invoices='';
    $exists=1;
}

        if ($invoices) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');

        }
        else if(!$invoices && $exists==1 && $tago==1) {
             Session::flash('message', 'Invoice has been created ! Check DataTable.');
            Session::flash('alert-class', 'alert-danger');

        }
        else if(!$invoices && $exists==1 && $tago==0) {
             Session::flash('message', 'Invoice already exists !');
            Session::flash('alert-class', 'alert-danger');

        }
        else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($receiveme) && !empty($addmore2) &&  $exists!=1){
            return redirect('finance-and-management/finance-invoices/finance-new-invoices-aeu');
        }
       else if(empty($receiveme) && !empty($addmore) &&  $exists!=1)
            {
                 return redirect('finance-and-management/finance-new-invoices/invoice/'.$request->invoice_no);
            }

          else if(empty($receiveme) && !empty($saveandreceive) &&  $exists!=1){
               if($request->invoice_type==0){
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'memid='. $request->member_id);
              }
              else if($request->invoice_type==6){
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'corporateid='. $request->corporate_id);
              }
              else  {
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/'.'?'. 'guestid='. $request->customer_id);
              }
            }
             else if(!empty($receiveme)  &&  $exists!=1){
                 return redirect('finance-and-management/finance-new-invoices/invoice/'.$request->invoice_no);
            }
            else{
               /* return redirect('finance-and-management/finance-new-invoices-vue');*/
                 return redirect('finance-and-management/finance-invoices/finance-new-invoices-aeu');
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
         $data['invoice_update'] = finance_invoice::where('invoice_no',$id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['invoice_update']->code;

    $data['gts']=guest_type::where('status',1)->get();
$data['main_types']=trans_type::where('type',1)->get();
$data['finance_invoice_charges_type']=trans_type::where('type',2)->orderby('name', 'ASC')->get();
$data['subscription_type']=trans_type::where('type',3)->orderby('name', 'ASC')->get();

        $memberfmid=$data['invoice_update']->member_id;
         $data['familymembers']=mem_family::with('relationship_name')->where('member_id',$memberfmid)->get();


    $data['bookingsubdata']=finance_invoice::where('invoice_no', $id)->where('status',null)->get();

$data['receiptstatus']   = 1;
$data['account_types']= trans_type::where('cash_or_payment',2)->where('type',7)->get();
$data['accounts']=coa_accounts_control::whereIn('cost_center',['1','2'])->get();

        return view('backend/finance-and-management.finance-invoices.finance-invoices-edit', $data);
  }



    public function update(Request $request, $id)
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
//            //'mem_no' => 'required',
//          'address' => 'required',
//         // 'ledger_amount' => 'required',
//          //  'cnic' => 'required',
//            //'contact' => 'required',
//            //'email' => 'required',
//
//           'final_total' => 'required',
//
//            'grand_total'=> 'required',
//             'amount_in_words'=> 'required',
//
//
//              'charges_type' => 'required',
//            'charges_amount'=> 'required',
//             'qty'=> 'required',
//              'sub_total'=> 'required'
           'charges_type.*' =>'required',
        'charges_amount.*' => 'required',
       // 'qty.*' => 'required',
        'sub_total.*' => 'required',
        'total.*' => 'required',

               ];
        if($request->get('invoice_type')==0){
            $validation['mem_no']='required';
            $validation['member_id']='required';
        }
        else if($request->get('invoice_type')==6){
          // $validation['cop_no']='required';
            $validation['corporate_id']='required';
        }
        else{
            $validation['customer_id']='required';

        }

          if($request->get('my_final_total')==0){
            $validation['comments']='required';
        }

        $this->validate($request, $validation);


 $d=[];
 $dd='';
       
        $cati ='';
      

        $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }


        if($request->get('member_id')){
          
                $dd=$request->get('member_id');

        if(membership::where('id',$request->get('member_id'))->exists()){
           $arr_coa=membership::where('id',$request->get('member_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
         //   $dd=$coa;
           $cati =  coaparent($coa);
         

          }else{
             
              $coa_code=null;
            $cati = memcategoryname($dd);
           
          
          }
        }
         else{
           $coa_code=null;
           $cati =  null;
        }
       
      }
       else if($request->get('corporate_id')){
          
                $dd=$request->get('corporate_id');

        if(corporateMembership::where('id',$request->get('corporate_id'))->exists()){
           $arr_coa=corporateMembership::where('id',$request->get('corporate_id'))->get()->pluck('mem_unique_code');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
            $coa_code=$coa;
         //   $dd=$coa;
           $cati =  coaparent($coa);
         

          }else{
             
              $coa_code=null;
            $cati = comemcategoryname($dd);
           
          
          }
        }
         else{
           $coa_code=null;
           $cati =  null;
        }
       
      }
        else if($request->get('customer_id')){
          
            $dd=$request->get('customer_id');

             if(customer::where('id',$request->get('customer_id'))->exists()){
           $arr_coa=customer::where('id',$request->get('customer_id'))->get()->pluck('account');
           if($arr_coa[0]){
            $coa=$arr_coa[0];
             $coa_code=$coa;
            
         //    $dd=$coa;
           $cati =  coaparent($coa);
            
          }else{
             $coa_code=null;
           $cati =  null;
         
          }
        }
        else{
           $coa_code=null;
           $cati =  null;
        }
 

        }



foreach($request->charges_type as $key=>$c){

    $charges=$request->sub_total[$key];

    $theprename='';
    $theprename=finance_invoice::where('id',$request->subid[$key])->get()->pluck('charges_type');
   // dd($theprename[0]);

    $invoices= finance_invoice::where('id',$request->subid[$key])->updateWithUserstamps([
        'coa_code' => $coa_code,
        'invoice_no' =>  $id,
        'invoice_date' => formatDate($request->invoice_date),
        'invoice_type' => $request->invoice_type>10?1:$request->invoice_type,
        'name' => $request->name,
        'customer_id'     =>  $request->customer_id,
        'member_id'     =>  $request->member_id,

         'corporate_id'     =>  $request->corporate_id,
        'mem_no' => $request->mem_no,

        'address' => $request->address,
        'ledger_amount' => $request->ledger_amount,
        'cnic' => $request->cnic,
        'contact' => $request->contact,
        'email' => $request->email,
        //'family' => $request->family,
        //'total' => $request->final_total[$key],

        'discount_details' => $request->discount_details,

      /*  'extra_charges' => $request->extra_charges[$key],*/

        'extra_details' => $request->extra_details,

      /*  'tax_charges' => $request->tax_charges[$key],*/

        'tax_details' => $request->tax_details,


//        'amount_in_words' => $request->amount_in_words,
        'comments' => $request->comments,

     'discount_amount' => isset($request->discount_amount[$key])?$request->discount_amount[$key]:null,
       'discount_percentage' => isset($request->discount_percentage[$key])?$request->discount_percentage[$key]:null,
       'extra_percentage' => isset($request->extra_percentage[$key])?$request->extra_percentage[$key]:null,
       'extra_charges' => isset($request->extra_charges[$key])?$request->extra_charges[$key]:null,
      'tax_percentage' => isset($request->tax_percentage[$key])?$request->tax_percentage[$key]:null,
      'grand_total' => isset($request->grand_total[$key])?$request->grand_total[$key]:null,
        'charges_type' => isset($request->charges_type[$key])?$request->charges_type[$key]:null,
        'charges_amount' => isset($request->charges_amount[$key])?$request->charges_amount[$key]:null,
         'per_day_amount' => isset($request->per_day_amount[$key])?$request->per_day_amount[$key]:null,
        'start_date' => isset($request->start_date[$key])?formatDate($request->start_date[$key]):null,
        'end_date' => isset($request->end_date[$key])?formatDate($request->end_date[$key]):null,
        'days' => isset($request->days[$key])?$request->days[$key]:null,
        'qty' => isset($request->qty[$key])?$request->qty[$key]:1,
        'sub_total' => isset($request->sub_total[$key])?$request->sub_total[$key]:null,
        'total' => isset($request->sub_total[$key])?$request->sub_total[$key]:null,
        'family' => isset($request->family[$key])?$request->family[$key]:null,

     ]);

//$request->charges_type[$key]
    if($request->invoice_type==0){

        if(transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->exists()){
             $transaction = transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->updateWithUserstamps([
           

          'type' =>  1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $request->subid[$key],
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  0,
            'trans_moc' => $dd,
               'trans_moc_category' => $cati,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date[$key]),
            'account'=>transTypesCoa($request->charges_type[$key]),
            'trans_coa'=>$coa_code,
            'unit'=>$ccc,
        ]);
        }
       else{
         $transaction = transactions::create([
           

          'type' =>  1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $request->subid[$key],
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  0,
            'trans_moc' => $dd,
               'trans_moc_category' => $cati,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date[$key]),
            'account'=>transTypesCoa($request->charges_type[$key]),
            'trans_coa'=>$coa_code,
            'unit'=>$ccc,
        ]);
       }
    }
    else if($request->invoice_type==6){

        if(transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->exists()){
             $transaction = transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->updateWithUserstamps([
           

          'type' =>  1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $request->subid[$key],
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  6,
            'trans_moc' => $dd,
               'trans_moc_category' => $cati,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date[$key]),
            'account'=>transTypesCoa($request->charges_type[$key]),
            'trans_coa'=>$coa_code,
            'unit'=>$ccc,
        ]);
        }
       else{
         $transaction = transactions::create([
           

          'type' =>  1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' =>  $request->subid[$key],
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  6,
            'trans_moc' => $dd,
               'trans_moc_category' => $cati,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date[$key]),
            'account'=>transTypesCoa($request->charges_type[$key]),
            'trans_coa'=>$coa_code,
            'unit'=>$ccc,
        ]);
       }
    }
    else {
if(transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->exists()){

        $transaction = transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->updateWithUserstamps([
            'type' =>  1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' => $request->subid[$key],
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  1,
            'trans_moc' =>  $dd,
                'trans_moc_category' => $cati,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date[$key]),
              'account'=>transTypesCoa($request->charges_type[$key]),
                'trans_coa'=>$coa_code,
                'unit'=>$ccc,
             //  'trans_moc_category' => ltrim($request->invoice_type, $request->invoice_type[0]),
        ]);
    }else{
  $transaction = transactions::create([
            'type' =>  1,
            'debit_or_credit' =>  1,
            'trans_type' =>  $request->charges_type[$key],
            'trans_type_id' => $request->subid[$key],
            'trans_amount' =>  $request->grand_total[$key],
            'trans_moc_type' =>  1,
            'trans_moc' =>  $dd,
                'trans_moc_category' => $cati,
            'is_active' =>  1,
            'date' =>  $request->start_date[$key]!=null?formatDate($request->start_date[$key]):formatDate($request->invoice_date[$key]),
              'account'=>transTypesCoa($request->charges_type[$key]),
                'trans_coa'=>$coa_code,
                'unit'=>$ccc,
             //  'trans_moc_category' => ltrim($request->invoice_type, $request->invoice_type[0]),
        ]);
    }
}



if($request->deleted_at[$key]!=null){
  /*finance_invoice::where('id',$request->subid[$key])->deleteWithUserstamps();*/
/*transactions::where('debit_or_credit',1)->where('trans_type',$request->charges_type[$key])->where('trans_type_id',$request->subid[$key])->deleteWithUserstamps();*/
finance_invoice::where('id',$request->subid[$key])->updateWithUserstamps([
 'status' => 'Cancelled',
/* 'grand_total' => 0,*/
     ]);

 transactions::where('type',0)->where('debit_or_credit',1)->where('trans_type',$theprename[0])->where('trans_type_id',$request->subid[$key])->updateWithUserstamps([
 'trans_amount' =>  0,
     ]);

}


}


       if ($invoices) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

/*
        if(!empty($addmore2)){
            return redirect('finance-and-management/finance-invoices/finance-new-invoices-aeu');
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
            else{*/
                return redirect('finance-and-management/finance-new-invoices-vue');
         /*   }
*/
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_payment_receipt  $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function old_update(Request $request, $id)
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
        else {

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
              else  {
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

   
        public function restorecancelled(finance_invoice $finance_invoice,$id)
    {
   $data['mi']=finance_invoice::where('invoice_no',$id)->where('status','Cancelled')->get();
  

foreach ($data['mi'] as $key => $value) {
//dd($value);

  if(transactions::where('debit_or_credit',1)->where('trans_type_id',$value->id)->where('trans_type',$value->charges_type)->exists())
{
$transaction = transactions::where('debit_or_credit',1)->where('trans_type_id',$value->id)->where('trans_type',$value->charges_type)->updateWithUserstamps([
 'trans_amount' =>  $value->grand_total,
     ]);
}


}


      $recipt=$finance_invoice::where('invoice_no', $id)->where('status','Cancelled')->updateWithUserstamps([
 'status' => null,
     ]);

     


        if($recipt){
            Session::flash('message', 'Invoice Restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Invoice Not Restored !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-cancelled-invoices-vue');
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

         $data['receiptdata']=finance_invoice::with('member')->with('customer')->with('corporatemember')->where('invoice_no',$id)->first();

         $data['mr']=finance_invoice::where('invoice_no',$id)->get()->pluck('charges_type');
         $data['mi']=finance_invoice::where('invoice_no',$id)->get()->pluck('id');

       $data['profiledata']=admin_company_profile::get()->first();

     $data['finance_invoice_charges_type']=finance_invoice_charges_type::where('status',1)->get();
$data['subscription_type']=sports_subscription::where('status',1)->get();


 $summe=finance_invoice::where('invoice_no',$id)->where('status',null)->get()->sum('grand_total');
  $v=transactions::where('debit_or_credit',0)->where('type',2)->whereIn('trans_type',$data['mr'])->whereIn('trans_type_id',$data['mi'])->get()->pluck('id');
      /*  $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');*/
        $b = (transactions::whereIn('id',$v)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

 $storein[]=[];
 $storedd[]=[];
 $storecc='';  
            foreach($b as $rv){

                if(!empty($rv['receipt_id'])) {
                  $accu=finance_cash_receipt::where('id',$rv['receipt_id'])->get()->pluck('account');
                 /* $datti=finance_cash_receipt::where('id',$rv['receipt_id'])->get()->pluck('invoice_date');*/
                  $datti=transactions::where('debit_or_credit',0)->where('type',2)->where('receipt_id',$rv['receipt_id'])->get()->pluck('date');

                     $creati=transactions::where('debit_or_credit',0)->where('type',2)->where('receipt_id',$rv['receipt_id'])->get();
                  $storein[]=$accu[0];
                  $storedd[]=$datti[0];

                  if($creati[0]){
                      $storecc=$creati[0]->created_by;
                  }
                  else{
                      $storecc='';  
                  }
                

             } 

            }

if($storein){
   $data['storage']=$storein;
}
   else{
     $data['storage']=[];
   }
if($storedd){
   $data['datedat']=$storedd;
}
   else{
     $data['datedat']=[];
   }


   if($storecc){
   $data['recby']=$storecc;
}
   else{
     $data['recby']='';
   }


//dd($data['storage']);

           $data['resultant'] = $summe-$x;
            $data['amount_paid'] = $x;


 $data['loggedinuser'] = auth()->user();

               $data['bookingsubdata']=finance_invoice::where('invoice_no',$id)->where('status',null)->get();


        return view('backend/finance-and-management.finance-invoices.invoice-new', $data);
    }


 public function destroy(Request $request,finance_invoice $finance_invoice,$id)
    { 
        $gimme=[];
        $giees=[];
    $data['mr']=finance_invoice::where('invoice_no',$id)->get()->pluck('charges_type');
    $data['mi']=finance_invoice::where('invoice_no',$id)->get()->pluck('id');


     $update= finance_invoice::where('invoice_no',$id)->updateWithUserstamps([
        'comments' => $request->remarks,
     ]);

      $recipt=$finance_invoice::where('invoice_no', $id)->deleteWithUserstamps();

if(transactions::where('debit_or_credit',1)->whereIn('trans_type_id',$data['mi'])->whereIn('trans_type',$data['mr'])->exists())
{
$transaction = transactions::where('debit_or_credit',1)->whereIn('trans_type_id',$data['mi'])->whereIn('trans_type',$data['mr'])->deleteWithUserstamps();
}

if(transactions::where('debit_or_credit',0)->whereIn('trans_type_id',$data['mi'])->whereIn('trans_type',$data['mr'])->exists())
{
  $gimme=transactions::where('debit_or_credit',0)->whereIn('trans_type_id',$data['mi'])->whereIn('trans_type',$data['mr'])->pluck('receipt_id');

  $giees=transactions::where('debit_or_credit',0)->whereIn('trans_type_id',$data['mi'])->whereIn('trans_type',$data['mr'])->pluck('id');

$transaction = transactions::where('debit_or_credit',0)->whereIn('trans_type_id',$data['mi'])->whereIn('trans_type',$data['mr'])->deleteWithUserstamps();
}

if(finance_cash_receipt::whereIn('id',$gimme)->exists())
{
 finance_cash_receipt::whereIn('id',$gimme)->deleteWithUserstamps();
}

if(trans_relations::whereIn('receipt',$giees)->exists())
{
 trans_relations::whereIn('receipt',$giees)->deleteWithUserstamps();
}
  

        if($recipt){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-new-invoices-vue');
    }



public function restore(finance_invoice $finance_invoice,$id)
    {

       $gimme='';
        $giees='';
  
        $restore = finance_invoice::onlyTrashed()->find($id)->restore();
         $chargestpe= $finance_invoice::where('id', $id)->get()->pluck('charges_type');

if(transactions::onlyTrashed()->where('debit_or_credit',1)->where('trans_type_id', $id)->where('trans_type',$chargestpe)->exists())
{
  $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$chargestpe)->where('debit_or_credit',1)->restore();
}


if(transactions::onlyTrashed()->where('debit_or_credit',0)->where('trans_type_id', $id)->where('trans_type',$chargestpe)->exists())
{

    $gimme=transactions::onlyTrashed()->where('debit_or_credit',0)->where('trans_type_id',$id)->where('trans_type',$chargestpe)->pluck('receipt_id');

  $giees=transactions::onlyTrashed()->where('debit_or_credit',0)->where('trans_type_id',$id)->where('trans_type',$chargestpe)->pluck('id');


  $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$chargestpe)->where('debit_or_credit',0)->restore();
}


if(finance_cash_receipt::onlyTrashed()->where('id',$gimme)->exists())
{
 finance_cash_receipt::onlyTrashed()->where('id',$gimme)->restore();
}

if(trans_relations::onlyTrashed()->where('receipt',$giees)->exists())
{
 trans_relations::onlyTrashed()->where('receipt',$giees)->restore();
}
  

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
