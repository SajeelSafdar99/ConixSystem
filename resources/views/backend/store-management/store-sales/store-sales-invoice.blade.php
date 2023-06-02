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


.termsandconditions {text-align: left !important;}

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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">General Sales</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('sales') }}">Sales</a></li>
  <li><a href="{{ url('store-management/store-sales-vue') }}">General Sales List</a></li>
  <li><a href>Print Invoice</a></li>
</ul>


<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="60" width="110">

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>SALE INVOICE<br><br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif</h1><!-- <h1>@if($receiptdata->approved==1) SALE INVOICE @else QUOTATION @endif<br><br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif</h1> --></span>

</div>
<div class="card-body">
<div class="row mb-4">


<div class="col-sm-2">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
</div>

<div class="col-sm-4">
  <div><strong>Name:</strong>&nbsp&nbsp @if($receiptdata->customer && $receiptdata->type==1) {{$receiptdata->customer->customer_name}} @elseif($receiptdata->employee && $receiptdata->type==3) {{$receiptdata->employee->name}} @elseif($receiptdata->member && $receiptdata->type==0) {{$receiptdata->member->title}} {{$receiptdata->member->first_name}} {{$receiptdata->member->middle_name}} {{$receiptdata->member->applicant_name}} @endif</div>

<div><strong>Category:</strong>&nbsp&nbsp @if($receiptdata->customer && $receiptdata->type==1) {{guesttypename($receiptdata->customer->guest_type)}} @elseif($receiptdata->member && $receiptdata->type==0) Member @elseif($receiptdata->employee && $receiptdata->type==3) Employee @endif</div>

@if($receiptdata->customer && $receiptdata->type==1)
<div><strong>ID #:</strong>&nbsp&nbsp {{$receiptdata->customer->id}} </div>
@elseif($receiptdata->member && $receiptdata->type==0)
<div><strong>Membership #:</strong>&nbsp&nbsp {{$receiptdata->member->mem_no}}</div>
@elseif($receiptdata->employee && $receiptdata->type==3)
<div><strong>ID #:</strong>&nbsp&nbsp {{$receiptdata->employee->id}} </div>
@endif
 

@if($receiptdata->member && $receiptdata->type==0)
<div><strong>Family Member:</strong>&nbsp&nbsp{{invoicesfamilyname($receiptdata->family)}} @if($receiptdata->family)(@endif{{familyrelationship(invoicesfamilyrelation($receiptdata->family))}} @if($receiptdata->family))@endif</div>

@endif
 
</div>


<div class="col-sm-2">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Invoice #:</strong> &nbsp&nbsp{{$receiptdata->id}}</div>
<div><strong>Issue Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->invoice_date) }}</div>
 
</div>

</div>

<div class="table-responsive-sm" >
<table class="table table-striped myFormat">
<thead>
   @php  $subdisc = 0;
         $subtax = 0;
 @endphp
 
  @foreach($bookingsubdata as $sub)
 @php $subdisc += $sub->discount; @endphp
 @php $subtax += $sub->tax; @endphp
  @endforeach
<tr>
<!-- <th class="text-left"><strong>Code</strong></th> -->
<th class="text-left"><strong>Sr #</strong></th>
<th class="text-left"><strong>Item Name</strong></th>
<th class="text-left"><strong>Qty</strong></th>
<th class="text-left"><strong>Price</strong></th>
<th class="text-left"><strong>Service Charges</strong></th>

@if($subdisc!=0 && $subdisc>0)
<th class="text-left"><strong>Discount</strong></th>
@endif

@if($subtax!=0 && $subtax>0)
<th class="text-left"><strong>Tax</strong></th>
@endif

<th class="text-left"><strong>Sub-Total</strong></th>
<th class="text-left"><strong>Instructions</strong></th>
<!-- <th class="text-left"><strong>Location</strong></th>
<th class="text-left"><strong>Department</strong></th> -->



</tr>
</thead>

<tbody>
  @php $divide=1;

 @endphp
