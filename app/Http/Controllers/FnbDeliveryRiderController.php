<?php

namespace App\Http\Controllers;

use App\fnb_delivery_rider;
use App\fnb_restaurant_location;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbDeliveryRiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, fnb_delivery_rider $fnb_delivery_rider)
    {
         return view('backend/food-and-beverage/delivery-riders/delivery-riders');
    }

    public function indexdt(Request $request, fnb_delivery_rider $fnb_delivery_rider)
    {

        
     $fnb_delivery_riders = fnb_delivery_rider::get();
       return DataTables::of($fnb_delivery_riders)
       ->addColumn('status', function ($fnb_delivery_riders) {
               if($fnb_delivery_riders->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })

        ->addColumn('restaurant', function ($fnb_delivery_riders) {
            $restaurant=fnb_restaurant_location::where('id',$fnb_delivery_riders->restaurant_location)->get();
            if($fnb_delivery_riders->restaurant_location){
                  return $restaurant[0]['desc'];
                   }
                else{
                    return '';
                }
                })

        ->addColumn('editbutton', function ($fnb_delivery_riders) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/delivery-riders/delivery-riders-aeu/').'/'.$fnb_delivery_riders->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_delivery_riders) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/delivery-riders/delete') . '/' . $fnb_delivery_riders->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','restaurant','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_delivery_rider $fnb_delivery_rider)
    {
        return view('backend/food-and-beverage/delivery-riders/delivery-riders-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_delivery_rider $fnb_delivery_rider)
    {

        $table = fnb_delivery_rider::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/delivery-riders/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

            ->addColumn('restaurant', function ($table) {
            $restaurant=fnb_restaurant_location::where('id',$table->restaurant_location)->get();
            if($table->restaurant_location){
                  return $restaurant[0]['desc'];
                   }
                else{
                    return '';
                }
                })

        ->rawColumns(['restorebutton','restaurant'])
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
      $lastval=fnb_delivery_rider::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['rider_update'] = '';

       $data['restaurants']=fnb_restaurant_location::where('status',1)->get();

     return view('backend/food-and-beverage.delivery-riders.delivery-riders-aeu',$data);
   
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
            'name' => 'required|unique:fnb_delivery_riders,name',
            'contact'   =>  'required',
            'restaurant_location'  =>  'required',
            'status'   =>  'required'
        ]);  
                    
       $store=fnb_delivery_rider::create([
            'name'=>$request->name,
            'contact'=>$request->contact,
            'restaurant_location'=>$request->restaurant_location,
            'status' => $request->status
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
                return redirect('food-and-beverage/delivery-riders/delivery-riders-aeu');
            }else{
                return redirect('food-and-beverage/delivery-riders');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_delivery_rider  $fnb_delivery_rider
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_delivery_rider $fnb_delivery_rider)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_delivery_rider  $fnb_delivery_rider
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_delivery_rider $fnb_delivery_rider, $id)
    {
        $data['rider_update'] = fnb_delivery_rider::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['rider_update']->code;

        $data['restaurants']=fnb_restaurant_location::where('status',1)->get();

         return view('backend/food-and-beverage.delivery-riders.delivery-riders-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_delivery_rider  $fnb_delivery_rider
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:fnb_delivery_riders,name,'.$id,
            'contact'   =>  'required',
            'restaurant_location'  =>  'required',
            'status'   =>  'required'
        ]);

        $update = fnb_delivery_rider::where('id', $id)->updateWithUserstamps([
            'name'=>$request->name,
            'contact'=>$request->contact,
            'restaurant_location'=>$request->restaurant_location,
            'status' => $request->status
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/delivery-riders/delivery-riders-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_delivery_rider  $fnb_delivery_rider
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_delivery_rider $fnb_delivery_rider,$id)
    {
        
        $destroy=$fnb_delivery_rider::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/delivery-riders');
    }

public function restore(fnb_delivery_rider $fnb_delivery_rider,$id)
    {
        $restore = fnb_delivery_rider::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/delivery-riders/deleted');

}

}
