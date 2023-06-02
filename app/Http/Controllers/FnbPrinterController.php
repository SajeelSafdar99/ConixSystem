<?php

namespace App\Http\Controllers;

use App\fnb_printer;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FnbPrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, fnb_printer $fnb_printer)
    {
         return view('backend/food-and-beverage/printers/printers');
    }

    public function indexdt(Request $request, fnb_printer $fnb_printer)
    {

        
     $fnb_printers = fnb_printer::get();
       return DataTables::of($fnb_printers)
       ->addColumn('status', function ($fnb_printers) {
               if($fnb_printers->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($fnb_printers) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/printers/printers-aeu/').'/'.$fnb_printers->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_printers) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/printers/delete') . '/' . $fnb_printers->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_printer $fnb_printer)
    {
        return view('backend/food-and-beverage/printers/printers-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_printer $fnb_printer)
    {

        $table = fnb_printer::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/printers/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_printer::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['printer_update'] = '';

     return view('backend/food-and-beverage.printers.printers-aeu',$data);
   
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
            'desc' => 'required|unique:fnb_printers,desc',
             'api'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=fnb_printer::create([
            'desc'=>$request->desc,
            'api'=>$request->api,
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
                return redirect('food-and-beverage/printers/printers-aeu');
            }else{
                return redirect('food-and-beverage/printers');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_printer  $fnb_printer
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_printer $fnb_printer)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_printer  $fnb_printer
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_printer $fnb_printer, $id)
    {
        $data['printer_update'] = fnb_printer::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['printer_update']->code;

         return view('backend/food-and-beverage.printers.printers-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_printer  $fnb_printer
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:fnb_printers,desc,'.$id,
            'api'   =>  'required',
            'status'   =>  'required']);

        $update = fnb_printer::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'api'=>$request->api,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/printers/printers-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_printer  $fnb_printer
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_printer $fnb_printer,$id)
    {
        
        $destroy=$fnb_printer::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/printers');
    }

public function restore(fnb_printer $fnb_printer,$id)
    {
        $restore = fnb_printer::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/printers/deleted');

}

}
