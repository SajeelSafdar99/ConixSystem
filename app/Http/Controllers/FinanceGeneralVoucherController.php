<?php

namespace App\Http\Controllers;
use App\trans_type;
use App\transactions;
use App\finance_general_voucher;
use Illuminate\Http\Request;
use App\finance_account_head;
use App\finance_voucher_type;
use App\finance_account_type;
use App\admin_company_profile;
use Session;
use DataTables;
use App\coa_accounts_control;
use App\finance_payment_methods;
use App\coa_account;
use App\fnb_predefined_value;
use App\membership;
use App\finance_ledger_person;
use App\hr_employment;
use App\customer;

class FinanceGeneralVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function paymentmethod($id){
     if($id!=0){
        $cc   = coa_accounts_control::where('code',$id)->get()->pluck('cost_center');
        $pms  = finance_payment_methods::where('status',1)->where('coa_trans_type',$cc)->get()->pluck('id');
        $data = trans_type::where('cash_or_payment',2)->where('type',7)->whereIn('mod_id',$pms)->get();
     }
     else{
         $data=[];
     }
        return $data;
    }

     public function index(Request $request, finance_general_voucher $finance_general_voucher)
    {
        return view('backend/finance-and-management/finance-general-voucher/finance-general-voucher');
    }

      public function indexdt(Request $request, finance_general_voucher $finance_general_voucher)
    {

        $voucher = finance_general_voucher::get();
        return DataTables::of($voucher)



            ->addColumn('status', function ($voucher) {
                if ($voucher->status == 1) {
                    return '<a style="color:#000000;" href="' . url('finance-and-management/finance-voucher/unpost/') . '/' . $voucher->id . '"><button style="cursor:pointer;" class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Change Status">Posted</button></a>'
                ;
                } else {
                    return '<a style="color:#000000;" href="' . url('finance-and-management/finance-voucher/post/') . '/' . $voucher->id . '"><button style="cursor:pointer;" class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Change Status">Unposted</button></a>'
                ;
                }



            })

            ->addColumn('invoice', function ($voucher) {
                 return '<button class="buttoncolor" title="Print Invoice"><a target="_blank" style="color:#000000;" href="' . url('finance-and-management/finance-voucher/finance-voucher-invoice/') . '/' . $voucher->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>'
                ;

            })

             ->addColumn('invoice_type', function ($voucher) {
                if($voucher->invoice_type==1){
                     return "Guest";
                }
                else if($voucher->invoice_type==2){
                     return "Supplier";
                }
                else if($voucher->invoice_type==0){
                     return "Member";
                 }
                 else if($voucher->invoice_type==3){
                     return "Employee";
                 }
                 else if($voucher->invoice_type==4){
                     return "COA Accounts";
                 }


                })

             ->addColumn('invoice_date', function ($voucher) {
              return formatDateToShow($voucher->invoice_date);


                })

             ->addColumn('voucher_type', function ($voucher) {
              return generalVoucherType($voucher->voucher_type);


                })

              ->addColumn('unit', function ($voucher) {
                if($voucher->unit){
                    return coaaccountname($voucher->unit);
                }else{
                    return '';
                }
              
                })

             ->addColumn('number', function ($voucher) {
                if($voucher->invoice_type==1){
                     return $voucher->customer_id;
                }
                else if($voucher->invoice_type==2){
                     return $voucher->person_id;
                }
                else if($voucher->invoice_type==3){
                     return $voucher->employee_id;
                }
                 else if($voucher->invoice_type==4){
                     return $voucher->account_id;
                }
                else if($voucher->invoice_type==0){
                     return $voucher->member?$voucher->member->mem_no:'';
                }
            })


          ->addColumn('docs', function ($voucher) {
            return '<button class="buttoncolor" title="View"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-voucher/finance-voucher-documents/') . '/' . $voucher->id . '"><i class="fas fa-eye"></i></a></button>'
                ;
            })

             ->addColumn('editbutton', function ($voucher) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-voucher/finance-voucher-aeu/') . '/' . $voucher->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($voucher) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-voucher/delete') . '/' . $voucher->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status', 'invoice', 'docs'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, finance_general_voucher $finance_general_voucher)
    {
        return view('backend/finance-and-management/finance-general-voucher/finance-general-voucher-deleted');
    }

      public function indexdt_deleted(Request $request, finance_general_voucher $finance_general_voucher)
    {

        $voucher = finance_general_voucher::onlyTrashed()->get();
        return DataTables::of($voucher)

             ->addColumn('invoice_type', function ($voucher) {
                if($voucher->invoice_type==1){
                     return "Guest";
                }
                else if($voucher->invoice_type==2){
                     return "Supplier";
                }
                else if($voucher->invoice_type==0){
                     return "Member";
                 }
                else if($voucher->invoice_type==3){
                     return "Employee";
                 }
                 else if($voucher->invoice_type==4){
                     return "COA Accounts";
                 }

                })

             ->addColumn('invoice_date', function ($voucher) {
              return formatDateToShow($voucher->invoice_date);


                })

  ->addColumn('deleted_at', function ($voucher) {
              return formatDateToShow($voucher->deleted_at);


                })


             ->addColumn('voucher_type', function ($voucher) {
              return generalVoucherType($voucher->voucher_type);


                })

->addColumn('unit', function ($voucher) {
                if($voucher->unit){
                    return coaaccountname($voucher->unit);
                }else{
                    return '';
                }
              
                })

              /*->addColumn('ac', function ($voucher) {
              return salesaccounttype($voucher->account);
                })*/

             ->addColumn('number', function ($voucher) {
                if($voucher->invoice_type==1){
                     return $voucher->customer_id;
                }
                else if($voucher->invoice_type==2){
                     return $voucher->person_id;
                }
                else if($voucher->invoice_type==4){
                     return $voucher->account_id;
                }
                else if($voucher->invoice_type==0){
                     return $voucher->member?$voucher->member->mem_no:'';
                 }
                else if($voucher->invoice_type==3){
                    return $voucher->employee_id;
                }


                })


             ->addColumn('restorebutton', function ($voucher) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-voucher/restore/') . '/' . $voucher->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
    public function create()
    {
        $lastval = finance_general_voucher::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['voucher_update'] = '';

/* $data['payment_methods']=finance_account_head::where('status',1)->get();*/
  $data['voucher_types']=finance_voucher_type::where('status',1)->get();
/* $data['account_types']=finance_account_type::where('status',1)->get();*/
      $data['accounts']=coa_accounts_control::whereIn('cost_center',['1','2'])->get();
         $data['units']=coa_account::where('desc','!=',null)->get();
 $data['payment_methods']=  [] ;

//  trans_type::where('cash_or_payment',2)->where('type',7)->get()
        return view('backend/finance-and-management.finance-general-voucher.finance-general-voucher-aeu', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
/*      public function store(Request $request)
    {
        $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;

     $createimg='';

if($request->hasFile('documents')) {

           $files = $request->file('documents');
           foreach($files as $file){
             // dd($file);
            if($request->invoice_type==1){ //for Guest/Customer
              $createimg=sendGeneralVoucherDocs($file,$size,['type'=>81,'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->invoice_type==2){ //for Ledger Account
              $createimg=sendGeneralVoucherDocs($file,$size,['type'=>80,'moc_id'=>$request->post('person_id')]);
            }
            else if($request->invoice_type==0){// for Member
              $createimg=sendGeneralVoucherDocs($file,$size,['type'=>82,'moc_id'=>$request->post('member_id')]);
            }
        else if($request->invoice_type==3){// for Employee
            $createimg=sendGeneralVoucherDocs($file,$size,['type'=>83,'moc_id'=>$request->post('employee_id')]);
            }
            else if($request->invoice_type==4){// for Account
            $createimg=sendGeneralVoucherDocs($file,$size,['type'=>84,'moc_id'=>$request->post('account_id')]);
            }
          }
       }



         $save=$request->save;
   $validation=[

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'voucher_type' => 'required',
            'name' => 'required',
         
            'ledger_amount' => 'required',
            //'cnic' => 'required',
           // 'email' => 'required',
           'account_date' => 'required',
            'account'=> 'required'

        ];
        if($request->get('invoice_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else if($request->get('invoice_type')==2){
            $validation['person_id']='required';
        }
         else if($request->get('invoice_type')==4){
            $validation['account_id']='required';
        }
        else if($request->get('invoice_type')==3){
            $validation['employee_id']='required';
        }
        else if($request->get('invoice_type')==1){
            $validation['customer_id']='required';

        }

         //dd($request->all());
       $this->validate($request, $validation);

        $voucher = finance_general_voucher::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'voucher_type' => $request->voucher_type,
            'name' => $request->name,
            'customer_id' => $request->customer_id,
            'member_id' => $request->member_id,
            'person_id' => $request->person_id,
            'account_id' => $request->account_id,
            'employee_id' => $request->employee_id,
            'address' => $request->address,
           'contact' => $request->contact,
           'ledger_amount' => $request->ledger_amount,
            'cnic' => $request->cnic,
            'invoice_type' => $request->invoice_type,
            'email' => $request->email,

           'debit_amount' => $request->debit_amount,
           'credit_amount' => $request->credit_amount,
            'debit_details' => $request->debit_details,
         'credit_details' => $request->credit_details,
              'account_date' => formatDate($request->account_date),
            'status' => 0,
            'account' => $request->account,
             'acc_details' => $request->acc_details,
             'documents' => $createimg,
            'remarks' => $request->remarks

        ]);
 $vouchertype=trans_type::where('type',4)->where('mod_id',$request->voucher_type)->get()->pluck('id');
          $vouchertypeid  =$vouchertype[0];

if($request->debit_amount){


if($request->invoice_type==0){

     $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  0,
        'trans_moc' =>  $request->member_id,
        'trans_moc_category' =>  memcategoryname($request->member_id),
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

      $acc= transactions::create([
               'debit_or_credit'=>1,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=> $request->member_id,
               'trans_moc_category' =>  memcategoryname($request->member_id),
               'trans_moc_type'=> 0,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==1){
 
  $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  1,
        'trans_moc' =>  $request->customer_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);


      $acc= transactions::create([
               'debit_or_credit'=>1,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=> $request->customer_id,
               'trans_moc_type'=> 1,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==4){

    $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  4,
        'trans_moc' =>  $request->account_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

    $acc_two= transactions::create([
        'debit_or_credit'=>0,
        'trans_type'=>92,
        'trans_type_id'=> $request->account_id,
        'trans_amount'=> $request->debit_amount,
        'trans_moc'=> $request->account,
        'trans_moc_type'=> 4,
        'date'=>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,

    ]);
    $acc= transactions::create([
               'debit_or_credit'=>1,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=> $request->account_id,
               'trans_moc_type'=> 4,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==2){

    $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  2,
        'trans_moc' =>  $request->person_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

    $acc= transactions::create([
               'debit_or_credit'=>1,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=> $request->person_id,
               'trans_moc_type'=> 2,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==3){

  $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  3,
        'trans_moc' =>  $request->employee_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

  $acc= transactions::create([
               'debit_or_credit'=>1,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=> $request->employee_id,
               'trans_moc_type'=> 3,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}

}

if($request->credit_amount){


if($request->invoice_type==0){

     $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  0,
        'trans_moc' =>  $request->member_id,
        'trans_moc_category' =>  memcategoryname($request->member_id),
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

     $acc= transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=> $request->member_id,
               'trans_moc_category' =>  memcategoryname($request->member_id),
               'trans_moc_type'=> 0,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==1){

  $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  1,
        'trans_moc' =>  $request->customer_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);
   $acc= transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=> $request->customer_id,
               'trans_moc_type'=> 1,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==4){

  $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  4,
        'trans_moc' =>  $request->account_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);
  $acc_two= transactions::create([
               'debit_or_credit'=>1,
               'trans_type'=>92,
               'trans_type_id'=> $request->account_id,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=> $request->account,
               'trans_moc_type'=> 4,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
  $acc= transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=> $request->account_id,
               'trans_moc_type'=> 4,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==2){

  $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  2,
        'trans_moc' =>  $request->person_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

  $acc= transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=> $request->person_id,
               'trans_moc_type'=> 2,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}
elseif($request->invoice_type==3){

  $transaction = transactions::create([
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  3,
        'trans_moc' =>  $request->employee_id,
        'date' =>  formatDate($request->invoice_date),
        'receipt_id' => $voucher->id,
         'payment_method' => $request->account,
        ]);

  $acc= transactions::create([
               'debit_or_credit'=>0,
               'trans_type'=>92,
               'trans_type_id'=> $request->account,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=> $request->employee_id,
               'trans_moc_type'=> 3,
               'date'=>  formatDate($request->invoice_date),
               'receipt_id' => $voucher->id,
            ]);
}

}
        if($voucher) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$voucher->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-voucher/finance-voucher-invoice/'.$getlastinsert);
            }else{
                return redirect('finance-and-management/finance-voucher');
            }


    }*/
     public function store(Request $request)
    {
          $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }
 $typo=null;
 $vari=7;

     
      $typo=$request->get('invoice_type');
 
  
         $dd='';
         $cati ='';
         $coa_code='';

        if($typo==0){
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

        else if($typo==1){
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
        else if($typo==3){
             
   $dd=$request->get('employee_id');
       

   if(hr_employment::where('id',$request->get('employee_id'))->exists()){
           $arr_coa=hr_employment::where('id',$request->get('employee_id'))->get()->pluck('account');
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
         else if($typo==2){
             
   $dd=$request->get('person_id');
       

   if(finance_ledger_person::where('id',$request->get('person_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('person_id'))->get()->pluck('account');
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
        else if($typo==4){
             
   $dd=$request->get('account_id');
       
   if(coa_accounts_control::where('code',$request->get('account_id'))->exists()){
           if($request->get('account_id')){
          //  $coa=$arr_coa[0];
             $coa_code=$request->get('account_id');
           //  $dd=$d['coa_code'];
           
           $cati =  coaparent($coa_code);
        
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

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'voucher_type' => 'required',
            'name' => 'required',
         /*   'address' => 'required',*/
          /* 'contact' => 'required',*/
    //  'ledger_amount' => 'required',
            //'cnic' => 'required',
           // 'email' => 'required',
           'account_date' => 'required',
         //   'account'=> 'required',
         //    'payment_method'=> 'required',
               'unit'=>'required',

        ];
         if($request->get('voucher_type')!=5){
            $validation['account']='required';
            $validation['payment_method']='required';
        }
        if($request->get('invoice_type')==0){
            $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else if($request->get('invoice_type')==2){
            $validation['person_id']='required';
        }
         else if($request->get('invoice_type')==4){
            $validation['account_id']='required';
        }
        else if($request->get('invoice_type')==3){
            $validation['employee_id']='required';
        }
        else if($request->get('invoice_type')==1){
            $validation['customer_id']='required';

        }

         //dd($request->all());
       $this->validate($request, $validation);



        if($request->voucher_type==5){
           $request->payment_method=null;
           $request->account=null;
        }




        $voucher = finance_general_voucher::create([

       'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'voucher_type' => $request->voucher_type,
            'name' => $request->name,
            'customer_id' => $request->customer_id,
            'member_id' => $request->member_id,
            'person_id' => $request->person_id,
            'account_id' => $request->account_id,
            'employee_id' => $request->employee_id,
            'address' => $request->address,
           'contact' => $request->contact,
           'ledger_amount' => $request->ledger_amount,
            'cnic' => $request->cnic,
            'invoice_type' => $request->invoice_type,
            'email' => $request->email,

           'debit_amount' => $request->debit_amount,
           'credit_amount' => $request->credit_amount,
            'debit_details' => $request->debit_details,
         'credit_details' => $request->credit_details,
              'account_date' => formatDate($request->account_date),
            'status' => 0,

             'acc_details' => $request->acc_details,
           //  'documents' => $createimg,
            'remarks' => $request->remarks,

              'account' => $request->account,
              'unit' => $request->unit,
              'payment_method' => $request->payment_method,

        ]);



 $vouchertype=trans_type::where('type',4)->where('mod_id',$request->voucher_type)->get()->pluck('id');
          $vouchertypeid  =$vouchertype[0];



if($request->hasFile('documents')) {

           $files = $request->file('documents');
           foreach($files as $file){
             // dd($file);
            if($request->invoice_type==1){ //for Guest/Customer
              
            $createimg=sendGeneralVoucherDocs($file,$size,['type'=>1,'trans_type'=>80,'trans_type_id'=>$voucher->id,'moc_id'=>$request->post('customer_id')]); // type = 81
            }
            else if($request->invoice_type==2){ //for Ledger Account
              $createimg=sendGeneralVoucherDocs($file,$size,['type'=>2,'trans_type'=>80,'trans_type_id'=>$voucher->id,'moc_id'=>$request->post('person_id')]); // type = 80
            }
            else if($request->invoice_type==0){// for Member
              $createimg=sendGeneralVoucherDocs($file,$size,['type'=>0,'trans_type'=>80,'trans_type_id'=>$voucher->id,'moc_id'=>$request->post('member_id')]); // type = 82
            }
        else if($request->invoice_type==3){// for Employee
            $createimg=sendGeneralVoucherDocs($file,$size,['type'=>3,'trans_type'=>80,'trans_type_id'=>$voucher->id,'moc_id'=>$request->post('employee_id')]);  // type = 83
            }
            else if($request->invoice_type==4){// for Account
  $vari=3;
              $accid=coa_accounts_control::where('code', $request->get('account_id'))->get()->pluck('id');   
              $createimg=sendGeneralVoucherDocs($file,$size,['type'=>4,'trans_type'=>80,'trans_type_id'=>$voucher->id,'moc_id'=>$accid[0]]);  // type = 84
            }
          }
       }



if($request->debit_amount){


     $transaction = transactions::create([
        'type'=>$vari,
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  $typo,
        'trans_moc' => $dd,
        'trans_moc_category' => $cati,
        'date' =>  formatDate($request->invoice_date),
       // 'receipt_id' => $voucher->id,
        'payment_method'=>$request->get('payment_method'),
         'account' =>transTypesCoa($vouchertypeid),
         'trans_coa' =>$coa_code,
         // 'is_active' => 1,
           'unit' => $ccc,
        ]);

      $acc= transactions::create([
         'type'=>3,
               'debit_or_credit'=>0,
               'trans_type'=> $vouchertypeid,
               'trans_type_id'=>$voucher->id,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$typo,
              // 'receipt_id'=> $voucher->id,
               'date'=> formatDate($request->account_date),
               'payment_method'=>$request->get('payment_method'),
               'unit'=> $ccc,
            //   'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$coa_code,
 
            ]);

}

if($request->credit_amount){
 

     $transaction = transactions::create([
          'type'=>$vari,
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $voucher->id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  $typo,
        'trans_moc' => $dd,
        'trans_moc_category' => $cati,
        'date' =>  formatDate($request->invoice_date),
       // 'receipt_id' => $voucher->id,
        'payment_method'=>$request->get('payment_method'),
         'account' =>transTypesCoa($vouchertypeid),
         'trans_coa' =>$coa_code,
     //     'is_active' => 1,
           'unit' => $ccc,

        ]);

     $acc= transactions::create([
       

                'type'=>3,
               'debit_or_credit'=> 1,
               'trans_type'=> $vouchertypeid,
               'trans_type_id'=>$voucher->id,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$typo,
             //  'receipt_id'=> $voucher->id,
               'date'=> formatDate($request->account_date),
               'payment_method'=>$request->get('payment_method'),
               'unit'=> $ccc,
         //      'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$coa_code,

            ]);


}
        if($voucher) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
             $getlastinsert=$voucher->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-voucher/finance-voucher-invoice/'.$getlastinsert);
            }else{
                return redirect('finance-and-management/finance-voucher');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_general_voucher  $finance_general_voucher
     * @return \Illuminate\Http\Response
     */
    public function show(finance_general_voucher $finance_general_voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_general_voucher  $finance_general_voucher
     * @return \Illuminate\Http\Response
     */
   public function edit(finance_general_voucher $finance_general_voucher,$id)
    {
        $data['voucher_update'] = finance_general_voucher::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['voucher_update']->code;
$moc_type=0;
$moc_id=0;
        if($data['voucher_update']->member_id){
            $moc_type=0;
            $moc_id=$data['voucher_update']->member_id;


        } if($data['voucher_update']->customer_id){
            $moc_type=1;
        $moc_id=$data['voucher_update']->customer_id;


}if($data['voucher_update']->employee_id){
            $moc_type=3;
        $moc_id=$data['voucher_update']->employee_id;

}
/*
 $data['payment_methods']=finance_account_head::where('status',1)->get();*/
  $data['voucher_types']=finance_voucher_type::where('status',1)->get();
      $data['accounts']=coa_accounts_control::whereIn('cost_center',['1','2'])->get();
 $data['payment_methods']=   trans_type::where('cash_or_payment',2)->where('type',7)->get();
    $data['units']=coa_account::where('desc','!=',null)->get();

 $data['transactionsP']=   transactions::where('trans_type_id',$data['voucher_update']->account)->where('trans_type',92)->where('trans_moc',$moc_id)->where('trans_moc_type',$moc_type)->get()->pluck('id');
 $data['transactionsV']=   transactions::where('trans_type_id',  $data['voucher_update']->id)->where('trans_type',trans_type::where('type',4)->where('mod_id',$data['voucher_update']->voucher_type)->get()->pluck('id'))->get()->pluck('id');

        return view('backend/finance-and-management.finance-general-voucher.finance-general-voucher-aeu', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_general_voucher  $finance_general_voucher
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {

    /*    $accid=finance_general_voucher::where('id', $id)->get()->pluck('account_id');
        $accountid = $accid[0];

        $acc=finance_general_voucher::where('id', $id)->get()->pluck('account');
        $account = $acc[0];
*/

          $magi=fnb_predefined_value::first()->pluck('cost_center');
    if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }
 $typo=null;
 $vari=7;
     
      $typo=$request->get('invoice_type');
 
  
         $dd='';
         $cati ='';
         $coa_code='';

        if($typo==0){
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

        else if($typo==1){
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
        else if($typo==3){
             
   $dd=$request->get('employee_id');
       

   if(hr_employment::where('id',$request->get('employee_id'))->exists()){
           $arr_coa=hr_employment::where('id',$request->get('employee_id'))->get()->pluck('account');
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
         else if($typo==2){
             
   $dd=$request->get('person_id');
       

   if(finance_ledger_person::where('id',$request->get('person_id'))->exists()){
           $arr_coa=finance_ledger_person::where('id',$request->get('person_id'))->get()->pluck('account');
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
        else if($typo==4){
             
   $dd=$request->get('account_id');
       
   if(coa_accounts_control::where('code',$request->get('account_id'))->exists()){
           if($request->get('account_id')){
          //  $coa=$arr_coa[0];
             $coa_code=$request->get('account_id');
           //  $dd=$d['coa_code'];
           
           $cati =  coaparent($coa_code);
        
          }else{
              $coa_code=null;
           $cati =  null;
        
          }
        }
        
        }
 $vouchertype=trans_type::where('type',4)->where('mod_id',$request->voucher_type)->get()->pluck('id');
          $vouchertypeid  =$vouchertype[0];

          $size['width'] = 300;
    $size['height'] = 200;
        $updateimg='';

if($request->hasFile('documents')) {

           $files = $request->file('documents');

if($request->invoice_type==1){
     $s=finance_general_voucher::find($id)->generalVoucherDocs;
           foreach($s as $m){
               $m->delete();
    }
}
else if($request->invoice_type==2){
     $s=finance_general_voucher::find($id)->generalVoucherDocs;
           foreach($s as $m){
               $m->delete();
    }
}
else if($request->invoice_type==3){
     $s=finance_general_voucher::find($id)->generalVoucherDocs;
           foreach($s as $m){
               $m->delete();
    }
}
else if($request->invoice_type==4){
     $s=finance_general_voucher::find($id)->generalVoucherDocs;
           foreach($s as $m){
               $m->delete();
    }
}
else if($request->invoice_type==0){
           $s=finance_general_voucher::find($id)->generalVoucherDocs;
           foreach($s as $m){
               $m->delete();
           }
           }


           foreach($files as $file){
             // dd($file);
            if($request->invoice_type==1){
              $updateimg=sendGeneralVoucherDocs($file,$size,['type'=>1,'trans_type'=>80,'trans_type_id'=>$id,'moc_id'=>$request->post('customer_id')]);
            }
            else if($request->invoice_type==2){
                $updateimg=sendGeneralVoucherDocs($file,$size,['type'=>2,'trans_type'=>80,'trans_type_id'=>$id,'moc_id'=>$request->post('person_id')]);
            }
            else if($request->invoice_type==0){
                $updateimg=sendGeneralVoucherDocs($file,$size,['type'=>0,'trans_type'=>80,'trans_type_id'=>$id,'moc_id'=>$request->post('member_id')]);
            }
            else if($request->invoice_type==3){
              $updateimg=sendGeneralVoucherDocs($file,$size,['type'=>3,'trans_type'=>80,'trans_type_id'=>$id,'moc_id'=>$request->post('employee_id')]);
            }
            else if($request->invoice_type==4){
                 $vari=3;
                   $accid=coa_accounts_control::where('code', $request->get('account_id'))->get()->pluck('id');
               $updateimg=sendGeneralVoucherDocs($file,$size,['type'=>4,'trans_type'=>80,'trans_type_id'=>$id,'moc_id'=>$accid[0]]);
            }
          }
       }

       $validation=[
          'invoice_no' => 'required',
            'invoice_date' => 'required',
            'voucher_type' => 'required',
            'name' => 'required',
          /*  'address' => 'required',
           'contact' => 'required',*/
        //    'ledger_amount' => 'required',
           // 'cnic' => 'required',
            // 'email' => 'required',
           'account_date' => 'required',
         
        //     'account'=> 'required',
        //     'payment_method'=> 'required',
             'unit'=>'required',

        ];
         if($request->get('voucher_type')!=5){
            $validation['account']='required';
            $validation['payment_method']='required';
        }
       if($request->get('invoice_type')==0){
           $validation['member_code']='required';
            $validation['member_id']='required';
        }
        else if($request->get('invoice_type')==2){
            $validation['person_id']='required';
        }
        else if($request->get('invoice_type')==4){
            $validation['account_id']='required';
        }
        else if($request->get('invoice_type')==1){
            $validation['customer_id']='required';
        }
        else if($request->get('invoice_type')==3){
            $validation['employee_id']='required';
        }
        $this->validate($request, $validation);

        
        if($request->voucher_type==5){
           $request->payment_method=null;
           $request->account=null;
        }

       
/*dd($vouchertypeid);*/
 /*   transactions::whereIn('id',explode(',',$request->transactionsID))->delete();*/




// where('trans_type',$vouchertypeid)
if($request->debit_amount!=NUll){
 
   if(transactions::where('trans_type_id', $id)->where('type',7)->exists()){
        $transaction = transactions::where('trans_type_id', $id)->where('type',7)->updateWithUserstamps([
       'type'=>$vari,
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  $typo,
        'trans_moc' => $dd,
        'trans_moc_category' => $cati,
        'date' =>  formatDate($request->invoice_date),
       // 'receipt_id' => $id,
        'payment_method'=>$request->get('payment_method'),
         'account' =>transTypesCoa($vouchertypeid),
         'trans_coa' =>$coa_code,
         // 'is_active' => 1,
           'unit' => $ccc,
       ]);
   }
  else{
   $transaction = transactions::create([
        'type'=>$vari,
        'debit_or_credit' =>  1,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->debit_amount,
        'trans_moc_type' =>  $typo,
        'trans_moc' => $dd,
        'trans_moc_category' => $cati,
        'date' =>  formatDate($request->invoice_date),
       // 'receipt_id' => $id,
        'payment_method'=>$request->get('payment_method'),
         'account' =>transTypesCoa($vouchertypeid),
         'trans_coa' =>$coa_code,
         // 'is_active' => 1,
           'unit' => $ccc,
       ]);
  }


if(transactions::where('trans_type_id',$id)->where('type',3)->exists()){
       $acc= transactions::where('trans_type_id',$id)->where('type',3)->updateWithUserstamps([
               'type'=>3,
               'debit_or_credit'=>0,
               'trans_type'=> $vouchertypeid,
               'trans_type_id'=>$id,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$typo,
              // 'receipt_id'=> $id,
               'date'=> formatDate($request->account_date),
               'payment_method'=>$request->get('payment_method'),
               'unit'=> $ccc,
            //   'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$coa_code,
           ]);
   }
else{
       $acc= transactions::create([
               'type'=>3,
               'debit_or_credit'=>0,
               'trans_type'=> $vouchertypeid,
               'trans_type_id'=>$id,
               'trans_amount'=> $request->debit_amount,
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$typo,
              // 'receipt_id'=> $id,
               'date'=> formatDate($request->account_date),
               'payment_method'=>$request->get('payment_method'),
               'unit'=> $ccc,
            //   'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$coa_code,
           ]);
  }
 

   }



if($request->credit_amount!=null){
 
   if(transactions::where('trans_type_id', $id)->where('type',7)->exists()){
        $transaction = transactions::where('trans_type_id', $id)->where('type',7)->updateWithUserstamps([
        'type'=>$vari,
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  $typo,
        'trans_moc' => $dd,
        'trans_moc_category' => $cati,
        'date' =>  formatDate($request->invoice_date),
        'payment_method'=>$request->get('payment_method'),
       // 'receipt_id' => $id,
         'account' =>transTypesCoa($vouchertypeid),
         'trans_coa' =>$coa_code,
     //     'is_active' => 1,
           'unit' => $ccc,
       ]);
   }
  else{
   $transaction = transactions::create([
       'type'=>$vari,
        'debit_or_credit' =>  0,
        'trans_type' =>  $vouchertypeid,
        'trans_type_id' =>  $id,
        'trans_amount' =>  $request->credit_amount,
        'trans_moc_type' =>  $typo,
        'trans_moc' => $dd,
        'trans_moc_category' => $cati,
        'date' =>  formatDate($request->invoice_date),
        'payment_method'=>$request->get('payment_method'),
       // 'receipt_id' => $id,
         'account' =>transTypesCoa($vouchertypeid),
         'trans_coa' =>$coa_code,
     //     'is_active' => 1,
           'unit' => $ccc,
       ]);
  }

  if(transactions::where('trans_type_id',$id)->where('type',3)->exists()){
       $acc= transactions::where('trans_type_id',$id)->where('type',3)->updateWithUserstamps([
               'type'=>3,
               'debit_or_credit'=> 1,
               'trans_type'=> $vouchertypeid,
               'trans_type_id'=>$id,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$typo,
             //  'receipt_id'=> $id,
               'date'=> formatDate($request->account_date),
               'payment_method'=>$request->get('payment_method'),
               'unit'=> $ccc,
         //      'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$coa_code,
           ]);
   }
else{
       $acc= transactions::create([
              'type'=>3,
               'debit_or_credit'=> 1,
               'trans_type'=> $vouchertypeid,
               'trans_type_id'=>$id,
               'trans_amount'=> $request->credit_amount,
               'trans_moc'=>$dd,
               'trans_moc_category' => $cati,
               'trans_moc_type'=>$typo,
             //  'receipt_id'=> $id,
               'date'=> formatDate($request->account_date),
               'payment_method'=>$request->get('payment_method'),
               'unit'=> $ccc,
         //      'is_active'=>1,
               'account'=>$request->get('account'),
                'trans_coa'=>$coa_code,
           ]);
  }
 

}
/*         if($request->debit_amount){


             if($request->invoice_type==0){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  0,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->debit_amount,
                     'trans_moc_type' =>  0,
                     'trans_moc' =>  $request->member_id,
                     'trans_moc_category' =>  memcategoryname($request->member_id),
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc= transactions::create([
                     'debit_or_credit'=>1,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->debit_amount,
                     'trans_moc'=> $request->member_id,
                     'trans_moc_category' =>  memcategoryname($request->member_id),
                     'trans_moc_type'=> 0,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==1){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  0,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->debit_amount,
                     'trans_moc_type' =>  1,
                     'trans_moc' =>  $request->customer_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);


                 $acc= transactions::create([
                     'debit_or_credit'=>1,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->debit_amount,
                     'trans_moc'=> $request->customer_id,
                     'trans_moc_type'=> 1,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==4){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  0,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->debit_amount,
                     'trans_moc_type' =>  4,
                     'trans_moc' =>  $request->account_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc_two= transactions::create([
                     'debit_or_credit'=>0,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account_id,
                     'trans_amount'=> $request->debit_amount,
                     'trans_moc'=> $request->account,
                     'trans_moc_type'=> 4,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,

                 ]);
                 $acc= transactions::create([
                     'debit_or_credit'=>1,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->debit_amount,
                     'trans_moc'=> $request->account_id,
                     'trans_moc_type'=> 4,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==2){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  0,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->debit_amount,
                     'trans_moc_type' =>  2,
                     'trans_moc' =>  $request->person_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc= transactions::create([
                     'debit_or_credit'=>1,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->debit_amount,
                     'trans_moc'=> $request->person_id,
                     'trans_moc_type'=> 2,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==3){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  0,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->debit_amount,
                     'trans_moc_type' =>  3,
                     'trans_moc' =>  $request->employee_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc= transactions::create([
                     'debit_or_credit'=>1,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->debit_amount,
                     'trans_moc'=> $request->employee_id,
                     'trans_moc_type'=> 3,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }

         }

         if($request->credit_amount){


             if($request->invoice_type==0){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  1,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->credit_amount,
                     'trans_moc_type' =>  0,
                     'trans_moc' =>  $request->member_id,
                     'trans_moc_category' =>  memcategoryname($request->member_id),
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc= transactions::create([
                     'debit_or_credit'=>0,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->credit_amount,
                     'trans_moc'=> $request->member_id,
                     'trans_moc_category' =>  memcategoryname($request->member_id),
                     'trans_moc_type'=> 0,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==1){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  1,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->credit_amount,
                     'trans_moc_type' =>  1,
                     'trans_moc' =>  $request->customer_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);
                 $acc= transactions::create([
                     'debit_or_credit'=>0,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->credit_amount,
                     'trans_moc'=> $request->customer_id,
                     'trans_moc_type'=> 1,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==4){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  1,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->credit_amount,
                     'trans_moc_type' =>  4,
                     'trans_moc' =>  $request->account_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);
                 $acc_two= transactions::create([
                     'debit_or_credit'=>1,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account_id,
                     'trans_amount'=> $request->credit_amount,
                     'trans_moc'=> $request->account,
                     'trans_moc_type'=> 4,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
                 $acc= transactions::create([
                     'debit_or_credit'=>0,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->credit_amount,
                     'trans_moc'=> $request->account_id,
                     'trans_moc_type'=> 4,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==2){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  1,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->credit_amount,
                     'trans_moc_type' =>  2,
                     'trans_moc' =>  $request->person_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc= transactions::create([
                     'debit_or_credit'=>0,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->credit_amount,
                     'trans_moc'=> $request->person_id,
                     'trans_moc_type'=> 2,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }
             elseif($request->invoice_type==3){

                 $transaction = transactions::create([
                     'debit_or_credit' =>  1,
                     'trans_type' =>  $vouchertypeid,
                     'trans_type_id' =>  $id,
                     'trans_amount' =>  $request->credit_amount,
                     'trans_moc_type' =>  3,
                     'trans_moc' =>  $request->employee_id,
                     'date' =>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                      'payment_method' => $request->account,
                 ]);

                 $acc= transactions::create([
                     'debit_or_credit'=>0,
                     'trans_type'=>92,
                     'trans_type_id'=> $request->account,
                     'trans_amount'=> $request->credit_amount,
                     'trans_moc'=> $request->employee_id,
                     'trans_moc_type'=> 3,
                     'date'=>  formatDate($request->invoice_date),
                     'receipt_id' => $id,
                 ]);
             }

         }*/

        $voucher = finance_general_voucher::where('id', $id)->updateWithUserstamps([
 'invoice_no' =>  $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'voucher_type' => $request->voucher_type,
            'name' => $request->name,
            'customer_id' => $request->customer_id,
            'member_id' => $request->member_id,
            'person_id' => $request->person_id,
            'account_id' => $request->account_id,
            'employee_id' => $request->employee_id,
            'address' => $request->address,
           'contact' => $request->contact,
           'ledger_amount' => $request->ledger_amount,
            'cnic' => $request->cnic,
            'invoice_type' => $request->invoice_type,
            'email' => $request->email,

           'debit_amount' => $request->debit_amount,
           'credit_amount' => $request->credit_amount,
            'debit_details' => $request->debit_details,
         'credit_details' => $request->credit_details,
              'account_date' => formatDate($request->account_date),
          
             'acc_details' => $request->acc_details,
        //     'documents' => $updateimg,
            'remarks' => $request->remarks,

              'account' => $request->account,
              'unit' => $request->unit,
              'payment_method' => $request->payment_method,

        ]);



        if ($voucher) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-voucher/finance-voucher-aeu/'.$id);

    }


      public function post(Request $request, $id)
    {
 
        $vtype=finance_general_voucher::where('id', $id)->get()->pluck('voucher_type');
        $jvtype=$vtype[0];

        $voucher = finance_general_voucher::where('id', $id)->updateWithUserstamps([

            'status' => 1
        ]);

$vouchertype=trans_type::where('type',4)->where('mod_id',$jvtype)->get()->pluck('id');
$vouchertypeid  =$vouchertype[0];

 if(transactions::where('type',7)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->exists()){
        $transaction = transactions::where('type',7)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->updateWithUserstamps([
        'is_active' => 1,
        ]);
    }

  if(transactions::where('type',3)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->exists()){
         $transaction = transactions::where('type',3)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->updateWithUserstamps([
        'is_active' => 1,
        ]);
    }

        if ($voucher) {
            Session::flash('message', 'Voucher Posted Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Voucher Not Posted !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-voucher');

    }


    public function unpost(Request $request, $id)
    {
        $vtype=finance_general_voucher::where('id', $id)->get()->pluck('voucher_type');
        $jvtype=$vtype[0];

        $voucher = finance_general_voucher::where('id', $id)->updateWithUserstamps([

            'status' => 0
        ]);

$vouchertype=trans_type::where('type',4)->where('mod_id',$jvtype)->get()->pluck('id');
$vouchertypeid  =$vouchertype[0];

 if(transactions::where('type',7)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->exists()){
         $transaction = transactions::where('type',7)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->updateWithUserstamps([
        'is_active' => 0,
        ]);
    }

  if(transactions::where('type',3)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->exists()){
         $transaction = transactions::where('type',3)->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->updateWithUserstamps([
        'is_active' => 0,
        ]);
    }

        if ($voucher) {
            Session::flash('message', 'Voucher Unposted Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Voucher Not Unposted !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-voucher');

    }

    function vouchertype($id){
      $debit=finance_voucher_type::where('id',$id)->pluck('debit')->first();
      $credit=finance_voucher_type::where('id',$id)->pluck('credit')->first();
      if($credit){
        $creditfinal = $credit;
      }
      else
      {
        $creditfinal = 0;
      }

      if($debit){
        $debitfinal = $debit;
      }
      else
      {
        $debitfinal = 0;
      }
      return $debitfinal.$creditfinal;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_general_voucher  $finance_general_voucher
     * @return \Illuminate\Http\Response
     */
     public function destroy(finance_general_voucher $finance_general_voucher,$id)
    {
        $type= $finance_general_voucher::where('id', $id)->get()->pluck('voucher_type');
        $vouchertype=trans_type::where('type',4)->where('mod_id',$type)->get()->pluck('id');
          $vouchertypeid  =$vouchertype[0];


        $voucher= $finance_general_voucher::where('id', $id)->deleteWithUserstamps();

    if(transactions::where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',7)->exists()){
        transactions::where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',7)->deleteWithUserstamps();
    }
     if(transactions::where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',3)->exists()){
        transactions::where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',3)->deleteWithUserstamps();
    }

   
        if($voucher){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-voucher');
    }

    public function restore(finance_general_voucher $finance_general_voucher,$id)
    {
        $type= $finance_general_voucher::onlyTrashed()->where('id', $id)->get()->pluck('voucher_type');
   $vouchertype=trans_type::where('type',4)->where('mod_id',$type)->get()->pluck('id');
          $vouchertypeid  =$vouchertype[0];

        $restore = finance_general_voucher::onlyTrashed()->find($id)->restore();

    if(transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',7)->exists()){
       transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',7)->restore();
    }

    if(transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',3)->exists()){
       transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type',$vouchertypeid)->where('type',3)->restore();
    }
     
       
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-voucher/deleted');

}

 public function invoice(finance_general_voucher $finance_general_voucher,$id)
    {

         $data['receiptdata']=finance_general_voucher::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();

 $typeid=$data['receiptdata']->account;
 $data['accounttype']=finance_account_type::with('accounttypes')->where('id',$typeid)->first();

        return view('backend/finance-and-management.finance-general-voucher.finance-general-voucher-invoice', $data);
    }

    public function docs(finance_general_voucher $finance_general_voucher,$id)
    {
        $data['receiptdata']=finance_general_voucher::where('id',$id)->first();

        return view('backend/finance-and-management.finance-general-voucher.finance-general-voucher-documents', $data);
    }

}
