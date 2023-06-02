<?php

namespace App\Http\Controllers;
use App\trans_type;
use App\membership;
use Illuminate\Http\Request;
use App\mem_address;
use App\exports\membershipDown;
use App\mem_family;
use App\mem_classification;
use App\mem_category;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use DataTables;
use App\mem_car;
use App\mem_title;
use App\media;
use App\mem_status;
use App\User;
use App\mem_relation;
use test\Mockery\ReturnTypeObjectTypeHint;
use Illuminate\Support\Facades\Auth;
class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index_vue(Request $request, membership $membership)
    {
         $tableColumns=    $membership->getTableColumns();
         return view('backend/club-hospitality/membership/membership-vue')->withColumns($tableColumns);
    }

       public function init_vue(Request $request)
    {
 
  $data['memberships'] =\Illuminate\Support\Facades\DB::select(

      'select memberships.* , mem_categories.desc as memcategoryid , mem_classifications.desc as memclassificationid, mem_statuses.desc as activestatus, (select group_concat(sup_barcode) from mem_families where mem_families.member_id=memberships.id and mem_families.deleted_at is null) as supbarcode, (select count(id) from mem_families where mem_families.member_id=memberships.id and mem_families.deleted_at is null) as famcount, media.url as image, (select group_concat(car_no) from mem_cars where mem_cars.member_id=memberships.id) as carno,
  users.name as cashiername,
  TIMESTAMPDIFF(year,memberships.membership_date,CURDATE())  as duration_year,
  TIMESTAMPDIFF(month,memberships.membership_date,CURDATE())  as duration_month

FROM memberships


left outer join mem_statuses on mem_statuses.id=memberships.active
left outer join users on users.id =memberships.created_by and users.status=1
left outer join mem_classifications on mem_classifications.id=memberships.mem_classification_id
left outer join mem_categories on mem_categories.id=memberships.mem_category_id
left outer join media on media.trans_type=3 and media.trans_type_id=memberships.id and media.deleted_at is null

where memberships.deleted_at is null group by memberships.id order by memberships.id desc');

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();

     return $data;
}


// FOR FAMILY MEMBERSHIPS
 public function fam_index_vue(Request $request, mem_family $mem_family)
    {

         $tableColumns=    $mem_family->getTableColumns();
         return view('backend/club-hospitality/family-membership/family-membership-vue')->withColumns($tableColumns);

    }

       public function fam_init_vue(Request $request)
    {

  $data['memberships'] =\Illuminate\Support\Facades\DB::select(

      'select mem_families.* , media.url as image ,memberships.title as mttitle, memberships.first_name as mfname, memberships.middle_name as mmname, memberships.applicant_name as amname, mem_relations.desc as relation,
  users.name as cashiername,mem_statuses.desc as active,
   YEAR(CURDATE()) - YEAR(mem_families.date_of_birth) AS age

FROM mem_families

left outer join mem_statuses on mem_statuses.id=mem_families.status
left outer join users on users.id =mem_families.created_by and users.status=1
left outer join media on media.type=20 and media.type_id=mem_families.id and media.deleted_at is null
left outer join memberships on memberships.id=mem_families.member_id
left outer join mem_relations on mem_relations.id=mem_families.fam_relationship
where mem_families.deleted_at is null group by mem_families.id order by mem_families.id desc');

  $data['stati']= mem_status::where('status',1)->get();
  $data['relationships']= mem_relation::where('status',1)->get();

     return $data;
}
// FOR FAMILY MEMBERSHIPS


    public function cardPrint(Request $request,$id){
        return view('backend/club-hospitality/membership/cardprint')->withMem(Membership::find($id));
    }
    public function fmCardPrint(Request $request,$id){
        return view('backend/club-hospitality/membership/fmcardprint')->withMem(mem_family::find($id));
    }
    public function export(Request $request){
      ob_end_clean(); 
     ob_start();
        return Excel::download(new membershipDown,'members.xlsx');
    }
    public function index(Request $request, membership $membership)
    {
       if($request->get('searchstatus')){
     $status=   mem_status::where('status',1)->whereNotIn('id',[10,11])->whereIn('id',$request->get('searchstatus'))->get();
}
  else{
        $status=   mem_status::where('status',1)->whereNotIn('id',[10,11])->get();
  }

     if($request->get('searchcat')){
     $categories=   mem_category::where('status',1)->whereIn('id',$request->get('searchcat'))->get();
}
  else{
        $categories=mem_category::where('status',1)->get();
  }

if($request->get('searchcat')){
$caties =$request->get('searchcat');
}
else{
$caties =[];
}


if($request->get('searchstatus')){
$staties =$request->get('searchstatus');
}
else{
$staties =[];
}


if($request->get('searchcard')){
$cardstaties =$request->get('searchcard');
}
else{
$cardstaties =[];
}


       $tableColumns=    $membership->getTableColumns();
        return view('backend/club-hospitality/membership/membership')->withStatus($status)->withCat($categories)->withCati($caties)->withStati($staties)->withCardstati($cardstaties)->withColumns($tableColumns);
    }

     public function indexdt(Request $request, membership $membership)
    {
        $member=membership::query();

        if($request->get('barcode')){
            $member->where('mem_barcode',$request->get('barcode'))->orWhereHas('family',function($m) use($request){
                $m->where('sup_barcode',$request->get('barcode'));
            });
        }

      if($request->get('searchid')){
            $member->where('id',$request->get('searchid'));
        }

        if($request->get('member_id')){
            $member->where('id',$request->get('member_id'));
        }

        if($request->get('membership_number')){
            $member->where('mem_no',$request->get('membership_number'));
        }

        if($request->get('name')){
            $member->where('applicant_name',$request->get('name'));
        }

        if($request->get('cnic')){
            $member->where('cnic',$request->get('cnic'));
        }

        if($request->get('contact')){
            $member->where('mob_a',$request->get('contact'));
        }

        if($request->get('car_number')){
            $member->whereHas('cars',function($m) use($request){
                $m->where('car_no',$request->get('car_number'));
            });
        }if($request->get('searchstatus')){

            $member->whereIn('active',explode(',',$request->get('searchstatus')));

        }
        if($request->get('searchcat')){

            $member->whereIn('mem_category_id',explode(',',$request->get('searchcat')));

        }
        if($request->get('searchcard')){
            $member->whereIn('card_status',explode(',',$request->get('searchcard')));

        }



//        if($request->get('barcode') ||
//            $request->get('member_id')||
//            $request->get('membership_number')||
//            $request->get('name')||
//            $request->get('contact')||
//            $request->get('car_number')){
//
////            $data['membershipdata'] = $member->withCount('family')->get();
//        }
//        else{
////            $data['membershipdata'] =[];
//
//        }


        $membership = $member->withCount('family')->with('member_status','member_classification','profilePic')->get();

        return DataTables::of($membership)

        /*    ->addColumn('active', function ($membership) {
                if ($membership->active == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } elseif ($membership->active == 0) {
                    return '<button class="btnwidth btn btn-outline-warning active btn-block mg-b-10">Suspended</button>';
                }
                elseif ($membership->active == 2) {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">Terminated</button>';
                }
                else{
                    return '<button class="btnwidth btn btn-outline-primary active btn-block mg-b-10">Expired</button>';
                }


            })*/

            ->addColumn('active', function ($membership) {
              if($membership->member_status){
//                   $status=mem_status::where('id',$membership->active)->first();

                  return ['datamy'=>$membership->member_status->desc];
              }
              else
              {
                return '';
              }

            })


            ->addColumn('mem_classification_id', function ($membership) {

//                  $classificationname=mem_classification::where('id',$membership->member_classification)->first();
                    return $membership->member_classification->desc;
            })


             ->addColumn('editbutton', function ($membership) {

                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('club-hospitality/membership/membership-aeu/') . '/' . $membership->id . '"><i class="fas fa-edit"></i></a></button>'

                ;
            })

            ->addColumn('viewbutton', function ($membership) {

                return '<button class="buttoncolor" title="View"><a style="color:#000000;" target="_blank" href="' . url('club-hospitality/membership/membership-view/') . '/' . $membership->id . '"><i class="fas fa-eye"></i></a></button>'

                ;
            })

             ->addColumn('family_count', function ($membership) {

                   return ['name'=>$membership->family_count,'id'=>$membership->id];
                ;
            })

      ->addColumn('deletebutton', function ($membership) {

                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/membership/delete') . '/' . $membership->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'

                ;
            })

        ->addColumn('membership_date', function ($membership) {
              return formatDateToShow($membership->membership_date);


                })

          ->addColumn('name', function ($membership) {
              return $membership->title.' '.$membership->first_name.' '.$membership->middle_name.' '.$membership->applicant_name;
            })

          ->addColumn('category', function ($membership) {
              return membercategory($membership->mem_category_id);
            })

          ->addColumn('mem_picture', function ($membership) {
              $m=$membership->toArray();

              return '<img style="width: 100px;" src="'.url('/').'/'.($m['profile_pic']?$m['profile_pic']['url']:'').'"/>';
            })

//            ->addColumn('mem_no', function ($membership) {
////               return ['mem_no'=>$membership->mem_no,'id',$membership->id];
//                $x=[
//                    'display' =>$membership->mem_no,
//                    'timestamp' =>$membership->id
//                ];
////                dd($x);
//                return $x;
//            })

            ->rawColumns(['editbutton', 'deletebutton', 'viewbutton', 'active','mem_picture','mem_no', 'name', 'category'])
            ->addIndexColumn()
            ->make(true);
    }



    public function index_deleted(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/membership-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, membership $membership)
    {

        $members = membership::onlyTrashed()->withCount('family')->get();
        return DataTables::of($members)

         ->addColumn('mem_classification_id', function ($members) {

                  $classificationname=mem_classification::where('id',$members->mem_classification_id)->first();
                    return $classificationname->desc;



            })


           ->addColumn('family_count', function ($members) {

                   return ['name'=>$members->family_count,'id'=>$members->id];

                ;
            })


        ->addColumn('membership_date', function ($members) {
              return formatDateToShow($members->membership_date);


                })
        
         ->addColumn('deleted_at', function ($members) {
              return formatDateToShow($members->deleted_at);


                })

      ->addColumn('mem_picture', function ($members) {

                return '<img style="width: 100px;" src="'.url('/').'/'.($members->profilePic?$members->profilePic->url:'').'"/>';
            })

            ->addColumn('restorebutton', function ($members) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/membership/restore/') . '/' . $members->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

           ->addColumn('name', function ($members) {
              return $members->title.' '.$members->first_name.' '.$members->middle_name.' '.$members->applicant_name;
            })

          ->addColumn('category', function ($members) {
              return membercategory($members->mem_category_id);
            })

        ->rawColumns(['restorebutton','mem_picture','mem_no', 'name', 'category'])
        ->addIndexColumn()
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Get the last record id and pass to the view
      $lastval=membership::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=sprintf("%03d", $num);;

      }else{
        $num=1;
        $data['increment_number']=sprintf("%03d", $num);;
      }
       $data['init']                = 0;

    $data['mem_category']=mem_category::where('status',1)->get();
    $data['mem_classification']=mem_classification::where('status',1)->get();
    $data['mem_status']=mem_status::where('status',1)->whereNotIn('id',[10,11])->get();
     $data['titles']=mem_title::where('status',1)->get();

/*
      $data['bds']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',2);
            })->get();*/

     $data['bds']= User::where('category',null)->where('status',1)->orWhere('category',2)->where('status',1)->get();

    $data['id']=$request->get('id');
     return view('backend.club-hospitality.membership.membership-aeu',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    $size['width'] = 300;
    $size['height'] = 200;
    $getlastinsert=0;

    if(membership::get()->last())
    {
$lastval=membership::get()->last();
 $num=$lastval->id+1;
}

/*
  if ($request->hasFile('mem_picture')) {
           $file = $request->file('mem_picture');
  }
else{
            $file='';
        }*/



        $save=$request->save;

if(mem_category::where('id',$request->get('mem_category_id'))->exists()){
  $iamcat =mem_category::where('id',$request->get('mem_category_id'))->get()->pluck('account');
}
if($iamcat){
  $icat=$iamcat[0];
}else{
  $icat=null;
}
    
 

        $validation=[
            'app_no' => 'required',
            'mem_no'   => 'required|unique:memberships,mem_no',
            'membership_date' => 'required',

            'first_name' => 'required',
            'last_name' => 'required',

            'father_name' => 'required',
          'cnic'     =>'required_without:passport_no|unique:memberships,cnic',
          'passport_no'     =>'required_without:cnic',

            'gender'   =>'required',
            'date_of_birth'   =>'required',
            'mob_a'=>'required',
            //'mob_b'=>'required',
            //'personal_email'=>'required|email',
            'card_status'   =>'required',
          //  'mem_picture'   =>'required',

            'father_name'=> 'required',
            'mem_classification_id'    => 'required',
            'cur_address'   =>'required',
            'cur_city'=> 'required',
            'cur_country'    => 'required',
             'mem_category_id'    => 'required',
             'membership_date'    => 'required',
             //'mem_fee'=> 'required',
            'total'    => 'required',
          //  'maintenance_amount'   =>'required',
             'total_maintenance'    => 'required',
             'active'   => 'required',
              'mem_barcode'     =>'required_without:passport_no|unique:memberships,mem_barcode',
             /*   'done_by'   => 'required',*/
];
        if($request->get('active')==5){
            $validation['from']='required';
            $validation['to']='required';
             $validation['active_remarks']='required';
        }
        else if($request->get('active')!=1 && $request->get('active')!=5){
            $validation['active_remarks']='required';
        }

          $this->validate($request, $validation);


       $members=membership::create([
            'application_no'=>$request->app_no,
            //'application_date'=>$request->app_date,
            'mem_no'=>$request->mem_no,
            'membership_date'=>formatDate($request->membership_date),

             'title'=>$request->title,
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'applicant_name'=>$request->last_name,
            'name_comment'=>$request->name_comment,

            'kinship'=>$request->kinship,
            'transferred_from'=>$request->transferred_from,

            'mem_category_id'=>$request->mem_category_id,
            'coa_category_id'=>$icat,
            'mem_classification_id'=>$request->mem_classification_id,
            'father_name'=>$request->father_name,
            'father_mem_no'=>$request->father_mem_no,
            'cnic'=>$request->cnic,
            'passport_no'=>$request->passport_no,
            'gender'=>$request->gender,
            'status_remarks'=>$request->status_remarks,
            'active_remarks'=>$request->active_remarks,
            'from'=>formatDate($request->from),
            'to'=>formatDate($request->to),
            'education'=>$request->education,
            'ntn'=>$request->ntn,
            'date_of_birth'=>formatDate($request->date_of_birth),
            'reason'=>$request->reason,
            /*'card_issued'=>1,*/
            'card_issue_date'=>formatDate($request->card_issue_date),
             'card_exp'=>formatDate($request->card_exp),
            'mem_barcode'=>$request->mem_barcode,

            'mem_unique_code'=>$request->mem_unique_code,
            'tel_a'=>$request->tel_a,
           'tel_b'=>$request->tel_b,

           'emergency_name'=>$request->emergency_name,
            'emergency_relation'=>$request->emergency_relation,
            'emergency_contact'=>$request->emergency_contact,

            'mob_a'=>$request->mob_a,
            'mob_b'=>$request->mob_b,
            'personal_email'=>$request->personal_email,
            'official_email'=>$request->official_email,
            'remarks'=>$request->remarks,
            'cur_address'   =>$request->cur_address,
            'cur_city'=> $request->cur_city,
            'cur_country'    => $request->cur_country,
            'per_address'   =>$request->per_address,
            'per_city'=> $request->per_city,
            'per_country'    => $request->per_country,
            'card_status'=>$request->card_status,
            'details'=>$request->details,

            'mem_fee'=> $request->mem_fee,
            'additional_mem'    => $request->additional_mem,
            'additional_mem_remarks'   =>$request->additional_mem_remarks,
            'mem_discount'=> $request->mem_discount,
            'mem_discount_remarks'    => $request->mem_discount_remarks,
            'total'=>$request->total,
            'maintenance_amount'=>$request->maintenance_amount,
            'additional_mt'=> $request->additional_mt,
            'additional_mt_remarks'    => $request->additional_mt_remarks,
            'mt_discount'=>$request->mt_discount,
            'mt_discount_remarks'=>$request->mt_discount_remarks,
            'total_maintenance'    => $request->total_maintenance,
            'maintenance_per_day'    => $request->maintenance_per_day,
             'active' => $request->active,
                   'done_by' => $request->done_by,
          //   'mem_picture'=>sendImage($file,$size,['type'=>5,'moc_id'=>$num]),

            ]);
/*dd($members);
*/



 if ($request->hasFile('mem_picture')) {
           $file = $request->file('mem_picture');
          // dd($file);
           $createimg=saveFile($file,$size,['type'=>0,'trans_type'=>3,'trans_type_id'=>$members->id,'moc_id'=>$members->id]);   
       }



if($request->transfer){
  membership::where('id',$request->transferred_from)->updateWithUserstamps([
    'active'=>12,
  ]);
}


            if($members)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $getlastinsert=$members->id;


            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
            }
/*if($file != ''){
     $members->profilePic()->updateOrCreate(['url'=>saveFile($file),'type'=>11]);
}*/

            //echo $message;
          if($getlastinsert==0){
          return redirect('club-hospitality/membership/membership-aeu');
          }else{
          return redirect('club-hospitality/membership/familymember-aeu/'.$getlastinsert);
          }

        /*   if(empty($save))
            {
                return redirect('club-hospitality/membership/membership-aeu');
            }else{
                return redirect('club-hospitality/membership');
            }*/


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
     public function edit(membership $membership,$id)
    {
        $data['membership_update'] = membership::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['membership_update']->code;

 $getkinship=membership::where('id', $id)->pluck('kinship');
$varmem = membership::where('id',$getkinship)->pluck('mem_no');
$varf = membership::where('id',$getkinship)->pluck('first_name');
$varm = membership::where('id',$getkinship)->pluck('middle_name');
$varl = membership::where('id',$getkinship)->pluck('applicant_name');


if(membership::where('id',$getkinship)->where('mem_no','!=',null)->exists()){
  $memno='('.$varmem[0].')';
}
else{
  $memno='';
}


if(membership::where('id',$getkinship)->where('first_name','!=',null)->exists()){
  $first=$varf[0];
}
else{
  $first='';
}

if(membership::where('id',$getkinship)->where('middle_name','!=',null)->exists()){
  $mid=$varm[0];
}
else{
  $mid='';
}


if(membership::where('id',$getkinship)->where('applicant_name','!=',null)->exists()){
  $last=$varl[0];
}
else{
  $last='';
}
 $data['varkinship']=$first.' '.$mid.' '.$last.' '.$memno;








$gettransferred=membership::where('id', $id)->pluck('transferred_from');
$varmemt = membership::where('id',$gettransferred)->pluck('mem_no');
$varft = membership::where('id',$gettransferred)->pluck('first_name');
$varmt = membership::where('id',$gettransferred)->pluck('middle_name');
$varlt = membership::where('id',$gettransferred)->pluck('applicant_name');

 if(membership::where('id',$gettransferred)->where('mem_no','!=',null)->exists()){
  $memnot='('.$varmemt[0].')';
}
else{
  $memnot='';
}


if(membership::where('id',$gettransferred)->where('first_name','!=',null)->exists()){
  $firstt=$varft[0];
}
else{
  $firstt='';
}

if(membership::where('id',$gettransferred)->where('middle_name','!=',null)->exists()){
  $midt=$varmt[0];
}
else{
  $midt='';
}


if(membership::where('id',$gettransferred)->where('applicant_name','!=',null)->exists()){
  $lastt=$varlt[0];
}
else{
  $lastt='';
}
 $data['vartransferred']=$firstt.' '.$midt.' '.$lastt.' '.$memnot;



//dd($varmem);
    $data['mem_category']=mem_category::where('status',1)->get();
    $data['mem_classification']=mem_classification::where('status',1)->get();
    $data['mem_status']=mem_status::where('status',1)->whereNotIn('id',[10,11])->get();
    $data['titles']=mem_title::where('status',1)->get();

    $data['profession_update']='';
    $data['mem_result']='';
    $data['affiliations_update']='';
    $data['family_update']='';
    $data['referal_update']='';
    $data['maintenance_update']='';
    $data['cars_update']='';
   // $data['address_update']=mem_address::where('member_id',$id)->get();
  /*  $data['bds']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',2);
            })->get();*/
    $data['bds']= User::where('category',null)->where('status',1)->orWhere('category',2)->where('status',1)->get();

        return view('backend/club-hospitality.membership.membership-aeu', $data);
    }


    public function view(Request $request,membership $membership,$id)
    {
        $data['membership_update'] = membership::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['membership_update']->code;


 $getkinship=membership::where('id', $id)->pluck('kinship');
$varmem = membership::where('id',$getkinship)->pluck('mem_no');
$varf = membership::where('id',$getkinship)->pluck('first_name');
$varm = membership::where('id',$getkinship)->pluck('middle_name');
$varl = membership::where('id',$getkinship)->pluck('applicant_name');


if(membership::where('id',$getkinship)->where('mem_no','!=',null)->exists()){
  $memno='('.$varmem[0].')';
}
else{
  $memno='';
}


if(membership::where('id',$getkinship)->where('first_name','!=',null)->exists()){
  $first=$varf[0];
}
else{
  $first='';
}

if(membership::where('id',$getkinship)->where('middle_name','!=',null)->exists()){
  $mid=$varm[0];
}
else{
  $mid='';
}


if(membership::where('id',$getkinship)->where('applicant_name','!=',null)->exists()){
  $last=$varl[0];
}
else{
  $last='';
}

 $data['varkinship']=$first.' '.$mid.' '.$last.' '.$memno;






$gettransferred=membership::where('id', $id)->pluck('transferred_from');
$varmemt = membership::where('id',$gettransferred)->pluck('mem_no');
$varft = membership::where('id',$gettransferred)->pluck('first_name');
$varmt = membership::where('id',$gettransferred)->pluck('middle_name');
$varlt = membership::where('id',$gettransferred)->pluck('applicant_name');

 if(membership::where('id',$gettransferred)->where('mem_no','!=',null)->exists()){
  $memnot='('.$varmemt[0].')';
}
else{
  $memnot='';
}


if(membership::where('id',$gettransferred)->where('first_name','!=',null)->exists()){
  $firstt=$varft[0];
}
else{
  $firstt='';
}

if(membership::where('id',$gettransferred)->where('middle_name','!=',null)->exists()){
  $midt=$varmt[0];
}
else{
  $midt='';
}


if(membership::where('id',$gettransferred)->where('applicant_name','!=',null)->exists()){
  $lastt=$varlt[0];
}
else{
  $lastt='';
}
 $data['vartransferred']=$firstt.' '.$midt.' '.$lastt.' '.$memnot;



    $data['mem_category']=mem_category::where('status',1)->get();
    $data['mem_classification']=mem_classification::where('status',1)->get();
    $data['mem_status']=mem_status::where('status',1)->whereNotIn('id',[10,11])->get();
    $data['titles']=mem_title::where('status',1)->get();

    $data['profession_update']='';
    $data['mem_result']='';
    $data['affiliations_update']='';
    $data['family_update']='';
    $data['referal_update']='';
    $data['maintenance_update']='';
    $data['cars_update']='';
   // $data['address_update']=mem_address::where('member_id',$id)->get();
     $data['bds']= User::where('status', 1)->where(function ($query) use ($request) {
                $query->orWhere('category',null)->orWhere('category',2);
            })->get();
    /*  $data['bds']= User::where('category',null)->where('status',1)->orWhere('category',2)->where('status',1)->get();*/

        return view('backend/club-hospitality.membership.membership-view', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
    $size['width'] = 300;
    $size['height'] = 200;


if(mem_category::where('id',$request->get('mem_category_id'))->exists()){
  $iamcat =mem_category::where('id',$request->get('mem_category_id'))->get()->pluck('account');
}
if($iamcat){
  $icat=$iamcat[0];
}else{
  $icat=null;
}
   
        $validation=[
             'app_no' => 'required',
            'mem_no'   => 'required|unique:memberships,mem_no,'.$id,
            'date_of_birth'   =>'required',
            'membership_date' => 'required',

            'first_name' => 'required',
            'last_name' => 'required',

            'cnic'  => 'required_without:passport_no|unique:memberships,cnic,'.$id,
            'passport_no'     =>'required_without:cnic',

            'gender'   =>'required',
            'mob_a'=>'required',
            //'mob_b'=>'required',
           // 'personal_email'=>'required|email',

            'card_status'   =>'required',
            'father_name'=> 'required',
            'mem_classification_id'    => 'required',
            'cur_address'   =>'required',
            'cur_city'=> 'required',
            'cur_country'    => 'required',
             'mem_category_id'    => 'required',
              'membership_date'    => 'required',
            // 'mem_fee'=> 'required',
            'total'    => 'required',
            //'maintenance_amount'   =>'required',
             'total_maintenance'    => 'required',
             'active'   => 'required',
             'mem_barcode'     => 'required_without:passport_no|unique:memberships,mem_barcode,'.$id,
            /* 'done_by'   => 'required',*/
          ];

       if($request->get('active')==5){
            $validation['from']='required';
            $validation['to']='required';
             $validation['active_remarks']='required';
        }
        else if($request->get('active')!=1 && $request->get('active')!=5){
            $validation['active_remarks']='required';
        }

        $this->validate($request, $validation);
      

        $updateimg='';
        if ($request->hasFile('mem_picture')) {


          if(membership::find($id)->profilePic){
             $s=membership::find($id)->profilePic; //updatepp
             $s->delete();
          }
          
        

            $updateimg=$request->file('mem_picture');
            $updateimg=saveFile($updateimg,$size,['type'=>0,'trans_type'=>3,'trans_type_id'=>$id,'moc_id'=>$id]);   
            // $updateimg=saveFile($updateimg,'upload');
        }else{
            $updateimg=$request->existimg;
        }

      $memberships = membership::find($id);

        $member = membership::where('id', $id)->updateWithUserstamps([

         // 'application_no'=>$request->app_no,
            //'application_date'=>$request->app_date,
            'mem_no'=>$request->mem_no,
            'membership_date'=>formatDate($request->membership_date),

            'title'=>$request->title,
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'applicant_name'=>$request->last_name,
            'name_comment'=>$request->name_comment,

            'kinship'=>$request->kinship_name?$request->kinship:null,
            'transferred_from'=>$request->transfer?$request->transferred_from:null,

            'mem_category_id'=>$request->mem_category_id,
            'coa_category_id'=>$icat,
            'mem_classification_id'=>$request->mem_classification_id,
            'father_name'=>$request->father_name,
            'father_mem_no'=>$request->father_mem_no,
            'cnic'=>$request->cnic,
            'passport_no'=>$request->passport_no,
            'gender'=>$request->gender,
            'ntn'=>$request->ntn,
            'status_remarks'=>$request->status_remarks,
            'active_remarks'=>$request->active_remarks,
            'from'=>formatDate($request->from),
            'to'=>formatDate($request->to),
            'education'=>$request->education,
            'date_of_birth'=>formatDate($request->date_of_birth),
            'reason'=>$request->reason,
            'details'=>$request->details,
            'card_issue_date'=>formatDate($request->card_issue_date),
            'card_exp'=>formatDate($request->card_exp),
            'mem_barcode'=>$request->mem_barcode,
//            'mem_picture'=>$updateimg,
            //'mem_unique_code'=>$request->app_no,


  'mem_unique_code'=>$request->mem_unique_code,
           'emergency_name'=>$request->emergency_name,
            'emergency_relation'=>$request->emergency_relation,
            'emergency_contact'=>$request->emergency_contact,

            'tel_a'=>$request->tel_a,
            'tel_b'=>$request->tel_b,
            'mob_a'=>$request->mob_a,
            'mob_b'=>$request->mob_b,
            'personal_email'=>$request->personal_email,
            'official_email'=>$request->official_email,
            'remarks'=>$request->remarks,
            'cur_address'   =>$request->cur_address,
            'cur_city'=> $request->cur_city,
            'cur_country'    => $request->cur_country,
            'per_address'   =>$request->per_address,
            'per_city'=> $request->per_city,
            'per_country'    => $request->per_country,
            'card_status'=>$request->card_status,

             'mem_fee'=> $request->mem_fee,
            'additional_mem'    => $request->additional_mem,
            'additional_mem_remarks'   =>$request->additional_mem_remarks,
            'mem_discount'=> $request->mem_discount,
            'mem_discount_remarks'    => $request->mem_discount_remarks,
            'total'=>$request->total,
            'maintenance_amount'=>$request->maintenance_amount,
            'additional_mt'=> $request->additional_mt,
            'additional_mt_remarks'    => $request->additional_mt_remarks,
            'mt_discount'=>$request->mt_discount,
            'mt_discount_remarks'=>$request->mt_discount_remarks,
            'total_maintenance'    => $request->total_maintenance,
            'maintenance_per_day'    => $request->maintenance_per_day,
            'active' => $request->active,
               'done_by' => $request->done_by,
        ]);

if($request->transfer){
  membership::where('id',$request->transferred_from)->updateWithUserstamps([
    'active'=>12,
  ]);
     $familia=mem_family::where('member_id',$request->transferred_from)->get();
      foreach($familia as $fam){
        $fam::where('member_id',$request->transferred_from)->where('id',$fam->id)->whereNotIn('status',[10,11])->updateWithUserstamps([
            'status'=>12,
        ]);
      }
}




      $fms=mem_family::where('member_id',$id)->get();

      foreach($fms as $fm){

        $mem= $request->mem_no;
$supp =mem_family::withoutTrashed()->where('member_id',$id)->where('id','<',$fm->id)->count();
      $suppno=$supp+1;

      // dd( $suppno);

       // $sup=explode(' ', $fm->sup_card_no, 2);

// dd($sup[1]);
          if($memberships->mem_no!=$request->mem_no){
              $fm::where('member_id',$id)->where('id',$fm->id)->updateWithUserstamps([
                  'sup_card_no'=>$mem.'-'.generateRandomString($suppno),
              ]);
          }



        $fm::where('member_id',$id)->where('id',$fm->id)->whereNotIn('status',[10,11])->updateWithUserstamps([
            'status'=> $request->active,
        ]);
      }


      /*if($updateimg){
        $memberships->profilePic()->updateOrCreate(['url'=>($updateimg)]); 
      }*/

        if ($member) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }






 public function barcodeupdate(Request $request, $id)
    {
        // dd($request->all());
    $size['width'] = 300;
    $size['height'] = 200;


if(mem_category::where('id',$request->get('mem_category_id'))->exists()){
  $iamcat =mem_category::where('id',$request->get('mem_category_id'))->get()->pluck('account');
}
if($iamcat){
  $icat=$iamcat[0];
}else{
  $icat=null;
}
   
        $validation=[
             
             'mem_barcode'     => 'required_without:passport_no|unique:memberships,mem_barcode,'.$id,
            /* 'done_by'   => 'required',*/
          ];

      

        $this->validate($request, $validation);
      

        $updateimg='';
         

      $memberships = membership::find($id);

        $member = membership::where('id', $id)->updateWithUserstamps([

 
            'mem_barcode'=>$request->mem_barcode,
 
        ]);
 

 
 

        if ($member) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\membership  $membership
     * @return \Illuminate\Http\Response
     */
      public function destroy(Request $request,membership $membership,$id)
    {

     $update= membership::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);

      $delete=$membership::where('id', $id)->deleteWithUserstamps();
    }

/*     public function destroy(membership $membership,$id)
    {
        $membership=$membership::where('id', $id)->deleteWithUserstamps();
        if($membership){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('club-hospitality/membership-vue');
    }*/

    public function getmemnumber(membership $membership,$id)
    {
       $unique_code=mem_category::select('unique_code')->where('id',$id)->first();
        return $unique_code->unique_code;
    }

    public function getmemfee(membership $membership,$id)
    {
       $fee=mem_category::select('fee')->where('id',$id)->first();
        return $fee->fee;
    }

    public function getmaintenancefee(membership $membership,$id)
    {
       $monthly_sub_fee=mem_category::select('monthly_sub_fee')->where('id',$id)->first();
        return $monthly_sub_fee->monthly_sub_fee;
    }


    public function address(Request $request,$id){


         $member_address=mem_address::create([
            'member_id'=>$id,
            'address_type'=>$request->add_type,
            'address'=>$request->add,
            'city'=>$request->city,
            'country'=>$request->country,
            'make_primary'=>0

            ]);


            if($member_address)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                Session::flash('tab_value', 'address');
                $memid=$member_address->id;
                $lastrec=mem_address::where('id',$memid)->first();
                return redirect('club-hospitality/membership/membership-aeu/');
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                Session::flash('tab_value', 'address');
                return redirect('club-hospitality/membership/membership-aeu/');

            }



    }


     public function address_update(Request $request, $id)
       {
        $this->validate($request, [

           'member_id'=>'required',
            'address_type'=>'required',
            'address'=>'required',
            'city'=>'required',
            'country'=>'required',

          ]);

        $add = mem_address::where('id', $id)->update([
          'member_id'=>$id,
            'address_type'=>$request->add_type,
            'address'=>$request->add,
            'city'=>$request->city,
            'country'=>$request->country,
            'make_primary'=>0
        ]);

        if ($add) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }
        public function profession(Request $request,$id){


         $member_profession=mem_profession::create([
            'member_id'=>$id,
            'occupation'=>$request->bussiness,
            'position'=>$request->pos,
            'experience'=>$request->experience,
            'govt_department'=>$request->dep,
            'govt_position'=>$request->govt_pos,
            'grade'=>$request->grade,
            'army_rank'=>$request->rank,
            'serving'=>$request->army_status,
            'retired'=>$request->army_status,
            'monthly_income'=>$request->income,
            'other_membership'=>$request->anymess,
            'when'=>$request->when,
            'was_approved'=>$request->mem_result,
            'was_rejected'=>$request->mem_result

            ]);


            if($member_profession)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $memid=$member_profession->id;
                $lastrec=mem_profession::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return 'data not enter';
            }



    }

     public function profession_update(Request $request, $id)
    {
        $this->validate($request, [

            'member_id'=>'required',
            'occupation'=>'required',
            'position'=>'required',
            'experience'=>'required',
            'govt_department'=>'required',
            'govt_position'=>'required',
            'grade'=>'required',
            'army_rank'=>'required',
            'serving'=>'required',
            'retired'=>'required',
            'monthly_income'=>'required',
            'other_membership'=>'required',
            'when'=>'required',
            'was_approved'=>'required',
            'was_rejected'=>'required',
          ]);

        $profession = mem_profession::where('id', $id)->update([
           'member_id'=>$id,
            'occupation'=>$request->bussiness,
            'position'=>$request->pos,
            'experience'=>$request->experience,
            'govt_department'=>$request->dep,
            'govt_position'=>$request->govt_pos,
            'grade'=>$request->grade,
            'army_rank'=>$request->rank,
            'serving'=>$request->army_status,
            'retired'=>$request->army_status,
            'monthly_income'=>$request->income,
            'other_membership'=>$request->anymess,
            'when'=>$request->when,
            'was_approved'=>$request->mem_result,
            'was_rejected'=>$request->mem_result
        ]);

        if ($profession) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

     public function affiliations(Request $request,$id){


         $member_affiliations=mem_affiliation::create([
            'member_id'=>$id,
            'affiliation'=>$request->aff,
            'name'=>$request->aff_name,
            'period'=>$request->aff_period,
            'other_club'=>$request->others,
            'details'=>$request->details,
            'political_affiliation'=>$request->political_details,
            'relative_a'=>$request->a,
            'relative_b'=>$request->b,
            'stayed_abroad'=>$request->abroad,
            'abroad_details'=>$request->abroad_details,
            'criminal'=>$request->crime,
            'criminal_details'=>$request->crime_details

            ]);


            if($member_affiliations)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $memid=$member_affiliations->id;
                $lastrec=mem_affiliation::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return 'data not enter';
            }

    }

     public function affiliations_update(Request $request, $id)
    {
        $this->validate($request, [

           'member_id'=>'required',
            'affiliation'=>'required',
            'name'=>'required',
            'period'=>'required',
            'other_club'=>'required',
            'details'=>'required',
            'political_affiliation'=>'required',
            'relative_a'=>'required',
            'relative_b'=>'required',
            'stayed_abroad'=>'required',
            'abroad_details'=>'required',
            'criminal'=>'required',
            'criminal_details'=>'required',
          ]);

        $affiliations = mem_affiliation::where('id', $id)->update([
           'member_id'=>$id,
            'affiliation'=>$request->aff,
            'name'=>$request->aff_name,
            'period'=>$request->aff_period,
            'other_club'=>$request->others,
            'details'=>$request->details,
            'political_affiliation'=>$request->political_details,
            'relative_a'=>$request->a,
            'relative_b'=>$request->b,
            'stayed_abroad'=>$request->abroad,
            'abroad_details'=>$request->abroad_details,
            'criminal'=>$request->crime,
            'criminal_details'=>$request->crime_details
        ]);

        if ($affiliations) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

     public function referal(Request $request,$id){


         $member_referal=mem_referal::create([
            'member_id'=>$id,
            'member_name'=>$request->ref_name,
            'mem_no'=>$request->mem_number,
            'relation'=>$request->rel,
            'contact'=>$request->mobile_no

            ]);


            if($member_referal)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $memid=$member_referal->id;
                $lastrec=mem_referal::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return 'data not enter';
            }

    }

     public function referal_update(Request $request, $id)
    {
        $this->validate($request, [

           'member_id'=>'required',
            'member_name'=>'required',
            'mem_no'=>'required',
            'relation'=>'required',
            'contact'=>'required',
          ]);

        $referal = mem_referal::where('id', $id)->update([
           'member_id'=>$id,
            'member_name'=>$request->ref_name,
            'mem_no'=>$request->mem_number,
            'relation'=>$request->rel,
            'contact'=>$request->mobile_no
        ]);

        if ($referal) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

    public function cars(Request $request,$id){


         $member_cars=mem_car::create([
            'member_id'=>$id,
            'name'=>$request->nameforcar,
            'familyforcar'=>$request->familyforcar,
            'membership_number'=>$request->mem_noforcar,
            'contactforcar'=>$request->contactforcar,
             'addressforcar'=>$request->addressforcar,
            'owner_name'=>$request->owner,
             'owner_cnic'=>$request->owner_cnic,
            'car_makeover'=>$request->car_make,
             'car_model'=>$request->model,
            'car_color'=>$request->color,
             'car_no'=>$request->car_no,
            'engine_no'=>$request->engine_no,
             'chassis_no'=>$request->chassis_no,
            'driver_name'=>$request->driver_name,
             'driver_cnic'=>$request->driver_cnic,
            'driver_relation'=>$request->driver_relation,
             'car_remarks'=>$request->car_remarks

            ]);


            if($member_cars)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $memid=$member_cars->id;
                $lastrec=mem_car::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return 'data not enter';
            }

    }

      public function cars_update(Request $request, $id)
    {
        $this->validate($request, [

           'member_id'=>'required',
            'name'=>'required',
            'familyforcar'=>'required',
            'membership_number'=>'required',
            'contactforcar'=>'required',
             'addressforcar'=>'required',
            'owner_name'=>'required',
             'owner_cnic'=>'required',
            'car_makeover'=>'required',
             'car_model'=>'required',
            'car_color'=>'required',
             'car_no'=>'required',
            'engine_no'=>'required',
             'chassis_no'=>'required',
            'driver_name'=>'required',
             'driver_cnic'=>'required',
            'driver_relation'=>'required',
             'car_remarks'=>'required',
          ]);

        $cars = mem_car::where('id', $id)->update([
           'member_id'=>$id,
            'name'=>$request->nameforcar,
            'familyforcar'=>$request->familyforcar,
            'membership_number'=>$request->mem_noforcar,
            'contactforcar'=>$request->contactforcar,
             'addressforcar'=>$request->addressforcar,
            'owner_name'=>$request->owner,
             'owner_cnic'=>$request->owner_cnic,
            'car_makeover'=>$request->car_make,
             'car_model'=>$request->model,
            'car_color'=>$request->color,
             'car_no'=>$request->car_no,
            'engine_no'=>$request->engine_no,
             'chassis_no'=>$request->chassis_no,
            'driver_name'=>$request->driver_name,
             'driver_cnic'=>$request->driver_cnic,
            'driver_relation'=>$request->driver_relation,
             'car_remarks'=>$request->car_remarks
        ]);

        if ($cars) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

    public function familymember(Request $request,$id){


         $member_family=mem_family::create([
            'member_id'=>$id,
            'next_of_kin'=>$request->kin,
            'relationship'=>$request->kin_rel,
            'name'=>$request->fm_name,
            'date_of_birth'=>$request->fm_bday,
             'fam_relationship'=>$request->fm_rel,
            'nationality'=>$request->nation,
             'cnic'=>$request->fm_cnic,
            'contact'=>$request->fm_contact,
             'maritial_status'=>$request->fm_status,
             'sup_card_no'=>$request->sup_no,
            'card_status'=>$request->sup_type,
            'sup_card_issue'=>$request->sup_issue,
             'sup_card_exp'=>$request->sup_exp,
            'sup_barcode'=>$request->fm_bar,
            'fam_picture'=>$request->fm_pic

            ]);


            if($member_family)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $memid=$member_family->id;
                $lastrec=mem_family::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return 'data not enter';
            }

    }

          public function family_update(Request $request, $id)
    {
        $this->validate($request, [

           'member_id'=>'required',
            'next_of_kin'=>'required',
            'relationship'=>'required',
            'name'=>'required',
            'date_of_birth'=>'required',
             'fam_relationship'=>'required',
            'nationality'=>'required',
             'cnic'=>'required',
            'contact'=>'required',
             'maritial_status'=>'required',
             'sup_card_no'=>'required',
            'card_status'=>'required',
            'sup_card_issue'=>'required',
             'sup_card_exp'=>'required',
            'sup_barcode'=>'required',
            'fam_picture'=>'required',
          ]);

        $family = mem_family::where('id', $id)->update([
          'member_id'=>$id,
            'next_of_kin'=>$request->kin,
            'relationship'=>$request->kin_rel,
            'name'=>$request->fm_name,
            'date_of_birth'=>$request->fm_bday,
             'fam_relationship'=>$request->fm_rel,
            'nationality'=>$request->nation,
             'cnic'=>$request->fm_cnic,
            'contact'=>$request->fm_contact,
             'maritial_status'=>$request->fm_status,
             'sup_card_no'=>$request->sup_no,
            'card_status'=>$request->sup_type,
            'sup_card_issue'=>$request->sup_issue,
             'sup_card_exp'=>$request->sup_exp,
            'sup_barcode'=>$request->fm_bar,
            'fam_picture'=>$request->fm_pic
        ]);

        if ($family) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

    public function maintenance(Request $request,$id){


         $member_maintenance=mem_maintenance::create([
            'member_id'=>$id,
            'name'=>$request->applicant_name,
            'membership_number'=>$request->mem_no,
            'membership_fee'=>$request->mem_fee,
            'addi_mem_charges'=>$request->additional_mem,
             'addi_mem_remarks'=>$request->additional_mem_remarks,
            'mem_discount'=>$request->mem_discount,
             'mem_discount_remarks'=>$request->mem_discount_remarks,
            'total_fee'=>$request->total,
             'amount'=>$request->maintenance_amount,
             'addi_mt_charges'=>$request->additional_mt,
            'addi_mt_remarks'=>$request->additional_mt_remarks,
             'mt_discount'=>$request->mt_discount,
            'mt_discount_remarks'=>$request->mt_discount_remarks,
            'total_maintenance'=>$request->total_maintenance

            ]);


            if($member_maintenance)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $memid=$member_maintenance->id;
                $lastrec=mem_maintenance::where('id',$memid)->first();
                return json_encode($lastrec);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return 'data not enter';
            }

    }


        public function maintenance_update(Request $request, $id)
       {
        $this->validate($request, [

           'member_id'=>'required',
            'name'=>'required',
            'membership_number'=>'required',
            'membership_fee'=>'required',
            'addi_mem_charges'=>'required',
             'addi_mem_remarks'=>'required',
            'mem_discount'=>'required',
             'mem_discount_remarks'=>'required',
            'total_fee'=>'required',
             'amount'=>'required',
             'addi_mt_charges'=>'required',
            'addi_mt_remarks'=>'required',
             'mt_discount'=>'required',
            'mt_discount_remarks'=>'required',
            'total_maintenance'=>'required',
          ]);

        $maintenance = mem_maintenance::where('id', $id)->update([
          'member_id'=>$id,
            'name'=>$request->applicant_name,
            'membership_number'=>$request->mem_no,
            'membership_fee'=>$request->mem_fee,
            'addi_mem_charges'=>$request->additional_mem,
             'addi_mem_remarks'=>$request->additional_mem_remarks,
            'mem_discount'=>$request->mem_discount,
             'mem_discount_remarks'=>$request->mem_discount_remarks,
            'total_fee'=>$request->total,
             'amount'=>$request->maintenance_amount,
             'addi_mt_charges'=>$request->additional_mt,
            'addi_mt_remarks'=>$request->additional_mt_remarks,
             'mt_discount'=>$request->mt_discount,
            'mt_discount_remarks'=>$request->mt_discount_remarks,
            'total_maintenance'=>$request->total_maintenance
        ]);

        if ($maintenance) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/membership-aeu/'.$id);

    }

public function restore(membership $membership,$id)
    {
        $restore = membership::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/membership/deleted');

}

 public function creditlimit(membership $membership,$id)
    {
        $data['membership_update'] = membership::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['membership_update']->code;

        $data['membershipdata'] = membership::where('id', $id)->first();

     return view('backend/club-hospitality.membership.creditlimit', $data);


    }

     public function updatecredit(Request $request, $id)
    {

        $this->validate($request, [
             'credit_limit' => 'required',
          ]);

        $member = membership::where('id', $id)->updateWithUserstamps([
            'credit_limit' => $request->credit_limit,
        ]);


        if ($member) {
            Session::flash('message', 'Credit Limit Saved Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Credit Limit Not Saved !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/membership/creditlimit/'.$id);
    }



     public function availmems_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/available-memberships-vue');
    }
     public function availmems_init(Request $request)
    { 
        $data=[];

       $ra=$request->get('rangea');
       $rb=$request->get('rangeb');


$hereitgoes=membership::get()->pluck('mem_no');

 foreach($hereitgoes as $mem){

   $raw[]  = (int) filter_var( $mem, FILTER_SANITIZE_NUMBER_INT);
 }



if($ra){

for ($i = 1; $i >= $ra; $i++){
if (!in_array($i,$raw)) { 
   $data['memberships'][]  =$i;
} 
   
 }
}
if($rb){

for ($i = $ra; $i <= $rb; $i++){
if (!in_array($i,$raw)) { 
   $data['memberships'][]  =$i;
} 
   
 }
}


// dd( $data['memberships']);
 
     return $data;
}


     public function memsummary_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/membership-summary-vue');
    }
       public function memsummary_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and transactions.date>="'.$request->start_date.'" ';
        }
        if($request->end_date){
            $search.=' and transactions.date<="'.$request->end_date.'" ';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }

    $quar=' am ';

    if($request->qt){
        $q=$request->get('qt')-1;
        $quar.='<='.$request->qt.' and am >'.$q;

    }

    else{
      $quar.='>0';
    }

