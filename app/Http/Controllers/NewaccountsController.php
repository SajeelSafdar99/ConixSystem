<?php

namespace App\Http\Controllers;

use App\coa_accounts_cat;
use App\coa_accounts_control;
use App\coa_account;
use Illuminate\Http\Request;
use App\admin_company_profile;
use App\coa_trans_types;
use DataTables;
use Session;

class NewaccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index_vue(Request $request, coa_accounts_control $coa_accounts_control)
    {
         return view('backend/finance-and-management/COA/COA-listing-vue');
    }
       public function init_vue(Request $request)
    {

  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select coa_accounts_controls.*,
      coa.name as parentname,
      coa_accounts_cat.name as categoryname,
      coa_accounts.name as costcentername

from coa_accounts_controls
left outer join coa_accounts_controls as coa on coa.code=coa_accounts_controls.parent
 left outer join coa_accounts_cat on coa_accounts_cat.id=coa_accounts_controls.category_id
 left outer join coa_accounts on coa_accounts.code=coa_accounts_controls.cost_center
 
where coa_accounts_controls.deleted_at is null group by coa_accounts_controls.id order by coa_accounts_controls.id desc');
  $data['ccs']=coa_account::get();
   $data['categories']=coa_accounts_cat::get();
     return $data;

}




    public function index()
    {
        return view('backend/finance-and-management/COA/COA-new');
    }

     public function index_deleted(Request $request, coa_accounts_control $coa_accounts_control)
    {
        return view('backend/finance-and-management/COA/COA-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, coa_accounts_control $coa_accounts_control)
    {

        $table = coa_accounts_control::onlyTrashed()->get();
        return DataTables::of($table)


          ->addColumn('category_id', function ($table) {
              return coacategoryname($table->category_id);
            })


            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('COA-new/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton' ])
        ->addIndexColumn()
        ->make(true);
    }


 public function restore(coa_accounts_control $coa_accounts_control,$id)
    {
        $restore = coa_accounts_control::onlyTrashed()->find($id)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('COA-new/deleted');

}


    public function f($code){
        $z='';
        for($x=0;$x<=2-strlen($code);$x++){
            $z.='0';
        }
        return $z.$code;
    }


    public function api($action, Request $request)
    {
        if ($action == '1') {
//            coa_account::where()
            $code = 0;
            $acc = coa_account::level(1)->orderBy('code', 'desc')->first();
            if ($acc) {
                $code = $acc->code;

            }

            coa_account::create([
                'code' => $this->f($code + 1),
                'name' => $request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::level(1)->get();
        }
        if($action =='2'){
            $code=0;
            $acc=coa_account::level(2)->where('code','like',$request->level.'%')->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
                'desc'=>$request->get('level'),
            ]);
            return coa_account::level(2)->get();
        }
        if($action =='3'){
            $code=0;
            $acc=coa_account::level(3)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::level(3)->plevel($request->get('level'))->get();
        } if($action =='4'){
            $code=0;
            $acc=coa_account::level(4)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::level(4)->plevel($request->get('level'))->get();
        }
        if($action =='5'){
            $code=0;
            $acc=coa_account::levelg(5)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);


            }

            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::levelg(5)->plevel(substr($request->get('level'),0,3))->get();
        }
    }

     public function api_update($action, Request $request)
    {
        if ($action == '1') {

        coa_account::where('code',$request->get('code'))->updateWithUserstamps([
           'name' => $request->get('name'),
        ]);


            return coa_account::level(1)->get();
        }
        if($action =='2'){ 

         coa_account::where('code',$request->get('code'))->updateWithUserstamps([
           'name' => $request->get('name'),
           'desc' => $request->get('parent'),
         ]);

            return coa_account::level(2)->get();
        }
        if($action =='3'){
            $code=0;
            $acc=coa_account::level(3)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::level(3)->plevel($request->get('level'))->get();
        } if($action =='4'){
            $code=0;
            $acc=coa_account::level(4)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::level(4)->plevel($request->get('level'))->get();
        }
        if($action =='5'){
            $code=0;
            $acc=coa_account::levelg(5)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);


            }

            coa_account::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return coa_account::levelg(5)->plevel(substr($request->get('level'),0,3))->get();
        }
    }



      public function api_delete($action, Request $request)
    {
        if ($action == '1') {

        coa_account::where('code',$request->get('code'))->deleteWithUserstamps();

            return coa_account::level(1)->get();
        }
        if($action =='2'){

          coa_account::where('code',$request->get('code'))->deleteWithUserstamps();

            return coa_account::level(2)->get();
        }

    }

     public function apidelete(coa_accounts_control $coa_accounts_control,$id)
    {
         $delete=$coa_accounts_control::where('id',$id)->deleteWithUserstamps();
    }


    public function defaultAcc($action)
    {
        $code = 0;
        $defaults = ["Assets" => [
            "Cash and Bank"=>[],
            "Money in Transit"=>[],
            "Expected Payments from Customers"=>[],
            "Inventory"=>[],
            "Property, Plant, Equipment"=>[],
            "Depreciation and Amortization"=>[],
            "Vendor Prepayments and Vendor Credits"=>[],
            "Other Short-Term Asset"=>[],
            "Other Long-Term Asset"=>[]

        ],
            "Liabilities & Credit Cards" => [
                "Credit Card"=>[],
                "Loan and Line of Credit"=>[],
                "Expected Payments to Vendors"=>[],
                "Sales Taxes"=>[],
                "Due For Payroll"=>[],
                "Due to You and Other Business Owners"=>[],
                "Customer Prepayments and Customer Credits"=>[],
                "Other Short-Term Liability"=>[],
                "Other Long-Term Liability"=>[],

            ],
            "Income" => [
                "Income"=>[],
                "Discount"=>[],
                "Uncategorized Income"=>[],
                "Gain On Foreign Exchange"=>[],
            ],
            "Expense" => [
                "Operating Expense" => [
                    "Accounting Fees",
                    "Advertising & Promotion",
                    "Bank Service Charges",
                    "Computer – Hardware",
                    "Computer – Hosting",
                    "Computer – Internet",
                    "Computer – Software",
                    "Depreciation Expense",
                    "Dues & Subscriptions",
                    "Equipment Lease or Rental",
                    "Insurance – Vehicles",
                    "Interest Expense",
                    "Meals and Entertainment",
                    "Office Supplies",
                    "Postage & Delivery",
                    "Professional Fees",
                    "Rent Expense",
                    "Repairs & Maintenance",
                    "Telephone – Land Line",
                    "Telephone – Wireless",
                    "Travel Expense",
                    "Vehicle – Fuel",
                    "Vehicle – Repairs & Maintenance",
                ],
                "Payroll Expense" => [
                    "Payroll – Employee Benefits"
                    , "Payroll – Employer's Share of Benefits"
                    , "Payroll – Salary & Wages"
                    , "Uncategorized Expense"

                ],
                "Loss On Foreign Exchange"=>['Loss on Foreign Exchange'],

            ],
            "Equity"=>[
                "Business Owner Contribution and Drawing"=>['Owner Investment / Drawings'],
            "Retained Earnings: Profit"=>["Owner's Equity"]

            ]];
$x=0;
$y=0;
$z=0;
//return ($defaults['Expense']["Operating Expense"]);
        foreach (array_keys($defaults) as $d) {

            $y=0;
            $z=0;
            $c = $action .'-'. ($x=$this->f($x + 1));
            coa_account::create([
                'name' => $d,
                'code' => $c
            ]);

            foreach(array_keys($defaults[$d]) as $m){

                $z=0;
                $b=$c .'-'. ($y=$this->f($y + 1));
                coa_account::create([
                    'name' => $m,
                    'code' => $b
                ]);
                foreach($defaults[$d][$m] as $n){
                    $a=$b.'-'. ($z=$this->f($z + 1));
                    coa_account::create([
                        'name' => $n,
                        'code' => $a
                    ]);
                }
            }


        }
//        $data=[];
//        $data[3]=coa_account::level(3)->get();
//        $data[4]=coa_account::level(4)->get();
//        $data[5]=coa_account::level(5)->get();
//        return $data;
    }
    public function getAccounts($type){
        return coa_accounts_control::where('desc',$type)->get();
    }
    public function loadCategories(){
        return coa_accounts_cat::selectRaw('*,false as visible,false as vvisible')->get();
    }
    public function loadCompany(){
        return admin_company_profile::get()->first()->pluck('organization_name');
    }

     public function loadUnits(){
        $data=[];
        $data['ccs']= coa_account::get();
        $data['cost_centers']= coa_trans_types::all();
      /*   $data['cost_centers']= coa_account::where('desc','!=',null)->get();*/
        return $data;
    }

    public function loadControls(Request $request){
        return coa_accounts_control::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$request->get('cat'))->get();
    }
    public function saveControl(Request $request){
  
        $cat=  $request->get('category');
        $parent=$request->get('parent');
        $name=$request->get('name');
        $desc=$request->get('desc');
        $dropdown=$request->get('dropdown');
        $code=$request->get('code');
        $remarks=$request->get('remarks');
        $subaccount=$request->get('subaccount');
        $cost_center=$request->get('cost_center');


        if($subaccount==true){
            $desc=1;
        }

        $show=0;
        if($dropdown==true){
            $show=1;
        }

          if($show==1 && $request->get('cost_center')==''){
             abort(500);
         }
       else{


/*
        $d=coa_accounts_control::query();
        $parent2=$cat.'-';
        if($parent!=''){
            $d->where('parent',$parent);
            $parent2=$parent.'-';
        }
        else{
            $d->whereNull('parent');
        }
      $x=  $d->where('category_id',$cat)->orderBy("id",'desc')->first();

        if($x!=null ){

            $x=$x->code;
            $code=explode('-',$x);
            $code=end($code);

        }
        else{

            $code=0;
        }*/
       // dd($code);

          $saved=[];

       $saved= coa_accounts_control::create([

            'code'=>$code,
            'name'=>$name,

            'parent'=>$parent,
            'desc'=>$desc,
            'show'=>$show,
            'category_id'=>$cat,
            'remarks'=>$remarks,
            'cost_center'=>$cost_center,
        ]);


      return coa_accounts_control::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$cat)->where('id',$saved->id)->get();

       }


      /*  return coa_accounts_control::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$cat)->get();*/
 
}

    public function checkmaincontrol(Request $request){
        if(coa_accounts_control::where('parent',$request->get('code') )->exists())
        {
            return 1;
        }
        else{
            return 0;
        }
    }

    public function checkcontrol(Request $request){
        if(coa_accounts_control::where('id',$request->get('idd') )->exists())
        {
            return coa_accounts_control::where('id',$request->get('idd'))->get();
        }
        else{
            return 0;
        }
    }



    public function checkchildren(Request $request){

       
           $lastval = coa_accounts_control::withTrashed()->where('parent',$request->get('parent') )->count();
           $num     = 1;

        if ($lastval) {
            $num    = $lastval + 1;
        } else {
            $num    = 1;
        }

           return $num;

        
    }


        public function updateControl(Request $request){

        $idd=  $request->get('idd');
        $cat=  $request->get('category');
        $parent=$request->get('parent');
        $name=$request->get('name');
        $code=$request->get('code');
        $desc=$request->get('desc');
          $show=$request->get('show');
         $remarks=$request->get('remarks');
         $cost_center=$request->get('cost_center');


          if($show==1 && $request->get('cost_center')==''){
             abort(500);
         }


if($show==0){
    $cost_center=null;
}
        coa_accounts_control::where('category_id',$cat)->where('id',$idd)->where('parent',$parent)->updateWithUserstamps([
            'code'=>$code,
            'name'=>$name,
            'parent'=>$parent,
            'category_id'=>$cat,
            'desc'=>$desc,
            'show'=>$show,
            'remarks'=>$remarks,
            'cost_center'=>$cost_center,
        ]);
 
  if($parent==''){

       return coa_accounts_control::selectRaw('*,true as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('parent','')->get();
  }else{

       return coa_accounts_control::selectRaw('*,true as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$cat)->where('id',$idd)->where('parent',$parent)->get();
  }
    }

     public function deleteControl(Request $request){

        $cat=  $request->get('category');
        $parent=$request->get('parent');
        $name=$request->get('name');
        $code=$request->get('code');

        coa_accounts_control::where('category_id',$cat)->where('code',$code)->where('parent',$parent)->deleteWithUserstamps();

        return coa_accounts_control::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$cat)->get();
    }


    public function getlevelChild($action, Request $request)
    {
        $acc = coa_account::level(count(explode('-',$action)) + 1)->plevel($action)->get();
        return $acc;
    }

    public function apiget($action)
    {
        $data = [];
        foreach (explode(',', $action) as $c) {

            $data[$c] = coa_account::level($c)->get();
        }
        return $data;
    }
    public function apiget2($action,$action2)
    {
        $data = [];
        foreach (explode(',', $action) as $c) {
            if($c==5){
                $data[$c] = coa_account::levelg($c)->plevel($action2)->get();

            }
            else{

                $data[$c] = coa_account::level($c)->plevel($action2)->get();
            }
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
