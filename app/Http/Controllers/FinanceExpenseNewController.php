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
use App\payment_finance_sheet;
use App\payment_finance_sheet_subs;
use App\coa_transactions;
use App\coa_account;
use App\coa_accounts_control;
use App\coa_accounts_cat;
use App\fnb_predefined_value;
use App\media;
class FinanceExpenseNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function create(Request $request)
    {

       // dd($costCenters);
        return view('backend/finance-and-management.payment-finance-sheet.payment-finance-sheet-aeu-vue');
    }



     public function init(Request $request)
    {
        if($request->get('r')){
          //  $lastval=finance_expense::find($request->get('r'));
          $lastval=finance_expense::where('expense_no',$request->get('r'))->first();
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }

 $ikd=$lastval->supplier_id;
    $lastval['documents']=media::where('type_id',$ikd)->where('trans_type',9)->where('trans_type_id',$lastval->id)->get();


 $lastval['payment_methods']=trans_type::where('type',7)->get();
 $lastval['units']=coa_account::get();
 $lastval['ccs']=coa_account::get();
 $lastval['books']=finance_books::where('status',1)->get();
 $lastval['companies']=coa_account::wherenotnull('desc')->get();
/* $lastval['drows']=DB::table('payment_finance_sheet_subs')->selectRaw('payment_finance_sheet_subs.*,1 as hid')
              ->where('payment_finance_sheet_subs.expense_id',$num)
              ->get();*/

if(Auth::user()->can('Add Ledger Persons')){
        $lastval['add_sup']=Permission::where('name','Add Ledger Persons')->get();
}


 
$lastval['drows'] =DB::table('finance_expense')
              ->join('coa_accounts_controls','coa_accounts_controls.code', '=', 'finance_expense.unit', 'left outer')
              ->selectRaw('finance_expense.*,1 as hid')
              ->where('finance_expense.expense_no',$request->get('r'))->where('finance_expense.deleted_at',null)->where('coa_accounts_controls.deleted_at',null)->groupBy('finance_expense.id')
              ->get(); 

       /* $lastval['drows'] =DB::table('payment_finance_sheet_subs')
              ->join('coa_transactions','coa_transactions.account', '=', 'payment_finance_sheet_subs.code', 'left outer')
              ->selectRaw('payment_finance_sheet_subs.*,1 as hid, sum(if(coa_transactions.debit_or_credit=0,coa_transactions.amount,0))-
       sum(if(coa_transactions.debit_or_credit=1,coa_transactions.amount,0)) as balance')
              ->where('payment_finance_sheet_subs.expense_id',$num)->where('coa_transactions.deleted_at',null)->where('coa_transactions.is_active',1)->groupBy('payment_finance_sheet_subs.id')
              ->get();
*/
       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $data=finance_expense::withTrashed()->latest('id')->first();
      $num=0;
      if($data){
        $num=$data->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }

  $data['ccs']=coa_account::get();
        $data['units']=coa_account::get();
        $data['books']=finance_books::where('status',1)->get();
     $data['payment_methods']=trans_type::where('type',7)->get();
      $data['companies']=coa_account::wherenotnull('desc')->get();
     if(Auth::user()->can('Add Ledger Persons')){
        $data['add_sup']=Permission::where('name','Add Ledger Persons')->get();
}

     return $data;
 }


}


    public function save(Request $request){




       // dd($request->all());
 $size['width'] = 300;
         $size['height'] = 200;
             $lastval=finance_expense::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }




  $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }
 $typo=2;
 

        $d=[];
         $dd='';
         $cati ='';

       if($typo==2){
          $dd=$request->get('supplier_id');

             if(finance_ledger_person::where('id',$request->get('supplier_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('supplier_id'))->get()->pluck('account');
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



 
// SAVING 
    if($request->get('drows')==[]){
 abort(500);
      }

      foreach($request->get('drows') as $inv){
         

        if(isset($inv['code'])){


            
             if(!isset($inv['code'])){
          abort(500);
            }
            
             if(!isset($inv['name'])){
            abort(500);
            }

               
                  if(!isset($inv['amount'])){
            abort(500);
            }
            

  if(!isset($inv['description'])){
            $inv['description']=null;
            }






          $m=  finance_expense::create([
           
              'unit'=>$request->get('company'),
               'code'=>$inv['code'],
                'name'=>$inv['name'],
               'amount'=>$inv['amount'],
               'description'=>$inv['description'],

                'expense_no'=>$request->get('invoice_no'),
            'expense_date'=>formatDate($request->get('invoice_date')),
               'supplier_id'=>$request->get('supplier_id'),
          //     'doc_no'=>$request->get('doc_no'),
               'comments'=>$request->get('comments'),
            ]);

          $t=  transactions::create([
            'type'=>6,
            'debit_or_credit'=>0,
            'trans_type'=>9,
            'trans_type_id'=>$m->id,
               'trans_amount'=>$inv['amount'],
               'trans_moc'=>$dd,
               'trans_moc_category'=>$cati,
               'trans_moc_type'=>$typo,
               'date'=>formatDate($request->get('invoice_date')),
               'is_active'=>1,
               'account'=>$inv['code'],
               'trans_coa'=>$d['coa_code'],
                'unit'=>$request->get('company'),
            ]);


if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
             $createimg=sendExpensesDocs($file,$size,['type'=>2,'trans_type'=>9,'trans_type_id'=>$m->id,'moc_id'=>$request->post('supplier_id')]);  // type = 15
            
          }


   }
       

        }
 }
// SAVING 

      

    }
    
/*
 public function expense_init_dd(Request $request){
      $units=accounts::units()->get();
      $books=finance_books::where('status',1)->get();
     
    
       
        return ['units'=>$units, 'books'=>$books];
    }*/


    /*public function save(Request $request){
      $lastval=payment_finance_sheet::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }

if(payment_finance_sheet::where('id',$num)->count() == 0){
        $d=[];

        $d['dated']=formatDate($request->get('dated'));
        $d['book']=$request->get('book');
        $d['doc_no']=$request->get('doc_no');
        $d['comments']=$request->get('comments');
   
        $id=  payment_finance_sheet::create($d);

}

if(finance_books::where('id',$request->get('book'))->exists()){
  $learry=finance_books::where('id',$request->get('book'))->get()->pluck('debit_or_credit');
  $le=$learry[0];
}else{
  $le=0;
}

//dd($request->get('drows'));

 if($request->get('drows')==[]){
 abort(500);
      }

      foreach($request->get('drows') as $inv){
         

        if(isset($inv['unit'])){


            
             if(!isset($inv['code'])){
          abort(500);
            }
            
             if(!isset($inv['name'])){
            abort(500);
            }

                  if(!isset($inv['payment_method'])){
            abort(500);
            }


                  if(!isset($inv['amount'])){
            abort(500);
            }
            

  if(!isset($inv['description'])){
            $inv['description']=null;
            }


          $m=  payment_finance_sheet_subs::create([
            'expense_id'=>$id->id,
               'unit'=>$inv['unit'],
               'code'=>$inv['code'],
                'name'=>$inv['name'],
              'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'description'=>$inv['description'],
               'book'=>$request->get('book'),
               'doc_no'=>$request->get('doc_no'),
            ]);

 $t=  coa_transactions::create([
            'debit_or_credit'=>$le,
            'trans_type'=>35,
            'trans_type_id'=>$id->id,
               'unit'=>$inv['unit'],
               'account'=>$inv['code'],
              'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'desc'=>$inv['description'],
               'date'=>formatDate($request->get('dated')),
               'is_active'=>1,
            ]);

        }
 }

     return $id->id;


    }*/



      public function index_vue(Request $request, payment_finance_sheet $payment_finance_sheet)
    {
        return view('backend/finance-and-management/payment-finance-sheet/payment-finance-sheet-vue');
    }


       public function sheet_init_vue(Request $request)
    {

       $data['expenses'] =\Illuminate\Support\Facades\DB::select('select finance_expense.*,

          group_concat(finance_expense.code) as code,


 finance_ledger_people.person_name as name, if(sum(DISTINCT transactions.trans_amount )>0,sum(DISTINCT transactions.trans_amount ),0) as paid_amount , GROUP_CONCAT(DISTINCT transactions.receipt_id) as reciept_id,
  group_concat( distinct finance_expense.id ORDER BY finance_expense.id ASC SEPARATOR "<br>") as multiid,
    group_concat(distinct if(finance_expense.status is not null,0  ,concat(finance_expense.amount,"-",finance_expense.id)) ORDER BY finance_expense.id ASC SEPARATOR "<br>") as grandtotal,

      group_concat(distinct if(finance_expense.status is null,concat(coa_accounts_controls.code," ",coa_accounts_controls.name) ,concat(coa_accounts_controls.code," ",coa_accounts_controls.name," ","(",finance_expense.status,")")) SEPARATOR "<br>") as ttname
,

     group_concat(finance_expense.status) as statuss,
       users.name as cashiername,
              media.url as image

    from finance_expense 

left outer join finance_ledger_people on finance_ledger_people.id=finance_expense.supplier_id
 left outer join transactions on transactions.trans_type=9 and transactions.trans_type_id=finance_expense.id and transactions.debit_or_credit=1 and transactions.type=5 and transactions.deleted_at is null
left outer join users on users.id =finance_expense.created_by and users.status=1
left outer join coa_accounts_controls on coa_accounts_controls.code =finance_expense.code
left outer join media on media.trans_type=9 and media.trans_type_id=finance_expense.id and media.deleted_at is null

where finance_expense.deleted_at is null group by finance_expense.expense_no order by finance_expense.expense_no desc');


//dd($data['expenses']);
/*  $data['expenses'] =\Illuminate\Support\Facades\DB::select('select payment_finance_sheet_subs.*,
    payment_finance_sheet_subs.book as bookid,
    finance_books.desc as book,
     coa_accounts.name as unit

    from payment_finance_sheet_subs
left outer join finance_books on finance_books.id=payment_finance_sheet_subs.book
left outer join coa_accounts on coa_accounts.code=payment_finance_sheet_subs.unit

where payment_finance_sheet_subs.deleted_at is null group by payment_finance_sheet_subs.id order by payment_finance_sheet_subs.id desc');*/


 /* $data['expenses'] =\Illuminate\Support\Facades\DB::select('select payment_finance_sheets.*,
    payment_finance_sheets.book as bookid,
    finance_books.desc as book

    from payment_finance_sheets
left outer join finance_books on finance_books.id=payment_finance_sheets.book

where payment_finance_sheets.deleted_at is null group by payment_finance_sheets.id order by payment_finance_sheets.id desc');*/

   $data['books']=finance_books::where('status',1)->get();

     return $data;

}



  public function edit(payment_finance_sheet $payment_finance_sheet,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/finance-and-management.payment-finance-sheet.payment-finance-sheet-aeu-vue', $data);
    }

 public function updated(Request $request){
     //  dd($request->all());
     $size['width'] = 300;
    $size['height'] = 200;
 $typo=2;
 
$magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }



       
  $d=[];
         $dd='';
         $cati ='';

         if($typo==2){
          $dd=$request->get('supplier_id');

             if(finance_ledger_person::where('id',$request->get('supplier_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('supplier_id'))->get()->pluck('account');
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


       /* if($request->get('document')) {
          
           $files = $request->get('document');
 
           foreach($files as $file){
             // dd($file);
            
              $updateimg=sendExpensesDocs($file,$size,['type'=>15,'moc_id'=>$request->post('supplier_id')]);
             

          }
       }*/

      
  
 
// SAVING  
    
 if($request->get('drows')==[]){
 abort(500);
      }

foreach($request->get('drows') as $inv){


             if(!isset($inv['code'])){
          abort(500);
            }
            
             if(!isset($inv['name'])){
            abort(500);
            }

              
                  if(!isset($inv['amount'])){
            abort(500);
            }
            
if(!isset($inv['description'])){
            $inv['description']=null;
            }

if(isset($inv['hid'])){
        $m =finance_expense::where('id',$inv['id'])->updateWithUserstamps([
           //  'expense_id'=>$id->id,
               'unit'=>$request->get('company'),
               'code'=>$inv['code'],
                'name'=>$inv['name'],
             // 'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'description'=>$inv['description'],
               'remarks'=>$inv['remarks']=='null'?null:$inv['remarks'],
               'status'=>$inv['status']=='null'?null:$inv['status'],
               'comments'=>$inv['comments']=='null'?null:$inv['comments'],

                  'expense_no'=>$request->get('invoice_no'),
            'expense_date'=>($request->get('invoice_date')),
               'supplier_id'=>$request->get('supplier_id'),
          //     'doc_no'=>$request->get('doc_no'),
               //'comments'=>$request->get('comments'),
          ]);

   $t=  transactions::where('type',6)->where('debit_or_credit',0)->where('trans_type',9)->where('trans_type_id',$inv['id'])->updateWithUserstamps([
            'type'=>6,
            'debit_or_credit'=>0,
            'trans_type'=>9,
            'trans_type_id'=>$inv['id'],
               'trans_amount'=>$inv['amount'],
               'trans_moc'=>$dd,
               'trans_moc_category'=>$cati,
               'trans_moc_type'=>$typo,
               'date'=>formatDate($request->get('invoice_date')),
               'is_active'=>1,
               'account'=>$inv['code'],
               'trans_coa'=>$d['coa_code'],
                'unit'=>$request->get('company'),
            ]);



}else{
       $m=  finance_expense::create([
           
               'unit'=>$request->get('company'),
               'code'=>$inv['code'],
                'name'=>$inv['name'],
               'amount'=>$inv['amount'],
               'description'=>$inv['description'],

                'expense_no'=>$request->get('invoice_no'),
            'expense_date'=>formatDate($request->get('invoice_date')),
               'supplier_id'=>$request->get('supplier_id'),
          //     'doc_no'=>$request->get('doc_no'),
               'comments'=>$request->get('comments'),
            ]);

   $t=  transactions::create([
            'type'=>6,
            'debit_or_credit'=>0,
            'trans_type'=>9,
            'trans_type_id'=>$m->id,
               'trans_amount'=>$inv['amount'],
               'trans_moc'=>$dd,
               'trans_moc_category'=>$cati,
               'trans_moc_type'=>$typo,
               'date'=>formatDate($request->get('invoice_date')),
               'is_active'=>1,
               'account'=>$inv['code'],
               'trans_coa'=>$d['coa_code'],
                'unit'=>$request->get('company'),
            ]);
}


if($request->hasFile('images')) {

           $files = $request->file('images');
           foreach($files as $file){
             // dd($file);
             $createimg=sendExpensesDocs($file,$size,['type'=>2,'trans_type'=>9,'trans_type_id'=>$inv['id'],'moc_id'=>$request->post('supplier_id')]);  // type = 15
            
          }


   }
 
    }

// SAVING

}




   /*  public function updated(Request $request){

        $d=[];
  $d['dated']=formatDate($request->get('dated'));
        $d['book']=$request->get('book');
        $d['doc_no']=$request->get('doc_no');
        $d['comments']=$request->get('comments');


      $id=  payment_finance_sheet::where('id',$request->get('id'))->updateWithUserstamps($d);
//      dd();

     

if(finance_books::where('id',$request->get('book'))->exists()){
  $learry=finance_books::where('id',$request->get('book'))->get()->pluck('debit_or_credit');
  $le=$learry[0];
}else{
  $le=0;
}

 if($request->get('drows')==[]){
 abort(500);
      }

foreach($request->get('drows') as $inv){


             if(!isset($inv['code'])){
          abort(500);
            }
            
             if(!isset($inv['name'])){
            abort(500);
            }

                  if(!isset($inv['payment_method'])){
            abort(500);
            }


                  if(!isset($inv['amount'])){
            abort(500);
            }
            
if(!isset($inv['description'])){
            $inv['description']=null;
            }

if(isset($inv['hid'])){
        $m =payment_finance_sheet_subs::where('id',$inv['id'])->updateWithUserstamps([
           //  'expense_id'=>$id->id,
               'unit'=>$inv['unit'],
               'code'=>$inv['code'],
                'name'=>$inv['name'],
              'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'description'=>$inv['description'],
               'remarks'=>$inv['remarks'],
               'status'=>$inv['status'],
               'book'=>$request->get('book'),
               'doc_no'=>$request->get('doc_no'),
          ]);


       $t =coa_transactions::where('trans_type',35)->where('trans_type_id',$request->get('id'))->updateWithUserstamps([
                'debit_or_credit'=>$le,
            'trans_type'=>35,
           // 'trans_type_id'=>$request->get('id'),
               'unit'=>$inv['unit'],
               'account'=>$inv['code'],
              'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'desc'=>$inv['description'],
               'date'=>formatDate($request->get('dated')),
               'is_active'=>1,
        ]);

}else{
   $m=  payment_finance_sheet_subs::create([
            'expense_id'=>$request->get('id'),
               'unit'=>$inv['unit'],
               'code'=>$inv['code'],
                'name'=>$inv['name'],
              'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'description'=>$inv['description'],
               'book'=>$request->get('book'),
               'doc_no'=>$request->get('doc_no'),
            ]);

 $t=  coa_transactions::create([
            'debit_or_credit'=>$le,
            'trans_type'=>35,
            'trans_type_id'=>$request->get('id'),
               'unit'=>$inv['unit'],
               'account'=>$inv['code'],
              'payment_method'=>$inv['payment_method'],
               'amount'=>$inv['amount'],
               'desc'=>$inv['description'],
               'date'=>formatDate($request->get('dated')),
               'is_active'=>1,
            ]);
}


 
    }


}*/

    public function index_deleted(Request $request, finance_expense $finance_expense)
    {
        return view('backend/finance-and-management/payment-finance-sheet/payment-finance-sheet-deleted');
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


           ->addColumn('expense_date', function ($expenses) {
              return formatDateToShow($expenses->expense_date);
                })

           /* ->addColumn('book', function ($expenses) {
              return financebookname($expenses->book);
            })*/

            ->addColumn('name', function ($expenses) {
              if($expenses->supplier_id && $expenses->ledgerperson){
                return $expenses->ledgerperson->person_name;
              }else{
                return '';
              }
             })

            ->addColumn('restorebutton', function ($expenses) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-expenses/restore/') . '/' . $expenses->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton' ])
        ->addIndexColumn()
        ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_expense  $finance_expense
     * @return \Illuminate\Http\Response
     */
  
  public function destroy(Request $request,finance_expense $finance_expense,$id)
    {

 $data['mi']=finance_expense::where('expense_no',$id)->get()->pluck('id');

     $update= finance_expense::where('expense_no',$id)->updateWithUserstamps([
        'comments' => $request->remarks,
     ]);

      $delete=finance_expense::where('expense_no', $id)->deleteWithUserstamps();

if(transactions::where('type',6)->where('debit_or_credit',0)->where('trans_type',9)->whereIn('trans_type_id',$data['mi'])->exists()){
  transactions::where('type',6)->where('debit_or_credit',0)->where('trans_type',9)->whereIn('trans_type_id',$data['mi'])->deleteWithUserstamps();
}
     
/* 
     $update= payment_finance_sheet::where('id',$id)->updateWithUserstamps([
        'comments' => $request->remarks,
     ]);

      $delete=payment_finance_sheet::where('id', $id)->deleteWithUserstamps();

      $deletesubs=payment_finance_sheet_subs::where('expense_id', $id)->deleteWithUserstamps();

       if(transactions::where('trans_type_id', $id)->where('trans_type',35)->where('debit_or_credit',0)->exists()){
            transactions::where('trans_type_id', $id)->where('trans_type',35)->where('debit_or_credit',0)->deleteWithUserstamps();
         }*/
    }
 


public function restore(finance_expense $finance_expense,$id)
    {
     $restore = finance_expense::onlyTrashed()->where('id',$id)->restore();
    
  if(transactions::onlyTrashed()->where('type',6)->where('debit_or_credit',0)->where('trans_type',9)->where('trans_type_id',$id)->exists()){
     transactions::onlyTrashed()->where('type',6)->where('debit_or_credit',0)->where('trans_type',9)->where('trans_type_id',$id)->restore();
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

      /*  $restore = payment_finance_sheet::onlyTrashed()->find($id)->restore();
        $restoresubs = payment_finance_sheet_subs::onlyTrashed()->where('expense_id',$id)->restore();
  if(transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',35)->where('debit_or_credit',0)->exists()){
     transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',35)->where('debit_or_credit',0)->restore();
  }
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }
         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');
         }
        return redirect('finance-and-management/payment-finance-sheet/deleted');*/
}


    public function invoice(finance_expense $finance_expense,$id)
    {
      $data['receiptdata']=finance_expense::with('ledgerperson')->where('expense_no',$id)->first();
       $data['profiledata']=admin_company_profile::where('cost_center',$data['receiptdata']->unit)->first();

     $data['bookingsubdata']=finance_expense::where('expense_no',$id)->where('status',null)->get();

$data['mi']=finance_expense::where('expense_no',$id)->get()->pluck('id');
  $summe=finance_expense::where('expense_no',$id)->where('status',null)->get()->sum('amount');
  $v=transactions::where('debit_or_credit',1)->where('type',5)->where('trans_type',9)->whereIn('trans_type_id',$data['mi'])->get()->pluck('id');
        $b = (transactions::whereIn('id',$v)->get()->toArray(1));
                $x=0;

//dd($b);
            foreach($b as $v){
                if(!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                     $x = $v['trans_amount']+$x;
             }
            }
  
           $data['resultant'] = $summe-$x;
            $data['amount_paid'] = $x;

     /* $data['receiptdata']=payment_finance_sheet::where('id',$id)->first();
      $data['profiledata']=admin_company_profile::get()->first();

      $data['sub']=payment_finance_sheet::with('paymentSheetSubs')->where('id', $id)->get();
      $data['subdata']=$data['sub'][0]['paymentSheetSubs'];*/

      return view('backend/finance-and-management.payment-finance-sheet.invoice', $data);
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
            $path = 'expensedocs';
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


     public function docs(finance_expense $finance_expense,$id)
    {
         $data['receiptdata']=finance_expense::where('expense_no',$id)->first();

        return view('backend/finance-and-management.finance-expenses.finance-expenses-documents', $data);
    }

        public function getbook(Request $request, $book)
    {             
      if(payment_finance_sheet::where('book',$book)->exists()){
        $acc = payment_finance_sheet::where('book',$book)->count();
      }
      else{
$acc=0;
      }
          
      return $acc+1;
      
    }


}