$data['maintenance'] =\Illuminate\Support\Facades\DB::select(
     'select
       finance_invoices.discount_amount

       ,memberships.id,
       finance_invoices.invoice_no as invoiceid,
       memberships.mem_no,
         memberships.membership_date,
         memberships.total AS tmen,
       sum(if(trans_types.id = 22,memberships.total,0)) as cashgross,
       sum(if(trans_types.id = 24,memberships.total,0)) as creditgross,
       sum(if(trans_types.id not in (22,24),memberships.total,0)) as othergross,
         trans_types.name                               as paymentMethod,

CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name) as  name,
memberships.mob_a as contact
     
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
inner join finance_cash_receipts on finance_cash_receipts.id = transactions.receipt_id
inner join trans_types on trans_types.id = finance_cash_receipts.account


where transactions.trans_type=3 and transactions.trans_moc_type=0 '.$search.' group by memberships.id');
   $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['maintenance'=>$data['maintenance'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}

  public function categorymem_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/category-membership-summary-vue');
    }
       public function categorymem_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and (transactions.date)>="'.$request->start_date.'"';
        }
         if($request->end_date){
            $search.=' and (transactions.date)<="'.$request->end_date.'"';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }



$data['membership'] =\Illuminate\Support\Facades\DB::select(
     " 
select  
        
 
     finance_invoices.discount_amount

       ,memberships.id,
       memberships.mem_category_id,
        sum(if(trans_types.id = 22,memberships.total,0)) as cashgross,
       sum(if(trans_types.id = 24,memberships.total,0)) as creditgross,
       sum(if(trans_types.id not in (22,24),memberships.total,0)) as othergross
 
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
inner join finance_cash_receipts on finance_cash_receipts.id = transactions.receipt_id
inner join trans_types on trans_types.id = finance_cash_receipts.account


where transactions.trans_type=3  and transactions.trans_moc_type=0  $search  group by memberships.mem_category_id");

        $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['membership'=>$data['membership'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}



     public function subs_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/subscriptions-maintenance-summary-vue');
    }
       public function subs_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and transactions.date>="'.$request->start_date.'" ';
        }
        if($request->end_date){
            $search.=' and transactions.date<="'.$request->end_date.'" ';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }

    $quar=' am ';

    if($request->qt){
        $q=$request->get('qt')-1;
        $quar.='<='.$request->qt.' and am >'.$q;

    }

    else{
      $quar.='>0';
    }