@foreach($bookingsubdata as $sub)
<tr>
<!-- <td class="text-left">{{ $sub->item_code }}</td> -->
<td class="text-left">{{$divide}}</td>
<td class="text-left">{{ itemcategoryname($sub->item_code) }} - {{ itemsubcategoryname($sub->item_code) }} - {{ $sub->item_details }}</td>
<td class="text-left">{{ $sub->qty }}</td>

@if(explode('.', $sub->sale_price)[1]==0)
  <td class="text-left">{{ round($sub->sale_price) }}</td>
@else
  <td class="text-left">{{ $sub->sale_price }}</td>
@endif

<td class="text-left">{{ $sub->service_charges }}</td>
@if($sub->discount>0 )

@if(explode('.', $sub->discount)[1]==0)
  <td class="text-left">{{ round($sub->discount) }}</td>
@else
  <td class="text-left">{{ $sub->discount }}</td>
@endif
@else
@if($subdisc!=0 && $subdisc>0)
<td></td>
@endif
@endif

@if($sub->tax>0 )
@if(explode('.', $sub->tax)[1]==0)
  <td class="text-left">{{ round($sub->tax) }}</td>
@else
  <td class="text-left">{{ $sub->tax }}</td>
@endif
@else
@if($subtax!=0 && $subtax>0)
<td></td>
@endif
@endif

<td class="text-left">{{ $sub->sub_total_price }}</td>
<td class="text-left">{{ $sub->instructions }}</td>
<!-- <td class="text-left">{{ salesrestaurantname($sub->store_location) }}</td>
<td class="text-left">{{ storeDepartmentName($sub->department) }}</td> -->


</tr>
 @php $divide++; @endphp
@endforeach

</tbody>

</table>

</div>
<div class="row">
<div class="col-lg-4 col-sm-5">
<strong>Amount in Words:</strong> {{$receiptdata->amount_in_words}}<br>
<strong>Remarks:</strong> {{$receiptdata->remarks}}

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>
<tr>
<td class="text-left">
<strong>GROSS</strong>
</td>
<td class="text-right">{{$receiptdata->gross}}</td>
</tr>

@if($receiptdata->discount)
<tr>
<td class="text-left">
<strong>DISCOUNT </strong>
</td>
<td class="text-right">{{$receiptdata->discount}}</td>
</tr>
@endif

@if($receiptdata->tax)
<tr>
<td class="text-left">
 <strong>TAX</strong>
</td>
<td class="text-right">{{$receiptdata->tax}}</td>
</tr>
@endif

<tr>
<td class="text-left">
<strong>GRAND TOTAL</strong>
</td>
<td class="text-right">
<strong>{{round($receiptdata->grand_total)}}</strong>
</td>
</tr>


<tr>
<td class="text-left">
<strong>AMOUNT PAID</strong>
</td>
<td class="text-right">
<strong>{{$amount_paid?$amount_paid:0}}</strong>
</td>
</tr>

<tr>
<td class="text-left">
<strong>BALANCE</strong>
</td>
<td class="text-right">
<strong>{{round($resultant?$resultant:0)}}</strong>
</td>
</tr>

<!-- 
<tr>
<td class="text-left">
<strong>AMOUNT PAID</strong>
</td>
<td class="text-right">
<strong></strong>
</td>
</tr>

<tr>
<td class="text-left">
<strong>BALANCE</strong>
</td>
<td class="text-right">
<strong> </strong>
</td>
</tr>
 -->

</tbody>
</table>

</div>

</div>



<br><br>
<h5><strong>TERMS & CONDITIONS</strong></h5>
<br>
<p class="termsandconditions">

  <?php
 echo str_replace( '\n', '<br />', $terms->terms_and_conditions );
?>
 
</p>
<br>
<br>


<div class="row" >
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important">Manager:&nbsp_______________</p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <p style="font-size: 12px !important">&nbsp&nbspCustomer:&nbsp_______________</p>
 </div>
</div> 




<!-- 
<div class="row">
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important">SIGNATURE:&nbsp_______________</p>
</div>
<div class="col-lg-3 col-sm-2"></div>

</div> -->


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
