<?php
use App\fnb_item_definition;
use App\membership;
use App\User;
use App\finance_expense_head;
use App\room_charges_type;
use App\room_type;
use App\finance_invoice_charges_type;
use App\mem_relation;
use App\mem_family;
use App\event_menu;
use App\finance_account_head;
use App\finance_account_type;
use App\event_type;
use App\event_venue;
use App\event_menu_add_on;
use App\event_rate_category;
use App\event_charges_type;
use App\finance_payment_receivable;
use App\permission_category;
use App\room;
use App\mem_category;
use App\sports_subscription;
use App\finance_expense_paid_for;
use App\finance_voucher_type;
use App\fnb_currency;
use App\fnb_item_category;
use App\fnb_item_sub_category;
use App\mem_status;
use App\fnb_waitor_definition;
use App\fnb_table_definition;
use App\fnb_restaurant_location;
use App\fnb_product_classification;
use App\fnb_item_manufacturer;
use App\trans_type;
use App\hr_department;
use App\hr_company;
use App\store_location;
use App\store_department;
use App\fnb_cake_type;
use App\crm_leads_status;
use App\finance_level_one;
use App\finance_level_two;
use App\finance_level_three;
use App\maint_work_order_department;
// use File;
use App\finance_books;
use Illuminate\Support\Facades\DB;
use App\coa_accounts_cat;
use App\coa_accounts_control;
use App\coa_account;
use App\guest_type;
use App\transactions;
use App\customer;
use App\room_category;
use App\mem_corporate_companies;
use App\corporateMembership;
use App\corporateMemFamily;
use App\mem_partners;
use App\fnb_sales_subs;

if (!function_exists('AddPlayTimeasd')) {
function AddPlayTimeasd($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}
}

 if (!function_exists('membershipStatus')) {

    function membershipStatus($id){

        $status=mem_status::where('id',$id)->first();
                if(isset($status->desc)){
        return $status->desc;
      }
    }
  }
 if (!function_exists('settings')) {

    function settings($a){
        $S=session('settings');
        if($S){
            return $S[$a];

        }
        else{

     $status=\App\fnb_predefined_value::first();
        session('settings',$status);
        return $status[$a];
        }


    }
  }


  if (!function_exists('sendImage')) {


    function sendImage($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
           $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();
            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'upload';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;

            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
           if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid Image';
        }
    }
 }


 if (!function_exists('sendCorporateImage')) {


    function sendCorporateImage($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
           $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();
            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'corporatelogos';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;

            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
           if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid Image';
        }
    }
 }