$data['maintenance'] =\Illuminate\Support\Facades\DB::select(
     'select
       finance_invoices.discount_amount

       ,memberships.id,
       finance_invoices.invoice_no as invoiceid,
       memberships.mem_no,
         memberships.membership_date,
         memberships.total AS tmen,
       sum(if(trs.id = 22,transactions.trans_amount,0)) as cashgross,
       sum(if(trs.id = 24,transactions.trans_amount,0)) as creditgross,
       sum(if(trs.id not in (22,24),transactions.trans_amount,0)) as othergross,
       
CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name) as  name,
memberships.mob_a as contact
     
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
inner join finance_cash_receipts on finance_cash_receipts.id = transactions.receipt_id
left outer join trans_types on trans_types.id = transactions.trans_type
 
left outer join trans_types trs on trs.id = finance_cash_receipts.account


where transactions.deleted_at is null and (trans_types.type = 3 or trans_types.id=4 or trans_types.id = 10) and transactions.trans_moc_type=0 '.$search.' group by memberships.id');
   $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['maintenance'=>$data['maintenance'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}

  public function categorysubs_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/category-subscriptions-maintenance-summary-vue');
    }
       public function categorysubs_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and (transactions.date)>="'.$request->start_date.'"';
        }
         if($request->end_date){
            $search.=' and (transactions.date)<="'.$request->end_date.'"';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }



