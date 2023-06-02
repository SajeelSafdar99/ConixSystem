<?php

namespace App\Http\Controllers;

use App\guest_type;
use Illuminate\Http\Request;
use Session;
use DataTables;

class GuestTypeController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, guest_type $guest_type)
    {
         return view('backend/room-management/guest-types/guest-types');
    }

    public function indexdt(Request $request, guest_type $guest_type)
    {

        
     $guest_types = guest_type::get();
       return DataTables::of($guest_types)
       ->addColumn('status', function ($guest_types) {
               if($guest_types->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($guest_types) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('room-management/guest-types/guest-types-aeu/').'/'.$guest_types->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($guest_types) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/guest-types/delete') . '/' . $guest_types->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, guest_type $guest_type)
    {
        return view('backend/room-management/guest-types/guest-types-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, guest_type $guest_type)
    {

        $table = guest_type::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/guest-types/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=guest_type::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['gt_update'] = '';

     return view('backend/room-management.guest-types.guest-types-aeu',$data);
   
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
            'desc' => 'required|unique:guest_types,desc',
         //   'coa_code'   =>  'required',
         //    'account'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=guest_type::create([
            'desc'=>$request->desc,
          /*   'account'=>$request->account,*/
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
                return redirect('room-management/guest-types/guest-types-aeu');
            }else{
                return redirect('room-management/guest-types');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\guest_type  $guest_type
     * @return \Illuminate\Http\Response
     */
    public function show(guest_type $guest_type)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\guest_type  $guest_type
     * @return \Illuminate\Http\Response
     */
    public function edit(guest_type $guest_type, $id)
    {
        $data['gt_update'] = guest_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['gt_update']->code;

         return view('backend/room-management.guest-types.guest-types-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\guest_type  $guest_type
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:guest_types,desc,'.$id,
        //    'coa_code'   =>  'required',
         //   'account'   =>  'required',
            'status'   =>  'required']);

        $update = guest_type::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
           /* 'account'=>$request->account,*/
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/guest-types/guest-types-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\guest_type  $guest_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(guest_type $guest_type,$id)
    {
        
        $destroy=$guest_type::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('room-management/guest-types');
    }

public function restore(guest_type $guest_type,$id)
    {
        $restore = guest_type::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/guest-types/deleted');

}

}
