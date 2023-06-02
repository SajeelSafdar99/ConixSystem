@extends('backend.layout.app')
@section('page-content')
    <style type="text/css">
        .header {
  background-color:     #B0B0B0;
  text-align: center;
  font-size: 18px;
  color:black;
}

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
        ul.breadcrumbee li + li:before {
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

        .floatydivs {
            float: left;
            margin-right: 149px;
            margin-left: 100px;
        }

        .desktop-screen-design {
            width: 100% !important;
            padding-bottom: 70px;
        }

        .block {
            display: block;
            width: 20%;
            line-height: 50px;
            float: left;
        }


        .w3-black, .w3-hover-black:hover {
            color: #fff !important;
            background-color: #dddddd !important;
        }

        .w3-button:hover {
            color: #000 !important;
            background-color: #ccc !important;
        }

        .w3-red {
            color: #fff !important;
            background-color: #616161 !important;
        }

        .w3-red:hover {
            color: #fff !important;
            background-color: #616161 !important;
        }


        .w3-bar {
            width: 100%;
            height: 60px;
            overflow: hidden;
        }

        .w3-border {
            border: 1px solid #ccc !important;
        }

        .w3-bar .w3-bar-item {
            padding: 8px 16px;
            float: left;
            width: 20%;
            border: none;
            display: block;
            outline: 0;
            height: 60px;
        }

        .w3-bar .w3-button {
            white-space: normal;
        }

        th {
            color: #fff !important;
        }
        
        .headingsettings {
            font-size: 20px !important;
        }
        input:focus{
    outline: none !important;
}

input[readonly] {
    background: transparent !important;
    border: none;
    border-bottom: none;
    width:100%;
}
.cardcss{
    height: 200px !important;
  width: 50% !important;
  border-style: solid !important;
  border-width: thick !important;
  border-color: white !important;
}

.cardcsstwo{
    height: 200px !important;
  width: 100% !important;
  border-style: solid !important;
  border-width: thick !important;
  border-color: white !important;
}

.areabox{cursor:pointer !important;}
@page {
  size: A4;
  margin: 0;

}
@media print {
  html, body {
    width: 250mm;
    height: 297mm;
  }
}
    </style>

    <div class="br-pagebody">
        <div>
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10  hidden-print"> Sales Report</h6>
            <div style="text-align: right;">
                <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
                <a href="{{ url('finance-and-management/finance-sales-report') }}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
    <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
    <li><a href="{{ url('finance-and-management/reports') }}">Finance Management Reports</a></li>
    <li><a href="{{ url('finance-and-management/finance-sales-report') }}">Sales Report List</a></li>
    </ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


<div>
 <form>

<div class="hidden-print">
<div class="row">
      <div class="col-lg">      <p style="color: black;">Begin Date:</p>
                            <input value="{{$start_date}}" class=" form-control tablikebutton" type="text" autocomplete="off" placeholder="From (dd/mm/yyyy)" 
                                   id="start_date"
                                   name="start_date">
                               </div>
                                    <div class="col-lg">
                        
                            <p style="color: black;">End Date:</p>
                            <input value="{{$end_date}}" class="form-control tablikebutton" type="text" autocomplete="off" placeholder="To (dd/mm/yyyy)" 
                                   id="end_date" name="end_date">
                               </div>
                         <div class="col-lg">

                        <button style="    margin-top: 32px;" type="submit" id="searchbtn" class="btn btn-info"><i
                                class="fa fa-search"></i>Search
                        </button>

                    </div>
                </div>
 <br>
</div>
</form>

<div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
  <h3>SALES REPORT</h3>
<hr>
</div>

@if($start_date && $end_date)
<div style="text-align: center; color: black;">
  <h5>Date = From {{$start_date}} To {{$end_date}}</h5>
<hr>
</div>
@endif


   <!--   <div class="header" style="text-transform: uppercase; "><b>ROOM BOOKING</b></div>  -->
            <div id="London2" class="w3-container w3-border city">
                <div class="table-wrapper">
                    <table id="usersTable2" class="table display nowrap datatable">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-10p">Module</th>
                            <th class="wd-5p">Gross Sale</th>
                            <th class="wd-5p">Disc.</th>
                            <th class="wd-5p">Net Sale</th>
                            <th class="wd-5p"> Tax</th>
                            <th class="wd-5p">Total Sale</th>
                            <th class="wd-5p">Cash Sale</th>
                            <th class="wd-5p">Credit Sale</th>
                            
                            <th class="wd-5p">Paid Sale</th>
                            <th class="wd-5p">Unpaid Sale</th>
                            
                        </tr>
                        </thead>

                        <tbody>
@php
$i=0;
    @endphp
@foreach($types as $type)
@php
$i++; @endphp

                         <tr>
                          <td>{{$i}}</td>
                          <td>{{$type->name}}</td>

              @if($type->name == 'Room Booking')            
                  @php $gross = 0; @endphp
     @foreach($rooms as $room)
      @if(is_numeric($room->total_charges))

        @php $gross+= $room->total_charges; @endphp
        @endif 
         
      @endforeach
     
<td>{{number_format($gross)}}</td>

@elseif($type->name == 'Food and Beverage')           
                  @php $gross = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->gross))

        @php $gross+= $sale->gross; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($gross)}}</td>

