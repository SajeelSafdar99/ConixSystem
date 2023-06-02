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
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Terms & Conditions</h6>
              <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
 <li><a href="{{ url('sales') }}">Sales</a></li>
   <li><a href="{{ url('sales/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('sales/terms-and-conditions') }}">Terms & Conditions List</a></li>
  <li><a href>Edit Terms & Conditions</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
 <li><a href="{{ url('sales') }}">Sales</a></li>
    <li><a href="{{ url('sales/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('sales/terms-and-conditions') }}">Terms & Conditions List</a></li>
  <li><a href>Add Terms & Conditions</a></li>
</ul>
@endif


           <div class="col-xl-12 ">
@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    @if($init==1)
          <form method="post" action="{{ url('sales/terms-and-conditions/update') }}/{{ $terms_update->id }}">
                 @else
                 <form method="post">
                   @endif     
            @csrf
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
                <div class="row">
                <label class="col-sm-3 form-control-label " style="color:black;">Terms & Conditions: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                <textarea  id="terms_and_conditions" class="form-control" placeholder="Enter Text" rows="20" type="text" name="terms_and_conditions">@if($init==0){{old('terms_and_conditions')}}@else{{old('terms_and_conditions',$terms_update->terms_and_conditions)}}@endif</textarea>
                  </div>
                </div>

          
 
               
  @if($init==1)
               <div class="row mg-t-10">
               <label class="col-sm-3 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('sales/terms-and-conditions') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>
   @else  
<div class="row mg-t-10">
               <label class="col-sm-3 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">
                 
                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Add More">

                  &nbsp&nbsp
                  <a href="{{ url('sales/terms-and-conditions') }}" class="btn btn-secondary">Cancel</a>
                 
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
 
@endpush