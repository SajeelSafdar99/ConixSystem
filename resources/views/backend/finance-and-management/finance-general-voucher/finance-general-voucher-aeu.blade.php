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

    .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }

.areabox{cursor:pointer !important;}
.areabox_two{cursor:pointer !important;}

div.groove {border-style: groove !important; height: 150px !important;}
div.saveoptions { height: 390px !important; }

.padtheicon{
  padding-top: 15px;
  cursor: pointer;
}

 .btne {
  border: 2px solid #56bff9;
  color: white;
  background-color: #56bff9;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 15px;

}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
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

  .formpad {
    padding: 5px !important;
  }
</style>

  </head>

<div class="br-pagebody">
        <!-- <div class="br-section-wrapper"> -->
          <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">General Vouchers</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <!-- <a target="_blank" href="{{ url('room-management/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> -->
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a></li>
  <li><a href="{{ url('finance-and-management/finance-voucher') }}">General Vouchers List</a></li>
  <li><a href>Edit General Voucher</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a></li>
  <li><a href="{{ url('finance-and-management/finance-voucher') }}">General Vouchers List</a></li>
  <li><a href>Add General Voucher</a></li>
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
   <form method="post" enctype="multipart/form-data" action="{{ url('finance-and-management/finance-voucher/update') }}/{{ $voucher_update->id }}">
     @else
    <form method="post" enctype="multipart/form-data">
    @endif
    @csrf


                                        <div class="form-layout form-layout-4 " style="color: black;">

                  <div class="row">
               <div class="col-sm-8">



<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">Voucher #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('invoice_no')) style="border-color:red;" @endif type="text" class="form-control input-height" id="invoice_no" name="invoice_no" value="@if($init==0){{$increment_number}}@else{{old('invoice_no',$voucher_update->invoice_no)}}@endif" autocomplete="off" readonly style="background-color: #c1c1c1" style="background-color: #c1c1c1">
                        </div>

<label class="col-sm-1 form-control-label">
                                                    Voucher Date:
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

                                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
          <input @if ($errors->has('invoice_date')) style="border-color:red;" @endif type="text" name="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="@if($init==0)<?php echo $today;?>@else{{old('invoice_date',formatDateToShow($voucher_update->invoice_date))}}@endif" readonly style="background-color: #c1c1c1">

                                                    </div>

             <label class="col-sm-1 form-control-label">  Voucher Type: <span class="tx-danger">
                                *
                            </span>
               </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
   <select @if ($errors->has('voucher_type')) style="border-color:red;" @endif  id="voucher_type" name="voucher_type" class="form-control  " onchange="vouchertypeselect(this.id)">
    <option label="Choose Option"></option>
 @foreach($voucher_types as $vouchertype)
 @can($vouchertype->desc.' '.$vouchertype->id)
                                @if($init==1)
                                 <option @if(old('voucher_type',$voucher_update->voucher_type)==$vouchertype->id)  selected @endif  value="{{ $vouchertype->id }}">
                                  {{ $vouchertype->desc }}
                                </option>
                                @else
                                 <option @if(old('voucher_type')==$vouchertype->id)  selected @endif value="{{ $vouchertype->id }}">
                                  {{ $vouchertype->desc }}
                                </option>
                                @endif
                            @endcan
                                @endforeach

</select>
                        </div>




                                                 </div>
                                                <!-- row -->

<div class="row mg-t-10">


 @if($init==1)   <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('invoice_type',$voucher_update->invoice_type)=='0') checked="" @endif @endif type="radio" name="invoice_type" value="0"><span class="pabs">Member</span>
              </label>
            </div><!-- col-3 -->
                                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type',$voucher_update->invoice_type)=='1') checked="" @endif type="radio" name="invoice_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
<div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type',$voucher_update->invoice_type)=='2') checked="" @endif type="radio" name="invoice_type" value="2"><span class="pabs">Supplier</span>
              </label>
            </div><!-- col-3 -->
            <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type',$voucher_update->invoice_type)=='3') checked="" @endif type="radio" name="invoice_type" value="3"><span class="pabs">Employee</span>
              </label>
            </div><!-- col-3 -->
             <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type',$voucher_update->invoice_type)=='4') checked="" @endif type="radio" name="invoice_type" value="4"><span class="pabs">COA Accounts</span>
              </label>
            </div><!-- col-3 -->
                                @else

        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('invoice_type')=='0') checked="" @endif @endif type="radio" name="invoice_type" value="0"><span class="pabs">Member</span></label>
            </div><!-- col-3 -->
                                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type')=='1') checked="" @endif type="radio" name="invoice_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
             <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type')=='2') checked="" @endif type="radio" name="invoice_type" value="2"><span class="pabs">Supplier</span>
              </label>
            </div><!-- col-3 -->
            <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type')=='3') checked="" @endif type="radio" name="invoice_type" value="3"><span class="pabs">Employee</span>
              </label>
            </div><!-- col-3 -->
             <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type')=='4') checked="" @endif type="radio" name="invoice_type" value="4"><span class="pabs">COA Accounts</span>
              </label>
            </div><!-- col-3 -->
                             @endif
                              <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                                        <a href="{{ url('room-management/room-customer/room-customer-aeu') }}"
                                                           target="_blank">
                                                            <input type="button" value="+ Guest"
                                                                   class="btn btn-info">
                                                        </a>

                                                        <a href="{{ url('finance-and-management/suppliers/suppliers-aeu') }}"
                                                           target="_blank">
                                                            <input type="button" value="+ Supplier"
                                                                   class="btn btn-info">
                                                        </a>
                                                    </div>

                       <label class="col-sm-1 form-control-label">
                               Ledger Amount:
                                                        <span class="tx-danger">
                                *
                            </span>
<!-- <a class="showAfterSelection" style="display: none" href="{{ url('finance-and-management/member-guest-ledgers-vue') }}" data-href="{{ url('finance-and-management/member-guest-ledgers-vue') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a> -->
                                                    </label>
                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
          <input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$voucher_update->ledger_amount)}}@endif">
                                                    </div>

           <!--   <label class="col-sm-1 form-control-label"> CNIC:
               </label>
                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('cnic')) style="border-color:red;" @endif type="text" class="form-control input-height" id="cnic" name="cnic" autocomplete="off" value="@if($init==0){{old('cnic')}}@else{{old('cnic',$voucher_update->cnic)}}@endif" readonly style="background-color: #c1c1c1">
                        </div> -->


                                                 </div>
                                                <!-- row -->

  <div class="row mg-t-10">
  <label class="col-sm-1 form-control-label">Name:<span class="tx-danger"> * </span>
               </label>
      <div class="col-sm-7 mg-t-10 mg-sm-t-0">
 <input @if($errors->has('name')) style="border-color:red;" @endif type="text" class="form-control input-height" id="name" name="name" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" autocomplete="off" class="typeahead" placeholder="Search By Name or ID" value="@if($init==0){{old('name')}}@else{{old('name',$voucher_update->name)}}@endif">

    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                                                 </div>


                                                     <label class="col-sm-1 form-control-label">
                                             Contact:
                                                    </label>
                                                     <div class="col-sm-3 mg-t-10 mg-sm-t-0">
        <input @if ($errors->has('contact')) style="border-color:red;" @endif type="text" class="form-control input-height" id="contact" name="contact" autocomplete="off" value="@if($init==0){{old('contact')}}@else{{old('contact',$voucher_update->contact)}}@endif" readonly style="background-color: #c1c1c1">
                                                    </div>


                        </div>



                                                <!-- row -->



         <!--   <label class="col-sm-1 form-control-label">
                                              Address:
                                                    </label>
                                                     <div class="col-sm-3 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('address')) style="border-color:red;" @endif type="text" class="form-control input-height" id="address" name="address" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('address')}}@else{{old('address',$voucher_update->address)}}@endif">
