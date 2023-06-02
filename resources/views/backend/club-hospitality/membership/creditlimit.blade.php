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

.headingsetting{
  color: black !important;
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
 
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Credit Limit</a></li>
</ul>


<div class="w3-bar w3-black">

@if($init==1)
   <a href="{{ url('club-hospitality/membership/membership-aeu/') }}/{{Request::segment(4)}}' ">
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

@can('View Cars')
 <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('club-hospitality/membership/cars-aeu/') }}/{{Request::segment(4)}}' ">Cars</button>
 @endcan

@can('View Membership Documents')
  <button class="w3-bar-item w3-button  w3-red " onclick="location.href='{{ url('club-hospitality/membership/membership_docs-aeu/') }}/{{Request::segment(4)}}' ">Membership Documents</button>
  @endcan

@can('View Sports')
  <button class="w3-bar-item w3-button  w3-red" onclick="" disabled>Sports Subscription</button>
  @endcan

  @can('View Credit Limit')
<a href="{{ url('club-hospitality/membership/creditlimit') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button theactiveclass w3-red">Credit Limit</button>
</a>
  @endcan

  @can('View Notices')
  <button class="w3-bar-item w3-button  w3-red" onclick="" disabled>Notices</button>
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
 
@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
 
  <div class="col-xl-12 ">
  <div class="row mg-t-10">
     
                  <label class="col-sm-1 form-control-label profession"><u>Member Name:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->title}} {{$membershipdata->first_name}} {{$membershipdata->middle_name}} {{$membershipdata->applicant_name}}</b>
                  </div>
                </div><!-- row -->
         
             
            <div class="row mg-t-10">
      
                  <label class="col-sm-1 form-control-label profession"><u>Membership #:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->mem_no}}</b>
                  </div>
                </div><!-- row -->

                
  <form method="post" action="{{ url('club-hospitality/membership/updatecredit') }}/{{ $membership_update->id }}">
 @csrf
            <div class="form-layout form-layout-4 inner-content-address">
           <div class="row mg-t-10">
                      <label class="col-sm-2 form-control-label headingsetting">
                          Credit Limit Amount:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-6 mg-t-10 mg-sm-t-0" >
                            <input @if ($errors->has('credit_limit')) style="border-color:red;" @endif  id="credit_limit" autocomplete="off" class="form-control input-height charamt" type="number" name="credit_limit" placeholder="Enter Amount" value="@if($init==0){{old('credit_limit')}}@else{{old('credit_limit',$membership_update->credit_limit)}}@endif">

                        </div>
                  <div class="col-md-1"> </div>  
            
            <div class="col-md-2">

                  <button type="input" name="save" class="btn btn-success">Save</button>
             
            </div>

            </div>

   
              </div><!-- form-layout -->

            </form>

            </div><!-- col-6 -->
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


@endsection
