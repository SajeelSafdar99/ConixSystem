<?php

namespace App\Http\Controllers;

use App\store_restaurant_section_definition;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\store_department;

class StoreRestaurantSectionDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, store_restaurant_section_definition $store_restaurant_section_definition)
    {
         return view('backend/store-management/restaurant-section-definitions/restaurant-section-definitions');
    }

    public function indexdt(Request $request, store_restaurant_section_definition $store_restaurant_section_definition)
    {

        
     $store_restaurant_section_definitions = store_restaurant_section_definition::get();
       return DataTables::of($store_restaurant_section_definitions)
       ->addColumn('status', function ($store_restaurant_section_definitions) {
               if($store_restaurant_section_definitions->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($store_restaurant_section_definitions) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('store-management/restaurant-section-definitions/restaurant-section-definitions-aeu/').'/'.$store_restaurant_section_definitions->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($store_restaurant_section_definitions) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('store-management/restaurant-section-definitions/delete') . '/' . $store_restaurant_section_definitions->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, store_restaurant_section_definition $store_restaurant_section_definition)
    {
        return view('backend/store-management/restaurant-section-definitions/restaurant-section-definitions-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, store_restaurant_section_definition $store_restaurant_section_definition)
    {

        $table = store_restaurant_section_definition::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('store-management/restaurant-section-definitions/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }


     public function mapping_index(Request $request, store_restaurant_section_definition $store_restaurant_section_definition)
    {
         return view('backend/store-management/restaurant-section-definitions/section-department-mapping');
    }

    public function mapping_indexdt(Request $request, store_restaurant_section_definition $store_restaurant_section_definition)
    {

        
     $store_restaurant_section_definitions = store_restaurant_section_definition::get();

       return DataTables::of($store_restaurant_section_definitions)
         

        ->addColumn('editbutton', function ($store_restaurant_section_definitions) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('store-management/restaurant-section-definitions/section-department-mapping-aeu/').'/'.$store_restaurant_section_definitions->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })

          ->addColumn('departments', function ($store_restaurant_section_definitions) {
    return str_replace(array('[',']','"'),'', $store_restaurant_section_definitions->departments()->pluck('desc')) ;

                })
      
       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }

   public function mapping_edit(store_restaurant_section_definition $store_restaurant_section_definition, $id)
    {
        $data['section_update'] = store_restaurant_section_definition::with('departments')->where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['section_update']->code;

          $data['departments']= store_department::where('status',1)->get();

         return view('backend/store-management.restaurant-section-definitions.section-department-mapping-aeu',$data);
    }

  public function mapping_update(Request $request, $id)
    {
 $departments = $request['departments'];
if( $departments){
  foreach($departments as $deps){
      $update =   store_department::where('id', $deps)->updateWithUserstamps([
            'section'=>$id,
        ]);
     }
}
else{
     $update = store_department::where('section', $id)->updateWithUserstamps([
         'section'=>null,
        ]);
}
   
      
        if ($update) {
            Session::flash('message', 'Linked Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Linkage Was Unsuccessful!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('store-management/restaurant-section-definitions/section-department-mapping-aeu/'.$id);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get the last record id and pass to the view
      $lastval=store_restaurant_section_definition::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['section_update'] = '';

     return view('backend/store-management.restaurant-section-definitions.restaurant-section-definitions-aeu',$data);
   
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
            'desc' => 'required|unique:store_restaurant_section_definitions,desc',
            'status'   =>  'required'
        ]);  
                    
       $store=store_restaurant_section_definition::create([
            'desc'   => $request->desc,
            'status' => $request->status,
            
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
                return redirect('store-management/restaurant-section-definitions/restaurant-section-definitions-aeu');
            }else{
                return redirect('store-management/restaurant-section-definitions');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\store_restaurant_section_definition  $store_restaurant_section_definition
     * @return \Illuminate\Http\Response
     */
    public function show(store_restaurant_section_definition $store_restaurant_section_definition)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\store_restaurant_section_definition  $store_restaurant_section_definition
     * @return \Illuminate\Http\Response
     */
    public function edit(store_restaurant_section_definition $store_restaurant_section_definition, $id)
    {
        $data['section_update'] = store_restaurant_section_definition::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['section_update']->code;

         return view('backend/store-management.restaurant-section-definitions.restaurant-section-definitions-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\store_restaurant_section_definition  $store_restaurant_section_definition
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request,[
            'desc' => 'required|unique:store_restaurant_section_definitions,desc',
            'status'   =>  'required'
        ]); 

        $update = store_restaurant_section_definition::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);


        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('store-management/restaurant-section-definitions/restaurant-section-definitions-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\store_restaurant_section_definition  $store_restaurant_section_definition
     * @return \Illuminate\Http\Response
     */
    public function destroy(store_restaurant_section_definition $store_restaurant_section_definition,$id)
    {
        
        $destroy=$store_restaurant_section_definition::where('id', $id)->deleteWithUserstamps();

       
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('store-management/restaurant-section-definitions');
    }

public function restore(store_restaurant_section_definition $store_restaurant_section_definition,$id)
    {

        $restore = store_restaurant_section_definition::onlyTrashed()->find($id)->restore();
        
        
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('store-management/restaurant-section-definitions/deleted');

}

}
