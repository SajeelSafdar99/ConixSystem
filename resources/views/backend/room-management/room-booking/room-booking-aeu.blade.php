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

 .form-control-label{
        color:black !important;
      }
    </style>

    <div class="br-pagebody">
        <div>

            @if($init==1 && $checkinedit==0)
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Booking</h6>
            @elseif($init==1 && $checkinedit==1)
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Check In</h6>
            @else
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Booking</h6>
            @endif

             <div class="hidden-print" style="text-align: right; margin-top: -39px;">
                <a href>
                    <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>


            @if($init==1 && $checkinedit==0)

                <ul class="breadcrumbee mg-b-25 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
                    <li><a href="{{ url('room-management/room-booking-vue') }}">Room Booking List</a></li>
                    <li><a href>Edit Room Booking</a></li>
                </ul>

            @elseif($init==1 && $checkinedit==1)
                <ul class="breadcrumbee mg-b-25 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
                    <li><a href="{{ url('room-management/room-check-in') }}">Rooms Check In List</a></li>
                    <li><a href>Edit Room Check In</a></li>
                </ul>
            @else
                <ul class="breadcrumbee mg-b-25 border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
                    <li><a href="{{ url('room-management/room-booking-vue') }}">Room Booking List</a></li>
                    <li><a href>Add Room Booking</a></li>
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


                @if($init==1 && $checkinedit==0)
                    <form method="post" enctype="multipart/form-data"
                          action="{{ url('room-management/room-booking/update/') }}/{{ $room_booking_update->id }}">
                        @elseif($init==1 && $checkinedit==1)
                            <form method="post" enctype="multipart/form-data"
                                  action="{{ url('room-management/roomcheckin/update/') }}/{{ $room_booking_update->id }}">
                                @else
                                    <form method="post" enctype="multipart/form-data">
                                        @endif
                                        @csrf

                                        <div class="form-layout form-layout-4 ">

                  <div class="row">
               <div class="col-sm-6">
