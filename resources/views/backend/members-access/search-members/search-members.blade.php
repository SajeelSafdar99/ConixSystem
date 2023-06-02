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
    /*  margin-top: 3%;*/
/*      margin-bottom: 3%;*/
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
    <script>
        function red(a){
            let c=a
            // setTimeout(function(){
            //     window.location.href=c;
            // },5000)

        }
    </script>
    
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Search Members</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">

          <a href="{{url()->current()}}">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('members-access') }}">Members Access Management</a></li>
  <li><a href>Search Members List</a></li>
</ul>

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
<form method="get">
    <div class="row">
    <div class="col-sm">
        <div class="form-group">
            <label for="barcode">Barcode</label>
            <input autofocus="autofocus" value="" type="text" class="form-control" id="barcode" name="barcode">
        </div>
    </div>  <div class="col-sm">
        <div class="form-group">
            <label for="barcode">Family Barcode</label>
            <input autofocus="autofocus" value="" type="text" class="form-control" id="barcode" name="barcode2">
        </div>
    </div>
 <!--    <div class="col-sm">
        <div class="form-group">
            <label for="member_id">Member ID</label>
            <input value="{{request('member_id')}}" type="text" class="form-control" id="member_id" name="member_id">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="membership_number">Membership Number</label>
            <input value="{{request('membership_number')}}" type="text" class="form-control" id="membership_number" name="membership_number">
        </div>
    </div> -->
    <div class="col-sm">
        <div class="form-group">
            <label for="name">Name</label>
            <input id="customer_search" autocomplete="off" autosearch="off" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" value="{{request('name')}}" type="text" class="form-control" id="name" name="name">

            <input type="hidden" name="mog_id" value="{{old('mog_id')}}"  >
            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
        </div>
    </div><div class="col-sm">
        <div class="form-group">
            <label for="name">Family Name</label>
            <input id="customer_search2" autocomplete="off" autosearch="off" onkeyup="fcustomerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox2').hide();},500)" value="{{request('fname')}}" type="text" class="form-control" id="fname" name="fname">

            <input type="hidden" name="fam_id" value="{{old('fam_id')}}"  >
            <ul id="areabox2" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="cnic">CNIC</label>
            <input value="{{request('cnic')}}" type="text" class="form-control" id="cnic" name="cnic">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="contact">Contact (Primary)</label>
            <input value="{{request('contact')}}" type="text" class="form-control" id="contact" name="contact">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="car_number">Car Number</label>
            <input value="{{request('car_number')}}" type="text" class="form-control" id="car_number" name="car_number">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">

            <button type="submit" name="search"  value="1" class="mg-t-30 btn btn-success"><i class="fa fa-search"></i> Search</button>
        </div>
    </div>
    </div>
</form>
                @if($membershipdata)
                    @if($membershipdata->mem_barcode!=request('barcode') || request('fam_id'))
                        @php
                            if(request('fam_id')){
                                $family=$membershipdata->family()->where('id',request('fam_id'))->first() ;

                        }
else{

                            $family=$membershipdata->family()->where('sup_barcode',request('barcode'))->first()   ;  } @endphp

                    @else
                        @php $family=null @endphp

                    @endif


                    <div class=" emp-profile">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-img">
                                        @if(!$family)

                                        @if(  $membershipdata->profilePic)
                                        <img src="{{url( $membershipdata->profilePic->url)}}" alt=""/>
                                        @else
                                            <img src="https://image.flaticon.com/icons/png/512/149/149071.png" alt=""/>
