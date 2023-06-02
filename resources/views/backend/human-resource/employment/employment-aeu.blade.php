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
    height: 45px;
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

</style>
<div class="br-pagebody">
    <div>
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">
            Employment
        </h6>
         <div style="text-align: right; margin-top: -39px;">
            <a href="">
                <img border="0/" height="28" src="{{ url('assets/images/reload.png') }}" title="Reload Page" width="28">
                </img>
            </a>
        </div>

        @if($init==1)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
  <li><a href>Edit Employment</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
  <li><a href>Add Employment</a></li>
</ul>
@endif

<div class="w3-bar w3-black">
  @if($init==1)
   <a href="{{ url('human-resource/employment/employment-aeu') }}/{{ $employment_update->id }}">
  <button class="w3-bar-item w3-button  w3-red theactiveclass">Employee</button>
</a>
  @else
   <a href="{{ url('human-resource/employment/employment-aeu') }}">
  <button class="w3-bar-item w3-button  w3-red theactiveclass">Employee</button>
</a>
  @endif
 

@if($init==1)
  <a href="{{ url('human-resource/employment/education-aeu') }}/{{ $employment_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Education</button>
</a>
@else
 <a href="{{ url('human-resource/employment/education-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Education</button>
</a>
@endif  


@if($init==1)
  <a href="{{ url('human-resource/employment/job-aeu') }}/{{ $employment_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Jobs</button>
</a>
@else
 <a href="{{ url('human-resource/employment/job-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Jobs</button>
</a>
@endif  



@if($init==1)
  <a href="{{ url('human-resource/employment/reference-aeu') }}/{{ $employment_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">References</button>
</a>
@else
 <a href="{{ url('human-resource/employment/reference-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>References</button>
</a>
@endif  


@can('View Employment Documents')
@if($init==1)
<a href="{{ url('human-resource/employment/employment-docs-aeu') }}/{{ $employment_update->id }}">
  <button class="w3-bar-item w3-button  w3-red">Employment Documents</button>
