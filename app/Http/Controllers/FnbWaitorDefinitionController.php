<?php

namespace App\Http\Controllers;

use App\fnb_waitor_definition;
use App\fnb_restaurant_location;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbWaitorDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, fnb_waitor_definition $fnb_waitor_definition)
    {
         return view('backend/food-and-beverage/waiter-definitions/waiter-definitions');
    }

    public function indexdt(Request $request, fnb_waitor_definition $fnb_waitor_definition)
    {

        
     $fnb_waitor_definitions = fnb_waitor_definition::get();
       return DataTables::of($fnb_waitor_definitions)
       ->addColumn('status', function ($fnb_waitor_definitions) {
               if($fnb_waitor_definitions->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })

        ->addColumn('restaurant', function ($fnb_waitor_definitions) {
                $restaurant=fnb_restaurant_location::where('id',$fnb_waitor_definitions->restaurant_location)->get();
                if($fnb_waitor_definitions->restaurant_location){
                  return $restaurant[0]['desc'];
                   }
                else{
                    return '';
                }
                })

->addColumn('srestaurant', function ($fnb_waitor_definitions) {
                $srestaurant=fnb_restaurant_location::where('id',$fnb_waitor_definitions->second_restaurant_location)->get();
                if($fnb_waitor_definitions->second_restaurant_location){
                  return $srestaurant[0]['desc'];
                   }
                else{
                    return '';
                }
                })

->addColumn('trestaurant', function ($fnb_waitor_definitions) {
                $trestaurant=fnb_restaurant_location::where('id',$fnb_waitor_definitions->third_restaurant_location)->get();
                if($fnb_waitor_definitions->third_restaurant_location){
                  return $trestaurant[0]['desc'];
                   }
                else{
                    return '';
                }
                })

        ->addColumn('editbutton', function ($fnb_waitor_definitions) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/waiter-definitions/waiter-definitions-aeu/').'/'.$fnb_waitor_definitions->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_waitor_definitions) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/waiter-definitions/delete') . '/' . $fnb_waitor_definitions->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','restaurant','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_waitor_definition $fnb_waitor_definition)
    {
        return view('backend/food-and-beverage/waiter-definitions/waiter-definitions-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_waitor_definition $fnb_waitor_definition)
    {

        $table = fnb_waitor_definition::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/waiter-definitions/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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


           ->addColumn('srestaurant', function ($table) {
                $srestaurant=fnb_restaurant_location::where('id',$table->second_restaurant_location)->get();
                if($table->second_restaurant_location){
                  return $srestaurant[0]['desc'];
                   }
                else{
                    return '';
                }
                })

->addColumn('trestaurant', function ($table) {
                $trestaurant=fnb_restaurant_location::where('id',$table->third_restaurant_location)->get();
                if($table->third_restaurant_location){
                  return $trestaurant[0]['desc'];
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
      $lastval=fnb_waitor_definition::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['waiter_def_update'] = '';

       $data['restaurants']=fnb_restaurant_location::where('status',1)->get();

     return view('backend/food-and-beverage.waiter-definitions.waiter-definitions-aeu',$data);
   
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
            'name' => 'required|unique:fnb_waitor_definitions,name',
            'contact'   =>  'required',
            'restaurant_location'  =>  'required',
            'status'   =>  'required'
        ]);  
                    
       $store=fnb_waitor_definition::create([
            'name'=>$request->name,
            'contact'=>$request->contact,
            'restaurant_location'=>$request->restaurant_location,
            'second_restaurant_location'=>$request->second_restaurant_location,
            'third_restaurant_location'=>$request->third_restaurant_location,
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
                return redirect('food-and-beverage/waiter-definitions/waiter-definitions-aeu');
            }else{
                return redirect('food-and-beverage/waiter-definitions');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_waitor_definition  $fnb_waitor_definition
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_waitor_definition $fnb_waitor_definition)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_waitor_definition  $fnb_waitor_definition
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_waitor_definition $fnb_waitor_definition, $id)
    {
        $data['waiter_def_update'] = fnb_waitor_definition::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['waiter_def_update']->code;

        $data['restaurants']=fnb_restaurant_location::where('status',1)->get();

         return view('backend/food-and-beverage.waiter-definitions.waiter-definitions-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_waitor_definition  $fnb_waitor_definition
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:fnb_waitor_definitions,name,'.$id,
            'contact'   =>  'required',
            'restaurant_location'  =>  'required',
            'status'   =>  'required'
        ]);

        $update = fnb_waitor_definition::where('id', $id)->updateWithUserstamps([
            'name'=>$request->name,
            'contact'=>$request->contact,
            'restaurant_location'=>$request->restaurant_location,
             'second_restaurant_location'=>$request->second_restaurant_location,
            'third_restaurant_location'=>$request->third_restaurant_location,
            'status' => $request->status
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/waiter-definitions/waiter-definitions-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_waitor_definition  $fnb_waitor_definition
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_waitor_definition $fnb_waitor_definition,$id)
    {
        
        $destroy=$fnb_waitor_definition::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/waiter-definitions');
    }

public function restore(fnb_waitor_definition $fnb_waitor_definition,$id)
    {
        $restore = fnb_waitor_definition::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/waiter-definitions/deleted');

}

}
