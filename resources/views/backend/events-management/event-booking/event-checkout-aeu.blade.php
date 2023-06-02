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
   .padtheicon{
  padding-top: 15px;
  cursor: pointer;
}

    </style>

       <div class="br-pagebody" style="color: black;">
        <div>
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Event Completion</h6>
             <div class="hidden-print" style="text-align: right; margin-top: -39px;">
                <a href>
                    <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

@if($checkout==1 && $init==1)
                <ul class="breadcrumbee mg-b-25 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('events-management') }}">Events Management</a></li>
                    <li><a href="{{ url('events-management/event-checkout-vue') }}">Event Completion List</a></li>
                    <li><a href>Edit Event Completion Details</a></li>
                </ul>
@else
 <ul class="breadcrumbee mg-b-25 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('events-management') }}">Events Management</a></li>
                    <li><a href="{{ url('events-management/event-booking-vue') }}">Event Booking List</a></li>
                    <li><a href>Add Event Completion Details</a></li>
                </ul>
@endif


 @if($errors->any())
<div id="error_msg" class=" alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
 

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
                
 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">Booking Type:<span
                                                            class="tx-danger">
                                *

                            </span>
                                                    </label>

 @if($init==1)   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if(old('booking_type',$eventbooking->booking_type)=='0') checked="" @else disabled @endif type="radio" name="booking_type" value="0"><span class="pabs">Member</span>
              </label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('booking_type',$eventbooking->booking_type)=='1') checked="" @else disabled @endif type="radio" name="booking_type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->

                                @else

        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('booking_type')=='0') checked="" @endif @endif type="radio" name="booking_type" value="0"><span class="pabs">Member</span></label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('booking_type')=='1') checked="" @endif type="radio" name="booking_type" value="1"><span class="pabs">Guest / Non-Member</span>
              </label>
            </div><!-- col-3 -->
                             @endif
 </div><!-- row-->

                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Member / Guest Name:
                                                      <span class="tx-danger">
                                                                      *
                                                                  </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                             <input @if($errors->has('moc_name')) style="border-color:red;"  @endif id="moc_name" class="form-control input-height typeahead" placeholder="Enter to Search" autocomplete="off" value="@if($init==0){{old('moc_name')}}@else{{old('moc_name',$eventbooking->moc_name)}}@endif"
                                                               type="text" name="moc_name" readonly style="background-color: #c1c1c1">

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

            style="border-color:red;" @endif id="family" class="form-control " name="family" style="background-color: #c1c1c1"> <option disabled label="Choose Family Member">  </option>
                    @foreach($familymembers as $fm)
         @if($init==1)
          <option
           @if(old('family',$eventbooking->family)==$fm->id)  selected @else disabled @endif  value="{{ $fm->id }}"> {{ $fm->name }} ({{ $fm->relationship_name->desc }})
                         </option>  @else
            <option
        @if(old('family')==$fm->id)  selected @endif value="{{ $fm->id }}">  {{ $fm->name }}
              </option>
                         @endif
                            @endforeach
                                                        </select>
                                                </div>

</div>

 <br> 
               <h6 class="box-title headingsettings"><b>EVENT DETAILS</b></h6>
               
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
                                                               placeholder="Enter Booking Reference"
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
                                                               placeholder="Enter Details"
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
                                                            autocomplete="off" type="text" placeholder="dd/mm/yyyy"
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
                                                            autocomplete="off" type="text" placeholder="hh:mm AM/PM"
                                                            value="@if($init==0){{old('from')}}@else{{old('from',$eventbooking->from)}}@endif" name="from">
                                                    </div>
                                                    <script>
  $(document).ready(function(){
      $('#from').on('dp.change',function(){
          let time=$('#event_date').val()+' '+$(this).val();
          $.get('{{route('fetch.venue')}}?time='+time,function(x){
              x='<option label="Choose Venue"></option>'+x;
              $('select[name="venue"]').html(x);
              $('select[name="venue"]').removeAttr('disabled');

          })
      })

  })