</a>
@else
<a href="{{ url('human-resource/employment/employment-docs-aeu/'.$id) }}">
  <button class="w3-bar-item w3-button  w3-red" disabled>Employment Documents</button>
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

              @if($init==1)
    <form method="post" enctype="multipart/form-data" action="{{ url('human-resource/employment/update') }}/{{ $employment_update->id }}">
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
                        <label class="col-sm-4 form-control-label {{ $errors->has('application_no') ? ' has-error' : '' }}">
                            Employment #:
                          <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div  class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('application_no')) style="border-color:red;" @endif id="application_no" class="form-control input-height" type="Number" readonly placeholder="Enter Application Number of Employment" value="@if($init==0){{$increment_number}}@else{{old('application_no', $employment_update->application_no)}}@endif" name="application_no" style="background-color: #c1c1c1">

                        </div>
                         @if ($errors->has('application_no'))
                        <span class="help-block">
                        <strong>{{ $errors->first('application_no') }}</strong>
                        </span>
                        @endif
                    </div>
                    <!-- row -->
                         <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">COA Account: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if($errors->has('coa_code')) style="border-color:red;" @endif id="coa_code" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('coa_code')}}@else{{old('coa_code',coaname($employment_update->account))}} - {{old('coa_code',$employment_update->account)}}@endif" type="text" name="coa_code" onkeyup="coadata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                    <input @if($errors->has('account')) style="border-color:red;"  @endif id="account" autocomplete="off" value="@if($init==0){{old('account')}}@else{{old('account',$employment_update->account)}}@endif"
                                                               type="hidden" name="account">

                 <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$employment_update->name)}}@endif"
                                                               type="hidden" name="name"
                                                               >

 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                  </div>
                </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Employee's Name:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('name')) style="border-color:red;" @endif id="name" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('name')}}@else{{old('name',$employment_update->name)}}@endif"  type="text" name="name">

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
                            <input @if ($errors->has('father_name')) style="border-color:red;" @endif id="father_name" class="form-control input-height" placeholder="Enter Full Name" type="text" name="father_name" value="@if($init==0){{old('father_name')}}@else{{old('father_name',$employment_update->father_name)}}@endif">

                        </div>
                    </div>
                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            National Identity Card #:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('cnic')) style="border-color:red;" @endif id="cnic" class="form-control input-height" placeholder="Enter CNIC Number (13 digits)" type="text" name="cnic" value="@if($init==0){{old('cnic')}}@else{{old('cnic',$employment_update->cnic)}}@endif">
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
                            <select @if ($errors->has('gender')) style="border-color:red;" @endif class="form-control" name="gender" value="@if($init==0){{old('gender')}}@else{{old('gender',$employment_update->gender)}}@endif">
                                <option label="Choose Option">
                                </option>
                                 @if($init==1)
                                 <option @if(old('gender',$employment_update->gender)=='Male') selected @endif value="Male">
                                    Male
                                </option>
                                <option @if(old('gender',$employment_update->gender)=='Female') selected @endif value="Female">
                                    Female
                                </option>
                                <option @if(old('gender',$employment_update->gender)=='Other') selected @endif value="Other">
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
                  <label class="col-sm-4 form-control-label">Are you over 18 years of Age? <span class="tx-danger">*</span></label>
                   <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('age')) style="border-color:red;" @endif class="form-control" name="age" value="@if($init==0){{old('age')}}@else{{old('age',$employment_update->age)}}@endif">

                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('age',$employment_update->age)=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('age',$employment_update->age)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('age')=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('age')=='No') selected @endif value="No">
                                    No
                                </option>

                                 @endif

                            </select>
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Do you have a valid Driving License? </label>
                   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('license')) style="border-color:red;" @endif class="form-control" name="license" value="@if($init==0){{old('license')}}@else{{old('license',$employment_update->license)}}@endif">

                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('license',$employment_update->license)=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('license',$employment_update->license)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('license')=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('license')=='No') selected @endif value="No">
                                    No
                                </option>

                                 @endif

                            </select>
                  </div>
                        <label class="col-sm-2 form-control-label" style="color: black !important;">
                            License #:
                        </label>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('license_no')) style="border-color:red;" @endif id="license_no" class="form-control input-height" placeholder="Enter License Number" type="text" name="license_no" value="@if($init==0){{old('license_no')}}@else{{old('license_no',$employment_update->license_no)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                          Bank Account Details:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('bank_details')) style="border-color:red;" @endif id="bank_details" class="form-control input-height" placeholder="Enter Details" type="text" name="bank_details" value="@if($init==0){{old('bank_details')}}@else{{old('bank_details',$employment_update->bank_details)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                          Vehicle Details:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('vehicle_details')) style="border-color:red;" @endif id="vehicle_details" class="form-control input-height" placeholder="Enter Details" type="text" name="vehicle_details" value="@if($init==0){{old('vehicle_details')}}@else{{old('vehicle_details',$employment_update->vehicle_details)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                           How did you learn of our Organization?
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('learn_of_org')) style="border-color:red;" @endif id="learn_of_org" class="form-control input-height" placeholder="Enter Details" type="text" name="learn_of_org" value="@if($init==0){{old('learn_of_org')}}@else{{old('learn_of_org',$employment_update->learn_of_org)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                          Do you know anyone working in our Organization?
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('anyone_in_org')) style="border-color:red;" @endif id="anyone_in_org" class="form-control input-height" placeholder="Enter Name and Department" type="text" name="anyone_in_org" value="@if($init==0){{old('anyone_in_org')}}@else{{old('anyone_in_org',$employment_update->anyone_in_org)}}@endif">
                        </div>
                    </div>
                    <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Have you ever been convicted of a crime in the past ten years, excluding misdemeanors and summary of offenses, which has not been annulled, expunged or sealed by a Court? <span class="tx-danger">*</span></label>
                   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('crime')) style="border-color:red;" @endif class="form-control" name="crime" value="@if($init==0){{old('crime')}}@else{{old('crime',$employment_update->crime)}}@endif">

                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('crime',$employment_update->crime)=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('crime',$employment_update->crime)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('crime')=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('crime')=='No') selected @endif value="No">
                                    No
                                </option>

                                 @endif

                            </select>
                  </div>
                        <label class="col-sm-2 form-control-label" style="color: black !important;">
                         Details:
                        </label>

                        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
