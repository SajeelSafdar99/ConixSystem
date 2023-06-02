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
.areabox {
            cursor: pointer !important;
        }
</style>
<div class="br-pagebody">
        <div>
          
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Invoices</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <!-- <a target="_blank" href="{{ url('room-management/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> -->
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div> 
 

@if(isset($id))
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/new-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Edit Invoice</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/new-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Add Invoice</a></li>
</ul>

@endif


<div id="app" style="color: black;">
    @if(isset($id))
        <financeinvoices :id="{{$id}}" :linking="'{{url('/')}}'"></financeinvoices>
        @else
        <financeinvoices :linking="'{{url('/')}}'"></financeinvoices>

    @endif
</div>

  

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')

@endpush
