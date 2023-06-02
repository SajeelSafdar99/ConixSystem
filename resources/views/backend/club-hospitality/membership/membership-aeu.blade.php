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
.w3-black, .w3-hover-black:hover{
    color: #fff!important;
    background-color: white;
}

.w3-button:hover{
    color: #000!important;
    background-color: #ccc!important;
}

.w3-red{
    color: #fff!important;
    background-color: #56bff9!important;
}
.w3-red:hover {
    color: #fff!important;
    background-color: #17a2b8!important;
}

.w3-bar {
    width: 100%;
    height: 60px;
    overflow: hidden;
}
.w3-border {
    border: 1px solid #ccc!important;
}


.w3-bar .w3-button {
    white-space: normal;
}
.theactiveclass{
background-color: #17a2b8!important;
}
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
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

.areabox{cursor:pointer !important;}
.areaboxtwo{cursor:pointer !important;}

.headingsetting{
  color: black !important;
}

.w3-bar .w3-bar-item {
    padding: 8px 16px;
    float: left;

    border: none;
   display: inline-block;
border-radius: 5px;
margin: 0;

margin-right: 8px;
    outline: 0;
    height: 45px;
}


</style>
<div class="br-pagebody">
    <div>
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">
            Membership
        </h6>
        <div style="text-align: right; margin-top: -39px;">
            <a href="">
                <img border="0/" height="28" src="{{ url('assets/images/reload.png') }}" title="Reload Page" width="28">
                </img>
            </a>
        </div>

        @if($init==1)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Edit Membership</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Add Membership</a></li>
</ul>
@endif

<div class="w3-bar w3-black">
  @if($init==1)
   <a href="{{ url('club-hospitality/membership/membership-aeu') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red theactiveclass">Member</button>
</a>
  @else
 <button class="w3-bar-item w3-button w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/membership-aeu') }}'; ">Member</button>
  @endif

@can('View Family Member')
@if($init==1)
  <a href="{{ url('club-hospitality/membership/familymember-aeu') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Family Member</button>
</a>
@else
 <a href="{{ url('club-hospitality/membership/familymember-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Family Member</button>
</a>
@endif
@endcan


@can('View Professsion')
@if($init==1)
<a href="{{ url('club-hospitality/membership/profession-aeu') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Profession</button>
</a>
@else
<a href="{{ url('club-hospitality/membership/profession-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Profession</button>
</a>
 @endif
@endcan

@can('View Cars')
@if($init==1)
<a href="{{ url('club-hospitality/membership/cars-aeu') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Cars</button>
</a>
@else
<a href="{{ url('club-hospitality/membership/cars-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Cars</button>
</a>
 @endif
 @endcan

@can('View Membership Documents')
@if($init==1)
<a href="{{ url('club-hospitality/membership/membership_docs-aeu') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Membership Documents</button>
</a>
@else
<a href="{{ url('club-hospitality/membership/membership_docs-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Membership Documents</button>
</a>
 @endif
  @endcan

@can('View Sports')
  <button class="w3-bar-item w3-button  w3-red" disabled onclick="">Sports Subscription</button>
   @endcan


@can('View Credit Limit')
   @if($init==1)
<a href="{{ url('club-hospitality/membership/creditlimit') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Credit Limit</button>
</a>
@else
<a href="{{ url('club-hospitality/membership/creditlimit/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Credit Limit</button>
</a>
 @endif
   @endcan


@can('View Notices')
  <button class="w3-bar-item w3-button  w3-red" disabled onclick="">Notices</button>
   @endcan


@can('View Cards')
  @if($init==1)
<a href="{{ url('memberprint') }}/{{ $membership_update->id }}" target="_blank">
  <button class="w3-bar-item w3-button  w3-red">Card</button>
</a>
@else
<a href="{{ url('memberprint/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Card</button>
</a>
 @endif
  @endcan

@can('View Cards')
  @if($init==1)
<a href="{{ url('club-hospitality/membership/familymembercard') }}/{{ $membership_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Family Cards</button>
</a>
@else
<a href="{{ url('club-hospitality/membership/familymembercard/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Family Cards</button>
</a>
 @endif
  @endcan
</div>


