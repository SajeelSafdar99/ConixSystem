<?php

namespace App\Http\Controllers;
use App\corporateMembership; 
use App\media; 
use App\membership; 
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use DataTables;

class MembershipDocumentsController extends Controller
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
        $data['images'] = membership::find($id)->docs->pluck('url');
        $data['membershipdata'] = membership::where('id', $id)->first();
       
     return view('backend/club-hospitality.membership.membership_docs-aeu', $data);
    
    }


      public function corporate_create(media $media,$id)
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
        $data['images'] = corporateMembership::find($id)->docs->pluck('url');
        $data['membershipdata'] = corporateMembership::where('id', $id)->first();
       
     return view('backend/club-hospitality.corporate-membership.corporate-membership-docs-aeu', $data);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function corporate_store(Request $request,$id)
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
 
              $createimg=sendCorporateMemberDocs($file,$size,['type'=>0,'trans_type'=>180,'trans_type_id'=>$id,'moc_id'=>$id]);  
              // type = 10 
          }
       }

      //  $save=$request->save;
    


            if($createimg)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            
                 return redirect('club-hospitality/corporate-membership/corporate-membership-docs-aeu/'.$id);
            
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
                return redirect('club-hospitality/corporate-membership/corporate-membership-docs-aeu/'.$id);
            }


    }



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
 
              $createimg=sendMemberDocs($file,$size,['type'=>0,'trans_type'=>90,'trans_type_id'=>$id,'moc_id'=>$id]);  
              // type = 10 
          }
       }

      //  $save=$request->save;
    


            if($createimg)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            
                 return redirect('club-hospitality/membership/membership_docs-aeu/'.$id);
            
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
                return redirect('club-hospitality/membership/membership_docs-aeu/'.$id);
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
    public function destroy(request $request,$url)
    {
                $url=base64_decode($url);
//         dd($url);
       $hash=$request->get('hash');
     $m= media::where('url',$url)->deleteWithUserstamps();
     unlink($url);
if(1==1){
    return Redirect::to(URL::previous() . $hash);

}
      /// return $img->response('jpg');
    }



     public function corporate_destroy(request $request,$url)
    {
                $url=base64_decode($url);
//         dd($url);
       $hash=$request->get('hash');
     $m= media::where('url',$url)->deleteWithUserstamps();
     unlink($url);
if(1==1){
    return Redirect::to(URL::previous() . $hash);

}
      /// return $img->response('jpg');
    }



}
