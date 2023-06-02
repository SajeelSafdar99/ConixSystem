<?php

namespace App\Http\Controllers;

use App\mem_partners;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemPartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_partners $mem_partners)
    {
         return view('backend/club-hospitality/partners/partners');
    }

    public function indexdt(Request $request, mem_partners $mem_partners)
    {

        
     $mem_partners = mem_partners::get();
       return DataTables::of($mem_partners)
       ->addColumn('status', function ($mem_partners) {
               if($mem_partners->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })

        ->addColumn('editbutton', function ($mem_partners) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('club-hospitality/partners/partners-aeu/').'/'.$mem_partners->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($mem_partners) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/partners/delete') . '/' . $mem_partners->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, mem_partners $mem_partners)
    {
        return view('backend/club-hospitality/partners/partners-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_partners $mem_partners)
    {

        $table = mem_partners::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/partners/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=mem_partners::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['partners_update'] = '';

     return view('backend/club-hospitality.partners.partners-aeu',$data);
   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;

     $createimg='';
    
    $lastval=mem_partners::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
      }
//dd($num);

if($request->hasFile('documents')) {

           $files = $request->file('documents');
           foreach($files as $file){
           
              $createimg=sendPartnerDocs($file,$size,['type'=>90,'moc_id'=>$num]);
        
          }
       }
         $save=$request->save;


         $this->validate($request,[
            'type'   =>  'required',
            'partner_name'   =>  'required|unique:mem_partners,partner_name',
            'address'   =>  'required',
            'partner_tel_a'   =>  'required',
            'partner_email'   =>  'required|email',
            'focal_person_name'   =>  'required',
            'focal_mob_a'   =>  'required',
            'focal_email'   =>  'required|email',
            'documents'   =>  'required',
            'agreement_date'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=mem_partners::create([
             'type'=>$request->type,
            'partner_name'=>$request->partner_name,
            'facilitation'=>$request->facilitation,
            'address'=>$request->address,
            'partner_mob_a'=>$request->partner_mob_a,
            'partner_mob_b'=>$request->partner_mob_b,
            'partner_tel_a'=>$request->partner_tel_a,
            'partner_email'=>$request->partner_email,
            'website'=>$request->website,

            'focal_person_name'=>$request->focal_person_name,
            'focal_mob_a'=>$request->focal_mob_a,
            'focal_mob_b'=>$request->focal_mob_b,
            'focal_tel_a'=>$request->focal_tel_a,
            'focal_email'=>$request->focal_email,

            'documents'=> $createimg,
            'agreement_date'=>formatDate($request->agreement_date),
            'status'=>$request->status,
            'remarks'=>$request->remarks
            
            ]);
            
            if($store)
            {
                Session::flash('message', 'Data Entered Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message;
             if(empty($save))
            {
                return redirect('club-hospitality/partners/partners-aeu');
            }else{
                return redirect('club-hospitality/partners');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_partners  $mem_partners
     * @return \Illuminate\Http\Response
     */
    public function show(mem_partners $mem_partners)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_partners  $mem_partners
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_partners $mem_partners, $id)
    {
        $data['partners_update'] = mem_partners::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['partners_update']->code;

         return view('backend/club-hospitality.partners.partners-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_partners  $mem_partners
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
                  $size['width'] = 300;
    $size['height'] = 200;
        $updateimg='';

if($request->hasFile('documents')) {

           $files = $request->file('documents');

     $s=mem_partners::find($id)->partnerDocs;
           foreach($s as $m){
               $m->delete();
    }

           foreach($files as $file){
             // dd($file);
            
              $updateimg=sendPartnerDocs($file,$size,['type'=>90,'moc_id'=>$request->post($id)]);

          }
       }

        $this->validate($request, [
            'type'   =>  'required',
            'partner_name'   =>  'required|unique:mem_partners,partner_name,'.$id,
            'address'   =>  'required',
            'partner_tel_a'   =>  'required',
            'partner_email'   =>  'required|email',
            'focal_person_name'   =>  'required',
            'focal_mob_a'   =>  'required',
            'focal_email'   =>  'required|email',
            'agreement_date'   =>  'required',
            'status'   =>  'required']);

        $update = mem_partners::where('id', $id)->updateWithUserstamps([
           'type'=>$request->type,
            'partner_name'=>$request->partner_name,
            'facilitation'=>$request->facilitation,
            'address'=>$request->address,
            'partner_mob_a'=>$request->partner_mob_a,
            'partner_mob_b'=>$request->partner_mob_b,
            'partner_tel_a'=>$request->partner_tel_a,
            'partner_email'=>$request->partner_email,
            'website'=>$request->website,

            'focal_person_name'=>$request->focal_person_name,
            'focal_mob_a'=>$request->focal_mob_a,
            'focal_mob_b'=>$request->focal_mob_b,
            'focal_tel_a'=>$request->focal_tel_a,
            'focal_email'=>$request->focal_email,

            'documents'=> $updateimg,
            'agreement_date'=>formatDate($request->agreement_date),
            'status'=>$request->status,
            'remarks'=>$request->remarks
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/partners/partners-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_partners  $mem_partners
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_partners $mem_partners,$id)
    {
        
        $destroy=$mem_partners::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/partners');
    }

public function restore(mem_partners $mem_partners,$id)
    {
        $restore = mem_partners::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/partners/deleted');

}

}
