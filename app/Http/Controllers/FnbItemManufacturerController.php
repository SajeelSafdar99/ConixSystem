<?php

namespace App\Http\Controllers;

use App\fnb_item_manufacturer;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbItemManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request, fnb_item_manufacturer $fnb_item_manufacturer)
    {
         return view('backend/food-and-beverage/item-manufacturers/item-manufacturers');
    }

    public function indexdt(Request $request, fnb_item_manufacturer $fnb_item_manufacturer)
    {

        
     $fnb_item_manufacturers = fnb_item_manufacturer::get();
       return DataTables::of($fnb_item_manufacturers)
       ->addColumn('status', function ($fnb_item_manufacturers) {
               if($fnb_item_manufacturers->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($fnb_item_manufacturers) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/item-manufacturers/item-manufacturers-aeu/').'/'.$fnb_item_manufacturers->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_item_manufacturers) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/item-manufacturers/delete') . '/' . $fnb_item_manufacturers->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_item_manufacturer $fnb_item_manufacturer)
    {
        return view('backend/food-and-beverage/item-manufacturers/item-manufacturers-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_item_manufacturer $fnb_item_manufacturer)
    {

        $table = fnb_item_manufacturer::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/item-manufacturers/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_item_manufacturer::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['manufacturer_update'] = '';

     return view('backend/food-and-beverage.item-manufacturers.item-manufacturers-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_item_manufacturers,desc',
            'status'   =>  'required']);  
                    
       $store=fnb_item_manufacturer::create([
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
                return redirect('food-and-beverage/item-manufacturers/item-manufacturers-aeu');
            }else{
                return redirect('food-and-beverage/item-manufacturers');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_item_manufacturer  $fnb_item_manufacturer
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_item_manufacturer $fnb_item_manufacturer)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_item_manufacturer  $fnb_item_manufacturer
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_item_manufacturer $fnb_item_manufacturer, $id)
    {
        $data['manufacturer_update'] = fnb_item_manufacturer::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['manufacturer_update']->code;

         return view('backend/food-and-beverage.item-manufacturers.item-manufacturers-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_item_manufacturer  $fnb_item_manufacturer
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_item_manufacturers,desc,'.$id,
            'status'   =>  'required']);

        $update = fnb_item_manufacturer::where('id', $id)->updateWithUserstamps([
           
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

        return redirect('food-and-beverage/item-manufacturers/item-manufacturers-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_item_manufacturer  $fnb_item_manufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_item_manufacturer $fnb_item_manufacturer,$id)
    {
        
        $destroy=$fnb_item_manufacturer::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/item-manufacturers');
    }

public function restore(fnb_item_manufacturer $fnb_item_manufacturer,$id)
    {
        $restore = fnb_item_manufacturer::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/item-manufacturers/deleted');

}

}
