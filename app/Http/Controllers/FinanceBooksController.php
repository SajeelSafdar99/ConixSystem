<?php

namespace App\Http\Controllers;

use App\finance_books;
use Illuminate\Http\Request;
use Session;
use DataTables;

class FinanceBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, finance_books $finance_books)
    {
         return view('backend/finance-and-management/books/books');
    }

    public function indexdt(Request $request, finance_books $finance_books)
    {

        
     $finance_books = finance_books::get();
       return DataTables::of($finance_books)
       ->addColumn('status', function ($finance_books) {
               if($finance_books->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        
         ->addColumn('type', function ($finance_books) {
               if($finance_books->debit_or_credit==1){
return 'Credit';
               }else{
                return 'Debit';
               }
            })


        ->addColumn('editbutton', function ($finance_books) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('finance-and-management/books/books-aeu/').'/'.$finance_books->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($finance_books) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/books/delete') . '/' . $finance_books->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, finance_books $finance_books)
    {
        return view('backend/finance-and-management/books/books-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_books $finance_books)
    {

        $table = finance_books::onlyTrashed()->get();
        return DataTables::of($table)

          ->addColumn('type', function ($table) {
               if($table->debit_or_credit==1){
return 'Credit';
               }else{
                return 'Debit';
               }
            })


            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/books/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=finance_books::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['books_update'] = '';

     return view('backend/finance-and-management.books.books-aeu',$data);
   
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
            'desc' => 'required|unique:finance_books,desc',
            'debit_or_credit'   =>  'required',
            'status'   =>  'required']);  
                    
       $store=finance_books::create([
            'desc'=>$request->desc,
            'debit_or_credit'=>$request->debit_or_credit,
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
                return redirect('finance-and-management/books/books-aeu');
            }else{
                return redirect('finance-and-management/books');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_books  $finance_books
     * @return \Illuminate\Http\Response
     */
    public function show(finance_books $finance_books)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_books  $finance_books
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_books $finance_books, $id)
    {
        $data['books_update'] = finance_books::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['books_update']->code;

         return view('backend/finance-and-management.books.books-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_books  $finance_books
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:finance_books,desc,'.$id,
             'debit_or_credit'   =>  'required',
            'status'   =>  'required']);

        $update = finance_books::where('id', $id)->updateWithUserstamps([
           
            'desc'=>$request->desc,
            'debit_or_credit'=>$request->debit_or_credit,
            'status'=>$request->status,
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/books/books-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_books  $finance_books
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_books $finance_books,$id)
    {
        
        $destroy=$finance_books::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/books');
    }

public function restore(finance_books $finance_books,$id)
    {
        $restore = finance_books::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/books/deleted');

}

}
