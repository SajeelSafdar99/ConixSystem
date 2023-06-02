<?php

namespace App\Http\Controllers;

use App\sports_subscription;
use DataTables;
use Illuminate\Http\Request;
use Session;
use App\trans_type;
use Spatie\Permission\Models\Permission;

class SportsSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, sports_subscription $sports_subscription)
    {
         return view('backend/sports-subscription/sports/sports');
    }



    public function indexdt(Request $request, sports_subscription $sports_subscription)
    {

        $sports = sports_subscription::get();
        return DataTables::of($sports)
            ->addColumn('status', function ($sports) {
                if ($sports->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($sports) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('sports-subscription/sports/sports-aeu/') . '/' . $sports->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

             ->addColumn('deletebutton', function ($sports) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('sports-subscription/sports/delete') . '/' . $sports->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }



    public function index_deleted(Request $request, sports_subscription $sports_subscription)
    {
        return view('backend/sports-subscription/sports/sports-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, sports_subscription $sports_subscription)
    {

        $Sports = sports_subscription::onlyTrashed()->get();
        return DataTables::of($Sports)

            ->addColumn('restorebutton', function ($Sports) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('sports-subscription/sports/restore/') . '/' . $Sports->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
        $lastval = sports_subscription::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['sports_update'] = '';

        return view('backend/sports-subscription.sports.sports-aeu', $data);
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
            'code'     => 'required',
            'sport_name' => 'required',
          //  'charges' => 'required',
          //  'coa_code'   =>  'required',
          //  'account' => 'required',
            'status'   => 'required']);

        $Sports = sports_subscription::create([
            'code'   => $request->code,
            'desc'   => $request->sport_name,
            'account'   => $request->account,
            'charges'   => $request->charges,
            'status' => $request->status,

        ]);

        $invoice_module = trans_type::create([
            'name'   => $request->sport_name,
            'mod_id' => $Sports->id,
            'type'   => 3,
            'cash_or_payment'   => 0,
            'details' => 'financeInvoice',
            'table_name' => 'finance_invoice'
        ]);

       Permission::create(['name' => $request->sport_name.' '.$Sports->id,'category'=>19,'auto_generated' => 1]);
       Permission::create(['name' => 'Invoice'.' '.$request->sport_name.' '.$Sports->id,'category'=>20,'auto_generated' => 1]);

        if ($Sports) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('sports-subscription/sports/sports-aeu');
            }else{
                return redirect('sports-subscription/sports');
            }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\sports_subscription  $sports_subscription
     * @return \Illuminate\Http\Response
     */
    public function show(sports_subscription $sports_subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sports_subscription  $sports_subscription
     * @return \Illuminate\Http\Response
     */
     public function edit(sports_subscription $sports_subscription,$id)
    {
         $data['sports_update'] = sports_subscription::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['sports_update']->code;

        return view('backend/sports-subscription.sports.sports-aeu', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sports_subscription  $sports_subscription
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $theprename='';
        $theprename=sports_subscription::where('id', $id)->get()->pluck('desc');

        $this->validate($request, [
           'sport_name' => 'required',
        //   'charges' => 'required',
         //  'coa_code'   =>  'required',
         //  'account' => 'required',
           'status'   => 'required']);

if(Permission::where('category',19)->where('name', $theprename[0].' '.$id)->exists())
{
    Permission::where('category',19)->where('name', $theprename[0].' '.$id)->updateWithUserstamps([
            'name'=>$request->sport_name.' '.$id,
            'category'=>19,
            'auto_generated' => 1
    ]);
}
else{
    Permission::create(['name' => $request->sport_name.' '.$id,'category'=>19,'auto_generated' => 1]);
}


if(Permission::where('category',20)->where('name', 'Invoice'.' '.$theprename[0].' '.$id)->exists())
{
    Permission::where('category',20)->where('name', 'Invoice'.' '.$theprename[0].' '.$id)->updateWithUserstamps([
            'name'=> 'Invoice'.' '.$request->sport_name.' '.$id,
            'category'=>20,
            'auto_generated' => 1
        ]);
}
else{
    Permission::create(['name' => 'Invoice'.' '.$request->sport_name.' '.$id,'category'=>20,'auto_generated' => 1]);
}
        

        $sports_subscriptions = sports_subscription::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->sport_name,
            'account'   => $request->account,
            'charges'   => $request->charges,
            'status' => $request->status,
        ]);

if(trans_type::where('type', 3)->where('mod_id', $id)->exists()){
    $invoice_module = trans_type::where('type', 3)->where('mod_id', $id)->updateWithUserstamps([
            'name'   => $request->sport_name,
            'mod_id'   => $id,
            'type'   => 3,
            'cash_or_payment'   => 0,
            'details' => 'financeInvoice',
            'table_name' => 'finance_invoice'
        ]);
}else{
     $invoice_module = trans_type::create([
            'name'   => $request->sport_name,
            'mod_id' => $id,
            'type'   => 3,  
            'cash_or_payment'   => 0,
            'details' => 'financeInvoice',
            'table_name' => 'finance_invoice'
        ]);
}
        
        

        if ($sports_subscriptions) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('sports-subscription/sports/sports-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sports_subscription  $sports_subscription
     * @return \Illuminate\Http\Response
     */

      public function destroy(sports_subscription $sports_subscription,$id)
    {
          $data['getname'] = sports_subscription::where('id', $id)->first();

        $sports=$sports_subscription::where('id', $id)->deleteWithUserstamps();
      
        trans_type::where('type',3)->where('mod_id', $id)->deleteWithUserstamps();
Permission::where('category',19)->where('name', $data['getname']->desc.' '.$id)->deleteWithUserstamps();
Permission::where('category',20)->where('name', 'Invoice'.' '.$data['getname']->desc.' '.$id)->deleteWithUserstamps();

        if($sports){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('sports-subscription/sports');
    }


public function restore(sports_subscription $sports_subscription,$id)
    {
        $data['getname'] = sports_subscription::onlyTrashed()->where('id', $id)->first();
        
          $restore = sports_subscription::onlyTrashed()->find($id)->restore();
        trans_type::onlyTrashed()->where('type',3)->where('mod_id', $id)->restore();
Permission::onlyTrashed()->where('category',19)->where('name', $data['getname']->desc.' '.$id)->restore();
Permission::onlyTrashed()->where('category',20)->where('name', 'Invoice'.' '.$data['getname']->desc.' '.$id)->restore();

      
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('sports-subscription/sports/deleted');

}

}
