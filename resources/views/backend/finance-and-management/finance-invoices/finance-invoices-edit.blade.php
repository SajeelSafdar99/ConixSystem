@extends('backend.layout.app')
@section('page-content')

<?php
use App\User;

$user = auth()->user();
?>

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
  padding-left:21px;
  }
.pc:before {
  position: absolute;
    content:"%";
    left:8px;
  top:6px;
  }
.thecenteredform
 {
    padding: 10px !important;
  }
    .form-control-label{
        color:black !important;
      }
</style>

  </head>
<div class="br-pagebody">
        <!-- <div class="br-section-wrapper"> -->
          <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Invoices</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <!-- <a target="_blank" href="{{ url('room-management/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> -->
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1 && $receiptstatus==0)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Edit Payment Receipt</a></li>
</ul>

@elseif($init==1 && $receiptstatus==1)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-new-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Edit Invoice</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-new-invoices-vue') }}">Invoices List</a></li>
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
    <form id="formID" method="post" action="{{ url('finance-and-management/finance-new-invoices/update') }}/{{ $invoice_update->invoice_no }}">
     @else
    <form id="formID" method="post">
    @endif
    @csrf


                                        <div class="form-layout form-layout-4 ">

                  <div class="row">
               <div class="col-sm-10">



<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">  Invoice #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
    <input id="invoice_no" class="form-control input-height validate[required]" data-errormessage-value-missing="Invoice No. is Required !" type="number" readonly value="@if($init==0){{$increment_number}}@else{{old('invoice_no', $invoice_update->invoice_no)}}@endif"
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
              <input  @if ($errors->has('invoice_date')) style="border-color:red;" @endif id="invoice_date" class="form-control input-height validate[required]" data-errormessage-value-missing="Invoice Date is Required !" type="text" value="@if($init==0)<?php echo $today;?>@else{{old('invoice_date',formatDateToShow($invoice_update->invoice_date))}}@endif" name="invoice_date" readonly style="background-color: #c1c1c1">

                                                    </div>

             <label class="col-sm-1 form-control-label">    Ledger Amount:<span class="tx-danger"> </span>

<a class="showAfterSelection" style="display: none" href="{{ url('finance-and-management/finance-ledger-accounts') }}" data-href="{{ url('finance-and-management/member-guest-ledgers') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a>
               </label>
                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
       <input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$invoice_update->ledger_amount)}}@endif">
                        </div>


                                                 </div>
                                                <!-- row -->


  <div class="row mg-t-10">

        @if($init==1)   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('invoice_type',$invoice_update->invoice_type)=='0') checked="" @else disabled @endif @endif type="radio" name="invoice_type" value="0" data-errormessage-value-missing="Customer Type is Required !" class="validate[required]"><span class="pabs">Member</span>
              </label>
          </div>

 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if(old('invoice_type',$invoice_update->invoice_type)=='6') checked="" @else disabled @endif type="radio" name="invoice_type" value="6" data-errormessage-value-missing="Customer Type is Required !" class="validate[required]"><span class="pabs">Corporate Member</span>
              </label>
          </div>


              @foreach($gts as $gt)
               <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type',customertype($invoice_update->customer_id))==$gt->id) checked="" @else disabled @endif type="radio" name="invoice_type" value="{{10+$gt->id}}" data-errormessage-value-missing="Customer Type is Required !" class="validate[required]"><span class="pabs">{{$gt->desc}}</span>
              </label>
          </div>
              @endforeach
          

                                @else

        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('invoice_type')=='0') checked="" @endif @endif type="radio" name="invoice_type" value="0" data-errormessage-value-missing="Customer Type is Required !" class="validate[required]"><span class="pabs">Member</span></label>
  </div>

   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if(old('invoice_type')=='6') checked="" @endif type="radio" name="invoice_type" value="6" data-errormessage-value-missing="Customer Type is Required !" class="validate[required]"><span class="pabs">Corporate Member</span></label>
  </div>
  

  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('invoice_type')=='1') checked="" @endif type="radio" name="invoice_type" value="1" data-errormessage-value-missing="Customer Type is Required !" class="validate[required]"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
                             @endif

  </div>

 <div class="row mg-t-10">
      <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                                  <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" class="validate[required] form-control input-height typeahead" data-errormessage-value-missing="Customer Name is Required !" placeholder="Enter Number to Search" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$invoice_update->name)}}@endif" readonly style="background-color: #c1c1c1"
                                                               type="text" name="name"
                                                               onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                                                        <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>

                                                 </div>
                                                  <!--   <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                                                       <a href="/room-management/room-customer/room-customer-aeu" target="popup" onclick="window.open('/room-management/room-customer/room-customer-aeu','popup','width=450,height=550'); return false;"><button class="btn btn-sm btn-info">Add Guest</button></a>  -->
                                                       <!--  <a href="{{ url('room-management/room-customer/room-customer-aeu') }}"
                                                           target="_blank">
                                                            <input type="button" value="Add Guest"
                                                                   class="btn btn-info">
                                                        </a> -->
                                                 <!--    </div> -->




                                                    
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <input @if ($errors->has('contact')) style="border-color:red;"
                                                               @endif id="contact" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('contact')}}@else{{old('contact',$invoice_update->contact)}}@endif"
                                                               type="text" name="contact" placeholder="Enter Contact">
                                                    </div>




                                           <label class="col-sm-1 form-control-label"> Member #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-1 mg-t-10 mg-sm-t-0">
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



                                           <label class="col-sm-1 form-control-label"> Corporate #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('corporate_id')) style="border-color:red;"
                                                               @endif id="cop_no" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('cop_no')}}@else{{old('cop_no',$invoice_update->cop_no)}}@endif"
                                                               type="text" name="cop_no">
                                                        <input @if ($errors->has('corporate_id')) style="border-color:red;"
                                                               @endif id="corporate_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('corporate_id')}}@else{{old('corporate_id',$invoice_update->corporate_id)}}@endif"
                                                               type="hidden" name="corporate_id">
                        </div>



                             <label class="col-sm-1 form-control-label"> Guest #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-1 mg-t-10 mg-sm-t-0">
        <input  @if ($errors->has('customer_id')) style="border-color:red;"
                                                            @endif id="customer_id" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$invoice_update->customer_id)}}@endif"
                                                            type="text" name="customer_id">
                        </div>

                                                 
                                                <!-- row -->

