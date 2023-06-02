<?php

namespace App\Http\Controllers;

use App\event_menu_add_on;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class EventMenuAddOnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, event_menu_add_on $event_menu_add_on)
    {
        return view('backend/events-management/menu-add-ons/menu-add-ons');
    }

     public function indexdt(Request $request, event_menu_add_on $event_menu_add_on)
    {

        $eventcharges = event_menu_add_on::get();
        return DataTables::of($eventcharges)
            ->addColumn('status', function ($eventcharges) {
                if ($eventcharges->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($eventcharges) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/menu-add-ons/menu-add-ons-aeu/') . '/' . $eventcharges->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($eventcharges) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/menu-add-ons/delete') . '/' . $eventcharges->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton','status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, event_menu_add_on $event_menu_add_on)
    {
        return view('backend/events-management/menu-add-ons/menu-add-ons-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_menu_add_on $event_menu_add_on)
    {

        $event_menu_add_on = event_menu_add_on::onlyTrashed()->get();
        return DataTables::of($event_menu_add_on)

            ->addColumn('restorebutton', function ($event_menu_add_on) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/menu-add-ons/restore/') . '/' . $event_menu_add_on->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval = event_menu_add_on::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['menu_addon_update'] = '';

        return view('backend/events-management.menu-add-ons.menu-add-ons-aeu', $data);
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
          
            'desc' => 'required|unique:event_menu_add_ons,desc',
            'charges' => 'required',
            'status'   => 'required']);

        $event_menu_add_on = event_menu_add_on::create([
         
            'desc'   => $request->desc,
            'charges'   => $request->charges,
            'status' => $request->status,

        ]);

        if ($event_menu_add_on) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/menu-add-ons/menu-add-ons-aeu');
            }else{
                return redirect('events-management/menu-add-ons');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\event_menu_add_on  $event_menu_add_on
     * @return \Illuminate\Http\Response
     */
    public function edit(event_menu_add_on $event_menu_add_on,$id)
    {
         $data['menu_addon_update'] = event_menu_add_on::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['menu_addon_update']->code;

        return view('backend/events-management.menu-add-ons.menu-add-ons-aeu', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_menu_add_on  $event_menu_add_on
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_menu_add_on  $event_menu_add_on
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request,$id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:event_menu_add_ons,desc,'.$id,
            'charges' => 'required',
            'status'   => 'required']);

        $event_menu_add_on = event_menu_add_on::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'charges'   => $request->charges,
            'status' => $request->status,
        ]);

        if ($event_menu_add_on) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/menu-add-ons/menu-add-ons-aeu/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_menu_add_on  $event_menu_add_on
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_menu_add_on $event_menu_add_on,$id)
    {
        $destroy=$event_menu_add_on::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('events-management/menu-add-ons');
    }

 public function restore(event_menu_add_on $event_menu_add_on,$id)
    {
        $restore = event_menu_add_on::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/menu-add-ons/deleted');

}
}