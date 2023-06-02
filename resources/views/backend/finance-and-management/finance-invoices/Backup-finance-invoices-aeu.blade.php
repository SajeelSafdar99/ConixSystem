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

    .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }

.areabox{cursor:pointer !important;}
.areabox_two{cursor:pointer !important;}

div.groove {border-style: groove !important; height: 300px !important;}
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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Invoices</h6>
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
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Edit Invoice</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Add Invoice</a></li>
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

    @if($init==1)
    <form method="post" action="{{ url('finance-and-management/finance-invoices/update') }}/{{ $invoice_update->id }}">
     @else
    <form method="post">
    @endif
    @csrf


{{-- Modal --}}

<div id="modaldemo1" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 1000px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">RECEIVE PAYMENT:</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>


                 <div class="modal-body pd-25">
              <div class="row ">   
                      <div class="col-md-12">

 <div class="row mg-t-10">   
   <label class="col-sm-2 form-control-label">Account Types:<span class="tx-danger">*</span></label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('account_type')) style="border-color:red;" @endif id="account_type" class="form-control input-height select2" name="account_type">
                            <option label="Choose Option">
                                </option>
                               @foreach($account_types as $type)
                            @can($type->name.' '.$type->mod_id)
                                 <option @if(old('account_type')==$type->id)  selected @endif value="{{ $type->id }}">
                                  {{ $type->name }}
                                </option>
                              @endcan
                                @endforeach
                            </select>
                  </div>

          </div>    
 <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-2 form-control-label">Grand Total:<span class="tx-danger">*</span></label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('grand')) style="border-color:red;" @endif id="grand" type="number" readonly name="grand" placeholder="Enter Amount" class="form-control input-height" autocomplete="off" value="">
                  </div>
                </div><!-- row -->

                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-2 form-control-label">Amount Received:</label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('amount_received')) style="border-color:red;" @endif id="amount_received" type="number" name="amount_received" oninput="calculatereturn()" class="form-control input-height" placeholder="Enter Amount" autocomplete="off" value="">
                  </div>
                </div><!-- row -->

                 <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-2 form-control-label">Return Value:<span class="tx-danger">*</span></label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('return_value')) style="border-color:red;" @endif id="return_value" type="number" name="return_value" class="form-control input-height" placeholder="Enter Balance" readonly autocomplete="off" value="">
                  </div>
                </div><!-- row -->

           <div class="row mg-t-10">   
                      <label class="col-sm-2 form-control-label">Comment Box:</label>
                        <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter Remarks" rows="2" name="remarks">{{old('remarks')}}</textarea>
                        </div>
                   
</div>
<br>
             
                  </div>
              </div>
                 <div class="modal-footer">
                
                  <input type="submit" name="receive" class="btn btn-info tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" value="RECEIVE & PRINT">
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
               
            </div><!-- modal-dialog -->
          </div><!-- modal -->
   </div>
 </div>
{{-- Modal --}}

                                        <div class="form-layout form-layout-4 ">

                  <div class="row">
               <div class="col-sm-10">



<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">  Invoice #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
    <input id="invoice_no" class="form-control input-height" type="number" readonly value="@if($init==0){{$increment_number}}@else{{old('invoice_no', $invoice_update->id)}}@endif"
                                                               name="invoice_no" style="background-color: #c1c1c1">
                        </div>
                                                    @if ($errors->has('invoice_no'))
                                                        <span class="help-block">
                        <strong>{{ $errors->first('invoice_no') }}</strong>
                        </span>
                                                    @endif



                                                    <label class="col-sm-1 form-control-label">
                                                    Invoice Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <?php

                                                    $month = date('m');
                                                    $day = date('d');
                                                    $year = date('Y');

                                                    $today = $day . '/' . $month . '/' . $year;
                                                    ?>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
              <input  @if ($errors->has('invoice_date')) style="border-color:red;" @endif id="invoice_date" class="form-control input-height" type="text" value="@if($init==0)<?php echo $today;?>@else{{old('invoice_date',formatDateToShow($invoice_update->invoice_date))}}@endif" name="invoice_date" readonly style="background-color: #c1c1c1">

                                                    </div>

             <label class="col-sm-1 form-control-label">    Ledger Amount:<span class="tx-danger"> </span>
          
<a class="showAfterSelection" style="display: none" href="{{ url('finance-and-management/finance-ledger-accounts') }}" data-href="{{ url('finance-and-management/finance-ledger-accounts') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a>
               </label>
                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
       <input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$invoice_update->ledger_amount)}}@endif">
                        </div>


                                                 </div>
                                                <!-- row -->


  <div class="row mg-t-10">

        @if($init==1)   <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('invoice_type',$invoice_update->invoice_type)=='0') checked="" @endif @endif type="radio" name="invoice_type" value="0"><span class="pabs">Member</span>
              </label>

                <label class="rdiobox">
    <input @if(old('invoice_type',$invoice_update->invoice_type)=='1') checked="" @endif type="radio" name="invoice_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->

                                @else

        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('invoice_type')=='0') checked="" @endif @endif type="radio" name="invoice_type" value="0"><span class="pabs">Member</span></label>

                <label class="rdiobox">
    <input @if(old('invoice_type')=='1') checked="" @endif type="radio" name="invoice_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
                             @endif

      <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                                  <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" class="form-control input-height typeahead" placeholder="Enter Number to Search" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$invoice_update->name)}}@endif"
                                                               type="text" name="name"
                                                               onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

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
                                              Contact: </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                     <input @if ($errors->has('contact')) style="border-color:red;"
                                                               @endif id="contact" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('contact')}}@else{{old('contact',$invoice_update->contact)}}@endif"
                                                               type="text" name="contact">
