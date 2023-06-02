<?php

namespace App\Http\Controllers;

use App\event_charges_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class EventChargesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, event_charges_type $event_charges_type)
    {
        return view('backend/events-management/event-charges-type/event-charges-type');
    }



    public function indexdt(Request $request, event_charges_type $event_charges_type)
    {

        $eventcharges = event_charges_type::get();
        return DataTables::of($eventcharges)
            ->addColumn('status', function ($eventcharges) {
                if ($eventcharges->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($eventcharges) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-charges-type/event-charges-type-aeu/') . '/' . $eventcharges->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($eventcharges) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/event-charges-type/delete') . '/' . $eventcharges->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton','status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, event_charges_type $event_charges_type)
    {
        return view('backend/events-management/event-charges-type/event-charges-type-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_charges_type $event_charges_type)
    {

        $Event_charges_type = event_charges_type::onlyTrashed()->get();
        return DataTables::of($Event_charges_type)

            ->addColumn('restorebutton', function ($Event_charges_type) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/event-charges-type/restore/') . '/' . $Event_charges_type->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        // //Get the last record id and pass to the view
        $lastval = event_charges_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['event_charges_update'] = '';

        return view('backend/events-management.event-charges-type.event-charges-type-aeu', $data);
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
           // 'event_charges_code'     => 'required',
            'type' => 'required|unique:event_charges_types,type',
            'charges' => 'required',
            'status'   => 'required']);

        $Event_charges_type = event_charges_type::create([
           // 'code'   => $request->event_charges_code,
            'type'   => $request->type,
            'charges'   => $request->charges,
            'status' => $request->status,

        ]);

        if ($Event_charges_type) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/event-charges-type/event-charges-type-aeu');
            }else{
                return redirect('events-management/event-charges-type');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_charges_type  $event_charges_type
     * @return \Illuminate\Http\Response
     */
    public function show(event_charges_type $event_charges_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_charges_type  $event_charges_type
     * @return \Illuminate\Http\Response
     */
    public function edit(event_charges_type $event_charges_type,$id)
    {
         $data['event_charges_update'] = event_charges_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['event_charges_update']->code;

        return view('backend/events-management.event-charges-type.event-charges-type-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_charges_type  $event_charges_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'type' => 'required|unique:event_charges_types,type,'.$id,
            'charges' => 'required',
            'status'   => 'required']);

        $event_charges = event_charges_type::where('id', $id)->updateWithUserstamps([
            'type'   => $request->type,
            'charges'   => $request->charges,
            'status' => $request->status,
        ]);

        if ($event_charges) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/event-charges-type/event-charges-type-aeu/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_charges_type  $event_charges_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_charges_type $event_charges_type,$id)
    {
        $eventchargestype=$event_charges_type::where('id', $id)->deleteWithUserstamps();
        if($eventchargestype){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('events-management/event-charges-type');
    }

 public function restore(event_charges_type $event_charges_type,$id)
    {
        $restore = event_charges_type::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/event-charges-type/deleted');

}
}
