<?php

namespace App\Http\Controllers;

use App\mem_status;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_status $mem_status)
    {
         return view('backend/club-hospitality/membership-status/membership-status');
    }

    public function indexdt(Request $request, mem_status $mem_status)
    {

        
     $mem_statuss = mem_status::get();
       return DataTables::of($mem_statuss)
       ->addColumn('status', function ($mem_statuss) {
               if($mem_statuss->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($mem_statuss) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('club-hospitality/membership-status/membership-status-aeu/').'/'.$mem_statuss->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($mem_statuss) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/membership-status/delete') . '/' . $mem_statuss->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, mem_status $mem_status)
    {
        return view('backend/club-hospitality/membership-status/membership-status-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_status $mem_status)
    {

        $Classification_add = mem_status::onlyTrashed()->get();
        return DataTables::of($Classification_add)

            ->addColumn('restorebutton', function ($Classification_add) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/membership-status/restore/') . '/' . $Classification_add->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=mem_status::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['mem_status_update'] = '';

     return view('backend/club-hospitality.membership-status.membership-status-aeu',$data);
   
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
            'desc' => 'required|unique:mem_statuses,desc',
             'color'   =>  'required',
            'status'   =>  'required']);  
                    
       $Classification_add=mem_status::create([
            'desc'=>$request->desc,
             'color'=>$request->color,
            'status'=>$request->status,
            
            ]);
            
            if($Classification_add)
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
                return redirect('club-hospitality/membership-status/membership-status-aeu');
            }else{
                return redirect('club-hospitality/membership-status');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_status  $mem_status
     * @return \Illuminate\Http\Response
     */
    public function show(mem_status $mem_status)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_status  $mem_status
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_status $mem_status, $id)
    {
        $data['mem_status_update'] = mem_status::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_status_update']->code;

         return view('backend/club-hospitality.membership-status.membership-status-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_status  $mem_status
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:mem_statuses,desc,'.$id,
             'color'   =>  'required',
            'status'   =>  'required']);

        $update = mem_status::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
              'color'=>$request->color,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership-status/membership-status-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_status  $mem_status
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_status $mem_status,$id)
    {
        
        $destroy=$mem_status::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/membership-status');
    }

public function restore(mem_status $mem_status,$id)
    {
        $restore = mem_status::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/membership-status/deleted');

}

}
