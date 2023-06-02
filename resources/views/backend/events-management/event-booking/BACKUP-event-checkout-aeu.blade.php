@extends('backend.layout.app')
@section('page-content')
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
        ul.breadcrumbee li + li:before {
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

        .areabox {
            cursor: pointer !important;
        }

        .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

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

    <div class="br-pagebody">
        <div>
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Event Check Out</h6>
            <div style="text-align: right;">
                <a href>
                    <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

@if($checkout==1 && $init==1)
                <ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('events-management') }}">Events Management</a></li>
                    <li><a href="{{ url('events-management/event-checkout') }}">Event Check Out List</a></li>
                    <li><a href>Edit Event Check Out</a></li>
                </ul>
@else
 <ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('events-management') }}">Events Management</a></li>
                    <li><a href="{{ url('events-management/event-booking') }}">Event Booking List</a></li>
                    <li><a href>Add Event Check Out</a></li>
                </ul>
@endif


 @if($errors->any())
<div id="error_msg" class=" alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
<br>

            <div class="col-xl-12">
    <form method="post" enctype="multipart/form-data" action="{{ url('events-management/event-booking/event-checkout-aeu') }}/{{ Request::segment(4)}}">
    @csrf

                  <div class="form-layout form-layout-4 ">
                  <div class="row">
               <div class="col-sm-6">
<div class="row mg-t-10">
        <label class="col-sm-3 form-control-label">  Booking No.:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-9 mg-t-10 mg-sm-t-0">
    <input id="booking_no" class="form-control input-height" type="number" readonly value="@if($init==0){{$increment_number}}@else{{old('booking_no', $eventbooking->booking_no)}}@endif"
                                                               name="booking_no" style="background-color: #c1c1c1">
                        </div>
                                                    @if ($errors->has('booking_no'))
                                                        <span class="help-block">
                        <strong>{{ $errors->first('booking_no') }}</strong>
                        </span>
                                                    @endif
                                                </div>
           <div class="row mg-t-10">
                                                    <label>
                                                    </label>
                                                    <label class="col-sm-3 form-control-label">
                                                        Booking Date:
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

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
              <input  @if ($errors->has('booking_date')) style="border-color:red;" @endif id="booking_date" class="form-control input-height" type="text" value="@if($init==0)<?php echo $today;?>@else{{old('booking_date',formatDateToShow($eventbooking->booking_date))}}@endif" name="booking_date" readonly style="background-color: #c1c1c1">

                                                    </div>

                                                </div>
                                                <!-- row -->
    <br>
               <h6 class="box-title headingsettings"><b>GUEST BILL TO</b></h6>
                <br>
 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">Booking Type:<span
                                                            class="tx-danger">
                                *

                            </span>
                                                    </label>
        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($eventbooking->booking_type==0) checked="" @else disabled @endif type="radio" name="booking_type" value="0"><span class="pabs">Member</span></label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if($eventbooking->booking_type==1) checked=""  @else disabled @endif type="radio" name="booking_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->
                           
 </div><!-- row-->

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Member / Guest Name:
                                                      <span class="tx-danger">
                                                                      *
                                                                  </span> 
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                             <input @if($errors->has('moc_name')) style="border-color:red;"  @endif id="moc_name" class="form-control input-height typeahead" readonly style="background-color: #c1c1c1"  placeholder="Enter to Search" autocomplete="off" value="@if($init==0){{old('moc_name')}}@else{{old('moc_name',$eventbooking->moc_name)}}@endif"
                                                               type="text" name="moc_name">

                                                        <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>

                                                    </div>
                                                </div>

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <a href="{{ url('room-management/room-customer/room-customer-aeu') }}"
                                                           target="_blank">
                                                            <input type="button" value="Add New Guest"
                                                                   class="btn btn-info">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Member No.:
                                                        <!-- <span class="tx-danger">
                                                                         *
                                                                     </span> -->
                                                    </label>
                                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_code" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_code')}}@else{{old('member_code',$eventbooking->member?$eventbooking->member->mem_no:'') }}@endif"
                                                               type="text" name="member_code">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_id')}}@else{{old('member_id',$eventbooking->member_id)}}@endif"
                                                               type="hidden" name="member_id">

                                                    </div>
                                                    <label class="col-sm-1 form-control-label">
                                                        Guest No.:
                                                        <!-- <span class="tx-danger">
                                                                         *
                                                                     </span> -->
                                                    </label>
                                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('customer_id')) style="border-color:red;"
                                                            @endif id="customer_id" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$eventbooking->customer_id)}}@endif"
                                                            type="text" name="customer_id">

                                                    </div>
                                                </div>

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Address:
                                                        <!-- <span class="tx-danger">
                                                                         *
                                                                     </span> -->
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('moc_address')) style="border-color:red;"
                                                            @endif id="moc_address" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('moc_address')}}@else{{old('moc_address',$eventbooking->moc_address)}}@endif"
                                                            type="text" name="moc_address">

                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        CNIC:
                                                        <!--  <span class="tx-danger">
                                                                        *
                                                                    </span> -->
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('moc_cnic')) style="border-color:red;"
                                                               @endif id="moc_cnic" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('moc_cnic')}}@else{{old('moc_cnic',$eventbooking->moc_cnic)}}@endif"
                                                               type="text" name="moc_cnic">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Contact:
                                                        <!--  <span class="tx-danger">
                                                                        *
                                                                    </span> -->
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('moc_mob')) style="border-color:red;"
                                                               @endif id="moc_mob" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('moc_mob')}}@else{{old('moc_mob',$eventbooking->moc_mob)}}@endif"
                                                               type="text" name="moc_mob">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Email:
                                                        <!--  <span class="tx-danger">
                                                                       *
                                                                   </span> -->
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('moc_email')) style="border-color:red;"
                                                               @endif id="moc_email" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('moc_email')}}@else{{old('moc_email',$eventbooking->moc_email)}}@endif"
                                                               type="text" name="moc_email">

                                                    </div>
                                                </div>
