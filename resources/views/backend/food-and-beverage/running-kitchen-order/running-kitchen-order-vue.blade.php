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

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Running Kitchen Orders</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
            <!--     <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button> -->
                <a href="{{ url('food-and-beverage/reports/running-kitchen-order') }}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>
 
 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
    <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
    <li><a href="{{ url('finance-and-management/food-and-beverage/reports') }}">Food & Beverage Reports</a></li>
    <li><a href="{{ url('finance-and-management/food-and-beverage/reports/daily-reports') }}">Daily Reports</a></li>
    <li><a href="{{ url('food-and-beverage/reports/running-kitchen-order') }}">Running Kitchen Orders List</a></li>
    </ul>   

@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
            

<div id="app">
   
         <runningorders></runningorders>

</div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')

@endpush