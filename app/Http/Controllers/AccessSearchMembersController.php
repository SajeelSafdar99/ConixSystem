<?php

namespace App\Http\Controllers;


use App\access_search_members;
use App\customer;
use App\exports\checkouts;
use App\exports\occupancy;
use App\mem_visits;
use App\membership;
use App\room_check_out;
use App\room_booking;
use Carbon\Carbon;
use DataTables;
use App\room;
use App\room_type;
use App\room_charges_type;
use Illuminate\Http\Request;
use App\room_category;
use App\room_category_charges;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\bookingsub;
use DB;
use function foo\func;

class AccessSearchMembersController extends Controller
{


    public function search_members_index_vue(Request $request, access_search_members $access_search_members)
    {
        return view('backend/members-access/search-members/search-members-vue');
    }

    public function search_members_init_vue(Request $request)
    {

$data['init']                = 0;


       $member=membership::query();

       if($request->get('barcode')){
           $member->where('mem_barcode',$request->get('barcode'))->orWhereHas('family',function($m) use($request){
               $m->where('sup_barcode',$request->get('barcode'));
           });
       }

       if($request->get('member_id')){
           $member->where('id',$request->get('member_id'));
       }if($request->get('fam_id')){
           $member->WhereHas('family',function($m) use($request){
               $m->where('id',$request->get('fam_id'));
           });
       }

       if($request->get('membership_number')){
           $member->where('mem_no',$request->get('membership_number'));
       }

       if($request->get('name')){
          /* $member->where('applicant_name',$request->get('name'));*/
           $member->whereIn('applicant_name',explode(' ',$request->get('name')));
       }

       if($request->get('cnic')){
           $member->where('cnic',$request->get('cnic'));
       }

       if($request->get('contact')){
           $member->where('mob_a',$request->get('contact'));
       }
       if($request->get('car_number')){
//           $member->cars()->where('car_no',$request->get('car_number'));
           $member->whereHas('cars',function($m) use($request){
               $m->where('car_no',$request->get('car_number'));
           });
       }


       // echo $member->toSql();die();
        if($request->get('barcode') ||
        $request->get('member_id')||
$request->get('membership_number')||
$request->get('name')||
$request->get('cnic')||
$request->get('contact')||
$request->get('car_number')||
            $request->get('fam_id')){

        $data['membershipdata'] = $member->first();
      $viss= $data['membershipdata']->id;
      $data['visits']= mem_visits::where('type',11)->where('type_id',$viss)->last();
      $data['countofvisits']= mem_visits::where('type',11)->where('type_id',$viss)->count();
      $data['membervisits']= mem_visits::where('type',11)->where('type_id',$viss)->get()->sortByDesc('id');
    
//dd($data['membershipdata']->family);
            $subscriptions=[];




//dd($memberSubscriptions);
//dd($data);
            $data['familySubscriptions']=null;
            $data['memberSubscriptions']=null;
            $data['sub'] =[];


//           dd($data);
            $ddat=date('Y-m-d',time());
            if($data['membershipdata']) {
              //  dd($request->get('mog_id') );
                if ($request->get('barcode') || $request->get('mog_id')  ) {
                    $mid = $data['membershipdata']->id;
                    $data['sub'] = \Illuminate\Support\Facades\DB::select("select t.name,if(t2.id is not null, 1,0) as ac from trans_types t
    inner join finance_invoices f on f.charges_type=t.id
    left outer join transactions t2 on t.id = t2.trans_type and t2.trans_type_id=f.id and t2.debit_or_credit=0
    where '$ddat' between f.start_date and f.end_date and (f.member_id=$mid and f.family is null )");
                } else {
                    if (request('fam_id')) {
                       $data['family'] = $data['membershipdata']->family()->where('id', request('fam_id'))->first();
                       $data['families'] = $data['membershipdata']->family()->where('id', request('fam_id'))->get();

                    } else {

                       $data['family'] = $data['membershipdata']->family()->where('sup_barcode', request('barcode2'))->first();
                       $data['families'] = $data['membershipdata']->family()->where('sup_barcode', request('barcode2'))->get();
                    }

                    if ($data['family']) {
                        $mid = $data['membershipdata']->id;
                        $fid = $data['family']->id;

                        $data['sub'] = \Illuminate\Support\Facades\DB::select("select t.name,if(t2.id is not null, 1,0) as ac from trans_types t
    inner join finance_invoices f on f.charges_type=t.id
    left outer join transactions t2 on t.id = t2.trans_type and t2.trans_type_id=f.id and t2.debit_or_credit=0
    where '$ddat' between f.start_date and f.end_date and (f.member_id=$mid and f.family =$fid)");


       $data['fvisits']= mem_visits::where('type',20)->where('type_id',$fid)->last();
      $data['countoffvisits']= mem_visits::where('type',20)->where('type_id',$fid)->count();
      $data['familyvisits']= mem_visits::where('type',20)->where('type_id',$fid)->get()->sortByDesc('id');

                    }
                }
            }
        }
        else{
            $data['membershipdata'] =null;
            $data['familySubscriptions'] =null;
            $data['memberSubscriptions'] =null;
            $data['sub'] =null;
             $data['family'] =null;
              $data['visits'] =null;
               $data['membervisits'] =null;
                 $data['countofvisits'] =null;
           $data['fvisits'] =null;
               $data['familyvisits'] =null;
                 $data['countoffvisits'] =null;
              $data['families'] =null;
        }


     return $data;
}



     public function index(Request $request, access_search_members $access_search_members)
    {
        $data['init']                = 0;


       $member=membership::query();

       if($request->get('barcode')){
           $member->where('mem_barcode',$request->get('barcode'))->orWhereHas('family',function($m) use($request){
               $m->where('sup_barcode',$request->get('barcode'));
           });
       }

       if($request->get('member_id')){
           $member->where('id',$request->get('member_id'));
       }if($request->get('fam_id')){
           $member->WhereHas('family',function($m) use($request){
               $m->where('id',$request->get('fam_id'));
           });
       }

       if($request->get('membership_number')){
           $member->where('mem_no',$request->get('membership_number'));
       }

       if($request->get('name')){
          /* $member->where('applicant_name',$request->get('name'));*/
           $member->whereIn('applicant_name',explode(' ',$request->get('name')));
       }

       if($request->get('cnic')){
           $member->where('cnic',$request->get('cnic'));
       }

       if($request->get('contact')){
           $member->where('mob_a',$request->get('contact'));
       }
       if($request->get('car_number')){
//           $member->cars()->where('car_no',$request->get('car_number'));
           $member->whereHas('cars',function($m) use($request){
               $m->where('car_no',$request->get('car_number'));
           });
       }


       // echo $member->toSql();die();
        if($request->get('barcode') ||
        $request->get('member_id')||
$request->get('membership_number')||
$request->get('name')||
$request->get('cnic')||
$request->get('contact')||
$request->get('car_number')||
            $request->get('fam_id')){

        $data['membershipdata'] = $member->first();
//dd($data['membershipdata']->family);
            $subscriptions=[];



//dd($memberSubscriptions);
//dd($data);
            $data['familySubscriptions']=null;
            $data['memberSubscriptions']=null;
            $data['sub'] =[];


//           dd($data);
            $ddat=date('Y-m-d',time());
            if($data['membershipdata']) {
              //  dd($request->get('mog_id') );
                if ($request->get('barcode') || $request->get('mog_id')  ) {
                    $mid = $data['membershipdata']->id;
                    $data['sub'] = \Illuminate\Support\Facades\DB::select("select t.name,if(t2.id is not null, 1,0) as ac from trans_types t
    inner join finance_invoices f on f.charges_type=t.id
    left outer join transactions t2 on t.id = t2.trans_type and t2.trans_type_id=f.id and t2.debit_or_credit=0
    where '$ddat' between f.start_date and f.end_date and (f.member_id=$mid and f.family is null )");
                } else {
                    if (request('fam_id')) {
                        $family = $data['membershipdata']->family()->where('id', request('fam_id'))->first();

                    } else {

                        $family = $data['membershipdata']->family()->where('sup_barcode', request('barcode2'))->first();
                    }

                    if ($family) {
                        $mid = $data['membershipdata']->id;
                        $fid = $family->id;

                        $data['sub'] = \Illuminate\Support\Facades\DB::select("select t.name,if(t2.id is not null, 1,0) as ac from trans_types t
    inner join finance_invoices f on f.charges_type=t.id
    left outer join transactions t2 on t.id = t2.trans_type and t2.trans_type_id=f.id and t2.debit_or_credit=0
    where '$ddat' between f.start_date and f.end_date and (f.member_id=$mid and f.family =$fid)");

                    }
                }
            }
        }
        else{
            $data['membershipdata'] =null;
            $data['familySubscriptions'] =null;
            $data['memberSubscriptions'] =null;
            $data['sub'] =null;
        }


        return view('backend/members-access.search-members.search-members', $data);
    }


     public function searchstatus(Request $request, access_search_members $access_search_members)
    {
        $data['init']                = 0;


       $member=membership::query();

       if($request->get('membership_number')){
           $member->where('mem_no',$request->get('membership_number'));
       }

       if($request->get('name')){
        $searchValues = preg_split('/\s+/', $request->get('name'), -1, PREG_SPLIT_NO_EMPTY);



 $member->where(function ($q) use ($searchValues) {
  foreach ($searchValues as $value) {
    $q->orWhere('first_name', 'like', "%{$value}%")->orWhere('middle_name', 'like', "%{$value}%")->orWhere('applicant_name', 'like', "%{$value}%");
  }
});

       }

       if($request->get('cnic')){
           $member->where('cnic',$request->get('cnic'));
       }



        if($request->get('membership_number')&&
$request->get('name')&&
$request->get('cnic')){

        $data['membershipdata'] = $member->first();
        if(!empty($data['membershipdata'])){


$data['memberstatus'] = $data['membershipdata']->active;


        }



    else{
           $data['memberstatus'] =[];
        }
}
   else  if(!(
        $request->get('membership_number')!=''&&
$request->get('name')!=''&&
$request->get('cnic')!='')){
        $data['memberstatus'] =[];
   }


 return view('backend/members-access.search-member-status.search-member-status', $data);
}

    public function checkin($type,$id){
         $type=$type=='member'?0:1;
         mem_visits::create(['type_id'=>$id,'type'=>$type,'location'=>'Main Gate']);
        return redirect('/members-access/search-members');
    }
  public function indexdt(Request $request, access_search_members $access_search_members)
    {


        $cards = membership::get();
        return DataTables::of($cards)

            ->addColumn('editbutton', function ($cards) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('club-hospitality/cards/edit/') . '/' . $cards->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

            ->addColumn('deletebutton', function ($cards) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/cards/delete/') . '/' . $cards->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton'])
            ->addIndexColumn()
            ->make(true);
    }
}