<textarea @if ($errors->has('crime_details')) style="border-color:red;" @endif class="form-control" placeholder="Enter Details" rows="2" name="crime_details">@if($init==0){{old('crime_details')}}@else{{old('crime_details',$employment_update->crime_details)}}@endif</textarea>
                        </div>
</div>
                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                           Employment Status:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('active')) style="border-color:red;" @endif class="form-control" name="active" value="@if($init==0){{old('active')}}@else{{old('active',$employment_update->active)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('active',$employment_update->active)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('active',$employment_update->active)=='0') selected @endif value="0">
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

                     <div class="row mg-t-10">
                        <label class="col-sm-6 form-control-label"  style="color: black !important;">
                            Applicant's Picture:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                             <img id="picchose" style="width: 300px; height: 300px; margin-left: -135px;" src="@if($init==1) {{ url('') }}/{{old('picture',$employment_update->employeePic?$employment_update->employeePic->url:'')}}@else {{ url('assets/images/nouser.png') }} @endif">
                             @if($init==0)
                            <input @if ($errors->has('picture')) style="border-color:red;" @endif type="file" name="picture" value="@if($init==0){{old('picture')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="picture" />
</div>
                            <input type="hidden" name="existimg" value="{{old('picture',$employment_update->employeePic?$employment_update->employeePic->url:'')}}">
                            @endif

                        </div>
                    </div>
<br><br>
                        <h6 class="box-title" style="color: black; text-align: center;">CONTACT INFORMATION</h6>
                    <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Mobile (a): <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mob_a')) style="border-color:red;" @endif id="mob_a" type="text" name="mob_a" value="@if($init==0){{old('mob_a')}}@else{{old('mob_a',$employment_update->mob_a)}}@endif" class="form-control input-height" placeholder="Enter First Mobile Number">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Mobile (b): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mob_b')) style="border-color:red;" @endif id="mob_b" type="text" name="mob_b" value="@if($init==0){{old('mob_b')}}@else{{old('mob_b',$employment_update->mob_b)}}@endif" class="form-control input-height" placeholder="Enter Second Mobile Number">
                  </div>
                </div>
            <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Telephone (a): </label>
          <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input @if ($errors->has('tel_a')) style="border-color:red;" @endif id="tel_a" type="text" name="tel_a" value="@if($init==0){{old('tel_a')}}@else{{old('tel_a',$employment_update->tel_a)}}@endif" class="form-control input-height" placeholder="Enter First Telephone Number">
                  </div>
                </div>
                 <div class="row mg-t-10">
             <label class="col-sm-4 form-control-label">Telephone (b): </label>
          <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input @if ($errors->has('tel_b')) style="border-color:red;" @endif id="tel_b" type="text" name="tel_b" value="@if($init==0){{old('tel_b')}}@else{{old('tel_b',$employment_update->tel_b)}}@endif" class="form-control input-height" placeholder="Enter Second Telephone Number">
                  </div>
                </div>

                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Email: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
    <input @if ($errors->has('email')) style="border-color:red;" @endif id="email" type="text" name="email" class="form-control input-height" value="@if($init==0){{old('email')}}@else{{old('email',$employment_update->email)}}@endif" placeholder="Enter Email ID">
                  </div>
                </div>
                <br><br>
                      <h6 class="box-title" style="color: black; text-align: center;">CURRENT ADDRESS</h6>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_address')) style="border-color:red;" @endif id="cur_address" type="text" name="cur_address" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('cur_address')}}@else{{old('cur_address',$employment_update->cur_address)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_city')) style="border-color:red;" @endif  id="cur_city" type="text" name="cur_city" class="form-control input-height" placeholder="Enter City name" value="@if($init==0){{old('cur_city')}}@else{{old('cur_city',$employment_update->cur_city)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('cur_country')) style="border-color:red;" @endif  id="cur_country" type="text" name="cur_country" class="form-control input-height" placeholder="Enter Country name" value="@if($init==0){{old('cur_country')}}@else{{old('cur_country',$employment_update->cur_country)}}@endif">
                  </div>
                </div>
                 <br><br>
                 <h6 class="box-title" style="color: black; text-align: center;">PERMANENT ADDRESS</h6>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_address')) style="border-color:red;" @endif id="per_address" type="text" name="per_address" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('per_address')}}@else{{old('per_address',$employment_update->per_address)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_city')) style="border-color:red;" @endif  id="per_city" type="text" name="per_city" class="form-control input-height" placeholder="Enter City name" value="@if($init==0){{old('per_city')}}@else{{old('per_city',$employment_update->per_city)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('per_country')) style="border-color:red;" @endif  id="per_country" type="text" name="per_country" class="form-control input-height" placeholder="Enter Country name" value="@if($init==0){{old('per_country')}}@else{{old('per_country',$employment_update->per_country)}}@endif">
                  </div>
                </div>

            

                </div>

 <div class="col-sm-6">

