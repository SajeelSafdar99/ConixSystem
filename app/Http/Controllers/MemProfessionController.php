<?php

namespace App\Http\Controllers;

use App\mem_professionaffiliations;
use App\mem_family;
use App\mem_relation;
use App\membership; 
use App\mem_occupation; 
use App\mem_profession_subs;
use Illuminate\Http\Request;
use Session;
use DataTables;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MemProfessionController extends Controller
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

     public function create(mem_professionaffiliations $mem_professionaffiliations,$id)
    { 
        // //Get the last record id and pass to the view
        $lastval = mem_professionaffiliations::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['profession_update'] = '';

         $data['familymembers']=mem_family::where('member_id',$id)->get();

        $data['count']=membership::find($id)->profession()->count();
 $data['membershipdata'] = membership::where('id', $id)->first();
 $data['occupations']=mem_occupation::where('status',1)->get();
if($data['count']>0){
    return redirect('club-hospitality/profession/edit/'.$id);
}
else{
     return view('backend/club-hospitality.membership.profession-aeu', $data);
}
       
        
    }

    
    public function store(Request $request,$id)
    {
        $save=$request->save;
         $this->validate($request, [

            'bussiness'=>'required',
            //'position'=>'required',
            //'experience'=>'required',
            //'income'=>'required',
            'anymess'=>'required',
            'mem_result'=>'required',
            'aff'=>'required',
            'abroad'=>'required',
            'crime'=>'required'
          ]);
         $member_profession=mem_professionaffiliations::create([
            'member_id'=>$id,
            'next_of_kin'=>$request->next_of_kin,
            'kin_relation'=>$request->kin_relation,
            'kin_contact'=>$request->kin_contact,
            'bussiness'=>$request->bussiness,
            'position'=>$request->position,
            'organization_name'=>$request->organization_name,
            'experience'=>$request->experience,
        'income'=>$request->income,
            'anymess'=>$request->anymess,
            'when'=>$request->when,
            'mem_result'=>$request->mem_result,
            'reason'=>$request->reason,
            'referal_mem_name'=>$request->referal_mem_name,
            'referal_mem_no'=>$request->referal_mem_no,
            'referal_relation'=>$request->referal_relation,
            'referal_contact'=>$request->referal_contact,

            'aff'=>$request->aff,
            'aff_name'=>$request->aff_name,
            
            'aff_period'=>$request->aff_period,
         
            'details'=>$request->details,
            'political_details'=>$request->political_details,
            'a'=>$request->a,
            'b'=>$request->b,
            'abroad'=>$request->abroad,
            'abroad_details'=>$request->abroad_details,
            'crime'=>$request->crime,
            'crime_details'=>$request->crime_details

            ]);

         $clubname=$request->club_name;
        $clubmemno=$request->club_mem_no;

          $i=0;
        foreach ($clubname as $cname => $c_name) {

            $ta = new mem_profession_subs;
            $ta->profession_id = $member_profession->member_id;
            $ta->club_name = $clubname[$i];
            $ta->club_mem_no=$clubmemno[$i];
            $ta->save();
            $i++;
        }


            if($member_profession)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
                $memid=$member_profession->id;
                $lastrec=mem_professionaffiliations::where('id',$memid)->first();
               return redirect('club-hospitality/profession/edit/'.$id);
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
                return redirect('club-hospitality/profession/edit/'.$id);
            }


    }


      public function edit(mem_professionaffiliations $mem_professionaffiliations,$id)
    {
        $data['profession_update'] = membership::find($id)->profession()->first();

        $data['init']                = 1;
        $data['increment_number']    = $data['profession_update'];

         $data['familymembers']=mem_family::where('member_id',$id)->get();
        //dd($data);
         $data['membershipdata'] = membership::where('id', $id)->first();
         $data['occupations']=mem_occupation::where('status',1)->get();

    $data['club']=mem_professionaffiliations::with('clubsubs')->where('member_id', $id)->get();
       $data['clubdatas']=$data['club'][0]['clubsubs'];


        return view('backend/club-hospitality.membership.profession-aeu', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'bussiness'=>'required',
            //'position'=>'required',
           // 'experience'=>'required',
            //'income'=>'required',
            'anymess'=>'required',
            'mem_result'=>'required',
            'aff'=>'required',
            'abroad'=>'required',
            'crime'=>'required'
          ]);

        $profession = mem_professionaffiliations::where('member_id', $id)->updateWithUserstamps([
            'next_of_kin'=>$request->next_of_kin,
            'kin_relation'=>$request->kin_relation,
            'kin_contact'=>$request->kin_contact,
            'bussiness'=>$request->bussiness,
            'position'=>$request->position,
             'organization_name'=>$request->organization_name,
            'experience'=>$request->experience,
        'income'=>$request->income,
            'anymess'=>$request->anymess,
            'when'=>$request->when,
            'mem_result'=>$request->mem_result,
            'reason'=>$request->reason,
            'referal_mem_name'=>$request->referal_mem_name,
            'referal_mem_no'=>$request->referal_mem_no,
            'referal_relation'=>$request->referal_relation,
            'referal_contact'=>$request->referal_contact,

            'aff'=>$request->aff,
            'aff_name'=>$request->aff_name,
            
            'aff_period'=>$request->aff_period,
          
            'details'=>$request->details,
            'political_details'=>$request->political_details,
            'a'=>$request->a,
            'b'=>$request->b,
            'abroad'=>$request->abroad,
            'abroad_details'=>$request->abroad_details,
            'crime'=>$request->crime,
            'crime_details'=>$request->crime_details
        ]);



 $prodelete= mem_profession_subs::where('profession_id', $id)->deleteWithUserstamps();

if($prodelete){
        $clubname=$request->club_name;
        $clubmemno=$request->club_mem_no;

          $i=0;
        foreach ($clubname as $club_name => $c_name) {


            $ta = new mem_profession_subs;
             $ta->profession_id=$id;
             $ta->club_name = $clubname[$i];
            $ta->club_mem_no=$clubmemno[$i];
            $ta->save();
            $i++;
        }
  }


        if ($profession) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }
        
        return redirect('club-hospitality/profession/edit/'.$id);


    }


     function findrel($id){
      $fam_relationship=mem_family::where('id',$id)->first();
      return $fam_relationship->fam_relationship;


    }

    function fmcontact($id){
      $fam_contact=mem_family::where('id',$id)->first();
      return $fam_contact->contact;


    }

     function fmrelationship($id){
        $data='';
        $fmrelationship=mem_relation::where('id',$id)->first();

        if(!empty($fmrelationship->desc)){
         return  $data=$fmrelationship->desc;
         }else{
         return $data='not exists';
         }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_profession  $mem_profession
     * @return \Illuminate\Http\Response
     */
    public function show(mem_profession $mem_profession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_profession  $mem_profession
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_profession  $mem_profession
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_profession  $mem_profession
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_profession $mem_profession)
    {
        //
    }
}