$data['membership'] =\Illuminate\Support\Facades\DB::select(
    'select
       finance_invoices.discount_amount

       ,memberships.id,
       finance_invoices.invoice_no as invoiceid,
       memberships.mem_category_id,
 
       sum(if(trs.id = 22,transactions.trans_amount,0)) as cashgross,
       sum(if(trs.id = 24,transactions.trans_amount,0)) as creditgross,
       sum(if(trs.id not in (22,24),transactions.trans_amount,0)) as othergross,
       
CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name) as  name,
memberships.mob_a as contact
     
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
inner join finance_cash_receipts on finance_cash_receipts.id = transactions.receipt_id
left outer join trans_types on trans_types.id = transactions.trans_type
 
left outer join trans_types trs on trs.id = finance_cash_receipts.account


where transactions.deleted_at is null and (trans_types.type = 3 or trans_types.id=4 or trans_types.id = 10) and transactions.trans_moc_type=0 '.$search.' group by memberships.mem_category_id');

        $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['membership'=>$data['membership'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}














       public function npending_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/new-pending-maintenance-vue');
    }
       public function npending_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and transactions.date<="'.$request->start_date.'" ';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }


   $quar=' am ';

    if($request->qt && $request->qt!=4){
        $q=$request->get('qt')-1;
        $quar.='<='.$request->qt.' and am >'.$q;

    }
 else if($request->qt==4){
        $q=$request->get('qt')-1;
        $quar.='>'.$q;

    }
    else{
      $quar.='>0';
    }
   