<br>
                         <h6 class="box-title" style="color: black; text-align: center;">EMPLOYEE DETAILS</h6>
           <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Company:<span class="tx-danger">
                                *
                            </span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('company')) style="border-color:red;"
                                                                @endif id="company"
                                                                class="form-control select2"
                                                                name="company" onchange="companyselect(this.id)">
                                                            <option label="Choose Option">
                                                            </option>
                                                            @foreach($companies as $company)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('company',$employment_update->company)==$company->code)  selected
                                                                        @endif  value="{{ $company->code }}">
                                                                        {{ $company->name }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('company')==$company->code)  selected
                                                                        @endif value="{{ $company->code }}">
                                                                        {{ $company->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                  </div>
                </div><!-- row -->

  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Department:<span class="tx-danger">
                                *
                            </span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('department')) style="border-color:red;"
                                                                @endif id="department"
                                                                class="form-control select2"
                                                                name="department" onchange="departmentselect(this.id)">
                                                            <option label="Choose Option">
                                                            </option>
                                                             @foreach($departments as $department)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('department',$employment_update->department)==$department->id)  selected
                                                                        @endif  value="{{ $department->id }}">
                                                                        {{ $department->desc }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('department')==$department->id)  selected
                                                                        @endif value="{{ $department->id }}">
                                                                        {{ $department->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                  </div>
                </div><!-- row -->

                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Sub-Department:<span class="tx-danger">
                                *
                            </span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('subdepartment')) style="border-color:red;"
                                                                @endif id="subdepartment"
                                                                class="form-control select2"
                                                                name="subdepartment">
                                                            <option label="Choose Option">
                                                            </option>
                                                       @foreach($subdepartments as $subdepartment)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('subdepartment',$employment_update->subdepartment)==$subdepartment->id)  selected
                                                                        @endif  value="{{ $subdepartment->id }}">
                                                                        {{ $subdepartment->desc }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('subdepartment')==$subdepartment->id)  selected
                                                                        @endif value="{{ $subdepartment->id }}">
                                                                        {{ $subdepartment->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                  </div>
                </div><!-- row -->


                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Designation:<span class="tx-danger">
                                *
                            </span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('designation')) style="border-color:red;" @endif id="designation" type="text" name="designation" class="form-control input-height" placeholder="Enter Designation or Job Title" value="@if($init==0){{old('designation')}}@else{{old('designation',$employment_update->designation)}}@endif">
                  </div>
                </div><!-- row -->
                  <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Date of Joining:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('date_of_joining')) style="border-color:red;" @endif id="date_of_joining" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" type="text" name="date_of_joining" value="@if($init==0){{old('date_of_joining')}}@else{{old('date_of_joining',formatDateToShow($employment_update->date_of_joining))}}@endif">

                        </div>
                    </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Barcode #:<span class="tx-danger">
                                *
                            </span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('barcode')) style="border-color:red;" @endif id="barcode" type="text" name="barcode" class="form-control input-height" placeholder="Enter Barcode Number of Employment Card" value="@if($init==0){{old('barcode')}}@else{{old('barcode',$employment_update->barcode)}}@endif">
                  </div>
                </div><!-- row -->
                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Current Salary:<span class="tx-danger">
                                *
                            </span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('current_salary')) style="border-color:red;" @endif id="current_salary" type="number" name="current_salary" class="form-control input-height" placeholder="Enter per Month Salary" value="@if($init==0){{old('current_salary')}}@else{{old('current_salary',$employment_update->current_salary)}}@endif" oninput="sendtototal()">
                  </div>
                </div><!-- row -->

                 <br><br>
                    <h6 class="box-title" style="color: black; text-align: center;">SALARY ADD-ONS</h6>
            <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                      <td width="5%" align="left">&nbsp</td>
                                                        <td width="45%" align="left">Add-On</td>
                                                        <td width="25%" align="left">Charges</td>
                                                        <td width="25%" align="left">Details</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">
{{--                                                    @dd($subdata);--}}
                                                    @if($init==1)

                                                        @foreach($subdata as $subs)
                                                            <tr> 
                                                                <td> <i class="fa fa-times" onclick="$(this).parents('tr').remove(); extrachargesselect2();"></i></td>
                                                                  
                                                                   <td>
                                                                  <select id="{{ $subs->id }}"
                                                                            onchange="extrachargesselect(this.id)"
                                                                            class="form-control select2"
                                                                            name="addon[]">
                                                                          <option label="Choose Option"></option>
                                                                    @foreach($addons as $add)

                                                                                <option
                                                                                    @if(old('addon[]',$subs->addon)==$add->id)  selected
                                                                                    @endif value="{{ $add->id }}">
                                                                                    {{ $add->desc }}
                                                                                </option>

                                                                        @endforeach
                                                                    </select></td>


                                                                <!--       <td>
                                                                  <select id="{{ $subs->id }}"
                                                                            class="form-control select2"
                                                                            name="trans_type[]">
                                                                          <option label="Choose Option"></option>
                                                                    @foreach($types as $type)

                                                                                <option
                                                                                    @if(old('trans_type[]',$subs->trans_type)==$type->id)  selected
                                                                                    @endif value="{{ $type->id }}">
                                                                                    {{ $type->name }}
                                                                                </option>

                                                                        @endforeach
                                                                    </select></td> -->

                                                                     <td>
                                                                    <input id="charges_amount{{ $subs->id }}"
                                                                           onkeyup="extrachargesselect2()"
                                                                           class="form-control  charamt"
                                                                           type="number" name="charges_amount[]"
                                                                           value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$subs->charges_amount)}}@endif"
                                                                          >
                                                                </td>
                                                                <td>
                                                                    <input id="details{{ $subs->id }}"
                                                                           class="form-control  " type="text"
                                                                           name="details[]"
                                                                           value="@if($init==0){{old('details[]')}}@else{{old('details[]',$subs->details)}}@endif">
                                                                </td>

                                                            </tr>
                                                        @endforeach
