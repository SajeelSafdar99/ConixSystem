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
    #DataTables_Table_0_filter{
        display: none!important;
    }



.select2-selection {
  height: 34px !important; 
  font-size: 13px;
  font-family: 'Open Sans', sans-serif;
  border-radius: 0 !important;
  border: solid 1px #c4c4c4 !important;
  padding-left: 4px;
}

.select2-selection--multiple {
  height: 53px !important;

}

.select2-selection__choice {
  height: 40px;
  line-height: 40px !important;
  padding-right: 16px !important;
  padding-left: 16px !important;
  background-color: #CAF1FF !important;
  color: #333 !important;
  border: none !important;
  border-radius: 3px !important;
}


.select2-container--default .select2-selection--multiple .select2-selection__choice__remove 
 {
  float: right !important;
 
  font-size: 20px !important;
  color: black !important;
  position: relative !important;
  top: 0px !important;
}
.select2-search--inline .select2-search__field {
  line-height: 40px;
  color: #333;
  width: 100%!important;
}

.select2-container:hover,
.select2-container:focus,
.select2-container:active,
.select2-selection:hover,
.select2-selection:focus,
.select2-selection:active {
  outline-color: transparent;
  outline-style: none;
}

.select2-results__options li {
  display: block; 
}

.select2-selection__rendered {
  transform: translateY(2px);
}

.select2-selection__arrow {
  display: none;
}

.select2-results__option--highlighted {
  background-color: #CAF1FF !important;
  color: #333 !important;
}

.select2-dropdown {
  border-radius: 0 !important;
  box-shadow: 0px 3px 6px 0 rgba(0,0,0,0.15) !important;
  border: none !important;
  margin-top: 4px !important;
  width: 366px !important;
}

.select2-results__option {
  font-family: 'Open Sans', sans-serif;
  font-size: 13px;
  line-height: 24px !important;
  vertical-align: middle !important;
  padding-left: 8px !important;
}

.select2-results__option[aria-selected="true"] {
  background-color: #eee !important; 
}

.select2-search__field {
  font-family: 'Open Sans', sans-serif;
  color: #333;
  font-size: 13px;
  padding-left: 8px !important;
  border-color: #c4c4c4 !important;
}

.select2-selection__placeholder {
  color: #c4c4c4 !important; 
}

.border-bottom-custom {
  margin-top: -11px;
}

</style>

<div class="br-pagebody">
        <div> 
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Corporate Membership</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
   <!--   <a href="{{ url('club-hospitality/membership') }}">
<button type="button" title="Old Membership" class="btn btn-warning btn-sm hidden-print">OLD MEMBERSHIP</button>
</a> -->
 @can('Export Corporate Membership Columns')
                            <button type="button" data-toggle="modal" data-target="#modal" class=" btn btn-primary"><i class="fa fa-file"></i> Export</button>
                            @endcan
<button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
             @can('Add Corporate Membership')
          <a href="{{ url('club-hospitality/corporate-membership/corporate-membership-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Membership" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Corporate Memberships')
          <a href="{{ url('club-hospitality/corporate-membership/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href="{{url()->current()}}">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{url()->current()}}">Corporate Memberships List</a></li>
</ul>
 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

  <div id="modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" action="{{route('comember.export')}}">
                            {{csrf_field()}}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">SELECT COLUMNS TO EXPORT</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   @php sort($columns) @endphp
                                    @foreach($columns as $col)
                                        <div class="col-sm-3"><label><input type="checkbox" name="columns[]" value="{{$col}}"> {{ucwords(str_replace('_',' ',$col))}}</label></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default"><i class="fa fa-download"></i> Export</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
<div id="app">
         <corporatemembershipdt></corporatemembershipdt>
</div>
         
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')


<script type="text/javascript">
$('#cnic').mask('00000-0000000-0');
$('#contact').mask('00000000000');
</script>
@endpush
