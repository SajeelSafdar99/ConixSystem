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
  width: 620px !important;
}
.widthclass2{
  width: 400px !important;
}

</style>

	</head>
<div class="br-pagebody">
        <div>

          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">Invoice</h6>

        <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

         <!-- <div style="text-align: right;">
          <a target="_blank" href="{{ url('room-management/room-check-out/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div> -->
 
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-check-out-vue') }}">Room Check Out List</a></li>
  <li><a href>Print Details</a></li>
</ul>



<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="60" width="110">
 
<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass">
  <STRONG>AFOHS CLUB</STRONG> <br> PAF Falcon Complex, Gulberg III, Lahore, Pakistan </span>

  <span class="float-right"> <h1>GUEST ROOMS<br>INVOICE<br><br>@if($resultant)(unpaid)@elseif(!$resultant)(paid)@endif</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
<div> 

</div>
<div><strong>Booking #:</strong>&nbsp&nbsp{{$roombooking->booking_no}}</div>
<div><strong>Booking Date:</strong>&nbsp&nbsp{{formatDateToShow($roombooking->booking_date)}}</div>
<div><strong>Booked By:</strong>&nbsp&nbsp{{ $roombooking->booked_by }}</div>
<div><strong>Name:</strong>&nbsp&nbsp {{$roombooking->moc_name}}</div>
<div><strong>Booking Type:</strong>&nbsp&nbsp @if($roombooking->booking_type==1) Guest @elseif($roombooking->booking_type==6) Corporate Member @else Member @endif</div>


@if($roombooking->booking_type==0 || $roombooking->booking_type==6)
<div><strong>Membership #:</strong>&nbsp&nbsp @if($roombooking->booking_type==0){{$roombooking->member?$roombooking->member->mem_no:''}} @elseif($roombooking->booking_type==6){{$roombooking->corporateMember?$roombooking->corporateMember->mem_no:''}} @endif</div>
@elseif($roombooking->booking_type==1)
<div><strong>Guest #:</strong>&nbsp&nbsp{{$roombooking->customer_id}}</div>
@endif


