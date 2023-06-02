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

.padtheicon{
  padding-top: 15px;
  cursor: pointer;
}
 .form-control-label{
        color:black !important;
      }
</style>

  </head>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Monthly Maintenance Fee Posting</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <!-- <a target="_blank" href="{{ url('room-management/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> -->
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1 && $receiptstatus==0)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-payment-receipts') }}">Payment Receipts List</a></li>
  <li><a href>Edit Payment Receipt</a></li>
</ul>

@elseif($init==1 && $receiptstatus==1)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Edit Invoice</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href>Maintenance Fee Posting List</a></li>
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
    <form method="post" onsubmit="return runpostin(event)">
    @endif
    @csrf


                                        <div class="form-layout form-layout-4 ">

                  <div class="row">

<div class="col-sm-6 col-sm-offset-3">
                      <h6 class="box-title headingsettings"><b>CHARGES FOR ALL MEMBERS</b></h6><br>

    <div class="row mg-t-10">
        <label class="col-sm-3 form-control-label">
           Select Range:
            <i class="fa fa-info-circle text-info" data-toggle="tooltip" title="Leave empty if generating for all members"></i>

        </label>
        <div class="col-sm-4 ">
            <input type="text"
                  class="form-control input-height "
                   placeholder="From Member ID"

                   value=""
                   name="from">

        </div>
        <div class="col-sm-4 ">
            <input type="text"
                   class="form-control input-height "

                   value=""
                   placeholder="To Member ID"
                   name="to">

        </div>
    </div>
    <div class="row mg-t-10">
        <label class="col-sm-3 form-control-label">
            Invoice Date:
            <span class="tx-danger">
                                *
                            </span>
        </label>
        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
            <input type="text"
                   id="invoice_date" class="form-control input-height " autocomplete="off"

                   value=""
                   name="invoice_date">

        </div>
        <div class="col-sm-4  mg-t-10 mg-sm-t-0">
            <h5>Select to Include Members by their Status</h5>
            @foreach($status as $s)
                <label> <input type="checkbox" class="status" value="{{$s->id}}" name="status[]">{{$s->desc}}</label>

            @endforeach

        </div>
    </div>
                                        

                                             

          <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td width="20%" align="left">Type</td>
                                                        <td width="10%" align="left">Amount</td>
                                                        <td width="10%" align="left">Per Day Amount</td>
                                                        <td width="15%" align="left">Start Date</td>
                                                        <td width="15%" align="left">End Date</td>
                                                        <td width="10%" align="left">Days</td>
                                                        <td width="10%" align="left">QTY</td>
                                                        <td width="10%" align="left">Total</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">

                                                    @if($init==1)
                                                    @php $count=0; @endphp
                                                        @foreach($subdata as $sub)
                                                    @php $count++; @endphp

                                                            <tr>
                                  <td><select id="{{ $count }}" onchange="extrachargesselect(this.id)"
                                                                            class="form-control input-height select2"
                                                                            name="charges_type[]">
                                <option value="">Choose Option</option>
<optgroup label="Main Charges">
   @foreach($main_types as $main)
    @can('Invoice'.' '.$main->id)

                                         @if($init==1)
                  <option  @if(old('charges_type',$invoice_update->charges_type)==$main->id)  selected @endif value="{{ $main->id }}"> {{ $main->name }}  </option>
                                   @endif
                                   @endcan
                                  @endforeach
</optgroup>

 
                                                <optgroup label="Charges Types">
                                                                        @foreach($finance_invoice_charges_type as $chargestypes)
                                           @can('Invoice'.' '.$chargestypes->name.' '.$chargestypes->mod_id)

                                         @if($init==1)
                  <option  @if(old('charges_type',$invoice_update->charges_type)==$chargestypes->id)  selected
                                                                                    @endif value="{{ $chargestypes->id }}">
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
                  <option  @if(old('charges_type',$invoice_update->charges_type)==$subscription->id)  selected
                                                                                    @endif value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                                                                    {{ $subscription->name }}
                                                                                </option>

                                                                            @endif
                                                                      @endcan
                                                                        @endforeach
                                                                        </optgroup>

                                                                    </select></td>
 <td>
  <input id="charges_amount{{ $count }}" onkeyup="extrachargesselect2()" class="form-control input-height"
                                                                           type="text" name="charges_amount[]"
                                                                           value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$sub->charges_amount)}}@endif"
                                                                          >
                                                                </td>

              <td>
         <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date{{ $count }}" class="form-control input-height" type="text"
                                                                           name="start_date[]"
                                                                           value="@if($init==0){{old('start_date[]')}}@else{{old('start_date[]',formatDateToShow($sub->start_date))}}@endif">
                                                                </td>
 <td>
         <input id="end_date{{ $count }}" placeholder="dd/mm/yyyy" autocomplete="off" class="form-control input-height" type="text"
                                                                           name="end_date[]"
                                                                           value="@if($init==0){{old('end_date[]')}}@else{{old('end_date[]',formatDateToShow($sub->end_date))}}@endif">
                                                                </td>
  <td>
         <input id="days{{ $count }}" class="form-control input-height" readonly type="number"
                                                                           name="days[]"
                                                                           value="@if($init==0){{old('days[]')}}@else{{old('days[]',$sub->days)}}@endif">
                                                                </td>
