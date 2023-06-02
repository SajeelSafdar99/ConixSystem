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
<div class="br-pagebody"> 
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">Invoices</h6>
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
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-new-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Print Invoice</a></li>
</ul>
  <!--  $invoicesubs=(object) $v['invoicesubs'];
        $subdata=(object) $v['subdata']; -->

   

@foreach (array_except($s,['profiledata','bookingsubdata', 'majorx']) as $v)
    @php
 
        $member=(object) $v['member'];
        $receiptdata=(object) $v['receiptdata'];
        $resultant=$v['resultant'];
        $amount_paid=$v['amount_paid'];
         $storage=(object) $v['storage'];
        $profiledata=(object) $s['profiledata'];
      $bookingsubdata=(object) $s['bookingsubdata'];
       $majorx=(int) $s['majorx'];
        

        @endphp
 
     @endforeach
 
<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="100" width="200">

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>INVOICE<br><!-- <br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif --></h1></span>

</div>
<div class="card-body">
<div class="row mb-4">


<div class="col-sm-2">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Name:</strong>&nbsp&nbsp {{$receiptdata->member?$receiptdata->member->title:''}} {{$receiptdata->member?$receiptdata->member->first_name:''}} {{$receiptdata->member?$receiptdata->member->middle_name:''}} {{$receiptdata->member?$receiptdata->member->applicant_name:''}}</div>
<div><strong>Category:</strong>&nbsp&nbsp @if($receiptdata->invoice_type==1) Guest @else Member @endif</div>

@if($receiptdata->mem_no)
<div><strong>Membership #:</strong>&nbsp&nbsp{{$receiptdata->member->mem_no}}</div>
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
<!-- <div><strong>Invoice #:</strong> &nbsp&nbsp{{$receiptdata->invoice_no}}</div>
<div><strong>Issue Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->invoice_date) }}</div> -->
<div><strong>Print Date:</strong> &nbsp&nbsp{{ date('d/m/Y',time()) }}</div>
<!-- <div><strong>Payment Method:</strong> @php $arrayme[]=[]; @endphp @foreach($storage as $st) @if($st)
@if(!in_array($st,$arrayme)) {{transTypesChargesTypes($st)}} @endif
@php $arrayme[]=$st; @endphp
 @endif @endforeach </div> -->
</div>

</div>

<div class="table-responsive-sm" style="margin-top: -40px !important;">
<table class="table table-striped myFormat">
<thead>
 @php  $subdisc = 0;
 $subdue = 0;
 $subtax = 0;
 @endphp

  @foreach($bookingsubdata as $sub)
 @php $subdisc += $sub->discount_amount; @endphp
 @php $subdue += $sub->extra_percentage; @endphp
 @php $subtax += $sub->tax_percentage; @endphp
  @endforeach
<tr>
<th class="left"><strong>Type</strong></th>
<th class="left"><strong>Invoice #</strong></th>
<th class="left"><strong>Family Member</strong></th>
<!-- <th class="left"><strong>Charges</strong></th> -->
<th class="left"><strong>Start Date</strong></th>
<th class="left"><strong>End Date</strong></th>
<!--   <th class="left"><strong>Days</strong></th> -->
  <th class="left"><strong>Qty</strong></th>
<th class="left"><strong>Sub-Total</strong></th>

@if($subdisc!=0 && $subdisc>0)
<th class="left"><strong>Discount</strong></th>
@endif

@if($subdue!=0 && $subdue>0)
<th class="left"><strong>Overdue</strong></th>
@endif

@if($subtax!=0 && $subtax>0)
<th class="left"><strong>Tax</strong></th>
@endif

<th class="left"><strong>Total</strong></th>
</tr>
</thead>
 
<tbody>
 @php  $sumofgrandtotal = 0; @endphp 
@foreach($bookingsubdata as $sub)

<tr>
<td class="left">{{transTypesChargesTypes($sub->charges_type)}}</td>
<td class="left">{{$sub->invoice_no}}</td>
<td class="left">{{ invoicesfamilyname($sub->family)}} @if($sub->family)(@endif{{familyrelationship(invoicesfamilyrelation($sub->family))}}@if($sub->family))@endif</td>
<!-- <td class="left">{{ $sub->charges_amount }}</td> -->
  <td class="left">{{ formatDateToShow($sub->start_date) }}</td>
   <td class="left">{{ formatDateToShow($sub->end_date) }}</td>
<!-- <td class="left">{{ $sub->days }}</td> -->
<td class="left">{{ $sub->qty }}</td>
<td class="left">{{ $sub->sub_total }}</td>

@if($sub->discount_amount )
<td class="left">{{ $sub->discount_amount }} @if($sub->discount_amount) @endif</td>
@else
@if($subdisc!=0 && $subdisc>0)
<td></td>
@endif
@endif

@if($sub->extra_percentage )
<td class="left">{{ $sub->extra_percentage }} @if($sub->extra_percentage)% @endif</td>
@else
@if($subdue!=0 && $subdue>0)
<td></td>
@endif
@endif

@if($sub->tax_percentage )
<td class="left">{{ $sub->tax_percentage }} @if($sub->tax_percentage)% @endif</td>
@else
@if($subtax!=0 && $subtax>0)
<td></td>
@endif
@endif


<td class="left">{{ $sub->grand_total }}</td>

</tr>


 @php $sumofgrandtotal += $sub->grand_total; @endphp

@endforeach

</tbody>

</table>

</div>
<div class="row">
<div class="col-lg-4 col-sm-5">
{{$receiptdata->comments}}
<br>
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
<strong>{{$majorx?$majorx:0}}</strong>
</td>
</tr>

<tr>
<td class="left">
<strong>BALANCE</strong>
</td>
<td class="right">
<strong>{{$sumofgrandtotal-$majorx}}</strong>
</td>
</tr>  
 
</tbody>
</table>

</div>

</div>


<div class="row" style="margin-top: -20px !important;">
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
 
<!--  -->


</div>
</div>

@endsection




@push('jscode')

<script type="text/javascript">
  $( document ).ready(function() {

 window.print();
});
</script>
@endpush