</div>
 -->


<!--   <label class="col-sm-1 form-control-label">Email:  </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('email')) style="border-color:red;" @endif type="text" class="form-control input-height" id="email" name="email" autocomplete="off" value="@if($init==0){{old('email')}}@else{{old('email',$voucher_update->email)}}@endif" readonly style="background-color: #c1c1c1">  </div> -->


                                                <!-- row -->

</div>
<div class="col-sm-3">
      <div class="form-layout form-layout-4 formpad">
                          <div class="row mg-t-10">
                                        <label class="col-sm-2 form-control-label">
                                             Member #:
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
           <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_code" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_code')}}@else{{old('member_code',$voucher_update->member?$voucher_update->member->mem_no:'') }}@endif"
                                                               type="text" name="member_code">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_id')}}@else{{old('member_id',$voucher_update->member_id)}}@endif"
                                                               type="hidden" name="member_id">
                                                    </div>



                                           <label class="col-sm-2 form-control-label"> Guest #:  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('customer_id')) style="border-color:red;" @endif type="text" class="form-control input-height" id="customer_id" name="customer_id" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$voucher_update->customer_id)}}@endif">
                        </div>
</div>
<div class="row mg-t-10">

                             <label class="col-sm-2 form-control-label"> Supplier #:  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('person_id')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_id" name="person_id" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('person_id')}}@else{{old('person_id',$voucher_update->person_id)}}@endif">     </div>


          <label class="col-sm-2 form-control-label"> Employee #:  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('employee_id')) style="border-color:red;" @endif type="text" class="form-control input-height" id="employee_id" name="employee_id" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('employee_id')}}@else{{old('employee_id',$voucher_update->employee_id)}}@endif">     </div>
