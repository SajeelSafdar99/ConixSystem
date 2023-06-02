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
.areabox{cursor:pointer !important;}
.areabox_two{cursor:pointer !important;}
</style>

  </head>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Payment Receipts</h6>
         <div style="text-align: right;">
          <!-- <a target="_blank" href="{{ url('room-management/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> -->
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1 && $receiptstatus==0)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Edit Payment Receipt</a></li>
</ul>

@elseif($init==1 && $receiptstatus==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Edit Payment Receipt</a></li>
</ul>

@elseif($init==0 && $receiptstatus==0)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Add Payment Receipt</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Add Payment Receipt</a></li>
</ul>

@endif

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

    @if($init==1)
    <form method="post" action="{{ url('room-management/room-payment-receipts/update') }}/{{ $payment_update->id }}">
     @else
    <form method="post">
    @endif
    @csrf

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
  <div class="col-md-8"><b>Receipt No.<input @if ($errors->has('invoice_no')) style="border-color:red;" @endif type="text" id="invoice_no" name="invoice_no" value="@if($init==0){{$increment_number}}@else{{old('invoice_no',$payment_update->invoice_no)}}@endif" autocomplete="off" readonly></b></div>

  <div class="col-md-4">
     <?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $day.'/'.$month.'/'.$year;
?>
<b>Date:<input @if ($errors->has('invoice_date')) style="border-color:red;" @endif type="text" name="invoice_date" id="invoice_date" autocomplete="off" value="@if($init==0)<?php echo $today;?>@else{{old('invoice_date',$payment_update->invoice_date)}}@endif" readonly></b></div>
</div>
   <br>
<div class="row">

<div class="col-md-8">
   <b>Receipt Type:<br><br>
    <div class="row">
@if($init==1)   <div class="col-sm-6 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('receipt_type',$payment_update->receipt_type)=='0') checked="" @endif @endif type="radio" name="receipt_type" value="0"><span class="pabs">Member</span>
              </label>
            </div><!-- col-3 -->
                                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('receipt_type',$payment_update->receipt_type)=='1') checked="" @endif type="radio" name="receipt_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
                                
                                @else

         <div class="col-sm-6 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('receipt_type')=='0') checked="" @endif @endif type="radio" name="receipt_type" value="0"><span class="pabs">Member</span></label>
            </div><!-- col-3 -->
                                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('receipt_type')=='1') checked="" @endif type="radio" name="receipt_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
                             @endif
          </div>
          </b>
        </div><!-- row-->

 <div class="col-md-4"><b>Member / Guest Name:<input @if($errors->has('guest_name')) style="border-color:red;" @endif type="text" id="guest_name" name="guest_name" onkeyup="customerdata(this.value)" autocomplete="off" class="typeahead" value="@if($init==0){{old('guest_name')}}@else{{old('guest_name',$payment_update->guest_name)}}@endif"></b>

    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul></div>

  <!-- <div class="col-md-4"><b>Membership No.<input @if ($errors->has('mem_number')) style="border-color:red;" @endif type="text" id="mem_number" name="mem_number" autocomplete="off" onkeyup="memdata(this.value)" class="typeahead" value="@if($init==0){{old('mem_number')}}@else{{$payment_update->mem_number}}@endif"></b>

    <ul id="areabox_two" class="areabox_two" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul></div> -->
</div>
<br>
<div class="row">
  <div class="col-md-4"><b>Member No.<input @if ($errors->has('mem_code')) style="border-color:red;" @endif type="text" id="mem_number" autocomplete="off" readonly value="@if($init==0){{old('mem_code')}}@else{{$payment_update->member?$payment_update->member->mem_no:''}}@endif"><input type="hidden" value="@if($init==0){{old('mem_number')}}@else{{$payment_update->mem_number}}@endif" name="mem_number" id="member_id"> </b></div>
  <div class="col-md-4"><b>Guest No.<input @if ($errors->has('customer_id')) style="border-color:red;" @endif type="text" id="customer_id" name="customer_id" autocomplete="off" readonly value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$payment_update->customer_id)}}@endif"></b></div>

  <div class="col-md-4"><b>Address:<input @if ($errors->has('guest_address')) style="border-color:red;" @endif type="text" id="guest_address" name="guest_address" autocomplete="off" readonly value="@if($init==0){{old('guest_address')}}@else{{old('guest_address',$payment_update->guest_address)}}@endif"></b></div>
