<?php

namespace App\Http\Controllers;
use App\accountControls;
use App\accounts;
use App\trans_type;
use App\transactions;
use App\trans_relations;
use App\finance_expense_head;
use App\finance_expense;
use Illuminate\Http\Request;
use DataTables;
use Session;
use App\finance_payment_methods;
use App\finance_ledger_person;
use App\finance_account_head;
use App\finance_voucher_type;
use App\finance_account_type;
use App\admin_company_profile;
use App\finance_expense_paid_for;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\finance_books;

class FinanceExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function expense_create(Request $request)
    {

       // dd($costCenters);
        return view('backend/finance-and-management.finance-expenses.finance-expenses-aeu-vue');
    }

  public function expense_init(Request $request){
      $units=accounts::units()->get();
      $books=finance_books::where('status',1)->get();
     // $costCenters=accountControls::where('desc',1)->get()->toArray();
        return ['units'=>$units, 'books'=>$books];
    }

    public function expense_save(Request $request){

            $lastval=finance_expense::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }

if(finance_expense::where('id',$num)->count() == 0){
        $d=[];

        $d['invoice_date']=formatDate($request->get('invoice_date'));
        $d['invoice_no']=$request->get('invoice_no');
        $d['customer']=$request->get('customer');
        $d['person_id']=$request->get('person_id');
        $d['total_amount']=$request->get('total_amount');
        $d['total']=$request->get('total');
        $d['surcharge']=$request->get('sur');
        $d['remarks']=$request->get('remarks');
        $d['amount_in_words']=$request->get('amount_in_words');

        $id=  finance_expense::create($d);

}
     return $id->id;


    }

      public function index_vue(Request $request, finance_expense $finance_expense)
    {

        return view('backend/finance-and-management/finance-expenses/finance-expenses-vue');

    }

       public function expenses_init_vue(Request $request)
    {

  $data['expenses'] =\Illuminate\Support\Facades\DB::select('select finance_expenses.*, finance_ledger_people.person_name as personname, if(sum(transactions.trans_amount )>0,sum(transactions.trans_amount ),0) as paid_amount , GROUP_CONCAT(transactions.receipt_id) as reciept_id,
    users.name as cashiername,
    trans_types.name as type_name from finance_expenses
left outer join transactions on transactions.trans_type=finance_expenses.expense_paid_for and transactions.trans_type_id=finance_expenses.id and transactions.debit_or_credit=1 and transactions.deleted_at is null
left outer join users on users.id =finance_expenses.created_by and users.status=1
left outer join trans_types on trans_types.id=finance_expenses.expense_paid_for
left outer join finance_ledger_people on finance_ledger_people.id=finance_expenses.person_id and finance_ledger_people.deleted_at is null
where finance_expenses.deleted_at is null group by finance_expenses.id order by finance_expenses.id desc');

     return $data;

}


    public function index(Request $request, finance_expense $finance_expense)
    {
        return view('backend/finance-and-management/finance-expenses/finance-expenses');
    }



     public function indexdt(Request $request, finance_expense $finance_expense)
    {
        $r=finance_expense::where('deleted_at');

            if($request->get('finance_ledger_person')){
            $x=$request->get('finance_ledger_person');

            $c=finance_ledger_person::where('person_name','like',"%$x%")->first();
            $r=finance_ledger_person::find($c->id)->expenses();

        }


        if($request->get('start_date')){
            $r->where('invoice_date','>=',formatDate($request->get('start_date')));
        }
        if($request->get('end_date')){
            $r->where('invoice_date','<=',formatDate($request->get('end_date')));

        }
        if($request->get('expense')){
            $r->where('invoice_no','=',$request->get('expense'));

        }

        $expenses = $r->get();

        $dx= DataTables::of($expenses)

            ->addColumn('editbutton', function ($expenses) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-expenses/finance-expenses-aeu/') . '/' . $expenses->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })


            ->addColumn('deletebutton', function ($expenses) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-expenses/delete') . '/' . $expenses->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


             ->addColumn('ac', function ($expenses) {
              return salesaccounttype($expenses->account_type);
                })


              ->addColumn('expense_paid_for', function ($expenses) {
            if($expenses->expense_paid_for){
                  return transTypesChargesTypes($expenses->expense_paid_for);
                  }
                else{
                    return '';
                }
           })

            /*  ->addColumn('expense_paid_for', function ($expenses) {
              return expensepaidfor($expenses->expense_paid_for);


                })*/

                ->addColumn('expense_details', function ($expenses) {
              return $expenses->expense_details ;

                })

            ->addColumn('amountpaid', function ($expenses) {
                $s=transactions::where('debit_or_credit',0)->where('trans_type',$expenses->expense_paid_for)->where('trans_type_id',$expenses->id)->get()->pluck('id');

                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit',1)->get()->toArray(1));
                $x=0;

            foreach($b as $v){

                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }

            return $x;
           })

            ->addColumn('finalbalance', function ($expenses) {

            $s=transactions::where('debit_or_credit',0)->where('trans_type',$expenses->expense_paid_for)->where('trans_type_id',$expenses->id)->get()->pluck('id');

                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit',1)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                      $x = $v['trans_amount']+$x;
             }
            }

            return $expenses->total-$x;

           })

              ->addColumn('balancestatus', function ($expenses) {

 $s=transactions::where('debit_or_credit',0)->where('trans_type',$expenses->expense_paid_for)->where('trans_type_id',$expenses->id)->get()->pluck('id');

                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit', 1)->get()->toArray(1));
                $x=0;

//dd($b);
             foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                      $x = $v['trans_amount']+$x;
             }
            }


            $resultant = $expenses->total-$x;

               if($resultant==0){
return '<button class=" btn btn-outline-success active">Paid</button>';
               }
               else{

                   return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/') . '?'. 'accid='. $expenses->person_id . '">Unpaid</a></button>';

               }
            })

                  ->addColumn('details_d', function ($expenses) {
          /*
                $expid=$expenses->id;
                $payableid=$expenses->expense_paid_for;
                $transtype = trans_type::where('type',5)->where('mod_id',$payableid)->get()->pluck('id');*/

             $s=transactions::where('debit_or_credit',0)->where('trans_type',$expenses->expense_paid_for)->where('trans_type_id',$expenses->id)->get()->pluck('id');

                $v=trans_relations::whereIn('invoice',$s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id',$v)->where('debit_or_credit',1)->get());


                foreach($b as $d){
//               dd($d->type);
                    $c=$d->type->name;
                    return "   <a target='_blank' href='".route('payment.receipt.print',$d['receipt_id'])."'>($d[receipt_id] - $c)</a><br>";
                }
           })

            ->addColumn('dtotal', function ($r) {
                $request=Request::capture();
                $r=finance_expense::where('deleted_at');

                    if($request->get('finance_ledger_person')){
                        $x=$request->get('finance_ledger_person');

                        $c=finance_ledger_person::where('person_name','like',"%$x%")->first();
                        $r=finance_ledger_person::find($c->id)->expenses();

                    }

                if($request->get('start_date')){
                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('expense')){
                    $r->where('invoice_no','=',$request->get('expense'));

                }
              return number_format( $r->sum('total')) ;


                })


            ->addColumn('ctotal', function ($expenses) {
                $request=Request::capture();
                $r=finance_expense::where('deleted_at');


                    if($request->get('finance_ledger_person')){
                        $x=$request->get('finance_ledger_person');

                        $c=finance_ledger_person::where('person_name','like',"%$x%")->first();
                        $r=finance_ledger_person::find($c->id)->expenses();

                    }


                if($request->get('start_date')){
                    $r->where('invoice_date','>=',formatDate($request->get('start_date')));
                }
                if($request->get('end_date')){
                    $r->where('invoice_date','<=',formatDate($request->get('end_date')));

                }
                if($request->get('expense')){
                    $r->where('invoice_no','=',$request->get('expense'));

                }
                return number_format( $r->count('id')) ;


                })

               ->addColumn('invoice_date', function ($expenses) {
              return formatDateToShow($expenses->invoice_date);


                }) ->addColumn('expense_details', function ($expenses) {
              return wordwrap($expenses->expense_details,40,"\n");


                }) ->addColumn('person_id', function ($expenses) {

                return $expenses->person_id;

                })

             ->addColumn('status', function ($expenses) {
                 return '<button class="buttoncolor" title="Print Voucher"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-expenses/finance-expenses-invoice/') . '/' . $expenses->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

          ->addColumn('docs', function ($expenses) {
            return '<button class="buttoncolor" title="View"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-expenses/finance-expenses-documents/') . '/' . $expenses->id . '"><i class="fas fa-eye"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton', 'finance_ledger_person', 'status', 'customer', 'admin_company_profile', 'finance_account_head', 'finance_account_type', 'ac', 'amountpaid', 'finalbalance', 'balancestatus', 'details_d', 'docs'])
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




    public function index_deleted(Request $request, finance_expense $finance_expense)
    {
        return view('backend/finance-and-management/finance-expenses/finance-expenses-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_expense $finance_expense)
    {

        $expenses = finance_expense::onlyTrashed()->get();
        return DataTables::of($expenses)


        ->addColumn('expense_paid_for', function ($expenses) {
            if($expenses->expense_paid_for){
                  return transTypesChargesTypes($expenses->expense_paid_for);
                  }
                else{
                    return '';
                }
           })


         ->addColumn('expense_details', function ($expenses) {
              return $expenses->expense_details ;
                })

                   ->addColumn('ac', function ($expenses) {
              return salesaccounttype($expenses->account_type);
                })


           ->addColumn('invoice_date', function ($expenses) {
              return formatDateToShow($expenses->invoice_date);


                })

                  ->addColumn('deleted_at', function ($expenses) {
              return formatDateToShow($expenses->deleted_at);


                })

                 ->addColumn('expense_details', function ($expenses) {
              return wordwrap($expenses->expense_details,40,"\n");


                }) ->addColumn('person_id', function ($expenses) {

                return $expenses->person_id;

                })


            ->addColumn('restorebutton', function ($expenses) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-expenses/restore/') . '/' . $expenses->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton', 'admin_company_profile', 'ac'])
        ->addIndexColumn()
        ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {
        $lastval = finance_expense::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['expenses_update'] = '';

    $data['finance_ledger_persons']=finance_ledger_person::get();

    $data['expense_payables']=trans_type::where('type',5)->get();

          //$data['expense_payables']=finance_expense_paid_for::where('status',1)->get();

 $data['payment_methods']=finance_account_head::where('status',1)->get();
 $data['account_types']=finance_account_type::where('status',1)->get();
 $data['profiledata']=admin_company_profile::get()->first();

   $data['expense_heads']=finance_expense_head::where('status',1)->get();

        return view('backend/finance-and-management.finance-expenses.finance-expenses-aeu', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;

     $createimg='';


if($request->hasFile('documents')) {

           $files = $request->file('documents');
           foreach($files as $file){

              $createimg=sendExpensesDocs($file,$size,['type'=>15,'moc_id'=>$request->post('person_id')]);

          }
       }


        $save=$request->save;

        $this->validate($request, [

            'invoice_no' => 'required',
            'invoice_date' => 'required',

            'person_name' => 'required',

            //'person_address' => 'required',
            //'person_cnic' => 'required',
           'person_contact' => 'required',
            //'person_email' => 'required',
           // 'ledger_amount' => 'required',
   //         'expense_head' => 'required',
   //        'expense_paid_for' => 'required',
   //       'expense_details' => 'required',

         // 'account_head' => 'required',

          //'account_type' => 'required',
          //'account_date' => 'required',

          'total_amount' => 'required',

            'total' => 'required',

            'amount_in_words'=> 'required',

        ]);

    foreach($request->expense_head as $key=>$c){
    $charges=$request->charges[$key];

    $cm=[

            //'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),

            'person_id' => $request->person_id,

            'person_name' => $request->person_name,
            'person_address' => $request->person_address,
            'person_cnic' => $request->person_cnic,
            'person_contact' => $request->person_contact,
             'person_email' => $request->person_email,

            'ledger_amount' => $request->ledger_amount,
    //  'expense_head' => $request->expense_head,
      //      'expense_paid_for' => $request->expense_paid_for,

        //   'expense_details' => $request->expense_details,

            'account_head' => $request->account_head,
            'account_type' => $request->account_type,
            'account_date' => $request->account_date,

             'payment_mode_details' => $request->payment_mode_details,

           'total_amount' => $request->total_amount,
           'surcharge' => $request->surcharge,
            'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,

            'amount_in_words' => $request->amount_in_words,

            'documents' => $createimg,
            'remarks' => $request->remarks,

            'expense_head' => $request->expense_head[$key],
        'expense_paid_for' => $request->expense_payable[$key],
        'expense_details' => $request->expense_details[$key],
        'charges' => $request->charges[$key],

      ];

        $expenses = finance_expense::create($cm);

/*$vouchertype=trans_type::where('type',5)->where('mod_id',$request->expense_paid_for)->get()->pluck('id');
          $vouchertypeid  =$vouchertype[0];*/

    $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $request->expense_payable[$key],
        'trans_type_id' =>  $expenses->id,
        'trans_amount' =>  $request->total,
        'trans_moc_type' =>  2,
        'trans_moc' =>  $request->person_id,
        'date' =>  formatDate($request->invoice_date),
        'is_active' =>  1
    ]);

}
        if ($expenses) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$expenses->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-expenses/finance-expenses-invoice/'.$getlastinsert);
            }else{
                return redirect('finance-and-management/finance-expenses-vue');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_expense  $finance_expense
     * @return \Illuminate\Http\Response
     */
    public function show(finance_expense $finance_expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_expense  $finance_expense
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_expense $finance_expense,$id)
    {
         $data['expenses_update'] = finance_expense::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['expenses_update']->code;

       $data['finance_ledger_persons']=finance_ledger_person::get();

         $data['expense_payables']=trans_type::where('type',5)->get();
//$data['expense_payables']=finance_expense_paid_for::where('status',1)->get();
$data['profiledata']=admin_company_profile::get()->first();

$data['payment_methods']=finance_account_head::where('status',1)->get();
 $data['account_types']=finance_account_type::where('status',1)->get();
 $data['expense_heads']=finance_expense_head::where('status',1)->get();
        return view('backend/finance-and-management.finance-expenses.finance-expenses-edit', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_expense  $finance_expense
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {
$size['width'] = 300;
$size['height'] = 200;
        $updateimg='';

if($request->hasFile('documents')) {

           $files = $request->file('documents');

     $s=finance_expense::find($id)->ledgerperson->expensesDocs;
           foreach($s as $m){
               $m->delete();
    }
           foreach($files as $file){


              $updateimg=sendExpensesDocs($file,$size,['type'=>15,'moc_id'=>$request->post('person_id')]);
          }
       }


        $this->validate($request, [

 'invoice_no' => 'required',
            'invoice_date' => 'required',

            'person_name' => 'required',

          //  'person_address' => 'required',
          //  'person_cnic' => 'required',
           'person_contact' => 'required',
          //  'person_email' => 'required',
         //   'ledger_amount' => 'required',
 'expense_head' =>'required',
           'expense_paid_for' => 'required',
          'expense_details' => 'required',

         //  'account_head' => 'required',

        //  'account_type' => 'required',
        //  'account_date' => 'required',

          'total_amount' => 'required',

            'total' => 'required',

            'amount_in_words'=> 'required',

        ]);
        $expenses = finance_expense::where('id', $id)->updateWithUserstamps([
          'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),

            'person_id' => $request->person_id,

            'person_name' => $request->person_name,
            'person_address' => $request->person_address,
            'person_cnic' => $request->person_cnic,
            'person_contact' => $request->person_contact,
             'person_email' => $request->person_email,

            'ledger_amount' => $request->ledger_amount,
       'expense_head' => $request->expense_head,
            'expense_paid_for' => $request->expense_paid_for,

           'expense_details' => $request->expense_details,

          'account_head' => $request->account_head,
            'account_type' => $request->account_type,
            'account_date' => $request->account_date,

             'payment_mode_details' => $request->payment_mode_details,

           'total_amount' => $request->total_amount,
           'surcharge' => $request->surcharge,
           'surcharge_percentage' => $request->surcharge_percentage,
            'total' => $request->total,

            'amount_in_words' => $request->amount_in_words,

            'documents' => $updateimg,
            'remarks' => $request->remarks
        ]);


 $f= finance_expense::find($id);

if(transactions::where('trans_type_id', $id)->where('trans_type', $f->expense_paid_for)->exists()){
    $transaction = transactions::where('trans_type_id', $id)->where('trans_type',$f->expense_paid_for)->where('debit_or_credit',0)->updateWithUserstamps([
        'debit_or_credit' =>  0,
        'trans_type' =>  $request->expense_paid_for,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->total,
        'trans_moc_type' =>  2,
        'trans_moc' =>  $request->person_id,
        'date' =>  formatDate($request->invoice_date),
        'is_active' =>  1
        ]);
}
else{
     $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $request->expense_paid_for,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->total,
        'trans_moc_type' =>  2,
        'trans_moc' =>  $request->person_id,
        'date' =>  formatDate($request->invoice_date),
        'is_active' =>  1
    ]);
}



    if ($expenses) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-expenses/finance-expenses-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_expense  $finance_expense
     * @return \Illuminate\Http\Response
     */
/*   public function destroy(finance_expense $finance_expense,$id)
    {
        $payable= $finance_expense::where('id', $id)->get()->pluck('expense_paid_for');
        $expenses=$finance_expense::where('id', $id)->deleteWithUserstamps();

        if(transactions::where('trans_type_id', $id)->where('trans_type',$payable)->where('debit_or_credit',0)->exists()){
            transactions::where('trans_type_id', $id)->where('trans_type',$payable)->where('debit_or_credit',0)->deleteWithUserstamps();
         }


        if($expenses){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-expenses-vue');
    }*/
      public function destroy(Request $request,finance_expense $finance_expense,$id)
    {
     $update= finance_expense::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);
$payable= $finance_expense::where('id', $id)->get()->pluck('expense_paid_for');
      $delete=$finance_expense::where('id', $id)->deleteWithUserstamps();

       if(transactions::where('trans_type_id', $id)->where('trans_type',$payable)->where('debit_or_credit',0)->exists()){
            transactions::where('trans_type_id', $id)->where('trans_type',$payable)->where('debit_or_credit',0)->deleteWithUserstamps();
         }
    }


    public function invoice(finance_expense $finance_expense,$id)
    {

         $data['receiptdata']=finance_expense::with('ledgerperson')->where('id',$id)->first();

       $data['profiledata']=admin_company_profile::get()->first();
           $rid=$data['receiptdata']->expense_paid_for;
         $data['expense_payables']=trans_type::where('id',$rid)->first();


 $aid=$data['receiptdata']->account_head;

        return view('backend/finance-and-management.finance-expenses.finance-expenses-invoice', $data);
    }

 public function docs(finance_expense $finance_expense,$id)
    {
         $data['receiptdata']=finance_expense::with('ledgerperson')->where('id',$id)->first();

        return view('backend/finance-and-management.finance-expenses.finance-expenses-documents', $data);
    }


public function restore(finance_expense $finance_expense,$id)
    {
        $payable= $finance_expense::onlyTrashed()->where('id', $id)->get()->pluck('expense_paid_for');

        $restore = finance_expense::onlyTrashed()->find($id)->restore();

    if(transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$payable)->where('debit_or_credit',0)->exists()){
        $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$payable)->where('debit_or_credit',0)->restore();
    }

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-expenses/deleted');

}

function payables($id){
     if($id!=0){
        $prepayables=finance_expense_paid_for::where('expense_head',$id)->get()->pluck('id');
         $payables=trans_type::where('type',5)->whereIn('mod_id',$prepayables)->orderBy('name')->get();

     }
     else{
          $prepayables=finance_expense_paid_for::get()->pluck('id');
         $payables=trans_type::where('type',5)->whereIn('mod_id',$prepayables)->orderBy('name')->get();
     }

        return $payables;
    }

}
