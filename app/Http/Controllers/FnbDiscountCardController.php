<?php

namespace App\Http\Controllers;

use App\fnb_discount_card;
use Illuminate\Http\Request;
use Session;
use DataTables;
use Illuminate\Support\Carbon;
use DateTime;

class FnbDiscountCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, fnb_discount_card $fnb_discount_card)
    {
         return view('backend/food-and-beverage/discount-cards/discount-cards');
    }

    public function indexdt(Request $request, fnb_discount_card $fnb_discount_card)
    {


      
        
$fnb_discount_cards = fnb_discount_card::get();


       return DataTables::of($fnb_discount_cards)



      ->addColumn('status', function ($fnb_discount_cards) {


$fdate = date('Y-m-d');
$tdate = $fnb_discount_cards->card_expiry_date;
$d1 = strtotime($fdate);
$d2 = strtotime($tdate);
$totalSecondsDiff = abs($d1-$d2); //42600225
$totalDaysDiff    = $totalSecondsDiff/60/60/24; //493.05


               if($totalDaysDiff==0){
                return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Valid</button>';
               }else{
               //return $totalDaysDiff;
                return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Valid</button>';
               }
            })

              ->addColumn('type', function ($fnb_discount_cards) {
                if($fnb_discount_cards->name==''){
                     return '';
                }
                else if($fnb_discount_cards->type==1){
                     return "Guest";
                }
                else if($fnb_discount_cards->type==3){
                     return "Employee";
                }
                else if($fnb_discount_cards->type==0){
                     return "Member";
                 }

                })

            ->addColumn('pct', function ($fnb_discount_cards) {
            if($fnb_discount_cards->discount_percentage){
                  return $fnb_discount_cards->discount_percentage.'%'.'';
            }

                })
        
        ->addColumn('card_issue_date', function ($fnb_discount_cards) {
              return formatDateToShow($fnb_discount_cards->card_issue_date);
                })

        ->addColumn('card_expiry_date', function ($fnb_discount_cards) {
              return formatDateToShow($fnb_discount_cards->card_expiry_date);
                })

        ->addColumn('editbutton', function ($fnb_discount_cards) {
            return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="'.url('food-and-beverage/discount-cards/discount-cards-aeu/').'/'.$fnb_discount_cards->id.'"><i class="fas fa-edit"></i></a></button>'
            ;
        })
        ->addColumn('deletebutton', function ($fnb_discount_cards) {
            return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('food-and-beverage/discount-cards/delete') . '/' . $fnb_discount_cards->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
            ;
        })

       ->rawColumns(['editbutton','deletebutton','status'])
       ->addIndexColumn()
       ->make(true);
    }



    public function index_deleted(Request $request, fnb_discount_card $fnb_discount_card)
    {
        return view('backend/food-and-beverage/discount-cards/discount-cards-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, fnb_discount_card $fnb_discount_card)
    {

        $table = fnb_discount_card::onlyTrashed()->get();
        return DataTables::of($table)

        ->addColumn('type', function ($table) {
                if($table->name==''){
                     return '';
                }
                else if($table->type==1){
                     return "Guest";
                }
                else if($table->type==3){
                     return "Employee";
                }
                else if($table->type==0){
                     return "Member";
                 }

                })

  ->addColumn('pct', function ($table) {
            if($table->discount_percentage){
                  return $table->discount_percentage.'%'.'';
            }

                })



          ->addColumn('card_issue_date', function ($table) {
              return formatDateToShow($table->card_issue_date);
                })

              ->addColumn('card_expiry_date', function ($table) {
              return formatDateToShow($table->card_expiry_date);
                })

            ->addColumn('restorebutton', function ($table) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/discount-cards/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get the last record id and pass to the view
      $lastval=fnb_discount_card::withTrashed()->latest('id')->first();
      $num=0;
      if($lastval){
        $num=$lastval->id+1;
        $data['increment_number']=$num;
        
      }else{
        $num=1;
        $data['increment_number']=$num;
      }
       $data['init']=0;
       $data['discount_card_update'] = '';

     return view('backend/food-and-beverage.discount-cards.discount-cards-aeu',$data);
   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save=$request->save;

        $validation=[
            'name'   =>  'unique:fnb_discount_cards,name',
            'card_number'   =>  'required|unique:fnb_discount_cards,card_number',
            'discount_amount'   =>  'required_without:discount_percentage',
            'discount_percentage'   =>  'required_without:discount_amount',
            'card_issue_date' => 'required',
            'card_expiry_date'   =>  'required'
            ];
        
        if($request->get('card_issue_date')==$request->get('card_expiry_date')){
            $validation['accurate_card_expiry_date']='required';
        }
        

        $this->validate($request, $validation);
                    
       $store=fnb_discount_card::create([
            'type'=>$request->type,
            'name'=>$request->name,
            'customer_id'=>$request->customer_id,
            'card_number'=>$request->card_number,
            'discount_amount'=>$request->discount_amount,
            'discount_percentage'=>$request->discount_percentage,
            'card_issue_date'=> formatDate($request->card_issue_date),
            'card_expiry_date'=> formatDate($request->card_expiry_date)
            ]);
            
            if($store)
            {
                Session::flash('message', 'Data Entered Successfully !'); 
                Session::flash('alert-class', 'alert-success'); 
            }
            else{
                
                Session::flash('message', 'Data Not Inserted !');
                Session::flash('alert-class', 'alert-danger'); 
            }

            //echo $message;
             if(empty($save))
            {
                return redirect('food-and-beverage/discount-cards/discount-cards-aeu');
            }else{
                return redirect('food-and-beverage/discount-cards');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fnb_discount_card  $fnb_discount_card
     * @return \Illuminate\Http\Response
     */
    public function show(fnb_discount_card $fnb_discount_card)
    {
        //
    }
    
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fnb_discount_card  $fnb_discount_card
     * @return \Illuminate\Http\Response
     */
    public function edit(fnb_discount_card $fnb_discount_card, $id)
    {
        $data['discount_card_update'] = fnb_discount_card::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['discount_card_update']->code;

         return view('backend/food-and-beverage.discount-cards.discount-cards-aeu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fnb_discount_card  $fnb_discount_card
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request, $id)
    {
        $validation=[
            'name'   =>  'unique:fnb_discount_cards,name,'.$id,
            'card_number'   =>  'required|unique:fnb_discount_cards,card_number,'.$id,
            'discount_amount'   =>  'required_without:discount_percentage',
            'discount_percentage'   =>  'required_without:discount_amount',
            'card_issue_date' => 'required',
            'card_expiry_date'   =>  'required'
        ];
        
        if($request->get('card_issue_date')==$request->get('card_expiry_date')){
            $validation['accurate_card_expiry_date']='required';
        }
        

        $this->validate($request, $validation);

        $update = fnb_discount_card::where('id', $id)->updateWithUserstamps([
           
           'type'=>$request->type,
            'name'=>$request->name,
             'customer_id'=>$request->customer_id,
            'card_number'=>$request->card_number,
             'discount_amount'=>$request->discount_amount,
            'discount_percentage'=>$request->discount_percentage,
             'card_issue_date'=> formatDate($request->card_issue_date),
            'card_expiry_date'=> formatDate($request->card_expiry_date)

        ]);

        if ($update) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('food-and-beverage/discount-cards/discount-cards-aeu/'.$id);
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fnb_discount_card  $fnb_discount_card
     * @return \Illuminate\Http\Response
     */
    public function destroy(fnb_discount_card $fnb_discount_card,$id)
    {
        
        $destroy=$fnb_discount_card::where('id', $id)->deleteWithUserstamps();
        if($destroy){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('food-and-beverage/discount-cards');
    }

public function restore(fnb_discount_card $fnb_discount_card,$id)
    {
        $restore = fnb_discount_card::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('food-and-beverage/discount-cards/deleted');

}

}