</div>
<br>
<div class="row">
  <div class="col-md-8"><b>Contact:<input @if ($errors->has('guest_contact')) style="border-color:red;" @endif type="text" id="guest_contact" name="guest_contact" autocomplete="off" value="@if($init==0){{old('guest_contact')}}@else{{old('guest_contact',$payment_update->guest_contact)}}@endif" readonly></b></div>

  <div class="col-md-4"><b>Ledger Amount:<input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$payment_update->ledger_amount)}}@endif"></b></div>

</div>
<br>

<div class="row">
  <div class="col-md-12">
<h6><b>Payment Received For:</b><select @if ($errors->has('payment_received_for')) style="border-color:red;" @endif  id="payment_received_for" name="payment_received_for">
    <option label="Choose Option"></option>
 @foreach($finance_payment_receivable as $receivable)
                                @if($init==1)
                                 <option @if(old('payment_received_for',$payment_update->payment_received_for)==$receivable->id)  selected @endif  value="{{ $receivable->id }}">
                                  {{ $receivable->desc }}
                                </option>
                                @else
                                 <option @if(old('payment_received_for')==$receivable->id)  selected @endif value="{{ $receivable->id }}">
                                  {{ $receivable->desc }}
                                </option>
                                @endif
                                @endforeach

</select></h6>
</div>
</div>

<br>

<div class="row">
  <div class="col-md-12"><b>Payment Details:<input @if ($errors->has('payment_details')) style="border-color:red;" @endif type="text" id="payment_details" name="payment_details" autocomplete="off" value="@if($init==0){{old('payment_details')}}@else{{old('payment_details',$payment_update->payment_details)}}@endif"></b></div>

</div>

<br>
<div class="row">
  <div class="col-md-12">
<h6><b>Payment Mode:</b><select @if ($errors->has('payment_method')) style="border-color:red;" @endif  id="payment_method" name="payment_method">
    <option label="Choose Option"></option>
 @foreach($payment_methods as $methods)
                                @if($init==1)
                                 <option @if(old('payment_method',$payment_update->payment_method)==$methods->id)  selected @endif  value="{{ $methods->id }}">
                                  {{ $methods->desc }}
                                </option>
                                @else
                                 <option @if(old('payment_method')==$methods->id)  selected @endif value="{{ $methods->id }}">
                                  {{ $methods->desc }}
                                </option>
                                @endif
                                @endforeach

</select></h6>
</div>
</div>

<br>

<div class="row">
  <div class="col-md-12"><b>Mode Details:<input @if ($errors->has('payment_mode_details')) style="border-color:red;" @endif type="text" id="payment_mode_details" name="payment_mode_details" autocomplete="off" value="@if($init==0){{old('payment_mode_details')}}@else{{old('payment_mode_details',$payment_update->payment_mode_details)}}@endif"></b></div>

</div>

<br>
<!-- 
<div class="row">
  <div class="col-md-3"><b>Payment Method: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp @if($init==1)<input type="checkbox" class="payment_method" name="payment_method" @if(old('payment_method',$payment_update->payment_method)=="Cash") checked @endif value="Cash">@else<input @if(old('payment_method')=='Cash') checked @endif type="checkbox" class="payment_method" name="payment_method" value="Cash">@endif &nbsp<b>Cash</b></b></div>
   <div class="col-md-3"><b> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  @if($init==1)<input type="checkbox" class="payment_method" name="payment_method" value="Credit" @if(old('payment_method',$payment_update->payment_method)=="Credit") checked @endif>@else<input @if(old('payment_method')=='Credit') checked @endif type="checkbox" class="payment_method" name="payment_method" value="Credit">@endif &nbsp<b>Credit Card</b></b></div>