<div class="row mg-t-10">

        <label class="col-sm-3 form-control-label">  Booking No.:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-9 mg-t-10 mg-sm-t-0">
    <input id="booking_no" class="form-control input-height" type="number" readonly value="@if($init==0){{$increment_number}}@else{{old('booking_no', $room_booking_update->booking_no)}}@endif"
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
              <input  @if ($errors->has('booking_date')) style="border-color:red;" @endif id="booking_date" class="form-control input-height" type="text" value="@if($init==0)<?php echo $today;?>@else{{old('booking_date',formatDateToShow($room_booking_update->booking_date))}}@endif" name="booking_date" readonly style="background-color: #c1c1c1">

                                                    </div>

                                                </div>
                                                <!-- row -->
    <br>
               <h6 class="box-title headingsettings"><b>GUEST BILL TO</b></h6>
            
 <div class="row mg-t-10">
                                                    <label class="col-sm-1 form-control-label">Booking Type:<span
                                                            class="tx-danger">
                                *

                            </span>
                                                    </label>

 @if($init==1)   <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('booking_type',$room_booking_update->booking_type)=='0') checked="" @endif @endif type="radio" name="booking_type" value="0"><span class="pabs">Member</span>
              </label>
            </div><!-- col-3 -->
             <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('booking_type',$room_booking_update->booking_type)=='6') checked="" @endif @endif type="radio" name="booking_type" value="6"><span class="pabs">Corporate Member</span>
              </label>
            </div><!-- col-3 -->
               @foreach($gts as $gt)
                                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
            
                <label class="rdiobox">
    <input @if(old('booking_type',customertype($room_booking_update->customer_id))==$gt->id) checked="" @endif type="radio" name="booking_type" value="{{10+$gt->id}}" data-errormessage-value-missing="Guest Type is Required !" class="validate[required]"><span class="pabs">{{$gt->desc}}</span>
              </label>
            
            </div><!-- col-3 -->
              @endforeach

                                @else

        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('booking_type')=='0') checked="" @endif @endif type="radio" name="booking_type" value="0"><span class="pabs">Member</span></label>
            </div><!-- col-3 -->

              <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0)   @else @if(old('booking_type')=='6') checked="" @endif @endif type="radio" name="booking_type" value="6"><span class="pabs">Corporate Member</span></label>
            </div><!-- col-3 -->
            @foreach($gts as $gt)
                                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
         
                <label class="rdiobox">
    <input @if(old('booking_type')==10+$gt->id) checked="" @endif type="radio" name="booking_type" value="{{10+$gt->id}}" data-errormessage-value-missing="Guest Type is Required !" class="validate[required]"><span class="pabs">{{$gt->desc}}</span>
              </label>
               
            </div><!-- col-3 -->
             @endforeach
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
                             <input @if($errors->has('moc_name')) style="border-color:red;"  @endif id="moc_name" class="form-control input-height typeahead" placeholder="Enter to Search" autocomplete="off" value="@if($init==0){{old('moc_name')}}@else{{old('moc_name',$room_booking_update->moc_name)}}@endif"
                                                               type="text" name="moc_name"
                                                               onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

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
                                                        Member #:
                                                        <!-- <span class="tx-danger">
                                                                         *
                                                                     </span> -->
                                                    </label>
                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_code" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_code')}}@else{{old('member_code',$room_booking_update->member?$room_booking_update->member->mem_no:'') }}@endif"
                                                               type="text" name="member_code">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_id')}}@else{{old('member_id',$room_booking_update->member_id)}}@endif"
                                                               type="hidden" name="member_id">

                                                    </div>
                                                     <label class="col-sm-1 form-control-label">
                                                        Corporate Mem #:
                                                        <!-- <span class="tx-danger">
                                                                         *
                                                                     </span> -->
                                                    </label>
                                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                                       <input @if ($errors->has('corporate_id')) style="border-color:red;"
                                                               @endif id="corporate_code" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('corporate_code')}}@else{{old('corporate_code',$room_booking_update->corporateMember?$room_booking_update->corporateMember->mem_no:'') }}@endif"
                                                               type="text" name="corporate_code">
                                                        <input @if ($errors->has('corporate_id')) style="border-color:red;"
                                                               @endif id="corporate_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('corporate_id')}}@else{{old('corporate_id',$room_booking_update->corporate_id)}}@endif"
                                                               type="hidden" name="corporate_id">

                                                    </div>
                                                    <label class="col-sm-1 form-control-label">
                                                        Guest No.:
                                                        <!-- <span class="tx-danger">
                                                                         *
                                                                     </span> -->
                                                    </label>
                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('customer_id')) style="border-color:red;"
                                                            @endif id="customer_id" class="form-control input-height"
                                                            readonly style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$room_booking_update->customer_id)}}@endif"
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
                                                            value="@if($init==0){{old('moc_address')}}@else{{old('moc_address',$room_booking_update->moc_address)}}@endif"
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
                                                               value="@if($init==0){{old('moc_cnic')}}@else{{old('moc_cnic',$room_booking_update->moc_cnic)}}@endif"
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
                                                               value="@if($init==0){{old('moc_mob')}}@else{{old('moc_mob',$room_booking_update->moc_mob)}}@endif"
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
                                                               value="@if($init==0){{old('moc_email')}}@else{{old('moc_email',$room_booking_update->moc_email)}}@endif"
                                                               type="text" name="moc_email">

                                                    </div>
                                                </div>
<div class="row mg-t-10">
      <label class="col-sm-3 form-control-label">
         Ledger Amount:     <span class="tx-danger"> </span> &nbsp &nbsp &nbsp &nbsp &nbsp
