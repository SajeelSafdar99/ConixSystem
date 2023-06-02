<?php

namespace App\Http\Controllers;

use App\mem_relation;
use DataTables;
use Illuminate\Http\Request;
use Session;

class MemRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, mem_relation $mem_relation)
    {

        return view('backend/club-hospitality/member-relation/members-relation');
    }

    public function indexdt(Request $request, mem_relation $mem_relation)
    {


        $mem_relations = mem_relation::get();
        return DataTables::of($mem_relations)
            ->addColumn('status', function ($mem_relations) {
                if ($mem_relations->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }

        
    
            })

            ->addColumn('editbutton', function ($mem_relations) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" href="' . url('club-hospitality/member-relation/members-relation-aeu/') . '/' . $mem_relations->id . '"><i class="fas fa-edit"></i></a></button>'
                ;
            })

            ->addColumn('deletebutton', function ($mem_relations) {
                return '<button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/member-relation/delete') . '/' . $mem_relations->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })

            ->rawColumns(['editbutton', 'deletebutton', 'status'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index_deleted(Request $request, mem_relation $mem_relation)
    {
        return view('backend/club-hospitality/member-relation/members-relation-deleted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexdt_deleted(Request $request, mem_relation $mem_relation)
    {

        $Relation_add = mem_relation::onlyTrashed()->get();
        return DataTables::of($Relation_add)

            ->addColumn('restorebutton', function ($Relation_add) {
                return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('club-hospitality/member-relation/restore/') . '/' . $Relation_add->id . '"><i class="fas fa-trash-restore"></i></a></button>'
                ;
            })

        ->rawColumns(['restorebutton'])
        ->addIndexColumn()
        ->make(true);
    }

    public function create()
    {
        //Get the last record id and pass to the view
        $lastval = mem_relation::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = sprintf("%03d", $num);

        } else {
            $num                      = 1;
            $data['increment_number'] = printf("%03d", $num);
        }
        $data['init']                = 0;
        $data['mem_relation_update'] = '';

        return view('backend/club-hospitality.member-relation.members-relation-aeu', $data);
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
           // 'code'     => 'required',
            'desc' => 'required|unique:mem_relations,desc',
            'status'   => 'required']);

        $Relation_add = mem_relation::create([
            //'code'   => $request->code,
            'desc'   => $request->desc,
            'status' => $request->status,

        ]);

        if ($Relation_add) {
            Session::flash('message', 'Data Enter Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {

            Session::flash('message', 'Data Not Inserted !');
            Session::flash('alert-class', 'alert-danger');
        }

        //echo $message;
        if(empty($save))
            {
                return redirect('club-hospitality/member-relation/members-relation-aeu');
            }else{
                return redirect('club-hospitality/member-relation');
            }


        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\mem_relation  $mem_relation
     * @return \Illuminate\Http\Response
     */
    public function show(mem_relation $mem_relation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\mem_relation  $mem_relation
     * @return \Illuminate\Http\Response
     */
    public function edit(mem_relation $mem_relation, $id)
    {
        $data['mem_relation_update'] = mem_relation::where('id', $id)->first();
        $data['init']                = 1;
        $data['increment_number']    = $data['mem_relation_update']->code;

        return view('backend/club-hospitality.member-relation.members-relation-aeu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\mem_relation  $mem_relation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'desc' => 'required|unique:mem_relations,desc,'.$id,
            'status'   => 'required']);

        $member_relation = mem_relation::where('id', $id)->updateWithUserstamps([
            'desc'   => $request->desc,
            'status' => $request->status,
        ]);

        if ($member_relation) {
            Session::flash('message', 'Data Updated Successfully !');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Data Not Updated!');
            Session::flash('alert-class', 'alert-danger');
        }

        return redirect('club-hospitality/member-relation/members-relation-aeu/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\mem_relation  $mem_relation
     * @return \Illuminate\Http\Response
     */
    public function destroy(mem_relation $mem_relation,$id)
    {
        
        $memrelation=$mem_relation::where('id', $id)->deleteWithUserstamps();
        if($memrelation){ 
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }
        

        return redirect('club-hospitality/member-relation');
    }


public function restore(mem_relation $mem_relation,$id)
    {
        $restore = mem_relation::onlyTrashed()->find($id)->restore();
        if($restore){ 
            Session::flash('message', 'Data restored Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Failed to restore data !');
            Session::flash('alert-class', 'alert-danger');

         }
        return redirect('club-hospitality/member-relation/deleted');

}

}
