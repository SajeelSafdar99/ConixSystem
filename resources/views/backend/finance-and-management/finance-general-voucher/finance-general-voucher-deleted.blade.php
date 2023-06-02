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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">General Vouchers</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
 <li><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a></li>
  <li><a href="{{ url('finance-and-management/finance-voucher') }}">General Vouchers List</a></li>
   <li><a href>Deleted General Vouchers</a></li>
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
                  <th class="wd-5p">Voucher #</th>
                  <th class="wd-10p">Voucher Date</th>
                  <th class="wd-10p">Voucher Type</th>
                  <th class="wd-10p">Name</th>
                  <th class="wd-10p">Type</th>
                  <th class="wd-5p">No.</th>
                  <th class="wd-15p">Contact</th>
                   <th class="wd-10p">Unit</th>
                  <th class="wd-10p">Debit</th>
                  <th class="wd-10p">Credit</th>

           <th class="wd-10p">Deleted At</th>
              <th class="wd-15p">Remarks</th>
              
                  @can('Restore General Voucher')
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
          "pageLength": 50,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'asc' ]],
          "ajax": {
          'url': '{{ route('general_voucher_deleted.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
        
             { data: 'DT_RowIndex', name: 'DT_RowIndex',width: '0.5%' },
            {width: '0.8%',data: 'invoice_no', name: 'invoice_no', searchable: true},
            {width: '1%',data: 'invoice_date', name: 'invoice_date', searchable: true},
           {width: '1%',data: 'voucher_type', name: 'voucher_type', searchable: true},
            {width: '1%',data: 'name', name: 'name', searchable: true},
            {width: '1%',data: 'invoice_type', name: 'invoice_type', searchable: true},
            {width: '0.7%',data: 'number', name: 'number', searchable: true},
            {width: '1%',data: 'contact', name: 'contact', searchable: true},
            {width: '1%',data: 'unit', name: 'unit', searchable: false},
            {width: '1%',data: 'debit_amount', name: 'debit_amount', searchable: false},
            {width: '1%',data: 'credit_amount', name: 'credit_amount', searchable: false},
            
              {width: '1%', data: 'deleted_at', name: 'deleted_at', searchable: true},
               { width: '2%',data: 'remarks', name: 'remarks', searchable: false},

            @can('Restore General Voucher')
            {width: '0.5%',data: 'restorebutton', name: 'restorebutton', orderable:false},
            @endcan        
        ]
    });

</script>
@endpush