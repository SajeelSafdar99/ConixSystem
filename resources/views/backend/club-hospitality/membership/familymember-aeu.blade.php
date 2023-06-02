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

.profession{
  color: black !important;
  font-size: 16px !important;
}

.modal-dialog {
    max-width: 10000px !important;
    }

    .headingsettings{
      color: black !important;
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
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Edit Family Member</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Add Family Member</a></li>
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


  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/familymember-aeu/') }}/{{Request::segment(4)}}' ">Family Member</button>

  @can('View Professsion')
  <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('club-hospitality/membership/profession-aeu/') }}/{{Request::segment(4)}}' ">Profession</button>
  @endcan


  @can('View Cars')
   <button class="w3-bar-item w3-button w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/') }}/{{Request::segment(4)}}' ">Cars</button>
   @endcan

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
<div style="text-align: right !important; margin-top: -50px;" class="col-sm-8 mg-t-10 mg-sm-t-0">
          @can('Export Family Member Columns')
             <button type="button" data-toggle="modal" data-target="#modal" class="mg-t-30 btn btn-primary"><i class="fa fa-file"></i> Export</button>
          @endcan

          @can('View Deleted Family Members')
          <a href="{{ url('club-hospitality/familymember/deleted') }}/{{$membershipdata->id}}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/" style="margin-top: 25px;">
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
 @can('Edit Family Member')
       <button id="btnadd" style="float: right;
    background-color: #49a2fb;
    cursor: pointer;
    margin-top: 0px;
    margin-right: 34px;
  color: #fff;
    border-radius: 15px;"  data-toggle="modal" data-target="#modaldemo1">Edit <i class="fas fa-edit"></i></button>
    @endcan

    @else

    @can('Add Family Member')
      <button id="theaddbtn" style="float: right;
    background-color: #49a2fb;
    cursor: pointer;
    margin-top: 0px;
    margin-right: 34px;
  color: #fff;
    border-radius: 15px;" data-toggle="modal" data-target="#modaldemo1">Add <i class="fas fa-plus-circle"></i></button>
     @endcan
    @endif

                </div>
<br><br>

                <div class="col-md-12" class="table-wrapper">
<div id="modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" action="{{route('familymember.export')}}">
                            {{csrf_field()}}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">SELECT COLUMNS TO EXPORT</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @foreach($columns as $col)
                                        <div class="col-sm-3"><label><input type="checkbox" name="columns[]" value="{{$col}}"> {{ucwords(str_replace('_',' ',$col))}}</label></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default"><i class="fa fa-download"></i> Export</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <table  class="table display nowrap datatable">
              <thead>
                <tr>

                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-25p">Name</th>
                   <th class="wd-10p">Comment</th>
                  <th class="wd-10p">Relationship</th>
                   <th class="wd-10p">CNIC</th>
                  <th class="wd-10p">Contact</th>
                  <th class="wd-15p">Supplementary Card #</th>
                  <th class="wd-10p">Issue Date</th>
                  <th class="wd-10p">Expiry Date</th>
                  <th class="wd-10p">Barcode #</th>
                   <th class="wd-15p">Picture</th>
                    <th class="wd-10p">Status</th>
                    @can('Edit Family Member')
                   <th class="wd-5p">Edit</th>
                   @endcan
                   @can('Delete Family Member')
                   <th class="wd-5p">Delete</th>
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

{{-- Family Member Modal --}}
 

     @if($init==1 && Gate::check('Update Supplementary Barcode'))
   <form method="post" action="{{ url('club-hospitality/familymember/barcodeupdate/') }}/{{ $family_update->member_id }}/{{ $family_update->id }}" enctype="multipart/form-data">
      @elseif($init==1 && !Gate::check('Update Supplementary Barcode'))
 <form method="post" action="{{ url('club-hospitality/familymember/update/') }}/{{ $family_update->member_id }}/{{ $family_update->id }}" enctype="multipart/form-data">
   @else
    <form method="post" enctype="multipart/form-data">
    @endif
    @csrf
