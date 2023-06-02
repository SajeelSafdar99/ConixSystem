<?php

namespace App\Http\Controllers;

use App\permissions;
use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use App\permission_category;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class PermissionsController extends Controller
{
      public function index(Request $request, permissions $permissions)
    {
        return view('backend/admin-settings/permissions/permissions');
    }

      public function indexdt(Request $request, permissions $permissions)
    {

        $permission = Permission::all();
        return DataTables::of($permission)
    
    


            ->addColumn('button', function ($permission) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('admin-settings/permissions/permissions-aeu/') . '/' . $permission->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })


             ->addColumn('category', function ($permission) {
              return categoryidchange($permission->category);


                })
           

            ->rawColumns(['button', 'permission_category', 'category'])
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
          $lastval = permissions::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['permissions_update'] = '';
       $data['categories']=permission_category::get();

        return view('backend/admin-settings.permissions.permissions-aeu', $data);
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
            'name' => 'required|unique:permissions,name',
             'category' => 'required',
         ]);
       
        $permission = Permission::create(['name' => $request->name,
'category' => $request->category
    ]);

        if ($permission) {
            Session::flash('message', 'Permission Entered Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Permission Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('admin-settings/permissions/permissions-aeu');
            }else{
                return redirect('admin-settings/permissions');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\roles  $roles
     * @return \Illuminate\Http\Response
     */
 public function show(permissions $permissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\roles  $roles
     * @return \Illuminate\Http\Response
     */
     public function edit(permissions $permissions,$id)
    {
         $data['permissions_update'] = Permission::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['permissions_update']->code;
$data['categories']=permission_category::get();
        return view('backend/admin-settings.permissions.permissions-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\roles  $roles
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,'.$id,
            'category' => 'required'
        ]);

        $permission = Permission::where('id', $id)->updateWithUserstamps([
           'name'   => $request->name,
           'category' => $request->category

        ]);


        if ($permission) {
            Session::flash('message', 'Permission Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Permission Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/permissions/permissions-aeu/'.$id);

    }

    public function destroy(permissions $permissions, $id)
    {
        $permission=$permissions::where('id', $id)->deleteWithUserstamps();
        if($permission){
            Session::flash('message', 'Permission deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Permission Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('admin-settings/permissions');
    }


}
