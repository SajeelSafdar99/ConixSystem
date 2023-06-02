<?php

namespace App\Http\Controllers;

use App\room_category;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;

class RoomCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room_category $room_category)
    {
        return view('backend/room-management/room-category/room-category');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function indexdt(Request $request, room_category $room_category)
    {

        $roomcategory = room_category::get();
        return DataTables::of($roomcategory)
            ->addColumn('status', function ($roomcategory) {
                if ($roomcategory->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($roomcategory) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-category/room-category-aeu/') . '/' . $roomcategory->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($roomcategory) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-category/delete') . '/' . $roomcategory->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
        ->addIndexColumn()
            ->make(true);
    }

 public function index_deleted(Request $request, room_category $room_category)
    {
        return view('backend/room-management/room-category/room-category-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, room_category $room_category)
    {

        $Room_categories = room_category::onlyTrashed()->get();
        return DataTables::of($Room_categories)

            ->addColumn('restorebutton', function ($Room_categories) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room-category/restore/') . '/' . $Room_categories->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        // //Get the last record id and pass to the view
        $lastval = room_category::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_category_update'] = '';

        return view('backend/room-management.room-category.room-category-aeu', $data);
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
            //'room_category_code'     => 'required',
            'desc' => 'required|unique:room_categories,desc',

            'status'   => 'required']);

        $Room_categories = room_category::create([
           // 'code'   => $request->room_category_code,
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if ($Room_categories) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('room-management/room-category/room-category-aeu');
            }else{
                return redirect('room-management/room-category');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_category  $room_category
     * @return \Illuminate\Http\Response
     */
    public function show(room_category $room_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_category  $room_category
     * @return \Illuminate\Http\Response
     */
    public function edit(room_category $room_category,$id)
    {
         $data['room_category_update'] = room_category::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_category_update']->code;

        return view('backend/room-management.room-category.room-category-aeu', $data);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_category  $room_category
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:room_categories,desc,'.$id,

            'status'   => 'required']);

        $roomcategories = room_category::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);
        $chargesnull= room_category::find($id)->chargesnull()->get();
   
       foreach($chargesnull as $charge){
        $charge->status=$request->status;
       $charge->save();
       }

        if ($roomcategories) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-category/room-category-aeu/'.$id);

    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_category  $room_category
     * @return \Illuminate\Http\Response
     */
    
     public function destroy(room_category $room_category, $id)
    {
        $roomcategories=$room_category::where('id', $id)->deleteWithUserstamps();
        if($roomcategories){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('room-management/room-category');
    }


 public function restore(room_category $room_category,$id)
    {
        $restore = room_category::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room-category/deleted');

}
}