</div>

            <label class="col-sm-1 form-control-label">
                                              CNIC #: </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                              <input @if ($errors->has('cnic')) style="border-color:red;"
                                                               @endif id="cnic" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('cnic')}}@else{{old('cnic',$invoice_update->cnic)}}@endif"
                                                               type="text" name="cnic">
</div>





                         

                                                 </div>
                                                <!-- row -->

  <div class="row mg-t-10">


                                           <label class="col-sm-1 form-control-label"> Member #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="mem_no" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('mem_no')}}@else{{old('mem_no',$invoice_update->mem_no)}}@endif"
                                                               type="text" name="mem_no">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_id')}}@else{{old('member_id',$invoice_update->member_id)}}@endif"
                                                               type="hidden" name="member_id">
                        </div>

          <label class="col-sm-1 form-control-label"> Guest #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-1 mg-t-10 mg-sm-t-0">
        <input  @if ($errors->has('customer_id')) style="border-color:red;"
                                                            @endif id="customer_id" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$invoice_update->customer_id)}}@endif"
                                                            type="text" name="customer_id">
                        </div>





                    <label class="col-sm-1 form-control-label">
                                              Email: </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                     <input @if ($errors->has('email')) style="border-color:red;"
                                                               @endif id="email" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('email')}}@else{{old('email',$invoice_update->email)}}@endif"
                                                               type="text" name="email">
</div>


  <label class="col-sm-1 form-control-label">Address: </label>

                                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
               <input @if ($errors->has('address')) style="border-color:red;"
                                                            @endif id="address" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('address')}}@else{{old('address',$invoice_update->address)}}@endif"
                                                            type="text" name="address">

                                                    </div>

                                                 </div>
                                                <!-- row -->
<br><br>
<div class="groove">
<div @if($init==0) class="hidethisdiv" @endif>          <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td width="20%" align="left">Type</td>
                                                        <td width="10%" align="left">Amount</td>
                                                        <td width="10%" align="left">Start Date</td>
                                                        <td width="10%" align="left">End Date</td>
                                                        <td width="10%" align="left">Days</td>
                                                        <td width="10%" align="left">Qty</td>
                                                        <td width="10%" align="left">Total</td>
                                                        <td width="20%" align="left">Family Member</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">

                                                    @if($init==1)
                                                   @foreach($bookingsubdata as $bookingsub)

                                                            <tr>
                                  <td><select id="{{ $bookingsub->id }}" onchange="extrachargesselect(this.id)"
                                                                            class="form-control input-height select2"
                                                                            name="charges_type[]">
                                <option value="">Choose Option</option>
             <optgroup label="Main Charges">
   @foreach($main_types as $main)
    @can('Invoice'.' '.$main->id)

                                         @if($init==1)
                  <option  @if(old('charges_type[]',$bookingsub->charges_type)==$main->id)  selected @endif value="{{ $main->id }}"> {{ $main->name }}  </option>
                                   @endif
                                   @endcan
                                  @endforeach
</optgroup>


                                                <optgroup label="Charges Types">
                                                                        @foreach($finance_invoice_charges_type as $roomcharges)
                                       @can('Invoice'.' '.$roomcharges->name.' '.$roomcharges->mod_id)

                                         @if($init==1)
                  <option  @if(old('charges_type[]',$bookingsub->charges_type)==$roomcharges->id)  selected
                                                                                    @endif value="{{ $roomcharges->id }}">
                                                                                    {{ $roomcharges->name }}
                                                                                </option>
                                                                          
                                                                           @endif
                                                                            @endcan
                                                                        @endforeach
                                                                        </optgroup>
  <optgroup label="Subscription Types">
                                                                        @foreach($subscription_type as $subscription)
  @can('Invoice'.' '.$subscription->name.' '.$subscription->mod_id)
                                         @if($init==1)
                  <option  @if(old('charges_type[]',$bookingsub->charges_type)==$subscription->id)  selected
                                                                                    @endif value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                                                                    {{ $subscription->name }}
                                                                                </option>
                                                                       
                                                                              @endif
                                                                            @endcan
                                                                        @endforeach
                                                                        </optgroup>


                                                                    </select></td>
 <td>
  <input id="charges_amount{{ $bookingsub->id }}" onkeyup="extrachargesselect2()"
                                                                           class="form-control input-height"
                                                                           type="number" name="charges_amount[]"
                                                                           value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$bookingsub->charges_amount)}}@endif"
                                                                          >
                                                                </td>

              <td>
         <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date{{ $bookingsub->id }}" class="form-control input-height" type="text"
                                                                           name="start_date[]"
                                                                           value="@if($init==0){{old('start_date[]')}}@else{{old('start_date[]',formatDateToShow($bookingsub->start_date))}}@endif">
                                                                </td>
 <td>
         <input id="end_date{{ $bookingsub->id }}" placeholder="dd/mm/yyyy" autocomplete="off" class="form-control input-height" type="text"
                                                                           name="end_date[]"
                                                                           value="@if($init==0){{old('end_date[]')}}@else{{old('end_date[]',formatDateToShow($bookingsub->end_date))}}@endif">
                                                                </td>
  <td>
         <input id="days{{ $bookingsub->id }}" class="form-control input-height" readonly type="number"
                                                                           name="days[]"
                                                                           value="@if($init==0){{old('days[]')}}@else{{old('days[]',$bookingsub->days)}}@endif">
                                                                </td>
    <td>
         <input id="qty{{ $bookingsub->id }}" oninput="multiplyqty({{ $bookingsub->id }})" class="form-control input-height" type="number"
                                                                           name="qty[]"
                                                                           value="@if($init==0){{old('qty[]')}}@else{{old('qty[]',$bookingsub->qty)}}@endif">
                                                                </td>
