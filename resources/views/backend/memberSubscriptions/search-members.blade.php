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

</style>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Search Members</h6>
         <div style="text-align: right;">

          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Member Management</a></li>
  <li><a href>Search Members Subscriptions</a></li>
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
            <input value="{{request('barcode')}}" value="" type="text" class="form-control" id="barcode" name="barcode">
        </div>
    </div>
    <div class="col-sm">
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
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="name">Name</label>
            <input value="{{request('name')}}" type="text" class="form-control" id="name" name="name">
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



<div class="card" style="background: #f9f9f9">
    <div class="card-body">
        <div class="row">
    <div class="col-sm-4">
    <div class="row">
    <div class="col-sm-4">
        @if(  $membershipdata->profilePic)
            <img src="{{url( $membershipdata->profilePic->url)}}" alt=""  height="100" width="100"/>
        @else
            <img src="//image.flaticon.com/icons/png/512/149/149071.png" height="100" width="100" alt=""/>
        @endif
    </div>
        <div class="col-sm-8">
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
        </div>
    </div>
    </div>
        <div class="col-sm-8">
            <form method="post" action="{{route('member.subscription.save',['id'=>$membershipdata->id])}}">
{{csrf_field()}}
        <h4>Member Subscriptions   <button style="    float: right;" type="submit" class="btn btn-primary "><i class="fa fa-address-card"></i> Save</button></h4>
            <div class="row">
{{--                @dd($subscriptions);--}}
                @foreach($subscriptions as $subscription)
                    <div class="col-sm-2">
                        <label for="idx{{$subscription->id}}">
                            <input type="checkbox"
                            @if(in_array($subscription->id,$membershipdata->subscriptions->pluck('subscription_id')->toArray()))
                                checked="checked"

                            @endif    name="sub[]"
                                   id="idx{{$subscription->id}}" value="{{$subscription->id}}">{{$subscription->desc}} </label>
                    </div>
                @endforeach
            </div>

            </form>
        </div>
    </div>
</div>





                @else



                    @if(request('search'))
                    <h3 class="text-center text-warning"><i class="fa fa-exclamation-triangle"></i> No Member found try to change your search criteria</h3>

                    @endif
                    @endif
              </div><!-- form-layout -->
            </div><!-- col-6 -->
 </div>
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection
@push('jscode')



@endpush
