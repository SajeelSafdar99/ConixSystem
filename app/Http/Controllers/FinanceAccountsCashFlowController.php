<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\accounts_cash_flow;
use DB;
use Session;
use DataTables;
use App\transactions;
use App\trans_type;
use App\trans_relations;
use Carbon\Carbon;

class FinanceAccountsCashFlowController extends Controller
{
     public function index(Request $request, accounts_cash_flow $accounts_cash_flow)
    {
    $data['types'] =trans_type::get();

      $data['start_date'] =$request->get('start_date');
      $data['end_date'] =$request->get('end_date');
      $data['type'] =$request->get('type');
      
if($request->get('type')){
   $data['transtypes'] =trans_type::where('name',$request->get('type'))->get();
}
else{
  $data['transtypes'] =trans_type::get();
}


$r =transactions::where('debit_or_credit',0);

if($request->get('start_date')){
    $r->where('date','>=',formatDate($request->get('start_date')));
}
 if($request->get('end_date')){
    $r->where('date','<=',formatDate($request->get('end_date')));
}
       
        $data['debit_trans'] = $r->get();



        return view('backend/finance-and-management/accounts-cash-flow/accounts-cash-flow',$data);
    }

}
