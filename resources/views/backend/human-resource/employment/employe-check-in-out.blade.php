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

.profession{
  color: black !important;
  font-size: 16px !important;
}

 .visitingCard{

     background-image:url('/assets/img/card_bg.jpeg');
     padding:20px;
     background-repeat:no-repeat;
     background-size:cover;
     min-height:250px;
     position:relative;
     color:#fff;
     text-shadow:1px 1px 1px #000;
     border-radius:20px;
     box-shadow:1px 1px 9px #000
 }
 .visitingCard .membership_number{
     position:absolute;
     bottom:0;
     left:200px;
     text-align:center;
 }
 .visitingCard .membership_number .mem_n{
     display:block;
     font-weight: bold;
 }
 .visitingCard .image {
     position :absolute;
     top:60px;
     font-size:18px
 }
 .visitingCard .image img{
     display:block;margin-bottom:10px;
     box-shadow: 1px 1px 7px #000;
     border-radius: 5px;
 }
 .visitingCard .valid{
     position:absolute;
     right:10px;
     bottom:20px
 } .visitingCard.family{
    background-image: url("/assets/img/card_bg_family.jpeg");
        color:#000;
        text-shadow:1px 1px 1px #fff;
 }

  .emp-profile{
      padding: 3%;
      margin-top: 3%;
      margin-bottom: 3%;
      border-radius: 0.5rem;
      background: #efefef;
  }
  .profile-img{
      text-align: center;
  }
  .profile-img img{
      width: 200px;
      height: 100%;
  }
  .profile-img .file {
      position: relative;
      overflow: hidden;
      margin-top: -20%;
      width: 70%;
      border: none;
      border-radius: 0;
      font-size: 15px;
      background: #212529b8;
  }
  .profile-img .file input {
      position: absolute;
      opacity: 0;
      right: 0;
      top: 0;
  }
  .profile-head h5{
      color: #333;
  }
  .profile-head h6{
      color: #0062cc;
  }
  .profile-edit-btn{
      border: none;
      border-radius: 1.5rem;
      width: 70%;
      padding: 2%;
      font-weight: 600;
      color: #6c757d;
      cursor: pointer;
  }
  .proile-rating{
      font-size: 12px;
      color: #818182;
      margin-top: 5%;
  }
  .proile-rating span{
      color: #495057;
      font-size: 15px;
      font-weight: 600;
  }
  .profile-head .nav-tabs{
      margin-bottom:5%;
  }
  .profile-head .nav-tabs .nav-link{
      font-weight:600;
      border: none;
  }
  .profile-head .nav-tabs .nav-link.active{
      border: none;
      border-bottom:2px solid #0062cc;
  }
  .profile-work{
      padding: 14%;
      margin-top: -15%;
  }
  .profile-work p{
      font-size: 12px;
      color: #818182;
      font-weight: 600;
      margin-top: 10%;
  }
  .profile-work a{
      text-decoration: none;
      color: #495057;
      font-weight: 600;
      font-size: 14px;
  }
  .profile-work ul{
      list-style: none;
  }
  .profile-tab label{
      font-weight: 600;
  }
  .profile-tab p{
      font-weight: 600;
      color: #0062cc;
  }
</style>
<div class="br-pagebody">
        <div>
          @if($type==0)
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">CHECK-IN EMPLOYEE</h6>
          @else
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">CHECK-OUT EMPLOYEE</h6>
          @endif
         <div  style="text-align: right; margin-top: -39px;">

          <a href="{{url()->current()}}">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($type==0)
  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href>Check In Employee</a></li>
</ul>
@else
<ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href>Check Out Employee</a></li>
</ul>
@endif

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

 <div class="col-xl-12 ">
<!-- row -->


            <div class="form-layout form-layout-4 inner-content-address">