<!-- profession-aeu/'.$id) -->

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


              @if($init==1 && Gate::check('Update Member Barcode'))
    <form method="post" enctype="multipart/form-data" action="{{ url('club-hospitality/membership/barcodeupdate') }}/{{ $membership_update->id }}">
      @elseif($init==1 && !Gate::check('Update Member Barcode'))
  <form method="post" enctype="multipart/form-data" action="{{ url('club-hospitality/membership/update') }}/{{ $membership_update->id }}">
     @else
    <form method="post" enctype="multipart/form-data">
    @endif
    @csrf
                <div class="col-xl-12 ">
            <div class="form-layout form-layout-4 ">
                <div class="row">
               <div class="col-sm-6">
                    <br>
                <h6 class="box-title" style="color: black; text-align: center;">PERSONAL INFORMATION</h6>
               
              <div  class="row ">

              </div>
                 <div  class="row ">
                        <label class="col-sm-4 form-control-label {{ $errors->has('app_no') ? ' has-error' : '' }}">
                            Application Number:
                          <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div  class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input id="app-number" class="form-control input-height" type="Number" readonly="" placeholder="Enter Application Number of Membership" value="@if($init==0){{$increment_number}}@else{{old('application_no', $membership_update->application_no)}}@endif" name="app_no" style="background-color: #c1c1c1">

                        </div>
                         @if ($errors->has('app_no'))
                        <span class="help-block">
                        <strong>{{ $errors->first('app_no') }}</strong>
                        </span>
                        @endif
                    </div>  
                    <!-- row -->


                      <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">COA Account: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if($errors->has('coa_code')) style="border-color:red;" @endif id="coa_code" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('coa_code')}}@else{{old('coa_code',coaname($membership_update->mem_unique_code))}} - {{old('coa_code',$membership_update->mem_unique_code)}}@endif" type="text" name="coa_code" onkeyup="coaaccountdata(this.value)" onfocusout="setTimeout(function(){$('#areabox23').hide();},500)">

                    <input @if($errors->has('mem_unique_code')) style="border-color:red;"  @endif id="mem_unique_code" autocomplete="off" value="@if($init==0){{old('mem_unique_code')}}@else{{old('mem_unique_code',$membership_update->mem_unique_code)}}@endif"
                                                               type="hidden" name="mem_unique_code">

                 <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$membership_update->name)}}@endif"
                                                               type="hidden" name="name"
                                                               >

 <ul id="areabox23" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                  </div>
                </div>
                     
                      <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Title:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                              <select @if ($errors->has('title')) style="border-color:red;" @endif id="title" class="form-control" name="title">

                                <option label="Choose Option">
                                </option>
                                @foreach($titles as $t)
                                @if($init==1)
                                 <option @if(old('title',$membership_update->title)==$t->desc)  selected @endif  value="{{ $t->desc }}">
                                    {{ $t->desc }}
                                </option>
                                @else
                                 <option @if(old('title')==$t->desc)  selected @endif  value="{{ $t->desc }}">
                                    {{ $t->desc }}
                                </option>
                                @endif

                                @endforeach
                            </select>
                    </div>
                      </div>

                      <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            First Name:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('first_name')) style="border-color:red;" @endif id="first_name" class="form-control" placeholder="Enter First Name of Applicant" value="@if($init==0){{old('first_name')}}@else{{old('first_name',$membership_update->first_name)}}@endif"  type="text" name="first_name">

                        </div>
                    </div>
                      <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Middle Name:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('middle_name')) style="border-color:red;" @endif id="middle_name" class="form-control input-height" placeholder="Enter Middle Name of Applicant" value="@if($init==0){{old('middle_name')}}@else{{old('middle_name',$membership_update->middle_name)}}@endif"  type="text" name="middle_name">

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Last Name:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('last_name')) style="border-color:red;" @endif id="last_name" class="form-control input-height" placeholder="Enter Last Name of Applicant" value="@if($init==0){{old('last_name')}}@else{{old('last_name',$membership_update->applicant_name)}}@endif"  type="text" name="last_name">

                        </div>
                    </div>
                      <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Name Comments:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                          <input @if ($errors->has('name_comment')) style="border-color:red;" @endif id="name_comment" class="form-control input-height" placeholder="Enter your Comments" value="@if($init==0){{old('name_comment')}}@else{{old('name_comment',$membership_update->name_comment)}}@endif"  type="text" name="name_comment">

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Father's / HusbandName:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('father_name')) style="border-color:red;" @endif id="father_name" class="form-control input-height" placeholder="Enter Father's or Husband's Name" type="text" name="father_name" value="@if($init==0){{old('father_name')}}@else{{old('father_name',$membership_update->father_name)}}@endif">

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            If father is already a member then Membership No:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                         <!--    <input @if ($errors->has('father_mem_no')) style="border-color:red;" @endif id="father_number" class="form-control input-height" placeholder="Enter Father's Membership Number" type="text" name="father_mem_no" value="@if($init==0){{old('father_mem_no')}}@else{{old('father_mem_no',$membership_update->father_mem_no)}}@endif"> -->

 <input @if ($errors->has('father_mem_no')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('father_mem_no')}}@else{{old('father_mem_no',$membership_update->father_mem_no)}}@endif" name="father_mem_no" id="father_mem_no" autocomplete="off" class="form-control input-height typeahead" placeholder="Enter Father's Membership Number" onfocusout="setTimeout(function(){$('#areaboxtwo').hide();},500)" onkeyup="customerdatatwo(this.value)">
                     <ul id="areaboxtwo" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            National Identity Card No.:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('cnic')) style="border-color:red;" @endif id="mem-cnic" class="form-control input-height" placeholder="Enter CNIC Number (13 digits)" type="text" autocomplete="off" name="cnic" value="@if($init==0){{old('cnic')}}@else{{old('cnic',$membership_update->cnic)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Passport No.:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('passport_no')) style="border-color:red;" @endif id="passport_no" class="form-control input-height" placeholder="Enter Passport Number (8 digits)" type="text" autocomplete="off" name="passport_no" value="@if($init==0){{old('passport_no')}}@else{{old('passport_no',$membership_update->passport_no)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Gender:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('gender')) style="border-color:red;" @endif class="form-control" name="gender" value="@if($init==0){{old('gender')}}@else{{old('gender',$membership_update->gender)}}@endif">
                                <option label="Choose Gender">
                                </option>
                                 @if($init==1)
                                 <option @if(old('gender',$membership_update->gender)=='Male') selected @endif value="Male">
                                    Male
                                </option>
                                <option @if(old('gender',$membership_update->gender)=='Female') selected @endif value="Female">
                                    Female
                                </option>
                                <option @if(old('gender',$membership_update->gender)=='Other') selected @endif value="Other">
                                    Other
                                </option>
                                 @else

                                 <option @if(old('gender')=='Male') selected @endif value="Male">
                                    Male
                                </option>
                                <option @if(old('gender')=='Female') selected @endif value="Female">
                                    Female
                                </option>
                                <option @if(old('gender')=='Other') selected @endif value="Other">
                                    Other
                                </option>

                                 @endif

                            </select>
                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Date of Birth:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('date_of_birth')) style="border-color:red;" @endif id="mem-dob" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" type="text" name="date_of_birth" value="@if($init==0){{old('date_of_birth')}}@else{{old('date_of_birth',formatDateToShow($membership_update->date_of_birth))}}@endif">

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Education:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('education')) style="border-color:red;" @endif id="mem-education" class="form-control input-height" placeholder="Enter Complete Education of the Applicant" type="text" name="education" value="@if($init==0){{old('education')}}@else{{old('education',$membership_update->education)}}@endif">

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            NTN (If any):
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('ntn')) style="border-color:red;" @endif id="mem-ntn" class="form-control input-height" placeholder="Enter National Tax Number" type="text" name="ntn" value="@if($init==0){{old('ntn')}}@else{{old('ntn',$membership_update->ntn)}}@endif">

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label ">
                            Reason for Seeking Membership:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea class="form-control" placeholder="Enter details" rows="2" name="reason">@if($init==0){{old('reason')}}@else{{old('reason',$membership_update->reason)}}@endif</textarea>
                        </div>
                    </div>

                <!--     <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Details of Nearest Relative:

                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea class="form-control" placeholder="Enter details" rows="2" name="details">@if($init==0){{old('details')}}@else{{old('details',$membership_update->details)}}@endif</textarea>
                        </div>