</div>


  <div class="row mg-t-10">


  <label class="col-sm-1 form-control-label">Address:<span class="tx-danger">  * </span>  </label>

                                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
               <input @if ($errors->has('address')) style="border-color:red;"
                                                            @endif id="address" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('address')}}@else{{old('address',$invoice_update->address)}}@endif"
                                                            type="text" name="address">

                                                    </div>



                    <label class="col-sm-1 form-control-label">
                                              Email:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                     <input @if ($errors->has('email')) style="border-color:red;"
                                                               @endif id="email" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('email')}}@else{{old('email',$invoice_update->email)}}@endif"
                                                               type="text" name="email">
</div>

                                                    <label class="col-sm-1 form-control-label">
                                              CNIC #:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                              <input @if ($errors->has('cnic')) style="border-color:red;"
                                                               @endif id="cnic" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('cnic')}}@else{{old('cnic',$invoice_update->cnic)}}@endif"
                                                               type="text" name="cnic">
</div>



                                                 </div>
                                                <!-- row -->


</div>
</div>

<br>
  <div class="row mg-t-10">
 <div class="col-sm-12">
<div class="thecenteredform form-layout form-layout-4">
    <script>
        let cl='<tr>\n' +
            '                                                            <td><select id="charges_type" onchange="extrachargesselect(this)" class="form-control  " name="charges_type[]">\n' +
            '                        <option value="">Choose Option</option>\n' +
            '<optgroup label="Main Charges">\n' +
            '        <option value="1"> Room Booking </option>\n' +
            '\n' +
            '     <option value="2"> Events Management </option>\n' +
            '\n' +
            '     <option value="3"> Membership Fee </option>\n' +
            '\n' +
            '     <option value="4"> Monthly Maintenance Fee </option>\n' +
            '\n' +
            '     <option value="5"> Food and Beverage </option>\n' +
            '\n' +
            ' </optgroup>\n' +
            '\n' +
               '                                   <optgroup label="Charges Types">\n' +
                  '                                                                                                                                                                    <option value="50">\n' +
            '                                                                           New Year Eve \n' +
            '                                                                        </option>\n' +
            '                                                                                                                                                                    <option value="49">\n' +
            '                                                                            Reinstating Fee\n' +
            '                                                                        </option>\n' +
              '                                                                                                                                                                    <option value="10">\n' +
            '                                                                            Supplementary Card Charges\n' +
            '                                                                        </option>\n' +
            '                                                                                                                                                                                                       </optgroup>\n' +
            '\n' +
             '                     <optgroup label="Subscription Types">\n' +
            '                                                                                                \n' +
 

            '                                                         <option value="13" data-price="">\n' +
            '                                                                                    Billiard\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +
            '                                                         <option value="14" data-price="">\n' +
            '                                                                                    Gaming Zone\n' +
            '                                                                                </option>\n' +
                           '                                                            \n' +
            '                                                         <option value="31" data-price="">\n' +
            '                                                                          GYM (Guest)\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +
                        '                                                         <option value="45" data-price="">\n' +
            '                                                                          GYM Member Per Day\n' +
            '                                                                                </option>\n' +
                                     '                                                            \n' +
    
 
            '                                                         <option value="17" data-price="">\n' +
            '                                                                                  GYM Personal Training\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +
                       '                                                         <option value="11" data-price="">\n' +
            '                                                                                   GYM Subscription\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +
                    '                                                         <option value="15" data-price="">\n' +
            '                                                                                    Sauna / Steam\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +
                       '                                                         <option value="34" data-price="">\n' +
            '                                                                          Squash Court (Guest)\n' +
            '                                                                                </option>\n' +
                                       '                                                            \n' +
          
  
            '                                                         <option value="30" data-price="">\n' +
            '                                                                           Squash Court Coaching\n' +
            '                                                                                </option>\n' +
                        '                                                         <option value="47" data-price="">\n' +
            '                                                                    Squash Court Member Per Day\n' +
            '                                                                                </option>\n' +

               '                                                            \n' +
                          '                                                         <option value="16" data-price="">\n' +
            '                                                                                   Squash Court Subscription\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +
            '                                                         <option value="32" data-price="">\n' +
            '                                                                          Swimming Pool (Guest)\n' +
            '                                                                                </option>\n' +
                           '                                                            \n' +
                                     '                                                         <option value="21" data-price="">\n' +
            '                                                                                  Swimming Pool Coaching\n' +
            '                                                                                </option>\n' +
             '                                                            \n' +
 

            '                                                         <option value="46" data-price="">\n' +
            '                                                                          Swimming Pool Member Per Day\n' +
            '                                                                                </option>\n' +
                                     '                                                            \n' +
                                                 '                                                         <option value="12" data-price="">\n' +
            '                                                                                 Swimming Pool Subscription\n' +
            '                                                                                </option>\n' +
            '                                                                                                                                                                          \n' +

             '                                                         <option value="19" data-price="">\n' +
            '                                                                          Table Tennis\n' +
            '                                                                                </option>\n' +
                                     '                                                            \n' +
      
            '                                                                                                                                                                          \n' +

            '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     </optgroup>\n' +
            '                                                            </select></td>\n' +
            '               <td>\n' +
            '         <input id="charges_amount" onkeyup="extrachargesselect2()" class="form-control input-height charamt" type="text" name="charges_amount[]" value="">\n' +
            '                                                            </td>\n' +
                      '               <td>\n' +
            '         <input id="per_day_amount" onkeyup="extrachargesselect2()" class="form-control input-height chars" type="text" name="per_day_amount[]" value="">\n' +
            '                                                            </td>\n' +
            '                                                            <td>\n' +
            '          <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date" class="form-control input-height" type="text" name="start_date[]" value="">\n' +
            '                                                            </td>\n' +
            '                    <td>\n' +
            '                          <input placeholder="dd/mm/yyyy" autocomplete="off" id="end_date" class="form-control input-height" type="text" name="end_date[]" value="">\n' +
            '                                                            </td>\n' +
            ' <td>\n' +
            '                                                                <input id="days" readonly="" class="form-control input-height" type="number" name="days[]" value="">\n' +
            '                                                            </td>\n' +
            '<td>\n' +
            '                                                                <input id="qty" oninput="multiplyqty(this)" class="form-control input-height" type="number" name="qty[]" min="1" value="">\n' +
            '                                                            </td>\n' +
            '\n' +
            '                                               <td>\n' +
            '                                                                <input id="sub_total" readonly="" onkeyup="extrachargesselect2()" class="form-control input-height totalamt" type="number" name="sub_total[]" value="">\n' +
            '                                                            </td>\n' +
            '\n' +
            '                                                             <td>\n' +
            '                                                                <div>\n' +
            '                                                                <input id="discount_amount" oninput="d_percentage(this,this.id)" class="form-control input-height" type="number" name="discount_amount[]" value="">\n' +
            '                                                                     </div>\n' +
            '                                                            </td>\n' +
              '                                                             <td>\n' +
            '                                                                <div>\n' +
            '                                                                <input id="discount_percentage" oninput="d_percentage(this)" class="form-control input-height" type="number" name="discount_percentage[]" value="">\n' +
            '                                                                     </div>\n' +
            '                                                            </td>\n' +
            '                                                             <td>\n' +
            '                                                              <div class="pc">\n' +
            '                                                                <input id="extra_percentage" oninput="d_percentage(this)" class="form-control input-height" type="number" name="extra_percentage[]" value="">     <input id="extra_charges"   class="form-control input-height" type="hidden" name="extra_charges[]" value="">\n' +
            '                                                                     </div>\n' +
            '                                                            </td>\n' +
            '                                                             <td>\n' +
            '                                                              <div class="pc">\n' +
            '                                                                <input id="tax_percentage" oninput="d_percentage(this)" class="form-control input-height" type="number" name="tax_percentage[]" value="">\n' +
            '                                                                     </div>\n' +
            '                                                            </td>\n' +
            '                                                              <td>\n' +
            '                                                                <input id="grand_total" readonly="" class="form-control input-height grandamt" type="number" name="grand_total[]" value="">\n' +
            '                                                            </td>\n' +
            '                                                              <td>\n' +
            '                                   <select id="family" class="form-control  " name="family[]"> <option label="Choose Option">  </option>  @foreach($familymembers as $fm) <option value="{{ $fm->id }}">{{$fm->name }}</option> @endforeach     <option value="01">  Guest </option><option value="02">  Self </option></select> \n' +
            '                                                            </td>\n' +
            '\n' +
            '                                                            <td>\n' +
            '                                                                <button type="button" class="btn btn-danger btn-xs" onclick="removeme(this)"><svg class="svg-inline--fa fa-minus-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zM124 296c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h264c6.6 0 12 5.4 12 12v56c0 6.6-5.4 12-12 12H124z"></path></svg><!-- <i class="fa fa-minus-circle"></i> --> </button>\n' +
            '                                                            </td>\n' +
            '\n' +
            '\n' +
            '                                                        </tr>';

        function addmoreRows(){

        $('#addmoreid').append(cl);

                $("input[name='start_date[]']").datepicker({

                    format: 'dd/mm/yyyy',
                    todayHighlight: true
                }).on('changeDate', function (e) {
                    datecheckx(e);

                });

                $("input[name='end_date[]']").datepicker({

                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    enableOnReadonly: false
                }).on('changeDate', function (e) {
                    datecheckx(e);

                });

        }
    </script>
