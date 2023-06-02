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
  width: 520px !important;
}
.widthclass2{
  width: 200px !important;
}

 table.myFormat tr td { font-size: 12px !important; }
 table.myFormat tr th { font-size: 11px !important; }
</style>

  </head>
    <body>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">Expenses</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li> 
  <li><a href="{{ url('finance-and-management/payment-finance-sheet-vue') }}">Expense List</a></li>
  <li><a href>Print Expense Bill</a></li>
</ul>

<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="100" width="200">

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>EXPENSE BILL<br><br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">


<div class="col-sm-2">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
</div>

<div class="col-sm-4">
  <div><strong>Name:</strong>&nbsp&nbsp {{$receiptdata->ledgerperson?$receiptdata->ledgerperson->person_name:''}}</div>
<div><strong>Category:</strong>&nbsp&nbsp Supplier</div>
  
<div><strong>Supplier #:</strong>&nbsp&nbsp {{$receiptdata->supplier_id}}</div>
 
<div><strong>Contact #:</strong>&nbsp&nbsp {{$receiptdata->ledgerperson?$receiptdata->ledgerperson->person_contact:''}}</div>
<!-- <div><strong>Email:</strong>&nbsp&nbsp{{$receiptdata->email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp{{$receiptdata->address}}</div> -->

<!-- <div><strong>Book:</strong> &nbsp&nbsp{{ financebookname($receiptdata->book)}}</div>
<div><strong>Doc #:</strong> &nbsp&nbsp{{$receiptdata->doc_no}}</div>
<div><strong>Dated:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->dated) }}</div> -->
</div>

<div class="col-sm-2">
<h5 class="mb-3"><strong>DETAILS:</strong> 
</h5>
</div>

<div class="col-sm-4">
<div><strong>Expense #:</strong> &nbsp&nbsp{{$receiptdata->expense_no}}</div>
<div><strong>Expense Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->expense_date) }}</div>
<div><strong>Print Date:</strong> &nbsp&nbsp{{ date('d/m/Y',time()) }}</div>
 
<!-- <div><strong>Company:</strong>&nbsp&nbsp {{ coaaccountname($receiptdata->unit) }}</div> -->

</div>


</div>

<div class="table-responsive-sm" style="margin-top: -40px !important;">
<table class="table table-striped myFormat">
<thead>
  
<tr>
<!-- <th class="text-left"><strong>Unit</strong></th> -->
<th class="text-left"><strong>Account</strong></th>
<th class="text-left"><strong>Amount</strong></th>
<th class="text-left"><strong>Description</strong></th>
 
 
</tr>
</thead>

<tbody>
  @php  $sumofgrandtotal = 0; @endphp
@foreach($bookingsubdata as $sub)
<tr>
<!-- <td class="text-left">{{ $sub->unit}} ({{ coaaccountname($sub->unit)}})</td> -->
<td class="text-left">{{ $sub->code}} ({{ $sub->name}})</td>
 <td class="text-left">{{ $sub->amount }}</td>
<td class="text-left">{{ $sub->description }}</td>
 
</tr>

 
 @php $sumofgrandtotal += $sub->amount; @endphp
@endforeach

</tbody>

</table>

</div>
<div class="row">
<div class="col-lg-4 col-sm-5">
 
<strong>Note: </strong><p>This is a computer generated invoice. It does not require any signature or stamp. </p>

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>

<tr>
<td class="left">
<strong>GRAND TOTAL</strong>
</td>
<td class="right">
<strong>{{$sumofgrandtotal}}</strong>
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


<div class="row" >
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important"><strong>PRINTED BY:</strong>&nbsp<u style="text-transform: uppercase;">@if($receiptdata->created_by){{usernames($receiptdata->created_by)}}@endif</u></p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <!-- <p style="font-size: 12px !important">&nbsp&nbspMEMBER SIGNATURE:&nbsp_______________</p> -->
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