<a href="{{ url('finance-and-management/finance-ledger-accounts') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a> </label>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$room_booking_update->ledger_amount)}}@endif">
</div>
</div>

                        <div class="row mg-t-10">
                 <label class="col-sm-3 form-control-label">
                         Family Member:
                                                    </label>
                                                      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
          <select onchange="relationship(this.id)" @if ($errors->has('family')) id="{{ $familymembers->id }}"

            style="border-color:red;" @endif id="family" class="form-control " name="family"> <option label="Choose Family Member">  </option>
                    @foreach($familymembers as $fm)
         @if($init==1)
          <option
           @if(old('family',$room_booking_update->family)==$fm->id)  selected  @endif  value="{{ $fm->id }}"> {{ $fm->name }} ({{ $fm->relationship_name->desc }})
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
               <h6 class="box-title headingsettings"><b>OCCUPIED GUEST INFORMATION</b></h6>
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
                                                               value="@if($init==0){{old('booked_by')}}@else{{old('booked_by',$room_booking_update->booked_by)}}@endif"
                                                               type="text" name="booked_by">

                                                    </div>
                                                </div>
 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Guest First Name:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if($errors->has('first_name')) style="border-color:red;"
                                                               @endif id="first_name" class="form-control input-height"
                                                               value="@if($init==0){{old('first_name')}}@else{{old('first_name',$room_booking_update->first_name)}}@endif"
                                                               type="text" name="first_name"
                                                               placeholder="Enter First Name">
                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Guest Last Name:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if($errors->has('last_name')) style="border-color:red;"
                                                               @endif id="last_name" class="form-control input-height"
                                                               placeholder="Enter Father of Husband's Name"
                                                               value="@if($init==0){{old('last_name')}}@else{{old('last_name',$room_booking_update->last_name)}}@endif"
                                                               type="text" name="last_name">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Company / Institution:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('guest_company')) style="border-color:red;"
                                                            @endif id="guest_company" class="form-control input-height"
                                                            placeholder="Enter Name of Company"
                                                            value="@if($init==0){{old('guest_company')}}@else{{old('guest_company',$room_booking_update->guest_company)}}@endif"
                                                            type="text" name="guest_company"></div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Address:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if($errors->has('guest_address')) style="border-color:red;"
                                                            @endif id="guest_address" class="form-control input-height"
                                                            placeholder="Enter Complete Address"
                                                            value="@if($init==0){{old('guest_address')}}@else{{old('guest_address',$room_booking_update->guest_address)}}@endif"
                                                            type="text" name="guest_address">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Country:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if($errors->has('guest_country')) style="border-color:red;"
                                                            @endif id="guest_country" class="form-control input-height"
                                                            placeholder="Enter Country of Residence"
                                                            value="@if($init==0){{old('guest_country')}}@else{{old('guest_country',$room_booking_update->guest_country)}}@endif"
                                                            type="text" name="guest_country">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">City: <span
                                                            class="tx-danger">*</span></label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if($errors->has('guest_city')) style="border-color:red;"
                                                               @endif id="guest_city" type="text" name="guest_city"
                                                               value="@if($init==0){{old('guest_city')}}@else{{old('guest_city',$room_booking_update->guest_city)}}@endif"
                                                               class="form-control input-height"
                                                               placeholder="Enter City of Residence">
                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">Mobile: <span
                                                            class="tx-danger">*</span></label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('guest_mob')) style="border-color:red;"
                                                               @endif id="guest_mob" type="text" name="guest_mob"
                                                               value="@if($init==0){{old('guest_mob')}}@else{{old('guest_mob',$room_booking_update->guest_mob)}}@endif"
                                                               class="form-control input-height"
                                                               placeholder="Enter Contact Number">
                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">Email: <span
                                                            class="tx-danger">*</span></label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if($errors->has('guest_email')) style="border-color:red;"
                                                            @endif id="guest_email" type="text" name="guest_email"
                                                            class="form-control input-height"
                                                            value="@if($init==0){{old('guest_email')}}@else{{old('guest_email',$room_booking_update->guest_email)}}@endif"
                                                            placeholder="Enter Email Id">
                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label"> CNIC / Passport No.:
                                                        <span class="tx-danger">*</span></label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('guest_cnic')) style="border-color:red;"
                                                            @endif id="guest_cnic" type="text" name="guest_cnic"
                                                            class="form-control input-height"
                                                            value="@if($init==0){{old('guest_cnic')}}@else{{old('guest_cnic',$room_booking_update->guest_cnic)}}@endif"
                                                            placeholder="Enter CNIC Number (13 digits)">
                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Accompained Guest Name:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('accompained_guest')) style="border-color:red;"
                                                            @endif id="accompained_guest"
                                                            class="form-control input-height"
                                                            placeholder="Enter Name of Accompained Guest (if any)"
                                                            value="@if($init==0){{old('accompained_guest')}}@else{{old('accompained_guest',$room_booking_update->accompained_guest)}}@endif"
                                                            type="text" name="accompained_guest">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Relationship:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if($errors->has('acc_relationship')) style="border-color:red;"
                                                            @endif id="acc_relationship"
                                                            class="form-control input-height"
                                                            placeholder="Enter Relationship"
                                                            value="@if($init==0){{old('acc_relationship')}}@else{{old('acc_relationship',$room_booking_update->acc_relationship)}}@endif"
                                                            type="text" name="acc_relationship">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label"> CNIC / Passport
                                                        No.: </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input @if ($errors->has('acc_cnic')) style="border-color:red;"
                                                               @endif id="acc_cnic" type="text" name="acc_cnic"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('acc_cnic')}}@else{{old('acc_cnic',$room_booking_update->acc_cnic)}}@endif"
                                                               placeholder="Enter CNIC Number (13 digits)">
                                                    </div>
                                                </div>

                                                </div>
