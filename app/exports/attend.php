<?php
namespace App\exports;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\hr_employment;
class attend implements FromView
{
 public function view(): View
    {
        $request=Request::capture();
        $employees=hr_employment::query();
        $count=0;
   //$depts= hr_department::where('status',1)->get();
        if($request->get('start_date') && $request->get('end_date')){
            $now =strtotime(formatDate($request->get('end_date'))); // or your date as well
            $your_date = strtotime(formatDate($request->get('start_date')));
            $datediff = $now - $your_date;

            $count= round($datediff / (60 * 60 * 24));
        }
    if($request->get('dept') ){
        $employees->where('department',$request->get('dept'));
    }
    $employees= $employees->get();
//        echo $count;
    return view('exports/attend')->withEmployees($employees)->withCount($count);

}
}