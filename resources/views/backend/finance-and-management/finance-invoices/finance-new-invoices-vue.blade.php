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
       
<button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>

                                        @if($iam==1)
                                                @can('Add Finance Invoices')
                                       
          <a href="{{ url('finance-and-management/finance-invoices/invoices-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title=edit("Add New Invoice" height="28" width="28" border="0/">
          </a>
         @endcan
                                            @else
                                              @can('Add Finance Invoices')
                                       
          <a href="{{ url('finance-and-management/finance-invoices/finance-new-invoices-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Invoice" height="28" width="28" border="0/">
          </a>
         @endcan
                                         
                                           @endif
                                        
          @can('View Deleted Finance Invoices')
          <a href="{{ url('finance-and-management/finance-invoices/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


  <ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href>Invoices List</a></li>
</ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif




<div id="app">

   @if($iam==1)
   
         <newinvoicesdt :csrf="'{{csrf_token()}}'" :iam="{{$iam}}"></newinvoicesdt>
           @else

             <newinvoicesdt :csrf="'{{csrf_token()}}'"></newinvoicesdt>

            @endif

</div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')

@endpush
