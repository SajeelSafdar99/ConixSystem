@extends('backend.layout.app')
@section('page-content')
    <style type="text/css">
        .header {
  background-color: #f1f1f1;
  text-align: center;
  font-size: 18px;
  color:black;
}

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
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Cash Flow</h6>
            <div style="text-align: right;">
            <!-- <a href="{{ url('room-management/room-customer/room-customer-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Customer" height="28" width="28" border="0/">
          </a> -->
                <a href>
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
    <li><a href>Cash Flow List</a></li>
    </ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


                <div class="container-fluid">
                <form method="get">
                    <div class="row">

                        <div class="col-lg-5">
                            <div>
                                <p style="color: black;">Begin Date:</p>
                                <input value="{{$start_date}}" class="form-control tablikebutton" type="text" autocomplete="off"
                                       id="start_date"
                                       name="start_date">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div>
                                <p style="color: black;">End Date:</p>
                                <input value="{{$end_date}}" class="form-control tablikebutton" type="text" autocomplete="off"
                             id="end_date" name="end_date">
                            </div>
                        </div>

               
                        <div class="col-lg-2">
                            <button style="    margin-top: 34px;" type="submit" class="btn btn-info"><i
                                    class="fa fa-search"></i>Search
                            </button>

                            <button onclick="window.print();" title="print" style="    margin-top: 34px;"
                                    class="btn btn-danger"><i
                                    class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>


                </form>
            </div>
<br>
<br>


            <div class="header"><b>OVERVIEW</b></div>
            <div id="London" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable1" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th style="cursor: pointer;" class="wd-10p">Start Date</th>
                            <th style="cursor: pointer;" class="wd-10p">End Date</th>
                            <th class="wd-10p">Type</th>
                            <th class="wd-10p">Quantity</th>
                            <th class="wd-5p">Debit</th>
                            <th class="wd-5p">Credit</th>
                            <th class="wd-5p">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                              

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;

$sumqnt = 0;
$Esumqnt = 0;
$debitsum = 0;
$creditsum = 0;
    @endphp

                        @foreach($data as $r)
                            @php

                           

                            $r=(object) $r;
$i++;




$sumqnt+= $r->Qnt;
$Esumqnt+= $r->Eqnt;
$debitsum+= $r->debit;
$creditsum+= $r->credit;
                            @endphp
                           

                             
                            
                          @endforeach
                           <tr>
                                <td>1</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
                                <td>Room Payment Receipt</td>
                                <td>{{$sumqnt}}</td>
                                 <td>{{$debitsum}}</td>
                                <td>0</td>
                                <td>{{$debitsum}}</td>
                
                            </tr>
