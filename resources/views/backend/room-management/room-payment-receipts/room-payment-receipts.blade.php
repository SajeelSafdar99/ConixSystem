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
         <div style="text-align: right;" class="hidden-print">

           @if($receiptstatus==0)
            @can('Add Payment Receipt')
          <a href="{{ url('room-management/room-payment-receipts/room-payment-receipts-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Cash Receipt" height="28" width="28" border="0/">
          </a>
          @endcan
          @elseif($receiptstatus==2)
           @can('Add Payment Receipt')
          <a href="{{ url('events-management/payment-receipts/payment-receipts-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Cash Receipt" height="28" width="28" border="0/">
          </a>
          @endcan
           @else
           @can('Add Payment Receipt')
           <a href="{{ url('finance-and-management/payment-receipts/payment-receipts-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Cash Receipt" height="28" width="28" border="0/">
          </a>
          @endcan
           @endif

           @if($receiptstatus==0)
           @can('View Deleted Payment Receipts')
          <a href="{{ url('room-management/room-payment-receipts/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          @elseif($receiptstatus==2)
           @can('View Deleted Payment Receipts')
          <a href="{{ url('events-management/payment-receipts/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          @else
          @can('View Deleted Payment Receipts')
          <a href="{{ url('finance-and-management/payment-receipts/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          @endif

          <a  href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($receiptstatus==0)
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href>Cash Receipts List</a></li>
</ul>
@elseif($receiptstatus==2)
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href>Cash Receipts List</a></li>
</ul>
@else
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-payments-submodules') }}">Payments</a></li>
  <li><a href>Cash Receipts List</a></li>
</ul>
@endif

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
            <form method="get">
                <div class="row">

                    <div class="col-lg">
                        <div>
                           <div class="row">
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                            <p style="color: black;">Name:</p></div>
 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input type="radio"  name="mog" value="0"><span class="pabs">Member</span>
                                </label>
                            </div>
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input type="radio" name="mog" value="1"><span class="pabs">Guest</span>
                                </label>
                            </div>
                          </div>
                            <input @if($errors->has('customer')) style="border-color:red;"
                                   @endif id="customer_search" class="form-control typeahead tablikebutton"
                                   placeholder="Search by Name" type="text" value="" name="customer"
                                   onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" autocomplete="off">