<div id="modaldemo1" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 1000px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Family Member</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif

                 <div class="modal-body pd-25">
                  <div class="row headingsettings">
                      <div class="col-md-12">
 <div class="row ">
                  <label class="col-sm-2 form-control-label">Member Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('member_name')) style="border-color:red;" @endif type="text" name="member_name" id="member_name" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Full Name" value="@if($init==0){{old('member_name',$membershipdata->title)}} {{old('member_name',$membershipdata->first_name)}} {{old('member_name',$membershipdata->middle_name)}} {{old('member_name',$membershipdata->applicant_name)}}@else{{old('member_name',$family_update->member_name)}}@endif">
                  </div>

                  <label class="col-sm-2 form-control-label">Membership #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('membership_number')) style="border-color:red;" @endif type="text" name="membership_number" id="membership_number" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Membership No." value="@if($init==0){{$membershipdata->mem_no}}@else{{old('membership_number',$membershipdata->mem_no)}}@endif">
                  </div>
              </div>

              </br>
               <h6 class="box-title" style="color: black;">FAMILY MEMBER DETAILS</h6>
                 </br>

                 <div class="row mg-t-10">
                        <label class="col-sm-2 form-control-label">
                            Title:
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                              <select @if ($errors->has('title')) style="border-color:red;" @endif id="title" class="form-control" name="title">

                                <option label="Choose Option">
                                </option>
                                @foreach($titles as $t)
                                @if($init==1)
                                 <option @if(old('title',$family_update->title)==$t->desc)  selected @endif  value="{{ $t->desc }}">
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

 
                           <label class="col-sm-2 form-control-label">Supplementary Card #:<span class="tx-danger">*</span></label>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('sup_card_no')) style="border-color:red;" @endif  id="sup_card_no" type="text" name="sup_card_no" class="form-control input-height" placeholder="Enter Supplementary Card No." value="@if($init==0){{old('sup_card_no',$membershipdata->mem_no.'-'.generateRandomString($suppno))}}@else{{old('sup_card_no',$family_update->sup_card_no)}}@endif">
              </div>
               @can('Edit Membership Number')
              <div class="col-sm-1 mg-t-10 mg-sm-t-0">
 <input id="check" class="form-control input-height" type="checkbox" name="check" onclick="checks()">
              </div>
              @endcan
                    </div>


  <div class="row mg-t-10">
                        <label class="col-sm-2 form-control-label">
                            First Name:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('first_name')) style="border-color:red;" @endif id="first_name" class="form-control" placeholder="Enter First Name" value="@if($init==0){{old('first_name')}}@else{{old('first_name',$family_update->first_name)}}@endif"  type="text" name="first_name">

                        </div>

                        <label class="col-sm-2 form-control-label">
                            Middle Name:
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('middle_name')) style="border-color:red;" @endif id="middle_name" class="form-control input-height" placeholder="Enter Middle Name" value="@if($init==0){{old('middle_name')}}@else{{old('middle_name',$family_update->middle_name)}}@endif"  type="text" name="middle_name">

                        </div>
                    </div>

                        <div class="row mg-t-10">
                           <label class="col-sm-2 form-control-label">Last Name:<span class="tx-danger">*</span></label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('name')) style="border-color:red;" @endif  id="name" type="text" name="name" class="form-control input-height" placeholder="Enter Last Name" value="@if($init==0){{old('name')}}@else{{old('name',$family_update->name)}}@endif">
              </div>

                        <label class="col-sm-2 form-control-label">
                            Name Comments:
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <input @if ($errors->has('name_comment')) style="border-color:red;" @endif id="name_comment" class="form-control input-height" placeholder="Enter your Comments" value="@if($init==0){{old('name_comment')}}@else{{old('name_comment',$family_update->name_comment)}}@endif"  type="text" name="name_comment">

                        </div>
                    </div>



                  <div class="row mg-t-10">
                  <label class="col-sm-2 form-control-label">Relationship:<span class="tx-danger">*</span></label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('fam_relationship')) style="border-color:red;" @endif id="fam_relationship" class="form-control" name="fam_relationship">
                            <option label="Choose Relationship">
                                </option>
                               @foreach($relationships as $relationship)
                                @if($init==1)
                                 <option @if(old('fam_relationship',$family_update->fam_relationship)==$relationship->id)  selected @endif  value="{{ $relationship->id }}">
                                  {{ $relationship->desc }}
                                </option>
                                @else
                                 <option @if(old('fam_relationship')==$relationship->id)  selected @endif value="{{ $relationship->id }}">
                                  {{ $relationship->desc }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                  </div>



                        <label class="col-sm-2 form-control-label">
                            Gender:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('gender')) style="border-color:red;" @endif class="form-control" name="gender" value="@if($init==0){{old('gender')}}@else{{old('gender',$family_update->gender)}}@endif">
                                <option label="Choose Gender">
                                </option>
                                 @if($init==1)
                                 <option @if(old('gender',$family_update->gender)=='Male') selected @endif value="Male">
                                    Male
                                </option>
                                <option @if(old('gender',$family_update->gender)=='Female') selected @endif value="Female">
                                    Female
                                </option>
                                <option @if(old('gender',$family_update->gender)=='Other') selected @endif value="Other">
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
                  <label class="col-sm-2 form-control-label">Maritial Status: <span class="tx-danger">*</span></label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('maritial_status')) style="border-color:red;" @endif class="form-control" id="maritial_status" name="maritial_status" value="@if($init==0){{old('maritial_status')}}@else{{old('maritial_status',$family_update->maritial_status)}}@endif">
                      @if($init==1)
                                 <option @if(old('maritial_status',$family_update->maritial_status)=='Single') selected @endif value="Single">
                                    Single
                                </option>
                                <option @if(old('maritial_status',$family_update->maritial_status)=='Married') selected @endif value="Married">
                                    Married
                                </option>
                                <option @if(old('maritial_status',$family_update->maritial_status)=='Divorced') selected @endif value="Divorced">
                                    Divorced
                                </option>
                                 @else

                                 <option @if(old('maritial_status')=='Single') selected @endif value="Single">
                                    Single
                                </option>
                                <option @if(old('maritial_status')=='Married') selected @endif value="Married">
                                    Married
                                </option>
                                <option @if(old('maritial_status')=='Divorced') selected @endif value="Divorced">
                                   Divorced
                                </option>

                                 @endif
                    </select>
                  </div>
                </div><!-- row -->

                  <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-2 form-control-label">Date of Birth: <span class="tx-danger">*</span></label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('date_of_birth')) style="border-color:red;" @endif  id="date_of_birth" type="text" name="date_of_birth" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" value="@if($init==0){{old('date_of_birth')}}@else{{old('date_of_birth',formatDateToShow($family_update->date_of_birth))}}@endif">
                  </div>

                  <label class="col-sm-2 form-control-label">Nationality:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('nationality')) style="border-color:red;" @endif id="nationality" type="text" name="nationality" class="form-control input-height" placeholder="Enter Nationality e.g. Pakistani" value="@if($init==0){{old('nationality')}}@else{{old('nationality',$family_update->nationality)}}@endif">
                  </div>
                </div><!-- row -->

                  <div class="row mg-t-10">
                  <label class="col-sm-2 form-control-label">CNIC #:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('cnic')) style="border-color:red;" @endif id="cnic" type="text" name="cnic" autocomplete="off" class="form-control input-height" placeholder="Enter CNIC no. (13 digits)" value="@if($init==0){{old('cnic')}}@else{{old('cnic',$family_update->cnic)}}@endif">
                  </div>

                  <label class="col-sm-2 form-control-label">Passport #:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('passport_no')) style="border-color:red;" @endif id="passport_no" type="text" autocomplete="off" name="passport_no" class="form-control input-height" placeholder="Enter Passport no. (8 digits)" value="@if($init==0){{old('passport_no')}}@else{{old('passport_no',$family_update->passport_no)}}@endif">
                  </div>
                </div><!-- row -->

                  <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-2 form-control-label">Contact: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('contact')) style="border-color:red;" @endif id="contact" type="text" name="contact" class="form-control input-height" placeholder="Enter Family Member's Contact " value="@if($init==0){{old('contact')}}@else{{old('contact',$family_update->contact)}}@endif">
                  </div>

                  <label class="col-sm-2 form-control-label">Barcode Card #:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('sup_barcode')) style="border-color:red;" @endif class="form-control input-height" placeholder="Enter Supplementary Card's Barcode no." type="text" id="sup_barcode" name="sup_barcode" value="@if($init==0){{old('sup_barcode')}}@else{{old('sup_barcode',$family_update->sup_barcode)}}@endif">
                  </div>
                </div><!-- row -->


                 <div class="row mg-t-10">
                  <label class="col-sm-2 form-control-label">Supplementary Card Issue Date:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('sup_card_issue')) style="border-color:red;" @endif id="sup_card_issue" type="text" name="sup_card_issue" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" value="@if($init==0){{old('sup_card_issue') }}@else{{old('sup_card_issue',formatDateToShow($family_update->sup_card_issue))}}@endif">
                  </div>

                  <label class="col-sm-2 form-control-label">Supplementary Card Expiry Date:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('sup_card_exp')) style="border-color:red;" @endif id="sup_card_exp" type="text" name="sup_card_exp" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" value="@if($init==0){{old('sup_card_exp')}}@else{{old('sup_card_exp',formatDateToShow($family_update->sup_card_exp))}}@endif">
                  </div>
                </div><!-- row -->

                 <div class="row mg-t-10">
                  <label></label>
                  <label class="col-sm-2 form-control-label">Supplementary Card Status: <span class="tx-danger">*</span></label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <select @if ($errors->has('card_status')) style="border-color:red;" @endif class="form-control" name="card_status" id="card_status" value="@if($init==0){{old('card_status')}}@else{{old('card_status',$family_update->card_status)}}@endif">
                     @if($init==1)
                                 <option @if(old('card_status',$family_update->card_status)=='Issued') selected @endif value="Issued">
                                    Issued
                                </option>
                                 <option @if(old('card_status',$family_update->card_status)=='Applied') selected @endif value="Applied">
                                    Applied
                                </option>
                                <option @if(old('card_status',$family_update->card_status)=='Printed') selected @endif value="Printed">
                                    Printed
                                </option>
                                <option @if(old('card_status',$family_update->card_status)=='Re-Printed') selected @endif value="Re-Printed">
                                    Re-Printed
                                </option>
                               <option @if(old('card_status',$family_update->card_status)=='Not Applied') selected @endif value="Not Applied">
                                    Not Applied
                                </option>
                                <option @if(old('card_status',$family_update->card_status)=='Expired') selected @endif value="Expired">
                                    Expired
                                </option>
                                <option @if(old('card_status',$family_update->card_status)=='Not Applicable') selected @endif value="Not Applicable">
                                    Not Applicable
                                </option>

                                 @else

                                 <option @if(old('card_status')=='Issued') selected @endif value="Issued">
                                    Issued
                                </option>
                                <option @if(old('card_status')=='Applied') selected @endif value="Applied">
                                    Applied
                                </option>
                                <option @if(old('card_status')=='Printed') selected @endif value="Printed">
                                    Printed
                                </option>
                                <option @if(old('card_status')=='Re-Printed') selected @endif value="Re-Printed">
                                    Re-Printed
                                </option>
                                <option @if(old('card_status')=='Not Applied') selected @endif value="Not Applied">
                                    Not Applied
                                </option>
                                <option @if(old('card_status')=='Expired') selected @endif value="Expired">
                                    Expired
                                </option>
                                <option @if(old('card_status')=='Not Applicable') selected @endif value="Not Applicable">
                                    Not Applicable
                                </option>

                                 @endif
                  </select>
                  </div>

                        <label class="col-sm-2 form-control-label">
                        Status:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                           <select @if ($errors->has('status')) style="border-color:red;" @endif id="status" class="form-control" name="status">
                               @foreach($stati as $stat)
                                @if($init==1)
                                 <option @if(old('status',$family_update->status)==$stat->id)  selected @endif  value="{{ $stat->id }}">
                                  {{ $stat->desc }}
                                </option>
                                @else
                                 <option @if(old('status')==$stat->id)  selected @endif value="{{ $stat->id }}">
                                  {{ $stat->desc }}
                                </option>
                                @endif
                                @endforeach
                          </select>
                           <!--  <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$family_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$family_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$family_update->status)=='0') selected @endif value="0">
                                    In-Active
                                </option>

                                @else

                              <option @if($init==0) selected="" @else @if(old('status')=='1') selected @endif @endif value="1">
                                   Active
                                </option>
                                <option @if(old('status')=='0') selected @endif value="0">
                                    In-Active
                                </option>

                                @endif


                            </select> -->
                        </div>

                    </div>
    <div class="row mg-t-10">
        <label class="col-sm-2 form-control-label">Family Member Picture: </label>
                        <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                             <img id="picchose" style="width: 289px; height: 220px;" src="@if($init==1) {{ url('') }}/{{old('fam_picture',$family_update->familymemberPic?$family_update->familymemberPic->url:'')}}@else {{ url('assets/images/nouser.png') }} @endif">
                             @if($init==0)
                            <input @if ($errors->has('fam_picture')) style="border-color:red;" @endif type="file" name="fam_picture" value="@if($init==0){{old('fam_picture')}}@endif">
                             @else
                                 &nbsp  &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="fam_picture" />
