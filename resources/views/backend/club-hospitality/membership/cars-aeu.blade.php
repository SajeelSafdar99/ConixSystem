<a href>@extends('backend.layout.app')
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
    height: 45;
}
.w3-bar .w3-button {
    white-space: normal;
}
.theactiveclass{
background-color: #17a2b8!important;
}

.profession{
  color: black !important;
  font-size: 16px !important;
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
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Edit Cars Information</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Add Cars Information</a></li>
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

  @can('View Professsion')
  <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/') }}/{{Request::segment(4)}}' ">Profession</button>
  @endcan

<button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/') }}/{{Request::segment(4)}}' ">Cars</button>

@can('View Membership Documents')
    <button class="w3-bar-item w3-button w3-red" onclick="location.href='{{ url('club-hospitality/membership/membership_docs-aeu/') }}/{{Request::segment(4)}}' ">Membership Documents</button>
    @endcan

@can('View Sports')
  <button class="w3-bar-item w3-button  w3-red" disabled onclick="">Sports Subscription</button>
  @endcan

  @can('View Credit Limit')
 <a href="{{ url('club-hospitality/membership/creditlimit') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button w3-red">Credit Limit</button>
</a>
  @endcan

   @can('View Notices')
  <button class="w3-bar-item w3-button  w3-red" disabled onclick="">Notices</button>
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
  
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

<div class="col-xl-12 ">
 <div class="row mg-t-10">
     
                  <label class="col-sm-1 form-control-label profession"><u>Member Name:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->title}} {{$membershipdata->first_name}} {{$membershipdata->middle_name}} {{$membershipdata->applicant_name}}</b>
                  </div>
                  @if($init==0)
<div style="text-align: right !important; margin-top: -25px;" class="col-sm-8 mg-t-10 mg-sm-t-0">
          @can('View Deleted Cars')
          <a href="{{ url('club-hospitality/cars/deleted') }}/{{$membershipdata->id}}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          &nbsp&nbsp&nbsp&nbsp&nbsp
        </div>
        @endcan
                </div><!-- row -->
         
             
            <div class="row mg-t-10">
      
                  <label class="col-sm-1 form-control-label profession"><u>Membership #:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->mem_no}}</b>
                  </div>
                </div><!-- row -->

                
            <div class="form-layout form-layout-4 inner-content-address">

 <div class="row" style="float: right;">
@if($init==1)
@can('Edit Cars')
       <button id="btnadd" style="float: right;
    background-color: #49a2fb;
    cursor: pointer;
    margin-top: 0px;
    margin-right: 34px;
  color: #fff;
    border-radius: 15px;"  data-toggle="modal" data-target="#modaldemo1">Edit <i class="fas fa-edit"></i></button>
    @endcan

    @else

    @can('Add Cars')
      <button id="theaddbtn" style="float: right;
    background-color: #49a2fb;
    cursor: pointer;
    margin-top: 0px;
    margin-right: 34px;
  color: #fff;
    border-radius: 15px;"  data-toggle="modal" data-target="#modaldemo1">Add <i class="fas fa-plus-circle"></i></button>
    @endcan
    @endif   
                </div>
                <br><br>
                <div class="col-md-12" class="table-wrapper">
            <table  class="table display nowrap datatable">
              <thead>
                <tr>
                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-15p">Owner Name</th>
                   <th class="wd-10p">Owner CNIC</th>
                   <th class="wd-15p">Driver Name</th>
                   <th class="wd-10p">Driver CNIC</th>
                  <th class="wd-10p">Car Model</th>
                  <th class="wd-10p">Color</th>
                   <th class="wd-10p">Registration #</th>
                   <th class="wd-10p">Sticker #</th>
                   @can('Edit Cars')
                   <th class="wd-10p">Edit</th>
                   @endcan
                   @can('Delete Cars')
                   <th class="wd-10p">Delete</th>
                   @endcan
                
                </tr>
              </thead>
            </table>
          </div>

              </div><!-- form-layout -->
            </div><!-- col-6 -->
             </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
{{-- Cars Model --}}
@if($init==1)
<form method="post" action="{{ url('club-hospitality/cars/update/') }}/{{ $cars_update->member_id }}/{{ $cars_update->id  }}" >
   @else
    <form method="post">
    @endif
    @csrf
    <div id="modaldemo1" class="modal fade">
 <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 1000px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
 <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Car</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
                 <div class="modal-body pd-25">
