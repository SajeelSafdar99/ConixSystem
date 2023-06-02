<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		{{-- <title>Booking Details</title> --}}
		<link rel="stylesheet" href="style.css">
		<link rel="license" href="//www.opensource.org/licenses/mit-license/">
		<script src="script.js"></script>
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
    padding: 0px !important;
    text-align: left !important;
    font: 120% sans-serif !important;
    height: 37px;
    padding-left: 1px;
}
span.spantext {
    font-size: 14px;
}

/* heading */
h5 { font: bold 120% sans-serif !important; letter-spacing: 0.2em !important; text-align: left !important; text-transform: uppercase !important; height: 40px !important; color: black !important;}

h1 {font: bold 108% sans-serif !important; letter-spacing: 0.5em !important; text-align: center !important; text-transform: uppercase !important; color: black !important; height: 50px !important; padding-top: 28px !important; font-size: 14px !important; margin-right: 130px;}

p { text-align: center !important; color: black !important; font-size: 10px !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
span {float:left !important; }
b {
    font-size: 14px;
}
/* table */

img {float: left !important; height: 95!important; width: 180!important;}

.termsandconditions {text-align: left !important; font-size: 11px !important;}
</style>

	</head>
<div class="br-pagebody">
        <div>
         
      

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

<div>
<img src="{{ url($profiledata->company_logo) }}">
<h1>BOOKING DETAILS</h1>
<p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>

    
<table style="width:100%">

  <tr>
    <td><b>Booking No.:</b> <span class="spantext">
    {{$roombooking->booking_no}}</span></td>
    <td><b>Booking Date:</b> <span class="spantext">
    {{formatDateToShow($roombooking->booking_date)}}</span></td>
     <td><b>Booking Type:</b> <span class="spantext">@if($roombooking->booking_type==1) Guest @else Member @endif</span></td>
     
    
    
  </tr>
  <tr>
    <td><b>Check-In Date:</b> <span class="spantext"> {{formatDateToShow($roombooking->check_in_date)}}</span></td>
    <td  rowspan="1" colspan="2"><b>Check-Out Date:</b> <span class="spantext"> {{formatDateToShow($roombooking->check_out_date)}}</span></td>
    
    
  </tr>
  <tr>
   <td><b>Name:</b> <span class="spantext">{{$roombooking->first_name}} {{$roombooking->last_name}}</span></td>
<td><b>Phone No:</b> <span class="spantext">{{$roombooking->guest_mob}}</span></td>
  <td><b>Email:</b> <span class="spantext">{{$roombooking->guest_email}}</span></td>
   
  </tr>


<tr>
    <td><b>Family Member:</b> <span class="spantext"> {{invoicesfamilyname($roombooking->family)}} ({{familyrelationship(invoicesfamilyrelation($roombooking->family))}})</span></td>
    <td  rowspan="1" colspan="2"><b>Address:</b> <span class="spantext">{{$roombooking->guest_address}}</span></td>
    
    
  </tr>


   <tr>
    <td><b>City:</b> <span class="spantext">{{$roombooking->guest_city}}</span></td>
    <td><b>Country:</b> <span class="spantext">{{$roombooking->guest_country}}</span></td>
    <td><b>CNIC / Passport No:</b> <span class="spantext">{{$roombooking->guest_cnic}}</span></td>
  </tr>
  <tr>
    <td><b>Acc. Guest Name:</b> <span class="spantext">{{$roombooking->accompained_guest}}</span></td>
    <td><b>Relationship:</b> <span class="spantext">{{$roombooking->acc_relationship}}</span></td>
    <td><b>CNIC:</b> <span class="spantext">{{$roombooking->acc_cnic}}</span></td>
  </tr>
  <tr>
    <td><b>Guest Name:</b> <span class="spantext">{{$roombooking->moc_name}}</span></td>
    <td><b>Guest Category:</b> <span class="spantext">{{ $room_category->desc }}</span></td>
    <td><b>Guest No:</b> <span class="spantext">{{$roombooking->customer_id}}</span></td>
  </tr>
  <tr>
    <td><b>Guest Tel:</b> <span class="spantext">{{$roombooking->moc_mob}}</span></td>
    <td><b>Booked By:</b> <span class="spantext">{{$roombooking->booked_by}}</span></td>
    <td><b>Room No:</b>  <span class="spantext">{{ $room->room_no }} ({{ pdfroomtypename($room->room_type) }})</span>
                     </td>
  </tr>
  <tr>
      <td><b>No. of Nights:</b> <span class="spantext">{{$roombooking->nights}}</span></td>
    <td><b>Rates Per Night:</b> <span class="spantext">{{$roombooking->pday_charges_id}}</span></td>
    <td><b>Room Charges:</b> <span class="spantext">{{$roombooking->charges}}</span></td>
   
  </tr>

  <tr>
<td rowspan="1" colspan="3" bgcolor="#D3D3D3" height="40" style="text-align: center;"><b>Other Charges Details</b></td>
  </tr>

  <tr>
    <td><b>Breakfast:</b> <span class="spantext">Free for upto 2 persons</span></td>
    <td><b>Food & Beverages:</b> <span class="spantext">As per usage</span></td>
    <td><b>Mini Bar:</b> <span class="spantext">As per usage</span></td>
  </tr>
 <tr>
    <td><b>Outgoing Calls:</b> <span class="spantext">As per usage</span></td>
    <td><b>Dry Cleaning / Ironing:</b> <span class="spantext">As per usage</span></td>
    <td><b>Transport:</b> <span class="spantext">As per usage</span></td>
  </tr>

   <tr>
    <td><b>Service Charges:</b> <span class="spantext">Rs. 100 per night</span></td>
    <td><b>Mattress:</b> <span class="spantext">Rs. 500 per mattress per night</span></td>
    <td><b>Wifi:</b> <span class="spantext">Free of cost</span></td>
  </tr>
 
@if($roombooking->discount_amount==!NULL)
<tr>
<td><b>Total Payable Amount:</b> <span class="spantext">{{$roombooking->total_charges}}</span></td>
<td><b>Discount Amount:</b> <span class="spantext">{{$roombooking->discount_amount}}</span></td>
<td><b>Advance Amount:</b> <span class="spantext">
 @if($roombooking->advance_paid>0 && $roombooking->advance_paid!=NULL)
  {{ $roombooking->advance_paid }}
@endif</span></td>

</tr>
@else
<tr>
<td><b>Total Payable Amount:</b> <span class="spantext">{{$roombooking->total_charges}}</span></td>
<td rowspan="1" colspan="2"><b>Advance Amount:</b> <span class="spantext">
 @if($roombooking->advance_paid>0 && $roombooking->advance_paid!=NULL)
  {{ $roombooking->advance_paid }}
@endif</span></td>

</tr>
@endif
 
<tr>
<td rowspan="1" colspan="3"><b>Remaining Balance:</b> <span class="spantext"> @if($roombooking->total_balance)
 {{ $roombooking->total_balance }} 
 @endif</span></td>
</tr>
</table>
<br>
<br>
<br>

<table style="width:100%">
	<tr height="90">
		<td rowspan="1" colspan="2" height="65"><b>Comments / Special Requirements:</b></td>
	</tr>
	<tr>
		<td style="text-align: center;"><b>Guest Signature</b></td>
		<td style="text-align: center;"><b>FDO Signature</b></td>
	</tr>
	<tr height="140">
		<td height="70">
    <br><br><br><br><br><br>
    </td>
		<td height="70">
    <br><br><br><br><br><br>
    </td>
	</tr>
</table>
<br><br><br><br>
 <table style="width:100%">
<tr>
<td rowspan="1" colspan="3" ><b>Documents:</b> <span class="spantext">
  @if($roombooking->booking_type==0)
    @foreach($roombooking->member->bookingDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" style="width: 200px; height: 200px;" >
                    </a>
                    @endforeach
@else
@foreach($roombooking->customer->bookingDocs->pluck('url') as $image)
 <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" style="width: 200px; height: 200px;" >
                    </a>
                    @endforeach
    @endif
 </span>
</td>
</tr>
</table>
<h5>TERMS & CONDITIONS</h5>
<p class="termsandconditions">
1. Any cancelation or amendments must be made before 4pm (Local Time) 1 day prior to the date of arrival. Otherwise a
Cancellation fee/ No-Show equivalent to the room rate for the first night will be levied. Standard check-in time is 1400 Hours and
check-out time is 1200 Hours. Early check-in is subject to availability of the room.
<br>
2. In case of No Show – one night charged shall be deducted.
<br>
3. Guest Rooms will be booked on first come first serve basis.
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
<table width="100%">
<tr style="text-align: right !important;">
 <th> <br><b>Guest Signature:</b> <span class="spantext">____________________</span></th>
 <th> <br><b>FDO Signature:</b> <span class="spantext">____________________</span></th>
</tr>
</table>

</div>
</html>