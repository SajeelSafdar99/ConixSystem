<?php

namespace App\Http\Controllers;

use App\hr_job_subs;
 use App\hr_employment;
use Illuminate\Http\Request;
 
use Session;
use DataTables;

class HrJobSubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

     public function indexdt(Request $request,$id, hr_employment $hr_job_subs)
    {


        $hr_job_subs = hr_employment::find($id)->jobs();

        return DataTables::of($hr_job_subs)

          

             ->addColumn('editbutton', function ($hr_job_subs) {

                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('human-resource/employment/job-aeu/') . '/' . $hr_job_subs->employee_id . '/' . $hr_job_subs->id . '"><i class="fas fa-edit"></i></a></button>'

                ;
            })

       ->addColumn('deletebutton', function ($hr_job_subs) {

                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/job/delete/') . '/' . $hr_job_subs->employee_id . '/' . $hr_job_subs->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'

                ;
            })

 
            ->rawColumns(['editbutton', 'deletebutton'])
            ->addIndexColumn()
            ->make(true);
    }

 public function index_deleted(Request $request, hr_job_subs $hr_job_subs,$id)
    {
        $data['employee_data'] = hr_employment::where('id', $id)->first();
        return view('backend/human-resource/employment/job-deleted', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function indexdt_deleted(Request $request,$id, hr_employment $hr_job_subs)
    {

        $hr_job_subs = hr_job_subs::onlyTrashed()->get();
        return DataTables::of($hr_job_subs)


        ->addColumn('restorebutton', function ($hr_job_subs) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/job/restore/') . '/' . $hr_job_subs->employee_id . '/' . $hr_job_subs->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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

     public function create(hr_job_subs $hr_job_subs,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = hr_job_subs::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['job_update'] = '';
        $data['employee_data'] = hr_employment::where('id', $id)->first();
 
        return view('backend/human-resource.employment.job-aeu', $data);
    }

    public function store(Request $request,$id)
    {

        $save=$request->save;
        $this->validate($request, [

            'company_name'=>'required',
            'hod'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'work'=>'required',
            'employed_from'=>'required',
            'employed_to'=>'required',
            'salary'=>'required',
            'reason'=>'required',
            
          ]);

         $create=hr_job_subs::create([
           'employee_id'=>$id,
           'company_name'=>$request->company_name,
            'hod'=>$request->hod,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'work'=>$request->work,
            'employed_from'=>formatDate($request->employed_from),
            'employed_to'=>formatDate($request->employed_to),
            'salary'=>$request->salary,
            'reason'=>$request->reason,

            ]);

       
            if($create)
            {
                Session::flash('message', 'Data Entered Successfully !');
                Session::flash('alert-class', 'alert-success');
                return redirect('human-resource/employment/job-aeu/'.$id);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return redirect('human-resource/employment/job-aeu/'.$id);

            }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function edit(hr_job_subs $hr_job_subs,$id,$jobid)
    {
        $data['job_update'] = hr_job_subs::where('id',$jobid)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['job_update']->code;

     
$data['employee_data'] = hr_employment::where('id', $id)->first();


        return view('backend/human-resource.employment.job-aeu', $data);
    }


    public function update(Request $request,$id,$jobid)
    {

        $this->validate($request, [
            'company_name'=>'required',
            'hod'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'work'=>'required',
            'employed_from'=>'required',
            'employed_to'=>'required',
            'salary'=>'required',
            'reason'=>'required',
          ]);



        $update = hr_job_subs::where('id', $jobid)->updateWithUserstamps([
 
           'company_name'=>$request->company_name,
            'hod'=>$request->hod,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'work'=>$request->work,
            'employed_from'=>formatDate($request->employed_from),
            'employed_to'=>formatDate($request->employed_to),
            'salary'=>$request->salary,
            'reason'=>$request->reason,
        ]);

       

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/employment/job-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hr_job_subs  $hr_job_subs
     * @return \Illuminate\Http\Response
     */
    public function show(hr_job_subs $hr_job_subs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_job_subs  $hr_job_subs
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hr_job_subs  $hr_job_subs
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_job_subs  $hr_job_subs
     * @return \Illuminate\Http\Response
     */
    public function destroy(hr_job_subs $hr_job_subs,$id,$jobid)
    {
        $delete=$hr_job_subs::where('id',$jobid)->deleteWithUserstamps();
        if($delete){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
         }

        return redirect('human-resource/employment/job-aeu/'.$id);
    }


    public function restore(hr_job_subs $hr_job_subs,$id,$jobid)
    {
        $restore = hr_job_subs::onlyTrashed()->find($jobid)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/job/deleted/'.$id);

}

}