</script>

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
                                                            autocomplete="off" type="text" placeholder="hh:mm AM/PM"
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
                                                                @endif id="venue"
                                                                class="form-control "
                                                                name="venue" @if($init!=1) disabled="disabled" @endif>
                                                            <option label="Choose Venue">
                                                            </option>
                                                            @foreach($venue as $venues)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('venue',$eventbooking->venue)==$venues->id)  selected
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
                                                                class="form-control  "
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

              
                 <div class="row mg-t-10">
<div class="col-sm-1"></div>
<div class="col-sm-11 mg-t-10 mg-sm-t-0">
        <table id="menutable" align="center" border="0" width="100%">
              <tbody>
           <tr>
             <td width="10%" align="left">&nbsp</td>
            <td width="7%" align="left">&nbsp</td>
                                                        <td width="70%" align="left">Item Name<span class="tx-danger">*</span></td>
                                                       
                                                    </tr>
                                                    <tbody>
                 <tbody id="addmoreidd">

                 @if($init==1)
                  @foreach($eventsubdata as $sub)
                          <tr>
<td>&nbsp</td>
                             <td>
                        <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); menuchargesselect3(this.id);"></i>
                            </td>

                            <td>
                              <select id="{{ $sub->id }}" class="form-control  " name="item_name[]">
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

                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                          <td>&nbsp</td>
                                                           <td>&nbsp</td>
                                      <td>
                                        <select id="1" class="form-control  " name="item_name[]">
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

                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>