<div class="row">
                      <div class="col-md-12">
                 <div class="row ">   
                  <label class="col-sm-4 form-control-label">Member Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('name')) style="border-color:red;" @endif type="text" name="name" id="name" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Full Name" value="@if($init==0){{$membershipdata->applicant_name}}@else{{old('name',$cars_update->name)}}@endif">
                  </div>
              </div>
            <!--   <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">S/O,D/O,W/O: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('familyforcar')) style="border-color:red;" @endif type="text" name="familyforcar" id="familyforcar" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Full Name" value="@if($init==0){{$membershipdata->father_name}}@else{{$cars_update->familyforcar}}@endif">
                  </div>
              </div> -->
              <div class="row mg-t-10">   
                  <label class="col-sm-4 form-control-label">Membership #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('membership_number')) style="border-color:red;" @endif type="text" name="membership_number" id="membership_number" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Membership No." value="@if($init==0){{$membershipdata->mem_no}}@else{{old('membership_number',$membershipdata->mem_no)}}@endif">
                  </div>
              </div>
              <!-- <div class="row mg-t-10">   
     
                  <label class="col-sm-4 form-control-label">Contact: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('contactforcar')) style="border-color:red;" @endif type="text" name="contactforcar" id="contactforcar" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Mobile Number" value="@if($init==0){{$membershipdata->mob_a}}@else{{$cars_update->contactforcar}}@endif">
                  </div>
              </div>
              <div class="row mg-t-10">   
       
                  <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('addressforcar')) style="border-color:red;" @endif type="text" name="addressforcar" id="addressforcar" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Complete Address" value="@if($init==0){{$membershipdata->cur_address}}@else{{$cars_update->addressforcar}}@endif">
                  </div>
              </div> -->
