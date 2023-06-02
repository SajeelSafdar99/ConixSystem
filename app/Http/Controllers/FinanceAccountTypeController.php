<?php

namespace App\Http\Controllers;
use App\trans_type;
use App\finance_level_one;
use App\finance_level_two;
use App\finance_level_three;
use App\finance_account_head;
use App\finance_account_type;
use DataTables;
use Illuminate\Http\Request;
use Session;
use App\coa_accounts_control;

class FinanceAccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, finance_account_type $finance_account_type)
    {
        return view('backend/finance-and-management/finance-account-types/finance-account-types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexdt(Request $request, finance_account_type $finance_account_type)
    {

        $payment = finance_account_type::get();
        return DataTables::of($payment)
            ->addColumn('status', function ($payment) {
                if ($payment->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }



            })


            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-account-types/finance-account-types-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-account-types/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

           ->addColumn('level_three', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        return financeLevelThree($headname);
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })


                   ->addColumn('level_two', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        $headname2=finance_level_three::where('id',$headname[0])->get()->pluck('level_two');
        if($headname2){
         return financeLevelTwo($headname2);
        }
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })



                   ->addColumn('level_one', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        $headname2=finance_level_three::where('id',$headname[0])->get()->pluck('level_two');
        if($headname2){
         $headname3=finance_level_two::where('id',$headname2[0])->get()->pluck('level_one');
        }
        if($headname3){
         return financeLevelOne($headname3);
        }
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })

           /* ->addColumn('level_three', function ($payment) {
if($payment->level_three)
{
     $headname=finance_level_three::where('id',$payment->level_three)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })*/

             ->addColumn('desc', function ($payment) {
if($payment->desc)
{
                $headname=finance_account_head::where('id',$payment->desc)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })


         
            ->addColumn('id', function ($payment) {
 if($payment->desc)
{
     $basic2=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
      

      if($basic2)
          {
     $basic1=finance_level_three::where('id',$basic2[0])->get()->pluck('level_two');
     $headname2=$basic2[0];
        }
        else{
            $headname2='';
        }

         if($basic1)
          {
      $basic0=finance_level_two::where('id',$basic1[0])->get()->pluck('level_one');
     $headname1=$basic1[0];
        }
        else{
            $headname1='';
        }

       if($basic0)
          {
     $headname0=$basic0[0];
        }
        else{
            $headname0='';
        }

}
else{
    $headname2='';
    $headname1='';
    $headname0='';
}

        
  return $headname0.'-'.$headname1.'-'.$headname2.'-'.$payment->desc.'-'.$payment->id;
                })



            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


   public function index_deleted(Request $request, finance_account_type $finance_account_type)
    {
        return view('backend/finance-and-management/finance-account-types/finance-account-types-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, finance_account_type $finance_account_type)
    {

        $payment = finance_account_type::onlyTrashed()->get();
        return DataTables::of($payment)

            ->addColumn('restorebutton', function ($payment) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('finance-and-management/finance-account-types/restore/') . '/' . $payment->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

           ->addColumn('level_three', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        return financeLevelThree($headname);
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })


                   ->addColumn('level_two', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        $headname2=finance_level_three::where('id',$headname[0])->get()->pluck('level_two');
        if($headname2){
         return financeLevelTwo($headname2);
        }
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })



                   ->addColumn('level_one', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        $headname2=finance_level_three::where('id',$headname[0])->get()->pluck('level_two');
        if($headname2){
         $headname3=finance_level_two::where('id',$headname2[0])->get()->pluck('level_one');
        }
        if($headname3){
         return financeLevelOne($headname3);
        }
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })

             ->addColumn('desc', function ($payment) {
if($payment->desc)
{
                $headname=finance_account_head::where('id',$payment->desc)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
         //Get the last record id and pass to the view
        $lastval = finance_account_type::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
        $data['init']                = 0;
        $data['acc_type_update'] = '';

        $data['ones']=finance_level_one::where('status',1)->get();
        $data['seconds']=finance_level_two::where('status',1)->get();
        $data['thirds']=finance_level_three::where('status',1)->get();
        $data['account_heads']=finance_account_head::where('status',1)->get();

        return view('backend/finance-and-management.finance-account-types.finance-account-types-aeu', $data);
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
        $this->validate($request, [
            'level_one'   => 'required',
            'level_two'   => 'required',
            'level_three'   => 'required',
            'desc'   => 'required',
            'type' => 'required|unique:finance_account_types,type',
            'status'   => 'required']);

        $payment = finance_account_type::create([
            'level_one'   => $request->level_one,
            'level_two'   => $request->level_two,
            'level_three'   => $request->level_three,
            'desc'   => $request->desc,
            'type'   => $request->type,
            'status' => $request->status,

        ]);

        if ($payment) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('finance-and-management/finance-account-types/finance-account-types-aeu');
            }else{
                return redirect('finance-and-management/finance-account-types');
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_account_type  $finance_account_type
     * @return \Illuminate\Http\Response
     */
    public function show(finance_account_type $finance_account_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_account_type  $finance_account_type
     * @return \Illuminate\Http\Response
     */
     public function edit(finance_account_type $finance_account_type,$id)
    {
         $data['acc_type_update'] = finance_account_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['acc_type_update']->code;

$data['selected_three']=finance_account_head::where('id',$data['acc_type_update']->desc)->get()->pluck('level_three');
$data['selected_two']=finance_level_three::where('id',$data['selected_three'][0])->get()->pluck('level_two');
$data['selected_one']=finance_level_two::where('id',$data['selected_two'][0])->get()->pluck('level_one');

     $data['ones']=finance_level_one::where('status',1)->get();
         $data['seconds']=finance_level_two::where('status',1)->get();
         $data['thirds']=finance_level_three::where('status',1)->get();
    $data['account_heads']=finance_account_head::where('status',1)->get();

        return view('backend/finance-and-management.finance-account-types.finance-account-types-aeu', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_account_type  $finance_account_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request, [
        'level_one'   => 'required',
            'level_two'   => 'required',
            'level_three'   => 'required',
            'desc'   => 'required',
            'type' => 'required|unique:finance_account_types,type,'.$id,
            'status'   => 'required']);

        $payment = finance_account_type::where('id', $id)->updateWithUserstamps([
            'level_one'   => $request->level_one,
            'level_two'   => $request->level_two,
            'level_three'   => $request->level_three,
            'desc'   => $request->desc,
            'type'   => $request->type,
            'status' => $request->status,
        ]);

        if ($payment) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/finance-account-types/finance-account-types-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_account_type  $finance_account_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_account_type $finance_account_type,$id)
    {
        $payment=$finance_account_type::where('id', $id)->deleteWithUserstamps();
        if($payment){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }

        return redirect('finance-and-management/finance-account-types');
    }


public function restore(finance_account_type $finance_account_type,$id)
    {
        $restore = finance_account_type::onlyTrashed()->find($id)->restore();
        if($restore){
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('finance-and-management/finance-account-types/deleted');

}

 
 public function linking_index(Request $request, coa_accounts_control $coa_accounts_control)
    {
        return view('backend/finance-and-management/accounts-linking/accounts-linking');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function linking_indexdt(Request $request, trans_type $trans_type)
    {
        $payment = trans_type::get();
        return DataTables::of($payment)


->addColumn('narration', function ($payment) {
     if($payment->account)
    {
       return coaname($payment->account).' '.'-'.' '.$payment->account;
    }
     else
    {
        return '';
    }
       })


        ->addColumn('status', function ($payment) {
            if($payment->account){
                return '<a style="color:white; "  href="' . url('finance-and-management/coa-linking/link/') . '/' . $payment->id . '/' . $payment->account . '"><button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Edit Link">Linked</button></a>'  /*'<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Linked</button>'*/;
            }
            else {
                return '<a style="color:white; "  href="' . url('finance-and-management/coa-linking/link/') . '/' . $payment->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Create Link">Link</button></a>' ;
            }

            })


            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }


    public function linking_indexdt_old(Request $request, finance_account_type $finance_account_type)
    {
        $payment = finance_account_type::get();
        return DataTables::of($payment)


            ->addColumn('editbutton', function ($payment) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('finance-and-management/finance-account-types/finance-account-types-aeu/') . '/' . $payment->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })
            ->addColumn('deletebutton', function ($payment) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('finance-and-management/finance-account-types/delete') . '/' . $payment->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })


   
           ->addColumn('level_three', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        return financeLevelThree($headname);
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })


                   ->addColumn('level_two', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        $headname2=finance_level_three::where('id',$headname[0])->get()->pluck('level_two');
        if($headname2){
         return financeLevelTwo($headname2);
        }
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })



                   ->addColumn('level_one', function ($payment) {
if($payment->desc)
{
     $headname=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     if($headname){
        $headname2=finance_level_three::where('id',$headname[0])->get()->pluck('level_two');
        if($headname2){
         $headname3=finance_level_two::where('id',$headname2[0])->get()->pluck('level_one');
        }
        if($headname3){
         return financeLevelOne($headname3);
        }
     }else{
          return '';
     }
    
}
     else {
        return '';
     }          
                })

             ->addColumn('desc', function ($payment) {
if($payment->desc)
{
                $headname=finance_account_head::where('id',$payment->desc)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })



             /* ->addColumn('level_one', function ($payment) {
if($payment->level_one)
{
     $headname=finance_level_one::where('id',$payment->level_one)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })

            ->addColumn('level_two', function ($payment) {
if($payment->level_two)
{
     $headname=finance_level_two::where('id',$payment->level_two)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })

            ->addColumn('level_three', function ($payment) {
if($payment->level_three)
{
     $headname=finance_level_three::where('id',$payment->level_three)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })

             ->addColumn('desc', function ($payment) {
if($payment->desc)
{
                $headname=finance_account_head::where('id',$payment->desc)->get();
                  return $headname[0]['desc'];
}
     else {
        return '';
     }
                })*/


    ->addColumn('levels', function ($payment) {

        if($payment->desc)
{
     $lt=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
        $headname=finance_account_head::where('id',$payment->desc)->get();
           $levelfour = $headname[0]['desc'];
}
     else {
         $levelfour = '';
     }



     if($lt)
{
    $ltw =finance_level_three::where('id',$lt[0])->get()->pluck('level_two');
     $headname3 =finance_level_three::where('id',$lt[0])->get();
                   $levelthree = $headname3[0]['desc'];
}
     else {
        return $levelthree='';
     }



  if($ltw)
{
       $lo =finance_level_two::where('id',$ltw[0])->get()->pluck('level_one');
     $headname2=finance_level_two::where('id',$ltw[0])->get();
                    $leveltwo = $headname2[0]['desc'];
}
     else {
        return  $leveltwo ='';
     }


    if($lo)
{
     $ls=finance_level_one::where('id',$lo[0])->get();
                    $levelone = $ls[0]['desc'];
}
     else {
        return  $levelone = '';
     }

   
   return $levelone.','.$leveltwo.','.$levelthree.','.$levelfour;
                })



        ->addColumn('id', function ($payment) {
   

  if($payment->id)
    {
     $iddd=$payment->id;
    }else
    {
        $iddd='';
    }

    
     if($payment->desc)
    {
     $lt=finance_account_head::where('id',$payment->desc)->get()->pluck('level_three');
     $desc=$payment->desc;
    }else
    {
        $desc='';
    }

      if($lt)
    {
     $ltw =finance_level_three::where('id',$lt[0])->get()->pluck('level_two');
     $level_three=$lt[0];
    }else
    {
        $level_three='';
    }


     if($ltw)
    {
        $lo =finance_level_two::where('id',$ltw[0])->get()->pluck('level_one');
     $level_two=$ltw[0];
    }else
    {
        $level_two='';
    }


if($lo)
    {
     $level_one=$lo[0];
    }else
    {
        $level_one='';
    }


    return $level_one.'-'.$level_two.'-'.$level_three.'-'.$desc.'-'.$iddd;
                })


->addColumn('narration', function ($payment) {
     if($payment->trans_type)
    {
       return transTypesChargesTypes($payment->trans_type);
        /*$tname=trans_type::where('id',$payment->trans_type)->get();
        if($tname){
            return $tname[0]['name'];
        }else{
            return '';
        }*/
    }
     else
    {
        return '';
    }
       })


        ->addColumn('status', function ($payment) {
            if($payment->trans_type){
                return '<a style="color:white; "  href="' . url('finance-and-management/accounts-linking/link/') . '/' . $payment->id . '/' . $payment->trans_type . '"><button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Edit Link">Linked</button></a>'  /*'<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Linked</button>'*/;
            }
            else {
                return '<a style="color:white; "  href="' . url('finance-and-management/accounts-linking/link/') . '/' . $payment->id . '"><button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Create Link">Link</button></a>' ;
            }

            })


            ->rawColumns(['editbutton', 'deletebutton', 'status'])
         ->addIndexColumn()
            ->make(true);
    }

public function link(trans_type $trans_type,$id)
    {

        $data['update'] = trans_type::where('id', $id)->first();
        $data['init']                = 0;
       
        return view('backend/finance-and-management.accounts-linking.link', $data);
    }

       public function edit_link(trans_type $trans_type,$id,$account)
    {
        $data['update'] = trans_type::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['update']->code;

        return view('backend/finance-and-management.accounts-linking.link', $data);
    }

 
    public function update_link(Request $request, $id)
    {
       if($request->coa_code==''){
          $what=null;
       }else{
         $what= $request->account;
       }

        $update = trans_type::where('id', $id)->updateWithUserstamps([
            'account' =>  $what,
            'debit_or_credit' =>  $request->debit_or_credit,
        ]);

        if ($update) {
            Session::flash('message', 'Linked Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'There was a problem, Try Again !');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('finance-and-management/coa-linking');

    }



      public function index_vue(Request $request, finance_account_type $finance_account_type)
    {
       return view('backend/finance-and-management/chart-of-accounts-list/chart-of-accounts-list-vue');
    }

    
public function list_init_vue(Request $request)
    {
$search='';
$search2='';
   if($request->get('start_date')){
            $search.=" and transactions.date >= '$request->start_date' ";
           
        }
        if($request->get('end_date')){
        $search.=" and transactions.date <= '$request->end_date' ";
    }
 if($request->get('accsearchid')){
        $search2.=" and coa_accounts_controls.code = '$request->accsearchid' ";
  
    } 
    if($request->get('accsearchpid')){
        $search2.=" and coa_accounts_controls.parent = '$request->accsearchpid' ";
  
    } 

  $data['trials'] =\Illuminate\Support\Facades\DB::select("select coa_accounts_controls.code,
    coa_accounts_controls.name,
    coa_accounts_controls.parent as parentcode,
    coa_accounts_cat.name as category,
    coa_accounts_controls.category_id,
     gi.name as parent,
       sum(if(transactions.debit_or_credit=0 and transactions.type in (2,4,5),trans_amount,0)) as debit,
       sum(if(transactions.debit_or_credit=1 and transactions.type in (1,6),trans_amount,0)) as credit

      from coa_accounts_controls
    
        left outer join transactions on transactions.trans_coa=coa_accounts_controls.code $search
        left outer join coa_accounts_controls gi on gi.code=coa_accounts_controls.parent
        left outer join coa_accounts_cat on coa_accounts_cat.id=coa_accounts_controls.category_id
 
where 1=1  and coa_accounts_controls.deleted_at is null $search2
group by coa_accounts_controls.id
order by coa_accounts_controls.category_id,coa_accounts_controls.id");

 
     return $data;
}
 

/*
     public function list_init_vue(Request $request)
    {
$search='';
if($request->get('filter')!=0){
    $search.=" and trans.trans_type = '$request->filter' ";
}
  $data['trials'] =\Illuminate\Support\Facades\DB::select("select ts.level,ts.`desc`,ts.t,
       sum(if(transactions.debit_or_credit=0,trans_amount,0)) as debit,
       sum(if(transactions.debit_or_credit=1,trans_amount,0)) as credit,
       finance_level_ones.desc as accty,
       trans_types.name as ttype

       from (
               select concat(level_one,'-',id) as level, `desc`,0 as t,id,level_one from finance_level_twos
               union all
               select concat(level_one,'-',level_two,'-',id) as level, `desc`,0 as t,id,level_one from finance_level_threes
               union all
               select concat(level_one,'-',level_two,'-',level_three,'-',id) as level, `desc`,0 as t,id,level_one from finance_account_heads
               union all
               select concat(level_one,'-',level_two,'-',level_three,'-',`desc`,'-',id) as level, `type` as `desc`,trans_type,id,level_one from finance_account_types
    ) ts
        left outer join transactions on transactions.trans_type>89 and transactions.trans_type_id=ts.t
        left outer join finance_level_ones on finance_level_ones.id=ts.level_one
        left outer join trans_types on trans_types.id = ts.t
where 1=1 $search
group by level
order by level");

 $data['ones']=finance_level_one::where('status',1)->get();
  $data['twos']=finance_level_two::where('status',1)->get();
 $data['threes']=finance_level_three::where('status',1)->get();
  $data['fours']=finance_account_head::where('status',1)->get();
 $data['filters']=finance_account_type::where('status',1)->get();

     return $data;

}
*/


    public function acc_balance_index_vue(Request $request, finance_account_type $finance_account_type)
    {
       return view('backend/finance-and-management/accounts-balance/accounts-balance-vue');
    }

       public function acc_balance_init_vue(Request $request)
    {
$search='';
if($request->get('filter')!=0){
    $search.=" and trans.trans_type = '$request->filter' ";
}
  $data['trials'] =\Illuminate\Support\Facades\DB::select("select t.name,t.type,t.id,t.no_id,sum(if(trans.debit_or_credit=0,trans.trans_amount,0)) as debit,sum(if(trans.debit_or_credit=1,trans.trans_amount,0)) as credit from (
    select  CONCAT(coalesce(memberships.title, ''), ' ', coalesce(memberships.first_name, ''), ' ',
              coalesce(memberships.middle_name, ''), ' ',
              coalesce(memberships.applicant_name, '')) as name, 0 as type,id,mem_no as no_id from memberships where deleted_at is null and active!=7
    union all
    select customer_name as name, 1 as type, id,customer_no as no_id from customers where deleted_at is null
    union all
    select name,3 as type,id,application_no as no_id from hr_employments where deleted_at is null
    union all
         select person_name as name, 2 as type, id, id as no_id
         from finance_ledger_people
         where deleted_at is null

    ) as t

    inner join transactions  trans on trans.trans_moc_type=t.type and trans.trans_moc=t.id and trans.type in (1,2) and trans.deleted_at is null and (trans.is_active=1 || trans.debit_or_credit=0) $search
where 1=1 group by t.id,t.type order by id, type");

 $data['ones']=finance_level_one::where('status',1)->get();
  $data['twos']=finance_level_two::where('status',1)->get();
 $data['threes']=finance_level_three::where('status',1)->get();
  $data['fours']=finance_account_head::where('status',1)->get();
 $data['filters']=finance_account_type::where('status',1)->get();

     return $data;

}



}