<div><strong>CNIC / Passport:</strong>&nbsp&nbsp{{$roombooking->moc_cnic}}</div>
<div><strong>Contact #:</strong>&nbsp&nbsp{{$roombooking->moc_mob}}</div>
<div><strong>Email:</strong>&nbsp&nbsp{{$roombooking->moc_email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp{{$roombooking->moc_address}}</div>
<div><strong>Family Member:</strong>&nbsp&nbsp{{invoicesfamilyname($roombooking->family)}} ({{familyrelationship(invoicesfamilyrelation($roombooking->family))}})</div>

</div>

<div class="col-sm-6">
<h5 class="mb-3"><strong>OCCUPIED BY:</strong>
</h5>
<div>

</div>
<div><strong>Name:</strong> &nbsp&nbsp{{$roombooking->first_name}}&nbsp{{$roombooking->last_name}}</div>
<div><strong>Guest Category:</strong>&nbsp&nbsp{{ roomcategoryname($roombooking->category) }}</div>
<div><strong>CNIC / Passport:</strong> &nbsp&nbsp{{$roombooking->guest_cnic}}</div>
<div><strong>Contact #:</strong> &nbsp&nbsp{{$roombooking->guest_mob}}</div>
<div><strong>Email:</strong> &nbsp&nbsp{{$roombooking->guest_email}}</div>
<div><strong>Address:</strong> &nbsp&nbsp{{$roombooking->guest_address}}</div>
<div><strong>City:</strong> &nbsp&nbsp{{$roombooking->guest_city}}</div>
<div><strong>Country:</strong> &nbsp&nbsp{{$roombooking->guest_country}}</div>
<div><strong>Accompained Guest Name:</strong> &nbsp&nbsp{{$roombooking->accompained_guest}}</div>
<div><strong>Relationship:</strong> &nbsp&nbsp{{$roombooking->acc_relationship}}</div>
<div><strong>CNIC / Passport:</strong> &nbsp&nbsp{{$roombooking->acc_cnic}}</div>
</div>

</div>

<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>


<th class="left"><strong>Room</strong></th>
<th class="right"><strong>Charges</strong></th>
<th class="right"><strong>Check-In Date</strong></th>
<th class="right"><strong>Check-Out Date</strong></th>
  <th class="center"><strong>Nights</strong></th>
<th class="right"><strong>Total</strong></th>
</tr>
</thead>

<tbody>
  
<tr>

<td class="left">{{ $room->room_no }} ({{ pdfroomtypename($room->room_type) }})</td>

<td class="right">{{$roombooking->pday_charges_id}}</td>
  <td class="center">{{formatDateToShow($roombooking->check_in_date)}}</td>
   <td class="center">{{formatDateToShow($roombooking->check_out_date)}}</td>
<td class="right">{{$roombooking->nights}}</td>
<td class="right">{{$roombooking->charges}}</td>
</tr>


</tbody>
</table>

</div>


<div class="table-responsive-sm">
<table class="table">
<thead>
<tr>
<th class="center"><strong>Food Bill Charges</strong></th>
</tr>
</thead>

<tbody>
  <tr>
  <td class="left">{{$roombooking->food_bill_charges}}</td>
  </tr>

</tbody>
</table>
</div>



<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>

<th class="center"><strong>Other Charges</strong></th>

</tr>
</thead>

<tbody>
  <tr>
   
    @foreach($bookingsubdata as $booksub)
    <tr>  
  <td class="left">{{ servicename($booksub->charges_type_id) }}:&nbsp&nbsp&nbsp{{ $booksub->charges_amount }}</td>
 </tr> 
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
<strong>TOTAL PAYABLE AMOUNT</strong>
</td>
<td class="right">{{$roombooking->total_charges}}</td>
</tr>
@if($roombooking->discount_amount==!NULL)
<tr>
<td class="left">
<strong>DISCOUNT </strong>
</td>
<td class="right">{{$roombooking->discount_amount}}</td>
</tr>
@endif
<tr>
<td class="left">
 <strong>ADVANCE</strong>
</td>
<td class="right">@if($roombooking->advance_paid>0 && $roombooking->advance_paid!=NULL)
  {{ $roombooking->advance_paid }} @else 0
@endif
</td>
</tr>
<tr>
<td class="left">
<strong>TOTAL PAID AMOUNT</strong>
</td>
<td class="right">
<strong>{{$amount_paid?$amount_paid+$roombooking->food_bill_charges:0}}</strong>
<!-- <strong>@if($roombooking->total_balance)
 {{ $roombooking->total_balance }} @else 0
 @endif</strong> -->
</td>
</tr>
<tr>
<td class="left">
<strong>REMAINING BALANCE</strong>
</td>
<td class="right">
   <!-- <strong>{{$resultant?$resultant+$roombooking->food_bill_charges:0}}</strong>  -->
  <strong>@if($roombooking->total_balance)
 {{ $roombooking->total_balance }} @else 0
 @endif</strong>  
</td>
</tr>
</tbody>
</table>

</div>

</div>
<br>
<div class="row">
   <div class="col-lg-6 col-sm-6">
  <p>GUEST ROOMS MANAGER SIGNATURE:&nbsp_______________</p>
</div>
<div class="col-lg-2 col-sm-1"></div>
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
<p style="text-align: left !important;">&nbsp&nbsp&nbspThank you for your stay at AFOHS Club.</p>
  </div>
</div>
</div>

<br>
<div class="card-body">
<div class="row">
   <div class="col-lg-4 col-sm-4">
  <p><strong>&nbsp&nbsp&nbspPhone:</strong>&nbsp+92 42 35925318 - 19</p>
</div>
<div class="col-lg-4 col-sm-4">
  <p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Email:</strong>&nbsp guestrooms@afohsclub.pk</p>
 </div>
<div style="text-align: right !important;" class="col-lg-4 col-sm-4"> <p><strong>Website:</strong>&nbspwww.afohsclub.pk</p></div>

</div>
</div>





<!-- 

  <header>

			<h1>Invoice</h1>

			<br><br>
<span> <img src="{{ url($profiledata->company_logo) }}"  height="90" width="200"></span><h2>{{$profiledata->company_name}}</h2><address>
       <p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>

			</address>
			 
		</header>
		<br><br>
    <form>
<table style="width:100%">

  <tr>
    <td><b>Booking No:</b> &nbsp&nbsp&nbsp{{$roombooking->booking_no}}</td>
    <td><b>Booking Date:</b> &nbsp&nbsp&nbsp{{formatDateToShow($roombooking->booking_date)}}
    </td>
    <td><b>Booking Type:</b> &nbsp&nbsp&nbsp
    @if($roombooking->booking_type==1) Guest @else Member @endif</td>
    
   
    
  </tr>
  <tr>
    
    <td><b>Check-In Date:</b> &nbsp&nbsp&nbsp{{formatDateToShow($roombooking->check_in_date)}}</td>
    <td  rowspan="1" colspan="2" ><b>Check-Out Date:</b> &nbsp&nbsp&nbsp{{formatDateToShow($roombooking->check_out_date)}}</td>
    
    
  </tr>
  <tr>
    <td><b>Name:</b> &nbsp&nbsp&nbsp{{$roombooking->first_name}}&nbsp{{$roombooking->last_name}}</td>
    <td><b>Phone No:</b> &nbsp&nbsp&nbsp{{$roombooking->guest_mob}}</td>
   <td><b>Email:</b> &nbsp&nbsp&nbsp{{$roombooking->guest_email}}</td>
  </tr>

<tr>
    <td><b>Family Member:</b> &nbsp&nbsp&nbsp{{invoicesfamilyname($roombooking->family)}}</td>
    <td  rowspan="1" colspan="2" ><b>Address:</b> &nbsp&nbsp&nbsp{{$roombooking->guest_address}}</td>
  </tr>

   <tr>
    <td><b>City:</b> &nbsp&nbsp&nbsp{{$roombooking->guest_city}}</td>
    <td><b>Country:</b> &nbsp&nbsp&nbsp{{$roombooking->guest_country}}</td>
    <td><b>CNIC / Passport No:</b> &nbsp&nbsp&nbsp{{$roombooking->guest_cnic}}</td>
  </tr>
  <tr>
    <td><b>Acc. Guest Name:</b> &nbsp&nbsp&nbsp{{$roombooking->accompained_guest}}</td>
    <td><b>Relationship:</b> &nbsp&nbsp&nbsp{{$roombooking->acc_relationship}}</td>
    <td><b>CNIC:</b> &nbsp&nbsp&nbsp{{$roombooking->acc_cnic}}</td>
  </tr>
  <tr> 
    <td><b>Guest Name:</b> &nbsp&nbsp&nbsp{{$roombooking->moc_name}}</td>
 
    <td><b>Guest No:</b> &nbsp&nbsp&nbsp{{$roombooking->customer_id}}</td>
  </tr>
  <tr>
    <td><b>Guest Tel:</b> &nbsp&nbsp&nbsp{{$roombooking->moc_mob}}</td>
    <td><b>Booked By:</b> &nbsp&nbsp&nbsp{{$roombooking->booked_by}}</td>
    
    <td><b>Room No:</b> &nbsp&nbsp&nbsp{{ $room->room_no }} ({{ pdfroomtypename($room->room_type) }})
    </td>
  </tr>
  <tr>
     <td><b>No. of Nights:</b> &nbsp&nbsp&nbsp{{$roombooking->nights}}</td>
    <td><b>Rates Per Night:</b> &nbsp&nbsp&nbsp{{$roombooking->pday_charges_id}}</td>
    <td><b>Room Charges:</b> &nbsp&nbsp&nbsp{{$roombooking->charges}}</td>
   
  </tr>

  <tr>
<td rowspan="1" colspan="3" bgcolor="#D3D3D3" height="40" style="text-align: center !important ;  "><b>Other Charges Details</b></td>
  </tr>
   <tr>
    @php $divide=0; @endphp
    @foreach($bookingsubdata as $booksub)
    @if($divide==3) <tr>  @endif
  <td><b>{{ servicename($booksub->charges_type_id) }}:</b> &nbsp&nbsp&nbsp{{ $booksub->charges_amount }}</td>
@if($divide==3) </tr>  @endif
  @php $divide++; @endphp
    @endforeach
  </tr>
 
@if($roombooking->discount_amount==!NULL)
<tr>
<td><b>Total Payable Amount:</b> &nbsp&nbsp&nbsp{{$roombooking->total_charges}}</td>
<td><b>Discount Amount:</b> &nbsp&nbsp&nbsp{{$roombooking->discount_amount}}</td>
<td><b>Advance Amount:</b> &nbsp&nbsp&nbsp @if($roombooking->advance_paid>0 && $roombooking->advance_paid!=NULL)
  {{ $roombooking->advance_paid }}

@endif</td>

</tr>
 @else
 <tr>
<td><b>Total Payable Amount:</b> &nbsp&nbsp&nbsp{{$roombooking->total_charges}}</td>
<td rowspan="1" colspan="2"><b>Advance Amount:</b> &nbsp&nbsp&nbsp @if($roombooking->advance_paid>0 && $roombooking->advance_paid!=NULL)
  {{ $roombooking->advance_paid }}

@endif</td>

</tr>
@endif


<tr>
<td rowspan="1" colspan="3" ><b>Remaining Balance:</b> &nbsp&nbsp&nbsp 
  @if($roombooking->total_balance)
 {{ $roombooking->total_balance }} 
 @endif
 
</td>
</tr>

</table>
<br>
<br>
<br>
<table style="width:100%">
	<tr height="90">
		<td rowspan="1" colspan="3" height="65"><b>Comments / Special Requirements:</b></td>
	</tr>
	<tr>
		<td style="text-align: center !important;"><b>Guest Signature</b></td>
		<td style="text-align: center !important;"><b>Cashier Signature</b></td>
	</tr>
	<tr height="140">
		<td height="70"></td>
		<td height="70"></td>
	</tr>
</table>
</div>
</form> -->


</div>
</div>
@endsection