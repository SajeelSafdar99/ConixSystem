<?php

namespace App\Http\Controllers;
use App\trans_type;
use App\finance_voucher_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Permission;


class FinanceVoucherTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, finance_voucher_type $finance_voucher_type)
    {
        return view('backend/finance-and-management/finance-voucher-types/finance-voucher-types');
    }

    public function indexdt(Request $request, finance_voucher_type $finance_voucher_type)
    {

        $voucher_type = finance_voucher_type::get();
        return DataTables::of($voucher_type)
            ->addColumn('status', function ($voucher_type) {
                if ($voucher_type->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }
            })


             ->addColumn('category', function ($voucher_type) {
                if($voucher_type->debit == 1 && $voucher_type->credit == 1) {
                    return "Debit,Credit";
                } else if($voucher_type->credit == 1) {
                    return "Credit";
                }
                else if($voucher_type->debit == 1) {
                    return "Debit";
                }
            })


            ->addColumn('editbutton', function ($voucher_type) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-voucher-types/finance-voucher-types-aeu/') . '/' . $voucher_type->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($voucher_type) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-voucher-types/delete') . '/' . $voucher_type->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


 public function index_deleted(Request $request, finance_voucher_type $finance_voucher_type)
    {
        return view('backend/finance-and-management/finance-voucher-types/finance-voucher-types-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_voucher_type $finance_voucher_type)
    {

        $voucher_type = finance_voucher_type::onlyTrashed()->get();
        return DataTables::of($voucher_type)


            ->addColumn('restorebutton', function ($voucher_type) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-voucher-types/restore/') . '/' . $voucher_type->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

            ->addColumn('category', function ($voucher_type) {
                if($voucher_type->debit == 1 && $voucher_type->credit == 1) {
                    return "Debit,Credit";
                } else if($voucher_type->credit == 1) {
                    return "Credit";
                }
                else if($voucher_type->debit == 1) {
                    return "Debit";
                }
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
        $lastval = finance_voucher_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['voucher_type_update'] = '';

        return view('backend/finance-and-management.finance-voucher-types.finance-voucher-types-aeu', $data);
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
     $validation=[
            'desc' => 'required|unique:finance_voucher_types,desc',

            'status'   => 'required'
        ];

         if($request->get('debit')=='' && $request->get('credit')==''){
            $validation['category']='required';
        }

        $this->validate($request, $validation);

        $voucher_type = finance_voucher_type::create([

            'desc'   => $request->desc,
            'debit'   => $request->debit,
            'credit'   => $request->credit,
            'status' => $request->status

        ]);

         $transtype = trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $voucher_type->id,
            'type'   => 4,
            'cash_or_payment'   => 1,
            'details' => 'JVinvoice',
            'table_name' => 'finance_general_voucher'
        ]);



if($transtype){
    Permission::create(['name' => $request->desc.' '.$voucher_type->id,'category'=>21,'auto_generated' => 1]);
}


        if ($voucher_type) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-voucher-types/finance-voucher-types-aeu');
            }else{
                return redirect('finance-and-management/finance-voucher-types');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_voucher_type  $finance_voucher_type
     * @return \Illuminate\Http\Response
     */
    public function show(finance_voucher_type $finance_voucher_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_voucher_type  $finance_voucher_type
     * @return \Illuminate\Http\Response
     */
     public function edit(finance_voucher_type $finance_voucher_type,$id)
    {
         $data['voucher_type_update'] = finance_voucher_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['voucher_type_update']->code;

        return view('backend/finance-and-management.finance-voucher-types.finance-voucher-types-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_voucher_type  $finance_voucher_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $theprename='';
        $theprename=finance_voucher_type::where('id', $id)->get()->pluck('desc');
        
        $validation=[
            'desc' => 'required|unique:finance_voucher_types,desc,'.$id,
            'status'   => 'required'
        ];

         if($request->get('debit')=='' && $request->get('credit')==''){
            $validation['category']='required';
        }

        $this->validate($request, $validation);

if(Permission::where('category',21)->where('name', $theprename[0].' '.$id)->exists()){
    Permission::where('category',21)->where('name', $theprename[0].' '.$id)->update([
            'name'=>$request->desc.' '.$id,
            'category'=>21,
            'auto_generated' => 1
        ]);
}
else{
    Permission::create(['name' => $request->desc.' '.$id,'category'=>21,'auto_generated' => 1]);
}

        $voucher_type = finance_voucher_type::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'debit'   => $request->debit,
            'credit'   => $request->credit,
            'status' => $request->status,
        ]);

if(trans_type::where('type',4)->where('mod_id', $id)->exists()){
       $transtype = trans_type::where('type',4)->where('mod_id', $id)->updateWithUserstamps([
            'name'   => $request->desc,
            'mod_id'   => $id,
            'type'   => 4,
            'cash_or_payment'   => 1,
            'details' => 'JVinvoice',
            'table_name' => 'finance_general_voucher'
        ]);
   }
   else
   {
          $transtype = trans_type::create([
            'name'   => $request->desc,
            'mod_id' => $id,
            'type'   => 4,
            'cash_or_payment'   => 1,
            'details' => 'JVinvoice',
            'table_name' => 'finance_general_voucher'
        ]);
   }

        if ($voucher_type) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-voucher-types/finance-voucher-types-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_voucher_type  $finance_voucher_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_voucher_type $finance_voucher_type,$id)
    {
        $getname = finance_voucher_type::where('id', $id)->get()->pluck('desc');
         $getnamedesc =$getname[0];

        $voucher_type=$finance_voucher_type::where('id', $id)->deleteWithUserstamps();

if(trans_type::where('type',4)->where('mod_id', $id)->exists()){
       trans_type::where('type',4)->where('mod_id', $id)->deleteWithUserstamps();
}

if(Permission::where('category',21)->where('name', $getnamedesc.' '.$id)->exists()){
            Permission::where('category',21)->where('name', $getnamedesc.' '.$id)->deleteWithUserstamps();
        }

        if($voucher_type){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
         }


        return redirect('finance-and-management/finance-voucher-types');
    }


public function restore(finance_voucher_type $finance_voucher_type,$id)
    {
        $getname = finance_voucher_type::onlyTrashed()->where('id', $id)->get()->pluck('desc');
         $getnamedesc =$getname[0];

        $restore = finance_voucher_type::onlyTrashed()->find($id)->restore();

        if(trans_type::onlyTrashed()->where('type',4)->where('mod_id', $id)->exists()){
            trans_type::onlyTrashed()->where('type',4)->where('mod_id', $id)->restore();
        }

        if(Permission::onlyTrashed()->where('category',21)->where('name', $getnamedesc.' '.$id)->exists()){
            Permission::onlyTrashed()->where('category',21)->where('name', $getnamedesc.' '.$id)->restore();
        }

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-voucher-types/deleted');

}

}