@else 
<td></td>
 @endif
              
                         


 @if($type->name == 'Room Booking')          
    @php $discount = 0; @endphp
     @foreach($rooms as $room)
      @if(is_numeric($room->discount_amount))

        @php $discount+= $room->discount_amount; @endphp
        @endif 
         
@endforeach
   <td >{{number_format($discount)}}</td>

@elseif($type->name == 'Food and Beverage')           
                  @php $discount = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->discount))

        @php $discount+= $sale->discount; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($discount)}}</td>

@else 
<td></td>
 @endif


@if($type->name == 'Room Booking')
    @php $net = 0; @endphp
     @foreach($rooms as $room)
      @if(is_numeric($room->grand_total))

        @php $net+= $room->grand_total; @endphp
        @endif 
         
@endforeach
   <td >{{number_format($net)}}</td>

   @elseif($type->name == 'Food and Beverage')           
                  @php $net = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->sub_total))

        @php $net+= $sale->sub_total; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($net)}}</td>

@else 
<td></td>
 @endif
 


  @if($type->name == 'Room Booking') <td>0</td>

 @elseif($type->name == 'Food and Beverage')           
                  @php $tax = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->tax))

        @php $tax+= $sale->tax; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($tax)}}</td>

@else 
<td></td>
 @endif



@if($type->name == 'Room Booking')
     @php $total = 0; @endphp
     @foreach($rooms as $room)
      @if(is_numeric($room->grand_total))

        @php $total+= $room->grand_total; @endphp
        @endif 
         
@endforeach
   <td >{{number_format($total)}}</td>

@elseif($type->name == 'Food and Beverage')           
                  @php $total = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total))

        @php $total+= $sale->grand_total; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($total)}}</td>

@else 
<td></td>
 @endif


 @if($type->name == 'Room Booking')
 
   <td>{{number_format($cashreceipts)}}</td>

   @elseif($type->name == 'Food and Beverage')           
                  @php $cash = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total) && $sale->completed==2 && in_array($sale->account_type,$acccash))

        @php $cash+= $sale->grand_total; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($cash)}}</td>

@else 
<td></td>
 @endif


@if($type->name == 'Room Booking')
               <td>{{number_format($cashreceipts2)}}</td>  

               @elseif($type->name == 'Food and Beverage')           
                  @php $credit = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total) && $sale->completed==2 && in_array($sale->account_type,$acccredit))

        @php $credit+= $sale->grand_total; @endphp
        @endif 
         
      @endforeach 
<td>{{number_format($credit)}}</td>             
@else 
<td></td>
 @endif


@if($type->name == 'Room Booking')
                <td>{{number_format($paid_rooms)}}</td>
  @elseif($type->name == 'Food and Beverage')           
                  @php $paid = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total) && $sale->completed==2)

        @php $paid+= $sale->grand_total; @endphp
        @endif 
      @endforeach 
<td>{{number_format($paid)}}</td>

                @else 
<td></td>
 @endif


@if($type->name == 'Room Booking')
              <td>{{number_format($total-$paid_rooms)}}</td>

              @elseif($type->name == 'Food and Beverage')           
                
<td>{{number_format($total-$paid)}}</td>
@else 
<td></td>
 @endif

                 </tr>
                        @endforeach  
                        </tbody>

                    </table>
                </div><!-- table-wrapper -->
            </div>
<br> <br> 

<table class="table display nowrap datatable" >
     <thead>

                        <tr style="background-color:#1288ce;">
                            <th class="wd-5p">Total : </th>
<tr>

                        </tr>
                    
                        </thead>
</table>


</div>
     
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
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


 
@endpush