<div @if($init==0) class="hidethisdiv" @endif>          <table align="center" border="0" width="100%">
                                                    <tbody>
                                                     <tr>
                                                        <td width="13%" align="left">Type</td>
                                                        <td width="6%" align="left">Amount</td>
                                                        <td width="6%" align="left">Per Day Amount</td>

                                                        <td width="8%" align="left">Start Date</td>
                                                        <td width="8%" align="left">End Date</td>
                                                        <td width="5%" align="left">Days</td>
                                                        <td width="5%" align="left">Qty</td>
                                                        <td width="8%" align="left">Sub-Total</td>
                                                        <td width="5%" align="left">Disc Amt</td>
                                                        <td width="5%" align="left">Disc Per</td>
                                                        <td width="5%" align="left">Overdue</td>
                                                        <td width="5%" align="left">Tax</td>
                                                        <td width="10%" align="left">Total</td>
                                                        <td width="10%" align="left">Family Member</td>
                                  <td width="5%" align="left"> </td> 

                                                     <!--    <td width="5%" align="left"><button type="button" class="btn btn-info btn-xs" onclick="addmoreRows()"><i class="fa fa-plus-circle"></i> </button></td> -->
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">


                                                    @if($init==1)
@foreach($bookingsubdata as $bookingsub)

                                                            <tr>
                              <td><select id="charges_type" onchange="extrachargesselect(this)"
                                                                            class="form-control  "
                                                                            name="charges_type[]">
                      <option value="">Choose Option</option>
<optgroup label="Main Charges">
   @foreach($main_types as $main)
    @can('Invoice'.' '.$main->id)

                                         @if($init==1)
                  <option  @if($bookingsub->charges_type==$main->id)  selected @endif value="{{ $main->id }}"> {{ $main->name }}  </option>
                                   @endif
                                   @endcan
                                  @endforeach
