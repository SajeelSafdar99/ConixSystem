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

.w3-bar .w3-bar-item {
    padding: 8px 16px;
    float: left;

    border: none;
   display: inline-block;
border-radius: 5px;
margin: 0;

margin-right: 8px;
    outline: 0;
    height: 60px;
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

input[readonly] {
  background-color: white !important;
}

textarea[readonly] {
  background-color: white !important;
}

select[disabled] {
  background-color: white !important;
}
</style>
<div class="br-pagebody">
    <div>
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">
            Membership
        </h6>
        <div style="text-align: right;">
            <a href="">
                <img border="0/" height="28" src="{{ url('assets/images/reload.png') }}" title="Reload Page" width="28">
                </img>
            </a>
        </div>

       
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership') }}">Memberships List</a></li>
  <li><a href>View Membership</a></li>
</ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
<br>
              
    <form method="post" enctype="multipart/form-data" action="{{ url('club-hospitality/membership/update') }}/{{ $membership_update->id }}">
    @csrf
                <div class="col-xl-12 ">
            <div class="form-layout form-layout-4 ">
                <div class="row">
               <div class="col-sm-6">
                    <br>
                <h6 class="box-title" style="color: black; text-align: center;">PERSONAL INFORMATION</h6>
                 <br>
                    <div  class="row ">
                        <label class="col-sm-4 form-control-label {{ $errors->has('app_no') ? ' has-error' : '' }}">
                            Application Number:
                          <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div  class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input id="app-number" class="form-control input-height" type="Number"  placeholder="Enter Application Number of Membership" value="@if($init==0){{$increment_number}}@else{{old('application_no', $membership_update->application_no)}}@endif" name="app_no" readonly>

                        </div>
                         @if ($errors->has('app_no'))
                        <span class="help-block">
                        <strong>{{ $errors->first('app_no') }}</strong>
                        </span>
                        @endif
                    </div>
                    <!-- row -->
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Name of Applicant:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('mem_name')) style="border-color:red;" @endif id="mem-name" class="form-control input-height" placeholder="Enter Name of the Applicant" value="@if($init==0){{old('mem_name')}}@else{{old('applicant_name',$membership_update->applicant_name)}}@endif"  type="text" name="mem_name" readonly>

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
                            <input @if ($errors->has('father_name')) style="border-color:red;" @endif id="father_name" class="form-control input-height" placeholder="Enter Father's or Husband's Name" type="text" name="father_name" value="@if($init==0){{old('father_name')}}@else{{old('father_name',$membership_update->father_name)}}@endif" readonly>

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            If father is already a member then Membership No:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('father_mem_no')) style="border-color:red;" @endif id="father_number" class="form-control input-height" placeholder="Enter Father's Membership Number" type="text" name="father_mem_no" value="@if($init==0){{old('father_mem_no')}}@else{{old('father_mem_no',$membership_update->father_mem_no)}}@endif" readonly>

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
                            <input @if ($errors->has('cnic')) style="border-color:red;" @endif id="mem-cnic" class="form-control input-height" placeholder="Enter CNIC Number (13 digits)" type="text" name="cnic" value="@if($init==0){{old('cnic')}}@else{{old('cnic',$membership_update->cnic)}}@endif" readonly>
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
                            <select @if ($errors->has('gender')) style="border-color:red;" @endif class="form-control" name="gender" value="@if($init==0){{old('gender')}}@else{{old('gender',$membership_update->gender)}}@endif" disabled="true">
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
   <input @if ($errors->has('date_of_birth')) style="border-color:red;" @endif id="mem-dob" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" placeholder="Enter Date of Birth" type="text" name="date_of_birth" value="@if($init==0){{old('date_of_birth')}}@else{{old('date_of_birth',formatDateToShow($membership_update->date_of_birth))}}@endif" readonly>

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Education:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('education')) style="border-color:red;" @endif id="mem-education" class="form-control input-height" placeholder="Enter Complete Education of the Applicant" type="text" name="education" value="@if($init==0){{old('education')}}@else{{old('education',$membership_update->education)}}@endif" readonly>

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            NTN (If any):
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('ntn')) style="border-color:red;" @endif id="mem-ntn" class="form-control input-height" placeholder="Enter National tax number of the Applicant" type="Number" name="ntn" value="@if($init==0){{old('ntn')}}@else{{old('ntn',$membership_update->ntn)}}@endif" readonly>

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label ">
                            Reason for Seeking Membership:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea class="form-control" placeholder="Enter details" rows="2" name="reason" readonly>@if($init==0){{old('reason')}}@else{{old('reason',$membership_update->reason)}}@endif</textarea>
                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Details of Nearest Relative:

                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea class="form-control" placeholder="Enter details" rows="2" name="details" readonly>@if($init==0){{old('details')}}@else{{old('details',$membership_update->details)}}@endif</textarea>
                        </div>