<div class="col-sm-6">
  <div class="row mg-t-10">
                                                    <label>
                                                    </label>
                                                    <label class="col-sm-3 form-control-label">
                                                        Check-In Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        @if($init==1 && $checkinedit==0)

                                                            <input onchange="checkoutdate(this)"
                                                                   @if ($errors->has('check_in_date')) style="border-color:red;"
                                                                   @endif id="check_in_date" placeholder="dd/mm/yyyy"
                                                                   class="form-control input-height" readonly type="text"
                                                                   autocomplete="off"
                                                                   value="@if($init==0){{old('check_in_date')}}@else{{old('check_in_date',formatDateToShow($room_booking_update->check_in_date))}}@endif"
                                                                   name="check_in_date"
                                                                   @if ($room_booking_update->status==1)
                                                                   readonly style="background-color: #c1c1c1" @endif>

                                                        @elseif($init==1 && $checkinedit==1)
                                                          <input onchange="checkoutdate(this)"
                                                                   @if ($errors->has('check_in_date')) style="border-color:red;"
                                                                   @endif id="check_in_date" placeholder="dd/mm/yyyy"
                                                                   class="form-control input-height checkinid" readonly type="text"
                                                                   autocomplete="off"
                                                                   value="@if($init==0){{old('check_in_date')}}@else{{old('check_in_date',formatDateToShow($room_booking_update->check_in_date))}}@endif"
                                                                   name="check_in_date"
                                                                   @if ($room_booking_update->status==1)
                                                                   readonly style="background-color: #c1c1c1" @endif>

                                                        @else
                                                            <input onchange="checkoutdate(this)"
                                                                   @if ($errors->has('check_in_date')) style="border-color:red;"
                                                                   @endif id="check_in_date" placeholder="dd/mm/yyyy"
                                                               class="form-control input-height" readonly
                                                                   type="text"
                                                                   value="@if($init==0){{old('check_in_date')}}@else{{old('check_in_date',formatDateToShow($room_booking_update->check_in_date))}}@endif"
                                                                   name="check_in_date">

                                                        @endif
                                                    </div>

                                                </div>
                                                <!-- row -->
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Arrival Details:

                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0"><textarea
                                                            @if($errors->has('arrival_details')) style="border-color:red;"
                                                            @endif id="arrival_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="arrival_details">@if($init==0){{old('arrival_details')}}@else{{old('arrival_details',$room_booking_update->arrival_details)}}@endif</textarea>

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label>
                                                    </label>
                                                    <label class="col-sm-3 form-control-label">
                                                        Check-Out Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">

                                                        <input
                                                            @if ($errors->has('check_out_date')) style="border-color:red;"
                                                            @endif id="check_out_date" class="form-control input-height" readonly
                                                            autocomplete="off" type="text" placeholder="dd/mm/yyyy"
                                                            value="@if($init==0){{old('check_out_date')}}@else{{old('check_out_date',formatDateToShow($room_booking_update->check_out_date))}}@endif"
                                                            name="check_out_date">

                                                    </div>

                                                </div>
                                                <!-- row -->
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Departure Details:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0"><textarea
                                                            @if($errors->has('departure_details')) style="border-color:red;"
                                                            @endif id="departure_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="departure_details">@if($init==0){{old('departure_details')}}@else{{old('departure_details',$room_booking_update->departure_details)}}@endif</textarea>

                                                    </div>
                                                </div>
 <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Room:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0" id="selectbelow">
                                                        <select @if ($errors->has('room')) style="border-color:red;"
                                                                @endif onchange="chargesselect()" id="roomid"
                                                                class="form-control" name="room">
                                                            <option label="Select a Room">
                                                            </option>
                                                            @php $a=0; @endphp

                                                            @foreach($room as $rooms)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('room',$room_booking_update->room)==$rooms->id)  selected
                                                                        @endif  value="{{ $rooms->id }}">{{ $rooms->room_no }} @if($roomtype[$a]['roomtypes']){{ roomtypename($rooms->id) }} @else @endif
                                                                    </option>
                                                                @else
                                                                    {{--  <option @if(old('room')==$rooms->id)  selected @endif  value="{{ $rooms->id }}">
                                                                        {{ $rooms->room_no }} (@if($roomtype[$a]['roomtypes']){{$roomtype[$a]['roomtypes']->desc}} @else @endif)
                                                                    </option>
                                                                     @php $a++; @endphp --}}
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @php $b=0; @endphp
                                                        @foreach($room as $rooms)

                                                            <input id="roomtype{{ $rooms->id }}" type="hidden"
                                                                   name="room_typeid{{ $rooms->id }}"
                                                                   value="@if($roomtype[$b]['roomtypes']) {{$roomtype[$b]['roomtypes']->id}} @else @endif">

                                                            @php $b++; @endphp
                                                        @endforeach

                                                    </div>
                                                </div>


                                     <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Booking Category:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <select @if ($errors->has('category')) style="border-color:red;"
                                                                @endif onchange="chargesselect()" id="roomcategoryid"
                                                                class="form-control"
                                                                name="category">
                                                            <option label="Choose Category">
                                                            </option>
                                                            @foreach($room_category as $roomcategory)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('category',$room_booking_update->category)==$roomcategory->id)  selected
                                                                        @endif  value="{{ $roomcategory->id }}">
                                                                        {{ $roomcategory->desc }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('category')==$roomcategory->id)  selected
                                                                        @endif value="{{ $roomcategory->id }}">
                                                                        {{ $roomcategory->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Per Day Room Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input
                                                            @if ($errors->has('pday_charges_id')) style="border-color:red;"
                                                            @endif id="pday_charges_id"
                                                            class="form-control input-height" readonly
                                                            style="background-color: #c1c1c1"
                                                            value="@if($init==0){{old('pday_charges_id')}}@else{{old('pday_charges_id',$room_booking_update->pday_charges_id)}}@endif"
                                                            type="text" name="pday_charges_id">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        No. of Nights:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('nights')) style="border-color:red;"
                                                               @endif id="nights" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('nights')}}@else{{old('nights',$room_booking_update->nights)}}@endif" type="text" name="nights">

                                                    </div>
                                                </div>


                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Room Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('charges')) style="border-color:red;"
                                                               @endif id="charges" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('charges')}}@else{{old('charges',$room_booking_update->charges)}}@endif"
                                                               type="text" name="charges">

                                                    </div>
                                                </div>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Security Deposit:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('security')) style="border-color:red;"
                                                               @endif id="security" class="form-control input-height"
                                                               placeholder="Enter Amount of Security (if deposited)"
                                                               value="@if($init==0){{old('security')}}@else{{old('security',$room_booking_update->security)}}@endif"
                                                               type="text" name="security">

                                                    </div>
                                                </div>

