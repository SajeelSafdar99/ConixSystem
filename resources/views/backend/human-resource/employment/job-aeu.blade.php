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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Employment</h6>
          <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
  @if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
  <li><a href>Edit Employment History</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
  <li><a href>Add Employment History</a></li>
</ul>
@endif


<div class="w3-bar w3-black">
   @if($init==1)
   <a href="{{ url('human-resource/employment/employment-aeu') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button  w3-red ">Employee</button>
</a>
  @else
 <button class="w3-bar-item w3-button w3-red " onclick="location.href='{{ url('human-resource/employment/employment-aeu/') }}/{{Request::segment(4)}}' ">Employee</button>
  @endif


  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('human-resource/employment/education-aeu/') }}/{{Request::segment(4)}}' ">Education</button>

    <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('human-resource/employment/job-aeu/') }}/{{Request::segment(4)}}' ">Jobs</button>

  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('human-resource/employment/reference-aeu/') }}/{{Request::segment(4)}}' ">References</button>

@can('View Employment Documents')
    <button class="w3-bar-item w3-button w3-red" onclick="location.href='{{ url('human-resource/employment/employment-docs-aeu/') }}/{{Request::segment(4)}}' ">Employment Documents</button>
    @endcan

</div>


@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

  <div class="col-xl-12 ">
 <div class="row mg-t-10">
     
                  <label class="col-sm-1 form-control-label profession"><u>Employee Name:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$employee_data->name}}</b>
                  </div>
                  @if($init==0)
<div style="text-align: right !important; margin-top: -25px;" class="col-sm-8 mg-t-10 mg-sm-t-0">
          @can('View Deleted Educations')
          <a href="{{ url('human-resource/job/deleted') }}/{{$employee_data->id}}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          &nbsp&nbsp&nbsp&nbsp&nbsp
        </div>
        @endcan
                </div><!-- row -->
         
             
            <div class="row mg-t-10">
      
                  <label class="col-sm-1 form-control-label profession"><u>Barcode #:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$employee_data->barcode}}</b>
                  </div>
                </div><!-- row -->

               

            <div class="form-layout form-layout-4 inner-content-address">

                 <div class="row" style="float: right;">

@if($init==1)
 @can('Edit Education')
       <button id="btnadd" style="float: right;
    background-color: #49a2fb;
    cursor: pointer;
    margin-top: 0px;
    margin-right: 34px;
  color: #fff;
    border-radius: 15px;"  data-toggle="modal" data-target="#modaldemo1">Edit <i class="fas fa-edit"></i></button>
    @endcan

    @else

    @can('Add Education')
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

            <table  class="table display nowrap datatable">
              <thead>
                <tr>

                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-15p">Company Name</th>
                   <th class="wd-15p">HOD Name</th>
                   <th class="wd-15p">Job Title</th>
                  <th class="wd-10p">Salary</th>
                
                    @can('Edit Job')
                   <th class="wd-5p">Edit</th>
                   @endcan
                   @can('Delete Job')
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

{{-- Education Modal --}}
@if($init==1)
<form method="post" action="{{ url('human-resource/job/update/') }}/{{ $job_update->employee_id }}/{{ $job_update->id }}" >
   @else
    <form method="post" >
    @endif
    @csrf
<div id="modaldemo1" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 1000px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Employment History</h6>
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

                 <div class="row mg-t-10">
                           <label class="col-sm-2 form-control-label">Company Name:<span class="tx-danger">*</span></label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('company_name')) style="border-color:red;" @endif id="company_name" type="text" name="company_name" class="form-control input-height" placeholder="Enter Company's Name" value="@if($init==0){{old('company_name')}}@else{{old('company_name',$job_update->company_name)}}@endif">
                </div>

                        <label class="col-sm-2 form-control-label">
                          Name of HR Head / HOD:<span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <input @if ($errors->has('hod')) style="border-color:red;" @endif id="hod" type="text" name="hod" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('hod')}}@else{{old('hod',$job_update->hod)}}@endif">
                        </div>
                    </div>


                       <div class="row mg-t-10">
                           <label class="col-sm-2 form-control-label">Address:<span class="tx-danger">*</span></label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('address')) style="border-color:red;" @endif id="address" type="text" name="address" class="form-control input-height" placeholder="Enter Complete Address of the Company" value="@if($init==0){{old('address')}}@else{{old('address',$job_update->address)}}@endif">
                </div>

                        <label class="col-sm-2 form-control-label">
                         Contact:<span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <input @if ($errors->has('contact')) style="border-color:red;" @endif id="contact" type="text" name="contact" class="form-control input-height" placeholder="Enter Contact Number" value="@if($init==0){{old('contact')}}@else{{old('contact',$job_update->contact)}}@endif">
                        </div>
                    </div>

  <div class="row mg-t-10">
                           <label class="col-sm-2 form-control-label">Job Title & Nature of Work:<span class="tx-danger">*</span></label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('work')) style="border-color:red;" @endif id="work" type="text" name="work" class="form-control input-height" placeholder="Enter Job Title and Description" value="@if($init==0){{old('work')}}@else{{old('work',$job_update->work)}}@endif">
                </div>
               <label class="col-sm-1 form-control-label">Employed From:<span class="tx-danger">*</span></label>
                  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('employed_from')) style="border-color:red;" @endif id="employed_from" type="text" autocomplete="off"  name="employed_from" class="form-control input-height" placeholder="dd/mm/yyyy" value="@if($init==0){{old('employed_from')}}@else{{old('employed_from',formatDateToShow($job_update->employed_from))}}@endif">
                  </div>
                  <label class="col-sm-1 form-control-label" style="color: black !important;">Employed To:<span class="tx-danger">*</span></label>
                  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('employed_to')) style="border-color:red;" @endif id="employed_to" autocomplete="off"  type="text" name="employed_to" class="form-control input-height" placeholder="dd/mm/yyyy" value="@if($init==0){{old('employed_to')}}@else{{old('employed_to',formatDateToShow($job_update->employed_to))}}@endif">
                  </div>
                    </div>

                        <div class="row mg-t-10">
                           <label class="col-sm-2 form-control-label">Salary:<span class="tx-danger">*</span></label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   <input @if ($errors->has('salary')) style="border-color:red;" @endif id="salary" type="number" name="salary" class="form-control input-height" placeholder="Enter per Month Salary" value="@if($init==0){{old('salary')}}@else{{old('salary',$job_update->salary)}}@endif">
                </div>

                        <label class="col-sm-2 form-control-label">
                         Reason for Leaving:<span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
  <textarea @if ($errors->has('reason')) style="border-color:red;" @endif class="form-control" placeholder="Enter Details" rows="2" name="reason">@if($init==0){{old('reason')}}@else{{old('reason',$job_update->reason)}}@endif</textarea>
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


{{-- Education Modal --}}

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
          'url': '{{ route('job.datatable',$employee_data->id) }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [

            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'company_name', name: 'company_name', searchable: true},
             {data: 'hod', name: 'hod', searchable: true},
            {data: 'work', name: 'work', searchable: true},
            {data: 'salary', name: 'years', searchable: true},
            @can('Edit Job')
            {data: 'editbutton', name: 'editbutton', orderable: false},
            @endcan
            @can('Delete Job')
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
    $( "#employed_from" ).datepicker({
       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

     $( function() {
     $( "#employed_to" ).datepicker({
       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
  </script>

 
<script src="{{ asset('/assets/plugins/jquery-mask-plugin/dist/jquery.mask.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  $('#contact').mask('00000000000');
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
