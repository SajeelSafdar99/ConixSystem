@extends('backend.layout.app')
@section('page-content')

<head>

<style type="text/css">
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

table, th, td {
  border: 1px solid black !important;
  border-collapse: collapse !important;
}
th, td {
  padding: 5px !important;
  text-align: left !important;
  font: 120% sans-serif !important;
  height: 50px

}

/* heading */
h5 { font: bold 120% sans-serif !important; letter-spacing: 0.2em !important; text-align: left !important; text-transform: uppercase !important; height: 50px !important; color: black !important;}

h1 { font: bold 120% sans-serif !important; letter-spacing: 0.5em !important; text-align: center !important; text-transform: uppercase !important; background-color: #000 !important; color: white !important; height: 50px !important; padding-top: 15px !important;}

p { text-align: center !important; color: black !important; padding-right: 200px;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px; text-transform:uppercase !important;}
span {float:left !important; }

.termsandconditions {text-align: left !important;}
/* table */
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
</style>

	</head>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Booking Details</h6>
        <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-booking') }}">Room Booking List</a></li>
  <li><a href>Print Details</a></li>
</ul>

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

<div>
  <header>
			<h1>Booking Details</h1>

<span> <img src="{{ url($profiledata->company_logo) }}" height="90" width="200"></span><h2>{{$profiledata->company_name}}</h2><address>
      <p>PAF Falcon Complex, Gulberg III, Lahore, Pakistan. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - guestrooms@afohsclub.pk</p>

			</address>

		</header>
		<br>

<table style="width:100%">

  <tr>
    <td><b>Booking No:</b> &nbsp&nbsp&nbsp{{$roombooking->booking_no}}</td>
    <td><b>Booking Date:</b> &nbsp&nbsp&nbsp{{formatDateToShow($roombooking->booking_date)}}
    </td>
    <td><b>Booking Type:</b> &nbsp&nbsp&nbsp
    @if($roombooking->booking_type==1) Guest @elseif($roombooking->booking_type==6) Corporate Member @else Member @endif</td>
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

    <td><b>Family Member:</b> &nbsp&nbsp&nbsp{{invoicesfamilyname($roombooking->family)}} ({{familyrelationship(invoicesfamilyrelation($roombooking->family))}})</td>
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
<td><strong>Guest Category:</strong>&nbsp&nbsp{{ roomcategoryname($roombooking->category) }}</td>
    <td><b>Guest No:</b> &nbsp&nbsp&nbsp  @if($roombooking->booking_type==1) {{$roombooking->customer_id}} @elseif($roombooking->booking_type==6 && $roombooking->corporateMember) {{$roombooking->corporateMember->mem_no}} @elseif($roombooking->booking_type==0 && $roombooking->member) {{$roombooking->member->mem_no}} @else {{$roombooking->customer_id}} @endif</td>
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
<!--
   <tr>
    //pdf code
    @php $divide=0; @endphp
    @foreach($bookingsubdata as $booksub)
    @if($divide==3) <tr>  @endif
  <td><b>{{ servicename($booksub->charges_type_id) }}:</b> <span class="spantext">{{ $booksub->charges_amount }}</span></td>
@if($divide==3) </tr>  @endif
  @php $divide++; @endphp
    @endforeach
  </tr> -->

   <tr>

    <td><b>Breakfast:</b> &nbsp&nbsp&nbspFree for upto 2 persons</td>
    <td><b>Food & Beverages:</b> &nbsp&nbsp&nbspAs per usage</td>
    <td><b>Mini Bar:</b> &nbsp&nbsp&nbspAs per usage</td>

   <!--  @php $divide=0; $totaladd=0; @endphp
    @foreach($bookingsubdata as $booksub)
    @php $totaladd+=$booksub->charges_amount;@endphp
    @if($divide==3) <tr>  @endif
  <td><b>{{ servicename($booksub->charges_type_id) }}:</b> &nbsp&nbsp&nbsp{{ $booksub->charges_amount }}</td>
@if($divide==3) </tr>  @endif
  @php $divide++; @endphp
    @endforeach -->
  </tr>
  <tr>

    <td><b>Outgoing Calls:</b> &nbsp&nbsp&nbspAs per usage</td>
    <td><b>Dry Cleaning / Ironing:</b> &nbsp&nbsp&nbspAs per usage</td>
    <td><b>Transport:</b> &nbsp&nbsp&nbspAs per usage</td>

<tr>
  <tr>

    <td><b>Service Charges:</b> &nbsp&nbsp&nbspRs. 100 per night</td>
    <td><b>Mattress:</b> &nbsp&nbsp&nbspRs. 500 per mattress per night</td>
    <td><b>Wifi:</b> &nbsp&nbsp&nbspFree of cost</td>
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
<td  rowspan="1" colspan="2"><b>Advance Amount:</b> &nbsp&nbsp&nbsp @if($roombooking->advance_paid>0 && $roombooking->advance_paid!=NULL)
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

<table style="width:100%">
	<tr height="60">
		<td rowspan="1" colspan="3" height="35"><b>Comments / Special Requirements:</b></td>
	</tr>
	<tr>
		<td style="text-align: center !important;"><b>Guest Signature</b></td>
		<td style="text-align: center !important;"><b>FDO Signature</b></td>
	</tr>
	<tr height="130">
		<td height="70"></td>
		<td height="70"></td>
	</tr>
</table>
<br>
<br>
<br><br>
  <table style="width:100%">
<tr>
<td rowspan="1" colspan="3" ><b>Documents:</b> &nbsp&nbsp&nbsp

@if($roombooking->booking_type==0)

    @foreach($roombooking->bookingDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" style="width: 200px; height: 200px;" >
                    </a>
                    @endforeach

@elseif($roombooking->booking_type==6)

    @foreach($roombooking->bookingDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" style="width: 200px; height: 200px;" >
                    </a>
                    @endforeach


@else
@foreach($roombooking->bookingDocs->pluck('url') as $image)
 <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" style="width: 200px; height: 200px;" >
                    </a>
                    @endforeach
    @endif

</td>
</tr>
</table>


</div>

<br><br>
<h5>TERMS & CONDITIONS</h5>
<p class="termsandconditions">
1. Any cancelation or amendments must be made before 4pm (Local Time) 1 day prior to the date of arrival. Otherwise a
Cancellation fee/ No-Show equivalent to the room rate for the first night will be levied. Standard check-in time is 1400 Hours and
check-out time is 1200 Hours. Early check-in is subject to availability of the room.
<br>
2. In case of No Show – one night charged shall be deducted.
<br>
3. Guest Rooms will be booked on first come first serve basis.Due to any emergent operations/ emergency requirement, AFOHS Club management can cancel the booking. Honorable Member must be informed about the cancellation thorough a phone call/sms.
    <br>
4. WIFI in rooms and lobby area is available for free of cost.
<br>
5. Guest Rooms will be charged as per the Category and eligibility of the occupant.
<br>
6. Credentials of guests shall be verified i-e relationship of accompanied guest/s.
<br>
7. No immoral activity will be allowed in the Guest Rooms.
<br>
8. No alcohol, gambling or any illegal activity will be allowed in the Guest Rooms. Strict actions will be taken against the violators.
<br>
9. No strange visitor is allowed in the room. All visitors must register themselves in the reception office before visiting the guest’s in
the rooms.
<br>
10. All rooms of AFOHS Club are non- smoking rooms and smoking inside the rooms is prohibited.
<br>
11. No fire arms, narcotics and or other illegal items are allowed in the room or in the club premises. All licensed / service weapons
must be declared and handed over to the in-charge security of AFOHS Club.
<br>
12. If any suspicious activity is observed in the room or other areas involving the occupants, the AFOHS Club management
reserves the right to ask the guest/s to leave the room and premises on immediate basis without prior notice.
<br>
13. Absolutely no pets or any other kind of animals are allowed in any part of the club premises.
<br>
14. Guest agrees to make sure that all of his visitors will abide by the AFOHS Club and Falcon Complex rules and regulations.
<br>
15. Guest/Guarantor assume full responsibility for any damaged caused to the room, facilities, crockery, cutlery, building or any
other area / place / items by them, their children and guests and agrees to pay the costs involved without hesitation.
<br>
16. All foreigner guests are subject to interview and club management reserves the right to ask the guest to produce security
clearance certificate and valid visa to stay in Pakistan if and when needed. And if security clearance or visa is not produced, the
club management reserves the right to ask the guest/s to leave the room and club premises.
<br>
17. This is the responsibility of the guest to make sure that they do not leave their minor children unattended at all times during their
presence in the club premises. The club management, Options International PVT Ltd and AHQ cannot be held accountable in
any manner in case any unattended minor child/children gets hurt, injured or any serious mishap happens with the unattended
children.
<br>
18. Towels, bed sheets, pillows, plants, pots and other furniture and fixture in the room must be left in the condition as it was
handed over. Any broken or destroyed item will be charged separately.
<br>
19. Guest room supervisor will perform check out inspection and will prepare the final bill after the thorough inspection only.
<br>
20. Final bill will also include items used from mini bar, meals, services used during stay and missing/broken/ destroyed items.
<br>
21. Guest Rooms will be booked against advance payment only.
<br>
22. One extra mattress will be provided as per demand @ Rs. 500/- per night.
<br>
23. Maximum 2 adults and 2 kids under the age of 12 can stay in one room.
<br>
24. Complimentary breakfast is available for two persons per room. All extra number of breakfasts will be charged separately.
<br>
25. All other meals inside the room or in dining areas will be charged separately.
<br>
26. Check-in time will be from 1400 hrs onward and check out time will be 1200 hrs.
<br>
27. Early check out by guest’s own decision doesn’t make the guest eligible for any discount.
<br>
28. Final Bill must be paid and keys of the room/s must be returned to the guest room supervisor prior to check out.
<br>
29. Only cash or own credit cards will be accepted as method of payments. All payments through credit card will be charged by Adding 5% processing fees.
<br>
30. Use of iron in the room is strictly prohibited.
</p>
<br>
<div class="row">

<div class="col-md-12">

<div class="float-left"><b style="color: black !important;"> Guest Signature: ____________________</b>
   </div> &nbsp&nbsp&nbsp
  <div class="float-right"><b style="color: black !important;"> FDO Signature: ____________________</b></div>
</div>
</div>

@endsection

@push('jscode')
<script type="text/javascript">
    var input = document.querySelector('input[type=file]');
input.onchange = function () {
  var file = input.files[0];
  displayAsImage(file);

};

function displayAsImage(file) {
  var imgURL = URL.createObjectURL(file);
  img=document.getElementById("picchose");
  img.src = imgURL;

}
</script>
@endpush
