<?php

namespace App\Http\Controllers;

use App\media;
use App\hr_employment; 
use Illuminate\Http\Request;
use Session;
use DataTables;

class EmploymentDocumentsController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function create(media $media,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = media::get()->last();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['images'] = hr_employment::find($id)->employeeDocs->pluck('url');
        $data['employmentdata'] = hr_employment::where('id', $id)->first();
       
     return view('backend/human-resource.employment.employment-docs-aeu', $data);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
  $this->validate($request, [

            'documents'=>'required'
          ]);

         $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;

      $createimg='';


      if($request->hasFile('documents')) {

           $files = $request->file('documents');

           foreach($files as $file){
           
              $createimg=sendEmployDocs($file,$size,['type'=>55,'type_id'=>$id]); 
          }
       }

      //  $save=$request->save;
    


            if($createimg)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            
                 return redirect('human-resource/employment/employment-docs-aeu/'.$id);
            
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
                return redirect('human-resource/employment/employment-docs-aeu/'.$id);
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\membership_documents  $membership_documents
     * @return \Illuminate\Http\Response
     */
    public function show(membership_documents $membership_documents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\membership_documents  $membership_documents
     * @return \Illuminate\Http\Response
     */
    public function edit(membership_documents $membership_documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\membership_documents  $membership_documents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, membership_documents $membership_documents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\membership_documents  $membership_documents
     * @return \Illuminate\Http\Response
     */
    public function destroy(membership_documents $membership_documents)
    {
        //
    }
}
