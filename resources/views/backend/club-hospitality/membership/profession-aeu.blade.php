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

.areabox {
            cursor: pointer !important;
        }

.profession{
  color: black !important;
  font-size: 16px !important;
}

.headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }

</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Membership</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

 @if($init==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Edit Profession & Affiliations</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Add Profession & Affiliations</a></li>
</ul>
@endif

<div class="w3-bar w3-black">
  
@if($init==1)
   <a href="{{ url('club-hospitality/membership/membership-aeu') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button  w3-red ">Member</button>
</a>
  @else
 <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/membership-aeu/') }}/{{Request::segment(4)}}' ">Member</button>
  @endif

  @can('View Family Member')
 <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/familymember-aeu/') }}/{{Request::segment(4)}}' ">Family Member</button>
 @endcan

  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/') }}/{{Request::segment(4)}}' ">Profession</button>

@can('View Cars')
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/') }}/{{Request::segment(4)}}' ">Cars</button>
  @endcan
  
  @can('View Membership Documents')
  <button class="w3-bar-item w3-button w3-red" onclick="location.href='{{ url('club-hospitality/membership/membership_docs-aeu/') }}/{{Request::segment(4)}}' ">Membership Documents</button>
  @endcan

@can('View Sports')
  <button class="w3-bar-item w3-button  w3-red" onclick="" disabled>Sports Subscription</button>
  @endcan

@can('View Credit Limit')
   <a href="{{ url('club-hospitality/membership/creditlimit') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button w3-red">Credit Limit</button>
</a>
  @endcan

  @can('View Notices')
  <button class="w3-bar-item w3-button  w3-red" onclick="" disabled>Notices</button>
  @endcan

@can('View Cards')
  <a href="{{ url('memberprint') }}/{{Request::segment(4)}}" target="_blank">
  <button class="w3-bar-item w3-button  w3-red">Card</button>
</a>
  @endcan

    @can('View Cards')
  <a href="{{ url('club-hospitality/membership/familymembercard') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button w3-red">Family Cards</button>
</a>
  @endcan

</div>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


              @if($init==1)
    <form method="post" action="{{ url('club-hospitality/profession/update/') }}/{{ $profession_update->member_id }} ">
     @else
    <form method="post">
    @endif     
    @csrf   
                <div class="col-xl-12 ">
  <div class="row mg-t-10">
     
                  <label class="col-sm-1 form-control-label profession"><u>Member Name:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->title}} {{$membershipdata->first_name}} {{$membershipdata->middle_name}} {{$membershipdata->applicant_name}}</b>
                  </div>
                </div><!-- row -->
         
             
            <div class="row mg-t-10">
      
                  <label class="col-sm-1 form-control-label profession"><u>Membership #:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->mem_no}}</b>
                  </div>
                </div><!-- row -->

               
            <div class="form-layout form-layout-4 ">

                  <div class="row">
               <div class="col-sm-6">
                   <br>
               <h6 class="box-title" style="color: black; text-align: center;">NOMINATION</h6>
                
              <div class="row mg-t-10">
            <label class="col-sm-4 form-control-label">
               Nominate your Next of Kin:
             </label>
 <div class="col-sm-8 mg-t-10 mg-sm-t-0">
           <select onchange="relationship(this.id)" @if ($errors->has('next_of_kin')) id="{{ $familymembers->id }}"
            style="border-color:red;" @endif id="next_of_kin" class="form-control js-example-tags select2" name="next_of_kin"> <option label="Choose Family Member"> </option>
  
  @if($init==1)

  @if(!is_numeric($profession_update->next_of_kin))
  @if($profession_update->next_of_kin!=='Not Mentioned')
  <option selected>{{ $profession_update->next_of_kin }}</option>
  @endif
  @endif

 


       
       <option @if(old('next_of_kin',$profession_update->next_of_kin)=='Not Mentioned')  selected  @endif>Not Mentioned</option>

       @else

 <option>Not Mentioned</option>


        @endif
      
                    @foreach($familymembers as $fm)
         @if($init==1)
       
         

        <option
           @if(old('next_of_kin',$profession_update->next_of_kin)==$fm->id)  selected  @endif  value="{{ $fm->id }}"> {{ $fm->title }} {{ $fm->first_name }} {{ $fm->middle_name }} {{ $fm->name }}
                         </option>  

                         @else
            <option
        @if(old('next_of_kin')==$fm->id)  selected @endif value="{{ $fm->id }}">  {{ $fm->title }} {{ $fm->first_name }} {{ $fm->middle_name }} {{ $fm->name }}
              </option>
                         @endif
                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Relationship:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('kin_relation')) style="border-color:red;" @endif  id="kin_relation" type="text" name="kin_relation" value="@if($init==0){{old('kin_relation')}}@else{{old('kin_relation',$profession_update->kin_relation)}}@endif" class="form-control input-height" autocomplete="off" placeholder="Enter Relation with Nominated Kin">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Contact:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('kin_contact')) style="border-color:red;" @endif  id="kin_contact" type="text" name="kin_contact" value="@if($init==0){{old('kin_contact')}}@else{{old('kin_contact',$profession_update->kin_contact)}}@endif" class="form-control input-height" autocomplete="off" placeholder="Enter Mobile Number of Nominated Kin">
                  </div>
                </div><!-- row -->
