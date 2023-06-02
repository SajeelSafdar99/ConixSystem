<?php

namespace App\Http\Controllers;
use App\coa_account;
use App\finance_account_type;
use App\finance_invoice;
use App\finance_accounts_ledgers;
use App\finance_payment_methods;
use App\room_booking;
use App\membership;
use App\room;
use App\room_type;
use App\trans_type;
use App\transactions;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\View;
use Session;
use App\customer;
use App\room_payment_receipt;
use DB;
use App\hr_department;
use App\hr_company;
use App\hr_sub_department;
use App\coa_accounts_control;

class FinanceAccountsLedgersController extends Controller
{


      public function acc_vue(Request $request, finance_accounts_ledgers $finance_accounts_ledgers)
    {

         return view('backend/finance-and-management/finance-ledger-accounts/accounts-ledger-vue');
    }
 
       public function acc_init_vue(Request $request)
    {
        $search='';
        $search2='';
if($request->moc==22){
  $request->moc=2;
}

        if($request->get('start_date')){
            $search.=" and transactions.date >= '$request->start_date' ";
            $search2.=" and transactions.date < '$request->start_date' ";
        }
        else{
            $search2.=" and 1=2 ";
        }if($request->get('end_date')){
        $search.=" and transactions.date <= '$request->end_date' ";
    }
        if($request->get('filter')!=0){
        $search.=" and transactions.trans_type = '$request->filter' ";
        $search2.=" and transactions.trans_type = '$request->filter' ";
    } 
  if($request->get('pm')!=0){
        $search.=" and transactions.payment_method = '$request->pm' ";
        $search2.=" and transactions.payment_method = '$request->pm' ";
    } 
     if($request->get('unitsearch')){
        $search.=" and transactions.unit = '$request->unitsearch' ";
        $search2.=" and transactions.unit = '$request->unitsearch' ";
    } 
    if($request->get('account')){
        $search.=" and transactions.account = '$request->account' ";
        $search2.=" and transactions.account = '$request->account' ";
    } 
     if($request->get('accsearchid')){
        $search.=" and transactions.account = '$request->accsearchid' ";
        $search2.=" and transactions.account = '$request->accsearchid' ";
    } 
     if($request->get('mocid')!=0){
        $search.=" and transactions.trans_moc = '$request->mocid' ";
        $search2.=" and transactions.trans_moc = '$request->mocid' ";
    }
    if($request->get('ent')=='Include ENT and CTS'){
   $search.=" and transactions.ent is not null  ";
   $search2.=" and transactions.ent is not null  ";
}
if($request->get('ent')=='Exclude ENT and CTS'){
    $search.=" and transactions.ent = 0 ";
    $search2.=" and transactions.ent = 0 ";
}
if($request->get('ent')=='Only ENT'){
    $search.=" and transactions.ent = 1 ";
    $search2.=" and transactions.ent = 1 ";
}
if($request->get('ent')=='Only CTS'){
    $search.=" and transactions.ent = 2 ";
    $search2.=" and transactions.ent = 2 ";
}

if($request->get('moc')!=5){
        $search.=" and transactions.trans_moc_type = '$request->moc' ";
        $search2.=" and transactions.trans_moc_type = '$request->moc' ";

    }else{
       $search.=" and transactions.trans_moc_type is not null ";
       $search2.=" and transactions.trans_moc_type is not null ";
    }
    
      /*  $search.=" and transactions.trans_moc_type = '$request->moc' ";
        $search2.=" and transactions.trans_moc_type = '$request->moc' ";
*/

  $data['ledgers'] =\Illuminate\Support\Facades\DB::select("select transactions.id as mainid, transactions.date,
       transactions.account,
       transactions.trans_type_id,
       transactions.trans_amount,
       transactions.debit_or_credit,
       transactions.receipt_id,
       coa_accounts_controls.name as accname,
        coa_accounts_controls.code as acccode,
       pm.name as payment_method,

memberships.mem_no as mem_no,
customers.id as customer_no,
finance_ledger_people.id as person_no,
hr_employments.id as emp_no,
coaa.name as coaname,

       if(transactions.trans_moc_type = 0,
          CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
                 coalesce(memberships.middle_name, ''), ' ',
                 coalesce(memberships.applicant_name, '')), if(transactions.trans_moc_type = 1,
          customers.customer_name, if(transactions.trans_moc_type = 2, finance_ledger_people.person_name,hr_employments.name))) as name,

          hr_employments.designation as designation,
          coa_accounts.name as company,
       transactions.trans_moc_type                      as type
        ,
       trans_types.name                                 as type_name
from transactions
 
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join trans_types pm on pm.id = transactions.payment_method
         left outer join memberships on memberships.id = transactions.trans_moc and transactions.trans_moc_type = 0
         left outer join customers on customers.id = transactions.trans_moc and transactions.trans_moc_type = 1
       left outer join coa_accounts_controls coaa on coaa.code = transactions.trans_moc and transactions.trans_moc_type =4

         left outer join finance_ledger_people on finance_ledger_people.id = transactions.trans_moc and transactions.trans_moc_type=2
         left outer join hr_employments
                         on hr_employments.id = transactions.trans_moc and transactions.trans_moc_type = 3
         left outer join coa_accounts
                         on coa_accounts.code = hr_employments.company
                              left outer join coa_accounts_controls on coa_accounts_controls.code=transactions.account 

where transactions.deleted_at is null and transactions.type=3 and transactions.trans_type!=90 and transactions.account is not null and coa_accounts_controls.name is not null $search  group by transactions.id order by `date` asc");
//        echo "select (sum(if(debit_or_credit=0,trans_amount,0))-sum(if(debit_or_credit=1,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.trans_type<90 $search2  ";
        $data['opening'] =\Illuminate\Support\Facades\DB::select("select (sum(if(debit_or_credit=1,trans_amount,0))-sum(if(debit_or_credit=0,trans_amount,0))) as opening from transactions transactions where  transactions.deleted_at is null and transactions.type=3 and transactions.trans_type!=90 and transactions.account is not null $search2  ")[0];
        
  $data['ccs']=coa_account::get();
$data['filters']=trans_type::all();
$data['pms']=trans_type::where('type',7)->get();
$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
 $data['paymentmethods']=finance_payment_methods::where('status',1)->get();
$data['accountss']=coa_accounts_control::whereIn('cost_center',['1','2'])->get();
$data['coaaccounts']=coa_accounts_control::all();
     return $data;

}