</div> -->
                     <div class="row mg-t-10">
                        <label class="col-sm-6 form-control-label"  style="color: black !important;">
                            Member Picture:
                        </label>

                        <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                             <img id="picchose" style="width: 300px; height: 300px; margin-left: -135px;" src="@if($init==1) {{ url('') }}/{{old('mem_picture',$membership_update->profilePic?$membership_update->profilePic->url:'')}}@else {{ url('assets/images/nouser.png') }} @endif">
                             @if($init==0)
                            <input @if ($errors->has('mem_picture')) style="border-color:red;" @endif type="file" name="mem_picture" value="@if($init==0){{old('mem_picture')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="mem_picture" />
</div>
                            <input type="hidden" name="existimg" value="{{old('mem_picture',$membership_update->profilePic?$membership_update->profilePic->url:'')}}">
                            @endif

                        </div>
                    </div>

                    <br><br>
                        <h6 class="box-title" style="color: black; text-align: center;">IN CASE OF EMERGENCY</h6>
                
                 <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Name:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('emergency_name')) style="border-color:red;" @endif id="emergency_name" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('emergency_name')}}@else{{old('emergency_name',$membership_update->emergency_name)}}@endif" type="text" name="emergency_name">

                        </div>
                    </div>
                 <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                           Relation:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('emergency_relation')) style="border-color:red;" @endif id="emergency_relation" class="form-control input-height" placeholder="Enter Relationship" value="@if($init==0){{old('emergency_relation')}}@else{{old('emergency_relation',$membership_update->emergency_relation)}}@endif"  type="text" name="emergency_relation">

                        </div>
                    </div>
                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Contact No.:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('emergency_contact')) style="border-color:red;" @endif id="emergency_contact" type="text" name="emergency_contact" value="@if($init==0){{old('emergency_contact')}}@else{{old('emergency_contact',$membership_update->emergency_contact)}}@endif" class="form-control input-height" placeholder="Enter Mobile Number">
                  </div>
                </div>

