<?php

namespace App\Http\Controllers;

use App\hr_employment;
 use App\hr_education_subs;
use Illuminate\Http\Request;
 
use Session;
use DataTables;

class HrEmployeeEducation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

     public function indexdt(Request $request,$id, hr_employment $hr_education_subs)
    {


        $hr_education_subs = hr_employment::find($id)->education();

        return DataTables::of($hr_education_subs)

          

             ->addColumn('editbutton', function ($hr_education_subs) {

                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('human-resource/employment/education-aeu/') . '/' . $hr_education_subs->employee_id . '/' . $hr_education_subs->id . '"><i class="fas fa-edit"></i></a></button>'

                ;
            })

       ->addColumn('deletebutton', function ($hr_education_subs) {

                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/education/delete/') . '/' . $hr_education_subs->employee_id . '/' . $hr_education_subs->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'

                ;
            })

 
            ->rawColumns(['editbutton', 'deletebutton'])
            ->addIndexColumn()
            ->make(true);
    }

 public function index_deleted(Request $request, hr_education_subs $hr_education_subs,$id)
    {
        $data['employee_data'] = hr_employment::where('id', $id)->first();
        return view('backend/human-resource/employment/education-deleted', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function indexdt_deleted(Request $request,$id, hr_employment $hr_education_subs)
    {

        $hr_education_subs = hr_education_subs::onlyTrashed()->get();
        return DataTables::of($hr_education_subs)


        ->addColumn('restorebutton', function ($hr_education_subs) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/education/restore/') . '/' . $hr_education_subs->employee_id . '/' . $hr_education_subs->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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

     public function create(hr_education_subs $hr_education_subs,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = hr_education_subs::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['edu_update'] = '';
        $data['employee_data'] = hr_employment::where('id', $id)->first();
 
        return view('backend/human-resource.employment.education-aeu', $data);
    }

    public function store(Request $request,$id)
    {

        $save=$request->save;
        $this->validate($request, [

            'level_of_education'=>'required',
            'institute'=>'required',
            'course'=>'required',
            'years'=>'required',
            'type'=>'required',
            
          ]);

         $education=hr_education_subs::create([
           'employee_id'=>$id,
           'level_of_education'=>$request->level_of_education,
            'institute'=>$request->institute,
            'course'=>$request->course,

            'years'=>$request->years,
            'type'=>$request->type,

            ]);

       
            if($education)
            {
                Session::flash('message', 'Data Entered Successfully !');
                Session::flash('alert-class', 'alert-success');
                return redirect('human-resource/employment/education-aeu/'.$id);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return redirect('human-resource/employment/education-aeu/'.$id);

            }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function edit(hr_education_subs $hr_education_subs,$id,$educationid)
    {
        $data['edu_update'] = hr_education_subs::where('id', $educationid)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['edu_update']->code;

     
$data['employee_data'] = hr_employment::where('id', $id)->first();


        return view('backend/human-resource.employment.education-aeu', $data);
    }


    public function update(Request $request,$id,$educationid)
    {

        $this->validate($request, [
                 'level_of_education'=>'required',
            'institute'=>'required',
            'course'=>'required',
            'years'=>'required',
            'type'=>'required',
          ]);



        $education = hr_education_subs::where('id', $educationid)->updateWithUserstamps([

           'level_of_education'=>$request->level_of_education,
            'institute'=>$request->institute,
            'course'=>$request->course,

            'years'=>$request->years,
            'type'=>$request->type,
        ]);

       

        if ($education) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/employment/education-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hr_education_subs  $hr_education_subs
     * @return \Illuminate\Http\Response
     */
    public function show(hr_education_subs $hr_education_subs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_education_subs  $hr_education_subs
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hr_education_subs  $hr_education_subs
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_education_subs  $hr_education_subs
     * @return \Illuminate\Http\Response
     */
    public function destroy(hr_education_subs $hr_education_subs,$id,$educationid)
    {
        $education=$hr_education_subs::where('id', $educationid)->deleteWithUserstamps();
        if($education){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }

        return redirect('human-resource/employment/education-aeu/'.$id);
    }


    public function restore(hr_education_subs $hr_education_subs,$id,$educationid)
    {
        $restore = hr_education_subs::onlyTrashed()->find($educationid)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/education/deleted/'.$id);

}

}
