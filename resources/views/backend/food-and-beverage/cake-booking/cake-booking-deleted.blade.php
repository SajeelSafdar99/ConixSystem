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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Cake Booking</h6>
             <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
  <ul class="breadcrumbee border-bottom-custom">
<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
 <li><a href="{{ url('food-and-beverage/cake-booking-vue') }}">Cake Bookings List</a></li> 
<li><a href>Deleted Cake Bookings</a></li>
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
                  <th class="wd-10p">Booking #</th>
                   <th class="wd-10p">Booking Date</th>
                  <th class="wd-10p">Customer Type</th>
                  <th class="wd-15p">Customer #</th>
                  <th class="wd-20p">Name</th>
                  <th class="wd-10p">Gross</th>
                  <th class="wd-10p">Discount</th>
                  <th class="wd-10p">Tax</th>
                  <th class="wd-10p">Grand Total</th>

               <th class="wd-10p">Deleted At</th>
              <th class="wd-15p">Remarks</th>
                 
                  @can('Restore Cake Bookings')
                  <th class="wd-5p">Restore</th>
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
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'asc' ]],
          "ajax": {
          'url': '{{ route('cake_booking_deleted.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'booking_no', name: 'booking_no', searchable: true},
            {data: 'booking_date', name: 'booking_date', searchable: true},
            {data: 'type', name: 'type', searchable: true},
            {data: 'customer_id', name: 'customer_id', searchable: true},
            {data: 'name', name: 'name', searchable: true},
            {data: 'total_amount', name: 'total_amount', searchable: false},
            {data: 'discount', name: 'discount', searchable: false},
            {data: 'tax', name: 'tax', searchable: false},
            {data: 'grand_total', name: 'grand_total', searchable: false},

                 { data: 'deleted_at', name: 'deleted_at', searchable: true},
               { data: 'note', name: 'note', searchable: false},
            @can('Restore Cake Bookings')
            {data: 'restorebutton', name: 'restorebutton', orderable: false},  
            @endcan        
        ]
    });

</script>
@endpush