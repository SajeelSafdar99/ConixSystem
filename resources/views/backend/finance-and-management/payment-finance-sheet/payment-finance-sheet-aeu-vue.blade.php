@extends('backend.layout.app')
@section('page-content')

<head>

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

    .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }

.areabox{cursor:pointer !important;}
.areabox_two{cursor:pointer !important;}

div.groove {border-style: groove !important; height: 200px !important;}
div.saveoptions { height: 390px !important; }

.padtheicon{
  padding-top: 15px;
  cursor: pointer;
}

.pc{
  display:inline-block;
  position: relative;
  }
.pc input{
  padding-left:15px;
  }
.pc:before {
  position: absolute;
    content:"%";
    left:17px;
  top:6px;
  }


.has-search .form-control {
    padding-left: 2.375rem !important;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 1rem;
    height: 1rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
    margin-left: 6px;
    margin-top: 4px;
}
</style>

  </head>
<div class="br-pagebody">
        <!-- <div class="br-section-wrapper"> -->
          <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Expenses</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

   @if(isset($id))
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li> 
  <li><a href="{{ url('finance-and-management/finance-expenses-vue') }}">Expense List</a></li>
  <li><a href>Edit Expense</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li> 
  <li><a href="{{ url('finance-and-management/finance-expenses-vue') }}">Expense List</a></li>
  <li><a href>Add Expense</a></li>
</ul>

@endif

 

<div id="app" style="color: black;">
    @if(isset($id))
        <paymentsheet :id="{{$id}}" :linking="'{{url('/')}}'"></paymentsheet>
        @else
        <paymentsheet :linking="'{{url('/')}}'"></paymentsheet>

    @endif
</div>
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->


@endsection



@push('jscode')


@endpush
