<?php

namespace App\Http\Controllers;

use App\event_venue;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class EventVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, event_venue $event_venue)
    {
        return view('backend/events-management/event-venue/event-venue');
    }


      public function indexdt(Request $request, event_venue $event_venue)
    {

        $event_venue = event_venue::get();
        return DataTables::of($event_venue)
            ->addColumn('status', function ($event_venue) {
                if ($event_venue->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

             ->addColumn('editbutton', function ($event_venue) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-venue/event-venue-aeu/') . '/' . $event_venue->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($event_venue) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/event-venue/delete') . '/' . $event_venue->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, event_venue $event_venue)
    {
        return view('backend/events-management/event-venue/event-venue-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_venue $event_venue)
    {

        $Event_venue = event_venue::onlyTrashed()->get();
        return DataTables::of($Event_venue)

            ->addColumn('restorebutton', function ($Event_venue) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/event-venue/restore/') . '/' . $Event_venue->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval = event_venue::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['event_venue_update'] = '';

        return view('backend/events-management.event-venue.event-venue-aeu', $data);
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
            'desc' => 'required|unique:event_venues,desc',
            'status'   => 'required']);

        $Event_venue = event_venue::create([
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if ($Event_venue) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/event-venue/event-venue-aeu');
            }else{
                return redirect('events-management/event-venue');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_venue  $event_venue
     * @return \Illuminate\Http\Response
     */
    public function show(event_venue $event_venue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_venue  $event_venue
     * @return \Illuminate\Http\Response
     */
    public function edit(event_venue $event_venue,$id)
    {
        $data['event_venue_update'] = event_venue::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['event_venue_update']->code;

        return view('backend/events-management.event-venue.event-venue-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_venue  $event_venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $this->validate($request, [
            'desc' => 'required|unique:event_venues,desc,'.$id,
            'status'   => 'required']);

        $event_venue = event_venue::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($event_venue) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/event-venue/event-venue-aeu/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_venue  $event_venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_venue $event_venue,$id)
    {
         $eventvenue=$event_venue::where('id', $id)->deleteWithUserstamps();
        if($eventvenue){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('events-management/event-venue');
    }

 public function restore(event_venue $event_venue,$id)
    {
        $restore = event_venue::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/event-venue/deleted');

}
}