<br><br>
               <h6 class="box-title" style="color: black; text-align: center;">PROFESSION</h6>
               
                <div class="row ">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Nature of Occupation:<span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
           <select name="bussiness" @if ($errors->has('bussiness')) style="border-color:red;" @endif class="form-control" >
                        <option label="Choose Status"></option>

                        @foreach($occupations as $occupation)
                        @if($init==1)
                        <option @if(old('bussiness',$profession_update->bussiness)==$occupation->id) selected @endif value="{{ $occupation->id }}">
                        {{ $occupation->desc }}
                        </option>
                        @else
                        <option @if(old('bussiness')==$occupation->id)  selected @endif  value="{{ $occupation->id }}">
                                    {{ $occupation->desc }}
                                </option>
                        @endif
                        @endforeach
                        </select>
       <!--   <select @if ($errors->has('bussiness')) style="border-color:red;" @endif class="form-control" name="bussiness" value="@if($init==0){{old('bussiness')}}@else{{old('bussiness',$profession_update->bussiness)}}{{$profession_update->bussiness}}@endif">
                                <option label="Choose Occupation">
                                </option>
                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('bussiness',$profession_update->bussiness)=='Businessman') selected @endif @endif value="Businessman">
                                    Businessman
                                </option>
                                <option @if(old('bussiness',$profession_update->bussiness)=='Government Officer') selected @endif value="Government Officer">
                                    Government Officer
                                </option>
                                <option @if(old('bussiness',$profession_update->bussiness)=='Armed Forces Officer') selected @endif value="Armed Forces Officer">
                                    Armed Forces Officer
                                </option>
                                 <option @if(old('bussiness',$profession_update->bussiness)=='Private Employee') selected @endif value="Private Employee">
                                    Private Employee
                                </option>
                                 <option @if(old('bussiness',$profession_update->bussiness)=='Other') selected @endif value="Other">
                                    Other
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('bussiness')=='Businessman') selected @endif @endif value="Businessman">
                                    Businessman
                                </option>
                                <option @if(old('bussiness')=='Government Officer') selected @endif value="Government Officer">
                                    Government Officer
                                </option>
                                <option @if(old('bussiness')=='Armed Forces Officer') selected @endif value="Armed Forces Officer">
                                    Armed Forces Officer
                                </option>
                                <option @if(old('bussiness')=='Private Employee') selected @endif value="Private Employee">
                                   Private Employee
                                </option>
                                <option @if(old('bussiness')=='Other') selected @endif value="Other">
                                   Other
                                </option>
                                 @endif

                            </select> -->
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Designation / Position / Rank / Grade:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('position')) style="border-color:red;" @endif id="position" type="text" name="position" value="@if($init==0){{old('position')}}@else{{old('position',$profession_update->position)}}@endif" class="form-control input-height" placeholder="Enter Position or Rank">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Organization Name:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('organization_name')) style="border-color:red;" @endif id="organization_name" type="text" name="organization_name" value="@if($init==0){{old('organization_name')}}@else{{old('organization_name',$profession_update->organization_name)}}@endif" class="form-control input-height" placeholder="Enter Name">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Experience: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('experience')) style="border-color:red;" @endif id="experience" type="text" value="@if($init==0){{old('experience')}}@else{{old('experience',$profession_update->experience)}}@endif" name="experience" class="form-control input-height" placeholder="Enter Years of Experience">
                  </div>
                </div><!-- row -->
          
               <!--  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Income (Rs.): <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('income')) style="border-color:red;" @endif id="income" type="number" value="@if($init==0){{old('income')}}@else{{old('income',$profession_update->income)}}@endif" name="income" class="form-control input-height" placeholder="Enter Income per Month ">
                  </div>
                </div> -->
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Did you ever Apply for membership in AFOHS Club / PAF Officers Mess: <span class="tx-danger">*</span></label>
                   <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('anymess')) style="border-color:red;" @endif class="form-control" name="anymess" value="@if($init==0){{old('anymess')}}@else{{old('anymess',$profession_update->anymess)}}@endif">
                                
                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('anymess',$profession_update->anymess)=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('anymess',$profession_update->anymess)=='Yes') selected @endif value="Yes">
                                  Yes
                                </option>
                                <option @if(old('anymess',$profession_update->anymess)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('anymess')=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('anymess')=='Yes') selected @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('anymess')=='No') selected @endif value="No">
                                    No
                                </option>
                               
                                 @endif

                            </select>
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">When: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('when')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('when')}}@else{{old('when',$profession_update->when)}}@endif" name="when" id="when" class="form-control input-height" placeholder="Enter Month & Year">
                  </div>
                </div>
                <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>

 @if($init==1)   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('mem_result',$profession_update->mem_result)=='0') checked="" @endif @endif type="radio" name="mem_result" value="0"><span class="pabs">Was Approved?</span>
              </label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('mem_result',$profession_update->mem_result)=='1') checked="" @endif type="radio" name="mem_result" value="1"><span class="pabs">Was Rejected?</span>
              </label>
            </div><!-- col-3 -->
                                
                                @else

        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('mem_result')=='0') checked="" @endif @endif type="radio" name="mem_result" value="0"><span class="pabs">Was Approved?</span></label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
    <input @if(old('mem_result')=='1') checked="" @endif type="radio" name="mem_result" value="1"><span class="pabs">Was Rejected?</span>
              </label>
            </div><!-- col-3 -->
                             @endif
        </div><!-- row-->
          
            <div class="row mg-t-10" >
                  <label class="col-sm-4 form-control-label">Reason for Rejection / Withdrawal: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('reason')) style="border-color:red;" @endif rows="2" class="form-control" name="reason" id="reason" placeholder="Enter details in case of Rejection">@if($init==0){{old('reason')}}@else{{old('reason',$profession_update->reason)}}@endif</textarea>
                  </div>
                </div>

                <br><br>
               <h6 class="box-title" style="color: black; text-align: center;">REFERAL</h6>
              
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Member Name: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('referal_mem_name')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('referal_mem_name')}}@else{{old('referal_mem_name',$profession_update->referal_mem_name)}}@endif" name="referal_mem_name" id="referal_mem_name" autocomplete="off" class="form-control input-height" placeholder="Enter to Search"  onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" >
                     <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>
                  </div>
                </div>
              <div class="row mg-t-10">
            <label class="col-sm-4 form-control-label">Membership No.:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('referal_mem_no')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('referal_mem_no')}}@else{{old('referal_mem_no',$profession_update->referal_mem_no)}}@endif" name="referal_mem_no" id="referal_mem_no" class="form-control input-height" placeholder="Enter Membership Number">
                  </div>
                </div>
                 <div class="row mg-t-10">
            <label class="col-sm-4 form-control-label">Relation with Member:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('referal_relation')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('referal_relation')}}@else{{old('referal_relation',$profession_update->referal_relation)}}@endif" name="referal_relation" id="referal_relation" class="form-control input-height" placeholder="Enter Relationship">
                  </div>
                </div>
                 <div class="row mg-t-10">
            <label class="col-sm-4 form-control-label">Contact:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('referal_contact')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('referal_contact')}}@else{{old('referal_contact',$profession_update->referal_contact)}}@endif" name="referal_contact" id="referal_contact" class="form-control input-height" placeholder="Enter Mobile No.">
                  </div>
                </div>
              </div>

 <div class="col-sm-6">
   <br>
     <h6 class="box-title" style="color: black; text-align: center;">AFFILIATIONS</h6>
              
  <div class="row mg-t-10">
   
                  <label class="col-sm-4 form-control-label">Affiliation with Any Foreign Organization:<span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('aff')) style="border-color:red;" @endif class="form-control" name="aff" value="@if($init==0){{old('aff')}}@else{{old('aff',$profession_update->aff)}}@endif">
                                
                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('aff',$profession_update->aff)=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('aff',$profession_update->aff)=='Yes') selected @endif value="Yes">
                                  Yes
                                </option>
                                <option @if(old('aff',$profession_update->aff)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('aff')=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('aff')=='Yes') selected @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('aff')=='No') selected @endif value="No">
                                    No
                                </option>
                               
                                 @endif

                            </select>
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Organization Name: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('aff_name')) style="border-color:red;" @endif id="aff_name" type="text" name="aff_name" class="form-control input-height" placeholder="Enter Name (If Yes)" value="@if($init==0){{old('aff_name')}}@else{{old('aff_name',$profession_update->aff_name)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Affiliation Period:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('aff_period')) style="border-color:red;" @endif id="aff_period" type="text" name="aff_period" class="form-control input-height" placeholder="Starting Month & Year - Ending Month & Year" value="@if($init==0){{old('aff_period')}}@else{{old('aff_period',$profession_update->aff_period)}}@endif">
                  </div>
                </div><!-- row -->
              

