@extends('backend.layout.app')
@section('page-content')

<head>
    <meta charset="utf-8">
    <title>Cash Receipt</title>
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

    .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }

.areabox{cursor:pointer !important;}
.areabox_two{cursor:pointer !important;}

div.groove {border-style: groove !important; height: 200px !important;}
div.saveoptions { height: 390px !important; }

.padtheicon{
  padding-top: 15px;
  cursor: pointer;
}

.pc{
  display:inline-block;
  position: relative;
  }
.pc input{
  padding-left:15px;
  }
.pc:before {
  position: absolute;
    content:"%";
    left:17px;
  top:6px;
  }
</style>

  </head> 
<div class="br-pagebody">
        <!-- <div class="br-section-wrapper"> -->
          <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Cash Receipts</h6>
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
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Cash Receipts List</a></li>
  <li><a href>Edit Cash Receipt</a></li>
</ul>

@elseif($init==1 && $receiptstatus==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-payments-submodules') }}">Payments</a></li>
  <li><a href="{{ url('finance-and-management/payment-receipts') }}">Cash Receipts List</a></li>
  <li><a href>Edit Cash Receipt</a></li>
</ul>

@elseif($init==0 && $receiptstatus==0)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Cash Receipts List</a></li>
  <li><a href>Add Cash Receipt</a></li>
</ul>

@elseif($init==1 && $receiptstatus==2)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/payment-receipts') }}">Cash Receipts List</a></li>
  <li><a href>Edit Cash Receipt</a></li>
</ul>

@elseif($init==0 && $receiptstatus==2)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/payment-receipts') }}">Cash Receipts List</a></li>
  <li><a href>Add Cash Receipt</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-payments-submodules') }}">Payments</a></li>
  <li><a href="{{ url('finance-and-management/payment-receipts') }}">Cash Receipts List</a></li>
  <li><a href>Add Cash Receipt</a></li>
</ul>

@endif

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

    @if($init==1 && $receiptstatus==0)
    <form method="post" action="{{ url('room-management/room-payment-receipts/update') }}/{{ $payment_update->id }}">
      @elseif($init==1 && $receiptstatus==1)
    <form method="post" action="{{ url('finance-and-management/payment-receipts/update') }}/{{ $payment_update->id }}">
      @elseif($init==1 && $receiptstatus==2)
    <form method="post" action="{{ url('events-management/payment-receipts/update') }}/{{ $payment_update->id }}">
     @else
    <form method="post">
    @endif
    @csrf


                                        <div class="form-layout form-layout-4 ">

                  <div class="row">
               <div class="col-sm-10">



<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">Receipt #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('invoice_no')) style="border-color:red;" @endif type="text" class="form-control input-height" id="invoice_no" name="invoice_no" value="@if($init==0){{$increment_number}}@else{{old('invoice_no',$payment_update->invoice_no)}}@endif" autocomplete="off" readonly style="background-color: #c1c1c1" style="background-color: #c1c1c1">
                        </div>
                              

                       <label class="col-sm-1 form-control-label">
                                                    Receipt Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <?php

                                          
$month = date('m');
$day = date('d');
$year = date('Y');

$today = $day.'/'.$month.'/'.$year;
?>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
            <input @if ($errors->has('invoice_date')) style="border-color:red;" @endif type="text" name="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="@if($init==0)<?php echo $today;?>@else{{old('invoice_date',$payment_update->invoice_date)}}@endif" readonly style="background-color: #c1c1c1">

                                                    </div>

             <label class="col-sm-1 form-control-label">    Ledger Amount:<span class="tx-danger">*</span>
             &nbsp &nbsp &nbsp &nbsp &nbsp
<a class="showAfterSelection" style="display: none" href="{{ url('finance-and-management/finance-ledger-accounts') }}" data-href="{{ url('finance-and-management/finance-ledger-accounts') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a>
               </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
       <input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$payment_update->ledger_amount)}}@endif">
                        </div>


                                                 </div>
                                                <!-- row -->


  <div class="row mg-t-10">

        @if($init==1)   <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('receipt_type',$payment_update->receipt_type)=='0') checked="" @endif @endif type="radio" name="receipt_type" value="0"><span class="pabs">Member</span>
              </label>

                <label class="rdiobox">
   <input @if(old('receipt_type',$payment_update->receipt_type)=='1') checked="" @endif type="radio" name="receipt_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->

                                @else

        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('receipt_type')=='0') checked="" @endif @endif type="radio" name="receipt_type" value="0"><span class="pabs">Member</span></label>

                <label class="rdiobox">
    <input @if(old('receipt_type')=='1') checked="" @endif type="radio" name="receipt_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
                             @endif

      <div class="col-sm-3 mg-t-10 mg-sm-t-0">
