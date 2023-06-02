<?php

namespace App\Http\Controllers;

use App\fnb_item_sub_category;
use App\fnb_item_category;
use App\fnb_item_definition;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbItemSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, fnb_item_sub_category $fnb_item_sub_category)
    {
         $data['cats']=fnb_item_category::get();
        $data['subcats']=fnb_item_sub_category::get();
         return view('backend/food-and-beverage/item-sub-categories/item-sub-categories',$data);
    }

    public function indexdt(Request $request, fnb_item_sub_category $fnb_item_sub_category)
    {
 $subcategory=fnb_item_sub_category::query();

 if($request->get('cat')){
            $subcategory->where('item_category',$request->get('cat'));

        }
if($request->get('subcat')){
            $subcategory->where('desc',$request->get('subcat'));

        }
if($request->get('printer')){
            $subcategory->where('printer',$request->get('printer'));
}
if($request->get('status')){
    if($request->get('status')=='Active'){
         $subcategory->where('status',1);
    }
    else if($request->get('status')=='In-Active')

 $subcategory->where('status',0);
        }


  $sub_categories = $subcategory->get();

  /*   $sub_categories = fnb_item_sub_category::get();*/
       return DataTables::of($sub_categories)
       ->addColumn('status', function ($sub_categories) {
               if($sub_categories->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })

   ->addColumn('category', function ($sub_categories) {
         
                
                if($sub_categories->item_category){
                  return salescategory($sub_categories->item_category);
                  }
                else{
                    return '';
                }
                })

      

        ->addColumn('editbutton', function ($sub_categories) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/item-sub-categories/item-sub-categories-aeu/').'/'.$sub_categories->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($sub_categories) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/item-sub-categories/delete') . '/' . $sub_categories->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','category','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_item_sub_category $fnb_item_sub_category)
    {
        return view('backend/food-and-beverage/item-sub-categories/item-sub-categories-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_item_sub_category $fnb_item_sub_category)
    {

        $table = fnb_item_sub_category::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/item-sub-categories/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->addColumn('category', function ($table) {
                $category=fnb_item_category::where('id',$table->item_category)->get();
                if($table->item_category){
                  return $category[0]['desc'];
                  }
                else{
                    return '';
                }
                })


        ->rawColumns(['restorebutton', 'category'])
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
      $lastval=fnb_item_sub_category::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['sub_category_update'] = '';

        $data['mains']=fnb_item_category::where('status',1)->get();

     return view('backend/food-and-beverage.item-sub-categories.item-sub-categories-aeu',$data);

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
            'item_category'   =>  'required',
            'desc' => 'required|unique:fnb_item_sub_categories,desc,NULL,id,item_category,'.$request->item_category,
/*            'printer'   =>  'required',*/
            'status'   =>  'required']);

       $store=fnb_item_sub_category::create([
        'item_category'=>$request->item_category,
            'desc'=>$request->desc,
            'printer'=>$request->printer,
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
                return redirect('food-and-beverage/item-sub-categories/item-sub-categories-aeu');
            }else{
                return redirect('food-and-beverage/item-sub-categories');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_item_sub_category  $fnb_item_sub_category
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_item_sub_category $fnb_item_sub_category)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_item_sub_category  $fnb_item_sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_item_sub_category $fnb_item_sub_category, $id)
    {
        $data['sub_category_update'] = fnb_item_sub_category::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['sub_category_update']->code;

        $data['mains']=fnb_item_category::where('status',1)->get();

         return view('backend/food-and-beverage.item-sub-categories.item-sub-categories-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_item_sub_category  $fnb_item_sub_category
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'item_category'   =>  'required',
            'desc' => 'required|unique:fnb_item_sub_categories,desc,'.$id,
/*            'printer'   =>  'required',*/
            'status'   =>  'required']);

        $update = fnb_item_sub_category::where('id', $id)->updateWithUserstamps([
           'item_category'=>$request->item_category,
            'desc'=>$request->desc,
            'printer'=>$request->printer,
            'status'=>$request->status,
        ]);


      $items=fnb_item_definition::where('sub_category',$id)->get();

      foreach($items as $item){
        $item::where('sub_category',$id)->where('id',$item->id)->updateWithUserstamps([
            'category'=>$request->item_category,
        ]);
      }

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/item-sub-categories/item-sub-categories-aeu/'.$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_item_sub_category  $fnb_item_sub_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_item_sub_category $fnb_item_sub_category,$id)
    {

        $destroy=$fnb_item_sub_category::where('id', $id)->deleteWithUserstamps();
        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('food-and-beverage/item-sub-categories');
    }

public function restore(fnb_item_sub_category $fnb_item_sub_category,$id)
    {
        $restore = fnb_item_sub_category::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/item-sub-categories/deleted');

}

}
