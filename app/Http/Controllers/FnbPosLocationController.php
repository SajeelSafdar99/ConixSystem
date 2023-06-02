<?php

namespace App\Http\Controllers;
use App\trans_type;
use App\fnb_pos_location;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbPosLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, fnb_pos_location $fnb_pos_location)
    {
         return view('backend/food-and-beverage/pos-locations/pos-locations');
    }

    public function indexdt(Request $request, fnb_pos_location $fnb_pos_location)
    {

        
     $fnb_pos_locations = fnb_pos_location::get();
       return DataTables::of($fnb_pos_locations)
       ->addColumn('status', function ($fnb_pos_locations) {
               if($fnb_pos_locations->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($fnb_pos_locations) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/pos-locations/pos-locations-aeu/').'/'.$fnb_pos_locations->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_pos_locations) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/pos-locations/delete') . '/' . $fnb_pos_locations->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_pos_location $fnb_pos_location)
    {
        return view('backend/food-and-beverage/pos-locations/pos-locations-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_pos_location $fnb_pos_location)
    {

        $table = fnb_pos_location::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/pos-locations/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_pos_location::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['pos_location_update'] = '';

     return view('backend/food-and-beverage.pos-locations.pos-locations-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_pos_locations,desc',
            // 'coa_code'   =>  'required',
             // 'account'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=fnb_pos_location::create([
            'desc'=>$request->desc,
            'account'=>$request->account,
            'status'=>$request->status,
            
            ]);

       trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $store->id,
            'type'   => 6, // type 6 stands for POS Locations' Trans Types
            'cash_or_payment'   => 0,
            'details' => 'salesInvoice',
            'table_name' => 'fnb_pos_location'
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
                return redirect('food-and-beverage/pos-locations/pos-locations-aeu');
            }else{
                return redirect('food-and-beverage/pos-locations');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_pos_location  $fnb_pos_location
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_pos_location $fnb_pos_location)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_pos_location  $fnb_pos_location
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_pos_location $fnb_pos_location, $id)
    {
        $data['pos_location_update'] = fnb_pos_location::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['pos_location_update']->code;

         return view('backend/food-and-beverage.pos-locations.pos-locations-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_pos_location  $fnb_pos_location
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_pos_locations,desc,'.$id,
          //    'coa_code'   =>  'required',
          //  'account'   =>  'required',
            'status'   =>  'required']);

        $update = fnb_pos_location::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
             'account'=>$request->account,
            'status'=>$request->status,
        ]);


if(trans_type::where('type',6)->where('mod_id', $id)->exists()){
    trans_type::where('type',6)->where('mod_id', $id)->updateWithUserstamps([
            'name'   => $request->desc,
            'mod_id'   => $id,
            'type'   => 6,
            'cash_or_payment'   => 0,
            'details' => 'salesInvoice',
            'table_name' => 'fnb_pos_location'
        ]);
}else{
    trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $id,
            'type'   => 6, // type 6 stands for POS Locations' Trans Types
            'cash_or_payment'   => 0,
            'details' => 'salesInvoice',
            'table_name' => 'fnb_pos_location'
        ]);
}
        

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/pos-locations/pos-locations-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_pos_location  $fnb_pos_location
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_pos_location $fnb_pos_location,$id)
    {
        
        $destroy=$fnb_pos_location::where('id', $id)->deleteWithUserstamps();

        trans_type::where('type',6)->where('mod_id', $id)->deleteWithUserstamps();

        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/pos-locations');
    }

public function restore(fnb_pos_location $fnb_pos_location,$id)
    {
        $restore = fnb_pos_location::onlyTrashed()->find($id)->restore();

        trans_type::onlyTrashed()->where('type',6)->where('mod_id', $id)->restore();

        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/pos-locations/deleted');

}

}
