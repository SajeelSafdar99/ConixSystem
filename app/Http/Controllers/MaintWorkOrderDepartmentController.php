<?php

namespace App\Http\Controllers;

use App\maint_work_order_department;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class MaintWorkOrderDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, maint_work_order_department $maint_work_order_department)
    {
        return view('backend/maintenance-management/work-order-departments/work-order-departments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexdt(Request $request, maint_work_order_department $maint_work_order_department)
    {

        $table = maint_work_order_department::get();
        return DataTables::of($table)
            ->addColumn('status', function ($table) {
                if ($table->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($table) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('maintenance-management/work-order-departments/work-order-departments-aeu/') . '/' . $table->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($table) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('maintenance-management/work-order-departments/delete') . '/' . $table->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, maint_work_order_department $maint_work_order_department)
    {
        return view('backend/maintenance-management/work-order-departments/work-order-departments-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, maint_work_order_department $maint_work_order_department)
    {

        $maint_work_order_department = maint_work_order_department::onlyTrashed()->get();
        return DataTables::of($maint_work_order_department)

            ->addColumn('restorebutton', function ($maint_work_order_department) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('maintenance-management/work-order-departments/restore/') . '/' . $maint_work_order_department->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval = maint_work_order_department::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['dep_update'] = '';

        return view('backend/maintenance-management.work-order-departments.work-order-departments-aeu', $data);
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
           
            'desc' => 'required|unique:maint_work_order_departments,desc',
            'status'   => 'required']);

        $maint_work_order_department = maint_work_order_department::create([
         
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if($maint_work_order_department) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('maintenance-management/work-order-departments/work-order-departments-aeu');
            }else{
                return redirect('maintenance-management/work-order-departments');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\maint_work_order_department  $maint_work_order_department
     * @return \Illuminate\Http\Response
     */
    public function show(maint_work_order_department $maint_work_order_department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\maint_work_order_department  $maint_work_order_department
     * @return \Illuminate\Http\Response
     */
  public function edit(maint_work_order_department $maint_work_order_department,$id)
    {
         $data['dep_update'] = maint_work_order_department::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['dep_update']->code;

        return view('backend/maintenance-management.work-order-departments.work-order-departments-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\maint_work_order_department  $maint_work_order_department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:maint_work_order_departments,desc,'.$id,
            'status'   => 'required']);

        $maint_work_order_department = maint_work_order_department::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($maint_work_order_department) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('maintenance-management/work-order-departments/work-order-departments-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\maint_work_order_department  $maint_work_order_department
     * @return \Illuminate\Http\Response
     */

    public function destroy(maint_work_order_department $maint_work_order_department,$id)
    {
        $maint_work_order_department=$maint_work_order_department::where('id', $id)->deleteWithUserstamps();
        if($maint_work_order_department){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('maintenance-management/work-order-departments');
    }


    public function restore(maint_work_order_department $maint_work_order_department,$id)
    {
        $restore = maint_work_order_department::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('maintenance-management/work-order-departments/deleted');

}

}