// 3648
    // 
 $data['maintenance'] =\Illuminate\Support\Facades\DB::select(
  'select QUARTER(transactions.date),year(transactions.date),
 
 

count(teez.id)-

sum(if(teez.trans_amount-tees.trans_amount=0 , 1, 0) )

  as am,
 


       (sum(if(transactions.debit_or_credit = 1 and transactions.type = 1, transactions.trans_amount, 0) )) +if(finance_invoices.discount_amount is null,0,0)as credit,
           (sum(if(transactions.debit_or_credit = 0 and transactions.type = 2, transactions.trans_amount, 0))) as debit
       ,finance_invoices.discount_amount

       ,memberships.id,
      group_concat(finance_invoices.invoice_no) as invoiceid,
       memberships.mem_no,
         memberships.membership_date,
         (memberships.total_maintenance*3) AS tmen,
CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name) as  name,
memberships.mob_a as contact,

memberships.cur_address,
memberships.cur_city,
memberships.cur_country,
mem_statuses.desc as state,
memberships.total_maintenance*3

from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id  and finance_invoices.deleted_at is null and finance_invoices.status is null and finance_invoices.grand_total!=0
inner join mem_statuses on mem_statuses.id=memberships.active

 


left outer join transactions teez on teez.trans_type_id=finance_invoices.id and teez.trans_type=4  and teez.debit_or_credit=1 and teez.type=1 and teez.trans_moc =finance_invoices.member_id and teez.deleted_at is null 

left outer join transactions tees on tees.trans_type_id=teez.trans_type_id and tees.trans_type=4 and tees.debit_or_credit=0 and tees.type=2 and tees.trans_moc =finance_invoices.member_id and tees.deleted_at is null 

where transactions.trans_type=4  and transactions.trans_moc_type=0  and transactions.deleted_at is null  and memberships.deleted_at is null '.$search.' group by transactions.trans_moc having  '.$quar.'     ');
 
