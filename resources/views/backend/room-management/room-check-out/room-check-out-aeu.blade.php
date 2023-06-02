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

.areabox {
            cursor: pointer !important;
        }
 .form-control-label{
        color:black !important;
      }
</style>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Check Out</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-check-out') }}">Room Check Out List</a></li>
  <li><a href>Add Room Check Out</a></li>
</ul>

<div class="col-xl-12">

    @if($errors->any())
<div id="error_msg" class="alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

 <form method="post" action="{{ url('room-management/room-check-out/update') }}/{{ Request::segment(4)}}">
     @csrf
             <div class="form-layout form-layout-4 ">


               <div class="row">
               <div class="col-sm-6">
 <div  class="row mg-t-10">
                        <label>
                        </label>
                        <label class="col-sm-3 form-control-label {{ $errors->has('booking_no') ? ' has-error' : '' }}">
                          Booking Number:
                           <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input id="booking_no" class="form-control input-height" type="number" value="{{$roombooking->booking_no}}" name="booking_no" readonly style="background-color: #c1c1c1">
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

$today = $month.'/'.$day.'/'.$year;
?>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('booking_date')) style="border-color:red;" @endif id="booking_date"  class="form-control input-height" type="text" value="{{formatDateToShow($roombooking->booking_date)}}" name="booking_date" readonly style="background-color: #c1c1c1">

                        </div>

                    </div>
                    <!-- row -->
<br>
               <h6 class="box-title headingsettings"><b>GUEST BILL TO</b></h6>
           
 <div class="row mg-t-10">
               <label class="col-sm-1 form-control-label">Booking Type:<span class="tx-danger">
                                *
                            </span>
                          </label>
              <div class="col-sm-1 mg-t-10 mg-sm-t-0">
               <label class="rdiobox">
    <input @if($roombooking->booking_type==0) checked="" @else disabled @endif type="radio" name="booking_type" value="0" ><span class="pabs">Member</span>
              </label>
            </div><!-- col-3 -->

       <div class="col-sm-2 mg-t-10 mg-sm-t-0">
               <label class="rdiobox">
    <input @if($roombooking->booking_type==6) checked="" @else disabled @endif type="radio" name="booking_type" value="6" ><span class="pabs">Corporate Member</span>
              </label>
            </div><!-- col-3 -->
             
@foreach($gts as $gt)
 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
              <label class="rdiobox">
    <input @if(customertype($roombooking->customer_id)==$gt->id) checked="" @else disabled @endif type="radio" name="booking_type" value="{{10+$gt->id}}"><span class="pabs">{{$gt->desc}}</span>
              </label>
            </div><!-- col-3 -->
             @endforeach


        </div><!-- row-->
         <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                 Member / Guest Name:
                  <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if($errors->has('moc_name')) style="border-color:red;"@endif id="moc_name" readonly style="background-color: #c1c1c1" class="form-control input-height typeahead" placeholder="Enter Number to Search" value="{{$roombooking->moc_name}}" type="text" name="moc_name">

  <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <a href="{{ url('room-management/room-customer/room-customer-aeu') }}" target="_blank">
                           <input type="button" value="Add New Guest" class="btn btn-info">
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
                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                           <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_code" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_code')}}@else{{old('member_code',$roombooking->member?$roombooking->member->mem_no:'') }}@endif"
                                                               type="text" name="member_code">
                                                        <input @if ($errors->has('member_id')) style="border-color:red;"
                                                               @endif id="member_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('member_id')}}@else{{old('member_id',$roombooking->member_id)}}@endif"
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
                                                               value="@if($init==0){{old('corporate_code')}}@else{{old('corporate_code',$roombooking->corporateMember?$roombooking->corporateMember->mem_no:'') }}@endif"
                                                               type="text" name="corporate_code">
                                                        <input @if ($errors->has('corporate_id')) style="border-color:red;"
                                                               @endif id="corporate_id" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('corporate_id')}}@else{{old('corporate_id',$roombooking->corporate_id)}}@endif"
                                                               type="hidden" name="corporate_id">

                                                    </div>
                   
                        <label class="col-sm-1 form-control-label">
            Guest No.:
               <!-- <span class="tx-danger">
                                *
                            </span> -->
                        </label>
                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('customer_id')) style="border-color:red;" @endif id="customer_id" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->customer_id}}" type="text" name="customer_id">

                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
               Address:
               <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('moc_address')) style="border-color:red;" @endif id="moc_address" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->moc_address}}"  type="text" name="moc_address">

                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                 CNIC:
                 <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('moc_cnic')) style="border-color:red;" @endif id="moc_cnic" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->moc_cnic}}"  type="text"name="moc_cnic">

                        </div>
                    </div>
                      <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                 Contact:
                 <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('moc_mob')) style="border-color:red;" @endif id="moc_mob" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->moc_mob}}"  type="text" name="moc_mob">

                        </div>
                    </div>
                   <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                  Email:
                  <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('moc_email')) style="border-color:red;" @endif id="moc_email" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->moc_email}}"  type="text" name="moc_email">
 
                        </div>
                    </div>