<br><br>
                        <h6 class="box-title" style="color: black; text-align: center;">CONTACT INFORMATION</h6>
               
                    <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Mobile (a): <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mob_a')) style="border-color:red;" @endif id="mob_a" type="text" name="mob_a" value="@if($init==0){{old('mob_a')}}@else{{old('mob_a',$membership_update->mob_a)}}@endif" class="form-control input-height" placeholder="Enter First Mobile Number">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Mobile (b):</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mob_b')) style="border-color:red;" @endif id="mob_b" type="number" name="mob_b" value="@if($init==0){{old('mob_b')}}@else{{old('mob_b',$membership_update->mob_b)}}@endif" class="form-control input-height" placeholder="Enter Second Mobile Number">
                  </div>
                </div>
                <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Mobile (c): </label>
          <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input @if ($errors->has('tel_a')) style="border-color:red;" @endif id="tel_a" type="text" name="tel_a" value="@if($init==0){{old('tel_a')}}@else{{old('tel_a',$membership_update->tel_a)}}@endif" class="form-control input-height" placeholder="Enter Third Mobile Number">
                  </div>
                </div>
            <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Telephone: </label>
          <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input @if ($errors->has('tel_b')) style="border-color:red;" @endif id="tel_b" type="text" name="tel_b" value="@if($init==0){{old('tel_b')}}@else{{old('tel_b',$membership_update->tel_b)}}@endif" class="form-control input-height" placeholder="Enter Telephone Number">
                  </div>
                </div>
                 

                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Personal Email:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
    <input @if ($errors->has('personal_email')) style="border-color:red;" @endif id="p-email" type="text" name="personal_email" class="form-control input-height" value="@if($init==0){{old('personal_email')}}@else{{old('personal_email',$membership_update->personal_email)}}@endif" placeholder="Enter Personal E-mail">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Official Email: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('official_email')) style="border-color:red;" @endif id="o-emaill" type="text" name="official_email" class="form-control input-height" value="@if($init==0){{old('official_email')}}@else{{old('official_email',$membership_update->official_email)}}@endif" placeholder="Enter Official E-mail">
                  </div>
                </div>


                   <br><br>
                      <h6 class="box-title" style="color: black; text-align: center;">CURRENT ADDRESS</h6>
                
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_address')) style="border-color:red;" @endif id="cur_address" type="text" name="cur_address" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('cur_address')}}@else{{old('cur_address',$membership_update->cur_address)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_city')) style="border-color:red;" @endif  id="cur_city" type="text" name="cur_city" class="form-control input-height" placeholder="Enter City name" value="@if($init==0){{old('cur_city')}}@else{{old('cur_city',$membership_update->cur_city)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_country')) style="border-color:red;" @endif  id="cur_country" type="text" name="cur_country" class="form-control input-height" placeholder="Enter Country name" value="@if($init==0){{old('cur_country')}}@else{{old('cur_country',$membership_update->cur_country)}}@endif">
                  </div>
                </div>


                </div>

 <div class="col-sm-6">

                 <br>
                 <h6 class="box-title" style="color: black; text-align: center;">PERMANENT ADDRESS</h6>
               
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_address')) style="border-color:red;" @endif id="per_address" type="text" name="per_address" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('per_address')}}@else{{old('per_address',$membership_update->per_address)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_city')) style="border-color:red;" @endif  id="per_city" type="text" name="per_city" class="form-control input-height" placeholder="Enter City name" value="@if($init==0){{old('per_city')}}@else{{old('per_city',$membership_update->per_city)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_country')) style="border-color:red;" @endif  id="per_country" type="text" name="per_country" class="form-control input-height" placeholder="Enter Country name" value="@if($init==0){{old('per_country')}}@else{{old('per_country',$membership_update->per_country)}}@endif">
                  </div>
                </div>

                <br><br>
                <h6 class="box-title" style="color: black; text-align: center;">MEMBERSHIP INFORMATION</h6>
       
          <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Membership Category:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('mem_category_id')) style="border-color:red;" @endif @if($init==0) onchange="membershipnum(this.value)" @else onchange="editmembershipnum(this.value)" @endif id="categoryselect" class="form-control" name="mem_category_id">

                                <option label="Choose Category">
                                </option>
                                @foreach($mem_category as $memcategory)
                                @if($init==1)
                                 <option @if(old('mem_category_id',$membership_update->mem_category_id)==$memcategory->id)  selected @endif  value="{{ $memcategory->id }}">
                                    {{ $memcategory->desc }}
                                </option>
                                @else
                                 <option @if(old('mem_category_id')==$memcategory->id)  selected @endif  value="{{ $memcategory->id }}">
                                    {{ $memcategory->desc }}
                                </option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>
            <div class="row mg-t-10">
                        <label>
                        </label>
                        <label class="col-sm-4 form-control-label">
                            Kinship:
                        </label>

                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
             <input @if($errors->has('kinship_name')) style="border-color:red;" @endif id="kinship_name" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('kinship_name')}}@else{{old('kinship_name',$varkinship)}}@endif" type="text" name="kinship_name" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">
              <input @if($errors->has('kinship')) style="border-color:red;"  @endif id="kinship" autocomplete="off" value="@if($init==0){{old('kinship')}}@else{{old('kinship',$membership_update->kinship)}}@endif"
                                                               type="hidden" name="kinship">

 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                        </div>


                         <label class="col-sm-1 form-control-label" style="color: black;">
                            Transfer:
                        </label>
   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
             <input @if($errors->has('transfer')) style="border-color:red;" @endif id="transfer" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('transfer')}}@else{{old('transfer',$vartransferred)}}@endif" type="text" name="transfer" onkeyup="customerdatatransfer(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">
             <input @if($errors->has('transferred_from')) style="border-color:red;"  @endif id="transferred_from" autocomplete="off" value="@if($init==0){{old('transferred_from')}}@else{{old('transferred_from',$membership_update->transferred_from)}}@endif" type="hidden" name="transferred_from">

 <ul id="areabox2" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                        </div>


                    </div>
                    <!-- row -->

                      <div class="row mg-t-10">
                        <label>
                        </label>
                        <label class="col-sm-4 form-control-label">
                            Membership Number:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                            <input  @if ($errors->has('mem_no')) style="border-color:red;" @endif id="memship-number" class="form-control input-height" type="text" value="@if($init==0){{old('mem_no')}}@else{{old('mem_no',$membership_update->mem_no)}}@endif" placeholder="Enter Membership Number of Applicant" name="mem_no">
                        </div>
                        @can('Edit Membership Number')
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                          <input id="check" class="form-control input-height" type="checkbox" name="check" onclick="checks()">
                        </div>
                        @endcan

                    </div>
                    <!-- row -->
         
                    <div class="row mg-t-10">
                        <label>
                        </label>
                        <label class="col-sm-4 form-control-label">
                            Membership Date:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('membership_date')) style="border-color:red;" @endif id="memship-date"  class="form-control input-height" placeholder="dd/mm/yyyy" type="text" autocomplete="off" value="@if($init==0){{old('membership_date')}}@else{{old('membership_date',formatDateToShow($membership_update->membership_date))}}@endif" name="membership_date">

                        </div>

                    </div>
                    <!-- row -->

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Status of Membership Card:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('card_status')) style="border-color:red;" @endif class="form-control" name="card_status" value="@if($init==0){{old('card_status')}}@else{{old('card_status',$membership_update->card_status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('card_status',$membership_update->card_status)=='In-Process') selected @endif @endif value="In-Process">
                                    In-Process
                                </option>
                                <option @if(old('card_status',$membership_update->card_status)=='Printed') selected @endif value="Printed">
                                    Printed
                                </option>
                                <option @if(old('card_status',$membership_update->card_status)=='Received') selected @endif value="Received">
                                    Received
                                </option>
                                <option @if(old('card_status',$membership_update->card_status)=='Issued') selected @endif value="Issued">
                                    Issued
                                </option>
                                <option @if(old('card_status',$membership_update->card_status)=='Re-Printed') selected @endif value="Re-Printed">
                                    Re-Printed
                                </option>

                                @else

                                <option @if($init==0) selected="" @else @if(old('card_status')=='In-Process') selected @endif @endif value="In-Process">
                                    In-Process
                                </option>
                                <option @if(old('card_status')=='Printed') selected @endif value="Printed">
                                    Printed
                                </option>
                                <option @if(old('card_status')=='Received') selected @endif value="Received">
                                    Received
                                </option>
                                <option @if(old('card_status')=='Issued') selected @endif value="Issued">
                                    Issued
                                </option>
                                <option @if(old('card_status')=='Re-Printed') selected @endif value="Re-Printed">
                                    Re-Printed
                                </option>

                                @endif


                            </select>
                        </div>
                    </div>


                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Card Issue Date:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('card_issue_date')) style="border-color:red;" @endif id="card-date" class="form-control input-height" autocomplete="off" type="text" name="card_issue_date" placeholder="dd/mm/yyyy" value="@if($init==0){{old('card_issue_date')}}@else{{old('card_issue_date',formatDateToShow($membership_update->card_issue_date))}}@endif">

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Card Expiry Date:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('card_exp')) style="border-color:red;" @endif id="card-exp" class="form-control input-height" autocomplete="off" type="text" name="card_exp" placeholder="dd/mm/yyyy" value="@if($init==0){{old('card_exp')}}@else{{old('card_exp',formatDateToShow($membership_update->card_exp))}}@endif">

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Barcode Card Number:
                        </label>
<div class="col-sm-8 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('mem_barcode')) style="border-color:red;" @endif class="form-control input-height" placeholder="Enter Primary Card's Barcode Number" type="text" name="mem_barcode" value="@if($init==0){{old('mem_barcode')}}@else{{old('mem_barcode',$membership_update->mem_barcode)}}@endif" autocomplete="off">
                        </div>
                    </div>

                     <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Member Type:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <select name="mem_classification_id" @if ($errors->has('mem_classification_id')) style="border-color:red;" @endif class="form-control" >
                        <option label="Choose Type"></option>

                        @foreach($mem_classification as $memclassification)
                        @if($init==1)
                        <option @if(old('mem_classification_id',$membership_update->mem_classification_id)==$memclassification->id) selected @endif value="{{ $memclassification->id }}">
                        {{ $memclassification->desc }}
                        </option>
                        @else
                        <option @if(old('mem_classification_id')==$memclassification->id)  selected @endif  value="{{ $memclassification->id }}">
                                    {{ $memclassification->desc }}
                                </option>
                        @endif
                        @endforeach
                        </select>
                        </div>
                        <label class="col-sm-1 form-control-label"  style="color: black;">
                            Remarks:

                        </label>
