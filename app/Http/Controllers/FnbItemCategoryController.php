<?php

namespace App\Http\Controllers;

use App\fnb_pos_location;
use App\fnb_item_category;
use Illuminate\Http\Request;
use Session;
use DataTables;
use Spatie\Permission\Models\Permission;

class FnbItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index(Request $request, fnb_item_category $fnb_item_category)
    {
         return view('backend/food-and-beverage/item-categories/item-categories');
    }

    public function indexdt(Request $request, fnb_item_category $fnb_item_category)
    {

     $category = fnb_item_category::get();
       return DataTables::of($category)
       ->addColumn('status', function ($category) {
               if($category->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($category) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/item-categories/item-categories-aeu/').'/'.$category->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($category) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/item-categories/delete') . '/' . $category->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_item_category $fnb_item_category)
    {
        return view('backend/food-and-beverage/item-categories/item-categories-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_item_category $fnb_item_category)
    {

        $table = fnb_item_category::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/item-categories/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_item_category::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['item_category_update'] = '';

       $data['locs']=fnb_pos_location::where('status',1)->get();

     return view('backend/food-and-beverage.item-categories.item-categories-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_item_categories,desc',
            'pos_location'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=fnb_item_category::create([
            'desc'=>$request->desc,
                   'printer'=>$request->printer,
                    'pos_location'=>$request->pos_location,
            'status'=>$request->status,
            
            ]);

        Permission::create(['name' => $request->desc.' '.$store->id,'category'=>18,'auto_generated' => 1]);
        Permission::create(['name' => 'Store'.' '.$request->desc.' '.$store->id,'category'=>24,'auto_generated' => 1]);
            
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
                return redirect('food-and-beverage/item-categories/item-categories-aeu');
            }else{
                return redirect('food-and-beverage/item-categories');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_item_category  $fnb_item_category
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_item_category $fnb_item_category)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_item_category  $fnb_item_category
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_item_category $fnb_item_category, $id)
    {
        $data['item_category_update'] = fnb_item_category::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['item_category_update']->code;

        $data['locs']=fnb_pos_location::where('status',1)->get();

         return view('backend/food-and-beverage.item-categories.item-categories-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_item_category  $fnb_item_category
     * @return \Illuminate\Http\Response
     */

  public function update(Request $request, $id)
    {
         $theprename='';
        $theprename=fnb_item_category::where('id', $id)->get()->pluck('desc');
        
        $this->validate($request, [
            'desc' => 'required|unique:fnb_item_categories,desc,'.$id,
             'pos_location'   =>  'required',
            'status'   =>  'required']);

        $update = fnb_item_category::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'printer'=>$request->printer,
           'pos_location'=>$request->pos_location,
            'status'=>$request->status,
        ]);

if(Permission::where('category',18)->where('name', $theprename[0].' '.$id)->exists())
{
    Permission::where('category',18)->where('name', $theprename[0].' '.$id)->updateWithUserstamps([
            'name'=>$request->desc.' '.$id,
            'category'=>18,
             'auto_generated' => 1
        ]);

}
else{
     Permission::create(['name' => $request->desc.' '.$id,'category'=>18, 'auto_generated' => 1]);
}
 

 if(Permission::where('category',24)->where('name', 'Store'.' '.$theprename[0].' '.$id)->exists())
{
    Permission::where('category',24)->where('name', 'Store'.' '.$theprename[0].' '.$id)->updateWithUserstamps([
            'name'=>'Store'.' '.$request->desc.' '.$id,
            'category'=>24,
            'auto_generated' => 1
        ]);
}
else{
     Permission::create(['name' => 'Store'.' '.$request->desc.' '.$id,'category'=>24, 'auto_generated' => 1]);
}
             
        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/item-categories/item-categories-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_item_category  $fnb_item_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_item_category $fnb_item_category,$id)
    {

        $data['getname'] = fnb_item_category::where('id', $id)->first();
        
        $destroy=$fnb_item_category::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
        Permission::where('category',18)->where('name', $data['getname']->desc.' '.$id)->deleteWithUserstamps();
        }

        if($destroy){ 
        Permission::where('category',24)->where('name', 'Store'.' '.$data['getname']->desc.' '.$id)->deleteWithUserstamps();
        }

        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/item-categories');
    }

public function restore(fnb_item_category $fnb_item_category,$id)
    {
        $data['getname'] = fnb_item_category::onlyTrashed()->where('id', $id)->first();

        $restore = fnb_item_category::onlyTrashed()->find($id)->restore();
        if($restore){
            Permission::onlyTrashed()->where('category',18)->where('name', $data['getname']->desc.' '.$id)->restore();
        }
        if($restore){
            Permission::onlyTrashed()->where('category',24)->where('name', 'Store'.' '.$data['getname']->desc.' '.$id)->restore();
        }

        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/item-categories/deleted');

}

}