<div class="row mg-t-10">
      <label class="col-sm-3 form-control-label">
         Ledger Amount:     <span class="tx-danger"> </span> &nbsp &nbsp &nbsp &nbsp &nbsp
<a href="{{ url('finance-and-management/finance-ledger-accounts') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a> </label>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$eventbooking->ledger_amount)}}@endif">
</div>
</div>

                        <div class="row mg-t-10">
                 <label class="col-sm-3 form-control-label">
                         Family Member:
                                                    </label>
                                                      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
          <select onchange="relationship(this.id)" @if ($errors->has('family')) id="{{ $familymembers->id }}"

            style="border-color:red;" @endif id="family" class="form-control input-height select2" name="family" style="background-color: #c1c1c1"> <option disabled label="Choose Family Member">  </option>
                    @foreach($familymembers as $fm)
         @if($init==1)
          <option
           @if(old('family',$eventbooking->family)==$fm->id)  selected @else disabled   @endif  value="{{ $fm->id }}"> {{ $fm->name }} ({{ $fm->relationship_name->desc }})
                         </option>  @else
            <option
        @if(old('family')==$fm->id)  selected @endif value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         @endif
                            @endforeach
                                                        </select>
                                                </div>

</div>

 <br><br>
               <h6 class="box-title headingsettings"><b>EVENT DETAILS</b></h6>
                <br>
                 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Booked By:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('booked_by')) style="border-color:red;"
                                                               @endif id="booked_by" class="form-control input-height"
                                                               placeholder="Enter Booking Reference" readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('booked_by')}}@else{{old('booked_by',$eventbooking->booked_by)}}@endif"
                                                               type="text" name="booked_by">

                                                    </div>
                                                </div>
     <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                      Nature of Event:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('nature_of_event')) style="border-color:red;"
                                                               @endif id="nature_of_event" class="form-control input-height"
                                                               placeholder="Enter Details" readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('nature_of_event')}}@else{{old('nature_of_event',$eventbooking->nature_of_event)}}@endif"
                                                               type="text" name="nature_of_event">

                                                    </div>
                                                </div>
                            <div class="row mg-t-10">
                                                    <label>
                                                    </label>
                                                    <label class="col-sm-3 form-control-label">
                                                       Event Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">

                                                        <input
                                                            @if ($errors->has('event_date')) style="border-color:red;"
                                                            @endif id="event_date" class="form-control input-height"
                                                            autocomplete="off" type="text" style="background-color: #c1c1c1" readonly placeholder="dd/mm/yyyy"
                                                            value="@if($init==0){{old('event_date')}}@else{{old('event_date',formatDateToShow($eventbooking->event_date))}}@endif"
                                                            name="event_date">

                                                    </div>

                                                </div>
                                                <!-- row -->
  <div class="row mg-t-10">
                                                    <label>
                                                    </label>
                                                    <label class="col-sm-3 form-control-label">
                                                   Timing (From):
                                                    <span class="tx-danger"> * </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('from')) style="border-color:red;"
                                                            @endif id="from" class="form-control input-height timepicker"
                                                            autocomplete="off" style="background-color: #c1c1c1" readonly  type="text" placeholder="hh:mm AM/PM"
                                                            value="@if($init==0){{old('from')}}@else{{old('from',$eventbooking->from)}}@endif" name="from">
                                                    </div>

                                                </div>
  <div class="row mg-t-10">
                                                    <label>
                                                    </label>
                                                    <label class="col-sm-3 form-control-label">
                                                   Timing (To):
                                                    <span class="tx-danger"> * </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('to')) style="border-color:red;"
                                                            @endif id="to" class="form-control input-height timepicker"
                                                            autocomplete="off" style="background-color: #c1c1c1" readonly type="text" placeholder="hh:mm AM/PM"
                                                            value="@if($init==0){{old('to')}}@else{{old('to',$eventbooking->to)}}@endif" name="to">
                                                    </div>

                                                </div>
    <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Venue:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <select @if ($errors->has('venue')) style="border-color:red;"
                                                                @endif id="roomcategoryid"
                                                                class="form-control input-height select2"
                                                                name="venue" style="background-color: #c1c1c1">
                                                            <option disabled label="Choose Venue">
                                                            </option>
                                                            @foreach($venue as $venues)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('venue',$eventbooking->venue)==$venues->id)  selected @else disabled
                                                                        @endif  value="{{ $venues->id }}">
                                                                        {{ $venues->desc }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('venue')==$venues->id)  selected
                                                                        @endif value="{{ $venues->id }}">
                                                                        {{ $venues->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                </div>

<div class="col-sm-6">
    <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Menu:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <select onchange="menuChargesSelect(this.id)" @if ($errors->has('menu')) style="border-color:red;"
                                                                @endif id="menu"
                                                                class="form-control input-height select2"
                                                                name="menu" >
                                                            <option label="Choose Menu">
                                                            </option>
                                                            @foreach($menu as $menus)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('menu',$eventbooking->menu)==$menus->id)  selected
                                                                        @endif  value="{{ $menus->id }}">
                                                                        {{ $menus->menu_name }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('menu')==$menus->id)  selected
                                                                        @endif value="{{ $menus->id }}">
                                                                        {{ $menus->menu_name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                <br>

                 <div class="row mg-t-10">
<div class="col-sm-1"></div>
<div class="col-sm-11 mg-t-10 mg-sm-t-0">
        <table id="menutable" align="center" border="0" width="100%">
              <tbody>
           <tr>
             <td width="10%" align="left">&nbsp</td>
            <td width="7%" align="left">&nbsp</td>
                                                        <td width="50%" align="left">Item Name<span class="tx-danger">*</span></td>
                                                        <td width="20%" align="left">Charges<span class="tx-danger">*</span></td>
                                                       
                                                    </tr>
                                                    <tbody>
                 <tbody id="addmoreidd">

                 @if($init==1)
                  @foreach($eventsubdata as $sub)
                          <tr>
<td>&nbsp</td>
                             <td>
                        <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect3(this.id);"></i>
                            </td>

                            <td>
                              <select id="{{ $sub->id }}" class="form-control input-height select2" name="item_name[]">
                                <option label="Select Menu Category"></option>
                                                                        @foreach($menu_category as $menucategory)

                                                                            @if($init==1)
                                                                                <option
                                                                                    @if(old('item_name[]',$sub->item_name)==$menucategory->id)  selected
                                                                                    @endif value="{{ $menucategory->id }}">
                                                                                    {{ $menucategory->desc }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    @if(old('item_name[]')==$menucategory->id)  selected
                                                                                    @endif value="{{ $menucategory->id }}">
                                                                                    {{ $menucategory->desc }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                   </td>
                                              <td>
                             <input id="item_charges{{ $sub->id }}" onkeyup="extrachargesselect3(this.id)"
                                                                           class="form-control input-height event_item"
                                                                           type="number" name="item_charges[]"
                                                                           value="@if($init==0){{old('item_charges[]')}}@else{{old('item_charges[]',$sub->item_charges)}}@endif">
                                                                </td>
                                                      
                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                          <td>&nbsp</td>
                                                           <td>&nbsp</td>
                                      <td>
                                        <select id="1" class="form-control input-height select2" name="item_name[]">
                                                                    <option label="Select Menu Category"></option>
                                                                    @foreach($menu_category as $menucategory)


                                                                <option
                                                               @if(old('item_name[]')==$menucategory->id)  selected
                                                                            @endif value="{{ $menucategory->id }}">
                                                                            {{ $menucategory->desc }}
                                                                        </option>

                                                                    @endforeach
                                                                </select>
                                                            </td>
                                       <td>
                                     <input id="item_charges1" onkeyup="extrachargesselect3(this.id)"
                                                                       class="form-control input-height event_item" type="number" name="item_charges[]"
                                                                       value="@if($init==0){{old('item_charges[]')}}@else{{old('item_charges[]',$sub->item_charges)}}@endif">
                                                            </td>
                                                            
                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>

</div></div>
                                                <div class="row mg-t-10">

                                     <div class="col-sm-3"></div>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                      <input onclick="addmorefields3()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>
                                                <br/>

            <!--            <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Menu Rate Category:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <select @if ($errors->has('menu_category')) style="border-color:red;" @endif id="menu_category"
                                                                class="form-control input-height select2"
                                                                name="menu_category">
                                                            <option label="Choose Category">
                                                            </option>
                                                            @foreach($menu_category as $menucategory)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('menu_category',$eventbooking->menu_category)==$menucategory->id)  selected
                                                                        @endif  value="{{ $menucategory->id }}">
                                                                        {{ $menucategory->desc }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('menu_category')==$menucategory->id)  selected
                                                                        @endif value="{{ $menucategory->id }}">
                                                                        {{ $menucategory->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Per Person Menu Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('menu_charges')) style="border-color:red;"
                                                            @endif id="menu_charges"
                                                            class="form-control input-height" readonly
                                                            style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('menu_charges')}}@else{{old('menu_charges',$eventbooking->menu_charges)}}@endif"
                                                            type="number" name="menu_charges">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        No. of Guests:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('guests')) style="border-color:red;"
                                                               @endif id="guests" placeholder="Enter Total Number of Guests" class="form-control input-height" autocomplete="off" oninput="chargesselect()"
                                                               value="@if($init==0){{old('guests')}}@else{{old('guests',$eventbooking->guests)}}@endif" name="guests">

                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Total Food Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_food_charges')) style="border-color:red;"
                                                               @endif id="total_food_charges" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_food_charges')}}@else{{old('total_food_charges',$eventbooking->total_food_charges)}}@endif"
                                                               name="total_food_charges">

                                                    </div>
                                                </div>

<br><br>
        <h6 class="box-title headingsettings"><b>OTHER CHARGES</b></h6>
                <br>
                                                </br>
                                                <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                      <td width="5%" align="left">&nbsp</td>
                                                        <td width="40%" align="left">Charges Type</td>
                                                        <td width="20%" align="left">Bill Details</td>
                                                        <td width="20%" align="left">Charges Amount</td>
                                                        <td width="15%" align="left">&nbsp;</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">

                                                    @if($init==1)
                                                        @foreach($bookingsubdata as $bookingsub)
                                                            <tr>
                     <td>
                        <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect2(this.id);"></i>
                            </td>
                                                                <td><select id="{{ $bookingsub->id }}"
                                                                            onchange="extrachargesselect(this.id)"
                                                                            class="form-control input-height select2"
                                                                            name="charges_type[]">
                                                                        <option label="Choose Charges Type"></option>
                                                                        @foreach($charges_type as $chargestype)

                                                                            @if($init==1)
                                                                                <option
                                                                                    @if(old('charges_type[]',$bookingsub->charges_type_id)==$chargestype->id)  selected
                                                                                    @endif value="{{ $chargestype->id }}">
                                                                                    {{ $chargestype->type }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    @if(old('charges_type[]')==$chargestype->id)  selected
                                                                                    @endif value="{{ $chargestype->id }}">
                                                                                    {{ $chargestype->type }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select></td>
                                                                <td>
                                                                    <input id="bill_details{{ $bookingsub->id }}"
                                                                           class="form-control input-height" type="text"
                                                                           name="bill_details[]"
                                                                           value="@if($init==0){{old('bill_details[]')}}@else{{old('bill_details[]',$bookingsub->bill_details)}}@endif">
                                                                </td>
                                                                <td>

                                                                    <input id="charges_amount{{ $bookingsub->id }}"
                                                                           onkeyup="extrachargesselect2()"
                                                                           class="form-control input-height @if($bookingsub->iscomplementary=='true') @else charamt  @endif "
                                                                           type="number" name="charges_amount[]"
                                                                           value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$bookingsub->charges_amount)}}@endif"
                                                                           @if($bookingsub->iscomplementary=='true') readonly="" @endif>
                                                                </td>
                                                                <td>
                                                             <input id="complementary{{ $bookingsub->id }}" type="checkbox"
                                                   class="form-control input-height" name="complementary[]" onclick="resetchargesamount({{ $bookingsub->id }})" @if($bookingsub->iscomplementary=='true') checked=""
                                                                           @endif value="false">
               <input type="hidden" id="complementary{{ $bookingsub->id }}dump"  type="checkbox"  class="form-control input-height" name="complementary[]">
                  <label class="custom-control-label" for="Complementary?">Complementary?</label>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                          <td>&nbsp</td>
                                                            <td><select id="1" onchange="extrachargesselect(this.id)"
                                                                        class="form-control input-height select2"
                                                                        name="charges_type[]">
                                                                    <option label="Select a Charges Type"></option>
                                                                    @foreach($charges_type as $chargestype)


                                                                <option
                                                               @if(old('charges_type[]')==$chargestype->id)  selected
                                                                            @endif value="{{ $chargestype->id }}">
                                                                            {{ $chargestype->type }}
                                                                        </option>

                                                                    @endforeach
                                                                </select></td>
                                                            <td>
                                                                <input id="bill_details1"
                                                                       class="form-control input-height" type="text"
                                                                       name="bill_details[]"
                                                                       value="@if($init==0){{old('bill_details[]')}}@else{{old('bill_details[]',$bookingsub->bill_details)}}@endif">
                                                            </td>
                                                            <td>
                                                                <input id="charges_amount1"
                                                                       onkeyup="extrachargesselect2()"
                                                                       class="form-control input-height charamt"
                                                                       type="number" name="charges_amount[]"
                                                                       value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$bookingsub->charges_amount)}}@endif">
                                                            </td>
                                                            <td>
                                                                <input id="complementary1" type="checkbox"
                                                                       class="form-control input-height"
                                                                       name="complementary[]"
                                                                       onclick="resetchargesamount(1)" value="false">

                                                                <input type="hidden" id="complementary1dump"
                                                                       type="checkbox" class="form-control input-height"
                                                                       name="complementary[]" value="false">
                                                                <label class="custom-control-label"
                                                                       for="Complementary?">Complementary?</label>
                                                            </td>
                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>


                                                <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer mg-t-30">
                                                        <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>
                                                <br/>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Total Other Charges:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_other_charges')) style="border-color:red;"
                                                               @endif id="total_other_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_other_charges')}}@else{{old('total_other_charges',$eventbooking->total_other_charges)}}@endif" name="total_other_charges">

                                                    </div>
                                                </div>
