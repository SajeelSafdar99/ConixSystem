<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    {{-- <title>Invoice</title> --}}
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

h1 {font: bold 108% sans-serif !important; letter-spacing: 0.5em !important; text-align: center !important; text-transform: uppercase !important; color: black !important; height: 50px !important; padding-top: 28px !important; font-size: 14px !important; margin-right: 130px;}

p { text-align: center !important; color: black !important; font-size: 10px !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
span {float:left !important; }
b {
    font-size: 14px;
}
/* table */

img {float: left !important; height: 95!important; width: 180!important;}
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
<h1>INVOICE</h1>
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
   <td><b>Guest Name:</b> <span class="spantext">{{$roombooking->first_name}} {{$roombooking->last_name}}</span></td>
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
    @php $divide=0; @endphp
    @foreach($bookingsubdata as $booksub)
    @if($divide==3) <tr>  @endif
  <td><b>{{ servicename($booksub->charges_type_id) }}:</b> <span class="spantext">{{ $booksub->charges_amount }}</span></td>
@if($divide==3) </tr>  @endif
  @php $divide++; @endphp
    @endforeach
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
    <td style="text-align: center;"><b>Cashier Signature</b></td>
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
</div>
</html>