</div></div>
                                              
                                                 

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
                                                  Menu Charges:
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
                                                <br> 
        <h6 class="box-title headingsettings"><b>MENU ADD-ONS</b></h6>
                 
 <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                      <td width="5%" align="left">&nbsp</td>
                                                        <td width="40%" align="left">Item Name</td>
                                                        <td width="20%" align="left">Bill Details</td>
                                                        <td width="20%" align="left">Item Charges</td>
                                                        <td width="15%" align="left">&nbsp;</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreiddd">

                                                    @if($init==1)
                                                        @foreach($menuaddons as $menuaddon)
                                                            <tr>
                     <td>
                       <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); menuaddonselect2(this.id);"></i>
                            </td>
                                                                <td><select id="{{ $menuaddon->id }}"
                                                                            onchange="menuAddOnselect(this.id)"
                                                                            class="form-control  "
                                                                            name="add_on_name[]">
                                                                        <option label="Choose Add On"></option>
                                                                        @foreach($add_on as $addon)

                                                                            @if($init==1)
                                                                                <option
                                                                                    @if(old('add_on_name[]',$menuaddon->add_on_name)==$addon->id)  selected
                                                                                    @endif value="{{ $addon->id }}">
                                                                                    {{ $addon->desc }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    @if(old('add_on_name[]')==$addon->id)  selected
                                                                                    @endif value="{{ $addon->id }}">
                                                                                    {{ $addon->desc }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select></td>
                                                                <td>
                                                                    <input id="addon_bill_details{{ $menuaddon->id }}"
                                                                           class="form-control " type="text"
                                                                           name="addon_bill_details[]"
                                                                           value="@if($init==0){{old('addon_bill_details[]')}}@else{{old('addon_bill_details[]',$menuaddon->addon_bill_details)}}@endif">
                                                                </td>
                                                                <td>
                                                                    <input id="add_on_charges{{ $menuaddon->id }}"
                                                                           onkeyup="menuaddonselect2()"
                                                                           class="form-control  @if($menuaddon->addoncomplementary=='true') @else addonamt  @endif "
                                                                           type="number" name="add_on_charges[]"
                                                                           value="@if($init==0){{old('add_on_charges[]')}}@else{{old('add_on_charges[]',$menuaddon->add_on_charges)}}@endif"
                                                                           @if($menuaddon->addoncomplementary=='true') readonly="" @endif>
                                                                </td>
                                                                <td>
                                                             <input id="complementarytwo{{ $menuaddon->id }}" type="checkbox"
                                                   class="form-control input-height" name="complementarytwo[]" onclick="resetaddoncharges({{ $menuaddon->id }})" @if($menuaddon->addoncomplementary=='true') checked=""
                                                                           @endif value="false">
               <input type="hidden" id="complementarytwo{{ $menuaddon->id }}dump"  type="checkbox"  class="form-control input-height" name="complementarytwo[]">
                  <label class="custom-control-label" for="Complementary?">Complementary?</label>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                          <td>&nbsp</td>
                                                            <td><select id="1" onchange="menuAddOnselect(this.id)"
                                                                        class="form-control "
                                                                        name="add_on_name[]">
                                                                    <option label="Choose Add On"></option>
                                                                    @foreach($add_on as $addon)


                                                                <option
                                                               @if(old('add_on_name[]')==$addon->id)  selected
                                                                            @endif value="{{ $addon->id }}">
                                                                            {{ $addon->desc }}
                                                                        </option>

                                                                    @endforeach
                                                                </select></td>
                                                            <td>
                                                                <input id="addon_bill_details1"
                                                                       class="form-control " type="text"
                                                                       name="addon_bill_details[]"
                                                                       value="@if($init==0){{old('addon_bill_details[]')}}@else{{old('addon_bill_details[]',$menuaddon->addon_bill_details)}}@endif">
                                                            </td>
                                                            <td>
                                                                <input id="add_on_charges1"
                                                                       onkeyup="menuaddonselect2()"
                                                                       class="form-control addonamt"
                                                                       type="number" name="add_on_charges[]"
                                                                       value="@if($init==0){{old('add_on_charges[]')}}@else{{old('add_on_charges[]',$menuaddon->add_on_charges)}}@endif">
                                                            </td>
                                                            <td>
                                                                <input id="complementarytwo1" type="checkbox"
                                                                       class="form-control input-height"
                                                                       name="complementarytwo[]"
                                                                       onclick="resetaddoncharges(1)" value="false">

                                                                <input type="hidden" id="complementarytwo1dump"
                                                                       type="checkbox" class="form-control input-height"
                                                                       name="complementarytwo[]" value="false">
                                                                <label class="custom-control-label"
                                                                       for="Complementary?">Complementary?</label>
                                                            </td>
                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>


                                                <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer  ">
                                                        <input onclick="addmorefields4()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>
                              
<br>
<div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                    Menu Add-On Charges:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_addon_charges')) style="border-color:red;"
                                                               @endif id="total_addon_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_addon_charges')}}@else{{old('total_addon_charges',$eventbooking->total_addon_charges)}}@endif" name="total_addon_charges">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                    Total Per Person Menu Charges:
                                                     <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_per_person_charges')) style="border-color:red;"
                                                               @endif id="total_per_person_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_per_person_charges')}}@else{{old('total_per_person_charges',$eventbooking->total_per_person_charges)}}@endif" name="total_per_person_charges">

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
                                                               @endif id="guests" placeholder="Enter Total Number of Guests" class="form-control input-height" readonly style="background-color: #c1c1c1" autocomplete="off" oninput="chargesselect()"
                                                               value="@if($init==0){{old('guests')}}@else{{old('guests',$eventbooking->guests)}}@endif" name="guests">

                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                      Guest Charges:
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
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Extra Guests:
                                                        
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('extra_guests')) style="border-color:red;"
                                                               @endif id="extra_guests" placeholder="Enter Total Number of Extra Guests" class="form-control input-height" autocomplete="off" oninput="extra_guestcharges()"
                                                               value="@if($init==0){{old('extra_guests')}}@else{{old('extra_guests',$eventbooking->extra_guests)}}@endif" name="extra_guests">

                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Extra Guest Charges:
                                                       
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('extra_food_charges')) style="border-color:red;"
                                                               @endif id="extra_food_charges" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('extra_food_charges')}}@else{{old('extra_food_charges',$eventbooking->extra_food_charges)}}@endif"
                                                               name="extra_food_charges">

                                                    </div>
                                                </div>

                                                 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                       Total Food Charges:<span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('grand_guest_charges')) style="border-color:red;"
                                                               @endif id="grand_guest_charges" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('grand_guest_charges')}}@else{{old('grand_guest_charges',$eventbooking->grand_guest_charges)}}@endif" name="grand_guest_charges">

                                                    </div>
                                                </div>


