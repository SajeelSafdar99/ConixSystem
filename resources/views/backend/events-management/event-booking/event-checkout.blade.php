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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Event Completion</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
<ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href>Completed Events List</a></li>
</ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


             <form method="get" >
                <div class="row">

                    <div class="col-lg">
                        <div>
                             <div class="row">
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
 <p style="color: black;">Name:</p>
</div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input  type="radio"  name="mog" value="0"><span class="pabs">Member</span>
                                </label>
                            </div>
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
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
                            <input value="" class=" form-control tablikebutton" type="text" autocomplete="off"
                                   id="start_date"
                                   name="start_date">
                        </div>
                    </div>
                    <div class="col-lg">
                        <div>
                            <p style="color: black;">End Date:</p>
                            <input value="" class="form-control tablikebutton" type="text" autocomplete="off"
                                   id="end_date" name="end_date">
                        </div>
                    </div>

                        <div class="col-lg">
                        <div>
                            <p style="color: black;">Booking No.</p>
                            <input value="" class=" form-control tablikebutton" size="20" type="number"
                                   id="receipt_search"
                                   name="booking" placeholder="Search Id...">
                        </div>
                    </div>

                    <div class="col-lg">
                        <div>
                            <p style="color: black;">Status</p>
                            <select class="form-control" name="status" id="status">

                               <option value="0">All</option>
                                        <option  value="1">
                                           Paid
                                        </option>
                                         <option  value="2">
                                           UnPaid
                                        </option>
            </select>
                        </div>
                    </div>

  <div class="col-lg">
                        <button  type="button" style="    margin-top: 32px;" onclick="search()" class="btn btn-info"><i
                                class="fa fa-search"></i>Search
                        </button>

                        <button type="button" onclick="window.print();" title="print" style="    margin-top: 32px;"
                                class="btn btn-danger"><i
                                class="fa fa-print"></i>
                        </button>

                    </div>

                </div>


                <br><br>
</form>

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
                  <th class="wd-10p">Event Date</th>
                  <th class="wd-10p">Venue</th>
                  <th class="wd-10p">Menu</th>
                  <th class="wd-10p">Event Date</th>
                  <th class="wd-10p">Timing (From)</th>
                  <th class="wd-10p">Timing (To)</th>
                   <th class="wd-10p">Grand Total</th>
                   <th class="wd-10p">Amount Paid</th>
                   <th class="wd-10p">Balance</th>
                    <th class="wd-15p">Details</th>
                   <th class="wd-10p">Status</th>
                    <th class="wd-10p">Mark</th>
                  @can('Print Event Invoice')
                  <th class="wd-5p">Invoice</th>
                  @endcan
                  @can('Edit Event Check Out')
                  <th class="wd-5p">Edit</th>
                  @endcan
                </tr>
              </thead>
               <tfoot>
                <tr>
                    <td colspan="12">Total :</td>
                    <td class="GrandTotal"></td>
                    <td class="AmountPaid"></td>
                    <td class="Balance"></td>
                     <td></td>
                     <td></td>
                    <td></td>
                     @can('Print Event Invoice')
                    <td></td>
                    @endcan
                    @can('Edit Event Check Out')
                    <td ></td>
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
<style>
    .remove{
        display:none;
    }
</style>

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
          seaching: false,
            "fnDrawCallback": function(c,b,a){
                console.log(c.aoData.length);
                if(c.aoData.length>0){
                      $('.GrandTotal').html(c.aoData[0]._aData.dtotal.GrandTotal);
                      $('.AmountPaid').html(c.aoData[0]._aData.dtotal.AmountPaid);
                      $('.Balance').html(c.aoData[0]._aData.dtotal.Balance);
                    $('.type').html($('input[name="mog"] :checked').val()==0?'Selected Member:':'Selected Guest:');
                    $('.name123').html($('input[name="customer"]').val());
                    $('.start_date').html($('input[name="start_date"]').val()!=''?' From: '+$('input[name="start_date"]').val():'');
                    $('.end_date').html($('input[name="end_date"]').val()!=''?' to: '+$('input[name="end_date"]').val():'');
                    $('.booking_no').html($('input[name="booking"]').val()!=''?' where Booking #: '+$('input[name="booking"]').val():'');

                    // $('.totalC').html('Total Bookings: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal)
                }
                else{
                    $('.totalC').html('')

                }



            },
            "pageLength": 50,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'desc' ]],
          "ajax": {
          'url': '{{ route('event_checkout.datatable') }}',
          'type': 'POST',
           data:{
                  'start_date':function(){ return $('input[name="start_date"]').val()},
                  'end_date':function(){ return $('input[name="end_date"]').val()},
                  'customer':function(){ return $('input[name="mog_id"]').val()},
                  'receipt':function(){ return $('input[name="booking"]').val()},
                  'mog':function(){ return $('input[name="mog"]:checked').val()},
                  'status':function(){ return $('#status').val()},
              },
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
            "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": ""
            } ],
        columns: [
          
              { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'booking_no', name: 'booking_no', searchable: true},
            {'name': 'booking_date.timestamp', 'data': { '_': 'booking_date.display', 'sort': 'booking_date' }},
            {data: 'type', name: 'type', searchable: true},
            {data: 'moc_name', name: 'moc_name', searchable: true},
            {data: 'customer_id', name: 'customer_id', searchable: true},
            {data: 'event_date', name: 'event_date', searchable: true},
            {data: 'venue', name: 'venue', searchable: true},
            {data: 'menu', name: 'menu', searchable: true},
            {data: 'event_date', name: 'event_date', searchable: true},
            {data: 'from', name: 'from', searchable: false},
            {data: 'to', name: 'to', searchable: false},
             {data: 'grand_total', name: 'grand_total', searchable: false},
             {data: 'amountpaid', name: 'amountpaid', searchable: false},
             {data: 'finalbalance', name: 'finalbalance', searchable: false},
             {data: 'details_d', name: 'details_d', searchable: true},
             {data: 'balancestatus', name: 'balancestatus', orderable: false},
              {data: 'paid', name: 'paid', orderable: false},

             @can('Print Event Invoice')
            {data: 'status', name: 'status', orderable: false},
            @endcan
            @can('Edit Event Check Out')
            {data: 'editbutton', name: 'editbutton', orderable: false},
            @endcan
        ],
              /*      rowCallback: function( row, data, index ) {
              if($('#status').val()=='1'){
                  if(data.finalbalance!=0){
                      console.log(data);
                      $(row).addClass('remove');
                  }
                  else{
                      $(row).removeClass('remove');

                  }
              }
              else if($('#status').val()=='2'){
                  if(data.finalbalance==0){
                      console.log(data);

                      $(row).addClass('remove');
                  }
                  else{
                      $(row).removeClass('remove');

                  }
              }
              else{

              }
            } */
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

                 $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                  let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                  let code = v == 1 ? val1.customer_no : val1.mem_no;
                  let status = v == 1 ? '' : '('+val1.mem_status.desc+')';
                  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code} ${status}<li>`);


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
                 
                  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                  document.getElementById('customer_search').value = $fname+$mname+$lname;
                  $('input[name="mog_id"]').val( obj.id);

              }
              jQuery('#areabox').html('');

          }


      });
  }
</script>


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

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
