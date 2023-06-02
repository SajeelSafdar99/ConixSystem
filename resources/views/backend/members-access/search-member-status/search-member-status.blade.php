@extends('backend.layout.app')
@section('page-content')
<style type="text/css">

  .breadcrumbee,.border-menu,.br-header,.br-logo{
  display:none !important;
}
  .br-pagebody{
    padding: 15px 155px !important;
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
      color: black;
      font-size: 17px;
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
         
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-18 mg-b-10" style="text-align: center;">Membership Status Confirmation</h6>
       
         <div class="float-right">

        <!--   <a href="{{ url('members-access/search-member-status') }}">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a> -->
          </div>


 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
<br>

 

            <div class="form-layout form-layout-4 inner-content-address">
<form method="get">
  
    <div class="col-sm">
        <div class="form-group">
            <label for="membership_number">MEMBERSHIP #:</label>
            <input value="{{request('membership_number')}}" type="text" class="form-control" id="membership_number" name="membership_number" autocomplete="off">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="name">NAME:</label>
             <input value="{{request('name')}}" type="text" class="form-control" id="name" name="name" autocomplete="off">
        </div>
    </div>
    <div class="col-sm">
        <div class="form-group">
            <label for="cnic">CNIC:</label>
            <input value="{{request('cnic')}}" autocomplete="off" type="text" class="form-control" id="cnic" name="cnic">
        </div>
    </div>
    
    <div class="col-sm">
        <div class="form-group">

            <button type="submit" name="search"  value="1" class="mg-t-30 btn btn-success">SUBMIT</button>
        </div>
    </div>
    
</form>

 @if(request('search'))
    @if($memberstatus)
                    <div class=" emp-profile">
                        <form method="post">
                <b>Dear {{$membershipdata->first_name}} {{$membershipdata->middle_name}} {{$membershipdata->applicant_name}}, your Membership Status is "{{membershipStatus($memberstatus)}}".</b>
                        </form>
                    </div>





                    @elseif(!$memberstatus)

                     <h4 class="text-center text-warning"><i class="fa fa-exclamation-triangle"></i> Kindly Enter Accurate & Complete Information !</h4>
                    

                    @endif

                    @endif

              </div><!-- form-layout -->
         
            
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection
@push('jscode')

<script type="text/javascript">
$('#cnic').mask('00000-0000000-0');

</script>

@endpush