</optgroup>


                                                <optgroup label="Charges Types">
                                                                        @foreach($finance_invoice_charges_type as $chargestypes)
                                                @can('Invoice'.' '.$chargestypes->name.' '.$chargestypes->mod_id)

                                         @if($init==1)
                  <option @if($bookingsub->charges_type==$chargestypes->id)  selected @endif value="{{ $chargestypes->id }}">
                                                                                    {{ $chargestypes->name }}
                                                                                </option>

                                                                            @endif
                                                                            @endcan
                                                                        @endforeach
                                                                        </optgroup>
  <optgroup label="Subscription Types">
                                                                        @foreach($subscription_type as $subscription)
                                           @can('Invoice'.' '.$subscription->name.' '.$subscription->mod_id)
                                         @if($init==1)
                  <option @if($bookingsub->charges_type==$subscription->id)  selected @endif value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                                                                    {{ $subscription->name }}
                                                                                </option>

                                                                            @endif
                                                                      @endcan
                                                                        @endforeach
                                                                        </optgroup>


                                                                    </select></td>
 <td>
  <input id="charges_amount" oninput="multiplyqty(this,2)" 
                                                                           class="form-control input-height"
                                                                           type="text" name="charges_amount[]"
                                                                           value="@if($init==0)@else{{$bookingsub->charges_amount}}@endif"
                                                                          >

 <input id="subid" class="form-control input-height" type="hidden" name="subid[]"
                                                                           value="{{$bookingsub->id}}">



<input id="user" class="form-control input-height"  type="hidden" name="user[]"
                                                                       value="{{$user->id}}">

                                                                <input id="deleted_at" class="form-control input-height"
                                                                       type="hidden" name="deleted_at[]"
                                                                       value="">

                                                                <input id="deleted_by" class="form-control input-height "
                                                                       type="hidden" name="deleted_by[]"
                                                                       value="">


                                                                </td>

             

                <td>
  <input id="per_day_amount" oninput="multiplyqty(this)"  class="form-control input-height" type="text" name="per_day_amount[]" value="@if($init==0)@else{{$bookingsub->per_day_amount}}@endif"></td>
                
                 <td>
         <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date" class="start_date form-control input-height" type="text"               name="start_date[]"
                                                                           value="@if($init==0){{'start_date'}}@else{{formatDateToShow($bookingsub->start_date)}}@endif">
                                                                </td>
 <td>
         <input id="end_date" placeholder="dd/mm/yyyy" autocomplete="off" class="end_date form-control input-height" type="text"
                                                                           name="end_date[]"
                                                                           value="@if($init==0){{'end_date'}}@else{{formatDateToShow($bookingsub->end_date)}}@endif">
                                                                </td>
  <td>
         <input id="days" class="form-control input-height" readonly type="number"
                                                                           name="days[]"
                                                                           value="@if($init==0){{'days'}}@else{{$bookingsub->days}}@endif">
                                                                </td>
   <td>
         <input id="qty" oninput="multiplyqty(this)" class="form-control input-height" type="number"
                                                                           name="qty[]" min="1"
                                                                           value="@if($init==0){{'qty'}}@else{{$bookingsub->qty}}@endif">
                                                                </td>
<td>
         <input id="sub_total" class="form-control input-height totalamt" readonly onkeyup="extrachargesselect2()" type="number"
                                                                           name="sub_total[]"
                                                                           value="@if($init==0){{'sub_total'}}@else{{$bookingsub->sub_total}}@endif">
                                                                </td>
 <td> 
                                                                <div >
                                                                <input id="discount_amount" oninput="d_percentage(this,this.id)"
                                                                       class="form-control input-height" type="number"
                                                                       name="discount_amount[]"
                                                                       value="@if($init==0){{'discount_amount'}}@else{{$bookingsub->discount_amount}}@endif">
                                                                     </div>
                                                            </td>

                                                              <td>
                                                                <div class="pc">
                                                              <input id="discount_percentage" oninput="d_percentage(this)"
                                                                       class="form-control input-height" type="number"
                                                                       name="discount_percentage[]"
                                                                       value="@if($init==0){{'discount_percentage'}}@else{{$bookingsub->discount_percentage}}@endif">
                                                                     </div>
                                                            </td>


                                                             <td>
                                                              <div class="pc">
                                                                <input id="extra_percentage" oninput="d_percentage(this)"
                                                                       class="form-control input-height" type="number"
                                                                       name="extra_percentage[]"
                                                                       value="@if($init==0){{'extra_percentage'}}@else{{$bookingsub->extra_percentage}}@endif">


                                                                          <input id="extra_charges" 
                                                                       class="form-control input-height" type="hidden"
                                                                       name="extra_charges[]"
                                                                       value="@if($init==0){{'extra_charges'}}@else{{$bookingsub->extra_charges}}@endif">
                                                                     </div>
                                                            </td>
                                                             <td>
                                                              <div class="pc">
                                                                <input id="tax_percentage" oninput="d_percentage(this)"
                                                                       class="form-control input-height" type="number"
                                                                       name="tax_percentage[]"
                                                                       value="@if($init==0){{'tax_percentage'}}@else{{$bookingsub->tax_percentage}}@endif">
                                                                     </div>
                                                            </td>
                                                              <td>
                                                           <input id="grand_total" readonly
                                                                       class="form-control input-height grandamt" type="number"
                                                                       name="grand_total[]"
                                                                       value="@if($init==0){{'grand_total'}}@else{{$bookingsub->grand_total}}@endif">
                                                            </td>
                                                             <td>
                    <select id="family" class="form-control " name="family[]"> <option label="Choose Option">  </option>
                    @foreach($familymembers as $fm)
            <option @if($init==1) @if($bookingsub->family==$fm->id) selected @endif @endif
        value="{{ $fm->id }}">  {{ $fm->name }} ({{ $fm->relationship_name->desc }})
              </option>
                         
                            @endforeach
                                <option @if($init==1) @if($bookingsub->family==01) selected @endif @endif
        value="01">  Guest
              </option>
               <option @if($init==1) @if($bookingsub->family==02) selected @endif @endif
        value="02">  Self
              </option>
                                                        </select>
                                                            </td>
