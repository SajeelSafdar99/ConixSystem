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
        ul.breadcrumbee li + li:before {
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

        .floatydivs {
            float: left;
            margin-right: 149px;
            margin-left: 100px;
        }

        .desktop-screen-design {
            width: 100% !important;
            padding-bottom: 70px;
        }

        .block {
            display: block;
            width: 20%;
            line-height: 50px;
            float: left;
        }


        .w3-black, .w3-hover-black:hover {
            color: #fff !important;
            background-color: #dddddd !important;
        }

        .w3-button:hover {
            color: #000 !important;
            background-color: #ccc !important;
        }

        .w3-red {
            color: #fff !important;
            background-color: #616161 !important;
        }

        .w3-red:hover {
            color: #fff !important;
            background-color: #616161 !important;
        }


        .w3-bar {
            width: 100%;
            height: 60px;
            overflow: hidden;
        }

        .w3-border {
            border: 1px solid #ccc !important;
        }

        .w3-bar .w3-bar-item {
            padding: 8px 16px;
            float: left;
            width: 20%;
            border: none;
            display: block;
            outline: 0;
            height: 60px;
        }

        .w3-bar .w3-button {
            white-space: normal;
        }

        th {
            color: #fff !important;
        }
        .dataTables_filter {
            display: none;
        }
        table.dataTable thead .sorting,table.dataTable thead .sorting_desc,table.dataTable thead .sorting_asc{
background-image: none!important;
        }

.areabox{cursor:pointer !important;}

    </style>

    <div class="br-pagebody">
        <div>
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Rooms Revenue Report</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
            <!-- <a href="{{ url('room-management/room-customer/room-customer-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Customer" height="28" width="28" border="0/">
          </a> -->
                <a href>
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

@if($reportstatus==1)
 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
    <li><a href="{{ url('room-management/room-reports') }}">Types of Reports</a></li>
    <li><a href>Reports List</a></li>
    </ul>
@else
 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
    <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
    <li><a href="{{ url('finance-and-management/finance-reports') }}">Types of Reports</a></li>
    <li><a href>Rooms Revenue Report List</a></li>
    </ul>
@endif

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


            <form method="get" id="fformToExcel" action="{{route('financeReporting.export')}}">
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
                                   onkeyup="customerdata(this.value)" autocomplete="off" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                        </div>
                    </div>

                    <div class="col-lg">
                        <div class="row">
                        <div class="col-lg">
                            <p style="color: black;">Begin Date:</p>
                            <input value="" placeholder="Select Date" class=" form-control tablikebutton" type="text" autocomplete="off"
                                   id="start_date"
                                   name="start_date">
                        </div>
                        <div class="col-lg">
                            <p style="color: black;">End Date:</p>
                            <input value="" placeholder="Select Date" class="form-control tablikebutton" type="text" autocomplete="off"
                                   id="end_date" name="end_date">
                        </div>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="row">
                            <div class="col-lg">
                            <p style="color: black;">Date Filter</p>
                          <select class="form-control " name="dateF">
                              <option selected="selected" value="check_in_date">Check in date</option>
                              <option  value="check_out_date">Check out date</option>
                              <option  value="booking_date">Booking date</option>

                          </select>
                        </div>
                            <div class="col-lg">
                            <p style="color: black;">Filter by Room:</p>
                          <select class="form-control " name="room">
                              <option selected="selected" value="null">All</option>
                              @foreach ($rooms as $r)
                              <option value="{{$r['id']}}">{{$r['roomtypes']['desc']}} {{$r['room_no']}}</option>
                              @endforeach
                          </select>
                        </div>



                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="row">
                            <div class="col-lg">
                        <p style="color: black;">Charges  type:</p>
                        <select class="form-control " name="cType">
                            <option selected="selected" value="null">All</option>
                            @foreach ($subs as $r)
                                <option value="{{$r['id']}}">{{$r['type']}}</option>
                            @endforeach
                        </select>
                            </div>
                            <div class="col-lg">
                                <p style="color: black;">Booking No.</p>
                                <input value="" class=" form-control tablikebutton" size="20" type="number"
                                       id="receipt_search"
                                       name="booking" placeholder="Search Id...">
                            </div>
                    </div>
                    </div>
                        <div class="col-lg">
                        <div class="row">
                            <div class="col-lg">
                                <p style="color: black;">Payment:</p>
                                <select class="form-control " name="paymentF">
                                    <option selected="selected" value="null">All</option>
                                    <option value="advance_paid">Advance</option>
                                    <option value="total_balance">Balance</option>
                                    <option value="discount_amount">Discount</option>
                                </select>
                            </div>
                            <div class="col-lg">
                                <p style="color: black;">Payment Methods:</p>
                                <select class="form-control " name="payment_mode">
                                    <option selected="selected" value="null">All</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>

                        </div>
                    </div>
                        <div class="col-lg">
                            <p style="color: black;">Sort by.</p>

                            <div class="row">
                        <div  class="col-sm-8">
                           <select name="sort" class="form-control">
                               <option value="1">Book #</option>
                               <option value="2">Room #</option>
                               <option selected value="3">In Date</option>
                               <option value="4">Out Date</option>
                               <option value="5">Member/Guest Name</option>
                               <option value="6">Type</option>
                               <option value="7">Occupied by</option>
                               <option value="8">Room Rent</option>
                               <option value="9">Nights #</option>
                               <option value="10">Charges</option>
                               <option value="11">Food</option>
                               <option value="12">M.Bar</option>
                               <option value="13">Laundry</option>
                               <option value="14">Service</option>
                               <option value="15">Matt.</option>
                               <option value="16">MISC</option>
                               <option value="17">Disc.</option>
                               <option value="18">Total</option>
                               <option value="19">Adv.</option>
                               <option value="20">Balance</option>
                           </select>
                        </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="direction">
                                    <option value="desc">Desc</option>
                                    <option selected value="asc">Asc</option>

                                </select>
                            </div>
                            </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px">
  <div class="col-lg">
                        <button  type="button" id="searchButton" class="btn btn-info"><i
                                class="fa fa-search"></i>Search
                        </button>

                        <button type="button" onclick="window.print();" title="print"
                                class="btn btn-danger"><i
                                class="fa fa-print"></i>
                        </button>
                        <input type="hidden" name="type" value="0" class="typed">
                        <button type="button" onclick="$('.typed').val(0);$('#fformToExcel').submit()" class="btn btn-default"><i class="text-success fa fa-file-excel"></i> Checkout</button>
                        <button type="button" onclick="$('.typed').val(1);$('#fformToExcel').submit()"  class="btn btn-default"><i class="text-success fa fa-file-excel"></i> Occupancy</button>
                        <button type="button" onclick="$('.typed').val(2);$('#fformToExcel').submit()"  class="btn btn-default"><i class="text-success fa fa-file-excel"></i> Advanced Checkout</button>
                    </div>

                </div>


                <br>

            </form>
          <div class="table-wrapper" style="display: none">
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
                  <th class="wd-10p">Food</th>
                  <th class="wd-10p">M.Bar</th>
                  <th class="wd-10p">Laundry</th>
                  <th class="wd-10p">Service</th>
                  <th class="wd-10p">Matt.</th>
                  <th class="wd-10p">MISC</th>
                  <th class="wd-10p">Disc.</th>
                  <th class="wd-10p">Total</th>
                  <th class="wd-10p">Adv.</th>
                  <th class="wd-10p">Balance</th>
                  <th class="wd-10p hidden-print">Invoice</th>
                  <th class="wd-10p ">Remarks</th>


                </tr>
              </thead>
                <tfoot>
                <tr>
                    <td colspan="3">Total :</td>
                    <td colspan="7" class="bookingTotal"></td>
                    <td class="totalRoomRent"></td>
                    <td class="totalFood"></td>
                    <td class="totalMiniBar"></td>
                    <td class="totalLaundry"></td>
                    <td class="totalService"></td>
                    <td class="totalMattress"></td>
                    <td class="totalMISC"></td>
                    <td class="totalDiscount"></td>
                    <td class="totalBill"></td>
                    <td class="totalAdvance"></td>
                    <td class="totalBalance"></td>
                    <td></td>
                    <td ></td>

                </tr>
                </tfoot>
            </table>
          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')



<script type="text/javascript">

// $(document).ready(function() {

  $(document).ready(function(){
      var oTable = '';

      $('#searchButton').click(function () {
          if($('.dataTable tbody tr').length>0){
              $('.dataTable').DataTable().order( $('select[name="sort"]').val(), $('select[name="direction"]').val() );
              $('.dataTable').DataTable().ajax.reload();
          }
          else{
              $('.table-wrapper').show();

              var oTable =   $('.datatable').DataTable({
              seaching: false,
              "paging":   false,
                  // "ordering": false,
              "fnDrawCallback": function(c,b,a){
                  // console.log(c.aoData.length);

                  if(c.aoData.length>0){
                      $('.bookingTotal').html(c.aoData[0]._aData.ctotal);
                      // $('.totalBill').html(c.aoData[0]._aData.dtotal);
                      $('.totalRoomRent').html(c.aoData[0]._aData.dtotal.totalRoomRent);
                      $('.totalFood').html(c.aoData[0]._aData.dtotal.totalFood);
                      $('.totalMiniBar').html(c.aoData[0]._aData.dtotal.totalMiniBar);
                      $('.totalLaundry').html(c.aoData[0]._aData.dtotal.totalLaundry);
                      $('.totalService').html(c.aoData[0]._aData.dtotal.totalService);
                      $('.totalMattress').html(c.aoData[0]._aData.dtotal.totalMattress);
                      $('.totalMISC').html(c.aoData[0]._aData.dtotal.totalMISC);
                      $('.totalDiscount').html(c.aoData[0]._aData.dtotal.totalDiscount);
                      $('.totalAdvance').html(c.aoData[0]._aData.dtotal.totalAdvance);
                      $('.totalBill').html(c.aoData[0]._aData.dtotal.totalBill);
                      $('.totalBalance').html(c.aoData[0]._aData.dtotal.totalBalance);
                      $('.type').html($('input[name="mog"] :checked').val()==0?'Selected Member:':'Selected Guest:');
                      $('.name123').html($('input[name="customer"]').val());
                      $('.start_date').html($('input[name="start_date"]').val()!=''?' From: '+$('input[name="start_date"]').val():'');
                      $('.end_date').html($('input[name="end_date"]').val()!=''?' to: '+$('input[name="end_date"]').val():'');
                      $('.booking_no').html($('input[name="booking"]').val()!=''?' where Booking #: '+$('input[name="booking"]').val():'');
                      // $('.totalC').html('Total Bookings: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal)
                  }
                  else{
                      $('.bookingTotal').html('');
                      // $('.totalBill').html(c.aoData[0]._aData.dtotal);
                      $('.totalRoomRent').html('');
                      $('.totalFood').html('');
                      $('.totalMiniBar').html('');
                      $('.totalLaundry').html('');
                      $('.totalService').html('');
                      $('.totalMattress').html('');
                      $('.totalMISC').html('');
                      $('.totalDiscount').html('');
                      $('.totalAdvance').html('');
                      $('.totalBill').html('');
                      $('.totalBalance').html('');
                      $('.type').html('');
                      $('.name123').html('');
                      $('.start_date').html('');
                      $('.end_date').html('');
                      $('.booking_no').html('');
                      $('.totalC').html('');

                  }



              },
              oLanguage: {
                  sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
              },
              processing: true,
              serverSide: true,
              order: [[ $('select[name="sort"]').val(), $('select[name="direction"]').val() ]],
              "ajax": {
                  'url': '{{ route('financereports.datatable') }}',
                  'type': 'POST',
                  data:{
                      'start_date':function(){ return $('input[name="start_date"]').val()},
                      'end_date':function(){ return $('input[name="end_date"]').val()},
                      'customer':function(){ return $('input[name="customer"]').val()},
                      'receipt':function(){ return $('input[name="booking"]').val()},
                      'mog':function(){ return $('input[name="mog"]:checked').val()},
                      'room':function(){ return $('select[name="room"]').val()},
                      'cType':function(){ return $('select[name="cType"]').val()},
                      'dateF':function(){ return $('select[name="dateF"]').val()},
                      'paymentF':function(){ return $('select[name="paymentF"]').val()},
                      'payment_mode':function(){ return $('select[name="payment_mode"]').val()},
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
                  { data: 'DT_RowIndex', name: 'DT_RowIndex',width:'0.5%'},
                  {data: 'booking_no', name: 'booking_no', searchable: true,width:'.6%'},
                  {data: 'room', name: 'room', searchable: true,width:'1%'},
                  {data: 'check_in_date', name: 'check_in_date', searchable: true,width:'1.1%'},
                  {data: 'check_out_date', name: 'check_out_date', searchable: true,width:'1.3%'},
                  {data: 'moc_name', name: 'moc_name', searchable: true,width:'1.7%'},
                  {data: 'type', name: 'type', searchable: true,width:'.8%'},
                  {data: 'name', name: 'name', searchable: true,width:'2%'},
                  {data: 'pday_charges_id', name: 'pday_charges_id', searchable: true,width:'.9%'},
                  {data: 'nights', name: 'nights', searchable: true,width:'.9%'},
                  {data: 'charges', name: 'charges', searchable: true,width:'.9%'},

                  {data: 'food', name: 'food', searchable: true,width:'.7%'},
                  {data: 'mini_bar', name: 'mini_bar', searchable: true,width:'.7%'},
                  {data: 'laundry', name: 'laundry', searchable: true,width:'.8%'},
                  {data: 'services', name: 'services', searchable: true,width:'.7%'},
                  {data: 'mattress', name: 'mattress', searchable: true,width:'.9%'},
                  {data: 'misc', name: 'misc', searchable: true,width:'.5%'},
                  {data: 'discount_amount', name: 'discount_amount', searchable: true,width:'.9%'},
                  {data: 'total_charges', name: 'total_charges', searchable: true,width:'1%'},
                  {data: 'advance_paid', name: 'advance_paid', searchable: true,width:'.8%'},
                  {data: 'total_balance', name: 'total_balance', searchable: true,width:'1%'},
                  {data: 'status', name: 'status',width:'.7%'},
                  {data: null,width:'.7%'},

              ],

          });
          }
      })
  })

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

              // $('#areabox').html(data);
              $('#areabox').show();

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
                  
                  document.getElementById('customer_search').value =  $fname+$mname+$lname;
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