/*$data['maintenance'] =\Illuminate\Support\Facades\DB::select(
     'select QUARTER(date),year(date),

 (sum( finance_invoices.grand_total)) -(sum(if(transactions.debit_or_credit = 0 and transactions.type = 2   , transactions.trans_amount , 0))) as am,

 
sum(case when transactions.debit_or_credit = 1 and transactions.type = 1  then transactions.trans_amount else 0 end)
  - sum(case when transactions.debit_or_credit = 0 and transactions.type = 2  then transactions.trans_amount else 0 end)
   
     as kam
  ,
 

       (sum(if(transactions.debit_or_credit = 1 and transactions.type = 1, transactions.trans_amount, 0) )) +if(finance_invoices.discount_amount is null,0,0)as credit,
           (sum(if(transactions.debit_or_credit = 0 and transactions.type = 2, transactions.trans_amount, 0))) as debit
       ,finance_invoices.discount_amount

       ,memberships.id,
      group_concat(finance_invoices.invoice_no) as invoiceid,
       memberships.mem_no,
         memberships.membership_date,
         (memberships.total_maintenance*3) AS tmen,
CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name) as  name,
memberships.mob_a as contact,

memberships.cur_address,
memberships.cur_city,
memberships.cur_country,

       memberships.total_maintenance*3
from finance_invoices

left outer join memberships on memberships.id=finance_invoices.member_id

left outer join transactions on transactions.trans_type_id = finance_invoices.id and transactions.trans_type=4  and transactions.trans_moc_type=0  and transactions.deleted_at is null '.$search.' 
 
 
where   finance_invoices.charges_type=4 and finance_invoices.deleted_at is null group by finance_invoices.member_id and transactions.id is not null  having '.$quar.'  ');*/

 
   $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();

/*   (sum(if(transactions.debit_or_credit = 0 and transactions.type = 2, transactions.trans_amount, 0)))+if(finance_invoices.discount_amount is null,0,finance_invoices.discount_amount) as debit*/

     return ['maintenance'=>$data['maintenance'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}




       public function pending_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/pending-maintenance-vue');
    }
       public function pending_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and transactions.date<="'.$request->start_date.'" ';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }

    $quar=' am ';

    if($request->qt && $request->qt!=7){
        $q=$request->get('qt')-1;
        $quar.='<='.$request->qt.' and am >'.$q;

    }
 else if($request->qt==7){
        $q=$request->get('qt')-1;
        $quar.='>'.$q;

    }
    else{
      $quar.='>0';
    }

$data['maintenance'] =\Illuminate\Support\Facades\DB::select(
     'select QUARTER(date),year(date),
       ((sum(if(transactions.debit_or_credit = 1 and transactions.type = 1, transactions.trans_amount +if(finance_invoices.discount_amount is null,0,0)-if(finance_invoices.extra_charges is null,0,finance_invoices.extra_charges), 0))
           -
         sum(if(transactions.debit_or_credit = 0 and transactions.type = 2, transactions.trans_amount+if(finance_invoices.discount_amount is null,0,finance_invoices.discount_amount)-if(finance_invoices.extra_charges is null,0,finance_invoices.extra_charges), 0)))

       / (memberships.total_maintenance*3))
           as am
,
       (sum(if(transactions.debit_or_credit = 1 and transactions.type = 1, transactions.trans_amount, 0) )) +if(finance_invoices.discount_amount is null,0,0)as credit,
           (sum(if(transactions.debit_or_credit = 0 and transactions.type = 2, transactions.trans_amount, 0))) as debit
       ,finance_invoices.discount_amount

       ,memberships.id,
      group_concat(finance_invoices.invoice_no) as invoiceid,
       memberships.mem_no,
         memberships.membership_date,
         (memberships.total_maintenance*3) AS tmen,
CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name) as  name,
memberships.mob_a as contact,

memberships.cur_address,
memberships.cur_city,
memberships.cur_country,
mem_statuses.desc as state,

       memberships.total_maintenance*3
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
inner join mem_statuses on mem_statuses.id=memberships.active

where transactions.trans_type=4  and transactions.trans_moc_type=0  and transactions.deleted_at is null and memberships.deleted_at is null  '.$search.' group by memberships.id having  '.$quar.'');
   $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();

/*   (sum(if(transactions.debit_or_credit = 0 and transactions.type = 2, transactions.trans_amount, 0)))+if(finance_invoices.discount_amount is null,0,finance_invoices.discount_amount) as debit*/

     return ['maintenance'=>$data['maintenance'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}





       public function category_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/category-pending-maintenance-vue');
    }
       public function category_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and (transactions.date)<="'.$request->start_date.'"';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }



$data['membership'] =\Illuminate\Support\Facades\DB::select(
     "select t.*,concat(sum(if(t.am<=1,1,0) ),'(',sum(if(t.am<=1,t.credit-t.debit,0)),')') as q1,
     sum(if(t.am<=1,1,0) ) as oq,
     sum(if(t.am<=1,t.credit-t.debit,0)) as toq,

       concat(sum(if(t.am<=2 and t.am>1,1,0) ),'(',sum(if(t.am<=2  and t.am>1,t.credit-t.debit,0)),')') as q2,
       sum(if(t.am<=2 and t.am>1,1,0) ) as sq,
       sum(if(t.am<=2  and t.am>1,t.credit-t.debit,0)) as tsq,

       concat(sum(if(t.am<=3  and t.am>2,1,0) ),'(',sum(if(t.am<=3  and t.am>2,t.credit-t.debit,0)),')') as q3,
       sum(if(t.am<=3  and t.am>2,1,0) ) as tq,
       sum(if(t.am<=3  and t.am>2,t.credit-t.debit,0)) as ttq,

       concat(sum(if(t.am<=4  and t.am>3,1,0) ),'(',sum(if(t.am<=4  and t.am>3,t.credit-t.debit,0)),')') as q4,
       sum(if(t.am<=4  and t.am>3,1,0) ) as fq,
       sum(if(t.am<=4  and t.am>3,t.credit-t.debit,0)) as tfq,

       concat(sum(if(t.am<=5  and t.am>4,1,0) ),'(',sum(if(t.am<=5  and t.am>4,t.credit-t.debit,0)),')') as q5,
       sum(if(t.am<=5  and t.am>4,1,0) ) as qq,
       sum(if(t.am<=5  and t.am>4,t.credit-t.debit,0)) as tqq,

       concat(sum(if(t.am<=6  and t.am>5,1,0) ),'(',sum(if(t.am<=6  and t.am>5,t.credit-t.debit,0)),')') as q6,
       sum(if(t.am<=6  and t.am>5,1,0) ) as vq,
       sum(if(t.am<=6  and t.am>5,t.credit-t.debit,0)) as tvq,

      concat(sum(if(t.am>6,1,0) ),'(',sum(if(t.am>6,t.credit-t.debit,0)),')') as q7,
sum(if(t.am>6,1,0) ) as bq,
sum(if(t.am>6,t.credit-t.debit,0)) as tbq

       from (
select QUARTER(date),year(date),
       ((sum(if(transactions.debit_or_credit = 1 and transactions.type=1, transactions.trans_amount +if(finance_invoices.discount_amount is null,0,0)-if(finance_invoices.extra_charges is null,0,finance_invoices.extra_charges), 0))
           -
         sum(if(transactions.debit_or_credit = 0 and transactions.type=2, transactions.trans_amount+if(finance_invoices.discount_amount is null,0,finance_invoices.discount_amount)-if(finance_invoices.extra_charges is null,0,finance_invoices.extra_charges), 0)))

       / (memberships.total_maintenance*3))
           as am



,
       (sum(if(transactions.debit_or_credit = 1 and transactions.type=1, transactions.trans_amount, 0) )) +if(finance_invoices.discount_amount is null,0,0)as credit,
           (sum(if(transactions.debit_or_credit = 0 and transactions.type=2, transactions.trans_amount, 0)))+if(finance_invoices.discount_amount is null,0,finance_invoices.discount_amount)-if(finance_invoices.extra_charges is null,0,finance_invoices.extra_charges) as debit
       ,finance_invoices.discount_amount

       ,memberships.id,
       memberships.mem_category_id,

       memberships.total_maintenance*3,
       memberships.total_maintenance*3 as tm
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
where transactions.trans_type=4  and transactions.trans_moc_type=0 and transactions.deleted_at is null  and memberships.deleted_at is null $search  group by memberships.id having am>0) as t where 1=1 and t.mem_category_id is not null group by t.mem_category_id");

        $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['membership'=>$data['membership'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}




   public function ncategory_report_vue(Request $request, membership $membership)
    {
        return view('backend/club-hospitality/membership/new-category-pending-maintenance-vue');
    }
       public function ncategory_report_init(Request $request)
    {

        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        }
         if($request->cnic){
            $search.=' and memberships.cnic='.$request->cnic;
        }
         if($request->contact){
            $search.=' and memberships.mob_a='.$request->contact;
        }
         if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;
       }
      if($request->start_date){
            $search.=' and (transactions.date)<="'.$request->start_date.'"';
        }
      if($request->category){
           $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }
        if($request->memstatus){
            $search.=' and memberships.active in ('.$request->memstatus.') ';
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }



$data['membership'] =\Illuminate\Support\Facades\DB::select(
     "select t.*,concat(sum(if(t.am<=1,1,0) ),'(',sum(if(t.am<=1,t.credit-t.debit,0)),')') as q1,
     sum(if(t.am<=1,1,0) ) as oq,
     sum(if(t.am<=1,t.credit-t.debit,0)) as toq,

       concat(sum(if(t.am<=2 and t.am>1,1,0) ),'(',sum(if(t.am<=2  and t.am>1,t.credit-t.debit,0)),')') as q2,
       sum(if(t.am<=2 and t.am>1,1,0) ) as sq,
       sum(if(t.am<=2  and t.am>1,t.credit-t.debit,0)) as tsq,

       concat(sum(if(t.am<=3  and t.am>2,1,0) ),'(',sum(if(t.am<=3  and t.am>2,t.credit-t.debit,0)),')') as q3,
       sum(if(t.am<=3  and t.am>2,1,0) ) as tq,
       sum(if(t.am<=3  and t.am>2,t.credit-t.debit,0)) as ttq,

      concat(sum(if(t.am>3,1,0) ),'(',sum(if(t.am>3,t.credit-t.debit,0)),')') as q4,
sum(if(t.am>3,1,0) ) as fq,
sum(if(t.am>3,t.credit-t.debit,0)) as tfq

       from (
select QUARTER(date),year(date),
    sum(if(transactions.debit_or_credit = 1 and transactions.type = 1 and finance_invoices.grand_total!=0, 1 , 0))
      
           -

         sum(if(transactions.debit_or_credit = 0 and transactions.type = 2 , 1 , 0))

     
           as am



,
       (sum(if(transactions.debit_or_credit = 1 and transactions.type=1, transactions.trans_amount, 0) )) +if(finance_invoices.discount_amount is null,0,0)as credit,
           (sum(if(transactions.debit_or_credit = 0 and transactions.type=2, transactions.trans_amount, 0)))+if(finance_invoices.discount_amount is null,0,finance_invoices.discount_amount) as debit
       ,finance_invoices.discount_amount

       ,memberships.id,
       memberships.mem_category_id,

       memberships.total_maintenance*3,
       memberships.total_maintenance*3 as tm
from transactions

inner join memberships on memberships.id=transactions.trans_moc
inner join finance_invoices on finance_invoices.id = transactions.trans_type_id
where transactions.trans_type=4  and transactions.trans_moc_type=0 and transactions.deleted_at is null  and memberships.deleted_at is null $search  group by memberships.id having am>0) as t where 1=1 and t.mem_category_id is not null group by t.mem_category_id");

        $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['membership'=>$data['membership'],'co'=>$co, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}







     public function maintenance_report_vue(Request $request, membership $membership)
    {

        return view('backend/club-hospitality/membership/mem-maintenance-vue');

    }  public function maintenance_report_rev_vue(Request $request, membership $membership)
    {

        return view('backend/club-hospitality/membership/mem-maintenance-rev-vue');

    }

       public function maintenance_report_init(Request $request)
    {

        $member=membership::query();
        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        } if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;

    }
     if($request->category){
            $search.=' and memberships.mem_category_id='.$request->category;
        }
        if($request->memstatus){
            $search.=' and memberships.active='.$request->memstatus;
        }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
            $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))=0 and $request->qt like   '%&&&&%' ";
        }if($request->st==2){
        $having="having (COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',1),0)-COALESCE(SUBSTRING_INDEX(SUBSTRING_INDEX($request->qt,'&&&&',-1),'-',-1),0))<0 and $request->qt like '%&&&&%'";
    }if($request->st==2){
        $having="having $request->qt is null";

    }

