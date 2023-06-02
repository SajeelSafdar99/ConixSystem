<?php

namespace App\Http\Controllers;

use App\event_menu;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;
use App\event_type;
use App\event_menus_subs;
use App\event_rate_category;

class EventMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, event_menu $event_menu)
    {
        return view('backend/events-management/menus/menus');
    }


      public function indexdt(Request $request, event_menu $event_menu)
    {

        $event_menu = event_menu::get();
        return DataTables::of($event_menu)
            ->addColumn('status', function ($event_menu) {
                if ($event_menu->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

             ->addColumn('menu_type', function ($event_menu) {
              return menutype($event_menu->menu_type);


                })

             ->addColumn('editbutton', function ($event_menu) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/menus/menus-aeu/') . '/' . $event_menu->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($event_menu) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/menus/delete') . '/' . $event_menu->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status', 'menu_type'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, event_menu $event_menu)
    {
        return view('backend/events-management/menus/menus-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, event_menu $event_menu)
    {

        $Event_venue = event_menu::onlyTrashed()->get();
        return DataTables::of($Event_venue)

            ->addColumn('restorebutton', function ($Event_venue) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/menus/restore/') . '/' . $Event_venue->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

             ->addColumn('menu_type', function ($event_menu) {
              return menutype($event_menu->menu_type);


                })

        ->rawColumns(['restorebutton', 'menu_type'])
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
        $lastval = event_menu::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['menus_update'] = '';
  $data['menutypes']=event_type::where('status',1)->get();
  $data['menu_category']=event_rate_category::where('status',1)->get();

        return view('backend/events-management.menus.menus-aeu', $data);
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
            'menu_name' => 'required|unique:event_menus,menu_name',
            //'menu_type' => 'required',
            'total' => 'required',
            'status'   => 'required'
        ]);

        $event_menu = event_menu::create([
          
            'menu_name'   => $request->menu_name,
            //'menu_type'   => $request->menu_type,
            'total'   => $request->total,
            'status' => $request->status,

        ]);


         $items=$request->item_name;
         $charges=$request->item_charges;
    
          $i=0;
        foreach ($items as $item => $event_item) {

            $ta = new event_menus_subs;
            $ta->menu_id = $event_menu->id;
             $ta->item_charges = $charges[$i];
            $ta->item_name=$items[$i];
            $ta->save();
            $i++;
        }

        if ($event_menu) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('events-management/menus/menus-aeu');
            }else{
                return redirect('events-management/menus');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_menu  $event_menu
     * @return \Illuminate\Http\Response
     */
    public function show(event_menu $event_menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_menu  $event_menu
     * @return \Illuminate\Http\Response
     */
    public function edit(event_menu $event_menu,$id)
    {
        $data['menus_update'] = event_menu::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['menus_update']->code;

        $data['eventsub']=event_menu::with('menus')->where('id', $id)->get();
        $data['eventsubdata']=$data['eventsub'][0]['menus'];
  $data['menutypes']=event_type::where('status',1)->get();
  $data['menu_category']=event_rate_category::where('status',1)->get();

        return view('backend/events-management.menus.menus-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_menu  $event_menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $this->validate($request, [
           'menu_name' => 'required|unique:event_menus,menu_name,'.$id,
           //'menu_type' => 'required',
            'total' => 'required',
            'status'   => 'required'
        ]);

        $event_menu = event_menu::where('id', $id)->updateWithUserstamps([
           'menu_name'   => $request->menu_name,
           //'menu_type'   => $request->menu_type,
            'total'   => $request->total,
            'status' => $request->status,
        ]);

$eventdelete= event_menus_subs::where('menu_id', $id)->delete();
if($eventdelete){

         $items=$request->item_name;
         $charges=$request->item_charges;
    
          $i=0;
        foreach ($items as $item => $event_item) {

            $ta = new event_menus_subs;
            $ta->menu_id = $id;
             $ta->item_charges = $charges[$i];
            $ta->item_name=$items[$i];
            $ta->save();
            $i++;
        }
    }

        if ($event_menu) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('events-management/menus/menus-aeu/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_menu  $event_menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_menu $event_menu,$id)
    {
         $eventvenue=$event_menu::where('id', $id)->deleteWithUserstamps();
        if($eventvenue){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('events-management/menus');
    }

 public function restore(event_menu $event_menu,$id)
    {
        $restore = event_menu::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('events-management/menus/deleted');

}
}
