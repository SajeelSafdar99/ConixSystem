<?php

namespace App\Http\Controllers;

use App\mem_maintenance;
use Illuminate\Http\Request;
use Session;
use DataTables;


class MemMaintenanceController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request,$id)
    {
         $member_maintenance=mem_maintenance::create([
            'member_id'=>$id,
            'name'=>$request->applicant_name,
            'membership_number'=>$request->mem_no,
            'membership_fee'=>$request->mem_fee,
            'addi_mem_charges'=>$request->additional_mem,
             'addi_mem_remarks'=>$request->additional_mem_remarks,
            'mem_discount'=>$request->mem_discount,
             'mem_discount_remarks'=>$request->mem_discount_remarks,
            'total_fee'=>$request->total,
             'amount'=>$request->maintenance_amount,
             'addi_mt_charges'=>$request->additional_mt,
            'addi_mt_remarks'=>$request->additional_mt_remarks,
             'mt_discount'=>$request->mt_discount,
            'mt_discount_remarks'=>$request->mt_discount_remarks,
            'total_maintenance'=>$request->total_maintenance
             
            ]);


            if($member_maintenance)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
                $memid=$member_maintenance->id;
                $lastrec=mem_maintenance::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
                return 'data not enter';
            }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_maintenance(Request $request,$id)
    {
       $this->validate($request, [
        
           'member_id'=>'required',
            'name'=>'required',
            'membership_number'=>'required',
            'membership_fee'=>'required',
            'addi_mem_charges'=>'required',
             'addi_mem_remarks'=>'required',
            'mem_discount'=>'required',
             'mem_discount_remarks'=>'required',
            'total_fee'=>'required',
             'amount'=>'required',
             'addi_mt_charges'=>'required',
            'addi_mt_remarks'=>'required',
             'mt_discount'=>'required',
            'mt_discount_remarks'=>'required',
            'total_maintenance'=>'required',
          ]);

        $maintenance = mem_maintenance::where('id', $id)->update([
          'member_id'=>$id,
            'name'=>$request->applicant_name,
            'membership_number'=>$request->mem_no,
            'membership_fee'=>$request->mem_fee,
            'addi_mem_charges'=>$request->additional_mem,
             'addi_mem_remarks'=>$request->additional_mem_remarks,
            'mem_discount'=>$request->mem_discount,
             'mem_discount_remarks'=>$request->mem_discount_remarks,
            'total_fee'=>$request->total,
             'amount'=>$request->maintenance_amount,
             'addi_mt_charges'=>$request->additional_mt,
            'addi_mt_remarks'=>$request->additional_mt_remarks,
             'mt_discount'=>$request->mt_discount,
            'mt_discount_remarks'=>$request->mt_discount_remarks,
            'total_maintenance'=>$request->total_maintenance
        ]);

        if ($maintenance) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/maintenance-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_maintenance  $mem_maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(mem_maintenance $mem_maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_maintenance  $mem_maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_maintenance $mem_maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_maintenance  $mem_maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mem_maintenance $mem_maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_maintenance  $mem_maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_maintenance $mem_maintenance)
    {
        //
    }
}