$query="SELECT memberships.id as id ,
 memberships.membership_date,
 memberships.mem_no,
 memberships.mem_category_id,
memberships.active,
 memberships.total_maintenance AS tmen,
 CONCAT(COALESCE(memberships.title,''),' ',COALESCE(memberships.first_name,''),' ',COALESCE(memberships.middle_name,''),' ',COALESCE(memberships.applicant_name,'')) as name,
 memberships.total_maintenance,
mem_statuses.desc as descc,
0 as tto,
 (select group_concat(concat('<b class=text-danger>(',trans_type_id,') ',trans_amount,'</b> <br><b class=text-success> ',COALESCE((select concat(group_concat('(',tx.receipt_id,') ',tx.trans_amount SEPARATOR '<br>'),'</b>&&&&',concat(sum(tx.trans_amount),'-',transactions.trans_amount)) from transactions tx where tx.id in(select receipt from trans_relations where invoice=transactions.id) and trans_type=4 and debit_or_credit=0 and QUARTER(transactions.`date`)=1 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0 ),''),'')) from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`)=1 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0) as qt1,
 (select group_concat(concat('<b class=text-danger>(',trans_type_id,') ',trans_amount,'</b> <br><b class=text-success>  ',COALESCE((select concat(group_concat('(',tx.receipt_id,') ',tx.trans_amount  SEPARATOR '<br>'),'</b>&&&&',concat(sum(tx.trans_amount),'-',transactions.trans_amount)) from transactions tx where tx.id in(select receipt from trans_relations where invoice=transactions.id) and trans_type=4 and debit_or_credit=0 and QUARTER(transactions.`date`)=2 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0 ),''),'')) from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`)=2 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0) as qt2,
 (select group_concat(concat('<b class=text-danger>(',trans_type_id,') ',trans_amount,'</b> <br><b class=text-success>  ',COALESCE((select concat(group_concat('(',tx.receipt_id,') ',tx.trans_amount  SEPARATOR '<br>'),'</b>&&&&',concat(sum(tx.trans_amount),'-',transactions.trans_amount)) from transactions tx where tx.id in(select receipt from trans_relations where invoice=transactions.id) and trans_type=4 and debit_or_credit=0 and QUARTER(transactions.`date`)=3 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0 ),''),'')) from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`)=3 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0) as qt3,
 (select group_concat(concat('<b class=text-danger>(',trans_type_id,') ',trans_amount,'</b> <br><b class=text-success>  ',COALESCE((select concat(group_concat('(',tx.receipt_id,') ',tx.trans_amount  SEPARATOR '<br>'),'</b>&&&&',concat(sum(tx.trans_amount),'-',transactions.trans_amount)) from transactions tx where tx.id in(select receipt from trans_relations where invoice=transactions.id) and trans_type=4 and debit_or_credit=0 and QUARTER(transactions.`date`)=4 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0 ),''),'')) from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`)=4 and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0) as qt4,
 (select sum(trans_amount) from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`) in (1,2,3,4) and YEAR(transactions.`date`)='$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0) as tot,
 ((select sum(trans_amount) from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`) in (1,2,3,4) and YEAR(transactions.`date`)<'$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0)-

  (
               select sum(trans_amount) from transactions where id in ( (select (trans_relations.receipt) from trans_relations where invoice in ( select id from transactions where trans_type=4 and debit_or_credit=1 and QUARTER(transactions.`date`) in (1,2,3,4) and YEAR(transactions.`date`)<'$year' and deleted_at is null and trans_moc=memberships.id and trans_moc_type=0)

               )))) as opening

   from memberships

    left outer join mem_statuses on mem_statuses.id=memberships.active
    where memberships.deleted_at is null and memberships.active<>7  $search  $having order by memberships.id asc limit ".$request->get('off').", 50";
