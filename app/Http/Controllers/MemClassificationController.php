<?php

namespace App\Http\Controllers;

use App\mem_classification;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_classification $mem_classification)
    {
         return view('backend/club-hospitality/member-classification/member-classification');
    }

    public function indexdt(Request $request, mem_classification $mem_classification)
    {

        
     $mem_classifications = mem_classification::get();
       return DataTables::of($mem_classifications)
       ->addColumn('status', function ($mem_classifications) {
               if($mem_classifications->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($mem_classifications) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('club-hospitality/member-classification/member-classification-aeu/').'/'.$mem_classifications->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($mem_classifications) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/member-classification/delete') . '/' . $mem_classifications->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, mem_classification $mem_classification)
    {
        return view('backend/club-hospitality/member-classification/member-classification-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_classification $mem_classification)
    {

        $Classification_add = mem_classification::onlyTrashed()->get();
        return DataTables::of($Classification_add)

            ->addColumn('restorebutton', function ($Classification_add) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/member-classification/restore/') . '/' . $Classification_add->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=mem_classification::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['mem_classification_update'] = '';

     return view('backend/club-hospitality.member-classification.member-classification-aeu',$data);
   
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
         $this->validate($request,[
            'desc' => 'required|unique:mem_classifications,desc',
            'status'   =>  'required']);  
                    
       $Classification_add=mem_classification::create([
            'desc'=>$request->desc,
            'status'=>$request->status,
            
            ]);
            
            if($Classification_add)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message;
             if(empty($save))
            {
                return redirect('club-hospitality/member-classification/member-classification-aeu');
            }else{
                return redirect('club-hospitality/member-classification');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_classification  $mem_classification
     * @return \Illuminate\Http\Response
     */
    public function show(mem_classification $mem_classification)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_classification  $mem_classification
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_classification $mem_classification, $id)
    {
        $data['mem_classification_update'] = mem_classification::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_classification_update']->code;

         return view('backend/club-hospitality.member-classification.member-classification-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_classification  $mem_classification
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:mem_classifications,desc,'.$id,
            'status'   =>  'required']);

        $member_classification = mem_classification::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'status'=>$request->status,
        ]);

        if ($member_classification) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/member-classification/member-classification-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_classification  $mem_classification
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_classification $mem_classification,$id)
    {
        
        $memclassification=$mem_classification::where('id', $id)->deleteWithUserstamps();
        if($memclassification){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/member-classification');
    }

public function restore(mem_classification $mem_classification,$id)
    {
        $restore = mem_classification::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/member-classification/deleted');

}

}