if (!function_exists('saveFile')) {
     function saveFile($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'upload';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}


if (!function_exists('saveCorporateMember')) {
     function saveCorporateMember($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'corporateupload';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}
/*if (!function_exists('saveFile')) {


    function saveFile($file , $path='upload'){
        $ext = $file->getClientOriginalName();


            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();
            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            // $file->move($destinationPath, $newFilename);
        $path=env('uploadPrefix').$path;
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;

            return $finalPath;

    }
}*/

/*
if (!function_exists('saveFamilyMember')) {


    function saveFamilyMember($file , $path='familymemberupload'){
        $ext = $file->getClientOriginalName();


            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();
            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            // $file->move($destinationPath, $newFilename);
        $path=env('uploadPrefix').$path;
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;

            return $finalPath;

    }
}*/

  if (!function_exists('sendFamilyMember')) {


    function sendFamilyMember($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
           $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();
            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'familymemberupload';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
           if(!empty($doc)){

                 \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid Image';
        }
    }
 }


 if (!function_exists('sendCorporateFamilyMember')) {


    function sendCorporateFamilyMember($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
           $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();
            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'corporatefamilyupload';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
           if(!empty($doc)){

                 \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid Image';
        }
    }
 }

 if (!function_exists('sendDocs')) {
     function sendDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'docs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}

if (!function_exists('sendPartnerDocs')) {
     function sendPartnerDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'partnerdocs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}

 if (!function_exists('sendGeneralVoucherDocs')) {
     function sendGeneralVoucherDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'generalvoucherdocs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

            /*    \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);*/

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);


            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}

 if (!function_exists('sendEventDocs')) {
     function sendEventDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'eventdocs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                 \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);


            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}


/*
 if (!function_exists('sendExpensesDocs')) {
     function sendExpensesDocs($file , $size,$doc=array()){
            $path = 'expensedocs';
            $mypath=env('uploadPrefix').$path;

        $newFilename = "finance_expense_" . date('d-m-Y_h-i-s') . "_".time()."_.";
$finalpath=$path.'/' . $newFilename;

            file::move($file,$finalpath);
if(!empty($doc)){

                \App\media::create(['url'=>$finalpath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);
 }
            return $file;

    }
}*/ 

  if (!function_exists('sendExpensesDocs')) {
     function sendExpensesDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'expensedocs';
            $path=env('uploadPrefix').$path;
            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

               \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
} 





 if (!function_exists('sendMemberDocs')) {
     function sendMemberDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'memberdocs';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;

            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){
 
                 \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}




 if (!function_exists('sendCorporateMemberDocs')) {
     function sendCorporateMemberDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'corporatememberdocs';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;

            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){
 
                 \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}



 


/*
 if (!function_exists('sendCakeBookingDocs')) {
     function sendCakeBookingDocs($file , $size,$doc=array()){
            $path = 'cakebookingdocs';
            $mypath=env('uploadPrefix').$path;

        $newFilename = "cake_booking_" . date('d-m-Y_h-i-s') . "_".time()."_.";
$finalpath=$path.'/' . $newFilename;

            file::move($file,$finalpath);
if(!empty($doc)){

                \App\media::create(['url'=>$finalpath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);
 }
            return $file;

    }
}*/
 if (!function_exists('sendCakeBookingDocs')) {
     function sendCakeBookingDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'cakebookingdocs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}



/*
 if (!function_exists('sendStorePurchaseDocs')) {
     function sendStorePurchaseDocs($file , $size,$doc=array()){
            $path = 'storepurchasedocs';
            $mypath=env('uploadPrefix').$path;

        $newFilename = "store_purchase_" . date('d-m-Y_h-i-s') . "_".time()."_.";
$finalpath=$path.'/' . $newFilename;

            file::move($file,$finalpath);
if(!empty($doc)){

                \App\media::create(['url'=>$finalpath,'type'=>$doc['type'],'type_id'=>$doc['moc_id']]);
 }
            return $file;

    }
}*/
 if (!function_exists('sendStorePurchaseDocs')) {
     function sendStorePurchaseDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'storepurchasedocs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}


 if (!function_exists('sendStoreSalesDocs')) {
     function sendStoreSalesDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);

            $path = 'storesalesdocs';
            $path=env('uploadPrefix').$path;

            // $file->move($destinationPath, $newFilename);
            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'trans_type'=>$doc['trans_type'],'trans_type_id'=>$doc['trans_type_id'],'type_id'=>$doc['moc_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}

 if (!function_exists('sendEmployDocs')) {
     function sendEmployDocs($file , $size,$doc=array()){
        $ext = $file->getClientOriginalName();

        if ($ext != 'docx' || $ext != 'pdf' || $ext != 'gif') {
            $newFilename = "s_img_" . date('d-m-Y_h-i-s') . "_".time()."_." . $file->getClientOriginalName();

            $img = \Image::make($file);
            // $img->fit(30, 30)->save($destinationPath . '/' . $newFilename);
            $path = 'employeedocs';
            // $file->move($destinationPath, $newFilename);
            $path=env('uploadPrefix').$path;

            $img->save($path.'/' . $newFilename);
            $picPath = $newFilename;
            $finalPath =$path.'/' . $newFilename;
            if(!empty($doc)){

                \App\media::create(['url'=>$finalPath,'type'=>$doc['type'],'type_id'=>$doc['type_id']]);
            }
            return $finalPath;
        } else {
            return $message = 'Kindly select Valid File';
        }
    }
}

function generateRandomString($length) {
   $alphabet = range('A', 'Z');
    $myalphabet=$length-1;
    return $alphabet[$myalphabet];
}


if (!function_exists('formatDate')) {
    function formatDate($date){
        if($date){
              $x=str_replace('/','-',$date);
//        $x=$x[1].'-'.$x[0].'-'.$x[2];

        return date('Y-m-d',strtotime($x));
        }
        else
        {

        return '';
        }

    }
}

if (!function_exists('formatTimestamp')) {
    function formatTimestamp($date){
         if($date){
        return date('Y-m-d H:i:s',strtotime(str_replace('/','-',$date)));
        }
        else
        {

        return '';
        }
    }
}


if (!function_exists('formatDateToShow')) {
    function formatDateToShow($date){
      if($date=='0000-00-00' || $date=="")
        return null;
      else
      {
        return date('d/m/Y',strtotime($date));
      }
    }
}


if (!function_exists('formatTime')) {
    function formatTime($date){
       if($date=="")
        return null;
      else
      {
        return date('h:i:s',strtotime(str_replace('/','-',$date)));
    }
    }
}


if (!function_exists('salesformatTime')) {
    function salesformatTime($date){
       if($date=="")
        return null;
      else
      {
        return date('h:i A',strtotime(str_replace('/','-',$date)));
    }
    }
}


// MAINTENANCE - WORK ORDER SHEET
 if (!function_exists('WorkOrderDepartment')) {
    function WorkOrderDepartment($id){
    $name=maint_work_order_department::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }
// MAINTENANCE - WORK ORDER SHEET



  if (!function_exists('servicename')) {


    function servicename($id){
        $servicedata=room_charges_type::where('id',$id)->first();
        if(isset($servicedata->type)){

         return $servicedata->type;
        }
    }


  }


  if (!function_exists('servicename2')) {


    function servicename2($id){
        $servicedata=finance_invoice_charges_type::where('id',$id)->first();
        if(isset($servicedata->type)){

         return $servicedata->type;
        }
    }


  }


   if (!function_exists('servicename3')) {


    function servicename3($id){
        $servicedata=sports_subscription::where('id',$id)->first();
        if(isset($servicedata->desc)){

         return $servicedata->desc;
        }
    }


  }

  if (!function_exists('roomtypename')) {


    function roomtypename($id){
        $data='';
        $roomtypename=room::select('room_type')->where('id',$id)->first();

        if($roomtypename){
              $roomtname=$roomtypename->room_type;
              if($roomtname && is_numeric($roomtname) && $roomtname!=''){
                   $roomname=room_type::where('id',$roomtname)->first();
              }
     else{
        $roomname='';
     }
         if(!empty($roomname)){
         return  $data=$roomname->desc;
         }else{
         return $data='not exists ';
         }

        }
        else{
            return $data='not exists';
        }


    }


  }



     if (!function_exists('customertype')) {


    function customertype($id){
        $servicedata=customer::where('id',$id)->first();
        if(isset($servicedata->guest_type)){

         return $servicedata->guest_type;
        }
    }


  }
 


   if (!function_exists('accountheadname')) {


    function accountheadname($id){
        $data='';
        $accountheadname=finance_account_type::select('desc')->where('id',$id)->first();
        $head=$accountheadname->desc;
        $headname=finance_account_head::where('id',$head)->first();
         if(!empty($headname)){
         return  $data=$headname->desc;
         }else{
         return $data='not exists';
         }


    }


  }
 



 if (!function_exists('comemcategoryname')) {
    function comemcategoryname($id){

        $cat=corporateMembership::where('id',$id)->first();
                if(isset($cat->mem_category_id)){
            $name=mem_category::where('id',$cat->mem_category_id)->first();
if(isset($name->id)){
        return $name->id;
      }
      }
    }
  }


 if (!function_exists('memcategoryname')) {
    function memcategoryname($id){

        $cat=membership::where('id',$id)->first();
                if(isset($cat->mem_category_id)){
            $name=mem_category::where('id',$cat->mem_category_id)->first();
if(isset($name->id)){
        return $name->id;
      }
      }
    }
  }


   if (!function_exists('membercategory')) {
    function membercategory($id){

        $cat=mem_category::where('id',$id)->first();
                if(isset($cat->desc)){
        return $cat->desc;
      }
    }
  }


if (!function_exists('hrdepartmentname')) {
    function hrdepartmentname($id){
        $dep=hr_department::where('id',$id)->first();
                if(isset($dep->desc)){
        return $dep->desc;
      }
    }
  }


if (!function_exists('hrcompanyname')) {
    function hrcompanyname($id){
        $dep=hr_company::where('id',$id)->first();
                if(isset($dep->desc)){
        return $dep->desc;
      }
    }
  }

  
if (!function_exists('guesttypename')) {
    function guesttypename($id){
        $dep=guest_type::where('id',$id)->first();
                if(isset($dep->desc)){
        return $dep->desc;
      }
    }
  }


 
if (!function_exists('guestaffiliatename')) {
    function guestaffiliatename($id){
        $name=mem_partners::where('id',$id)->first();
                if(isset($name->partner_name)){
        return $name->partner_name;
      }
    }
  }



    if (!function_exists('salesaccounttype')) {


    function salesaccounttype($id){

        $acc=finance_account_type::where('id',$id)->first();
                if(isset($acc->type)){
        return $acc->type;
      }
    }
  }


   if (!function_exists('eventmenu')) {


    function eventmenu($id){

        $eventmenu=event_menu::where('id',$id)->first();
                if(isset($eventmenu->menu_name)){
        return $eventmenu->menu_name;
      }
    }
  }


   if (!function_exists('menuCategoryItems')) {


    function menuCategoryItems($id){

        $menuCategoryItems=event_rate_category::where('id',$id)->first();
                if(isset($menuCategoryItems->desc)){
        return $menuCategoryItems->desc;
      }
    }
  }


   if (!function_exists('menuChargesTypes')) {

    function menuChargesTypes($id){

        $menuChargesTypes=event_charges_type::where('id',$id)->first();
                if(isset($menuChargesTypes->type)){
        return $menuChargesTypes->type;
      }
    }
  }



 if (!function_exists('menuAddOnItems')) {


    function menuAddOnItems($id){

        $menuAddOnItems=event_menu_add_on::where('id',$id)->first();
                if(isset($menuAddOnItems->desc)){
        return $menuAddOnItems->desc;
      }
    }
  }


  if (!function_exists('menutype')) {


    function menutype($id){

        $menutype=event_type::where('id',$id)->first();
                if(isset($menutype->desc)){
        return $menutype->desc;
      }
    }
  }



   if (!function_exists('eventvenue')) {


    function eventvenue($id){

        $eventvenue=event_venue::where('id',$id)->first();
                if(isset($eventvenue->desc)){
        return $eventvenue->desc;
      }
    }


  }


  if (!function_exists('paymentreceivedfor')) {


    function paymentreceivedfor($id){

        $paymentreceivedfor=finance_payment_receivable::where('id',$id)->first();
                if(isset($paymentreceivedfor->desc)){
        return $paymentreceivedfor->desc;
      }
    }


  }


   if (!function_exists('generalVoucherType')) {


    function generalVoucherType($id){

        $generalVoucherType=finance_voucher_type::where('id',$id)->first();
                if(isset($generalVoucherType->desc)){
        return $generalVoucherType->desc;
      }
    }


  }



if (!function_exists('expensepaidfor')) {


    function expensepaidfor($id){

        $expensepaidfor=finance_expense_paid_for::where('id',$id)->first();
                if(isset($expensepaidfor->desc)){
        return $expensepaidfor->desc;
      }
    }


  }


  if (!function_exists('categoryidchange')) {


    function categoryidchange($id){

        $categoryidchange=permission_category::where('id',$id)->first();

        if(isset($categoryidchange->desc)){
        return $categoryidchange->desc;
      }
    }


  }


   if (!function_exists('familyrelationship')) {
    function familyrelationship($id){

        $familyrelationship=mem_relation::where('id',$id)->first();

        if(isset($familyrelationship->desc)){
        return $familyrelationship->desc;
      }
    }
  }
 


  if (!function_exists('invoicesfamilyname')) {
    function invoicesfamilyname($id){

        $invoicesfamilyname=mem_family::where('id',$id)->first();

         if(isset($invoicesfamilyname->name)){
        return $invoicesfamilyname->title.' '.$invoicesfamilyname->first_name.' '.$invoicesfamilyname->middle_name.' '.$invoicesfamilyname->name;
      }
    }
  }


  if (!function_exists('copinvoicesfamilyname')) {
    function copinvoicesfamilyname($id){

        $invoicesfamilyname=corporateMemFamily::where('id',$id)->first();

         if(isset($invoicesfamilyname->name)){
        return $invoicesfamilyname->title.' '.$invoicesfamilyname->first_name.' '.$invoicesfamilyname->middle_name.' '.$invoicesfamilyname->name;
      }
    }
  }


  if (!function_exists('invoicesfamilyrelation')) {
    function invoicesfamilyrelation($id){

        $invoicesfamilyrelation=mem_family::where('id',$id)->first();

         if(isset($invoicesfamilyrelation->fam_relationship)){
        return $invoicesfamilyrelation->fam_relationship;
      }
    }
  }


 if (!function_exists('copinvoicesfamilyrelation')) {
    function copinvoicesfamilyrelation($id){

        $invoicesfamilyrelation=corporateMemFamily::where('id',$id)->first();

         if(isset($invoicesfamilyrelation->fam_relationship)){
        return $invoicesfamilyrelation->fam_relationship;
      }
    }
  }



  if (!function_exists('roomno')) {


    function roomno($id){
        $data='';
        $roomno=room::where('id',$id)->first();

        if(!empty($roomno->room_no)){
         return  $data=$roomno->room_no;
         }else{
         return $data='not exists';
         }

    }


  }

  if (!function_exists('pdfroomtypename')) {


    function pdfroomtypename($id){
        $data='';
        $roomname=room_type::where('id',$id)->first();
         if(!empty($roomname)){
         return  $data=$roomname->desc;
         }else{
         return $data='not exists';
         }


    }


  }



// CRM

 if(!function_exists('leadstatus')) {
    function leadstatus($id){
    $table=crm_leads_status::where('id',$id)->first();
                if(isset($table->desc)){
        return $table->desc;
      }
    }
 }

// CRM



//store management

if (!function_exists('storeDepartmentName')) {
    function storeDepartmentName($id){
    $name=store_department::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
}

if (!function_exists('storelocs')) {

    function storelocs($id){
    $loc=store_location::where('id',$id)->first();
                if(isset($loc->desc)){
        return $loc->desc;
      }
    }
  }

//store management


// LEVELS OF ACCOUNTS
 if (!function_exists('financeLevelOne')) {

    function financeLevelOne($id){
    $name=finance_level_one::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }

  if (!function_exists('financeLevelTwo')) {

    function financeLevelTwo($id){
    $name=finance_level_two::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }

  if (!function_exists('financeLevelThree')) {

    function financeLevelThree($id){
    $name=finance_level_three::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }
// LEVELS OF ACCOUNTS




 if (!function_exists('financebookname')) {

    function financebookname($id){
    $name=finance_books::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }


 if (!function_exists('coaparent')) {

    function coaparent($id){
    $name=coa_accounts_control::where('code',$id)->first();
      if(isset($name->parent)){
        return $name->parent;
      }else{
        return null;
      }
    }
  }



 if (!function_exists('coaunitname')) {
    function coaunitname($id){

        $cat=coa_account::where('code',$id)->first();
                if(isset($cat->desc)){
            $name=coa_account::where('code',$cat->desc)->first();
if(isset($name->name)){
        return $name->name;
      }
      }
    }
  }




 if (!function_exists('corporatecompanyname')) {

    function corporatecompanyname($id){
    $name=mem_corporate_companies::where('id',$id)->first();
                if(isset($name->name)){
        return $name->name;
      }
    }
  }


 if (!function_exists('fmcorporatecompanyname')) {

    function fmcorporatecompanyname($id){
    $name=corporateMembership::where('id',$id)->first();
                if(isset($name->corporate_company)){
       $xx=mem_corporate_companies::where('id',$name->corporate_company)->first();
                if(isset($xx->name)){
        return $xx->name;
      }
      }
    }
  }






 if (!function_exists('coaaccountname')) {

    function coaaccountname($id){
    $name=coa_account::where('code',$id)->first();
                if(isset($name->name)){
        return $name->name;
      }
    }
  }


 if (!function_exists('coacategoryname')) {

    function coacategoryname($id){
    $name=coa_accounts_cat::where('id',$id)->first();
                if(isset($name->name)){
        return $name->name;
      }
    }
  }

 if (!function_exists('coaname')) {

    function coaname($id){
    $name=coa_accounts_control::where('code',$id)->first();
                if(isset($name->name)){
        return $name->name;
      }
    }
  }

 

 if (!function_exists('itemcategoryname')) {
    function itemcategoryname($id){
    $sales=fnb_item_definition::where('item_code',$id)->first();
                if(isset($sales->category)){
        
             $cat=fnb_item_category::where('id',$sales->category)->first();
                if(isset($cat->desc)){
             return $cat->desc;
      }

      }
    }
  }



 if (!function_exists('itemsubcategoryname')) {
    function itemsubcategoryname($id){
    $sales=fnb_item_definition::where('item_code',$id)->first();
                if(isset($sales->sub_category)){
        
             $cat=fnb_item_sub_category::where('id',$sales->sub_category)->first();
                if(isset($cat->desc)){
             return $cat->desc;
      }

      }
    }
  }

if (!function_exists('roomcategoryname')) {

    function roomcategoryname($id){
    $name=room_category::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }


//fnb sales helpers

  if (!function_exists('salescaketype')) {

    function salescaketype($id){
    $name=fnb_cake_type::where('id',$id)->first();
                if(isset($name->desc)){
        return $name->desc;
      }
    }
  }


 if (!function_exists('saleswaitername')) {

    function saleswaitername($id){
    $waiter=fnb_waitor_definition::where('id',$id)->first();
                if(isset($waiter->name)){
        return $waiter->name;
      }
    }
  }

  if (!function_exists('salestablename')) {

    function salestablename($id){
    $table=fnb_table_definition::where('id',$id)->first();
                if(isset($table->desc)){
        return $table->desc;
      }
    }
  }

  if (!function_exists('salesrestaurantname')) {

    function salesrestaurantname($id){
    $rest=fnb_restaurant_location::where('id',$id)->first();
                if(isset($rest->desc)){
        return $rest->desc;
      }
    }
  }


    if (!function_exists('usernames')) {

    function usernames($id){
    $user=User::where('id',$id)->first();
                if(isset($user->name)){
        return $user->name;
      }
    }
  }

   if (!function_exists('salescurrency')) {

    function salescurrency($id){
    $sales=fnb_currency::where('id',$id)->first();
                if(isset($sales->code)){
        return $sales->code;
      }
    }
  }

  if (!function_exists('salescategory')) {

    function salescategory($id){
    $sales=fnb_item_category::where('id',$id)->first();
                if(isset($sales->desc)){
        return $sales->desc;
      }
    }
  }

   if (!function_exists('salessubcategory')) {

    function salessubcategory($id){
    $sales=fnb_item_sub_category::where('id',$id)->first();
                if(isset($sales->desc)){
        return $sales->desc;
      }
    }
  }

   if (!function_exists('salesproductclass')) {

    function salesproductclass($id){
    $sales=fnb_product_classification::where('id',$id)->first();
                if(isset($sales->desc)){
        return $sales->desc;
      }
    }
  }


  if (!function_exists('salesmanufacturer')) {

    function salesmanufacturer($id){
    $sales=fnb_item_manufacturer::where('id',$id)->first();
                if(isset($sales->desc)){
        return $sales->desc;
      }
    }
  }
//fnb sales helpers


  if (!function_exists('transTypesDetails')) {

    function transTypesDetails($id){
    $getname=trans_type::where('id',$id)->first();
                if(isset($getname->details)){
        return $getname->details;
      }
    }
  }


  if (!function_exists('transTypesChargesTypes')) {

    function transTypesChargesTypes($id){
    $getname=trans_type::where('id',$id)->first();
                if(isset($getname->name)){
        return $getname->name;
      }
    }
  }
 if (!function_exists('transTypesCoa')) {

    function transTypesCoa($id){
    $getname=trans_type::where('id',$id)->first();
                if(isset($getname->account)){
        return $getname->account;
      }
    }
  }


if (!function_exists('ItemCoaCode')) {

    function ItemCoaCode($id){
    $getname=fnb_item_definition::where('item_code',$id)->first();
                if(isset($getname->coa_code)){
        return $getname->coa_code;
      }
    }
  }


   if (!function_exists('ExpenseHeadName')) {

    function ExpenseHeadName($id){
    $getname=finance_expense_head::where('id',$id)->first();
                if(isset($getname->desc)){
        return $getname->desc;
      }
    }
  }


//todo update for new modules

    function balanceOFCOA($id){

   $d=   DB::select("select
    sum(if(debit_or_credit=1,trans_amount,0))-
       sum(if(debit_or_credit=0,trans_amount,0))
       as balance

from transactions
where  transactions.type =3 and transactions.trans_type!=90 and transactions.account=$id  and  transactions.deleted_at is null  order by `date` asc
");

  /* $d=   DB::select("select
    sum(if(debit_or_credit=0,amount,0))-
       sum(if(debit_or_credit=1,amount,0))
       as balance

from coa_transactions
where  coa_transactions.account=$id  and  coa_transactions.deleted_at is null and (coa_transactions.is_active = 1 || coa_transactions.debit_or_credit = 0)  order by `date` asc
");*/

        return $d[0]->balance;
    }


    function balanceOFMOC($id,$type){

   $d=   DB::select("select
    sum(if(debit_or_credit=0,trans_amount,0))-
       sum(if(debit_or_credit=1,trans_amount,0))
       as balance

from transactions
where  transactions.type in (1,2,7) and trans_moc_type=$type and trans_moc=$id  and  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 0)  order by `date` asc
");

        return $d[0]->balance;
    }


 
      function balanceOFSUP($id,$type=0){
     $d=   DB::select("select
     sum(if(debit_or_credit=1,trans_amount,0))-
       sum(if(debit_or_credit=0,trans_amount,0))
       as balance

from transactions

where  transactions.type in (4,5,6,7) and trans_moc_type=2 and trans_moc=$id  and  transactions.deleted_at is null and (transactions.is_active = 1 || transactions.debit_or_credit = 1)  order by `date` asc
");

        return $d[0]->balance;
    }

    function lastPaymentofSUP($id){
        if(transactions::where('trans_moc_type',2)->where('trans_moc',$id)->where('type',5)->where('debit_or_credit',1)->exists())
        {
            $d=transactions::where('trans_moc_type',2)->where('trans_moc',$id)->where('type',5)->where('debit_or_credit',1)->orderBy('id', 'DESC')->first();
            return $d->trans_amount;
        }
        else
        {
            return 0;
        }
       
    }

    function lastPaymentofMOC($id){
        if(transactions::where('trans_moc',$id)->where('type',2)->where('debit_or_credit',0)->exists())
        {
            $d=transactions::where('trans_moc',$id)->where('type',2)->where('debit_or_credit',0)->orderBy('id', 'DESC')->first();
            return $d->trans_amount;
        }
        else
        {
            return 0;
        }
       
    }
	
	function getLastKot(){

		$kot = fnb_sales_subs::where ('created_by', Auth::id())->orderBy('id','desc')->pluck('kot_no')->first();
		if(!empty($kot)){
			$kot = explode("-", $kot);
			if(count($kot) == 2){
				$kotPlus = $kot[1]+1;
				$kot = $kot[0].'-'.$kotPlus;
			}else{
				$kot = Auth::id() .'-'. 1;
			}	
		}else{
			$kot = Auth::id() .'-'. 1;
		}
		return $kot;
       
    }



if (! function_exists('script')) {
    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function script($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->script($url, $attributes, $secure);
    }
}
  //$path = sendImage($request->{$value->input['name']} , $size);
