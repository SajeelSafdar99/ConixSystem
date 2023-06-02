<?php

namespace App\Http\Controllers;

use App\store_department;
use App\fnb_restaurant_location;
use App\fnb_item_category;
use App\store_location;
use Illuminate\Http\Request;
use Session;
use DataTables;

class StoreDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, store_department $store_department)
    {
         return view('backend/store-management/store-departments/store-departments');
    }

    public function indexdt(Request $request, store_department $store_department)
    {

     $store_departments = store_department::get();
       return DataTables::of($store_departments)
       ->addColumn('status', function ($store_departments) {
               if($store_departments->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        
          ->addColumn('location', function ($store_departments) {
           if($store_departments->location){
                 // return salesrestaurantname($store_departments->location);
            return salescategory($store_departments->location);
                  }
                else{
                    return '';
                }
                  
                })

        ->addColumn('editbutton', function ($store_departments) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('store-management/store-departments/store-departments-aeu/').'/'.$store_departments->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($store_departments) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('store-management/store-departments/delete') . '/' . $store_departments->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, store_department $store_department)
    {
        return view('backend/store-management/store-departments/store-departments-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, store_department $store_department)
    {

        $table = store_department::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('store-management/store-departments/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

             ->addColumn('location', function ($table) {
           if($table->location){
                  return salescategory($table->location);
                  }
                else{
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
      $lastval=store_department::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['store_department_update'] = '';
/* $data['locations']= fnb_restaurant_location::where('status',1)->get();*/
  $data['locations']= fnb_item_category::where('status',1)->get();

     return view('backend/store-management.store-departments.store-departments-aeu',$data);
   
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
            'desc' => 'required|unique:store_departments,desc',
            'location'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=store_department::create([
            'desc'=>$request->desc,
            'location'=>$request->location,
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
                return redirect('store-management/store-departments/store-departments-aeu');
            }else{
                return redirect('store-management/store-departments');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\store_department  $store_department
     * @return \Illuminate\Http\Response
     */
    public function show(store_department $store_department)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\store_department  $store_department
     * @return \Illuminate\Http\Response
     */
    public function edit(store_department $store_department, $id)
    {
        $data['store_department_update'] = store_department::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['store_department_update']->code;
  $data['locations']= fnb_item_category::where('status',1)->get();

         return view('backend/store-management.store-departments.store-departments-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\store_department  $store_department
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:store_departments,desc,'.$id,
            'location'   =>  'required',
            'status'   =>  'required']);

        $update = store_department::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'location'=>$request->location,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('store-management/store-departments/store-departments-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\store_department  $store_department
     * @return \Illuminate\Http\Response
     */
    public function destroy(store_department $store_department,$id)
    {
        
        $destroy=$store_department::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('store-management/store-departments');
    }

public function restore(store_department $store_department,$id)
    {
        $restore = store_department::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/store-departments/deleted');

}

}