<form method="post" action="{{route(($type==0?'employee.checkin':'employee.checkout'))}}">
    {{csrf_field()}}
    <div class="row">
    <div class="col-sm">
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input autofocus="autofocus" value="" type="text" class="form-control" id="barcode" name="barcode">
            <input type="hidden" name="in_out" value="{{$type}}">
        </div>
    </div>  <div class="col-sm">
        <div class="form-group">
            <label for="barcode">Name</label>
            <input value="" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" type="text" class="form-control" id="name" name="">
            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
        </div>
    </div> <div class="col-sm">
        <div class="form-group">
            <label for="checkdate">Check  @if($type==0) in @else out @endif Date Time</label>
            <input type="datetime-local" name="checkdate" class="form-control">

        </div>
    </div>

    <div class="col-sm">
        <div class="form-group">

            <button type="submit" name="search"  value="1" class="mg-t-30 btn btn-success"><i class="fa fa-search"></i> @if($type=="0")Check In @else Check Out @endif</button>
        </div>
    </div>
    </div>
</form>

                @if(isset($employee))



                    <div class=" emp-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="text-success text-center">{{$employee->name}} Checked @if($type==0) in @else out @endif!</h2>
                                <script>
                                    setTimeout(function(){
                                        window.location.href="{{route(($type==0?'employee.checkin':'employee.checkout'))}}"
                                    },5000)
                                </script>
                            </div>
                        </div>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-img">
{{--                                        @if(  $employee->profilePic)--}}
{{--                                        <img src="{{url( $employee->profilePic->url)}}" alt=""/>--}}
{{--                                        @else--}}
{{--                                            <img src="//image.flaticon.com/icons/png/512/149/149071.png" alt=""/>--}}
{{--@endif--}}
                                        @if(  $employee->employeePic)
                                            <img src="{{url( $employee->employeePic->url)}}" alt=""/>
                                        @else
                                            <img src="//image.flaticon.com/icons/png/512/149/149071.png" alt=""/>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-head">
                                        <h5>
                                            {{$employee->name}} {{$employee->father_name}}
                                        </h5>
                                        <h6>
                                            Employee No: {{$employee->application_no}}
                                        </h6>

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#info" role="tab" aria-controls="home" aria-selected="true">Employee Information</a>
                                            </li>
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>--}}
{{--                                            </li>--}}
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">

                                    <hr>
                                    @if($type==1)
                                        <span class="">Last check in:<br> {{$employee->visits->last()?$employee->visits->last()->in?$employee->visits->last()->in->format('F jS Y | h:i A'):'never':'never'}}</span>

                                    @else
                                    <span class="">Last check out:<br> {{$employee->visits->last()?$employee->visits->last()->out?$employee->visits->last()->out->format('F jS Y | h:i A'):'never':'never'}}</span>
                           @endif
                                        <hr>

                                </div>
                            </div>
                            <div class="row">
<div class="col-sm-4">

</div>
                                <div class="col-md-8">
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            @if($employee->email)

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$employee->email}}</p>
                                                </div>
                                            </div>
                                                    @endif  @if($employee->mob_a)

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Contact</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$employee->mob_a}}</p>
                                                </div>
                                            </div>
                                                    @endif
                                                @if($employee->date_of_birth)

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Date of Birth</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$employee->date_of_birth}}</p>
                                                </div>
                                            </div>
                                                    @endif


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>





                @else


@if(isset($error))
                    @if($error==1)
                    <h3 class="text-center text-warning"><i class="fa fa-exclamation-triangle"></i> No Employee found try to change your search criteria</h3>
@elseif($error==2)
                        <h3 class="text-center text-warning"><i class="fa fa-exclamation-triangle"></i> Employee already check @if($type==0) in @else out @endif !</h3>

                    @endif
                    @endif
                    @endif
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

<script>
    function customerdata(val) {


        $.ajax({
            type: 'POST',
            url: '{{ url('search/employeedatalike') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "customerid": val,

            },
            success: function (data) {

                jQuery('#areabox').html('');
                jQuery.each(JSON.parse(data), function (i, val1) {
                    let name=val1.name;
                    let code=val1.barcode;
                    $("#areabox").append(`<li onclick="customerdatavalue('${val1.barcode}')">${name} - ${code}<li>`);


                });
$('#areabox').show();
                // $('#areabox').html(data);

            }
        });
    }
    function customerdatavalue(val) {
      $('#barcode').val(val);
      $('#barcode').parents('form').submit()


    }
</script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>
<script>
    $( function() {
        $( "#checkdate" ).datepicker({

            format: 'DD/MM/YYYY',
            todayHighlight: true
        })
    } );
</script>
@endsection
@push('jscode')

<script type="text/javascript">
$('#cnic').mask('00000-0000000-0');

</script>

@endpush
