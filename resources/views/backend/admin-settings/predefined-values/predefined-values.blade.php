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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Predefined Values</h6>
          <div style="text-align: right; margin-top: -39px;">

            @if($records<1)
          @can('Add Predefined Values')
          <a href="{{ url('admin-settings/predefined-values/predefined-values-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Currency Definition" height="28" width="28" border="0/">
          </a>
          @endcan
          @endif


          @can('View Deleted Predefined Values')
          <a href="{{ url('admin-settings/predefined-values/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href>Predefined Values List</a></li>
</ul>            

@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
         
          <div class="table-wrapper">
            <table class="table display nowrap datatable">
              <thead>
                <tr>
                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-10p">Discount Amt</th>
                  <th class="wd-10p">Discount Pct</th>
                  <th class="wd-5p">Currency</th>
                  <th class="wd-10p">Store Location</th>
                  <th class="wd-10p">Store Department</th>
                  @can('Edit Predefined Values')
                  <th class="wd-5p">Edit</th>
                  @endcan
                   @can('Delete Predefined Values')
                  <th class="wd-5p">Delete</th>
                  @endcan
                </tr>
              </thead>
             
            </table>
          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')
<script type="text/javascript">
  $( document ).ready(function() {
    console.log( "ready!" );
});
  
</script>


<script type="text/javascript">
  var oTable = '';
// $(document).ready(function() {
  
        var oTable =   $('.datatable').DataTable({
          seaching: true,
          "pageLength": 50,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'asc' ]],
          "ajax": {
          'url': '{{ route('predefined_vals.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'discount_amount', name: 'discount_amount', searchable: true},
            {data: 'discount_percentage', name: 'discount_percentage', searchable: true},
            {data: 'currency', name: 'currency', searchable: true},
            {data: 'store_location', name: 'store_location', searchable: true},
            {data: 'department', name: 'department', searchable: true},
             @can('Edit Predefined Values')
            {data: 'editbutton', name: 'editbutton', orderable: false}, 
             @endcan 
            @can('Delete Predefined Values')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},  
             @endcan           
        ]
    });

</script>
@endpush