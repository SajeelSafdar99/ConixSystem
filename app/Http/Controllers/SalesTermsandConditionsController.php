<?php

namespace App\Http\Controllers;

use App\SalesTermsandConditions;
use Illuminate\Http\Request;
use Session;
use DataTables;
use Spatie\Permission\Models\Permission;

class SalesTermsandConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index(Request $request, SalesTermsandConditions $SalesTermsandConditions)
    {

          $data['records'] = SalesTermsandConditions::count();
          return view('backend/sales/terms-and-conditions/terms-and-conditions', $data);
    }

    public function indexdt(Request $request, SalesTermsandConditions $SalesTermsandConditions)
    {

     $category = SalesTermsandConditions::get();
       return DataTables::of($category)
       ->addColumn('status', function ($category) {
               if($category->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($category) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('sales/terms-and-conditions/terms-and-conditions-aeu/').'/'.$category->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($category) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('sales/terms-and-conditions/delete') . '/' . $category->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, SalesTermsandConditions $SalesTermsandConditions)
    {
        return view('backend/sales/terms-and-conditions/terms-and-conditions-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, SalesTermsandConditions $SalesTermsandConditions)
    {

        $table = SalesTermsandConditions::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('sales/terms-and-conditions/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=SalesTermsandConditions::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['terms_update'] = '';
 
     

     return view('backend/sales.terms-and-conditions.terms-and-conditions-aeu',$data);
   
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
         
            'terms_and_conditions'   =>  'required',
         ]);  
                    
       $store=SalesTermsandConditions::create([
            'terms_and_conditions'=>$request->terms_and_conditions,
           
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
                return redirect('sales/terms-and-conditions/terms-and-conditions-aeu');
            }else{
                return redirect('sales/terms-and-conditions');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesTermsandConditions  $SalesTermsandConditions
     * @return \Illuminate\Http\Response
     */
    public function show(SalesTermsandConditions $SalesTermsandConditions)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesTermsandConditions  $SalesTermsandConditions
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesTermsandConditions $SalesTermsandConditions, $id)
    {
        $data['terms_update'] = SalesTermsandConditions::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['terms_update']->code;

 

         return view('backend/sales.terms-and-conditions.terms-and-conditions-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesTermsandConditions  $SalesTermsandConditions
     * @return \Illuminate\Http\Response
     */

  public function update(Request $request, $id)
    {
      
        $this->validate($request, [
       
             'terms_and_conditions'   =>  'required',
        ]);

        $update = SalesTermsandConditions::where('id', $id)->updateWithUserstamps([
           
            'terms_and_conditions'=>$request->terms_and_conditions,
             
        ]);
 
        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('sales/terms-and-conditions/terms-and-conditions-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesTermsandConditions  $SalesTermsandConditions
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesTermsandConditions $SalesTermsandConditions,$id)
    {

       
        $destroy=$SalesTermsandConditions::where('id', $id)->deleteWithUserstamps();
   
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('sales/terms-and-conditions');
    }

public function restore(SalesTermsandConditions $SalesTermsandConditions,$id)
    {
        

        $restore = SalesTermsandConditions::onlyTrashed()->find($id)->restore();
        
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('sales/terms-and-conditions/deleted');

}

}
