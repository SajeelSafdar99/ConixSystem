<?php

namespace App\Http\Controllers;

use App\mem_family;
use App\mem_cards;
use App\corporateMemFamily;
use App\corporateMembership;
use App\membership;
use DataTables;
use Illuminate\Http\Request;
use Session;

class MemCardsController extends Controller
{
     public function index(Request $request,$id, mem_cards $mem_cards)
    {
    	$data['init']                = 0;
    	$data['membershipdata'] = membership::where('id', $id)->with('family')->first();
        return view('backend/club-hospitality.membership.cards', $data);
    }

    public function indexdt(Request $request,$id, membership $membership)
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

      public function fmcard(membership $membership,$id)
    {  $data['init']                = 1;
    
         $data['familymembers']=mem_family::where('member_id',$id)->where('card_status','!=', 'Not Applicable')->where('status','!=',0)->get();

 $data['membershipdata'] = membership::where('id', $id)->first();

     return view('backend/club-hospitality.membership.familymembercard', $data);
 
        
    }




      public function corporate_fmcard(corporateMembership $corporateMembership,$id)
    {  $data['init']                = 1;
    
         $data['familymembers']=corporateMemFamily::where('member_id',$id)->where('card_status','!=', 'Not Applicable')->where('status','!=',0)->get();

 $data['membershipdata'] = corporateMembership::where('id', $id)->first();

     return view('backend/club-hospitality.corporate-membership.familymembercard', $data);
 
        
    }

}
