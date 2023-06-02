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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Booking</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
           @can('Add Room Booking')
          <a href="{{ url('room-management/room-booking/room-booking-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Room Booking" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Room Bookings')
          <a href="{{ url('room-management/room-booking/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
<ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href>Room Booking List</a></li>
</ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


          <div class="table-wrapper">
            <table  class="table display nowrap datatable">

              <thead>
                <tr>

                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">Booking #</th>
                  <th class="wd-10p">Booking Date</th>
                  <th class="wd-10p">Type</th>
                  <th class="wd-10p">M/G Name</th>
                  <th class="wd-10p">M/G #</th>
                  <th class="wd-10p">Guest Name</th>
                  <th class="wd-10p">Arrival Date</th>
                  <th class="wd-10p">Departure Date</th>
                  <th class="wd-10p">Room</th>

                  <th class="wd-10p">Grand Total</th>
                   <th class="wd-10p">Amount Paid</th>
                  <th class="wd-10p">Balance</th>
                    <th class="wd-15p">Details</th>

                  <th class="wd-10p">Mark</th>
                  <th class="wd-10p">Check-In</th>
                  @can('Print Booking Details')
                  <th class="wd-10p">Invoice</th>
                  @endcan
                  @can('Edit Room Booking')
                  <th class="wd-10p">Edit</th>
                  @endcan
                  @can('Delete Room Booking')
                  <th class="wd-10p">Delete</th>
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
          'url': '{{ route('roombooking.datatable') }}',
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
            {data: 'booking_no', name: 'booking_no', searchable: true},
            {'name': 'booking_date.timestamp', 'data': { '_': 'booking_date.display', 'sort': 'booking_date' }},
            {data: 'type', name: 'type', searchable: true},
            // {
            //     data: 'booking_date',
            //     type: 'num',
            //     render: {
            //         _: 'display',
            //         sort: 'timestamp'
            //     }
            // },
            {data: 'moc_name', name: 'moc_name', searchable: true},
            {data: 'customer_id', name: 'customer_id', searchable: true},
            {data: 'name', name: 'name', searchable: true},
            {data: 'check_in_date', name: 'check_in_date', searchable: true},
            {data: 'check_out_date', name: 'check_out_date', searchable: true},
            {data: 'room', name: 'room', searchable: true},
            {data: 'grand_total', name: 'grand_total', searchable: true},
            {data: 'amountpaid', name: 'amountpaid', searchable: true},
            {data: 'finalbalance', name: 'finalbalance', searchable: true},
            {data: 'details_d', name: 'details_d', searchable: false},
            {data: 'paid', name: 'paid'},
            {data: 'status', name: 'status'},
             @can('Print Booking Details')
            {data: 'invoice', name: 'invoice'},
            @endcan
            @can('Edit Room Booking')
            {data: 'editbutton', name: 'editbutton'},
            @endcan
            @can('Delete Room Booking')
            {data: 'deletebutton', name: 'deletebutton'},
            @endcan
        ]
    });

</script>
@endpush
