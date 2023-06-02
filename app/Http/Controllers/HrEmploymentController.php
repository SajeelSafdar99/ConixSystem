<?php

namespace App\Http\Controllers;

use App\employment_in_out;
use App\hr_employment;
use App\hr_employments_subs;
use App\membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use DataTables;
use App\hr_company;
use App\hr_department;
use App\hr_sub_department;
use App\media;
use App\exports\attend;
use App\hr_salary_add_on;
use App\admin_company_profile;
use Maatwebsite\Excel\Facades\Excel;

use App\finance_payment_receipt;
use App\transactions;
use App\trans_relations;
use App\trans_type;
use App\hr_employee_salaries;
use App\User;
use App\hr_salary_deduction;
use App\hr_employments_deduction_subs;
use App\coa_account;

class HrEmploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function pay_salary(Request $request){
//        dd($request->all());
         $d=[];
        
        $d['employee_id']=$request->get('employee_id');
        $d['current_salary']=$request->get('current_salary');
        $d['working_days']=$request->get('working_days');
        $d['overtime_days']=$request->get('overtime_days');
        $d['total_salary']=$request->get('total_salary');
        $d['payable_salary']=$request->get('payable_salary');
        $d['hours']=$request->get('hours');
        $d['pay_date']=formatDate($request->get('pay_date'));
      $id=  hr_employee_salaries::create($d);
//      dd();

        $transaction = transactions::create([
        'debit_or_credit' =>  0,
        'trans_type' =>  9,
        'trans_type_id' =>  $id->id,
        'trans_amount' =>  $request->get('payable_salary'),
        'trans_moc_type' =>  3,
        'trans_moc' =>  $request->employee_id,
        'date' =>  formatDate($request->pay_date)
        ]);

