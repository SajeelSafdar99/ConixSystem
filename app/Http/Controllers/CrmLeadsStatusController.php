<?php

namespace App\Http\Controllers;

use App\crm_leads_status;
use Illuminate\Http\Request;
use Session;
use DataTables;

class CrmLeadsStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, crm_leads_status $crm_leads_status)
    {
         return view('backend/crm/leads-status/leads-status');
    }

    public function indexdt(Request $request, crm_leads_status $crm_leads_status)
    {

        
     $crm_leads_status = crm_leads_status::get();
       return DataTables::of($crm_leads_status)
       ->addColumn('status', function ($crm_leads_status) {
               if($crm_leads_status->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($crm_leads_status) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('crm/leads-status/leads-status-aeu/').'/'.$crm_leads_status->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($crm_leads_status) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('crm/leads-status/delete') . '/' . $crm_leads_status->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, crm_leads_status $crm_leads_status)
    {
        return view('backend/crm/leads-status/leads-status-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, crm_leads_status $crm_leads_status)
    {

        $table = crm_leads_status::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('crm/leads-status/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=crm_leads_status::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['status_update'] = '';

     return view('backend/crm.leads-status.leads-status-aeu',$data);
   
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
            'desc' => 'required|unique:crm_leads_statuses,desc',
            'status'   =>  'required'
        ]);  
                    
       $store=crm_leads_status::create([
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
                return redirect('crm/leads-status/leads-status-aeu');
            }else{
                return redirect('crm/leads-status');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\crm_leads_status  $crm_leads_status
     * @return \Illuminate\Http\Response
     */
    public function show(crm_leads_status $crm_leads_status)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\crm_leads_status  $crm_leads_status
     * @return \Illuminate\Http\Response
     */
    public function edit(crm_leads_status $crm_leads_status, $id)
    {
        $data['status_update'] = crm_leads_status::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['status_update']->code;

         return view('backend/crm.leads-status.leads-status-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\crm_leads_status  $crm_leads_status
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request,[
            'desc' => 'required|unique:crm_leads_statuses,desc,'.$id,
            'status'   =>  'required'
        ]); 

        $update = crm_leads_status::where('id', $id)->updateWithUserstamps([
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

        return redirect('crm/leads-status/leads-status-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\crm_leads_status  $crm_leads_status
     * @return \Illuminate\Http\Response
     */
    public function destroy(crm_leads_status $crm_leads_status,$id)
    {
        
        $destroy=$crm_leads_status::where('id', $id)->deleteWithUserstamps();

       
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('crm/leads-status');
    }

public function restore(crm_leads_status $crm_leads_status,$id)
    {

        $restore = crm_leads_status::onlyTrashed()->find($id)->restore();
        
        
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('crm/leads-status/deleted');

}

}