<td>  <button type="button" class="btn btn-danger btn-xs" onclick="removeme(this)"> Cancel </button>   </td> 
 <!--  <td>  <button type="button" class="btn btn-danger btn-xs" onclick="removeme(this)"><i class="fa fa-minus-circle"></i> </button>   </td>  -->



                                                            </tr>
@endforeach

                                                    @else


                                                        <tr>
                                                            <td><select id="charges_type" onchange="extrachargesselect(this)"
                                                                        class="form-control "
                                                                        name="charges_type[]">
                        <option value="">Choose Option</option>
<optgroup label="Main Charges">
    @foreach($main_types as $main)
    @can('Invoice'.' '.$main->id)
<option value="{{ $main->id }}"> {{ $main->name }} </option>

@endcan
 @endforeach
</optgroup>

                                   <optgroup label="Charges Types">
                                                                    @foreach($finance_invoice_charges_type as $chargestypes)
                                @can('Invoice'.' '.$chargestypes->name.' '.$chargestypes->mod_id)
                                                                <option
                                                               value="{{ $chargestypes->id }}">
                                                                            {{ $chargestypes->name }}
                                                                        </option>
                                                               @endcan
                                                                    @endforeach
                                                                    </optgroup>

                     <optgroup label="Subscription Types">
                                                                        @foreach($subscription_type as $subscription)
                        @can('Invoice'.' '.$subscription->name.' '.$subscription->mod_id)

                                                         <option  value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                                                                    {{ $subscription->name }}
                                                                                </option>
                                                                          @endcan
                                                                        @endforeach
                                                                        </optgroup>
                                                            </select></td>
               <td>
         <input id="charges_amount"  onkeyup="extrachargesselect2()"  class="form-control input-height charamt"
                                                                       type="text" name="charges_amount[]"
                                                                       value="@if($init==0){{'charges_amount'}}@else{{$invoice_update->charges_amount}}@endif">

 
                                                            </td>
                                                            <td>
          <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date"
                                                                       class="form-control input-height" type="text"
                                                                       name="start_date[]"
                                                                       value="@if($init==0)@else{{formatDateToShow($invoice_update->start_date)}}@endif">
                                                            </td>
                    <td>
                          <input placeholder="dd/mm/yyyy" autocomplete="off" id="end_date"
                                                                       class="form-control input-height" type="text"
                                                                       name="end_date[]"
                                                                       value="@if($init==0)@else{{formatDateToShow($invoice_update->end_date)}}@endif">
                                                            </td>
 <td>
                                                                <input id="days" readonly
                                                                       class="form-control input-height" type="number"
                                                                       name="days[]"
                                                                       value="@if($init==0){{'days'}}@else{{$invoice_update->days}}@endif">
                                                            </td>
<td>
                                                                <input id="qty" oninput="multiplyqty(this)"
                                                                       class="form-control input-height" type="number"
                                                                       name="qty[]" min="1"
                                                                       value="@if($init==0){{'qty'}}@else{{$invoice_update->qty}}@endif">
                                                            </td>

                                               <td>
                                                                <input id="sub_total" readonly onkeyup="extrachargesselect2()"
                                                                       class="form-control input-height totalamt" type="number"
                                                                       name="sub_total[]"
                                                                       value="@if($init==0){{'sub_total'}}@else{{$invoice_update->sub_total}}@endif">
                                                            </td>

                                                             <td>
                                                                <div >
                                                                <input id="discount_amount" oninput="d_percentage(this,this.id)"
                                                                       class="form-control input-height" type="number"
                                                                       name="discount_amount[]"
                                                                       value="@if($init==0){{'discount_amount'}}@else{{$invoice_update->discount_amount}}@endif">
                                                                     </div>
                                                            </td>
                                                             <td>
                                                              <div class="pc">
                                                                <input id="extra_percentage" oninput="d_percentage(this)"
                                                                       class="form-control input-height" type="number"
                                                                       name="extra_percentage[]"
                                                                       value="@if($init==0){{'extra_percentage'}}@else{{$invoice_update->extra_percentage}}@endif">

                                                                          <input id="extra_charges" 
                                                                       class="form-control input-height" type="hidden"
                                                                       name="extra_charges[]"
                                                                       value="@if($init==0){{'extra_charges'}}@else{{$invoice_update->extra_charges}}@endif">
                                                                     </div>
                                                            </td>
                                                             <td>
                                                              <div class="pc">
                                                                <input id="tax_percentage" oninput="d_percentage(this)"
                                                                       class="form-control input-height" type="number"
                                                                       name="tax_percentage[]"
                                                                       value="@if($init==0){{'tax_percentage'}}@else{{old('tax_percentage',$invoice_update->tax_percentage)}}@endif">
                                                                     </div>
                                                            </td>
                                                              <td>
                                                           <input id="grand_total" readonly
                                                                       class="form-control input-height" type="number"
                                                                       name="grand_total[]"
                                                                       value="@if($init==0){{'grand_total'}}@else{{old('grand_total',$invoice_update->grand_total)}}@endif">
                                                            </td>

                                                            <td>

                    <select @if ($errors->has('family')) id="{{ $familymembers->id }}" style="border-color:red;" @endif id="family" class="form-control " name="family[]"> <option label="Choose Option">  </option>
                    @foreach($familymembers as $fm)
            <option
        value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         
                            @endforeach
                                <option
        value="01">  Guest
              </option>
              <option
        value="02">  Self
              </option>
                                                        </select>
                                                            </td>

                                                           <td> <button type="button" class="btn btn-danger btn-xs" onclick="$(this).parents('tr').remove()"><svg class="svg-inline--fa fa-minus-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="minus-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zM124 296c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h264c6.6 0 12 5.4 12 12v56c0 6.6-5.4 12-12 12H124z"></path></svg><!-- <i class="fa fa-minus-circle"></i> --> </button></td>



                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>

                                             <!--    <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer mg-t-30">
                                                        <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div>
                                                </div> -->
</div>
</div>
<br>

