@extends('backend.layout.app')
@section('page-content')
 <style type="text/css">
   .form-control-label{
        color:black !important;
      }
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
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Check In</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-check-in') }}">Room Check In List</a></li>
  <li><a href>Edit Room Check In</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/room-check-in') }}">Room Check In List</a></li>
  <li><a href>Add Room Check In</a></li>
</ul>

@endif


<div class="col-xl-12">
@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

       @if($init==1)
    <form method="post" action="{{ url('room-management/room-check-in/update') }}/{{ $roombooking->id }}">
     @else
    <form method="post" action="{{url('room-management/room-check-in/update') }}/{{ Request::segment(4)}}">
    @endif
    @csrf

      <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                <div class="row">
                        <label class="col-sm-4 form-control-label">
                          Check In Date:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                         <?php

$month = date('m');
$day = date('d');
$year = date('Y');

$today =  $day.'/'.$month.'/'.$year;
?>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                      <input @if ($errors->has('check_in_date')) style="border-color:red;" @endif id="check_in_date" class="form-control input-height" type="text" placeholder="dd/mm/yyyy" name="check_in_date" value="{{formatDateToShow($roombooking->check_in_date)}}">

                        </div>
                    </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                          Check In Time
                          <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('check_in_time')) style="border-color:red;" @endif id="check_in_time" class="form-control input-height" type="time" name="check_in_time">

                        </div>
                    </div>
 @if($init==1)
  <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-check-in') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>
             @else
            <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Save</button>
                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-booking-vue') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

             @endif


              </div><!-- form-layout -->
            </div><!-- col-6 -->
          </form>
            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


@endsection


@push('jscode')
<script type="text/javascript">
  // Function which returns a minimum of two digits in case the value is less than 10
const getTwoDigits = (value) => value < 10 ? `0${value}` : value;

const formatTime = (date) => {
  const hours = getTwoDigits(date.getHours());
  const mins = getTwoDigits(date.getMinutes());

  return `${hours}:${mins}`;
}

const date = new Date();
document.getElementById('check_in_time').value = formatTime(date);
</script>

<!--      <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/>  -->

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

  <script>
  $( function() {
    $( "#check_in_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true,
       startDate: '-2d'
     });
  } );
  </script>

@endpush
