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

          <p class="mg-b-25 mg-lg-b-50 border-bottom-custom">Add Member Address</p>


<div class="w3-bar w3-black">
  <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/membership-aeu') }}'; ">Member</button>
  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/address-aeu/{id}') }}'; ">Address</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/{id}') }}'; ">Profession</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/affiliation-aeu/{id}') }}'; ">Affiliations</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/familymember-aeu/{id}') }}'; ">Family Member</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/referal-aeu/{id}') }}'; ">Referal</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/maintenance-aeu/{id}') }}'; ">Membership & Maintenance</button>
  <button class="w3-bar-item w3-button w3-red" >Cards</button>
  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/{id}') }}'; ">Cars</button>

</div>
        <div class="col-xl-12 ">

            <div class="form-layout form-layout-4 inner-content-address">
                 <div class="row" style="float: right;">
                    <div class="col-md-12" style="float: right;
    background-color: #49a2fb;
    margin-top: -21px;
    color: #fff;
    border-radius: 12px;"  data-toggle="modal" data-target="#modaldemo1">Add More</div>
                </div>
                <div class="desktop-screen-design-address1">
                <div class="row ">   
                <div class="col-md-12" class="table-wrapper">
            <table  class="table display nowrap datatable">
              <thead>
                <tr>
                 
                  <th class="wd-15p">Sr #</th>
                  <th class="wd-15p">Address Type</th>
                  <th class="wd-20p">Address</th>
                  <th class="wd-15p">City</th>
                  <th class="wd-15p">Country</th>
                  <th class="wd-15p">Action</th>
                </tr>
              </thead>
              <tbody id='addressdata'>
                @if($init==1)
                @foreach($address_update as $addressupdate)
                  <tr>
                  <td>{{ $addressupdate->id }}</td>
                  <td>{{ $addressupdate->address_type }}</td>
                  <td>{{ $addressupdate->address }}</td>
                  <td>{{ $addressupdate->city }}</td>
                  <td>{{ $addressupdate->country }}</td>
                  <td><button title="Edit"><i class="fas fa-edit"></i></button>
                      <button title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                  </tr>
                @endforeach 
                @endif
              </tbody>
            </table>
          </div>
                </div><!-- row --> 
            </div>
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
{{-- Address Model --}}
<form method="post" action="{{ url('club-hospitality/membership/membership-aeu/address/') }}/{{ Request::segment(4) }}" >
    @csrf
<div id="modaldemo1" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 406px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Member Address</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="row ">   
                <label class="col-sm-4 form-control-label">Address Type:<span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select @if ($errors->has('add_type')) style="border-color:red;" @endif class="form-control input-height select2" name="add_type" id="add_type">
                    <option label="Choose Category"></option>
                    <option value="Current">Current</option>
                    <option value="Permanent">Permanent</option>
                  </select>
              </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('add')) style="border-color:red;" @endif id="add" type="text" name="add" class="form-control input-height" placeholder="Enter Address of the Applicant">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('city')) style="border-color:red;" @endif  id="city" type="text" name="city" class="form-control input-height" placeholder="Enter City of the Applicant">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Country: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('country')) style="border-color:red;" @endif  id="country" type="text" name="country" class="form-control input-height" placeholder="Enter Country of the Applicant">
                  </div>
                </div>  
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
      </form>

{{-- Address Model --}}

@endsection