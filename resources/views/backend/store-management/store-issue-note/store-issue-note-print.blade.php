@extends('backend.layout.app')
@section('page-content')

<head>
   
<style type="text/css">

*{
    color: black ;
    font-size: 12px ;
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

b{ color: black; font-size: 18px !important;}
/* heading */

.boldee{
  font: 150% sans-serif !important;
}



p {  color: black !important;  font: 100% sans-serif !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */




h1 { font: bold 130% sans-serif !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; color: black !important; padding-top: 27px !important; }

header { margin: 0 0 3em; }
span {float:left !important; }


th, td {
  padding: 10px !important;
  text-align: left !important;
  font: 130% sans-serif !important;
  height: 50px
}
th {
  padding: 10px !important;
  text-align: left !important;
  background-color: white !important;
  color: black !important;
  font: 30% sans-serif !important;
  height: 70px
}

strong{
font: bold 100% sans-serif !important;
}

.thheighty{
  height: 150px !important;
}

.goleft{
  float: left !important;
}

.goleftopp{
  float: right !important;
}
 .middiv{
  text-align: center !important;
  margin-top: 38px !important;
 }

@page {
  size: A4;
  margin: 0;

}
@media print {
  html, body {
    width: 250mm;
    height: 200mm;
  }
}

.container{
  min-width: 100% !important;
  } .card{
  min-width: 100% !important;
}

.widthclass{
  width: 670px !important;
}
.widthclass2{
  width: 500px !important;
}
 
p.border{
  font-size: 20px !important;
  border-color: #000000 !important;
}


p.bordered{
  font-size: 16px !important;
   border-color: #000000 !important;
}
 table.myFormat tr td { font-size: 12px !important; }
 table.myFormat tr th { font-size: 11px !important; }
</style>

  </head>
    <body>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara hidden-print">Store Issue Note</h6>
        <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
   <li><a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('store-management/store-issue-note-vue') }}">Store Issue Note List</a></li>
  <li><a href>Print Issue Note</a></li>
</ul>


<div class="container">
  <div class="card">
<div class="card-header">
  <div class="float-left"><h1>AFOHS</h1></div>

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong><h1>STORE ISSUE NOTE</h1></strong> <br></span>

 

</div>
<div class="card-body">
<div class="row mb-4">


<div class="col-sm-4">
<div><strong>COMPANY: </strong> &nbsp&nbsp<strong>{{coaaccountname($receiptdata->unit)}}</strong></div>
<div><strong>STORE LOCATION:</strong> &nbsp&nbsp{{ salescategory($receiptdata->store_location) }}</div>
<div><strong>DEPARTMENT:</strong> &nbsp&nbsp{{ storeDepartmentName($receiptdata->department) }}</div>
</div>

<div class="col-sm-2">

</div>


<div class="col-sm-1">

</div>

<div class="col-sm-5">
<div><strong>ISSUE NOTE # : </strong> &nbsp&nbsp<strong>{{$receiptdata->id}}</strong></div>
<div><strong>DATE : </strong> &nbsp&nbsp<strong>{{ formatDateToShow($receiptdata->invoice_date) }}</strong></div>

</div>

</div>



<!-- <div>
<u><strong class="text-uppercase">{{ salesrestaurantname($receiptdata->store_location) }} </strong></u></div> -->
<br>
<div class="table-responsive-sm" >
<table class="table table-bordered myFormat">
<thead>
<tr>
  <th class="text-left"><strong>SR #</strong></th>
<th class="text-left"><strong>CODE</strong></th>
<th class="text-left"><strong>ITEM NAME</strong></th>
<th class="text-left"><strong>QTY</strong></th>
<th class="text-left"><strong>PRICE</strong></th>

 
<!--  <th class="text-left"><strong>LOCATION</strong></th>
<th class="text-left"><strong>DEPARTMENT</strong></th>  -->
<th class="text-left"><strong>INSTRUCTIONS</strong></th>
<!-- <th class="text-right"><strong>COST</strong></th>
<th class="text-right"><strong>TOTAL</strong></th> -->

</tr>
</thead>

<tbody>
 @php $divide=1; @endphp
@foreach($bookingsubdata as $sub)
<tr>
<td class="text-left">{{$divide}}</td>
<td class="text-left">{{ $sub->item_code }}</td>
<td class="text-left">{{ $sub->item_details }}</td>
<td class="text-left">{{ $sub->qty }}</td>
<td class="text-left">{{ $sub->old_purchase_price }}</td>

<!-- <td class="text-right">{{ $sub->sub_total_price }}</td> -->
<!--  <td class="text-left">{{ salesrestaurantname($sub->store_location) }}</td>
<td class="text-left">{{ storeDepartmentName($sub->department) }}</td>   -->
<td class="text-left">{{ $sub->instructions }}</td>
</tr>
 @php $divide++; @endphp
@endforeach

</tbody>

</table>

</div>
<div class="row">
<div class="col-lg-4 col-sm-5">


</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>

<tr>
<td class="text-left">
<strong>GRAND TOTAL : </strong>
</td>
<td class="text-right">
  <strong><p  class="bordered border border-dark"> &nbsp <strong>@if($receiptdata->grand_total) {{$receiptdata->grand_total}} @else 0 @endif</strong> &nbsp</p></strong>
</td>
</tr>


<tr>
<td class="text-left">
<strong>PREPARED BY : </strong>
</td>
<td class="text-left">
<STRONG class=" text-uppercase">@if($receiptdata->created_by){{usernames($receiptdata->created_by)}}@endif</STRONG>
</td>
</tr>


</tbody>
</table>

</div>

</div>

<div class="row">
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important"><STRONG>PRINTED BY : </STRONG> &nbsp<u class=" text-uppercase"><STRONG>@if($activeuser){{usernames($activeuser)}}@endif</STRONG></u></p>
</div>
<div class="col-lg-3 col-sm-2"></div>

</div>


</div>
</div>

</div>



</div>
</div>
</body>
@endsection



@push('jscode')

<script type="text/javascript">
  $( document ).ready(function() {

 window.print();
});
</script>
@endpush
