<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use DB;
use DataTables;
use App\roles;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;
use App\permission_category;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    /* public function __construct() {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
*/
    public function index(Request $request, User $User)
    {
        return view('backend/admin-settings/users/users');
    }


     public function indexdt(Request $request, User $User)
    {

        $users = User::get();
        return DataTables::of($users)
            ->addColumn('status', function ($users) {
                if ($users->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }



            })

             ->addColumn('roles', function ($users) {
              return str_replace(array('[',']','"'),'', $users->roles()->pluck('name')) ;
                })

            ->addColumn('editbutton', function ($users) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('admin-settings/users/users-aeu/') . '/' . $users->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($users) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('admin-settings/users/delete') . '/' . $users->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
        ->addIndexColumn()
            ->make(true);
    }


     public function index_assign(Request $request, User $User)
    {
        return view('backend/admin-settings/assign-roles/assign-roles');
    }


     public function indexdt_assign(Request $request, User $User)
    {

        $users = User::get();
        return DataTables::of($users)
            ->addColumn('status', function ($users) {
                if ($users->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }



            })

             ->addColumn('roles', function ($users) {
              return str_replace(array('[',']','"'),'', $users->roles()->pluck('name')) ;
                })

            ->addColumn('editbutton', function ($users) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('admin-settings/assign-roles/assign-roles-aeu/') . '/' . $users->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            
            ->rawColumns(['editbutton', 'status'])
        ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, User $User)
    {
        return view('backend/admin-settings/users/users-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, User $User)
    {

        $deleted = User::onlyTrashed()->get();
        return DataTables::of($deleted)

        ->addColumn('roles', function ($users) {
              return str_replace(array('[',']','"'),'', $users->roles()->pluck('name')) ;
                })

            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('admin-settings/users/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['roles','restorebutton'])
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
         $lastval = User::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['users_update'] = '';
        $data['roles']=Role::get();

         $data['categories']=permission_category::where('id','!=',1)->where('id','<=',15)->get();

        return view('backend/admin-settings.users.users-aeu', $data);
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
            //'room_category_code'     => 'required',
            'name' => 'required|unique:users,name|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
            'status'   => 'required']);

        $user = User::create([
           // 'code'   => $request->room_category_code,
            'name'   => $request->name,
            'email'   => $request->email,
            'password'   => Hash::make($request->password),
            'category' => $request->category,
            'status' => $request->status,

        ]);


        $roles=$request['roles'];
        if(isset($roles)){
            foreach($roles as $role){
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }
       /* $users->assignRole($request->role);*/
        if ($user) {
            Session::flash('message', 'User Entered Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'User Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('admin-settings/users/users-aeu');
            }else{
                return redirect('admin-settings/users');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User,$id)
    {
         $data['users_update'] = User::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['users_update']->code;
    $data['roles']=Role::get();
    $data['categories']=permission_category::where('id','!=',1)->where('id','<=',15)->get();
        return view('backend/admin-settings.users.users-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:120|unique:users,name,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'confirmed',
            'status'   => 'required'
        ]);

       $input = $request->only(['name', 'email', 'password', 'status','category']);
       if($input['password']!=''){

        $input['password']=Hash::make($input['password']);
       }
       else{
          unset( $input['password']);
       }

         $user->fill($input)->save();
         
    /*   $roles= $request['roles'];
     

       if(isset($roles)){
        $user->roles()->sync($roles);
       }
       else{
        $user->roles()->detach();
       }*/


        if ($user) {
            Session::flash('message', 'User Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'User Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/users/users-aeu/'.$id);

    }


      public function edit_assign(User $User,$id)
    {
         $data['users_update'] = User::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['users_update']->code;
    $data['roles']=Role::get();
        return view('backend/admin-settings.assign-roles.assign-roles-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update_assign(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:120|unique:users,name,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
          
        ]);

     
       $roles= $request['roles'];
       
       if(isset($roles)){
        $user->roles()->sync($roles);
       }
       else{
        $user->roles()->detach();
       }


        if ($user) {
            Session::flash('message', 'Roles Assigned Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Roles Not Assigned!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/assign-roles/assign-roles-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function destroy(User $User, $id)
    {
        $user=$User::where('id', $id)->deleteWithUserstamps();
        if($user){
            Session::flash('message', 'User deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'User Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('admin-settings/users');
    }


 public function restore(User $User,$id)
    {
        $restore = User::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('admin-settings/users/deleted');

}

 /*public function previous_restore(User $User)
    {

if(DB::table('users')->whereNotNull('deleted_at')->count() == 0)
{
    Session::flash('message', 'Nothing to restore !');
    Session::flash('alert-class', 'alert-success');

    return redirect('admin-settings/users');
}
else{


        $restore = User::withTrashed()->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('admin-settings/users');

    }
}*/
}