<input type="hidden" name="mog_id" value="">
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                        </div>
                    </div>

                    <div class="col-lg">
                        <div>
                            <p style="color: black;">Begin Date:</p>
                            <input value="" class=" form-control tablikebutton" placeholder="dd/mm/yyyy" type="text" autocomplete="off"
                                   id="start_date"
                                   name="start_date">
                        </div>
                    </div>
                    <div class="col-lg">
                        <div>
                            <p style="color: black;">End Date:</p>
                            <input value="" class=" form-control tablikebutton" placeholder="dd/mm/yyyy" type="text" autocomplete="off"
                                   id="end_date" name="end_date">
                        </div>
                    </div>


                    <div class="col-lg">
                        <div>
                            <p style="color: black;">Receipt No.</p>
                            <input value="" class="form-control tablikebutton" autocomplete="off" size="20" type="number"
                                   id="receipt_search"
                                   name="receipt" placeholder="Search Id...">
                        </div>
                    </div>

                    <div class="col-lg">
                        <button style="    margin-top: 32px;" type="button" onclick="search()" class="btn btn-info"><i
                                    class="fa fa-search"></i>Search
                            </button>

                        <button onclick="window.print();" title="print" style="    margin-top: 32px;"
                                class="btn btn-danger"><i
                                class="fa fa-print"></i>
                        </button>
                    </div>
                </div>


                <br><br>
                </form>

          <div class="table-wrapper">
              <h5 class=" text-info visible-print"><span class="type"></span> <span class="name123"></span> <span class="start_date"></span> <span class="end_date"></span> <span class="booking_no"></span> </h5>

              <table  class="table display nowrap datatable">

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
                   @can('Print Payment Receipt')
                  <th class="wd-15p hidden-print">Invoice</th>
                  @endcan
                   @can('Edit Payment Receipt')
                  <th class="wd-15p hidden-print">Edit</th>
                  @endcan
                   @can('Delete Payment Receipt')
                  <th class="wd-15p hidden-print">Delete</th>
                  @endcan

                </tr>
              </thead>
                <tfoot>
                <tr>
                    <td colspan="1">Total:</td>
                    <td colspan="2"><span class="countx"></span> </td>
                    <td colspan="6"></td>
                    <td colspan="1"><span class="amountx"></span> </td>
                    @can('Print Payment Receipt')
                   <td></td>
                   @endcan
                    @can('Edit Payment Receipt')
                        <td ></td>
                    @endcan
                    @can('Delete Payment Receipt')
                        <td></td>
                    @endcan
                </tr>
                </tfoot>
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
  $(".datatable").on('xhr', function(e, settings, json, xhr){
      // TODO: Insert your code
      // console.log(json);return;
      if(json.data.length>0){
          $('.totalC').html('Total Receipts: '+json.data[0].ctotal+ ' <br>Total Amount: '+json.data[0].dtotal)
      }
  });
        var oTable =   $('.datatable').DataTable({
            "pageLength": 100,
            "fnDrawCallback": function(c,b,a){
                console.log(c.aoData.length);
                if(c.aoData.length>0){
                    // $('.totalC').html('Total Receipts: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal);
                    console.log(c);
                    console.log(b);
                    console.log(a);
                    $('.countx').html(c.json.cTotal);
                    $('.amountx').html(c.json.dTotal);
                    $('.type').html($('input[name="mog"] :checked').val()==0?'Selected Member:':'Selected Guest:');
                    $('.name123').html($('input[name="customer"]').val());
                    $('.start_date').html($('input[name="start_date"]').val()!=''?' From: '+$('input[name="start_date"]').val():'');
                    $('.end_date').html($('input[name="end_date"]').val()!=''?' to: '+$('input[name="end_date"]').val():'');
                    $('.booking_no').html($('input[name="receipt"]').val()!=''?' where Receipt #: '+$('input[name="receipt"]').val():'');
                }
                else{
                    $('.totalC').html('')

                }



            },
                searching: false,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
           // "autoWidth": false,
          order: [[ 1, 'des' ]],
          "ajax": {
          'url': '{{ route('payment.datatable') }}',
          'type': 'POST',
              data:{
                'start_date':function(){ return $('input[name="start_date"]').val()},
                'end_date':function(){ return $('input[name="end_date"]').val()},
                'customer':function(){ return $('input[name="mog_id"]').val()},
                'receipt':function(){ return $('input[name="receipt"]').val()},
                'mog':function(){ return $('input[name="mog"]:checked').val()}
              },
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

             @can('Print Payment Receipt')
             @if($receiptstatus==0)
            {width: '0.7%',data: 'status', name: 'status', orderable:false},
            @elseif($receiptstatus==2)
            {width: '0.7%',data: 'status_events', name: 'status_events', orderable:false},
            @else
            {width: '0.7%',data: 'status_finance', name: 'status_finance', orderable:false},
            @endif
             @endcan

             @can('Edit Payment Receipt')
             @if($receiptstatus==0)
            {width: '0.5%',data: 'editbutton', name: 'editbutton', orderable:false},
            @elseif($receiptstatus==2)
            {width: '0.5%',data: 'editeventbutton', name: 'editeventbutton', orderable:false},
            @else
            {width: '0.5%',data: 'editfinancebutton', name: 'editfinancebutton', orderable:false},
            @endif
             @endcan


            @can('Delete Payment Receipt')
             @if($receiptstatus==0)
            {width: '0.7%',data: 'deletebutton', name: 'deletebutton', orderable:false},
            @elseif($receiptstatus==2)
            {width: '0.7%',data: 'deleteeventbutton', name: 'deleteeventbutton', orderable:false},
            @else
            {width: '0.7%',data: 'deletefinancebutton', name: 'deletefinancebutton', orderable:false},
            @endif
             @endcan
        ]
    });
  function search() {
      oTable.ajax.reload();
  }

  function customerdata(val) {
      let v=$('input[name="mog"]:checked').val();
      if(val==''){
          $('input[name="mog_id"]').val('');
      }
      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdatalike') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "customerid": val,
              'MOC':v
          },
          success: function (data) {

              jQuery('#areabox').html('');
              jQuery.each(JSON.parse(data), function (i, val1) {
                  let name = v == 1 ? val1.customer_name : val1.applicant_name;
                  let code = v == 1 ? val1.customer_no : val1.mem_no;
                  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);


              });
$('#areabox').show();
              // $('#areabox').html(data);

          }
      });
  }
  function customerdatavalue(val) {
      let v=$('input[name="mog"]:checked').val();

      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdata') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "customerid": val,
              'MOC':v
          },
          success: function (data) {

              console.log(data);
              var obj = JSON.parse(data);

              if(v==1){
                  document.getElementById('customer_search').value = obj.customer_name;
                  $('input[name="mog_id"]').val( obj.id);
              }

              else{
                  document.getElementById('customer_search').value = obj.applicant_name;
                  $('input[name="mog_id"]').val( obj.id);

              }
              jQuery('#areabox').html('');

          }


      });
  }
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

  <script>
    $( function() {
    $( "#start_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#end_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
  </script>
@endpush