//
//      echo $query;
//      die();
        $query2="select YEAR(transactions.`date`) as y from transactions where deleted_at is null and trans_moc_type=0  and trans_type=4 group by YEAR(transactions.`date`)";


    $membership=DB::select($query);
    $membership2=DB::select($query2);
    $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();


        $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();


     return ['membership'=>$membership,'co'=>$co,'cm'=>$membership2, 'categories'=>$data['categories'],'stati'=>$data['stati']];

}

    public function maintenance_report_rev_init(Request $request)
      {
        $member=membership::query();
        $search='';
        $year=date('Y',time());
        if($request->barcode){
            $search.=' and memberships.mem_barcode='.$request->barcode;
        } if($request->searchid){
            $search.=' and memberships.id='.$request->searchid;
        }if($request->fullname){
        $search.=' and memberships.id='.$request->fullname;

    }
        if($request->year){
        $year=$request->year;
        }
        $having='';
        if($request->st==1){
$having=' having balance=0 and qt is not null ';
        }
        if($request->st==2){
            $having=' having balance>0  ';
        }
        if($request->st==3){
            $having=' having qt is null ';
        }


$query="SELECT memberships.id as id ,
       memberships.membership_date,
       memberships.mem_no,
       memberships.mem_category_id,
       memberships.active,
       memberships.total_maintenance AS tmen,
       CONCAT(COALESCE(memberships.title,''),' ',COALESCE(memberships.first_name,''),' ',COALESCE(memberships.middle_name,''),' ',COALESCE(memberships.applicant_name,'')) as name,
       memberships.total_maintenance,
       mem_statuses.desc as descc,
       group_concat(distinct concat(transactions.trans_amount,'(',transactions.trans_type_id,')')) as qt,
      sum(transactions.trans_amount) as qts,
       group_concat(concat(t.trans_amount,'(',t.receipt_id,')')) as qtp,
      sum(t.trans_amount) as qtps


from memberships
         left outer join transactions on transactions.trans_type=4 and transactions.trans_moc=memberships.id and transactions.deleted_at is null and transactions.debit_or_credit=1 and quarter(transactions.`date`)=$request->qt and YEAR(transactions.`date`)=$year
         left outer join trans_relations on invoice=transactions.id
         left outer join transactions as t on t.trans_type=4 and t.trans_amount!=0  and t.trans_moc=memberships.id and t.deleted_at is null and t.debit_or_credit=0 and t.id in (trans_relations.receipt)
         left outer join mem_statuses on mem_statuses.id=memberships.active
where memberships.deleted_at is null  and memberships.mem_category_id is not null and memberships.total_maintenance is not null $search  group by memberships.id order by memberships.id asc";

        $query2="select YEAR(transactions.`date`) as y from transactions where deleted_at is null and trans_moc_type=0  and trans_type=4 group by YEAR(transactions.`date`)";



    $membership=DB::select($query);
    $membership2=DB::select($query2);
    $co=membership::where('memberships.active','<>','7');
        if($request->searchid){
            $co->where('id',$request->searchid);

        }  if($request->fullname){
            $co->where('id',$request->fullname);

        }
      $co=  $co->count();

        $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->whereNotIn('id',[10,11])->get();

     return ['membership'=>$membership,'co'=>$co,'cm'=>$membership2, 'categories'=>$data['categories'],'stati'=>$data['stati']];
}

     public function maintenance_report(Request $request, membership $membership)
    {

       if($request->get('searchstatus')){
     $status=   mem_status::where('status',1)->whereNotIn('id',[10,11])->whereIn('id',$request->get('searchstatus'))->get();
}
  else{
        $status=   mem_status::where('status',1)->whereNotIn('id',[10,11])->get();
  }

     if($request->get('searchcat')){
     $categories=   mem_category::where('status',1)->whereIn('id',$request->get('searchcat'))->get();
}
  else{
        $categories=mem_category::where('status',1)->get();
  }

if($request->get('searchcat')){
$caties =$request->get('searchcat');
}
else{
$caties =[];
}


if($request->get('searchstatus')){
$staties =$request->get('searchstatus');
}
else{
$staties =[];
}


if($request->get('searchcard')){
$cardstaties =$request->get('searchcard');
}
else{
$cardstaties =[];
}



       $tableColumns=    $membership->getTableColumns();
        return view('backend/club-hospitality/membership/mem-maintenance')->withStatus($status)->withCat($categories)->withCati($caties)->withStati($staties)->withCardstati($cardstaties)->withColumns($tableColumns);
    }


     public function maintenance_report_dt(Request $request, membership $membership)
    {
        $member=membership::query();

        if($request->get('barcode')){
            $member->where('mem_barcode',$request->get('barcode'))->orWhereHas('family',function($m) use($request){
                $m->where('sup_barcode',$request->get('barcode'));
            });
        }

      if($request->get('searchid')){
            $member->where('id',$request->get('searchid'));
        }

        if($request->get('member_id')){
            $member->where('id',$request->get('member_id'));
        }

        if($request->get('membership_number')){
            $member->where('mem_no',$request->get('membership_number'));
        }

        if($request->get('name')){
            $member->where('applicant_name',$request->get('name'));
        }

        if($request->get('cnic')){
            $member->where('cnic',$request->get('cnic'));
        }

        if($request->get('contact')){
            $member->where('mob_a',$request->get('contact'));
        }

        if($request->get('car_number')){
            $member->whereHas('cars',function($m) use($request){
                $m->where('car_no',$request->get('car_number'));
            });
        }if($request->get('searchstatus')){

            $member->whereIn('active',explode(',',$request->get('searchstatus')));

        }
        if($request->get('searchcat')){

            $member->whereIn('mem_category_id',explode(',',$request->get('searchcat')));

        }
        if($request->get('searchcard')){
            $member->whereIn('card_status',explode(',',$request->get('searchcard')));

        }



//        if($request->get('barcode') ||
//            $request->get('member_id')||
//            $request->get('membership_number')||
//            $request->get('name')||
//            $request->get('contact')||
//            $request->get('car_number')){
//
////            $data['membershipdata'] = $member->withCount('family')->get();
//        }
//        else{
////            $data['membershipdata'] =[];
//
//        }


        $membership = $member->with(['transactions'=>function($query){
            $query->where('trans_type',4);
            $query->where('debit_or_credit',1);
        }])->get();
//dd($membership->toArray()[0]['transactions']);
       return DataTables::of($membership)



            ->addColumn('active', function ($membership) {
              if($membership->member_status){
//                   $status=mem_status::where('id',$membership->active)->first();

                  return ['datamy'=>$membership->member_status->desc];
              }
              else
              {
                return '';
              }

            })
            ->addColumn('quater1', function ($membership) {
                $data=$membership->transactions;
                $x='';
//$rid='';
                foreach($data as $c){
//                    $paymentDate = date('Y-m-d');
                $color="danger";
                    $paymentDate=date('Y-m-d', strtotime($c->date));
//echo $paymentDate; // echos today!
                    $contractDateBegin = date('Y-m-d', strtotime(date('Y-01-01')));
                    $contractDateEnd = date('Y-m-d', strtotime(date('Y-03-31')));
                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    foreach($c->receipts as $r){

                        $color=$c['trans_amount']==$r->receiptDetails->trans_amount?'success':'danger';
                        $rid=' -('.$r->receiptDetails->receipt_id.') '.$r->receiptDetails->trans_amount;
                    }
                        $x=$x. '<span class="text-'.$color.'">('.$c['trans_type_id'].') '.$c['trans_amount'].(isset($rid)?$rid:'').'</span><br>';

                    }
                }
                return $x;

            })
            ->addColumn('quater2', function ($membership) {
                $data=$membership->transactions;
                $x= "";                $color="danger";

                foreach($data as $c){
//                    $paymentDate = date('Y-m-d');
                    $paymentDate=date('Y-m-d', strtotime($c->date));

//echo $paymentDate; // echos today!
                    $contractDateBegin = date('Y-m-d', strtotime(date('Y-04-01')));
                    $contractDateEnd = date('Y-m-d', strtotime(date('Y-06-30')));

                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                        foreach($c->receipts as $r){

                            $color=$c['trans_amount']==$r->receiptDetails->trans_amount?'success':'danger';
                            $rid=' -('.$r->receiptDetails->receipt_id.') '.$r->receiptDetails->trans_amount;

                        }
                        $x=$x. '<span class="text-'.$color.'">('.$c['trans_type_id'].') '.$c['trans_amount'].(isset($rid)?$rid:'').'</span><br>';
                    }

                }
                return $x;

            })->addColumn('quater3', function ($membership) {
                $data=$membership->transactions;
               $x= "";                $color="danger";

               foreach($data as $c){
//                    $paymentDate = date('Y-m-d');
                    $paymentDate=date('Y-m-d', strtotime($c->date));

 // echos today!
                    $contractDateBegin = date('Y-m-d', strtotime(date('Y-07-01')));
                    $contractDateEnd = date('Y-m-d', strtotime(date('Y-09-30')));
                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){

                        foreach($c->receipts as $r){

                            $color=$c['trans_amount']==$r->receiptDetails->trans_amount?'success':'danger';
                            $rid=' -('.$r->receiptDetails->receipt_id.') '.$r->receiptDetails->trans_amount;

                        }
                        $x=$x. '<span class="text-'.$color.'">('.$c['trans_type_id'].') '.$c['trans_amount'].(isset($rid)?$rid:'').'</span><br>';
                    }
                }
                return $x;

            })->addColumn('quater4', function ($membership) {

                $data=$membership->transactions;
               $x='';                $color="danger";


               foreach($data as $c){
//                    $paymentDate = date('Y-m-d');
                    $paymentDate=date('Y-m-d', strtotime($c->date));

//echo $paymentDate; // echos today!
                    $contractDateBegin = date('Y-m-d', strtotime(date('Y-10-01')));
                    $contractDateEnd = date('Y-m-d', strtotime(date('Y-12-31')));
                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                        foreach($c->receipts as $r){

                            $color=$c['trans_amount']==$r->receiptDetails->trans_amount?'success':'danger';
                            $rid=' -('.$r->receiptDetails->receipt_id.') '.$r->receiptDetails->trans_amount;


                        }
                        $x=$x. '<span class="text-'.$color.'">('.$c['trans_type_id'].') '.$c['trans_amount'].(isset($rid)?$rid:'').'</span><br>';
                    }
                }
               return $x;
            })












        ->addColumn('membership_date', function ($membership) {
              return formatDateToShow($membership->membership_date);


                })

          ->addColumn('name', function ($membership) {
              return $membership->title.' '.$membership->first_name.' '.$membership->middle_name.' '.$membership->applicant_name;
            })





            ->rawColumns(['quater1', 'quater2', 'quater3', 'active','quater4','mem_no', 'name',])
            ->addIndexColumn()
            ->make(true);
    }



      public function activities_index_vue(Request $request, membership $membership)
    {
       return view('backend/finance-and-management/member-activities/member-activities-vue');
    }

       public function activities_init_vue(Request $request)
    {

     $search='';
        $search2='';
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
    }  if($request->get('mocid')!=0){
        $search.=" and transactions.trans_moc = '$request->mocid' ";
        $search2.=" and transactions.trans_moc = '$request->mocid' ";
    }
        $search.=" and transactions.trans_moc_type = '$request->moc' ";
        $search2.=" and transactions.trans_moc_type = '$request->moc' ";

  $data['ledgers'] =\Illuminate\Support\Facades\DB::select("select transactions.date,
       transactions.trans_type_id,
       transactions.trans_amount,
       transactions.debit_or_credit,
       sum(if(transactions.debit_or_credit = 0,transactions.trans_amount,0)) as debitamt,
       sum(if(transactions.debit_or_credit = 1,transactions.trans_amount,0)) as creditamt,



       transactions.receipt_id,

count(transactions.id) as totalinvoices,

      if(transactions.trans_moc_type = 0,
          CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
                 coalesce(memberships.middle_name, ''), ' ',
                 coalesce(memberships.applicant_name, '')), if(transactions.trans_moc_type = 1,
          customers.customer_name, if(transactions.trans_moc_type = 2, finance_ledger_people.person_name,hr_employments.name))) as name,
      transactions.trans_moc_type                      as type
        ,
       trans_types.name                                 as type_name,

    sum(if(transactions.trans_type = 1 and transactions.debit_or_credit = 1,room_bookings.nights,0)) as detail_night,
    sum(if(transactions.trans_type = 5 and transactions.debit_or_credit = 1,fnb_sales.covers,0)) as detail_cover,
    sum(if(transactions.trans_type = 2 and transactions.debit_or_credit = 1,event_bookings.guests,0)) as detail_guest,
    sum(if(transactions.trans_type = 2 and transactions.debit_or_credit = 1,event_bookings.extra_guests,0)) as detail_ext_guest,
    sum(if(trans_types.type = 3 and transactions.debit_or_credit = 1 or trans_types.id=4 and transactions.debit_or_credit = 1,finance_invoices.days,0)) as detail_days,
    sum(if(trans_types.id=3 and transactions.debit_or_credit = 1,finance_invoices.grand_total,0)) as detail_total

from transactions

        left outer join trans_types on trans_types.id = transactions.trans_type
        left outer join memberships on memberships.id = transactions.trans_moc and transactions.trans_moc_type = 0
        left outer join customers on customers.id = transactions.trans_moc and transactions.trans_moc_type = 1
        left outer join finance_ledger_people on finance_ledger_people.id = transactions.trans_moc and transactions.trans_moc_type=2
        left outer join hr_employments
                         on hr_employments.id = transactions.trans_moc and transactions.trans_moc_type = 3
  left outer join room_bookings on room_bookings.id = transactions.trans_type_id
  left outer join fnb_sales on fnb_sales.id = transactions.trans_type_id
  left outer join event_bookings on event_bookings.id = transactions.trans_type_id
  left outer join finance_invoices on finance_invoices.id = transactions.trans_type_id

where transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.type!=3 $search  group by transactions.trans_type order by `date` asc");
//echo "select (sum(if(debit_or_credit=0,trans_amount,0))-sum(if(debit_or_credit=1,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.trans_type<90 $search2  ";

  // transactions.trans_type<90
  // 

        $data['opening'] =\Illuminate\Support\Facades\DB::select("select (sum(if(debit_or_credit=0,trans_amount,0))-sum(if(debit_or_credit=1,trans_amount,0))) as opening from transactions where  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0) and transactions.type!=3 $search2  ")[0];
        $data['filters']=trans_type::all();
     return $data;

}





       public function card_vue(Request $request, membership $membership)
    {
         return view('backend/finance-and-management/member-card-detail/member-card-detail-vue');
    }

       public function card_init_vue(Request $request)
    {

        $search ='';

        if($request->category){
            $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }   if($request->status){
            $search.=' and memberships.active in ('.$request->status.') ';
        }
        if($request->r){


  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select
       mem_categories.desc                               as cat,
    sum(if(memberships.card_status = "Issued",1,0)) as issued,
    sum(if(memberships.card_status = "Printed",1,0)) as printed,
    sum(if(memberships.card_status = "Re-Printed",1,0)) as reprinted,
    sum(if(memberships.card_status = "In-Process",1,0)) as pending,
    count(memberships.id) as applied

from memberships
        left outer join mem_categories on mem_categories.id=memberships.mem_category_id

where memberships.deleted_at is null and memberships.id is not null and  memberships.active!=7 '.$search.'
group by memberships.mem_category_id
order by cat asc');

        }

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->get();

     return $data;
}



       public function summary_vue(Request $request, membership $membership)
    {
         return view('backend/finance-and-management/member-card-detail/supplementary-card-detail-vue');
    }

       public function summary_init_vue(Request $request)
    {
        $search ='';
        $search2 ='';

        if($request->category){
            $search.=' and memberships.mem_category_id in ('.$request->category.') ';
        }   if($request->status){
            $search2.=' and mem_families.status in ('.$request->status.') ';
        }
        if($request->r){


  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select
       mem_categories.desc                               as cat,
    sum(if(mem_families.card_status = "Issued",1,0)) as issued,
    sum(if(mem_families.card_status = "Printed",1,0)) as printed,
    sum(if(mem_families.card_status = "Re-Printed",1,0)) as reprinted,
    sum(if(mem_families.card_status = "Applied",1,0)) as applied

from memberships
        left outer join mem_categories on mem_categories.id=memberships.mem_category_id
        left outer join mem_families on mem_families.id=memberships.id '.$search2.'

where memberships.deleted_at is null and memberships.id is not null and  memberships.active!=7 '.$search.'
group by memberships.mem_category_id
order by cat asc');

        }

  $data['categories']= mem_category::where('status',1)->get();
  $data['stati']= mem_status::where('status',1)->get();

     return $data;
}



}