<div class="row mg-t-10">



 <label class="col-sm-1 form-control-label">
                                      Grand Total: <span class="tx-danger">  * </span>
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <input @if($errors->has('my_final_total'))style="border-color:red;"
                                                            @endif id="my_final_total" readonly 
                                                                       class="validate[required] form-control input-height" type="number"
                                                                       name="my_final_total"
                                                                       value="{{old('my_final_total')}}" data-errormessage-value-missing="Grand Total is Required !">
                                                </div>


              <label class="col-sm-1 form-control-label">
                                      Comments: <span class="tx-danger">  * </span>
                                                    </label>
                                                     <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                             <textarea
                                                            @if($errors->has('comments'))style="border-color:red;"
                                                            @endif id="comments" class="form-control" placeholder="Give any details" rows="2" type="text"
                                                            name="comments">@if($init==0){{old('comments')}}@else{{old('comments',$invoice_update->comments)}}@endif</textarea>
</div>

                              </div>
                                                <!-- row -->


  <div class="float-left" style="margin-left:15px;">



                                                @if($init==1)

                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        &nbsp&nbsp
                                                        <div class="form-layout-footer mg-t-30">

                                                          <!--   <button type="input" name="save" class="btn btn-info">
                                                                Update
                                                            </button> -->
                                                              <input type="submit" name="save" class="btn btn-info" onclick="this.disabled=true;this.form.submit();" 
                                                                   value="Update">

                                 <!--  <input type="submit" name="saveandreceive" class="btn btn-warning" value="Update & Receive">
 -->
                                                            <a href="{{ url('finance-and-management/finance-new-invoices-vue') }}"
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
                                                            <input type="submit" name="addmore2" class="btn btn-primary"
                                                                   value="Save & Add More">

                                                            <input type="submit" name="addmore" class="btn btn-info"
                                                                   value="Save & Print">

                                                        <input type="submit" name="saveandreceive" class="btn btn-warning" value="Save & Receive">

                                                            <a href="{{ url('finance-and-management/finance-new-invoices-vue') }}"
                                                               class="btn btn-secondary">Cancel</a>

                                                        </div><!-- form-layout-footer -->
                                                    </div>
                                                @endif
                                            </div><!-- form-layout -->
                                     </div>






                                                </div>

                                        </div><!-- col-6 -->
                                    </form>
            </div>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->


@endsection


@push('jscode')
    <script type="text/javascript">
        var total = 0;

        $('#contact').mask('00000000000');

        $('#cnic').mask('00000-0000000-0');



           $( document ).ready(function() {
sumupgrandtotal();
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
                            document.getElementById("total_balance").value = result;
                        }

                    }
                });
            }

        }
  </script>


  <script type="text/javascript">

function removeme(idd) {
  var today = 2; 
$(idd).parents('tr').find('#deleted_at').val(today);

var minusthegrand = $(idd).parents('tr').find('#grand_total').val();  
var fromfinal =   document.getElementById('my_final_total').value;  
document.getElementById('my_final_total').value = fromfinal - minusthegrand;

    $(idd).parents('tr').hide();

}



function old_removeme(idd) {

var today = moment().toDate(); 
var user = $(idd).parents('tr').find('#user').val();  
$(idd).parents('tr').find('#deleted_at').val(today);
$(idd).parents('tr').find('#deleted_by').val(user);


console.log($(idd).parents('tr').find('#deleted_at').val());
console.log($(idd).parents('tr').find('#deleted_by').val());

var minusthegrand = $(idd).parents('tr').find('#grand_total').val();  
var fromfinal =   document.getElementById('my_final_total').value;  
document.getElementById('my_final_total').value = fromfinal - minusthegrand;

    $(idd).parents('tr').hide();

}



        function extrachargesselect(idd) {

            idval=$(idd).val();

              var v = $('input[name="invoice_type"]:checked').val();



            if(document.getElementById('member_id').value!=0 && v==0){
            var memid = document.getElementById('member_id').value;
           }

            else if(document.getElementById('corporate_id').value!=0 && v==6){
                var memid = document.getElementById('corporate_id').value;
                }

           else{
            var memid = 0;
           }
// console.log(type[1])
            $.ajax({
                type: 'GET',
                    url: '{{ url('finance-and-management/finance-invoices/calculatesportscharges/') }}/'+ memid +'/' + v +'/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                    
                        $(idd).parents('tr').find('#charges_amount').val(obj);
                         $(idd).parents('tr').find('#per_day_amount').val(Math.round((obj/30)*100)/100);
                        $(idd).parents('tr').find('#sub_total').val(Math.round(obj/30));
                        $(idd).parents('tr').find('#qty').val(1)  ;

                        // document.getElementById('sub_total' ).value = obj;
                        // document.getElementById('qty' ).value = 1;
                        // $('#addressdata').html(data);
                        // total+=parseInt(obj);
                        //document.getElementById('total_room_charges').value=total;
                  total = 0;

                    $('.totalamt').each(function (index, element) {
                           total += parseFloat($(element).val());
                      });

                        $(idd).parents('tr').find('#final_total').val(total);
                  if(Number.isNaN(total)){
                  total=0;
                 }
var memid = document.getElementById('member_id').value;
if(memid){
   myval(memid,idd);
}
    d_percentage(idd);


     gt = 0;
            $('.grandamt').each(function (index, element) {
               
                gt += parseFloat($(element).val());

            });
   
            document.getElementById('my_final_total').value = gt;
             
        if(Number.isNaN(gt)){
                    gt=0;
                  }




                    }
                }
            });

        }


        function extrachargesselect2(idd) {
            total = 0;
            $('.totalamt').each(function (index, element) {
                console.log(total)
                total += parseFloat($(element).val());

            });
            if(idd.target){
                $(idd.target).parents('tr').find('#final_total').val(total) ;

            }
            else{
                $(idd).parents('tr').find('#final_total').val(total) ;

            }

            if(Number.isNaN(total)){
                    total=0;
                  }


            d_percentage(idd);




                 gt = 0;
            $('.grandamt').each(function (index, element) {
               
                gt += parseFloat($(element).val());

            });
   
            document.getElementById('my_final_total').value = gt;
            
        if(Number.isNaN(gt)){
                    gt=0;
                  }

        }



