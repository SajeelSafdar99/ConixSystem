<?php

namespace App\Http\Controllers;

use App\crm_reason;
use Illuminate\Http\Request;
use Session;
use DataTables;

class CrmReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, crm_reason $crm_reason)
    {
         return view('backend/crm/reasons/reasons');
    }

    public function indexdt(Request $request, crm_reason $crm_reason)
    {

        
     $crm_reason = crm_reason::get();
       return DataTables::of($crm_reason)
       ->addColumn('status', function ($crm_reason) {
               if($crm_reason->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($crm_reason) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('crm/reasons/reasons-aeu/').'/'.$crm_reason->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($crm_reason) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('crm/reasons/delete') . '/' . $crm_reason->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, crm_reason $crm_reason)
    {
        return view('backend/crm/reasons/reasons-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, crm_reason $crm_reason)
    {

        $table = crm_reason::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('crm/reasons/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=crm_reason::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['reason_update'] = '';

     return view('backend/crm.reasons.reasons-aeu',$data);
   
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
        $this->validate($request,[
            'desc' => 'required|unique:crm_reasons,desc',
            'status'   =>  'required'
        ]);  
                    
       $store=crm_reason::create([
            'desc'   => $request->desc,
            'status' => $request->status,
            
            ]);

        
            if($store)
            {
                Session::flash('message', 'Data Entered Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message;
             if(empty($save))
            {
                return redirect('crm/reasons/reasons-aeu');
            }else{
                return redirect('crm/reasons');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\crm_reason  $crm_reason
     * @return \Illuminate\Http\Response
     */
    public function show(crm_reason $crm_reason)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\crm_reason  $crm_reason
     * @return \Illuminate\Http\Response
     */
    public function edit(crm_reason $crm_reason, $id)
    {
        $data['reason_update'] = crm_reason::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['reason_update']->code;

         return view('backend/crm.reasons.reasons-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\crm_reason  $crm_reason
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request,[
            'desc' => 'required|unique:crm_reasons,desc',
            'status'   =>  'required'
        ]); 

        $update = crm_reason::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);


        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('crm/reasons/reasons-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\crm_reason  $crm_reason
     * @return \Illuminate\Http\Response
     */
    public function destroy(crm_reason $crm_reason,$id)
    {
        
        $destroy=$crm_reason::where('id', $id)->deleteWithUserstamps();

       
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('crm/reasons');
    }

public function restore(crm_reason $crm_reason,$id)
    {

        $restore = crm_reason::onlyTrashed()->find($id)->restore();
        
        
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('crm/reasons/deleted');

}

}
