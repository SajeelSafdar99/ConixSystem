@extends('backend.layout.app')
@section('page-content')
    <style type="text/css">
        ul.breadcrumbee {
            padding: 10px 2px;
            list-style: none;
        }

        /* Display list items side by side */
        ul.breadcrumbee li {
            display: inline;
            font-family: "Roboto", "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
        }

        /* Add a slash symbol (/) before/behind each list item */
        ul.breadcrumbee li+li:before {
            padding: 8px;
            color: black;
            content: ">>\00a0";
        }

        /* Add a color to all links inside the list */
        ul.breadcrumbee li a {
            color: #17a2b8;
            text-decoration: none;
        }

        /* Add a color on mouse-over */
        ul.breadcrumbee li a:hover {
            color: black;
        }

        .profession{
            color: black !important;
            font-size: 16px !important;
        }

        .visitingCard{

            background-image:url('/assets/img/card_bg.jpeg');
            padding:20px;
            background-repeat:no-repeat;
            background-size:cover;
            min-height:250px;
            position:relative;
            color:#fff;
            text-shadow:1px 1px 1px #000;
            border-radius:20px;
            box-shadow:1px 1px 9px #000
        }
        .visitingCard .membership_number{
            position:absolute;
            bottom:0;
            left:200px;
            text-align:center;
        }
        .visitingCard .membership_number .mem_n{
            display:block;
            font-weight: bold;
        }
        .visitingCard .image {
            position :absolute;
            top:60px;
            font-size:18px
        }
        .visitingCard .image img{
            display:block;margin-bottom:10px;
            box-shadow: 1px 1px 7px #000;
            border-radius: 5px;
        }
        .visitingCard .valid{
            position:absolute;
            right:10px;
            bottom:20px
        } .visitingCard.family{
              background-image: url("/assets/img/card_bg_family.jpeg");
              color:#000;
              text-shadow:1px 1px 1px #fff;
          }

        .emp-profile{
            padding: 3%;
            margin-top: 3%;
            margin-bottom: 3%;
            border-radius: 0.5rem;
            background: #efefef;
        }
        .profile-img{
            text-align: center;
        }
        .profile-img img{
            width: 200px;
            height: 100%;
        }
        .profile-img .file {
            position: relative;
            overflow: hidden;
            margin-top: -20%;
            width: 70%;
            border: none;
            border-radius: 0;
            font-size: 15px;
            background: #212529b8;
        }
        .profile-img .file input {
            position: absolute;
            opacity: 0;
            right: 0;
            top: 0;
        }
        .profile-head h5{
            color: #333;
        }
        .profile-head h6{
            color: #0062cc;
        }
        .profile-edit-btn{
            border: none;
            border-radius: 1.5rem;
            width: 70%;
            padding: 2%;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
        }
        .proile-rating{
            font-size: 12px;
            color: #818182;
            margin-top: 5%;
        }
        .proile-rating span{
            color: #495057;
            font-size: 15px;
            font-weight: 600;
        }
        .profile-head .nav-tabs{
            margin-bottom:5%;
        }
        .profile-head .nav-tabs .nav-link{
            font-weight:600;
            border: none;
        }
        .profile-head .nav-tabs .nav-link.active{
            border: none;
            border-bottom:2px solid #0062cc;
        }
        .profile-work{
            padding: 14%;
            margin-top: -15%;
        }
        .profile-work p{
            font-size: 12px;
            color: #818182;
            font-weight: 600;
            margin-top: 10%;
        }
        .profile-work a{
            text-decoration: none;
            color: #495057;
            font-weight: 600;
            font-size: 14px;
        }
        .profile-work ul{
            list-style: none;
        }
        .profile-tab label{
            font-weight: 600;
        }
        .profile-tab p{
            font-weight: 600;
            color: #0062cc;
        }
        .card-body{
            overflow-x: auto;
        }
        .table thead > tr > th, .table tfoot > tr > th{
            min-width: 200px;
        }
    </style>
    <div class="br-pagebody">
        <div>
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Employee Attendance</h6>
            <div style="text-align: right;">

                <a href="{{url()->current()}}">
                    <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
                </a>
            </div>

            <ul class="breadcrumbee border-bottom-custom">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
                <li><a href>Employee Attendance List</a></li>
            </ul>

            @if($errors->any())
                <div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
                </div>
            @endif
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="col-xl-12 ">
                <!-- row -->


                <div class="form-layout form-layout-4 inner-content-address">
                    <form method="get">
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="barcode">Start Date</label>
                                    <input   value="{{request('start_date')}}" type="text" id="start_date" class="form-control" id="barcode" name="start_date">

                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="barcode">End Date</label>
                                    <input   value="{{request('end_date')}}" type="text" id="end_date" class="form-control"  name="end_date">

                                </div>
                            </div>    <div class="col-sm">
                                <div class="form-group">
                                    <label for="barcode">Department</label>
                                    <select name="dept" class="form-control">
                                        <option selected="selected" disabled="disabled">Select Department</option>
                                        @foreach($depts as $dept)
                                        <option value="{{$dept->id}}">{{$dept->desc}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="form-group">

                                    <button type="submit" name="search"  value="1" class="mg-t-30 btn btn-success"><i class="fa fa-search"></i> Search</button>
                                    <a href="{{str_replace('attend','attend/export',url()->full())}}" class="mg-t-30 btn btn-primary"><i class="fa fa-file"></i> Export </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div><!-- form-layout -->
            </div><!-- col-6 -->
            <div class="col-sm-12">
            <div class="card">
            <div class="card-body">
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
                        <th>Total</th>
                </tr>
                </thead>
                <tbody>

                @foreach($employees as $employee)
                @php $h2=[]; $d=0;$a=0;@endphp
                <tr>
                    <td>{{$employee->name}}<br><small>@if($employee->departments)({{$employee->departments->desc}})@endif</small></td>
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
    Total Working Hours:{{AddPlayTimeasd($h2)}}<br>
    Total Working Days: {{$d}}<br>
    Total Absent: {{$a}}
    Total Salary: {{number_format(round(($employee->current_salary/30)*$d))}}
</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
            </div>

        </div>
    </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

<style>
    .t1{
        display: block;
        text-align: center;
        color: #fff;
    }
    .t2{
        display: block;
        text-align: center;
        color: #fff;

    }
</style>
@endsection
@push('jscode')

    <script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>
        $( function() {
            $( "#start_date" ).datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        } );

        $( function() {
            $( "#end_date" ).datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        } );
    </script>
    <script type="text/javascript">
        $('#cnic').mask('00000-0000000-0');

    </script>

@endpush
