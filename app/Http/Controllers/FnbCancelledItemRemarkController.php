<?php

namespace App\Http\Controllers;

use App\fnb_cancelled_item_remark;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbCancelledItemRemarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, fnb_cancelled_item_remark $fnb_cancelled_item_remark)
    {
         return view('backend/food-and-beverage/cancelled-item-remarks/cancelled-item-remarks');
    }

    public function indexdt(Request $request, fnb_cancelled_item_remark $fnb_cancelled_item_remark)
    {

        
     $table = fnb_cancelled_item_remark::get();
       return DataTables::of($table)
       ->addColumn('status', function ($table) {
               if($table->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($table) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-aeu/').'/'.$table->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($table) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/cancelled-item-remarks/delete') . '/' . $table->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }

     public function index_deleted(Request $request, fnb_cancelled_item_remark $fnb_cancelled_item_remark)
    {
        return view('backend/food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_cancelled_item_remark $fnb_cancelled_item_remark)
    {

        $table = fnb_cancelled_item_remark::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/cancelled-item-remarks/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get the last record id and pass to the view
      $lastval=fnb_cancelled_item_remark::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['cancelled_remark_update'] = '';

     return view('backend/food-and-beverage.cancelled-item-remarks.cancelled-item-remarks-aeu',$data);
   
    }

public function store(Request $request)
    {
        $save=$request->save;
         $this->validate($request,[
            'desc' => 'required|unique:fnb_cancelled_item_remarks,desc',
            'status'   =>  'required']);  
                    
       $store=fnb_cancelled_item_remark::create([
            'desc'=>$request->desc,
            'status'=>$request->status,
            
            ]);
            
            if($store)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message;
             if(empty($save))
            {
                return redirect('food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-aeu');
            }else{
                return redirect('food-and-beverage/cancelled-item-remarks');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_cancelled_item_remark  $fnb_cancelled_item_remark
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_cancelled_item_remark $fnb_cancelled_item_remark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_cancelled_item_remark  $fnb_cancelled_item_remark
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_cancelled_item_remark $fnb_cancelled_item_remark, $id)
    {
        $data['cancelled_remark_update'] = fnb_cancelled_item_remark::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['cancelled_remark_update']->code;

         return view('backend/food-and-beverage.cancelled-item-remarks.cancelled-item-remarks-aeu',$data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_cancelled_item_remark  $fnb_cancelled_item_remark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_cancelled_item_remarks,desc,'.$id,
            'status'   =>  'required']);

        $update = fnb_cancelled_item_remark::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-aeu/'.$id);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_cancelled_item_remark  $fnb_cancelled_item_remark
     * @return \Illuminate\Http\Response
     */
   public function destroy(fnb_cancelled_item_remark $fnb_cancelled_item_remark,$id)
    {
        
        $destroy=$fnb_cancelled_item_remark::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/cancelled-item-remarks');
    }

public function restore(fnb_cancelled_item_remark $fnb_cancelled_item_remark,$id)
    {
        $restore = fnb_cancelled_item_remark::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/cancelled-item-remarks/deleted');

}

}

