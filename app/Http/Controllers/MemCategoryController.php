<?php

namespace App\Http\Controllers;

use App\mem_category;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_category $mem_category)
    {
        return view('backend/club-hospitality/member-category/member-category');
    }

     public function indexdt(Request $request, mem_category $mem_category)
    {

        
     $mem_categories = mem_category::get();
       return DataTables::of($mem_categories)
       ->addColumn('status', function ($mem_categories) {
               if($mem_categories->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($mem_categories) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('club-hospitality/member-category/member-category-aeu/').'/'.$mem_categories->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })

        ->addColumn('deletebutton', function ($mem_categories) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/member-category/delete') . '/' . $mem_categories->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })
       ->rawColumns(['editbutton','deletebutton', 'status'])
       ->addIndexColumn()
       ->make(true);
    }
    

     public function index_deleted(Request $request, mem_category $mem_category)
    {
        return view('backend/club-hospitality/member-category/member-category-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_category $mem_category)
    {

        $Category_add = mem_category::onlyTrashed()->get();
        return DataTables::of($Category_add)

            ->addColumn('restorebutton', function ($Category_add) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/member-category/restore/') . '/' . $Category_add->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval=mem_category::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
      $data['init']=0;
      $data['mem_category_update'] = '';


     return view('backend/club-hospitality.member-category.member-category-aeu',$data);
 
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
           
            'unique_code' => 'required|unique:mem_categories,unique_code',
            'desc' => 'required|unique:mem_categories,desc',
            // 'coa_code'   =>  'required',
           // 'account'   =>  'required',
            'fee' => 'required',
            'monthly_sub_fee' => 'required',
            'status'   =>  'required']);  
                    
       $Category_add=mem_category::create([
            
            'unique_code'=>$request->unique_code,
            'desc'=>$request->desc,
            'account'=>$request->account,
            'name'=>$request->name,
            'fee'=>$request->fee,
            'monthly_sub_fee'=>$request->monthly_sub_fee,
            'status'=>$request->status,
            
            ]);
            
            if($Category_add)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message
             if(empty($save))
            {
                return redirect('club-hospitality/member-category/member-category-aeu');
            }else{
                return redirect('club-hospitality/member-category');
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_category  $mem_category
     * @return \Illuminate\Http\Response
     */
    public function show(mem_category $mem_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_category  $mem_category
     * @return \Illuminate\Http\Response
     */
     public function edit(mem_category $mem_category, $id)
    {
        $data['mem_category_update'] = mem_category::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_category_update']->code;

        return view('backend/club-hospitality.member-category.member-category-aeu',$data);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_category  $mem_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            
            'unique_code' => 'required|unique:mem_categories,unique_code,'.$id,
            'desc' => 'required|unique:mem_categories,desc,'.$id,
           // 'coa_code'   =>  'required',
           // 'account'   =>  'required',
            'fee' => 'required',
            'monthly_sub_fee' => 'required',
            'status'   =>  'required']);

        $member_category = mem_category::where('id', $id)->updateWithUserstamps([
            
            'unique_code'=>$request->unique_code,
            'desc'=>$request->desc,
            'account'=>$request->account,
            'name'=>$request->name,
            'fee'=>$request->fee,
            'monthly_sub_fee'=>$request->monthly_sub_fee,
            'status'=>$request->status,
            
        ]);

        if ($member_category) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/member-category/member-category-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_category  $mem_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_category $mem_category,$id)
    {
        
        $memcategory=$mem_category::where('id', $id)->deleteWithUserstamps();
        if($memcategory){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/member-category');
    }

public function restore(mem_category $mem_category,$id)
    {
        $restore = mem_category::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/member-category/deleted');

}

}