<div class="row mg-t-10">
      <label class="col-sm-3 form-control-label">
         Ledger Amount:     <span class="tx-danger"> </span> &nbsp &nbsp &nbsp &nbsp &nbsp
<a href="{{ url('finance-and-management/finance-ledger-accounts') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a> </label>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="{{$roombooking->ledger_amount}}">
</div>
</div>
                  <div class="row mg-t-10">
                 <label class="col-sm-3 form-control-label">
                         Family Member:
                                                    </label>
                                                      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
          <select onchange="relationship(this.id)" @if ($errors->has('family')) id="{{ $familymembers->id }}"

            style="border-color:red;" @endif id="family" class="form-control" name="family" style="background-color: #c1c1c1"> <option disabled label="Choose Family Member">  </option>
                    @foreach($familymembers as $fm)
         @if($init==1)
         <option
           @if(old('family',$roombooking->family)==$fm->id)  selected @else disabled @endif  value="{{ $fm->id }}"> {{ $fm->name }} ({{ $fm->relationship_name->desc }})
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
                            <input @if ($errors->has('booked_by')) style="border-color:red;" @endif id="booked_by" class="form-control input-height" placeholder="Enter Booking Reference" readonly style="background-color: #c1c1c1" value="{{$roombooking->booked_by}}"  type="text" name="booked_by">

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
                            <input @if($errors->has('first_name')) style="border-color:red;"@endif id="first_name" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->first_name}}" type="text" name="first_name" placeholder="Enter First Name">
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
                            <input @if($errors->has('last_name')) style="border-color:red;"@endif id="last_name" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Father of Husband's Name" value="{{$roombooking->last_name}}" type="text" name="last_name">

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
                            <input @if ($errors->has('guest_company')) style="border-color:red;" @endif id="guest_company" class="form-control input-height" placeholder="Enter Name of Company" readonly style="background-color: #c1c1c1" value="{{$roombooking->guest_company}}" type="text" name="guest_company"></div>
                    </div>
                   <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                             Address:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if($errors->has('guest_address')) style="border-color:red;" @endif id="guest_address" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Complete Address" value="{{$roombooking->guest_address}}" type="text" name="guest_address">

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
                            <input @if($errors->has('guest_country')) style="border-color:red;" @endif id="guest_country" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Country of Residence" value="{{$roombooking->guest_country}}" type="text" name="guest_country">

                        </div>
                    </div>
                         <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if($errors->has('guest_city')) style="border-color:red;"@endif id="guest_city" type="text" name="guest_city" readonly style="background-color: #c1c1c1" value="{{$roombooking->guest_city}}" class="form-control input-height" placeholder="Enter City of Residence">
                  </div>
                </div>
                         <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label">Mobile: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('guest_mob')) style="border-color:red;" @endif id="guest_mob" type="text" name="guest_mob" readonly style="background-color: #c1c1c1" value="{{$roombooking->guest_mob}}" class="form-control input-height" placeholder="Enter Contact Number">
                  </div>
                </div>
                     <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label">Email: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if($errors->has('guest_email')) style="border-color:red;"@endif id="guest_email" type="text" name="guest_email" readonly style="background-color: #c1c1c1" class="form-control input-height"value="{{$roombooking->guest_email}}" placeholder="Enter Email Id">
                  </div>
                </div>
                     <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label">  CNIC / Passport No.: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('guest_cnic')) style="border-color:red;" @endif id="guest_cnic" type="text" name="guest_cnic" readonly style="background-color: #c1c1c1" class="form-control input-height" value="{{$roombooking->guest_cnic}}" placeholder="Enter CNIC Number (13 digits)">
                  </div>
                </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                             Accompained Guest Name:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('accompained_guest')) style="border-color:red;"@endif id="accompained_guest" readonly style="background-color: #c1c1c1" class="form-control input-height"placeholder="Enter Name of Accompained Guest (if any)" value="{{$roombooking->accompained_guest}}"  type="text" name="accompained_guest">

                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                 Relationship:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if($errors->has('acc_relationship')) style="border-color:red;"@endif id="acc_relationship" class="form-control input-height"placeholder="Enter Relationship" readonly style="background-color: #c1c1c1" value="{{$roombooking->acc_relationship}}"  type="text" name="acc_relationship">

                        </div>
                    </div>
                    <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label">  CNIC / Passport No.: </label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('acc_cnic')) style="border-color:red;" @endif id="acc_cnic" type="text" name="acc_cnic" readonly style="background-color: #c1c1c1" class="form-control input-height" value="{{$roombooking->acc_cnic}}" placeholder="Enter CNIC Number (13 digits)">
                  </div>
                </div>
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
                   <input @if ($errors->has('check_in_date')) style="border-color:red;" @endif id="check_in_date"  class="form-control input-height" type="text" value="{{formatDateToShow($roombooking->check_in_date)}}" name="check_in_date" readonly style="background-color: #c1c1c1" placeholder="dd/mm/yyyy">


                        </div>

                    </div>
                    <!-- row -->
             <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                               Arrival Details:

                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0"><textarea @if($errors->has('arrival_details')) style="border-color:red;"@endif id="arrival_details" class="form-control" readonly style="background-color: #c1c1c1" placeholder="Give any details" rows="2" type="text" name="arrival_details">{{$roombooking->arrival_details}}</textarea>

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
                            <input @if ($errors->has('check_out_date')) style="border-color:red;"@endif id="check_out_date"  class="form-control input-height" type="text" value="{{formatDateToShow($roombooking->check_out_date)}}" name="check_out_date" readonly style="background-color: #c1c1c1" placeholder="dd/mm/yyyy">


                        </div>

                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                          Check Out Time
                          <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('check_out_time')) style="border-color:red;" @endif id="check_out_time" class="form-control input-height" type="time" name="check_out_time" readonly style="background-color: #c1c1c1">


                        </div>
                    </div>
                    <!-- row -->
                  <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                               Departure Details:
                         </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0"><textarea @if($errors->has('departure_details')) style="border-color:red;"@endif id="departure_details" class="form-control" readonly style="background-color: #c1c1c1" placeholder="Give any details" rows="2" type="text" name="departure_details">{{$roombooking->departure_details}}</textarea>

                        </div>
                    </div>

               </div>

