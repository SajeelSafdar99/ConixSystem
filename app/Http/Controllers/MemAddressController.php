<?php

namespace App\Http\Controllers;

use App\mem_address;

use App\membership; 
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemAddressController extends Controller
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
         
         $member_address=mem_address::create([
           'member_id'=>$id,
            'address_type'=>$request->add_type,
            'address'=>$request->add,
            'city'=>$request->city,
            'country'=>$request->country,
            'make_primary'=>0
            
            ]);

            if($member_address)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
                Session::flash('tab_value', 'address'); 
                $memid=$member_address->id;
                $lastrec=mem_address::where('id',$memid)->first();
                return redirect('club-hospitality/membership/address-aeu/');
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
                Session::flash('tab_value', 'address'); 
                return redirect('club-hospitality/membership/address-aeu/');
               
            }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_address(Request $request,$id)
    {
       $this->validate($request, [
        
           'member_id'=>'required',
            'address_type'=>'required',
            'address'=>'required',
            'city'=>'required',
            'country'=>'required',
    
          ]);

        $add = mem_address::where('id', $id)->update([
          'member_id'=>$id,
            'address_type'=>$request->add_type,
            'address'=>$request->add,
            'city'=>$request->city,
            'country'=>$request->country,
            'make_primary'=>0
        ]);

        if ($add) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/address-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_address  $mem_address
     * @return \Illuminate\Http\Response
     */
    public function show(mem_address $mem_address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_address  $mem_address
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_address $mem_address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_address  $mem_address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mem_address $mem_address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_address  $mem_address
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_address $mem_address)
    {
        //
    }
}