</div>

<div class="row mg-t-10">
 <label class="col-sm-2 form-control-label"> COA Code:  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('account_id')) style="border-color:red;" @endif type="text" class="form-control input-height" id="account_id" name="account_id" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('account_id')}}@else{{old('account_id',$voucher_update->account_id)}}@endif">     </div>
</div>
                        </div>
</div>
<div class="col-sm-1">    </div>
</div>


  <div class="row">
               <div class="col-sm-10">
<br><br>
<div class="groove">

  <div class="row mg-t-10" id="thedebit_div">
 <label class="col-sm-1 form-control-label">
                                       Debit Amount:
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">

<input @if ($errors->has('debit_amount')) style="border-color:red;" @endif type="number" id="debit_amount" name="debit_amount" class="form-control input-height" autocomplete="off" placeholder="Enter Amount" value="@if($init==0){{old('debit_amount')}}@else{{old('debit_amount',$voucher_update->debit_amount)}}@endif">
</div>
 <label class="col-sm-1 form-control-label">
                                   Debit Details:
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('debit_details')) style="border-color:red;" @endif type="text" id="debit_details" name="debit_details" class="form-control input-height" autocomplete="off" placeholder="Enter Details" value="@if($init==0){{old('debit_details')}}@else{{old('debit_details',$voucher_update->debit_details)}}@endif">
</div>
</div>

  <div class="row mg-t-10" id="thecredit_div">
 <label class="col-sm-1 form-control-label">
                                     Credit Amount:
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('credit_amount')) style="border-color:red;" @endif type="number" id="credit_amount" name="credit_amount" class="form-control input-height" autocomplete="off" placeholder="Enter Amount" value="@if($init==0){{old('credit_amount')}}@else{{old('credit_amount',$voucher_update->credit_amount)}}@endif">
</div>
 <label class="col-sm-1 form-control-label">
                                 Credit Details:
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('credit_details')) style="border-color:red;" @endif type="text" id="credit_details" name="credit_details" class="form-control input-height" autocomplete="off" placeholder="Enter Details" value="@if($init==0){{old('credit_details')}}@else{{old('credit_details',$voucher_update->credit_details)}}@endif">
</div>
</div>

</div>
<br>


  <div class="row mg-t-10">

 <label class="col-sm-1 form-control-label">
                                       Company:
                         <span class="tx-danger">
                                *
                            </span>
                                                    </label>

<div class="col-sm-2 mg-t-10 mg-sm-t-0">
<select @if ($errors->has('unit')) style="border-color:red;" @endif  id="unit" name="unit" class="form-control" onchange="coaselect(this.id)">
    <option label="Choose Option"></option>
 @foreach($units as $unit)
                                @if($init==1)
                                 <option @if(old('unit',$voucher_update->unit)==$unit->code)  selected @endif  value="{{ $unit->code }}">
                                  {{ $unit->name }}
                                </option>
                                @else
                                 <option @if(old('unit')==$unit->id)  selected @endif value="{{ $unit->code }}">
                                  {{ $unit->name }}
                                </option>
                                @endif
                        
                                @endforeach

