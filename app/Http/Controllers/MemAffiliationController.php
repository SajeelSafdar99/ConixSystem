<?php

namespace App\Http\Controllers;

use App\mem_affiliation;
use Illuminate\Http\Request;

use Session;
use DataTables;
use App\membership;

class MemAffiliationController extends Controller
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

     public function create(mem_affiliation $mem_affiliation,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = mem_affiliation::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['affiliation_update'] = '';
        return view('backend/club-hospitality.membership.affiliation-aeu', $data);
    }

    public function store(Request $request,$id)
    {
      
         $member_affiliations=mem_affiliation::create([
            'member_id'=>$id,
            'affiliation'=>$request->aff,
            'name'=>$request->aff_name,
            'period'=>$request->aff_period,
            'other_club'=>$request->others,
            'details'=>$request->details,
            'political_affiliation'=>$request->political_details,
            'relative_a'=>$request->a,
            'relative_b'=>$request->b,
            'stayed_abroad'=>$request->abroad,
            'abroad_details'=>$request->abroad_details,
            'criminal'=>$request->crime,
            'criminal_details'=>$request->crime_details

            ]);


            if($member_affiliations)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
                $memid=$member_affiliations->id;
                $lastrec=mem_affiliation::where('id',$memid)->first();
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

    public function store_affiliation(Request $request,$id)
    {
         $this->validate($request, [

           'member_id'=>'required',
            'affiliation'=>'required',
            'name'=>'required',
            'period'=>'required',
            'other_club'=>'required',
            'details'=>'required',
            'political_affiliation'=>'required',
            'relative_a'=>'required',
            'relative_b'=>'required',
            'stayed_abroad'=>'required',
            'abroad_details'=>'required',
            'criminal'=>'required',
            'criminal_details'=>'required',
          ]);

        $affiliations = mem_affiliation::where('id', $id)->update([
           'member_id'=>$id,
            'affiliation'=>$request->aff,
            'name'=>$request->aff_name,
            'period'=>$request->aff_period,
            'other_club'=>$request->others,
            'details'=>$request->details,
            'political_affiliation'=>$request->political_details,
            'relative_a'=>$request->a,
            'relative_b'=>$request->b,
            'stayed_abroad'=>$request->abroad,
            'abroad_details'=>$request->abroad_details,
            'criminal'=>$request->crime,
            'criminal_details'=>$request->crime_details
        ]);

        if ($affiliations) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/affiliation-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_affiliation  $mem_affiliation
     * @return \Illuminate\Http\Response
     */
    public function show(mem_affiliation $mem_affiliation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_affiliation  $mem_affiliation
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_affiliation $mem_affiliation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_affiliation  $mem_affiliation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mem_affiliation $mem_affiliation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_affiliation  $mem_affiliation
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_affiliation $mem_affiliation)
    {
        //
    }
}
