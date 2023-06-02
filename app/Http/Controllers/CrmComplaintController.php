<?php

namespace App\Http\Controllers;

use App\crm_complaint;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\User;
use Illuminate\Support\Facades\Auth;

class CrmComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function complaints_vue(Request $request, crm_complaint $crm_complaint)
    {
      return view('backend/crm/complaints/complaints-vue');
    }

    public function complaints_init_vue(Request $request)
    {

    $data['complaints'] =\Illuminate\Support\Facades\DB::select(
        'select crm_complaints.id,
         crm_complaints.subject,
      crm_complaints.message,
        crm_complaints.created_at,
        crm_complaints.created_by

from crm_complaints

where crm_complaints.deleted_at is null group by crm_complaints.id order by crm_complaints.id desc');

 //  $data['users']= User::where('status',1)->->get();

 $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();

 if(Auth::user()->can('Export Complaints')){
 $data['exported']=1;
 }

     return $data;
}

   public function index_deleted(Request $request, crm_complaint $crm_complaint)
    {
      return view('backend/crm/complaints/complaints-deleted-vue');
    }

    public function indexdt_deleted(Request $request)
    {

    $data['complaints'] =\Illuminate\Support\Facades\DB::select(
        'select crm_complaints.id,
         crm_complaints.subject,
      crm_complaints.message,
       crm_complaints.created_at,
        crm_complaints.deleted_at,
        crm_complaints.deleted_by

from crm_complaints

where crm_complaints.deleted_at is not null group by crm_complaints.id order by crm_complaints.id desc');

  /* $data['users']= User::where('status',1)->get();*/
   $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();

     return $data;
}

 public function create(Request $request)
    {
        return view('backend/crm.complaints.complaints-aeu-vue');
    }

  public function init(Request $request)
    {
        if($request->get('r')){
            $lastval=crm_complaint::find($request->get('r'));
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
 $lastval=crm_complaint::withTrashed()->latest('id')->first();
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
      $lastval=crm_complaint::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
      
      }else{
        $num=1;
      }

if(crm_complaint::where('id',$num)->count() == 0){
        $d=[];
      
        $d['subject']=$request->get('subject');
        $d['message']=$request->get('message');
       
        $id=  crm_complaint::create($d);

}
     return $id->id;
 
    }


public function edit(crm_complaint $crm_complaint,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/crm.complaints.complaints-aeu-vue', $data);
    }

   
   public function updated(Request $request){
//        dd($request->all());
        $d=[];
       
        $d['subject']=$request->get('subject');
        $d['message']=$request->get('message');

      $id=  crm_complaint::where('id',$request->get('id'))->updateWithUserstamps($d);
}


   public function destroy(crm_complaint $crm_complaint,$id)
    {

        $destroy=$crm_complaint::where('id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

        else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
        }


        return redirect('crm/complaints-vue');
    }

    public function restore(crm_complaint $crm_complaint,$id)
    {
        $restore = crm_complaint::onlyTrashed()->find($id)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('crm/complaints/deleted-vue');

}


}