<input @if($errors->has('guest_name')) style="border-color:red;" @endif type="text" class="form-control input-height" id="guest_name" name="guest_name" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" autocomplete="off" class="typeahead" placeholder="Search By Name or ID" value="@if($init==0){{old('guest_name')}}@else{{old('guest_name',$payment_update->guest_name)}}@endif">

                                                        <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>

                                                 </div>
                                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                                                        <a href="{{ url('room-management/room-customer/room-customer-aeu') }}"
                                                           target="_blank">
                                                            <input type="button" value="Add Guest"
                                                                   class="btn btn-info">
                                                        </a>
                                                    </div>




                                                    <label class="col-sm-1 form-control-label">
                                              Family Member:
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                         <select onchange="relationship(this.id)" @if ($errors->has('family')) id="{{ $familymembers->id }}"

            style="border-color:red;" @endif id="family" class="form-control input-height select2" name="family"> <option label="Choose Family Member">  </option>
                    @foreach($familymembers as $fm)
         @if($init==1)
        <option
           @if(old('family',$payment_update->family)==$fm->id)  selected  @endif  value="{{ $fm->id }}"> {{ $fm->name }} ({{ $fm->relationship_name->desc }})
                         </option>  @else
            <option
        @if(old('family')==$fm->id)  selected @endif value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         @endif
                            @endforeach
                                                        </select>
                                                    </div>




                                           <label class="col-sm-1 form-control-label"> Member #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('mem_code')) style="border-color:red;" @endif type="text" class="form-control input-height" id="mem_number" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('mem_code')}}@else{{old($payment_update->member?$payment_update->member->mem_no:'')}}@endif"><input type="hidden" value="@if($init==0){{old('mem_number')}}@else{{$payment_update->mem_number}}@endif" name="mem_number" id="member_id">
                        </div>


                             <label class="col-sm-1 form-control-label"> Guest #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('customer_id')) style="border-color:red;" @endif type="text" class="form-control input-height" id="customer_id" name="customer_id" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$payment_update->customer_id)}}@endif">                        </div>

                                                 </div>
                                                <!-- row -->

  <div class="row mg-t-10">


           <label class="col-sm-1 form-control-label">
                                              Contact:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('guest_contact')) style="border-color:red;" @endif type="text" class="form-control input-height" id="guest_contact" name="guest_contact" autocomplete="off" value="@if($init==0){{old('guest_contact')}}@else{{old('guest_contact',$payment_update->guest_contact)}}@endif" readonly style="background-color: #c1c1c1">
</div>


  <label class="col-sm-1 form-control-label">Address:<span class="tx-danger">  * </span>  </label>

                                                    <div class="col-sm-6 mg-t-10 mg-sm-t-0">
              <input @if ($errors->has('guest_address')) style="border-color:red;" @endif type="text" class="form-control input-height" id="guest_address" name="guest_address" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('guest_address')}}@else{{old('guest_address',$payment_update->guest_address)}}@endif">

                                                    </div>

                                                 </div>
                                                <!-- row -->



<br><br>
<div class="groove">

  <div class="row mg-t-10">
 <label class="col-sm-1 form-control-label">
                                         Payment Received For:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">

<select @if ($errors->has('payment_received_for')) style="border-color:red;" @endif  id="payment_received_for" class="form-control input-height select2" name="payment_received_for">
    <option label="Choose Option"></option>
 @foreach($finance_payment_receivable as $receivable)
     @can($receivable->desc.' '.$receivable->id)

                                @if($init==1)
                                 <option @if(old('payment_received_for',$payment_update->payment_received_for)==$receivable->id)  selected @endif  value="{{ $receivable->id }}">
                                  {{ $receivable->desc }}
                                </option>
                                @else
                                 <option @if((isset($invoice)) && $invoice->payment_received_for==$receivable->id) selected="selected" @endif @if(old('payment_received_for')==$receivable->id)  selected @endif value="{{ $receivable->id }}">
                                  {{ $receivable->desc }}
                                </option>
                                @endif
        @endcan
                                @endforeach

</select>
</div>
 <label class="col-sm-1 form-control-label">
                                        Payment Details: 
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">

<input @if ($errors->has('payment_details')) style="border-color:red;" @endif type="text" placeholder="Enter Details" id="payment_details" name="payment_details" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('payment_details')}}@else{{old('payment_details',$payment_update->payment_details)}}@endif">
</div>
</div>

  <div class="row mg-t-10">
 <label class="col-sm-1 form-control-label">
                                        Payment Mode:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">

<select @if ($errors->has('payment_method')) style="border-color:red;" @endif  id="payment_method" name="payment_method" class="form-control input-height select2">
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

</select>
</div>
 <label class="col-sm-1 form-control-label">
                                          Mode Details:
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<textarea @if ($errors->has('payment_mode_details')) style="border-color:red;" @endif type="text" id="payment_mode_details" class="form-control" name="payment_mode_details" placeholder="Enter Details" autocomplete="off">@if($init==0){{old('payment_mode_details')}}@else{{old('payment_mode_details',$payment_update->payment_mode_details)}}@endif</textarea>
</div>
</div>

</div>
<br><br>



  <div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                          Total Amount:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                            <input  @if ($errors->has('total_amount')) style="border-color:red;" @endif type="number" id="total_amount" name="total_amount" class="form-control input-height" autocomplete="off" oninput="add_surcharge()" value="@if($init==0){{old('total_amount')}}@else{{old('total_amount',$payment_update->total_amount)}}@endif">