<div class="col-sm-6">

<div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                            Room:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('room')) style="border-color:red;" @endif onchange="chargesselect()" id="roomid" class="form-control" name="room" style="background-color: #c1c1c1">
                         <option disabled label="Select a Room">
                                </option>
                                  @php $a=0; @endphp
                     @foreach($room as $rooms)

                                 <option @if(old('room',$roombooking->room)==$rooms->id)  selected @else disabled @endif  value="{{ $rooms->id }}">{{ $rooms->room_no }} (@if($roomtype[$a]['roomtypes']){{$roomtype[$a]['roomtypes']->desc}} @else @endif)
                                </option>


                                 @php $a++; @endphp

                                @endforeach
                            </select>
                              @php $b=0; @endphp
                     @foreach($room as $rooms)

                 <input id="roomtype{{ $rooms->id }}" type="hidden" name="room_typeid{{ $rooms->id }}" value="@if($roomtype[$b]['roomtypes']) {{$roomtype[$b]['roomtypes']->id}} @else @endif">

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
                            <select @if ($errors->has('category')) style="border-color:red;" @endif onchange="chargesselect()" id="roomcategoryid" class="form-control" name="category" style="background-color: #c1c1c1">
                            <option disabled label="Choose Category">
                                </option>
                               @foreach($room_category as $roomcategory)

                              <option @if(old('category',$roombooking->category)==$roomcategory->id)  selected @else disabled @endif  value="{{ $roomcategory->id }}">
                                  {{ $roomcategory->desc }}
                                </option>
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
                            <input @if ($errors->has('pday_charges_id')) style="border-color:red;" @endif id="pday_charges_id" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->pday_charges_id}}"  type="text" name="pday_charges_id">

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
                            <input type="number"  @if($errors->has('nights')) style="border-color:red;"@endif id="nights" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->nights}}" type="text" name="nights">

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
                            <input type="number" @if($errors->has('charges')) style="border-color:red;"@endif id="charges" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$roombooking->charges}}" type="text" name="charges">

                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                  Security Deposit:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if($errors->has('security')) style="border-color:red;"@endif id="security" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Amount of Security (if deposited)" value="{{$roombooking->security}}"  type="text" name="security" value="0">

                        </div>
                    </div>


