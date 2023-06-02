<?php

namespace App\Http\Controllers;

use App\roles;
use App\permissions;
use App\permission_category;
use Illuminate\Http\Request;
use Auth;
use DataTables;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Role $Role)
    {
        return view('backend/admin-settings/roles/roles');
    }



     public function indexdt(Request $request, Role $Role)
    {
 
        $role = Role::all();
        return DataTables::of($role)


            ->addColumn('button', function ($role) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('admin-settings/roles/roles-aeu/') . '/' . $role->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('permissions', function ($role) {
              return str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) ;
                })

            ->rawColumns(['button', 'permissions'])
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
          $lastval = Role::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['roles_update'] = '';

$data['categories']=permission_category::get();

$data['permissions']=Permission::where('category','!=','')->orderBy('name','asc')->get();


        return view('backend/admin-settings.roles.roles-aeu', $data);
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
            'name' => 'required|unique:roles,name',
             'permissions' => 'required',
           ]);

        $name= $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];
        $role->save();

        foreach($permissions as $permission){
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

       /* $roles = Role::create(['name' => $request->name]);*/
     /*   $permission = Permission::create(['name' => $request->name]);
        $permission->assignRole($request->name);*/
        if ($save) {
            Session::flash('message', 'Role Entered Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Role Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('admin-settings/roles/roles-aeu');
            }else{
                return redirect('admin-settings/roles');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\roles  $roles
     * @return \Illuminate\Http\Response
     */
     public function edit(Role $Role,$id)
    {
         $data['roles_update'] = Role::findOrFail($id);
        $data['init']                = 1;
        $data['increment_number']    = $data['roles_update']->code;


$data['categories']=permission_category::get();

$data['permissions']=Permission::where('category','!=','')->orderBy('name','asc')->get();


        return view('backend/admin-settings.roles.roles-aeu', $data);
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

        $role=Role::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' => 'required'
        ]);

$input = $request->only(['name']);

        $permissions=$request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();

        foreach($p_all as $p){
            $role->revokePermissionTo($p);
        }

        foreach ($permissions as $permission) {
            $p=Permission::where('id', '=', $permission)->firstOrFail();
            $role->givePermissionTo($p);
        }

      /*  $role = Role::where('id', $id)->update([
           'name'   => $request->name,

        ]);*/

        if ($role) {
            Session::flash('message', 'Role Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Role Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/roles/roles-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(roles $roles, $id)
    {
        $role=$roles::where('id', $id)->delete();
        if($role){
            Session::flash('message', 'Role deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Role Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('admin-settings/roles');
    }

}