<td>
         <input id="sub_total{{ $bookingsub->id }}" class="form-control input-height totalamt" readonly onkeyup="extrachargesselect2()" type="number"
                                                                           name="sub_total[]"
                                                                           value="@if($init==0){{old('sub_total[]')}}@else{{old('sub_total[]',$bookingsub->total)}}@endif">
                                                                </td>
 <td>
                    <select id="family{{ $bookingsub->id }}" class="form-control input-height select2" name="family[]"> <option label="Choose Option">  </option>
                    @foreach($familymembers as $fm)
            <option @if($init==1) @if(old('family[]',$bookingsub->family)==$fm->id) selected @endif @endif
        value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         
                            @endforeach
                                                        </select>
                                                            </td>

                                                            </tr>
                                                       @endforeach

                                                    @else


                                                        <tr>
                                                            <td><select id="1" onchange="extrachargesselect(this.id)"
                                                                        class="form-control input-height select2"
                                                                        name="charges_type[]">
                        <option value="">Choose Option</option>
<optgroup label="Main Charges">
    @foreach($main_types as $main)
    @if($main->id==3 || $main->id==4)
    @can('Invoice'.' '.$main->id)
<option value="{{ $main->id }}"> {{ $main->name }} </option>

@endcan
@endif
 @endforeach
</optgroup>

                                   <optgroup label="Charges Type">
                                                                    @foreach($finance_invoice_charges_type as $roomcharges)

         @can('Invoice'.' '.$roomcharges->name.' '.$roomcharges->mod_id)
                                                                <option
                                                               @if(old('charges_type[]')==$roomcharges->id)  selected
                                                                            @endif value="{{ $roomcharges->id }}">
                                                                            {{ $roomcharges->name }}
                                                                        </option>
                                                              @endcan
                                                                    @endforeach
                                                                    </optgroup>

                     <optgroup label="Subscription Types">
                                                                        @foreach($subscription_type as $subscription)

                                          @can('Invoice'.' '.$subscription->name.' '.$subscription->mod_id)
                                                         <option @if(old('charges_type[]')==$subscription->id)  selected
                                                                                    @endif value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                                                                    {{ $subscription->name }}
                                                                                </option>
                                                                           @endcan
                                                                        @endforeach
                                                                        </optgroup>
                                                            </select></td>
               <td>
         <input id="charges_amount1"  onkeyup="extrachargesselect2()"  class="form-control input-height charamt"
                                                                       type="number" name="charges_amount[]"
                                                                       value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$invoice_update->charges_amount)}}@endif">
                                                            </td>
                                                            <td>
          <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date1"
                                                                       class="form-control input-height" type="text"
                                                                       name="start_date[]"
                                                                       value="@if($init==0){{old('start_date[]')}}@else{{old('start_date[]',formatDateToShow($invoice_update->start_date))}}@endif">
                                                            </td>
                    <td>
                          <input placeholder="dd/mm/yyyy" autocomplete="off" id="end_date1"
                                                                       class="form-control input-height" type="text"
                                                                       name="end_date[]"
                                                                       value="@if($init==0){{old('end_date[]')}}@else{{old('end_date[]',formatDateToShow($invoice_update->end_date))}}@endif">
                                                            </td>
 <td>
                                                                <input id="days1" readonly
                                                                       class="form-control input-height" type="number"
                                                                       name="days[]"
                                                                       value="@if($init==0){{old('days[]')}}@else{{old('days[]',$invoice_update->days)}}@endif">
                                                            </td>