<div class="col-md-4"> @if($init==1)<input type="checkbox" class="payment_method" value="Cheaque" name="payment_method" @if(old('payment_method',$payment_update->payment_method)=="Cheaque") checked @endif>@else<input @if(old('payment_method')=='Cheaque') checked @endif type="checkbox" class="payment_method" value="Cheaque" name="payment_method">@endif &nbsp<b>Cheaque - Cheaque/PO/DD No.<input @if ($errors->has('cheaque_no')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('cheaque_no')}}@else{{old('cheaque_no',$payment_update->cheaque_no)}}@endif" name="cheaque_no" autocomplete="off"></b></div>


<div class="col-md-2"><b>Surcharge (If Any):<input @if ($errors->has('surcharge')) style="border-color:red;" @endif type="number" id="surcharge" name="surcharge" autocomplete="off" oninput="add_surcharge()" value="@if($init==0){{old('surcharge')}}@else{{old('surcharge',$payment_update->surcharge)}}@endif"></b></div>
</div>

<br>
 -->

<div class="row">
<div class="col-md-4"><b>Surcharge (If Any):<input @if ($errors->has('surcharge')) style="border-color:red;" @endif type="number" id="surcharge" name="surcharge" autocomplete="off" oninput="add_surcharge()" value="@if($init==0){{old('surcharge')}}@else{{old('surcharge',$payment_update->surcharge)}}@endif"></b></div>

  <div class="col-md-4"><b>Total Amount:<input @if ($errors->has('total_amount')) style="border-color:red;" @endif type="number" id="total_amount" name="total_amount" autocomplete="off" oninput="add_surcharge()" value="@if($init==0){{old('total_amount')}}@else{{old('total_amount',$payment_update->total_amount)}}@endif"></b></div>

<!--
  <div class="col-md-4"><b>Discount Amount:<input type="number" name="discount" id="discount" autocomplete="off" oninput="subtract_discount()" value="@if($init==0){{old('discount')}}@else{{$payment_update->discount}}@endif"></b></div>
 -->

  <div class="col-md-4"><b>Total Paid Amount:<input @if ($errors->has('total')) style="border-color:red;" @endif type="number" id="total" name="total" autocomplete="off" readonly value="@if($init==0){{old('total')}}@else{{old('total',$payment_update->total)}}@endif"></b></div>




</div>

<br>
<div class="row">
   <div class="col-md-12"><b>Amount Paid in Words:<input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly id="amount_in_words" name="amount_in_words" autocomplete="off" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$payment_update->amount_in_words)}}@endif"></b></div>
</div>

<br>

<div class="row">
  <div class="col-md-12"><b>Remarks:<input @if ($errors->has('remarks')) style="border-color:red;" @endif type="text" id="remarks" name="remarks" autocomplete="off" value="@if($init==0){{old('remarks')}}@else{{old('remarks',$payment_update->remarks)}}@endif"></b></div>

</div>

<br>
<br>

<p style="text-align: left !important;">If paid by credit card or cheaque, 5% surcharge will be added to the total amount.</p>

<br>
<br>
 @if($init==1)
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-payment-receipts') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

   @else
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-payment-receipts') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>
  @endif



</div>
</form>

</div>

@endsection



@push('jscode')

<script type="text/javascript">
  var val;
  function memdatavalue(val){

   $.ajax({
    type : 'POST',
    url : '{{ url('room-management/room-payment-receipts/memdata') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "membershipid": val
        },
  success: function(data){

console.log(data);
   var obj = JSON.parse(data);
  document.getElementById('mem_number').value=obj.mem_no;
  document.getElementById('guest_contact').value=obj.mob_a;
 document.getElementById('guest_address').value=obj.address;
  jQuery('#areabox_two').html('');

      }


      });
}
</script>
<script type="text/javascript">
  var val;

  function memdata(val){
    jQuery('#areabox_two').html('');
   $.ajax({
    type : 'POST',
    url : '{{ url('room-management/room-payment-receipts/memdatalike') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "membershipid": val
        },
  success: function(data){


jQuery.each( JSON.parse(data), function( i, val1 ) {
  $("#areabox_two").append(`<li onclick="memdatavalue('${val1.id}')">${val1.mem_no}<li>`);
});

    // $('#areabox_two').html(data);

      }
      });
}
</script>