<br><br>


 <h6 class="box-title headingsettings"><b>ARE YOU A MEMBER OF OTHER CLUBS / MESSES ?</b></h6>
              
                            <table align="center" border="0" width="100%">
                          <tbody>
                       <tr>
           
                  <td width="50%" align="left">Name</td>
                  <td width="40%" align="left">Membership No.</td>
                   <td width="10%" align="right">&nbsp</td>
                                                    </tr>
                                                    <tbody>
                                                    <tbody id="addmoreid">

                                                    @if($init==1)
           @foreach($clubdatas as $clubdata)
                                    <tr>
                           
                             <td>
          <input id="club_name{{ $clubdata->id }}" class="form-control input-height" type="text" name="club_name[]" value="@if($init==0){{old('club_name[]')}}@else{{old('club_name[]',$clubdata->club_name)}}@endif">
                        </td>
                  <td>
 <input id="club_mem_no{{ $clubdata->id }}" class="form-control input-height" type="text" name="club_mem_no[]" value="@if($init==0){{old('club_mem_no[]')}}@else{{old('club_mem_no[]',$clubdata->club_mem_no)}}@endif">
                                           </td>

                 <td> <i class="fa fa-trash" onclick="$(this).parents('tr').remove();"></i></td>
                                    
                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                          



 <td>
          <input id="club_name1" class="form-control input-height" type="text" name="club_name[]" value="@if($init==0){{old('club_name[]')}}@else{{old('club_name[]',$clubdata->club_name)}}@endif">
                        </td>
                  <td>
 <input id="club_mem_no1" class="form-control input-height" type="text" name="club_mem_no[]" value="@if($init==0){{old('club_mem_no[]')}}@else{{old('club_mem_no[]',$clubdata->club_mem_no)}}@endif">
                                           </td>
                                   </tr>