<br>
               <h6 class="box-title headingsettings"><b>TOTAL</b></h6>
                <br>

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Total Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_charges')) style="border-color:red;"
                                                               @endif id="total_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               onclick="calculate_total()"
                                                               value="@if($init==0){{old('total_charges')}}@else{{old('total_charges',$eventbooking->total_charges)}}@endif" name="total_charges">

                                                    </div>
                                                </div>

                  <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label" style="color: black;">
                                                        Discount Amount:

                                                    </label>
                                                    <div class="col-sm-4 mg-t-5 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('discount_amount')) style="border-color:red;"
                                                               @endif id="discount_amount"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount" autocomplete="off"
                                                               value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$eventbooking->discount_amount)}}@endif" name="discount_amount" oninput="calculate_total()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label" style="color: black;">
                                                    Pct:
                                                    </label>
                                                    <div class="col-sm-4 mg-t-4 mg-sm-t-0 pc">
                                                        <input type="number"
                                                               @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage" autocomplete="off"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('discount_percentage')}}@else{{old('discount_percentage',$eventbooking->discount_percentage)}}@endif" name="discount_percentage" oninput="calculate_total()">

                                                    </div>
                                                </div>

                           <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Details:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <textarea
                                                            @if ($errors->has('discount_details')) style="border-color:red;"
                                                            @endif id="discount_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="discount_details">@if($init==0){{old('discount_details')}}@else{{old('discount_details',$eventbooking->discount_details)}}@endif</textarea>
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
                                                               onclick="calculate_total()" value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$eventbooking->grand_total)}}@endif" name="grand_total">

                                                    </div>
                                                </div>