         return $id->id;
    }



       public function index_vue(Request $request, hr_employment $hr_employment)
    {
        return view('backend/human-resource/employment/employment-vue');
    }

       public function init_vue(Request $request)
    {
  $data['employees'] =\Illuminate\Support\Facades\DB::select(

      'select hr_employments.* , media.url as image,
  users.name as cashiername,
  coa_accounts.name as company,
  hr_departments.desc as department,
  hr_sub_departments.desc as subdepartment


FROM hr_employments

left outer join users on users.id =hr_employments.created_by and users.status=1
left outer join media on media.type=50 and media.type_id=hr_employments.id and media.deleted_at is null
 left outer join coa_accounts
                         on coa_accounts.code = hr_employments.company
                         left outer join hr_departments
                         on hr_departments.id = hr_employments.department
                         left outer join hr_sub_departments
                         on hr_sub_departments.id = hr_employments.subdepartment

where hr_employments.deleted_at is null group by hr_employments.id order by hr_employments.id desc');

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();

     return $data;
}



      public function salary_vue(Request $request, hr_employment $hr_employment)
    {
        return view('backend/human-resource/employment/salary-vue');
    }

       public function salary_init_vue(Request $request)
    {
  $data['employees'] =\Illuminate\Support\Facades\DB::select(

      'select hr_employee_salaries.id,
       hr_employee_salaries.current_salary,
       hr_employee_salaries.pay_date,
       hr_employee_salaries.working_days,
       hr_employee_salaries.overtime_days,
       hr_employee_salaries.payable_salary as grand_total,


  hr_employments.name as name,
  hr_employments.id as employeeid,
  hr_employments.cnic as cnic,
  hr_employments.mob_a as mob_a,
  hr_employments.barcode as barcode,

  sum(distinct transactions.trans_amount ) as paid_amount, 
  GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,
(t1.is_active) as is_active,
(t1.id) as transid

FROM hr_employee_salaries

left outer join hr_employments on hr_employments.id=hr_employee_salaries.employee_id and hr_employments.deleted_at is null
left outer join transactions as t1 on t1.trans_type=9 and t1.trans_type_id=hr_employee_salaries.id and t1.debit_or_credit=0 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=9 and transactions.trans_type_id=hr_employee_salaries.id and transactions.debit_or_credit=1 and transactions.deleted_at is null

where hr_employee_salaries.deleted_at is null group by hr_employee_salaries.id order by hr_employee_salaries.id desc');

     return $data;
}




      public function attend_vue(Request $request, hr_employment $hr_employment)
    {
       return view('backend/human-resource/employment/employee-attend-vue');
    }

       public function attend_init_vue(Request $request)
    {
        $data=[];
 $employees=hr_employment::query();
        $count=0;
   $depts= hr_department::where('status',1)->get();
        if($request->get('start_date') && $request->get('end_date')){
            $now =strtotime(formatDate($request->get('end_date'))); // or your date as well
            $your_date = strtotime(formatDate($request->get('start_date')));
            $datediff = $now - $your_date;

            $data['count']= round($datediff / (60 * 60 * 24));
        }
    if($request->get('dept') ){
        $employees->where('department',$request->get('dept'));
    }
    $data['employees']= $employees->with(['visits'=>function($query) use($request){
        $start_date=$request->get('start_date');
        $end_date=$request->get('end_date');
//        echo"Date(created_at) between '$start_date' and '$end_date'";
        $query->whereRaw("Date(created_at) between '$start_date' and '$end_date'");

    }])->get();

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();

     return $data;
}

 
      public function foodbills_vue(Request $request, hr_employment $hr_employment)
    {
       return view('backend/finance-and-management/monthly-reports/food-bills-vue');
    }


       public function foodbills_init_vue(Request $request)
    {
        $data=[];
             
 $employees=hr_employment::query();
        $count=0;


   $depts= hr_department::where('status',1)->get();
        if($request->get('start_date') && $request->get('end_date')){
            $now =strtotime(formatDate($request->get('end_date'))); // or your date as well
            $your_date = strtotime(formatDate($request->get('start_date')));
            $datediff = $now - $your_date;

            $data['count']= round($datediff / (60 * 60 * 24));
        }
    if($request->get('dept') ){
        $employees->where('department',$request->get('dept'));
    }

     $search ='';


    $data['employees']= $employees->with(['foodbills'=>function($query) use($request){
        $start_date=$request->get('start_date');
        $end_date=$request->get('end_date');
 
  if($request->get('ent')=='Include ENT and CTS'){
        $search=' and ent is not null' ;
        }
          if($request->get('ent')=='Exclude ENT and CTS'){
        $search='and ent=0';
        }
   if($request->get('ent')=='Only ENT'){
        $search='and ent=1';
        }
         if($request->get('ent')=='Only CTS'){
        $search='and ent=2';
        }

        $query->whereRaw('Date(created_at) between "'.$start_date.'" and "'.$end_date.'" and type=3  '.$search.' ');

    }])->get();

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();

     return $data;
}


   public function totalfoodbills_vue(Request $request, hr_employment $hr_employment)
    {
       return view('backend/finance-and-management/monthly-reports/total-food-bills-vue');
    }


       public function totalfoodbills_init_vue(Request $request)
    {
        $data=[];
             
 $employees=hr_employment::query();
        $count=0;


   $depts= hr_department::where('status',1)->get();
        if($request->get('start_date') && $request->get('end_date')){
            $now =strtotime(formatDate($request->get('end_date'))); // or your date as well
            $your_date = strtotime(formatDate($request->get('start_date')));
            $datediff = $now - $your_date;

            $data['count']= round($datediff / (60 * 60 * 24));
        }
    if($request->get('dept') ){
        $employees->where('department',$request->get('dept'));
    }

     $search ='';


    $data['employees']= $employees->with(['foodbills'=>function($query) use($request){
        $start_date=$request->get('start_date');
        $end_date=$request->get('end_date');
 
  if($request->get('ent')=='Include ENT and CTS'){
        $search=' and ent is not null' ;
        }
          if($request->get('ent')=='Exclude ENT and CTS'){
        $search='and ent=0';
        }
   if($request->get('ent')=='Only ENT'){
        $search='and ent=1';
        }
         if($request->get('ent')=='Only CTS'){
        $search='and ent=2';
        }

        $query->selectRaw('*,0 as tata')->whereRaw('Date(created_at) between "'.$start_date.'" and "'.$end_date.'" and type=3  '.$search.' ');

    }])->get();

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();

     return $data;
}



      public function daily_vue(Request $request, hr_employment $hr_employment)
    {
       return view('backend/human-resource/employment/employee-daily-attend-vue');
    }
 
       public function daily_init_vue(Request $request)
    {
        $data=[];
 $employees=hr_employment::query();
        $count=0;
   $depts= hr_department::where('status',1)->get();
        if($request->get('start_date') && $request->get('end_date')){
            $now =strtotime(formatDate($request->get('end_date'))); // or your date as well
            $your_date = strtotime(formatDate($request->get('start_date')));
            $datediff = $now - $your_date;

            $data['count']= round($datediff / (60 * 60 * 24));
        }
    if($request->get('dept') ){
        $employees->where('department',$request->get('dept'));
    }
    $data['employees']= $employees->with(['visits'=>function($query) use($request){
        $start_date=$request->get('start_date');
        $end_date=$request->get('end_date');
//        echo"Date(created_at) between '$start_date' and '$end_date'";
        $query->whereRaw("Date(created_at) between '$start_date' and '$end_date'");

    }])->get();

$data['departments']=hr_department::where('status',1)->get();
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();

     return $data;
}



      public function payroll_vue(Request $request, hr_employment $hr_employment)
    {
       return view('backend/human-resource/employment/employee-payroll-vue');
    }

       public function payroll_init_vue(Request $request)
    {
        $data=[];
        $start_date=$request->get('start_date');
        $end_date=$request->get('end_date');
 $employees=DB::select("select c.*, count( distinct DATE(employment_in_out.in)) as visits,
       4 as adjusted,
       sec_to_time(sum(time_to_sec(timediff(employment_in_out.out,employment_in_out.in)))) as ctime,
       (sum(time_to_sec(timediff(employment_in_out.out,employment_in_out.in)))/3600) as ctime2  ,
       (sec_to_time
           (sum(
                       if((time_to_sec(timediff(employment_in_out.out, employment_in_out.in))) > (c.hour * 3600),
                          (time_to_sec(timediff(employment_in_out.out, employment_in_out.in))) - (c.hour * 3600),
                          0))))                                                             as overtime,
       sum(
                       if((time_to_sec(timediff(employment_in_out.out, employment_in_out.in))) > (c.hour * 3600),
                          1,
                          0)) as overtimeDays,
       sec_to_time(sum(c.hour*3600)) as thours,
       group_concat(timediff(employment_in_out.out, employment_in_out.in))                  as tt


from (select f.*,(f.cr-f.dr) as balance
           , group_concat(concat(hsa.desc, ': ', hes.charges_amount)) as charges_details ,sum(hes.charges_amount) as charges
      from (
               select hr_employments.name,
                      hr_employments.id                                  as id,

                      hr_employments.current_salary                      as csalary,
                      hr_employments.days                      as days,
                      hr_employments.hours                      as hour,
                      hr_employments.current_salary/hr_employments.days                      as perday,
                      (hr_employments.current_salary/hr_employments.days)/hr_employments.hours                     as perhour,


                      hr_employments.total_salary                        as tsalary,
                      group_concat(distinct  concat(tt.name, ':', t.trans_amount)) as usage_details,
                      sum(distinct if(t.debit_or_credit = 1 and trans_type!=33,t.trans_amount,0))                                as cr,
                      sum(distinct if(t.debit_or_credit = 1 and trans_type=33,t.trans_amount,0))                                as advance,
                      sum(distinct if(t.debit_or_credit = 0,t.trans_amount,0))                                as dr
               from hr_employments

                        left outer join transactions t on t.trans_moc_type = 3 and t.trans_moc = hr_employments.id and  t.date >= '$start_date'
  and t.date <= '$end_date'

                        left outer join trans_types tt on t.trans_type = tt.id
          group by hr_employments.id
           ) as f
               left outer join hr_employments_subs hes on hes.employee_id = f.id
               left outer join hr_salary_add_ons hsa on hsa.id = hes.addon
     ) as c
         left outer join  employment_in_out on employee_id = c.id and employment_in_out.in >= '$start_date'
            and employment_in_out.in <= '$end_date'

where 1=1
group by c.id");

$data['employees']=$employees;
$data['departments']=hr_department::where('status',1)->get();

     return $data;
}




 public function voucher(hr_employee_salaries $hr_employee_salaries,$id)
    {
       $data['receiptdata']=hr_employee_salaries::with('employee')->where('id',$id)->first();
       $data['profiledata']=admin_company_profile::get()->first();

        return view('backend/human-resource.employment.employment-voucher', $data);
    }




    public function index(Request $request, hr_employment $hr_employment)
    {

        return view('backend/human-resource/employment/employment');
    }


    public function indexdt(Request $request, hr_employment $hr_employment)
    {

        $employment = hr_employment::get();
        return DataTables::of($employment)
            ->addColumn('status', function ($employment) {
                if ($employment->active == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }



            })

            ->addColumn('picture', function ($employment) {

                return '<img style="width: 100px;" src="'.url('/').'/'.($employment->employeePic?$employment->employeePic->url:'').'"/>';
            })

            ->addColumn('editbutton', function ($employment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('human-resource/employment/employment-aeu/') . '/' . $employment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
             ->addColumn('deletebutton', function ($employment) {
                return ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('human-resource/employment/delete') . '/' . $employment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton','deletebutton', 'status','picture'])
         ->addIndexColumn()
            ->make(true);
    }



    public function index_deleted(Request $request, hr_employment $hr_employment)
    {
        return view('backend/human-resource/employment/employment-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, hr_employment $hr_employment)
    {
        $employment = hr_employment::onlyTrashed()->get();
        return DataTables::of($employment)

      ->addColumn('picture', function ($employment) {

                return '<img style="width: 100px;" src="'.url('/').'/'.($employment->employeePic?$employment->employeePic->url:'').'"/>';
            })

  ->addColumn('deleted_at', function ($employment) {
              return formatDateToShow($employment->deleted_at);


                }) 

            ->addColumn('restorebutton', function ($employment) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('human-resource/employment/restore/') . '/' . $employment->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton','picture'])
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
      $lastval=hr_employment::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=sprintf("%03d", $num);;

      }else{
        $num=1;
        $data['increment_number']=sprintf("%03d", $num);;
      }
       $data['init']                = 0;
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['departments']=hr_department::where('status',1)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['addons']=hr_salary_add_on::where('status',1)->get();
$data['deductions']=hr_salary_deduction::where('status',1)->get();
$data['types']=trans_type::all();
    $data['id']=$request->get('id');
     return view('backend.human-resource.employment.employment-aeu',$data);
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
    if(hr_employment::get()->last())
    {
      $lastval=hr_employment::get()->last();
 $num=$lastval->id+1;
    }


           $file = $request->file('picture');


        $save=$request->save;

      $this->validate($request,[
            'application_no' => 'required|unique:hr_employments,application_no',
            'name' => 'required',
            'father_name' => 'required',
            'cnic'     =>'required|unique:hr_employments,cnic',
            'gender'   =>'required',
            'age'   =>'required',
            //'license'=>'required',
           // 'license_no'=>'required',
            //'bank_details'   =>'required',
            //'vehicle_details'   =>'required',
            //'learn_of_org'=> 'required',
            //'anyone_in_org'=> 'required',
            'crime'    => 'required',
            //'crime_details'   =>'required',
            'active'=> 'required',
   /*         'picture'    => 'required',*/
             'mob_a'    => 'required',
             //'mob_b'    => 'required',
            // 'tel_a'=> 'required',
            //'tel_b'    => 'required',
            // 'email'=>'required|email',
            'cur_address'   =>'required',
             'cur_city'    => 'required',
             'cur_country'   =>'required',
             //'per_address'    => 'required',
            // 'per_city'   =>'required',
             //'per_country'    => 'required',
        

             //'level_b'   =>'required',
             //'course_b'    => 'required',
            // 'years_b'   =>'required',
            // 'type_b'    => 'required',
             //'level_c'   =>'required',
            // 'course_c'    => 'required',
            // 'years_c'   =>'required',
            // 'type_c'    => 'required',
         /*    'company_name_a'   =>'required',
             'hod_a'    => 'required',
              'company_add_a'   =>'required',
             'company_tel_a'    => 'required',
              'work_a'   =>'required',
             'employed_from_a'    => 'required',
              'employed_to_a'   =>'required',
             'salary_a'    => 'required',
              'leaving_reason_a'   =>'required',
               'company_name_b'   =>'required',
             'hod_b'    => 'required',
              'company_add_b'   =>'required',
             'company_tel_b'    => 'required',
              'work_b'   =>'required',
             'employed_from_b'    => 'required',
              'employed_to_b'   =>'required',
               'salary_b'   =>'required',
             'leaving_reason_b'    => 'required',*/
            

             'company'    => 'required',
             'department'    => 'required',
             'subdepartment'    => 'required',

             'designation'   =>'required',
               'date_of_joining'    => 'required',
             'barcode'    => 'required|unique:hr_employments,barcode',
             'current_salary'    => 'required',
             'total_salary'    => 'required',
             'days'    => 'required',
             'hours'    => 'required',
             // 'remarks'   =>'required' 
            ]);



       $employment=hr_employment::create([
        'application_no' => $request->application_no,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic'     =>$request->cnic,
            'gender'   =>$request->gender,
            'age'   =>$request->age,
            'license'=> $request->license,
            'license_no'=>$request->license_no,
            'bank_details'   =>$request->bank_details,
           'vehicle_details'   =>$request->vehicle_details,
            'learn_of_org'=> $request->learn_of_org,
            'anyone_in_org'=> $request->anyone_in_org,
            'crime'    => $request->crime,
            'crime_details'   =>$request->crime_details,
            'active'=> $request->active,
           'picture'    => $request->picture,
             'mob_a'    => $request->mob_a,
             'mob_b'    => $request->mob_b,
             'tel_a'=>$request->tel_a,
            'tel_b'    => $request->tel_b,
             'email'=>$request->email,
            'cur_address'   =>$request->cur_address,
             'cur_city'    => $request->cur_city,
             'cur_country'   =>$request->cur_country,
             'per_address'    => $request->per_address,
             'per_city'   =>$request->per_city,
             'per_country'    => $request->per_country,

              'remarks'   => $request->remarks,
              'company'    => $request->company,
              'department'    => $request->department,
              'subdepartment'    => $request->subdepartment,

              'designation'   => $request->designation,
              'date_of_joining'   => formatDate($request->date_of_joining),
              'current_salary'    => $request->current_salary,
              'barcode'   => $request->barcode,
               'total_addon_charges'    => $request->total_addon_charges,
               'total_deduction_charges'    => $request->total_deduction_charges,
              'total_salary'    => $request->total_salary,
               'days'    => $request->days,
                'hours'    => $request->hours,
              'account'    => $request->account,
            ]);


     $addons=$request->addon;
/*        $transtype=$request->trans_type;*/
        $details=$request->details;
        $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new hr_employments_subs;
            $ta->employee_id = $employment->id;
            $ta->details = $details[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->addon=$addons[$i];
/*            $ta->trans_type=$transtype[$i];*/
            $ta->save();
            $i++;
        }

     


     $deds=$request->deduction;
        $detail=$request->detail;
        $charges=$request->charges;
          $i=0;
        foreach ($charges as $chargesamt => $char_amt) {
            $ta = new hr_employments_deduction_subs;
            $ta->employee_id = $employment->id;
            $ta->details = $detail[$i];
            $ta->charges_amount = $charges[$i];
            $ta->deduction=$deds[$i];
            $ta->save();
            $i++;
        }

         


            if($employment)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
                $getlastinsert=$employment->id;


            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
            }


if($file){
      $employment->employeePic()->updateOrCreate(['url'=>saveFile($file),'type'=>50]);
}
        
            //echo $message;
          if($getlastinsert==0){
          return redirect('human-resource/employment/employment-aeu');
          }else{
          return redirect('human-resource/employment/employment-docs-aeu/'.$getlastinsert);
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
     * @param  \App\hr_employment  $hr_employment
     * @return \Illuminate\Http\Response
     */
    public function show(hr_employment $hr_employment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hr_employment  $hr_employment
     * @return \Illuminate\Http\Response
     */
    public function edit(hr_employment $hr_employment,$id)
    {
        $data['employment_update'] = hr_employment::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['employment_update']->code;
 $data['companies']=coa_account::where('status',1)->where('desc',null)->get();
$data['departments']=hr_department::where('status',1)->get();
$data['subdepartments']=hr_sub_department::where('status',1)->get();
$data['addons']=hr_salary_add_on::where('status',1)->get();
$data['deductions']=hr_salary_deduction::where('status',1)->get();
$data['types']=trans_type::all();

       $data['sub']=hr_employment::with('addons')->where('id', $id)->get();
       $data['subdata']=$data['sub'][0]['addons'];


        $data['subs']=hr_employment::with('deductions')->where('id', $id)->get();
       $data['subdatatwo']=$data['subs'][0]['deductions'];

        return view('backend/human-resource.employment.employment-aeu', $data);
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


        $this->validate($request, [
            'application_no' => 'required|unique:hr_employments,application_no,'.$id,
            'name' => 'required',
            'father_name' => 'required',
            'cnic'     =>'required|unique:hr_employments,cnic,'.$id,
            'gender'   =>'required',
            'age'   =>'required',
            //'license'=>'required',
           // 'license_no'=>'required',
           // 'bank_details'   =>'required',
            //'vehicle_details'   =>'required',
            //'learn_of_org'=> 'required',
            //'anyone_in_org'=> 'required',
            'crime'    => 'required',
            //'crime_details'   =>'required',
            'active'=> 'required',
           // 'picture'    => 'required',
             'mob_a'    => 'required',
             //'mob_b'    => 'required',
            // 'tel_a'=> 'required',
            //'tel_b'    => 'required',
            // 'email'=>'required|email',
            'cur_address'   =>'required',
             'cur_city'    => 'required',
             'cur_country'   =>'required',
             //'per_address'    => 'required',
            // 'per_city'   =>'required',
             //'per_country'    => 'required',
         
             //'level_b'   =>'required',
             //'course_b'    => 'required',
            // 'years_b'   =>'required',
            // 'type_b'    => 'required',
             //'level_c'   =>'required',
            // 'course_c'    => 'required',
            // 'years_c'   =>'required',
            // 'type_c'    => 'required',
         /*    'company_name_a'   =>'required',
             'hod_a'    => 'required',
              'company_add_a'   =>'required',
             'company_tel_a'    => 'required',
              'work_a'   =>'required',
             'employed_from_a'    => 'required',
              'employed_to_a'   =>'required',
             'salary_a'    => 'required',
              'leaving_reason_a'   =>'required',
               'company_name_b'   =>'required',
             'hod_b'    => 'required',
              'company_add_b'   =>'required',
             'company_tel_b'    => 'required',
              'work_b'   =>'required',
             'employed_from_b'    => 'required',
              'employed_to_b'   =>'required',
               'salary_b'   =>'required',
             'leaving_reason_b'    => 'required',*/
          
             'company'    => 'required',
             'department'    => 'required',
             'subdepartment'    => 'required',

             'designation'   =>'required',
  'date_of_joining'    => 'required',
             'barcode'    => 'required|unique:hr_employments,barcode,'.$id,
              'current_salary'    => 'required',
              'total_salary'    => 'required',
              'days'    => 'required',
              'hours'    => 'required',
             // 'remarks'   =>'required'
          ]);
       $s=hr_employment::find($id)->updateEmployeePic;
        foreach($s as $m){
            $m->delete();
        }

        $updateimg='';
        if ($request->hasFile('picture')) {
            $updateimg=$request->file('picture');
            $updateimg=saveFile($updateimg,'employeeupload');
        }else{
            $updateimg=$request->existimg;
        }

        $employment = hr_employment::find($id);
         $employee = hr_employment::where('id', $id)->updateWithUserstamps([
               'application_no' => $request->application_no,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic'     =>$request->cnic,
            'gender'   =>$request->gender,
            'age'   =>$request->age,
            'license'=> $request->license,
            'license_no'=>$request->license_no,
            'bank_details'   =>$request->bank_details,
            'vehicle_details'   =>$request->vehicle_details,
            'learn_of_org'=> $request->learn_of_org,
            'anyone_in_org'=> $request->anyone_in_org,
            'crime'    => $request->crime,
            'crime_details'   =>$request->crime_details,
            'active'=> $request->active,
           'picture'    => $request->picture,
             'mob_a'    => $request->mob_a,
             'mob_b'    => $request->mob_b,
             'tel_a'=>$request->tel_a,
            'tel_b'    => $request->tel_b,
             'email'=>$request->email,
            'cur_address'   =>$request->cur_address,
             'cur_city'    => $request->cur_city,
             'cur_country'   =>$request->cur_country,
             'per_address'    => $request->per_address,
             'per_city'   =>$request->per_city,
             'per_country'    => $request->per_country,

              'remarks'   => $request->remarks,
              'company'    => $request->company,
              'department'    => $request->department,
              'subdepartment'    => $request->subdepartment,

              'designation'   => $request->designation,
              'date_of_joining'   => formatDate($request->date_of_joining),
              'current_salary'    => $request->current_salary,
              'barcode'   => $request->barcode,
              'total_addon_charges'    => $request->total_addon_charges,
              'total_deduction_charges'    => $request->total_deduction_charges,
              'total_salary'    => $request->total_salary,
               'days'    => $request->days,
                'hours'    => $request->hours,
                'account'    => $request->account,
        ]);

         if($updateimg){
             $employment->employeePic()->updateOrCreate(['url'=>($updateimg),'type'=>50]);
         }
       

         $datadel= hr_employments_subs::where('employee_id', $id)->delete();

if($datadel){

         $addons=$request->addon;
/*         $transtype=$request->trans_type;*/
         $details=$request->details;
         $chargesamount=$request->charges_amount;

          $i=0;
        foreach ($chargesamount as $chargesamt => $char_amt) {

            $ta = new hr_employments_subs;
             $ta->employee_id=$id;
             $ta->details = $details[$i];
            $ta->charges_amount = $chargesamount[$i];
            $ta->addon=$addons[$i];
       /*     $ta->trans_type=$transtype[$i];*/
            $ta->save();
            $i++;
        }
    }



      $datadels= hr_employments_deduction_subs::where('employee_id', $id)->delete();
if($datadels){
         $deduction=$request->deduction;
         $detail=$request->detail;
         $charges=$request->charges;
         $i=0;
      foreach ($charges as $chargesamt => $char_amt) {
            $ta = new hr_employments_deduction_subs;
             $ta->employee_id=$id;
             $ta->details = $detail[$i];
            $ta->charges_amount = $charges[$i];
            $ta->deduction=$deduction[$i];
            $ta->save();
            $i++;
      }
    }

        if ($employee) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('human-resource/employment/employment-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hr_employment  $hr_employment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,hr_employment $hr_employment,$id)
    {
      $update= hr_employment::where('id',$id)->updateWithUserstamps([
        'remarks' => $request->remarks,
     ]);
      $delete=$hr_employment::where('id', $id)->deleteWithUserstamps();
    }
   /* public function destroy(hr_employment $hr_employment,$id)
    {
        $employment=$hr_employment::where('id', $id)->deleteWithUserstamps();
        if($employment){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('human-resource/employment');
    }*/

    public function restore(hr_employment $hr_employment,$id)
    {
        $restore = hr_employment::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/employment/deleted');

}
public function checkin(){
        $data['type']=0;
    return view('backend/human-resource.employment.employe-check-in-out', $data);

}
public function checkout(){
    $data['type']=1;
    return view('backend/human-resource.employment.employe-check-in-out', $data);
}
public function checkoutsave(Request $request){
    $data['type']=1;
    $em=hr_employment::where('barcode',$request->get('barcode'))->first();

    if($em){
        $date=date('Y-m-d H:i:s',time());
        if($request->get('checkdate')){
//                dd(($request->get('checkdate')));
            $date=date('Y-m-d H:i:s',strtotime(($request->get('checkdate'))));

        }
    $ch=$em->visits()->whereRaw("DATE(`in`) = '".date('Y-m-d',strtotime($date))."'")->orderBy('id','desc')->first();
//    dd($ch);
        $d=[];
        if(($ch) ){
            if($ch->out!=null){

                $data['error']=2;
            }
            else{
                $ch->out=$date;
                $ch->save();
                $data['employee']=$em;
            }


        }else{
            $ch=$em->visits()->orderBy('id','desc')->first();
            if($ch->out!=null){

                $data['error']=2;
            }
            else{
                $ch->out=$date;
                $ch->save();
                $data['employee']=$em;

            }
            //$start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');


        // dd($hourCount);
          //  $d['workingHours']=$hourCount;




    }
    }
else{
        $data['error']=1;

    }

    return view('backend/human-resource.employment.employe-check-in-out', $data);
}
public function checkinsave(Request $request){
    $em=hr_employment::where('barcode',$request->get('barcode'))->first();
    if($em){
$date=date('Y-m-d H:i:s',time());
        if($request->get('checkdate')){
//                dd(($request->get('checkdate')));
            $date=date('Y-m-d H:i:s',strtotime(($request->get('checkdate'))));

        }

        $ch=$em->visits()->where('in',$date)->orderBy('id','desc')->first();

        if(($ch) && $ch->out==null){
            $data['error']=2;
        }else {
           $d=[];
                $d['in']=$date;



//            dd($d);
            $em->visits()->create($d);
            $data['employee']=$em;
        }
    }
    else{
        $data['error']=1;

    }

    $data['type']=0;

    return view('backend/human-resource.employment.employe-check-in-out', $data);
}
public function attend(Request $request){
        $employees=hr_employment::query();
        $count=0;
   $depts= hr_department::where('status',1)->get();
        if($request->get('start_date') && $request->get('end_date')){
            $now =strtotime(formatDate($request->get('end_date'))); // or your date as well
            $your_date = strtotime(formatDate($request->get('start_date')));
            $datediff = $now - $your_date;

            $count= round($datediff / (60 * 60 * 24));
        }
    if($request->get('dept') ){
        $employees->where('department',$request->get('dept'));
    }
    $employees= $employees->get();
//        echo $count;
    return view('backend/human-resource.employment.employee-attend')->withEmployees($employees)->withCount($count)->withDepts($depts);

}
 public function export(){

    ob_end_clean(); 
     ob_start();
     return Excel::download(new attend,'attend.xlsx');

    }

     function department($id){
     if($id!=0){
        $name=hr_department::where('company',$id)->orderBy('desc')->get();
     }
     else{
         $name=hr_department::orderBy('desc')->get();
     }
        return $name;
    }
    function visits(){
       $d= employment_in_out::all()->keyBy('created_at');
       return $d;
    }


     function subdepartment($id){
     if($id!=0){
        $name=hr_sub_department::where('department',$id)->orderBy('desc')->get();
     }
     else{
         $name=hr_sub_department::orderBy('desc')->get();
     }
        return $name;
    }


    public function index_deleted_voucher(Request $request, hr_employee_salaries $hr_employee_salaries)
    {
      return view('backend/human-resource/employment/salary-deleted-vue');
    }

    public function indexdt_deleted_voucher(Request $request)
    {
      $data['employees'] =\Illuminate\Support\Facades\DB::select(
           'select hr_employee_salaries.id,
       hr_employee_salaries.current_salary,
       hr_employee_salaries.pay_date,
       hr_employee_salaries.working_days,
       hr_employee_salaries.overtime_days,
       hr_employee_salaries.payable_salary as grand_total,
       hr_employee_salaries.deleted_at,
       hr_employee_salaries.deleted_by,


  hr_employments.name as name,
  hr_employments.id as employeeid,
  hr_employments.cnic as cnic,
  hr_employments.mob_a as mob_a,
  hr_employments.barcode as barcode

FROM hr_employee_salaries

left outer join hr_employments on hr_employments.id=hr_employee_salaries.employee_id and hr_employments.deleted_at is null

where hr_employee_salaries.deleted_at is not null group by hr_employee_salaries.id order by hr_employee_salaries.id desc');

  $data['users']= User::where('status',1)->get();
     return $data;
}


  public function destroy_voucher(hr_employee_salaries $hr_employee_salaries,$id)
    {

        $destroy=$hr_employee_salaries::where('id', $id)->deleteWithUserstamps();
        $transaction = transactions::where('debit_or_credit',0)->where('trans_type', 9)->where('trans_type_id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('human-resource/employment/salary-vue');
    }
public function restore_voucher(hr_employee_salaries $hr_employee_salaries,$id)
    {
        $restore = hr_employee_salaries::onlyTrashed()->find($id)->restore();
        $transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type', 9)->where('debit_or_credit',0)->restore();

        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('human-resource/employment/voucher/deleted-vue');

}






// EMPLOYEE IN & OUT

    public function inout_vue(Request $request, employment_in_out $employment_in_out)
    {
      return view('backend/human-resource/employee-in-out/employee-in-out-vue');
    }

    public function inout_init_vue(Request $request)
    {

  $data['employees'] =\Illuminate\Support\Facades\DB::select(
        'select employment_in_out.id,
         employment_in_out.employee_id,
         hr_employments.name as name,
         employment_in_out.in,
         employment_in_out.out

from employment_in_out

left outer join hr_employments on hr_employments.id=employment_in_out.employee_id
where employment_in_out.deleted_at is null group by employment_in_out.id order by employment_in_out.id desc');

     return $data;
}

 public function create_inout(Request $request)
    {
        return view('backend/human-resource.employee-in-out.employee-in-out-aeu-vue');
    }

  public function init_inout(Request $request)
    {
        if($request->get('r')){
            $lastval=employment_in_out::find($request->get('r'));
            $num=0;
      if($lastval){
        $num=$lastval->id;
        $lastval['increment_number']=$num;

      }else{
        $num=0;
        $lastval['increment_number']=$num;
      }


       return $lastval;

        }
        else{

        //Get the last record id and pass to the view
 $lastval=employment_in_out::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;

      }else{
        $num=1;
        $data['increment_number']=$num;
      }

     return $data;
 }

}


 public function save_inout(Request $request){
//        dd($request->all());
      $lastval=employment_in_out::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;

      }else{
        $num=1;
      }

if(employment_in_out::where('id',$num)->count() == 0){
        $d=[];

          $d['employee_id']=$request->get('employee_id');
          $d['in']=formatTimestamp($request->get('in_date'));
          $d['out']=formatTimestamp($request->get('out_date'));


        $id=  employment_in_out::create($d);

}
     return $id->id;

    }

public function edit_inout(employment_in_out $employment_in_out,$id)
    {
     $data['id']=$id;
     $data['datatableid']=$id;
     $data['init']=0;
        return view('backend/human-resource.employee-in-out.employee-in-out-aeu-vue', $data);
    }


   public function updated_inout(Request $request){
//        dd($request->all());
        $d=[];

         $d['employee_id']=$request->get('employee_id');
          $d['in']=formatTimestamp($request->get('in_date'));
          $d['out']=formatTimestamp($request->get('out_date'));


       $id=  employment_in_out::where('id',$request->get('id'))->updateWithUserstamps($d);
}

 public function destroy_inout(employment_in_out $employment_in_out,$id)
    {
        $destroy=$employment_in_out::where('id', $id)->deleteWithUserstamps();
        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }
        else{
            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect('human-resource/employee-in-out-vue');
    }

    public function restore_inout(employment_in_out $employment_in_out,$id)
    {
        $restore = employment_in_out::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }
         else{
            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');
         }
        return redirect('human-resource/employee-in-out/deleted-vue');
}

public function index_deleted_inout(Request $request, employment_in_out $employment_in_out)
    {
      return view('backend/human-resource/employee-in-out/employee-in-out-deleted-vue');
    }

    public function indexdt_deleted_inout(Request $request)
 {
    $data['employees'] =\Illuminate\Support\Facades\DB::select(
         'select employment_in_out.id,
         employment_in_out.employee_id,
         hr_employments.name as name,
         employment_in_out.in,
         employment_in_out.out,
         employment_in_out.deleted_at

from employment_in_out

left outer join hr_employments on hr_employments.id=employment_in_out.employee_id
where employment_in_out.deleted_at is not null group by employment_in_out.id order by employment_in_out.id desc');
     return $data;
}

// EMPLOYEE IN & OUT


}