<td>
                                                                <input id="qty1" oninput="multiplyqty()"
                                                                       class="form-control input-height" type="number"
                                                                       name="qty[]"
                                                                       value="@if($init==0){{old('qty[]')}}@else{{old('qty[]',$invoice_update->qty)}}@endif">
                                                            </td>

                                               <td>
                                                                <input id="sub_total1" readonly onkeyup="extrachargesselect2()"
                                                                       class="form-control input-height totalamt" type="number"
                                                                       name="sub_total[]"
                                                                       value="@if($init==0){{old('sub_total[]')}}@else{{old('sub_total[]',$invoice_update->total)}}@endif">
                                                            </td>

                                                              <td>
                    <select id="family1" class="form-control input-height select2" name="family[]"> <option label="Choose Option">  </option>
                    @foreach($familymembers as $fm)
            <option 
        value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         
                            @endforeach
                                                        </select>
                                                            </td>

                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>

                                                 <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer mg-t-30">
                                                        <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div>
                                                </div> 
</div>
</div>
<br><br>



  <div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                          Total Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input type="number"
                                                               @if ($errors->has('final_total')) style="border-color:red;"
                                                               @endif id="final_total"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('final_total')}}@else{{old('final_total',$invoice_update->total)}}@endif"
                                                               name="final_total">
</div>

        <label class="col-sm-1 form-control-label">Discount Amount: </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
            <input type="number"
                                                               @if ($errors->has('discount_amount')) style="border-color:red;"
                                                               @endif id="discount_amount"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$invoice_update->discount_amount)}}@endif" name="discount_amount" oninput="subtract_discount()">

                                                    </div>



                                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number" @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('discount_percentage')}}@else{{old('discount_percentage',$invoice_update->discount_percentage)}}@endif" name="discount_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                   <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="discountDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="discount_div">
                                                <textarea
                                                            @if ($errors->has('discount_details')) style="border-color:red;"
                                                            @endif id="discount_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="discount_details">@if($init==0){{old('tax_details')}}@else{{old('discount_details',$invoice_update->discount_details)}}@endif</textarea>
</div>







                                                 </div>
                                                <!-- row -->

  <div class="row mg-t-10">
   <label class="col-sm-1 form-control-label">
                                        Grand Total:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                                 <input type="number"
                                                               @if ($errors->has('grand_total')) style="border-color:red;"
                                                               @endif id="grand_total" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1" 
                                                               value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$invoice_update->grand_total)}}@endif"
                                                               name="grand_total">
</div>



      <label class="col-sm-1 form-control-label"> Overdue Charges:</label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" >
            <input type="number" @if ($errors->has('extra_charges')) style="border-color:red;"
                                                               @endif id="extra_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('extra_charges')}}@else{{old('extra_charges',$invoice_update->extra_charges)}}@endif" name="extra_charges" oninput="subtract_discount()">

                                                    </div>


                                                   <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number"
                                                               @if ($errors->has('extra_percentage')) style="border-color:red;"
                                                               @endif id="extra_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('extra_percentage')}}@else{{old('extra_percentage',$invoice_update->extra_percentage)}}@endif" name="extra_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="ExtraDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="extra_div">
                                           <textarea
                                                            @if ($errors->has('extra_details')) style="border-color:red;"
                                                            @endif id="extra_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="extra_details">@if($init==0){{old('extra_details')}}@else{{old('extra_details',$invoice_update->extra_details)}}@endif</textarea>
</div>
</div>


  <div class="row mg-t-10">


<label class="col-sm-1 form-control-label">
                                        Amt in Words:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                     <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$invoice_update->amount_in_words)}}@endif">
</div>



  <label class="col-sm-1 form-control-label"> Tax Charges: </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" >
           <input type="number" @if ($errors->has('tax_charges')) style="border-color:red;"
                                                               @endif id="tax_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('tax_charges')}}@else{{old('tax_charges',$invoice_update->tax_charges)}}@endif" name="tax_charges" oninput="subtract_discount()">

                                                    </div>

           <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number" @if ($errors->has('tax_percentage')) style="border-color:red;"
                                                               @endif id="tax_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('tax_percentage')}}@else{{old('tax_percentage',$invoice_update->tax_percentage)}}@endif" name="tax_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="TaxDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="tax_div">
                                             <textarea
                                                            @if ($errors->has('tax_details')) style="border-color:red;"
                                                            @endif id="tax_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="tax_details">@if($init==0){{old('tax_details')}}@else{{old('tax_details',$invoice_update->tax_details)}}@endif</textarea>
</div>




                                                 </div>
                                                <!-- row -->


<div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                      Comments:
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                             <textarea
                                                            @if($errors->has('comments'))style="border-color:red;"
                                                            @endif id="comments" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="comments">@if($init==0){{old('comments')}}@else{{old('comments',$invoice_update->comments)}}@endif</textarea>
</div>

                              </div>
                                                <!-- row -->


  <div class="float-left">



                                                @if($init==1)

                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        &nbsp&nbsp
                                                        <div class="form-layout-footer mg-t-30">

                                                            <button type="input" name="save" class="btn btn-info">
                                                                Update
                                                            </button>
                                                            &nbsp&nbsp
                                                            <a href="{{ url('finance-and-management/finance-invoices-vue') }}"
                                                               class="btn btn-secondary">Cancel</a>
                                                        </div><!-- form-layout-footer -->
                                                    </div>

                                                @else
                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        &nbsp&nbsp
                                                        <div class="form-layout-footer mg-t-30">
                                                            <input type="submit" name="save" class="btn btn-info"
                                                                   value="Save">

                                                            &nbsp&nbsp
                                                            <input type="submit" name="addmore" class="btn btn-info"
                                                                   value="Save & Print">
                                                      
                                              
                               

                                                            &nbsp&nbsp
                                                            <a href="{{ url('finance-and-management/finance-invoices-vue') }}"
                                                               class="btn btn-secondary">Cancel</a>

                                                        </div><!-- form-layout-footer -->
                                                    </div>
                                                @endif
 </form>



                                            </div><!-- form-layout -->

                                     </div>