    public function index_vue(Request $request, finance_accounts_ledgers $finance_accounts_ledgers)
    {
      return view('backend/finance-and-management/ledgers/coa-ledgers-vue');
    }

       public function coaledgers_init_vue(Request $request)
    {
       $search='';
        $whereBooking='';
        $whereBooking2='';
        $whereinvoice='';
        $filter='';
        $fname='All';
        
        if($request->get('start_date')){
            $whereBooking=' AND `coa_transactions`.`date` '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
     
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
       

where coa_transactions.deleted_at is null and coa_accounts_controls.deleted_at is null and coa_accounts_controls.name is not null $whereBooking $whereBooking2   group by coa_transactions.id order by coa_accounts_controls.name asc");

    $data['opening'] =\Illuminate\Support\Facades\DB::select("select (sum(if(debit_or_credit=0,amount,0))-sum(if(debit_or_credit=1,amount,0))) as opening from coa_transactions where  coa_transactions.deleted_at is null and (coa_transactions.is_active = 1 || coa_transactions.debit_or_credit = 0) $whereBooking $whereBooking2")[0];

  $data['ccs']=coa_account::get();

     return $data;
}



       public function accledgers_init_vue(Request $request)
    {
        $whereBooking='';
        $whereBooking2='';
        $whereinvoice='';
        $filter='';
        $fname='All';
        if($request->get('start_date')){
            $whereBooking=' AND `transactions`.`date` '.'>='. \Illuminate\Support\Facades\DB::raw('"'.formatDate($request->get('start_date')).'"');
//           $whereinvoice='AND date '.'>='.DB::raw('"'.formatDate($request->get('start_date')).'"');
        }
        if($request->get('end_date')){
            $whereBooking2=' AND `transactions`.`date` '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');
//           $whereinvoice='AND date '.'<='.DB::raw('"'.formatDate($request->get('end_date')).'"');

        }
  $data['ledgers'] =\Illuminate\Support\Facades\DB::select("select t.*,
       if(t.trans_moc_type = 0,
          CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
                 coalesce(memberships.middle_name, ''), ' ',
                 coalesce(memberships.applicant_name, '')), if(t.trans_moc_type = 1,
                                                               customers.customer_name,
                                                               if(t.trans_moc_type = 2,
                                                                  finance_ledger_people.person_name,
                                                                  hr_employments.name))) as name,
       if(t.trans_moc_type = 0,memberships.mem_no,if(t.trans_moc_type = 1,customers.id,null)) as mem_no,
       trans_types.name as tname,
       trans_types.id as trans_type2,
       transactions.trans_type_id as trans_type_id2

       from (
select transactions.id,
       transactions.trans_amount,
       transactions.trans_moc,
       transactions.trans_moc_type,
       transactions.trans_type_id,
       transactions.trans_type,
       transactions.debit_or_credit,
       transactions.date,
       fpm.desc as name,
       fpm.id as accid,
       trans_types.name as type_name,
       trans_relations.receipt as recid

from transactions
         left outer join trans_types on trans_types.id=transactions.trans_type_id and trans_types.type=7
         left outer   join finance_payment_methods fpm on trans_types.mod_id = fpm.id
        left outer join trans_relations on trans_relations.account=transactions.id

where
      transactions.deleted_at is null

    and (transactions.is_active = 1 or transactions.debit_or_credit = 0)
  and  transactions.trans_type not in (trans_types.id)
$whereBooking $whereBooking2
group by transactions.id order by transactions.date asc) as t
                left outer join memberships on memberships.id=t.trans_moc
                left outer join customers on customers.id=t.trans_moc
                left outer join finance_ledger_people on finance_ledger_people.id=t.trans_moc
                left outer join hr_employments on hr_employments.id=t.trans_moc
                left outer join transactions on transactions.id = t.recid
                left outer join trans_types on trans_types.id=transactions.trans_type");

        $data['types']=finance_payment_methods::where('status',1)->get();
        $data['types2']=trans_type::where('type','<=',5)->get();


     return $data;
}

    public  function index(Request $request, finance_accounts_ledgers $finance_accounts_ledgers)
    {
//dd(12);
        $transactions = transactions::query();

        if ($request->get('mog')) {
            $transactions->where('trans_type_id', ($request->get('mog')));

        }
        if ($request->get('mog')) {
//            $transactions->where('trans_moc_type', $request->get('mog'));

        } else {
         //   $transactions->where('trans_moc_type', 0);

        }
        if ($request->get('mog_id')) {


        }
        else{
            //$transactions->where('trans_type', 90);

        }
        if ($request->get('start_date')) {
            $transactions->where('date', '>=', formatDate($request->get('start_date')));

        }
        else{
//            $transactions->where('date', '>=', formatDate(date('Y-m-d',time())));

        }
        if ($request->get('end_date')) {
            $transactions->where('date', '<=', formatDate($request->get('end_date')));

        }
        if ($request->get('receipt')) {
            $transactions->where('receipt_id', ($request->get('receipt')));


        }
        if ($request->get('filter')) {
            $transactions->where('trans_type', $request->get('filter'));

        }
//        dd($transactions->toSql());
//        $transactions->where('debit_or_credit', 1);
//dd($transactions->with('type')->orderBy('date','asc')->whereRaw('(is_active =1 OR debit_or_credit=0)')->toSql());
        if ($request->get('start_date') ||
            $request->get('end_date') ||
            $request->get('filter') ||
            $request->get('mog') ||
            $request->get('mog_id') || $request->get('receipt') ||
            $request->get('booking_no') || true) {
if($request->get('start_date') ){
//    $mmm=$request->get('mog')?$request->get('mog'):0;
    $c=$request->get('start_date')?$request->get('start_date'):date('Y-m-d',time());
    $dopen=transactions::where('date', '<', formatDate($c))->whereRaw('debit_or_credit=0')->doesnthave('type');
    $copen=transactions::where('date', '<', formatDate($c))->whereRaw('debit_or_credit=1 and is_active=1')->doesnthave('type');
    if ($request->get('filter')) {
        $dopen->where('trans_type', $request->get('filter'));
        $copen->where('trans_type', $request->get('filter'));

    }  if ($request->get('mog')) {
        $dopen->where('trans_type_id', $request->get('mog'));
        $copen->where('trans_type_id', $request->get('mog'));

    }


    $dopen=$dopen->get()->sum('trans_amount');
        $copen=$copen->get()->sum('trans_amount');

    $data['opening']=$dopen-$copen;

}
else{
    $data['opening']=0;
}
        $t = $transactions->with('accounts')->whereRaw(' is_active = 1 ')->orderBy('date', 'asc')->doesnthave('type')->orderBy('id')->get()->toArray();
    }
    else {
    $t=[];
        $data['opening']=0;
    }


        $data['data']=$t;

        $data['types']=finance_account_type::all();
        $data['ty']=[
            90=>['Cash Receipts','cash.receipt.print'],
            91=>['Payment Receipts','payment.receipt.print'],
            92=>['Vouchers','JVinvoice']
        ];
        $data['roomledgeraccounts']=0;
        $data['customer']=$request->get('customer');
        $data['start_date']=$request->get('start_date');
        $data['end_date']=$request->get('end_date');

        $data['booking_no']=$request->get('booking_no');
        $data['receipt']=$request->get('receipt');
        $data['mog_id']=$request->get('mog_id');
        $data['mog']=$request->get('mog');
        $data['filter']=$request->get('filter');

        return view('backend/finance-and-management/accounts-ledgers/accounts-ledgers',$data);

    }
}
