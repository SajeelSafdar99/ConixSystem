<?php

namespace App\Http\Controllers;

use App\hr_company;
use App\hr_department;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;
use App\coa_account;

class HrDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, hr_department $hr_department)
    {
        return view('backend/human-resource/departments/departments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, hr_department $hr_department)
    {

        $tables = hr_department::get();
        return DataTables::of($tables)
            ->addColumn('status', function ($tables) {
                if ($tables->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }
            })

             ->addColumn('company', function ($tables) {
                 if($tables->company){
                    return coaaccountname($tables->company);
                }
            })

            ->addColumn('editbutton', function ($tables) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('human-resource/departments/departments-aeu/') . '/' . $tables->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($tables) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/departments/delete') . '/' . $tables->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton', 'status', 'company'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, hr_department $hr_department)
    {
        return view('backend/human-resource/departments/departments-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, hr_department $hr_department)
    {

        $tables = hr_department::onlyTrashed()->get();
        return DataTables::of($tables)

            ->addColumn('restorebutton', function ($tables) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/departments/restore/') . '/' . $tables->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

             ->addColumn('company', function ($tables) {
                 if($tables->company){
                    return coaaccountname($tables->company);
                }
            })

        ->rawColumns(['restorebutton', 'company'])
        ->addIndexColumn()
        ->make(true);
    }
    
    public function create()
    {
        //Get the last record id and pass to the view
        $lastval = hr_department::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['departments_update'] = '';

         $data['companies']=coa_account::where('status',1)->where('desc',null)->get();

        return view('backend/human-resource.departments.departments-aeu', $data);
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
           'company'   => 'required',
            'desc' => 'required',
            'status'   => 'required']);

        $hr_department = hr_department::create([
           'company'   => $request->company,
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if($hr_department) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('human-resource/departments/departments-aeu');
            }else{
                return redirect('human-resource/departments');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hr_department  $hr_department
     * @return \Illuminate\Http\Response
     */
    public function show(hr_department $hr_department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_department  $hr_department
     * @return \Illuminate\Http\Response
     */
  public function edit(hr_department $hr_department,$id)
    {
         $data['departments_update'] = hr_department::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['departments_update']->code;

       $data['companies']=coa_account::where('status',1)->where('desc',null)->get();

        return view('backend/human-resource.departments.departments-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hr_department  $hr_department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company'   => 'required',
            'desc' => 'required',
            'status'   => 'required']);

        $hr_department = hr_department::where('id', $id)->updateWithUserstamps([
            'company'   => $request->company,
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($hr_department) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/departments/departments-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_department  $hr_department
     * @return \Illuminate\Http\Response
     */

    public function destroy(hr_department $hr_department,$id)
    {
        $hr_department=$hr_department::where('id', $id)->deleteWithUserstamps();
        if($hr_department){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('human-resource/departments');
    }


    public function restore(hr_department $hr_department,$id)
    {
        $restore = hr_department::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/departments/deleted');

}

}