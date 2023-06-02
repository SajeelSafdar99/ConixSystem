<?php

namespace App\Http\Controllers;

use App\membership;
use App\fnb_item_definition;
use App\fnb_restaurant_location;
use App\fnb_currency;
use App\fnb_item_sub_category;
use App\fnb_item_category;
use App\fnb_item_manufacturer;
use App\fnb_measurement_unit;
use App\fnb_product_classification;
use App\fnb_waitor_definition;
use App\fnb_table_definition;
use App\fnb_predefined_value;
use App\fnb_sales_recipe_subs;
use App\mem_status;
use Illuminate\Http\Request;
use Session;
use DataTables;
use Illuminate\Support\Facades\Auth;
use DB;

class FnbItemDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function itemdefs_vue(Request $request, fnb_item_definition $fnb_item_definition)
    {
       return view('backend/food-and-beverage/item-definitions/item-definitions-aeu-vue');
    }

    public function itemdefs_init_vue(Request $request)
    {

        if($request->get('r')){
            $lastval=fnb_item_definition::find($request->get('r'));
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }

    $lastval['selected_items'] =DB::table('fnb_sales_recipe_subs')
            ->leftJoin('fnb_item_definitions', function ($join) {
              $join->on('fnb_item_definitions.item_code', '=', 'fnb_sales_recipe_subs.item_code')->where('fnb_item_definitions.status',1);
            })
            ->selectRaw('fnb_sales_recipe_subs.*,1 as hid,0 as hdel, fnb_item_definitions.item_details')
              ->where('fnb_sales_recipe_subs.item_id',$num)->where('fnb_sales_recipe_subs.deleted_at',null)->groupBy('fnb_sales_recipe_subs.id')
              ->get();
   
/* $lastval['selected_items']=fnb_sales_recipe_subs::selectRaw('fnb_sales_recipe_subs.*,1 as hid')->where('item_id',$num)->get();*/
        $lastval['predefined']=fnb_predefined_value::get()->first();
         $lastval['catspermit']=Auth::user()->getAllPermissions()->where('category',24)->pluck('name');
        $lastval['subcats']=fnb_item_sub_category::where('status',1)->get();
        $lastval['mains']=fnb_item_category::where('status',1)->get();
        $lastval['manufacturers']=fnb_item_manufacturer::where('status',1)->get();
        $lastval['measurement_units']=fnb_measurement_unit::where('status',1)->get();
        $lastval['products']=fnb_product_classification::where('status',1)->get();

       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $lastval=fnb_item_definition::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }
     $data['catspermit']=Auth::user()->getAllPermissions()->where('category',24)->pluck('name');
        $data['predefined']=fnb_predefined_value::get()->first();
        $data['subcats']=fnb_item_sub_category::where('status',1)->get();
        $data['mains']=fnb_item_category::where('status',1)->get();
        $data['manufacturers']=fnb_item_manufacturer::where('status',1)->get();
        $data['measurement_units']=fnb_measurement_unit::where('status',1)->get();
        $data['products']=fnb_product_classification::where('status',1)->get();
