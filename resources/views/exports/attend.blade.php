<table class="table table-striped">

                <thead>
                <tr>
                    <th>Employee</th>
                    @php

                        if($count>0){
    $x=(int)$count;
}
else{
    $x=6;
}
                        @endphp
                    @for($i=0;$i<=$x;$i++)
                       <th>
                           @if($x>6)
                               <span class="t1">{{date('D',strtotime((request('end_date')?formatDate(request('end_date')):'').' -'.($x-$i).'days'))}}</span>
                               <span class="t2">{{date('j M y',strtotime((request('end_date')?formatDate(request('end_date')):'').' -'.($x-$i).'days'))}}</span>
                           @else


                               <span class="t1">{{date('l',strtotime((request('end_date')?formatDate(request('end_date')):'').' -'.($x-$i).'days'))}}</span>
                           <span class="t2">{{date('jS F y',strtotime((request('end_date')?formatDate(request('end_date')):'').' -'.($x-$i).'days'))}}</span>
                           @endif

                       </th>
                        @endfor
                        <th>Total Number of hours</th>
                        <th>Total Number of working days</th>
                        <th>Total Number of absent</th>
                        <th>Total salary</th>
                        <th>Actual salary</th>
                </tr>
                </thead>
                <tbody>

                @foreach($employees as $employee)
                @php $h2=[]; $d=0;$a=0;@endphp
                <tr>
                    <td>{{$employee->name}}<br><small>({{$employee->departments->desc}})</small></td>
                    @for($i=0;$i<=$x;$i++)
                        <td class="text-center">
                            @php
                            $visits=$employee->visits()->whereRaw("DATE(created_at) = '".date('Y-m-d',strtotime((request('end_date')?formatDate(request('end_date')):'').' -'.($x-$i).'days'))."'")->get();
                                $h=[];
                            @endphp
                            @if(count($visits)>0)
                            @php $d++;@endphp
                                @foreach($visits as $visit)
                           <span class="text-center" style="display: block">@if($visit->in_out==0) In @else Out @endif: {{date('h:i a',strtotime($visit->created_at))}} @if($visit->in_out==1 && $visit->workingHours) <span style="background: #eaa338;
    color: #fff;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 5px;"> {{$visit->workingHours}} @php $h[]=$visit->workingHours.':00' @endphp</span> @endif</span>
                          @endforeach
                          <span class="text-center" style="background: #5da909;
    color: #fff;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 5px;">Total Number of hours: {{$h2[]=AddPlayTimeasd($h)}}</span>
@else
@php $a++; @endphp

                                    @endif


                        </td>
                    @endfor
<td>
    {{AddPlayTimeasd($h2)}}</td><td>
     {{$d}}</td><td>
     {{$a}}</td><td>
                        {{number_format(round(($employee->current_salary/30)*$d))}}</td><td>
     {{number_format($employee->current_salary)}}
</td>
                </tr>
                @endforeach
                </tbody>
            </table>
