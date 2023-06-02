<?php

namespace App\Http\Controllers;
use App\finance_expense_head;
use App\trans_type;
use App\finance_expense_paid_for;
use DataTables;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Permission;

class FinanceExpensePaidForController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_expense_paid_for $finance_expense_paid_for)
    {
        return view('backend/finance-and-management/finance-expense-paid-for/finance-expense-paid-for');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, finance_expense_paid_for $finance_expense_paid_for)
    {

        $payment = finance_expense_paid_for::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

             ->addColumn('expense_head', function ($payment) {
            if($payment->expense_head){
                  return ExpenseHeadName($payment->expense_head);
                  }
                else{
                    return '';
                }

           })


            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-expense-paid-for/finance-expense-paid-for-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-expense-paid-for/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton', 'status', 'expense_head'])
         ->addIndexColumn()
            ->make(true);
    }


 public function index_deleted(Request $request, finance_expense_paid_for $finance_expense_paid_for)
    {
        return view('backend/finance-and-management/finance-expense-paid-for/finance-expense-paid-for-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_expense_paid_for $finance_expense_paid_for)
    {

        $expense_paid_for = finance_expense_paid_for::onlyTrashed()->get();
        return DataTables::of($expense_paid_for)


            ->addColumn('restorebutton', function ($expense_paid_for) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-expense-paid-for/restore/') . '/' . $expense_paid_for->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

              ->addColumn('expense_head', function ($expense_paid_for) {
            if($expense_paid_for->expense_head){
                  return ExpenseHeadName($expense_paid_for->expense_head);
                  }
                else{
                    return '';
                }

           })



        ->rawColumns(['restorebutton', 'expense_head'])
        ->addIndexColumn()
        ->make(true);
    }


    public function create()
    {
         //Get the last record id and pass to the view
        $lastval = finance_expense_paid_for::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['expense_update'] = '';

        $data['expense_heads']=finance_expense_head::where('status',1)->get();

        return view('backend/finance-and-management.finance-expense-paid-for.finance-expense-paid-for-aeu', $data);
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
             'expense_head'   => 'required',
            'desc' => 'required|unique:finance_expense_paid_fors,desc',
            'status'   => 'required']);

        $expense_paid_for = finance_expense_paid_for::create([
         'expense_head'   => $request->expense_head,
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

          $transtype = trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $expense_paid_for->id,
            'type'   => 5,
            'cash_or_payment'   => 1,
            'details' => 'expenseInvoice',
            'table_name' => 'finance_expense'
        ]);

          if($transtype){
    Permission::create(['name' => $request->desc.' '.$expense_paid_for->id,'category'=>21,'auto_generated' => 1]);
}

        if ($expense_paid_for) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-expense-paid-for/finance-expense-paid-for-aeu');
            }else{
                return redirect('finance-and-management/finance-expense-paid-for');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_expense_paid_for  $finance_expense_paid_for
     * @return \Illuminate\Http\Response
     */
    public function show(finance_expense_paid_for $finance_expense_paid_for)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_expense_paid_for  $finance_expense_paid_for
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_expense_paid_for $finance_expense_paid_for,$id)
    {
         $data['expense_update'] = finance_expense_paid_for::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['expense_update']->code;

         $data['expense_heads']=finance_expense_head::where('status',1)->get();

        return view('backend/finance-and-management.finance-expense-paid-for.finance-expense-paid-for-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_expense_paid_for  $finance_expense_paid_for
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
        'expense_head'   => 'required',
            'desc' => 'required|unique:finance_expense_paid_fors,desc,'.$id,
            'status'   => 'required']);

if(Permission::where('category',21)->where('name', $request->desc.' '.$id)->exists()){
    Permission::where('category',21)->where('name', $request->desc.' '.$id)->updateWithUserstamps([
            'name'=>$request->desc.' '.$id,
            'category'=>21,
            'auto_generated' => 1
        ]);
}
else{
    Permission::create(['name' => $request->desc.' '.$id,'category'=>21,'auto_generated' => 1]);
}

        $expense_paid_for = finance_expense_paid_for::where('id', $id)->updateWithUserstamps([
             'expense_head'   => $request->expense_head,
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

if(trans_type::where('type',5)->where('mod_id', $id)->exists()){
          $transtype = trans_type::where('type',5)->where('mod_id', $id)->updateWithUserstamps([
            'name'   => $request->desc,
            'mod_id'   => $id,
            'type'   => 5,
            'cash_or_payment'   => 1,
            'details' => 'expenseInvoice',
            'table_name' => 'finance_expense'
        ]);
}else{
      $transtype = trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $id,
            'type'   => 5,
            'cash_or_payment'   => 1,
            'details' => 'expenseInvoice',
            'table_name' => 'finance_expense'
        ]);
}

        if ($expense_paid_for) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-expense-paid-for/finance-expense-paid-for-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_expense_paid_for  $finance_expense_paid_for
     * @return \Illuminate\Http\Response
     */
     public function destroy(finance_expense_paid_for $finance_expense_paid_for,$id)
    {
         $getname = finance_expense_paid_for::where('id', $id)->get()->pluck('desc');
         $getnamedesc =$getname[0];

        $expense_paid_for=$finance_expense_paid_for::where('id', $id)->deleteWithUserstamps();

if(trans_type::where('type',5)->where('mod_id', $id)->exists()){
       trans_type::where('type',5)->where('mod_id', $id)->deleteWithUserstamps();
}
if(Permission::where('category',21)->where('name', $getnamedesc.' '.$id)->exists()){
            Permission::where('category',21)->where('name', $getnamedesc.' '.$id)->deleteWithUserstamps();
}
   
        if($expense_paid_for){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/finance-expense-paid-for');
    }


public function restore(finance_expense_paid_for $finance_expense_paid_for,$id)
    {

         $getname = finance_expense_paid_for::onlyTrashed()->where('id', $id)->get()->pluck('desc');
         $getnamedesc =$getname[0];

        $restore = finance_expense_paid_for::onlyTrashed()->find($id)->restore();

        if(trans_type::onlyTrashed()->where('type',5)->where('mod_id', $id)->exists()){
            trans_type::onlyTrashed()->where('type',5)->where('mod_id', $id)->restore();
        }

         if(Permission::onlyTrashed()->where('category',21)->where('name', $getnamedesc.' '.$id)->exists()){
            Permission::onlyTrashed()->where('category',21)->where('name', $getnamedesc.' '.$id)->restore();
        }

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-expense-paid-for/deleted');

}


}
