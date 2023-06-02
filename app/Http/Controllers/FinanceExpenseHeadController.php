<?php

namespace App\Http\Controllers;

use App\finance_expense_head;
use Illuminate\Http\Request;
use DataTables;
use Session;

class FinanceExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_expense_head $finance_expense_head)
    {
        return view('backend/finance-and-management/finance-expense-heads/finance-expense-heads');
    }

     public function indexdt(Request $request, finance_expense_head $finance_expense_head)
    {

        $payment = finance_expense_head::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-expense-heads/finance-expense-heads-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-expense-heads/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


    public function index_deleted(Request $request, finance_expense_head $finance_expense_head)
    {
        return view('backend/finance-and-management/finance-expense-heads/finance-expense-heads-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_expense_head $finance_expense_head)
    {

        $deleted = finance_expense_head::onlyTrashed()->get();
        return DataTables::of($deleted)

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-expense-heads/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
         //Get the last record id and pass to the view
        $lastval = finance_expense_head::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['exp_head_update'] = '';

        return view('backend/finance-and-management.finance-expense-heads.finance-expense-heads-aeu', $data);
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
            
            'desc' => 'required|unique:finance_expense_heads,desc',
            'status'   => 'required']);

        $payment = finance_expense_head::create([
         
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if ($payment) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-expense-heads/finance-expense-heads-aeu');
            }else{
                return redirect('finance-and-management/finance-expense-heads');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\finance_expense_head  $finance_expense_head
     * @return \Illuminate\Http\Response
     */
    public function show(finance_expense_head $finance_expense_head)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_expense_head  $finance_expense_head
     * @return \Illuminate\Http\Response
     */
      public function edit(finance_expense_head $finance_expense_head,$id)
    {
         $data['exp_head_update'] = finance_expense_head::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['exp_head_update']->code;

        return view('backend/finance-and-management.finance-expense-heads.finance-expense-heads-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_expense_head  $finance_expense_head
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
       $this->validate($request, [
            'desc' => 'required|unique:finance_expense_heads,desc,'.$id,
            'status'   => 'required']);

        $payment = finance_expense_head::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($payment) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-expense-heads/finance-expense-heads-aeu/'.$id);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_expense_head  $finance_expense_head
     * @return \Illuminate\Http\Response
     */
   public function destroy(finance_expense_head $finance_expense_head,$id)
    {
        $payment=$finance_expense_head::where('id', $id)->deleteWithUserstamps();
        if($payment){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/finance-expense-heads');
    }


    public function restore(finance_expense_head $finance_expense_head,$id)
    {
        $restore = finance_expense_head::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-expense-heads/deleted');

}

}
