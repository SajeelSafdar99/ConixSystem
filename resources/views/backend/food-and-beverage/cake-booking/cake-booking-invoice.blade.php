@extends('backend.layout.app')
@section('page-content')

<head>
    <meta charset="utf-8"> 
    <title>Invoice</title>
  
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
 
b{ color: black; font-size: 16px !important;}
/* heading */

h1 { font: bold 108% sans-serif !important; letter-spacing: 0.3em !important; text-align: center !important; text-transform: uppercase !important; color: black !important; height: 50px !important; padding-top: 10px !important; font-size: 19px !important;}

p { text-align: center !important; color: black !important; font-size: 15px !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */


input[type=text] {
    background: transparent;
    border: none;
    border-bottom: 1px solid #000000;
    width:100%;

}

input[type=date] {
    background: transparent;
    border: none;
    border-bottom: 1px solid #000000;
    width:100%;

}

input[type=number] {
    background: transparent;
    border: none;
    border-bottom: 1px solid #000000;
    width:100%;

}

input[readonly] {
  background-color: white;
}

input[disabled] {
  background-color: white;
  color: black;
}


select {
border-color: black;
    border-left: 0 none;
    border-right: 0 none;
    border-top: 0 none;
    min-height: 30px;
    padding-right: 5px;
    text-align: left;
   width:100%;
    word-break: break-word;
    white-space: normal;
}

</style>

  </head>
<div class="br-pagebody">
        <div>
       <!--    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Payment Receipts</h6>
         <div style="text-align: right;">
        <a target="_blank" href="{{ url('room-management/paymentreceipt-invoice-download') }}/{{ Request::segment(4) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> 
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Print Payment Receipt</a></li>
</ul>

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div> 
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
  -->
    
 <body>

<div>
  <header>
    <address>
      <p> <img src="{{ url($profiledata->company_logo) }}" height="100" width="200"></p>
        <p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>
      </address>
      <h1><u>ORDER FORM</u></h1>
   
    </header>
   
   <div class="row">
   <div class="col-md-4"><b>Booking #<input type="text" style="font-weight: bold !important;" id="booking_no" name="booking_no" value="{{$receiptdata->booking_no}}" disabled></b></div>

  <div class="col-md-4"><b>Date<input type="text" id="customer_id" name="customer_id" value="{{formatDateToShow($receiptdata->booking_date)}}" disabled></b></div>

  <div class="col-md-4"><b>Order Taker<input type="text" id="guest_address" name="guest_address" autocomplete="off" value="{{$receiptdata->order_taker}}" disabled></b></div>

 
</div>
<br>
<div class="row">
   <div class="col-md-4"><b>Customer Name<input type="text" id="mem_number" name="mem_number" value="{{$receiptdata->name}}" disabled></b></div>

  <div class="col-md-4"><b>Customer No.<input type="text" id="customer_id" name="customer_id" value="{{$receiptdata->customer_id}}" disabled></b></div>

  <div class="col-md-4"><b>Type: <input type="text" disabled @if($receiptdata->type==1 && $receiptdata->customer && $receiptdata->customer->guest_type==1) value="Applied Member" @elseif($receiptdata->type==1 && $receiptdata->customer && $receiptdata->customer->guest_type==2) value="Affiliated Member" @elseif($receiptdata->type==0) value="Member"  @elseif($receiptdata->type==6) value="Corporate Member" @elseif($receiptdata->type==3)  value="Employee" @endif></b></div>

 
</div>
<br>
<div class="row"> 
  <div class="col-md-8"><b>Address<input type="text" id="invoice_no" name="invoice_no" value="{{$receiptdata->member->cur_address}}" autocomplete="off" disabled></b></div>

  <div class="col-md-4">
<b>Contact<input type="text" id="invoice_no" name="invoice_no" value="{{$receiptdata->member->mob_a}}" autocomplete="off" disabled></b></div>
</div> 
   <br>
<div class="row">
 <div class="col-md-8">
   <b>Cake Type
   <input type="text" id="invoice_no" name="invoice_no" value="{{salescaketype($receiptdata->cake_type)}}" autocomplete="off" disabled></b></div>

     <div class="col-md-4"><b>Special Display<input type="text" id="guest_name" name="guest_name" value="{{$receiptdata->special_display}}" disabled></b>
</div>

 
</div> 
<br>
<div class="row">
   <div class="col-md-4"><b>Flavor/s<input type="text" id="mem_number" name="mem_number" value="{{$receiptdata->flavor}}" disabled></b></div>

  <div class="col-md-4"><b>Topping/s<input type="text" id="customer_id" name="customer_id" value="{{$receiptdata->topping}}" disabled></b></div>

  <div class="col-md-4"><b>Filling<input type="text" id="guest_address" name="guest_address" autocomplete="off" value="{{$receiptdata->filling}}" disabled></b></div>

 
</div>
<br>
<div class="row">
   <div class="col-md-4"><b>Icing<input type="text" id="mem_number" name="mem_number" value="{{$receiptdata->icing}}" disabled></b></div>

  <div class="col-md-4"><b>Color/s<input type="text" id="customer_id" name="customer_id" value="{{$receiptdata->color}}" disabled></b></div>

  <div class="col-md-4"><b>Weight<input type="text" id="guest_address" name="guest_address" autocomplete="off" value="{{$receiptdata->weight}}" disabled></b></div>

 
</div>
<br>
<div class="row">
  <div class="col-md-12">

<b>Written Message / Special Instructions<input type="text" id="payment_received_for" name="payment_received_for" autocomplete="off" value="{{$receiptdata->instructions}}" disabled></b>
</div>
</div>
<br>
<div class="row">
  <div class="col-md-4"><b>Delivery Date<input type="text" style="font-weight: bold !important;" id="customer_id" name="customer_id" value="{{formatDateToShow($receiptdata->delivery_date)}}" disabled></b></div>

  <div class="col-md-4"><b>Pick-up Time<input type="text" style="font-weight: bold !important;" id="guest_address" name="guest_address" autocomplete="off" value="{{$receiptdata->pickup_time}}" disabled></b></div>

   <div class="col-md-4"><b>Picture / Sketch Attached<input type="text" id="mem_number" name="mem_number" value="{{$receiptdata->attachment}}" disabled></b></div>
</div>
<br>
<div class="row">
   <div class="col-md-8"><b>Name of Person Receiving<input type="text" id="guest_contact" name="guest_contact" autocomplete="off" value="{{$receiptdata->receiver}}" disabled></b></div>

   <div class="col-md-4"><b>Delivery Address<input type="text" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly value="{{$receiptdata->delivery_address}}" disabled></b></div>
</div>
<br>

<div class="row">
  <div class="col-md-12">

<b><input type="text" id="payment_received_for" name="payment_received_for" autocomplete="off" value="" disabled></b>
</div>
</div>

<br> 

<div class="row">
  <div class="col-md-12">

<b>Note:<input type="text" id="payment_received_for" name="payment_received_for" autocomplete="off" value="{{$receiptdata->note}}" disabled></b>
</div>
</div>

<br> 


<div class="row">
<div class="col-md-8"><b>Mode of Payment<input type="text" id="payment_method" name="payment_method" autocomplete="off" value="{{transTypesChargesTypes($receiptdata->payment_method)}}" disabled></b></div>

</div>


<div class="row">

<div class="col-md-4"><b>Grand Total<input type="number" id="surcharge" name="surcharge" autocomplete="off" value="{{$receiptdata->grand_total}}" disabled></b></div>

  <div class="col-md-4"><b>Advance<input type="number" id="total_amount" name="total_amount" autocomplete="off" value="{{$receiptdata->advance_paid}}" disabled></b></div>


  <div class="col-md-4"><b>Balance:<input type="number" id="total" name="total" autocomplete="off" value="{{$receiptdata->balance_amount}}" disabled></b></div>



  
</div>

<br>
<br>
<p style="text-align: left !important;"><b>TERMS & CONDITIONS :</b></p>
<p style="text-align: left !important;">I understand that the weight / shape of designer cake is subject to change plus / minus 20% depending on the complexity of the design. I agree to pay the final amount as per final and actual weight no exceeding or decreasing more than 20% in all circumstances.</p>
<br>
<br>
 
<div class="row" style="text-align: center !important;">
  <div class="col-md-2"></div>
   <div class="col-md-2"></div>
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>
  <div class="col-md-2"><b><span style="text-decoration: underline; white-space: pre;">                         </span>
    <br>Order Taker / Manager Signature:</b></div>
<div class="col-md-2"><b><span style="text-decoration: underline; white-space: pre;">                         </span>
    <br>Customer Signature:</b></div>
</div>

</div>

</body>
</div>

@endsection



@push('jscode')

<script type="text/javascript">
  $( document ).ready(function() {

 window.print();
});
</script>
@endpush
