<?php

namespace App\Http\Controllers;

use App\room;

use DataTables;
use Illuminate\Http\Request;
use App\room_type;
use App\room_category;
use App\fnb_table_definition;
use App\fnb_restaurant_location;
use Session;
use App\room_category_charges;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function mapping_vue(Request $request, room $room)
    {
       return view('backend/room-management/room/room-table-mapping-vue');
    }

    public function mapping_init_vue(Request $request)
    {
$data['bookings'] =\Illuminate\Support\Facades\DB::select(
      'select rooms.*, 
        room_types.desc as roomtype,
        fnb_table_definitions.desc as tabledef

from rooms

left outer join room_types on room_types.id =rooms.room_type and room_types.status=1 and room_types.deleted_at is null
left outer join fnb_table_definitions on fnb_table_definitions.id = rooms.table_definition and fnb_table_definitions.status=1 and fnb_table_definitions.deleted_at is null

where rooms.deleted_at is null group by rooms.id order by rooms.id desc');

     return $data;
}



    public function index(Request $request, room $room)
    {
        return view('backend/room-management/room/room');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function indexdt(Request $request, room $room)
    {

        $var_room = room::with('roomtypes')->get();

        return DataTables::of($var_room)
            ->addColumn('status', function ($var_room) {
                if ($var_room->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }
               })

               ->addColumn('room_type', function ($var_room) {

                $roomsname=room_type::where('id',$var_room->room_type)->get();
                  return $roomsname[0]['desc'];


                })

            ->addColumn('editbutton', function ($var_room) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room/room-aeu/') . '/' . $var_room->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($var_room) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room/delete') . '/' . $var_room->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

           
            ->rawColumns(['editbutton','deletebutton', 'status','room_type','room_category', 'room_category_charges'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, room $room)
    {
        return view('backend/room-management/room/room-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, room $room)
    {

        $Rooms = room::onlyTrashed()->get();
        return DataTables::of($Rooms)

            ->addColumn('restorebutton', function ($Rooms) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room/restore/') . '/' . $Rooms->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }


    public function create()
    {
         // //Get the last record id and pass to the view
        $lastval = room::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_update'] = '';
        $data['room_type']=room_type::where('status',1)->get();
        $data['room_category']=room_category::where('status',1)->get();
        $data['room_category_charges']=room_category_charges::where('status',1)->get();


        return view('backend/room-management.room.room-aeu', $data);
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
           // 'room_code'     => 'required',
            'room_no' => 'required|unique:rooms,room_no',
            'room_type' => 'required',
            'status'   => 'required',
            'room_category_id' => 'required',
            'charges' => 'required'
        ]);

        $Rooms = room::create([
          //  'code'   => $request->room_code,
            'room_no'   => $request->room_no,
            'room_type'=> $request->room_type,
            'status' => $request->status

        ]);

        $categories=$request->room_category_id;
        $charges=$request->charges;

          $i=0;
        foreach ($categories as $cat => $cat_val) {

            $ta = new room_category_charges;
            $ta->room_category_id = $cat_val;
            $ta->room_id = $Rooms->id;
            $ta->charges = $charges[$i];
            $ta->save();
            $i++;
        }

        if ($Rooms) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('room-management/room/room-aeu');
            }else{
                return redirect('room-management/room');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */

     public function edit(room $room,$id)
    {
        $data['room_update'] = room::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_update']->code;

        $data['room_type']=room_type::where('status',1)->get();
        $data['room_category']=room_category::get();
        $categorycharges=room_category_charges::where('room_id',$id)->select('room_category_id')->get();
       //dd($categorycharges);
        $data['roomscateg']=room_category::where('status',1)->whereNotIn('id',$categorycharges)->get();

        $data['room_category_charges']=room_category_charges::where('status',1)->get();

        $roomcat=room::with('categorywithchanges.roomtypes')->where('id',$id)->get();
        $data['roomswithcat']=$roomcat[0]['categorywithchanges'];

        return view('backend/room-management.room.room-aeu', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */
      public function update(Request $request, $id)
    {


        $this->validate($request, [
            'room_no' => 'required|unique:rooms,room_no,'.$id,

             'room_type' => 'required',
            'status'   => 'required',
            'charges' => 'required',
            'category_charges_id'=> 'required'

        ]);

        $rooms = room::where('id', $id)->updateWithUserstamps([
            'room_no'   => $request->room_no,
            'room_type'   => $request->room_type,
            'status' => $request->status,
        ]);


          $chargesid=$request->category_charges_id;
        $charges=$request->charges;
          $i=0;
        foreach ($charges as $charge => $char_val) {

            room_category_charges::where('id', $chargesid[$i])->updateWithUserstamps([
            'charges'   => $char_val,
            ]);
           $i++;
        }

        if($request->newcharges){

        $categories=$request->newroom_category_id;
        $charges=$request->newcharges;

          $i=0;
        foreach ($categories as $cat => $cat_val) {

            $ta = new room_category_charges;
            $ta->room_category_id = $cat_val;
            $ta->room_id = $id;
            $ta->charges = $charges[$i];
            $ta->save();
            $i++;
        }

        }


        if ($rooms) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room/room-aeu/'.$id);

    }


      public function mapping_edit(room $room, $id)
    {

         $data['room_update'] = room::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_update']->code;

     
     if($data['room_update'] && $data['room_update']->table_definition){
        $mmm=fnb_table_definition::where('id',$data['room_update']->table_definition)->pluck('restaurant_location');
        $data['selected_rest']=$mmm[0];
     }
     else {
        $data['selected_rest']='';
     }


        $data['table_defs']= fnb_table_definition::where('status',1)->get();
        $data['restaurants']= fnb_restaurant_location::where('status',1)->get();

         return view('backend/room-management.room.room-table-mapping-aeu',$data);
    }

  public function mapping_update(Request $request, $id)
    {

  $this->validate($request, [
            'room_no' => 'required',

             'table_definition' => 'required',

        ]);

      $update = room::where('id',$id)->updateWithUserstamps([
            'table_definition'=>  $request->table_definition,
        ]);
   
        if ($update) {
            Session::flash('message', 'Linked Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Linkage Was Unsuccessful!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-table-mapping/room-table-mapping-aeu/'.$id);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room  $room
     * @return \Illuminate\Http\Response
     */
      public function destroy(room $room, $id)
    {
        $var_rooms=$room::where('id', $id)->deleteWithUserstamps();
        if($var_rooms){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('room-management/room');
    }

 public function restore(room $room,$id)
    {
        $restore = room::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room/deleted');

}

}