function sumupgrandtotal(){
    gt = 0;
            $('.grandamt').each(function (index, element) {
               
                gt += parseFloat($(element).val());

            });
   
            document.getElementById('my_final_total').value = gt;
             
        if(Number.isNaN(gt)){
                    gt=0;
                  }
}

    </script>




     <script type="text/javascript">  //this function is not in USE. FALSE CALCULATIONS
       function subtract_discount(idd) {
           if(idd.target){
             ss=  $(idd.target).parents('tr') ;

           }
           else{
              ss= $(idd).parents('tr');

           }
                    var first = parseFloat(ss.find("#final_total").val());
                    var second = parseFloat(ss.find("#discount_amount").val());
                    var third = parseFloat(ss.find("#extra_charges").val());
                    var fourth = parseFloat(ss.find("#tax_charges").val());

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

            var result = first + third;
            var total_result = first - second;
            var final_result = total_result + result + fourth;
                    /*var result = first - second;

                    var final_result = result + third + fourth;*/

           ss.find('#grand_total').val(final_result);

                    //document.getElementById("grand_total").value = final_result;

                }
    </script>


    <script type="text/javascript">
       function d_percentage(idd,thisid) {

        if(thisid){
var pres = 1;
        }
        else{
var pres = 0;
        }

           if(idd.target){
               ss=  $(idd.target).parents('tr') ;

           }
           else{
               ss= $(idd).parents('tr');

           }
                    var first = parseFloat(ss.find("#sub_total").val());

                    var second = parseFloat(ss.find("#discount_amount").val());
                    var psecond = parseFloat(ss.find("#discount_percentage").val());
                    var third = parseFloat(ss.find("#extra_percentage").val());
                    var fourth = parseFloat(ss.find("#tax_percentage").val());



                   if(Number.isNaN(second)){
                    second=0;
                  }

  if(Number.isNaN(psecond)){
                    psecond=0;
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

/*
if(pres==1){
if(second!=null){
              ss.find("#discount_percentage").attr('disabled', true);
            }

 if(second==null || second==0){
              ss.find("#discount_percentage").attr('disabled', false);
            }
}
else{

if(psecond!=null){
              ss.find("#discount_amount").attr('disabled', true);
            }

 if(psecond==null || psecond==0){
              ss.find("#discount_amount").attr('disabled', false);
            }
}*/



  var extra = third / 100;
     var totalValue1 =  (first * extra);


         document.getElementById('extra_charges').value = totalValue1;


if(second){
  var totalValuesss = second;
}else{
 var ppp = psecond / 100;
    var totalValuesss = (first * ppp);
}

  

var totalValues = first + totalValue1 - totalValuesss;

 var tax = fourth / 100;
     var totalValuetax = (first * tax);


  var totalValue2 = totalValues + totalValuetax;

   /* var totalValue = first - second;

 var ppp = psecond / 100;
    var totalValues = totalValue - (totalValue * ppp)

     var extra = third / 100;
    var totalValue1 = totalValues + (totalValues * extra)


     var tax = fourth / 100;
    var totalValue2 = totalValue1 + (totalValue1 * tax)*/

           ss.find('#grand_total').val(Math.round(totalValue2));

                  gt = 0;
            $('.grandamt').each(function (index, element) {
               
                gt += parseFloat($(element).val());

            });
   
            document.getElementById('my_final_total').value = gt;


        if(Number.isNaN(gt)){
                    gt=0;
                  }

           // document.getElementById("grand_total").value = Math.round(totalValue2);


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
                        $('#family').html('<option label="Choose Option">  </option>');


                    } 

                    else if(v == 6) {
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
                          document.getElementById('corporate_id').value = obj.id;
                        document.getElementById('cop_no').value = obj.mem_no;

                           document.getElementById('member_id').value = '';
                        document.getElementById('mem_no').value = '';
                        document.getElementById('customer_id').value = '';

                         document.getElementById('ledger_amount').value=obj.balance;
                        let d='?customer='+obj.applicant_name+'&mog=6&mog_id=';
                        let link=$('.showAfterSelection').data('href');
                        $('.showAfterSelection').attr('href',link+d+obj.id);
                        $('.showAfterSelection').show();

                        let selected="{{$init==1?$invoice_update->family:''}}";
        $('#family').html('<option label="Choose Option">  </option>');
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
                            $('#family').append(s);
                        })

                         $('#family').append('<option value="01"  >Guest</option><option value="02"  >Self</option>');

                      /*  $($('optgroup[label="Main Charges"]').find('option')[2]).attr('data-price',obj.total);
                        $($('optgroup[label="Main Charges"]').find('option')[3]).attr('data-price',obj.total_maintenance);*/

                    }

                    else {
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
        $('#family').html('<option label="Choose Option">  </option>');
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
                            $('#family').append(s);
                        })

                         $('#family').append('<option value="01"  >Guest</option><option value="02"  >Self</option>');

                      /*  $($('optgroup[label="Main Charges"]').find('option')[2]).attr('data-price',obj.total);
                        $($('optgroup[label="Main Charges"]').find('option')[3]).attr('data-price',obj.total_maintenance);*/

                    }
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>


     <script type="text/javascript">
        var val;
        

        function myval(val,idd) {
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
                        $('#family').html('<option label="Choose Option">  </option>');


                    }

                    else if (v == 6) {
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
                     document.getElementById('corporate_id').value = obj.id;
                        document.getElementById('cop_no').value = obj.mem_no;

                         document.getElementById('member_id').value = '';
                        document.getElementById('mem_no').value = '';
                        document.getElementById('customer_id').value = '';

                         document.getElementById('ledger_amount').value=obj.balance;
                        let d='?customer='+obj.applicant_name+'&mog=6&mog_id=';
                        let link=$('.showAfterSelection').data('href');
                        $('.showAfterSelection').attr('href',link+d+obj.id);
                        $('.showAfterSelection').show();

                        let selected="";
        $(idd).parents('tr').find('#family').html('<option label="Choose Option">  </option>');
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
                         
                            $(idd).parents('tr').find('#family').append(s);
                        })

 $(idd).parents('tr').find('#family').append('<option value="01" >Guest</option><option value="02" >Self</option>');
                      /*  $($('optgroup[label="Main Charges"]').find('option')[2]).attr('data-price',obj.total);
                        $($('optgroup[label="Main Charges"]').find('option')[3]).attr('data-price',obj.total_maintenance);*/

                    }
                     else {
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

                        let selected="";
        $(idd).parents('tr').find('#family').html('<option label="Choose Option">  </option>');
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
                         
                            $(idd).parents('tr').find('#family').append(s);
                        })

 $(idd).parents('tr').find('#family').append('<option value="01" >Guest</option><option value="02" >Self</option>');
                      /*  $($('optgroup[label="Main Charges"]').find('option')[2]).attr('data-price',obj.total);
                        $($('optgroup[label="Main Charges"]').find('option')[3]).attr('data-price',obj.total_maintenance);*/

                    }
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>