<br><br>
        <h6 class="box-title headingsettings"><b>OTHER CHARGES</b></h6>
              
                
                                                </br>
                                                <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                        <td width="40%" align="left">Charges Type</td>
                                                        <td width="20%" align="left">Bill Details</td>
                                                        <td width="20%" align="left">Charges Amount</td>
                                                        <td width="20%" align="left">&nbsp;</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">

                                                    @if($init==1)
                                                        @foreach($bookingsubdata as $bookingsub)
                                                            <tr>
                                                                <td><select id="{{ $bookingsub->id }}"
                                                                            onchange="extrachargesselect(this.id)"
                                                                            class="form-control"
                                                                            name="charges_type[]">
                                                                        <option label="Select a Charges Type"></option>
                                                                        @foreach($room_charges_type as $roomcharges)

                                                                            @if($init==1)
                                                                                <option
                                                                                    @if(old('charges_type[]',$bookingsub->charges_type_id)==$roomcharges->id)  selected
                                                                                    @endif value="{{ $roomcharges->id }}">
                                                                                    {{ $roomcharges->type }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    @if(old('charges_type[]')==$roomcharges->id)  selected
                                                                                    @endif value="{{ $roomcharges->id }}">
                                                                                    {{ $roomcharges->type }}
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
                                                            <td><select id="1" onchange="extrachargesselect(this.id)"
                                                                        class="form-control "
                                                                        name="charges_type[]">
                                                                    <option label="Select a Charges Type"></option>
                                                                    @foreach($room_charges_type as $roomcharges)


                                                                <option
                                                               @if(old('charges_type[]')==$roomcharges->id)  selected
                                                                            @endif value="{{ $roomcharges->id }}">
                                                                            {{ $roomcharges->type }}
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

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer">
                                                        <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>
                                              
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-3 form-control-label">
                                                        Total Other Charges:
                                                    </label>
                                                    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_room_charges')) style="border-color:red;"
                                                               @endif id="total_room_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_room_charges')}}@else{{old('total_room_charges',$room_booking_update->total_room_charges)}}@endif"
                                                               type="text" name="total_room_charges">

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
                                                               value="@if($init==0){{old('total_charges')}}@else{{old('total_charges',$room_booking_update->total_charges)}}@endif"
                                                               type="text" name="total_charges">

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
                                                               placeholder="Enter Discount (if given)"
                                                               value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$room_booking_update->discount_amount)}}@endif" name="discount_amount" oninput="calculate_total()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label" style="color: black;">
                                                        Details:
                                                    </label>
                                                    <div class="col-sm-4 mg-t-4 mg-sm-t-0">
                                                        <textarea
                                                            @if ($errors->has('discount_details')) style="border-color:red;"
                                                            @endif id="discount_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="discount_details">@if($init==0){{old('discount_details')}}@else{{old('discount_details',$room_booking_update->discount_details)}}@endif</textarea>

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
                                                               onclick="calculate_total()" value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$room_booking_update->grand_total)}}@endif"
                                                               type="text" name="grand_total">

                                                    </div>
                                                </div>