</div>
                            <input type="hidden" name="existimg" value="{{old('fam_picture',$family_update->familymemberPic?$family_update->familymemberPic->url:'')}}">
                            @endif

                        </div>
                    </div>

<div class="row mg-t-10">
                      <label class="col-sm-2 form-control-label">Comment Box:</label>
                        <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                    <textarea @if ($errors->has('remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter Remarks" rows="2" name="remarks">@if($init==0){{old('remarks')}}@else{{old('remarks',$family_update->remarks)}}@endif</textarea>
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


@if(Gate::check('Update Supplementary Barcode') )
<button type="input" name="save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Update Barcode</button>
@else
<button type="input" name="save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Update</button>
@endif


                     
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                  @endif
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
      </form>


{{-- Family Member Modal --}}

@endsection
@push('jscode')

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


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
 
<script src="{{ asset('/assets/plugins/datatable/datatables.min.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" ></script>

  <script>
    $( function() {
    $( "#date_of_birth" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

     $( function() {
    $( "#sup_card_issue" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#sup_card_exp" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
  </script>
  
<script src="{{ asset('/assets/plugins/jquery-mask-plugin/dist/jquery.mask.js') }}" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

  $('#cnic').mask('AAAAA-AAAAAAA-A');
$('#contact').mask('00000000000');
$('#passport_no').mask('AAAAAAAA');
</script>

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
          'url': '{{ route('familymember.datatable',$membershipdata->id) }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [

            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'name', name: 'name', searchable: true},
            {data: 'name_comment', name: 'name_comment', searchable: false},
            {data: 'fam_relationship', name: 'fam_relationship', searchable: true},
            {data: 'cnic', name: 'cnic', searchable: true},
            {data: 'contact', name: 'contact', searchable: true},
            {data: 'sup_card_no', name: 'sup_card_no', searchable: true},
            {data: 'sup_card_issue', name: 'sup_card_issue', searchable: false},
            {data: 'sup_card_exp', name: 'sup_card_exp', searchable: false},
            {data: 'sup_barcode', name: 'sup_barcode', searchable: true},
            {data: 'fam_picture', name: 'fam_picture', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            @can('Edit Family Member')
            {data: 'editbutton', name: 'editbutton', orderable: false},
            @endcan
            @can('Delete Family Member')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},
            @endcan
        ]
    });

</script>



<script type="text/javascript">
  $( document ).ready(function() {
/*console.log('1233');*/
if($("#check").prop('checked') == true){
document.getElementById('sup_card_no').readOnly = false;
}
else if($("#check").prop('checked') == false){
  document.getElementById('sup_card_no').readOnly = true;
}
});
</script>
<script type="text/javascript">
  function checks(){
/*console.log('1233');*/
if($("#check").prop('checked') == true){
document.getElementById('sup_card_no').readOnly = false;
}
else if($("#check").prop('checked') == false){
  document.getElementById('sup_card_no').readOnly = true;
}
    } 
</script>


@if($init==1)
<script type="text/javascript">
     $(document).ready(function(){

      console.log(1234);

    document.getElementById("btnadd").click();
    });
</script>
@endif

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