@endif
                                        @else


                                                @if($family->familymemberPic)
                                                    <img src="{{url( $family->familymemberPic->url)}}" alt=""/>
                                                @else
                                                    <img src="https://image.flaticon.com/icons/png/512/149/149071.png" alt=""/>
                                                @endif
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="profile-head">
@if(!$family)
                                        <h5 style="text-transform: uppercase;">
{{$membershipdata->title}} {{$membershipdata->first_name}} {{$membershipdata->middle_name}} {{$membershipdata->applicant_name}} ({{membershipStatus($membershipdata->active)}})
                                        </h5>
                                        <h6>
                                            Membership No: {{$membershipdata->mem_no}}
                                        </h6>
                                        <p class="proile-rating">Membership expiry: {{formatDateToShow($membershipdata->card_exp)}}</p>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#info" role="tab" aria-controls="home" aria-selected="true">Membership Information</a>
                                            </li>
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>--}}
{{--                                            </li>--}}
                                        </ul>
    @else


                                            <h5>
                                                {{$family->title}} {{$family->first_name}} {{$family->middle_name}} {{$family->name}}
                                            </h5>
                                            <h6>
                                                Membership No: {{$family->sup_card_no}}
                                            </h6>
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#info" role="tab" aria-controls="home" aria-selected="true">Membership Information</a>
                                                </li>
                                                {{--                                            <li class="nav-item">--}}
                                                {{--                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>--}}
                                                {{--                                            </li>--}}
                                            </ul>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    @if(!$family)
                                    <a href="{{route('access.checkin',['type'=>'member','id'=>$membershipdata->id])}}"  class="btn btn-primary">Check In</a>
                                    <script>
                                        red("{{route('access.checkin',['type'=>'member','id'=>$membershipdata->id])}}")
                                    </script>
                                        <hr>
                                    <span class="">Last check in:<br> {{$membershipdata->visits->last()?$membershipdata->visits->last()->created_at->format('F jS Y | h:i A'):'never'}}</span>
                           <hr>
                                    @if(count($membershipdata->visits)>1)
                            <a href="#" data-toggle="collapse" data-target="#history"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                    <ul class="list-unstyled collapse" id="history">
                                        @foreach($membershipdata->visits->sortByDesc('id') as $v)
                                            @if ($loop->first) @continue @endif

                                            <li>
                                                {{$v->created_at->format('F jS Y | h:i A')}}
                                            </li>
                                            @endforeach
                                    </ul>





                                        @endif




                                    @else

                                        <a href="{{route('access.checkin',['type'=>'family','id'=>$family->id])}}"  class="btn btn-primary">Check In</a>
                                        <script>
                                           red("{{route('access.checkin',['type'=>'family','id'=>$family->id])}}")
                                        </script>
                                        <hr>
                                        <span class="">Last check in:<br> {{$family->visits->last()?$family->visits->last()->created_at->format('F jS Y | h:i A'):'never'}}</span>
                                        <hr>
                                        @if(count($family->visits)>1)
                                            <a href="#" data-toggle="collapse" data-target="#history"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                            <ul class="list-unstyled collapse" id="history">
                                                @foreach($family->visits->sortByDesc('id') as $v)
                                                    @if ($loop->first) @continue @endif

                                                    <li>
                                                        {{$v->created_at->format('F jS Y | h:i A')}}
                                                    </li>
                                                @endforeach
                                            </ul>





                                        @endif
@endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-work">
                                        <h2>Member Subscriptions</h2>
                                        <ul class="list-unstyled">
                                            @forelse ($sub as $s)
                                                <li style="color:#000;font-size:18px">@if($s->ac==1)<i class="fa fa-check text-success fa-2x"></i>@else <i class="fa fa-times text-danger fa-2x"></i>@endif {{$s->name}}</li>
                                            @empty
