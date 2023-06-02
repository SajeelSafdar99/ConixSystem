<?php

namespace App\Http\Controllers;

use App\mem_title;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_title $mem_title)
    {
         return view('backend/club-hospitality/member-title/member-title');
    }

    public function indexdt(Request $request, mem_title $mem_title)
    {

        
     $mem_titles = mem_title::get();
       return DataTables::of($mem_titles)
       ->addColumn('status', function ($mem_titles) {
               if($mem_titles->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($mem_titles) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('club-hospitality/member-title/member-title-aeu/').'/'.$mem_titles->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($mem_titles) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/member-title/delete') . '/' . $mem_titles->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, mem_title $mem_title)
    {
        return view('backend/club-hospitality/member-title/member-title-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_title $mem_title)
    {

        $Classification_add = mem_title::onlyTrashed()->get();
        return DataTables::of($Classification_add)

            ->addColumn('restorebutton', function ($Classification_add) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/member-title/restore/') . '/' . $Classification_add->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=mem_title::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['mem_title_update'] = '';

     return view('backend/club-hospitality.member-title.member-title-aeu',$data);
   
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
            'desc' => 'required|unique:mem_titles,desc',
            'status'   =>  'required']);  
                    
       $store=mem_title::create([
            'desc'=>$request->desc,
            'status'=>$request->status,
            
            ]);
            
            if($store)
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
                return redirect('club-hospitality/member-title/member-title-aeu');
            }else{
                return redirect('club-hospitality/member-title');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_title  $mem_title
     * @return \Illuminate\Http\Response
     */
    public function show(mem_title $mem_title)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_title  $mem_title
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_title $mem_title, $id)
    {
        $data['mem_title_update'] = mem_title::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_title_update']->code;

         return view('backend/club-hospitality.member-title.member-title-aeu',$data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_title  $mem_title
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:mem_titles,desc,'.$id,
            'status'   =>  'required']);

        $update = mem_title::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/member-title/member-title-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_title  $mem_title
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_title $mem_title,$id)
    {
        
        $destroy=$mem_title::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/member-title');
    }

public function restore(mem_title $mem_title,$id)
    {
        $restore = mem_title::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/member-title/deleted');

}

}