<!-- <div class="row mg-t-10">
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
                                                           <option label="Choose Mode">
                                                            </option>
                                        @foreach($payment_methods as $methods)
                                                                @if($init==1)
                           <option  @if(old('payment_mode',$room_booking_update->payment_mode)==$methods->id)  selected  @endif  value="{{ $methods->id }}">  {{ $methods->desc }}
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
                                                            name="payment_mode_details">@if($init==0){{old('payment_mode_details')}}@else{{old('payment_mode_details',$room_booking_update->payment_mode_details)}}@endif</textarea>

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
                                                               placeholder="Enter Advance (if paid)"
                                                               value="@if($init==0){{old('advance_paid')}}@else{{old('advance_paid',$room_booking_update->advance_paid)}}@endif"
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
                                                               value="@if($init==0){{old('total_balance')}}@else{{old('total_balance',$room_booking_update->total_balance)}}@endif"
                                                               type="text" name="total_balance">

                                                    </div>
                                                </div> -->






                                            <!--  <br>

                    @if($init==1)
                                                <div class="input-group control-group increment" >
                                   <input type="file" name="booking_docs[]" value="{{$room_booking_update->booking_docs}}" class="form-control">
          <div class="input-group-btn">
            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
          </div>
        </div>
        <div class="clone hide">
          <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="booking_docs[]" value="{{$room_booking_update->booking_docs}}" class="form-control">
            <div class="input-group-btn">
              <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
            </div>
          </div>
        </div>
        @else
                                                <div class="input-group control-group increment" >
                                                  <input type="file" name="booking_docs[]" class="form-control">
          <div class="input-group-btn">
            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
          </div>
        </div>
        <div class="clone hide">
          <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="booking_docs[]" class="form-control">
            <div class="input-group-btn">
              <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
            </div>
          </div>
        </div>
        @endif
                                                <br> -->
     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label"  style="color: black !important;">
                    Documents:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                             @if($init==0)
                             <img id="picchose" style="width: 200px; height: 100px; " src="{{ url('assets/images/nouser.png') }}">

                             @else
@if($room_booking_update->booking_type==0)

    @foreach($room_booking_update->bookingDocs->pluck('url') as $image)
     <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach


@else
{{--@dd($room_booking_update->customer_id)--}}
                                    @foreach($room_booking_update->bookingDocs->pluck('url') as $image)
 <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach
    @endif

                             @endif
                             @if($init==0)
                            <input @if ($errors->has('booking_docs')) style="border-color:red;" @endif type="file" name="booking_docs[]" multiple="multiple" value="@if($init==0){{old('booking_docs')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="booking_docs[]" multiple="multiple">