<td>
         <input id="total{{ $count }}" class="form-control input-height totalamt" readonly onkeyup="extrachargesselect2()" type="number"
                                                                           name="total[]"
                                                                           value="@if($init==0){{old('total[]')}}@else{{old('total[]',$sub->total)}}@endif">
                                                                </td><td>
         <input id="qty{{ $count }}" oninput="multiplyqty()" class="form-control input-height "  type="number"
                                                                           name="qty[]" min="1"
                                                                           value="@if($init==0){{old('total[]')}}@else{{old('total[]',$sub->total)}}@endif">
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
     @can('Invoice'.' '.$main->id)
<option  @if(old('charges_type')==$main->id)  selected @endif value="{{ $main->id }}"> {{ $main->name }} </option>

@endcan
 @endforeach
</optgroup>

                                   <optgroup label="Charges Types">
                                                                    @foreach($finance_invoice_charges_type as $chargestypes)
                                @can('Invoice'.' '.$chargestypes->name.' '.$chargestypes->mod_id)
                                                                <option
                                                               @if(old('charges_type')==$chargestypes->id)  selected
                                                                            @endif value="{{ $chargestypes->id }}">
                                                                            {{ $chargestypes->name }}
                                                                        </option>
                                                               @endcan
                                                                    @endforeach
                                                                    </optgroup>

                     <optgroup label="Subscription Types">
                                                                        @foreach($subscription_type as $subscription)
                        @can('Invoice'.' '.$subscription->name.' '.$subscription->mod_id)
                                                         <option @if(old('charges_type')==$subscription->id)  selected
                                                                                    @endif value="{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                                                                    {{ $subscription->name }}
                                                                                </option>
                                                                          @endcan
                                                                        @endforeach
                                                                        </optgroup>
                                                            </select></td>
               <td>
         <input id="charges_amount1"  oninput="multiplyqty(this,2)"   class="form-control input-height charamt"
                                                                       type="text" name="charges_amount[]"
                                                                       value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$sub->charges_amount)}}@endif">
                                                            </td>

                                                                 <td>
         <input id="per_day_amount1"  oninput="multiplyqty(this)"   class="form-control input-height chars"
                                                                       type="text" name="per_day_amount[]"
                                                                       value="@if($init==0)@else{{$sub->per_day_amount}}@endif">
                                                            </td>

                                                            <td>
          <input placeholder="dd/mm/yyyy" autocomplete="off" id="start_date1"
                                                                       class="form-control input-height" type="text"
                                                                       name="start_date[]"
                                                                       value="@if($init==0){{old('start_date[]')}}@else{{old('start_date[]',formatDateToShow($sub->start_date))}}@endif">
                                                            </td>
                    <td>
                          <input placeholder="dd/mm/yyyy" autocomplete="off" id="end_date1"
                                                                       class="form-control input-height" type="text"
                                                                       name="end_date[]"
                                                                       value="@if($init==0){{old('end_date[]')}}@else{{old('end_date[]',formatDateToShow($sub->end_date))}}@endif">
                                                            </td>
 <td>
                                                                <input id="days1" readonly
                                                                       class="form-control input-height" type="number"
                                                                       name="days[]"
                                                                       value="@if($init==0){{old('days[]')}}@else{{old('days[]',$sub->days)}}@endif">
                                                            </td>

                                               <td>
                                                                <input id="qty1"  oninput="multiplyqty()"
                                                                       class="form-control input-height" type="number" min="1"
                                                                       name="qty[]"
                                                                       value="@if($init==0){{old('qty[]')}}@else{{old('qty[]',$sub->qty)}}@endif">
                                                            </td>  <td>
                                                                <input id="total1" readonly onkeyup="extrachargesselect2()"
                                                                       class="form-control input-height totalamt" type="number"
                                                                       name="total[]"
                                                                       value="@if($init==0){{old('total[]')}}@else{{old('total[]',$sub->total)}}@endif">
                                                            </td>

                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>


                                               
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Total Charges:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('final_total')) style="border-color:red;"
                                                               @endif id="final_total"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('final_total')}}@else{{old('final_total',$invoice_update->total)}}@endif"
                                                               name="final_total">

                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label" style="color: black;">
                                                        Discount Amount:

                                                    </label>
                                                    <div class="col-sm-3 mg-t-5 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('discount_amount')) style="border-color:red;"
                                                               @endif id="discount_amount"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$invoice_update->discount_amount)}}@endif" name="discount_amount" oninput="subtract_discount()">

                                                    </div>

                                                       <div class="col-sm-2 mg-t-10 mg-sm-t-0 pc">

            <input type="number"
                                                               @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('discount_percentage')}}@else{{old('discount_percentage',$invoice_update->discount_percentage)}}@endif" name="discount_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label" style="color: black;">
                                                        Details:
                                                    </label>

                                                      <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="discountDetails()"></i></div>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="discount_div">
                                                <textarea
                                                            @if ($errors->has('discount_details')) style="border-color:red;"
                                                            @endif id="discount_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="discount_details">@if($init==0){{old('discount_details')}}@else{{old('discount_details',$invoice_update->discount_details)}}@endif</textarea>
                                                  </div>

                                                </div>
 <div class="row mg-t-10">
          <label class="col-sm-3 form-control-label"> Overdue Charges:</label>

                                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0" >
            <input type="number" @if ($errors->has('extra_charges')) style="border-color:red;"
                                                               @endif id="extra_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('extra_charges')}}@else{{old('extra_charges',$invoice_update->extra_charges)}}@endif" name="extra_charges" oninput="subtract_discount()">

                                                    </div>


                                                   <div class="col-sm-2 mg-t-10 mg-sm-t-0 pc">

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
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="extra_div">
                                           <textarea
                                                            @if ($errors->has('extra_details')) style="border-color:red;"
                                                            @endif id="extra_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="extra_details">@if($init==0){{old('extra_details')}}@else{{old('extra_details',$invoice_update->extra_details)}}@endif</textarea>
