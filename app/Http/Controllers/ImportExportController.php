<?php

namespace App\Http\Controllers;

use App\Imports\BulkImport3;
use App\Imports\BulkImport2;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    //
    public function importExportView()
    {
        return view('importexport');
    }
    public function import()
    {
        Excel::import(new BulkImport2,request()->file('file'));

        return back();
    }
    public function export()
    {
        ob_end_clean(); 
     ob_start();
        return Excel::download(new \App\Exports\BulkImport2, 'bulkData.xlsx');
    }
    public function import2()
    {
        Excel::import(new BulkImport3,request()->file('file'));

        return back();
    }
    public function export2()
    {
        ob_end_clean(); 
     ob_start();
        return Excel::download(new \App\Exports\BulkImport3, 'bulkData.xlsx');
    }
}
