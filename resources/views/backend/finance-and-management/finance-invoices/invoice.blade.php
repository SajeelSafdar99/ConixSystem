@extends('backend.layout.app')
@section('page-content')

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="//www.opensource.org/licenses/mit-license/">
    <script src="script.js"></script>
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
  width: 620px !important;
}
.widthclass2{
  width: 400px !important;
}
 
 table.myFormat tr td { font-size: 12px !important; }
 table.myFormat tr th { font-size: 11px !important; }
</style>

  </head>
    <body>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print">Invoices</h6>
         <div style="text-align: right;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Print Invoice</a></li>
</ul>



<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="60" width="110">

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>INVOICE<br><br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">


<div class="col-sm-2">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Name:</strong>&nbsp&nbsp {{$receiptdata->name}}</div>
<div><strong>Category:</strong>&nbsp&nbsp @if($receiptdata->invoice_type==1) Guest @else Member @endif</div>

@if($receiptdata->mem_no)
<div><strong>Membership #:</strong>&nbsp&nbsp{{$receiptdata->mem_no}}</div>
@elseif($receiptdata->customer_id)
<div><strong>Guest #:</strong>&nbsp&nbsp{{$receiptdata->customer_id}}</div>
@endif

<!-- <div><strong>CNIC #:</strong>&nbsp&nbsp{{$receiptdata->cnic}}</div> -->
<div><strong>Contact #:</strong>&nbsp&nbsp{{$receiptdata->contact}}</div>
<!-- <div><strong>Email:</strong>&nbsp&nbsp{{$receiptdata->email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp{{$receiptdata->address}}</div> -->

</div>


<div class="col-sm-2">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Invoice #:</strong> &nbsp&nbsp{{$receiptdata->id}}</div>
<div><strong>Issue Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->invoice_date) }}</div>
<div><strong>Payment Method:</strong> &nbsp&nbsp{{ transTypesChargesTypes($receiptdata->account) }}</div>
</div>

</div>

<div class="table-responsive-sm" style="margin-top: -40px !important;">
<table class="table table-striped myFormat">
<thead>
<tr>
<th class="left"><strong>Description</strong></th>
<th class="left"><strong>Family Member</strong></th>
<th class="right"><strong>Charges</strong></th>
<th class="right"><strong>Start Date</strong></th>
<th class="right"><strong>End Date</strong></th>
  <th class="center"><strong>Days</strong></th>
  <th class="center"><strong>Qty</strong></th>
<th class="right"><strong>Total</strong></th>

</tr>
</thead>

<tbody>

@foreach($bookingsubdata as $sub)
<tr>
<td class="left">{{transTypesChargesTypes($sub->charges_type)}}</td>
<td class="left">{{ invoicesfamilyname($sub->family)}} ({{familyrelationship(invoicesfamilyrelation($sub->family))}})</td>
<td class="right">{{ $sub->charges_amount }}</td>
  <td class="center">{{ formatDateToShow($sub->start_date) }}</td>
   <td class="center">{{ formatDateToShow($sub->end_date) }}</td>
<td class="right">{{ $sub->days }}</td>
<td class="right">{{ $sub->qty }}</td>
<td class="right">{{ $sub->total }}</td>

</tr>
@endforeach

</tbody>

</table>

</div>
<div class="row">
<div class="col-lg-4 col-sm-5">
{{$receiptdata->amount_in_words}}<br>
{{$receiptdata->comments}}
<br>
<strong>Note: </strong><p>Thank you for your business. This is a computer generated invoice. Please contact us if you have questions or issues with this bill. </p>

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>
<tr>
<td class="left">
<strong>SUB-TOTAL</strong>
</td>
<td class="right">{{$receiptdata->total}}</td>
</tr>

@if($receiptdata->discount_amount)
<tr>
<td class="left">
<strong>DISCOUNT </strong>
</td>
<td class="right">{{$receiptdata->discount_amount}}</td>
</tr>
@elseif($receiptdata->discount_percentage)
<tr>
<td class="left">
<strong>DISCOUNT </strong>
</td>
<td class="right">{{$receiptdata->discount_percentage}}%</td>
</tr>
@endif

@if($receiptdata->extra_charges)
<tr>
<td class="left">
 <strong>EXTRA CHARGES</strong>
</td>
<td class="right">{{$receiptdata->extra_charges}}</td>
</tr>
@elseif($receiptdata->extra_percentage)
<tr>
<td class="left">
 <strong>EXTRA CHARGES</strong>
</td>
<td class="right">{{$receiptdata->extra_percentage}}%</td>
</tr>
@endif

@if($receiptdata->tax_charges)
<tr>
<td class="left">
 <strong>TAX</strong>
</td>
<td class="right">{{$receiptdata->tax_charges}}</td>
</tr>
@elseif($receiptdata->tax_percentage)
<tr>
<td class="left">
 <strong>TAX</strong>
</td>
<td class="right">{{$receiptdata->tax_percentage}}%</td>
</tr>
@endif

<tr>
<td class="left">
<strong>GRAND TOTAL</strong>
</td>
<td class="right">
<strong>{{$receiptdata->grand_total}}</strong>
</td>
</tr>

<tr>
<td class="left">
<strong>AMOUNT PAID</strong>
</td>
<td class="right">
<strong>{{$amount_paid?$amount_paid:0}}</strong>
</td>
</tr>

<tr>
<td class="left">
<strong>BALANCE</strong>
</td>
<td class="right">
<strong>{{$resultant?$resultant:0}}</strong>
</td>
</tr>


