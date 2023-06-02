<?php

namespace App\Http\Controllers;

use App\fnb_predefined_value;
use App\store_department;
use App\fnb_restaurant_location;
use App\fnb_currency;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\trans_type;
use App\coa_account;

class PredefinedValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, fnb_predefined_value $fnb_predefined_value)
    {
         $data['records'] = fnb_predefined_value::count();
         //dd($records);
         return view('backend/admin-settings/predefined-values/predefined-values', $data);
    }

    public function indexdt(Request $request, fnb_predefined_value $fnb_predefined_value)
    {


     $predefined_values = fnb_predefined_value::get();
       return DataTables::of($predefined_values)
       ->addColumn('status', function ($predefined_values) {
               if($predefined_values->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })


       ->addColumn('currency', function ($predefined_values) {
                if($predefined_values->currency){
                 $cur=fnb_currency::where('id',$predefined_values->currency)->where('status',1)->get();
                  return $cur[0]['code'];
                   }
                else{
                    return '';
                }
                })


        ->addColumn('store_location', function ($predefined_values) {
           if($predefined_values->store_location){
                  return salesrestaurantname($predefined_values->store_location);
                  }
                else{
                    return '';
                }

                })

        ->addColumn('department', function ($predefined_values) {
           if($predefined_values->department){
                  return storeDepartmentName($predefined_values->department);
                  }
                else{
                    return '';
                }

                })


        ->addColumn('editbutton', function ($predefined_values) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('admin-settings/predefined-values/predefined-values-aeu/').'/'.$predefined_values->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($predefined_values) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('admin-settings/predefined-values/delete') . '/' . $predefined_values->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_predefined_value $fnb_predefined_value)
    {
        return view('backend/admin-settings/predefined-values/predefined-values-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function indexdt_deleted(Request $request, fnb_predefined_value $fnb_predefined_value)
    {

        $table = fnb_predefined_value::onlyTrashed()->get();
        return DataTables::of($table)


         ->addColumn('currency', function ($table) {
                if($table->currency){
                 $cur=fnb_currency::where('id',$table->currency)->where('status',1)->get();
                  return $cur[0]['code'];
                   }
                else{
                    return '';
                }
                })


 ->addColumn('store_location', function ($table) {
           if($table->store_location){
                  return salesrestaurantname($table->store_location);
                  }
                else{
                    return '';
                }

                })

        ->addColumn('department', function ($table) {
           if($table->department){
                  return storeDepartmentName($table->department);
                  }
                else{
                    return '';
                }

                })

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('admin-settings/predefined-values/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
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
      $lastval=fnb_predefined_value::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['values_update'] = '';
       $data['currencies']=fnb_currency::where('status',1)->get();
      $data['locations']=fnb_restaurant_location::where('status',1)->get();
       $data['departments']=store_department::where('status',1)->get();

       $data['trans_types']=trans_type::where('cash_or_payment',0)->get();

        $data['cost_centers']=coa_account::where('desc','!=',null)->get();

     return view('backend/admin-settings.predefined-values.predefined-values-aeu',$data);

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
            'fnb_due' => 'required',
            'rooms_due' => 'required',
            'cashrec_due' => 'required',
        ];

       if($request->get('discount_amount')=='' && $request->get('discount_percentage')=='' && $request->get('tax_amount')=='' && $request->get('tax_percentage')=='' && $request->get('service_amount')=='' && $request->get('service_percentage')=='' && $request->get('take_away_tax')=='' && $request->get('take_away_tax_pct')=='' && $request->get('home_del_tax')=='' && $request->get('home_del_tax_pct')==''){
            $validation['Predefined_Values']='required';
        }

        $this->validate($request, $validation);

       $store=fnb_predefined_value::create([
            'discount_amount'=>$request->discount_amount,
            'discount_percentage'=>$request->discount_percentage,
            'tax_amount'=>$request->tax_amount,
            'tax_percentage'=>$request->tax_percentage,

            'take_away_tax'=>$request->take_away_tax,
            'take_away_tax_pct'=>$request->take_away_tax_pct,
            'home_del_tax'=>$request->home_del_tax,
            'home_del_tax_pct'=>$request->home_del_tax_pct,

            'service_amount'=>$request->service_amount,
            'service_percentage'=>$request->service_percentage,
            'printer'=>$request->printer,
            'xp_printer'=>$request->xp_printer,
             'xp_printer_two'=>$request->xp_printer_two,
               'print_limit'=>$request->print_limit,
            'currency'=>$request->currency,
            'store_location'=>$request->store_location,
            'department'=>$request->department,
            'default_hours'=>$request->default_hours,
            'default_offs'=>$request->default_offs,
            'include_overtime'=>$request->include_overtime,

            'fnb_due'=>formatDate($request->fnb_due),
            'rooms_due'=>formatDate($request->rooms_due),
            'cashrec_due'=>formatDate($request->cashrec_due),
            'cost_center'=>$request->cost_center,
        ]);

         $typies=$request['trans_type'];
        if(isset($typies)){
            foreach($typies as $typi){
if(trans_type::where('id', '=', $typi)->exists()){
       trans_type::where('id', '=', $typi)->updateWithUserstamps([
              'cashrec_due'=>formatDate($request->cashrec_due)
        ]);
}
            }
        }


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
                return redirect('admin-settings/predefined-values/predefined-values-aeu');
            }else{
                return redirect('admin-settings/predefined-values');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_predefined_value  $fnb_predefined_value
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_predefined_value $fnb_predefined_value)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_predefined_value  $fnb_predefined_value
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_predefined_value $fnb_predefined_value, $id)
    {
        $data['values_update'] = fnb_predefined_value::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['values_update']->code;
        $data['currencies']=fnb_currency::where('status',1)->get();
        $data['locations']=fnb_restaurant_location::where('status',1)->get();
       $data['departments']=store_department::where('status',1)->get();

           $data['trans_types']=trans_type::where('cash_or_payment',0)->get();
    $data['selected']=trans_type::where('cash_or_payment',0)->where('cashrec_due',$data['values_update']->cashrec_due)->get()->pluck('id')->toArray();

 $data['cost_centers']=coa_account::where('desc','!=',null)->get();

         return view('backend/admin-settings.predefined-values.predefined-values-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_predefined_value  $fnb_predefined_value
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {

      /*  dd($request->trans_type);*/

       $validation=[
            'fnb_due' => 'required',
            'rooms_due' => 'required',
            'cashrec_due' => 'required',
        ];

        if($request->get('discount_amount')=='' && $request->get('discount_percentage')=='' && $request->get('tax_amount')=='' && $request->get('tax_percentage')=='' && $request->get('service_amount')=='' && $request->get('service_percentage')=='' && $request->get('take_away_tax')=='' && $request->get('take_away_tax_pct')=='' && $request->get('home_del_tax')=='' && $request->get('home_del_tax_pct')==''){
            $validation['Predefined_Values']='required';
        }

        $this->validate($request, $validation);

        $update = fnb_predefined_value::where('id', $id)->updateWithUserstamps([
           'discount_amount'=>$request->discount_amount,
            'discount_percentage'=>$request->discount_percentage,
            'tax_amount'=>$request->tax_amount,
            'tax_percentage'=>$request->tax_percentage,

            'take_away_tax'=>$request->take_away_tax,
            'take_away_tax_pct'=>$request->take_away_tax_pct,
            'home_del_tax'=>$request->home_del_tax,
            'home_del_tax_pct'=>$request->home_del_tax_pct,

            'service_amount'=>$request->service_amount,
            'service_percentage'=>$request->service_percentage,
            'printer'=>$request->printer,
            'xp_printer'=>$request->xp_printer,
              'xp_printer_two'=>$request->xp_printer_two,
               'print_limit'=>$request->print_limit,
            'currency'=>$request->currency,
             'store_location'=>$request->store_location,
            'department'=>$request->department,
            'default_hours'=>$request->default_hours,
            'default_offs'=>$request->default_offs,
            'include_overtime'=>$request->include_overtime,

              'fnb_due'=>formatDate($request->fnb_due),
              'rooms_due'=>formatDate($request->rooms_due),
               'cashrec_due'=>formatDate($request->cashrec_due),
               'cost_center'=>$request->cost_center,
        ]);


         $typies=$request['trans_type'];
        if(isset($typies)){
            foreach($typies as $typi){
if(trans_type::where('id', '=', $typi)->exists()){
       trans_type::where('id', '=', $typi)->updateWithUserstamps([
              'cashrec_due'=>formatDate($request->cashrec_due)
        ]);
}
            }
        }



        Session::forget('settings');

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('admin-settings/predefined-values/predefined-values-aeu/'.$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_predefined_value  $fnb_predefined_value
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_predefined_value $fnb_predefined_value,$id)
    {

        $destroy=$fnb_predefined_value::where('id', $id)->deleteWithUserstamps();
        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('admin-settings/predefined-values');
    }

public function restore(fnb_predefined_value $fnb_predefined_value,$id)
    {
        $restore = fnb_predefined_value::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('admin-settings/predefined-values/deleted');

}

}