<div class="col-sm-3 mg-t-10 mg-sm-t-0">
<textarea @if ($errors->has('status_remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter Remarks for alotted Status" rows="2" name="status_remarks">@if($init==0){{old('status_remarks')}}@else{{old('status_remarks',$membership_update->status_remarks)}}@endif</textarea>
                        </div>
                    </div>
                 <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                           Membership Status:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <select name="active" @if ($errors->has('active')) style="border-color:red;" @endif class="form-control" >
                        <option label="Choose Status"></option>

                        @foreach($mem_status as $status)
                        @if($init==1)
                        <option @if(old('active',$membership_update->active)==$status->id) selected @endif value="{{ $status->id }}">
                        {{ $status->desc }}
                        </option>
                        @else
                        <option @if(old('active')==$status->id)  selected @endif  value="{{ $status->id }}">
                                    {{ $status->desc }}
                                </option>
                        @endif
                        @endforeach
                        </select>
                        </div>
                         <label class="col-sm-1 form-control-label"  style="color: black;">
                            Remarks:

                        </label>
<div class="col-sm-3 mg-t-10 mg-sm-t-0">
<textarea @if ($errors->has('active_remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter Details" rows="2" name="active_remarks">@if($init==0){{old('active_remarks')}}@else{{old('active_remarks',$membership_update->active_remarks)}}@endif</textarea>
                        </div>
                    </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                          
                        </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <label for="from" class="headingsetting">From:</label>
                  <input @if ($errors->has('from')) style="border-color:red;" @endif id="from" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" type="text" name="from" value="@if($init==0){{old('from')}}@else{{old('from',formatDateToShow($membership_update->from))}}@endif">
                        </div>
                        
<div class="col-sm-4 mg-t-10 mg-sm-t-0">
  <label for="to" class="headingsetting">To:</label>
<input @if ($errors->has('to')) style="border-color:red;" @endif id="to" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" type="text" name="to" value="@if($init==0){{old('to')}}@else{{old('to',formatDateToShow($membership_update->to))}}@endif">                        </div>
                    </div>
<br><br>
                         <h6 class="box-title" style="color: black; text-align: center;">MEMBERSHIP FEE</h6>

                    <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                            Membership Fee:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0" >
                            <input @if ($errors->has('mem_fee')) style="border-color:red;" @endif  id="mem_fee" autocomplete="off" class="form-control input-height charamt" type="number" name="mem_fee" placeholder="Fee of Membership for selected Category" value="@if($init==0){{old('mem_fee')}}@else{{old('mem_fee',$membership_update->mem_fee)}}@endif">

                        </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Additional Membership Charges: </label>

                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input  @if ($errors->has('additional_mem')) style="border-color:red;" @endif  id="additional_mem" type="number" name="additional_mem" class="form-control input-height" placeholder="(if any)" oninput="additionalsofmem()" value="@if($init==0){{old('additional_mem')}}@else{{old('additional_mem',$membership_update->additional_mem)}}@endif">
                  </div>

             <label class="col-sm-1 form-control-label"  style="color: black;">Remarks: </label>
          <div class="col-sm-3 mg-t-10 mg-sm-t-0">
            <textarea  @if ($errors->has('additional_mem_remarks')) style="border-color:red;" @endif  name="additional_mem_remarks" id="additional_mem_remarks" class="form-control" placeholder="Reason for Additional Charges" rows="2">@if($init==0){{old('additional_mem_remarks')}}@else{{old('additional_mem_remarks',$membership_update->additional_mem_remarks)}}@endif</textarea>
                  </div>
                </div>
                 <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Discount Amount: </label>
          <div class="col-sm-4 mg-t-10 mg-sm-t-0">
            <input  @if ($errors->has('mem_discount')) style="border-color:red;" @endif  id="mem_discount" class="form-control input-height" placeholder="(if any)" oninput="additionalsofmem()" type="number" name="mem_discount" value="@if($init==0){{old('mem_discount')}}@else{{old('mem_discount',$membership_update->mem_discount)}}@endif">
                  </div>

                  <label class="col-sm-1 form-control-label"  style="color: black;">Remarks:</label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
    <textarea  @if ($errors->has('mem_discount_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Reason of Discount" rows="2" id="mem_discount_remarks" name="mem_discount_remarks">@if($init==0){{old('mem_discount_remarks')}}@else{{old('mem_discount_remarks',$membership_update->mem_discount_remarks)}}@endif</textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                            Total Membership Fee:
                        <span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                          <input  @if ($errors->has('total')) style="border-color:red;" @endif  id="total" class="form-control input-height" type="number" name="total" value="@if($init==0){{old('total')}}@else{{old('total',$membership_update->total)}}@endif" placeholder="Total Membership Fee">
                        </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                           Amount in Words:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                          <input  @if ($errors->has('mem_in_words')) style="border-color:red;" @endif  id="mem_in_words" class="form-control input-height" type="text" name="mem_in_words" value="@if($init==0){{old('mem_in_words')}}@else{{old('mem_in_words',$membership_update->mem_in_words)}}@endif" placeholder="Total Membership Fee in Words" readonly style="background-color: #c1c1c1">
                        </div>
                </div>
               <br><br>
                         <h6 class="box-title" style="color: black; text-align: center;">MAINTENANCE CHARGES</h6>
                  <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                            Maintenance Charges:
                        <span class="tx-danger">*</span>
                        </label>
                         <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input  @if ($errors->has('maintenance_amount')) style="border-color:red;" @endif type="number" name="maintenance_amount" id="maintenance_amount" class="form-control input-height" autocomplete="off" placeholder="Charges of Maintenance for selected category" value="@if($init==0){{old('maintenance_amount')}}@else{{old('maintenance_amount',$membership_update->maintenance_amount)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                           Additional Maintenance Charges:

                        </label>
                         <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <input  @if ($errors->has('additional_mt')) style="border-color:red;" @endif  id="additional_mt" type="number" name="additional_mt" class="form-control input-height" oninput="additionalsofmt()" placeholder="(if any)" value="@if($init==0){{old('additional_mt')}}@else{{old('additional_mt',$membership_update->additional_mt)}}@endif">
                  </div>
                   <label class="col-sm-1 form-control-label" style="color: black;">
                           Remarks:

                        </label>
                         <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <textarea  @if ($errors->has('additional_mt_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Reason for Additional Charges" rows="2" name="additional_mt_remarks" id="additional_mt_remarks">@if($init==0){{old('additional_mt_remarks')}}@else{{old('additional_mt_remarks',$membership_update->additional_mt_remarks)}}@endif</textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                          Discount Amount:
                        </label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
        <input @if ($errors->has('mt_discount')) style="border-color:red;" @endif id="mt_discount" class="form-control input-height" placeholder="(if any)" type="number" name="mt_discount" oninput="additionalsofmt()" value="@if($init==0){{old('mt_discount')}}@else{{old('mt_discount',$membership_update->mt_discount)}}@endif">
                  </div>
                   <label class="col-sm-1 form-control-label"  style="color: black;">
                            Remarks:

                        </label>
                         <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                      <textarea @if ($errors->has('mt_discount_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Enter reason of Discount" rows="2" name="mt_discount_remarks" id="mt_discount_remarks">@if($init==0){{old('mt_discount_remarks')}}@else{{old('mt_discount_remarks',$membership_update->mt_discount_remarks)}}@endif</textarea>
                  </div>
                </div>
                 <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                       Total Maintenance Charges:
                        <span class="tx-danger">*</span>
                        </label>
                         <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                         <input @if ($errors->has('total_maintenance')) style="border-color:red;" @endif  id="total_maintenance" class="form-control input-height" type="number" name="total_maintenance" placeholder="Total Maintenance Charges" value="@if($init==0){{old('total_maintenance')}}@else{{old('total_maintenance',$membership_update->total_maintenance)}}@endif">
                  </div>

                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                           Amount in Words:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                          <input  @if ($errors->has('mt_in_words')) style="border-color:red;" @endif  id="mt_in_words" class="form-control input-height" type="text" name="mt_in_words" value="@if($init==0){{old('mt_in_words')}}@else{{old('mt_in_words',$membership_update->mt_in_words)}}@endif" placeholder="Total Maintenance Charges in Words" readonly style="background-color: #c1c1c1">
                        </div>
                </div>
                 <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label"  style="color: black;">
                            Per Day Maintenance Charges:
 <span class="tx-danger">*</span>
                        </label>
                         <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('maintenance_per_day')) style="border-color:red;" @endif  id="maintenance_per_day" class="form-control input-height" type="text" name="maintenance_per_day" readonly style="background-color: #c1c1c1" placeholder="Maintenance per day" value="@if($init==0){{old('maintenance_per_day')}}@else{{old('maintenance_per_day',$membership_update->maintenance_per_day)}}@endif">
                         </div>
                       </div>
                <br>
 <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Membership Done By:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                        <select name="done_by" @if ($errors->has('done_by')) style="border-color:red;" @endif class="form-control" >
                        <option label="Choose Option"></option>

                        @foreach($bds as $bd)
                        @if($init==1)
                        <option @if(old('done_by',$membership_update->done_by)==$bd->id) selected @endif value="{{ $bd->id }}">
                        {{ $bd->name }}
                        </option>
                        @else
                        <option @if(old('done_by')==$bd->id)  selected @endif  value="{{ $bd->id }}">
                                    {{ $bd->name }}
                                </option>
                        @endif
                        @endforeach
                        </select>
                        </div>
                       
                    </div>
                    <div class="row mg-t-10">
                                      <label class="col-sm-4 form-control-label" style="color: black;">
                            Comment Box:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea  @if ($errors->has('remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter Remarks" rows="2" name="remarks">@if($init==0){{old('remarks')}}@else{{old('remarks',$membership_update->remarks)}}@endif</textarea>
                        </div>

                </div>

</div>
</div>


      <div class="row">
<div class="col-sm-6">


</div>
<div class="col-sm-6">

                </div>
            </div>
            </div>
            <!-- col-6 -->
        </div>

      
                 @if($init==1)
           <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
  <div class="form-layout-footer mg-t-30">
               &nbsp&nbsp&nbsp&nbsp


@if(Gate::check('Update Member Barcode') )
<button type="input" name="save" class="btn btn-info">Update Barcode</button>
@else
<button type="input" name="save" class="btn btn-info">Update</button>
@endif



              
                  &nbsp&nbsp
                  <a href="{{ url('club-hospitality/membership-vue') }}" class="btn btn-secondary">Cancel</a>
             </div>
              </div>
    </div>

             @else
             <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
            <div class="form-layout-footer mg-t-30">
               &nbsp&nbsp&nbsp&nbsp

               <input type="submit" name="save" class="btn btn-info" value="Save & Continue">

        &nbsp&nbsp
    <a href="{{ url('club-hospitality/membership-vue') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
    </div>
             @endif

    </form>


    </div>
    <!-- br-section-wrapper -->
</div>
<!-- br-pagebody -->
@endsection

@push('jscode')
<script>
      $(function(){

        // showing modal with effect
        $('.modal-effect').on('click', function(){
          var effect = $(this).attr('data-effect');
          $('#modaldemo1').addClass(effect, function(){
            $('#modaldemo1').modal('show');
          });
          return false;
        });

        // hide modal with effect
        $('#modaldemo1').on('hidden.bs.modal', function (e) {
          $(this).removeClass (function (index, className) {
              return (className.match (/(^|\s)effect-\S+/g) || []).join(' ');
          });
        });
      });
    </script>
   <script>
      $(function(){

        // showing modal with effect
        $('.modal-effect').on('click', function(){
          var effect = $(this).attr('data-effect');
          $('#modaldemo8').addClass(effect, function(){
            $('#modaldemo8').modal('show');
          });
          return false;
        });

        // hide modal with effect
        $('#modaldemo8').on('hidden.bs.modal', function (e) {
          $(this).removeClass (function (index, className) {
              return (className.match (/(^|\s)effect-\S+/g) || []).join(' ');
          });
        });
      });
    </script>


    <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v =0;
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
                    console.log(obj);
                     var memnom=document.getElementById('memship-number').value;
                     if(memnom.length==9){
                      document.getElementById('memship-number').value = memnom.slice(0,4)+' '+obj.id+'-'+obj.kins;
                    }else{
                      document.getElementById('memship-number').value = memnom.slice(0,2)+' '+obj.id+'-'+obj.kins;
                    }
                        

                          $fname=obj.first_name?obj.first_name+' ':'';
                          $mname=obj.middle_name?obj.middle_name+' ':'';
                          $lname=obj.applicant_name?obj.applicant_name:'';
                          $mem=obj.mem_no?' '+'('+obj.mem_no+')':'';
                        document.getElementById('kinship_name').value = $fname+$mname+$lname+$mem;
/*document.getElementById('categoryselect').value = obj.mem_category_id;*/
                        document.getElementById('kinship').value = obj.id;

                        $("#kinship_name").prop("readonly", true);
                       // $("#kinship").prop("readonly", true);
                      
                    jQuery('#areabox').html('');

                }


            });
        }


        function customerdatavaluetransfer(val) {
            let v =0;
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
                    console.log(obj);
                     var memnom=document.getElementById('memship-number').value;
                     if(memnom.length==9){
                      document.getElementById('memship-number').value = memnom.slice(0,4)+' '+obj.id;
                    }else{
                      document.getElementById('memship-number').value = memnom.slice(0,2)+' '+obj.id;
                    }
                        

                          $fname=obj.first_name?obj.first_name+' ':'';
                          $mname=obj.middle_name?obj.middle_name+' ':'';
                          $lname=obj.applicant_name?obj.applicant_name:'';
                          $mem=obj.mem_no?' '+'('+obj.mem_no+')':'';
                        document.getElementById('transfer').value = $fname+$mname+$lname+$mem;
                        document.getElementById('transferred_from').value = obj.id;

                        $("#transfer").prop("readonly", true);
                      
                    jQuery('#areabox2').html('');

                }


            });
        }
    </script>

    <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v = 0;
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


         function customerdatatransfer(val) {
            let v = 0;
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    jQuery('#areabox2').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                       $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                  let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        let status = v == 1 ? '' : '('+val1.mem_status.desc+')';
                        $("#areabox2").append(`<li onclick="customerdatavaluetransfer('${val1.id}')">${name} - ${code} ${status}<li>`);

                    });
$('#areabox2').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>


<script type="text/javascript">
    $('#wizard1').steps({
  headerTag: 'h3',
  bodyTag: 'section',
  autoFocus: true,
  titleTemplate: '#index# #title#'
});
</script>
<script type="text/javascript">
//$('#memship-number').mask('AA 0000');
//$('#mem_name').attr('maxlength', 50);
//$('#father_name').attr('maxlength', 50);
//$('#father_number').mask('AF-0000');
$('#mem-cnic').mask('00000-0000000-0');
$('#passport_no').mask('AAAAAAAA');
//$('#mem-education').attr('maxlength', 100);
$('#emergency_contact').mask('00000000000');
$('#tel_a').mask('00000000000');
$('#tel_b').mask('00000000000');
$('#mob_a').mask('00000000000');
//$('#mob_b').mask('00000000000');
//$('#p-email').attr('maxlength', 200);
//$('#o-email').attr('maxlength', 200);


/*$('#add').attr('maxlength', 300);
$('#city').attr('maxlength', 50);
$('#country').attr('maxlength', 50);


$('#bussiness').attr('maxlength', 100);
$('#pos').attr('maxlength', 100);*/
$('#experience').mask('00/0000 - 00/0000');
/*$('#dep').attr('maxlength', 100);
$('#govt_pos').attr('maxlength', 100);
$('#grade').attr('maxlength', 20);
$('#rank').attr('maxlength', 50);
$('#anymess').attr('maxlength', 3);*/
$('#when').mask('00/0000');
$('#aff_period').mask('00/0000 - 00/0000');

$('#fm_cnic').mask('00000-0000000-0');
$('#fm_contact').mask('0000-0000000');
$('#sup_no').mask('AF-0000-A');

/*$('#ref_name').attr('maxlength', 50);*/
$('#mem_number').mask('AF-0000');

$('#mobile_no').mask('0000-0000000');


$('#owner_cnic').mask('00000-0000000-0');
/*$('#driver_name').attr('maxlength', 50);*/
/*$('#driver_relation').attr('maxlength', 100);*/
$('#driver_cnic').mask('00000-0000000-0');
/*$('#owner').attr('maxlength', 50);
$('#model').attr('maxlength', 100);
$('#color').attr('maxlength', 100);
$('#car_no').attr('maxlength', 50);
$('#engine_no').attr('maxlength', 50);
$('#chassis_no').attr('maxlength', 50);*/
</script>
            

            <script type="text/javascript">
        var val;

        function customerdatavaluetwo(val) {
            let v = 0;
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

                        document.getElementById('father_mem_no').value = obj.mem_no;
          
                    jQuery('#areaboxtwo').html('');

                }


            });
        }
    </script>
     <script type="text/javascript">
        var val;

        function customerdatatwo(val) {
            let v = 0;
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    jQuery('#areaboxtwo').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                        $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                  let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        $("#areaboxtwo").append(`<li onclick="customerdatavaluetwo('${val1.id}')">${name} - ${code}<li>`);


                    });

      $('#areaboxtwo').show();             

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
function membershipnum(id){

event.preventDefault();
$.ajax({
type : 'GET',
url : '{{ url('/') }}/club-hospitality/membership/getcategory/'+id,
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
success: function(data){
var appno =document.getElementById("app-number").value;
$('#memship-number').val(data+' '+appno);
//$('.minicart-items').append(obj.html);

               membershipfee(id);
               maintenancefee(id);
                    }
                });
}