<br><br> 
               <h6 class="box-title headingsettings"><b>FOOD BILL CHARGES</b></h6>
        
                 <table class="table-bordered" align="center" border="0" width="100%">
                   <tbody>
                    <tr>
<!--                      <td width="25%" align="left"><b>TYPE</b></td> -->
                     <td width="10%" align="left"><b>DATE</b></td>
                     <td width="10%" align="left"><b>INVOICE #</b></td>
                     <td width="35%" align="left"><b>M/G NAME (ID)</b></td>
                     <td width="15%" align="left"><b>M/G TYPE</b></td>
                     <td width="10%" align="left"><b>TOTAL</b></td>
                     <td width="10%" align="left"><b>PAID</b></td>
                     <td width="10%" align="left"><b>BALANCE</b></td>
                     </tr>
                  <tbody>
                    <tbody>

     @php 
       $grandee=0;
       $sumtrans=0;
       $sumpaid=0; 
     @endphp

                    @foreach($invoices as $inv)       
         
                     <tr>
                 <!--       <td>Food and Beverage</td> -->
                       <td>{{formatDateToShow($inv->date)}}</td>
  <td><a href="{{ url('food-and-beverage/sales/sales-invoice/') }}/{{$inv->id}}" target="_blank">{{$inv->id}}</td>

                   @if($inv->mog==1)
                      <td>{{$inv->customer}} ({{$inv->customer_id}})</td>
                   @elseif($inv->mog==0)
                     <td>{{$inv->tname}} {{$inv->fname}} {{$inv->mname}} {{$inv->lname}} ({{$inv->mem_no}})</td>
                   @elseif($inv->mog==3)
                     <td>{{$inv->employee}} ({{$inv->customer_id}})</td>
                   @else 
                    <td></td>
                   @endif


                   @if($inv->mog==1)
                      @if($inv->guesttype)

                         <td>{{$inv->guesttype}}</td>
                      @else
                          <td>Guest</td>
                      
                      @endif
                   @elseif($inv->mog==0)
                    <td>Member</td>
                   @elseif($inv->mog==3)
                    <td>Employeee</td>
                   @else 
                    <td></td>
                   @endif


                  <td>{{$inv->grand_total}}</td>
                 
                  <td>{{$inv->paid_amount}}</td>
                  <td>{{$inv->grand_total-$inv->paid_amount}}</td>

   @php  $grandee=$grandee+$inv->grand_total;  @endphp
   @php  $sumpaid=$sumpaid+$inv->paid_amount;  @endphp
   @php  $sumtrans=$sumtrans+($inv->grand_total-$inv->paid_amount);  @endphp
            
                     </tr>
               
       
                  @endforeach


                   </tbody>
                 </table>
 <br/>

  <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                  Grand Total:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if($errors->has('food_grand_total')) style="border-color:red;"@endif id="food_grand_total" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$grandee}}"  type="text" name="food_grand_total" >

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                   Total Paid Amount:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if($errors->has('food_paid')) style="border-color:red;"@endif id="food_paid" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$sumpaid}}"  type="text" name="food_paid" >

                        </div>
                    </div>
             <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                  Food Bill Charges:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if($errors->has('food_bill_charges')) style="border-color:red;"@endif id="food_bill_charges" class="form-control input-height" readonly style="background-color: #c1c1c1" value="{{$sumtrans}}"  type="text" name="food_bill_charges" >

                        </div>
                    </div>


                    <br>

