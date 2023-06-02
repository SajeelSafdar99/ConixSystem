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
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10  hidden-print margara">Running Kitchen Orders</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
            <!--     <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button> -->
                <a href="{{ url('food-and-beverage/reports/running-kitchen-order') }}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
    <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
    <li><a href="{{ url('finance-and-management/food-and-beverage/reports') }}">Food & Beverage Reports</a></li>
    <li><a href="{{ url('finance-and-management/food-and-beverage/reports/daily-reports') }}">Daily Reports</a></li>
    <li><a href="{{ url('food-and-beverage/reports/running-kitchen-order') }}">Running Kitchen Orders List</a></li>
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
          <div class="col-md-1"><p style="color: black;">INVOICE DATE:</p></div>
  <div class="col-md-4">
    <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="invdate" id="invdate" autocomplete="off" value="{{$date_search}}">
  </div>


    <div class="col-md-1"><p style="color: black;">RESTAURANT:</p></div>
  <div class="col-md-4">
  
                        <select class="form-control" name="restaurant" id="restaurant">
                           <option value="0">All</option>
                            @foreach($restaurants as $restaurant)
                                <option  value="{{$restaurant->id}}" @if($rest_search==$restaurant->id) selected @endif>
                                    {{$restaurant->desc}}
                                </option>
                            @endforeach
                        </select></div>

                   

                     <div class="col-md-2">
                     
<button type="submit" id="searchbtn" class="btn btn-info"><i class="fa fa-search"></i>Search</button>  </div>
                  
 
                 </div>
 <br>
</div>
</form>
  @php $mysub=''; @endphp


<div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
  <h3>RUNNING KITCHEN ORDERS</h3>
</div>

<div style="background-color: black; padding: 5px;">
 <div class="row" style="width: 100%; height: 560px; overflow-y: scroll; overflow: auto;">
@foreach($sales as $sale)
@if($sale->restaurant_location == $rest_search)
    <div class="col-md-3">
      <a onclick="return confirm('Are you sure ?')" href="{{ url('food-and-beverage/sales/sales-aeu/confirmorder') }}/{{ $sale->id }}">
<div class="card border-success mb-3  text-success" style="max-width: 30rem; height: 34rem; overflow-y: scroll; overflow: auto; font-size: 19px; background-color: black; cursor: pointer;">
  <div class="card-header text-center"><strong>INVOICE #: {{$sale->invoice_no}} </strong></div>

   <div class="card-header"><strong class="float-left">{{formatDateToShow($sale->date)}} </strong><strong class="float-right">{{$sale->time}} </strong></div>
  <div class="card-body text-success">
    <h5 class="card-title text-success"><strong>TABLE #: {{salestablename($sale->table_definition)}}</strong></h5>

    @foreach($salessubs as $sub)
     @if($sub->sales_id == $sale->id)
      <div class="card-text"><strong>
       
        @if($mysub!=$sub->kot_no)
         ########## {{$mysub=$sub->kot_no}} ##########
           <br>
        @endif
         
   {{$sub->qty}}   &nbsp&nbsp&nbsp&nbsp ✕ &nbsp&nbsp&nbsp&nbsp  {{$sub->item_code}} &nbsp&nbsp&nbsp&nbsp   {{$sub->item_details}}
   </strong></div>
    @endif
    @endforeach
  </div>
</div>
</a>
</div>
@elseif($rest_search == 0)
<div class="col-md-3">
      <a onclick="return confirm('Are you sure ?')" href="{{ url('food-and-beverage/sales/sales-aeu/confirmorder') }}/{{ $sale->id }}">
<div class="card border-success mb-3  text-success" style="max-width: 30rem; height: 34rem; overflow-y: scroll; overflow: auto; font-size: 19px; background-color: black; cursor: pointer;">
  <div class="card-header text-center"><strong>INVOICE #: {{$sale->invoice_no}} </strong></div>

   <div class="card-header"><strong class="float-left">{{formatDateToShow($sale->date)}} </strong><strong class="float-right">{{$sale->time}} </strong></div>
  <div class="card-body text-success">
    <h5 class="card-title text-success"><strong>TABLE #: {{salestablename($sale->table_definition)}}</strong></h5>

    @foreach($salessubs as $sub)
     @if($sub->sales_id == $sale->id)
      <div class="card-text"><strong>
       
        @if($mysub!=$sub->kot_no)
         ########## {{$mysub=$sub->kot_no}} ##########
           <br>
        @endif
         
   {{$sub->qty}}   &nbsp&nbsp&nbsp&nbsp ✕ &nbsp&nbsp&nbsp&nbsp  {{$sub->item_code}} &nbsp&nbsp&nbsp&nbsp   {{$sub->item_details}}
   </strong></div>
    @endif
    @endforeach
  </div>
</div>
</a>
</div>
@endif
@endforeach
</div>

</div>

     
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')
 
 
<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>

        $(function () {
            $("#invdate").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
            })
        });
</script>
@endpush
