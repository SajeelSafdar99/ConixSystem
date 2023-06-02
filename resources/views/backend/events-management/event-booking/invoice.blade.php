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
      

<!--           <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">Invoice</h6>

        <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 @if($invoicestatus==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/event-checkout-vue') }}">Event Completion List</a></li>
  <li><a href>Print Details</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/event-booking-vue') }}">Event Booking List</a></li>
  <li><a href>Print Details</a></li>
</ul>
@endif

 -->

<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="60" width="110">
 
<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass">
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1>EVENT <br> INVOICE<br><br>@if($resultant) (unpaid) @elseif(!$resultant) (paid) @endif</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
<div> 

</div>
<div><strong>Booking #:</strong>&nbsp&nbsp{{$eventbooking->booking_no}}</div>
<div><strong>Booking Date:</strong>&nbsp&nbsp{{formatDateToShow($eventbooking->booking_date)}}</div>


<div><strong>Booking Type:</strong>&nbsp&nbsp @if($eventbooking->booking_type==1) Guest / Non-Member @else Member @endif</div>
<div><strong>Name:</strong>&nbsp&nbsp {{$eventbooking->moc_name}}</div>
<div><strong>No.:</strong>&nbsp&nbsp  @if($eventbooking->booking_type==1) {{$eventbooking->customer_id}} @else {{$eventbooking->member?$eventbooking->member->mem_no:''}} @endif</div>
<div><strong>CNIC / Passport:</strong>&nbsp&nbsp{{$eventbooking->moc_cnic}}</div>
<div><strong>Contact #:</strong>&nbsp&nbsp{{$eventbooking->moc_mob}}</div>
<div><strong>Email:</strong>&nbsp&nbsp{{$eventbooking->moc_email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp{{$eventbooking->moc_address}}</div>
<div><strong>Family Member:</strong>&nbsp&nbsp{{invoicesfamilyname($eventbooking->family)}} @if($eventbooking->family)(@endif {{familyrelationship(invoicesfamilyrelation($eventbooking->family))}} @if($eventbooking->family))@endif</div>

</div>

<div class="col-sm-6">
<h5 class="mb-3"><strong>EVENT DETAILS:</strong>
</h5>
<div>

</div>
<div><strong>Booked By:</strong>&nbsp&nbsp{{ $eventbooking->booked_by }}</div>
<div><strong>Nature of Event:</strong>&nbsp&nbsp{{$eventbooking->nature_of_event}}</div>
<div><strong>Event Date:</strong>&nbsp&nbsp{{formatDateToShow($eventbooking->event_date)}}</div>
<div><strong>Timing (From):</strong>&nbsp&nbsp{{$eventbooking->from}}</div>
<div><strong>Timing (To):</strong>&nbsp&nbsp{{$eventbooking->to}}</div>
<div><strong>Venue:</strong>&nbsp&nbsp{{eventvenue($eventbooking->venue)}}</div>
</div>

</div>

<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>


<th class="left"><strong>Menu Charges</strong></th>
<th class="right"><strong>Add-On Charges</strong></th>
<th class="right"><strong>Per Person Charges</strong></th>
<th class="right"><strong>Guests</strong></th>
<th class="right"><strong>Extra Guests</strong></th>
  <th class="center"><strong>Total Food Charges</strong></th>
</tr>
</thead>

<tbody>
  
<tr>

<td class="left">{{ $eventbooking->menu_charges }}</td>

<td class="right">@if($eventbooking->total_addon_charges) {{ $eventbooking->total_addon_charges }} @else 0 @endif</td>
<td class="center">{{ $eventbooking->total_per_person_charges }}</td>
  <td class="center">{{ $eventbooking->guests }}</td>
   <td class="center">@if($eventbooking->extra_guests) {{ $eventbooking->extra_guests }} @else 0 @endif</td>
<td class="right">{{$eventbooking->grand_guest_charges}}</td>
</tr>


</tbody>
</table>

</div>


@if(sizeof($menuaddons) > 0)
<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>
<th class="center" ><strong>Menu Add-Ons</strong></th>

</tr>
</thead>

<tbody>
   
   <tr>
    @php $divide=0; @endphp
    @foreach($menuaddons as $menuaddon)
    @if($divide==4) <tr>  @endif
  <td>{{ menuAddOnItems($menuaddon->add_on_name) }}&nbsp @if($menuaddon->addon_bill_details)(@endif{{ $menuaddon->addon_bill_details }} @if($menuaddon->addon_bill_details))@endif &nbsp:&nbsp&nbsp{{ $menuaddon->add_on_charges }}</td>
@if($divide==4) </tr>  @endif
  @php $divide++; @endphp
    @endforeach
  </tr>

</tbody>
</table>
</div>
@endif



@if(sizeof($bookingsubdata) > 0)
<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>
<th class="center" ><strong>Other Charges</strong></th>

</tr>
</thead>

<tbody>
   
   <tr>
    @php $divide=0; @endphp
    @foreach($bookingsubdata as $bookingsub)
    @if($divide==4) <tr>  @endif
  <td>{{ menuChargesTypes($bookingsub->charges_type_id) }}&nbsp @if($bookingsub->bill_details)(@endif{{ $bookingsub->bill_details }} @if($bookingsub->bill_details))@endif &nbsp:&nbsp&nbsp{{ $bookingsub->charges_amount }}</td>
@if($divide==4) </tr>  @endif
  @php $divide++; @endphp
    @endforeach
  </tr>

</tbody>
</table>
</div>
@endif


<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>

<th class="center"><strong>{{eventmenu($eventbooking->menu)}}</strong></th>

</tr>
</thead>

<tbody>
   
   <tr>
    @php $divide=0; @endphp
    @foreach($eventsubdata as $sub)
    @if($divide==-1) <tr>  @endif
  <td>{{ menuCategoryItems($sub->item_name) }}</td>
@if($divide==4) </tr>  @endif
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
<strong>TOTAL CHARGES</strong>
</td>
<td class="right">{{$eventbooking->total_charges}}</td>
</tr>
@if($eventbooking->surcharge==!NULL)
<tr>
<td class="left">
<strong>SURCHARGE </strong>
</td>
<td class="right">{{$eventbooking->surcharge}}</td>
</tr>
@endif
@if($eventbooking->discount_amount==!NULL)
<tr>
<td class="left">
<strong>REDUCTION </strong>
</td>
<td class="right">{{$eventbooking->discount_amount}}</td>
</tr>
@endif
<tr>
<td class="left">
 <strong>ADVANCE</strong>
</td>
<td class="right">@if($eventbooking->advance_paid>0 && $eventbooking->advance_paid!=NULL)
  {{ $eventbooking->advance_paid }} @else 0
@endif
</td>
</tr>
<tr>
<td class="left">
<strong>REMAINING BALANCE</strong>
</td>
<td class="right">
<strong>@if($eventbooking->grand_total)
 {{ $eventbooking->grand_total }} @else 0
 @endif</strong>
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

<table style="width:100%">
<tr>
<td rowspan="1" colspan="3" bgcolor="#dee2e6" height="40">I have read, understood, accepted and shall comply with the terms and condictions provided on the back of this invoice and on the website of AFOHS club. www.AFOHSclub.pk/rooms.termsandconditions
<br>
I hereby guarantee that I will make sure that my referred guest will abide by all the terms and conditions set by the AFOHS Club and I will be personally responsible for the conducts and dues of my referred guest/s.</td>
  </tr>
</table>
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
@endsection 

@push('jscode')

<script type="text/javascript">
  $( document ).ready(function() {

 window.print();
});
</script>
@endpush
