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



p {  color: black !important;  font: 110% sans-serif !important;}
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

 table.myFormat tr td { font-size: 13px !important; }
 table.myFormat tr th { font-size: 12px !important; }
</style>


  </head>
  <body>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">Payments</h6>
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
  <li><a href="{{ url('finance-and-management/finance-payment-receipts-vue') }}">Payments List</a></li>
  <li><a href>Print Payment</a></li>
</ul>

<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="100" width="200">

<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>PAYMENT</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">

<div class="col-sm-2">
<h5 class="mb-3"><strong>PAYER:</strong>
</h5>
</div>

<div class="col-sm-4">

<div><strong>Name:</strong>&nbsp&nbsp @if($receiptdata->customer) {{$receiptdata->customer->customer_name}} @elseif($receiptdata->employee) {{$receiptdata->employee->name}} @elseif($receiptdata->member) {{$receiptdata->member->applicant_name}} @elseif($receiptdata->person)  {{$receiptdata->person->person_name}}  @endif</div>

<div><strong>Category:</strong>&nbsp&nbsp @if($receiptdata->customer) Guest @elseif($receiptdata->member) Member @elseif($receiptdata->employee) Employee @elseif($receiptdata->person) Ledger Account @endif</div>

@if($receiptdata->member)
<div><strong>Membership #:</strong>&nbsp&nbsp {{$receiptdata->member->mem_no}}</div>
@elseif($receiptdata->customer)
<div><strong>Guest #:</strong>&nbsp&nbsp {{$receiptdata->customer->id}} </div>
@elseif($receiptdata->employee)
<div><strong>Employee #:</strong>&nbsp&nbsp {{$receiptdata->employee->id}} </div>
@elseif($receiptdata->person)
<div><strong>A/C #:</strong>&nbsp&nbsp {{$receiptdata->person->id}} </div>
@endif

<div><strong>Contact #:</strong>&nbsp&nbsp @if($receiptdata->customer) {{$receiptdata->customer->customer_contact}} @elseif($receiptdata->employee) {{$receiptdata->employee->mob_a}} @elseif($receiptdata->member) {{$receiptdata->member->mob_a}} @elseif($receiptdata->person) {{$receiptdata->person->person_contact}} @endif</div>

@if($receiptdata->member)
<div><strong>City:</strong>&nbsp&nbsp @if($receiptdata->member->cur_city){{$receiptdata->member->cur_city}}@endif </div>

<div><strong>Family Member:</strong>&nbsp&nbsp{{invoicesfamilyname($receiptdata->family)}} @if($receiptdata->family)(@endif{{familyrelationship(invoicesfamilyrelation($receiptdata->family))}} @if($receiptdata->family))@endif</div>

@endif

</div>


<div class="col-sm-2">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
</div>

<div class="col-sm-4">
<div><strong>Receipt #:</strong> &nbsp&nbsp{{$receiptdata->id}}</div>
<div><strong>Issue Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->invoice_date) }}</div>
<div><strong>Payment Method:</strong> &nbsp&nbsp{{ transTypesChargesTypes($receiptdata->account) }}</div>
</div>



</div>


<div class="table-responsive-sm" style="margin-top: -40px !important;">
<table class="table table-striped myFormat">
<thead>
<tr>

<th class="left"><strong>SR #</strong></th>
<th class="left"><strong>PAYMENT AGAINST</strong></th>
<th class="left" ><strong>INVOICE AMOUNT</strong></th>
<th class="left" ><strong>Remaining AMOUNT</strong></th>
<th class="left" ><strong>PAID AMOUNT</strong></th>
<th class="left" ><strong>BALANCE</strong></th>
</tr>
</thead>

<tbody> 
   @php $divide=1;

 @endphp
   @foreach($varb as $var_b)
<tr>
@php
    $m=\App\transactions::whereIn('id',$var_b->receiptsp()->select('receipt')->get())->where('receipt_id',$receiptdata->id)->get()[0];
    $m2=\App\transactions::whereIn('id',$var_b->receiptsp()->select('receipt')->get())->where('receipt_id','!=',$receiptdata->id)->where('receipt_id','<',$receiptdata->id)->get()->sum('trans_amount')