</div>
                     <div class="row mg-t-10">
                        <label class="col-sm-6 form-control-label"  style="color: black !important;">
                            Member Picture:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                             <img id="picchose" style="width: 200px; height: 100px; margin-left: -135px;" src="@if($init==1) {{ url('') }}/{{old('mem_picture',$membership_update->profilePic?$membership_update->profilePic->url:'')}}@else {{ url('assets/images/nouser.png') }} @endif">
                             @if($init==0)
                            <input @if ($errors->has('mem_picture')) style="border-color:red;" @endif type="file" name="mem_picture" value="@if($init==0){{old('mem_picture')}}@endif">
                             @else
                    <input type="hidden" name="existimg" value="{{old('mem_picture',$membership_update->profilePic?$membership_update->profilePic->url:'')}}">
                            @endif

                        </div>
                    </div>
<br><br>
                        <h6 class="box-title" style="color: black; text-align: center;">CONTACT INFORMATION</h6>
                 <br>
                    <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Mobile (a): <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mob_a')) style="border-color:red;" @endif id="mob_a" type="text" name="mob_a" value="@if($init==0){{old('mob_a')}}@else{{old('mob_a',$membership_update->mob_a)}}@endif" class="form-control input-height" placeholder="Enter First Mobile Number" readonly>
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Mobile (b): <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mob_b')) style="border-color:red;" @endif id="mob_b" type="text" name="mob_b" value="@if($init==0){{old('mob_b')}}@else{{old('mob_b',$membership_update->mob_b)}}@endif" class="form-control input-height" placeholder="Enter Second Mobile Number" readonly>
                  </div>
                </div>
            <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Telephone (a): </label>
          <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input @if ($errors->has('tel_a')) style="border-color:red;" @endif id="tel_a" type="text" name="tel_a" value="@if($init==0){{old('tel_a')}}@else{{old('tel_a',$membership_update->tel_a)}}@endif" class="form-control input-height" placeholder="Enter First Telephone Number" readonly>
                  </div>
                </div>
                 <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Telephone (b): </label>
          <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input @if ($errors->has('tel_b')) style="border-color:red;" @endif id="tel_b" type="text" name="tel_b" value="@if($init==0){{old('tel_b')}}@else{{old('tel_b',$membership_update->tel_b)}}@endif" class="form-control input-height" placeholder="Enter Second Telephone Number" readonly>
                  </div>
                </div>

                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Personal Email: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
    <input @if ($errors->has('personal_email')) style="border-color:red;" @endif id="p-email" type="text" name="personal_email" class="form-control input-height" value="@if($init==0){{old('personal_email')}}@else{{old('personal_email',$membership_update->personal_email)}}@endif" placeholder="Enter Personal E-mail" readonly>
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Official Email: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('personal_email')) style="border-color:red;" @endif id="o-emaill" type="text" name="official_email" class="form-control input-height" value="@if($init==0){{old('official_email')}}@else{{old('official_email',$membership_update->official_email)}}@endif" placeholder="Enter Official E-mail" readonly>
                  </div>
                </div>
                <br><br>
                      <h6 class="box-title" style="color: black; text-align: center;">CURRENT ADDRESS</h6>
                 <br>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_address')) style="border-color:red;" @endif id="cur_address" type="text" name="cur_address" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('cur_address')}}@else{{old('cur_address',$membership_update->cur_address)}}@endif" readonly>
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_city')) style="border-color:red;" @endif  id="cur_city" type="text" name="cur_city" class="form-control input-height" placeholder="Enter City name" value="@if($init==0){{old('cur_city')}}@else{{old('cur_city',$membership_update->cur_city)}}@endif" readonly>
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_country')) style="border-color:red;" @endif  id="cur_country" type="text" name="cur_country" class="form-control input-height" placeholder="Enter Country name" value="@if($init==0){{old('cur_country')}}@else{{old('cur_country',$membership_update->cur_country)}}@endif" readonly>
                  </div>
                </div>
                 <br>
                 <h6 class="box-title" style="color: black; text-align: center;">PERMANENT ADDRESS</h6>
                 <br>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_address')) style="border-color:red;" @endif id="per_address" type="text" name="per_address" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('per_address')}}@else{{old('per_address',$membership_update->per_address)}}@endif" readonly>
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_city')) style="border-color:red;" @endif  id="per_city" type="text" name="per_city" class="form-control input-height" placeholder="Enter City name" value="@if($init==0){{old('per_city')}}@else{{old('per_city',$membership_update->per_city)}}@endif" readonly>
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_country')) style="border-color:red;" @endif  id="per_country" type="text" name="per_country" class="form-control input-height" placeholder="Enter Country name" value="@if($init==0){{old('per_country')}}@else{{old('per_country',$membership_update->per_country)}}@endif" readonly>
                  </div>
                </div>


                </div>

 <div class="col-sm-6">
                <br>
                <h6 class="box-title" style="color: black; text-align: center;">MEMBERSHIP INFORMATION</h6>
        <br>
          <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Membership Category:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('mem_category_id')) style="border-color:red;" @endif onchange="membershipnum(this.value)" id="categoryselect" class="form-control" name="mem_category_id" disabled="true">

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
                            Membership Number:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input  @if ($errors->has('mem_no')) style="border-color:red;" @endif id="memship-number" class="form-control input-height" type="text" value="@if($init==0){{old('mem_no')}}@else{{old('mem_no',$membership_update->mem_no)}}@endif" placeholder="Enter Membership Number of Applicant" name="mem_no" readonly>
                        </div>


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
                            <input @if ($errors->has('membership_date')) style="border-color:red;" @endif id="memship-date"  class="form-control input-height" placeholder="dd/mm/yyyy" type="text" autocomplete="off" value="@if($init==0){{old('membership_date')}}@else{{old('membership_date',formatDateToShow($membership_update->membership_date))}}@endif" name="membership_date" readonly>

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
                            <select @if ($errors->has('card_status')) style="border-color:red;" @endif class="form-control" name="card_status" value="@if($init==0){{old('card_status')}}@else{{old('card_status',$membership_update->card_status)}}@endif" disabled="true">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('card_status',$membership_update->card_status)=='In-Process') selected @endif @endif value="In-Process">
                                    In-Process
                                </option>
                                <option @if(old('card_status',$membership_update->card_status)=='Printed') selected @endif value="Printed">
                                    Printed
                                </option>
                                <option @if(old('card_status',$membership_update->card_status)=='Recieved') selected @endif value="Recieved">
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
                                <option @if(old('card_status')=='Recieved') selected @endif value="Recieved">
                                    Recieved
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
                            <input @if ($errors->has('card_issue_date')) style="border-color:red;" @endif id="card-date" class="form-control input-height" autocomplete="off" type="text" name="card_issue_date" placeholder="dd/mm/yyyy" value="@if($init==0){{old('card_issue_date')}}@else{{old('card_issue_date',formatDateToShow($membership_update->card_issue_date))}}@endif" readonly>

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Card Expiry Date:

                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('card_exp')) style="border-color:red;" @endif id="card-exp" class="form-control input-height" autocomplete="off" type="text" name="card_exp" placeholder="dd/mm/yyyy" value="@if($init==0){{old('card_exp')}}@else{{old('card_exp',formatDateToShow($membership_update->card_exp))}}@endif" readonly>

                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Barcode Card Number:
                        </label>
