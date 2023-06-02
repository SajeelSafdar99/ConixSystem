<?php

namespace App\Http\Controllers;
use App\trans_type;
use App\finance_invoice_charges_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Permission;

class FinanceInvoiceChargesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
     public function index(Request $request, finance_invoice_charges_type $finance_invoice_charges_type)
    {
        return view('backend/finance-and-management/invoice-charges-types/invoice-charges-types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function indexdt(Request $request, finance_invoice_charges_type $finance_invoice_charges_type)
    {

        $charges = finance_invoice_charges_type::get();
        return DataTables::of($charges)
            ->addColumn('status', function ($charges) {
                if ($charges->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($charges) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/invoice-charges-types/invoice-charges-types-aeu/') . '/' . $charges->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($charges) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/invoice-charges-types/delete') . '/' . $charges->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

    public function index_deleted(Request $request, finance_invoice_charges_type $finance_invoice_charges_type)
    {
        return view('backend/finance-and-management/invoice-charges-types/invoice-charges-types-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_invoice_charges_type $finance_invoice_charges_type)
    {

        $deleted = finance_invoice_charges_type::onlyTrashed()->get();
        return DataTables::of($deleted)


            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/invoice-charges-types/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        $lastval = finance_invoice_charges_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['charges_types_update'] = '';

        return view('backend/finance-and-management.invoice-charges-types.invoice-charges-types-aeu', $data);
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
        $this->validate($request, [
          
            'type' => 'required|unique:finance_invoice_charges_types,type',
            'charges' => 'required',
            'status'   => 'required']);

        $charges_type = finance_invoice_charges_type::create([
          
            'type'   => $request->type,
            'charges'   => $request->charges,
            'status' => $request->status,

        ]);

        $invoice_module = trans_type::create([
            'name'   => $request->type,
            'mod_id' => $charges_type->id,
            'type'   => 2,
            'cash_or_payment'   => 0,
            'details' => 'financeInvoice',
            'table_name' => 'finance_invoice'
        ]);

Permission::create(['name' => $request->type.' '.$charges_type->id,'category'=>19, 'auto_generated' => 1]);

Permission::create(['name' => 'Invoice'.' '.$request->type.' '.$charges_type->id,'category'=>20, 'auto_generated' => 1]);

        if ($charges_type) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/invoice-charges-types/invoice-charges-types-aeu');
            }else{
                return redirect('finance-and-management/invoice-charges-types');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_invoice_charges_type  $finance_invoice_charges_type
     * @return \Illuminate\Http\Response
     */
    public function show(finance_invoice_charges_type $finance_invoice_charges_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_invoice_charges_type  $finance_invoice_charges_type
     * @return \Illuminate\Http\Response
     */
   
   public function edit(finance_invoice_charges_type $finance_invoice_charges_type,$id)
    {
         $data['charges_types_update'] = finance_invoice_charges_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['charges_types_update']->code;

        return view('backend/finance-and-management.invoice-charges-types.invoice-charges-types-aeu', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_invoice_charges_type  $finance_invoice_charges_type
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        $theprename='';
        $theprename=finance_invoice_charges_type::where('id', $id)->get()->pluck('type');
        
        $this->validate($request, [
            'type' => 'required|unique:finance_invoice_charges_types,type,'.$id,
            'charges' => 'required',
            'status'   => 'required']);


if(Permission::where('category',19)->where('name', $theprename[0].' '.$id)->exists())
{
       Permission::where('category',19)->where('name', $theprename[0].' '.$id)->updateWithUserstamps([
            'name'=>$request->type.' '.$id,
            'category'=>19,
            'auto_generated' => 1
        ]);
}
else{
    Permission::create(['name' => $request->type.' '.$id,'category'=>19, 'auto_generated' => 1]);
}
   

      

       
if(Permission::where('category',20)->where('name', 'Invoice'.' '.$theprename[0].' '.$id)->exists())
{
     Permission::where('category',20)->where('name', 'Invoice'.' '.$theprename[0].' '.$id)->updateWithUserstamps([
            'name'=> 'Invoice'.' '.$request->type.' '.$id,
            'category'=>20,
            'auto_generated' => 1
        ]);
}
else{
     Permission::create(['name' => 'Invoice'.' '.$request->type.' '.$id,'category'=>20, 'auto_generated' => 1]);
}
       

        $charges = finance_invoice_charges_type::where('id', $id)->updateWithUserstamps([
            'type'   => $request->type,
            'charges'   => $request->charges,
            'status' => $request->status,
        ]);


if(trans_type::where('type', 2)->where('mod_id', $id)->exists()){
    $invoice_module = trans_type::where('type', 2)->where('mod_id', $id)->updateWithUserstamps([
            'name'   => $request->type,
            'mod_id'   => $id,
            'type'   => 2,
            'cash_or_payment'   => 0,
            'details' => 'financeInvoice',
            'table_name' => 'finance_invoice'
        ]);
}else{
   $invoice_module = trans_type::create([
            'name'   => $request->type,
            'mod_id' => $id,
            'type'   => 2, 
            'cash_or_payment'   => 0,
            'details' => 'financeInvoice',
            'table_name' => 'finance_invoice'
        ]);
}
     

       
        if ($charges) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/invoice-charges-types/invoice-charges-types-aeu/'.$id);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_invoice_charges_type  $finance_invoice_charges_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_invoice_charges_type $finance_invoice_charges_type, $id)
    {
         $data['getname'] = finance_invoice_charges_type::where('id', $id)->first();
        
        $chargestype=$finance_invoice_charges_type::where('id', $id)->deleteWithUserstamps();
        trans_type::where('type',2)->where('mod_id', $id)->deleteWithUserstamps();
Permission::where('category',19)->where('name', $data['getname']->type.' '.$id)->deleteWithUserstamps();
Permission::where('category',20)->where('name', 'Invoice'.' '.$data['getname']->type.' '.$id)->deleteWithUserstamps();
      
        if($chargestype){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('finance-and-management/invoice-charges-types');
    }


public function restore(finance_invoice_charges_type $finance_invoice_charges_type,$id)
    {
        $data['getname'] = finance_invoice_charges_type::onlyTrashed()->where('id', $id)->first();

        $restore = finance_invoice_charges_type::onlyTrashed()->find($id)->restore();
        trans_type::onlyTrashed()->where('type',2)->where('mod_id', $id)->restore();
    Permission::onlyTrashed()->where('category',19)->where('name', $data['getname']->type.' '.$id)->restore();
    Permission::onlyTrashed()->where('category',20)->where('name', 'Invoice'.' '.$data['getname']->type.' '.$id)->restore();
        
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/invoice-charges-types/deleted');

}

}
