@extends('backend.layout.app')
@section('page-content')

<head>
    <meta charset="utf-8"> 
    <title>Invoice</title>
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
 
b{ color: black; font-size: 19px !important;}
/* heading */

h1 { font: bold 108% sans-serif !important; letter-spacing: 0.5em !important; text-align: center !important; text-transform: uppercase !important; color: black !important; height: 50px !important; padding-top: 15px !important; font-size: 19px !important;}

p { text-align: center !important; color: black !important; font-size: 18px !important;}
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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Payment Receipts</h6>
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
 
    
    <form>
    
         
<div>
  <header>
    <address>
      <p> <img src="{{ url($profiledata->company_logo) }}" height="100" width="200"></p>
        <p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>
      </address>
      <h1><u>Payment Receipt</u></h1>
      <br>
    </header>
   
<div class="row"> 
  <div class="col-md-8"><b>Receipt No.<input type="text" id="invoice_no" name="invoice_no" value="{{$receiptdata->invoice_no}}" autocomplete="off" disabled></b></div>

  <div class="col-md-4">
     <?php 

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $day.'/'.$month.'/'.$year;
?> 
<b>Date:<input type="text" name="invoice_date" id="invoice_date" autocomplete="off" value="{{$receiptdata->invoice_date}}" disabled></b></div>
</div> 
   <br>
<div class="row">
 <div class="col-md-8">
   <b>Receipt Type:
    <input type="text" @if($receiptdata->receipt_type==1) value="Guest" @else value="Member" @endif></b></div>

     <div class="col-md-4"><b>Member / Guest Name:<input type="text" id="guest_name" name="guest_name" value="{{$receiptdata->guest_name}}" disabled></b>

    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul></div>

 
</div> 
<br>
<div class="row">
   <div class="col-md-4"><b>Member No.<input type="text" id="mem_number" name="mem_number" value="{{$receiptdata->mem_number}}" disabled></b></div>

  <div class="col-md-4"><b>Guest No.<input type="text" id="customer_id" name="customer_id" value="{{$receiptdata->customer_id}}" disabled></b></div>

  <div class="col-md-4"><b>Address:<input type="text" id="guest_address" name="guest_address" autocomplete="off" value="{{$receiptdata->guest_address}}" disabled></b></div>

 
</div>
<br>
<div class="row">
   <div class="col-md-8"><b>Contact:<input type="text" id="guest_contact" name="guest_contact" autocomplete="off" value="{{$receiptdata->guest_contact}}" disabled></b></div>

   <div class="col-md-4"><b>Ledger Amount:<input type="number" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly value="{{$receiptdata->ledger_amount}}" disabled></b></div>
</div>
<br>

<div class="row">
  <div class="col-md-12">

<b>Payment Received For:<input type="text" id="payment_received_for" name="payment_received_for" autocomplete="off" value="{{$finance_payment_receivable->desc}}" disabled></b>
</div>
</div>

<br> 

<div class="row">
  <div class="col-md-12"><b>Payment Details:<input type="text" id="payment_details" name="payment_details" autocomplete="off" value="{{$receiptdata->payment_details}}" disabled></b></div>

</div>


<br>
<div class="row">
  <div class="col-md-12">

<b>Payment Mode:<input type="text" id="payment_method" name="payment_method" autocomplete="off" value="{{$finance_payment_methods->desc?$finance_payment_methods->desc:''}}" disabled></b>
</div>
</div>

<br> 

<div class="row">
  <div class="col-md-12"><b>Mode Details:<input type="text" id="payment_mode_details" name="payment_mode_details" autocomplete="off" value="{{$receiptdata->payment_mode_details}}" disabled></b></div>

</div>
<br>
<!-- 
<div class="row">
  <div class="col-md-3"><b>Payment Method: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="checkbox" class="payment_method" name="payment_method" value="Cash" @if($receiptdata->payment_method=="Cash") checked @endif readonly>&nbsp<b>Cash</b></b></div>
   <div class="col-md-3"><b> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="checkbox" class="payment_method" value="Credit" name="payment_method" readonly @if($receiptdata->payment_method=="Credit") checked @endif>&nbsp<b>Credit Card</b></b></div>

<div class="col-md-4"><input type="checkbox" value="Cheaque" class="payment_method" name="payment_method" readonly @if($receiptdata->payment_method=="Cheaque") checked @endif>&nbsp<b>Cheaque - Cheaque/PO/DD No.<input type="text" value="{{$receiptdata->cheaque_no}}" name="cheaque_no" autocomplete="off" disabled></b></div>
 

<div class="col-md-2"><b>Surcharge (If Any):<input type="number" id="surcharge" name="surcharge" autocomplete="off" value="{{$receiptdata->surcharge}}" disabled></b></div>
</div>

<br> -->


<div class="row">

<div class="col-md-4"><b>Surcharge (If Any):<input type="number" id="surcharge" name="surcharge" autocomplete="off" value="{{$receiptdata->surcharge}}" disabled></b></div>

  <div class="col-md-4"><b>Total Amount:<input type="number" id="total_amount" name="total_amount" autocomplete="off" value="{{$receiptdata->total_amount}}" disabled></b></div>


  <div class="col-md-4"><b>Total Paid Amount:<input type="number" id="total" name="total" autocomplete="off" value="{{$receiptdata->total}}" disabled></b></div>



  
</div>

<br> 
<div class="row">
   <div class="col-md-12"><b>Amount Paid in Words:<input type="text" id="amount_in_words" name="amount_in_words" autocomplete="off" value="{{$receiptdata->amount_in_words}}" disabled></b></div>
</div>

<br>

<div class="row">
  <div class="col-md-12"><b>Remarks:<input type="text" id="remarks" name="remarks" autocomplete="off" value="{{$receiptdata->remarks}}" disabled></b></div>

</div>

<br>
<br>

<p style="text-align: left !important;">If paid by credit card or cheaque, 5% surcharge will be added to the total amount.</p>
<br>
<br>
 
<div class="row" style="text-align: center !important;">
  <div class="col-md-2"></div>
   <div class="col-md-2"></div>
    <div class="col-md-2"></div>
  <div class="col-md-2"><b><span style="text-decoration: underline; white-space: pre;">                         </span>
    <br>Approved By:</b></div>
<div class="col-md-2"><b><span style="text-decoration: underline; white-space: pre;">                         </span>
    <br>Recieved By:</b></div>
  <div class="col-md-2"><b><span style="text-decoration: underline; white-space: pre;">                         </span>
    <br>Paid By:</b></div>
</div>

</div>
</form>

</div>

@endsection



@push('jscode')


@endpush