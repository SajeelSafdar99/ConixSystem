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
.areabox {
            cursor: pointer !important;
        }
</style>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Room Check Out</h6>
         <div style="text-align: right;">

          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href>Rooms Check Out List</a></li>
</ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
            <form method="get" action="{{route('roomCheckout.export')}}">
                <div class="row">

                    <div class="col-lg">
                        <div>
                           <div class="row">
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
 <p style="color: black;">Name:</p>
</div>
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input  type="radio"  name="mog" value="0"><span class="pabs">Member</span>
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
              <h5 class=" text-info visible-print"><span class="type"></span> <span class="name123"></span> <span class="start_date"></span> <span class="end_date"></span> <span class="booking_no"></span> </h5>
            <table  class="table display nowrap datatable">

              <thead>
                <tr>

                  <th class="wd-5p">#</th>
                  <th class="wd-5p">Book #</th>
                  <th class="wd-10p">Room #</th>
                  <th class="wd-10p">In Date</th>
                  <th class="wd-10p">Out Date</th>
                  <th class="wd-10p">Member/Guest Name</th>
                  <th class="wd-10p">Type</th>
                  <th class="wd-5p">Occupied by</th>
                  <th class="wd-10p">Room Rent</th>
                  <th class="wd-5p">Nights #</th>
                  <th class="wd-5p">Charges</th>
                 <!--  <th class="wd-10p">Food</th>
                  <th class="wd-10p">M.Bar</th>
                  <th class="wd-10p">Laundry</th>
                  <th class="wd-10p">Service</th>
                  <th class="wd-10p">Matt.</th>
                  <th class="wd-10p">MISC</th> -->
                   <th class="wd-10p">Other Charges</th>
                  <th class="wd-10p">Disc.</th>
                  <th class="wd-10p">Grand Total</th>
                  <th class="wd-10p">Amount Paid</th>
                  <th class="wd-10p">Balance</th>
                    <th class="wd-15p">Details</th>
                   <th class="wd-10p">Status</th>
                    <th class="wd-10p">Mark</th>
                @can('Print Check Out Invoice')
                  <th class="wd-5p hidden-print">Invoice</th>
                  @endcan
                  @can('Edit Final Check Out')
                  <th class="wd-5p hidden-print">Edit</th>
                  @endcan
                  <th class="wd-10p ">Remarks</th>


                </tr>
              </thead>
                <tfoot>
                <tr>
                    <td colspan="3">Total :</td>
                    <td colspan="6" class="bookingTotal"></td>
                    <td colspan="2" class="text-right totalCharges">{{number_format($totalcharges)}}</td>
                    <!-- <td class="totalFood"></td>
                    <td class="totalMiniBar"></td>
                    <td class="totalLaundry"></td>
                    <td class="totalService"></td>
                    <td class="totalMattress"></td>
                    <td class="totalMISC"></td> -->
                    <td class=" totalRoomCharges">{{number_format($totalroomcharges)}}</td>
                    <td class=" totalDiscount">{{number_format($totaldiscount)}}</td>
                    <td class="text-left  totalGrandTotal">{{number_format($totalgrandtotal)}}</td>
                     <td class="AmountPaid"></td>
                    <td class="Balance"></td>
                     <td></td>
                    <td></td>
                     @can('Print Check Out Invoice')
                    <td></td>
                    @endcan
                    @can('Edit Final Check Out')
                    <td ></td>
                    @endcan
                    <td ></td>

                </tr>
                </tfoot>
            </table>
          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')

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

                if(c.aoData.length>0){
                    $('.bookingTotal').html(c.aoData[0]._aData.bookingTotal);
                    // $('.totalBill').html(c.aoData[0]._aData.dtotal);
           /*         $('.totalRoomRent').html(c.aoData[0]._aData.dtotal.totalRoomRent);*/
                   /* $('.totalFood').html(c.aoData[0]._aData.dtotal.totalFood);
                    $('.totalMiniBar').html(c.aoData[0]._aData.dtotal.totalMiniBar);
                    $('.totalLaundry').html(c.aoData[0]._aData.dtotal.totalLaundry);
                    $('.totalService').html(c.aoData[0]._aData.dtotal.totalService);
                    $('.totalMattress').html(c.aoData[0]._aData.dtotal.totalMattress);
                    $('.totalMISC').html(c.aoData[0]._aData.dtotal.totalMISC);*/

              /*       $('.totalOtherCharges').html(c.aoData[0]._aData.dtotal.totalOtherCharges);
                    $('.totalDiscount').html(c.aoData[0]._aData.dtotal.totalDiscount);
                    $('.totalBalance').html(c.aoData[0]._aData.dtotal.totalBalance);
                     $('.AmountPaid').html(c.aoData[0]._aData.dtotal.AmountPaid);
                      $('.FinalBalance').html(c.aoData[0]._aData.dtotal.FinalBalance);*/
                    $('.type').html($('input[name="mog"] :checked').val()==0?'Selected Member:':'Selected Guest:');
                    $('.name123').html($('input[name="customer"]').val());
                    $('.start_date').html($('input[name="start_date"]').val()!=''?' From: '+$('input[name="start_date"]').val():'');
                    $('.end_date').html($('input[name="end_date"]').val()!=''?' to: '+$('input[name="end_date"]').val():'');
                    $('.booking_no').html($('input[name="booking"]').val()!=''?' where Booking #: '+$('input[name="booking"]').val():'');

                    $('.totalCharges').html(c.json.totalcharges);
                    $('.totalRoomCharges').html(c.json.totalroomcharges);
                    $('.totalDiscount').html(c.json.totaldiscount);
                    $('.totalGrandTotal').html(c.json.totalgrandtotal);
                    $('.AmountPaid').html(c.json.amountpaidT);
                      $('.Balance').html(c.json.finalbalanceT);

                    // $('.totalC').html('Total Bookings: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal)
                }
                else{
                    $('.totalC').html('')

                }



            },
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 4, 'desc' ]],
          "ajax": {
          'url': '{{ route('checkout.datatable') }}',
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
          // {
          //       // "className":      'details-control',
          //       "orderable":      false,
          //       "data":           null,
          //       "defaultContent": '',
          //       'searchable': false
          //   },
            // {data: 'id',name: 'id', orderable: false, searchable: false},
            { data: 'DT_RowIndex', name: 'DT_RowIndex',width:'0.3%'},
            {data: 'booking_no', name: 'booking_no', searchable: true,width:'.6%'},
            {data: 'room', name: 'room', searchable: true,width:'1%'},
            {data: 'check_in_date', name: 'check_in_date', searchable: true,width:'1.1%'},
            { name: 'check_out_date.timestamp', width:'1.3%','data': { '_': 'check_out_date.display', 'sort': 'check_out_date' }},
            {data: 'moc_name', name: 'moc_name', searchable: true,width:'1.7%'},
            {data: 'type', name: 'type', searchable: true,width:'.8%'},
            {data: 'name', name: 'name', searchable: true,width:'2%'},
            {data: 'pday_charges_id', name: 'pday_charges_id', searchable: false,width:'.9%'},
            {data: 'nights', name: 'nights', searchable: false,width:'.9%'},
            {data: 'charges', name: 'charges', searchable: false,width:'.9%'},

           /* {data: 'food', name: 'food', searchable: true,width:'.7%'},
            {data: 'mini_bar', name: 'mini_bar', searchable: true,width:'.7%'},
            {data: 'laundry', name: 'laundry', searchable: true,width:'.8%'},
            {data: 'services', name: 'services', searchable: true,width:'.7%'},
            {data: 'mattress', name: 'mattress', searchable: true,width:'.9%'},
            {data: 'misc', name: 'misc', searchable: true,width:'.5%'},*/
            {data: 'total_room_charges', name: 'total_room_charges', searchable: false,width:'.9%'},
            {data: 'discount_amount', name: 'discount_amount', searchable: false,width:'.9%'},
            {data: 'grand_total', name: 'grand_total', searchable: true,width:'1%'},
             {data: 'amountpaid', name: 'amountpaid', searchable: true,width:'1%'},
             {data: 'finalbalance', name: 'finalbalance', searchable: false,width:'1%'},
             {width: '2%',data: 'details_d', name: 'details_d', searchable: true},
             {data: 'balancestatus', name: 'balancestatus',width:'1.2%'},
            {data: 'paid', name: 'paid',width:'1%'},
            @can('Print Check Out Invoice')
            {data: 'status', name: 'status',width:'.7%'},
            @endcan
            @can('Edit Final Check Out')
            {data: 'editbutton', name: 'editbutton',width:'.7%'},
            @endcan
            {data: null,width:'.7%'},

        ],
         /*    rowCallback: function( row, data, index ) {
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
            }*/
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
                  let name = v == 1 ? val1.customer_name : val1.first_name+' '+val1.middle_name+' '+val1.applicant_name;
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
                  document.getElementById('customer_search').value = obj.first_name+' '+obj.middle_name+' '+obj.applicant_name;
                  $('input[name="mog_id"]').val( obj.id);

              }
              jQuery('#areabox').html('');

          }


      });
  }
</script>

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
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