<li style="color:#000;font-size:18px">No subscription found</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            @if(!$family)
                                            @if($membershipdata->personal_email)

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$membershipdata->personal_email}}</p>
                                                </div>
                                            </div>
                                                    @endif  @if($membershipdata->mob_a)

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Contact</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$membershipdata->mob_a}}</p>
                                                </div>
                                            </div> <div class="row">
                                                <div class="col-md-6">
                                                    <label>Barcode</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$membershipdata->mem_barcode}}</p>
                                                </div>
                                            </div>
                                                    @endif  @if($membershipdata->date_of_birth)

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Date of Birth</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{$membershipdata->date_of_birth}}</p>
                                                </div>
                                            </div>
                                                    @endif
                                                @else
                                          @if($family->relationship_name)

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Relationship</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>{{$family->relationship_name->desc}}</p>
                                                        </div>
                                                    </div> <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Maritial Status:</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>{{$family->maritial_status}}</p>
                                                        </div>
                                                    </div>
                                                @endif  @if($family->sup_barcode)

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Bar Code:</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>{{$family->sub_barcode}}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            @if($membershipdata->family)
                                               <hr>
                                                <div class="row">
                                                <div class="col-sm-12">
                                                <h5>
                                                    Family
                                                </h5>
                                                    <div class="row">
                                                    @foreach($membershipdata->family()->with('visits')->get() as $f)
                                                        @if($f->sup_barcode==request('barcode') || $f->id==request('fam_id') )
                                                                <div class="col-sm-6">
                                                                    <div class="card" style="    background: #49a2fb;">

                                                                        <div class="">
                                                                            <table class="table table-striped">

                                                                                @if(  $membershipdata->profilePic)
                                                                                    <img src="" alt=""/>

                                                                                    <tr>
                                                                                        <td colspan="1" class="text-center">
                                                                                            <img src="{{url( $membershipdata->profilePic->url)}}" style="height: 150px;    width: 100px;" class="img-responsive">
                                                                                            <h5>{{$membershipdata->title}} {{$membershipdata->first_name}} {{$membershipdata->middle_name}} {{$membershipdata->applicant_name}}</h5>

                                                                                        </td>
                                                                                        <td>
                                                                                            <table class="table table-striped">
                                                                                                <tr>
                                                                                                    <td>Membership No: </td>
                                                                                                    <td>{{$membershipdata->mem_no}}</td>
                                                                                                </tr>

                                                                                                @if($membershipdata->mob_a)
                                                                                                    <tr>
                                                                                                        <td>Contact: </td>
                                                                                                        <td>{{$membershipdata->mob_a}}</td>
                                                                                                    </tr>
                                                                                                @endif  @if($membershipdata->mem_barcode)
                                                                                                    <tr>
                                                                                                        <td>Bar Code: </td>
                                                                                                        <td>{{$membershipdata->mem_barcode}}</td>
                                                                                                    </tr>
                                                                                                @endif @if($membershipdata->date_of_birth)
                                                                                                    <tr>
                                                                                                        <td>Date of Birth: </td>
                                                                                                        <td>{{$membershipdata->date_of_birth}}</td>
                                                                                                    </tr>
                                                                                                @endif
                                                                                                <tr>

                                                                                                    <td colspan="2">

                                                                                                        {{--@dd($familySubscriptions);--}}

                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>  <span class="">Last check in: <br>{{$membershipdata->visits->last()?$membershipdata->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                                                        @if(count($membershipdata->visits)>1)
                                                                                                            <a href="#" data-toggle="collapse" data-target="#history{{$membershipdata->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                                                            <ul class="list-unstyled collapse" id="history{{$membershipdata->id}}">
                                                                                                                @foreach($membershipdata->visits->sortByDesc('id') as $v)
                                                                                                                    @if ($loop->first) @continue @endif
                                                                                                                    <li>
                                                                                                                        {{$v->created_at->format('F jS Y | h:i A')}}
                                                                                                                    </li>
                                                                                                                @endforeach
                                                                                                            </ul>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td><a class="btn btn-primary" href="{{route('access.checkin',['type'=>'member','id'=>$membershipdata->id])}}">Checkin</a>


                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>

                                                                                    </tr>
                                                                                @else <tr>
                                                                                    <td colspan="1" class="text-center">
                                                                                        <img src="https://image.flaticon.com/icons/png/512/149/149071.png" height="150px" width="150px" class="img-responsive">
                                                                                        <h5>{{$f->name}}</h5>
                                                                                    </td>
                                                                                    <td>
                                                                                        <table class="table table-striped">
                                                                                            <tr>
                                                                                                <td>Membership No: </td>
                                                                                                <td>{{$f->sup_card_no}}</td>
                                                                                            </tr>
                                                                                            @if($f->relationship_name)
                                                                                                <tr>
                                                                                                    <td>Relationship: </td>
                                                                                                    <td>{{$f->relationship_name->desc}}</td>
                                                                                                </tr>
                                                                                            @endif
                                                                                            @if($f->maritial_status)
                                                                                                <tr>
                                                                                                    <td>Maritial Status: </td>
                                                                                                    <td>{{$f->maritial_status}}</td>
                                                                                                </tr>
                                                                                            @endif
                                                                                            <tr>
                                                                                                <td>  <span class="">Last check in:<br> {{$f->visits->last()?$f->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                                                    @if(count($f->visits)>1)
                                                                                                        <a href="#" data-toggle="collapse" data-target="#history{{$f->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                                                        <ul class="list-unstyled collapse" id="history{{$f->id}}">
                                                                                                            @foreach($f->visits->sortByDesc('id') as $v)
                                                                                                                @if ($loop->first) @continue @endif
                                                                                                                <li>
                                                                                                                    {{$v->created_at->format('F jS Y | h:i A')}}
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                        </ul>
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td><a class="btn btn-primary" href="{{route('access.checkin',['type'=>'family','id'=>$f->id])}}">Checkin</a>


                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>

                                                                                    </td>

                                                                                </tr>
                                                                                @endif

                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                        <div class="col-sm-6">
                                                            <div class="card">

                                                                <div class="">
                                                                    <table class="table table-striped">

                                                                        @if($f->familymemberPic)

                                                                        <tr>
                                                                            <td colspan="1" class="text-center">
                                                                                <img src="{{url($f->familymemberPic->url)}}" style="height: 150px;    width: 100px;" class="img-responsive">
                                                                                <h5>{{$f->title}} {{$f->first_name}} {{$f->middle_name}} {{$f->name}}</h5>

                                                                            </td>
                                                                            <td>
                                                                                <table class="table table-striped">
                                                                                    <tr>
                                                                                        <td>Membership No: </td>
                                                                                        <td>{{$f->sup_card_no}}</td>
                                                                                    </tr>
                                                                                    @if($f->relationship_name)
                                                                                        <tr>
                                                                                            <td>Relationship: </td>
                                                                                            <td>{{$f->relationship_name->desc}}</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    @if($f->maritial_status)
                                                                                        <tr>
                                                                                            <td>Maritial Status: </td>
                                                                                            <td>{{$f->maritial_status}}</td>
                                                                                        </tr>
                                                                                    @endif  @if($f->sup_barcode)
                                                                                        <tr>
                                                                                            <td>Bar Code: </td>
                                                                                            <td>{{$f->sup_barcode}}</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    <tr>

                                                                                        <td colspan="2">

{{--@dd($familySubscriptions);--}}
                                                                                        @foreach(
   !empty($familySubscriptions)?( $familySubscriptions['family']==$f->id?$familySubscriptions['subs']:[]):[]
             as
             $subscription)

                                                                                                <p > <i class="fa fa-check"></i> &nbsp; {{($subscription['subscription']['desc'])}} <small>(Valid till {{formatDateToShow($subscription['end_date'])}})</small></p>
                                                                                            @endforeach
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>  <span class="">Last check in: <br>{{$f->visits->last()?$f->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                                            @if(count($f->visits)>1)
                                                                                                <a href="#" data-toggle="collapse" data-target="#history{{$f->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                                                <ul class="list-unstyled collapse" id="history{{$f->id}}">
                                                                                                    @foreach($f->visits->sortByDesc('id') as $v)
                                                                                                        @if ($loop->first) @continue @endif
                                                                                                        <li>
                                                                                                            {{$v->created_at->format('F jS Y | h:i A')}}
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td><a class="btn btn-primary" href="{{route('access.checkin',['type'=>'family','id'=>$f->id])}}">Checkin</a>


                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>

                                                                        </tr>
                                                                            @else <tr>
                                                                            <td colspan="1" class="text-center">
                                                                                <img src="https://image.flaticon.com/icons/png/512/149/149071.png" height="150px" width="150px" class="img-responsive">
                                                                                <h5>{{$f->name}}</h5>
                                                                            </td>
                                                                            <td>
                                                                            <table class="table table-striped">
                                                                                <tr>
                                                                                    <td>Membership No: </td>
                                                                                    <td>{{$f->sup_card_no}}</td>
                                                                                </tr>
                                                                                @if($f->relationship_name)
                                                                                    <tr>
                                                                                        <td>Relationship: </td>
                                                                                        <td>{{$f->relationship_name->desc}}</td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if($f->maritial_status)
                                                                                    <tr>
                                                                                        <td>Maritial Status: </td>
                                                                                        <td>{{$f->maritial_status}}</td>
                                                                                    </tr>
                                                                                @endif
                                                                                <tr>
                                                                                    <td>  <span class="">Last check in:<br> {{$f->visits->last()?$f->visits->last()->created_at->format('M jS Y | h:i A'):'never'}}</span><br>
                                                                                        @if(count($f->visits)>1)
                                                                                            <a href="#" data-toggle="collapse" data-target="#history{{$f->id}}"><i class="fa fa-arrow-circle-down"></i> See History</a>
                                                                                            <ul class="list-unstyled collapse" id="history{{$f->id}}">
                                                                                                @foreach($f->visits->sortByDesc('id') as $v)
                                                                                                    @if ($loop->first) @continue @endif
                                                                                                    <li>
                                                                                                        {{$v->created_at->format('F jS Y | h:i A')}}
                                                                                                    </li>
                                                                                                @endforeach
                                                                                            </ul>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td><a class="btn btn-primary" href="{{route('access.checkin',['type'=>'family','id'=>$f->id])}}">Checkin</a>


                                                                                    </td>
                                                                                </tr>
                                                                            </table>

                                                                            </td>

                                                                        </tr>
                                                                        @endif

                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
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



                    @if(request('search'))
                    <h3 class="text-center text-warning"><i class="fa fa-exclamation-triangle"></i> No Member found try to change your search criteria</h3>

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
        let v=$('input[name="mog"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('search/customerdatalike') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "customerid": val,
                'MOC':v
            },
            success: function (data) {

                jQuery('#areabox').html('');
                jQuery.each(JSON.parse(data), function (i, val1) {

                $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                    let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                    let code = v == 1 ? val1.customer_no : val1.mem_no;
                      let status = val1.mem_status.desc;
                    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code} (${status})<li>`);


                });
$('#areabox').show();
                // $('#areabox').html(data);

            }
        });
    }   function fcustomerdata(val) {
        let v=$('input[name="mog"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('search/famcustomerdatalike') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "customerid": val,
                'MOC':v
            },
            success: function (data) {

                jQuery('#areabox2').html('');
                jQuery.each(JSON.parse(data), function (i, val1) {

                $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.name?val1.name:'';

                    let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                    let code = v == 1 ? val1.customer_name : val1.sup_card_no;
               let status = '';
                    if(val1.status==1)
                    {
                       status = 'Active';
                    }
                    else
                    {
                        status = 'In-Active';
                    }
                    $("#areabox2").append(`<li onclick="fcustomerdatavalue('${val1.id}')">${name} : ${code} (${status})<li>`);


                });
$('#areabox').show();
                // $('#areabox').html(data);

            }
        });
    }
    function customerdatavalue(val) {
        let v=$('input[name="mog"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('search/customerdata') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "customerid": val,
                'MOC':v
            },
            success: function (data) {

                console.log(data);
                var obj = JSON.parse(data);

                if(v==1){
                    document.getElementById('customer_search').value = obj.customer_name;
                    $('input[name="mog_id"]').val( obj.id);
                }

                else{

                  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                    document.getElementById('customer_search').value = $fname+$mname+$lname;
                    $('input[name="mog_id"]').val( obj.id);

                }
                jQuery('#areabox').html('');

            }


        });
    } function fcustomerdatavalue(val) {
        let v=$('input[name="mog"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('search/famcustomerdata') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                "customerid": val,
                'MOC':v
            },
            success: function (data) {

                console.log(data);
                var obj = JSON.parse(data);

                if(false){
                    document.getElementById('customer_search2').value = obj.customer_name;
                    $('input[name="fam_id"]').val( obj.id);
                }

                else{

                  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.name?obj.name:'';

                    document.getElementById('customer_search2').value = $fname+$mname+$lname;
                    $('input[name="fam_id"]').val( obj.id);

                }
                jQuery('#areabox2').html('');

            }


        });
    }
</script>
@endsection
@push('jscode')

<script type="text/javascript">
$('#cnic').mask('00000-0000000-0');

</script>

@endpush