<script>
    $(window).load(function(){

        extrachargesselect2()
    })
</script>
                                                    @else

                                                        <tr>
                                                          <td></td>
                                                            <td><select id="1" onchange="extrachargesselect(this.id)"
                                                                        class="form-control select2"
                                                                        name="addon[]">
                                                                    <option label="Choose Option"></option>
                                                                    @foreach($addons as $add)
                                                                <option
                                                               @if(old('addon[]')==$add->id)  selected
                                                                            @endif value="{{ $add->id }}">
                                                                            {{ $add->desc }}
                                                                        </option>

                                                                    @endforeach
                                                                </select></td>

                                                            <!--    <td><select id="1"
                                                                        class="form-control select2"
                                                                        name="trans_type[]">
                                                                    <option label="Choose Option"></option>
                                                                    @foreach($types as $type)
                                                                <option
                                                               @if(old('trans_type[]')==$type->id)  selected
                                                                            @endif value="{{ $type->id }}">
                                                                            {{ $type->name }}
                                                                        </option>

                                                                    @endforeach
                                                                </select></td>
 -->
                                                            <td>

                                                                <input id="charges_amount1"
                                                                       onkeyup="extrachargesselect2()"
                                                                       class="form-control   charamt"
                                                                       type="number" name="charges_amount[]"
                                                                       value="@if($init==0){{old('charges_amount[]')}}@else{{old('charges_amount[]',$subs->charges_amount)}}@endif">
                                                            </td>
                                                              <td>
                                                                <input id="details1"
                                                                       class="form-control  " type="text"
                                                                       name="details[]"
                                                                       value="@if($init==0){{old('details[]')}}@else{{old('details[]',$subs->details)}}@endif">
                                                            </td>

                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>


                                                <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer ">
                                                        <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>


                                            

                                                  <br><br>
                    <h6 class="box-title" style="color: black; text-align: center;">SALARY DEDUCTIONS</h6>
            <table align="center" border="0" width="100%">
                                                    <tbody>
                                                    <tr>
                                                      <td width="5%" align="left">&nbsp</td>
                                                        <td width="45%" align="left">Deduction</td>
                                                        <td width="25%" align="left">Charges</td>
                                                        <td width="25%" align="left">Details</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreidtwo">
 
                                                    @if($init==1)

                                                        @foreach($subdatatwo as $subs)
                                                            <tr> 
                                                                <td> <i class="fa fa-times" onclick="$(this).parents('tr').remove(); extrachargesselect4();"></i></td>
                                                                  
                                                                   <td>
                                                                  <select id="{{ $subs->id }}"
                                                                            onchange="extrachargesselect3(this.id)"
                                                                            class="form-control select2"
                                                                            name="deduction[]">
                                                                          <option label="Choose Option"></option>
                                                                    @foreach($deductions as $ded)

                                                                                <option
                                                                                    @if(old('deduction[]',$subs->deduction)==$ded->id)  selected
                                                                                    @endif value="{{ $ded->id }}">
                                                                                    {{ $ded->desc }}
                                                                                </option>

                                                                        @endforeach
                                                                    </select></td>

  

                                                                     <td>
                                                                    <input id="charges{{ $subs->id }}"
                                                                           onkeyup="extrachargesselect4()"
                                                                           class="form-control   charamttwo"
                                                                           type="number" name="charges[]"
                                                                           value="@if($init==0){{old('charges[]')}}@else{{old('charges[]',$subs->charges_amount)}}@endif"
                                                                          >
                                                                </td>
                                                                <td>
                                                                    <input id="detail{{ $subs->id }}"
                                                                           class="form-control  " type="text"
                                                                           name="detail[]"
                                                                           value="@if($init==0){{old('detail[]')}}@else{{old('detail[]',$subs->details)}}@endif">
                                                                </td>

                                                            </tr>
                                                        @endforeach