</script>

@if($init==1){
<script type="text/javascript">
$( document ).ready(function() {
 var myttt =document.getElementById("total_maintenance").value;
 if(Number.isNaN(myttt)){
                document.getElementById("maintenance_per_day").value='';
              }
              else{
                   document.getElementById("maintenance_per_day").value= (myttt/30).toFixed(2);
              }
    
  });
</script>
}
@endif



<script type="text/javascript">
function editmembershipnum(id){

event.preventDefault();
$.ajax({
type : 'GET',
url : '{{ url('/') }}/club-hospitality/membership/getcategory/'+id,
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
success: function(data){
var appno =document.getElementById("app-number").value;
$('#memship-number').val(data+' '+appno);
//$('.minicart-items').append(obj.html);
 membershipfee(id);
               maintenancefee(id);
                    }
                });
}


</script>

<script type="text/javascript">
  function addCommas(nStr){
 nStr += '';
 var x = nStr.split('.');
 var x1 = x[0];
 var x2 = x.length > 1 ? '.' + x[1] : '';
 var rgx = /(\d+)(\d{3})/;
 while (rgx.test(x1)) {
  x1 = x1.replace(rgx, '$1' + ',' + '$2');
 }
 return x1 + x2;
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

@if($init==1)
 <script type="text/javascript">
        $(document).ready(function () {
document.getElementById("mem_in_words").value = inWords(parseFloat(document.getElementById("total").value.replace(/,/g, '')));
document.getElementById("mt_in_words").value = inWords(parseFloat(document.getElementById("total_maintenance").value.replace(/,/g, '')));
        });
</script>
@endif

<script type="text/javascript">
function membershipfee(id){

event.preventDefault();
$.ajax({
type : 'GET',
url : '{{ url('/') }}/club-hospitality/membership/getfee/'+id,
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
success: function(data){
var object = parseFloat(data);

/*$('#mem_fee').val(addCommas(object));*/
$('#mem_fee').val(object);
$('#total').val(object);
$('#mem_in_words').val(inWords(object));
//$('.minicart-items').append(obj.html);


                    }
                });
}


</script>

<script type="text/javascript">
function maintenancefee(id){

event.preventDefault();
$.ajax({
type : 'GET',
url : '{{ url('/') }}/club-hospitality/membership/getmaintenance/'+id,
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
success: function(data){
var object = parseFloat(data);

$('#maintenance_amount').val(object);
$('#total_maintenance').val(object);
$('#mt_in_words').val(inWords(object));
$('#maintenance_per_day').val((data/30).toFixed(2));
//$('.minicart-items').append(obj.html);


                    }
                });
}


</script>

<script type="text/javascript">
   function additionalsofmem() {

                var first =  parseFloat(document.getElementById("mem_fee").value.replace(/,/g, ''));
                var second = parseFloat(document.getElementById("additional_mem").value.replace(/,/g, ''));
                var third = parseFloat(document.getElementById("mem_discount").value.replace(/,/g, ''));
                 if(Number.isNaN(first)){
                first=0;
              }
                if(Number.isNaN(second)){
                second=0;
              }
               if(Number.isNaN(third)){
                third=0;
              }
                var result = first + second;
                var final = result - third;

                document.getElementById("total").value = final;
                document.getElementById("mem_in_words").value = inWords(final);

            }
</script>

<script type="text/javascript">
   function additionalsofmt() {

                var first =  parseFloat(document.getElementById("maintenance_amount").value.replace(/,/g, ''));
                var second = parseFloat(document.getElementById("additional_mt").value.replace(/,/g, ''));
                var third = parseFloat(document.getElementById("mt_discount").value.replace(/,/g, ''));
                 if(Number.isNaN(first)){
                first=0;
              }
                if(Number.isNaN(second)){
                second=0;
              }
               if(Number.isNaN(third)){
                third=0;
              }
                var result = first + second;
                var final = result - third;

                document.getElementById("total_maintenance").value = final;
                document.getElementById("mt_in_words").value = inWords(final);
               var pday = (final/30).toFixed(2);
               document.getElementById("maintenance_per_day").value = pday;
            }
</script>

<script type="text/javascript">
$('#form').submit(function(event){
event.preventDefault();
 $.ajax({
    type : 'POST',
    url : '{{ url('club-hospitality/membership/membership-aeu/address/') }}/ {{ Request::segment(4) }}',
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  data : $('#form').serialize(),
  success: function(data){
   var obj = JSON.parse(data);
  if(obj)
  {

  $('#addressdata').html(data);

  }

      }
      });
      });

</script>

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>


  <script>
    $( function() {
    $( "#mem-dob" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

     $( function() {
    $( "#from" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#to" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

     $( function() {
    $( "#card-date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );


     $( function() {
    $( "#card-exp" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#memship-date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
  </script>

@if(Request::segment(4))
<script>
$("#wizard1 li:nth-child(n)").removeClass("disabled");
</script>
@else
<script type="text/javascript">
$(".actions li:nth-child(2)").addClass("disabled");
</script>

@endif


<script type="text/javascript">

    $( document ).ready(function() {
/*console.log('1233');*/
if($("#check").prop('checked') == true){
document.getElementById('memship-number').readOnly = false;
}
else if($("#check").prop('checked') == false){
  document.getElementById('memship-number').readOnly = true;
}
});

</script>


 <script type="text/javascript">

            var val;

        function coaaccountdata(val) {
            
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "searchid": val,
                    
                },
                success: function (data) {

                    jQuery('#areabox23').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                        $("#areabox23").append(`<li onclick="coaaccountdatavalue('${val1.id}')">${val1.name} - ${val1.code}<li>`);

                    });
$('#areabox23').show();
                 

                }
            });
        }

</script>

<script type="text/javascript">
        var val;

        function coaaccountdatavalue(val) {
          
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "theid": val,
                 
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    console.log(obj);
                  
                          $fname=obj.name?obj.name+' ':'';
                     
                          $lname=obj.code?obj.code:'';

                        document.getElementById('coa_code').value = $fname+'-'+' '+$lname;
 
                        document.getElementById('mem_unique_code').value = obj.code;
                        document.getElementById('name').value = obj.name;

                        $("#coa_code").prop("readonly", true);
                     
                      
                    jQuery('#areabox23').html('');

                }


            });
        }
</script>


<script type="text/javascript">

  function checks(){
/*console.log('1233');*/
if($("#check").prop('checked') == true){
document.getElementById('memship-number').readOnly = false;
}
else if($("#check").prop('checked') == false){
  document.getElementById('memship-number').readOnly = true;
}
    } 

</script>

@endpush