<div class="col-sm-8 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('mem_barcode')) style="border-color:red;" @endif class="form-control input-height" placeholder="Enter Primary Card's Barcode Number" type="text" name="mem_barcode" value="@if($init==0){{old('mem_barcode')}}@else{{old('mem_barcode',$membership_update->mem_barcode)}}@endif" readonly>
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
                        <select name="mem_classification_id" @if ($errors->has('mem_classification_id')) style="border-color:red;" @endif class="form-control" disabled="true">
                        <option label="Choose Status"></option>

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
                        <label class="col-sm-1 form-control-label">
                            Remarks:

                        </label>
<div class="col-sm-3 mg-t-10 mg-sm-t-0">
<textarea @if ($errors->has('status_remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter any Remarks for alotted Status" rows="2" name="status_remarks" readonly>@if($init==0){{old('status_remarks')}}@else{{old('status_remarks',$membership_update->status_remarks)}}@endif</textarea>
                        </div>
                    </div>

                 <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                           Membership Status:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('active')) style="border-color:red;" @endif class="form-control" name="active" value="@if($init==0){{old('active')}}@else{{old('active',$membership_update->active)}}@endif" disabled="true">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('active',$membership_update->active)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('active',$membership_update->active)=='0') selected @endif value="0">
                                    In-Active
                                </option>

                                @else

                              <option @if($init==0) selected="" @else @if(old('active')=='1') selected @endif @endif value="1">
                                   Active
                                </option>
                                <option @if(old('active')=='0') selected @endif value="0">
                                    In-Active
                                </option>

                                @endif


                            </select>
                        </div>
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
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input  @if ($errors->has('mem_fee')) style="border-color:red;" @endif  id="mem_fee" class="form-control input-height charamt" type="number" name="mem_fee" placeholder="Fee of Membership for selected Category" value="@if($init==0){{old('mem_fee')}}@else{{old('mem_fee',$membership_update->mem_fee)}}@endif" readonly>

                        </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Additional Membership Charges: </label>

                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input  @if ($errors->has('additional_mem')) style="border-color:red;" @endif  id="additional_mem" type="number" name="additional_mem" class="form-control input-height" placeholder="(if any)" oninput="additionalsofmem()" value="@if($init==0){{old('additional_mem')}}@else{{old('additional_mem',$membership_update->additional_mem)}}@endif" readonly>
                  </div>

             <label class="col-sm-1 form-control-label">Remarks: </label>
          <div class="col-sm-3 mg-t-10 mg-sm-t-0">
            <textarea  @if ($errors->has('additional_mem_remarks')) style="border-color:red;" @endif  name="additional_mem_remarks" id="additional_mem_remarks" class="form-control" placeholder="Reason for Additional Charges" rows="2" readonly>@if($init==0){{old('additional_mem_remarks')}}@else{{old('additional_mem_remarks',$membership_update->additional_mem_remarks)}}@endif</textarea>
                  </div>
                </div>
                 <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Discount Amount: </label>
          <div class="col-sm-4 mg-t-10 mg-sm-t-0">
            <input  @if ($errors->has('mem_discount')) style="border-color:red;" @endif  id="mem_discount" class="form-control input-height" placeholder="(if any)" oninput="additionalsofmem()" type="Number" name="mem_discount" value="@if($init==0){{old('mem_discount')}}@else{{old('mem_discount',$membership_update->mem_discount)}}@endif" readonly>
                  </div>

                  <label class="col-sm-1 form-control-label">Remarks:</label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
    <textarea  @if ($errors->has('mem_discount_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Reason of Discount" rows="2" id="mem_discount_remarks" name="mem_discount_remarks" readonly>@if($init==0){{old('mem_discount_remarks')}}@else{{old('mem_discount_remarks',$membership_update->mem_discount_remarks)}}@endif</textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                            Total Membership Fee:
                        <span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                          <input  @if ($errors->has('total')) style="border-color:red;" @endif  id="total" class="form-control input-height" type="Number" name="total" value="@if($init==0){{old('total')}}@else{{old('total',$membership_update->total)}}@endif" placeholder="Total Membership Fee" readonly>
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
                    <input  @if ($errors->has('maintenance_amount')) style="border-color:red;" @endif type="number" name="maintenance_amount" id="maintenance_amount" class="form-control input-height" placeholder="Charges of Maintenance for selected category" value="@if($init==0){{old('maintenance_amount')}}@else{{old('maintenance_amount',$membership_update->maintenance_amount)}}@endif" readonly>
                  </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                           Additional Maintenance Charges:

                        </label>
                         <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <input  @if ($errors->has('additional_mt')) style="border-color:red;" @endif  id="additional_mt" type="number" name="additional_mt" class="form-control input-height" oninput="additionalsofmt()" placeholder="(if any)" value="@if($init==0){{old('additional_mt')}}@else{{old('additional_mt',$membership_update->additional_mt)}}@endif" readonly>
                  </div>
                   <label class="col-sm-1 form-control-label">
                           Remarks:

                        </label>
                         <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <textarea  @if ($errors->has('additional_mt_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Reason for Additional Charges" rows="2" name="additional_mt_remarks" id="additional_mt_remarks" readonly>@if($init==0){{old('additional_mt_remarks')}}@else{{old('additional_mt_remarks',$membership_update->additional_mt_remarks)}}@endif</textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                          Discount Amount:
                        </label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
        <input @if ($errors->has('mt_discount')) style="border-color:red;" @endif id="mt_discount" class="form-control input-height" placeholder="(if any)" type="number" name="mt_discount" oninput="additionalsofmt()" value="@if($init==0){{old('mt_discount')}}@else{{old('mt_discount',$membership_update->mt_discount)}}@endif" readonly>
                  </div>
                   <label class="col-sm-1 form-control-label">
                            Remarks:

                        </label>
                         <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                      <textarea @if ($errors->has('mt_discount_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Enter reason of Discount" rows="2" name="mt_discount_remarks" id="mt_discount_remarks" readonly>@if($init==0){{old('mt_discount_remarks')}}@else{{old('mt_discount_remarks',$membership_update->mt_discount_remarks)}}@endif</textarea>
                  </div>
                </div>
                 <div class="row mg-t-10">
                   <label class="col-sm-4 form-control-label">
                       Total Maintenance Charges:
                        <span class="tx-danger">*</span>
                        </label>
                         <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                         <input @if ($errors->has('total_maintenance')) style="border-color:red;" @endif  id="total_maintenance" class="form-control input-height" type="number" name="total_maintenance" placeholder="Total Maintenance Charges" value="@if($init==0){{old('total_maintenance')}}@else{{old('total_maintenance',$membership_update->total_maintenance)}}@endif" readonly>
                  </div>
                </div>
                 <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label"  style="color: black;">
                            Per Day Maintenance Charges:
 <span class="tx-danger">*</span>
                        </label>
                         <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('maintenance_per_day')) style="border-color:red;" @endif  id="maintenance_per_day" class="form-control input-height" type="number" name="maintenance_per_day" readonly style="background-color: #c1c1c1" placeholder="Maintenance per day" value="@if($init==0){{old('maintenance_per_day')}}@else{{old('maintenance_per_day',$membership_update->maintenance_per_day)}}@endif">
                         </div>
                       </div>
                <br>

                    <div class="row mg-t-10">
                                      <label class="col-sm-4 form-control-label" style="color: black;">
                            Comment Box:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea  @if ($errors->has('remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter any Remarks about this Membership" rows="2" name="remarks" readonly>@if($init==0){{old('remarks')}}@else{{old('remarks',$membership_update->remarks)}}@endif</textarea>
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
    </form>

 <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
            <div class="form-layout-footer mg-t-30">
              
    <a href="{{ url('club-hospitality/membership') }}" class="btn btn-secondary">Back</a>
    </div>
  </div>
    </div>
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
    $('#wizard1').steps({
  headerTag: 'h3',
  bodyTag: 'section',
  autoFocus: true,
  titleTemplate: '#index# #title#'
});
</script>
<script type="text/javascript">
//$('#memship-number').mask('AA 0000');
$('#mem-name').attr('maxlength', 50);
$('#father_name').attr('maxlength', 50);
//$('#father_number').mask('AF-0000');
$('#mem-cnic').mask('00000-0000000-0');
$('#mem-education').attr('maxlength', 100);
$('#tel_a').mask('00000000000');
$('#tel_b').mask('00000000000');
$('#mob_a').mask('00000000000');
$('#mob_b').mask('00000000000');
//$('#mem-ntn').mask('0000000');
$('#p-email').attr('maxlength', 200);
$('#o-email').attr('maxlength', 200);


$('#add').attr('maxlength', 300);
$('#city').attr('maxlength', 50);
$('#country').attr('maxlength', 50);


$('#bussiness').attr('maxlength', 100);
$('#pos').attr('maxlength', 100);
$('#experience').mask('00/0000 - 00/0000');
$('#dep').attr('maxlength', 100);
$('#govt_pos').attr('maxlength', 100);
$('#grade').attr('maxlength', 20);
$('#rank').attr('maxlength', 50);
$('#anymess').attr('maxlength', 3);
$('#when').mask('00/0000');

$('#aff').attr('maxlength', 3);
$('#aff_name').attr('maxlength', 100);
$('#aff_period').mask('00/0000 - 00/0000');
$('#others').attr('maxlength', 3);
$('#a').attr('maxlength', 50);
$('#b').attr('maxlength', 50);

$('#kin').attr('maxlength', 50);
$('#kin_rel').attr('maxlength', 100);
$('#fm_name').attr('maxlength', 50);
$('#fm_rel').attr('maxlength', 100);
$('#nation').attr('maxlength', 50);
$('#fm_cnic').mask('00000-0000000-0');
$('#fm_contact').mask('0000-0000000');
$('#sup_no').mask('AF-0000-A');

$('#ref_name').attr('maxlength', 50);
$('#mem_number').mask('AF-0000');
$('#rel').attr('maxlength', 100);
$('#mobile_no').mask('0000-0000000');

$('#sport_name').attr('maxlength', 50);

$('#owner_cnic').mask('00000-0000000-0');
$('#driver_name').attr('maxlength', 50);
$('#driver_relation').attr('maxlength', 100);
$('#driver_cnic').mask('00000-0000000-0');
$('#owner').attr('maxlength', 50);
$('#model').attr('maxlength', 100);
$('#color').attr('maxlength', 100);
$('#car_no').attr('maxlength', 50);
$('#engine_no').attr('maxlength', 50);
$('#chassis_no').attr('maxlength', 50);
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

$('#memship-number').val(data);
//$('.minicart-items').append(obj.html);

               membershipfee(id);
               maintenancefee(id);
                    }
                });
}


</script>

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

$('#mem_fee').val(data);
$('#total').val(data);
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

$('#maintenance_amount').val(data);
$('#total_maintenance').val(data);
//$('.minicart-items').append(obj.html);


                    }
                });
}


</script>

<script type="text/javascript">
   function additionalsofmem() {

                var first = parseFloat(document.getElementById("mem_fee").value);
                var second = parseFloat(document.getElementById("additional_mem").value);
                var third = parseFloat(document.getElementById("mem_discount").value);
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

            }
</script>

<script type="text/javascript">
   function additionalsofmt() {

                var first = parseFloat(document.getElementById("maintenance_amount").value);
                var second = parseFloat(document.getElementById("additional_mt").value);
                var third = parseFloat(document.getElementById("mt_discount").value);
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
@if(Request::segment(4))
<script>
$("#wizard1 li:nth-child(n)").removeClass("disabled");
</script>
@else
<script type="text/javascript">
$(".actions li:nth-child(2)").addClass("disabled");
</script>

@endif
@endpush
