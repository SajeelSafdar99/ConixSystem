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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Cash Receipts</h6>
          <div style="text-align: right;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($receiptstatus==0)
  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
   <li><a href="{{ url('room-management/room-payment-receipts') }}">Cash Receipts List</a></li>
   <li><a href>Deleted Cash Receipts</a></li>
</ul>   
@elseif($receiptstatus==2)
  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
   <li><a href="{{ url('events-management/payment-receipts') }}">Cash Receipts List</a></li>
   <li><a href>Deleted Cash Receipts</a></li>
</ul>   
@else
 <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-payments-submodules') }}">Payments</a></li>
   <li><a href="{{ url('finance-and-management/payment-receipts') }}">Cash Receipts List</a></li>
   <li><a href>Deleted Cash Receipts</a></li>
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

            <table class="table display nowrap datatable">

              <thead>
                <tr>
                 <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">Receipt #</th>
                  <th class="wd-10p">Receipt Date</th>
                  <th class="wd-5p">Type</th>
                  <th class="wd-15p">Name</th>
                  <th class="wd-5p">M/G No.</th>
                  <th class="wd-15p">Address</th>
                  <th class="wd-15p">Contact</th>
                  <th class="wd-10p">Receivable</th>
                  <th class="wd-15p">Detail</th>
                  <th class="wd-15p">Amount</th>

                  @can('Restore Payment Receipt')
                  <th class="wd-15p">Restore</th>
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
          'url': '{{ route('payment_deleted.datatable') }}',
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
             { data: 'DT_RowIndex', name: 'DT_RowIndex',width: '0.5%' },
            {width: '0.8%',data: 'invoice_no', name: 'invoice_no', searchable: true},
            {width: '1%',data: 'invoice_date', name: 'invoice_date', searchable: true},
            {width: '1%',data: 'type', name: 'type', searchable: true},
            {width: '2%',data: 'guest_name', name: 'guest_name', searchable: true},
            {width: '0.7%',data: 'customer_id', name: 'customer_id', searchable: true},
            {width: '3%',data: 'guest_address', name: 'guest_address', searchable: true},
            {width: '1%',data: 'guest_contact', name: 'guest_contact', searchable: true},
            {width: '1.1%',data: 'payment_received_for', name: 'payment_received_for', searchable: false},
                {width: '3%',data: 'payment_details', name: 'payment_details', searchable: false},
            {width: '1%',data: 'total', name: 'total', searchable: false},
            
             @can('Restore Payment Receipt')
             @if($receiptstatus==0)
            {width: '0.5%', data: 'restorebutton', name: 'restorebutton', searchable: false},
            @elseif($receiptstatus==2)
            {width: '0.5%', data: 'restoreeventbutton', name: 'restoreeventbutton', searchable: false},
            @else
            {width: '0.5%', data: 'restorefinancebutton', name: 'restorefinancebutton', searchable: false},
            @endif
             @endcan    
        ]
    });

</script>
@endpush