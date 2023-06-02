<?php

namespace App\Http\Controllers;

use App\finance_level_one;
use App\finance_level_two;
use DataTables;
use Illuminate\Http\Request;
use Session;

class FinanceLevelTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_level_two $finance_level_two)
    {
        return view('backend/finance-and-management/finance-level-two/finance-level-two');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, finance_level_two $finance_level_two)
    {

        $payment = finance_level_two::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-level-two/finance-level-two-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-level-two/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->addColumn('level_one', function ($payment) {

if($payment->level_one)
{
     $headname=finance_level_one::where('id',$payment->level_one)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          

                })


              ->addColumn('id', function ($payment) {
if($payment->level_one)
{
     return $payment->level_one.'-'.$payment->id;
}
     else {
        return $payment->id;
     }          
                })


            ->rawColumns(['editbutton', 'deletebutton', 'status', 'level_one'])
         ->addIndexColumn()
            ->make(true);
    }


public function index_deleted(Request $request, finance_level_two $finance_level_two)
    {
        return view('backend/finance-and-management/finance-level-two/finance-level-two-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_level_two $finance_level_two)
    {

        $deleted = finance_level_two::onlyTrashed()->get();
        return DataTables::of($deleted)

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-level-two/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

              ->addColumn('level_one', function ($payment) {

if($payment->level_one)
{
     $headname=finance_level_one::where('id',$payment->level_one)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          

                })

        ->rawColumns(['restorebutton', 'level_one'])
        ->addIndexColumn()
        ->make(true);
    }

   public function create()
    {
         //Get the last record id and pass to the view
        $lastval = finance_level_two::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['level_two_update'] = '';

        $data['ones']=finance_level_one::where('status',1)->get();

        return view('backend/finance-and-management.finance-level-two.finance-level-two-aeu', $data);
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
            'level_one'   => 'required',
            'desc' => 'required|unique:finance_level_twos,desc',
            'status'   => 'required']);

        $payment = finance_level_two::create([
         'level_one'   => $request->level_one,
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
                return redirect('finance-and-management/finance-level-two/finance-level-two-aeu');
            }else{
                return redirect('finance-and-management/finance-level-two');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\finance_level_two  $finance_level_two
     * @return \Illuminate\Http\Response
     */
    public function show(finance_level_two $finance_level_two)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_level_two  $finance_level_two
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_level_two $finance_level_two,$id)
    {
         $data['level_two_update'] = finance_level_two::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['level_two_update']->code;

        $data['ones']=finance_level_one::where('status',1)->get();

        return view('backend/finance-and-management.finance-level-two.finance-level-two-aeu', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_level_two  $finance_level_two
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
        'level_one'   => 'required',
            'desc' => 'required|unique:finance_level_twos,desc,'.$id,
            'status'   => 'required']);

        $payment = finance_level_two::where('id', $id)->updateWithUserstamps([
            'level_one'   => $request->level_one,
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

        return redirect('finance-and-management/finance-level-two/finance-level-two-aeu/'.$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_level_two  $finance_level_two
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_level_two $finance_level_two,$id)
    {
        $payment=$finance_level_two::where('id', $id)->deleteWithUserstamps();
        if($payment){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/finance-level-two');
    }

 
public function restore(finance_level_two $finance_level_two,$id)
    {
        $restore = finance_level_two::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-level-two/deleted');

}

}