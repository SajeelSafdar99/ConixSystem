<?php

namespace App\Http\Controllers;

use App\admin_company_profile;
use Illuminate\Http\Request;
use DataTables;
use Session;
use App\coa_account;
 
class AdminCompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, admin_company_profile $admin_company_profile)
    {
        $data['profile'] = admin_company_profile::get();
        $data['records'] = admin_company_profile::count();
       // return view('backend/admin-settings/profile/profile',$profile); 
        return view('backend/admin-settings.profile.profile', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, admin_company_profile $admin_company_profile)
    {

        $profile = admin_company_profile::get();
        return DataTables::of($profile)

            ->addColumn('button', function ($profile) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('admin-settings/profile/profile-aeu/') . '/' . $profile->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

             ->addColumn('company_logo', function ($profile) {
                return '<img style="width: 100px;" src="'.url('/').'/'.$profile->company_logo.'"/>';
            })

            ->rawColumns(['button', 'status','company_logo'])
        ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $lastval = admin_company_profile::get()->last();
        $num     = 0;
        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['profile_update'] = '';

    $data['cost_centers']=coa_account::where('desc','!=',null)->get();

        return view('backend/admin-settings.profile.profile-aeu', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

           $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;
         
        $this->validate($request, [
               'cost_center' => 'required|unique:admin_company_profiles,cost_center',
           'organization_name' => 'required',
            'company_name' => 'required|unique:admin_company_profiles,company_name',
            'company_address'=>'required',
            'company_city'=>'required',
            'company_number'=>'required',
            'company_email'=>'required|email',
            'company_website'=>'required',
            'company_logo' => 'required',
            ]);

        $profile = admin_company_profile::create([
            'organization_name' =>  $request->organization_name,
            'company_name' =>  $request->company_name,
            'company_address'=> $request->company_address,
            'company_city'=> $request->company_city,
            'company_number'=> $request->company_number,
            'company_email'=> $request->company_email,
            'company_website'=> $request->company_website,
           'company_logo' =>  sendImage($request->company_logo,$size),
           'cost_center'=>$request->cost_center,

        ]);

        if ($profile) {
            Session::flash('message', 'Profile Entered Successfully !');
            Session::flash('alert-class', 'alert-success');
            $getlastinsert=$profile->id;
        } else {

            Session::flash('message', 'Profile Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

          //echo $message;
          if($getlastinsert==0){
          return redirect('admin-settings/profile/profile-aeu');
          }else{
          return redirect('admin-settings/profile/profile-aeu/'.$getlastinsert);
          }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\admin_company_profile  $admin_company_profile
     * @return \Illuminate\Http\Response
     */
    public function show(admin_company_profile $admin_company_profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\admin_company_profile  $admin_company_profile
     * @return \Illuminate\Http\Response
     */
     public function edit(admin_company_profile $admin_company_profile,$id)
    {
         $data['profile_update'] = admin_company_profile::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['profile_update']->code;

 $data['cost_centers']=coa_account::where('desc','!=',null)->get();

        return view('backend/admin-settings.profile.profile-aeu', $data);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\admin_company_profile  $admin_company_profile
     * @return \Illuminate\Http\Response
     */
      public function update(Request $request, $id)
    {

         $size['width'] = 300;
    $size['height'] = 200;
        $updateimg='';
        if ($request->hasFile('company_logo')) {
        $updateimg=$request->company_logo;
        $updateimg=sendImage($updateimg,$size);
        }else{
        $updateimg=$request->existimg;
        }

        $this->validate($request, [
            'cost_center' => 'required|unique:admin_company_profiles,cost_center,'.$id,
            'organization_name' => 'required',
            'company_name' => 'required|unique:admin_company_profiles,company_name,'.$id,
            'company_address'=>'required',
            'company_city'=>'required',
            'company_number'=>'required',
            'company_email'=>'required|email',
            'company_website'=>'required',
           /* 'company_logo' => 'required',*/
        ]);

        $profile = admin_company_profile::where('id', $id)->updateWithUserstamps([
           'organization_name' =>  $request->organization_name,
            'company_name' =>  $request->company_name,
           'company_address'=> $request->company_address,
            'company_city'=> $request->company_city,
            'company_number'=> $request->company_number,
            'company_email'=> $request->company_email,
             'company_website'=> $request->company_website,
             'company_logo'=>$updateimg,
             'cost_center'=>$request->cost_center,
        ]);
       

        if ($profile) {
            Session::flash('message', 'Profile Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Profile Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/profile/profile-aeu/'.$id);

    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\admin_company_profile  $admin_company_profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin_company_profile $admin_company_profile)
    {
        //
    }
}
