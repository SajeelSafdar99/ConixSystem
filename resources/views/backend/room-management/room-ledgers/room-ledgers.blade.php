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

        .areabox {
            cursor: pointer !important;
        }

    </style>

    <div class="br-pagebody">
        <div>
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Ledger Accounts</h6>
            <div style="text-align: right;">
            <!-- <a href="{{ url('room-management/room-customer/room-customer-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Customer" height="28" width="28" border="0/">
          </a> -->
                <a href>
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page"
                         height="28" width="28"
                         border="0/">
                </a>
            </div>

            @if($ledgerstatus==0)
                <ul class="breadcrumbee border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
                    <li><a href>Rooms Ledger Accounts List</a></li>
                </ul>
            @else
                <ul class="breadcrumbee border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
                    <li><a href>Rooms Ledger Accounts List</a></li>
                </ul>
            @endif
            @if($errors->any())
                <div id="error_msg"
                     class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
                </div>
            @endif
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="container-fluid">
                <form method="get">
                    <div class="row">

                        <div class="col-lg">
                            <div>
                                 <div class="row">
                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <p style="color: black;">Name:</p></div>
  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                    <label class="rdiobox">
                                        <input type="radio" name="mog" value="1" checked="checked"><span class="pabs">Member</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                    <label class="rdiobox">
                                        <input type="radio" name="mog" value="0"><span class="pabs">Guest</span>
                                    </label>
                                </div>
                            </div>
                                <input @if($errors->has('customer')) style="border-color:red;"
                                       @endif id="customer_search" class="form-control typeahead tablikebutton"
                                       placeholder="Search by Name" type="text" value="{{$customer}}" name="customer" autocomplete="off"
                                       onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">
                                <input type="hidden" name="mog_id" value="{{$mog_id}}">

                                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                            </div>
                        </div>

                        <div class="col-lg">
                            <div>
                                <p style="color: black;">Begin Date:</p>
                                <input value="{{$start_date}}" class="form-control tablikebutton" type="text" autocomplete="off"
                                       id="start_date"
                                       name="start_date">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div>
                                <p style="color: black;">End Date:</p>
                                <input value="{{$end_date}}" class="form-control tablikebutton" type="text" autocomplete="off"
                             id="end_date" name="end_date">
                            </div>
                        </div>

                           <div class="col-lg">
                            <div>
                                <p style="color: black;">Booking No.</p>
                                <input class=" form-control tablikebutton" size="20" type="number" id="booking_search"
                                       value="{{$booking_no}}" name="booking_no" placeholder="Search Id...">
                            </div>
                        </div>


                        <div class="col-lg">
                            <div>
                                <p style="color: black;">Receipt No.</p>
                                <input value="{{$receipt}}" class=" form-control tablikebutton" size="20" type="number"
                                       id="receipt_search"
                                       name="receipt" placeholder="Search Id...">
                            </div>
                        </div>

                        <div class="col-lg">
                            <button style="    margin-top: 32px;" type="submit" class="btn btn-info"><i
                                    class="fa fa-search"></i>Search
                            </button>

                            <button onclick="window.print();" title="print" style="    margin-top: 32px;"
                                    class="btn btn-danger"><i
                                    class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>


                </form>
            </div>

            <br><br><br><br>

            <div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Credit:
                        Rs. {{number_format($bookingdata->sum('grand_total'))}}
                    </button>
                </div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Debit:
                        Rs. {{number_format($receiptdata->sum('total'))}}
                    </button>
                </div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Balance:
                        Rs.{{number_format($receiptdata->sum('total')-$bookingdata->sum('grand_total'))}}
                    </button>
                </div>
                @if(isset($openingBalance))
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Opening Balance:
                        Rs.<span class="openingBalance" style="display: none"> {{$openingBalance}}</span> {{number_format($openingBalance)}}
                    </button>
                </div>
                    @endif
            </div>


            <div id="London" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th style="cursor: pointer;" class="wd-10p">Date</th>
                            <th class="wd-10p">Type</th>
                            <th class="wd-5p">ID</th>
                            <th class="wd-10p">Name</th>
                            <th class="wd-10p">M/G Type</th>
                            <th class="wd-10p">M/G ID</th>
                            <th class="wd-15p">Detail</th>
                            <th class="wd-10p">Debit</th>
                            <th class="wd-10p">Credit</th>
                            <th class="wd-10p">Balance</th>
                            <th class="wd-10p hidden-print">Print</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $a=1; $showBalanceLoad=1; @endphp
                        @foreach($bookingdata as $booking)

                            <tr>
                                <td>{{$a}}</td>
                                <td>{{formatDateToShow($booking->check_out_date)}}</td>
                                <td>Booking</td>
                                <td>{{$booking->booking_no}}</td>
                                <td>{{$booking->moc_name}}</td>
                                <td>@if($booking->customer_id)  <span class="text-warning">(Customer)</span> @else  <span class="text-success">(Member)</span>@endif</td>
                                <td>@if($booking->customer_id) {{$booking->customer_id}}  @else {{$booking->member->mem_no}} @endif</td>

                                <td>{{roomtypename($booking->room)}}-{{roomno($booking->room)}}</td>
                                <td>0</td>
                                <td class="credit">{{($booking->grand_total)}}</td>
                                <td class="balance"></td>
                                <td><a target="_blank"
                                       href="{{ url('room-management/room-invoice/'). '/' . $booking->id }}">
                                        <button
                                            class="btnwidth hidden-print  btn btn-outline-danger active btn-block mg-b-10"
                                            title="Print Voucher">Print
                                        </button>
                                    </a></td>
                            </tr>
                            @php $a++;  $showBalanceLoad++ @endphp
                        @endforeach


                        @php $b=$a; $x=1;@endphp
                        @foreach($receiptdata as $receipt)

                            <tr>
                                <td>{{$b}}</td>
                                <td>{{formatDateToShow($receipt->invoice_date)}}</td>
                                <td>Receipt</td>
                                <td>{{$receipt->invoice_no}}</td>
                                <td>{{$receipt->guest_name}}</td>
                                <td>@if($receipt->customer_id) <span class="text-warning">(Customer)</span> @else  <span class="text-success">(Member)</span>@endif</td>
                                <td>@if($receipt->customer_id) {{$receipt->customer_id}} @else {{$receipt->member->mem_no}} @endif</td>

                                <td><span
                                        style="max-width: 200px;display: inline-block;">{!!  wordwrap($receipt->payment_details,30,"<br>") !!}</span>
                                </td>
                                <td class="debit">{{($receipt->total)}}</td>
                                <td>0</td>
                                <td class="balance"></td>
                                <td class=" hidden-print"><a target="_blank"
                                                             href="{{ url('room-management/room-payment-receipts/room-payment-receipts-invoice/'). '/' . $receipt->id }}">
                                        <button class="btnwidth btn btn-outline-danger active btn-block mg-b-10"
                                                title="Print Voucher">Print
                                        </button>
                                    </a></td>
                            </tr>
                            @php $b++; $showBalanceLoad++; @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>


        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