</select>
</div>

 
 <label class="col-sm-1 form-control-label" id="cash_label">
                                         Cash / Bank:
                         <span class="tx-danger">
                                *
                            </span>
                                                    </label>

<div class="col-sm-2 mg-t-10 mg-sm-t-0" id="cash_div"> 
<select @if ($errors->has('account')) style="border-color:red;" @endif  id="account" name="account" class="form-control" onchange="coaselect(this.id)">
    <option label="Choose Option"></option>
 @foreach($accounts as $acc)
                                @if($init==1)
                                 <option @if(old('account',$voucher_update->account)==$acc->code)  selected @endif  value="{{ $acc->code }}">
                                  {{ $acc->name }}
                                </option>
                                @else
                                 <option @if(old('account')==$acc->id)  selected @endif value="{{ $acc->code }}">
                                  {{ $acc->name }}
                                </option>
                                @endif
                        
                                @endforeach

</select>
</div>
 
 <label class="col-sm-1 form-control-label" id="cash2_label">
                                          Payment Method:
                         <span class="tx-danger">
                                *
                            </span>
                                                    </label>

<div class="col-sm-2 mg-t-10 mg-sm-t-0" id="cash2_div">
<select @if ($errors->has('payment_method')) style="border-color:red;" @endif  id="payment_method" name="payment_method" class="form-control " >
    <option label="Choose Option"></option>
 @foreach($payment_methods as $methods)
  @can($methods->name.' '.$methods->mod_id)
                                @if($init==1)
                                 <option @if(old('payment_method',$voucher_update->payment_method)==$methods->id)  selected @endif  value="{{ $methods->id }}">
                                  {{ $methods->name }}
                                </option>
                                @else
                                 <option @if(old('payment_method')==$methods->id)  selected @endif value="{{ $methods->id }}">
                                  {{ $methods->name }}
                                </option>
                                @endif
                                @endcan
                                @endforeach

</select>
</div>
 
 
</div>

<div class="row mg-t-10">

<label class="col-sm-1 form-control-label">
                                   A/C Date:
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
   <div class="col-sm-1 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('account_date')) style="border-color:red;" @endif type="text" name="account_date" id="account_date" class="form-control input-height" autocomplete="off" value="@if($init==0)<?php echo $today;?>@else{{old('account_date',formatDateToShow($voucher_update->account_date))}}@endif">
</div>
<!-- 
 <label class="col-sm-1 form-control-label">
              A/C Details:
                </label> -->
 <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="AccDetails()"></i></div>
   <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="acc_details_div">
    <textarea @if ($errors->has('acc_details')) style="border-color:red;" @endif id="acc_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text" autocomplete="off"
                                                            name="acc_details">@if($init==0){{old('acc_details')}}@else{{old('acc_details',$voucher_update->acc_details)}}@endif</textarea>
</div>
     <label class="col-sm-1 form-control-label">
                                      Remarks:
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
             <textarea @if ($errors->has('remarks')) style="border-color:red;" @endif type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Details" rows="4" autocomplete="off">@if($init==0){{old('remarks')}}@else{{old('remarks',$voucher_update->remarks)}}@endif</textarea>
</div>

<label class="col-sm-1 form-control-label">
                                      Documents:

                                                    </label>
   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    @if($init==0)
                             <img id="picchose" style="width: 200px; height: 100px; " src="{{ url('assets/images/nouser.png') }}">

                             @else


