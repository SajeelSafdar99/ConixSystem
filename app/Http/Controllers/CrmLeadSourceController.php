<?php

namespace App\Http\Controllers;

use App\crm_lead_source;
use Illuminate\Http\Request;
use Session;
use DataTables;

class CrmLeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, crm_lead_source $crm_lead_source)
    {
         return view('backend/crm/lead-sources/lead-sources');
    }

    public function indexdt(Request $request, crm_lead_source $crm_lead_source)
    {

        
     $crm_lead_source = crm_lead_source::get();
       return DataTables::of($crm_lead_source)
       ->addColumn('status', function ($crm_lead_source) {
               if($crm_lead_source->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($crm_lead_source) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('crm/lead-sources/lead-sources-aeu/').'/'.$crm_lead_source->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($crm_lead_source) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('crm/lead-sources/delete') . '/' . $crm_lead_source->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, crm_lead_source $crm_lead_source)
    {
        return view('backend/crm/lead-sources/lead-sources-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, crm_lead_source $crm_lead_source)
    {

        $table = crm_lead_source::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('crm/lead-sources/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=crm_lead_source::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['source_update'] = '';

     return view('backend/crm.lead-sources.lead-sources-aeu',$data);
   
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
            'desc' => 'required|unique:crm_lead_sources,desc',
            'status'   =>  'required'
        ]);  
                    
       $store=crm_lead_source::create([
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
                return redirect('crm/lead-sources/lead-sources-aeu');
            }else{
                return redirect('crm/lead-sources');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\crm_lead_source  $crm_lead_source
     * @return \Illuminate\Http\Response
     */
    public function show(crm_lead_source $crm_lead_source)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\crm_lead_source  $crm_lead_source
     * @return \Illuminate\Http\Response
     */
    public function edit(crm_lead_source $crm_lead_source, $id)
    {
        $data['source_update'] = crm_lead_source::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['source_update']->code;

         return view('backend/crm.lead-sources.lead-sources-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\crm_lead_source  $crm_lead_source
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request,[
            'desc' => 'required|unique:crm_lead_sources,desc',
            'status'   =>  'required'
        ]); 

        $update = crm_lead_source::where('id', $id)->updateWithUserstamps([
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

        return redirect('crm/lead-sources/lead-sources-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\crm_lead_source  $crm_lead_source
     * @return \Illuminate\Http\Response
     */
    public function destroy(crm_lead_source $crm_lead_source,$id)
    {
        
        $destroy=$crm_lead_source::where('id', $id)->deleteWithUserstamps();

       
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('crm/lead-sources');
    }

public function restore(crm_lead_source $crm_lead_source,$id)
    {

        $restore = crm_lead_source::onlyTrashed()->find($id)->restore();
        
        
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('crm/lead-sources/deleted');

}

}
