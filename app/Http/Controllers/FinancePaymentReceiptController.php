<?php

namespace App\Http\Controllers;
use App\guest_type;
use App\finance_payment_receipt;
use Spatie\Permission\Models\Permission;
use App\finance_account_head;
use App\finance_account_type;
use App\finance_invoice;
use App\trans_type;
use App\trans_relations;
use App\transactions;
use Illuminate\Http\Request;
use DataTables;
use App\sports_subscription;
use App\finance_payment_receivable;
use App\customer;
use App\hr_employment;
use App\finance_payment_methods;
use App\membership;
use App\mem_family;
use App\mem_address;
use App\payment_receipts_sub;
use App\admin_company_profile;
use Illuminate\Support\Facades\Auth;
use Session;
use App\coa_accounts_control;
use App\finance_ledger_person;
use App\fnb_predefined_value;
use App\coa_account;

class FinancePaymentReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index_vue(Request $request, finance_payment_receipt $finance_payment_receipt)
    {

      return view('backend/finance-and-management/finance-payment-receipts/finance-payment-receipts-vue');

    }

       public function paymentrecs_init(Request $request)
    {
//$c=Auth::user()->getAllPermissions()->pluck('id')->toArray();
        $data['mains']=   [];
        $data['charges']=   [];
        $data['aa']=   [];

        $data['subscriptions']=   [];
        $dx=trans_type::where('type','>=',4)->where('cash_or_payment','>=',1)->get();
        foreach ($dx as $cm){
            $dcm=$cm->name;
            $dcm2=$cm->mod_id;
            if($cm->type!=6){

$ndcm = $dcm.' '.$dcm2;
            }
            else{
                $ndcm = $dcm;
            }
           /* if($cm->type==6){
              $dcm="Payment Receipt";
                $dcm2=$cm->id;

            }*/
            if(auth()->user()->can($ndcm)){
                if($cm->type==6){
                    $data['mains'][]=$cm;
                }elseif($cm->type==4){
                    $data['charges'][]=$cm;

                }elseif($cm->type==5){
                    $data['subscriptions'][]=$cm;

                }
                $data['aa'][]=$cm->id;
            }
        }

 $data['paymentrecs'] =\Illuminate\Support\Facades\DB::select('
select finance_payment_receipts.*,customers.customer_name as customer,finance_ledger_people.person_name as person,hr_employments.name as employee,
group_concat(t1.id) as transtype2,
  memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  memberships.mem_no as mem_no,
    mem_statuses.desc as activity,
    users.name as cashiername,
   group_concat(concat(transactions.trans_type_id," - (",t1.name,")"," ",if(mem_families.name is null,"",mem_families.name)) SEPARATOR "<br>") as tid,
       t2.name as payment_method
    from finance_payment_receipts

left outer join transactions on transactions.receipt_id=finance_payment_receipts.id and transactions.debit_or_credit=1 and transactions.type=5 and transactions.deleted_at is null

left outer join users on users.id =finance_payment_receipts.created_by and users.status=1
left outer join trans_types t1 on t1.id=transactions.trans_type
left outer join trans_types t2 on t2.id=finance_payment_receipts.account and t2.type=7
left outer join customers on customers.id=finance_payment_receipts.customer_id
left outer join finance_ledger_people on finance_ledger_people.id=finance_payment_receipts.person_id
left outer join hr_employments on hr_employments.id=finance_payment_receipts.employee_id
left outer join memberships on memberships.id=finance_payment_receipts.mem_number and memberships.deleted_at is null
left outer join mem_statuses on mem_statuses.id=memberships.active and mem_statuses.status=1
left outer join finance_invoices on finance_invoices.id=transactions.trans_type_id
left outer join mem_families on mem_families.id=finance_invoices.family
where finance_payment_receipts.deleted_at  is null group by finance_payment_receipts.id order by finance_payment_receipts.id desc');

/*left outer join trans_relations on trans_relations.receipt in (select id from transactions where transactions.receipt_id=finance_payment_receipts.id and transactions.deleted_at is null)*/


          /* $data['paymentrecs'] =\Illuminate\Support\Facades\DB::select('
select finance_payment_receipts.*,customers.customer_name as customer,finance_ledger_people.person_name as person,hr_employments.name as employee,
group_concat(t1.id) as transtype2,
  memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,
  memberships.mem_no as mem_no,
   group_concat(concat(transactions.trans_type_id," - (",t1.name,")"," ",if(mem_families.name is null,"",mem_families.name)) SEPARATOR "<br>") as tid,
       t2.name as payment_method
    from finance_payment_receipts
left outer join trans_relations on trans_relations.receipt in (select id from transactions where transactions.receipt_id=finance_payment_receipts.id and transactions.deleted_at is null)
left outer join transactions on transactions.id=trans_relations.invoice and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join trans_types t1 on t1.id=transactions.trans_type
left outer join trans_types t2 on t2.id=finance_payment_receipts.account and t2.type=7
left outer join customers on customers.id=finance_payment_receipts.customer_id
left outer join finance_ledger_people on finance_ledger_people.id=finance_payment_receipts.person_id
left outer join hr_employments on hr_employments.id=finance_payment_receipts.employee_id
left outer join memberships on memberships.id=finance_payment_receipts.mem_number and memberships.deleted_at is null
left outer join finance_invoices on finance_invoices.id=transactions.trans_type_id
left outer join mem_families on mem_families.id=finance_invoices.family
where finance_payment_receipts.deleted_at  is null group by finance_payment_receipts.id having transtype2 in ('.implode(',',$data['aa']).')  order by finance_payment_receipts.id desc');*/

   $data['accTypes']=   trans_type::where('cash_or_payment',2)->where('type',7)->get();
 $data['accpermit']=Auth::user()->getAllPermissions()->where('category',23)->pluck('name');
    $data['gts']=guest_type::where('status',1)->get();
    
     return $data;

}

    public function index(Request $request, finance_payment_receipt $finance_payment_receipt)
    {
    $data['mains']=   trans_type::where('type',6)->where('cash_or_payment',1)->get();
    $data['types']=   trans_type::where('type',4)->where('cash_or_payment',1)->get();
    $data['payables']=   trans_type::where('type',5)->where('cash_or_payment',1)->get();
        $data['receiptstatus']   = 0;
      /*  $data['types']= finance_invoices_modules_list::select('id','name')->get()->keyBy('id');*/
        return view('backend/finance-and-management/finance-payment-receipts/finance-payment-receipts', $data);
    }

     public function indexdt(Request $request, finance_payment_receipt $finance_payment_receipt)
    {
        $r=finance_payment_receipt::query();
        if($request->get('mog')==0){


            if($request->get('customer')){
                $x=$request->get('customer');

//                $c=membership::where('applicant_name','like',"%$x%")->first();
                $r->where('mem_number',$x);

            }
        }
        else if($request->get('mog')==1){
            if($request->get('customer')){
            $x=$request->get('customer');

//            $c=customer::where('customer_name','like',"%$x%")->first();
                $r->where('customer_id',$x);
            }

        }
         else if($request->get('mog')==2){
            if($request->get('customer')){
            $x=$request->get('customer');

//            $c=customer::where('customer_name','like',"%$x%")->first();
                $r->where('person_id',$x);
            }

        }
        else if($request->get('mog')==3){
            if($request->get('customer')){
            $x=$request->get('customer');

//            $c=customer::where('customer_name','like',"%$x%")->first();
                $r->where('employee_id',$x);
            }

        }
        else{
            if($request->get('customer')){
            $x=$request->get('customer');

//            $c=customer::where('customer_name','like',"%$x%")->first();
                $r->where('id','');


            }

        }

        if($request->get('start_date')){
            $r->where('invoice_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('invoice_date','<=',formatDate($request->get('end_date')));

        }
        if($request->get('receipt')){
            $r->where('id','=',$request->get('receipt'));

        } if($request->get('type')){

        $r->whereHas('transactions',function ($q) use ($request){
            $q->where('trans_type',$request->get('type'));
        });
        //$r->groupBy('finance_payment_receipts.id');
          //  $r->where('trans_type','=',$request->get('type'));

        }

//        $reID=[];

        $receipts = $r->get();
//dd($receipts);

//        $receipts = $r->orWwhere('payment_received_for',0)->get();

        $data= DataTables::of($receipts)


            ->addColumn('editbutton', function ($receipts) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/') . '/' . $receipts->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })


            ->addColumn('deletebutton', function ($receipts) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-payment-receipts/delete') . '/' . $receipts->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


             ->addColumn('invoice_no', function ($receipts) {
                return $receipts->id;
            })


             ->addColumn('detail', function ($receipts) {
//                $receipts->transaction
                $s=transactions::where('receipt_id',$receipts->id)->get()->pluck('id');
                $v=trans_relations::whereIn('receipt',$s)->get()->pluck('invoice');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit',0)->get()->toArray(1));
            //   return json_encode($receipts);

                $x='';
                $f= trans_type::select('id','name','details')->get()->keyBy('id');

                foreach($b as $v){
                    $link='';
                    $r='Room';
                    if(isset($f[$v['trans_type']])){
                        $r=$f[$v['trans_type']]['name'];
                    }
//                    dd($f[$v['trans_type']]);

                      $link =  '<a target="_blank" href="'.route($f[$v['trans_type']]['details'],$v['trans_type_id']).'">'.$v['trans_type_id'].'</a>';


                    $x= $x. $link .'('. $r.')<br>';

                }

                return $x;
            })


            ->addColumn('receipt_type', function ($receipts) {
                if($receipts->mem_number!=null){
                    return "Member";
                }
                else if($receipts->customer_id!=null){
                    return "Guest";
                }
                else if($receipts->employee_id!=null){
                    return "Employee";
                }
                else if($receipts->person_id!=null){
                    return "Supplier";
                }



                })  ->addColumn('guest_name', function ($receipts) {
                if($receipts->mem_number!=null){
                return   $receipts->member->applicant_name;
                }
                else if($receipts->customer_id!=null){
                   return $receipts->customer->customer_name;

                }
                else if($receipts->employee_id!=null){
                    return $receipts->employee->name;
                }
                else if($receipts->person_id!=null){
                    return $receipts->person->person_name;
                }



                })


                 ->addColumn('guest_contact', function ($receipts) {
                if($receipts->mem_number!=null){
                return   $receipts->member->mob_a;
                }
                else if($receipts->customer_id!=null){
                   return $receipts->customer->customer_contact;

                }
                else if($receipts->employee_id!=null){
                    return $receipts->employee->mob_a;
                }
                else if($receipts->person_id!=null){
                    return $receipts->person->person_contact;
                }


                })


   ->addColumn('customer_id', function ($receipts) {
                if($receipts->mem_number!=null){
                return    $receipts->member->mem_no;
                }
                else if($receipts->customer_id!=null){
                   return   $receipts->customer->id;
                }
                else if($receipts->employee_id!=null){
                   return   $receipts->employee->id;
                }
                else if($receipts->person_id!=null){
                   return   $receipts->person->id;
                }

          //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;
                })

    ->addColumn('invoice_date', function ($receipts) {
              return formatDateToShow($receipts->invoice_date);


                })

             ->addColumn('status', function ($receipts) {
                 return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-payment-receipts/finance-payment-receipts-invoice/') . '/' . $receipts->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

           ->addColumn('account', function ($receipts) {
            if($receipts->account){
                    return transTypesChargesTypes($receipts->account);
                }
            })


            ->rawColumns(['editbutton','detail', 'deletebutton', 'status', 'receipt_type', 'account', 'guest_contact', 'invoice_no', 'guest_name', 'customer_id', 'invoice_date'])

             ->addIndexColumn()
            ->make(true)->getData(true);
        $data['cTotal']=number_format($receipts->count('id'));
        $data['dTotal']=number_format($receipts->sum('total'));
        return $data;
    }


     public function index_deleted(Request $request, finance_payment_receipt $finance_payment_receipt)
    {
       $data['receiptstatus']   = 0;
        return view('backend/finance-and-management/finance-payment-receipts/finance-payment-receipts-deleted',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_payment_receipt $finance_payment_receipt)
    {

        $receipts = finance_payment_receipt::onlyTrashed()->get();
        return DataTables::of($receipts)

              ->addColumn('invoice_no', function ($receipts) {
                return $receipts->id;
            })

              ->addColumn('detail', function ($receipts) {
//                $receipts->transaction
                $s=transactions::where('receipt_id',$receipts->id)->get()->pluck('id');
                $v=trans_relations::whereIn('receipt',$s)->get()->pluck('invoice');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit',0)->get()->toArray(1));
            //   return json_encode($receipts);

                $x='';
                $f= trans_type::select('id','name','details')->get()->keyBy('id');

                foreach($b as $v){
                    $link='';
                    $r='';
                    if(isset($f[$v['trans_type']])){
                        $r=$f[$v['trans_type']]['name'];
                    }
//                    dd($f[$v['trans_type']]);

                      $link =  '<a target="_blank" href="'.route($f[$v['trans_type']]['details'],$v['trans_type_id']).'">'.$v['trans_type_id'].'</a>';


                    $x= $x. $link .'('. $r.')<br>';

                }

                return $x;
            })


        ->addColumn('account', function ($receipts) {
            if($receipts->account){
                    return transTypesChargesTypes($receipts->account);
                }
            })


 ->addColumn('receipt_type', function ($receipts) {
                if($receipts->mem_number!=null){
                    return "Member";
                }
                else if($receipts->customer_id!=null){
                    return "Guest";
                }
                else if($receipts->employee_id!=null){
                    return "Employee";
                }
                else if($receipts->person_id!=null){
                    return "Supplier";
                }



                })  ->addColumn('guest_name', function ($receipts) {
                if($receipts->mem_number!=null){
                return   $receipts->member->applicant_name;
                }
                else if($receipts->customer_id!=null){
                   return $receipts->customer->customer_name;

                }
                else if($receipts->employee_id!=null){
                    return $receipts->employee->name;
                }
                 else if($receipts->person_id!=null){
                    return $receipts->person->person_name;
                }



                })


                 ->addColumn('guest_contact', function ($receipts) {
                if($receipts->mem_number!=null){
                return   $receipts->member->mob_a;
                }
                else if($receipts->customer_id!=null){
                   return $receipts->customer->customer_contact;

                }
                else if($receipts->employee_id!=null){
                    return $receipts->employee->mob_a;
                }
                else if($receipts->person_id!=null){
                    return $receipts->person->person_contact;
                }



                })


   ->addColumn('customer_id', function ($receipts) {
                if($receipts->mem_number!=null){
                return    $receipts->member->mem_no;
                }
                else if($receipts->customer_id!=null){
                   return   $receipts->customer->id;
                }
                else if($receipts->employee_id!=null){
                   return   $receipts->employee->id;
                }
                else if($receipts->person_id!=null){
                   return   $receipts->person->id;
                }

          //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


                })

    ->addColumn('invoice_date', function ($receipts) {
              return formatDateToShow($receipts->invoice_date);


                })

       ->addColumn('deleted_at', function ($receipts) {
              return formatDateToShow($receipts->deleted_at);


                })

            ->addColumn('restorebutton', function ($receipts) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-payment-receipts/restore/') . '/' . $receipts->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })


        ->rawColumns(['restorebutton', 'receipt_type', 'account', 'guest_name' ,'guest_contact', 'customer_id', 'invoice_date', 'detail', 'invoice_no'])
        ->addIndexColumn()
        ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activate($id){
        $x=transactions::find($id);
        $x->is_active=1;
        $x->save();
    }
    public function init(Request $request){
        $lastval=[];
        if($request->get('r')){
            $lastval=finance_payment_receipt::find($request->get('r'));
            $lastval['member']=membership::find($lastval['mem_number']);
        }
        else{
            $lastval = finance_payment_receipt::withTrashed()->latest('id')->first();

        }
        if($lastval==null){
            $lastval['id'] =0;
        }
//        echo 123;
//        dd(Auth::user()->getAllPermissions()->where('category',21)->pluck('name')->toArray());
         $lastval['pms']=finance_payment_methods::where('status',1)->get();
                $lastval['gts']=guest_type::where('status',1)->get();
        $lastval['catspermit']=Auth::user()->getAllPermissions()->where('category',21)->pluck('name')->toArray();
        $lastval['accpermit']=Auth::user()->getAllPermissions()->where('category',23)->pluck('name');
      /*  $lastval['account_types']=finance_account_type::where('status',1)->with('account_head')->get();*/
         $lastval['account_types']=trans_type::where('type',7)->where('cash_or_payment',2)->get();
        $lastval['accounts']=coa_accounts_control::whereIn('cost_center',['1','2'])->get();
        $lastval['filters']=trans_type::select('id','name','mod_id')->get();
         $lastval['units']=coa_account::get();
         $lastval['coaaccounts']=coa_accounts_control::all();
              $lastval['companies']=coa_account::wherenotnull('desc')->get();

//        dd(trans_type::all());
        return ['invoice_no'=>$lastval];
    }

    public function save(Request $request){
//        dd($request->all());
        $d=[];
        $moc=0;
        $dd='';
       
        $cati ='';

          $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }
      
       // dd($request->get('person_id'));
     /*   if($request->get('member_id')){
$d['mem_number']=$request->get('member_id');

        }

        else if($request->get('customer_id')){
            $moc=1;

            $d['customer_id']=$request->get('customer_id');

        }
        else if($request->get('employee_id')){
            $moc=3;

            $d['employee_id']=$request->get('employee_id');

        }
        else if($request->get('person_id')){
            $moc=2;

            $d['person_id']=$request->get('person_id');

        }*/


           if($request->get('person_id')){
            $moc=2;
  $d['person_id']=$request->get('person_id');
            $dd=$d['person_id'];

             if(finance_ledger_person::where('id',$request->get('person_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('person_id'))->get()->pluck('account');
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
$d['advance']= $request->get('advance');
  $d['receipt_type']=$moc;
   $d['coa_trans_type']=$request->get('account');
        $d['amount_in_words']=$request->get('amount_in_words');
        $d['account']=$request->get('payment_method');
        $d['family']=$request->get('family');
        $d['remarks']=$request->get('remarks');
        $d['total']=$request->get('total')+$request->get('sur');
        $d['surcharge']=$request->get('sur');
        $d['total_amount']=$request->get('total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));
        $d['payment_mode_details']=$request->get('payment_mode_details');
      $id=  finance_payment_receipt::create($d);
//      dd();
        foreach($request->get('invoices') as $inv){
//            var_dump($inv);
if((isset($inv['p'])) && $inv['p']>0){
/*if($moc==3){
$dd=$d['employee_id'];
$cati =null;
}
else if($moc==2){
$dd=$d['person_id'];
$cati =null;
}
 else if($moc==0){
$dd=$d['mem_number'];
$cati = memcategoryname($dd);
}
else  if($moc==1){
$dd=$d['customer_id'];
$cati =null;

} */

    if($request->get('advance')==1){
       $m=  transactions::create([
               
               'type'=>5,
               'debit_or_credit'=>1,
               'trans_type'=>$inv['trans_type'],
               'trans_type_id'=>$inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_type'=>$moc,
               'trans_moc_category' => $cati,
               'receipt_id'=>$id->id,
               'date'=>$d['invoice_date'],
              // 'payment_method'=>$d['account'],
               'payment_method'=>20,
              // 'unit'=> $ccc,
              // 'account'=>transTypesCoa($inv['trans_type']),
               'unit'=> $inv['unit'],
               'account'=>$inv['account'],
               'trans_coa'=>$d['coa_code'],
               'ent'=>4,

            ]);
           $acc=  transactions::create([

               'type'=>7,
               'debit_or_credit'=>0,
               'trans_type'=>27,
               'trans_type_id'=> $inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$moc,
               'receipt_id'=>$id->id,
               'date'=>$d['invoice_date'],
               'payment_method'=>20,
               'unit'=> $inv['unit'],
               'is_active'=>1,
               'account'=>transTypesCoa(27),
                'trans_coa'=>$d['coa_code'],
                 'ent'=>4,

            ]);
    }

    else{
           $m=  transactions::create([
               
               'type'=>5,
               'debit_or_credit'=>1,
               'trans_type'=>$inv['trans_type'],
               'trans_type_id'=>$inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_type'=>$moc,
               'trans_moc_category' => $cati,
               'receipt_id'=>$id->id,
               'date'=>$d['invoice_date'],
               'payment_method'=>$d['account'],
               'unit'=> $inv['unit'],
               //'account'=>transTypesCoa($inv['trans_type']),
                 'account'=>$inv['account'],
               'trans_coa'=>$d['coa_code'],

            ]);
           $acc=  transactions::create([

               'type'=>3,
               'debit_or_credit'=>0,
               'trans_type'=>$inv['trans_type'],
               'trans_type_id'=> $inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$moc,
               'receipt_id'=>$id->id,
               'date'=>$d['invoice_date'],
               'payment_method'=>$d['account'],
               'unit'=> $inv['unit'],
               'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$d['coa_code'],

            ]);
    }

            trans_relations::create([
               'receipt'=>$m->id,
                'invoice'=>$inv['id'],
                 'account' =>  $acc->id
            ]);
}
        }

         return $id->id;

    }
    public function updated(Request $request){
//        dd($request->all());
        $d=[];
        $moc=0;
        $dd='';
        $cati ='';
     

           $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }

      if($request->get('person_id')){
            $moc=2;
  $d['person_id']=$request->get('person_id');
            $dd=$d['person_id'];

             if(finance_ledger_person::where('id',$request->get('person_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('person_id'))->get()->pluck('account');
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

    /*
        if($request->get('member_id')){
$d['mem_number']=$request->get('member_id');
        }

        else if($request->get('customer_id')){
            $moc=1;

            $d['customer_id']=$request->get('customer_id');

        }
        else if($request->get('employee_id')){
            $moc=3;

            $d['employee_id']=$request->get('employee_id');

        }
        else if($request->get('person_id')){
            $moc=2;

            $d['person_id']=$request->get('person_id');

        }*/
        $d['advance']= $request->get('advance');
         $d['receipt_type']=$moc;
         $d['coa_trans_type']=$request->get('account');
        $d['amount_in_words']=$request->get('amount_in_words');
        $d['account']=$request->get('payment_method');
        $d['family']=$request->get('family');
        $d['remarks']=$request->get('remarks');
        $d['total']=$request->get('total')+$request->get('sur');
        $d['surcharge']=$request->get('sur');
        $d['total_amount']=$request->get('total');
        $d['invoice_date']=formatDate($request->get('invoice_date'));
          $d['payment_mode_details']=$request->get('payment_mode_details');
      $id=  finance_payment_receipt::where(
          'id',$request->get('id'))->updateWithUserstamps($d);
//      dd();
        foreach($request->get('invoices') as $inv){
/* if($moc==3){
$dd=$d['employee_id'];
$cati =null;
}
else if($moc==2){
$dd=$d['person_id'];
$cati =null;
}
 else if($moc==0){
$dd=$d['mem_number'];
$cati = memcategoryname($dd);
}
else  if($moc==1){
$dd=$d['customer_id'];
$cati =null;

}*/
//            dd($inv);
if((isset($inv['p']))){
/*
var_dump([
    'type'=>5,
    'debit_or_credit'=>1,
    'trans_type'=>$inv['trans_type'],
    'trans_type_id'=>$inv['trans_type_id'],
    'trans_amount'=>$inv['p'],
    'trans_moc'=>$dd,
    'trans_moc_type'=>$moc,
    'trans_moc_category' => $cati,
    'receipt_id'=>$request->get('id'),
      'date'=>$d['invoice_date'],
                'payment_method'=>$d['account'],
                'unit'=>$inv['unit'],
               'account'=>transTypesCoa($inv['trans_type']),
                'trans_coa'=>$d['coa_code'],
]);*/


 $d['ent'] = 0;
if(transactions::where('receipt_id',$request->get('id'))->where('type',5)->where('debit_or_credit',1)->where('trans_type_id',$inv['trans_type_id'])->exists()){
  if($request->get('advance')==1){
    $d['account'] = 20;
     $d['ent'] = 4;
  }

    $m= transactions::where('receipt_id',$request->get('id'))->where('type',5)->where('debit_or_credit',1)->where('trans_type_id',$inv['trans_type_id'])->updateWithUserstamps([
 
               'type'=>5,
               'debit_or_credit'=>1,
               'trans_type'=>$inv['trans_type'],
               'trans_type_id'=>$inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_type'=>$moc,
               'trans_moc_category' => $cati,
               'receipt_id'=>$request->get('id'),
               'date'=>$d['invoice_date'],
                'payment_method'=>$d['account'],
               'unit'=>$inv['unit'],
               //'account'=>transTypesCoa($inv['trans_type']),
                'account'=>$inv['account'],
               'trans_coa'=>$d['coa_code'],
               'ent'=>$d['ent'],

            ]);
}
else{

  if($request->get('advance')==1){
    $d['account'] = 20;
      $d['ent'] = 4;
  }
    $m=  transactions::create([
               'type'=>5,
               'debit_or_credit'=>1,
               'trans_type'=>$inv['trans_type'],
               'trans_type_id'=>$inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_type'=>$moc,
               'trans_moc_category' => $cati,
               'receipt_id'=>$request->get('id'),
               'date'=>$d['invoice_date'],
                'payment_method'=>$d['account'],
                'unit'=>$inv['unit'],
               //'account'=>transTypesCoa($inv['trans_type']),
                 'account'=>$inv['account'],
                'trans_coa'=>$d['coa_code'],
                'ent'=>$d['ent'],
    ]);
}


  if($request->get('advance')==1){
    if(transactions::where('type',7)->where('debit_or_credit',0)->where('trans_type',27)->where('trans_type_id',$inv['trans_type_id'])->where('receipt_id',$request->get('id'))->exists()){
    $acc=  transactions::where('type',7)->where('debit_or_credit',0)->where('trans_type',27)->where('trans_type_id',$inv['trans_type_id'])->where('receipt_id',$request->get('id'))->updateWithUserstamps([
            

                 'type'=>7,
               'debit_or_credit'=>0,
               'trans_type'=>27,
               'trans_type_id'=> $inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$moc,
               'receipt_id'=>$request->get('id'),
               'date'=>$d['invoice_date'],
               'payment_method'=>20,
                 'unit'=> $inv['unit'],
               'is_active'=>1,
               'account'=>transTypesCoa(27),
                'trans_coa'=>$d['coa_code'],
                 'ent'=>4,

            ]);
}
else{
     $acc=  transactions::create([
              
                 'type'=>7,
               'debit_or_credit'=>0,
               'trans_type'=>27,
               'trans_type_id'=> $inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$moc,
               'receipt_id'=>$request->get('id'),
               'date'=>$d['invoice_date'],
               'payment_method'=>20,
                'unit'=> $inv['unit'],
               'is_active'=>1,
               'account'=>transTypesCoa(27),
                'trans_coa'=>$d['coa_code'],
                 'ent'=>4,

            ]);
}
  }
  else{
    if(transactions::where('type',3)->where('debit_or_credit',0)->where('trans_type',$inv['trans_type'])->where('trans_type_id',$inv['trans_type_id'])->where('receipt_id',$request->get('id'))->exists()){
    $acc=  transactions::where('type',3)->where('debit_or_credit',0)->where('trans_type',$inv['trans_type'])->where('trans_type_id',$inv['trans_type_id'])->where('receipt_id',$request->get('id'))->updateWithUserstamps([
               'type'=>3,
               'debit_or_credit'=>0,
                'trans_type'=>$inv['trans_type'],
                'trans_type_id'=> $inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$moc,
               'receipt_id'=>$request->get('id'),
               'date'=>$d['invoice_date'],
               'payment_method'=>$d['account'],
                'unit'=>$inv['unit'],
               'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$d['coa_code'],

            ]);
}
else{
     $acc=  transactions::create([
               'type'=>3,
               'debit_or_credit'=>0,
               'trans_type'=>$inv['trans_type'],
               'trans_type_id'=> $inv['trans_type_id'],
               'trans_amount'=>$inv['p'],
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$moc,
               'receipt_id'=>$request->get('id'),
               'date'=>$d['invoice_date'],
               'payment_method'=>$d['account'],
               'unit'=>$inv['unit'],
               'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$d['coa_code'],

            ]);
}
  }

/*
if(transactions::where('type',3)->where('debit_or_credit',0)->where('trans_type',$inv['trans_type'])->where('receipt_id',$request->get('id'))->exists()){
    $accid =transactions::where('type',3)->where('debit_or_credit',0)->where('trans_type',$inv['trans_type'])->where('receipt_id',$request->get('id'))->get()->pluck('id');
}*/

/*if(trans_relations::where('receipt',$inv['receipts2'][0]['receipt'])->where('invoice',$inv['id'])->exists()){
     trans_relations::where('receipt',$inv['receipts2'][0]['receipt'])->where('invoice',$inv['id'])->updateWithUserstamps([
               'receipt'=>$inv['receipts2'][0]['receipt'],
                'invoice'=>$inv['id'],
                'account' =>  $accid[0]
            ]);
}
else{
    trans_relations::create([
               'receipt'=>$inv['receipts2'][0]['receipt'],
                'invoice'=>$inv['id'],
                'account' =>  $acc->id
        ]);
}
*/
        }
    }

}


    public function create(Request $request)
    {
//        dd(123);

        $lastval = finance_payment_receipt::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['payment_update'] = '';

         $data['sports_subscription']=sports_subscription::get();
       //  $data['finance_payment_receivable']=finance_payment_receivable::where('status',1)->get();


 $data['receiptstatus']   = 0;
 $data['payment_methods']=finance_payment_methods::where('status',1)->get();
 $data['profiledata']=admin_company_profile::get()->first();

  $customernumber=$request->customerid;
      $MOC=$request->MOC;
      if($MOC==1){
    //
       }
      else{
         $data['familymembers']=mem_family::where('member_id',$customernumber)->get();

         }
        if($request->get('invoice_no')){
            $invoice=finance_invoice::find($request->get('invoice_no'));
            $data['invoice']=$invoice;
        }

        return view('backend/finance-and-management.finance-payment-receipts.finance-payment-receipts-aeu', $data);
    }


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
        $this->validate($request, [

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            //'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


         'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);

        $receipts = finance_payment_receipt::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
            'account' => $request->account,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
             'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks

        ]);


        if ($receipts) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$receipts->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-payment-receipts/finance-payment-receipts-invoice/'.$getlastinsert);
            }else{
                return redirect('finance-and-management/finance-payment-receipts');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_payment_receipt  $finance_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(finance_payment_receipt $finance_payment_receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_payment_receipt  $finance_payment_receipt
     * @return \Illuminate\Http\Response
     */
     public function edit(finance_payment_receipt $finance_payment_receipt,$id)
    {
     $data['id']=$id;
     $data['init']=0;

        return view('backend/finance-and-management.finance-payment-receipts.finance-payment-receipts-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_payment_receipt  $finance_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [


            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'receipt_type' => 'required',
            'guest_name' => 'required',
            //'mem_number' => 'required',
           // 'customer_id' => 'required',
           // 'mem_number' => 'required',
            'guest_address' => 'required',
           'guest_contact' => 'required',
            //'ledger_amount' => 'required',


/*            'start_date' => 'required',
            'end_date' => 'required',*/


           'payment_received_for' => 'required',
        //   'subscriptions' => 'required',
         // 'total_sub_amount' => 'required',
          //  'surcharge' => 'required',
            'total' => 'required',
    /*         'discount' => 'required',*/
              'total_amount' => 'required',
            'amount_in_words'=> 'required',
            'payment_method' => 'required',
           // 'cheaque_no' => 'required',


     'payment_details' => 'required',
           // 'remarks' => 'required'
        ]);
        $receipt = finance_payment_receipt::where('id', $id)->updateWithUserstamps([
           'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'receipt_type' => $request->receipt_type,
            'guest_name' => $request->guest_name,
            'customer_id' => $request->customer_id,
            'mem_number' => $request->mem_number,
            //'mem_number' => $request->mem_number,
            'guest_address' => $request->guest_address,
           'guest_contact' => $request->guest_contact,
           'ledger_amount' => $request->ledger_amount,
            'family' => $request->family,
            'account' => $request->account,
        //    'start_date' => $request->start_date,
        //    'end_date' => $request->end_date,
            'payment_received_for' => $request->payment_received_for,
        //    'subscriptions' => $request->subscriptions,
        //     'total_sub_amount' => $request->total_sub_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,
        //     'discount' => $request->discount,
              'total_amount' => $request->total_amount,
            'amount_in_words' => $request->amount_in_words,
            'payment_method' => $request->payment_method,
            'payment_mode_details' => $request->payment_mode_details,
            'cheaque_no' => $request->cheaque_no,

             'payment_details' => $request->payment_details,
            'remarks' => $request->remarks
        ]);


    if ($receipt) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/'.$id);

    }

 public function destroy(Request $request,finance_payment_receipt $finance_payment_receipt,$id)
    {
     $update= finance_payment_receipt::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$finance_payment_receipt::where('id', $id)->deleteWithUserstamps();
      $transaction= transactions::where('receipt_id', $id)->deleteWithUserstamps();
    }
    /*public function destroy(finance_payment_receipt $finance_payment_receipt,$id)
    {
        $recipt=$finance_payment_receipt::where('id', $id)->deleteWithUserstamps();
        $transaction= transactions::where('receipt_id', $id)->deleteWithUserstamps();

        if($recipt){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-payment-receipts-vue');
    }*/



     function calculateextracharges($id){
      $charges=sports_subscription::where('id',$id)->first();
      return $charges->charges;
    }


public function restore(finance_payment_receipt $finance_payment_receipt,$id)
    {
        $restore = finance_payment_receipt::onlyTrashed()->find($id)->restore();
        $transaction = transactions::onlyTrashed()->where('receipt_id', $id)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-payment-receipts/deleted');

}

 public function invoice(finance_payment_receipt $finance_payment_receipt,$id)
    {
        $data['receiptstatus']=0;
         $data['receiptdata']=finance_payment_receipt::where('id',$id)->first();
  /*     $data['profiledata']=admin_company_profile::get()->first();*/
   

           $rid=$data['receiptdata']->payment_received_for;
        // $data['finance_payment_receivable']=finance_payment_receivable::where('id',$rid)->first();

         $rid=$data['receiptdata']->payment_method;
         $data['finance_payment_methods']=finance_payment_methods::where('id',$rid)->first();

         $typeid=$data['receiptdata']->account;
 $data['accounttype']=finance_account_type::with('accounttypes')->where('id',$typeid)->first();

 $svar=transactions::where('receipt_id',$id)->get()->pluck('id');
$vvar=trans_relations::whereIn('receipt',$svar)->get()->pluck('invoice');
    $data['varb']= transactions::whereIn('id',$vvar)->where('debit_or_credit',0)->get();
$sumid=(transactions::whereIn('id',$vvar)->where('is_active',1)->where('debit_or_credit',0)->get()->pluck('id')->toArray(1));
//dd($data['varb']);

$data['plot']=transactions::whereIn('id',$vvar)->where('is_active',1)->where('debit_or_credit',0)->first();
   $data['profiledata']=admin_company_profile::where('cost_center',$data['plot']->unit)->first();



   
 $v=trans_relations::whereIn('invoice',$sumid)->get()->pluck('receipt');
 $data['b']=transactions::select('id','trans_amount')->whereIn('id',$v)->get()->keyBy('id');
//dd($v);

        return view('backend/finance-and-management.finance-payment-receipts.finance-payment-receipts-invoice', $data);
    }

    public function invoices(Request $request){
        if($request->get('id')) {
            $mog = 1;

            if ($request->get('mog')==1){



                $q = customer::find($request->get('id'));
                $invoices =$q->invoices()->with(['subs','subs.subscription'])->get();
            } else {
                $q = membership::find($request->get('id'));
                $invoices = $q->invoices()->with(['subs','subs.subscription'])->get();
            }
              return $invoices;


        }
    }

}