@if($voucher_update->invoice_type==0)

    @foreach($voucher_update->generalVoucherDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach

@elseif($voucher_update->invoice_type==2)

    @foreach($voucher_update->generalVoucherDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach

@elseif($voucher_update->invoice_type==3)

    @foreach($voucher_update->generalVoucherDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach

                  @elseif($voucher_update->invoice_type==4)

    @foreach($voucher_update->generalVoucherDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach

@elseif($voucher_update->invoice_type==1)

    @foreach($voucher_update->generalVoucherDocs->pluck('url') as $image)
 <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach
    @endif


                             @endif
                             @if($init==0)
                            <input @if ($errors->has('documents')) style="border-color:red;" @endif type="file" name="documents[]" multiple="multiple" value="@if($init==0){{old('documents')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="documents[]" multiple="multiple">
</div>
                            <input type="hidden" name="existimg" value="{{old('documents',$voucher_update->documents)}}">
                            @endif

</div>

                              </div>
                                                <!-- row -->
 

  <div class="float-left">


 @if($init==1)
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer  ">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/finance-voucher') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

     <input type="hidden" name="transactionsID" value="{{join(',',array_merge($transactionsP->toArray(),$transactionsV->toArray()))}}">

   @else
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

                <div class="form-layout-footer  ">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/finance-voucher') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>
  @endif
                                            </div><!-- form-layout -->
                                     </div>


<!--
<div class="col-sm-2">
 <div class="saveoptions"></div>

</div> -->

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
        $('#contact').mask('00000000000');

      /*  $('#cnic').mask('00000-0000000-0');*/

    </script>

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


    <script type="text/javascript">
  var val;
  function customerdatavalue(val){
    let v=$('input[name="invoice_type"]:checked').val();
if(v==2){
  v=22;
}
   $.ajax({
    type : 'POST',
    url : '{{ url('search/customerdata') }}?balance=1',
 data: {
        "_token": "{{ csrf_token() }}",
        "customerid": val,
        'MOC':v
        },
  success: function(data){

console.log(data);
   var obj = JSON.parse(data);

   if(v==1){
       document.getElementById('member_id').value ='';
      document.getElementById('member_code').value = '';
        document.getElementById('person_id').value='';
        document.getElementById('employee_id').value='';
        document.getElementById('account_id').value='';

  document.getElementById('name').value=obj.customer_name;
  /*document.getElementById('address').value=obj.customer_address;*/
  document.getElementById('contact').value=obj.customer_contact;
 /*   document.getElementById('cnic').value=obj.customer_cnic;*/
 /*  document.getElementById('email').value=obj.customer_email;*/
  document.getElementById('customer_id').value=obj.id;
  document.getElementById('ledger_amount').value=obj.balance;
  $('#family').html('<option label="Choose Family Member">  </option>');
       let d='?customer='+obj.customer_name+'&mog=1&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
   }
else if(v==22){
       document.getElementById('member_id').value ='';
       document.getElementById('member_code').value = '';
       document.getElementById('customer_id').value='';
       document.getElementById('employee_id').value='';
       document.getElementById('account_id').value='';

  document.getElementById('name').value=obj.person_name;
  /*document.getElementById('address').value=obj.person_address;*/
  document.getElementById('contact').value=obj.person_contact;
 /* document.getElementById('cnic').value=obj.person_cnic;*/
  /*document.getElementById('email').value=obj.person_email;*/
  document.getElementById('person_id').value=obj.id;
  document.getElementById('ledger_amount').value=obj.balance;
  $('#family').html('<option label="Choose Family Member">  </option>');
       let d='?customer='+obj.person_name+'&mog=22&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
   }
   else if(v==3){
       document.getElementById('member_id').value ='';
       document.getElementById('member_code').value = '';
       document.getElementById('customer_id').value='';
       document.getElementById('person_id').value='';
       document.getElementById('account_id').value='';

  document.getElementById('name').value=obj.name;
  /*document.getElementById('address').value=obj.cur_address;*/
  document.getElementById('contact').value=obj.mob_a;
  /*document.getElementById('cnic').value=obj.cnic;
  document.getElementById('email').value=obj.email;*/
  document.getElementById('employee_id').value=obj.id;
  document.getElementById('ledger_amount').value=obj.balance;
  $('#family').html('<option label="Choose Family Member">  </option>');
       let d='?customer='+obj.name+'&mog=3&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
   }
   else if(v==4){
       document.getElementById('member_id').value ='';
       document.getElementById('member_code').value = '';
       document.getElementById('customer_id').value='';
       document.getElementById('person_id').value='';
       document.getElementById('employee_id').value='';

  document.getElementById('account_id').value=obj.code;
  document.getElementById('name').value=obj.name;
  /*document.getElementById('address').value='';*/
  document.getElementById('contact').value='';
  /*document.getElementById('cnic').value='';
  document.getElementById('email').value='';*/
  document.getElementById('ledger_amount').value=obj.balance;
  $('#family').html('<option label="Choose Family Member">  </option>');
       let d='?customer='+obj.name+'&mog=4&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
   }
 else if(v==0){
   document.getElementById('person_id').value='';
   document.getElementById('employee_id').value='';
   document.getElementById('account_id').value='';

                  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

  document.getElementById('name').value= $fname+$mname+$lname;
 /* document.getElementById('address').value=obj.cur_address;*/
  document.getElementById('contact').value=obj.mob_a;
  /*document.getElementById('cnic').value=obj.cnic;
  document.getElementById('email').value=obj.personal_email;*/
 document.getElementById('member_id').value = obj.id;
 document.getElementById('member_code').value = obj.mem_no;
       document.getElementById('customer_id').value='';
       let d='?customer='+obj.applicant_name+'&mog=0&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
       document.getElementById('ledger_amount').value=obj.balance;

 let selected="{{$init==1?$voucher_update->family:''}}";
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
     let v=$('input[name="invoice_type"]:checked').val();
if(v==2){
v=22;
}


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
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name} : ${val1.customer_no} <li>`);
   }
   else if(v==22){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.person_name} : ${val1.person_no} <li>`);
   }
   else if(v==0){
     $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';
                let fullname=$fname+$mname+$lname;
    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${fullname} : ${val1.mem_no} (${val1.mem_status.desc}) <li>`);
                        }
    else if(v==3){
    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.name} : ${val1.barcode} <li>`);
                        }
     else if(v==4){
    $("#areabox").append(`<li onclick="customerdatavalue('${val1.code}')">${val1.name} : ${val1.code} <li>`);
                        }
});

    // $('#areabox').html(data);
$('#areabox').show();
      }
      });
}
</script>

