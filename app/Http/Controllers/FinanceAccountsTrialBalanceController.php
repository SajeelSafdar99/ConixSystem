<?php

namespace App\Http\Controllers;
use App\coa_account;
use App\accounts_trial_balance;
use App\finance_account_head;
use App\finance_account_type;
use App\finance_payment_methods;
use App\membership;
use App\room_booking;
use App\room;
use App\room_type;
use App\trans_type;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Session;
use App\customer;
use App\room_payment_receipt;
use App\hr_department;
use App\hr_company;
use App\hr_sub_department;
use App\hr_employment;

class FinanceAccountsTrialBalanceController extends Controller
{ 
    public function acc_trial_vue(Request $request, accounts_trial_balance $accounts_trial_balance)
    {
       return view('backend/finance-and-management/finance-trial-balance/accounts-trial-balance-vue');
    }

       public function acc_trial_init_vue(Request $request)
    {
$search='';
if($request->get('start_date')){
    $search.=" and transactions.date >= '$request->start_date' ";
}if($request->get('end_date')){
    $search.=" and transactions.date <= '$request->end_date' ";
}if($request->get('filter')!=0){
    $search.=" and transactions.trans_type = '$request->filter' ";
}
if($request->get('pm')!=0){
    $search.=" and transactions.payment_method = '$request->pm' ";
}
if($request->get('unitsearch')){
    $search.=" and transactions.unit = '$request->unitsearch' ";
}
if($request->get('ent')=='Include ENT and CTS'){
   $search.=" and transactions.ent is not null  ";
}
if($request->get('ent')=='Exclude ENT and CTS'){
    $search.=" and transactions.ent = 0 ";
}
if($request->get('ent')=='Only ENT'){
    $search.=" and transactions.ent = 1 ";
}
if($request->get('ent')=='Only CTS'){ 
    $search.=" and transactions.ent = 2 ";
}
 if($request->get('mocid')!=0){
        $search.=" and transactions.trans_moc = '$request->mocid' ";

    }
     if($request->get('moc')!=5){
        $search.=" and transactions.trans_moc_type = '$request->moc' ";

    }else{
       $search.=" and transactions.trans_moc_type is not null ";
    }


  $data['trials'] =\Illuminate\Support\Facades\DB::select("select transactions.*, sum(if(transactions.debit_or_credit=0,transactions.trans_amount,0)) as credit, sum(if(transactions.debit_or_credit=1,transactions.trans_amount,0)) as debit, 
coa_accounts_controls.name as accname,
  coa_accounts_controls.code as acccode
   from transactions

     left outer join coa_accounts_controls on coa_accounts_controls.code=transactions.account 

 where transactions.type=3 and transactions.trans_type!=90 and transactions.deleted_at is null and transactions.account is not null and coa_accounts_controls.name is not null $search group by coa_accounts_controls.id order by accname asc"

/*select t.name,t.type,t.id,t.no_id,sum(if(trans.debit_or_credit=0,trans.trans_amount,0)) as credit,sum(if(trans.debit_or_credit=1,trans.trans_amount,0)) as debit,t.designation as designation,t.company as company,t.department as department,t.subdepartment as subdepartment from (
    select  CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name, 0 as type,id,mem_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from memberships where deleted_at is null and active!=7
    union all
    select customer_name as name, 1 as type, id,customer_no as no_id,0 as designation,0 as company,0 as department,0 as subdepartment from customers where deleted_at is null
    union all
    select name,3 as type,id,application_no as no_id,designation as designation,company as company,department as department,subdepartment as subdepartment from hr_employments where deleted_at is null
    union all
         select person_name as name, 2 as type, id, id as no_id,0 as designation,0 as company,0 as department,0 as subdepartment
         from finance_ledger_people
         where deleted_at is null
    ) as t
    inner join transactions  trans on trans.trans_moc_type=t.type and trans.trans_moc=t.id and trans.type=3  and trans.trans_type!=90 and trans.deleted_at is null $search
where 1=1 group by t.id,t.type order by id, type*/);
  $data['ccs']=coa_account::get();
$data['pms']=trans_type::where('type',7)->get();
 $data['filters']=trans_type::all();
 $data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['employees']=hr_employment::where('active',1)->get();
/*

    select name,3 as type,id,application_no as no_id,designation,company,department,subdepartment from hr_employments where deleted_at is null*/
     return $data;

}