</div>
                                                </div>

 <div class="row mg-t-10">
                                   <label class="col-sm-3 form-control-label"> Tax Charges: </label>

                                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0" >
           <input type="number" @if ($errors->has('tax_charges')) style="border-color:red;"
                                                               @endif id="tax_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('tax_charges')}}@else{{old('tax_charges',$invoice_update->tax_charges)}}@endif" name="tax_charges" oninput="subtract_discount()">

                                                    </div>

           <div class="col-sm-2 mg-t-10 mg-sm-t-0 pc">

            <input type="number" @if ($errors->has('tax_percentage')) style="border-color:red;"
                                                               @endif id="tax_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('tax_percentage')}}@else{{old('tax_percentage',$invoice_update->tax_percentage)}}@endif" name="tax_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="TaxDetails()"></i></div>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="tax_div">
                                             <textarea
                                                            @if ($errors->has('tax_details')) style="border-color:red;"
                                                            @endif id="tax_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="tax_details">@if($init==0){{old('tax_details')}}@else{{old('tax_details',$invoice_update->tax_details)}}@endif</textarea>
</div>


                                                </div>

    <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Grand Total:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('grand_total')) style="border-color:red;"
                                                               @endif id="grand_total" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$invoice_update->grand_total)}}@endif"
                                                               name="grand_total">

                                                    </div>
                                                </div>
 <div class="row mg-t-10">
 <label class="col-sm-3 form-control-label">
         Amount Paid in Words:     <span class="tx-danger">
                                                                      *
                                                                  </span></label>
         <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$invoice_update->amount_in_words)}}@endif">