<td> &nbsp</td>

                                                    @endif


                                                    </tbody>
                                                </table>


                                                <div class="row mg-t-10">

                                                    &nbsp&nbsp&nbsp&nbsp&nbsp
                                                    <div class="form-layout-footer ">
                                                        <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div>
                                                </div>
                                                <br/>


<br>

    
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">In case of Membership of Club terminated / suspended. Please provide details: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('details')) style="border-color:red;" @endif rows="2" class="form-control" name="details" id="details" placeholder="Enter details">@if($init==0){{old('details')}}@else{{old('details',$profession_update->details)}}@endif</textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Poilitical Affiliations (If Any): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('political_details')) style="border-color:red;" @endif rows="2" class="form-control" name="political_details" id="political_details" placeholder="Enter details">@if($init==0){{old('political_details')}}@else{{old('political_details',$profession_update->political_details)}}@endif</textarea>
                  </div>
                </div>
                 
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Relatives in Armed Forces / Civil Services (A):</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('a')) style="border-color:red;" @endif id="a" type="text" name="a" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('a')}}@else{{old('a',$profession_update->a)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Relatives in Armed Forces / Civil Services (B): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('b')) style="border-color:red;" @endif id="b" type="text" name="b" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('b')}}@else{{old('b',$profession_update->b)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                <label class="col-sm-4 form-control-label">Has the Applicant ever stayed Abroad for more than 10 years or has any other Country's Citizenship / Residence Permit?<span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <select @if ($errors->has('abroad')) style="border-color:red;" @endif class="form-control" name="abroad" value="@if($init==0){{old('abroad')}}@else{{old('abroad',$profession_update->abroad)}}@endif">
                                
                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('abroad',$profession_update->abroad)=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('abroad',$profession_update->abroad)=='Yes') selected @endif value="Yes">
                                  Yes
                                </option>
                                <option @if(old('abroad',$profession_update->abroad)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('abroad')=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('abroad')=='Yes') selected @endif value="Yes">
                                Yes
                                </option>
                                <option @if(old('abroad')=='No') selected @endif value="No">
                                No
                                </option>
                               
                                 @endif

                            </select>
              </div>
              </div>
                
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">If yes, give Details:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('abroad_details')) style="border-color:red;" @endif rows="2" class="form-control" name="abroad_details"  id="abroad_details" placeholder="Enter details">@if($init==0){{old('abroad_details')}}@else{{old('abroad_details',$profession_update->abroad_details)}}@endif</textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                <label class="col-sm-4 form-control-label">Has the Applicant ever got convicted in any Criminal Case?<span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                <select @if ($errors->has('crime')) style="border-color:red;" @endif class="form-control" name="crime" value="@if($init==0){{old('crime')}}@else{{old('crime',$profession_update->crime)}}@endif">
                                
                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('crime',$profession_update->crime)=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('crime',$profession_update->crime)=='Yes') selected @endif value="Yes">
                                  Yes
                                </option>
                                <option @if(old('crime',$profession_update->crime)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('crime')=='N/A') selected @endif @endif value="N/A">
                                    N/A
                                </option>
                                <option @if(old('crime')=='Yes') selected @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('crime')=='No') selected @endif value="No">
                                    No
                                </option>
                               
                                 @endif

                            </select>
              </div>
              </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">If yes, give Details:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('crime_details')) style="border-color:red;" @endif rows="2" class="form-control" id="crime_details" name="crime_details" placeholder="Enter details">@if($init==0){{old('crime_details')}}@else{{old('crime_details',$profession_update->crime_details)}}@endif</textarea>
                  </div>
                </div>
 </div>
 </div> 

           
            </div>


               
                 @if($init==1)  
           <div class="row">
            <div class="col-md-9"></div> 
            <div class="col-md-3">          
  <div class="form-layout-footer mg-t-30">
               &nbsp&nbsp&nbsp&nbsp
                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="" class="btn btn-secondary">Cancel</a>
             </div> 
              </div>
    </div> 
          
             @else 
             <div class="row">
            <div class="col-md-9"></div> 
            <div class="col-md-3">
            <div class="form-layout-footer mg-t-30">
               &nbsp&nbsp&nbsp&nbsp
             
               <input type="submit" name="save" class="btn btn-info" value="Save">
             
        &nbsp&nbsp
    <a href="" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
    </div>
             @endif  
            
    </form>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection


