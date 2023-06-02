<?php

namespace App\Http\Controllers;

use App\finance_invoice;
use Illuminate\Http\Request;
use DataTables;
use Session;


class FinanceInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request, finance_invoice $finance_invoice)
    {

        return view('backend/finance-and-management/finance-invoices/finance-invoices-aeu');
    }

    public function indexdt(Request $request, finance_invoice $finance_invoice)
    {


        $invoices = finance_invoice::get();
        return DataTables::of($invoices)
           /* ->addColumn('status', function ($invoices) {
                if ($invoices->status == 1) {
                    return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10">Active</button>';
                } else {
                    return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10">In-Active</button>';
                }
        
    
            })

            ->addColumn('button', function ($invoices) {
                return '<button class="buttoncolor" title="Edit"><a style="color:#000000;" href="' . url('club-hospitality/member-relation/members-relation-aeu/') . '/' . $mem_relations->id . '"><i class="fas fa-edit"></i></a></button>' //. ' <button class="buttoncolor" title="Delete"><a style="color:#000000;" href="' . url('club-hospitality/member-relation/delete') . '/' . $mem_relations->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a></button>'
                ;
            })*/
            ->rawColumns([''])
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
        $lastval = finance_invoice::withTrashed()->latest('id')->first();
        $num     = 0;

        if ($lastval) {
            $num                      = $lastval->id + 1;
            $data['increment_number'] = $num;

        } else {
            $num                      = 1;
            $data['increment_number'] = $num;
        }
       
       
        return view('backend/finance-and-management.finance-invoices.finance-invoices-aeu', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\finance_invoice  $finance_invoice
     * @return \Illuminate\Http\Response
     */
    public function show(finance_invoice $finance_invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\finance_invoice  $finance_invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(finance_invoice $finance_invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\finance_invoice  $finance_invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, finance_invoice $finance_invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\finance_invoice  $finance_invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(finance_invoice $finance_invoice)
    {
        //
    }
}
