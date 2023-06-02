@extends('backend.layout.app')
@section('page-content')

<head>
		<meta charset="utf-8">
		
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



p {  color: black !important;  font: 110% sans-serif !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */




h1 { font: bold 120% sans-serif !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; color: black !important; padding-top: 25px !important; }

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
  font: 130% sans-serif !important; 
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
    height: 297mm;
  }
}

.container{
  min-width: 100% !important;
  } .card{
  min-width: 100% !important;
}

.widthclass{
  width: 637px !important;
}
.widthclass2{
  width: 400px !important;
}

</style>

	</head>
<div class="br-pagebody">
        <div>

          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print">Invoice</h6>

         <div style="text-align: right;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

 
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
   <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/sales') }}">Sales List</a></li>
  <li><a href>Print Invoice</a></li>
</ul>



<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="60" width="110">
 
<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass">
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>SALES <br> INVOICE</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
<div> 

</div>
<div><strong>Invoice #:</strong>&nbsp&nbsp{{$saledata->invoice_no}}</div>
<div><strong>Date:</strong>&nbsp&nbsp{{formatDateToShow($saledata->date)}}</div>
<div><strong>Time:</strong>&nbsp&nbsp{{$saledata->time}}</div>
<div><strong>Type:</strong>&nbsp&nbsp @if($saledata->type==1) Guest @elseif($saledata->type==0) Member @elseif($saledata->type==3) Employee @endif</div>
<div><strong>Name:</strong>&nbsp&nbsp {{$saledata->name}}</div>
<div><strong>Customer #:</strong>&nbsp&nbsp @if($saledata->type==1){{$saledata->customer_id}} @elseif($saledata->type==0){{$saledata->customer_id}} @elseif($saledata->type==3){{$saledata->customer_id}} @endif</div>
<div><strong>Contact #:</strong>&nbsp&nbsp{{$saledata->contact}}</div>
<div><strong>Family Member:</strong>&nbsp&nbsp{{invoicesfamilyname($saledata->family)}} @if($saledata->family)(@endif{{familyrelationship(invoicesfamilyrelation($saledata->family))}}@if($saledata->family))@endif</div>
<div><strong>Discount Card #:</strong>&nbsp&nbsp{{$saledata->discount_card_no}}</div>

</div>

<div class="col-sm-6">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
<div>

</div>
<div><strong>Restaurant:</strong>&nbsp&nbsp{{salesrestaurantname($saledata->restaurant_location)}}</div>
<div><strong>Currency:</strong>&nbsp&nbsp{{salescurrency($saledata->currency) }}</div>
<div><strong>Captain:</strong> &nbsp&nbsp{{saleswaitername($saledata->waiter_definition)}}</div>
<div><strong>Table #:</strong> &nbsp&nbsp{{salestablename($saledata->table_definition)}}</div>
<div><strong>Order Type:</strong> &nbsp&nbsp{{$saledata->order_type}}</div>
<div><strong>Covers:</strong> &nbsp&nbsp{{$saledata->covers}}</div>

<div><strong>Category:</strong> &nbsp&nbsp{{salescategory($saledata->category)}}</div>
<div><strong>Sub-Category:</strong> &nbsp&nbsp{{salessubcategory($saledata->sub_category)}}</div>
<div><strong>Payment Mode:</strong> &nbsp&nbsp{{accountheadname($saledata->account_head)}}</div>
</div>

</div>

<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>

<th class="left"><strong>Sr #</strong></th>

<th class="left"><strong>Qty</strong></th>
<th class="left"><strong>Code</strong></th>
<th class="left"><strong>Item</strong></th>
<th class="left"><strong>Price</strong></th>
  <th class="left"><strong>Sub-total</strong></th>
<th class="left"><strong>KOT #</strong></th>
<th class="left"><strong>Status</strong></th>

</tr>
</thead>

<tbody>
    <tr>
      @php $divide=1; @endphp
  @foreach($salesubdata as $sub)
<tr>
<td class="left">{{$divide}}</td>

<td class="left">{{ $sub->qty }}</td>
<td class="left">{{$sub->item_code}}</td>
  <td class="left">{{$sub->item_details}}</td>
   <td class="left">{{$sub->sale_price}}</td>
<td class="left">{{$sub->sub_total_price}}</td>
<td class="left">{{$sub->kot_no}}</td>
<td class="left">{{$sub->status}}</td>
</tr>
@php $divide++; @endphp
 @endforeach
</tr>

</tbody>
</table>

</div>


<div class="row">
<div class="col-lg-4 col-sm-5">
<strong>COMMENT / SPECIAL REQUIREMENTS:</strong>

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear">
<tbody>
<tr>
<td class="left">
<strong>GROSS</strong>
</td>
<td class="right">@if($saledata->gross)
 {{ $saledata->gross }} @else 0
 @endif</td>
</tr>
@if($saledata->discount==!NULL)
<tr>
<td class="left">
<strong>DISCOUNT </strong>
</td>
<td class="right">{{$saledata->discount}}</td>
</tr>
@endif
<tr>
<td class="left">
<strong>SUB TOTAL</strong>
</td>
<td class="right">@if($saledata->sub_total)
 {{ $saledata->sub_total }} @else 0
 @endif</td>
</tr>
@if($saledata->tax==!NULL)
<tr>
<td class="left">
<strong>TAX </strong>
</td>
<td class="right">{{$saledata->tax}}</td>
</tr>
@endif
@if($saledata->service_charges==!NULL)
<tr>
<td class="left">
<strong>SERVICE CHARGES </strong>
</td>
<td class="right">{{$saledata->service_charges}}</td>
</tr>
@endif
<tr>
<td class="left">
<strong>GRAND TOTAL</strong>
</td>
<td class="right">
<strong>@if($saledata->grand_total)
 {{ $saledata->grand_total }} @else 0
 @endif</strong>
</td>
</tr>
</tbody>
</table>

</div>

</div>
<br>
<div class="row">
   <div class="col-lg-5 col-sm-5">
  <p>MANAGER SIGNATURE:&nbsp_______________</p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <p>&nbsp&nbspGUEST SIGNATURE:&nbsp_______________</p>
 </div>
</div>

</div>


</div>
<br>
<br>
<div class="row">
  <div class="col-lg-12">
<p style="text-align: left !important;">&nbsp&nbsp&nbspWe highly appreciate your presence at AFOHS Club. Thank you for visiting.</p>
  </div>
</div>
</div>


</div>
</div>
@endsection