<br><br>
               <h6 class="box-title headingsettings"><b>OTHER CHARGES</b></h6>
   
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

                    @foreach($bookingsubdata as $bookingsub)
                     <tr>
                       <td><select  id="{{ $bookingsub->id }}" onchange="extrachargesselect(this.id)" class="form-control " name="charges_type[]">
                    <option label="Select a Charges Type"></option>
                     @foreach($room_charges_type as $roomcharges)


                                <option @if(old('charges_type[]',$bookingsub->charges_type_id)==$roomcharges->id)  selected @endif value="{{ $roomcharges->id }}">
                                    {{ $roomcharges->type }}
                                 </option>

                                @endforeach
                  </select></td>
                   <td>
             <input id="bill_details{{ $bookingsub->id }}" class="form-control input-height" type="text" name="bill_details[]" value="{{old('bill_details[]',$bookingsub->bill_details)}}">
                  </td>
                  <td>
                      <input  id="charges_amount{{ $bookingsub->id }}" onkeyup="extrachargesselect2()"  class="form-control input-height charamt" type="number" name="charges_amount[]" value="{{old('charges_amount[]',$bookingsub->charges_amount)}}" >
                  </td>
                   <td>
                     <input id="complementary{{ $bookingsub->id }}" type="checkbox"  class="form-control input-height" name="complementary[]" onclick="resetchargesamount({{ $bookingsub->id }})" @if($bookingsub->iscomplementary=='true') checked="" @endif value="false">

                     <input type="hidden" id="complementary{{ $bookingsub->id }}dump" type="checkbox"  class="form-control input-height" name="complementary[]" >
                           <label class="custom-control-label" for="Complementary?">Complementary?</label>
                  </td>
                     </tr>
                  @endforeach


                   </tbody>
                 </table>


                     <div class="row mg-t-10">

               &nbsp&nbsp&nbsp&nbsp&nbsp
                <div class="form-layout-footer">
                  <input onclick="addmorefields()" type="button" value="Add More" class="btn btn-info">

                </div><!-- form-layout-footer -->
            </div>
            <br/>
             <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                Other Charges:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if($errors->has('total_room_charges')) style="border-color:red;"@endif id="total_room_charges" class="form-control input-height" readonly style="background-color: #c1c1c1"value="{{$roombooking->total_room_charges}}"  type="text" name="total_room_charges" >

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
                            <input type="number" @if($errors->has('total_charges')) style="border-color:red;"@endif id="total_charges" class="form-control input-height" readonly style="background-color: #c1c1c1" onclick="calculate_total()" value="{{$roombooking->total_charges}}"  type="text" name="total_charges" >

                        </div>
                    </div>

               <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label" style="color: black;">
                   Discount Amount:
                        </label>
                        <div class="col-sm-4 mg-t-5 mg-sm-t-0">
                            <input type="number" @if($errors->has('discount_amount')) style="border-color:red;"@endif id="discount_amount" class="form-control input-height" placeholder="Enter Discount (if given)" value="{{old('discount_amount',$roombooking->discount_amount)}}"  type="text" name="discount_amount" oninput="calculate_total()">

                        </div>

                        <label class="col-sm-1 form-control-label" style="color: black;">
                                 Details:
                        </label>
                        <div class="col-sm-4 mg-t-4 mg-sm-t-0">
<textarea @if ($errors->has('discount_details')) style="border-color:red;" @endif id="discount_details" class="form-control" placeholder="Give any details" rows="2" type="text" name="discount_details">{{$roombooking->discount_details}}</textarea>

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
                            <input type="number" @if($errors->has('grand_total')) style="border-color:red;"@endif id="grand_total" class="form-control input-height" readonly style="background-color: #c1c1c1" onclick="calculate_total()" value="{{$roombooking->grand_total}}"  type="text" name="grand_total" >

                        </div>
                    </div>