</div>
</div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Comments:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <textarea
                                                            @if($errors->has('comments'))style="border-color:red;"
                                                            @endif id="comments" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="comments">@if($init==0){{old('comments')}}@else{{old('comments',$invoice_update->comments)}}@endif</textarea>

                                                    </div>
                                                </div>

                                                            <div class="float-left" style="margin-left:15px;">
                                            <div id="discount" style="display: none">
                                            <span  style="display: none" class="ccount"><span  class="count"></span> out of <span class="total"></span> are done </span>
                                                <div class="progress">
                                                    <div class="progress-bar"  ddm="0" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>


                                                @if($init==1)

                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                      
                                                        <div class="form-layout-footer mg-t-30">

                                                            <button type="input" name="save" class="btn btn-info">
                                                                Update
                                                            </button>
                                                            
                                                            <a href="{{ url('finance-and-management/finance-invoices') }}"
                                                               class="btn btn-secondary">Cancel</a>
                                                        </div><!-- form-layout-footer -->
                                                    </div>

                                                @else
                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        
                                                        <div class="form-layout-footer mg-t-30">
                                                            <input type="submit" name="save" class="btn btn-info"
                                                                   value="Save">

                                                           
                                                            <input type="submit" name="addmore" class="btn btn-info"
                                                                   value="Save & Print">
                                                            <input type="button" name="preview" class="btn btn-info"
                                                                   value="preview" onclick="previewx()">

                                                            
                                                            <a href="{{ url('finance-and-management/finance-invoices') }}"
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
function previewx(){
    let data=$('form').serialize();
let url='/finance-and-management/maintenance-fee-posting/maintenance-fee-posting-preview?'+data;
    window.open(url, '_blank');
    window.focus();
}
        function runpostin(e){
            e.preventDefault();
            let data=$('form').serialize();
            $('input[type="submit"]').attr('disabled','disabled');
         let intv=   setInterval(function(){
                // $.getJSON('/finance-and-management/maintenance-fee-posting/progress', function(data) {
                //     let d=data[0].split('-');
                //
                //
                //     $('.count').html(d[2]);
                //     $('.total').html(d[1]);
                //     $('#discount').show();
                // });

             if($('#progress').attr('ddm')!='100'){
                 $('#discount').show();

                 $('#progress').attr('ddm',parseInt($('#progress').attr('ddm'))+1)
                 $('#progress').css('width',$('#progress').attr('ddm')+'%');

             }
            }, 1000);
            $.ajax({
                url:"{{ url('finance-and-management/maintenance-fee-posting/storeall') }}",
                method:"POST",
                data:data,
                success:function(result){
                    $('input[type="submit"]').removeAttr('disabled');
                    $('#progress').attr('ddm',100)
                    $('.ccount').show()
                    $('#progress').css('width',100+'%');
                    $('#progress').addClass('progress-bar-success')
                    // setTimeout(function(){location.reload();},500)

                },
                error:function (){
                    $('input[type="submit"]').removeAttr('disabled');
                    $('#progress').attr('ddm',100)
                    $('#progress').css('width',100+'%');
                    $('#progress').addClass('progress-bar-danger')
                    // setTimeout(function(){location.reload();},500)
                }
            })
            return false;
        }

        var total = 0;

        $('#contact').mask('00000000000');

        $('#cnic').mask('00000-0000000-0');
        $(document).ready(function(){
            $('input[name="invoice_type"]').change(function(){
             console.log($(this).val())
            });
        })

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

        function extrachargesselect(idd) {

            var idval = document.getElementById(idd).value;


            var memid = 0;

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
                        document.getElementById('charges_amount' + idd).value = obj;
                        document.getElementById('per_day_amount' + idd).value = Math.round((obj/30)*100)/100;
                        document.getElementById('total'+ idd).value = obj;
                        document.getElementById('qty'+idd).value = 1;
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
    <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); datecheckx();"></i>
    <select id="`+id+`"  onchange="extrachargesselect(this.id)" class="form-control input-height select2" name="charges_type[]" >
<option value="">Choose Option</option>
<optgroup label="Membership Charges">
`+memD+`
</optgroup>

 <optgroup label="Charges Types">
                     @foreach($finance_invoice_charges_type as $roomcharges)
            <option value="C-{{ $roomcharges->id }}">
                                    {{ $roomcharges->type }}
            </option>
@endforeach
</optgroup>


<optgroup label="Subscription Types">
              @foreach($subscription_type as $subscription)
            <option value="S-{{ $subscription->id }}" data-price="{{$subscription->charges}}">
                                    {{ $subscription->desc }}
            </option>