</br>
               <h6 class="box-title" style="color: black;">VEHICAL REGISTRATION DETAILS</h6>
                 </br>

                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Name as Per Registration Book: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('owner_name')) style="border-color:red;" @endif id="owner_name" type="text" name="owner_name" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('owner_name')}}@else{{old('owner_name',$cars_update->owner_name)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">CNIC #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('owner_cnic')) style="border-color:red;" @endif id="owner_cnic" type="text" name="owner_cnic" class="form-control input-height" placeholder="Enter CNIC Number (13 digits)" value="@if($init==0){{old('owner_cnic')}}@else{{old('owner_cnic',$cars_update->owner_cnic)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Car Make & Type:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <textarea @if ($errors->has('car_makeover')) style="border-color:red;" @endif class="form-control" placeholder="Explain some Make and Type of Car" rows="2" name="car_makeover" id="car_makeover">@if($init==0){{old('car_makeover')}}@else{{old('car_makeover',$cars_update->car_makeover)}}@endif</textarea>
                        </div>
                    </div>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Car Model: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('car_model')) style="border-color:red;" @endif id="car_model" type="text" name="car_model" class="form-control input-height" placeholder="Enter Model of Car" value="@if($init==0){{old('car_model')}}@else{{old('car_model',$cars_update->car_model)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Car Color: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('car_color')) style="border-color:red;" @endif id="car_color" type="text" name="car_color" class="form-control input-height" placeholder="Enter Color of Car" value="@if($init==0){{old('car_color')}}@else{{old('car_color',$cars_update->car_color)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Car Registration #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('car_no')) style="border-color:red;" @endif id="car_no" type="text" name="car_no" class="form-control input-height" placeholder="Enter complete Number of Car" value="@if($init==0){{old('car_no')}}@else{{old('car_no',$cars_update->car_no)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Engine #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('engine_no')) style="border-color:red;" @endif id="engine_no" type="text" name="engine_no" class="form-control input-height" placeholder="Enter Engine Number of Car" value="@if($init==0){{old('engine_no')}}@else{{old('engine_no',$cars_update->engine_no)}}@endif" >
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Chassis #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('chassis_no')) style="border-color:red;" @endif id="chassis_no" type="text" name="chassis_no" class="form-control input-height" placeholder="Enter Chassis Number of Car" value="@if($init==0){{old('chassis_no')}}@else{{old('chassis_no',$cars_update->chassis_no)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Sticker #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('sticker_no')) style="border-color:red;" @endif id="sticker_no" type="text" name="sticker_no" class="form-control input-height" placeholder="Enter Chassis Number of Car" value="@if($init==0){{old('sticker_no',$membershipdata->mem_no)}}@else{{old('sticker_no',$cars_update->sticker_no)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Sticker Issue Date:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('sticker_issue_date')) style="border-color:red;" @endif id="sticker_issue_date" type="text" name="sticker_issue_date" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" value="@if($init==0){{old('sticker_issue_date') }}@else{{old('sticker_issue_date',formatDateToShow($cars_update->sticker_issue_date))}}@endif">
                  </div>
                </div><!-- row -->
                 <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Sticker Expiry Date:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('sticker_exp_date')) style="border-color:red;" @endif id="sticker_exp_date" type="text" name="sticker_exp_date" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" value="@if($init==0){{old('sticker_exp_date')}}@else{{old('sticker_exp_date',formatDateToShow($cars_update->sticker_exp_date))}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                    Sticker Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('sticker_status')) style="border-color:red;" @endif class="form-control" name="sticker_status" value="@if($init==0){{old('sticker_status')}}@else{{old('sticker_status',$cars_update->sticker_status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('sticker_status',$cars_update->sticker_status)=='1') selected @endif @endif value="1">
                                    Issued
                                </option>
                                <option @if(old('sticker_status',$cars_update->sticker_status)=='0') selected @endif value="0">
                                    Not Issued
                                </option>
                                
                                @else

                              <option @if($init==0) selected="" @else @if(old('sticker_status')=='1') selected @endif @endif value="1">
                                   Issued
                                </option>
                                <option @if(old('sticker_status')=='0') selected @endif value="0">
                                    Not Issued
                                </option>

                                @endif


                            </select>
                        </div>
                    </div>

                 </br>
                 <h6 class="box-title" style="color: black;">DETAILS OF DRIVER / FAMILY MEMBER USER</h6>
                 </br>

                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('driver_name')) style="border-color:red;" @endif id="driver_name" type="text" name="driver_name" class="form-control input-height" placeholder="Enter Name of Car Driver or User" value="@if($init==0){{old('driver_name')}}@else{{old('driver_name',$cars_update->driver_name)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">CNIC: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('driver_cnic')) style="border-color:red;" @endif id="driver_cnic" type="text" name="driver_cnic" class="form-control input-height" placeholder="Enter CNIC Number of Car Driver or User" value="@if($init==0){{old('driver_cnic')}}@else{{old('driver_cnic',$cars_update->driver_cnic)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Relationship: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('driver_relation')) style="border-color:red;" @endif id="driver_relation" type="text" name="driver_relation" class="form-control input-height" placeholder="Enter Relationship of Member with Driver" value="@if($init==0){{old('driver_relation')}}@else{{old('driver_relation',$cars_update->driver_relation)}}@endif">
                  </div>
                </div>
                <br/><br/>
                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Remarks:
                          
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <textarea @if ($errors->has('car_remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter any comments about the Car" rows="2" name="car_remarks" id="car_remarks">@if($init==0){{old('car_remarks')}}@else{{old('car_remarks',$cars_update->car_remarks)}}@endif</textarea>
                        </div>
                    </div>
                      </div>
                  </div>
                </div>
                @if($init==0)
                 <div class="modal-footer">
                  <input type="submit" name="save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" value="Save">
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
                @else
                 <div class="modal-footer">
                     <button type="input" name="save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Update</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                  @endif
              </div>
              </div><!-- modal-dialog -->
          </div><!-- modal -->
      </form>

{{-- Cars Model --}}

@endsection
@push('jscode')


<script type="text/javascript">
  var oTable = '';
// $(document).ready(function() {

        var oTable =   $('.datatable').DataTable({
          seaching: true,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'asc' ]],
          "ajax": {
          'url': '{{ route('cars.datatable',$membershipdata->id) }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'owner_name', name: 'owner_name', searchable: true},
            {data: 'owner_cnic', name: 'owner_cnic', searchable: true},
             {data: 'driver_name', name: 'driver_name', searchable: true},
            {data: 'driver_cnic', name: 'driver_cnic', searchable: true},
            {data: 'car_model', name: 'car_model', searchable: true},
            {data: 'car_color', name: 'car_color', searchable: true},
            {data: 'car_no', name: 'car_no', searchable: true},
            {data: 'sticker_no', name: 'sticker_no', searchable: true},
            @can('Edit Cars')
            {data: 'editbutton', name: 'editbutton', orderable: false},
            @endcan
            @can('Delete Cars')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},
            @endcan
        ]
    });

</script>


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
 
<script src="{{ asset('/assets/plugins/datatable/datatables.min.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" ></script>



  <script>
     $( function() {
    $( "#sticker_issue_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#sticker_exp_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
  </script>

  
<script src="{{ asset('/assets/plugins/jquery-mask-plugin/dist/jquery.mask.js') }}" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
  $('#owner_cnic').mask('00000-0000000-0');
  $('#driver_cnic').mask('00000-0000000-0');
</script>

<script type="text/javascript">
     $(document).ready(function(){

      console.log(1234);

    document.getElementById("btnadd").click();
    });
</script>

  @if($errors->any())
<script type="text/javascript">
  

    document.getElementById("theaddbtn").click();
</script>
@endif


@if($init==1)
@if($errors->any())
<script type="text/javascript">
    document.getElementById("btnadd").click();
</script>
@endif
@endif
@endpush
