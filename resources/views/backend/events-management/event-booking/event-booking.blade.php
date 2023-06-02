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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Event Booking</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
           @can('Add Event Booking')
          <a href="{{ url('events-management/event-booking/event-booking-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Event Booking" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Event Bookings')
          <a href="{{ url('events-management/event-booking/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
<ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href>Event Booking List</a></li>
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
                  <th class="wd-10p">Venue</th>
                  <th class="wd-10p">Menu</th>
                  <th class="wd-10p">Event Date</th>
                  <th class="wd-10p">Timing (From)</th>
                  <th class="wd-10p">Timing (To)</th>
                   <th class="wd-10p">Grand Total</th>
                  @can('Check Out Event')
                  <th class="wd-10p">Complete</th>
                  @endcan
                   @can('Print Event Invoice')
                  <th class="wd-5p">Invoice</th>
                  @endcan
                   @can('Cancel Event')
                  <th class="wd-5p">Cancel</th>
                  @endcan
                  @can('Edit Event Booking')
                  <th class="wd-5p">Edit</th>
                  @endcan
                  @can('Delete Event Booking')
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
          'url': '{{ route('event_booking.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },

        columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'booking_no', name: 'booking_no', searchable: true},
            {'name': 'booking_date.timestamp', 'data': { '_': 'booking_date.display', 'sort': 'booking_date' }},
            {data: 'type', name: 'type', searchable: false},
            {data: 'moc_name', name: 'moc_name', searchable: true},
            {data: 'customer_id', name: 'customer_id', searchable: true},
            {data: 'venue', name: 'venue', searchable: true},
            {data: 'menu', name: 'menu', searchable: true},
            {data: 'event_date', name: 'event_date', searchable: true},
            {data: 'from', name: 'from', searchable: false},
            {data: 'to', name: 'to', searchable: false},
             {data: 'grand_total', name: 'grand_total', searchable: false},
             @can('Check Out Event')
            {data: 'status', name: 'status', orderable: false},
            @endcan
             @can('Print Event Invoice')
            {data: 'invoice', name: 'invoice', orderable: false},
            @endcan
             @can('Cancel Event')
            {data: 'cancel', name: 'cancel', orderable: false},
            @endcan
            @can('Edit Event Booking')
            {data: 'editbutton', name: 'editbutton', orderable: false},
            @endcan
            @can('Delete Event Booking')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},
            @endcan
        ]
    });

</script>
@endpush
