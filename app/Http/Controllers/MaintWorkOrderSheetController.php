<?php

namespace App\Http\Controllers;

use App\maint_work_order_sheet;
use App\maint_work_order_department;
use App\admin_company_profile;
use Session;
use DataTables;
use Illuminate\Http\Request;

class MaintWorkOrderSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
     public function sheet_dt(Request $request, maint_work_order_sheet $maint_work_order_sheet)
    {
         return view('backend/maintenance-management/work-order-sheet/work-order-sheet-vue');
    }


       public function sheet_init_vue(Request $request)
    {
  $data['sales'] =\Illuminate\Support\Facades\DB::select(
     'select maint_work_order_sheets.*,
      maint_work_order_departments.desc as department
from maint_work_order_sheets

left outer join maint_work_order_departments on maint_work_order_departments.id=maint_work_order_sheets.department and maint_work_order_departments.status=1 and maint_work_order_departments.deleted_at is null
where maint_work_order_sheets.deleted_at is null group by maint_work_order_sheets.id order by maint_work_order_sheets.id desc');
  $data['departments']= maint_work_order_department::where('status',1)->get();
     return $data;
}

 public function index_deleted(Request $request, maint_work_order_sheet $maint_work_order_sheet)
    {
        return view('backend/maintenance-management/work-order-sheet/work-order-sheet-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, maint_work_order_sheet $maint_work_order_sheet)
    {

        $table = maint_work_order_sheet::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('maintenance-management/work-order-sheet/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

               ->addColumn('issue_date', function ($table) {
                 if($table->issue_date){
                       return formatDateToShow($table->issue_date);
                    }else{
                       return ""; 
                    }
                })

                ->addColumn('department', function ($table) {
                    if($table->department){
                       return WorkOrderDepartment($table->department);
                    }else{
                       return ""; 
                    }
                })

    ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

 public function create(Request $request)
    {
        return view('backend/maintenance-management.work-order-sheet.work-order-sheet-aeu-vue');
    }

  public function init(Request $request)
    {
        if($request->get('r')){
            $lastval=maint_work_order_sheet::find($request->get('r'));
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }

   $lastval['departments']= maint_work_order_department::where('status',1)->get();
       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $lastval=maint_work_order_sheet::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }
 $data['departments']= maint_work_order_department::where('status',1)->get();
     return $data;
 }
}


 public function save(Request $request){
//        dd($request->all());
      $lastval=maint_work_order_sheet::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
      
      }else{
        $num=1;
      }

if(maint_work_order_sheet::where('id',$num)->count() == 0){
        $d=[];
      
        $d['serial_no']=$request->get('serial_no');
        $d['issue_date']=formatDate($request->get('issue_date'));
        $d['department']=$request->get('department');
        $d['description']=$request->get('description');
       
        $id=  maint_work_order_sheet::create($d);

}
     return $id->id;
 
    }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\maint_work_order_sheet  $maint_work_order_sheet
     * @return \Illuminate\Http\Response
     */
    public function show(maint_work_order_sheet $maint_work_order_sheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\maint_work_order_sheet  $maint_work_order_sheet
     * @return \Illuminate\Http\Response
     */
     public function edit(maint_work_order_sheet $maint_work_order_sheet,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
     return view('backend/maintenance-management.work-order-sheet.work-order-sheet-aeu-vue', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\maint_work_order_sheet  $maint_work_order_sheet
     * @return \Illuminate\Http\Response
     */
    
    public function updated(Request $request){

        $lastval=maint_work_order_sheet::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }


        $d=[];

       $d['serial_no']=$request->get('serial_no');
        $d['issue_date']=formatDate($request->get('issue_date'));
        $d['department']=$request->get('department');
        $d['description']=$request->get('description');

      $id=  maint_work_order_sheet::where('id',$request->get('id'))->updateWithUserstamps($d);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\maint_work_order_sheet  $maint_work_order_sheet
     * @return \Illuminate\Http\Response
     */
    
     public function destroy(Request $request,maint_work_order_sheet $maint_work_order_sheet,$id)
    {
     $update= maint_work_order_sheet::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$maint_work_order_sheet::where('id', $id)->deleteWithUserstamps();
    }

    public function restore(maint_work_order_sheet $maint_work_order_sheet,$id)
    {
        $restore = maint_work_order_sheet::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }
         else{
            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');
         }
        return redirect('maintenance-management/work-order-sheet/deleted');

}


 public function invoice(maint_work_order_sheet $maint_work_order_sheet,$id,Request $request){
       $data['receiptdata']=maint_work_order_sheet::where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();
       
        return view('backend/maintenance-management.work-order-sheet.work-order-sheet-invoice', $data);
 }
    


}
