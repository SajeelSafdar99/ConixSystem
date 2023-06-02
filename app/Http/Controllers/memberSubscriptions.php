<?php

namespace App\Http\Controllers;

use App\membership;
use Illuminate\Http\Request;

class memberSubscriptions extends Controller
{
    //
    protected $table='member_subscriptions';

    public function index(Request $request){
        $member=membership::query();

        if($request->get('barcode')){
            $member->where('mem_barcode',$request->get('barcode'));
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

        if($request->get('contact')){
            $member->where('mob_a',$request->get('contact'));
        }

        if($request->get('car_number')){
            $member->cars()->where('car_no',$request->get('car_number'));
        }



        if($request->get('barcode') ||
            $request->get('member_id')||
            $request->get('membership_number')||
            $request->get('name')||
            $request->get('contact')||
            $request->get('car_number')){

            $data['membershipdata'] = $member->with('subscriptions')->first();
            $data['subscriptions'] = \App\sports_subscription::all();
        }
        else{
            $data['membershipdata'] =null;
            $data['subscriptions'] =null;

        }
//        dd($data['subscriptions']);
//
        return view('backend/memberSubscriptions.search-members', $data);
    }
    public function saveSubscriptions($id,Request $request){
        $sub_ids=$request->post('sub');
//dd($request->all());
        \App\memberSubscriptions::where('member_id',$id)->deleteWithUserstamps();
        if($sub_ids){
            foreach($sub_ids as $sub_id){
                \App\memberSubscriptions::create(['member_id'=>$id,'subscription_id'=>$sub_id]);
            }
        }

        return back();
    }
}
