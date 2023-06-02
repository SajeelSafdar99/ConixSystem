<?php

namespace App\Http\Controllers;

use App\mem_referal;

use App\membership; 
use Illuminate\Http\Request;
use Session;
use DataTables;


class MemReferalController extends Controller
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
          $member_referal=mem_referal::create([
            'member_id'=>$id,
            'member_name'=>$request->ref_name,
            'mem_no'=>$request->mem_number,
            'relation'=>$request->rel,
            'contact'=>$request->mobile_no
           
            ]);


            if($member_referal)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
                $memid=$member_referal->id;
                $lastrec=mem_referal::where('id',$memid)->first();
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

    public function store_referal(Request $request, $id)
    {
         $this->validate($request, [

           'member_id'=>'required',
            'member_name'=>'required',
            'mem_no'=>'required',
            'relation'=>'required',
            'contact'=>'required',
          ]);

        $referal = mem_referal::where('id', $id)->updateWithUserstamps([
           'member_id'=>$id,
            'member_name'=>$request->ref_name,
            'mem_no'=>$request->mem_number,
            'relation'=>$request->rel,
            'contact'=>$request->mobile_no
        ]);

        if ($referal) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/referal-aeu/'.$id);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_referal  $mem_referal
     * @return \Illuminate\Http\Response
     */
    public function show(mem_referal $mem_referal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_referal  $mem_referal
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_referal $mem_referal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_referal  $mem_referal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mem_referal $mem_referal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_referal  $mem_referal
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_referal $mem_referal)
    {
        //
    }
}
