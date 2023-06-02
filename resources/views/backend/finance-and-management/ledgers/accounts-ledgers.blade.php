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
        .colors-0{
            background: #00800059;
        }
        .colors-1{
            background: #f5000036;
        }

    </style>

    <div class="br-pagebody">
        <div>
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">
          Accounts Ledgers</h6>
            <div style="text-align: right;">
                <a href="{{url()->current()}}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page"
                         height="28" width="28"
                         border="0/">
                </a>
            </div>

                <ul class="breadcrumbee border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
                    <li><a href="{{ url('finance-and-management/chart-of-accounts') }}">Chart of Accounts</a></li>
                    <li><a href>Accounts Ledgers</a></li>
                </ul>



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
                                     <div class="col-sm-6 mt-2">
                                         <label class="rdiobox">
                                             <input type="radio" name="mog" value="0"><span class="pabs">All</span>
                                         </label>
                                     </div>
                                     @foreach($types as $type)
 @if($type->status==1)
  <div class="col-sm-6 mt-2">
                                    <label class="rdiobox">
                                        <input type="radio" name="mog" value="{{$type->id}}" @if(request('mog')==$type->id) checked="checked" @endif><span class="pabs">{{$type->type}}</span>
                                    </label>
                                </div>
                         @endif
                                         @endforeach

                            </div>

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

{{--                           <div class="col-lg">--}}
{{--                            <div>--}}
{{--                                <p style="color: black;">Booking No.</p>--}}
{{--                                <input class=" form-control tablikebutton" size="20" type="number" id="booking_search"--}}
{{--                                       value="{{$booking_no}}" name="booking_no" placeholder="Search Id...">--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                        <div class="col-lg">--}}
{{--                            <div>--}}
{{--                                <p style="color: black;">Receipt No.</p>--}}
{{--                                <input value="{{$receipt}}" class=" form-control tablikebutton" size="20" type="number"--}}
{{--                                       id="receipt_search"--}}
{{--                                       name="receipt" placeholder="Search Id...">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-lg">
                            <div>
                                <p style="color: black;">Filter:</p>
                                <select class="form-control" name="filter">
                                    <option value="0">All</option>
                             @foreach($ty as $key=> $t)
                                    <option value="{{$key}}" @if(request('filter')==$key)) selected="selected" @endif>{{$t[0]}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg">
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

            <br><br><br><br>
            @php
                $total=0;
                $total2=isset($opening)?$opening:0;
                $debit=0;
                $credit=0;
            @endphp
@if(count($data)>0)
            <div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Credit: <span class="creditT"></span>
                    </button>
                </div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Debit: <span class="debitT"></span>
                    </button>
                </div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Balance: <span class="balanceT"></span>
                    </button>
                </div>

            </div>


            <div id="London" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th style="cursor: pointer;" class="wd-10p">Date</th>
{{--                            <th class="wd-5p">ID</th>--}}
                            <th class="wd-10p">Name</th>
                            <th class="wd-10p">M/G Type</th>
                            <th class="wd-10p">M/G ID</th>
                            <th class="wd-15p">Detail</th>
                            <th class="wd-10p">Accounts Type</th>
                            <th class="wd-10p">Debit</th>
                            <th class="wd-10p">Credit</th>
                            <th class="wd-10p">Balance</th>
                            <th class="wd-10p">Total Balance</th>

                        </tr>
                        </thead>
                        <tbody>
<tr style="background-color: #55bff9;">
    <td colspan="5" class="text-right"></td>
<td></td>
    <td colspan="4" class="text-right">Opening Balance:</td>

    <td colspan="1" title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($opening);
                                @endphp" class="text-left balance">{{isset($opening)?number_format($opening):0}}</td>
</tr>


                        @foreach($data as $key=>$r)

@php

$r=(object) $r;

if($r->debit_or_credit==0){
        $r->debit=$r->trans_amount;
        $debit=$debit+$r->debit;
        $r->credit=0;
        $cm=\App\trans_relations::select('invoice')->whereIn('receipt',\App\transactions::where('receipt_id',$r->receipt_id)->where('trans_amount',$r->trans_amount)->has('type')->get()->pluck('id'));
               $details= \App\transactions::with('type')->whereIn('id',$cm)->get()->toArray();

    }
    else{
           $r->credit=$r->trans_amount;
                   $credit=$credit+$r->credit;
                   $cm=\App\trans_relations::select('receipt')->whereIn('invoice',\App\transactions::where('receipt_id',$r->receipt_id)->has('type')->get()->pluck('id'));
               $details= \App\transactions::with('type')->whereIn('id',$cm)->get()->toArray();

        $r->debit=0;
       $details= \App\transactions::whereIn('id',$r->relate_receipt)->get();


    }
    foreach($details as $dm){

    }
//dd($details);
$c=\App\trans_type::select('id','name','details')->get()->keyBy('id')->toArray();

@endphp
                            <tr class="colors-{{$r->debit_or_credit}}">

                                <td>{{$key+1}}</td>
                                <td>{{formatDateToShow($r->date)}}</td>
{{--                                <td>@if($r->debit_or_credit==1){{$r->trans_type_id}} @elseif($r->debit_or_credit==0) {{$r->receipt_id}} @endif</td>--}}
                                <td>{{$r->name}}</td>
                                <td><span class="text-success">({{$r->u_type}})</span></td>
                                <td>{{$r->trans_moc}}</td>
                                <td>
                                    @if(false)
                                        <a target="_blank" href="{{route($c[$r->trans_type]['details'],$r->trans_type_id)}}">({{$c[$r->trans_type]['name']}} - {{$c[$r->trans_type]['id']}})</a>

                                        @else

                                     <!--  -->
                                        
                                          <a target="_blank" href="#">({{$r->receipt_id}})</a>
                                          

                                      <br>  @foreach($details as $dc)
                                                <a target="_blank" href="{{($dc['type']['details'].$dc['details']['id'])}}"> {{$dc['type']['name']}} {{$dc['details']['id']}}</a> <br>
                                          @endforeach
                                    @endif
                                </td>
                                <td>{{$r->accounts['type']}}</td>



                                <td title="@php
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->debit);
                                @endphp">{{$r->debit}}</td>
                                <td title="@php
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->credit);
                                @endphp" class="credit">{{($r->credit)}}</td>
                                <td title="@php
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($total-$r->credit+$r->debit);
                                @endphp" class="balance">{{$total=$total-$r->credit+$r->debit}}</td>
                                <td title="@php
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($total2-$r->credit+$r->debit);
                                @endphp" class="balance2">{{$total2=$total2-$r->credit+$r->debit}}</td>

                            </tr>
                          @endforeach
<tr style="background-color: #55bff9;">
    <td colspan="5" class="text-right"></td>
    <td></td>
    <td colspan="4" class="text-right">Closing Balance:</td>
    <td colspan="1" title="@php
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($opening+$total);
                                @endphp" class="text-left balance">{{isset($opening)?number_format($opening+$total):0}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>
@endif

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
        $('.creditT').html('{{number_format($credit)}}');
        $('.debitT').html('{{number_format($debit)}}');
        $('.balanceT').html('{{number_format($debit-$credit)}}');
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
                             document.getElementById('customer_search').value = obj.first_name+' '+obj.middle_name+' '+obj.applicant_name;
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