</div>

        <label class="col-sm-1 form-control-label">Surcharge (If Any): </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
          <input @if ($errors->has('surcharge')) style="border-color:red;" @endif type="number" id="surcharge" name="surcharge" autocomplete="off" oninput="add_surcharge()" placeholder="Enter Amount" class="form-control input-height" value="@if($init==0){{old('surcharge')}}@else{{old('surcharge',$payment_update->surcharge)}}@endif">

                                                    </div>



                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0 pc">
           <input type="number" @if ($errors->has('surcharge_percentage')) style="border-color:red;"
                                                               @endif id="surcharge_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('surcharge_percentage')}}@else{{old('surcharge_percentage',$payment_update->surcharge_percentage)}}@endif" name="surcharge_percentage" oninput="s_percentage()">

                                                    </div>

                                             
                                                 </div>
                                                <!-- row -->

  <div class="row mg-t-10">
   <label class="col-sm-1 form-control-label">
                                       Total Paid Amount:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <input @if ($errors->has('total')) style="border-color:red;" @endif type="number" class="form-control input-height" id="total" name="total" autocomplete="off" readonly style="background-color: #c1c1c1"value="@if($init==0){{old('total')}}@else{{old('total',$payment_update->total)}}@endif">
</div>



      <label class="col-sm-1 form-control-label"> Amt in Words:</label>
<span class="tx-danger"> * </span>
                                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0" >
          <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$payment_update->amount_in_words)}}@endif">

                                                    </div>

</div>


<div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                      Remarks:
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <textarea @if ($errors->has('remarks')) style="border-color:red;" @endif type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Details" autocomplete="off">@if($init==0){{old('remarks')}}@else{{old('remarks',$payment_update->remarks)}}@endif</textarea>
</div>

                              </div>
                                                <!-- row -->


<br><br>
<br>
<b>NOTE:</b><p style="text-align: left !important;">If paid by credit card or cheaque, 5% surcharge will be added to the total amount.</p>

  <div class="float-left">



                                          @if($init==1 && $receiptstatus==0)
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-payment-receipts') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

            @elseif($init==1 && $receiptstatus==1)
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/payment-receipts') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

            @elseif($init==1 && $receiptstatus==2)
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('events-management/payment-receipts') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

   @elseif($init==0 && $receiptstatus==2)
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp
                  <a href="{{ url('events-management/payment-receipts') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>
             @elseif($init==0 && $receiptstatus==1)
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/payment-receipts') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>

             @else
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-payment-receipts') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>
  @endif
                                            </div><!-- form-layout -->
                                     </div>







<div class="col-sm-2">
 <div class="saveoptions"></div>

</div>

                                                </div>

<br><br>

                                        </div><!-- col-6 -->
                                    </form>
            </div>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->


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
    @if(isset($invoice))
        $(document).ready(function(){
            customerdatavalue({{$invoice->member_id}});
        document.getElementById('amount_in_words').value = inWords(document.getElementById('total').value);
    })
        @endif
  var val;
  function customerdatavalue(val){
    let v=$('input[name="receipt_type"]:checked').val();

   $.ajax({
    type : 'POST',
    url : '{{ url('search/customerdata') }}',
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
  $('#family').html('<option label="Choose Family Member">  </option>');
       let d='?customer='+obj.customer_name+'&mog=1&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
   }
 else{
  document.getElementById('guest_name').value=obj.applicant_name;
  document.getElementById('guest_address').value=obj.cur_address;
  document.getElementById('guest_contact').value=obj.mob_a;
  document.getElementById('mem_number').value=obj.mem_no;
  document.getElementById('member_id').value=obj.id;
       document.getElementById('customer_id').value='';
       let d='?customer='+obj.applicant_name+'&mog=0&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
       document.getElementById('ledger_amount').value=obj.balance;

 let selected="{{$init==1?$payment_update->family:''}}";
        $('#family').html('<option label="Choose Family Member">  </option>');
                        $.each(obj.family,function(x,y){

                          let s='<option value="'+y.id+'">'+y.name+' '+'('+(y.relationship_name.desc)+')'+'</option>';

                          console.log(selected==y.id);
                          if(selected==y.id){

                              s='<option value="'+y.id+'" selected="selected">'+y.name+' '+'('+(y.relationship_name.desc)+')'+'</option>';
                          }
                            $('#family').append(s);
                        })
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
    url : '{{ url('search/customerdatalike') }}',
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
$('#areabox').show();
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

 <script type="text/javascript">
       function s_percentage() {

                    var first = parseFloat(document.getElementById("total_amount").value);

                    var second = parseFloat(document.getElementById("surcharge_percentage").value);
                
                   if(Number.isNaN(second)){
                    second=0;
                  }

                   if (Number.isNaN(first)) {
                first = 0;
            }

    var surcharge = second / 100;
    var totalValue = first + (first * surcharge);

            document.getElementById("total").value = Math.round(totalValue);



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

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  
<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

@endpush
