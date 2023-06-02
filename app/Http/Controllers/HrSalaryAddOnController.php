<?php

namespace App\Http\Controllers;

use App\hr_salary_add_on;
use App\trans_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class HrSalaryAddOnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, hr_salary_add_on $hr_salary_add_on)
    {
        return view('backend/human-resource/salary-add-ons/salary-add-ons');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, hr_salary_add_on $hr_salary_add_on)
    {

        $table = hr_salary_add_on::get();
        return DataTables::of($table)
            ->addColumn('status', function ($table) {
                if ($table->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }
            })

            ->addColumn('trans_type', function ($table) {
                 if($table->trans_type){
                    return transTypesChargesTypes($table->trans_type);
                }
            })

            ->addColumn('editbutton', function ($table) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('human-resource/salary-add-ons/salary-add-ons-aeu/') . '/' . $table->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($table) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/salary-add-ons/delete') . '/' . $table->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, hr_salary_add_on $hr_salary_add_on)
    {
        return view('backend/human-resource/salary-add-ons/salary-add-ons-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, hr_salary_add_on $hr_salary_add_on)
    {

        $hr_salary_add_on = hr_salary_add_on::onlyTrashed()->get();
        return DataTables::of($hr_salary_add_on)

            ->addColumn('restorebutton', function ($hr_salary_add_on) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/salary-add-ons/restore/') . '/' . $hr_salary_add_on->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })



             ->addColumn('trans_type', function ($hr_salary_add_on) {
                 if($hr_salary_add_on->trans_type){
                    return transTypesChargesTypes($hr_salary_add_on->trans_type);
                }
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
        //Get the last record id and pass to the view
        $lastval = hr_salary_add_on::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['salary_update'] = '';

         $data['transtypes']=trans_type::all();

        return view('backend/human-resource.salary-add-ons.salary-add-ons-aeu', $data);
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
           
            'desc' => 'required|unique:hr_salary_add_ons,desc',
            'trans_type'   => 'required',
            'charges'   => 'required',
            'status'   => 'required']);

        $hr_salary_add_on = hr_salary_add_on::create([
         
            'desc'   => $request->desc,
            'trans_type'   => $request->trans_type,
            'charges'   => $request->charges,
            'status' => $request->status,

        ]);

        if($hr_salary_add_on) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('human-resource/salary-add-ons/salary-add-ons-aeu');
            }else{
                return redirect('human-resource/salary-add-ons');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hr_salary_add_on  $hr_salary_add_on
     * @return \Illuminate\Http\Response
     */
    public function show(hr_salary_add_on $hr_salary_add_on)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_salary_add_on  $hr_salary_add_on
     * @return \Illuminate\Http\Response
     */
  public function edit(hr_salary_add_on $hr_salary_add_on,$id)
    {
        $data['salary_update'] = hr_salary_add_on::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['salary_update']->code;

        $data['transtypes']=trans_type::all();

        return view('backend/human-resource.salary-add-ons.salary-add-ons-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hr_salary_add_on  $hr_salary_add_on
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:hr_salary_add_ons,desc,'.$id,
             'trans_type'   => 'required',
            'charges'   => 'required',
            'status'   => 'required']);

        $hr_salary_add_on = hr_salary_add_on::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
             'trans_type'   => $request->trans_type,
            'charges'   => $request->charges,
            'status' => $request->status,
        ]);

        if ($hr_salary_add_on) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/salary-add-ons/salary-add-ons-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_salary_add_on  $hr_salary_add_on
     * @return \Illuminate\Http\Response
     */

    public function destroy(hr_salary_add_on $hr_salary_add_on,$id)
    {
        $hr_salary_add_on=$hr_salary_add_on::where('id', $id)->deleteWithUserstamps();
        if($hr_salary_add_on){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('human-resource/salary-add-ons');
    }


    public function restore(hr_salary_add_on $hr_salary_add_on,$id)
    {
        $restore = hr_salary_add_on::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/salary-add-ons/deleted');

}

  function calculateextracharges($id){
      $charges=hr_salary_add_on::where('id',$id)->first();
      return $charges->charges;
    }


}