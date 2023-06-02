@extends('backend.layout.app')
@section('page-content')

<style type="text/css">
   

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

</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Membership</h6>
         <div style="text-align: right;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

          <p class="mg-b-25 mg-lg-b-50 border-bottom-custom">Add Member Affiliations</p>


<div class="w3-bar w3-black">
  <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/membership-aeu') }}'; ">Member</button>
  <!-- <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/address-aeu/{id}') }}'; ">Address</button> -->
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/{id}') }}'; ">Profession</button>
  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/affiliation-aeu/{id}') }}'; ">Affiliations</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/familymember-aeu/{id}') }}'; ">Family Member</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/referal-aeu/{id}') }}'; ">Referal</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="">Sports Subscription</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="">Credit Limit</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="">Notices</button>
 <!--  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/maintenance-aeu/{id}') }}'; ">Membership & Maintenance</button> -->
  <button class="w3-bar-item w3-button w3-red" >Cards</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/{id}') }}'; ">Cars</button>

</div>
           @if($init==1)
    <form method="post" action="{{ url('club-hospitality/membership/update') }}{{-- /{{ $affiliations_update->id }} --}}">
     @else
    <form method="post">
    @endif     
    @csrf   
                <div class="col-xl-12 ">

            <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
               
                <div class="row ">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Affiliation with Any Foreign Organization: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('aff')) style="border-color:red;" @endif id="aff" type="text" name="aff" class="form-control input-height" placeholder="Yes / No" value="{{-- @if($init==0) {{ old('aff') }} @else {{ $affiliations_update->aff }}  @endif --}}">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Organization Name: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('aff_name')) style="border-color:red;" @endif id="aff_name" type="text" name="aff_name" class="form-control input-height" placeholder="Enter Name of the Organization / Company" value="{{-- @if($init==0) {{ old('aff_name') }} @else {{ $affiliations_update->aff_name }}  @endif --}}">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Affiliation Period:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('aff_period')) style="border-color:red;" @endif id="aff_period" type="text" name="aff_period" class="form-control input-height" placeholder="Starting Month & Year - Ending Month & Year" value="{{-- @if($init==0) {{ old('aff_period') }} @else {{ $affiliations_update->aff_period }}  @endif --}}">
                  </div>
                </div><!-- row -->
              
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Is Applicant a Member of any other Clubs / Messes:<span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('others')) style="border-color:red;" @endif id="others" type="text" name="others" class="form-control input-height" placeholder="Yes / No" value="{{-- @if($init==0) {{ old('others') }} @else {{ $affiliations_update->others }}  @endif --}}">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">In case of Membership of Club terminated / suspended. Please provide details: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('details')) style="border-color:red;" @endif rows="2" class="form-control" name="details" id="details" placeholder="Enter details" value="{{-- @if($init==0) {{ old('details') }} @else {{ $affiliations_update->details }}  @endif --}}"></textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Poilitical Affiliations (if any): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('political_details')) style="border-color:red;" @endif rows="2" class="form-control" name="political_details" id="political_details" placeholder="Enter details" value="{{-- @if($init==0) {{ old('political_details') }} @else {{ $affiliations_update->political_details }}  @endif --}}"></textarea>
                  </div>
                </div>
                 
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Relatives in Armed Forces / Civil Services (A):</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('a')) style="border-color:red;" @endif id="a" type="text" name="a" class="form-control input-height" placeholder="Enter Name" value="{{-- @if($init==0) {{ old('a') }} @else {{ $affiliations_update->a }}  @endif --}}">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Relatives in Armed Forces / Civil Services (B): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('b')) style="border-color:red;" @endif id="b" type="text" name="b" class="form-control input-height" placeholder="Enter Name" value="{{-- @if($init==0) {{ old('b') }} @else {{ $affiliations_update->b }}  @endif --}}">
                  </div>
                </div>
                <div class="row mg-t-10">
                <label class="col-sm-4 form-control-label">Has the Applicant ever stayed Abroad for more than 10 years or has any other Country's Citizenship / Residence Permit?<span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('abroad')) style="border-color:red;" @endif class="form-control input-height select2" value="{{-- @if($init==0) {{ old('abroad') }} @else {{ $affiliations_update->abroad }}  @endif --}}" name="abroad" id="abroad">
                    <option label="Choose Answer"></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
              </div>
              </div>
                
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">If yes, give Details:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('abroad_details')) style="border-color:red;" @endif rows="2" class="form-control" name="abroad_details"  id="abroad_details" placeholder="Enter details" value="{{-- @if($init==0) {{ old('abroad_details') }} @else {{ $affiliations_update->abroad_details }}  @endif --}}"></textarea>
                  </div>
                </div>
                <div class="row mg-t-10">
                <label class="col-sm-4 form-control-label">Has the Applicant ever got convicted in any Criminal Case?<span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('crime')) style="border-color:red;" @endif class="form-control input-height select2" value="{{-- @if($init==0) {{ old('crime') }} @else {{ $affiliations_update->crime }}  @endif --}}" name="crime" id="crime">
                    <option label="Choose Answer"></option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
              </div>
              </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">If yes, give Details:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('crime_details')) style="border-color:red;" @endif rows="2" class="form-control" id="crime_details" name="crime_details" placeholder="Enter details" value="{{-- @if($init==0) {{ old('crime_details') }} @else {{ $affiliations_update->crime_details }}  @endif --}}"></textarea>
                  </div>
                </div>
            
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </div>
             <button type="submit">save and continue</button>
    </form>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection