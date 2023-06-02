<?php

namespace App\Http\Controllers;

use App\event_rate_category;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class EventRateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, event_rate_category $event_rate_category)
    {
        return view('backend/events-management/menu-category/menu-category');
    }


     public function indexdt(Request $request, event_rate_category $event_rate_category)
    {

        $menucategory = event_rate_category::get();
        return DataTables::of($menucategory)
            ->addColumn('status', function ($menucategory) {
                if ($menucategory->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })


            ->addColumn('editbutton', function ($menucategory) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/menu-category/menu-category-aeu/') . '/' . $menucategory->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($menucategory) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/menu-category/delete') . '/' . $menucategory->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
        ->addIndexColumn()
            ->make(true);
    }


    public function index_deleted(Request $request, event_rate_category $event_rate_category)
    {
        return view('backend/events-management/menu-category/menu-category-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_rate_category $event_rate_category)
    {

        $Event_categories = event_rate_category::onlyTrashed()->get();
        return DataTables::of($Event_categories)

            ->addColumn('restorebutton', function ($Event_categories) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/menu-category/restore/') . '/' . $Event_categories->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        // //Get the last record id and pass to the view
        $lastval = event_rate_category::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['menu_category_update'] = '';

        return view('backend/events-management.menu-category.menu-category-aeu', $data);
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
        $this->validate($request, [
           // 'menu_category_code'     => 'required',
            'desc' => 'required|unique:event_rate_categories,desc',
            'status'   => 'required']);

        $Event_categories = event_rate_category::create([
           // 'code'   => $request->menu_category_code,
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if ($Event_categories) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/menu-category/menu-category-aeu');
            }else{
                return redirect('events-management/menu-category');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_rate_category  $event_rate_category
     * @return \Illuminate\Http\Response
     */
    public function show(event_rate_category $event_rate_category)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_rate_category  $event_rate_category
     * @return \Illuminate\Http\Response
     */
    public function edit(event_rate_category $event_rate_category,$id)
    {
        $data['menu_category_update'] = event_rate_category::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['menu_category_update']->code;

        return view('backend/events-management.menu-category.menu-category-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_rate_category  $event_rate_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
           'desc' => 'required|unique:event_rate_categories,desc,'.$id,
            'status'   => 'required']);

        $eventcategories = event_rate_category::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($eventcategories) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/menu-category/menu-category-aeu/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_rate_category  $event_rate_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_rate_category $event_rate_category,$id)
    {
         $menucategories=$event_rate_category::where('id', $id)->deleteWithUserstamps();
        if($menucategories){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('events-management/menu-category');
    }


 public function restore(event_rate_category $event_rate_category,$id)
    {
        $restore = event_rate_category::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/menu-category/deleted');

}

}