@endsection

@push('jscode')

    <style>
        .select2 {

            margin-top: 33px;
        }
    </style>
    <script>
        function loadBalance(a) {
            $('#usersTable tbody').find('tr').each(function () {

                let credit = $(this).find('.credit').html();
                let debit = $(this).find('.debit').html();
                let balance = $(this).prev('tr').find('.balance').html();
                if (a) {
                    balance = a;
                }
                if (balance == undefined) {

                console.log($('.openingBalance').length>0)
                    balance = 0;
                    if($('.openingBalance').length>0) balance=$('.openingBalance').html();
                }
                if (credit != undefined) {
                    balance = parseInt(balance) - parseInt(credit);

                }
                if (debit != undefined) {
                    balance = parseInt(balance) + parseInt(debit);
                    // console.log(debit);
                }
                $(this).find('.balance').html(balance);
                return;
            });
            // odata.fnSort([1,'desc'])
        }


        $(window).load(function () {
            let odata;

            odata = $('#usersTable').dataTable({
                "order": [[1, "asc"]],
                "pageLength": 100,
                fixedColumns: true,
                columns: [
                    {width: '2%'},
                    {width: '2%'},
                    {width: '2%'},
                    {width: '2%'},
                    {width: '2%'},
                    {width: '2%'},
                    {width: '2%'},
                    {width: '10%'},
                    {width: '2%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'}
                ],
                columnDefs: [
                    { type: 'date-uk', targets: 1 }
                ],
                "initComplete": function (settings, json) {
                    loadBalance();
                    $('table thead').find('th').click(function () {
                        loadBalance();

                    });
                    $('.paginate_button ').click(function () {
                        loadBalance();

                    })
                }
            });
            $('#usersTable').on('page.dt', function (a, b, c) {

            });

        });
        $(document).ready(function () {
            $('.select2').select2({theme: 'bootstrap'});
        });
    </script>


    <script type="text/javascript">
        var val;

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




  <script>


</script>


    <script type="text/javascript">
        var val;

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
                        let name = v == 1 ? val1.customer_name : val1.applicant_name;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);


                    });
$('#areabox').show();
                    // $('#areabox').html(data);

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
    <!-- <script>
    function openCity(evt,cityName) {
      var i;
      var x = document.getElementsByClassName("city");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
      }
      document.getElementById(cityName).style.display = "block";
       evt.currentTarget.className += " w3-red";
    }
    </script>


     <script type="text/javascript">
      $( document ).ready(function() {


    let tid = "#usersTable";
    let headers = document.querySelectorAll(tid + " th");

    // Sort the table element when clicking on the table headers
    headers.forEach(function(element, i) {
      element.addEventListener("click", function() {
        w3.sortHTML(tid, ".item", "td:nth-child(" + (2) + ")");
      });
    });




    });

    </script> -->


@endpush
