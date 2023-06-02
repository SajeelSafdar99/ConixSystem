<?php

namespace App\Http\Controllers;

use App\hr_employment;
 use App\hr_reference_subs;
use Illuminate\Http\Request;
 
use Session;
use DataTables;

class HrReferenceSubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    

     public function indexdt(Request $request,$id, hr_employment $hr_reference_subs)
    {


        $hr_reference_subs = hr_employment::find($id)->references();

        return DataTables::of($hr_reference_subs)

          

             ->addColumn('editbutton', function ($hr_reference_subs) {

                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('human-resource/employment/reference-aeu/') . '/' . $hr_reference_subs->employee_id . '/' . $hr_reference_subs->id . '"><i class="fas fa-edit"></i></a></button>'

                ;
            })

       ->addColumn('deletebutton', function ($hr_reference_subs) {

                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/reference/delete/') . '/' . $hr_reference_subs->employee_id . '/' . $hr_reference_subs->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'

                ;
            })

 
            ->rawColumns(['editbutton', 'deletebutton'])
            ->addIndexColumn()
            ->make(true);
    }

 public function index_deleted(Request $request, hr_reference_subs $hr_reference_subs,$id)
    {
        $data['employee_data'] = hr_employment::where('id', $id)->first();
        return view('backend/human-resource/employment/reference-deleted', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function indexdt_deleted(Request $request,$id, hr_employment $hr_reference_subs)
    {

        $hr_reference_subs = hr_reference_subs::onlyTrashed()->get();
        return DataTables::of($hr_reference_subs)


        ->addColumn('restorebutton', function ($hr_reference_subs) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/reference/restore/') . '/' . $hr_reference_subs->employee_id . '/' . $hr_reference_subs->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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

     public function create(hr_reference_subs $hr_reference_subs,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = hr_reference_subs::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['ref_update'] = '';
        $data['employee_data'] = hr_employment::where('id', $id)->first();
 
        return view('backend/human-resource.employment.reference-aeu', $data);
    }

    public function store(Request $request,$id)
    {

        $save=$request->save;
        $this->validate($request, [

            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'years'=>'required',

            
          ]);

         $create=hr_reference_subs::create([
           'employee_id'=>$id,
           'name'=>$request->name,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'years'=>$request->years,

            ]);

       
            if($create)
            {
                Session::flash('message', 'Data Entered Successfully !');
                Session::flash('alert-class', 'alert-success');
                return redirect('human-resource/employment/reference-aeu/'.$id);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return redirect('human-resource/employment/reference-aeu/'.$id);

            }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function edit(hr_reference_subs $hr_reference_subs,$id,$refid)
    {
        $data['ref_update'] = hr_reference_subs::where('id', $refid)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['ref_update']->code;

     
$data['employee_data'] = hr_employment::where('id', $id)->first();


        return view('backend/human-resource.employment.reference-aeu', $data);
    }


    public function update(Request $request,$id,$refid)
    {

        $this->validate($request, [
           'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'years'=>'required',
          ]);



        $update = hr_reference_subs::where('id', $refid)->updateWithUserstamps([

            'name'=>$request->name,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'years'=>$request->years,
        ]);

       

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/employment/reference-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hr_reference_subs  $hr_reference_subs
     * @return \Illuminate\Http\Response
     */
    public function show(hr_reference_subs $hr_reference_subs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_reference_subs  $hr_reference_subs
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hr_reference_subs  $hr_reference_subs
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_reference_subs  $hr_reference_subs
     * @return \Illuminate\Http\Response
     */
    public function destroy(hr_reference_subs $hr_reference_subs,$id,$refid)
    {
        $delete=$hr_reference_subs::where('id', $refid)->deleteWithUserstamps();
        if($delete){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }

        return redirect('human-resource/employment/reference-aeu/'.$id);
    }


    public function restore(hr_reference_subs $hr_reference_subs,$id,$refid)
    {
        $restore = hr_reference_subs::onlyTrashed()->find($refid)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/reference/deleted/'.$id);

}

}
