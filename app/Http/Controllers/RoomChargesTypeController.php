<?php

namespace App\Http\Controllers;

use App\room_charges_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class RoomChargesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room_charges_type $room_charges_type)
    {
        return view('backend/room-management/room-charges-type/room-charges-type');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt(Request $request, room_charges_type $room_charges_type)
    {

        $roomcharges = room_charges_type::get();
        return DataTables::of($roomcharges)
            ->addColumn('status', function ($roomcharges) {
                if ($roomcharges->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($roomcharges) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-charges-type/room-charges-type-aeu/') . '/' . $roomcharges->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($roomcharges) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-charges-type/delete') . '/' . $roomcharges->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }



 public function index_deleted(Request $request, room_charges_type $room_charges_type)
    {
        return view('backend/room-management/room-charges-type/room-charges-type-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, room_charges_type $room_charges_type)
    {

        $roomcharges = room_charges_type::onlyTrashed()->get();
        return DataTables::of($roomcharges)

            ->addColumn('restorebutton', function ($roomcharges) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room-charges-type/restore/') . '/' . $roomcharges->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }
 
    public function create()
    {
        // //Get the last record id and pass to the view
        $lastval = room_charges_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_charges_update'] = '';

        return view('backend/room-management.room-charges-type.room-charges-type-aeu', $data);
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
          //  'room_charges_code'     => 'required',
            'type' => 'required|unique:room_charges_types,type',
            'charges' => 'required',
            'status'   => 'required']);

        $Room_charges_type = room_charges_type::create([
          //  'code'   => $request->room_charges_code,
            'type'   => $request->type,
            'charges'   => $request->charges,
            'status' => $request->status,

        ]);

        if ($Room_charges_type) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('room-management/room-charges-type/room-charges-type-aeu');
            }else{
                return redirect('room-management/room-charges-type');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\room_charges_type  $room_charges_type
     * @return \Illuminate\Http\Response
     */
    public function show(room_charges_type $room_charges_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_charges_type  $room_charges_type
     * @return \Illuminate\Http\Response
     */
    public function edit(room_charges_type $room_charges_type,$id)
    {
         $data['room_charges_update'] = room_charges_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_charges_update']->code;

        return view('backend/room-management.room-charges-type.room-charges-type-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_charges_type  $room_charges_type
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|unique:room_charges_types,type,'.$id,
            'charges' => 'required',
            'status'   => 'required']);

        $room_charges = room_charges_type::where('id', $id)->updateWithUserstamps([
            'type'   => $request->type,
            'charges'   => $request->charges,
            'status' => $request->status,
        ]);

        if ($room_charges) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-charges-type/room-charges-type-aeu/'.$id);

    }
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_charges_type  $room_charges_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(room_charges_type $room_charges_type, $id)
    {
        $roomchargestype=$room_charges_type::where('id', $id)->deleteWithUserstamps();
        if($roomchargestype){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('room-management/room-charges-type');
    }
  
 public function restore(room_charges_type $room_charges_type,$id)
    {
        $restore = room_charges_type::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room-charges-type/deleted');

}
}