</tbody>
</table>

</div>

</div>

<div class="row" style="margin-top: -20px !important;">
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important">MANAGER SIGNATURE:&nbsp_______________</p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <p style="font-size: 12px !important">&nbsp&nbspMEMBER SIGNATURE:&nbsp_______________</p>
 </div>
</div>


</div>
</div>


  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="60" width="110">

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>INVOICE<br><br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">


<div class="col-sm-2">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Name:</strong>&nbsp&nbsp {{$receiptdata->name}}</div>
<div><strong>Category:</strong>&nbsp&nbsp @if($receiptdata->invoice_type==1) Guest @else Member @endif</div>

@if($receiptdata->mem_no)
<div><strong>Membership #:</strong>&nbsp&nbsp{{$receiptdata->mem_no}}</div>
@elseif($receiptdata->customer_id)
<div><strong>Guest #:</strong>&nbsp&nbsp{{$receiptdata->customer_id}}</div>
@endif
<!-- <div><strong>CNIC #:</strong>&nbsp&nbsp{{$receiptdata->cnic}}</div> -->
<div><strong>Contact #:</strong>&nbsp&nbsp{{$receiptdata->contact}}</div>
<!-- <div><strong>Email:</strong>&nbsp&nbsp{{$receiptdata->email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp{{$receiptdata->address}}</div> -->

</div>


<div class="col-sm-2">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Invoice #:</strong> &nbsp&nbsp{{$receiptdata->id}}</div>
<div><strong>Issue Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->invoice_date) }}</div>
<div><strong>Payment Method:</strong> &nbsp&nbsp{{ transTypesChargesTypes($receiptdata->account) }}</div>
</div>

</div>

<div class="table-responsive-sm" style="margin-top: -40px !important;">
<table class="table table-striped myFormat">
<thead>
<tr>
<th class="left"><strong>Description</strong></th>
<th class="left"><strong>Family Member</strong></th>
<th class="right"><strong>Charges</strong></th>
<th class="right"><strong>Start Date</strong></th>
<th class="right"><strong>End Date</strong></th>
  <th class="center"><strong>Days</strong></th>
  <th class="center"><strong>Qty</strong></th>
<th class="right"><strong>Total</strong></th>

</tr>
</thead>

<tbody>

@foreach($bookingsubdata as $sub)
<tr>
<td class="left">{{transTypesChargesTypes($sub->charges_type)}}</td>
<td class="left">{{ invoicesfamilyname($sub->family)}} ({{familyrelationship(invoicesfamilyrelation($sub->family))}})</td>
<td class="right">{{ $sub->charges_amount }}</td>
  <td class="center">{{ formatDateToShow($sub->start_date) }}</td>
   <td class="center">{{ formatDateToShow($sub->end_date) }}</td>
<td class="right">{{ $sub->days }}</td>
<td class="right">{{ $sub->qty }}</td>
<td class="right">{{ $sub->total }}</td>

</tr>
@endforeach

</tbody>

</table>

</div>
<div class="row">
<div class="col-lg-4 col-sm-5">
{{$receiptdata->amount_in_words}}<br>
{{$receiptdata->comments}}
<br>
<strong>Note: </strong><p>Thank you for your business. This is a computer generated invoice. Please contact us if you have questions or issues with this bill. </p>

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>
<tr>
<td class="left">
<strong>SUB-TOTAL</strong>
</td>
<td class="right">{{$receiptdata->total}}</td>
</tr>

@if($receiptdata->discount_amount)
<tr>
<td class="left">
<strong>DISCOUNT </strong>
</td>
<td class="right">{{$receiptdata->discount_amount}}</td>
</tr>
@elseif($receiptdata->discount_percentage)
<tr>
<td class="left">
<strong>DISCOUNT </strong>
</td>
<td class="right">{{$receiptdata->discount_percentage}}%</td>
</tr>
@endif

@if($receiptdata->extra_charges)
<tr>
<td class="left">
 <strong>EXTRA CHARGES</strong>
</td>
<td class="right">{{$receiptdata->extra_charges}}</td>
</tr>
@elseif($receiptdata->extra_percentage)
<tr>
<td class="left">
 <strong>EXTRA CHARGES</strong>
</td>
<td class="right">{{$receiptdata->extra_percentage}}%</td>
</tr>
@endif

@if($receiptdata->tax_charges)
<tr>
<td class="left">
 <strong>TAX</strong>
</td>
<td class="right">{{$receiptdata->tax_charges}}</td>
</tr>
@elseif($receiptdata->tax_percentage)
<tr>
<td class="left">
 <strong>TAX</strong>
</td>
<td class="right">{{$receiptdata->tax_percentage}}%</td>
</tr>
@endif

<tr>
<td class="left">
<strong>GRAND TOTAL</strong>
</td>
<td class="right">
<strong>{{$receiptdata->grand_total}}</strong>
</td>
</tr>

<tr>
<td class="left">
<strong>AMOUNT PAID</strong>
</td>
<td class="right">
<strong>{{$amount_paid?$amount_paid:0}}</strong>
</td>
</tr>

<tr>
<td class="left">
<strong>BALANCE</strong>
</td>
<td class="right">
<strong>{{$resultant?$resultant:0}}</strong>
</td>
</tr>


</tbody>
</table>

</div>

</div>

<div class="row" style="margin-top: -20px !important;">
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important">MANAGER SIGNATURE:&nbsp_______________</p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <p style="font-size: 12px !important">&nbsp&nbspMEMBER SIGNATURE:&nbsp_______________</p>
 </div>
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