<!--   <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                              Payment Mode:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('payment_mode')) style="border-color:red;" @endif id="payment_mode" class="form-control input-height select2" name="payment_mode">
                            <option label="Choose Mode">
                                </option>
                               @foreach($payment_methods as $methods)

                              <option @if(old('payment_mode',$roombooking->payment_mode)==$methods->id)  selected @endif  value="{{ $methods->id }}">
                                  {{ $methods->desc }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                      <label class="col-sm-1 form-control-label" style="color: black;">
                                 Details:
                        </label>
                        <div class="col-sm-4 mg-t-4 mg-sm-t-0">
<textarea @if ($errors->has('payment_mode_details')) style="border-color:red;" @endif id="payment_mode_details" class="form-control" placeholder="Give any details" rows="2" type="text" name="payment_mode_details">{{$roombooking->payment_mode_details}}</textarea>

                        </div>
                    </div>

             <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                      Advance Paid:

                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" @if($errors->has('advance_paid')) style="border-color:red;"@endif id="advance_paid" class="form-control input-height" placeholder="Enter Advance (if paid)" value="{{$roombooking->advance_paid}}"  type="text" name="advance_paid" readonly style="background-color: #c1c1c1" oninput="calculate_total()">

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
                            <input type="number" @if($errors->has('total_balance')) style="border-color:red;"@endif id="total_balance" class="form-control input-height" readonly style="background-color: #c1c1c1" onclick="calculate_total()" value="{{$roombooking->total_balance}}"  type="text" name="total_balance">

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
                            <input type="number" @if ($errors->has('amount_paid')) style="border-color:red;" @endif id="amount_paid" class="form-control input-height" placeholder="Enter Total paid Amount" name="amount_paid" value="{{old('amount_paid',$roombooking->amount_paid)}}" oninput="calculate_total()">

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
                            <input type="number" @if ($errors->has('grand_balance')) style="border-color:red;" @endif id="grand_balance" class="form-control input-height" value="{{old('grand_balance',$roombooking->grand_balance)}}" readonly style="background-color: #c1c1c1" name="grand_balance">

                        </div>
                    </div> -->

                       <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                                 Additional Notes:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<textarea @if($errors->has('additional_notes'))style="border-color:red;"@endif id="additional_notes" class="form-control" placeholder="Give any details" rows="2" type="text" name="additional_notes">{{old('additional_notes',$roombooking->additional_notes)}}</textarea>

                        </div>
                    </div>
</div>

               </div>

<br><br><br>
                <div class="desktop-screen-design">
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

 <input type="submit" name="save" class="btn btn-info" value="Save">
                  &nbsp&nbsp
        <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp

                  <a href="{{ url('room-management/room-check-in') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

     </div><!-- form-layout -->
            </div><!-- col-6 -->
          </form>
            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


@endsection


@push('jscode')
<script type="text/javascript">
  // Function which returns a minimum of two digits in case the value is less than 10
const getTwoDigits = (value) => value < 10 ? `0${value}` : value;

const formatTime = (date) => {
  const hours = getTwoDigits(date.getHours());
  const mins = getTwoDigits(date.getMinutes());

  return `${hours}:${mins}`;
}

const date = new Date();
document.getElementById('check_out_time').value = formatTime(date);
</script>
<script type="text/javascript">
var total=0;
$('#first_name').attr('maxlength', 100);
$('#last_name').attr('maxlength', 100);
$('#guest_company').attr('maxlength', 300);
$('#guest_address').attr('maxlength', 600);
$('#guest_country').attr('maxlength', 100);
$('#guest_city').attr('maxlength', 100);
$('#guest_mob').mask('00000000000');
$('#guest_email').attr('maxlength', 300);
$('#guest_cnic').mask('00000-0000000-0');
$('#accompained_guest').attr('maxlength', 100);
$('#acc_relationship').attr('maxlength', 200);
$('#acc_cnic').mask('00000-0000000-0');
$('#booked_by').attr('maxlength', 100);

</script>

<script type="text/javascript">
function datecheckx(){
if($('#check_in_date').val()!='' && $('#check_out_date').val()!=''){


         var date1= $('#check_in_date').val().split('/');
        var date2=$('#check_out_date').val().split('/');


        var date1=new Date(date1[1]+'-'+date1[0]+'-'+date1[2]);
        var date2=new Date(date2[1]+'-'+date2[0]+'-'+date2[2]);
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
<!--
<script type="text/javascript">
function checkoutdatecheck(){
if($('#check_out_date').val() < $('#check_in_date').val()){

alert('Check-Out date must be greater than the Check-In date!');

return document.getElementById("check_out_date").value=null;
}
}

</script> -->
<script> 
$( document ).ready(function() {
     calculate_total();
});

</script>



<script type="text/javascript">
  function chargesselect(){
    var id=document.getElementById('roomid').value;
    var roomcategoryid=document.getElementById('roomcategoryid').value;

    var a='roomtype'+id;
    var roomtypeid=document.getElementById(a).value;

    $.ajax({
    type : 'POST',
    url : '{{ url('room-management/room-booking/calculatecharges/') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "roomid": id,
        "roomtypeid": roomtypeid,
        'roomcategoryid': roomcategoryid
        },
  success: function(data){
  var obj = JSON.parse(data);
  if(obj)
  {
    document.getElementById('pday_charges_id').value=obj;
  // $('#addressdata').html(data);
   var myBoxone = parseFloat(document.getElementById("pday_charges_id").value);
   var myBoxtwo = parseFloat(document.getElementById("nights").value);
   var result = myBoxone * myBoxtwo;
   document.getElementById("charges").value = result;

    document.getElementById("total_charges").value = result + parseFloat(document.getElementById("food_bill_charges").value);
    document.getElementById("grand_total").value = result + parseFloat(document.getElementById("food_bill_charges").value); 
/*   document.getElementById("total_charges").value = result;
    document.getElementById("grand_total").value = result; */

  }

      }
      });
  }
</script>


<script type="text/javascript">

  function extrachargesselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('room-management/room-booking/calculateextracharges/') }}/'+idval,
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

   document.getElementById('total_room_charges').value=total;

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

   document.getElementById('total_room_charges').value=total;
   calculate_total();

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