<script type="text/javascript">
  var val;
  function customerdatavalue(val){
    let v=$('input[name="receipt_type"]:checked').val();

   $.ajax({
    type : 'POST',
    url : '{{ url('room-management/room-payment-receipts/customerdata') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "customerid": val,
        'MOC':v
        },
  success: function(data){

console.log(data);
   var obj = JSON.parse(data);
   if(v==1){
       document.getElementById('mem_number').value='';
       document.getElementById('member_id').value='';

  document.getElementById('guest_name').value=obj.customer_name;
  document.getElementById('guest_address').value=obj.customer_address;
  document.getElementById('guest_contact').value=obj.customer_contact;
  document.getElementById('customer_id').value=obj.id;
  document.getElementById('ledger_amount').value=obj.balance;
   }
 else{
  document.getElementById('guest_name').value=obj.applicant_name;
  document.getElementById('guest_address').value=obj.cur_address;
  document.getElementById('guest_contact').value=obj.mob_a;
  document.getElementById('mem_number').value=obj.mem_no;
  document.getElementById('member_id').value=obj.id;
       document.getElementById('customer_id').value='';

       document.getElementById('ledger_amount').value=obj.balance;
  }
  jQuery('#areabox').html('');

      }


      });
}
</script>

<script type="text/javascript">
  var val;

  function customerdata(val){
     let v=$('input[name="receipt_type"]:checked').val();

   $.ajax({
    type : 'POST',
    url : '{{ url('room-management/room-payment-receipts/customerdatalike') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "customerid": val,
        'MOC':v
        },
  success: function(data){
jQuery('#areabox').html('');
jQuery.each( JSON.parse(data), function( i, val1 ) {
   if(v==1){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name}<li>`);
   }else{
    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.applicant_name} :${val1.mem_no} <li>`);
                        }
});

    // $('#areabox').html(data);

      }
      });
}
</script>

 <script type="text/javascript">
      $('.purpose').on('change', function() {
        $('.purpose').not(this).prop('checked', false);
    });
    </script>

    <script type="text/javascript">
      $('.payment_method').on('change', function() {
        $('.payment_method').not(this).prop('checked', false);
    });
    </script>


<script type="text/javascript">
   function add_surcharge() {

                var first = parseFloat(document.getElementById("total_amount").value);
                var second = parseFloat(document.getElementById("surcharge").value);
                 if(Number.isNaN(first)){
                first=0;
              }
                if(Number.isNaN(second)){
                second=0;
              }
                var result = first + second;

                document.getElementById("total").value = result;

            }
</script>

<!--
<script type="text/javascript">
   function subtract_surcharge() {

                var first = parseFloat(document.getElementById("total_sub_amount").value);
                var second = parseFloat(document.getElementById("surcharge").value);
                if(Number.isNaN(second)){
                second=0;
              }
                var result = first + second;

                document.getElementById("total_amount").value = result;

            }
</script>



<script type="text/javascript">
   function subtract_discount() {

                var first = parseFloat(document.getElementById("total_amount").value);
                var second = parseFloat(document.getElementById("discount").value);
                if(Number.isNaN(second)){
                second=0;
              }
                var result = first - second;

                document.getElementById("total").value = result;

            }
</script>
 -->

<script type="text/javascript">

  function extrachargesselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('room-management/room-payment-receipts/calculateextracharges/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){
   var obj = JSON.parse(data);
  if(obj)
  {
    document.getElementById('charges_amount'+idd).value=obj;
  // $('#addressdata').html(data);
 // total+=parseInt(obj);
    //document.getElementById('total_room_charges').value=total;
   total=0;
    $('.charamt').each(function (index, element) {
        total +=parseFloat($(element).val());
    });

   document.getElementById('total_sub_amount').value=total;

calculate_total();

  }
}
   });





  }


function extrachargesselect2(){
    total=0;
    $('.charamt').each(function (index, element) {
        total +=parseFloat($(element).val());
    });

   document.getElementById('total_sub_amount').value=total;

  }



</script>

<script type="text/javascript">
 var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lac ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str + 'only';
}

document.getElementById('amount_in_words').onclick = function () {
document.getElementById('amount_in_words').value = inWords(document.getElementById('total').value);
};
</script>

@endpush
