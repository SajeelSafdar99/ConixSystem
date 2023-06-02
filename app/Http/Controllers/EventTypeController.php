<?php

namespace App\Http\Controllers;

use App\event_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index(Request $request, event_type $event_type)
    {
        return view('backend/events-management/menu-type/menu-type');
    }


      public function indexdt(Request $request, event_type $event_type)
    {

        $event_types = event_type::get();
        return DataTables::of($event_types)
            ->addColumn('status', function ($event_types) {
                if ($event_types->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })


            ->addColumn('editbutton', function ($event_types) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/menu-type/menu-type-aeu/') . '/' . $event_types->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($event_types) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/menu-type/delete') . '/' . $event_types->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


    public function index_deleted(Request $request, event_type $event_type)
    {
        return view('backend/events-management/menu-type/menu-type-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_type $event_type)
    {

        $Event_Type = event_type::onlyTrashed()->get();
        return DataTables::of($Event_Type)

            ->addColumn('restorebutton', function ($Event_Type) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/menu-type/restore/') . '/' . $Event_Type->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval = event_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['event_type_update'] = '';

        return view('backend/events-management.menu-type.menu-type-aeu', $data);
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
            //'code'     => 'required',
            'desc' => 'required|unique:event_types,desc',
            'status'   => 'required']);

        $Event_Type = event_type::create([
           // 'code'   => $request->code,
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if ($Event_Type) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/menu-type/menu-type-aeu');
            }else{
                return redirect('events-management/menu-type');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_type  $event_type
     * @return \Illuminate\Http\Response
     */
    public function show(event_type $event_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_type  $event_type
     * @return \Illuminate\Http\Response
     */
    public function edit(event_type $event_type,$id)
    {
         $data['event_type_update'] = event_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['event_type_update']->code;

        return view('backend/events-management.menu-type.menu-type-aeu', $data);
    } 
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_type  $event_type
     * @return \Illuminate\Http\Response
     */
   
     public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:event_types,desc,'.$id,
            'status'   => 'required']);

        $event_type = event_type::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($event_type) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/menu-type/menu-type-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_type  $event_type
     * @return \Illuminate\Http\Response
     */
     public function destroy(event_type $event_type,$id)
    {
        $eventtype=$event_type::where('id', $id)->deleteWithUserstamps();
        if($eventtype){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('events-management/menu-type');
    }


    public function restore(event_type $event_type,$id)
    {
        $restore = event_type::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/menu-type/deleted');

}
}