<script>
    $(window).load(function(){

        extrachargesselect4()
    })
</script>
                                                    @else

                                                        <tr>
                                                          <td></td>
                                                            <td><select id="1" onchange="extrachargesselect3(this.id)"
                                                                        class="form-control select2"
                                                                        name="deduction[]">
                                                                    <option label="Choose Option"></option>
                                                                    @foreach($deductions as $ded)
                                                                <option
                                                               @if(old('deduction[]')==$ded->id)  selected
                                                                            @endif value="{{ $ded->id }}">
                                                                            {{ $ded->desc }}
                                                                        </option>

                                                                    @endforeach
                                                                </select></td>
 
                                                            <td>
                                                                <input id="charges1"
                                                                       onkeyup="extrachargesselect4()"
                                                                       class="form-control   charamttwo"
                                                                       type="number" name="charges[]"
                                                                       value="@if($init==0){{old('charges[]')}}@else{{old('charges[]',$subs->charges_amount)}}@endif">
                                                            </td>
                                                              <td>
                                                                <input id="detail1"
                                                                       class="form-control " type="text"
                                                                       name="detail[]"
                                                                       value="@if($init==0){{old('detail[]')}}@else{{old('detail[]',$subs->details)}}@endif">
                                                            </td>

                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>


                                                <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer ">
                                                        <input onclick="addmorefieldstwo()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>


                                            <br/>
                                                <div class="row mg-t-10">
                                                    <label class="col-sm-4 form-control-label">
                                                         Add-On Total:
                                                    </label>
                                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_addon_charges')) style="border-color:red;"
                                                               @endif id="total_addon_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_addon_charges')}}@else{{old('total_addon_charges',$employment_update->total_addon_charges)}}@endif"
                                                               type="number" name="total_addon_charges">

                                                    </div>
                                                </div>

                                                    <div class="row mg-t-10">
                                                    <label class="col-sm-4 form-control-label">
                                                         Deduction Total:
                                                    </label>
                                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_deduction_charges')) style="border-color:red;"
                                                               @endif id="total_deduction_charges"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_deduction_charges')}}@else{{old('total_deduction_charges',$employment_update->total_deduction_charges)}}@endif"
                                                               type="number" name="total_deduction_charges">

                                                    </div>
                                                </div>

                                                  <div class="row mg-t-10">
                                                    <label class="col-sm-4 form-control-label">
                                                         Total Salary: <span class="tx-danger"> * </span>
                                                    </label>
                                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('total_salary')) style="border-color:red;"
                                                               @endif id="total_salary"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('total_salary')}}@else{{old('total_salary',$employment_update->total_salary)}}@endif"
                                                               type="number" name="total_salary">

                                                    </div>
                                                </div>

                                                  <div class="row mg-t-10">
                                                    <label class="col-sm-4 form-control-label">
                                                        No. of Days (Per Month): <span class="tx-danger"> * </span>
                                                    </label>
                                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('days')) style="border-color:red;"
                                                               @endif id="days"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{30}}@else{{old('days',$employment_update->days)}}@endif"
                                                               type="number" name="days">

                                                    </div>
                                                </div>
                                                  <div class="row mg-t-10">
                                                    <label class="col-sm-4 form-control-label">
                                                      Hours (Per Day): <span class="tx-danger"> * </span>
                                                    </label>
                                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                                        <input type="number"
                                                               @if ($errors->has('hours')) style="border-color:red;"
                                                               @endif id="hours"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{9}}@else{{old('hours',$employment_update->hours)}}@endif"
                                                               type="number" name="hours">

                                                    </div>
                                                </div>
                                                <br>
                    <div class="row mg-t-10">
                                      <label class="col-sm-4 form-control-label" style="color: black;">
                            Comment Box:
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<textarea  @if ($errors->has('remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter any Remarks about this Employment" rows="2" name="remarks">@if($init==0){{old('remarks')}}@else{{old('remarks',$employment_update->remarks)}}@endif</textarea>
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

        <br>
                 @if($init==1)
           <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
  <div class="form-layout-footer mg-t-30">
               &nbsp&nbsp&nbsp&nbsp
                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('human-resource/employment-vue') }}" class="btn btn-secondary">Cancel</a>
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
    <a href="{{ url('human-resource/employment-vue') }}" class="btn btn-secondary">Cancel</a>
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
<script type="text/javascript">
      function extrachargesselect(idd) {

            var idval = document.getElementById(idd).value;
            $.ajax({
                type: 'GET',
                url: '{{ url('human-resource/salary-add-ons/calculateextracharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                        document.getElementById('charges_amount' + idd).value = obj;
                        // $('#addressdata').html(data);
                        // total+=parseInt(obj);
                        //document.getElementById('total_addon_charges').value=total;
                        total = 0;
                        $('.charamt').each(function (index, element) {
                            total += parseFloat($(element).val());
                        });

                        document.getElementById('total_addon_charges').value = total;

                        var current =document.getElementById('current_salary').value;

            if(!current){
              current =0;
             }
            if(!total){
              total =0;
             }

                document.getElementById('total_salary').value = parseInt(current)+parseInt(total);

                    }
                }
            });
        }


        function extrachargesselect2() {
            total = 0;
            $('.charamt').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            document.getElementById('total_addon_charges').value = total;
             var current =document.getElementById('current_salary').value;

                if(!current){
              current =0;
             }
            if(!total){
              total =0;
             }

                         document.getElementById('total_salary').value = parseInt(current)+parseInt(total);

        }