<div class="col-sm-2">
 <div class="saveoptions"></div>
  
</div>


                                                </div>
  
                                           
                                                 
                                        </div><!-- col-6 -->
                                   
                               
                                    
            </div>
   @if($init==0)
                                                    <div class="row mg-t-10">
                                                         <div class="form-layout-footer mg-t-30">
                                                          &nbsp&nbsp
                                                          &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                        <button id="theaddbtn" data-toggle="modal"  class="btn btn-warning" data-target="#modaldemo1">Save & Receive</button>
                                                      </div>
                                                    </div><!-- form-layout-footer -->
                                                @endif
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->



                                            

@endsection


@push('jscode')

    <script type="text/javascript">
        var total = 0;

        $('#contact').mask('00000000000');

        $('#cnic').mask('00000-0000000-0');

        $( document ).ready(function() {
   document.getElementById('return_value').value = 0;
   document.getElementById('grand').value = document.getElementById("grand_total").value;
});

    </script>


    <script type="text/javascript">
        function chargesselect() {
            var id = document.getElementById('roomid').value;
            var roomcategoryid = document.getElementById('roomcategoryid').value;

            var a = 'roomtype' + id;
            if (id != '') {
                var roomtypeid = document.getElementById(a).value;

                $.ajax({
                    type: 'POST',
                    url: '{{ url('room-management/room-booking/calculatecharges/') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "roomid": id,
                        "roomtypeid": roomtypeid,
                        'roomcategoryid': roomcategoryid
                    },
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj) {
                            document.getElementById('pday_charges_id').value = obj;
                            // $('#addressdata').html(data);
                            var myBoxone = parseFloat(document.getElementById("pday_charges_id").value);
                            var myBoxtwo = parseFloat(document.getElementById("nights").value);
                            var result = myBoxone * myBoxtwo;
                            document.getElementById("charges").value = result;
                            document.getElementById("total_charges").value = result;
                            document.getElementById("grand_total").value = result;
                            document.getElementById("grand").value = result;
                            document.getElementById("total_balance").value = result;
                        }

                    }
                });
            }

        }
    </script>

    <script type="text/javascript">

        function extrachargesselect(idd) {

            var idval = document.getElementById(idd).value;

            if(document.getElementById('member_id').value!=0){
            var memid = document.getElementById('member_id').value;
           }
           else{
            var memid = 0;
           }
// console.log(type[1])
            $.ajax({
                type: 'GET',
                    url: '{{ url('finance-and-management/finance-invoices/calculatesportscharges/') }}/'+ memid +'/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                     document.getElementById('charges_amount'+idd).value = obj;
                        document.getElementById('sub_total'+idd).value = obj;
                        document.getElementById('qty'+idd).value = 1;
                      
                        // document.getElementById('sub_total' ).value = obj;
                        // document.getElementById('qty' ).value = 1;
                        // $('#addressdata').html(data);
                        // total+=parseInt(obj);
                        //document.getElementById('total_room_charges').value=total;
                  total = 0;

                    $('.totalamt').each(function (index, element) {
                           total += parseFloat($(element).val());
                      });

                          document.getElementById('final_total').value = total;

                  if(Number.isNaN(total)){
                  total=0;
                 }
var memid = document.getElementById('member_id').value;
                myval(memid,idd);
                       d_percentage(idd);

                    }
                }
            });

        }


        function extrachargesselecttt(idd) {

            var idval = document.getElementById(idd).value;
            let type=idval.split('-')[0];
            // console.log(type);
            if(type=='S' || type=='M'){
               var copyit = document.getElementById('charges_amount').value = parseFloat($('option[value="'+idval+'"]').data('price'));
                document.getElementById('sub_total').value = copyit;
                document.getElementById('qty').value = 1;

                    total = 0;

                    $('.totalamt').each(function (index, element) {
                           total += parseFloat($(element).val());
                      });

                      document.getElementById('final_total').value = total;
                  if(Number.isNaN(total)){
                  total=0;
                 }

                       subtract_discount();
            }
            else if(type=="C"){

                idval=idval.split('-')[1];
// console.log(type[1])
            $.ajax({
                type: 'GET',
                url: '{{ url('finance-and-management/finance-invoices/calculateextracharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                        document.getElementById('charges_amount').value = obj;
                        document.getElementById('sub_total' ).value = obj;
                        document.getElementById('qty' ).value = 1;
                        // $('#addressdata').html(data);
                        // total+=parseInt(obj);
                        //document.getElementById('total_room_charges').value=total;
                  total = 0;

                    $('.totalamt').each(function (index, element) {
                           total += parseFloat($(element).val());
                      });

                      document.getElementById('final_total').value = total;
                  if(Number.isNaN(total)){
                  total=0;
                 }

                       subtract_discount();

                    }
                }
            });
            }

        }


        function extrachargesselect2() {
            total = 0;
            $('.totalamt').each(function (index, element) {
                console.log(total)
                total += parseFloat($(element).val());

            });

            document.getElementById('final_total').value = total;

            if(Number.isNaN(total)){
                    total=0;
                  }


            subtract_discount();

        }


    </script>



     <script type="text/javascript">
        var val;
        

        function myval(val,idd) {
          if (!idd){
            idd=1;
          }
            let v = $('input[name="invoice_type"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    if (v == 1) {

                        document.getElementById('address').value = obj.customer_address;
                        document.getElementById('cnic').value = obj.customer_cnic;
                        document.getElementById('contact').value = obj.customer_contact;
                        document.getElementById('email').value = obj.customer_email;
                        document.getElementById('name').value = obj.customer_name;
                        $('#name').attr('readonly','readonly')
                        document.getElementById('name').onkeyup = null;
                         $(".hidethisdiv").show()
                        document.getElementById('customer_id').value = obj.id;
                        document.getElementById('member_id').value ='';
                        document.getElementById('mem_no').value = '';
                         document.getElementById('ledger_amount').value=obj.balance;
                        let d='?customer='+obj.customer_name+'&mog=1&mog_id=';
                         let link=$('.showAfterSelection').data('href');
                        $('.showAfterSelection').attr('href',link+d+obj.id);
                        $('.showAfterSelection').show();
                        $('#family'+idd).html('<option label="Choose Option">  </option>');


                    } else {
                        document.getElementById('address').value = obj.cur_address;
                        document.getElementById('cnic').value = obj.cnic;
                        document.getElementById('contact').value = obj.mob_a;
                        document.getElementById('email').value = obj.personal_email;
                        $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                        document.getElementById('name').value = $fname+$mname+$lname;
                        $('#name').attr('readonly','readonly')
                        document.getElementById('name').onkeyup = null;
                         $(".hidethisdiv").show()
                        document.getElementById('member_id').value = obj.id;
                        document.getElementById('mem_no').value = obj.mem_no;
                        document.getElementById('customer_id').value = '';

                         document.getElementById('ledger_amount').value=obj.balance;
                        let d='?customer='+obj.applicant_name+'&mog=0&mog_id=';
                        let link=$('.showAfterSelection').data('href');
                        $('.showAfterSelection').attr('href',link+d+obj.id);
                        $('.showAfterSelection').show();

                        let selected="{{$init==1?$invoice_update->family:''}}";
                        $('#family'+idd).html('<option label="Choose Option">  </option>');
   
                        $.each(obj.family,function(x,y){

                            $tfam=y.title?y.title+' ':'';
                  $ffam=y.first_name?y.first_name+' ':'';
                  $mfam=y.middle_name?y.middle_name+' ':'';
                  $lfam=y.name?y.name:'';


                          let s='<option value="'+y.id+'">'+$tfam+$ffam+$mfam+$lfam+' '+'('+(y.relationship_name.desc)+')'+'</option>';

                          console.log(selected==y.id);
                          if(selected==y.id){

                              s='<option value="'+y.id+'" selected="selected">'+$tfam+$ffam+$mfam+$lfam+' '+'('+(y.relationship_name.desc)+')'+'</option>';
                          }
                         $('#family'+idd).append(s);
                        })

                      /*  $($('optgroup[label="Main Charges"]').find('option')[2]).attr('data-price',obj.total);
                        $($('optgroup[label="Main Charges"]').find('option')[3]).attr('data-price',obj.total_maintenance);*/

                    }
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>




     <script type="text/javascript">
       function subtract_discount() {

                    var first = parseFloat(document.getElementById("final_total").value);
                    var second = parseFloat(document.getElementById("discount_amount").value);
                    var third = parseFloat(document.getElementById("extra_charges").value);
                    var fourth = parseFloat(document.getElementById("tax_charges").value);

                   if(Number.isNaN(second)){
                    second=0;
                  }

                   if (Number.isNaN(first)) {
                first = 0;
            }
               if (Number.isNaN(third)) {
                third = 0;
            }

            if (Number.isNaN(fourth)) {
                fourth = 0;
            }
                    var result = first - second;

                    var final_result = result + third + fourth;

                    document.getElementById("grand_total").value = final_result;
                    document.getElementById("grand").value = final_result;

                }
    </script>


    <script type="text/javascript">
       function d_percentage() {

                    var first = parseFloat(document.getElementById("final_total").value);

                    var second = parseFloat(document.getElementById("discount_percentage").value);
                    var third = parseFloat(document.getElementById("extra_percentage").value);
                    var fourth = parseFloat(document.getElementById("tax_percentage").value);

                   if(Number.isNaN(second)){
                    second=0;
                  }

                   if (Number.isNaN(first)) {
                first = 0;
            }
               if (Number.isNaN(third)) {
                third = 0;
            }

            if (Number.isNaN(fourth)) {
                fourth = 0;
            }


    var discount = second / 100;
    var totalValue = first - (first * discount);


     var extra = third / 100;
    var totalValue1 = totalValue + (totalValue * extra)


     var tax = fourth / 100;
    var totalValue2 = totalValue1 + (totalValue1 * tax)

            document.getElementById("grand_total").value = Math.round(totalValue2);
            document.getElementById("grand").value = Math.round(totalValue2);



                }
    </script>



    <script type="text/javascript">
        var i = 2;

        function addmorefields() {
            var html = '';
            let memD=$('select#1 optgroup[label="Membership Charges"]').html();
id=$('#addmoreid').find('tr').length+1;
            html = `<tr>
    <td>
    <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); datecheckx(`+id+`);"></i>
    <select id="`+id+`"  onchange="extrachargesselect(this.id)" class="form-control input-height select2" name="charges_type[]" >
<option value="">Choose Option</option>
<optgroup label="Main Charges">
    @foreach($main_types as $main)
    @can('Invoice'.' '.$main->id)
<option value="{{ $main->id }}"> {{ $main->name }} </option>

@endcan
 @endforeach
</optgroup>

 <optgroup label="Charges Types">
                     @foreach($finance_invoice_charges_type as $roomcharges)
                       @can('Invoice'.' '.$roomcharges->name.' '.$roomcharges->mod_id)
            <option value="{{ $roomcharges->id }}">
                                    {{ $roomcharges->name }}
            </option>
             @endcan
@endforeach
</optgroup>


<optgroup label="Subscription Types">
              @foreach($subscription_type as $subscription)
                @can('Invoice'.' '.$subscription->name.' '.$subscription->mod_id)
            <option value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                    {{ $subscription->name }}
            </option>
             @endcan
@endforeach
</optgroup>


            </select></td>
              <td>
               <i>&nbsp</i>
                      <input id="charges_amount`+id+`" onkeyup="extrachargesselect2()" class="form-control input-height charamt" type="number" name="charges_amount[]">
                  </td>
            <td>
             <i>&nbsp</i>
                <input id="start_date`+id+`" placeholder="dd/mm/yyyy" autocomplete="off" class="form-control input-height" type="text" name="start_date[]" >
                  </td>
                   <td>
                    <i>&nbsp</i>
                <input id="end_date`+id+`" placeholder="dd/mm/yyyy" autocomplete="off" class="form-control input-height" type="text" name="end_date[]" >
                  </td>
                   <td>
                   <i>&nbsp</i>
                <input id="days`+id+`" readonly class="form-control input-height" type="number" name="days[]" >
                  </td>
                  <td>
                   <i>&nbsp</i>
                <input id="qty`+id+`" oninput="multiplyqty(`+id+`)" class="form-control input-height" type="number" name="qty[]" >
                  </td>
                   <td>
                   <i>&nbsp</i>
                <input id="sub_total`+id+`" readonly onkeyup="extrachargesselect2()" class="form-control input-height totalamt" type="number" name="sub_total[]" >
                  </td>

                             <td>
                                <i>&nbsp</i>
                    <select id="family`+id+`" class="form-control input-height select2" name="family[]"> <option label="Choose Option">  </option>
                    @foreach($familymembers as $fm)
            <option
        value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         
                            @endforeach
                                                        </select>
                                                            </td>


                     </tr>`;
            i++;
            $('#addmoreid').append(html);
            $('#addmoreid #start_date'+id+',#addmoreid #end_date'+id).datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false
            }).on('changeDate', function () {
                datecheckx(id);

            });;

        }

    </script> 

    <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v = $('input[name="invoice_type"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    if (v == 1) {
                        document.getElementById('address').value = obj.customer_address;
                        document.getElementById('cnic').value = obj.customer_cnic;
                        document.getElementById('contact').value = obj.customer_contact;
                        document.getElementById('email').value = obj.customer_email;
                        document.getElementById('name').value = obj.customer_name;
                        $('#name').attr('readonly','readonly')
                        document.getElementById('name').onkeyup = null;
                         $(".hidethisdiv").show()
                        document.getElementById('customer_id').value = obj.id;
                        document.getElementById('member_id').value ='';
                        document.getElementById('mem_no').value = '';
                         document.getElementById('ledger_amount').value=obj.balance;
                        let d='?customer='+obj.customer_name+'&mog=1&mog_id=';
                         let link=$('.showAfterSelection').data('href');
                        $('.showAfterSelection').attr('href',link+d+obj.id);
                        $('.showAfterSelection').show();
                        $('#family').html('<option label="Choose Family Member">  </option>');


                    } else {
                        document.getElementById('address').value = obj.cur_address;
                        document.getElementById('cnic').value = obj.cnic;
                        document.getElementById('contact').value = obj.mob_a;
                        document.getElementById('email').value = obj.personal_email;

                          $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                        document.getElementById('name').value = $fname+$mname+$lname;

                        $('#name').attr('readonly','readonly')
                        document.getElementById('name').onkeyup = null;
                         $(".hidethisdiv").show()
                        document.getElementById('member_id').value = obj.id;
                        document.getElementById('mem_no').value = obj.mem_no;
                        document.getElementById('customer_id').value = '';

                         document.getElementById('ledger_amount').value=obj.balance;
                        let d='?customer='+obj.applicant_name+'&mog=0&mog_id=';
                        let link=$('.showAfterSelection').data('href');
                        $('.showAfterSelection').attr('href',link+d+obj.id);
                        $('.showAfterSelection').show();

                        let selected="{{$init==1?$invoice_update->family:''}}";
         $('#family').html('<option label="Choose Family Member">  </option>');
                        $.each(obj.family,function(x,y){

                          let s='<option value="'+y.id+'">'+y.name+' '+'('+(y.relationship_name.desc)+')'+'</option>';

                          console.log(selected==y.id);
                          if(selected==y.id){

                              s='<option value="'+y.id+'" selected="selected">'+y.name+' '+'('+(y.relationship_name.desc)+')'+'</option>';
                          }
                            $('#family').append(s);
                        })

                        $($('optgroup[label="Membership Charges"]').find('option')[0]).attr('data-price',obj.total);
                        $($('optgroup[label="Membership Charges"]').find('option')[1]).attr('data-price',obj.total_maintenance);

                    }
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>

