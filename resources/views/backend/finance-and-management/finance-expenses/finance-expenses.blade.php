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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Expenses</h6>
         <div style="text-align: right;" class="hidden-print">
          @can('Add Expenses')
          <a href="{{ url('finance-and-management/finance-expenses/finance-expenses-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Expense Voucher" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Expenses')
          <a href="{{ url('finance-and-management/finance-expenses/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a  href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-expenses-submodules') }}">Expenses</a></li>
  <li><a href>Expenses List</a></li>
</ul>


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

                          </div>
                            <input @if($errors->has('finance_ledger_person')) style="border-color:red;"
                                   @endif id="customer_search" class="form-control typeahead tablikebutton"
                                   placeholder="Search by Name" type="text" value="" name="finance_ledger_person"
                                   onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" autocomplete="off">

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
                            <p style="color: black;">Voucher No.</p>
                            <input value="" class="form-control tablikebutton" autocomplete="off" size="20" type="number"
                                   id="receipt_search"
                                   name="expense" placeholder="Search Id...">
                        </div>
                    </div>

                    <div class="col-lg">
                        <button style="    margin-top: 32px;" type="submit" class="btn btn-info"><i
                                    class="fa fa-search"></i>Search
                            </button>

                        <button onclick="window.print();" title="print" style="margin-top: 32px;"
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
                  <th class="wd-5p">Voucher #</th>
                  <th class="wd-10p">Voucher Date</th>
                  <th class="wd-20p">Name</th>
                  <th class="wd-10p">Ledger A/c #</th>
        
                  <th class="wd-10p">Payable</th>
                  <th class="wd-15p">Expense Details</th>
               
                  <th class="wd-15p">Grand Total</th>
                   <th class="wd-10p">Amount Paid</th>
                   <th class="wd-10p">Balance</th>
                    <th class="wd-10p">Details</th>
                   <th class="wd-10p">Status</th>
                    @can('View Expenses Documents')
                  <th class="wd-15p hidden-print">Doc.</th>
                  @endcan
                   @can('Print Expenses Voucher')
                  <th class="wd-15p hidden-print">Voucher</th>
                  @endcan
                   @can('Edit Expenses')
                  <th class="wd-15p hidden-print">Edit</th>
                  @endcan
                   @can('Delete Expenses')
                  <th class="wd-15p hidden-print">Delete</th>
                  @endcan

                </tr>
              </thead>
                <tfoot>
                <tr>
                    <td colspan="1">Total:</td>
                    <td colspan="2"><span class="countx"></span> </td>
                    <td colspan="4"></td>
                    <td colspan="1"><span class="amountx"></span> </td>
                    <td colspan="1"><span class="paidx"></span> </td>
                    <td colspan="1"><span class="balx"></span> </td>
                    <td></td>
                    <td></td>
                     @can('View Expenses Documents')
                   <td></td>
                   @endcan
                    @can('Print Expenses Voucher')
                   <td></td>
                   @endcan
                    @can('Edit Expenses')
                        <td ></td>
                    @endcan
                    @can('Delete Expenses')
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
          $('.totalC').html('Total Vouchers: '+json.data[0].ctotal+ ' <br>Total Amount: '+json.data[0].dtotal)
      }
  });
        var oTable =   $('.datatable').DataTable({
            "pageLength": 100,
            "fnDrawCallback": function(c,b,a){
                console.log(c.aoData.length);
                if(c.aoData.length>0){
                    // $('.totalC').html('Total Receipts: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal);
                    $('.countx').html(c.aoData[0]._aData.ctotal);
                    $('.amountx').html(c.aoData[0]._aData.dtotal);
                   $('.paidx').html(c.aoData[0]._aData.dtotal);
                  $('.balx').html(c.aoData[0]._aData.dtotal);

                    $('.name123').html($('input[name="finance_ledger_person"]').val());
                    $('.start_date').html($('input[name="start_date"]').val()!=''?' From: '+$('input[name="start_date"]').val():'');
                    $('.end_date').html($('input[name="end_date"]').val()!=''?' to: '+$('input[name="end_date"]').val():'');
                    $('.booking_no').html($('input[name="expense"]').val()!=''?' where Receipt #: '+$('input[name="expense"]').val():'');
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
          'url': '{{ route('expenses.datatable') }}',
          'type': 'POST',
              data:{
                'start_date':function(){ return $('input[name="start_date"]').val()},
                'end_date':function(){ return $('input[name="end_date"]').val()},
                'finance_ledger_person':function(){ return $('input[name="finance_ledger_person"]').val()},
                'expense':function(){ return $('input[name="expense"]').val()}
               
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
           
            {width: '2%',data: 'person_name', name: 'person_name', searchable: true},
            {width: '0.7%',data: 'person_id', name: 'person_id', searchable: true},
          //  {width: '1%',data: 'person_contact', name: 'person_contact', searchable: true},
            {width: '1.1%',data: 'expense_paid_for', name: 'expense_paid_for', searchable: true},
            {width: '2.5%',data: 'expense_details', name: 'expense_details', searchable: false},
           // {width: '1.1%',data: 'ac', name: 'ac', searchable: false},
            {width: '1%',data: 'total', name: 'total', searchable: false},
            {width: '1%',data: 'amountpaid', name: 'amountpaid', searchable: false},
            {width: '1%',data: 'finalbalance', name: 'finalbalance', searchable: false},
             {width: '2%',data: 'details_d', name: 'details_d', searchable: true},
            {data: 'balancestatus', name: 'balancestatus',width:'1.2%', orderable:false},

             @can('View Expenses Documents')
             {width: '0.7%',data: 'docs', name: 'docs', orderable:false},
             @endcan

            @can('Print Expenses Voucher')
             {width: '0.7%',data: 'status', name: 'status', orderable:false},
             @endcan
            
              @can('Edit Expenses')
            {width: '0.5%',data: 'editbutton', name: 'editbutton', orderable:false},
            @endcan
           
            @can('Delete Expenses')
            {width: '0.5%',data: 'deletebutton', name: 'deletebutton', orderable:false},
            @endcan
        ]
    });

  function customerdata(val) {
     

      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdatalike') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "personid": val,
              
          },
          success: function (data) {

              jQuery('#areabox').html('');
              jQuery.each(JSON.parse(data), function (i, val1) {
                  let name = val1.person_name;
                  let code = val1.person_no;
                  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);


              });
$('#areabox').show();

          }
      });
  }
  function customerdatavalue(val) {
     

      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdata') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "personid": val,
              
          },
          success: function (data) {

              console.log(data);
              var obj = JSON.parse(data);

            
                  document.getElementById('customer_search').value = obj.person_name;
                 
             
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
