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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Invoices</h6>
         <div style="text-align: right;" class="hidden-print">

           @can('Add Finance Invoices')
          <a href="{{ url('finance-and-management/finance-invoices/finance-invoices-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Invoice" height="28" width="28" border="0/">
          </a>
         @endcan
          @can('View Deleted Finance Invoices')
          <a href="{{ url('finance-and-management/finance-invoices/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a  href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($receiptstatus==0)
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href>Payment Receipts List</a></li>
</ul>
@else
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href>Invoices List</a></li>
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
                                    <input type="radio"  name="mog" value="0" checked="checked"><span class="pabs">Member</span>
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
                                   placeholder="Search by Name" type="text" value="" autocomplete="off" name="customer"
                                   onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

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
                            <input value="" class=" form-control tablikebutton" type="text" autocomplete="off"
                                   id="end_date" name="end_date">
                        </div>
                    </div>


                    <div class="col-lg">
                        <div>
                            <p style="color: black;">Invoice No.</p>
                            <input value="" class=" form-control tablikebutton" size="20" type="number"
                                   id="receipt_search"
                                   name="receipt" placeholder="Search Id...">
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

                    <div class="col-sm">
                        <div >
                           <p style="color: black;">Details</p>
                            <select class="form-control" name="details" id="details">
                              <option label="Choose Option"></option>
                              <optgroup label="Main Charges">

                                @foreach($mains as $main)
                                 @can('Invoice'.' '.$main->id)
                                        <option  value="{{ $main->id }}">
                                            {{ $main->name }}
                                        </option>
                                        @endcan
                                @endforeach
                                </optgroup>
                                <optgroup label="Charges Types">
                                @foreach($charges as $charge)
                                 @can('Invoice'.' '.$charge->name.' '.$charge->mod_id)
                                        <option  value="{{ $charge->id }}">
                                            {{ $charge->name }}
                                        </option>
                                        @endcan
                                @endforeach
                                </optgroup>
                                <optgroup label="Subscription Types">
                                @foreach($subscriptions as $subs)
                                  @can('Invoice'.' '.$subs->name.' '.$subs->mod_id)
                                        <option  value="{{ $subs->id }}">
                                            {{ $subs->name }}
                                        </option>
                                        @endcan
                                @endforeach
                                </optgroup>
                            </select>
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
            <form method="post" action="{{url('finance-and-management/maintenance-fee-posting/printall')}}">
                {{csrf_field()}}
                <div class="row">

                    <div class="col-lg">
                        <div>
                           <div class="row">
                            <div class="col-sm-12">
                            <p style="color: black;">From Member ID</p></div>

                          </div>
                            <input name="fromMember" type="number" class="form-control">


                        </div>
                    </div>




                    <div class="col-lg">

                        <div>
                            <p style="color: black;">To Member ID</p>
                            <input type="number" class="form-control" name="toMember" >
                        </div>
                    </div>      <div class="col-lg">

                        <div>
                            <p style="color: black;">Batch No.</p>
                            <select name="invoice_Date"  class="form-control">
                                <option selected="selected" disabled="disabled">Select Batch Date</option>
                                @foreach($invoicesYears as $d)
                                <option value="{{$d->d}}">{{$d->d}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg">

                        <button type="submit" title="print" style="    margin-top: 32px;"
                                class="btn btn-warning"><i
                                class="fa fa-print"></i> Print All
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
                  <th class="wd-5p">Invoice #</th>
                  <th class="wd-10p">Invoice Date</th>
                  <th class="wd-5p">Type</th>
                  <th class="wd-15p">Name</th>
                  <th class="wd-5p">M/G No.</th>
                 
                  <th class="wd-15p">Grand Total</th>
                   <th class="wd-15p">Amount Paid</th>
                    <th class="wd-15p">Balance</th>
                     <th class="wd-15p">Details</th>

                    <th class="wd-15p">Status</th>
                   @can('Print Finance Invoices')
                  <th class="wd-15p hidden-print">Invoice</th>
                  @endcan
                   @can('Edit Finance Invoices')
                  <th class="wd-15p hidden-print">Edit</th>
                  @endcan
                   @can('Delete Finance Invoices')
                  <th class="wd-15p hidden-print">Delete</th>
                  @endcan

                </tr>
              </thead>
                <tfoot>
                <tr>
                    <td colspan="1">Total:</td>
                    <td colspan="3"><span class="countx"></span> </td>
                    <td colspan="2"></td>
                    <td colspan="1"><span class="grandx"></span> </td>
                     <td colspan="1"><span class="amtpaidx"></span> </td>
                     <td colspan="1"><span class="finalbalancex"></span> </td>
                     <td colspan="1"></td>
                      <td colspan="1"></td>
                    @can('Print Finance Invoices')
                   <td></td>
                   @endcan
                    @can('Edit Finance Invoices')
                        <td ></td>
                    @endcan
                    @can('Delete Finance Invoices')
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
            "pageLength": 100,
            "fnDrawCallback": function(c,b,a){
                console.log(c.aoData.length);
                if(c.aoData.length>0){
                    // $('.totalC').html('Total Receipts: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal);
                    $('.countx').html(c.aoData[0]._aData.ctotal);
                    $('.grandx').html(c.aoData[0]._aData.dtotal);
                     $('.amtpaidx').html(c.aoData[0]._aData.dtotal);
                    $('.finalbalancex').html(c.aoData[0]._aData.dtotal);
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
          order: [[ 1, 'desc' ]],
          "ajax": {
          'url': '{{ route('invoice.datatable') }}',
          'type': 'POST',
              data:{
                'start_date':function(){ return $('input[name="start_date"]').val()},
                'end_date':function(){ return $('input[name="end_date"]').val()},
                'customer':function(){ return $('input[name="customer"]').val()},
                'receipt':function(){ return $('input[name="receipt"]').val()},
                'mog':function(){ return $('input[name="mog"]:checked').val()},
               'status':function(){ return $('#status').val()},
                'details':function(){ return $('#details').val()}
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
             { data: 'DT_RowIndex', name: 'DT_RowIndex',width: '0.3%' },
            {width: '0.7%',data: 'id', name: 'id', searchable: false},
            {width: '1%',data: 'invoice_date', name: 'invoice_date', searchable: true},
            {width: '1%',data: 'type', name: 'type', searchable: true},
            {width: '2%',data: 'name', name: 'name', searchable: true},
            {width: '0.7%',data: 'customer_id', name: 'customer_id', searchable: true},

             {width: '0.9%',data: 'grand_total', name: 'grand_total', searchable: false},
              {width: '0.9%',data: 'amountpaid', name: 'amountpaid', searchable: false},
             {width: '0.9%',data: 'finalbalance', name: 'finalbalance', searchable: false},
             {width: '2%',data: 'details_d', name: 'details_d', searchable: true},
             {width: '0.7%',data: 'balancestatus', name: 'balancestatus', orderable:false},

            @can('Print Finance Invoices')
             {width: '0.7%',data: 'status', name: 'status', orderable:false},
             @endcan

            @can('Edit Finance Invoices')
            {width: '0.5%',data: 'editbutton', name: 'editbutton', orderable:false},
             @endcan

            @can('Delete Finance Invoices')
            {width: '0.7%',data: 'deletebutton', name: 'deletebutton', orderable:false},
            @endcan
        ],
            // rowCallback: function( row, data, index ) {
            //   if($('#status').val()=='1'){
            //       if(data.finalbalance!=0){
            //           console.log(data);
            //           $(row).addClass('remove');
            //       }
            //       else{
            //           $(row).removeClass('remove');
            //
            //       }
            //   }
            //   else if($('#status').val()=='2'){
            //       if(data.finalbalance==0){
            //           console.log(data);
            //
            //           $(row).addClass('remove');
            //       }
            //       else{
            //           $(row).removeClass('remove');
            //
            //       }
            //   }
            //   else{
            //
            //   }
            // }
    });
    function search() {
        oTable.ajax.reload();
    }
  function customerdata(val) {
      let v=$('input[name="mog"]:checked').val();

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
