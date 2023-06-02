<?php

namespace App\Http\Controllers;

use App\customer;
use Illuminate\Http\Request;
use App\media;
use App\file_manager;
use App\membership;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Session;

class FileManagerController extends Controller
{
     public function index(Request $request, file_manager $file_manager)
   {
       if($request->get('mog_id')){
           return view('backend/admin-settings/file-manager/file-manager')->with(['mog_id'=>$request->get('mog_id'),'customer'=>$request->get('customer'),'mog'=>$request->get('mog')]);

       }


         return view('backend/admin-settings/file-manager/file-manager')->with(['mog'=>0,'customer'=>'','mog_id'=>null]);
   }
   public function init(Request $request){
         $id=$request->get('mog_id');
         $mog=$request->get('mog');
       $moc=2;

         if($mog==0){
             $moc=12;
         $c=membership::find($request->get('mog_id'))['applicant_name'];
         }
         else{
             $c=customer::find($request->get('mog_id'))['customer_name'];

         }

     $types=['Member','Customer'];
       $dir='home';
       $name='home';
       $type='folder';



    $last='';
    if($request->get('path')){
        $dir=str_replace(',','/',$request->get('path'));
    $last =explode(',',$request->get('path'))[count(explode(',',$request->get('path')))-1];
    }

    $a=['Room Booking','Membership', 'Family','Profile'];
    if($mog==1 && !in_array($last,$a)){
        $name='home';
        $type='folder';
        $types=['Room Booking'];
    }
    elseif($mog==0 && !in_array($last,$a)){
        $name='home';
        $type='folder';
        $types=$a;
    }
    elseif(in_array($last,$a)){
        $type="file";
        $name=$last;
        $media=media::query();
        if($last=='Room Booking'){
            $media->where('type_id',$id);

            $media->where('type',$moc);
        }
        else if($last=='Membership'){
            $media->where('type_id',$id);

            $media->where('type',10);

        }
        else if($last=='Family'){
            $m=membership::find($id)->family()->pluck('id');
            $media->whereIn('type_id',$m);
            $media->where('type',20);

        }
        else if($last=='Profile'){
            $media->where('type_id',$id);

            $media->where('type',11);

        }
       $m= $media->get();

        $return =[
            "name" => $name,
            "type" => 'folder',
            "path" => $dir,
            'items'=>[]
        ];
        foreach($m as $s){
            if($moc==12){
               // $c=membership::selectRaw('applicant_name as  name')->where('id',$s->type_id)->first();

        }
            else {
             //   $c=customer::selectRaw('customer_name as name')->where('id',$s->type_id)->first();


            }
            $return['items'][]=[
                "name" => explode('/',$s->url)[count(explode('/',$s->url))-1],
                "type" => "file",
                "path" => route('imageviewx',[base64_encode($s->url),'1024x1024']),
                "delete" => route('deleteimage',[base64_encode($s->url)]),
                "size"=>'1215121'

            ];
        }
        return $return;
    }


     return [
         "name" => $name,
         "type" => $type,
         "path" => $dir,
         "items"=>$this->_loop($types,$dir)
     ];
   }
   function image(Request $request,$url,$size){
         $url=base64_decode($url);
//         dd($url);
       $img = Image::make($url);
         if($size!='auto'){
             $s=explode('x',$size);
             if($s[0]===300 && $s[1]==300){

             }
             else{
                 $img->resize($s[0], $s[1]);

             }
         }

       return $img->response('jpg');
   }
   function delete(Request $request,$url){

         $url=base64_decode($url);
//         dd($url);
       $hash=$request->get('hash');
     $m= media::where('url',$url)->deleteWithUserstamps();
     unlink($url);
if(1==1){
    return Redirect::to(URL::previous() . $hash);

}
      /// return $img->response('jpg');
   }
   function _loop($types,$dir){
       $files=[];

       foreach($types as $type):
           $files[] = array(
               "name" => $type,
               "type" => "folder",
               "path" => $dir . '/' . $type,
               "items"=>[]

           );
       endforeach;

   return $files;
     }
}
