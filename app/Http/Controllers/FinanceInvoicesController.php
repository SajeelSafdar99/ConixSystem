<?php

namespace App\Http\Controllers;
use App\guest_type;
use App\finance_cash_receipt;
use App\finance_invoice_subs;
use App\finance_invoice;
use App\transactions;
use App\trans_relations;
use App\finance_account_type;
use App\finance_invoice_charges_type;
use Illuminate\Http\Request;
use DataTables;
use App\admin_company_profile;
use App\customer;
use App\membership;
use App\mem_family;
use App\sports_subscription;
use Session;
use App\room_booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\trans_type;
use App\mem_category;
use Spatie\Permission\Models\Permission;
use App\User;
use App\corporateMembership;

class FinanceInvoicesController extends Controller
{

    public function index_vue(Request $request, finance_invoice $finance_invoice)
    {

        return view('backend/finance-and-management/finance-invoices/finance-invoices-vue');

    }

    public function invoices_init(Request $request)
    {
        $data['invoices'] = \Illuminate\Support\Facades\DB::select('select finance_invoices.*,
       memberships.title                                                                                  as tname,
       memberships.applicant_name                                                                         as lname,
       memberships.first_name                                                                             as fname,
       memberships.middle_name                                                                            as mname,
       memberships.mem_no                                                                                 as mem_no,
       if(sum(DISTINCT transactions.trans_amount) > 0, sum(DISTINCT transactions.trans_amount),
          0)                                                                                              as paid_amount,
       GROUP_CONCAT(DISTINCT transactions.receipt_id)                                                     as reciept_id,
       trans_types.name                                                                                   as type_name,
       mem_families.title                                                                                 as tfamily,
       mem_families.first_name                                                                            as ffamily,
       mem_families.middle_name                                                                           as mfamily,
       mem_families.name                                                                                  as lfamily,
       finance_invoices.start_date                                                                    as start_date,
       finance_invoices.end_date                                                                      as end_date
        ,
       trans_types.name                          as ttname
        ,

       group_concat(concat(coalesce(mem_families.title, ""), " ", coalesce(mem_families.first_name, ""), " ",
                           coalesce(mem_families.middle_name, ""), " ",
                           coalesce(mem_families.name, "")))                                              as familymember

from finance_invoices
         left outer join transactions
                         on transactions.trans_type_id = finance_invoices.id and
                            transactions.debit_or_credit = 0 and transactions.deleted_at is null
         left outer join memberships on memberships.id = finance_invoices.member_id and memberships.deleted_at is null
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join mem_families on mem_families.id in (finance_invoices.family)
where finance_invoices.deleted_at is null
group by finance_invoices.id
order by finance_invoices.id desc');


        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;

        return $data;
    }

  
    public function new_invoices_init(Request $request)
    {
$search='';
if($request->get('start_date')){
    $search.=' and  finance_invoices.start_date >="'.$request->get('start_date').'"';
}
if($request->get('end_date')){
    $search.=' and  finance_invoices.start_date <="'.$request->get('end_date').'"';

}

if($request->get('mstart_date')){
    $search.=' and  finance_invoices.invoice_date >="'.$request->get('mstart_date').'"';
}
if($request->get('mend_date')){
    $search.=' and  finance_invoices.invoice_date <="'.$request->get('mend_date').'"';

}
if($request->get('invoiceno')){
     $search.=' and  finance_invoices.invoice_no = "'.$request->get('invoiceno').'"';
}
if($request->get('mog')==2){
     $search.=' and finance_invoices.invoice_type is not null';
}
if($request->get('mog')>10){
     $search.=' and  finance_invoices.invoice_type =1';
if($request->get('mocid')){
    $search.=' and  finance_invoices.customer_id ="'.$request->get('mocid').'"';

}
}
if($request->get('mog')==0){
     $search.=' and  finance_invoices.invoice_type =0';
if($request->get('mocid')){
    $search.=' and  finance_invoices.member_id ="'.$request->get('mocid').'"';

}
}

if($request->get('mog')==6){
     $search.=' and  finance_invoices.invoice_type =6';
if($request->get('mocid')){
    $search.=' and  finance_invoices.corporate_id ="'.$request->get('mocid').'"';

}
}

if($request->get('details')){
    $search.=' and  finance_invoices.charges_type ="'.$request->get('details').'"';
}
if($request->get('cashier')){
            $search.=' and  finance_invoices.created_by in ('.$request->get('cashier').') ';
        }
if($request->get('rcashier')){
            $search.=' and  transactions.created_by in ('.$request->get('rcashier').') ';
        }

 if($request->r){
        $data['invoices'] = \Illuminate\Support\Facades\DB::select('select finance_invoices.*, memberships.title as tname, 
    customers.guest_type                                  as cgt,
    
    customers.customer_name as customer,
    guest_types.desc as guesttype,
            memberships.applicant_name as lname,memberships.first_name as fname,memberships.middle_name as mname,memberships.mem_no as mem_no,st1.desc as activity,


corporate_memberships.title as ctname,
  corporate_memberships.applicant_name as clname,corporate_memberships.first_name as cfname,corporate_memberships.middle_name as cmname,corporate_memberships.mem_no as co_mem_no,st2.desc as cactivity,


             if(sum(transactions.trans_amount )>0,sum( transactions.trans_amount ),0) as paid_amount , 

             GROUP_CONCAT(DISTINCT transactions.receipt_id) as reciept_id, 
   group_concat(distinct if(finance_invoices.status is null,trans_types.name  ,concat(trans_types.name," ","(",finance_invoices.status,")")) SEPARATOR "<br>") as ttname
,


  group_concat( if(finance_invoices.discount_amount is not null,finance_invoices.discount_amount  ,concat(finance_invoices.discount_percentage," ","%")) ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as discount
,
 group_concat(concat(finance_invoices.extra_percentage," ","%") ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as overdue
,
 group_concat(concat(finance_invoices.tax_percentage," ","%") ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as taxed
,

 
group_concat(finance_invoices.status) as statuss,

  group_concat( distinct finance_invoices.id ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as multiid
   ,
group_concat(finance_invoices.status) as statuss,

   group_concat(distinct if(finance_invoices.status is not null,0  ,concat(finance_invoices.sub_total,"-",finance_invoices.id)) ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as grandtotal


,

   group_concat(distinct if(finance_invoices.status is not null,0  ,concat(finance_invoices.grand_total,"-",finance_invoices.id)) ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as othergrandtotal


,

group_concat( 
    CASE
    WHEN finance_invoices.family=01 THEN "Guest"
    WHEN finance_invoices.family=02 THEN "Self"
    WHEN finance_invoices.family not in (01,02) THEN concat(coalesce(familia.title,"")," ",coalesce(familia.first_name,"")," ",coalesce(familia.middle_name,"")," ",coalesce(familia.name,""))
    ELSE " "
    END
  ORDER BY finance_invoices.id ASC SEPARATOR "<br>")  as familymember,

group_concat( 
    CASE
    WHEN finance_invoices.family=01 THEN "Guest"
    WHEN finance_invoices.family=02 THEN "Self"
    WHEN finance_invoices.family not in (01,02) THEN concat(coalesce(cop_familia.title,"")," ",coalesce(cop_familia.first_name,"")," ",coalesce(cop_familia.middle_name,"")," ",coalesce(cop_familia.name,""))
    ELSE " "
    END
  ORDER BY finance_invoices.id ASC SEPARATOR "<br>")  as cop_familymember,
 
   group_concat(distinct concat(coalesce(DATE_FORMAT(finance_invoices.start_date,"%d-%b"),""),"-",coalesce(DATE_FORMAT(finance_invoices.end_date,"%d-%b %y"),"")) ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as duration,

   users.name as cashiername,
    ruser.name as rcashiername

 from finance_invoices
left outer join transactions on transactions.trans_type=finance_invoices.charges_type and transactions.trans_type_id=finance_invoices.id and transactions.debit_or_credit=0 and transactions.type=2 and transactions.deleted_at is null

left outer join memberships on memberships.id=finance_invoices.member_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id=finance_invoices.corporate_id and corporate_memberships.deleted_at is null
left outer join customers on customers.id=finance_invoices.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id=customers.guest_type and guest_types.deleted_at is null
left outer join mem_statuses st1 on st1.id=memberships.active and st1.status=1
left outer join mem_statuses st2 on st2.id=corporate_memberships.active and st2.status=1
left outer join mem_families familia on familia.id =finance_invoices.family
left outer join corporate_mem_families cop_familia on cop_familia.id =finance_invoices.family
left outer join users on users.id =finance_invoices.created_by and users.status=1
left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1
left outer join trans_types on trans_types.id =finance_invoices.charges_type
where finance_invoices.deleted_at is null '.$search.' group by finance_invoices.invoice_no order by DATE(finance_invoices.invoice_date) desc');
}
else{
       $data['invoices']=[];
}


/*mem_families.title as tfamily,mem_families.first_name as ffamily,mem_families.middle_name as mfamily,mem_families.name as lfamily

 ,
*/


/* group_concat(concat(coalesce(mem_families.title,"")," ",coalesce(mem_families.first_name,"")," ",coalesce(mem_families.middle_name,"")," ",coalesce(mem_families.name,"")) ORDER BY finance_invoices.id ASC SEPARATOR "<br>") as familymember
  ,
*/
/*
and transactions.trans_moc=finance_invoices.member_id*/



        /*


         group_concat(distinct concat(finance_invoices.grand_total,"-",finance_invoices.id)  SEPARATOR "<br>") as grandtotal




        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }*/
 $data['gts']=guest_type::where('status',1)->get();
        $data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
  $data['users']= User::where('status',1)->get();
        return $data;
    }




    /// CANCELLED INVOICES
      public function canceled_index_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/finance-invoices/finance-cancelled-invoices-vue');
    }

        public function cancelled_invoices_init(Request $request)
    {
$search='';
if($request->get('start_date')){
    $search.=' and  finance_invoices.start_date >="'.$request->get('start_date').'"';
}
if($request->get('end_date')){
    $search.=' and  finance_invoices.start_date <="'.$request->get('end_date').'"';

}

        $data['invoices'] = \Illuminate\Support\Facades\DB::select('select finance_invoices.*, memberships.title as tname, memberships.applicant_name as lname,memberships.first_name as fname,memberships.middle_name as mname,memberships.mem_no as mem_no,

         corporate_memberships.title as ctname, corporate_memberships.applicant_name as clname,corporate_memberships.first_name as cfname,corporate_memberships.middle_name as cmname,corporate_memberships.mem_no as co_mem_no,

          if(sum(transactions.trans_amount )>0,sum( transactions.trans_amount ),0) as paid_amount , GROUP_CONCAT(DISTINCT transactions.receipt_id) as reciept_id

 ,
   group_concat(distinct concat(trans_types.name," ") SEPARATOR "<br>") as ttname
,

  group_concat( distinct finance_invoices.id  SEPARATOR "<br>") as multiid
   ,
group_concat(finance_invoices.status) as statuss,


   group_concat(distinct concat(finance_invoices.grand_total,"-",finance_invoices.id) SEPARATOR "<br>") as grandtotal


,




group_concat( 
    CASE
    WHEN finance_invoices.family=01 THEN "Guest"
    WHEN finance_invoices.family=02 THEN "Self"
    WHEN finance_invoices.family not in (01,02) THEN concat(coalesce(familia.title,"")," ",coalesce(familia.first_name,"")," ",coalesce(familia.middle_name,"")," ",coalesce(familia.name,""))
    ELSE " "
    END
  ORDER BY finance_invoices.id ASC SEPARATOR "<br>")  as familymember,

group_concat( 
    CASE
    WHEN finance_invoices.family=01 THEN "Guest"
    WHEN finance_invoices.family=02 THEN "Self"
    WHEN finance_invoices.family not in (01,02) THEN concat(coalesce(cop_familia.title,"")," ",coalesce(cop_familia.first_name,"")," ",coalesce(cop_familia.middle_name,"")," ",coalesce(cop_familia.name,""))
    ELSE " "
    END
  ORDER BY finance_invoices.id ASC SEPARATOR "<br>")  as cop_familymember,




   group_concat(distinct concat(coalesce(DATE_FORMAT(finance_invoices.start_date,"%d-%b"),""),"-",coalesce(DATE_FORMAT(finance_invoices.end_date,"%d-%b %y"),""))  SEPARATOR "<br>") as duration,

   users.name as cashiername

 from finance_invoices
left outer join transactions on transactions.trans_type=finance_invoices.charges_type and transactions.trans_type_id=finance_invoices.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join memberships on memberships.id=finance_invoices.member_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id=finance_invoices.corporate_id and corporate_memberships.deleted_at is null

left outer join mem_families familia on familia.id =finance_invoices.family
left outer join corporate_mem_families cop_familia on cop_familia.id =finance_invoices.family


left outer join users on users.id =finance_invoices.created_by and users.status=1
left outer join trans_types on trans_types.id =finance_invoices.charges_type
where finance_invoices.deleted_at is null and finance_invoices.status="Cancelled" '.$search.' group by finance_invoices.invoice_no order by finance_invoices.id desc');

/* and transactions.trans_moc=finance_invoices.member_id */
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;

        return $data;
    }


    /// CANCELLED INVOICES


  public function index_reinstating_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/reinstating-fee/reinstating-fee-vue');
    }

    public function reinstating_init(Request $request)
    {
       
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,

            mem_categories.desc                                                   as catname,
       finance_invoices.customer_id,
       memberships.mem_no,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,

       CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name,
       memberships.gender                               as mgender,
        memberships.kinship                               as kins,
        memberships.cur_city                                                      as mcity,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,
       finance_invoices.member_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                    as rd,
       transactions.trans_amount                    as total,
         ruser.name as rcashiername,
 transactions.created_by as ruserid


from transactions

         join finance_invoices on transactions.trans_type_id = finance_invoices.id
         left outer join memberships on memberships.id = finance_invoices.member_id
         left outer join mem_families mf on finance_invoices.family = mf.id
         left outer join customers c on c.id = finance_invoices.customer_id
left outer join mem_categories on mem_categories.id=memberships.mem_category_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
          left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.id = 49 and transactions.debit_or_credit=0 and transactions.trans_moc=finance_invoices.member_id

order by finance_invoices.member_id asc

");

        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
        $data['paymentmethods']=trans_type::where('type',7)->get();
        $data['categories']=mem_category::where('status',1)->get();
  $data['users']= User::where('status',1)->get();

        return $data;
    }





    public function index_subscriptions_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/finance-subscriptions/finance-subscriptions-vue');
    }

    public function subscriptions_init(Request $request)
    {
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,
       finance_invoices.customer_id,
       memberships.mem_no as mem_no,
        corporate_memberships.mem_no as co_mem_no,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,

       CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name,


       CONCAT(coalesce(corporate_memberships.title, ''), ' ', coalesce(corporate_memberships.first_name, ''), ' ',
              coalesce(corporate_memberships.middle_name, ''), ' ',
              coalesce(corporate_memberships.applicant_name, '')) as coname,

       memberships.gender                               as mgender,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,

 corporate_memberships.gender                               as cgender,
               cmf.gender                                        as cmfgender,
       CONCAT(coalesce(cmf.title, ''), ' ', coalesce(cmf.first_name, ''), ' ', coalesce(cmf.middle_name, ''), ' ',
              coalesce(cmf.name, ''))                    as cfname,

       finance_invoices.member_id,
       finance_invoices.corporate_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                    as rd,
       transactions.trans_amount                        as total,
       finance_invoices.family as familia,
        ruser.name as rcashiername,
 transactions.created_by as ruserid


from transactions

         join finance_invoices on transactions.trans_type_id = finance_invoices.id
         left outer join memberships on memberships.id = finance_invoices.member_id and finance_invoices.invoice_type=0
  left outer join corporate_memberships on corporate_memberships.id = finance_invoices.corporate_id and finance_invoices.invoice_type=6
         left outer join mem_families mf on finance_invoices.family = mf.id and finance_invoices.invoice_type=0
         left outer join corporate_mem_families cmf on finance_invoices.family = cmf.id and finance_invoices.invoice_type=6
         left outer join customers c on c.id = finance_invoices.customer_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
         left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.type = 3 and transactions.debit_or_credit=0 and (transactions.trans_moc=finance_invoices.member_id || transactions.trans_moc=finance_invoices.corporate_id || transactions.trans_moc=finance_invoices.customer_id)

order by finance_invoices.id desc

");
// and (trans_types.type = 3 ||  trans_types.id = 49)
//dd( $data['invoices'] );
        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
        $data['paymentmethods']=trans_type::where('type',7)->get();
        $data['gts']=guest_type::where('status',1)->get();
          $data['users']= User::where('status',1)->get();

        return $data;
    }




    public function index_co_maintenance_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/maintenance-fee/corporate-maintenance-fee-vue');
    }

    public function co_maintenance_init(Request $request)
    { 
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,

            mem_categories.desc                                                   as catname,
       finance_invoices.customer_id,
       corporate_memberships.mem_no,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,

       CONCAT(coalesce(corporate_memberships.title, ''), ' ', coalesce(corporate_memberships.first_name, ''), ' ',
              coalesce(corporate_memberships.middle_name, ''), ' ',
              coalesce(corporate_memberships.applicant_name, '')) as name,
       corporate_memberships.gender                               as mgender,
      
        corporate_memberships.cur_city                                                      as mcity,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,
       finance_invoices.corporate_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                    as rd,
       transactions.trans_amount                    as total,
         ruser.name as rcashiername,
 transactions.created_by as ruserid


from transactions

         join finance_invoices on transactions.trans_type_id = finance_invoices.id
         left outer join corporate_memberships on corporate_memberships.id = finance_invoices.corporate_id
      left outer join corporate_mem_families mf on finance_invoices.family = mf.id

         left outer join customers c on c.id = finance_invoices.customer_id
left outer join mem_categories on mem_categories.id=corporate_memberships.mem_category_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
          left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.id = 4 and transactions.debit_or_credit=0 and transactions.trans_moc=finance_invoices.corporate_id

order by finance_invoices.corporate_id asc

");

        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
        $data['paymentmethods']=trans_type::where('type',7)->get();
        $data['categories']=mem_category::where('status',1)->get();
  $data['users']= User::where('status',1)->get();

        return $data;
    }


  public function co_index_reinstating_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/reinstating-fee/corporate-reinstating-fee-vue');
    }

    public function co_reinstating_init(Request $request)
    {
       
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,

            mem_categories.desc                                                   as catname,
       finance_invoices.customer_id,

        finance_invoices.corporate_id,
       corporate_memberships.mem_no,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,

       CONCAT(coalesce(corporate_memberships.title, ''), ' ', coalesce(corporate_memberships.first_name, ''), ' ',
              coalesce(corporate_memberships.middle_name, ''), ' ',
              coalesce(corporate_memberships.applicant_name, '')) as name,
       corporate_memberships.gender                               as mgender,
        corporate_memberships.kinship                               as kins,
        corporate_memberships.cur_city                                                      as mcity,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,
       finance_invoices.member_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                    as rd,
       transactions.trans_amount                    as total,
         ruser.name as rcashiername,
 transactions.created_by as ruserid


from transactions

         join finance_invoices on transactions.trans_type_id = finance_invoices.id
        left outer join corporate_memberships on corporate_memberships.id = finance_invoices.corporate_id
      left outer join corporate_mem_families mf on finance_invoices.family = mf.id
         left outer join customers c on c.id = finance_invoices.customer_id
left outer join mem_categories on mem_categories.id=corporate_memberships.mem_category_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
          left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.id = 49 and transactions.debit_or_credit=0 and transactions.trans_moc=finance_invoices.corporate_id

order by finance_invoices.corporate_id asc

");

        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
        $data['paymentmethods']=trans_type::where('type',7)->get();
        $data['categories']=mem_category::where('status',1)->get();
  $data['users']= User::where('status',1)->get();

        return $data;
    }



public function index_co_cardprinting_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/card-printing/corporate-card-printing-vue');
    }

    public function co_cardprinting_init(Request $request)
    {
         
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,

            mem_categories.desc                                                   as catname,
       finance_invoices.customer_id,
       corporate_memberships.mem_no,
        finance_invoices.qty,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,
       CONCAT(coalesce(corporate_memberships.title, ''), ' ', coalesce(corporate_memberships.first_name, ''), ' ',
              coalesce(corporate_memberships.middle_name, ''), ' ',
              coalesce(corporate_memberships.applicant_name, '')) as name,
       corporate_memberships.gender                               as mgender,
        corporate_memberships.gender                               as mgender,
         corporate_memberships.card_status                                                   as cardstatus,
        corporate_memberships.cur_city                                                      as mcity,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,
       finance_invoices.member_id,
       finance_invoices.corporate_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                          as rd,
       transactions.trans_amount                        as total,
        ruser.name as rcashiername,
 transactions.created_by as ruserid

from transactions
         join finance_invoices on transactions.trans_type_id = finance_invoices.id
         left outer join corporate_memberships on corporate_memberships.id = finance_invoices.corporate_id
       left outer join corporate_mem_families mf on finance_invoices.family = mf.id

         left outer join customers c on c.id = finance_invoices.customer_id
left outer join mem_categories on mem_categories.id=corporate_memberships.mem_category_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
            left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.id = 10 and transactions.debit_or_credit=0 and transactions.trans_moc=finance_invoices.corporate_id

order by finance_invoices.id desc

");

        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
  $data['paymentmethods']=trans_type::where('type',7)->get();
   $data['users']= User::where('status',1)->get();
        return $data;
    }






    public function index_maintenance_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/maintenance-fee/maintenance-fee-vue');
    }

    public function maintenance_init(Request $request)
    {
        /*  $oldinvoices =\Illuminate\Support\Facades\DB::select("select finance_invoice_subs.*,finance_invoices.id as idi,finance_invoices.invoice_date as invoice_date,
               finance_invoices.invoice_type,c.customer_name as cname,finance_invoices.customer_id,finance_invoices.mem_no,
               CONCAT(coalesce(memberships.title,''), ' ', coalesce(memberships.first_name,''), ' ',coalesce( memberships.middle_name,''), ' ',
                      coalesce( memberships.applicant_name,''))                                      as name,
               memberships.gender                                                      as mgender,
               memberships.cur_city                                                      as mcity,
               trs.name                                                            as paymentMethod,
               mem_categories.desc                                                   as catname,
               finance_invoices.receipt_date                                                as dated,
                finance_invoices.paid_amount                                               as paidamount,

               mf.gender                                                      as mfgender,

               CONCAT(coalesce(mf.title,''), ' ', coalesce(mf.first_name,''), ' ', coalesce(mf.middle_name,''), ' ', coalesce(mf.name,'')) as fname,
               finance_invoices.member_id,
               trans_types.name as tname,
               if(c.id is null,(select mem_relations.desc from mem_relations where mem_relations.id=mf.fam_relationship),null)as rname

        from finance_invoice_subs
                   join finance_invoices on finance_invoice_subs.invoice_id = finance_invoices.id
                 left outer join memberships on memberships.id = finance_invoices.member_id
                 left outer join mem_families mf on  finance_invoice_subs.family = mf.id
                 left outer join customers c on c.id=finance_invoices.customer_id
                  join trans_types on trans_types.id=finance_invoice_subs.charges_type and trans_types.id =4
                 left outer join mem_categories on mem_categories.id=memberships.mem_category_id
                 left outer join trans_types trs on trs.id = finance_invoices.account

        where finance_invoice_subs.deleted_at is null and  finance_invoices.receipt_date is not null  group by finance_invoice_subs.id order by finance_invoices.member_id asc

        ");*/
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,

            mem_categories.desc                                                   as catname,
       finance_invoices.customer_id,
       memberships.mem_no,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,

       CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name,
       memberships.gender                               as mgender,
        memberships.kinship                               as kins,
        memberships.cur_city                                                      as mcity,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,
       finance_invoices.member_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                    as rd,
       transactions.trans_amount                    as total,
         ruser.name as rcashiername,
 transactions.created_by as ruserid


from transactions

         join finance_invoices on transactions.trans_type_id = finance_invoices.id
         left outer join memberships on memberships.id = finance_invoices.member_id
         left outer join mem_families mf on finance_invoices.family = mf.id
         left outer join customers c on c.id = finance_invoices.customer_id
left outer join mem_categories on mem_categories.id=memberships.mem_category_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
          left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.id = 4 and transactions.debit_or_credit=0 and transactions.trans_moc=finance_invoices.member_id

order by finance_invoices.member_id asc

");

        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
        $data['paymentmethods']=trans_type::where('type',7)->get();
        $data['categories']=mem_category::where('status',1)->get();
  $data['users']= User::where('status',1)->get();

        return $data;
    }


    public function index_cardprinting_vue(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/card-printing/card-printing-vue');
    }

    public function cardprinting_init(Request $request)
    {
        /* $invoices =\Illuminate\Support\Facades\DB::select("select finance_invoice_subs.*,finance_invoices.id as idi,finance_invoices.invoice_date as invoice_date,
               finance_invoices.invoice_type,c.customer_name as cname,finance_invoices.customer_id,finance_invoices.mem_no,
               CONCAT(coalesce(memberships.title,''), ' ', coalesce(memberships.first_name,''), ' ',coalesce( memberships.middle_name,''), ' ',
                      coalesce( memberships.applicant_name,''))                                      as name,
               memberships.gender                                                      as mgender,
               memberships.cur_city                                                      as mcity,
               memberships.card_status                                                   as cardstatus,
               trs.name                                                            as paymentMethod,
               finance_invoices.receipt_date                                                as dated,
                finance_invoices.paid_amount                                               as paidamount,
               mf.gender                                                      as mfgender,

               CONCAT(coalesce(mf.title,''), ' ', coalesce(mf.first_name,''), ' ', coalesce(mf.middle_name,''), ' ', coalesce(mf.name,'')) as fname,
               finance_invoices.member_id,
               trans_types.name as tname,
               if(c.id is null,(select mem_relations.desc from mem_relations where mem_relations.id=mf.fam_relationship),null)as rname

        from finance_invoice_subs
                  join finance_invoices on finance_invoice_subs.invoice_id = finance_invoices.id
                 left outer join memberships on memberships.id = finance_invoices.member_id
                 left outer join mem_families mf on  finance_invoice_subs.family = mf.id
                 left outer join customers c on c.id=finance_invoices.customer_id
                  join trans_types on trans_types.id=finance_invoice_subs.charges_type and trans_types.id =10
                 left outer join trans_types trs on trs.id = finance_invoices.account

        where finance_invoice_subs.deleted_at is null and  finance_invoices.receipt_date is not null  group by finance_invoice_subs.id order by finance_invoice_subs.id desc

        ");*/
        $data['invoices'] = \Illuminate\Support\Facades\DB::select("select transactions.trans_amount as charges_amount,
       finance_invoices.id                              as idi,
       finance_invoices.invoice_date                    as invoice_date,
       finance_invoices.invoice_type,
       c.customer_name                                  as cname,

            mem_categories.desc                                                   as catname,
       finance_invoices.customer_id,
       memberships.mem_no,
        finance_invoices.qty,
       finance_invoices.start_date,
       finance_invoices.end_date,
       finance_invoices.days,
       CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name,
       memberships.gender                               as mgender,
        memberships.gender                               as mgender,
         memberships.card_status                                                   as cardstatus,
        memberships.cur_city                                                      as mcity,
       mf.gender                                        as mfgender,
       CONCAT(coalesce(mf.title, ''), ' ', coalesce(mf.first_name, ''), ' ', coalesce(mf.middle_name, ''), ' ',
              coalesce(mf.name, ''))                    as fname,
       finance_invoices.member_id,
       trans_types.name                                 as tname,
       if(c.id is null, (select mem_relations.desc from mem_relations where mem_relations.id = mf.fam_relationship),
          null)                                         as rname,
       trs.name                                         as paymentMethod,
       transactions.created_at                          as rd,
       transactions.trans_amount                        as total,
        ruser.name as rcashiername,
 transactions.created_by as ruserid

from transactions
         join finance_invoices on transactions.trans_type_id = finance_invoices.id
         left outer join memberships on memberships.id = finance_invoices.member_id
         left outer join mem_families mf on finance_invoices.family = mf.id
         left outer join customers c on c.id = finance_invoices.customer_id
left outer join mem_categories on mem_categories.id=memberships.mem_category_id
         left outer join trans_types on trans_types.id = transactions.trans_type
         left outer join finance_cash_receipts rs on rs.id = transactions.receipt_id
         left outer join trans_types trs on trs.id = rs.account
            left outer join users ruser on ruser.id =transactions.created_by and ruser.status=1


where transactions.deleted_at is null
  and trans_types.id = 10 and transactions.debit_or_credit=0 and transactions.trans_moc=finance_invoices.member_id

order by finance_invoices.id desc

");

        $data['mains'] = [];
        $data['charges'] = [];

        $data['subscriptions'] = [];
        $dx = trans_type::where('type', '<=', 3)->get();
        foreach ($dx as $cm) {
            $fixed = "Invoice";
            $dcm = $cm->name;
            $dcm2 = $cm->mod_id;
            if ($cm->type == 1) {
                $ans = $cm->id;
            } else {
                $ans = $dcm . ' ' . $dcm2;
            }
            if (auth()->user()->can($fixed . ' ' . $ans)) {
                if ($cm->type == 1) {
                    $data['mains'][] = $cm;
                } elseif ($cm->type == 2) {
                    $data['charges'][] = $cm;

                } elseif ($cm->type == 3) {
                    $data['subscriptions'][] = $cm;

                }

            }
        }

        /*$data['mains']=   trans_type::where('type',1)->get();
             $data['charges']=   trans_type::where('type',2)->get();
            $data['subscriptions']=   trans_type::where('type',3)->get();*/
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
  $data['paymentmethods']=trans_type::where('type',7)->get();
   $data['users']= User::where('status',1)->get();
        return $data;
    }


    public function index(Request $request, finance_invoice $finance_invoice)
    {
        $data['mains'] = trans_type::where('type', 1)->get();
        $data['charges'] = trans_type::where('type', 2)->get();
        $data['subscriptions'] = trans_type::where('type', 3)->get();
        $data['receiptstatus'] = 1;
        $invoicesYears = finance_invoice::selectRaw('DISTINCT invoice_date as d')->where('is_auto_generated', 1)->get();
        $data['invoicesYears'] = $invoicesYears;
        return view('backend/finance-and-management/finance-invoices/finance-invoices', $data);
    }

    public function indexdt(Request $request, finance_invoice $finance_invoice)
    {
        $r = finance_invoice::where('deleted_at');
        if ($request->get('mog') == 0) {
            if ($request->get('customer')) {
                $x = $request->get('customer');

                $c = membership::where('applicant_name', 'like', "%$x%")->first();
                $r = membership::find($c->id)->invoices();

            }
        } else {
            if ($request->get('customer')) {
                $x = $request->get('customer');

                $c = customer::where('customer_name', 'like', "%$x%")->first();
                $r = customer::find($c->id)->invoices();

            }

        }

        if ($request->get('start_date')) {
            $r->where('invoice_date', '>=', formatDate($request->get('start_date')));
        }
        if ($request->get('end_date')) {
            $r->where('invoice_date', '<=', formatDate($request->get('end_date')));

        }

        if ($request->get('receipt')) {
            $r->where('invoice_no', '=', $request->get('receipt'));

        }

        if ($request->get('details')) {
            $r->where('charges_type', $request->get('details'));

        }


//        dd($r->toSql());

        $invoices = $r->get();

        $dx = DataTables::of($invoices)
            ->addColumn('chargestype', function ($invoices) {
                if ($invoices->charges_type) {
                    return transTypesChargesTypes($invoices->charges_type);
                } else {
                    return '';
                }

            })
            ->addColumn('details_d', function ($invoices) {
                $s = transactions::where('debit_or_credit', 1)->where('trans_type', 6)->where('trans_type_id', $invoices->id)->get()->pluck('id');
                $v = trans_relations::whereIn('invoice', $s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id', $v)->where('debit_or_credit', 0)->get());
                foreach ($b as $d) {
//                    dd($d->type);
                    $c = $d->type->name;
                    return "   <a target='_blank' href='" . route('cash.receipt.print', $d['receipt_id']) . "'>($d[receipt_id] - $c)</a><br>";
                }
            })
            ->addColumn('amountpaid', function ($invoices) {
                $s = transactions::where('debit_or_credit', 1)->where('trans_type', 6)->where('trans_type_id', $invoices->id)->get()->pluck('id');
                $v = trans_relations::whereIn('invoice', $s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id', $v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x = 0;

//dd($b);
                foreach ($b as $v) {
                    if (!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                        $x = $v['trans_amount'] + $x;
                    }
                }

                return $x;
            })
            ->addColumn('finalbalance', function ($invoices) {
                $s = transactions::where('debit_or_credit', 1)->where('trans_type', 6)->where('trans_type_id', $invoices->id)->get()->pluck('id');
                $v = trans_relations::whereIn('invoice', $s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id', $v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x = 0;

//dd($b);
                foreach ($b as $v) {
                    if (!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                        $x = $v['trans_amount'] + $x;
                    }
                }

                return $invoices->grand_total - $x;

            })
            ->addColumn('balancestatus', function ($invoices) {

                $s = transactions::where('debit_or_credit', 1)->where('trans_type', 6)->where('trans_type_id', $invoices->id)->get()->pluck('id');
                $v = trans_relations::whereIn('invoice', $s)->get()->pluck('receipt');
                $b = (transactions::whereIn('id', $v)->where('debit_or_credit', 0)->get()->toArray(1));
                $x = 0;

//dd($b);
                foreach ($b as $v) {
                    if (!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                        $x = $v['trans_amount'] + $x;
                    }
                }


                $resultant = $invoices->grand_total - $x;

                if ($resultant == 0) {
                    return '<button class=" btn btn-outline-success active">Paid</button>';
                } else {
                    if ($invoices->invoice_type == 0) {
                        return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?' . 'memid=' . $invoices->member_id . '">Unpaid</a></button>';
                    } else  {
                        return '<button class="btn btn-outline-danger active"><a style="color:white;" target="_blank" href="' . url('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/') . '?' . 'guestid=' . $invoices->customer_id . '">Unpaid</a></button>';
                    }


                }
            })
            ->addColumn('editbutton', function ($invoices) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-invoices/finance-invoices-aeu/') . '/' . $invoices->id . '"><i class="fas fa-edit"></i></a></button>';
            })
            ->addColumn('deletebutton', function ($invoices) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-invoices/delete') . '/' . $invoices->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>';
            })
            ->addColumn('type', function ($invoices) {
                if ($invoices->invoice_type == 1) {
                    return "Guest";
                } else {
                    return "Member";
                }


            })
            ->addColumn('dtotal', function ($r) {
                $request = Request::capture();
                $r = finance_invoice::where('deleted_at');
                if ($request->get('mog') == 0) {
                    if ($request->get('customer')) {
                        $x = $request->get('customer');

                        $c = membership::where('applicant_name', 'like', "%$x%")->first();
                        $r = membership::find($c->id)->invoices();

                    }
                } else {
                    if ($request->get('customer')) {
                        $x = $request->get('customer');

                        $c = customer::where('customer_name', 'like', "%$x%")->first();
                        $r = customer::find($c->id)->invoices();

                    }

                }
                if ($request->get('start_date')) {
                    $r->where('invoice_date', '>=', formatDate($request->get('start_date')));
                }
                if ($request->get('end_date')) {
                    $r->where('invoice_date', '<=', formatDate($request->get('end_date')));

                }
                if ($request->get('receipt')) {
                    $r->where('invoice_no', '=', $request->get('receipt'));

                }
                if ($request->get('details')) {
                    $r->where('charges_type', $request->get('details'));

                }

                return number_format($r->sum('grand_total'));


            })
            ->addColumn('ctotal', function ($invoices) {
                $request = Request::capture();
                $r = finance_invoice::where('deleted_at');
                if ($request->get('mog') == 0) {
                    if ($request->get('customer')) {
                        $x = $request->get('customer');

                        $c = membership::where('applicant_name', 'like', "%$x%")->first();
                        $r = membership::find($c->id)->invoices();

                    }
                } else {
                    if ($request->get('customer')) {
                        $x = $request->get('customer');

                        $c = customer::where('customer_name', 'like', "%$x%")->first();
                        $r = customer::find($c->id)->invoices();

                    }

                }
                if ($request->get('start_date')) {
                    $r->where('invoice_date', '>=', formatDate($request->get('start_date')));
                }
                if ($request->get('end_date')) {
                    $r->where('invoice_date', '<=', formatDate($request->get('end_date')));

                }
                if ($request->get('receipt')) {
                    $r->where('invoice_no', '=', $request->get('receipt'));

                }
                if ($request->get('details')) {
                    $r->where('charges_type', $request->get('details'));

                }

                return number_format($r->count('id'));


            })
            ->addColumn('invoice_date', function ($invoices) {
                return formatDateToShow($invoices->invoice_date);
            })
            ->addColumn('customer_id', function ($invoices) {
                if ($invoices->invoice_type == 1) {
                    return $invoices->customer_id;
                } else if ($invoices->invoice_type == 0) {
                    //        return "Member";

                    return $invoices->mem_no;

                }
                //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


            })
            ->addColumn('status', function ($receipts) {
                return '<button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-invoices/invoice/') . '/' . $receipts->id . '"><i class="fa fa-print" aria-hidden="true"></i></a></button>';

            })
            ->rawColumns(['editbutton',
                'details_d', 'editfinancebutton', 'deletebutton', 'sports_subscription', 'payment_receipts_sub', 'finance_invoice_charges_type', 'status', 'customer', 'membership', 'mem_address', 'admin_company_profile', 'finance_payment_methods', 'amountpaid', 'finalbalance', 'balancestatus', 'chargestype'])
            ->addIndexColumn();
        $ddm = $dx->toArray();
        $x = array_filter($ddm['data'], function ($val) use ($request) {
            if ($request->get('status') == 1) {
//                dd($val);
                return $val['finalbalance'] == 0;
            } elseif ($request->get('status') == 2) {
                return $val['finalbalance'] != 0;

            } else {
                return true;
            }
        });
//        $x= $x;
        $x = array_map(function ($a) {
            return (array)$a;
        }, $x);
        $x = array_values($x);

        $ddm['data'] = (array)$x;
        return $ddm;

    }


    public function index_deleted(Request $request, finance_invoice $finance_invoice)
    {
        return view('backend/finance-and-management/finance-invoices/finance-invoices-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_invoice $finance_invoice)
    {

        $deleted = finance_invoice::onlyTrashed()->get();
        return DataTables::of($deleted)
            ->addColumn('chargestype', function ($deleted) {
                if ($deleted->charges_type) {
                    return transTypesChargesTypes($deleted->charges_type);
                } else {
                    return '';
                }

            })
            ->addColumn('type', function ($invoices) {
                if ($invoices->invoice_type == 0) {
                    return "Member";
                }
                else  if ($invoices->invoice_type == 6) {
                    return "Corporate Member";
                }
                 else {
                    return "Guest";
                }


            })

              ->addColumn('name', function ($invoices) {
                if ($invoices->invoice_type == 0) {
                    return $invoices->member->title.' '.$invoices->member->first_name.' '.$invoices->member->middle_name.' '.$invoices->member->applicant_name;
                }
                else if ($invoices->invoice_type == 6) {
                    return $invoices->corporatemember->title.' '.$invoices->corporatemember->first_name.' '.$invoices->corporatemember->middle_name.' '.$invoices->corporatemember->applicant_name;
                }
                 else if ($invoices->invoice_type == 1 && $invoices->customer){
                    return $invoices->customer->customer_name;
                }
                else {
                    return $invoices->name;
                }


            })


            ->addColumn('invoice_date', function ($invoices) {
                return formatDateToShow($invoices->invoice_date);
            })

             ->addColumn('deleted_at', function ($invoices) {
                return formatDateToShow($invoices->deleted_at);
            })
            ->addColumn('customer_id', function ($invoices) {
                if ($invoices->invoice_type == 0) {
                      return $invoices->mem_no;
                   
                } 
                 else if ($invoices->invoice_type == 6) {
                      return $invoices->corporatemember->mem_no;
                   
                } 
                else  {
                    //        return "Member";
 return $invoices->customer_id;

                }
                //   return $receipts->receipt_type!=null?$receipts->customer_id:$receipts->member->mem_no;


            })
            ->addColumn('restorebutton', function ($deleted) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-invoices/restore/') . '/' . $deleted->id . '"><i class="fas fa-trash-restore"></i></a></button>';
            })
            ->rawColumns(['restorebutton'])
            ->addIndexColumn()
            ->make(true);
    }

    public function print(Request $request, finance_invoice $finance_invoice)
    {
        $data['receiptdata'] = finance_invoice::with('member')->get();
        $view = View::make('backend/finance-and-management/finance-invoices/invoice', $data)->renderSections()['page-content'];
        return $view;

    }

    public function create(Request $request)
    {
        $lastval = finance_invoice::withTrashed()->latest('id')->first();
        $num = 0;

        if ($lastval) {
            $num = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num = 1;
            $data['increment_number'] = $num;
        }
        $data['init'] = 0;
        $data['invoice_update'] = '';


        $customernumber = $request->customerid;
        $MOC = $request->MOC;
        if ($MOC == 1) {
            //
        } else {
            $data['familymembers'] = mem_family::where('member_id', $customernumber)->get();

        }
        $data['main_types'] = trans_type::where('type', 1)->get();
        $data['subscription_type'] = trans_type::where('type', 3)->get();
        $data['finance_invoice_charges_type'] = trans_type::where('type', 2)->get();
        $data['account_types'] = trans_type::where('cash_or_payment', 2)->where('type', 7)->get();
        /*$data['account_types']=finance_account_type::where('status',1)->get();*/
        $data['receiptstatus'] = 1;

        return view('backend/finance-and-management.finance-invoices.Backup-finance-invoices-aeu', $data);
    }


    public function store(Request $request)
    {

        $lastcashreceipt = finance_cash_receipt::withTrashed()->latest('id')->first();
        $numtwo = 0;
        if ($lastcashreceipt) {
            $numtwo = $lastcashreceipt->id + 1;
            $cashrec['increment_numbers'] = $numtwo;

        } else {
            $numtwo = 1;
            $cashrec['increment_numbers'] = $numtwo;

        }


        $receiveme = $request->receive;
        $addmore = $request->addmore;
        $addmore2 = $request->addmore2;
        $saveandreceive = $request->saveandreceive;
        $getlastinsert = 0;
        $validation = [

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'invoice_type' => 'required',
            'name' => 'required',
//            //'mem_no' => 'required',
//          'address' => 'required',
//         // 'ledger_amount' => 'required',
//          //  'cnic' => 'required',
//            //'contact' => 'required',
//            //'email' => 'required',
//
            'final_total' => 'required',
//
            'grand_total' => 'required',
            'amount_in_words' => 'required',
//
//
//              'charges_type' => 'required',
//            'charges_amount'=> 'required',
//             'qty'=> 'required',
//              'sub_total'=> 'required'

        ];
        if ($request->get('invoice_type') == 0) {
            $validation['mem_no'] = 'required';
            $validation['member_id'] = 'required';
        } else {
            $validation['customer_id'] = 'required';

        }

        if ($request->get('receive')) {
            $validation['account_type'] = 'required';
            $validation['return_value'] = 'required';
        }

        $this->validate($request, $validation);


        if ($request->receive) {


            if ($request->get('amount_received') > 0) {
                if ($request->get('invoice_type') == 0) {
                    $r = [];

                    $r['invoice_no'] = $cashrec['increment_numbers'];
                    $r['invoice_date'] = formatDate($request->get('invoice_date'));
                    $r['receipt_type'] = 0;
                    $r['mem_number'] = $request->get('member_id');
                    $r['total_amount'] = $request->get('amount_received') + $request->get('return_value');
                    $r['total'] = $request->get('amount_received') + $request->get('return_value');
                    $r['account'] = $request->get('account_type');
                    $r['remarks'] = $request->get('remarks');
                    $r['amount_in_words'] = $request->get('amount_in_words');
                } else   {
                    $r = [];

                    $r['invoice_no'] = $cashrec['increment_numbers'];
                    $r['invoice_date'] = $request->get('invoice_date');
                    $r['receipt_type'] = 1;
                    $r['customer_id'] = $request->get('customer_id');
                    $r['total_amount'] = $request->get('amount_received') + $request->get('return_value');
                    $r['total'] = $request->get('amount_received') + $request->get('return_value');
                    $r['account'] = $request->get('account_type');
                    $r['remarks'] = $request->get('remarks');
                    $r['amount_in_words'] = $request->get('amount_in_words');
                }

                $rid = finance_cash_receipt::create($r);
            }
        }

        if ($request->receive) {
            $cm = [

                // 'invoice_no' =>  $request->invoice_no,
                'invoice_date' => formatDate($request->invoice_date),
                'invoice_type' => $request->invoice_type,
                'name' => $request->name,
                'customer_id' => $request->customer_id,
                'member_id' => $request->member_id,
                'mem_no' => $request->mem_no,

                'address' => $request->address,
                'ledger_amount' => $request->ledger_amount,
                'cnic' => $request->cnic,
                'contact' => $request->contact,
                'email' => $request->email,
                //'family' => $request->family,
                'total' => $request->final_total,
                'discount_amount' => $request->discount_amount,
                'discount_percentage' => $request->discount_percentage,

                'discount_details' => $request->discount_details,

                'extra_charges' => $request->extra_charges,
                'extra_percentage' => $request->extra_percentage,

                'extra_details' => $request->extra_details,

                'tax_charges' => $request->tax_charges,
                'tax_percentage' => $request->tax_percentage,

                'tax_details' => $request->tax_details,

                'grand_total' => $request->grand_total,
                'amount_in_words' => $request->amount_in_words,
                'comments' => $request->comments,
                'member' => 1,

                'account' => $request->account_type,
                'paid_amount' => $request->amount_received + $request->return_value,
                'receipt_id' => $rid->id,
                'receipt_date' => formatDate($request->invoice_date),
            ];
        } else {
            $cm = [

                // 'invoice_no' =>  $request->invoice_no,
                'invoice_date' => formatDate($request->invoice_date),
                'invoice_type' => $request->invoice_type,
                'name' => $request->name,
                'customer_id' => $request->customer_id,
                'member_id' => $request->member_id,
                'mem_no' => $request->mem_no,

                'address' => $request->address,
                'ledger_amount' => $request->ledger_amount,
                'cnic' => $request->cnic,
                'contact' => $request->contact,
                'email' => $request->email,
                //'family' => $request->family,
                'total' => $request->final_total,
                'discount_amount' => $request->discount_amount,
                'discount_percentage' => $request->discount_percentage,

                'discount_details' => $request->discount_details,

                'extra_charges' => $request->extra_charges,
                'extra_percentage' => $request->extra_percentage,

                'extra_details' => $request->extra_details,

                'tax_charges' => $request->tax_charges,
                'tax_percentage' => $request->tax_percentage,

                'tax_details' => $request->tax_details,

                'grand_total' => $request->grand_total,
                'amount_in_words' => $request->amount_in_words,
                'comments' => $request->comments,
                'member' => 1,
            ];
        }


        $invoices = finance_invoice::create($cm);

        if ($request->invoice_type == 0) {
            $transaction = transactions::create([
                'debit_or_credit' => 1,
                'trans_type' => 6,
                'trans_type_id' => $invoices->id,
                'trans_amount' => $request->grand_total,
                'trans_moc_type' => 0,
                'trans_moc' => $request->member_id,
                'is_active' => 1,
                'date' => formatDate($request->invoice_date)
            ]);
        } else {

            $transaction = transactions::create([
                'debit_or_credit' => 1,
                'trans_type' => 6,
                'trans_type_id' => $invoices->id,
                'trans_amount' => $request->grand_total,
                'trans_moc_type' => 1,
                'trans_moc' => $request->customer_id,
                'is_active' => 1,
                'date' => formatDate($request->invoice_date)
            ]);
        }


        if ($request->receive) {
//sending into transactions table
            if ($request->get('amount_received') > 0) {
                if ($request->get('invoice_type') == 0) {
                    $t = [];

                    $t['debit_or_credit'] = 0;
                    $t['trans_type'] = 6;
                    $t['trans_type_id'] = $invoices->id;
                    $t['trans_amount'] = $request->get('amount_received') + $request->get('return_value');
                    $t['trans_moc'] = $request->get('member_id');
                    $t['trans_moc_type'] = 0;
                    $t['is_active'] = 1;
                    $t['receipt_id'] = $rid->id;
                    $t['date'] = formatDate($request->get('invoice_date'));

                    $acc = transactions::create([
                        'debit_or_credit' => 0,
                        'trans_type' => 90,
                        'trans_type_id' => $request->get('account_type'),
                        'trans_amount' => $request->get('amount_received') + $request->get('return_value'),
                        'trans_moc' => $request->get('member_id'),
                        'trans_moc_type' => 0,
                        'receipt_id' => $rid->id,
                        'date' => formatDate($request->get('invoice_date')),
                        'is_active' => 1
                    ]);
                } else   {
                    $t = [];

                    $t['debit_or_credit'] = 0;
                    $t['trans_type'] = 6;
                    $t['trans_type_id'] = $invoices->id;
                    $t['trans_amount'] = $request->get('amount_received') + $request->get('return_value');
                    $t['trans_moc'] = $request->get('customer_id');
                    $t['trans_moc_type'] = 1;
                    $t['is_active'] = 1;
                    $t['receipt_id'] = $rid->id;
                    $t['date'] = formatDate($request->get('invoice_date'));

                    $acc = transactions::create([
                        'debit_or_credit' => 0,
                        'trans_type' => 90,
                        'trans_type_id' => $request->get('account_type'),
                        'trans_amount' => $request->get('amount_received') + $request->get('return_value'),
                        'trans_moc' => $request->get('customer_id'),
                        'trans_moc_type' => 1,
                        'receipt_id' => $rid->id,
                        'date' => formatDate($request->get('invoice_date')),
                        'is_active' => 1
                    ]);
                }

                $tid = transactions::create($t);
            }

//sending into transactions table


            //sending into trans relations
            if ($request->get('amount_received') > 0) {
                $inv = transactions::where('debit_or_credit', 1)->where('trans_type', 6)->where('trans_type_id', $invoices->id)->get()->pluck('id');
                if ($inv) {
                    trans_relations::create([
                        'receipt' => $tid->id,
                        'invoice' => $inv[0],
                        'account' => $acc->id
                    ]);
                }
            }
//sending into trans relations

        }


        $chargestypes = $request->charges_type;
        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $days = $request->days;
        $qty = $request->qty;
        $chargesamount = $request->charges_amount;
        $total = $request->sub_total;
        $family = $request->family;


        $i = 0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new finance_invoice_subs;
            $ta->invoice_id = $invoices->id;
            $ta->start_date = formatDate($startdate[$i]);
            $ta->end_date = formatDate($enddate[$i]);
            $ta->days = $days[$i];
            $ta->qty = $qty[$i];
            $ta->total = $total[$i];
            $ta->family = $family[$i];
            $ta->charges_amount = $chargesamount[$i];
            //     $ta->charges_type_id=$chargestypes[$i][2];
            $ta->charges_type = $chargestypes[$i];
            $ta->created_by = Auth::user()->id;
            $ta->updated_by = Auth::user()->id;
            $ta->save();
            $i++;
        }


        if ($invoices) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
            $getlastinsert = $invoices->id;
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if (empty($receiveme) && !empty($addmore2)) {
            return redirect('finance-and-management/finance-invoices/finance-invoices-aeu');
        }
        if (empty($receiveme) && !empty($addmore)) {
            return redirect('finance-and-management/finance-invoices/invoice/' . $getlastinsert);
        } else if (empty($receiveme) && !empty($saveandreceive)) {
            if ($request->invoice_type == 0) {
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/' . '?' . 'memid=' . $request->member_id);
            } else  {
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/' . '?' . 'guestid=' . $request->customer_id);
            }
        } else if (!empty($receiveme)) {
            return redirect('finance-and-management/finance-invoices/invoice/' . $getlastinsert);
        } else {
            return redirect('finance-and-management/finance-invoices-vue');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\room_payment_receipt $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(room_payment_receipt $room_payment_receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\room_payment_receipt $room_payment_receipt
     * @return \Illuminate\Http\Response
     */

    public function edit(finance_invoice $finance_invoice, $id)
    {
        $data['invoice_update'] = finance_invoice::where('id', $id)->first();
        $data['init'] = 1;
        $data['increment_number'] = $data['invoice_update']->code;

        $data['main_types'] = trans_type::where('type', 1)->get();
        $data['finance_invoice_charges_type'] = trans_type::where('type', 2)->get();
        $data['subscription_type'] = trans_type::where('type', 3)->get();

        $memberfmid = $data['invoice_update']->member_id;
        $data['familymembers'] = mem_family::with('relationship_name')->where('member_id', $memberfmid)->get();

        $data['receiptstatus'] = 1;
        $data['account_types'] = trans_type::where('cash_or_payment', 2)->where('type', 7)->get();
        /*$data['account_types']=finance_account_type::where('status',1)->get();*/
        $data['bookingsub'] = finance_invoice::with('invoiceSubs')->where('id', $id)->get();
        $data['bookingsubdata'] = $data['bookingsub'][0]['invoiceSubs'];

        return view('backend/finance-and-management.finance-invoices.Backup-finance-invoices-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\room_payment_receipt $room_payment_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $saveandreceive = $request->saveandreceive;
        $validation = [

            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'invoice_type' => 'required',
            'name' => 'required',
//            //'mem_no' => 'required',
//          'address' => 'required',
//         // 'ledger_amount' => 'required',
//          //  'cnic' => 'required',
//            //'contact' => 'required',
//            //'email' => 'required',
//
            'final_total' => 'required',
//
            'grand_total' => 'required',
            'amount_in_words' => 'required',
//
//
//              'charges_type' => 'required',
//            'charges_amount'=> 'required',
//             'qty'=> 'required',
//              'sub_total'=> 'required'
        ];
        if ($request->get('invoice_type') == 0) {
            $validation['mem_no'] = 'required';
            $validation['member_id'] = 'required';
        } else {
            $validation['customer_id'] = 'required';

        }
        $this->validate($request, $validation);
        $f = finance_invoice::find($id);
        if ($request->invoice_type == 0) {
            $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 6)->where('debit_or_credit', 1)->updateWithUserstamps([
                'debit_or_credit' => 1,
                'trans_type' => 6,
                'trans_type_id' => $id,
                'trans_amount' => $request->grand_total,
                'trans_moc_type' => 0,
                'trans_moc' => $request->member_id,
                'is_active' => 1,
                'date' => formatDate($request->invoice_date)
            ]);

        } else  {
            $transaction = transactions::where('trans_type_id', $id)->where('trans_type', 6)->where('debit_or_credit', 1)->updateWithUserstamps([
                'debit_or_credit' => 1,
                'trans_type' => 6,
                'trans_type_id' => $id,
                'trans_amount' => $request->grand_total,
                'trans_moc_type' => 1,
                'trans_moc' => $request->customer_id,
                'is_active' => 1,
                'date' => formatDate($request->invoice_date)
            ]);
        }

        $x = transactions::where('trans_type_id', $id)->where('trans_type', 6)->where('debit_or_credit', 1)->first();
        if ($x) {

            $t = trans_relations::where('invoice', $x->id)->get();


            if ($t) {
//                dd($t);
                foreach ($t as $c) {

//                    dd(transactions::find($c->receipt));
                    $transaction_d = transactions::where('id', $c->receipt)->updateWithUserstamps([
                        'debit_or_credit' => 0,
                        'trans_type' => 6,
                        'trans_type_id' => $id,
//                        'trans_amount' =>  $request->grand_total,
//                        'trans_moc_type' =>  $request->invoice_type,
//                        'trans_moc' => $request->invoice_type==1? $request->customer_id:$request->member_id,
//                        'is_active' =>  1,
//                        'date' => formatDate($request->invoice_date)
                    ]);
                }
            }
        }
        $invoices = finance_invoice::where('id', $id)->updateWithUserstamps([
            'invoice_no' => $request->invoice_no,
            'invoice_date' => formatDate($request->invoice_date),
            'invoice_type' => $request->invoice_type,
            'name' => $request->name,
            'customer_id' => $request->customer_id,
            'member_id' => $request->member_id,
            'mem_no' => $request->mem_no,

            'address' => $request->address,
            'ledger_amount' => $request->ledger_amount,
            'cnic' => $request->cnic,
            'contact' => $request->contact,
            'email' => $request->email,
            //'family' => $request->family,
            'total' => $request->final_total,
            'discount_amount' => $request->discount_amount,
            'discount_percentage' => $request->discount_percentage,

            'discount_details' => $request->discount_details,

            'extra_charges' => $request->extra_charges,
            'extra_percentage' => $request->extra_percentage,

            'extra_details' => $request->extra_details,

            'tax_charges' => $request->tax_charges,
            'tax_percentage' => $request->tax_percentage,

            'tax_details' => $request->tax_details,

            'grand_total' => $request->grand_total,
            'amount_in_words' => $request->amount_in_words,
            'comments' => $request->comments,

        ]);


        $subdelete = finance_invoice_subs::where('invoice_id', $id)->deleteWithUserstamps();

        if ($subdelete) {

            $chargestypes = $request->charges_type;
            $startdate = $request->start_date;
            $enddate = $request->end_date;
            $days = $request->days;
            $qty = $request->qty;
            $chargesamount = $request->charges_amount;
            $total = $request->sub_total;
            $family = $request->family;

            $i = 0;
            foreach ($chargesamount as $chargesamt => $char_amt) {

                $ta = new finance_invoice_subs;
                $ta->invoice_id = $id;
                $ta->start_date = formatDate($startdate[$i]);
                $ta->end_date = formatDate($enddate[$i]);
                $ta->days = $days[$i];
                $ta->qty = $qty[$i];
                $ta->total = $total[$i];
                $ta->family = $family[$i];
                $ta->charges_amount = $chargesamount[$i];
                //  $ta->charges_type_id=$chargestypes[$i][2];
                $ta->charges_type = $chargestypes[$i];
                $ta->updated_by = Auth::user()->id;
                $ta->save();
                $i++;
            }
        }


        if ($invoices) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }


        if (empty($saveandreceive)) {
            return redirect('finance-and-management/finance-invoices/finance-invoices-aeu/' . $id);
        } else {
            if ($request->invoice_type == 0) {
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/' . '?' . 'memid=' . $request->member_id);
            } else  {
                return redirect('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/' . '?' . 'guestid=' . $request->customer_id);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\room_payment_receipt $room_payment_receipt
     * @return \Illuminate\Http\Response
     */

    public function destroy(finance_invoice $finance_invoice, $id)
    {

        $recipt = $finance_invoice::where('id', $id)->deleteWithUserstamps();

        if (transactions::where('debit_or_credit', 1)->where('trans_type_id', $id)->where('trans_type', 6)->exists()) {
            $transaction = transactions::where('debit_or_credit', 1)->where('trans_type_id', $id)->where('trans_type', 6)->deleteWithUserstamps();
        }

        if ($recipt) {
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

        }


        return redirect('finance-and-management/finance-invoices-vue');
    }

    function calculateextracharges($id)
    {
        $charges = trans_type::where('type', 2)->where('mod_id', $id)->first();
        return $charges->charges;

    }
 
    function calculatesportscharges($memid,$mog, $id)
    {
        $modid = trans_type::where('id', $id)->get()->pluck('mod_id');


        $type = trans_type::where('id', $id)->get()->pluck('type');
        if ($type[0] == '1' && $id == 3 && $mog==0) {
            $charges = membership::where('id', $memid)->get()->first();
            return $charges->total;
        } else if ($type[0] == '1' && $id == 4 && $mog==0) {
            $charges = membership::where('id', $memid)->get()->first();
            return $charges->total_maintenance;
        } 
        else if ($type[0] == '1' && $id == 3 && $mog==6) {
            $charges = corporateMembership::where('id', $memid)->get()->first();
            return $charges->total;
        } else if ($type[0] == '1' && $id == 4 && $mog==6) {
            $charges = corporateMembership::where('id', $memid)->get()->first();
            return $charges->total_maintenance;
        }
        else if ($type[0] == '2') {
            $charges = finance_invoice_charges_type::where('status', 1)->where('id', $modid)->first();
            return $charges->charges;
        } else if ($type[0] == '3') {
            $charges = sports_subscription::where('status', 1)->where('id', $modid)->first();
            return $charges->charges;
        }


    }


    public function invoice(finance_invoice $finance_invoice, $id)
    {
        $data['receiptdata'] = finance_invoice::with('member')->where('id', $id)->first();
        $data['profiledata'] = admin_company_profile::get()->first();


        $data['finance_invoice_charges_type'] = finance_invoice_charges_type::where('status', 1)->get();
        $data['subscription_type'] = sports_subscription::where('status', 1)->get();

        $s = transactions::where('debit_or_credit', 1)->where('trans_type', 6)->where('trans_type_id', $data['receiptdata']->id)->get()->pluck('id');
        $v = trans_relations::whereIn('invoice', $s)->get()->pluck('receipt');
        $b = (transactions::whereIn('id', $v)->where('debit_or_credit', 0)->get()->toArray(1));
        $x = 0;

//dd($b);
        foreach ($b as $v) {
            if (!empty($v['trans_amount']) && is_numeric($v['trans_amount'])) {
                $x = $v['trans_amount'] + $x;
            }
        }

        $data['resultant'] = $data['receiptdata']->grand_total - $x;
        $data['amount_paid'] = $x;

        $data['bookingsub'] = finance_invoice::with('invoiceSubs')->where('id', $id)->get();
        $data['bookingsubdata'] = $data['bookingsub'][0]['invoiceSubs'];
        return view('backend/finance-and-management.finance-invoices.invoice', $data);
    }


    public function restore(finance_invoice $finance_invoice, $id)
    {
        $restore = finance_invoice::onlyTrashed()->find($id)->restore();

        if (transactions::onlyTrashed()->where('debit_or_credit', 1)->where('trans_type_id', $id)->where('trans_type', 6)->exists()) {
            $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type', 6)->where('debit_or_credit', 1)->restore();
        }

        if ($restore) {
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

        }
        return redirect('finance-and-management/finance-invoices/deleted');

    }
 
    public function updateinvoices(Request $request)
    {
        if ($request->get('overdue') <= 0) abort(500);
        $overdues = $request->get('overdue') / 100;
        $ids = $request->get('ids');
        $mm = [];
        foreach ($ids as $idz) {

            foreach (explode('<br>', $idz) as $id) {

                  $f = finance_invoice::find($id);

                 $amountpaid=transactions::where('debit_or_credit',0)->where('type',2)->where('trans_type',$f->charges_type)->where('trans_type_id',$f->id)->sum('trans_amount');


                $thegrand = finance_invoice::where('id',$id)->get()->pluck('grand_total');

               if($thegrand[0]-$amountpaid>0){
                 $f->extra_percentage = $overdues * 100;
                 $f->extra_charges = $f->total * $overdues;
                $f->grand_total = $f->total + ($f->total * $overdues) - $f->discount_amount;
                transactions::where('debit_or_credit',1)->where('type',1)->where('trans_type',$f->charges_type)->where('trans_type_id',$f->id)->updateWithUserstamps([
                    'trans_amount'=> $f->grand_total
                ]);
                $f->save();
               }
//          dd($f);
               


            }
        }
    }

}
