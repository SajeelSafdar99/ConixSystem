<?php

namespace App\Http\Controllers;

use App\fnb_restaurant_location;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\coa_account;
use Spatie\Permission\Models\Permission;

class FnbRestaurantLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, fnb_restaurant_location $fnb_restaurant_location)
    {
         return view('backend/food-and-beverage/restaurant-locations/restaurant-locations');
    }

    public function indexdt(Request $request, fnb_restaurant_location $fnb_restaurant_location)
    {

        
     $fnb_restaurant_locations = fnb_restaurant_location::get();
       return DataTables::of($fnb_restaurant_locations)
       ->addColumn('status', function ($fnb_restaurant_locations) {
               if($fnb_restaurant_locations->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        
         ->addColumn('unit', function ($table) {
            if($table->unit){
                return coaaccountname($table->unit);
            }else{
                return '';
            }
                })

        ->addColumn('editbutton', function ($fnb_restaurant_locations) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/restaurant-locations/restaurant-locations-aeu/').'/'.$fnb_restaurant_locations->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_restaurant_locations) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/restaurant-locations/delete') . '/' . $fnb_restaurant_locations->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_restaurant_location $fnb_restaurant_location)
    {
        return view('backend/food-and-beverage/restaurant-locations/restaurant-locations-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_restaurant_location $fnb_restaurant_location)
    {

        $table = fnb_restaurant_location::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/restaurant-locations/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

             ->addColumn('unit', function ($table) {
            if($table->unit){
                return coaaccountname($table->unit);
            }else{
                return '';
            }
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
      $lastval=fnb_restaurant_location::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['restaurant_location_update'] = '';

    $data['cost_centers']=coa_account::where('desc','!=',null)->get();

     return view('backend/food-and-beverage.restaurant-locations.restaurant-locations-aeu',$data);
   
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

         $validation=[
            'desc' => 'required|unique:fnb_restaurant_locations,desc',
            'unit'   =>  'required',
            'status'   =>  'required',
        ];
        if(!$request->get('restaurant') && !$request->get('store')){
            $validation['Restaurant_or_Store']='required';
        }
         $this->validate($request, $validation);
                    
       $store=fnb_restaurant_location::create([
            'desc'=>$request->desc,
            'unit'=>$request->unit,
            'restaurant'=>$request->restaurant,
            'store'=>$request->store,
            'status'=>$request->status,
            
            ]);

       Permission::create(['name' => $request->desc.' '.$store->id,'category'=>25, 'auto_generated' => 1]);
            
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
                return redirect('food-and-beverage/restaurant-locations/restaurant-locations-aeu');
            }else{
                return redirect('food-and-beverage/restaurant-locations');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_restaurant_location  $fnb_restaurant_location
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_restaurant_location $fnb_restaurant_location)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_restaurant_location  $fnb_restaurant_location
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_restaurant_location $fnb_restaurant_location, $id)
    {
        $data['restaurant_location_update'] = fnb_restaurant_location::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['restaurant_location_update']->code;

        $data['cost_centers']=coa_account::where('desc','!=',null)->get();

         return view('backend/food-and-beverage.restaurant-locations.restaurant-locations-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_restaurant_location  $fnb_restaurant_location
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
         $theprename='';
        $theprename=fnb_restaurant_location::where('id', $id)->get()->pluck('desc');
        
        $validation=[
            'desc' => 'required|unique:fnb_restaurant_locations,desc,'.$id,
            'unit'   =>  'required',
            'status'   =>  'required',
        ];
        if(!$request->get('restaurant') && !$request->get('store')){
            $validation['Restaurant_or_Store']='required';
        }
       
         $this->validate($request, $validation);

        $update = fnb_restaurant_location::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'unit'=>$request->unit,
            'restaurant'=>$request->restaurant,
            'store'=>$request->store,
            'status'=>$request->status,
        ]);


if(Permission::where('category',25)->where('name', $theprename[0].' '.$id)->exists())
{
    Permission::where('category',25)->where('name', $theprename[0].' '.$id)->updateWithUserstamps([
            'name'=>$request->desc.' '.$id,
            'category'=>25,
            'auto_generated' => 1
        ]);

}
else{
     Permission::create(['name' => $request->desc.' '.$id,'category'=>25, 'auto_generated' => 1]);
}
 

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/restaurant-locations/restaurant-locations-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_restaurant_location  $fnb_restaurant_location
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_restaurant_location $fnb_restaurant_location,$id)
    {
        $data['getname'] = fnb_restaurant_location::where('id', $id)->first();
        
        $destroy=$fnb_restaurant_location::where('id', $id)->deleteWithUserstamps();

        if($destroy){ 
        Permission::where('category',25)->where('name', $data['getname']->desc.' '.$id)->deleteWithUserstamps();
        }

       
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/restaurant-locations');
    }

public function restore(fnb_restaurant_location $fnb_restaurant_location,$id)
    {
        $data['getname'] = fnb_restaurant_location::onlyTrashed()->where('id', $id)->first();

        $restore = fnb_restaurant_location::onlyTrashed()->find($id)->restore();
        
        if($restore){
            Permission::onlyTrashed()->where('category',25)->where('name', $data['getname']->desc.' '.$id)->restore();
        }

        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/restaurant-locations/deleted');

}

}
