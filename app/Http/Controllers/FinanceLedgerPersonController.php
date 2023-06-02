<?php

namespace App\Http\Controllers;

use App\finance_ledger_person;
use DataTables;
use Illuminate\Http\Request;
use Session; 

class FinanceLedgerPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_ledger_person $finance_ledger_person)
    {
        return view('backend/finance-and-management/finance_ledger_persons/finance_ledger_persons');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, finance_ledger_person $finance_ledger_person)
    {

        $person = finance_ledger_person::get();
        return DataTables::of($person)
        

            ->addColumn('editbutton', function ($person) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/suppliers/suppliers-aeu/') . '/' . $person->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($person) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/suppliers/delete') . '/' . $person->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, finance_ledger_person $finance_ledger_person)
    {
        return view('backend/finance-and-management/finance_ledger_persons/finance-ledger-persons-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_ledger_person $finance_ledger_person)
    {

        $deleted = finance_ledger_person::onlyTrashed()->get();
        return DataTables::of($deleted)


            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/suppliers/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        //
         $lastval = finance_ledger_person::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['person_update'] = '';
 
        return view('backend/finance-and-management.finance_ledger_persons.finance_ledger_persons-aeu', $data);
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
      
            'person_no' => 'required',
            'person_name' => 'required|unique:finance_ledger_people,person_name',
            'person_address' => 'required',
           // 'person_cnic' => 'required',
            'person_contact' => 'required|unique:finance_ledger_people,person_contact',
           //'person_email' => 'required',

            /*'acc_title' => 'required',
            'acc_no' => 'required',
            'branch_code' => 'required',
            'branch_address' => 'required',*/
        ]);

        $person = finance_ledger_person::create([
       
            'person_no' => $request->person_no,
            'person_name' => $request->person_name,
            'person_address' => $request->person_address,
            'person_cnic' => $request->person_cnic,
            'person_contact' => $request->person_contact,
            'person_email' => $request->person_email,
            'account' => $request->account,

            'acc_title' => $request->acc_title,
            'acc_no' => $request->acc_no,
            'branch_code' => $request->branch_code,
            'branch_address' => $request->branch_address,

            'contact_b' => $request->contact_b,
            'contact_c' => $request->contact_c,
            'ntn' => $request->ntn,
        ]);

        if ($person) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/suppliers/suppliers-aeu');
            }else{
                return redirect('finance-and-management/suppliers');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_ledger_person  $finance_ledger_person
     * @return \Illuminate\Http\Response
     */
    public function show(finance_ledger_person $finance_ledger_person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_ledger_person  $finance_ledger_person
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_ledger_person $finance_ledger_person,$id)
    {
         $data['person_update'] = finance_ledger_person::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['person_update']->code;

        return view('backend/finance-and-management.finance_ledger_persons.finance_ledger_persons-aeu', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_ledger_person  $finance_ledger_person
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
           'person_no' => 'required',
            'person_name' => 'required|unique:finance_ledger_people,person_name,'.$id,
            'person_address' => 'required',
           // 'person_cnic' => 'required',
            'person_contact' => 'required|unique:finance_ledger_people,person_contact,'.$id,
           //'person_email' => 'required'
        ]);

        $person = finance_ledger_person::where('id', $id)->updateWithUserstamps([
            'person_no' => $request->person_no,
            'person_name' => $request->person_name,
            'person_address' => $request->person_address,
            'person_cnic' => $request->person_cnic,
            'person_contact' => $request->person_contact,
            'person_email' => $request->person_email,
            'account' => $request->account,

            'acc_title' => $request->acc_title,
            'acc_no' => $request->acc_no,
            'branch_code' => $request->branch_code,
            'branch_address' => $request->branch_address,

            'contact_b' => $request->contact_b,
            'contact_c' => $request->contact_c,
            'ntn' => $request->ntn,
        ]);

        if ($person) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/suppliers/suppliers-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_ledger_person  $finance_ledger_person
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_ledger_person $finance_ledger_person,$id)
    {
        $person=$finance_ledger_person::where('id', $id)->deleteWithUserstamps();
        if($person){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/suppliers');
    }


    public function restore(finance_ledger_person $finance_ledger_person,$id)
    {
        $restore = finance_ledger_person::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/suppliers/deleted');

}

}
