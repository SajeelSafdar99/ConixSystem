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

        .tablikebutton {

            display: inline;
            /*margin-top: 30px;*/

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
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Trial Balance</h6>
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

            @if($accdetailstatus==1)
                <ul class="breadcrumbee border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
                    <li><a href>Rooms Trial Balance List</a></li>
                </ul>
            @else
                <ul class="breadcrumbee border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
                    <li><a href>Rooms Trial Balance List</a></li>
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
                            <p style="color: black;">Member / Guest:</p>
                            <br>
                            <div class="row">

                                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                    <label class="rdiobox">
                                        <input type="radio" {{$mog==0?'checked':''}} name="mog" value="0" checked="checked"><span class="pabs">Member</span>
                                    </label>
                                </div>
                                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                    <label class="rdiobox">
                                        <input type="radio" {{$mog==1?'checked':''}} name="mog" value="1"><span class="pabs">Guest</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg">
                            <div>
                                <p style="color: black;">Name:</p>

                                <input autocomplete="off" @if($errors->has('customer')) style="border-color:red;"
                                       @endif id="customer_search" class="form-control typeahead tablikebutton"
                                       placeholder="Search by Name" type="text" value="{{$customer}}" name="customer"
                                       autocomplete="off" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                            </div>
                        </div>

                        <div class="col-lg">
                            <div>
                                <p style="color: black;">Begin Date:</p>
                                <input value="{{$start_date}}" class=" form-control tablikebutton"
                                       placeholder="dd/mm/yyyy" type="text" autocomplete="off"
                                       id="start_date"
                                       name="start_date">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div>
                                <p style="color: black;">End Date:</p>
                                <input value="{{$end_date}}" class="form-control tablikebutton" type="text"
                                       placeholder="dd/mm/yyyy" autocomplete="off"
                                       id="end_date" name="end_date">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <button style="    margin-top: 33px;" type="submit" class="btn btn-primary"><i
                                        class="fa fa-search"></i> Search
                                </button>
                                <button style="    margin-top: 33px;" type="button" onclick="window.print()"
                                        class="btn btn-danger"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>


            <br>
            <br>
            <br>


            <div id="London" class="w3-container w3-border city">
                <div class="table-wrapper">
                    <table id="usersTable" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>

                            <th class="wd-10p">Name</th>
                            <th class="wd-10p">Type</th>
                            <th class="wd-10p">M/G No.</th>
                            <th class="wd-15p">Detail</th>
                            <th class="wd-10p">Debit</th>
                            <th class="wd-10p">Credit</th>
                            <th class="wd-10p">Balance</th>
                            <th class="wd-10p">Info</th>

                        </tr>
                        </thead>
                        <tbody>
                        @php $a=1; $showBalanceLoad=1; @endphp

                        @foreach($customers as $c)
                            @php
                                //  dd($c->receipts()->toSql('total'));
                                      $cond=  $c->bookings()->where('check_out_status', 1)->sum('grand_total')>0 || $c->receipts()->where('payment_received_for',2)->sum('total')>0;
       if($start_date!=''){
                                          $cond= $c->bookings()->where('check_out_date','>=',formatDate($start_date))->where('check_out_status', 1)->sum('grand_total')>0 || $c->receipts()->where('invoice_date','>=',formatDate($start_date))->where('payment_received_for',2)->sum('total')>0;

       }
       if($end_date!=''){
                                              $cond= $c->bookings()->where('check_out_date','<=',formatDate($end_date))->where('check_out_status', 1)->sum('grand_total')>0 || $c->receipts()->where('invoice_date','<=',formatDate($end_date))->where('payment_received_for',2)->sum('total')>0;

       }
       if($start_date!='' && $end_date!=''){
                                                  $cond= $c->bookings()->where('check_out_date','>=',formatDate($start_date))->where('check_out_date','<=',formatDate($start_date))->where('check_out_status', 1)->sum('grand_total')>0 || $c->receipts()->where('payment_received_for',2)->where('invoice_date','>=',formatDate($start_date))->where('invoice_date','<=',formatDate($start_date))->sum('total')>0;

       }
                            @endphp
                            @if($customer!='')
                                @if($cond)
                                    @if($member==1)
                                        @if($c->applicant_name==$customer)
                                            <tr>
                                                <td>{{$a}}</td>
                                                <td>{{$c->applicant_name}}</td>
                                                <td>Member</td>
                                                <td>{{$c->mem_no}}</td>
                                                <td>ledger</td>
                                                <td>{{$c->receipts()->sum('total')}}</td>
                                                <td>{{$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                                <td>{{$c->receipts()->where('payment_received_for',2)->sum('total')-$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                                <td><a target="_blank" class="text-info" href="{{url('room-management/room-ledgers?mog=0&customer='.$c->applicant_name.'&mog_id='.$c->id.'&start_date='.$start_date.'&end_date='.$end_date.'&booking_no=&receipt=')}}"><i class="fa fa-info-circle"></i> </a> </td>

                                            </tr>

                                        @endif
                                    @else
                                        @if($c->customer_name==$customer)
                                            <tr>
                                                <td>{{$a}}</td>
                                                <td>{{$c->customer_name}}</td>
                                                <td>Customer</td>
                                                <td>{{$c->id}}</td>
                                                <td>ledger</td>
                                                <td>{{$c->receipts()->sum('total')}}</td>
                                                <td>{{$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                                <td>{{$c->receipts()->where('payment_received_for',2)->sum('total')-$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                                <td><a target="_blank" class="text-info" href="{{url('room-management/room-ledgers?mog=0&customer='.$c->customer_name.'&mog_id='.$c->id.'&start_date='.$start_date.'&end_date='.$end_date.'&booking_no=&receipt=')}}"><i class="fa fa-info-circle"></i> </a> </td>


                                            </tr>

                                        @endif
                                    @endif
                                @endif
                            @else

                            @if($cond)
                                @if($member==1)
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td>{{$c->applicant_name}}</td>
                                        <td>Member</td>
                                        <td>{{$c->mem_no}}</td>
                                        <td>ledger</td>
                                        <td>{{$c->receipts()->sum('total')}}</td>
                                        <td>{{$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                        <td>{{$c->receipts()->where('payment_received_for',2)->sum('total')-$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                        <td><a target="_blank" class="text-info" href="{{url('room-management/room-ledgers?mog=1&customer='.$c->applicant_name.'&mog_id='.$c->id.'&start_date='.$start_date.'&end_date='.$end_date.'&booking_no=&receipt=')}}"><i class="fa fa-info-circle"></i> </a> </td>

                                    </tr>
                                @else
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td>{{$c->customer_name}}</td>
                                        <td>Customer</td>
                                        <td>{{$c->id}}</td>
                                        <td>ledger</td>
                                        <td>{{$c->receipts()->sum('total')}}</td>
                                        <td>{{$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                        <td>{{$c->receipts()->where('payment_received_for',2)->sum('total')-$c->bookings()->where('check_out_status', 1)->sum('grand_total')}}</td>
                                        <td><a target="_blank" class="text-info" href="{{url('room-management/room-ledgers?mog=0&customer='.$c->customer_name.'&mog_id='.$c->id.'&start_date='.$start_date.'&end_date='.$end_date.'&booking_no=&receipt=')}}"><i class="fa fa-info-circle"></i> </a> </td>

                                    </tr>
                                @endif
                                @php $a++;  $showBalanceLoad++ @endphp
                            @endif
                            @endif
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
                    balance = 0;
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
                    {width: '10%'},
                    {width: '2%'},
                    {width: '10%'},
                    {width: '2%'},
                    {width: '10%'},
                    {width: '2%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'}
                ],
                "initComplete": function (settings, json) {
                    loadBalance();
                    $('table thead').find('th').click(function () {
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

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

    <script>

        $(function () {
            $("#start_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        });

        $(function () {
            $("#end_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        });
    </script>
    <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v = $('input[name="mog"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);

                    if (v == 1) {
                        document.getElementById('customer_search').value = obj.customer_name;
                    } else {
                        document.getElementById('customer_search').value = obj.applicant_name;
                    }

                    jQuery('#areabox').html('');

                }


            });
        }
    </script>

    <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v = $('input[name="mog"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {
                        if (v == 1) {
                            $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name}<li>`);
                        } else {
                            $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.applicant_name}<li>`);
                        }

                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
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