@endphp
<td class="left">{{$divide}}</td>

<td class="left"><?php echo '<a target="_blank" href="'.route(transTypesDetails($var_b->trans_type),$var_b->trans_type_id).'">'.$var_b->trans_type_id.'</a>' ?> ({{transTypesChargesTypes($var_b->trans_type)}})</td>

<td class="left">{{ $var_b['trans_amount']  }}</td>
<td class="left">{{ $var_b['trans_amount'] -$m2  }}</td>

<td class="left">{{$m->trans_amount}}</td>
<td class="left">{{ $var_b['trans_amount']- $m2- ($m->trans_amount) }}</td>
</tr>
 @php $divide++; @endphp
@endforeach

</tbody>
</table>

</div>
<!--
<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>
<th class="center" ><strong>PAYMENT AGAINST:</strong></th>

</tr>
</thead>

<tbody>

   <tr>
    @php $divide=0; @endphp
    @foreach($varb as $var_b)
    @if($divide==4) <tr>  @endif
  <td>@if($var_b['trans_type']==0)
  <a target="_blank" href="{{ url('events-management/event-checkout/invoice/') }}/{{$var_b['trans_type_id']}}">{{$var_b['trans_type_id']}}</a> (Room)

  @elseif($var_b['trans_type']==1)
   {{$var_b['trans_type_id']}} (Event)

   @elseif($var_b['trans_type']==2)
    {{$var_b['trans_type_id']}} (Membership)

  @endif</td>
@if($divide==4) </tr>  @endif
  @php $divide++; @endphp
    @endforeach
  </tr>

</tbody>
</table>
</div>
 -->

<div class="row">
<div class="col-lg-6 col-sm-7">
<strong>Note: </strong><p>This is a computer generated receipt. It does not require any signature or stamp. </p>
If paid by credit card or cheaque, 5% surcharge will be added to the total amount.

<br>
<strong>AMOUNT IN WORDS :</strong> {{$receiptdata->amount_in_words}}

</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>

<tr>
<td class="left">
<strong>TOTAL</strong>
</td>
<td class="right">{{$receiptdata->total_amount}}</td>
</tr>

@if($receiptdata->surcharge)
<tr>
<td class="left">
 <strong>SURCHARGE</strong>
</td>
<td class="right">@if($receiptdata->surcharge) {{$receiptdata->surcharge}} @elseif($receiptdata->surcharge_percentage) {{$receiptdata->surcharge_percentage}}% @else 0 @endif</td>
</tr>
@endif

<tr>
<td class="left">
<strong>GRAND TOTAL</strong>
</td>
<td class="right">
<strong>{{$receiptdata->total}}</strong>
</td>
</tr>

</tbody>
</table>

</div>

</div>
<!-- 
<div class="row">
  <div class="col-lg-12 col-sm-12">

  <p>APPROVED BY:&nbsp_____________&nbsp&nbsp&nbsp
  RECEIVED BY:&nbsp_____________&nbsp&nbsp&nbsp
  PAID BY:&nbsp_____________</p>
 </div>
</div> -->

<br>
<div class="row" style="margin-top: -20px !important;">
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important"><strong>PRINTED BY:</strong>&nbsp<u style="text-transform: uppercase;">@if($receiptdata->created_by){{usernames($receiptdata->created_by)}}@endif</u></p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <!-- <p style="font-size: 12px !important">&nbsp&nbspMEMBER SIGNATURE:&nbsp_______________</p> -->
 </div>
</div>


<!-- 
<div class="row" >
   <div class="col-lg-5 col-sm-5">
  <p style="font-size: 12px !important">APPROVED BY:&nbsp_______________</p>
</div>
<div class="col-lg-3 col-sm-2"></div>
<div class="col-lg-4 col-sm-5">
  <p style="font-size: 12px !important">&nbsp&nbspRECEIVED BY:&nbsp_______________</p>
 </div>
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
