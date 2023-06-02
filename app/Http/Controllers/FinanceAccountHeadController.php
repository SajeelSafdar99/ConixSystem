<?php

namespace App\Http\Controllers;

use App\finance_level_one;
use App\finance_level_two;
use App\finance_level_three;
use App\finance_account_head;
use App\finance_account_type;
use DataTables;
use Illuminate\Http\Request;
use Session;

class FinanceAccountHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_account_head $finance_account_head)
    {
        return view('backend/finance-and-management/finance-account-heads/finance-account-heads');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, finance_account_head $finance_account_head)
    {

        $payment = finance_account_head::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }
            })

            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-account-heads/finance-account-heads-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-account-heads/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

           /* ->addColumn('level_one', function ($payment) {
if($payment->level_one)
{
     $headname=finance_level_one::where('id',$payment->level_one)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          
                })*/
      
      ->addColumn('level_one', function ($payment) {
if($payment->level_three)
{
     $base=finance_level_three::where('id',$payment->level_three)->get()->pluck('level_two');
     if($base){
         $headname=finance_level_two::where('id',$base[0])->get()->pluck('level_one');
     }
    
     if($headname){
         return financeLevelOne($headname);
     }else{
          return '';
     }
}
     else {
        return '';
     }          
                })



                ->addColumn('level_two', function ($payment) {
if($payment->level_three)
{
     $headname=finance_level_three::where('id',$payment->level_three)->get()->pluck('level_two');
     if($headname){
         return financeLevelTwo($headname);
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })



            ->addColumn('level_three', function ($payment) {
if($payment->level_three)
{
     $headname=finance_level_three::where('id',$payment->level_three)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          
                })



         ->addColumn('id', function ($payment) {
 if($payment->level_three)
{
      $basic1=finance_level_three::where('id',$payment->level_three)->get()->pluck('level_two');
     


         if($basic1)
          {
      $basic0=finance_level_two::where('id',$basic1[0])->get()->pluck('level_one');
     $headname1=$basic1[0];
        }
        else{
             $headname1='';
        }

       if($basic0)
          {
     $headname0=$basic0[0];
        }
        else{
             $headname0='';
        }

}
else{
    $headname1='';
    $headname0='';
}
  return $headname0.'-'.$headname1.'-'.$payment->level_three.'-'.$payment->id;
                })




            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


public function index_deleted(Request $request, finance_account_head $finance_account_head)
    {
        return view('backend/finance-and-management/finance-account-heads/finance-account-heads-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_account_head $finance_account_head)
    {

        $deleted = finance_account_head::onlyTrashed()->get();
        return DataTables::of($deleted)

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-account-heads/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

          ->addColumn('level_one', function ($payment) {
if($payment->level_three)
{
     $base=finance_level_three::where('id',$payment->level_three)->get()->pluck('level_two');
     if($base){
         $headname=finance_level_two::where('id',$base[0])->get()->pluck('level_one');
     }
    
     if($headname){
         return financeLevelOne($headname);
     }else{
          return '';
     }
}
     else {
        return '';
     }          
                })



                ->addColumn('level_two', function ($payment) {
if($payment->level_three)
{
     $headname=finance_level_three::where('id',$payment->level_three)->get()->pluck('level_two');
     if($headname){
         return financeLevelTwo($headname);
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })

            ->addColumn('level_three', function ($payment) {
if($payment->level_three)
{
     $headname=finance_level_three::where('id',$payment->level_three)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          
                })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

   public function create()
    {
         //Get the last record id and pass to the view
        $lastval = finance_account_head::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['acc_head_update'] = '';

        $data['ones']=finance_level_one::where('status',1)->get();
         $data['seconds']=finance_level_two::where('status',1)->get();
         $data['thirds']=finance_level_three::where('status',1)->get();

        return view('backend/finance-and-management.finance-account-heads.finance-account-heads-aeu', $data);
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
            'level_two'   => 'required',
            'level_three'   => 'required',
            'desc' => 'required|unique:finance_account_heads,desc',
            'status'   => 'required']);

        $payment = finance_account_head::create([
            'level_one'   => $request->level_one,
            'level_two'   => $request->level_two,
            'level_three'   => $request->level_three,
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
                return redirect('finance-and-management/finance-account-heads/finance-account-heads-aeu');
            }else{
                return redirect('finance-and-management/finance-account-heads');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\finance_account_head  $finance_account_head
     * @return \Illuminate\Http\Response
     */
    public function show(finance_account_head $finance_account_head)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_account_head  $finance_account_head
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_account_head $finance_account_head,$id)
    {
         $data['acc_head_update'] = finance_account_head::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['acc_head_update']->code;


$data['selected_two']=finance_level_three::where('id',$data['acc_head_update']->level_three)->get()->pluck('level_two');
$data['selected_one']=finance_level_two::where('id',$data['selected_two'][0])->get()->pluck('level_one');

        $data['ones']=finance_level_one::where('status',1)->get();
         $data['seconds']=finance_level_two::where('status',1)->get();
         $data['thirds']=finance_level_three::where('status',1)->get();

        return view('backend/finance-and-management.finance-account-heads.finance-account-heads-aeu', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_account_head  $finance_account_head
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
            'level_one'   => 'required',
            'level_two'   => 'required',
            'level_three'   => 'required',
            'desc' => 'required|unique:finance_account_heads,desc,'.$id,
            'status'   => 'required']);

        $payment = finance_account_head::where('id', $id)->updateWithUserstamps([
            'level_one'   => $request->level_one,
            'level_two'   => $request->level_two,
            'level_three'   => $request->level_three,
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

        return redirect('finance-and-management/finance-account-heads/finance-account-heads-aeu/'.$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_account_head  $finance_account_head
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_account_head $finance_account_head,$id)
    {
        $payment=$finance_account_head::where('id', $id)->deleteWithUserstamps();
        if($payment){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/finance-account-heads');
    }

    function gettypes($id){
        $customer=finance_account_type::where('desc',$id)->get();
      /*  $customerdata=$customer->accounttypes()->select('id', 'type')->get();*/
        return $customer;
    }

public function restore(finance_account_head $finance_account_head,$id)
    {
        $restore = finance_account_head::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-account-heads/deleted');

}

}