<tr>
                                <td>2</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
                                <td>Expense</td>
                                <td>{{$Esumqnt}}</td>
                                 <td>0</td>
                                <td>{{$creditsum}}</td>
                                <td>{{$debitsum-$creditsum}}</td>
                
                            </tr>





 <tr style="background-color: #55bff9;">
    <td colspan="7" class="text-right">Total Balance:</td>
    <td colspan="1"  class="text-left balance">{{isset($totalBalance)?$totalBalance:0}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>

<br> <br>



     <div class="header"><b>PAYMENT RECEIPTS</b></div>
            <div id="London4" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable4" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-10p">Cash</th>
                            <th class="wd-10p">Cheaque</th>
                            <th class="wd-10p">Credit Card</th>
                            <th class="wd-10p">Online Bank Transfer</th>
                            <th class="wd-10p">Total Debit</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                              

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;


$debitsum = 0;
$cashdebitsum = 0;
$cheaquedebitsum = 0;
$creditdebitsum = 0;
$bankdebitsum = 0;
    @endphp

                        @foreach($data as $r)
                            @php

                           

                            $r=(object) $r;
$i++;




$debitsum+= $r->debit;
$cashdebitsum+= $r->cashdebit;
$cheaquedebitsum+= $r->cheaquedebit;
$creditdebitsum+= $r->creditdebit;
$bankdebitsum+= $r->bankdebit;
                            @endphp
                           

                             
                            
                          @endforeach
                           <tr>
                                <td>1</td>
                                <td>{{$cashdebitsum}}</td>
                                <td>{{$cheaquedebitsum}}</td>
                                <td>{{$creditdebitsum}}</td>
                                <td>{{$bankdebitsum}}</td>
                                 <td>{{$debitsum}}</td>    
                            </tr>

                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>

<br><br>



   <div class="header"><b>EXPENSES</b></div>
            <div id="London3" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable3" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-10p">Cash</th>
                            <th class="wd-10p">Cheaque</th>
                            <th class="wd-10p">Credit Card</th>
                            <th class="wd-10p">Online Bank Transfer</th>
                            <th class="wd-10p">Total Credit</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                              

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;


$creditsum = 0;
$cashcreditsum = 0;
$cheaquecreditsum = 0;
$cardcreditsum = 0;
$bankcreditsum = 0;
    @endphp

                        @foreach($data as $r)
                            @php

                           

                            $r=(object) $r;
$i++;




$creditsum+= $r->credit;
$cashcreditsum+= $r->cashcredit;
$cheaquecreditsum+= $r->cheaquecredit;
$cardcreditsum+= $r->cardcredit;
$bankcreditsum+= $r->bankcredit;
                            @endphp
                           

                             
                            
                          @endforeach
                           <tr>
                                <td>1</td>
                                <td>{{$cashcreditsum}}</td>
                                <td>{{$cheaquecreditsum}}</td>
                                <td>{{$cardcreditsum}}</td>
                                <td>{{$bankcreditsum}}</td>
                                 <td>{{$creditsum}}</td>    
                            </tr>

                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>


<br><br>
            <div class="header"><b>DETAILS</b></div>
            <div id="London2" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable2" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th style="cursor: pointer;" class="wd-10p">Start Date</th>
                            <th style="cursor: pointer;" class="wd-10p">End Date</th>
                            <th class="wd-10p">Type</th>
                           
                            <th class="wd-5p">Debit</th>
                            <th class="wd-5p">Credit</th>
                            <th class="wd-5p">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                           

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;
    @endphp
                        @foreach($data as $r)
                            @php
                            $r=(object) $r;
$i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{formatDateToShow($r->dateS)}}</td>
                                <td>{{formatDateToShow($r->dateE)}}</td>
                                <td>{{$r->Mtype}}</td>
                                
                                 <td>{{$r->debit}}</td>
                                <td class="credit">{{($r->credit)}}</td>
                                <td class="balance">{{$total=$total-$r->credit+$r->debit}}</td>
                
                            </tr>
                          @endforeach

 <tr style="background-color: #55bff9;">
    <td colspan="6" class="text-right">Total Balance:</td>
    <td colspan="1"  class="text-left balance">{{isset($totalBalance)?$totalBalance:0}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>
  
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')



<script>
        function loadBalance(a) {
            $('#usersTable1 tbody').find('tr').each(function () {

                let credit = $(this).find('.credit').html();
                let debit = $(this).find('.debit').html();
                let balance = $(this).prev('tr').find('.balance').html();
                if (a) {
                    balance = a;
                }
                if (balance == undefined) {

                console.log($('.totalBalance').length>0)
                    balance = 0;
                    if($('.totalBalance').length>0) balance=$('.totalBalance').html();
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

            odata = $('#usersTable1').dataTable({
                "order": [[1, "asc"]],
                "pageLength": 100,
                fixedColumns: true,
                columns: [
                    {width: '2%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '10%'},
                    {width: '5%'},
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
            $('#usersTable1').on('page.dt', function (a, b, c) {

            });

        });
        $(document).ready(function () {
            $('.select2').select2({theme: 'bootstrap'});
        });
    </script>



    <script>
        function loadBalance(a) {
            $('#usersTable2 tbody').find('tr').each(function () {

                let credit = $(this).find('.credit').html();
                let debit = $(this).find('.debit').html();
                let balance = $(this).prev('tr').find('.balance').html();
                if (a) {
                    balance = a;
                }
                if (balance == undefined) {

                console.log($('.totalBalance').length>0)
                    balance = 0;
                    if($('.totalBalance').length>0) balance=$('.totalBalance').html();
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

            odata = $('#usersTable2').dataTable({
                "order": [[1, "asc"]],
                "pageLength": 100,
                fixedColumns: true,
                columns: [
                    {width: '2%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '10%'},
                    {width: '5%'},
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
            $('#usersTable2').on('page.dt', function (a, b, c) {

            });

        });
        $(document).ready(function () {
            $('.select2').select2({theme: 'bootstrap'});
        });
    </script>



     <script>
        function loadBalance(a) {
            $('#usersTable3 tbody').find('tr').each(function () {

                let credit = $(this).find('.credit').html();
                let debit = $(this).find('.debit').html();
                let balance = $(this).prev('tr').find('.balance').html();
                if (a) {
                    balance = a;
                }
                if (balance == undefined) {

                console.log($('.totalBalance').length>0)
                    balance = 0;
                    if($('.totalBalance').length>0) balance=$('.totalBalance').html();
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

            odata = $('#usersTable3').dataTable({
                "order": [[1, "asc"]],
                "pageLength": 100,
                fixedColumns: true,
                columns: [
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
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
            $('#usersTable3').on('page.dt', function (a, b, c) {

            });

        });
        $(document).ready(function () {
            $('.select2').select2({theme: 'bootstrap'});
        });
    </script>



    <script>
        function loadBalance(a) {
            $('#usersTable4 tbody').find('tr').each(function () {

                let credit = $(this).find('.credit').html();
                let debit = $(this).find('.debit').html();
                let balance = $(this).prev('tr').find('.balance').html();
                if (a) {
                    balance = a;
                }
                if (balance == undefined) {

                console.log($('.totalBalance').length>0)
                    balance = 0;
                    if($('.totalBalance').length>0) balance=$('.totalBalance').html();
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

            odata = $('#usersTable4').dataTable({
                "order": [[1, "asc"]],
                "pageLength": 100,
                fixedColumns: true,
                columns: [
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
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
            $('#usersTable4').on('page.dt', function (a, b, c) {

            });

        });
        $(document).ready(function () {
            $('.select2').select2({theme: 'bootstrap'});
        });
    </script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

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