$data['maxcode']=fnb_item_definition::max('item_code');
 
  //dd($data['maxcode']);
     return $data;
 }


}


    public function save(Request $request){
   


    if (fnb_item_definition::where('item_code', $request->get('item_code') )->count() != 0) {

        abort(500);
        }

        else{



//        dd($request->all());
        $lastval=fnb_item_definition::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }



        $d=[];

       $d['salable']= $request->get('salable');
        $d['purchasable']=$request->get('purchasable');
        $d['returnable']=$request->get('returnable');

        $d['category']=$request->get('category');
        $d['sub_category']=$request->get('sub_category');
        $d['manufacturer']=$request->get('manufacturer');

        $d['item_code']=$request->get('item_code');
         $d['item_details']=$request->get('item_details');
    //  $d['opening_stock']=$request->get('opening_stock');
        $d['purchase_price']=$request->get('purchase_price');
        $d['sale_price']=$request->get('sale_price');

        $d['unit']=$request->get('unit');

        $d['discountable']=$request->get('discountable');
        $d['taxable']=$request->get('taxable');
        $d['discount_amount']=$request->get('discount_amount');

         $d['discount_percentage']=$request->get('discount_percentage');
        $d['product_classification']=$request->get('product_classification');

        $d['status']=$request->get('status');
        $d['remarks']=$request->get('remarks');

          $d['coa_code']=$request->get('coa_code');
      
      $id=  fnb_item_definition::create($d);


      foreach($request->get('selected_items') as $inv){
//       var_dump($inv);
          $m=  fnb_sales_recipe_subs::create([
            'item_id'=>$id->id,
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
               'purchase_price'=>$inv['purchase_price'],
                'unit'=>$inv['unit'],
                'sub_total_price'=>$inv['product'],
               
            ]);
        }

return $id->id;
         /* return $m->kot_no;*/

//      dd();

 }

    }
     public function updated(Request $request){



    if (fnb_item_definition::where('id','!=',$request->get('id'))->where('item_code', $request->get('item_code') )->count() != 0) {

        abort(500);
        }

        else{

        $lastval=fnb_item_definition::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }


        $d=[];

       $d['salable']= $request->get('salable');
        $d['purchasable']=$request->get('purchasable');
        $d['returnable']=$request->get('returnable');

        $d['category']=$request->get('category');
        $d['sub_category']=$request->get('sub_category');
        $d['manufacturer']=$request->get('manufacturer');

        $d['item_code']=$request->get('item_code');
         $d['item_details']=$request->get('item_details');
   //   $d['opening_stock']=$request->get('opening_stock');
        $d['purchase_price']=$request->get('purchase_price');
        $d['sale_price']=$request->get('sale_price');

        $d['unit']=$request->get('unit');

        $d['discountable']=$request->get('discountable');
        $d['taxable']=$request->get('taxable');
        $d['discount_amount']=$request->get('discount_amount');

         $d['discount_percentage']=$request->get('discount_percentage');
        $d['product_classification']=$request->get('product_classification');

        $d['status']=$request->get('status');
        $d['remarks']=$request->get('remarks');
         $d['coa_code']=$request->get('coa_code');

      $id=  fnb_item_definition::where('id',$request->get('id'))->updateWithUserstamps($d);
//      dd();

foreach($request->get('selected_items') as $inv){
//            dd($inv);

if(isset($inv['hid'])){

    if($inv['hdel']==1){
        $m =fnb_sales_recipe_subs::where('id',$inv['id'])->deleteWithUserstamps();
    }else{
          $m =fnb_sales_recipe_subs::where('id',$inv['id'])->updateWithUserstamps([
              'item_id'=>$request->get('id'),
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                'purchase_price'=>$inv['purchase_price'],
                'unit'=>$inv['unit'],
                 'sub_total_price'=>$inv['product'],
          ]);
    }
 
         

        }
        else{
 $m= fnb_sales_recipe_subs::create([
            'item_id'=>$request->get('id'),
               'item_code'=>$inv['item_code'],
               'qty'=>$inv['qty'],
                'purchase_price'=>$inv['purchase_price'],
                'unit'=>$inv['unit'],
                 'sub_total_price'=>$inv['product'],
               
            ]);
     
}

}

}
    }

  public function edit_vue(fnb_item_definition $fnb_item_definition,$id)
    {
     $data['id']=$id;
          $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/food-and-beverage.item-definitions.item-definitions-aeu-vue', $data);
    }









     public function index_vue(Request $request, fnb_item_definition $fnb_item_definition)
    {
       return view('backend/food-and-beverage/item-definitions/item-definitions-vue');
    }

       public function init_vue(Request $request)
    {

  $data['items'] =\Illuminate\Support\Facades\DB::select(

      'select fnb_item_definitions.id,
      fnb_item_definitions.remarks,
      fnb_item_categories.desc as cate,
      fnb_item_sub_categories.desc as subcat,
      fnb_item_manufacturers.desc as manufacturer ,
        fnb_item_definitions.item_code,
        fnb_item_definitions.item_details,
        fnb_item_definitions.opening_stock,
         fnb_item_definitions.purchase_price,
        fnb_item_definitions.sale_price,
         fnb_product_classifications.desc as product,
        fnb_item_definitions.status as activestatus

FROM fnb_item_definitions


left outer join fnb_item_categories on fnb_item_categories.id=fnb_item_definitions.category
left outer join fnb_item_sub_categories on fnb_item_sub_categories.id=fnb_item_definitions.sub_category
left outer join fnb_item_manufacturers on fnb_item_manufacturers.id=fnb_item_definitions.manufacturer
left outer join fnb_product_classifications on fnb_product_classifications.id=fnb_item_definitions.product_classification

where fnb_item_definitions.deleted_at is null group by fnb_item_definitions.id order by fnb_item_definitions.id desc');

  $data['cats']=fnb_item_category::where('status',1)->get();
  $data['subcats']=fnb_item_sub_category::where('status',1)->get();
  $data['item_defs']=fnb_item_definition::get();

     return $data;
}


     public function index(Request $request, fnb_item_definition $fnb_item_definition)
    {
         $data['cats']=fnb_item_category::where('status',1)->get();
        $data['subcats']=fnb_item_sub_category::where('status',1)->get();
        $data['items']=fnb_item_definition::get();
         return view('backend/food-and-beverage/item-definitions/item-definitions',$data);
    }

    public function indexdt(Request $request, fnb_item_definition $fnb_item_definition)
    {

 $item=fnb_item_definition::query();
   if($request->get('item_code')){
            $item->where('item_code',$request->get('item_code'));
        }

        if($request->get('item_details')){
            $item->where('id',$request->get('item_details'));
        }

if($request->get('cat')){
            $item->where('category',$request->get('cat'));

        }
if($request->get('subcat')){
            $item->where('sub_category',$request->get('subcat'));

        }
        if($request->get('item')){
            $item->where('id',$request->get('item'));

        }

if($request->get('status')){
    if($request->get('status')=='Active'){
         $item->where('status',1);
    }
    else if($request->get('status')=='In-Active')
           
 $item->where('status',0);
        }



  $fnb_item_definitions = $item->get();

      /* $fnb_item_definitions = fnb_item_definition::get();*/
       return DataTables::of($fnb_item_definitions)

         ->addColumn('status', function ($fnb_item_definitions) {
               if($fnb_item_definitions->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })

        ->addColumn('category', function ($fnb_item_definitions) {
         
                
                if($fnb_item_definitions->category){
                  return salescategory($fnb_item_definitions->category);
                  }
                else{
                    return '';
                }
                })

        ->addColumn('sub_category', function ($fnb_item_definitions) {
           if($fnb_item_definitions->sub_category){
                  return salessubcategory($fnb_item_definitions->sub_category);
                  }
                else{
                    return '';
                }
                  
                })

        ->addColumn('manufacturer', function ($fnb_item_definitions) {
           if($fnb_item_definitions->manufacturer){
                  return salesmanufacturer($fnb_item_definitions->manufacturer);
                  }
                else{
                    return '';
                }

                })

        ->addColumn('product_classification', function ($fnb_item_definitions) {
          if($fnb_item_definitions->product_classification){
                  return salesproductclass($fnb_item_definitions->product_classification);
                  }
                else{
                    return '';
                }

                 
                })

        ->addColumn('editbutton', function ($fnb_item_definitions) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/item-definitions/item-definitions-aeu/').'/'.$fnb_item_definitions->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_item_definitions) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/item-definitions/delete') . '/' . $fnb_item_definitions->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

    ->rawColumns(['editbutton','deletebutton','category','sub_category', 'manufacturer','product_classification', 'status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_item_definition $fnb_item_definition)
    {
        return view('backend/food-and-beverage/item-definitions/item-definitions-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_item_definition $fnb_item_definition)
    {

        $table = fnb_item_definition::onlyTrashed()->get();
        return DataTables::of($table)

         ->addColumn('status', function ($table) {
               if($table->status==1){
return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
               }else{
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
               }
            })

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/item-definitions/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

          ->addColumn('category', function ($table) {
         
                
                if($table->category){
                  return salescategory($table->category);
                  }
                else{
                    return '';
                }
                })

        ->addColumn('sub_category', function ($table) {
           if($table->sub_category){
                  return salessubcategory($table->sub_category);
                  }
                else{
                    return '';
                }
                  
                })

        ->addColumn('manufacturer', function ($table) {
           if($table->manufacturer){
                  return salesmanufacturer($table->manufacturer);
                  }
                else{
                    return '';
                }

                })

        ->addColumn('product_classification', function ($table) {
          if($table->product_classification){
                  return salesproductclass($table->product_classification);
                  }
                else{
                    return '';
                }

                 
                })

        ->rawColumns(['restorebutton', 'category','sub_category', 'manufacturer','product_classification', 'status'])
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
      $lastval=fnb_item_definition::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['item_def_update'] = '';

       $data['predefined']=fnb_predefined_value::get()->first();
       //dd($data['predefined']);

        $data['subcats']=fnb_item_sub_category::where('status',1)->get();
        $data['mains']=fnb_item_category::where('status',1)->get();
        $data['manufacturers']=fnb_item_manufacturer::where('status',1)->get();
        $data['measurement_units']=fnb_measurement_unit::where('status',1)->get();
        $data['products']=fnb_product_classification::where('status',1)->get();

     return view('backend/food-and-beverage.item-definitions.item-definitions-aeu',$data);

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
            'category'   =>  'required',
            'sub_category'   =>  'required',
            'item_code' => 'required|unique:fnb_item_definitions,item_code',
            'item_details'   =>  'required|unique:fnb_item_definitions,item_details',
            'sale_price'   =>  'required',
            'unit'   =>  'required',
            'product_classification'   =>  'required',
            'status'   =>  'required'
        ]);


       $store=fnb_item_definition::create([
        'category'=>$request->category,
            'sub_category'=>$request->sub_category,
            'manufacturer'=>$request->manufacturer,
            'item_code'=>$request->item_code,
            'item_details'=>$request->item_details,
            'opening_stock'=>$request->opening_stock,
            'purchase_price'=>$request->purchase_price,
            'sale_price'=>$request->sale_price,
            'unit'=>$request->unit,
            'discountable'=>$request->discountable,
            'taxable'=>$request->taxable,
            'salable'=>$request->salable,
            'purchasable'=>$request->purchasable,
            'returnable'=>$request->returnable,
            'discount_amount'=>$request->discount_amount,
            'discount_percentage'=>$request->discount_percentage,
            'product_classification'=>$request->product_classification,
            'status'=>$request->status,
            'remarks'=>$request->remarks
            ]);

            if($store)
            {
                Session::flash('message', 'Data Entered Successfully !');
                Session::flash('alert-class', 'alert-success');
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
            }

            //echo $message;
             if(empty($save))
            {
                return redirect('food-and-beverage/item-definitions/item-definitions-aeu');
            }else{
                return redirect('food-and-beverage/item-definitions');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_item_definition  $fnb_item_definition
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_item_definition $fnb_item_definition)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_item_definition  $fnb_item_definition
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_item_definition $fnb_item_definition, $id)
    {
        $data['item_def_update'] = fnb_item_definition::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['item_def_update']->code;

        $data['subcats']=fnb_item_sub_category::where('status',1)->get();
        $data['mains']=fnb_item_category::where('status',1)->get();
        $data['manufacturers']=fnb_item_manufacturer::where('status',1)->get();
        $data['measurement_units']=fnb_measurement_unit::where('status',1)->get();
        $data['products']=fnb_product_classification::where('status',1)->get();

        return view('backend/food-and-beverage.item-definitions.item-definitions-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_item_definition  $fnb_item_definition
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category'   =>  'required',
            'sub_category'   =>  'required',
            'item_code' => 'required|unique:fnb_item_definitions,item_code,'.$id,
            'item_details'   => 'required|unique:fnb_item_definitions,item_details,'.$id,
            'sale_price'   =>  'required',
            'unit'   =>  'required',
            'product_classification'  =>  'required',
            'status'   =>  'required'
            ]);

        $update = fnb_item_definition::where('id', $id)->updateWithUserstamps([
           'category'=>$request->category,
            'sub_category'=>$request->sub_category,
            'manufacturer'=>$request->manufacturer,
            'item_code'=>$request->item_code,
            'item_details'=>$request->item_details,
            'opening_stock'=>$request->opening_stock,
            'purchase_price'=>$request->purchase_price,
            'sale_price'=>$request->sale_price,
            'unit'=>$request->unit,
            'discountable'=>$request->discountable,
            'taxable'=>$request->taxable,
            'salable'=>$request->salable,
            'purchasable'=>$request->purchasable,
            'returnable'=>$request->returnable,
            'discount_amount'=>$request->discount_amount,
            'discount_percentage'=>$request->discount_percentage,
            'product_classification'=>$request->product_classification,
            'status'=>$request->status,
            'remarks'=>$request->remarks
        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/item-definitions/item-definitions-aeu/'.$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_item_definition  $fnb_item_definition
     * @return \Illuminate\Http\Response
     */
       public function destroy(Request $request,fnb_item_definition $fnb_item_definition,$id)
    {
    
     $update= fnb_item_definition::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$fnb_item_definition::where('id', $id)->deleteWithUserstamps();
    }
   /* public function destroy(fnb_item_definition $fnb_item_definition,$id)
    {

        $destroy=$fnb_item_definition::where('id', $id)->deleteWithUserstamps();
        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('food-and-beverage/item-definitions');
    }*/

public function restore(fnb_item_definition $fnb_item_definition,$id)
    {
        $restore = fnb_item_definition::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/item-definitions/deleted');

}


}

