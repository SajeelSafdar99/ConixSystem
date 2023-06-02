<?php

namespace App\Http\Controllers;

use App\finance_payment_receivable;
use DataTables;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Permission;

class FinancePaymentReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_payment_receivable $finance_payment_receivable)
    {
        return view('backend/finance-and-management/finance-payment-receivables/finance-payment-receivables');
    }


     public function indexdt(Request $request, finance_payment_receivable $finance_payment_receivable)
    {

        $payment = finance_payment_receivable::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }



            })

            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-payment-receivables/finance-payment-receivables-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-payment-receivables/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


    public function index_deleted(Request $request, finance_payment_receivable $finance_payment_receivable)
    {
        return view('backend/finance-and-management/finance-payment-receivables/finance-payment-receivables-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_payment_receivable $finance_payment_receivable)
    {

        $payment_receivable = finance_payment_receivable::onlyTrashed()->get();
        return DataTables::of($payment_receivable)

            ->addColumn('restorebutton', function ($payment_receivable) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-payment-receivables/restore/') . '/' . $payment_receivable->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval = finance_payment_receivable::withTrashed()->latest('id')->first();
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

        return view('backend/finance-and-management.finance-payment-receivables.finance-payment-receivables-aeu', $data);
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
            'receivable_name' => 'required|unique:finance_payment_receivables,desc',
            'status'   => 'required']);

        $payment_receivable = finance_payment_receivable::create([
            //'code'   => $request->code,
            'desc'   => $request->receivable_name,
            'status' => $request->status,

        ]);
//        dd($payment_receivable->id);
        Permission::create(['name' => $request->receivable_name.' '.$payment_receivable->id,'category'=>16,'auto_generated' => 1]);

        if ($payment_receivable) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-payment-receivables/finance-payment-receivables-aeu');
            }else{
                return redirect('finance-and-management/finance-payment-receivables');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_payment_receivable  $finance_payment_receivable
     * @return \Illuminate\Http\Response
     */
    public function show(finance_payment_receivable $finance_payment_receivable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_payment_receivable  $finance_payment_receivable
     * @return \Illuminate\Http\Response
     */
     public function edit(finance_payment_receivable $finance_payment_receivable,$id)
    {
         $data['payment_update'] = finance_payment_receivable::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['payment_update']->code;

        return view('backend/finance-and-management.finance-payment-receivables.finance-payment-receivables-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_payment_receivable  $finance_payment_receivable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
            'receivable_name' => 'required|unique:finance_payment_receivables,desc,'.$id,
            'status'   => 'required']);

        $payments = finance_payment_receivable::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->receivable_name,
            'status' => $request->status,
        ]);

        if ($payments) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-payment-receivables/finance-payment-receivables-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_payment_receivable  $finance_payment_receivable
     * @return \Illuminate\Http\Response
     */
     public function destroy(finance_payment_receivable $finance_payment_receivable,$id)
    {
        $paymentreceivable=$finance_payment_receivable::where('id', $id)->deleteWithUserstamps();
        if($paymentreceivable){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('finance-and-management/finance-payment-receivables');
    }

public function restore(finance_payment_receivable $finance_payment_receivable,$id)
    {
        $restore = finance_payment_receivable::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-payment-receivables/deleted');

}

}
