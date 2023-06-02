<?php

namespace App\Http\Controllers;

use App\mem_car;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\membership;

class MemCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


     public function indexdt(Request $request,$id, mem_car $mem_car)
    {

        $cars = membership::find($id)->cars();

        return DataTables::of($cars)

             ->addColumn('editbutton', function ($mem_car) {

                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('club-hospitality/membership/cars-aeu/') . '/' . $mem_car->member_id . '/' . $mem_car->id . '"><i class="fas fa-edit"></i></a></button>'

                ;
            }) 

       ->addColumn('deletebutton', function ($mem_car) {

                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/cars/delete/') . '/' . $mem_car->member_id . '/' . $mem_car->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'

                ;
            })


            ->rawColumns(['editbutton', 'deletebutton'])
            ->addIndexColumn()
            ->make(true);
    }


    public function index_deleted(Request $request, mem_car $mem_car,$id)
    {
        $data['membershipdata'] = membership::where('id', $id)->first();
        return view('backend/club-hospitality/membership/cars-deleted', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request,$id, membership $mem_car)
    {

        $cars = mem_car::onlyTrashed()->get();
        return DataTables::of($cars)

            ->addColumn('restorebutton', function ($mem_car) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/cars/restore/') . '/' . $mem_car->member_id . '/' . $mem_car->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
 public function create(mem_car $mem_car,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = mem_car::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['cars_update'] = '';
        $data['membershipdata'] = membership::where('id', $id)->first();
    
     return view('backend/club-hospitality.membership.cars-aeu', $data);
       
        
    }

     public function edit(mem_car $mem_car,$id,$carsid)
    {
        $data['cars_update'] = mem_car::where('id', $carsid)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['cars_update'];
        $data['membershipdata'] = membership::where('id', $id)->first();
        //dd($data);
        return view('backend/club-hospitality.membership.cars-aeu', $data);
    }


     public function store(Request $request,$id)
    {
        $save=$request->save;
         $this->validate($request, [

           'name'=>'required',
            //'familyforcar'=>'required',
            'membership_number'=>'required',
           // 'contactforcar'=>'required',
            // 'addressforcar'=>'required',
            'owner_name'=>'required',
             'owner_cnic'=>'required',
            'car_makeover'=>'required',
             'car_model'=>'required',
            'car_color'=>'required',
             'car_no'=>'required',
            'engine_no'=>'required',
             'chassis_no'=>'required',
             'sticker_no'=>'required',
             'sticker_status'=>'required',
            'driver_name'=>'required',
             'driver_cnic'=>'required',
            'driver_relation'=>'required',
            // 'car_remarks'=>'required'
          ]);
         $member_car=mem_car::create([
            'member_id'=>$id,
            'name'=>$request->name,
            'familyforcar'=>$request->familyforcar,
            'membership_number'=>$request->membership_number,
            'contactforcar'=>$request->contactforcar,
             'addressforcar'=>$request->addressforcar,
            'owner_name'=>$request->owner_name,
             'owner_cnic'=>$request->owner_cnic,
            'car_makeover'=>$request->car_makeover,
             'car_model'=>$request->car_model,
            'car_color'=>$request->car_color,
             'car_no'=>$request->car_no,
            'engine_no'=>$request->engine_no,
             'chassis_no'=>$request->chassis_no,
             'sticker_no'=>$request->sticker_no,
             'sticker_issue_date'=>formatDate($request->sticker_issue_date),
             'sticker_exp_date'=> formatDate($request->sticker_exp_date),
             'sticker_status'=>$request->sticker_status,
            'driver_name'=>$request->driver_name,
             'driver_cnic'=>$request->driver_cnic,
            'driver_relation'=>$request->driver_relation,
             'car_remarks'=>$request->car_remarks

            ]);


            if($member_car)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
                /*$memid=$member_car->id;
                $lastrec=mem_car::where('id',$memid)->first();*/
                
                return redirect('club-hospitality/membership/cars-aeu/'.$id);
           
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
               return redirect('club-hospitality/membership/cars-aeu/'.$id);
            }


    }

  public function update(Request $request,$id,$carsid)
    {
        $this->validate($request, [
             'name'=>'required',
           // 'familyforcar'=>'required',
            'membership_number'=>'required',
           // 'contactforcar'=>'required',
           //  'addressforcar'=>'required',
            'owner_name'=>'required',
             'owner_cnic'=>'required',
            'car_makeover'=>'required',
             'car_model'=>'required',
            'car_color'=>'required',
             'car_no'=>'required',
            'engine_no'=>'required',
             'chassis_no'=>'required',
             'sticker_no'=>'required',
             'sticker_status'=>'required',
            'driver_name'=>'required',
             'driver_cnic'=>'required',
            'driver_relation'=>'required',
            // 'car_remarks'=>'required'
          ]);

        $cars = mem_car::where('id', $carsid)->updateWithUserstamps([
      
             'name'=>$request->name,
            'familyforcar'=>$request->familyforcar,
            'membership_number'=>$request->membership_number,
            'contactforcar'=>$request->contactforcar,
             'addressforcar'=>$request->addressforcar,
            'owner_name'=>$request->owner_name,
             'owner_cnic'=>$request->owner_cnic,
            'car_makeover'=>$request->car_makeover,
             'car_model'=>$request->car_model,
            'car_color'=>$request->car_color,
             'car_no'=>$request->car_no,
            'engine_no'=>$request->engine_no,
             'chassis_no'=>$request->chassis_no,
             'sticker_no'=>$request->sticker_no,
             'sticker_issue_date'=>formatDate($request->sticker_issue_date),
             'sticker_exp_date'=>formatDate($request->sticker_exp_date),
             'sticker_status'=>$request->sticker_status,
            'driver_name'=>$request->driver_name,
             'driver_cnic'=>$request->driver_cnic,
            'driver_relation'=>$request->driver_relation,
             'car_remarks'=>$request->car_remarks
        ]);

        if ($cars) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/cars-aeu/'.$id);


    }


    public function destroy(mem_car $mem_car,$id,$carsid)
    {
        $cars=$mem_car::where('id', $carsid)->deleteWithUserstamps();
        if($cars){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        
        return redirect('club-hospitality/membership/cars-aeu/'.$id);
    }

  public function restore(mem_car $mem_car,$id,$carsid)
    {
        $restore = mem_car::onlyTrashed()->find($carsid)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/cars/deleted/'.$id);

}

}