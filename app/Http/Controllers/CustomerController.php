<?php

namespace App\Http\Controllers;

use App\customer;
use App\guest_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\exports\CustomerDown;
use App\mem_partners;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request){
        ob_end_clean(); 
        ob_start();
        return Excel::download(new CustomerDown,'guests.xlsx');
    }
    public function index(Request $request, customer $customer)
    {
        $data['eventstatus']   = 0;
        $tableColumns=    $customer->getTableColumns();
         return view('backend/room-management/room-customer/room-customer', $data)->withColumns($tableColumns);
    }

    public function index_events(Request $request, customer $customer)
    {
        $data['eventstatus']   = 1;
        $tableColumns=    $customer->getTableColumns();
         return view('backend/room-management/room-customer/room-customer', $data)->withColumns($tableColumns);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
     public function indexdt(Request $request, customer $customer)
    {

        $room_customers = customer::get();
        return DataTables::of($room_customers)

        ->addColumn('guest_type', function ($customer) {
            if($customer->guest_type){
                   return guesttypename($customer->guest_type);
            }else{
                return '';
            }
         
        })


         ->addColumn('affiliate', function ($customer) {
            if($customer->affiliate){
                   return guestaffiliatename($customer->affiliate);
            }else{
                return '';
            }
         
        })
        

            ->addColumn('editbutton', function ($room_customers) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('room-management/room-customer/room-customer-aeu/') . '/' . $room_customers->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('editeventsbutton', function ($room_customers) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('events-management/event-customer/event-customer-aeu/') . '/' . $room_customers->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($room_customers) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('room-management/room-customer/delete') . '/' . $room_customers->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->addColumn('deleteeventsbutton', function ($room_customers) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('events-management/event-customer/delete') . '/' . $room_customers->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })
            ->rawColumns(['editbutton','editeventsbutton', 'deletebutton', 'deleteeventsbutton'])
         ->addIndexColumn()
            ->make(true);
    }


    public function index_deleted(Request $request, customer $customer)
    {
        $data['eventstatus']   = 0;
        return view('backend/room-management/room-customer/room-customer-deleted', $data);
    }

    public function index_deleted_events(Request $request, customer $customer)
    {
        $data['eventstatus']   = 1;
        return view('backend/room-management/room-customer/room-customer-deleted', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, customer $customer)
    {

        $Customer = customer::onlyTrashed()->get();
        return DataTables::of($Customer)

         ->addColumn('guest_type', function ($customer) {
            if($customer->guest_type){
                   return guesttypename($customer->guest_type);
            }else{
                return '';
            }
         
        })
        

           ->addColumn('affiliate', function ($customer) {
            if($customer->affiliate){
                   return guestaffiliatename($customer->affiliate);
            }else{
                return '';
            }
         
        })
           

            ->addColumn('restorebutton', function ($Customer) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('room-management/room-customer/restore/') . '/' . $Customer->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

            ->addColumn('restoreeventsbutton', function ($Customer) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('events-management/event-customer/restore/') . '/' . $Customer->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton', 'restoreeventsbutton'])
        ->addIndexColumn()
        ->make(true);
    }


    public function create()
    {
        //Get the last record id and pass to the view
        $lastval = customer::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_customer_update'] = '';


    $data['gts']=guest_type::where('status',1)->get();
      $data['affs']=mem_partners::where('status',1)->get();

$data['eventstatus']   = 0;
        return view('backend/room-management.room-customer.room-customer-aeu', $data);
    }


    public function create_events()
    {
        //Get the last record id and pass to the view
        $lastval = customer::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['room_customer_update'] = '';
$data['eventstatus']   = 1;

  $data['gts']=guest_type::where('status',1)->get();
    $data['affs']=mem_partners::where('status',1)->get();
        return view('backend/room-management.room-customer.room-customer-aeu', $data);
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
      
            'customer_no' => 'required',
            'customer_name' => 'required|unique:customers,customer_name',
          /*  'customer_address' => 'required',
            'customer_cnic' => 'required',*/
            'customer_contact' => 'required|unique:customers,customer_contact',
            'guest_type' => 'required',
        ]);

        $Customer = customer::create([
       
            'customer_no' => $request->customer_no,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_cnic' => $request->customer_cnic,
            'customer_contact' => $request->customer_contact,
            'customer_email' => $request->customer_email,
            'member_name' => $request->member_name,
            'mem_no' => $request->mem_no,
            'guest_type' => $request->guest_type,
              'account'=>$request->account,
               'affiliate' => $request->affiliate,
        ]);

        if ($Customer) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('room-management/room-customer/room-customer-aeu');
            }else{
                return redirect('room-management/room-customer');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\room_customer  $room_customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_customer  $room_customer
     * @return \Illuminate\Http\Response
     */ 
    public function edit(customer $customer,$id)
    {
         $data['room_customer_update'] = customer::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_customer_update']->code;
$data['eventstatus']   = 0;

 $data['gts']=guest_type::where('status',1)->get();
   $data['affs']=mem_partners::where('status',1)->get();

        return view('backend/room-management.room-customer.room-customer-aeu', $data);
    }

     public function edit_events(customer $customer,$id)
    {
         $data['room_customer_update'] = customer::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['room_customer_update']->code;
$data['eventstatus']   = 1;

 $data['gts']=guest_type::where('status',1)->get();
  $data['affs']=mem_partners::where('status',1)->get();

        return view('backend/room-management.room-customer.room-customer-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_customer  $room_customer
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $this->validate($request, [
           'customer_no' => 'required',
            'customer_name' => 'required|unique:customers,customer_name,'.$id,
          /*  'customer_address' => 'required',
            'customer_cnic' => 'required',*/
            'customer_contact' => 'required|unique:customers,customer_contact,'.$id,
              'guest_type' => 'required',
        ]);

        $Customer = customer::where('id', $id)->updateWithUserstamps([
            'customer_no' => $request->customer_no,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_cnic' => $request->customer_cnic,
            'customer_contact' => $request->customer_contact,
            'customer_email' => $request->customer_email,
            'member_name' => $request->member_name,
            'mem_no' => $request->mem_no,
             'guest_type' => $request->guest_type,
              'account'=>$request->account,
                'affiliate' => $request->affiliate,
        ]);

        if ($Customer) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('room-management/room-customer/room-customer-aeu/'.$id);

    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_customer  $room_customer
     * @return \Illuminate\Http\Response
     */
   public function destroy(customer $customer,$id)
    {
        $roomcustomer=$customer::where('id', $id)->deleteWithUserstamps();
        if($roomcustomer){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('room-management/room-customer');
    }


 public function restore(customer $customer,$id)
    {
        $restore = customer::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('room-management/room-customer/deleted');

}

}