<script type="text/javascript">
        function datecheckx(id) {

          if(!id){
            id=1;
          }

         for(i=1;i<=id;i++){
            if ($('#start_date'+id).val() != '' && $('#end_date'+id).val() != '') {


                var date1 = $('#start_date'+id).val().split('/');
                var date2 = $('#end_date'+id).val().split('/');


                var date1 = new Date(date1[1] + '-' + date1[0] + '-' + date1[2]);
                var date2 = new Date(date2[1] + '-' + date2[0] + '-' + date2[2]);
                var diff = Math.abs(date2.getTime() - date1.getTime());

                var noofdays = Math.ceil(diff / (1000 * 3600 * 24));


                if(noofdays == 0){
                  document.getElementById('days'+id).value = 1;
                }else
                {
                     noofdays=noofdays+1;
                    console.log(noofdays);
                    noofdays=noofdays>30?noofdays%30>0?noofdays-noofdays%30:noofdays:noofdays;
                   document.getElementById('days'+id).value = noofdays ;
                }


                totalcals(id);

            }
        }
        }
    </script>


     <script type="text/javascript">
        function totalcals(id) {

          if(!id){
id=1;
          }


            var days = parseFloat(document.getElementById("days"+id).value);

            var amount = parseFloat(document.getElementById("charges_amount"+id).value);

            var qty = parseFloat(document.getElementById("qty"+id).value);

            if (Number.isNaN(days)) {
                days = 0;
            }

            if (Number.isNaN(amount)) {
                amount = 0;
            }

             if (Number.isNaN(qty)) {
                qty = 1;
            }

            amount=amount/30;
            var result = days * qty * amount;

            document.getElementById("sub_total"+id).value = Math.round(result);

           extrachargesselect2()
        }
    </script>

  <script type="text/javascript">
        function calculatereturn() {
            
            var grand = parseFloat(document.getElementById("grand").value);
    
            var amount = parseFloat(document.getElementById("amount_received").value);

     

            if (Number.isNaN(grand)) {
                grand = 0;
            }

            if (Number.isNaN(amount)) {
                amount = 0;
            }

if(amount<grand){
   var result = 0;
}
else{
    var result = grand-amount;
}
          
            document.getElementById("return_value").value = Math.round(result);

        }
    </script>


     <script type="text/javascript">
        function multiplyqty(id) {

          //console.log('i am'+id);
   if(!id){
            id=1;
          }

            var total = parseFloat(document.getElementById("charges_amount"+id).value);

            var qty = parseFloat(document.getElementById("qty"+id).value);


            if (Number.isNaN(total)) {
                total = 0;
            }

            if (Number.isNaN(qty)) {
                qty = 1;
            }

            var result = total * qty;

            document.getElementById("sub_total"+id).value = Math.round(result);

            datecheckx(id);

             extrachargesselect2()

        }
    </script>


    <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v = $('input[name="invoice_type"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {


                       $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                        let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        let status = v == 1 ? '' : '('+val1.mem_status.desc+')';
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code} ${status}<li>`);

                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>


 
       <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/> 

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>


    <script>

        $(function () {
            $("#start_date1").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            }).on('changeDate', function () {
                datecheckx();

            });
        });

        $(function () {
            $("#end_date1").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false
            }).on('changeDate', function () {
                datecheckx();

            });
        });


       
    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            $(".btn-success").click(function () {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function () {
                $(this).parents(".control-group").remove();
            });

        });


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
document.getElementById('amount_in_words').value = inWords(document.getElementById('grand_total').value);
};
</script>


<script>
$(document).ready(function(){

    $(".hidethisdiv").hide();

    $("#discount_div").hide();
    $("#tax_div").hide();
     $("#extra_div").hide();

});
</script>


<script type="text/javascript">
  function discountDetails() {
  var x = document.getElementById("discount_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}



  function TaxDetails() {
  var x = document.getElementById("tax_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


 function ExtraDetails() {
  var x = document.getElementById("extra_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
@endpush

