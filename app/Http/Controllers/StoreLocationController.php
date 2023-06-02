<?php

namespace App\Http\Controllers;

use App\store_location;
use Illuminate\Http\Request;
use Session;
use DataTables;

class StoreLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, store_location $store_location)
    {
         return view('backend/store-management/store-locations/store-locations');
    }

    public function indexdt(Request $request, store_location $store_location)
    {

        
     $store_locations = store_location::get();
       return DataTables::of($store_locations)
       ->addColumn('status', function ($store_locations) {
               if($store_locations->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($store_locations) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('store-management/store-locations/store-locations-aeu/').'/'.$store_locations->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($store_locations) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('store-management/store-locations/delete') . '/' . $store_locations->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, store_location $store_location)
    {
        return view('backend/store-management/store-locations/store-locations-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, store_location $store_location)
    {

        $table = store_location::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('store-management/store-locations/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=store_location::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['store_location_update'] = '';

     return view('backend/store-management.store-locations.store-locations-aeu',$data);
   
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
            'desc' => 'required|unique:store_locations,desc',
            'status'   =>  'required']);  
                    
       $store=store_location::create([
            'desc'=>$request->desc,
            'status'=>$request->status,
            
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
                return redirect('store-management/store-locations/store-locations-aeu');
            }else{
                return redirect('store-management/store-locations');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\store_location  $store_location
     * @return \Illuminate\Http\Response
     */
    public function show(store_location $store_location)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\store_location  $store_location
     * @return \Illuminate\Http\Response
     */
    public function edit(store_location $store_location, $id)
    {
        $data['store_location_update'] = store_location::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['store_location_update']->code;

         return view('backend/store-management.store-locations.store-locations-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\store_location  $store_location
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:store_locations,desc,'.$id,
            'status'   =>  'required']);

        $update = store_location::where('id', $id)->updateWithUserstamps([
           
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

        return redirect('store-management/store-locations/store-locations-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\store_location  $store_location
     * @return \Illuminate\Http\Response
     */
    public function destroy(store_location $store_location,$id)
    {
        
        $destroy=$store_location::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('store-management/store-locations');
    }

public function restore(store_location $store_location,$id)
    {
        $restore = store_location::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/store-locations/deleted');

}

}