<script type="text/javascript">
   function subtract_discount() {

                var first = parseFloat(document.getElementById("total_charges").value) + parseFloat(document.getElementById("food_bill_charges").value);
/*
               var first = parseFloat(document.getElementById("total_charges").value);
*/
                var second = parseFloat(document.getElementById("discount_amount").value);
                if(Number.isNaN(second)){
                second=0;
              }
                var result = first - second;

                document.getElementById("grand_total").value = result;
              //  document.getElementById("total_balance").value = result;
            }
</script>


{{-- <script type="text/javascript">
   function subtract_amountpaid() {

                var first_number = parseFloat(document.getElementById("total_balance").value);
                var second_number = parseFloat(document.getElementById("amount_paid").value);
                var result = first_number - second_number;

                document.getElementById("grand_balance").value = result;
            }
</script>
 --}}

<script type="text/javascript">
   function calculate_total() {

                var room_charges = parseFloat(document.getElementById("charges").value);

              var extracharges = parseFloat(document.getElementById("total_room_charges").value);

              var discountamt = parseFloat(document.getElementById("discount_amount").value);

              //var advance_paid = parseFloat(document.getElementById("advance_paid").value);

              // var amount_paid = parseFloat(document.getElementById("amount_paid").value);

              if(Number.isNaN(extracharges)){
                extracharges=0;
              }

              if(Number.isNaN(discountamt)){
                discountamt=0;
              }

             /* if(Number.isNaN(advance_paid)){
                advance_paid=0;
              }

              if(Number.isNaN(amount_paid)){
                amount_paid=0;
              }*/

                var result = room_charges + extracharges;

                /*document.getElementById("total_charges").value = result;
                document.getElementById("grand_total").value = (result-discountamt);*/

                document.getElementById("total_charges").value = result  + parseFloat(document.getElementById("food_bill_charges").value);
                document.getElementById("grand_total").value = (result-discountamt) + parseFloat(document.getElementById("food_bill_charges").value);
              

            }
