<?php

namespace App\Http\Controllers;

use App\mem_corporate_companies;
use Illuminate\Http\Request;
use Session;
use DataTables;

class MemCorporateCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_corporate_companies $mem_corporate_companies)
    {
        return view('backend/club-hospitality/mem-corporate-companies/mem-corporate-companies');
    }

     public function indexdt(Request $request, mem_corporate_companies $mem_corporate_companies)
    {

        
     $mem_corporate_companies = mem_corporate_companies::get();
       return DataTables::of($mem_corporate_companies)
       ->addColumn('status', function ($mem_corporate_companies) {
               if($mem_corporate_companies->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })
        

        ->addColumn('editbutton', function ($mem_corporate_companies) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('club-hospitality/corporate-companies/corporate-companies-aeu').'/'.$mem_corporate_companies->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })

        ->addColumn('deletebutton', function ($mem_corporate_companies) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/corporate-companies/delete') . '/' . $mem_corporate_companies->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

          ->addColumn('company_logo', function ($mem_corporate_companies) {
                return '<img style="width: 100px;" src="'.url('/').'/'.$mem_corporate_companies->company_logo.'"/>';
            })

       ->rawColumns(['editbutton','deletebutton', 'status', 'company_logo'])
       ->addIndexColumn()
       ->make(true);
    }
    

     public function index_deleted(Request $request, mem_corporate_companies $mem_corporate_companies)
    {
        return view('backend/club-hospitality/mem-corporate-companies/mem-corporate-companies-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_corporate_companies $mem_corporate_companies)
    {

        $mem_corporate_companies = mem_corporate_companies::onlyTrashed()->get();
        return DataTables::of($mem_corporate_companies)

  ->addColumn('company_logo', function ($mem_corporate_companies) {
                return '<img style="width: 100px;" src="'.url('/').'/'.$mem_corporate_companies->company_logo.'"/>';
            })

            ->addColumn('restorebutton', function ($mem_corporate_companies) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/corporate-companies/restore/') . '/' . $mem_corporate_companies->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton', 'company_logo'])
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
        $lastval=mem_corporate_companies::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
      $data['init']=0;
      $data['mem_corporate_companies_update'] = '';


     return view('backend/club-hospitality.mem-corporate-companies.mem-corporate-companies-aeu',$data);
 
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

         $save=$request->save;
        $this->validate($request,[
           
            'name' => 'required|unique:mem_corporate_companies,name',
            'profile' => 'required',
            'address' => 'required',
             'city' => 'required',
            'contact' => 'required',
             'email' => 'required',
            'website' => 'required',
             'ntn' => 'required',
           //     'company_logo' => 'required',
            'status'   =>  'required']);  
              
              if($request->company_logo){
                   $add=mem_corporate_companies::create([
            
            'name'=>$request->name,
            'profile'=>$request->profile,
            'address'=>$request->address,
            'city'=>$request->city,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'website'=>$request->website,
            'ntn'=>$request->ntn,
               'company_logo' =>  sendCorporateImage($request->company_logo,$size),
            'status'=>$request->status,
            
            ]);
              }
              else{
                   $add=mem_corporate_companies::create([
            
            'name'=>$request->name,
            'profile'=>$request->profile,
            'address'=>$request->address,
            'city'=>$request->city,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'website'=>$request->website,
            'ntn'=>$request->ntn,
            //   'company_logo' =>  sendCorporateImage($request->company_logo,$size),
            'status'=>$request->status,
            
            ]);
              }      
    
            
            if($add)
            {
                Session::flash('message', 'Data Enter Successfully !'); 
                Session::flash('alert-class', 'alert-success');
               
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message

          

             if(empty($save))
            {
                return redirect('club-hospitality/corporate-companies/corporate-companies-aeu');
            }else{
                return redirect('club-hospitality/corporate-companies');
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_corporate_companies  $mem_corporate_companies
     * @return \Illuminate\Http\Response
     */
    public function show(mem_corporate_companies $mem_corporate_companies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_corporate_companies  $mem_corporate_companies
     * @return \Illuminate\Http\Response
     */
     public function edit(mem_corporate_companies $mem_corporate_companies, $id)
    {
        $data['mem_corporate_companies_update'] = mem_corporate_companies::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_corporate_companies_update']->code;

        return view('backend/club-hospitality.mem-corporate-companies.mem-corporate-companies-aeu',$data);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_corporate_companies  $mem_corporate_companies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


         $size['width'] = 300;
    $size['height'] = 200;
        $updateimg='';
        if ($request->hasFile('company_logo')) {
        $updateimg=$request->company_logo;
        $updateimg=sendCorporateImage($updateimg,$size);
        }else{
        $updateimg=$request->existimg;
        }


        $this->validate($request, [
            
             'name' => 'required|unique:mem_corporate_companies,name,'.$id,
            'profile' => 'required',
            'address' => 'required',
             'city' => 'required',
            'contact' => 'required',
             'email' => 'required',
            'website' => 'required',
             'ntn' => 'required',
           //     'company_logo' => 'required',
            'status'   =>  'required']);

        $add = mem_corporate_companies::where('id', $id)->updateWithUserstamps([
             
            'name'=>$request->name,
            'profile'=>$request->profile,
            'address'=>$request->address,
            'city'=>$request->city,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'website'=>$request->website,
            'ntn'=>$request->ntn,
             'company_logo'=>$updateimg,
            'status'=>$request->status,
            
        ]);

        if ($add) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/corporate-companies/corporate-companies-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_corporate_companies  $mem_corporate_companies
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_corporate_companies $mem_corporate_companies,$id)
    {
        
        $memcategory=$mem_corporate_companies::where('id', $id)->deleteWithUserstamps();
        if($memcategory){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/corporate-companies');
    }

public function restore(mem_corporate_companies $mem_corporate_companies,$id)
    {
        $restore = mem_corporate_companies::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/corporate-companies/deleted');

}

}

