<?php

namespace App\Http\Controllers;

use App\corporateMembership;
use App\fnb_item_sub_category;
use App\fnb_item_category;
use App\fnb_item_definition;
use App\finance_payment_receipt;
use App\hr_employment;
use App\finance_account_type;
use App\trans_relations;
use App\trans_type;
use App\transactions;
use Illuminate\Http\Request;
use App\customer;
use App\finance_ledger_person;
use App\membership;
use App\fnb_discount_card;
use App\mem_family;
use App\fnb_cake_booking;
use App\fnb_table_reservation;
use App\fnb_table_reservation_subs;
use DB;
use App\accounts;
use App\accountControls;
use App\coa_account;
use App\coa_accounts_control;
use App\coa_accounts_cat;
use App\store_purchases;

class SearchMemberGuestController extends Controller
{

    function guestid(request $request)
    {

        $clastval = customer::withTrashed()->latest('id')->first();
        $cnum = 0;

        if ($clastval) {
            $cnum = $clastval->id + 1;

        } else {
            $cnum = 1;

        }

        return $cnum;


    }

    function itemsearchdata(request $request)
    {
        $number = $request->theid;
        $data = fnb_item_definition::where('id', $number)->first();

        return json_encode($data);
    }

    function itemsearchdatalike(request $request)
    {
        $number = $request->theid;

        $data = fnb_item_definition::where('item_details', 'LIKE', "%{$number}%")->limit(30)->get();

        return json_encode($data);

    }


    function itemsdata(request $request)
    {
        $number = $request->theid;
        $data = fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('id', $number)->where('status', 1)->where('salable', 1)->orderBy('item_details')->first();

        return json_encode($data);
    }


    function itemsdataenter(request $request)
    {
        $number = $request->theid;

        $item_subcat = fnb_item_definition::where('item_code', $number)->where('status', 1)->where('salable', 1)->orWhere('item_details', $number)->where('status', 1)->where('salable', 1)->get()->pluck('sub_category');
        $itemsubcat = $item_subcat[0];

        $item_cat = fnb_item_definition::where('item_code', $number)->where('status', 1)->where('salable', 1)->orWhere('item_details', $number)->where('status', 1)->where('salable', 1)->get()->pluck('category');
        $itemcat = $item_cat[0];

        if (fnb_item_sub_category::where('id', $itemsubcat)->where('status', 1)->exists() && fnb_item_category::where('id', $itemcat)->where('status', 1)->exists()) {
            $data = fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('item_code', $number)->orWhere('item_details', $number)->where('status', 1)->where('salable', 1)->orderBy('item_details')->first();
        } else {
            $data = '';
        }
        return json_encode($data);
    }


    function itemsdatalike(request $request)
    {
        $number = $request->searchid;


        $item_subcat = fnb_item_definition::where('status', 1)->where('salable', 1)->where(function ($query) use ($number) {
            $query->orWhere('item_code', 'LIKE', "$number%")->orWhere('item_details', 'LIKE', "%$number%");
        })->get()->pluck('sub_category');
        $itemsubcat = $item_subcat;


        $item_cat = fnb_item_definition::where('status', 1)->where('salable', 1)->where(function ($query) use ($number) {
            $query->orWhere('item_code', 'LIKE', "$number%")->orWhere('item_details', 'LIKE', "%$number%");
        })->get()->pluck('category');
        $itemcat = $item_cat;

        $sub_category = fnb_item_sub_category::whereIn('id', $itemsubcat)->where('status', 1)->get()->pluck('id');
        $cateee = fnb_item_category::whereIn('id', $itemcat)->where('status', 1)->get()->pluck('id');


        if (true) {
            $data = fnb_item_definition::where('status', 1)->where('salable', 1)->whereIn('category', $cateee)->whereIn('sub_category', $sub_category)->where(function ($query) use ($number) {
                $query->orWhere('item_code', 'LIKE', "$number%")->orWhere('item_details', 'LIKE', "%$number%");
            })->limit(30);
            if (is_int($number)) {
            }
            $data = $data->orderByRaw("if(SUBSTRING(item_code, 1, length('$number'))= '$number', 0,1),if(SUBSTRING(item_details, 1, length('$number'))= '$number', 0,1)");
            $data = $data->get();
//dd($data);
        } else {
            $data = '';
        }

        return json_encode($data);

    }


