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

          <p class="mg-b-25 mg-lg-b-50 border-bottom-custom">Add Membership Maintenance</p>

<div class="w3-bar w3-black">
  <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/membership-aeu') }}'; ">Member</button>
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/address-aeu/{id}') }}'; ">Address</button>
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/{id}') }}'; ">Profession</button>
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/affiliation-aeu/{id}') }}'; ">Affiliations</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/familymember-aeu/{id}') }}'; ">Family Member</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/referal-aeu/{id}') }}'; ">Referal</button>
  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/maintenance-aeu/{id}') }}'; ">Membership & Maintenance</button>
  <button class="w3-bar-item w3-button w3-red" >Cards</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/{id}') }}'; ">Cars</button>

</div>
            @if($init==1)
    <form method="post" action="{{ url('club-hospitality/membership/update') }}{{-- /{{ $maintenance_update->id }} --}}">
     @else
    <form method="post">
    @endif     
    @csrf   
                <div class="col-xl-12 ">

            <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design-mem">
                <div class="row ">   
                <label></label>
                  <label class="col-sm-4 form-control-label">Name of Member: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input  @if ($errors->has('applicant_name')) style="border-color:red;" @endif  type="text" name="applicant_name" id="applicant_name" class="form-control input-height" readonly style="background-color: #c1c1c1">
                  </div>
              </div>
               <div class="row mg-t-10">   
                <label></label>
                  <label class="col-sm-4 form-control-label">Membership Number: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input  @if ($errors->has('mem_no')) style="border-color:red;" @endif  type="text" id="mem_no" name="mem_no" class="form-control input-height" readonly style="background-color: #c1c1c1">
                  </div>
              </div>
                     <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Membership Fee:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input  @if ($errors->has('mem_fee')) style="border-color:red;" @endif  id="mem_fee" class="form-control input-height" readonly style="background-color: #c1c1c1" type="number" name="mem_fee">
                           
                        </div>
                    </div>
                </div>
        <label></label>
                     <div class="row mg-t-10">
                  <label class="col-sm-2 form-control-label" style="color: black;">Additional Membership Charges: </label>
                   &nbsp&nbsp&nbsp&nbsp
                  <div class="col-sm-4 mg-t-5 mg-sm-t-0">
                    <input  @if ($errors->has('additional_mem')) style="border-color:red;" @endif  id="additional_mem" type="number" name="additional_mem" class="form-control input-height" placeholder="Enter Additional Membership Charges (if any)" value="{{-- @if($init==0) {{ old('additional_mem') }} @else {{ $maintenance_update->additional_mem }}  @endif --}}">
                  </div>
             &nbsp&nbsp&nbsp&nbsp
                        <label class="col-sm-2 form-control-label" style="color: black;">
                            Remarks:
                           
                        </label>


                        <div class="col-sm-3 mg-t-4 mg-sm-t-0">
                            <textarea  @if ($errors->has('additional_mem_remarks')) style="border-color:red;" @endif  name="additional_mem_remarks" id="additional_mem_remarks" class="form-control" placeholder="Enter detailed reason for Additional Charges" rows="2" value="{{-- @if($init==0) {{ old('additional_mem_remarks') }} @else {{ $maintenance_update->additional_mem_remarks }}  @endif --}}">
                            </textarea>
                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-2 form-control-label" style="color: black;">
                            Discount Amount:
                            
                        </label>
                         &nbsp&nbsp&nbsp&nbsp
                        <div class="col-sm-4 mg-t-5 mg-sm-t-0">
                            <input  @if ($errors->has('mem_discount')) style="border-color:red;" @endif  id="mem_discount" class="form-control input-height" placeholder="Enter Total Discount on Membership" type="Number" name="mem_discount" value="{{-- @if($init==0) {{ old('mem_discount') }} @else {{ $maintenance_update->mem_discount }}  @endif --}}">
                            
                        </div>
                     &nbsp&nbsp&nbsp&nbsp
                        <label class="col-sm-2 form-control-label" style="color: black;">
                            Remarks:
                           
                        </label>
                        <div class="col-sm-3 mg-t-4 mg-sm-t-0">
                            <textarea  @if ($errors->has('mem_discount_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Enter reason of Discount" rows="2" id="mem_discount_remarks" name="mem_discount_remarks" value="{{-- @if($init==0) {{ old('mem_discount_remarks') }} @else {{ $maintenance_update->mem_discount_remarks }}  @endif --}}">
                            </textarea>
                        </div>
                    </div>
                    <div class="desktop-screen-design-mem">
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Total Membership Fee:
                        <span class="tx-danger">*</span> 
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input  @if ($errors->has('total')) style="border-color:red;" @endif  id="total" class="form-control input-height" readonly style="background-color: #c1c1c1" type="Number" name="total" value="{{-- @if($init==0) {{ old('total') }} @else {{ $maintenance_update->total }}  @endif --}}">
                        </div>
                    </div>
                 
                    <br/><br/><br/>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Maintenance Charges: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input  @if ($errors->has('maintenance_amount')) style="border-color:red;" @endif type="number" name="maintenance_amount" id="maintenance_amount" class="form-control input-height" readonly style="background-color: #c1c1c1">
                  </div>
                </div><!-- row -->
            </div>
            <label></label>
                <div class="row mg-t-10">
                  <label class="col-sm-2 form-control-label" style="color: black;">Additional Maintenance Charges: </label>
                  &nbsp&nbsp&nbsp&nbsp
                  <div class="col-sm-4 mg-t-5 mg-sm-t-0">
                    <input  @if ($errors->has('additional_mt')) style="border-color:red;" @endif  id="additional_mt" type="number" name="additional_mt" id="additional_mt" class="form-control input-height" placeholder="Enter Additional Maintenance Charges (if any)" value="{{-- @if($init==0) {{ old('additional_mt') }} @else {{ $maintenance_update->additional_mt }}  @endif --}}">
                  </div>
                  &nbsp&nbsp&nbsp&nbsp
                    <label class="col-sm-2 form-control-label" style="color: black;">
                            Remarks:
                           
                        </label>
                        <div class="col-sm-3 mg-t-4 mg-sm-t-0">
                            <textarea  @if ($errors->has('additional_mt_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Enter detailed reason for Additional Charges" rows="2" name="additional_mt_remarks" id="additional_mt_remarks" value="{{-- @if($init==0) {{ old('additional_mt_remarks') }} @else {{ $maintenance_update->additional_mt_remarks }}  @endif --}}">
                            </textarea>
                        </div>
                </div><!-- row -->
             
                       <div class="row mg-t-10">
                        <label class="col-sm-2 form-control-label" style="color: black;">
                            Discount Amount:
                            
                        </label>
                        &nbsp&nbsp&nbsp&nbsp
                        <div class="col-sm-4 mg-t-5 mg-sm-t-0">
                            <input @if ($errors->has('mt_discount')) style="border-color:red;" @endif  id="mt_discount" class="form-control input-height" placeholder="Enter Total Discount on Maintenance" type="number" name="mt_discount " value="{{-- @if($init==0) {{ old('mt_discount') }} @else {{ $maintenance_update->mt_discount }}  @endif --}}">
                            
                        </div>
                   
                    &nbsp&nbsp&nbsp&nbsp
                        <label class="col-sm-2 form-control-label" style="color: black;">
                            Remarks:
                        </label>
                        <div class="col-sm-3 mg-t-4 mg-sm-t-0">
                            <textarea @if ($errors->has('mt_discount_remarks')) style="border-color:red;" @endif  class="form-control" placeholder="Enter reason of Discount" rows="2" name="mt_discount_remarks" id="mt_discount_remarks" value="{{-- @if($init==0) {{ old('mt_discount_remarks') }} @else {{ $maintenance_update->mt_discount_remarks }}  @endif --}}">
                            </textarea>
                        </div>
                    </div>

                          <div class="desktop-screen-design-mem">

                         <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Total Maintenance Charges:
                        <span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('total_maintenance')) style="border-color:red;" @endif  id="total_maintenance" class="form-control input-height" type="number" name="total_maintenance" readonly style="background-color: #c1c1c1">
                            
                        </div>
                    </div>
             
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </div>
        </form>
      </div>
    </div>

@endsection