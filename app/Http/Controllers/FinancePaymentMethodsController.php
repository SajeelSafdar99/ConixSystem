<?php

namespace App\Http\Controllers;
use App\trans_type;
use Spatie\Permission\Models\Permission;
use App\finance_payment_methods;
use DataTables;
use Illuminate\Http\Request;
use Session;
use App\coa_accounts_control;
use App\coa_trans_types;

class FinancePaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, finance_payment_methods $finance_payment_methods)
    {
        return view('backend/finance-and-management/finance-payment-methods/finance-payment-methods');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, finance_payment_methods $finance_payment_methods)
    {

        $payment = finance_payment_methods::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-payment-methods/finance-payment-methods-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-payment-methods/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }




 public function index_deleted(Request $request, finance_payment_methods $finance_payment_methods)
    {
        return view('backend/finance-and-management/finance-payment-methods/finance-payment-methods-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_payment_methods $finance_payment_methods)
    {

        $payment_method = finance_payment_methods::onlyTrashed()->get();
        return DataTables::of($payment_method)

            ->addColumn('restorebutton', function ($payment_method) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-payment-methods/restore/') . '/' . $payment_method->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }


    public function create()
    {
        //Get the last record id and pass to the view
        $lastval = finance_payment_methods::withTrashed()->latest('id')->first();
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

            $data['accounts']=  coa_trans_types::all();

        return view('backend/finance-and-management.finance-payment-methods.finance-payment-methods-aeu', $data);
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
        $this->validate($request, [
            //'code'     => 'required',
            'desc' => 'required|unique:finance_payment_methods,desc',
             'account'   => 'required',
            'status'   => 'required']);

        $payment_method = finance_payment_methods::create([
            //'code'   => $request->code,
            'desc'   => $request->desc,
             'coa_trans_type'   => $request->account,
            'status' => $request->status,

        ]);

        $transtype = trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $payment_method->id,
            'type'   => 7,
            'cash_or_payment'   => 2,
            'details' => '',
            'table_name' => ''
        ]);


if($transtype){
    Permission::create(['name' => $request->desc.' '.$payment_method->id,'category'=>23,'auto_generated' => 1]);
}


        if ($payment_method) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-payment-methods/finance-payment-methods-aeu');
            }else{
                return redirect('finance-and-management/finance-payment-methods');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_payment_methods  $finance_payment_methods
     * @return \Illuminate\Http\Response
     */
    public function show(finance_payment_methods $finance_payment_methods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_payment_methods  $finance_payment_methods
     * @return \Illuminate\Http\Response
     */

    public function edit(finance_payment_methods $finance_payment_methods,$id)
    {
         $data['payment_update'] = finance_payment_methods::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['payment_update']->code;
  $data['accounts']=  coa_trans_types::all();
        return view('backend/finance-and-management.finance-payment-methods.finance-payment-methods-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_payment_methods  $finance_payment_methods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $theprename='';
        $theprename=finance_payment_methods::where('id', $id)->get()->pluck('desc');
        
       $this->validate($request, [
            'desc' => 'required|unique:finance_payment_methods,desc,'.$id,
             'account'   => 'required',
            'status'   => 'required']);

        $payments = finance_payment_methods::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
             'coa_trans_type'   => $request->account,
            'status' => $request->status,
        ]);

if(Permission::where('category',23)->where('name', $theprename[0].' '.$id)->exists()){
    Permission::where('category',23)->where('name', $theprename[0].' '.$id)->updateWithUserstamps([
            'name'=>$request->desc.' '.$id,
            'category'=>23,
            'auto_generated' => 1
        ]);
}
else{
    Permission::create(['name' => $request->desc.' '.$id,'category'=>23,'auto_generated' => 1]);
}


if(trans_type::where('type',7)->where('mod_id', $id)->exists()){
       $transtype = trans_type::where('type',7)->where('mod_id', $id)->updateWithUserstamps([
            'name'   => $request->desc,
            'mod_id'   => $id,
            'type'   => 7,
            'cash_or_payment'   => 2,
            'details' => '',
            'table_name' => ''
        ]);
   }
   else 
   {
          $transtype = trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $id,
            'type'   => 7,
            'cash_or_payment'   => 2,
            'details' => '',
            'table_name' => ''
        ]);
   }

        if ($payments) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-payment-methods/finance-payment-methods-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_payment_methods  $finance_payment_methods
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_payment_methods $finance_payment_methods,$id)
    {

         $getname = finance_payment_methods::where('id', $id)->get()->pluck('desc');
         $getnamedesc =$getname[0];

         $payment_method=$finance_payment_methods::where('id', $id)->deleteWithUserstamps();
        
if(trans_type::where('type',7)->where('mod_id', $id)->exists()){
       trans_type::where('type',7)->where('mod_id', $id)->deleteWithUserstamps();
}
     
if(Permission::where('category',23)->where('name', $getnamedesc.' '.$id)->exists()){
            Permission::where('category',23)->where('name', $getnamedesc.' '.$id)->deleteWithUserstamps();
        }

      
        if($payment_method){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/finance-payment-methods');
    }


public function restore(finance_payment_methods $finance_payment_methods,$id)
    {

        $getname = finance_payment_methods::onlyTrashed()->where('id', $id)->get()->pluck('desc');
        $getnamedesc =$getname[0];

        $restore = finance_payment_methods::onlyTrashed()->find($id)->restore();

        if(trans_type::onlyTrashed()->where('type',7)->where('mod_id', $id)->exists()){
            trans_type::onlyTrashed()->where('type',7)->where('mod_id', $id)->restore();
        }
        
        if(Permission::onlyTrashed()->where('category',23)->where('name', $getnamedesc.' '.$id)->exists()){
            Permission::onlyTrashed()->where('category',23)->where('name', $getnamedesc.' '.$id)->restore();
        }

     
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-payment-methods/deleted');
}


}
