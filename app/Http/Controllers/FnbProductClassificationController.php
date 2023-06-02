<?php

namespace App\Http\Controllers;

use App\fnb_product_classification;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbProductClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, fnb_product_classification $fnb_product_classification)
    {
         return view('backend/food-and-beverage/product-classifications/product-classifications');
    }

    public function indexdt(Request $request, fnb_product_classification $fnb_product_classification)
    {

        
     $fnb_product_classifications = fnb_product_classification::get();
       return DataTables::of($fnb_product_classifications)
       ->addColumn('status', function ($fnb_product_classifications) {
               if($fnb_product_classifications->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($fnb_product_classifications) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/product-classifications/product-classifications-aeu/').'/'.$fnb_product_classifications->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_product_classifications) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/product-classifications/delete') . '/' . $fnb_product_classifications->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_product_classification $fnb_product_classification)
    {
        return view('backend/food-and-beverage/product-classifications/product-classifications-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_product_classification $fnb_product_classification)
    {

        $table = fnb_product_classification::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/product-classifications/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_product_classification::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['product_class_update'] = '';

     return view('backend/food-and-beverage.product-classifications.product-classifications-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_product_classifications,desc',
            'status'   =>  'required']);  
                    
       $store=fnb_product_classification::create([
            'desc'=>$request->desc,
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
                return redirect('food-and-beverage/product-classifications/product-classifications-aeu');
            }else{
                return redirect('food-and-beverage/product-classifications');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_product_classification  $fnb_product_classification
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_product_classification $fnb_product_classification)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_product_classification  $fnb_product_classification
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_product_classification $fnb_product_classification, $id)
    {
        $data['product_class_update'] = fnb_product_classification::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['product_class_update']->code;

         return view('backend/food-and-beverage.product-classifications.product-classifications-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_product_classification  $fnb_product_classification
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_product_classifications,desc,'.$id,
            'status'   =>  'required']);

        $update = fnb_product_classification::where('id', $id)->updateWithUserstamps([
           
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

        return redirect('food-and-beverage/product-classifications/product-classifications-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_product_classification  $fnb_product_classification
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_product_classification $fnb_product_classification,$id)
    {
        
        $destroy=$fnb_product_classification::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/product-classifications');
    }

public function restore(fnb_product_classification $fnb_product_classification,$id)
    {
        $restore = fnb_product_classification::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/product-classifications/deleted');

}

}