</script>


<script type="text/javascript">
   function resetchargesamount(id) {
         var ae=document.getElementById("complementary"+id).value;
          if(ae=='false'){
            document.getElementById("complementary"+id+"dump").disabled = true;

             document.getElementById("complementary"+id).value='true';
               document.getElementById("charges_amount"+id).readOnly = true;
                var minusval=document.getElementById("charges_amount"+id).value;
                total=total-minusval;
                document.getElementById('total_room_charges').value=total;
                calculate_total();
          }
          if(ae=='true'){
            document.getElementById("complementary"+id+"dump").disabled = false;
             document.getElementById("complementary"+id).value='false';
             document.getElementById("charges_amount"+id).readOnly = true;
                var minusval=document.getElementById("charges_amount"+id).value;
                total=parseFloat(total)+parseFloat(minusval);
                document.getElementById('total_room_charges').value=total;
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
  var i=2;
 function addmorefields(){
  var html='';

  html=`<tr>
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
/*  $('#transChecked').on('click', function () {
                      alert("working");

                    });*/
    function addonadd(val,id){  

if($("#transChecked"+id).prop('checked') == true){
 document.getElementById("food_bill_charges").value=parseInt(document.getElementById("food_bill_charges").value)+parseInt(val);
 document.getElementById("total_charges").value=parseInt(document.getElementById("total_charges").value)+parseInt(val);
 document.getElementById("grand_total").value=parseInt(document.getElementById("grand_total").value)+parseInt(val);
}
else if($("#transChecked"+id).prop('checked') == false){
  document.getElementById("food_bill_charges").value=parseInt(document.getElementById("food_bill_charges").value)-parseInt(val);
  document.getElementById("total_charges").value=parseInt(document.getElementById("total_charges").value)-parseInt(val);
  document.getElementById("grand_total").value=parseInt(document.getElementById("grand_total").value)-parseInt(val);
}

    }  
</script>

<script type="text/javascript">
  var val;
  function customerdatavalue(val){
    let v=$('input[name="booking_type"]:checked').val();
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
   if(v==0){
    document.getElementById('moc_address').value=obj.cur_address;
  document.getElementById('moc_cnic').value=obj.cnic;
  document.getElementById('moc_mob').value=obj.mob_a;
  document.getElementById('moc_email').value=obj.personal_email;

  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

  document.getElementById('moc_name').value= $fname+$mname+$lname;
  document.getElementById('member_id').value=obj.id;
  document.getElementById('ledger_amount').value=obj.balance;
 let selected="{{$init==1?$roombooking->family:''}}";
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
 else{
    document.getElementById('moc_address').value=obj.customer_address;
    document.getElementById('moc_cnic').value=obj.customer_cnic;
    document.getElementById('moc_mob').value=obj.customer_contact;
    document.getElementById('moc_email').value=obj.customer_email;
    document.getElementById('moc_name').value=obj.customer_name;
    document.getElementById('customer_id').value=obj.id;
    document.getElementById('ledger_amount').value=obj.balance;
    $('#family').html('<option label="Choose Family Member">  </option>');
  }
  jQuery('#areabox').html('');

      }


      });
}
</script>

<script type="text/javascript">
  var val;

  function customerdata(val){
     let v=$('input[name="booking_type"]:checked').val();
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
 jQuery.each(JSON.parse(data), function (i, val1) {
                        if(v==0){
                             $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';
                let fullname=$fname+$mname+$lname;
                
                $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${fullname}<li>`);


            
                        }else{
    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name}<li>`);
                       
                        }

                    });
$('#areabox').show();
    // $('#areabox').html(data);

      }
      });
}
</script>
<!-- 
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/>  -->

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

 <script>

  $( function() {
    $( "#check_out_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true,
       enableOnReadonly: false,
       startDate: '-2d'
     }).on('changeDate',function(){
        datecheckx();
    });
  } );

    $( function() {
    $( "#check_in_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true,
       enableOnReadonly: false,
       startDate: '-2d'
     }).on('changeDate',function(){
        datecheckx();
    });
  } );
  </script>

@endpush
