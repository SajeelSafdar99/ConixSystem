<?php

namespace App\Http\Controllers;

use App\mem_club_facilities;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemClubFacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_club_facilities $mem_club_facilities)
    {
        return view('backend/sports-subscription/club-facilities/club-facilities');
    }

    public function indexdt(Request $request, mem_club_facilities $mem_club_facilities)
    {

        
     $mem_facilities = mem_club_facilities::get();
       return DataTables::of($mem_facilities)
       ->addColumn('status', function ($mem_facilities) {
               if($mem_facilities->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($mem_facilities) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('sports-subscription/club-facilities/club-facilities-aeu/').'/'.$mem_facilities->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })

        ->addColumn('deletebutton', function ($mem_facilities) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('sports-subscription/club-facilities/delete') . '/' . $mem_facilities->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton', 'deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



 public function index_deleted(Request $request, mem_club_facilities $mem_club_facilities)
    {
        return view('backend/sports-subscription/club-facilities/club-facilities-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_club_facilities $mem_club_facilities)
    {

        $Club_Facility_add = mem_club_facilities::onlyTrashed()->get();
        return DataTables::of($Club_Facility_add)

            ->addColumn('restorebutton', function ($Club_Facility_add) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('sports-subscription/club-facilities/restore/') . '/' . $Club_Facility_add->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=mem_club_facilities::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
      $data['init']=0;
      $data['mem_facility_update'] = '';

  return view('backend/sports-subscription.club-facilities.club-facilities-aeu',$data);
   
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
            
            'desc' => 'required|unique:mem_club_facilities,desc',
            'status'   =>  'required']);  
                    
       $Club_Facility_add=mem_club_facilities::create([
            
            'desc'=>$request->desc,
            'status'=>$request->status,
            
            ]);
            
            if($Club_Facility_add)
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
                return redirect('sports-subscription/club-facilities/club-facilities-aeu');
            }else{
                return redirect('sports-subscription/club-facilities');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_club_facilities  $mem_club_facilities
     * @return \Illuminate\Http\Response
     */
    public function show(mem_club_facilities $mem_club_facilities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_club_facilities  $mem_club_facilities
     * @return \Illuminate\Http\Response
     */
     public function edit(mem_club_facilities $mem_club_facilities, $id)
    {
        $data['mem_facility_update'] = mem_club_facilities::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_facility_update']->code;

       return view('backend/sports-subscription.club-facilities.club-facilities-aeu',$data);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_club_facilities  $mem_club_facilities
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
           
            'desc' => 'required|unique:mem_club_facilities,desc,'.$id,
            'status'   =>  'required']);

        $member_facility = mem_club_facilities::where('id', $id)->updateWithUserstamps([
            
            'desc'=>$request->desc,
            'status'=>$request->status,
        ]);

        if ($member_facility) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('sports-subscription/club-facilities/club-facilities-aeu/'.$id);

    }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_club_facilities  $mem_club_facilities
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_club_facilities $mem_club_facilities,$id)
    {
        
        $memfacility=$mem_club_facilities::where('id', $id)->deleteWithUserstamps();
        if($memfacility){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('sports-subscription/club-facilities');
    }


public function restore(mem_club_facilities $mem_club_facilities,$id)
    {
        $restore = mem_club_facilities::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('sports-subscription/club-facilities/deleted');

}

}