<br> 
        <h6 class="box-title headingsettings"><b>OTHER CHARGES</b></h6>
            
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
                                                                            class="form-control  "
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
                                                                           class="form-control " type="text"
                                                                           name="bill_details[]"
                                                                           value="@if($init==0){{old('bill_details[]')}}@else{{old('bill_details[]',$bookingsub->bill_details)}}@endif">
                                                                </td>
                                                                <td>

                                                                    <input id="charges_amount{{ $bookingsub->id }}"
                                                                           onkeyup="extrachargesselect2()"
                                                                           class="form-control  @if($bookingsub->iscomplementary=='true') @else charamt  @endif "
                                                                           type="number" name="charges_amount[]"
                                                                           value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$bookingsub->charges_amount)}}@endif"
                                                                           @if($bookingsub->iscomplementary=='true') readonly="" @endif>
                                                                </td>
                                                                <td>
                                                             <input id="complementary{{ $bookingsub->id }}" type="checkbox"
                                                   class="form-control input-height" name="complementary[]" onclick="resetchargesamount({{ $bookingsub->id }})" @if($bookingsub->iscomplementary=='true') checked=""
                                                                           @endif value="false">
               <input type="hidden" id="complementary{{$bookingsub->id}}dump"  type="checkbox"  class="form-control input-height" name="complementary[]"  value="false">
                  <label class="custom-control-label" for="Complementary?">Complementary?</label>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                          <td>&nbsp</td>
                                                            <td><select id="1" onchange="extrachargesselect(this.id)"
                                                                        class="form-control  "
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
                                                                       class="form-control  " type="text"
                                                                       name="bill_details[]"
                                                                       value="@if($init==0){{old('bill_details[]')}}@else{{old('bill_details[]',$bookingsub->bill_details)}}@endif">
                                                            </td>
                                                            <td>
                                                                <input id="charges_amount1"
                                                                       onkeyup="extrachargesselect2()"
                                                                       class="form-control  charamt"
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
                                                    <div class="form-layout-footer">
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
                                                        Surcharge:

                                                    </label>
                                                    <div class="col-sm-3 mg-t-5 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('surcharge')) style="border-color:red;"
                                                               @endif id="surcharge"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount" autocomplete="off"
                                                               value="@if($init==0){{old('surcharge')}}@else{{old('surcharge',$eventbooking->surcharge)}}@endif" name="surcharge" oninput="calculate_total()">

                                                    </div>
                                                     <label class="col-sm-1 form-control-label" style="color: black;">
                                                    Pct:
                                                    </label>
                                                    <div class="col-sm-2 mg-t-4 mg-sm-t-0 pc">
                                                        <input type="number"
                                                               @if ($errors->has('surcharge_percentage')) style="border-color:red;"
                                                               @endif id="surcharge_percentage"
                                                               class="form-control input-height" autocomplete="off"
                                                               value="@if($init==0){{old('surcharge_percentage')}}@else{{old('surcharge_percentage',$eventbooking->surcharge_percentage)}}@endif" name="surcharge_percentage" oninput="calculate_total()">

                                                    </div>
                                                  
                                                      <div class=" col-sm-1 padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="surchargeDetails()"></i></div>
                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="surcharge_div">
                                                        <textarea
                                                            @if ($errors->has('surcharge_details')) style="border-color:red;"
                                                            @endif id="surcharge_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="surcharge_details">@if($init==0){{old('surcharge_details')}}@else{{old('surcharge_details',$eventbooking->surcharge_details)}}@endif</textarea>
                                                    </div>
                                                  </div>

                                               <!--    
                                                 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Balance:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('surcharge_total')) style="border-color:red;"
                                                               @endif id="surcharge_total"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               onclick="calculate_total()"
                                                               value="@if($init==0){{old('surcharge_total')}}@else{{old('surcharge_total',$eventbooking->surcharge_total)}}@endif" name="surcharge_total">

                                                    </div>
                                                </div> -->

                                            <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label" style="color: black;">
                                                        Reduction:

                                                    </label>
                                                    <div class="col-sm-3 mg-t-5 mg-sm-t-0">
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
                                                    <div class="col-sm-2 mg-t-4 mg-sm-t-0 pc">
                                                        <input type="number"
                                                               @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height" autocomplete="off"
                                                               value="@if($init==0){{old('discount_percentage')}}@else{{old('discount_percentage',$eventbooking->discount_percentage)}}@endif" name="discount_percentage" oninput="calculate_total()">

                                                    </div>
                                                     
                                                     <div class=" col-sm-1  padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="reductionDetails()"></i></div>
                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="reduction_div">
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
                                                               @endif id="grand_total"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               onclick="calculate_total()"
                                                               value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$eventbooking->grand_total)}}@endif" name="grand_total">

                                                    </div>
                                                </div>
      <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                         Amount in Words:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                            <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$eventbooking->amount_in_words)}}@endif" placeholder="Enter Total Amount to be Paid">
                                                    </div>
                                                </div>
               <!--   <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                      Amount Paid:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if ($errors->has('amount_paid')) style="border-color:red;" @endif id="amount_paid" class="form-control input-height" name="amount_paid" value="@if($init==0){{old('amount_paid')}}@else{{old('amount_paid',$eventbooking->amount_paid)}}@endif" oninput="calculate_total()" readonly style="background-color: #c1c1c1" autocomplete="off">

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
                            <input type="number" @if ($errors->has('grand_balance')) style="border-color:red;" @endif id="grand_balance" class="form-control input-height" value="@if($init==0){{old('grand_balance')}}@else{{old('grand_balance',$eventbooking->grand_balance)}}@endif" readonly style="background-color: #c1c1c1" name="grand_balance">

                        </div>
                    </div> -->



                <!--   <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label" style="color: black;">
                                                        Reduction:

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
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height" autocomplete="off"
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
                                                               class="form-control input-height"
                                                               placeholder="Enter Advance (if paid)"  autocomplete="off"
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
                                            <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$eventbooking->amount_in_words)}}@endif" placeholder="Enter Total Amount to be Paid">
                                                    </div>
                                                </div> -->

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
<br><br> 
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
                                                            <a href="{{ url('events-management/event-checkout-vue') }}"
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
                                                            <a href="{{ url('events-management/event-booking-vue') }}"
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
$('#addmoreidd').html('');
            var idval = document.getElementById(idd).value;

            $.ajax({
                type: 'GET',
                url: '{{ url('events-management/event-booking/calculatemenucharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    var obj = data;
                    if (obj) {
                        console.log(obj);
                        $.each(obj['menus'],function(x,y){
                            addmorefields3(y.item_name,y.item_charges)
                        })
                        document.getElementById('menu_charges').value = obj.total;

            var addoncharges = parseFloat(document.getElementById("total_addon_charges").value);

            if (Number.isNaN(addoncharges)) {
                addoncharges = 0;
            }

            var addtheaddon = parseFloat(obj.total);

            var addtheaddonfinal = addtheaddon + addoncharges;

                        document.getElementById('total_per_person_charges').value = addtheaddonfinal;
                    }
                }
            });
        }

    </script>

    <script type="text/javascript">
       function chargesselect() {
                            var myBoxone = parseFloat(document.getElementById("total_per_person_charges").value);
                            var myBoxtwo = parseFloat(document.getElementById("guests").value);


                     if(Number.isNaN(myBoxone)){
                    myBoxone=0;
                  }

                  if(Number.isNaN(myBoxtwo)){
                    myBoxtwo=0;
                  }
                    var result = myBoxone * myBoxtwo;

                     document.getElementById("total_food_charges").value = result;

                   var goreverse = parseFloat(document.getElementById("extra_food_charges").value);
                   if(Number.isNaN(goreverse)){
                    goreverse=0;
                  }

                             document.getElementById("grand_guest_charges").value = result + goreverse;
                           
                            document.getElementById("total_charges").value = result;
                          //  document.getElementById("surcharge_total").value = result;
                            document.getElementById("grand_total").value = result;
                         //   document.getElementById("grand_balance").value = result;
                             document.getElementById('amount_in_words').value = inWords(result);
                          
                }
    </script>


     <script type="text/javascript">
       function extra_guestcharges() {
                            var myBoxone = parseFloat(document.getElementById("total_per_person_charges").value);
                            var myBoxtwo = parseFloat(document.getElementById("extra_guests").value);
                            var myBoxThree = parseFloat(document.getElementById("total_food_charges").value);


                     if(Number.isNaN(myBoxone)){
                    myBoxone=0;
                  }

                  if(Number.isNaN(myBoxtwo)){
                    myBoxtwo=0;
                  }

                  if(Number.isNaN(myBoxThree)){
                    myBoxThree=0;
                  }

                    var result = myBoxone * myBoxtwo;


                            document.getElementById("extra_food_charges").value = result;

                            var afterresult = result + myBoxThree;

                             document.getElementById("grand_guest_charges").value = afterresult;



                            document.getElementById("total_charges").value = afterresult;
                           // document.getElementById("surcharge_total").value = afterresult;
                            document.getElementById("grand_total").value = afterresult;
                          //  document.getElementById("grand_balance").value = afterresult;
                            document.getElementById('amount_in_words').value = inWords(afterresult);
                            
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

        function menuAddOnselect(idd) {

            var idval = document.getElementById(idd).value;

            $.ajax({
                type: 'GET',
                url: '{{ url('events-management/event-booking/calculateaddoncharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                        document.getElementById('add_on_charges' + idd).value = obj;

                        total = 0;
                        $('.addonamt').each(function (index, element) {
                            total += parseFloat($(element).val());
                        });

                        document.getElementById('total_addon_charges').value = total;
                       var addoncharges = parseInt(document.getElementById('total_addon_charges').value);
                       var menu= parseInt(document.getElementById('menu_charges').value);
                        var grand = addoncharges+menu;
                        document.getElementById('total_per_person_charges').value = grand;
                    }
                }
            });


        }


        function menuaddonselect2() {
            total = 0;
            $('.addonamt').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            document.getElementById('total_addon_charges').value = total;
             var addoncharges = parseInt(document.getElementById('total_addon_charges').value);
                       var menu= parseInt(document.getElementById('menu_charges').value);
                        var grand = addoncharges+menu;
                        document.getElementById('total_per_person_charges').value = grand;
            

        }


    </script>

     <script type="text/javascript">
        function calculate_total() {

            var grand_charges = parseFloat(document.getElementById("grand_guest_charges").value);

            var extracharges = parseFloat(document.getElementById("total_other_charges").value);

            var surchargeamt = parseFloat(document.getElementById("surcharge").value);

             var surchargepct = parseFloat(document.getElementById("surcharge_percentage").value);

             var discountamt = parseFloat(document.getElementById("discount_amount").value);

           //    var amtpaid = parseFloat(document.getElementById("amount_paid").value);

             var discountpct = parseFloat(document.getElementById("discount_percentage").value);

            if (Number.isNaN(extracharges)) {
                extracharges = 0;
            }

            if (Number.isNaN(grand_charges)) {
                grand_charges = 0;
            }

            if (Number.isNaN(discountamt)) {
                discountamt = 0;
            }

          /*  if (Number.isNaN(amtpaid)) {
                amtpaid = 0;
            }*/

             if (Number.isNaN(discountpct)) {
                discountpct = 0;
            }

             if (Number.isNaN(surchargeamt)) {
                surchargeamt = 0;
            }

             if (Number.isNaN(surchargepct)) {
                surchargepct = 0;
            }

            var discount = discountpct / 100;
            var srch = surchargepct / 100;


      var result = grand_charges + extracharges;

            document.getElementById("total_charges").value = result;

            if(surchargeamt==0){
              var totalsur = result + (result * srch);
              var roundedsur = Math.round(totalsur);
        //   document.getElementById("surcharge_total").value = roundedsur;
         

         if(discountpct==0){
              document.getElementById("grand_total").value = (roundedsur - discountamt);
         //     document.getElementById("grand_balance").value = (roundedsur - discountamt) - (amtpaid);
            }
            else
            {
               var totalcharges = roundedsur - (roundedsur * discount);
            var roundeddiscount = Math.round(totalcharges);
            document.getElementById("grand_total").value = roundeddiscount;
          //  document.getElementById("grand_balance").value = (roundeddiscount) - (amtpaid);

            }
              
             document.getElementById('amount_in_words').value = inWords(document.getElementById('grand_total').value);
            }
            else
            {
           //  document.getElementById("surcharge_total").value = (result + surchargeamt);


              if(discountpct==0){
              document.getElementById("grand_total").value = (result + surchargeamt) - (discountamt);
          //    document.getElementById("grand_balance").value = (result + surchargeamt) - (discountamt) - (amtpaid);
            }
            else
            {
               var totalcharges = (result + surchargeamt) - (result + surchargeamt) * (discount);
            var roundeddiscount = Math.round(totalcharges);
            document.getElementById("grand_total").value = roundeddiscount;
       //   document.getElementById("grand_balance").value = (roundeddiscount) - (amtpaid);
            }

              
              document.getElementById('amount_in_words').value = inWords(document.getElementById('grand_total').value);
             
            }

             
  }
          
    </script>

      <script type="text/javascript">
        function OLD_calculate_total() {

            var room_charges = parseFloat(document.getElementById("total_food_charges").value);

             var extra_food = parseFloat(document.getElementById("extra_food_charges").value);

            var extracharges = parseFloat(document.getElementById("total_other_charges").value);

            var discountamt = parseFloat(document.getElementById("discount_amount").value);

            var advance_paid = parseFloat(document.getElementById("advance_paid").value);

            var discountpct = parseFloat(document.getElementById("discount_percentage").value);

            if (Number.isNaN(extracharges)) {
                extracharges = 0;
            }

            if (Number.isNaN(extra_food)) {
                extra_food = 0;
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


             var discount = discountpct / 100;
             var totalchargess = totalcharges + (totalcharges * discount);
            var roundeddiscount = Math.round(totalchargess);



if(discountamt==0){
  var finaldiscount = roundeddiscount;

  if(extra_food==0)
            var result = room_charges + extracharges;
          else{
             var result = extra_food + extracharges;
          }

            document.getElementById("total_charges").value = result;


            var totalcharges = result - (result * discount);
            var roundeddiscount = Math.round(totalcharges);
            document.getElementById("grand_total").value = roundeddiscount;


            document.getElementById("total_balance").value = roundeddiscount - advance_paid;

            document.getElementById('amount_in_words').value = inWords(document.getElementById('total_balance').value);
}
else{
             if(extra_food==0)
            var result = room_charges + extracharges;
          else{
             var result = extra_food + extracharges;
          }

            document.getElementById("total_charges").value = result;
            document.getElementById("grand_total").value = (result - discountamt);
            document.getElementById("total_balance").value = (result - discountamt) - advance_paid;
            document.getElementById('amount_in_words').value = inWords(document.getElementById('total_balance').value);
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
                 document.getElementById("bill_details" + id).value = "Complementary";
                 document.getElementById("bill_details" + id).readOnly = true;

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
                document.getElementById("charges_amount" + id).readOnly = false;
                 document.getElementById("bill_details" + id).value = '';
                document.getElementById("bill_details" + id).readOnly = false;

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
        function resetaddoncharges(id) {
            var ae = document.getElementById("complementarytwo" + id).value;
            if (ae == 'false') {
                document.getElementById("complementarytwo" + id + "dump").disabled = true;

                document.getElementById("complementarytwo" + id).value = 'true';
                document.getElementById("add_on_charges" + id).readOnly = true;
                 document.getElementById("addon_bill_details" + id).value = "Complementary";
                 document.getElementById("addon_bill_details" + id).readOnly = true;

                var minusval = document.getElementById("add_on_charges" + id).value;
                total = total - minusval;

                var element = document.getElementById("add_on_charges" + id);
                element.classList.remove("addonamt");
                document.getElementById('total_addon_charges').value = total;

                       var menu= parseInt(document.getElementById('menu_charges').value);
                        var grand = total+menu;
                        document.getElementById('total_per_person_charges').value = grand;

            }
            if (ae == 'true') {
                document.getElementById("complementarytwo" + id + "dump").disabled = false;
                document.getElementById("complementarytwo" + id).value = 'false';
                document.getElementById("add_on_charges" + id).readOnly = false;
                document.getElementById("addon_bill_details" + id).value = '';
                document.getElementById("addon_bill_details" + id).readOnly = false;

                var element = document.getElementById("add_on_charges" + id);
                element.classList.add("addonamt");
                var minusval = document.getElementById("add_on_charges" + id).value;
                total = parseFloat(total) + parseFloat(minusval);
                document.getElementById('total_addon_charges').value = total;
                
                       var menu= parseInt(document.getElementById('menu_charges').value);
                        var grand = total+menu;
                        document.getElementById('total_per_person_charges').value = grand;
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
     <select id="${i}"  onchange="extrachargesselect(this.id)" class="form-control  " name="charges_type[]" >
                    <option label="Select a Charges Type"></option>
                     @foreach($charges_type as $chargestype)
            <option value="{{ $chargestype->id }}">
                                    {{ $chargestype->type }}
            </option>
@endforeach
            </select></td>
            <td>

                <input id="bill_details${i}" class="form-control " type="text" name="bill_details[]" >
                  </td>
                  <td>

                      <input id="charges_amount${i}" onkeyup="extrachargesselect2()" class="form-control charamt" type="number" name="charges_amount[]">
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
        var i = 2;

        function addmorefields4() {
            var html = '';

            html = `
            <tr>
    <td>
     <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); menuaddonselect2();"></i></td>
     <td>
     <select id="${i}"  onchange="menuAddOnselect(this.id)" class="form-control " name="add_on_name[]" >
                    <option label="Choose Add On"></option>
                     @foreach($add_on as $addon)
            <option value="{{ $addon->id }}">
                                    {{ $addon->desc }}
            </option>
@endforeach
            </select></td>
             <td>

                <input id="addon_bill_details${i}" class="form-control" type="text" name="addon_bill_details[]" >
                  </td>

                  <td>

                      <input id="add_on_charges${i}" onkeyup="menuaddonselect2()" class="form-control addonamt" type="number" name="add_on_charges[]">
                  </td>

                   <td>

                     <input id="complementarytwo${i}" type="checkbox" class="form-control input-height" name="complementarytwo[]" onclick="resetaddoncharges(${i})" value="false">
                     <input type="hidden" id="complementarytwo${i}dump" type="checkbox" class="form-control input-height" name="complementarytwo[]" value="false">
                           <label class="custom-control-label" for="Complementary?">Complementary?</label>
                  </td>

                     </tr>`;
            i++;
            $('#addmoreiddd').append(html);
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

                          $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                        document.getElementById('moc_name').value = $fname+$mname+$lname;

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

                       $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                        let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);


                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>


  <script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

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
                startDate: new Date(),
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

        format: 'HH:mm A'

    });

</script>


<script type="text/javascript">
    function menuchargesselect3(id) {

      if(!id){
        id=1;
      }
            total = 0;
            $('.event_item').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            $('#total').val(total);
        }

        </script>

<script type="text/javascript">
        var i = 2;

        function addmorefields3(type, charges) {
            if(type==undefined){
                type='';
            }
            if(charges==undefined){
                charges='';
            }

            var html = '';

            html = `<tr>
<td></td>
            <td><i class="fa fa-trash" onclick="$(this).parents('tr').remove(); menuchargesselect3(${i});"></i></td>
            <td>
             <select id="${i}" class="form-control  " name="item_name[]" >
                    <option label="Select Menu Category"></option>
                     @foreach($menu_category as $menucategory)
            <option `+(type=={{ $menucategory->id }}?"selected=selected":"")+` value="{{ $menucategory->id }}">
                                    {{ $menucategory->desc }}
            </option>
@endforeach
            </select>
                  </td>
                     </tr>`;
            i++;
            $('#addmoreidd').append(html);
            menuchargesselect3(i);
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

<script>
$(document).ready(function(){

    $("#surcharge_div").hide();
    $("#reduction_div").hide();

});
</script>

<script type="text/javascript">
  function reductionDetails() {
  var x = document.getElementById("reduction_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}



  function surchargeDetails() {
  var x = document.getElementById("surcharge_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
@endpush