<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\maintenance_fee_revenue;
use App\mem_category;
use App\membership;
use DB;
use Session;
use App\mem_status;

class MemMaintenanceFeeRevenueController extends Controller
{

     public function index(Request $request, maintenance_fee_revenue $maintenance_fee_revenue)
    {

       $data['status']=mem_status::where('status',1)->get();
        $data['categories']=mem_category::where('status',1)->get();

        $_members = membership::withoutTrashed();
      $_memcount = membership::wherenotnull('mem_category_id');
      $_memdata = membership::wherenotnull('total_maintenance');
        if($request->get('status')){
            $_members->whereIn('active',$request->get('status'));
            $_memcount->whereIn('active',$request->get('status'));
            $_memdata->whereIn('active',$request->get('status'));
        }

         if($request->get('categories')){
            $_memcount->whereIn('mem_category_id',$request->get('categories'));
            $_memdata->whereIn('mem_category_id',$request->get('categories'));
        }
         $data['members'] =  $_members->get();
        $data['memberscount'] = $_memcount->count();
        $data['membershipdata'] = $_memdata->get()->pluck('total_maintenance')->sum();


    if($request->get('status')){
  $data['stati'] =$request->get('status');
}
else{
  $data['stati']=[];
}

if($request->get('categories')){
$data['cati'] =$request->get('categories');
}
else{
  $data['cati'] =[];
}
//dd($data['stati']);


      //dd($data['membershipdata']);
if($request->get('categories')){
   $data['subs']=mem_category::where('status',1)->whereIn('id',$request->get('categories'))->get();
}
  else{
       $data['subs']=mem_category::where('status',1)->get();
  }

        return view('backend/finance-and-management/maintenance-fee-revenue/maintenance-fee-revenue', $data);
    }

     public function index_membership(Request $request, maintenance_fee_revenue $maintenance_fee_revenue)
    {
        $data['status']=mem_status::where('status',1)->get();
        $data['categories']=mem_category::where('status',1)->get();


      $_members = membership::withoutTrashed();
      $_memcount = membership::wherenotnull('mem_category_id');
      $_memdata = membership::wherenotnull('total');
        if($request->get('status')){
            $_members->whereIn('active',$request->get('status'));
            $_memcount->whereIn('active',$request->get('status'));
            $_memdata->whereIn('active',$request->get('status'));
        }
         if($request->get('categories')){
            $_memcount->whereIn('mem_category_id',$request->get('categories'));
            $_memdata->whereIn('mem_category_id',$request->get('categories'));
        }
         $data['members'] =  $_members->get();
        $data['memberscount'] = $_memcount->count();
        $data['membershipdata'] = $_memdata->get()->pluck('total')->sum();

if($request->get('status')){
  $data['stati'] =$request->get('status');
}
else{
  $data['stati']=[];
}

if($request->get('categories')){
$data['cati'] =$request->get('categories');
}
else{
  $data['cati'] =[];
}
//dd($data['stati']);


      //dd($data['membershipdata']);
if($request->get('categories')){
   $data['subs']=mem_category::where('status',1)->whereIn('id',$request->get('categories'))->get();
}
  else{
       $data['subs']=mem_category::where('status',1)->get();
  }

        return view('backend/finance-and-management/membership-fee-revenue/membership-fee-revenue', $data);
    }

    function calculaterevenue($id){
      $revenue=membership::where('mem_category_id',$id)->get()->pluck('total_maintenance')->sum();
      return $revenue;
    }

/*function calculaterevenue($id){
      $revenue=membership::where('id',$id)->get()->pluck('total_maintenance')->sum();
return view('backend/club-hospitality/maintenance-fee-revenue/maintenance-fee-revenue', $revenue);
    }*/

}
