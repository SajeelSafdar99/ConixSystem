<?php

namespace App\Http\Controllers;

use App\store_cancellation_remark;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\User;
use Illuminate\Support\Facades\Auth;

class StoreCancellationRemarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function index_vue(Request $request, store_cancellation_remark $store_cancellation_remark)
    {
      return view('backend/store-management/cancellation-remarks/cancellation-remarks-vue');
    }

    public function init_vue(Request $request)
    {

    $data['remarks'] =\Illuminate\Support\Facades\DB::select(
        'select store_cancellation_remarks.id,
         store_cancellation_remarks.desc

from store_cancellation_remarks

where store_cancellation_remarks.deleted_at is null group by store_cancellation_remarks.id order by store_cancellation_remarks.id desc');


     return $data;
}

   public function index_deleted(Request $request, store_cancellation_remark $store_cancellation_remark)
    {
      return view('backend/store-management/cancellation-remarks/cancellation-remarks-deleted-vue');
    }

    public function indexdt_deleted(Request $request)
    {
    $data['remarks'] =\Illuminate\Support\Facades\DB::select(
        'select store_cancellation_remarks.id,
         store_cancellation_remarks.desc,
         store_cancellation_remarks.deleted_at,
         store_cancellation_remarks.deleted_by

from store_cancellation_remarks

where store_cancellation_remarks.deleted_at is not null group by store_cancellation_remarks.id order by store_cancellation_remarks.id desc');

       $data['users']= User::where('status',1)->get();

    return $data;
}

 public function create(Request $request)
    {
        return view('backend/store-management.cancellation-remarks.cancellation-remarks-aeu-vue');
    }

  public function init(Request $request)
    {
        if($request->get('r')){
            $lastval=store_cancellation_remark::find($request->get('r'));
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }


       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $lastval=store_cancellation_remark::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }

     return $data;
 }

}


 public function save(Request $request){
//        dd($request->all());
      $lastval=store_cancellation_remark::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
      
      }else{
        $num=1;
      }

if(store_cancellation_remark::where('id',$num)->count() == 0){
        $d=[];
      
        $d['desc']=$request->get('desc');
        $d['status']=$request->get('status');
       
        $id=  store_cancellation_remark::create($d);

}
     return $id->id;
 
    }


public function edit(store_cancellation_remark $store_cancellation_remark,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/store-management.cancellation-remarks.cancellation-remarks-aeu-vue', $data);
    }

   
   public function updated(Request $request){
//        dd($request->all());
        $d=[];
       
        $d['desc']=$request->get('desc');
        $d['status']=$request->get('status');

      $id=  store_cancellation_remark::where('id',$request->get('id'))->updateWithUserstamps($d);
}


   public function destroy(store_cancellation_remark $store_cancellation_remark,$id)
    {

        $destroy=$store_cancellation_remark::where('id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

        else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
        }


        return redirect('store-management/cancellation-remarks-vue');
    }

    public function restore(store_cancellation_remark $store_cancellation_remark,$id)
    {
        $restore = store_cancellation_remark::onlyTrashed()->find($id)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/cancellation-remarks/deleted-vue');

}


}