<div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Payment Mode:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                                        <select @if ($errors->has('payment_mode')) style="border-color:red;"
                                                                @endif id="payment_mode"
                                                                class="form-control input-height select2"
                                                                name="payment_mode">

                                        @foreach($payment_methods as $methods)
                                                                @if($init==1)
                           <option  @if(old('payment_mode',$eventbooking->payment_mode)==$methods->id)  selected  @endif  value="{{ $methods->id }}">  {{ $methods->desc }}
                    </option>
                                   @else
                             <option @if(old('payment_mode')==$methods->id) selected @endif value="{{ $methods->id }}">  {{ $methods->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
 <label class="col-sm-1 form-control-label" style="color: black;">
                                                        Details:
                                                    </label>
                                                    <div class="col-sm-4 mg-t-4 mg-sm-t-0">
                                                        <textarea
                                                            @if ($errors->has('payment_mode_details')) style="border-color:red;"
                                                            @endif id="payment_mode_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="payment_mode_details">@if($init==0){{old('payment_mode_details')}}@else{{old('payment_mode_details',$eventbooking->payment_mode_details)}}@endif</textarea>

                                                    </div>

                                                </div>

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Advance Paid:

                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('advance_paid')) style="border-color:red;"
                                                               @endif id="advance_paid"
                                                               class="form-control input-height" autocomplete="off"
                                                               placeholder="Enter Advance (if paid)"  style="background-color: #c1c1c1" readonly 
                                                               value="@if($init==0){{old('advance_paid')}}@else{{old('advance_paid',$eventbooking->advance_paid)}}@endif"
                                                               type="text" name="advance_paid"
                                                               oninput="calculate_total()">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Balance:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_balance')) style="border-color:red;"
                                                               @endif id="total_balance"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               onclick="calculate_total()"
                                                               value="@if($init==0){{old('total_balance')}}@else{{old('total_balance',$eventbooking->total_balance)}}@endif" name="total_balance">

                                                    </div>
                                                </div>
                               <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                         Amount in Words::
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                            <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" placeholder="Enter Total Amount to be Paid" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$eventbooking->amount_in_words)}}@endif">
                                                    </div>
                                                </div>
   <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                      Amount Paid:
<span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if ($errors->has('amount_paid')) style="border-color:red;" @endif id="amount_paid" class="form-control input-height" placeholder="Enter Total paid Amount" name="amount_paid" value="{{old('amount_paid',$eventbooking->amount_paid)}}" oninput="calculate_total()">

                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                 Balance:
                     <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if ($errors->has('grand_balance')) style="border-color:red;" @endif id="grand_balance" class="form-control input-height" value="{{old('grand_balance',$eventbooking->grand_balance)}}" readonly style="background-color: #c1c1c1" name="grand_balance">

                        </div>
                    </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Additional Notes:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <textarea
                                                            @if($errors->has('additional_notes'))style="border-color:red;"
                                                            @endif id="additional_notes" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="additional_notes">@if($init==0){{old('additional_notes')}}@else{{old('additional_notes',$eventbooking->additional_notes)}}@endif</textarea>

                                                    </div>
                                                </div>
</div>

                                                </div>
<!-- <br><br>
<b>NOTE:</b><p style="text-align: left !important;">Minimum 50% advance to book the event is valid. Balance is payable minimum 3 days prior to the event.</p> -->
<br><br><br>
                                            <div class="desktop-screen-design">

@if($checkout==1 && $init==1)
  <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        &nbsp&nbsp
                                                        <div class="form-layout-footer mg-t-30">

                                                            <button type="input" name="save" class="btn btn-info">
                                                                Update
                                                            </button>
                                                            &nbsp&nbsp
                                                            <a href="{{ url('events-management/event-checkout') }}"
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
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                                                            &nbsp&nbsp
                                                            <a href="{{ url('events-management/event-booking') }}"
                                                               class="btn btn-secondary">Cancel</a>

                                                        </div><!-- form-layout-footer -->
                                                    </div>
                                                    @endif
                                            </div><!-- form-layout -->
                                        </div><!-- col-6 -->
                                    </form>
            </div>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->


@endsection


@push('jscode')
    <script type="text/javascript">
        var total = 0;
        /*$('#first_name').attr('maxlength', 100);
        $('#last_name').attr('maxlength', 100);
        $('#guest_company').attr('maxlength', 300);
        $('#guest_address').attr('maxlength', 600);
        $('#guest_country').attr('maxlength', 100);
        $('#guest_city').attr('maxlength', 100);*/
        $('#guest_mob').mask('00000000000');
        /*$('#guest_email').attr('maxlength', 300); */
        $('#guest_cnic').mask('00000-0000000-0');
        /*$('#accompained_guest').attr('maxlength', 100);
        $('#acc_relationship').attr('maxlength', 200);*/
        $('#acc_cnic').mask('00000-0000000-0');
        /*$('#booked_by').attr('maxlength', 100);
        */
    </script>

    <script type="text/javascript">
        function checkoutdate(id) {

            var updateval = '';
            var out = $('#check_out_date').val();
            @if($init==1) updateval = '{{ Request::segment(4) }}';
            @else updateval = 'insert';
                @endif
            var pdate = $('#check_in_date').val();
            ;
            $('#roomid option:not(:first)').remove();
            $.ajax({
                type: 'POST',
                url: '{{ url('room-management/room-booking/roomallocation') }}',
                data: {
                    "_token": "{{ csrf_token() }}",

                    "pdate": pdate,
                    "odate": out,
                    "updatecheck": updateval

                },
                success: function (data) {
                    var val = JSON.parse(data);
                    console.log(val);
                    var rooms = val.room;
                    var idp = 0;
                    var inc = 0;
                    jQuery.each(rooms, function (i, val1, idp, val) {
                        idp = val1.room_type;
                        var valu12 = val1.id;
                        let select = '';
                        if (val1.id == '<?php echo isset($eventbooking->room) ? $eventbooking->room : ''?>') {
                            select = 'selected="selected"';
                        }
                        $("#roomid").append(`<option ` + select + ` value="${val1.id}">
    ${val1.room_no}  ${rooms[inc].roomtypes.desc}
       </option>`);


                        $("#selectbelow").append(`<input id="roomtype${val1.id}" type="hidden" name="room_typeid${val1.id}" value="${rooms[inc].roomtypes.id}"> `);

                        inc++;


                    });

                }

            });
        }
    </script>
    <script type="text/javascript">
        function datecheckx() {
            if ($('#check_in_date').val() != '' && $('#check_out_date').val() != '') {


                var date1 = $('#check_in_date').val().split('/');
                var date2 = $('#check_out_date').val().split('/');


                var date1 = new Date(date1[1] + '-' + date1[0] + '-' + date1[2]);
                var date2 = new Date(date2[1] + '-' + date2[0] + '-' + date2[2]);
                var diff = Math.abs(date2.getTime() - date1.getTime());

                var noofdays = Math.ceil(diff / (1000 * 3600 * 24));

                 if(noofdays == 0){
                  document.getElementById('nights').value = 1;
                }else
                {
                document.getElementById('nights').value = noofdays;
              }

                chargesselect();
            }
        }

    </script>

    <script type="text/javascript">
        var input = document.querySelector('input[type=file]');
        input.onchange = function () {

            var file = input.files[0];
            displayAsImage(file);

        };

        function displayAsImage(file) {
            var imgURL = URL.createObjectURL(file);
            img = document.getElementById("booking_docs");
            img.src = imgURL;

        }
    </script>

     <script type="text/javascript">

        function menuChargesSelect(idd) {

            var idval = document.getElementById(idd).value;

            $.ajax({
                type: 'GET',
                url: '{{ url('events-management/event-booking/calculatemenucharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                      console.log(obj);
                        document.getElementById('menu_charges').value = obj;
                    }
                }
            });
        }

    </script>

    <script type="text/javascript">
       function chargesselect() {
                            var myBoxone = parseFloat(document.getElementById("menu_charges").value);
                            var myBoxtwo = parseFloat(document.getElementById("guests").value);
                            

                     if(Number.isNaN(myBoxone)){
                    myBoxone=0;
                  }

                  if(Number.isNaN(myBoxtwo)){
                    myBoxtwo=0;
                  }
                    var result = myBoxone * myBoxtwo;
                            document.getElementById("total_food_charges").value = result;
                            document.getElementById("total_charges").value = result;
                            document.getElementById("grand_total").value = result;
                            document.getElementById("total_balance").value = result;

                            document.getElementById('amount_in_words').value = inWords(document.getElementById('total_balance').value);
                }
    </script>



    <script type="text/javascript">

        function extrachargesselect(idd) {

            var idval = document.getElementById(idd).value;

            $.ajax({
                type: 'GET',
                url: '{{ url('events-management/event-booking/calculateextracharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                        document.getElementById('charges_amount' + idd).value = obj;
                       
                        total = 0;
                        $('.charamt').each(function (index, element) {
                            total += parseFloat($(element).val());
                        });

                        document.getElementById('total_other_charges').value = total;

                        calculate_total();

                    }
                }
            });


        }


        function extrachargesselect2() {
            total = 0;
            $('.charamt').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            document.getElementById('total_other_charges').value = total;
            calculate_total();

        }


    </script>

     <script type="text/javascript">
        function calculate_total() {

            var room_charges = parseFloat(document.getElementById("total_food_charges").value);

            var extracharges = parseFloat(document.getElementById("total_other_charges").value);

            var discountamt = parseFloat(document.getElementById("discount_amount").value);

            var advance_paid = parseFloat(document.getElementById("advance_paid").value);

            var discountpct = parseFloat(document.getElementById("discount_percentage").value);

             var amount_paid = parseFloat(document.getElementById("amount_paid").value);

            if (Number.isNaN(extracharges)) {
                extracharges = 0;
            }

            
            if (Number.isNaN(discountamt)) {
                discountamt = 0;
            }

             if (Number.isNaN(discountpct)) {
                discountpct = 0;
            }

            if (Number.isNaN(advance_paid)) {
                advance_paid = 0;
            }


            if(Number.isNaN(amount_paid)){
                amount_paid=0;
              }

             var discount = discountpct / 100;
             var totalchargess = totalcharges + (totalcharges * discount);
            var roundeddiscount = Math.round(totalchargess);



if(discountamt==0){
  var finaldiscount = roundeddiscount;


            var result = room_charges + extracharges;

            document.getElementById("total_charges").value = result;


            var totalcharges = result - (result * discount);
            var roundeddiscount = Math.round(totalcharges);
            document.getElementById("grand_total").value = roundeddiscount;


            document.getElementById("total_balance").value = roundeddiscount - advance_paid;
            document.getElementById('amount_in_words').value = inWords(document.getElementById('total_balance').value);

            document.getElementById("grand_balance").value = (roundeddiscount-advance_paid)-(amount_paid);
}
else{
            var result = room_charges + extracharges;

            document.getElementById("total_charges").value = result;
            document.getElementById("grand_total").value = (result - discountamt);
            document.getElementById("total_balance").value = (result - discountamt) - advance_paid;
            document.getElementById('amount_in_words').value = inWords(document.getElementById('total_balance').value);

            document.getElementById("grand_balance").value = (result-discountamt)-(advance_paid)-(amount_paid);
}


        }
    </script>


    <script type="text/javascript">
        function resetchargesamount(id) {
            var ae = document.getElementById("complementary" + id).value;
            if (ae == 'false') {
                document.getElementById("complementary" + id + "dump").disabled = true;

                document.getElementById("complementary" + id).value = 'true';
                document.getElementById("charges_amount" + id).readOnly = true;
                var minusval = document.getElementById("charges_amount" + id).value;
                total = total - minusval;

                var element = document.getElementById("charges_amount" + id);
                element.classList.remove("charamt");
                document.getElementById('total_other_charges').value = total;
                calculate_total();
            }
            if (ae == 'true') {
                document.getElementById("complementary" + id + "dump").disabled = false;
                document.getElementById("complementary" + id).value = 'false';
                document.getElementById("charges_amount" + id).readOnly = true;

                var element = document.getElementById("charges_amount" + id);
                element.classList.add("charamt");
                var minusval = document.getElementById("charges_amount" + id).value;
                total = parseFloat(total) + parseFloat(minusval);
                document.getElementById('total_other_charges').value = total;
                calculate_total();
            }


        }
    </script>

    <script type="text/javascript">
        var i = 2;

        function addmorefields() {
            var html = '';

            html = `<tr>
    <td>
     <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect2();"></i></td>
     <td>
     <select id="${i}"  onchange="extrachargesselect(this.id)" class="form-control input-height select2" name="charges_type[]" >
                    <option label="Select a Charges Type"></option>
                     @foreach($charges_type as $chargestype)
            <option value="{{ $chargestype->id }}">
                                    {{ $chargestype->type }}
            </option>
@endforeach
            </select></td>
            <td>
           
                <input id="bill_details${i}" class="form-control input-height" type="text" name="bill_details[]" >
                  </td>
                  <td>
                 
                      <input id="charges_amount${i}" onkeyup="extrachargesselect2()" class="form-control input-height charamt" type="number" name="charges_amount[]">
                  </td>

                  <td>
                 
                     <input id="complementary${i}" type="checkbox" class="form-control input-height" name="complementary[]" onclick="resetchargesamount(${i})" value="false">
                     <input type="hidden" id="complementary${i}dump" type="checkbox" class="form-control input-height" name="complementary[]" value="false">
                           <label class="custom-control-label" for="Complementary?">Complementary?</label>
                  </td>
                     </tr>`;
            i++;
            $('#addmoreid').append(html);
        }

    </script>

    <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v = $('input[name="booking_type"]:checked').val();
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
                        document.getElementById('moc_address').value = obj.customer_address;
                        document.getElementById('moc_cnic').value = obj.customer_cnic;
                        document.getElementById('moc_mob').value = obj.customer_contact;
                        document.getElementById('moc_email').value = obj.customer_email;
                        document.getElementById('moc_name').value = obj.customer_name;
                        document.getElementById('customer_id').value = obj.id;
                        document.getElementById('member_id').value ='';
                        document.getElementById('member_code').value = '';
                        document.getElementById('ledger_amount').value=obj.balance;
                        $('#family').html('<option label="Choose Family Member">  </option>');
                    } else {
                        document.getElementById('moc_address').value = obj.cur_address;
                        document.getElementById('moc_cnic').value = obj.cnic;
                        document.getElementById('moc_mob').value = obj.mob_a;
                        document.getElementById('moc_email').value = obj.personal_email;
                        document.getElementById('moc_name').value = obj.applicant_name;
                        document.getElementById('member_id').value = obj.id;
                        document.getElementById('member_code').value = obj.mem_no;
                        document.getElementById('customer_id').value = '';
                        document.getElementById('ledger_amount').value=obj.balance;
         let selected="{{$init==1?$eventbooking->family:''}}";
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

        function customerdata(val) {
            let v = $('input[name="booking_type"]:checked').val();
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

                    // $('#areabox').html(data);

                }
            });
        }
    </script>
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

 
<link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" type="text/css"/>
<script src="{{ asset('/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}" type="text/javascript" charset="utf-8"></script>


    
<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>

        $(function () {
            $("#event_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false,
                startDate: '-2d'
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

    $('.timepicker').datetimepicker({
enableOnReadonly: false,
        format: 'HH:mm A'

    }); 

</script>


<script type="text/javascript">
    function extrachargesselect3(id) {

      if(!id){
        id=1;
      }
            total = 0;
            $('.event_item').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            document.getElementById('total').value = total;
        }

        </script>

<script type="text/javascript">
        var i = 2;

        function addmorefields3() {
            var html = '';

            html = `<tr>
<td></td>
            <td><i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect2(${i});"></i></td>
            <td>
             <select id="${i}" class="form-control input-height select2" name="item_name[]" >
                    <option label="Select Menu Category"></option>
                     @foreach($menu_category as $menucategory)
            <option value="{{ $menucategory->id }}">
                                    {{ $menucategory->desc }}
            </option>
@endforeach
            </select>
                  </td>
                  <td>
                      <input id="item_charges${i}" onkeyup="extrachargesselect2(${i})" class="form-control input-height event_item" type="number" name="item_charges[]">
                  </td>
                     </tr>`;
            i++;
            $('#addmoreidd').append(html);
            extrachargesselect3(i);
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

</script>
@endpush