</div>
                            <input type="hidden" name="existimg" value="{{old('booking_docs',$room_booking_update->booking_docs)}}">
                            @endif

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
                                                            name="additional_notes">@if($init==0){{old('additional_notes')}}@else{{old('additional_notes',$room_booking_update->additional_notes)}}@endif</textarea>

                                                    </div>
                                                </div>
</div>

                                                </div>

<br><br><br>
                                            <div class="desktop-screen-design">



                                                @if($init==1 && $checkinedit==0)

                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        &nbsp&nbsp
                                                        <div class="form-layout-footer mg-t-30">

                                                            <button type="input" name="save" class="btn btn-info">
                                                                Update
                                                            </button>
                                                            &nbsp&nbsp
                                                            <a href="{{ url('room-management/room-booking-vue') }}"
                                                               class="btn btn-secondary">Cancel</a>
                                                        </div><!-- form-layout-footer -->
                                                    </div>
                                                @elseif($init==1 && $checkinedit==1)
                                                    <div class="row mg-t-10">
                                                        <label class="col-sm-4 form-control-label"></label>
                                                        &nbsp&nbsp
                                                        <div class="form-layout-footer mg-t-30">

                                                            <button type="input" name="save" class="btn btn-info">
                                                                Update
                                                            </button>
                                                            &nbsp&nbsp
                                                            <a href="{{ url('room-management/room-check-in') }}"
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
                                                            <a href="{{ url('room-management/room-booking-vue') }}"
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
                        if (val1.id == '<?php echo isset($room_booking_update->room) ? $room_booking_update->room : ''?>') {
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

    <!-- <script type="text/javascript">
    function checkoutdatecheck(){
    if($('#check_out_date').val() < new Date($('#check_in_date').val())){

    alert('Check-Out date must be greater than the Check-In date!');

    return document.getElementById("check_out_date").value=null;
    }
    }

    </script> -->
    <!--
    <script type="text/javascript">
    function checkindatecheck(){
    if(new Date($('#check_in_date').val()) > new Date($('#check_out_date').val())){

    alert('Check-Out date must be greater than the Check-In date!');

    return document.getElementById("check_in_date").value=null;
    }
    }

    </script> -->

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
                           // document.getElementById("total_balance").value = result;
                        }

                    }
                });
            }

        }
    </script>




    <script type="text/javascript">

        function extrachargesselect(idd) {

            var idval = document.getElementById(idd).value;

            $.ajax({
                type: 'GET',
                url: '{{ url('room-management/room-booking/calculateextracharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                        document.getElementById('charges_amount' + idd).value = obj;
                        // $('#addressdata').html(data);
                        // total+=parseInt(obj);
                        //document.getElementById('total_room_charges').value=total;
                        total = 0;
                        $('.charamt').each(function (index, element) {
                            total += parseFloat($(element).val());
                        });

                        document.getElementById('total_room_charges').value = total;

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

            document.getElementById('total_room_charges').value = total;
            calculate_total();

        }


    </script>

    <script type="text/javascript">
        function calculate_total() {

            var room_charges = parseFloat(document.getElementById("charges").value);

            var extracharges = parseFloat(document.getElementById("total_room_charges").value);

            var discountamt = parseFloat(document.getElementById("discount_amount").value);

           // var advance_paid = parseFloat(document.getElementById("advance_paid").value);

            if (Number.isNaN(extracharges)) {
                extracharges = 0;
            }

            if (Number.isNaN(discountamt)) {
                discountamt = 0;
            }

            /*if (Number.isNaN(advance_paid)) {
                advance_paid = 0;
            }*/
            var result = room_charges + extracharges;

            document.getElementById("total_charges").value = result;
            document.getElementById("grand_total").value = (result - discountamt);
           // document.getElementById("total_balance").value = (result - discountamt) - advance_paid;

        }
    </script>

    {{-- <script type="text/javascript">
       function subtract_advance() {

                    var first_number = parseFloat(document.getElementById("grand_total").value);
                    var second_number = parseFloat(document.getElementById("advance_paid").value);

                     if(Number.isNaN(second_number)){
                    second_number=0;
                  }
                    var result = first_number - second_number;

                    document.getElementById("total_balance").value = result;
                }
    </script> --}}




    {{-- <script type="text/javascript">
       function subtract_discount() {

                    var first = parseFloat(document.getElementById("total_charges").value);
                    var second = parseFloat(document.getElementById("discount_amount").value);
                    if(Number.isNaN(second)){
                    second=0;
                  }
                    var result = first - second;

                    document.getElementById("grand_total").value = result;
                    document.getElementById("total_balance").value = result;
                }
    </script> --}}


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
                document.getElementById('total_room_charges').value = total;
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
                document.getElementById('total_room_charges').value = total;
                calculate_total();
            }


        }
    </script>


    <!--<script type="text/javascript">
       function resetpickup() {

                    document.getElementById("pick_up_charges").disabled = false;
                    document.getElementById("pick_up_details").disabled = false;
                }
    </script>


    <script type="text/javascript">
       function resetdropoff() {

                    document.getElementById("drop_off_charges").disabled = false;
                    document.getElementById("drop_off_details").disabled = false;
                }
    </script>-->

    <script type="text/javascript">
        var i = 2;

        function addmorefields() {
            var html = '';

            html = `<tr>
    <td>
     <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect2();"></i>
     <select id="${i}"  onchange="extrachargesselect(this.id)" class="form-control" name="charges_type[]" >
                    <option label="Select a Charges Type"></option>
                     @foreach($room_charges_type as $roomcharges)
            <option value="{{ $roomcharges->id }}">
                                    {{ $roomcharges->type }}
            </option>
@endforeach
            </select></td>
            <td>
            <i>&nbsp</i>
                <input id="bill_details${i}" class="form-control input-height" type="text" name="bill_details[]" >
                  </td>
                  <td>
                  <i>&nbsp</i>
                      <input id="charges_amount${i}" onkeyup="extrachargesselect2()" class="form-control input-height charamt" type="number" name="charges_amount[]">
                  </td>

                  <td>
                  <i>&nbsp</i>
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
                    'MOC': v,
                    'balance': 1
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    if (v == 0) {
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
                            document.getElementById('corporate_id').value = '';
                            document.getElementById('corporate_code').value = '';
                        document.getElementById('ledger_amount').value=obj.balance;
         let selected="{{$init==1?$room_booking_update->family:''}}";
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
                else if (v == 6) {
                       document.getElementById('moc_address').value = obj.cur_address;
                        document.getElementById('moc_cnic').value = obj.cnic;
                        document.getElementById('moc_mob').value = obj.mob_a;
                        document.getElementById('moc_email').value = obj.personal_email;

                           $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                        document.getElementById('moc_name').value = $fname+$mname+$lname;

                            document.getElementById('corporate_id').value = obj.id;
                            document.getElementById('corporate_code').value = obj.mem_no;

                        document.getElementById('member_id').value = '';
                        document.getElementById('member_code').value = '';
                        document.getElementById('customer_id').value = '';
                        document.getElementById('ledger_amount').value=obj.balance;
         let selected="{{$init==1?$room_booking_update->family:''}}";
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
                     else {
                       
                        document.getElementById('moc_address').value = obj.customer_address;
                        document.getElementById('moc_cnic').value = obj.customer_cnic;
                        document.getElementById('moc_mob').value = obj.customer_contact;
                        document.getElementById('moc_email').value = obj.customer_email;
                        document.getElementById('moc_name').value = obj.customer_name;
                        document.getElementById('customer_id').value = obj.id;
                        document.getElementById('member_id').value ='';
                        document.getElementById('member_code').value = '';

                         document.getElementById('corporate_id').value = '';
                         document.getElementById('corporate_code').value = '';

                        document.getElementById('ledger_amount').value=obj.balance;
                        $('#family').html('<option label="Choose Family Member">  </option>');
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
<!-- 
 <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/> -->

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}"></script> 


    <script>

        $(function () {
            $("#check_out_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                startDate: '-2d'
            }).on('changeDate', function () {
                datecheckx();

            });
        });

         $(function () {
            $(".checkinid").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
                enableOnReadonly: false,
                startDate: '-2d'
            }).on('changeDate', function () {
                datecheckx();

            });
        });

        $(function () {
            $("#check_in_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true,
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
@endpush