<script type="text/javascript">
        function datecheckx(idd) {


    if(idd.target){
               ss=  $(idd.target).parents('tr') ;

           }
           else{
               ss= $(idd).parents('tr');

           }
             
            if (ss.find('#start_date').val() != '' && ss.find('#end_date').val() != '') {


                var date1 = ss.find('#start_date').val().split('/');
                var date2 = ss.find('#end_date').val().split('/');


                var date1 = new Date(date1[1] + '-' + date1[0] + '-' + date1[2]);
                var date2 = new Date(date2[1] + '-' + date2[0] + '-' + date2[2]);
                 /*    console.log(date1.getMonth());*/
if((date1.getMonth()==1 && date1.getDate()==1) && (date2.getDate()>27)){
   var amme = 2;
}
else{
  var amme = 0;
}
                var diff = Math.abs(date2.getTime() - date1.getTime());

                var noofdays = Math.ceil(diff / (1000 * 3600 * 24));


                if(noofdays == 0){

                  ss.find('#days').val(1);
                }else
                {
                     noofdays=noofdays+1+amme;
                    console.log(noofdays);
                    noofdays=noofdays>30?noofdays%30<7?noofdays-noofdays%30:noofdays:noofdays;
                   // document.getElementById('days').value = noofdays ;
                    ss.find('#days').val(noofdays);

                }


                totalcals(idd);

            }

        }
    </script>


     <script type="text/javascript">
        function totalcals(idd) {
    if(idd.target){
               ss= $(idd.target).parents('tr') ;

           }
           else{
               ss= $(idd).parents('tr');

           }

            var days = parseFloat(ss.find("#days").val());

            var amount = parseFloat(ss.find("#per_day_amount").val());

            var qty = parseFloat(ss.find("#qty").val());

            if (Number.isNaN(days)) {
                days = 0;
            }

            if (Number.isNaN(amount)) {
                amount = 0;
            }

             if (Number.isNaN(qty)) {
                qty = 1;
            }
          
          amount=amount;
          /*    amount=amount/30;*/
            var result = days * qty * amount;

            ss.find("#sub_total").val(Math.round(result));

           extrachargesselect2(idd)
        }
    </script>



     <script type="text/javascript">
        function multiplyqty(idd,wes) {
          if(idd.target){
               ss=  $(idd.target).parents('tr') ;

           }
           else{
               ss= $(idd).parents('tr');

           }

/*
if(ss.find("#qty").val()<0 || ss.find("#qty").val()==0)
{
  ss.find("#qty").val(1);
}*/

/*
if(document.getElementById("qty").value<0 || document.getElementById("qty").value==0){
  document.getElementById("qty").value=1;
}*/


if(wes==2){

  ss.find("#per_day_amount").val(Math.round((parseFloat(ss.find("#charges_amount").val()/30))*100)/100);   
     }
     
    var total = parseFloat(ss.find("#per_day_amount").val());
    var qty = parseFloat(ss.find("#qty").val());
           

            if (Number.isNaN(total)) {
                total = 0;
            }

            if (Number.isNaN(qty)) {
                qty = 1;
            }

            var result = total * qty;

            //document.getElementById("sub_total").value = Math.round(result);

            ss.find("#sub_total").val(Math.round(result));
            ss.find("#grand_total").val(Math.round(result));

            datecheckx(idd);

            extrachargesselect2(idd);

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

            
                     let name = v == 0 || v == 6 ? $fname+$mname+$lname : val1.customer_name ;
                        let code = v == 0 || v == 6 ? val1.mem_no : val1.customer_no;
                        let status = v == 0 || v == 6  ? '('+val1.mem_status.desc+')' : '';
 
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code} ${status}<li>`);

                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>



<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
 
<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>

        $(function () {
            $("#start_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            }).on('changeDate', function (e) {
                datecheckx(e);

            });
        });

        $(function () {
            $("#end_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false
            }).on('changeDate', function (e) {
                datecheckx(e);

            });
        });

 $(function () {
            $(".start_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            }).on('changeDate', function (e) {
                datecheckx(e);

            });
        });

        $(function () {
            $(".end_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false
            }).on('changeDate', function (e) {
                datecheckx(e);

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

<!-- 
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
 -->

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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/
javascript"></script>

<script src="{{ asset('/assets/js/validationengine/js/languages/jquery.validationEngine-en.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('/assets/js/validationengine/js/jquery.validationEngine.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('/assets/js/validationengine/js/jquery.validationEngine.min.js') }}" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="{{ asset('/assets/js/validationengine/css/validationEngine.jquery.css') }}" type="text/css"/>
<script>
$(document).ready(function(){
    $("#formID").validationEngine();
   });

</script>

@endpush

