<?php

namespace App\Http\Controllers;

use App\permission_category;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class PermissionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, permission_category $permission_category)
    {
        return view('backend/admin-settings/permission-categories/permission-categories');
    }

     public function indexdt(Request $request, permission_category $permission_category)
    {
        $categories = permission_category::get();
        return DataTables::of($categories)
           
            ->addColumn('editbutton', function ($categories) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('admin-settings/permission-categories/permission-categories-aeu/') . '/' . $categories->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($categories) {
                return ' <button class="buttoncolor" title="Delete" data-confirm="Are you sure to delete this item?"><a style="color:#000000;" href="' . url('admin-settings/permission-categories/delete/') . '/' . $categories->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton'])
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
        $lastval = permission_category::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['permission_category_update'] = '';

        return view('backend/admin-settings.permission-categories.permission-categories-aeu', $data);
    }


    public function index_deleted(Request $request, permission_category $permission_category)
    {
        return view('backend/admin-settings/permission-categories/permission-categories-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, permission_category $permission_category)
    {

        $deleted = permission_category::onlyTrashed()->get();
        return DataTables::of($deleted)

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('admin-settings/permission-categories/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
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
          
            'desc' => 'required|unique:permission_categories,desc' ]);

        $Categories = permission_category::create([
           
            'desc'   => $request->desc

        ]);

        if ($Categories) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('admin-settings/permission-categories/permission-categories-aeu');
            }else{
                return redirect('admin-settings/permission-categories');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\permission_category  $permission_category
     * @return \Illuminate\Http\Response
     */
    public function show(permission_category $permission_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\permission_category  $permission_category
     * @return \Illuminate\Http\Response
     */
    public function edit(permission_category $permission_category,$id)
    {
         $data['permission_category_update'] = permission_category::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['permission_category_update']->code;

        return view('backend/admin-settings.permission-categories.permission-categories-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\permission_category  $permission_category
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:permission_categories,desc,'.$id ]);

        $categories = permission_category::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc
        ]);

        if ($categories) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/permission-categories/permission-categories-aeu/'.$id);

    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\permission_category  $permission_category
     * @return \Illuminate\Http\Response
     */

    public function destroy(permission_category $permission_category,$id)
    {
        $categories=$permission_category::where('id', $id)->deleteWithUserstamps();
        if($categories){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('admin-settings/permission-categories');
    }


public function restore(permission_category $permission_category,$id)
    {
        $restore = permission_category::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('admin-settings/permission-categories/deleted');

}

}