@push('jscode')
 <script type="text/javascript">

        function relationship(idd) {

            var idval = document.getElementById(idd).value;
            $.ajax({
                type: 'GET',
                url: '{{ url('club-hospitality/profession/findrel/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {
                      console.log(obj);

                    relationshiptwo(obj);
                    relationshipthree(idval);
                     
                    }
                }

            });


        }



        </script>


        <script type="text/javascript">

        function relationshiptwo(id) {

            $.ajax({
                type: 'GET',
                url: '{{ url('club-hospitality/profession/fmrelationship/') }}/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = data;
                    if (obj) {
                     
                    document.getElementById('kin_relation').value = obj;
                     
                    }
                }

            });


        }



        </script>
          <script type="text/javascript">

        function relationshipthree(id) {

            $.ajax({
                type: 'GET',
                url: '{{ url('club-hospitality/profession/fmcontact/') }}/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = data;
                    if (obj) {
                     
                    document.getElementById('kin_contact').value = obj;
                     
                    }
                }

            });


        }
        </script>

            <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
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
                        document.getElementById('referal_contact').value = obj.mob_a;

                         $fname=obj.first_name?obj.first_name+' ':'';
                          $mname=obj.middle_name?obj.middle_name+' ':'';
                          $lname=obj.applicant_name?obj.applicant_name:'';
                          $mem=obj.mem_no?' '+'('+obj.mem_no+')':'';
                        document.getElementById('referal_mem_name').value = $fname+$mname+$lname+$mem;

                        document.getElementById('referal_mem_no').value = obj.mem_no;
          
                    jQuery('#areabox').html('');

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
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);
                    });

      $('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>
<script type="text/javascript">
        var i = 2;

        function addmorefields() {
            var html = '';

            html = `<tr>
    
            <td>
            <i>&nbsp</i>
                <input id="club_name${i}" class="form-control input-height" type="text" name="club_name[]" >
                  </td>
                  <td>
                  <i>&nbsp</i>
                      <input id="club_mem_no${i}" class="form-control input-height" type="text" name="club_mem_no[]" >
                  </td>
                  <td>
     <i class="fa fa-trash" onclick="$(this).parents('tr').remove();"></i>
    </td>

                     </tr>`;
            i++;
            $('#addmoreid').append(html);
        }

    </script>
        
<script type="text/javascript">
$('#referal_contact').mask('00000000000');
</script>

<script type="text/javascript">
  $(".js-example-tags").select2({
  tags: true
});
</script>
        @endpush