   public function index_vue(Request $request, accounts_trial_balance $accounts_trial_balance)
    {
       return view('backend/finance-and-management/trial-balance/coa-trial-balance-vue');
    }

       public function acc_init_vue(Request $request)
    {
        $whereBooking='';
        $whereBooking2='';
        $whereinvoice='';
        $filter='';
        $fname='All';
        if($request->get('start_date')){
            $whereBooking=' AND `coa_transactions`.`date` '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
//           $whereinvoice='AND date '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
        }
        if($request->get('end_date')){
            $whereBooking2=' AND `coa_transactions`.`date` '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');
//           $whereinvoice='AND date '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');

        }
  $data['trials'] =\Illuminate\Support\Facades\DB::select("select
       sum(if(coa_transactions.debit_or_credit=1 and coa_transactions.is_active=1,coa_transactions.amount,0)) as  credit,
       sum(if(coa_transactions.debit_or_credit=0 ,coa_transactions.amount,0)) as  debit,
      coa_accounts_controls.name as name,
       coa_accounts_controls.cost_center as cost_center,
      coa_accounts_controls.code as code,
       0 as num,
    
       'type' as type
    from coa_transactions
       left outer join coa_accounts_controls on coa_accounts_controls.code=coa_transactions.account
       

where coa_transactions.deleted_at is null and coa_accounts_controls.deleted_at is null and coa_accounts_controls.name is not null $whereBooking $whereBooking2 group by coa_transactions.account ");

  $data['ccs']=coa_account::get();

     return $data;

}
     public function index(Request $request, accounts_trial_balance $accounts_trial_balance)
   {

         $data['customer']=$request->get('customer');
         $data['start_date']=$request->get('start_date');
         $data['end_date']=$request->get('end_date');
         $data['mog']=$request->get('mog');
         $data['types']=finance_account_type::all();
//         $data['types']=trans_type::all();
//dd($data);

         $data['roomtrialbalance']=0;

         return view('backend/finance-and-management/accounts-trial-balance/accounts-trial-balance',$data);
   }
   public function indexdt(Request $request,accounts_trial_balance $accounts_trial_balance){
       $data['member']=1;
       $whereBooking='';
       $whereBooking2='';
       $whereinvoice='';
       $filter='';
       $fname='All';
       if($request->get('start_date')){
           $whereBooking=' AND `transactions`.`date` '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
//           $whereinvoice='AND date '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
       }
       if($request->get('end_date')){
           $whereBooking2=' AND `transactions`.`date` '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');
//           $whereinvoice='AND date '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');

       }

       $moc=finance_account_type::selectRaw("
       sum(if(transactions.debit_or_credit=1 and transactions.is_active=1,transactions.trans_amount,0)) as  credit,
       sum(if(transactions.debit_or_credit=0 ,transactions.trans_amount,0)) as  debit,
      trans_types.name as name,
       0 as num,
       trans_types.id as id,
       'type' as type
    from transactions
       left outer join trans_types on trans_types.id=transactions.trans_type_id and trans_types.type=7
where transactions.trans_type not in (trans_types.id) and transactions.deleted_at is null and trans_types.deleted_at is null $whereBooking$whereBooking2 group by transactions.trans_type_id ");

       if($request->get('mog')){

           $moc->where('id',$request->get('mog'));

       }



       if($request->get('paid')){
           if($request->get('paid')==1){
               $moc->havingRaw("(IFNULL(debit,0)-IFNULL(credit,0))<0");

           }
           if($request->get('paid')==2){
//               $moc->havingRaw("credit > 0 or debit>0");
               $moc->havingRaw("(IFNULL(debit,0)-IFNULL(credit,0))>0");

           }

       }
       else{
           //$moc->havingRaw("credit > 0 or debit>0");
       }
        $moc->orderBy("id",'asc');
        //dd($moc->toSql());
       if(1==1){
           $d=$moc->get();

       }
else{
    $d=[];
}
       return DataTables::of($d)



           ->addIndexColumn()
           ->make(true);

   }

}