</script>
<script type="text/javascript">

          function extrachargesselect3(idd) {
            var idval = document.getElementById(idd).value;
            $.ajax({
                type: 'GET',
                url: '{{ url('human-resource/salary-deductions/calculateextracharges/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                        document.getElementById('charges' + idd).value = obj;
                     
                        total = 0;
                        $('.charamttwo').each(function (index, element) {
                            total += parseFloat($(element).val());
                        });

                        document.getElementById('total_deduction_charges').value = total;

                         var current =document.getElementById('current_salary').value;
                         var addon =document.getElementById('total_addon_charges').value;

            if(!current){
              current =0;
             }
            if(!total){
              total =0;
             }
              if(!addon){
              addon =0;
             }

                         document.getElementById('total_salary').value = parseInt(current)+parseInt(addon)-parseInt(total);

                    }
                }
            });


        }


        function extrachargesselect4() {
            total = 0;
            $('.charamttwo').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            document.getElementById('total_deduction_charges').value = total;
             var current =document.getElementById('current_salary').value;
             var addon =document.getElementById('total_addon_charges').value;

              if(!current){
              current =0;
             }
            if(!total){
              total =0;
             }
              if(!addon){
              addon =0;
             }

            document.getElementById('total_salary').value = parseInt(current)+parseInt(addon)-parseInt(total);

        }



    </script>


      <script type="text/javascript">
        var i = 2;

        function addmorefields() {
            var html = '';

            html = `<tr>
    <td>
     <i class="fa fa-times" onclick="$(this).parents('tr').remove(); extrachargesselect2();"></i>
     </td>

      <td>
     <select id="${i}"  onchange="extrachargesselect(this.id)" class="form-control select2" name="addon[]" >
                    <option label="Choose Option"></option>
                     @foreach($addons as $add)
            <option value="{{ $add->id }}">
                                    {{ $add->desc }}
            </option>
@endforeach
            </select></td>

             

            <td>
              <input id="charges_amount${i}" onkeyup="extrachargesselect2()" class="form-control   charamt" type="number" name="charges_amount[]">
                  </td>

                  <td>
                <input id="details${i}" class="form-control " type="text" name="details[]" >
                  </td>
              </tr>`;
            i++;
            $('#addmoreid').append(html);
        }

    </script>


     <script type="text/javascript">
        var i = 2;

        function addmorefieldstwo() {
            var html = '';

            html = `<tr>
    <td>
     <i class="fa fa-times" onclick="$(this).parents('tr').remove(); extrachargesselect4();"></i>
     </td>

      <td>
     <select id="${i}"  onchange="extrachargesselect3(this.id)" class="form-control select2" name="deduction[]" >
                    <option label="Choose Option"></option>
                     @foreach($deductions as $ded)
            <option value="{{ $ded->id }}">
                                    {{ $ded->desc }}
            </option>
@endforeach
            </select></td>

             

            <td>
              <input id="charges${i}" onkeyup="extrachargesselect4()" class="form-control   charamttwo" type="number" name="charges[]">
                  </td>

                  <td>
                <input id="detail${i}" class="form-control " type="text" name="detail[]" >
                  </td>
              </tr>`;
            i++;
            $('#addmoreidtwo').append(html);
        }

    </script>
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
  function sendtototal() {
             var total =document.getElementById('total_deduction_charges').value;
             if(!total){
              total =0;
             }
             var current =document.getElementById('current_salary').value;
              if(!current){
              current =0;
             }
             var addon =document.getElementById('total_addon_charges').value;
              if(!addon){
              addon =0;
             }

            document.getElementById('total_salary').value = parseInt(current)+parseInt(addon)-parseInt(total);

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
$('#cnic').mask('00000-0000000-0');
$('#tel_a').mask('00000000000');
$('#tel_b').mask('00000000000');
$('#mob_a').mask('00000000000');
$('#mob_b').mask('00000000000');
$('#license_no').mask('AA-00-00000');
$('#company_tel_a').mask('00000000000');
$('#company_tel_b').mask('00000000000');
$('#ref_mob_a').mask('00000000000');
$('#ref_mob_b').mask('00000000000');
</script>

  <script type="text/javascript">

            var val;

        function coadata(val) {
            
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "searchid": val,
                    
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                        $("#areabox").append(`<li onclick="coadatavalue('${val1.id}')">${val1.name} - ${val1.code}<li>`);

                    });
$('#areabox').show();
                 

                }
            });
        }

</script>

<script type="text/javascript">
        var val;

        function coadatavalue(val) {
          
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
 
                        document.getElementById('account').value = obj.code;
                        document.getElementById('name').value = obj.name;

                        $("#coa_code").prop("readonly", true);
                     
                      
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
  function companyselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('human-resource/company/department/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#department').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#department').append(s);
                })

  }
}
   });

  }
</script>

<script type="text/javascript">
  function departmentselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('human-resource/department/subdepartment/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#subdepartment').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
$('#subdepartment').append(s);
                })

  }
}
   });
  }
</script>


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

  <script>

     $( function() {
    $( "#date_of_joining" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );


    $( function() {
    $( "#employed_from_a" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

     $( function() {
    $( "#employed_to_a" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );


     $( function() {
    $( "#employed_from_b" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#employed_to_b" ).datepicker({

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
@endpush
