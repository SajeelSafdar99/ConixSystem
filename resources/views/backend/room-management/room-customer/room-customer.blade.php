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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Guest</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">

          @can('Export Customer Columns')
             <button type="button" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="fa fa-file"></i> Export</button>
          @endcan

          @if($eventstatus==0)
            @can('Add Customer')
          <a href="{{ url('room-management/room-customer/room-customer-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Guest" height="28" width="28" border="0/">
          </a>
          @endcan
           @else
           @can('Add Event Customer')
           <a href="{{ url('events-management/event-customer/event-customer-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Guest" height="28" width="28" border="0/">
          </a>
          @endcan
           @endif


           @if($eventstatus==0)
           @can('View Deleted Customers')
          <a href="{{ url('room-management/room-customer/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
           @else
           @can('View Deleted Event Customers')
           <a href="{{ url('events-management/event-customer/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
           @endif
          
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($eventstatus==0)
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/definitions') }}">Definitions</a></li>
  <li><a href>Guest List</a></li>
</ul>
@else
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/definitions') }}">Definitions</a></li>
  <li><a href>Guest List</a></li>
</ul>
@endif

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    
      
          <div class="table-wrapper">
<div id="modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" action="{{route('customer.export')}}">
                            {{csrf_field()}}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">SELECT COLUMNS TO EXPORT</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @foreach($columns as $col)
                                        <div class="col-sm-3"><label><input type="checkbox" name="columns[]" value="{{$col}}"> {{ucwords(str_replace('_',' ',$col))}}</label></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default""><i class="fa fa-download"></i> Export</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <table  class="table display nowrap datatable">

              <thead>
                <tr>
                 
                  <th class="wd-5p">Sr #</th>
                  <th class="wd-10p">ID</th>
                  <th class="wd-15p">Name</th>
                  <th class="wd-10p">Guest Type</th>
                  <th class="wd-25p">Address</th>
                  <th class="wd-10p">CNIC</th>
                  <th class="wd-10p">Contact</th>
                  <th class="wd-15p">Email</th>
                  <th class="wd-15p">Partner / Affiliate</th>

                  @if($eventstatus==0)
                  @can('Edit Customer')
                  <th class="wd-5p">Edit</th>
                  @endcan
                  @else
                  @can('Edit Event Customer')
                  <th class="wd-5p">Edit</th>
                  @endcan
                  @endif

                  @if($eventstatus==0)
                  @can('Delete Customer')
                  <th class="wd-5p">Delete</th>
                  @endcan
                  @else
                  @can('Delete Event Customer')
                  <th class="wd-5p">Delete</th>
                  @endcan
                  @endif
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
          order: [[ 1, 'desc' ]],
          "ajax": {
          'url': '{{ route('customer.datatable') }}',
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
            {data: 'customer_no', name: 'customer_no', searchable: true},
            {data: 'customer_name', name: 'customer_name', searchable: true},
            {data: 'guest_type', name: 'guest_type', searchable: true},
            {data: 'customer_address', name: 'customer_address', searchable: true},
            {data: 'customer_cnic', name: 'customer_cnic', searchable: true},
            {data: 'customer_contact', name: 'customer_contact', searchable: true},
            {data: 'customer_email', name: 'customer_email', searchable: true},
             {data: 'affiliate', name: 'affiliate', searchable: true},

            
            @if($eventstatus==0)
             @can('Edit Customer')
            {data: 'editbutton', name: 'editbutton', orderable:false},
            @endcan
            @else
             @can('Edit Event Customer')
            {data: 'editeventsbutton', name: 'editeventsbutton', orderable:false},
            @endcan
            @endif
            

            @if($eventstatus==0)
             @can('Delete Customer')
            {data: 'deletebutton', name: 'deletebutton', orderable:false},
            @endcan
            @else
             @can('Delete Event Customer')
            {data: 'deleteeventsbutton', name: 'deleteeventsbutton', orderable:false},
            @endcan
            @endif         
        ]
    });

</script>
@endpush