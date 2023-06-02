<?php

namespace App\Http\Controllers;

use App\crm_lead;
use App\crm_complaint;
use App\crm_lead_source;
use App\crm_call_detail;
use App\crm_visit_details;
use App\crm_leads_status;
use App\crm_calls_status;
use Illuminate\Http\Request;
use Session;
use DataTables;
use App\User;
use App\crm_reason;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
 use App\exports\CrmLeadDown;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
 
use test\Mockery\ReturnTypeObjectTypeHint;
class CrmLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


  public function export(Request $request){
      ob_end_clean(); 
     ob_start();
        return Excel::download(new CrmLeadDown,'leads.xlsx');
    }

      public function dash_vue(Request $request, crm_lead $crm_lead)
    {
      return view('backend/dashboards/revenue-dashboard-vue');
    }

    public function dash_init_vue(Request $request)
    {
        $today=date('Y-m-d');
    $yesterday= date('Y-m-d',strtotime("-1 days"));
    $tomorrow= date('Y-m-d',strtotime("+1 days"));

$now = Carbon::now();
$week_start = $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
$week_end = $now->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');
$month_start = $now->startOfMonth()->format('Y-m-d');
$month_end = $now->endOfMonth()->format('Y-m-d');
$year_start = $now->startOfYear()->format('Y-m-d');
$year_end = $now->endOfYear()->format('Y-m-d');

    $data['leads'] =\Illuminate\Support\Facades\DB::select(
      'select 
       
       sum(if(transactions.trans_type = 1 and
       DATE(transactions.date) = "'.$today.'", transactions.trans_amount, 0)) as today_room,
       sum(if(transactions.trans_type = 1 and
       DATE(transactions.date) = "'.$yesterday.'", transactions.trans_amount, 0)) as yes_room,
       sum(if(transactions.trans_type = 1 and
       DATE(transactions.date)  <= "'.$week_end.'" and
                                           DATE(transactions.date) >= "'.$week_start.'" , transactions.trans_amount, 0)) as week_room,
       sum(if(transactions.trans_type = 1 and
       DATE(transactions.date)  <= "'.$month_end.'" and
                                           DATE(transactions.date) >= "'.$month_start.'" , transactions.trans_amount, 0)) as month_room,
       sum(if(transactions.trans_type = 1 and
       DATE(transactions.date)  <= "'.$year_end.'" and
                                           DATE(transactions.date) >= "'.$year_start.'" , transactions.trans_amount, 0)) as year_room,



                                            sum(if(transactions.trans_type = 2 and
       DATE(transactions.date) = "'.$today.'", transactions.trans_amount, 0)) as today_event,
       sum(if(transactions.trans_type = 2 and
       DATE(transactions.date) = "'.$yesterday.'", transactions.trans_amount, 0)) as yes_event,
       sum(if(transactions.trans_type = 2 and
       DATE(transactions.date)  <= "'.$week_end.'" and
                                           DATE(transactions.date) >= "'.$week_start.'" , transactions.trans_amount, 0)) as week_event,
       sum(if(transactions.trans_type = 2 and
       DATE(transactions.date)  <= "'.$month_end.'" and
                                           DATE(transactions.date) >= "'.$month_start.'" , transactions.trans_amount, 0)) as month_event,
       sum(if(transactions.trans_type = 2 and
       DATE(transactions.date)  <= "'.$year_end.'" and
                                           DATE(transactions.date) >= "'.$year_start.'" , transactions.trans_amount, 0)) as year_event,


                                                      sum(if(transactions.trans_type = 4 and
       DATE(transactions.date) = "'.$today.'", transactions.trans_amount, 0)) as today_fee,
       sum(if(transactions.trans_type = 4 and
       DATE(transactions.date) = "'.$yesterday.'", transactions.trans_amount, 0)) as yes_fee,
       sum(if(transactions.trans_type = 4 and
       DATE(transactions.date)  <= "'.$week_end.'" and
                                           DATE(transactions.date) >= "'.$week_start.'" , transactions.trans_amount, 0)) as week_fee,
       sum(if(transactions.trans_type = 4 and
       DATE(transactions.date)  <= "'.$month_end.'" and
                                           DATE(transactions.date) >= "'.$month_start.'" , transactions.trans_amount, 0)) as month_fee,
       sum(if(transactions.trans_type = 4 and
       DATE(transactions.date)  <= "'.$year_end.'" and
                                           DATE(transactions.date) >= "'.$year_start.'" , transactions.trans_amount, 0)) as year_fee,


                                              sum(if(transactions.trans_type = 5 and
       DATE(transactions.date) = "'.$today.'", transactions.trans_amount, 0)) as today_food,
       sum(if(transactions.trans_type = 5 and
       DATE(transactions.date) = "'.$yesterday.'", transactions.trans_amount, 0)) as yes_food,
       sum(if(transactions.trans_type = 5 and
       DATE(transactions.date)  <= "'.$week_end.'" and
                                           DATE(transactions.date) >= "'.$week_start.'" , transactions.trans_amount, 0)) as week_food,
       sum(if(transactions.trans_type = 5 and
       DATE(transactions.date)  <= "'.$month_end.'" and
                                           DATE(transactions.date) >= "'.$month_start.'" , transactions.trans_amount, 0)) as month_food,
       sum(if(transactions.trans_type = 5 and
       DATE(transactions.date)  <= "'.$year_end.'" and
                                           DATE(transactions.date) >= "'.$year_start.'" , transactions.trans_amount, 0)) as year_food,



                                                   sum(if(transactions.trans_type = 8 and
       DATE(transactions.date) = "'.$today.'", transactions.trans_amount, 0)) as today_sale,
       sum(if(transactions.trans_type = 8 and
       DATE(transactions.date) = "'.$yesterday.'", transactions.trans_amount, 0)) as yes_sale,
       sum(if(transactions.trans_type = 8 and
       DATE(transactions.date)  <= "'.$week_end.'" and
                                           DATE(transactions.date) >= "'.$week_start.'" , transactions.trans_amount, 0)) as week_sale,
       sum(if(transactions.trans_type = 8 and
       DATE(transactions.date)  <= "'.$month_end.'" and
                                           DATE(transactions.date) >= "'.$month_start.'" , transactions.trans_amount, 0)) as month_sale,
       sum(if(transactions.trans_type = 8 and
       DATE(transactions.date)  <= "'.$year_end.'" and
                                           DATE(transactions.date) >= "'.$year_start.'" , transactions.trans_amount, 0)) as year_sale,




                                                   sum(if(trans_types.type= 3  and
       DATE(transactions.date) = "'.$today.'", transactions.trans_amount, 0)) as today_subs,
       sum(if(trans_types.type= 3 and
       DATE(transactions.date) = "'.$yesterday.'", transactions.trans_amount, 0)) as yes_subs,
       sum(if(trans_types.type= 3  and
       DATE(transactions.date)  <= "'.$week_end.'" and
                                           DATE(transactions.date) >= "'.$week_start.'" , transactions.trans_amount, 0)) as week_subs,
       sum(if(trans_types.type= 3  and
       DATE(transactions.date)  <= "'.$month_end.'" and
                                           DATE(transactions.date) >= "'.$month_start.'" , transactions.trans_amount, 0)) as month_subs,
       sum(if(trans_types.type= 3 and
       DATE(transactions.date)  <= "'.$year_end.'" and
                                           DATE(transactions.date) >= "'.$year_start.'" , transactions.trans_amount, 0)) as year_subs

                    from  transactions
                         
                                 left outer join trans_types on trans_types.id = transactions.trans_type 

                             WHERE transactions.type=2 and transactions.debit_or_credit=0 and transactions.deleted_at is null 
                 ');

   $data['complaints']= crm_complaint::count();
//(10,11,12,13,14,15,16,17,19,21,30,31,32,34,45,4)

   return $data;
}


      public function leads_vue(Request $request, crm_lead $crm_lead)
    { 

        $tableColumns=    $crm_lead->getTableColumns();
         return view('backend/crm/leads/leads-vue')->withColumns($tableColumns);

     
    }

    public function leads_init_vue(Request $request)
    {
$data=[];
$idd=Auth::id();
$user='';
        $search='';
        if($request->get('start_date')){
            $start_date=$request->get('start_date');
            $search.=" and crm_leads.lead_date>='$start_date'";
        }if($request->get('end_date')){
        $end_date=$request->get('end_date');
        $search.=" and crm_leads.lead_date<='$end_date'";
    }if($request->get('name')){
        $name=$request->get('name');
        $search.=" and crm_leads.name like '%$name%'";
    }if($request->get('contact')){
        $contact=$request->get('contact');
        $search.=" and crm_leads.contact like '%$contact%'";
    }if($request->get('city')){
        $city=$request->get('city');
        $search.=" and crm_leads.city like '%$city%'";
    }if($request->get('memberid')){
        $searchId=$request->get('memberid');
        $search.=" and crm_leads.id = '$searchId'";
    }if($request->get('response')){
        $searchId=$request->get('response');



        /*if(strpos($searchId,'null')!==false){*/
            if(strpos($searchId,',null')!==false){

                $searchId=str_replace(',null','',$searchId);
            }
            elseif(strpos($searchId,'null,')!==false){

                $searchId=str_replace('null,','',$searchId);
            }
            elseif(strpos($searchId,'null')!==false){

                $searchId=str_replace('null','',$searchId);
            }

            if($searchId==''){

                $search.=' and crm_leads.call_status is null';
            }
            else{
                $search.=" and (crm_leads.call_status in ($searchId) ) ";
//or crm_leads.call_status is null
            }
        /*}*/
        if($searchId!=''){

          //  $search.=" and ";
        }
      //  dd($search);
    }if($request->get('lead_source')){
        $searchId=$request->get('lead_source');
        $search.=" and crm_leads.source in($searchId)";
    }if($request->get('user')){
        $searchId=$request->get('user');
        $search.=" and crm_leads.created_by in($searchId)";
    }

if($request->get('countOnly')){
  $xs= crm_lead::query();
if($user!=''){
    $xs->where('assigned_to',$idd);
}

if($search!=''){
    $xs->whereRaw('1=1 '.$search);
}
//dd($xs->toSql());
 return $xs->count();
}
if($request->get('others')){
   
    $data['stati']= crm_leads_status::where('status',1)->get();
  $data['responses']= crm_calls_status::where('status',1)->get();
  $data['sources']= crm_lead_source::where('status',1)->get();
 if(Auth::user()->can('Export Leads')){
 $data['exported']=1;
 }

 return $data;
}

 if(!Auth::user()->can('ViewAllLeads')){
        $data['users']= User::where('status',1)->where('id',$idd)->get();
        $user.='and crm_leads.assigned_to='.$idd.'';
    }
    else{
      /*  $data['users']= User::where('status',1)->get();*/
       $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
        $user.='';
    }
    
if($request->get('onlySubs')){
    $data['selected_items']=crm_call_detail::selectRaw('crm_call_details.*,1 as hid')->where('lead_id',$request->get('lead_id'))->get();
    return $data;
//    $data['selected_visits']=crm_visit_details::selectRaw('crm_visit_details.*,1 as vid')->where('lead_id',$request->get('lead_id'))->get();
}if($request->get('onlySubs2')){
//    $data['selected_items']=crm_call_detail::selectRaw('crm_call_details.*,1 as hid')->where('lead_id',$request->get('lead_id'))->get();
    $data['selected_visits']=crm_visit_details::selectRaw('crm_visit_details.*,1 as vid,crm_visit_details.remarks as visit_remarks')->where('lead_id',$request->get('lead_id'))->get();
        return $data;

}
$last='';
if($request->get('last_id')){
  $last.=' and crm_leads.id>'.$request->get('last_id');
}

$page=$request->get('page');
$len=$request->get('len');
$page=$page-1;
//dd($search);

    $data['leads'] =\Illuminate\Support\Facades\DB::select(
        'select crm_leads.id,
         crm_leads.lead_date,
        crm_leads.name,
        crm_leads.email,
        crm_leads.contact,
        crm_leads.city,
        crm_leads.designation,
        crm_leads.company,
        crm_leads.company_number,
        crm_calls_statuses.desc as callstatus,
          crm_leads.call_status,
          crm_leads.source,
          users.name as username,
        crm_leads.created_at,
        crm_leads.created_by,
         crm_leads.assigned_to,
         crm_leads.delete_comments

from crm_leads

left outer join users on users.id =crm_leads.created_by and users.status=1
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_leads.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null

where crm_leads.deleted_at is null '.$user.' '.$last.' '.$search.' group by crm_leads.id order by crm_leads.id desc limit '.$page*$len.', '.$len);

    /*where crm_leads.deleted_at is null '.$user.' '.$last.' group by crm_leads.id order by crm_leads.id desc limit '.$page*$len.', '.$len*/

/*

        crm_leads_statuses.desc as status,

        left outer join crm_leads_statuses on crm_leads_statuses.id = crm_leads.status and crm_leads_statuses.status=1 and crm_leads_statuses.deleted_at is null

*/

     return $data;
}




   public function calls_vue(Request $request, crm_lead $crm_lead)
    {
      return view('backend/crm/leads/call-details-vue');
    }

    public function calls_init_vue(Request $request)
    {
$data=[];
$idd=Auth::id();
$user='';
        $search='';
        if($request->get('call_time')){
            $call_time=$request->get('call_time');
            $search.=" and DATE(crm_call_details.call_time)='$call_time'";
        }
        if($request->get('follow_up')){
        $follow_up=$request->get('follow_up');
        $search.=" and DATE(crm_call_details.follow_up)='$follow_up'";
    }
    if($request->get('name')){
        $name=$request->get('name');
        $search.=" and crm_leads.name like '%$name%'";
    } 
    if($request->get('contact')){
        $contact=$request->get('contact');
        $search.=" and crm_leads.contact like '%$contact%'";
    }
    if($request->get('memberid')){
        $searchId=$request->get('memberid');
        $search.=" and crm_call_details.id = '$searchId'";
    }
    if($request->get('leadid')){
        $searchId=$request->get('leadid');
        $search.=" and crm_leads.id = '$searchId'";
    }
    if($request->get('status')){
       $searchId=$request->get('status');
/* 
        if(strpos($searchId,'null')!==false){
            if(strpos($searchId,',null')!==false){

                $searchId=str_replace(',null','',$searchId);
            }
            elseif(strpos($searchId,'null,')!==false){

                $searchId=str_replace('null,','',$searchId);
            }
            elseif(strpos($searchId,'null')!==false){

                $searchId=str_replace('null','',$searchId);
            }
            if($searchId==''){

                $search.=' and crm_call_details.call_status is null';
            }
            else{*/
                $search.=" and (crm_call_details.call_status in ($searchId) or crm_call_details.call_status is null) ";

           /* }*/
      /*  }
        if($searchId!=''){

        }*/
      
    }if($request->get('user')){
        $searchId=$request->get('user');
        $search.=" and crm_leads.created_by in($searchId)";
    }

if($request->get('countOnly')){
  $xs= crm_call_detail::query();
/*if($user!=''){
    $xs->where('assigned_to',$idd);
}*/

if($search!=''){
    $xs->whereRaw('1=1 '.$search);
}
//dd($xs->toSql());
 return $xs->count();
}
if($request->get('others')){
  $data['stati']= crm_calls_status::where('status',1)->get();
 if(Auth::user()->can('Export Call Details')){
 $data['exported']=1;
 }

 return $data;
}

 if(!Auth::user()->can('ViewAllLeads')){
        $data['users']= User::where('status',1)->where('id',$idd)->get();
        $user.='and crm_leads.assigned_to='.$idd.'';
    }
    else{
      /*  $data['users']= User::where('status',1)->get();*/
       $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
        $user.='';
    }
 
$last='';
if($request->get('last_id')){
  $last.=' and crm_leads.id>'.$request->get('last_id');
}

$page=$request->get('page');
$len=$request->get('len');
$page=$page-1;
//dd($search);

    $data['leads'] =\Illuminate\Support\Facades\DB::select(
       'select crm_call_details.id,
      crm_call_details.lead_id,
      crm_leads.name as name,
      crm_leads.contact as contact,
      crm_calls_statuses.desc as status,
      crm_call_details.follow_up,
      crm_call_details.call_time,
      crm_call_details.remarks,
    crm_leads.assigned_to as user

from crm_call_details

left outer join crm_leads on crm_leads.id =crm_call_details.lead_id and crm_leads.deleted_at is null
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_call_details.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null

where crm_call_details.id is not null '.$user.' '.$last.' '.$search.' group by crm_call_details.id order by crm_leads.id desc  limit '.$page*$len.', '.$len);


     return $data;
}




      public function calls_vue_b(Request $request, crm_lead $crm_lead)
    {
      return view('backend/crm/leads/call-details-vue');
    }

    public function calls_init_vue_b(Request $request)
 {
$idd=Auth::id();
$user='';

 if(!Auth::user()->can('ViewAllLeads')){
    $data['users']= User::where('status',1)->where('id',$idd)->get();
    $user.='and crm_leads.assigned_to='.$idd.'';
 }
 else{
   /* $data['users']= User::where('status',1)->get();*/
    $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
    $user.='';
 }

  $data['leads'] =\Illuminate\Support\Facades\DB::select(
         'select crm_call_details.id,
      crm_call_details.lead_id,
      crm_leads.name as name,
      crm_calls_statuses.desc as status,
      crm_call_details.follow_up,
      crm_call_details.call_time,
      crm_call_details.remarks,
    crm_leads.assigned_to as user

from crm_call_details

left outer join crm_leads on crm_leads.id =crm_call_details.lead_id and crm_leads.deleted_at is null
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_call_details.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null

where crm_call_details.id is not null '.$user.' group by crm_call_details.id order by crm_leads.id desc');

  $data['stati']= crm_calls_status::where('status',1)->get();

     return $data;
}






  public function recoveries_vue(Request $request, crm_lead $crm_lead)
    {
      return view('backend/crm/leads/member-recoveries-vue');
    }

    public function recoveries_init_vue(Request $request)
 {


$idd=Auth::id();
$user='';

 if(!Auth::user()->can('ViewAllLeads')){
    $data['users']= User::where('status',1)->where('id',$idd)->get();
    $user.='and crm_leads.assigned_to='.$idd.'';
 }
 else{
    /*$data['users']= User::where('status',1)->get();*/
     $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
    $user.='';
 }

  $data['leads'] =\Illuminate\Support\Facades\DB::select(
         'select crm_visit_details.id,
      crm_visit_details.lead_id,
      crm_leads.name as name,
      crm_leads.contact as contact,
      crm_visit_details.membership_amount,
      crm_visit_details.advance_amount,
      crm_visit_details.remaining_amount,
      crm_visit_details.visit_date,
      crm_visit_details.next_visit,
      crm_visit_details.remarks,
    crm_leads.assigned_to as user

from crm_visit_details

left outer join crm_leads on crm_leads.id =crm_visit_details.lead_id and crm_leads.deleted_at is null

where crm_visit_details.id is not null group by crm_visit_details.id order by crm_leads.id desc'); //'.$user.'

 if(Auth::user()->can('Export Member Recoveries')){
 $data['exported']=1;
 }
     return $data;
}



  public function followups_vue(Request $request, crm_lead $crm_lead)
    {
      return view('backend/crm/leads/follow-ups-and-others-vue');
    }

    public function followups_init_vue(Request $request)
    {

$idd=Auth::id();
$user='';

 if(!Auth::user()->can('ViewAllLeads')){
    $data['users']= User::where('status',1)->where('id',$idd)->get();
    $user.='and crm_leads.assigned_to='.$idd.'';
 }
 else{
 /*   $data['users']= User::where('status',1)->get();*/
  $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
    $user.='';
 }


$data['leads'] =\Illuminate\Support\Facades\DB::select(
      'select crm_leads.id,
      crm_leads.name,
      crm_leads.email,
      crm_leads.contact,
    users.name as username,
      crm_calls_statuses.desc as status,
      crm_leads.follow_up,

       crm_leads.call_status,
       crm_leads.assigned_to

from crm_leads

left outer join users on users.id =crm_leads.assigned_to and users.status=1
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_leads.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null

where crm_leads.call_status=1 and crm_leads.deleted_at is null '.$user.' group by crm_leads.id order by crm_leads.id desc');

  $data['stati']= crm_calls_status::where('status',1)->get();
 if(Auth::user()->can('Export Follow Ups')){
 $data['exported']=1;
 }

     return $data;
}


public function visits_vue(Request $request, crm_lead $crm_lead)
    {
      return view('backend/crm/leads/visits-vue');
    }

    public function visits_init_vue(Request $request)
    {

$idd=Auth::id();
$user='';

 if(!Auth::user()->can('ViewAllLeads')){
    $data['users']= User::where('status',1)->where('id',$idd)->get();
    $user.='and crm_leads.assigned_to='.$idd.'';
 }
 else{
 /*   $data['users']= User::where('status',1)->get();*/
  $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
    $user.='';
 }


$data['leads'] =\Illuminate\Support\Facades\DB::select(
      'select crm_leads.id,
      crm_leads.name,
      crm_leads.email,
      crm_leads.contact,
    users.name as username,
      crm_calls_statuses.desc as status,
       crm_leads.call_status,
       crm_leads.assigned_to,
       crm_leads.next_visit,
       crm_leads.follow_up as follow_up,
       Date(crm_leads.next_visit) as nextvisit,
       Date(crm_leads.follow_up) as followup


from crm_leads

left outer join users on users.id =crm_leads.assigned_to and users.status=1
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_leads.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null
where crm_leads.deleted_at is null and (crm_leads.call_status=3 or crm_leads.call_status=6 or crm_leads.call_status=7 or crm_leads.next_visit is not null) '.$user.' group by crm_leads.id order by crm_leads.id desc');

/* 'select crm_leads.id,
      crm_leads.name,
      crm_leads.email,
      crm_leads.contact,
    users.name as username,
      crm_calls_statuses.desc as status,
      crm_leads.follow_up,

       crm_leads.call_status,
       crm_leads.assigned_to

from crm_leads

left outer join users on users.id =crm_leads.assigned_to and users.status=1
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_leads.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null
where crm_leads.deleted_at is null and (crm_leads.call_status=3 or crm_leads.call_status=6 or crm_leads.call_status=7) '.$user.' group by crm_leads.id order by crm_leads.id desc'*/

  $data['stati']= crm_calls_status::where('status',1)->where('id',6)->orWhere('id', 7)->get();
 if(Auth::user()->can('Export Visits')){
 $data['exported']=1;
 }

     return $data;
}

public function bd_vue(Request $request, crm_lead $crm_lead)
    {
         return view('backend/finance-and-management/crm/bd-report-vue');
    }

       public function bd_init_vue(Request $request)
    {
        $start_date=date('Y-m-d');
        $end_date=date('Y-m-d');
        if($request->start_date){
            $start_date=formatDate($request->start_date);
        }
        if($request->end_date){
            $end_date=formatDate($request->end_date);

        }
        $search ='';
       if($request->user){
            $search.=' and crm_leads.assigned_to in ('.$request->user.') ';
        }
        if($request->r){
  $data['leads'] =\Illuminate\Support\Facades\DB::select(
      'select crm_leads.id,
       users.name as username,
       crm_leads.assigned_to,
       crm_call_details.call_time,

   (count(DISTINCT crm_call_details.id))         as callss,
  sum(if(crm_call_details.call_status = 1,1,0)) as follows,
  sum(if(crm_call_details.call_status = 3 or crm_call_details.call_status = 6 or crm_call_details.call_status = 7,1,0)) as visits,
  sum(if(crm_call_details.call_status = 6,1,0)) as appeared,
  sum(if(crm_call_details.call_status = 5 or crm_call_details.call_status = 2,1,0)) as ninterested

from crm_leads

left outer join users on users.id =crm_leads.assigned_to and users.status=1
left outer join crm_call_details on crm_call_details.lead_id =crm_leads.id and
                                           DATE(crm_call_details.call_time) <= "'.$end_date.'" and
                                           DATE(crm_call_details.call_time) >= "'.$start_date.'"
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_leads.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null

where crm_leads.deleted_at is null '.$search.' and users.name is not null group by crm_leads.assigned_to order by crm_leads.assigned_to desc');

        }

   /*$data['users']= User::where('status',1)->get();*/
    $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
     return $data;
}



   public function lead_vue(Request $request, crm_lead $crm_lead)
    {
         return view('backend/finance-and-management/crm/lead-report-vue');
    }

       public function lead_init_vue(Request $request)
    {
        $start_date=date('Y-m-d');
        $end_date=date('Y-m-d');
        if($request->start_date){
            $start_date=formatDate($request->start_date);
        }
        if($request->end_date){
            $end_date=formatDate($request->end_date);

        }
        $search ='';
       if($request->user){
            $search.=' and crm_leads.assigned_to in ('.$request->user.') ';
        }
        if($request->r){
  $data['leads'] =\Illuminate\Support\Facades\DB::select(
      'select crm_leads.id,
       users.name as username,
       crm_leads.assigned_to,
       crm_leads.lead_date,

  (count(crm_leads.id))    as leads,
  sum(if(crm_leads.call_status is null,1,0)) as open,
  sum(if(crm_leads.call_status!=2 and crm_leads.call_status!=5 and crm_leads.call_status!=4 and crm_leads.call_status is not null,1,0)) as inprocess,
  sum(if(crm_leads.call_status = 2 or crm_leads.call_status = 5,1,0)) as noresponse,
  sum(if(crm_leads.call_status = 4,1,0)) as memberships

from crm_leads

left outer join users on users.id =crm_leads.assigned_to and users.status=1

where crm_leads.deleted_at is null '.$search.' and
                                           DATE(crm_leads.lead_date) <= "'.$end_date.'" and
                                           DATE(crm_leads.lead_date) >= "'.$start_date.'"
                                           and users.name is not null group by crm_leads.assigned_to order by crm_leads.assigned_to desc');

        }

  /* $data['users']= User::where('status',1)->get();*/
   $data['users']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',12);
            })->get();
     return $data;
}


   public function dashboard_vue(Request $request, crm_lead $crm_lead)
    {
      return view('backend/crm/dashboard/dashboard-vue');
    }

    public function dashboard_init_vue(Request $request)
    {
        $today=date('Y-m-d');
    $yesterday= date('Y-m-d',strtotime("-1 days"));
    $tomorrow= date('Y-m-d',strtotime("+1 days"));

    $data['leads'] =\Illuminate\Support\Facades\DB::select(
      'select t.* from (
                    select
                        (count(distinct users.id))                  as user,
                        (count(cb.id))                              as leadd,
                        (sum(if(cb.call_status is null,1,0)))       as opens,
                        (sum(if(cb.call_status!= 4 and cb.call_status is not null, 1, 0))) as inpro,
                        (sum(if(cb.call_status = 4, 1, 0))) as memberships,
sum(if(c.call_status = 3 or c.call_status = 6 or
       c.call_status = 7, 1, 0))                as visits,
sum(if((c.call_status = 3 or c.call_status = 6 or
        c.call_status = 7) and
       DATE(c.folLow_up) = "'.$today.'", 1, 0)) as todayvis,
sum(if((c.call_status = 3 or c.call_status = 6 or
        c.call_status = 7) and
       DATE(c.folLow_up) = "'.$yesterday.'", 1, 0)) as yesvis,
sum(if(c.call_status = 3 and
       DATE(c.folLow_up) = "'.$tomorrow.'", 1, 0)) as tomvis,
(count(c.id))                                   as callss,
(group_concat( distinct c.lead_id))                                   as lead_id,
sum(if(DATE(c.call_time) = "'.$today.'", 1, 0)) as todaycal,
sum(if(DATE(c.call_time) = "'.$yesterday.'", 1, 0)) as yescal,
sum(if(c.call_status = 6 and
       DATE(c.folLow_up) = "'.$today.'", 1, 0)) as todayappvis,
sum(if(c.call_status = 6 and
       DATE(c.folLow_up) = "'.$yesterday.'", 1, 0)) as yesappvis
                    from ( select  crm_call_details.id,
                                 crm_call_details.call_status,crm_call_details.lead_id,crm_call_details.folLow_up,crm_call_details.call_time
                          from crm_call_details
                         )
                             as c
                             left outer join crm_leads cb on cb.id = c.id and cb.deleted_at is null and cb.assigned_to is not null
                             left outer join users on users.id = cb.assigned_to
                ) as t');


/*    select crm_leads.id,
  (count(DISTINCT crm_leads.id))         as leadd,
  (count(DISTINCT if(crm_leads.status = 1,crm_leads.id,0)))         as opens,
  (count(DISTINCT if(crm_leads.status = 3,crm_leads.id,0)))         as inpro,
  (count(DISTINCT if(crm_leads.status = 2,crm_leads.id,0)))         as memberships,
  (count(DISTINCT users.id))         as user,

 sum(if(crm_call_details.call_status = 3 or crm_call_details.call_status = 6 or crm_call_details.call_status = 7,1,0)) as visits,

sum(if((crm_call_details.call_status = 3 or crm_call_details.call_status = 6 or crm_call_details.call_status = 7) and DATE(crm_call_details.folLow_up)="'.$today.'",1,0)) as todayvis,

sum(if((crm_call_details.call_status = 3 or crm_call_details.call_status = 6 or crm_call_details.call_status = 7) and DATE(crm_call_details.folLow_up)="'.$yesterday.'",1,0)) as yesvis,

sum(if(crm_call_details.call_status = 3 and DATE(crm_call_details.folLow_up)="'.$tomorrow.'",1,0)) as tomvis,

  (count(DISTINCT crm_call_details.id))         as callss,

  sum(if(DATE(crm_call_details.call_time)="'.$today.'",1,0)) as todaycal,
  sum(if(DATE(crm_call_details.call_time)="'.$yesterday.'",1,0)) as yescal,

  sum(if(crm_call_details.call_status = 6 and DATE(crm_call_details.folLow_up)="'.$today.'",1,0)) as todayappvis,
  sum(if(crm_call_details.call_status = 6 and DATE(crm_call_details.folLow_up)="'.$yesterday.'",1,0)) as yesappvis

from crm_leads

left outer join users on users.id =crm_leads.assigned_to and users.status=1
left outer join crm_call_details on crm_call_details.lead_id =crm_leads.id
left outer join crm_calls_statuses on crm_calls_statuses.id = crm_leads.call_status and crm_calls_statuses.status=1 and crm_calls_statuses.deleted_at is null

where crm_leads.deleted_at is null and crm_leads.id is not null*/


   $data['complaints']= crm_complaint::count();

   return $data;
}



  public function index_deleted(Request $request, crm_lead $crm_lead)
    {
        return view('backend/crm/leads/leads-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, crm_lead $crm_lead)
    {

        $table = crm_lead::onlyTrashed()->get();
        return DataTables::of($table)

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('crm/leads/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

            
                
                  ->addColumn('deleted_at', function ($table) {
              return formatDateToShow($table->deleted_at);


                }) 

->addColumn('status', function ($table) {
    if($table->status){
        return leadstatus($table->status);
    }
    else{
        return '';
    }
        })

->addColumn('deleted_by', function ($table) {
    if($table->deleted_by){
        return usernames($table->deleted_by);
    }
        else{
            return '';
        }
        })



->addColumn('user', function ($table) {
    if($table->created_by){
        return usernames($table->created_by);
    }
        else{
            return '';
        }
        })

    ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

 public function create(Request $request)
    {
        return view('backend/crm.leads.leads-aeu-vue');
    }


   public function init(Request $request)
    {
        if($request->get('r')){
            $lastval=crm_lead::find($request->get('r'));
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }

       $lastval['stati']= crm_leads_status::where('status',1)->get();
       $lastval['sources']= crm_lead_source::where('status',1)->get();
       $lastval['reasons']= crm_reason::where('status',1)->get();

       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $lastval=crm_lead::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }

    $data['stati']= crm_leads_status::where('status',1)->get();
    $data['sources']= crm_lead_source::where('status',1)->get();
    $data['reasons']= crm_reason::where('status',1)->get();

     return $data;
 }


}


 public function save(Request $request){
//        dd($request->all());
      $lastval=crm_lead::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }


  /* if(crm_lead::where('contact',"+92".$request->get('contact'))->count() != 0){ */

 if(crm_lead::where('contact',$request->get('contact'))->count() != 0 && $request->get('contact')){
 abort(500);
      }

      else{

if(crm_lead::where('id',$num)->count() == 0){
        $d=[];

        $d['lead_date']=formatDate($request->get('lead_date'));
        $d['name']=$request->get('name');
         $d['city']=$request->get('city');
        $d['email']=$request->get('email');
       /* $d['contact']="+92".$request->get('contact');*/
        $d['contact']=$request->get('contact');
        $d['designation']=$request->get('designation');
        $d['company']=$request->get('company');
        $d['company_number']=$request->get('company_number');
        $d['status']=$request->get('status');
        $d['source']=$request->get('source');
        $d['reason']=$request->get('reason');
         $d['assigned_to']=Auth::id();

        $id=  crm_lead::create($d);

}
     return $id->id;
 }

    }


 public function checkcontact_save(Request $request){

 if(crm_lead::onlyTrashed()->where('contact',$request->get('contact'))->count() != 0){
  $s = 1;
          return $s;
      }

      else if(crm_lead::where('contact',$request->get('contact'))->count() != 0){
  $s = 3;
          return $s;
      }


      else{
$s = 2;
          return $s;

}

 }

 public function checkcontact_edit(Request $request){

   if(crm_lead::where('contact',$request->get('contact'))->where('id','!=',$request->get('id'))->count() != 0){
$s = 1;
          return $s;
      }

      else{
$s = 2;
          return $s;
  }
}




    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\crm_lead  $crm_lead
     * @return \Illuminate\Http\Response
     */
    public function show(crm_lead $crm_lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\crm_lead  $crm_lead
     * @return \Illuminate\Http\Response
     */
   public function edit(crm_lead $crm_lead,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/crm.leads.leads-aeu-vue', $data);
    }

        public function updated(Request $request){
//        dd($request->all());



   if(crm_lead::where('contact',$request->get('contact'))->where('id','!=',$request->get('id'))->count() != 0 && $request->get('contact')){
 abort(500);
      }

      else{

        $d=[];

        $d['lead_date']=formatDate($request->get('lead_date'));
        $d['name']=$request->get('name');
         $d['city']=$request->get('city');
        $d['email']=$request->get('email');
        $d['contact']=$request->get('contact');
        $d['designation']=$request->get('designation');
        $d['company']=$request->get('company');
        $d['company_number']=$request->get('company_number');
        $d['status']=$request->get('status');
        $d['source']=$request->get('source');
         $d['reason']=$request->get('reason');

      $id=  crm_lead::where('id',$request->get('id'))->updateWithUserstamps($d);
  }
}

    public function assignlead(Request $request, $id){
        $d=[];

        $d['assigned_to']=$request->get('assigned_to');
        $d['created_by']=$request->get('assigned_to');
        $d['assigned_by']=Auth::id();

      $id=  crm_lead::where('id',$id)->updateWithUserstamps($d);
    }


      public function calldetails(Request $request, $id){
        $d=[];

        $d['call_status']=$request->get('call_status');
        $d['call_time']=formatTimestamp($request->get('call_time'));

      /*  dd($request->get('follow_up'));*/
        $d['follow_up']=formatTimestamp($request->get('follow_up'));
        $d['status']=3;




       /* if(!isset($inv['remarks'])){
            $inv['remarks']=null;
            }*/

         $m=  crm_call_detail::create([
            'lead_id'=>$id,
               'call_status'=>$request->get('call_status'),
               'call_time'=>formatTimestamp($request->get('call_time')),
               'follow_up'=>formatTimestamp($request->get('follow_up')),
               'remarks'=>$request->get('remarks'),
            ]);




      $id=  crm_lead::where('id',$id)->updateWithUserstamps($d);
    }


      public function visitdetails(Request $request, $id){
     /*   $d=[];*/

     /*   $d['next_visit']=formatTimestamp($request->get('next_visit'));*/

/*foreach($request->get('selected_visits') as $inv){
if(!isset($inv['vid'])){*/

         $m=  crm_visit_details::create([
               'visit_time'=>formatTimestamp($request->get('visit_time')),
               'lead_id'=>$id,
               'membership_amount'=>$request->get('membership_amount'),
               'advance_amount'=>$request->get('advance_amount'),
               'remaining_amount'=>$request->get('remaining_amount'),
               'visit_date'=>formatTimestamp($request->get('visit_date')),
               'next_visit'=>formatTimestamp($request->get('next_visit')),
               'remarks'=>$request->get('visit_remarks'),
            ]);
    /* }
    }*/

     /* $id=  crm_lead::where('id',$id)->updateWithUserstamps($d);*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\crm_lead  $crm_lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, crm_lead $crm_lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\crm_lead  $crm_lead
     * @return \Illuminate\Http\Response
     */
     public function destroy(Request $request,crm_lead $crm_lead,$id)
    {
    
     $update= crm_lead::where('id',$id)->updateWithUserstamps([
        'delete_comments' => $request->remark,
     ]);

      $delete=$crm_lead::where('id', $id)->deleteWithUserstamps();
    }
    /* public function destroy(crm_lead $crm_lead,$id)
    {

        $destroy=$crm_lead::where('id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

        else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
        }


        return redirect('crm/leads-vue');
    }*/

    public function restore(crm_lead $crm_lead,$id)
    {
        $restore = crm_lead::onlyTrashed()->find($id)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('crm/leads/deleted');

}


}
