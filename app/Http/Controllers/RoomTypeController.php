<?php

namespace App\Http\Controllers;

use App\room_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room_type $room_type)
    {
        return view('backend/room-management/room-type/room-type');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function indexdt(Request $request, room_type $room_type)
    {

        $room_types = room_type::get();
        return DataTables::of($room_types)
            ->addColumn('status', function ($room_types) {
                if ($room_types->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($room_types) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-type/room-type-aeu/') . '/' . $room_types->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($room_types) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-type/delete') . '/' . $room_types->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

 public function index_deleted(Request $request, room_type $room_type)
    {
        return view('backend/room-management/room-type/room-type-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, room_type $room_type)
    {

        $Room_Type = room_type::onlyTrashed()->get();
        return DataTables::of($Room_Type)

            ->addColumn('restorebutton', function ($Room_Type) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room-type/restore/') . '/' . $Room_Type->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }
    
    public function create()
    {
        //Get the last record id and pass to the view
        $lastval = room_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_type_update'] = '';

        return view('backend/room-management.room-type.room-type-aeu', $data);
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
           // 'code'     => 'required',
            'desc' => 'required|unique:room_types,desc',
            'status'   => 'required']);

        $Room_Type = room_type::create([
           // 'code'   => $request->code,
            'desc'   => $request->desc,
              'account'=>$request->account,
            'status' => $request->status,

        ]);

        if ($Room_Type) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('room-management/room-type/room-type-aeu');
            }else{
                return redirect('room-management/room-type');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function show(room_type $room_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function edit(room_type $room_type,$id)
    {
         $data['room_type_update'] = room_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_type_update']->code;

        return view('backend/room-management.room-type.room-type-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:room_types,desc,'.$id,
            'status'   => 'required']);

        $room_type = room_type::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
              'account'=>$request->account,
            'status' => $request->status,
        ]);
       $rooms= room_type::find($id)->rooms()->get();
   
       foreach($rooms as $room){
        $room->status=$request->status;
       $room->save();
       }

        if ($room_type) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-type/room-type-aeu/'.$id);

    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(room_type $room_type,$id)
    {
        $roomtype=$room_type::where('id', $id)->deleteWithUserstamps();
        if($roomtype){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('room-management/room-type');
    }


    public function restore(room_type $room_type,$id)
    {
        $restore = room_type::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room-type/deleted');

}

}
