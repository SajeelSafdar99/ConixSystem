<?php

namespace App\Http\Controllers;

use App\corporateMemFamily;
use App\corporateMembership;
use App\mem_family;
use App\membership;
use App\mem_relation;
use App\mem_title;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\exports\CorporateFamilyMemberDown;
use App\mem_status;
use Session;
use DataTables;
 
class CorporateMemFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function export(Request $request){
        ob_end_clean(); 
     ob_start();
        return Excel::download(new CorporateFamilyMemberDown,'corporate-family-members.xlsx');
    }

    public function index()
    {
        //
    }

     public function indexdt(Request $request,$id, corporateMembership $corporateMemFamily)
    {


        $family = corporateMembership::find($id)->family();

        return DataTables::of($family)

          ->addColumn('status', function ($corporateMemFamily) {
                if ($corporateMemFamily->status == 1) {
                    return '<button class="btnwidth btn btn-sm btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-sm btn-outline-danger active btn-block mg-b-10">'.membershipStatus($corporateMemFamily->status).'</button>';
                }


            })


             ->addColumn('editbutton', function ($corporateMemFamily) {

                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('club-hospitality/corporate-membership/corporate-familymember-aeu/') . '/' . $corporateMemFamily->member_id . '/' . $corporateMemFamily->id . '"><i class="fas fa-edit"></i></a></button>'

                ;
            })

       ->addColumn('deletebutton', function ($corporateMemFamily) {

                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/corporate-familymember/delete/') . '/' . $corporateMemFamily->member_id . '/' . $corporateMemFamily->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'

                ;
            })


       ->addColumn('sup_card_issue', function ($corporateMemFamily) {
              return formatDateToShow($corporateMemFamily->sup_card_issue);


                })

       ->addColumn('sup_card_exp', function ($corporateMemFamily) {
              return formatDateToShow($corporateMemFamily->sup_card_exp);


                })

        ->addColumn('fam_relationship', function ($corporateMemFamily) {
              return familyrelationship($corporateMemFamily->fam_relationship);


                })

         ->addColumn('name', function ($corporateMemFamily) {
              return $corporateMemFamily->title.' '.$corporateMemFamily->first_name.' '.$corporateMemFamily->middle_name.' '.$corporateMemFamily->name;
            })

          ->addColumn('fam_picture', function ($corporateMemFamily) {

                return '<img style="width: 100px;" src="'.url('/').'/'.($corporateMemFamily->familymemberPic?$corporateMemFamily->familymemberPic->url:'').'"/>';
            })

            ->rawColumns(['editbutton', 'deletebutton', 'mem_relation', 'corporateMembership', 'status', 'fam_picture', 'fam_relationship','name'])
            ->addIndexColumn()
            ->make(true);
    }

 public function index_deleted(Request $request, corporateMemFamily $corporateMemFamily,$id)
    {
        $data['membershipdata'] = corporateMembership::where('id', $id)->first();
        return view('backend/club-hospitality/corporate-membership/corporate-familymember-deleted', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function indexdt_deleted(Request $request,$id, corporateMembership $corporateMemFamily)
    {

        $family = corporateMemFamily::onlyTrashed()->get();
        return DataTables::of($family)

         ->addColumn('sup_card_issue', function ($corporateMemFamily) {
              return formatDateToShow($corporateMemFamily->sup_card_issue);


                })

       ->addColumn('sup_card_exp', function ($corporateMemFamily) {
              return formatDateToShow($corporateMemFamily->sup_card_exp);


                })

        ->addColumn('fam_relationship', function ($corporateMemFamily) {
              return familyrelationship($corporateMemFamily->fam_relationship);


                })


        ->addColumn('name', function ($corporateMemFamily) {
              return $corporateMemFamily->title.' '.$corporateMemFamily->first_name.' '.$corporateMemFamily->middle_name.' '.$corporateMemFamily->name;
            })

          ->addColumn('fam_picture', function ($corporateMemFamily) {

                return '<img style="width: 100px;" src="'.url('/').'/'.($corporateMemFamily->familymemberPic?$corporateMemFamily->familymemberPic->url:'').'"/>';
            })


            ->addColumn('restorebutton', function ($corporateMemFamily) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/corporate-familymember/restore/') . '/' . $corporateMemFamily->member_id . '/' . $corporateMemFamily->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton', 'mem_relation', 'corporateMembership', 'fam_picture', 'fam_relationship', 'name'])
        ->addIndexColumn()
        ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create(corporateMemFamily $corporateMemFamily,$id)
    {
        // //Get the last record id and pass to the view
        $lastval = corporateMemFamily::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['family_update'] = '';
        $data['relationships']=mem_relation::where('status',1)->get();
          $data['titles']=mem_title::where('status',1)->get();
        $data['membershipdata'] = corporateMembership::where('id', $id)->first();
    $data['stati']=mem_status::where('status',1)->get();

   $supp =corporateMemFamily::withoutTrashed()->where('member_id',$id)->count();
   $data['suppno']=$supp+1;

$tableColumns=    $corporateMemFamily->getTableColumns();
        return view('backend/club-hospitality.corporate-membership.corporate-familymember-aeu', $data)->withColumns($tableColumns);
    }
    public function store(Request $request,$id)
    {
          $size['width'] = 300;
    $size['height'] = 200;


/*

  if ($request->hasFile('fam_picture')) {
           $file = $request->file('fam_picture');
  }
else{
            $file='';
        }*/




$lastval = corporateMemFamily::get()->last();
if($lastval){
$num = $lastval->id + 1;
}else{
    $num = 0;
}



        $save=$request->save;

        $this->validate($request, [

            'member_name'=>'required',
            'membership_number'=>'required',
            
            'name'=>'required',
         'first_name'=>'required',

             'sup_card_no'=>'required|unique:corporate_mem_families,sup_card_no',
             'date_of_birth'=>'required',
              'fam_relationship'=>'required',
               'gender'   =>'required',
               //'nationality'=>'required',
               // 'cnic'=>'required|unique:mem_families,cnic',
             //    'contact'=>'required',
            'maritial_status'=>'required',

            //'sup_card_issue'=>'required',
            //'sup_card_exp'=>'required',
        'sup_barcode'=>'unique:corporate_mem_families,sup_barcode',
            'card_status'=>'required',
            'status'  => 'required',
         //   'fam_picture'=>'required'
          ]);

         $family=corporateMemFamily::create([
           'member_id'=>$id,
           'member_name'=>$request->member_name,
            'sup_card_no'=>$request->sup_card_no,
            'membership_number'=>$request->membership_number,

            'title'=>$request->title,
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'name'=>$request->name,
            'name_comment'=>$request->name_comment,

             'date_of_birth'=>formatDate($request->date_of_birth),
              'fam_relationship'=>$request->fam_relationship,
              'gender'=>$request->gender,
               'nationality'=>$request->nationality,
                'cnic'=>$request->cnic,
                'passport_no'=>$request->passport_no,
                'passport_no'=>$request->passport_no,
                 'contact'=>$request->contact,
            'maritial_status'=>$request->maritial_status,

            'sup_card_issue'=>formatDate($request->sup_card_issue),
                 'sup_card_exp'=>formatDate($request->sup_card_exp),
            'sup_barcode'=>$request->sup_barcode,
            'card_status'=>$request->card_status,
            // 'fam_picture'=>sendFamilyMember($file,$size,['type'=>2,'moc_id'=>$num]),
              'status'=>$request->status,
              'remarks'=>$request->remarks

            ]);

/*if($file != ''){
  $family->familymemberPic()->updateOrCreate(['url'=>saveFamilyMember($file),'type'=>20]);
  }*/
 if ($request->hasFile('fam_picture')) {
           $file = $request->file('fam_picture');
           $createimg=sendCorporateFamilyMember($file,$size,['type'=>0,'trans_type'=>200,'trans_type_id'=>$family->id,'moc_id'=>$id]);   
       }


       
            if($family)
            {
                Session::flash('message', 'Data Enter Successfully !');
                Session::flash('alert-class', 'alert-success');
              /*  $memid=$family->id;
                $lastrec=mem_family::where('id',$memid)->first();*/
                return redirect('club-hospitality/corporate-membership/corporate-familymember-aeu/'.$id);
            }
            else{

                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger');
                return redirect('club-hospitality/corporate-membership/corporate-familymember-aeu/'.$id);

            }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function edit(corporateMemFamily $corporateMemFamily,$id,$familyid)
    {
        $data['family_update'] = corporateMemFamily::where('id', $familyid)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['family_update']->code;

        $data['stati']=mem_status::where('status',1)->get();

 $data['relationships']=mem_relation::where('status',1)->get();
  $data['titles']=mem_title::where('status',1)->get();
$data['membershipdata'] = corporateMembership::where('id', $id)->first();

$tableColumns=    $corporateMemFamily->getTableColumns();
/*        return view('backend/club-hospitality.membership.familymember-aeu', $data)->withColumns($tableColumns);*/

        return view('backend/club-hospitality.corporate-membership.corporate-familymember-aeu', $data)->withColumns($tableColumns);
    }


    public function update(Request $request,$id,$familyid)
    {

    $size['width'] = 300;
    $size['height'] = 200;

   /* $updateimg='';

        if ($request->hasFile('fam_picture')) {
        $updateimg=$request->file('fam_picture');

        $updateimg=saveFamilyMember($updateimg,$size,['type'=>20,'type_id'=>$familyid]);
        }else{
        $updateimg=$request->existimg;
        }
*/

        $this->validate($request, [
            'member_name'=>'required',
            'membership_number'=>'required',

         'name'=>'required',
         'first_name'=>'required',

          'sup_card_no'=>'required|unique:corporate_mem_families,sup_card_no,'.$familyid,
             'date_of_birth'=>'required',
              'fam_relationship'=>'required',
              'gender'   =>'required',
               //'nationality'=>'required',
            //    'cnic'=>'required|unique:mem_families,cnic,'.$familyid,
            // 'contact'=>'required',
          //    'passport_no'     =>'required_without:cnic',
            'maritial_status'=>'required',

            //'sup_card_issue'=>'required',
            //'sup_card_exp'=>'required',
            'sup_barcode'=>'unique:corporate_mem_families,sup_barcode,'.$familyid,
            'card_status'=>'required',
            'status'=>'required'
          ]);

 /*
 $s=mem_family::find($familyid)->images;
           foreach($s as $m){
               $m->delete();
    }


$updateimg='';

        if ($request->hasFile('fam_picture')) {
        $updateimg=$request->file('fam_picture');
        $updateimg=saveFamilyMember($updateimg,'familymemberupload');
        }else{
        $updateimg=$request->existimg;
        }

*/
        $updateimg='';
        if ($request->hasFile('fam_picture')) {
            
            if(corporateMemFamily::find($familyid)->familymemberPic){
                $s=corporateMemFamily::find($familyid)->familymemberPic; //images
                $s->delete();
            }
           
        

            $updateimg=$request->file('fam_picture');
            $updateimg=sendCorporateFamilyMember($updateimg,$size,['type'=>0,'trans_type'=>200,'trans_type_id'=>$familyid,'moc_id'=>$id]);   
            // $updateimg=saveFile($updateimg,'upload');
        }else{
            $updateimg=$request->existimg;
        }



$families = corporateMemFamily::find($familyid);
        $family = corporateMemFamily::where('id', $familyid)->updateWithUserstamps([

            'member_name'=>$request->member_name,
            'membership_number'=>$request->membership_number,
            
            'title'=>$request->title,
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'name'=>$request->name,
            'name_comment'=>$request->name_comment,

             'date_of_birth'=>formatDate($request->date_of_birth),
              'fam_relationship'=>$request->fam_relationship,
              'gender'=>$request->gender,
               'nationality'=>$request->nationality,
                'cnic'=>$request->cnic,
                'passport_no'=>$request->passport_no,
                 'contact'=>$request->contact,
            'maritial_status'=>$request->maritial_status,
            'sup_card_no'=>$request->sup_card_no,
            'sup_card_issue'=>formatDate($request->sup_card_issue),
                 'sup_card_exp'=>formatDate($request->sup_card_exp),
            'sup_barcode'=>$request->sup_barcode,
            'card_status'=>$request->card_status,
            // 'fam_picture'=>$updateimg,
             'status'=>$request->status,
             'remarks'=>$request->remarks
        ]);

       /* if($updateimg){
            $families->familymemberPic()->updateOrCreate(['url'=>($updateimg),'type'=>20]);
        }
        */

        if ($family) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/corporate-membership/corporate-familymember-aeu/'.$id);

    }



      public function barcodeupdate(Request $request,$id,$familyid)
    {

    $size['width'] = 300;
    $size['height'] = 200;

   /* $updateimg='';

        if ($request->hasFile('fam_picture')) {
        $updateimg=$request->file('fam_picture');

        $updateimg=saveFamilyMember($updateimg,$size,['type'=>20,'type_id'=>$familyid]);
        }else{
        $updateimg=$request->existimg;
        }
*/

        $this->validate($request, [
          
            'sup_barcode'=>'unique:corporate_mem_families,sup_barcode,'.$familyid,
     
          ]);

 /*
 $s=mem_family::find($familyid)->images;
           foreach($s as $m){
               $m->delete();
    }


$updateimg='';

        if ($request->hasFile('fam_picture')) {
        $updateimg=$request->file('fam_picture');
        $updateimg=saveFamilyMember($updateimg,'familymemberupload');
        }else{
        $updateimg=$request->existimg;
        }

*/
        $updateimg='';
      

$families = corporateMemFamily::find($familyid);
        $family = corporateMemFamily::where('id', $familyid)->updateWithUserstamps([

           
            'sup_barcode'=>$request->sup_barcode,
           
        ]);

      

        if ($family) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/corporate-membership/corporate-familymember-aeu/'.$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_family  $mem_family
     * @return \Illuminate\Http\Response
     */
    public function show(mem_family $mem_family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_family  $mem_family
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_family  $mem_family
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_family  $mem_family
     * @return \Illuminate\Http\Response
     */
    public function destroy(corporateMemFamily $corporateMemFamily,$id,$familyid)
    {
        $family=$corporateMemFamily::where('id', $familyid)->deleteWithUserstamps();
        if($family){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }

        return redirect('club-hospitality/corporate-membership/corporate-familymember-aeu/'.$id);
    }


    public function restore(corporateMemFamily $corporateMemFamily,$id,$familyid)
    {
        $restore = corporateMemFamily::onlyTrashed()->find($familyid)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/corporate-familymember/deleted/'.$id);

}

}