<script type="text/javascript">
        function vouchertypeselect(idd) {

            var idval = document.getElementById(idd).value;

            if(idval==5){
  $("#cash_div").hide();  
  $("#cash_label").hide();
  $("#cash2_label").hide();
  $("#cash2_div").hide();  
            }else{
     $("#cash_div").show();  
  $("#cash_label").show();
  $("#cash2_label").show();
  $("#cash2_div").show();      
            }

            $.ajax({
                type: 'GET',
                url: '{{ url('finance-and-management/finance-voucher/vouchertype/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = data;
                    if (obj) {
                      if(obj==10){
                        $("#thedebit_div").show();
                        $("#thecredit_div").hide();
                       /* document.getElementById("credit_amount").disabled=true;
                        document.getElementById("credit_details").disabled=true;*/
                      }
                      else if(obj==11){
                        $("#thedebit_div").show();
                        $("#thecredit_div").show();
                      }
                       else if(obj==01){
                        $("#thecredit_div").show();
                        $("#thedebit_div").hide();
                       /* document.getElementById("debit_amount").disabled=true;
                        document.getElementById("debit_details").disabled=true;*/
                      }
                    }
                }
            });


        }
</script>
<script type="text/javascript">

  function coaselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('finance-and-management/finance-voucher/payment-mode/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#payment_method').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.name+'</option>';
 $('#payment_method').append(s);
                })

  }
}
   });

  }

</script>

<script type="text/javascript">
  function AccDetails() {
  var x = document.getElementById("acc_details_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

@if($init==0)
<script>
$(document).ready(function(){

    $("#acc_details_div").hide();
     $("#thedebit_div").hide();
      $("#thecredit_div").hide();

});
</script>
@endif

@if($init==1)
<script>
$(document).ready(function(){
   $("#acc_details_div").hide();
// if(document.getElementById("debit_amount").value==''){
//    $("#thedebit_div").hide();
// }
// if(document.getElementById("credit_amount").value==''){
//    $("#thecredit_div").hide();
// }
});
</script>
@endif

   
<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>

        $(function () {
            $("#account_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        });

    </script>
@endpush
