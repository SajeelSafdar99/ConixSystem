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
    height: 60px;
}
.w3-bar .w3-button {
    white-space: normal;
}
.theactiveclass{
background-color: #17a2b8!important;
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
 .visitingCard{

     background-image:url('/erppro/public/assets/img/card_bg.jpeg');
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
    background-image: url("/erppro/public/assets/img/card_bg_family.jpeg");
        color:#000;
        text-shadow:1px 1px 1px #fff;
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
  @if($init==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Cards</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
  <li><a href>Cards</a></li>
</ul>
@endif


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
  <button class="w3-bar-item w3-button  w3-red" onclick="" disabled>Credit Limit</button>
  @endcan

  @can('View Notices')
  <button class="w3-bar-item w3-button  w3-red" onclick="" disabled>Notices</button>
  @endcan

  <button class="w3-bar-item w3-button  w3-red theactiveclass" onclick="location.href='{{ url('club-hospitality/membership/cards/') }}/{{Request::segment(4)}}' ">Cards</button>

</div>
<br><br>
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
                   <b class="profession">{{$membershipdata->applicant_name}}</b>
                  </div>
                </div><!-- row -->


            <div class="row mg-t-10">

                  <label class="col-sm-1 form-control-label profession"><u>Membership #:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$membershipdata->mem_no}}</b>
                  </div>
                </div><!-- row -->

                <br>

            <div class="form-layout form-layout-4 inner-content-address">

                <div class="col-md-12" class="table-wrapper" style="">
                    <div class="row">
                        <div class="col-sm-4">
                        <div class="visitingCard">
                            <div class="image">
                                @if($membershipdata->profilePic)
                                    <img style="height: 100px;width: 100px" src="{{url($membershipdata->profilePic->url)}}">

                                @else
                                <img src="//via.placeholder.com/100">
@endif
                                <span class="name">
                                {{$membershipdata->applicant_name}}
                            </span>
                            </div>
                            <div class="membership_number">
                            <span class="mem_n">Membership No</span>
                                <span class="mem_no">{{$membershipdata->mem_no}}</span>
                            </div>
                            <div class="valid">
                            <span class="valid1">VALID<br>THRU</span>
                                <span class="mem_no">{{formatDateToShow($membershipdata->card_exp)}}</span>
                            </div>


                        </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                    @foreach($membershipdata->family as  $f)
                            <div class="col-sm-4">
                                <div class="visitingCard family">
                                    <div class="image">
{{--                                        {{isset($membershipdata->profilepic[0])?$membershipdata->profilepic[0]->url:''}}--}}
                                        @if($f->familymemberPic)
                                            <img style="height: 100px;width: 100px" src="{{url($f->familymemberPic->url)}}">

                                        @else
                                            <img src="//via.placeholder.com/100">
                                        @endif
                                        <span class="name">
                                {{$f->name}}
                            </span>
                                    </div>
                                    <div class="membership_number">
                                        <span class="mem_n">Membership No</span>
                                        <span class="mem_no">{{$f->sup_card_no}}</span>
                                    </div>
                                    <div class="valid">
                                        <span class="valid1">VALID<br>THRU</span>
                                        <span class="mem_no">{{formatDateToShow($f->sup_card_exp)}}</span>
                                    </div>


                                </div>
                            </div>
                        @endforeach
                    </div>

          </div>

              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


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
          'url': '{{ route('cards.datatable',$membershipdata->id) }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [
          // {
          //       // "className":      'details-control',
          //       "orderable":      false,
          //       "data":           null,
          //       "defaultContent": '',
          //       'searchable': false
          //   },
            // {data: 'id',name: 'id', orderable: false, searchable: false},
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },

            {data: 'editbutton', name: 'editbutton'},
            {data: 'deletebutton', name: 'deletebutton'},
        ]
    });

</script>

@endpush
