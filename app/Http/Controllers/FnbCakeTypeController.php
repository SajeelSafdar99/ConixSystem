<?php

namespace App\Http\Controllers;

use App\fnb_cake_type;
use App\fnb_measurement_unit;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbCakeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request, fnb_cake_type $fnb_cake_type)
    {
         return view('backend/food-and-beverage/cake-types/cake-types');
    }

    public function indexdt(Request $request, fnb_cake_type $fnb_cake_type)
    {

        
     $fnb_cake_types = fnb_cake_type::get();
       return DataTables::of($fnb_cake_types)
       ->addColumn('status', function ($fnb_cake_types) {
               if($fnb_cake_types->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($fnb_cake_types) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/cake-types/cake-types-aeu/').'/'.$fnb_cake_types->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_cake_types) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/cake-types/delete') . '/' . $fnb_cake_types->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_cake_type $fnb_cake_type)
    {
        return view('backend/food-and-beverage/cake-types/cake-types-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_cake_type $fnb_cake_type)
    {

        $table = fnb_cake_type::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/cake-types/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_cake_type::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['cake_type_update'] = '';

       $data['units']=fnb_measurement_unit::where('status',1)->get();

     return view('backend/food-and-beverage.cake-types.cake-types-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_cake_types,desc',
            'price'   =>  'required',
             'unit'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=fnb_cake_type::create([
            'desc'=>$request->desc,
             'price'=>$request->price,
             'unit'=>$request->unit,
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
                return redirect('food-and-beverage/cake-types/cake-types-aeu');
            }else{
                return redirect('food-and-beverage/cake-types');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_cake_type  $fnb_cake_type
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_cake_type $fnb_cake_type)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_cake_type  $fnb_cake_type
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_cake_type $fnb_cake_type, $id)
    {
        $data['cake_type_update'] = fnb_cake_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['cake_type_update']->code;

        $data['units']=fnb_measurement_unit::where('status',1)->get();

         return view('backend/food-and-beverage.cake-types.cake-types-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_cake_type  $fnb_cake_type
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_cake_types,desc,'.$id,
            'price'   =>  'required',
            'unit'   =>  'required',
            'status'   =>  'required']);

        $update = fnb_cake_type::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'price'=>$request->price,
            'unit'=>$request->unit,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/cake-types/cake-types-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_cake_type  $fnb_cake_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_cake_type $fnb_cake_type,$id)
    {
        
        $destroy=$fnb_cake_type::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/cake-types');
    }

public function restore(fnb_cake_type $fnb_cake_type,$id)
    {
        $restore = fnb_cake_type::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/cake-types/deleted');

}

}
