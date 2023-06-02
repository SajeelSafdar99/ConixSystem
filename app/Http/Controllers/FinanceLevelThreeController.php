<?php

namespace App\Http\Controllers;

use App\finance_level_one;
use App\finance_level_two;
use App\finance_level_three;
use App\finance_account_head;
use DataTables;
use Illuminate\Http\Request;
use Session;

class FinanceLevelThreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_level_three $finance_level_three)
    {
        return view('backend/finance-and-management/finance-level-three/finance-level-three');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, finance_level_three $finance_level_three)
    {

        $payment = finance_level_three::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-level-three/finance-level-three-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-level-three/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->addColumn('level_one', function ($payment) {
if($payment->level_two)
{
     $headname=finance_level_two::where('id',$payment->level_two)->get()->pluck('level_one');
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
if($payment->level_two)
{
     $headname=finance_level_two::where('id',$payment->level_two)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          
                })


             ->addColumn('id', function ($payment) {
 if($payment->level_two)
{
     $basic=finance_level_two::where('id',$payment->level_two)->get()->pluck('level_one');
     $headname=$basic[0];
}
else{
    $headname='';
}

     return $headname.'-'.$payment->level_two.'-'.$payment->id;
                })


            ->rawColumns(['editbutton', 'deletebutton', 'status', 'level_one', 'level_two'])
         ->addIndexColumn()
            ->make(true);
    }


public function index_deleted(Request $request, finance_level_three $finance_level_three)
    {
        return view('backend/finance-and-management/finance-level-three/finance-level-three-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_level_three $finance_level_three)
    {

        $deleted = finance_level_three::onlyTrashed()->get();
        return DataTables::of($deleted)

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-level-three/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

            ->addColumn('level_one', function ($payment) {
if($payment->level_two)
{
     $headname=finance_level_two::where('id',$payment->level_two)->get()->pluck('level_one');
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
if($payment->level_two)
{
     $headname=finance_level_two::where('id',$payment->level_two)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }          
                })

        ->rawColumns(['restorebutton', 'level_one', 'level_two'])
        ->addIndexColumn()
        ->make(true);
    }

   public function create()
    {
         //Get the last record id and pass to the view
        $lastval = finance_level_three::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['level_three_update'] = '';

        $data['ones']=finance_level_one::where('status',1)->get();
         $data['seconds']=finance_level_two::where('status',1)->get();

        return view('backend/finance-and-management.finance-level-three.finance-level-three-aeu', $data);
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
            'desc' => 'required|unique:finance_level_threes,desc',
            'status'   => 'required']);

        $payment = finance_level_three::create([
       
         'level_two'   => $request->level_two,
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
                return redirect('finance-and-management/finance-level-three/finance-level-three-aeu');
            }else{
                return redirect('finance-and-management/finance-level-three');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\finance_level_three  $finance_level_three
     * @return \Illuminate\Http\Response
     */
    public function show(finance_level_three $finance_level_three)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_level_three  $finance_level_three
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_level_three $finance_level_three,$id)
    {
         $data['level_three_update'] = finance_level_three::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['level_three_update']->code;

        $data['selected_one']=finance_level_two::where('id',$data['level_three_update']->level_two)->get()->pluck('level_one');



        $data['ones']=finance_level_one::where('status',1)->get();
        $data['seconds']=finance_level_two::where('status',1)->get();

        return view('backend/finance-and-management.finance-level-three.finance-level-three-aeu', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_level_three  $finance_level_three
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
        'level_one'   => 'required',
        'level_two'   => 'required',
            'desc' => 'required|unique:finance_level_threes,desc,'.$id,
            'status'   => 'required']);

        $payment = finance_level_three::where('id', $id)->updateWithUserstamps([
            'level_two'   => $request->level_two,
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

        return redirect('finance-and-management/finance-level-three/finance-level-three-aeu/'.$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_level_three  $finance_level_three
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_level_three $finance_level_three,$id)
    {
        $payment=$finance_level_three::where('id', $id)->deleteWithUserstamps();
        if($payment){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/finance-level-three');
    }

 
public function restore(finance_level_three $finance_level_three,$id)
    {
        $restore = finance_level_three::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-level-three/deleted');

}

function leveltwo($id){
     if($id!=0){
        $result=finance_level_two::where('level_one',$id)->orderBy('desc')->get();
     }
     else{
         $result=finance_level_two::orderBy('desc')->get();
     }
        return $result;
    }

function levelthree($id){
     if($id!=0){
        $result=finance_level_three::where('level_two',$id)->orderBy('desc')->get();
     }
     else{
         $result=finance_level_three::orderBy('desc')->get();
     }
        return $result;
    }

    function levelfour($id){
     if($id!=0){
        $result=finance_account_head::where('level_three',$id)->orderBy('desc')->get();
     }
     else{
         $result=finance_account_head::orderBy('desc')->get();
     }
        return $result;
    }

}