@extends('backend.layout.app')
@section('page-content')

<head>
 
<style type="text/css">
  
*{
    color: black ;
    font-size: 16px ;
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




h1 { font: bold 120% sans-serif !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; color: black !important; padding-top: 11px !important; }

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
  width: 620px !important;
}
.widthclass2{
  width: 400px !important;
}
 table.myFormat tr td { font-size: 18px !important; }
 table.myFormat tr th { font-size: 17px !important; }
</style>
 

  </head>
  <body>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">General Vouchers</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a></li>
  <li><a href="{{ url('finance-and-management/finance-voucher') }}">General Vouchers List</a></li>
  <li><a href>Print General Voucher</a></li>
</ul>


<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="90" width="125">
 
<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>VOUCHER<br><br>@if($receiptdata->status==0) (unposted) @elseif($receiptdata->status==1) (posted) @endif</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
<div>

</div>
<div><strong>Name:</strong>&nbsp&nbsp {{$receiptdata->name}}</div>

<div><strong>Category:</strong>&nbsp&nbsp @if($receiptdata->invoice_type==1) Guest @elseif($receiptdata->invoice_type==2) Supplier @elseif($receiptdata->invoice_type==3) Employee @elseif($receiptdata->invoice_type==4) COA Account @else Member @endif</div>

<div><strong>No.:</strong>&nbsp&nbsp @if($receiptdata->invoice_type==1) {{$receiptdata->customer_id}} @elseif($receiptdata->invoice_type==2)  {{$receiptdata->person_id}} @elseif($receiptdata->invoice_type==3)  {{$receiptdata->employee_id}} @elseif($receiptdata->invoice_type==4)  {{$receiptdata->account_id}} @else {{$receiptdata->member?$receiptdata->member->mem_no:''}} @endif</div>

<div><strong>CNIC #:</strong>&nbsp&nbsp{{$receiptdata->cnic}}</div>
<div><strong>Contact #:</strong>&nbsp&nbsp{{$receiptdata->contact}}</div>
<div><strong>Email:</strong>&nbsp&nbsp{{$receiptdata->email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp{{$receiptdata->address}}</div>
<!-- <div><strong>Ledger Amount:</strong>&nbsp&nbsp{{$receiptdata->ledger_amount}}</div> -->
</div>

<div class="col-sm-6">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
<div>

</div>
<div><strong>Voucher #:</strong> &nbsp&nbsp{{$receiptdata->invoice_no}}</div>
<div><strong>Voucher Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->invoice_date) }}</div>
</div>



</div>

<div class="table-responsive-sm">
<table class="table table-striped myFormat">
<thead>
<tr>


<th class="left">Account Type</th>
<th class="center">Account Date</th>
</tr>
</thead>

<tbody>
  
<tr>

<td class="left">{{generalVoucherType($receiptdata->voucher_type)}}</td>

<td class="center">{{formatDateToShow($receiptdata->account_date)}}</td>
</tr>


</tbody>
</table>

</div>
<div class="row">
<div class="col-lg-6 col-sm-7">

{{$receiptdata->remarks}}

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>
<tr>
<td class="left">
<strong>PAYMENT MODE</strong>
</td>
<td class="right">{{ transTypesChargesTypes($receiptdata->payment_method) }}</td>
</tr>

<tr>
<td class="left">
<strong>DEBIT</strong>
</td>
<td class="right"><strong>@if($receiptdata->debit_amount==NULL) 0 @else {{$receiptdata->debit_amount}} @endif</strong></td>
</tr>

<tr>
<td class="left">
 <strong>CREDIT</strong>
</td>
<td class="right"><strong>@if($receiptdata->credit_amount==NULL) 0 @else {{$receiptdata->credit_amount}} @endif</strong></td>
</tr>

</tr>
</tbody>
</table>

</div>

</div>

<div class="row">
  <div class="col-lg-12 col-sm-12">

  <p>APPROVED BY:&nbsp_____________&nbsp&nbsp&nbsp
  RECEIVED BY:&nbsp_____________&nbsp&nbsp&nbsp
  PAID BY:&nbsp_____________</p>
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


@endpush