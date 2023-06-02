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

          <p class="mg-b-25 mg-lg-b-50 border-bottom-custom">Add Member Referal</p>
        
<div class="w3-bar w3-black">
  <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/membership-aeu') }}'; ">Member</button>
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/{id}') }}'; ">Profession</button>
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/affiliation-aeu/{id}') }}'; ">Affiliations</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/familymember-aeu/{id}') }}'; ">Family Member</button>
  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/referal-aeu/{id}') }}'; ">Referal</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="">Sports Subscription</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="">Credit Limit</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="">Notices</button>
  <button class="w3-bar-item w3-button w3-red" >Cards</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/{id}') }}'; ">Cars</button>

</div>

 @if($init==1)
    <form method="post" action="{{ url('club-hospitality/membership/update') }}{{-- /{{ $referal_update->id }} --}}">
     @else
    <form method="post">
    @endif     
    @csrf   
                <div class="col-xl-12 ">

            <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
                <div class="row ">   
                <label></label>
                  <label class="col-sm-4 form-control-label">Member Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('ref_name')) style="border-color:red;" @endif  id="ref_name" type="text" name="ref_name" class="form-control input-height" placeholder="Enter Name of the Member who is refering Membership" value="{{-- @if($init==0) {{ old('ref_name') }} @else {{ $referal_update->ref_name }}  @endif --}}">
                  </div>
              </div>
               
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Membership Number: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mem_number')) style="border-color:red;" @endif  id="mem_number" type="number" name="mem_number" class="form-control input-height" placeholder="Enter Membership Number of the Member" value="{{-- @if($init==0) {{ old('mem_number') }} @else {{ $referal_update->mem_number }}  @endif --}}">
                  </div>
                </div><!-- row -->

                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Relation with Member: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('rel')) style="border-color:red;" @endif  id="rel" type="text" name="rel" class="form-control input-height" placeholder="Enter Relationship" value="{{-- @if($init==0) {{ old('rel') }} @else {{ $referal_update->rel }}  @endif --}}">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Contact: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mobile_no')) style="border-color:red;" @endif  id="mobile_no" type="text" name="mobile_no" class="form-control input-height" placeholder="Enter Mobile Number" value="{{-- @if($init==0) {{ old('mobile_no') }} @else {{ $referal_update->mobile_no }}  @endif --}}">
                  </div>
                </div><!-- row -->
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </div>
             <button type="submit">save and continue</button>
    </form>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection