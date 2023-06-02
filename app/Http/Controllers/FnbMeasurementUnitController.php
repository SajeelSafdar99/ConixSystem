<?php

namespace App\Http\Controllers;

use App\fnb_measurement_unit;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbMeasurementUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request, fnb_measurement_unit $fnb_measurement_unit)
    {
         return view('backend/food-and-beverage/measurement-units/measurement-units');
    }

    public function indexdt(Request $request, fnb_measurement_unit $fnb_measurement_unit)
    {

        
     $fnb_measurement_units = fnb_measurement_unit::get();
       return DataTables::of($fnb_measurement_units)
       ->addColumn('status', function ($fnb_measurement_units) {
               if($fnb_measurement_units->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($fnb_measurement_units) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/measurement-units/measurement-units-aeu/').'/'.$fnb_measurement_units->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_measurement_units) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/measurement-units/delete') . '/' . $fnb_measurement_units->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_measurement_unit $fnb_measurement_unit)
    {
        return view('backend/food-and-beverage/measurement-units/measurement-units-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_measurement_unit $fnb_measurement_unit)
    {

        $table = fnb_measurement_unit::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($pos_locations) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/measurement-units/restore/') . '/' . $pos_locations->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_measurement_unit::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['units_update'] = '';

     return view('backend/food-and-beverage.measurement-units.measurement-units-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_measurement_units,desc',
            'code'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=fnb_measurement_unit::create([
            'desc'=>$request->desc,
             'code'=>$request->code,
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
                return redirect('food-and-beverage/measurement-units/measurement-units-aeu');
            }else{
                return redirect('food-and-beverage/measurement-units');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_measurement_unit  $fnb_measurement_unit
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_measurement_unit $fnb_measurement_unit)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_measurement_unit  $fnb_measurement_unit
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_measurement_unit $fnb_measurement_unit, $id)
    {
        $data['units_update'] = fnb_measurement_unit::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['units_update']->code;

         return view('backend/food-and-beverage.measurement-units.measurement-units-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_measurement_unit  $fnb_measurement_unit
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_measurement_units,desc,'.$id,
            'code'   =>  'required',
            'status'   =>  'required']);

        $update = fnb_measurement_unit::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'code'=>$request->code,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/measurement-units/measurement-units-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_measurement_unit  $fnb_measurement_unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_measurement_unit $fnb_measurement_unit,$id)
    {
        
        $destroy=$fnb_measurement_unit::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/measurement-units');
    }

public function restore(fnb_measurement_unit $fnb_measurement_unit,$id)
    {
        $restore = fnb_measurement_unit::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/measurement-units/deleted');

}

}