@endforeach
</optgroup>


            </select></td>
              <td>
               <i>&nbsp</i>
                      <input id="charges_amount`+id+`" oninput="multiplyqty(this,2)" class="form-control input-height charamt" type="text" name="charges_amount[]">
                  </td>
                  <td>
               <i>&nbsp</i>
                      <input id="per_day_amount`+id+`" oninput="multiplyqty(this)"  class="form-control input-height chars" type="text" name="per_day_amount[]">
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
                <input id="total`+id+`" readonly onkeyup="extrachargesselect2()" class="form-control input-height totalamt" type="number" name="total[]" >
                  </td>


                     </tr>`;
            i++;
            $('#addmoreid').append(html);
            $('#addmoreid #start_date'+id+',#addmoreid #end_date'+id).datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false,
                startDate: new Date()
            }).on('changeDate', function () {
                datecheckx(id);

            });;

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
                        document.getElementById('customer_id').value = obj.id;
                        document.getElementById('member_id').value ='';
                        document.getElementById('mem_no').value = '';
                        $('#family').html('<option label="Choose Family Member">  </option>');

                    } else {
                        document.getElementById('address').value = obj.cur_address;
                        document.getElementById('cnic').value = obj.cnic;
                        document.getElementById('contact').value = obj.mob_a;
                        document.getElementById('email').value = obj.personal_email;
                        document.getElementById('name').value = obj.applicant_name;
                        $('#name').attr('readonly','readonly')

                        document.getElementById('member_id').value = obj.id;
                        document.getElementById('mem_no').value = obj.mem_no;
                        document.getElementById('customer_id').value = '';
                            $('#family').html('<option label="Choose Family Member">  </option>');
                        $.each(obj.family,function(x,y){
                            $('#family').append('<option value="'+y.id+'">'+y.name+'</option>');

                        })
                        $($('optgroup[label="Membership Charges"]').find('option')[0]).attr('data-price',obj.mem_fee);
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
            if ($('#start_date'+i).val() != '' && $('#end_date'+i).val() != '') {


                var date1 = $('#start_date'+i).val().split('/');
                var date2 = $('#end_date'+i).val().split('/');


                var date1 = new Date(date1[1] + '-' + date1[0] + '-' + date1[2]);
                var date2 = new Date(date2[1] + '-' + date2[0] + '-' + date2[2]);
                var diff = Math.abs(date2.getTime() - date1.getTime());

                var noofdays = Math.ceil(diff / (1000 * 3600 * 24));


                if(noofdays == 0){
                  document.getElementById('days'+i).value = 1;
                }else
                {
                     noofdays=noofdays+1;
                    console.log(noofdays);
                    noofdays=noofdays>30?noofdays%30>0?noofdays-noofdays%30:noofdays:noofdays;
                   document.getElementById('days'+i).value = noofdays ;
                }


                totalcals(i);

            }
        }
        }
    </script>


     <script type="text/javascript">
        function totalcals(id) {


            var days = parseFloat(document.getElementById("days"+id).value);

if(days){
            var amount = parseFloat(document.getElementById("per_day_amount"+id).value);
        }
        else{
            var amount = parseFloat(document.getElementById("charges_amount"+id).value);
        }

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

             amount=amount;
            var result = days * qty * amount;

            document.getElementById("total"+id).value = Math.round(result);
            extrachargesselect2()
        }
    </script>


     <script type="text/javascript">
        function multiplyqty(id,wes) {
         if(!id){
            id=1;
          }


if(wes==2){
document.getElementById("per_day_amount"+id).value = Math.round((parseFloat(document.getElementById("charges_amount"+id).value/30))*100)/100; 
     }

  var days = parseFloat(document.getElementById("days"+id).value);

if(days){
 var total = parseFloat(document.getElementById("per_day_amount"+id).value);
}else{
     var total = parseFloat(document.getElementById("charges_amount"+id).value);
}
           

            var qty = parseFloat(document.getElementById("qty"+id).value);


            if (Number.isNaN(total)) {
                total = 0;
            }

            if (Number.isNaN(qty)) {
                qty = 1;
            }

            var result = total * qty;

            document.getElementById("total"+id).value = Math.round(result);

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
                        let name = v == 1 ? val1.customer_name : val1.applicant_name;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);


                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>


<!--        <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/>  -->

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>


    <script>

        $(function () {
            $("#start_date1").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                 /* startDate: new Date()*/
            }).on('changeDate', function () {
                datecheckx();

            });
            $("#invoice_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
              /*  startDate: new Date()*/
            })
        });

        $(function () {
            $("#end_date1").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false,
               /* startDate: new Date()*/
            }).on('changeDate', function () {
                datecheckx();

            });
        });


         $(function () {
            $("#end_date2").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false,
              /*  startDate: new Date()*/
            }).on('changeDate', function () {
                datecheckx();

            });
        });


          $(function () {
            $("#start_date2").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false,
               /* startDate: new Date()*/
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

