<?php

namespace App\Http\Controllers;

use App\hr_company;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class HrCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, hr_company $hr_company)
    {
        return view('backend/human-resource/companies/companies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, hr_company $hr_company)
    {

        $hr_companies = hr_company::get();
        return DataTables::of($hr_companies)
            ->addColumn('status', function ($hr_companies) {
                if ($hr_companies->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($hr_companies) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('human-resource/companies/companies-aeu/') . '/' . $hr_companies->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($hr_companies) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/companies/delete') . '/' . $hr_companies->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, hr_company $hr_company)
    {
        return view('backend/human-resource/companies/companies-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, hr_company $hr_company)
    {

        $hr_company = hr_company::onlyTrashed()->get();
        return DataTables::of($hr_company)

            ->addColumn('restorebutton', function ($hr_company) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/companies/restore/') . '/' . $hr_company->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
    public function create()
    {
        //Get the last record id and pass to the view
        $lastval = hr_company::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['companies_update'] = '';

        return view('backend/human-resource.companies.companies-aeu', $data);
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
           
            'desc' => 'required|unique:hr_companies,desc',
            'status'   => 'required']);

        $hr_company = hr_company::create([
         
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if($hr_company) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('human-resource/companies/companies-aeu');
            }else{
                return redirect('human-resource/companies');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hr_company  $hr_company
     * @return \Illuminate\Http\Response
     */
    public function show(hr_company $hr_company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_company  $hr_company
     * @return \Illuminate\Http\Response
     */
  public function edit(hr_company $hr_company,$id)
    {
         $data['companies_update'] = hr_company::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['companies_update']->code;

        return view('backend/human-resource.companies.companies-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hr_company  $hr_company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:hr_companies,desc,'.$id,
            'status'   => 'required']);

        $hr_company = hr_company::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($hr_company) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/companies/companies-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_company  $hr_company
     * @return \Illuminate\Http\Response
     */

    public function destroy(hr_company $hr_company,$id)
    {
        $hr_company=$hr_company::where('id', $id)->deleteWithUserstamps();
        if($hr_company){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('human-resource/companies');
    }


    public function restore(hr_company $hr_company,$id)
    {
        $restore = hr_company::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/companies/deleted');

}

}