    //////////////////////////////////////////// STORE MANAGEMENT //////////////////////////////////////////////////////////
    function storeitemsdata(request $request)
    {
        $number = $request->theid;
         $unit = $request->theunit;
        /*       $data= DB::table('fnb_item_definitions')
                      ->join('store_transactions','store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
                      ->selectRaw('fnb_item_definitions.*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock')
                      ->where('fnb_item_definitions.id',$number)->where('fnb_item_definitions.status',1)->where('fnb_item_definitions.purchasable',1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
                      ->first();
        */

        $data = DB::table('fnb_item_definitions')
            ->leftJoin('store_transactions', function ($join) use ($unit){
                $join->on('store_transactions.item_code', '=', 'fnb_item_definitions.item_code')->where('store_transactions.is_active', 1)->where('store_transactions.type','!=',3)->where('store_transactions.type','!=',4)->where('store_transactions.unit',$unit);
            })
            ->selectRaw('fnb_item_definitions.*,0 as hdel,0 as service_charges,0 as discount,0 as tax, 1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.purchase_price+0) as old_purchase_price')
            ->where('fnb_item_definitions.id', $number)->where('fnb_item_definitions.status', 1)->where('fnb_item_definitions.purchasable', 1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
            ->first();


        /*    $data=fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('id',$number)->where('status',1)->where('purchasable',1)->orderBy('item_details')->first();*/

        return json_encode($data);

    }
 function storeitemsdataenter(request $request)
    {
        $number = $request->theid;
        $data = DB::table('fnb_item_definitions')
            ->join('store_transactions', 'store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
            ->selectRaw('fnb_item_definitions.*,1 as qty,0 as service_charges,0 as discount,0 as tax,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.purchase_price+0) as old_purchase_price')
            ->where('fnb_item_definitions.item_code', $number)->orWhere('fnb_item_definitions.item_details', $number)->where('fnb_item_definitions.status', 1)->where('fnb_item_definitions.purchasable', 1)->where('store_transactions.is_active', 1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
            ->first();
        /*  $data=fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('item_code',$number)->orWhere('item_details',$number)->where('status',1)->where('purchasable',1)->orderBy('item_details')->first();*/

        return json_encode($data);

    }


 function unitdata(request $request)
    {
        $number = $request->theid;
    
  $data = coa_account::whereNotNull('desc')->with('companyname')->where(function ($query) use ($number) {
                $query->orWhere('id',$number)->orWhere('code',$number);
            })->first();

 /*         $data=coa_account::whereNotNull('desc')->where('id',$number)->where('id',$number)->first();*/

        return json_encode($data);

    }

       function unitsdatalike(request $request)
    {
        $customernumber = $request->searchid;


    $customerdata = coa_account::whereNotNull('desc')->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

/*
        $customerdata = coa_account::with('companyname')->whereNotNull('desc')->where('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%")->whereNotNull('desc')->limit(30)->get();*/

        return json_encode($customerdata);

    }



  

       function expaccountdatalike(request $request)
    {
        $customernumber = $request->searchid;

    $customerdata = coa_accounts_control::where('cost_center',9)->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

        return json_encode($customerdata);

    }


 function coaaccountdata(request $request)
    {
        $number = $request->theid;
    

          $data=coa_accounts_control::where('id',$number)->orWhere('code',$number)->first();

 if ($request->get('balance') && $data) {

            $data['balance'] = balanceOFCOA($data->code);
        }

        return json_encode($data);

    }

       function coaaccountdatalike(request $request)
    {
        $customernumber = $request->searchid;

    $customerdata = coa_accounts_control::where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

        return json_encode($customerdata);

    }


       function cashbankdatalike(request $request)
    {
        $customernumber = $request->searchid;

    $customerdata = coa_accounts_control::whereIn('cost_center',[1,2])->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

        return json_encode($customerdata);

    }




    function accountdata(request $request)
    {
        $number = $request->theid;
    
        $data=coa_accounts_control::where('id',$number)->where('desc','!=',3)->where('show',1)->first();

        if ($request->get('balance')) {
            $data['balance'] = balanceOFCOA($data->code);
        }

        return json_encode($data);

    }

       function accountdatalike(request $request)
    {
        $customernumber = $request->searchid;

    $customerdata = coa_accounts_control::where('desc','!=',3)->where('show',1)->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

        return json_encode($customerdata);

    }



     function childdata(request $request)
    {
        $number = $request->theid;
    

          $data=coa_accounts_control::where('id',$number)->where('desc',3)->where('show',1)->first();

          if ($request->get('balance')) {
            $data['balance'] = balanceOFCOA($data->code);
          }

        return json_encode($data);

    }

       function childdatalike(request $request)
    {
        $customernumber = $request->searchid;

      $customerdata = coa_accounts_control::where('desc',3)->where('show',1)->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();


        return json_encode($customerdata);

    }

function pmdata(request $request)
    {
        $number = $request->theid;
    
          $data=coa_accounts_control::where('def',2)->where('id',$number)->first();

        return json_encode($data);

    }

       function pmdatalike(request $request)
    {
        $customernumber = $request->searchid;

       $customerdata = coa_accounts_control::where('def',2)->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();
/*
        $customerdata = accountControls::where('def',2)->where('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%")->limit(30)->get();*/

        return json_encode($customerdata);

    }



   

    function storeitemsdatalike(request $request)
    {
        $number = $request->searchid;

        $data = fnb_item_definition::where('status', 1)->where('purchasable', 1)->where('item_code', 'LIKE', "%{$number}%")->orWhere('item_details', 'LIKE', "%{$number}%")->where('status', 1)->where('purchasable', 1)->limit(30)->get();

        return json_encode($data);

    }


    function storesalesitemsdata(request $request)
    { 
        $number = $request->theid;
         $unit = $request->theunit;

        $data = DB::table('fnb_item_definitions')
            ->leftJoin('store_transactions', function ($join) use ($unit) {
                $join->on('store_transactions.item_code', '=', 'fnb_item_definitions.item_code')->where('store_transactions.is_active', 1)->where('store_transactions.type','!=',3)->where('store_transactions.type','!=',4)->where('store_transactions.unit',$unit);
            })
            ->selectRaw('fnb_item_definitions.*, 1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.sale_price+0) as old_sale_price')
            ->where('fnb_item_definitions.id', $number)->where('fnb_item_definitions.status', 1)->where('fnb_item_definitions.salable', 1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
            ->first();
        return json_encode($data);
    }

    function storesalesitemsdataenter(request $request)
    {
        $number = $request->theid;
        $data = DB::table('fnb_item_definitions')
            ->join('store_transactions', 'store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
            ->selectRaw('fnb_item_definitions.*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,(fnb_item_definitions.sale_price+0) as old_sale_price')
            ->where('fnb_item_definitions.item_code', $number)->orWhere('fnb_item_definitions.item_details', $number)->where('fnb_item_definitions.status', 1)->where('fnb_item_definitions.salable', 1)->where('store_transactions.is_active', 1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
            ->first();
        return json_encode($data);
    }

    function storesalesitemsdatalike(request $request)
    {
        $number = $request->searchid;
        $data = fnb_item_definition::where('status', 1)->where('salable', 1)->where('item_code', 'LIKE', "%{$number}%")->orWhere('item_details', 'LIKE', "%{$number}%")->where('status', 1)->where('salable', 1)->limit(30)->get();
        return json_encode($data);
    }


    function storeissueitemsdata(request $request)
    {
        $number = $request->theid;
         $date = $request->thedate;
         $unit = $request->theunit;
         $store = $request->thestore;

          $data =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.*, 1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when ll.in_or_out=1 then ll.qty else -ll.qty end) as opening_stock,
              (if(st.in_or_out = 1,st.purchase_price,0)) as old_purchase_price

from fnb_item_definitions


 left outer join store_transactions ll ON ll.item_code = fnb_item_definitions.item_code  and ll.is_active=1 and (ll.type=3 || ll.type=4) and ll.store_location="'.$store.'" and ll.unit="'.$unit.'"
   

 left outer join store_transactions st ON st.item_code = fnb_item_definitions.item_code and st.is_active=1
    and st.id =
    (SELECT st1.id from store_transactions st1 where st1.item_code = fnb_item_definitions.item_code and st1.is_active=1
     and st1.date is not null and  DATE(st1.date) <= "'.$date.'"
     order by st1.date desc limit 1) 




where fnb_item_definitions.id="'.$number.'"  and fnb_item_definitions.status=1 and fnb_item_definitions.deleted_at is null group by fnb_item_definitions.id order by fnb_item_definitions.item_details asc  limit 1');

            return json_encode($data[0]);

            // sum(case when slt.in_or_out=1 then slt.qty else -slt.qty end) as current_stock
  //left outer join store_transactions slt ON slt.item_code = fnb_item_definitions.item_code and slt.is_active=1 and slt.type!=3 and slt.type!=4 and slt.unit="'.$unit.'"



 
       /* $data = DB::table('fnb_item_definitions')
            ->leftJoin('store_transactions', function ($join) {
                $join->on('store_transactions.item_code', '=', 'fnb_item_definitions.item_code')->where('store_transactions.is_active', 1)->orderBy('store_transactions.id','desc');
            })
            ->selectRaw('fnb_item_definitions.*, 1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock,
              (if(store_transactions.in_or_out = 1 and MAX(store_transactions.date),store_transactions.purchase_price,0)) as old_purchase_price
              ')
             ->where('fnb_item_definitions.id', $number)->where('fnb_item_definitions.status', 1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
            ->first();*/
    }
 

    function storeissueitemsdatacs(request $request)
    {
        $number = $request->theid;
         $date = $request->thedate;
         $unit = $request->theunit;
         $store = $request->thestore;

          $data =\Illuminate\Support\Facades\DB::select(
      'select sum(case when slt.in_or_out=1 then slt.qty else -slt.qty end) as current_stock

from fnb_item_definitions

left outer join store_transactions slt ON slt.item_code = fnb_item_definitions.item_code and slt.is_active=1 and slt.type!=3 and slt.type!=4 and slt.unit="'.$unit.'"

where fnb_item_definitions.id="'.$number.'"  and fnb_item_definitions.status=1 and fnb_item_definitions.deleted_at is null group by fnb_item_definitions.id order by fnb_item_definitions.item_details asc  limit 1');

            return json_encode($data[0]);
 
    }


    function storeissueitemsdataenter(request $request)
    {
        $number = $request->theid;
        $data = DB::table('fnb_item_definitions')
            ->join('store_transactions', 'store_transactions.item_code', '=', 'fnb_item_definitions.item_code', 'left outer')
            ->selectRaw('fnb_item_definitions.*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt, sum(case when store_transactions.in_or_out=1 then store_transactions.qty else -store_transactions.qty end) as opening_stock, MAX(store_transactions.purchase_price) as old_purchase_price')
            ->where('fnb_item_definitions.item_code', $number)->orWhere('fnb_item_definitions.item_details', $number)->where('fnb_item_definitions.status', 1)->where('store_transactions.is_active', 1)->orderBy('fnb_item_definitions.item_details')->groupBy('fnb_item_definitions.id')
            ->first();
        return json_encode($data);
    }

    function storeissueitemsdatalike(request $request)
    {
        $number = $request->searchid;
        $data = fnb_item_definition::where('status', 1)->where('item_code', 'LIKE', "%{$number}%")->orWhere('item_details', 'LIKE', "%{$number}%")->where('status', 1)->limit(30)->get();
        return json_encode($data);
    }

    //////////////////////////////////////////// STORE MANAGEMENT //////////////////////////////////////////////////////////


    function discountdata(request $request)
    {
        $discountnumber = $request->discountid;
        $discountdata = fnb_discount_card::where('id', $discountnumber)->first();

        return json_encode($discountdata);
    }

    function discountdatalike(request $request)
    {
        $customernumber = $request->customerid;
        $customername = $request->customer;


        $discountdata = fnb_discount_card::where('name', $customername)->orWhere('name', null)->limit(30)->get();

        return json_encode($discountdata);

    }


    function salescustomerdata(request $request)
    {

        $customernumber = $request->customerid;
        $MOC = $request->MOC;

         if($MOC==8){
            $MOC=0;
        }
      
        if($MOC > 10 && $MOC < 22) {
             $MOC=1;
             $customerdata = customer::where('id', $customernumber)->first();

             $discountdata = fnb_discount_card::where('customer_id', $customernumber)->first();
             $customerdata['discountdata'] = $discountdata;

        } 
        /* else if ($MOC == 02) {
              $customerdata = customer::where('id', $customernumber)->first();
        } */
         else if ($MOC == 1) {
              $customerdata = customer::where('id', $customernumber)->first();

               $discountdata = fnb_discount_card::where('customer_id', $customernumber)->first();
             $customerdata['discountdata'] = $discountdata;
        } 
       else if ($MOC == 2) {
            $customerdata = finance_ledger_person::where('id', $customernumber)->first();
        } else if ($MOC == 3) {
            $customerdata = hr_employment::where('id', $customernumber)->first();


             $discountdata = fnb_discount_card::where('customer_id', $customernumber)->first();
             $customerdata['discountdata'] = $discountdata;

        } else if ($MOC == 4) {
            $customerdata = finance_account_type::where('id', $customernumber)->first();
        }
          else if ($MOC == 6) {
             $customerdata = corporateMembership::with('mem_status')->with(['family:id,title,first_name,middle_name,name,fam_relationship,member_id,status,sup_card_no', 'family.relationship_name:id,desc', 'family.status_name:id,desc'])->where('id', $customernumber)->first();

             $memnoo=corporateMembership::where('id', $customernumber)->get()->pluck('mem_no');
             if($memnoo){
                 $discountdata = fnb_discount_card::where('customer_id', $memnoo[0])->first();
                 $customerdata['discountdata'] = $discountdata;
             }

          
        }
         else {
             $customerdata = membership::with('mem_status')->with(['family:id,title,first_name,middle_name,name,fam_relationship,member_id,status,sup_card_no', 'family.relationship_name:id,desc', 'family.status_name:id,desc'])->where('id', $customernumber)->first();

             $memnoo=membership::where('id', $customernumber)->get()->pluck('mem_no');
             if($memnoo){
                 $discountdata = fnb_discount_card::where('customer_id', $memnoo[0])->first();
                 $customerdata['discountdata'] = $discountdata;
             }

             
        }
//      $booking=$customerdata->bookings()->where('check_out_status',1)->get()->sum('grand_total');
//        $invoice=$customerdata->invoices()->get()->sum('total');
//         $receipt=$customerdata->receipts()->get()->sum('total');
//        $subbalance=$invoice+$booking;
//        $balance=$receipt-$subbalance;

        $customerdata['balance'] = balanceOFMOC($customerdata->id, $MOC);
         $customerdata['lastpayment'] = lastPaymentofMOC($customerdata->id);


        if ($request->get('advance') == 1) {
            if ($request->get('r')) {
                
    $adv = ($customerdata->transactions()->where('trans_type',26)->where('trans_moc_type',$MOC)->with(['advances2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type',$MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $adv = ($customerdata->transactions()->where('trans_type',26)->where('trans_moc_type',$MOC)->with(['advances2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type',$MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

                
                
            
 
            }
      
             $customerdata['advances'] = $adv;

        } 


         if ($request->get('discount') == 1) {
            if ($request->get('r')) {
                
            $dis = ($customerdata->transactions()->where('trans_type',28)->where('trans_moc_type',$MOC)->with(['discounts2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type',$MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $dis = ($customerdata->transactions()->where('trans_type',28)->where('trans_moc_type',$MOC)->with(['discounts2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type',$MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->get()->toArray(1));
            }
      
             $customerdata['discounts'] = $dis;

        } 


        return json_encode($customerdata);

    }





  function purchasedata(request $request)
    {
        $customernumber = $request->customerid;
        
       
            $customerdata = store_purchases::where('id', $customernumber)->first();
         
      

        return json_encode($customerdata);

    }
 function purchasedatalike(request $request)
    {
        $customernumber = $request->customerid;
        
           
  $customerdata = store_purchases::with('ledgerperson')->where(function ($query) use ($customernumber) {
                $query->orWhere('id', $customernumber)->orWhere('id', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

          

        return json_encode($customerdata);

    }


   


// FOR FAMILY MEMBERS
    function famcustomerdata(request $request)
    {
        $customernumber = $request->customerid;

        $customerdata = mem_family::where('id', $customernumber)->where('status', 1)->first();

        return json_encode($customerdata);

    }

    function famcustomerdatalike(request $request)
    {

        $customernumber = $request->customerid;


        $customerdata = mem_family::where('first_name', 'LIKE', "%{$customernumber}%")->orWhere('middle_name', 'LIKE', "%{$customernumber}%")->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->orWhere('sup_card_no', 'LIKE', "%{$customernumber}%")->orWhereRaw('concat(first_name
," ",middle_name," ",
name) like "%' . $customernumber . '%"')->where('status', 1)->limit(10)->get();
//echo $customerdata;

        return json_encode($customerdata);

    }

// FOR FAMILY MEMBERS

   function comemdata(request $request)
    {
        $customernumber = $request->customerid;
        $MOC = $request->MOC;
         
             $customerdata = corporateMembership::with(['family:id,title,first_name,middle_name,name,fam_relationship,member_id', 'family.relationship_name:id,desc'])->where('id', $customernumber)->first();
       
         

        

            $customerdata['balance'] = balanceOFMOC($customerdata->id, $MOC);
 

    if ($request->get('inv') == 1) {
            if ($request->get('r')) {
                $q = transactions::where('receipt_id', $request->get('r'))->get()->pluck('trans_type');
                $r = transactions::where('receipt_id', $request->get('r'))->get()->pluck('trans_type_id');
                $s = transactions::where('receipt_id', $request->get('r'))->get()->pluck('id');

                $v = transactions::whereIn('trans_type', $q)->whereIn('trans_type_id', $r)->get()->pluck('id');

                $b = ($customerdata->transactions()->whereIn('id', $v)->with(['receipts2' => function ($query) use ($customerdata,$v) {
                    $query->where('trans_moc', $customerdata->id)->whereNotIn('id', $v);
 
                }, 'receiptDetails2' => function ($query) use ($customerdata,$s) {
                    $query->where('trans_moc', $customerdata->id)->whereIn('id', $s);
 
                }])->where('type',1)->where('debit_or_credit', 1)->where('is_active', 1)->get()->toArray(1));

 

 
                $b2 = ($customerdata->transactions()->whereIn('id', $v)->with(['payments2' => function ($query) use ($customerdata,$v) {
                    $query->where('trans_moc', $customerdata->id)->whereNotIn('id', $v);
 
                }, 'paymentDetails2' => function ($query) use ($customerdata,$s) {
                    $query->where('trans_moc', $customerdata->id)->whereIn('id', $s);
 
                }])->whereIn('type',[4,6])->where('debit_or_credit', 0)->where('is_active', 1)->get()->toArray(1));

            } else {
                $types=trans_type::where('cash_or_payment',0)->get()->pluck('id');
                $b = ($customerdata->transactions()->whereIn('trans_type',$types)->with(['receipts' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id);
 
                }, 'receipts.receiptDetails' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id);
 
                }])->where('debit_or_credit', 1)->where('type',1)->where('is_active', 1)->get()->toArray(1));
            

                $ptypes=trans_type::where('cash_or_payment',1)->get()->pluck('id');
                $b2 = ($customerdata->transactions()->whereIn('trans_type',$ptypes)->with(['payments' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id);
                }, 'payments.paymentDetails' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id);
                }])->where('debit_or_credit',0)->whereIn('type',[4,6])->where('is_active', 1)->get()->toArray(1));
            }
            $customerdata['invoices'] = $b;
            $customerdata['receipts'] = $b2;

        } 


        if ($request->get('advance') == 1) {
            if ($request->get('r')) {
                
    $adv = ($customerdata->transactions()->where('trans_type',26)->with(['advances2' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $adv = ($customerdata->transactions()->where('trans_type',26)->with(['advances2' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

                
                
            
 
            }
      
             $customerdata['advances'] = $adv;

        } 


        if ($request->get('padvance') == 1) {
            if ($request->get('r')) {
                
    $adv = ($customerdata->transactions()->where('trans_type',27)->with(['advances2' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id)->where('debit_or_credit',0);
 
                }])->where('debit_or_credit',1)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $adv = ($customerdata->transactions()->where('trans_type',27)->with(['advances2' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id)->where('debit_or_credit',0);
 
                }])->where('debit_or_credit',1)->where('type',7)->where('is_active', 1)->get()->toArray(1));

                
                
            
 
            }
      
             $customerdata['advances'] = $adv;

        } 

         if ($request->get('discount') == 1) {
            if ($request->get('r')) {
                
            $dis = ($customerdata->transactions()->where('trans_type',28)->with(['discounts2' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $dis = ($customerdata->transactions()->where('trans_type',28)->with(['discounts2' => function ($query) use ($customerdata) {
                    $query->where('trans_moc', $customerdata->id)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->get()->toArray(1));
            }
      
             $customerdata['discounts'] = $dis;

        } 


   
        if (corporateMembership::where('kinship', $customernumber)->exists()) {
            $kincount = corporateMembership::where('kinship', $customernumber)->count();
        } else {
            $kincount = 0;
        }
        $customerdata['kins'] = $kincount + 1;

        return json_encode($customerdata);

    }

    function customerdata(request $request)
    { 
        $customernumber = $request->customerid;
        $MOC = $request->MOC;
         if ($MOC == 01 || $MOC == 02 || $MOC == 1) {
           $customerdata = customer::where('id', $customernumber)->first();
        }
        else if($MOC > 10 && $MOC < 22) {
             $MOC=1;
             $customerdata = customer::where('id', $customernumber)->first();
        }
        else if ($MOC == 22) {
            $customerdata = finance_ledger_person::where('id', $customernumber)->first();
        } else if ($MOC == 3) {
            $customerdata = hr_employment::where('id', $customernumber)->first();
        } else if ($MOC == 4) {
             $customerdata = coa_accounts_control::where('id',$customernumber)->orWhere('code',$customernumber)->first();
           /* $customerdata = finance_account_type::where('id', $customernumber)->first();*/
        }
        else if ($MOC == 6) {
             $customerdata = corporateMembership::with(['family:id,title,first_name,middle_name,name,fam_relationship,member_id', 'family.relationship_name:id,desc'])->where('id', $customernumber)->first();
        }
         else {
             $customerdata = membership::with(['family:id,title,first_name,middle_name,name,fam_relationship,member_id', 'family.relationship_name:id,desc'])->where('id', $customernumber)->first();
        } 
//      $booking=$customerdata->bookings()->where('check_out_status',1)->get()->sum('grand_total');
//        $invoice=$customerdata->invoices()->get()->sum('total');
//         $receipt=$customerdata->receipts()->get()->sum('total');
//        $subbalance=$invoice+$booking;
//        $balance=$receipt-$subbalance;

        if($MOC == 22){
            $MOC = 2;
        }
        

         if ($request->get('paybalance')) {
            $customerdata['balance'] = balanceOFSUP($customerdata->id, $MOC);
            $customerdata['lastpayment'] = lastPaymentofSUP($customerdata->id);
        } 
         else if ($request->get('balance') && $MOC==4) {

            $customerdata['balance'] = balanceOFCOA($customerdata->code);
        }
        else if ($request->get('balance') && $MOC==2) {

            $customerdata['balance'] = balanceOFSUP($customerdata->id, $MOC);
        }
  
    
     else if ($request->get('balance')) {

            $customerdata['balance'] = balanceOFMOC($customerdata->id, $MOC);

        }
      /*  if ($request->get('inv') == 1) {
            if ($request->get('r')) {
                $s = transactions::where('receipt_id', $request->get('r'))->get()->pluck('id');
                $v = trans_relations::whereIn('receipt', $s)->get()->pluck('invoice');


                $b = ($customerdata->transactions()->withTrashed()->whereIn('id', $v)->with(['receipts' => function ($query) use ($s) {
                    $query->whereNotIn('receipt', $s);
 
                }, 'receipts2' => function ($query) use ($s) {
                    $query->whereIn('receipt', $s);
 
                }, 'receipts.receiptDetails', 'receipts2.receiptDetails'])->where('is_active', 1)->where('debit_or_credit', 1)->where('type', 1)->get()->toArray(1));


                $s2 = transactions::where('receipt_id', $request->get('r'))->get()->pluck('id');
                $v2 = trans_relations::whereIn('receipt', $s2)->get()->pluck('invoice');
                $b2 = ($customerdata->transactions()->whereIn('id', $v2)->with(['receipts' => function ($query) use ($s2) {
                    $query->whereNotIn('receipt', $s2);
 
                }, 'receipts2' => function ($query) use ($s2) {
                    $query->whereIn('receipt', $s2);
 
                }, 'receipts.receiptDetails', 'receipts2.receiptDetails'])->where('is_active', 1)->where('debit_or_credit', 0)->where('type',2)->get()->toArray(1));

            } else {
                $types=trans_type::where('cash_or_payment',0)->get()->pluck('id');
                $b = ($customerdata->transactions()->whereIn('trans_type',$types)->where('is_active', 1)->with('receipts', 'receipts.receiptDetails')->where('debit_or_credit', 1)->where('type', 1)->get()->toArray(1));

                $b2 = ($customerdata->transactions()->whereIn('trans_type',$types)->where('is_active', 1)->with('receipts', 'receipts.receiptDetails')->where('debit_or_credit', 0)->where('type', 2)->get()->toArray(1));
            }
            $customerdata['invoices'] = $b;
            $customerdata['receipts'] = $b2;

        }*/

    if ($request->get('inv') == 1) {
            if ($request->get('r')) {
                $q = transactions::where('receipt_id', $request->get('r'))->pluck('trans_type');
                $r = transactions::where('receipt_id', $request->get('r'))->pluck('trans_type_id');
                $s = transactions::where('receipt_id', $request->get('r'))->pluck('id');

                $v = transactions::whereIn('trans_type', $q)->whereIn('trans_type_id', $r)->pluck('id');

                $b = ($customerdata->transactions()->whereIn('id', $v)->where('trans_moc_type', $MOC)->with(['receipts2' => function ($query) use ($customerdata,$MOC,$v) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->whereNotIn('id', $v);
 
                }, 'receiptDetails2' => function ($query) use ($customerdata,$s, $MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->whereIn('id', $s);
 
                }])->where('type',1)->where('debit_or_credit', 1)->where('is_active', 1)->get()->toArray(1));

 

 
                $b2 = ($customerdata->transactions()->whereIn('id', $v)->where('trans_moc_type', $MOC)->with(['payments2' => function ($query) use ($customerdata,$v,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->whereNotIn('id', $v);
 
                }, 'paymentDetails2' => function ($query) use ($customerdata,$s, $MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->whereIn('id', $s);
 
                }])->whereIn('type',[4,6])->where('debit_or_credit', 0)->where('is_active', 1)->get()->toArray(1));

            } else {
                $types=trans_type::where('cash_or_payment',0)->get()->pluck('id');
                $b = ($customerdata->transactions()->whereIn('trans_type',$types)->where('trans_moc_type', $MOC)->with(['receipts' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC);
 
                }, 'receipts.receiptDetails' => function ($query) use ($customerdata, $MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC);
 
                }])->where('debit_or_credit', 1)->where('type',1)->where('is_active', 1)->get()->toArray(1));
            

                $ptypes=trans_type::where('cash_or_payment',1)->get()->pluck('id');
                $b2 = ($customerdata->transactions()->whereIn('trans_type',$ptypes)->where('trans_moc_type', $MOC)->with(['payments' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC);
                }, 'payments.paymentDetails' => function ($query) use ($customerdata, $MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC);
                }])->where('debit_or_credit',0)->whereIn('type',[4,6])->where('is_active', 1)->get()->toArray(1));
            }
            $customerdata['invoices'] = $b;
            $customerdata['receipts'] = $b2;

        } 


        if ($request->get('advance') == 1) {
            if ($request->get('r')) {
                
    $adv = ($customerdata->transactions()->where('trans_type',26)->where('trans_moc_type', $MOC)->with(['advances2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $adv = ($customerdata->transactions()->where('trans_type',26)->where('trans_moc_type', $MOC)->with(['advances2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

                
                
            
 
            }
      
             $customerdata['advances'] = $adv;

        } 


        if ($request->get('padvance') == 1) {
            if ($request->get('r')) {
                
    $adv = ($customerdata->transactions()->where('trans_type',27)->where('trans_moc_type', $MOC)->with(['advances2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->where('debit_or_credit',0);
 
                }])->where('debit_or_credit',1)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $adv = ($customerdata->transactions()->where('trans_type',27)->where('trans_moc_type', $MOC)->with(['advances2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->where('debit_or_credit',0);
 
                }])->where('debit_or_credit',1)->where('type',7)->where('is_active', 1)->get()->toArray(1));

                
                
            
 
            }
      
             $customerdata['advances'] = $adv;

        } 

         if ($request->get('discount') == 1) {
            if ($request->get('r')) {
                
            $dis = ($customerdata->transactions()->where('trans_type',28)->where('trans_moc_type', $MOC)->with(['discounts2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->where('is_active', 1)->get()->toArray(1));

            } else {

                  $dis = ($customerdata->transactions()->where('trans_type',28)->where('trans_moc_type', $MOC)->with(['discounts2' => function ($query) use ($customerdata,$MOC) {
                    $query->where('trans_moc', $customerdata->id)->where('trans_moc_type', $MOC)->where('debit_or_credit',1);
 
                }])->where('debit_or_credit',0)->where('type',7)->get()->toArray(1));
            }
      
             $customerdata['discounts'] = $dis;

        } 


     /*   if ($request->get('inv') == 1) {
            if ($request->get('r')) {
                $s = transactions::where('receipt_id', $request->get('r'))->get()->pluck('id');
                $v = trans_relations::whereIn('receipt', $s)->get()->pluck('invoice');


                $b = ($customerdata->transactions()->withTrashed()->whereIn('id', $v)->with(['receipts' => function ($query) use ($s) {
                    $query->whereNotIn('receipt', $s);
 
                }, 'receipts2' => function ($query) use ($s) {
                    $query->whereIn('receipt', $s);
 
                }, 'receipts.receiptDetails', 'receipts2.receiptDetails'])->where('is_active', 1)->where('debit_or_credit', 1)->get()->toArray(1));


                $s2 = transactions::where('receipt_id', $request->get('r'))->get()->pluck('id');
                $v2 = trans_relations::whereIn('receipt', $s2)->get()->pluck('invoice');
                $b2 = ($customerdata->transactions()->whereIn('id', $v2)->with(['receipts' => function ($query) use ($s2) {
                    $query->whereNotIn('receipt', $s2);
 
                }, 'receipts2' => function ($query) use ($s2) {
                    $query->whereIn('receipt', $s2);
 
                }, 'receipts.receiptDetails', 'receipts2.receiptDetails'])->where('is_active', 1)->where('debit_or_credit', 0)->get()->toArray(1));

            } else {
                $types=trans_type::where('cash_or_payment',0)->get()->pluck('id');
                $b = ($customerdata->transactions()->whereIn('trans_type',$types)->where('is_active', 1)->with('receipts', 'receipts.receiptDetails')->where('debit_or_credit', 1)->get()->toArray(1));

                $b2 = ($customerdata->transactions()->whereIn('trans_type',$types)->where('is_active', 1)->with('receipts', 'receipts.receiptDetails')->where('debit_or_credit', 0)->get()->toArray(1));
            }
            $customerdata['invoices'] = $b;
            $customerdata['receipts'] = $b2;

        }*/


        if (membership::where('kinship', $customernumber)->exists()) {
            $kincount = membership::where('kinship', $customernumber)->count();
        } else {
            $kincount = 0;
        }
        $customerdata['kins'] = $kincount + 1;

        return json_encode($customerdata);

    }


    function customerdatalike(request $request)
    {
        $customernumber = $request->customerid;
        $MOC = $request->MOC;

        
        if($MOC > 10 && $MOC < 22){

            $MOC=$MOC-10;

  $customerdata = customer::where('guest_type',$MOC)->where(function ($query) use ($customernumber) {
                $query->orWhere('customer_name', 'LIKE', "%{$customernumber}%")->orWhere('customer_contact', 'LIKE', "%{$customernumber}%")->orWhere('customer_no', 'LIKE', "%{$customernumber}%")->orWhere('id',$customernumber);
            })->limit(30)->get();


            /*$customerdata = customer::where('customer_name', 'LIKE', "%{$customernumber}%")->orWhere('customer_contact', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->orWhere('customer_no', 'LIKE', "%{$customernumber}%")->limit(30)->get();*/
       
        }
/*
 else if($MOC == 01){

  $customerdata = customer::where('guest_type',1)->where(function ($query) use ($customernumber) {
                $query->orWhere('customer_name', 'LIKE', "%{$customernumber}%")->orWhere('customer_contact', 'LIKE', "%{$customernumber}%")->orWhere('customer_no', 'LIKE', "%{$customernumber}%")->orWhere('id',$customernumber);
            })->limit(30)->get();
       
        }

       else if($MOC == 02){

  $customerdata = customer::where('guest_type',2)->where(function ($query) use ($customernumber) {
                $query->orWhere('customer_name', 'LIKE', "%{$customernumber}%")->orWhere('customer_contact', 'LIKE', "%{$customernumber}%")->orWhere('customer_no', 'LIKE', "%{$customernumber}%")->orWhere('id',$customernumber);
            })->limit(30)->get();
       
        }*/
 
        else if ($MOC == 1) {

            $customerdata = customer::where('customer_name', 'LIKE', "%{$customernumber}%")->orWhere('customer_contact', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->orWhere('customer_no', 'LIKE', "%{$customernumber}%")->limit(30)->get();
        }
         else if ($MOC == 22) {

            $customerdata = finance_ledger_person::where('person_name', 'LIKE', "%{$customernumber}%")->orWhere('person_contact', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->orWhere('person_no', 'LIKE', "%{$customernumber}%")->limit(30)->get();
        } else if ($MOC == 3) {

           /* $customerdata = hr_employment::with('hrcompany')->where('name', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->orWhere('barcode', 'LIKE', "%{$customernumber}%")->limit(30)->get();*/

             $customerdata = hr_employment::with('hrcompany')->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('barcode', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber);
            })->limit(30)->get();


        } else if ($MOC == 4) {
              $customerdata = coa_accounts_control::whereIn('cost_center',['1','2'])->where(function ($query) use ($customernumber) {
                $query->orWhere('name', 'LIKE', "%{$customernumber}%")->orWhere('code', 'LIKE', "%{$customernumber}%");
            })->limit(30)->get();

          /*   
            $customerdata = finance_account_type::where('type', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->limit(30)->get();*/
        } 
        else if ($MOC == 6){
            $customerdata = corporateMembership::with('mem_status')->where('first_name', 'LIKE', "%{$customernumber}%")->orWhere('middle_name', 'LIKE', "%{$customernumber}%")->orWhere('applicant_name', 'LIKE', "%{$customernumber}%")->orWhere('mem_no', 'LIKE', "%{$customernumber}%")
                ->orWhereRaw('concat(if(first_name is null, "",concat(first_name," ")), if(middle_name is null, "",concat(middle_name," ")), if(applicant_name is null, "",applicant_name)) like "%' . $customernumber . '%"')->limit(15)->get();
        }

        else {
            $customerdata = membership::with('mem_status')->where('first_name', 'LIKE', "%{$customernumber}%")->orWhere('middle_name', 'LIKE', "%{$customernumber}%")->orWhere('applicant_name', 'LIKE', "%{$customernumber}%")->orWhere('mem_no', 'LIKE', "%{$customernumber}%")
                ->orWhereRaw('concat(if(first_name is null, "",concat(first_name," ")), if(middle_name is null, "",concat(middle_name," ")), if(applicant_name is null, "",applicant_name)) like "%' . $customernumber . '%"')->limit(15)->get();
        }


        return json_encode($customerdata);

    }


    function comemdatalike(request $request)
    {
        $customernumber = $request->customerid;
        $MOC = $request->MOC;

    
            $customerdata = corporateMembership::with('mem_status')->where('first_name', 'LIKE', "%{$customernumber}%")->orWhere('middle_name', 'LIKE', "%{$customernumber}%")->orWhere('applicant_name', 'LIKE', "%{$customernumber}%")->orWhere('mem_no', 'LIKE', "%{$customernumber}%")
                ->orWhereRaw('concat(if(first_name is null, "",concat(first_name," ")), if(middle_name is null, "",concat(middle_name," ")), if(applicant_name is null, "",applicant_name)) like "%' . $customernumber . '%"')->limit(15)->get();
       

        return json_encode($customerdata);

    }



    function employeedatalike(request $request)
    {
        $customernumber = $request->customerid;


        $customerdata = hr_employment::where('name', 'LIKE', "%{$customernumber}%")->orWhere('id', $customernumber)->orWhere('barcode', 'LIKE', "%{$customernumber}%")->limit(30)->get();

        return json_encode($customerdata);

    }


    function cakebookingdatalike(request $request)
    {
        $bookingnumber = $request->bookingno;

        $data = fnb_cake_booking::where('booking_no', $bookingnumber)->limit(30)->get();

        return json_encode($data);

    }

    function cakebookingdata(request $request)
    {
        $bookingnumber = $request->bookingid;
        $data = fnb_cake_booking::where('id', $bookingnumber)->first();

        return json_encode($data);
    }

    function reservationdatalike(request $request)
    {
        $number = $request->reservationno;

        $data = fnb_table_reservation::where('reservation_no', $number)->limit(30)->get();

        return json_encode($data);

    }

    function reservationdata(request $request)
    {
        $number = $request->reservationid;

        $data = fnb_table_reservation::where('id', $number)->first();


        $data['selected_items'] = fnb_table_reservation_subs::selectRaw('fnb_table_reservation_subs.*,0 as product, 0 as varDisc,0 as totalamt')->where('sales_id', $number)->get();
        $data['tempvar'] = fnb_table_reservation::where('id', $number)->get()->pluck('grand_total');
        $data['tempgrandtotal'] = $data['tempvar'][0];


        return json_encode($data);
    }



    function designationdata(request $request)
    {
        $desnumber = $request->designationid;
  
         
            $customerdata = hr_employment::where('id', $desnumber)->first();
        
   
        return json_encode($customerdata);

    }


    function designationdatalike(request $request)
    {
        $desnumber = $request->designationid;
 
    $customerdata = hr_employment::where('designation', 'LIKE', "%{$desnumber}%")->groupBy('designation')->limit(30)->get();
       
        return json_encode($customerdata);

    }

     function empdata(request $request)
    {
         $desnumber = $request->empid;
  
         
            $customerdata = hr_employment::where('id', $desnumber)->first();
        
   
        return json_encode($customerdata);

    }


    function empdatalike(request $request)
    {
       $desnumber = $request->empid;
       $company = $request->company;
       $department = $request->department;
       $subdepartment = $request->subdepartment;


    /*$customerdata = hr_employment::with('hrcompany')->where('name', 'LIKE', "%{$desnumber}%")->whereIn('id', $company)->whereIn('id', $department)->whereIn('id', $subdepartment)->where(function ($query) use ($desnumber) {
                $query->orWhere('id', $desnumber);
            })->limit(30)->get();*/

       
   $customerdata = hr_employment::with('hrcompany')->where('name', 'LIKE', "%{$desnumber}%")->whereIn('id', $company)->whereIn('id', $department)->whereIn('id', $subdepartment)->limit(30)->get();


        return json_encode($customerdata);

    }


}
