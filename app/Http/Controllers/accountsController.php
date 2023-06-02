<?php

namespace App\Http\Controllers;

use App\accountCategory;
use App\accountControls;
use App\accounts;
use Illuminate\Http\Request;
use App\admin_company_profile;

class accountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/finance-and-management/COA/COA');
    }
    public function index_new()
    {
        return view('backend/finance-and-management/COA/COA-new');
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
//            accounts::where()
            $code = 0;
            $acc = accounts::level(1)->orderBy('code', 'desc')->first();
            if ($acc) {
                $code = $acc->code;

            }

            accounts::create([
                'code' => $this->f($code + 1),
                'name' => $request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::level(1)->get();
        }
        if($action =='2'){
            $code=0;
            $acc=accounts::level(2)->where('code','like',$request->level.'%')->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::level(2)->get();
        }
        if($action =='3'){
            $code=0;
            $acc=accounts::level(3)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::level(3)->plevel($request->get('level'))->get();
        } if($action =='4'){
            $code=0;
            $acc=accounts::level(4)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code,);
                $code=end($co);

            }
            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::level(4)->plevel($request->get('level'))->get();
        }
        if($action =='5'){
            $code=0;
            $acc=accounts::levelg(5)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);


            }

            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::levelg(5)->plevel(substr($request->get('level'),0,3))->get();
        }
    }

     public function api_update($action, Request $request)
    {
        if ($action == '1') {

        accounts::where('code',$request->get('code'))->updateWithUserstamps([
           'name' => $request->get('name'),
        ]);


            return accounts::level(1)->get();
        }
        if($action =='2'){

         accounts::where('code',$request->get('code'))->updateWithUserstamps([
           'name' => $request->get('name'),
         ]);

            return accounts::level(2)->get();
        }
        if($action =='3'){
            $code=0;
            $acc=accounts::level(3)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);

            }
            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::level(3)->plevel($request->get('level'))->get();
        } if($action =='4'){
            $code=0;
            $acc=accounts::level(4)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code,);
                $code=end($co);

            }
            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::level(4)->plevel($request->get('level'))->get();
        }
        if($action =='5'){
            $code=0;
            $acc=accounts::levelg(5)->plevel($request->get('level'))->orderBy('code','desc')->first();
            if($acc){
                $co=explode('-',$acc->code);
                $code=end($co);


            }

            accounts::create([
                'code'=>$request->get('level').'-'.($this->f($code+1)),
                'name'=>$request->get('name'),
//                'desc'=>$request->get('desc'),
            ]);
            return accounts::levelg(5)->plevel(substr($request->get('level'),0,3))->get();
        }
    }



      public function api_delete($action, Request $request)
    {
        if ($action == '1') {

        accounts::where('code',$request->get('code'))->deleteWithUserstamps();

            return accounts::level(1)->get();
        }
        if($action =='2'){

          accounts::where('code',$request->get('code'))->deleteWithUserstamps();

            return accounts::level(2)->get();
        }

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
            accounts::create([
                'name' => $d,
                'code' => $c
            ]);

            foreach(array_keys($defaults[$d]) as $m){

                $z=0;
                $b=$c .'-'. ($y=$this->f($y + 1));
                accounts::create([
                    'name' => $m,
                    'code' => $b
                ]);
                foreach($defaults[$d][$m] as $n){
                    $a=$b.'-'. ($z=$this->f($z + 1));
                    accounts::create([
                        'name' => $n,
                        'code' => $a
                    ]);
                }
            }


        }
//        $data=[];
//        $data[3]=accounts::level(3)->get();
//        $data[4]=accounts::level(4)->get();
//        $data[5]=accounts::level(5)->get();
//        return $data;
    }
    public function getAccounts($type){
        return accountControls::where('desc',$type)->get();
    }
    public function loadCategories(){
        return accountCategory::selectRaw('*,false as visible,false as vvisible')->get();
    }
    public function loadCompany(){
        return admin_company_profile::get()->first()->pluck('organization_name');
    }
    public function loadControls(Request $request){
        return accountControls::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$request->get('cat'))->get();
    }
    public function saveControl(Request $request){

      $cat=  $request->get('category');
        $parent=$request->get('parent');
        $name=$request->get('name');
        $desc=$request->get('desc');
        $subaccount=$request->get('subaccount');

        if($subaccount==true){
            $desc=1;
        }

        $d=accountControls::query();
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
        }
       // dd($code);
        accountControls::create([

            'code'=>$parent2.$this->f($code+1),
            'name'=>$name,

            'parent'=>$parent,
            'desc'=>$desc,
            'category_id'=>$cat
        ]);
        return accountControls::selectRaw('*,true as visible,true as vvisible,true as vvvisible,true as vvvvisible')->where('category_id',$cat)->get();
    }


    public function checkmaincontrol(Request $request){
        if(accountControls::where('parent',$request->get('code') )->exists())
        {
            return 1;
        }
        else{
            return 0;
        }
    }


        public function updateControl(Request $request){

        $cat=  $request->get('category');
        $parent=$request->get('parent');
        $name=$request->get('name');
        $code=$request->get('code');
        $desc=$request->get('desc');

        accountControls::where('category_id',$cat)->where('code',$code)->where('parent',$parent)->updateWithUserstamps([
            'code'=>$code,
            'name'=>$name,
            'parent'=>$parent,
            'category_id'=>$cat,
            'desc'=>$desc
        ]);

        return accountControls::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$cat)->get();
    }

     public function deleteControl(Request $request){

        $cat=  $request->get('category');
        $parent=$request->get('parent');
        $name=$request->get('name');
        $code=$request->get('code');

        accountControls::where('category_id',$cat)->where('code',$code)->where('parent',$parent)->deleteWithUserstamps();

        return accountControls::selectRaw('*,false as visible,false as vvisible,false as vvvisible,false as vvvvisible')->where('category_id',$cat)->get();
    }


    public function getlevelChild($action, Request $request)
    {
        $acc = accounts::level(count(explode('-',$action)) + 1)->plevel($action)->get();
        return $acc;
    }

    public function apiget($action)
    {
        $data = [];
        foreach (explode(',', $action) as $c) {

            $data[$c] = accounts::level($c)->get();
        }
        return $data;
    }
    public function apiget2($action,$action2)
    {
        $data = [];
        foreach (explode(',', $action) as $c) {
            if($c==5){
                $data[$c] = accounts::levelg($c)->plevel($action2)->get();

            }
            else{

                $data[$c] = accounts::level($c)->plevel($action2)->get();
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
