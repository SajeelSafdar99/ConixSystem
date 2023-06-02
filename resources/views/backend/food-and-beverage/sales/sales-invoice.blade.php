@extends('backend.layout.app')
@section('page-content')
<?php
use App\User;

$user = auth()->user();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style type="text/css">
        * {
            font-size: 12px !important;
            font-family: 'Times New Roman' !important;
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

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }

            p.border {
                border: 1px solid #e9ecef !important;
            }

            p.border-dark {
                border-color: #343a40 !important;
            }

            hr {
                display: block;
                height: 1px;
                background: transparent;
                width: 100%;
                border: none;
                border-top: solid 1px #000000;
            }

            tr.mytrstyle {
                border-bottom: 1px solid #000000 !important;
            }

            tr.tabletitleborder {
                border-top: 1px solid #000000 !important;
            }

            table.myFormat tr td {
                font-size: 12px !important;
            }

            table.myFormat tr td strong {
                font-size: 12px !important;
            }

            td.tdformatter {
                font-size: 7px !important;
            }


            p.border {
                font-size: 20px !important;
                border-color: #000000 !important;
            }


            p.bordered {
                font-size: 16px !important;
                border-color: #000000 !important;
            }

            #as123 {
                max-width: 80mm !important;
                height: auto !important;
                margin: none;

                font-size: 40px;

                background: #FFF;
                box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                /* border: 1px solid #ccc; */
                /* padding: 10px 11px; */

            }
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5) !important;
            padding: 2mm !important;
            margin: 0 auto !important;
            width: 65mm !important;
            background: #FFF !important;


            ::selection {
                background: #f31544 !important;
                color: #FFF !important;
            }

            ::moz-selection {
                background: #f31544 !important;
                color: #FFF !important;
            }

            h1 {
                font-size: 1.5em !important;
                color: #222 !important;
            }

            h2 {
                font-size: .9em !important;
            }

            h3 {
                font-size: 1.2em !important;
                font-weight: 300 !important;
                line-height: 2em !important;
            }

            p {
                font-size: .7em !important;
                color: #666 !important;
                line-height: 1.2em !important;
            }

            #top,
            #mid,
            #bot {
                /* Targets all id with 'col-' */
                border-bottom: 1px solid #EEE !important;
            }

            #top {
                min-height: 100px;
            }

            #mid {
                min-height: 80px;
            }

            #bot {
                min-height: 50px;
            }

            #top .logo {
                //float: left !important;


                background: url(//michaeltruong.ca/images/logo1.png) no-repeat !important;
                background-size: 60px 60px !important;
            }

            .clientlogo {
                float: left !important;

                background: url(//michaeltruong.ca/images/client.jpg) no-repeat !important;
                background-size: 60px 60px !important;
                border-radius: 50px !important;
            }

            .info {
                display: block !important;
                //float:left !important;
                margin-left: 0 !important;
            }

            .title {
                float: right !important;
            }

            .title p {
                text-align: right !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            td {
                //padding: 5px 0 5px 15px !important;
                //border: 1px solid #EEE !important;
            }


            .tabletitle {

                background: #EEE !important;
            }

            .service {
                border-bottom: 1px solid #EEE !important;
            }

            .item {
                width: 24mm !important;
            }

            .itemtext {
                font-size: .5em !important;
            }

            #legalcopy {
                margin-top: 5mm !important;
            }





        }

        hr {
            display: block;
            height: 1px;
            background: transparent;
            width: 100%;
            border: none;
            border-top: solid 1px #000000;
        }


        p.border {
            font-size: 20px !important;
            border-color: #000000 !important;
        }


        p.bordered {
            font-size: 16px !important;
            border-color: #000000 !important;
        }

    </style>

</head>
<div class="br-pagebody">
    <div>

        <!--   <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print">Invoice</h6>

         <div style="text-align: right;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div> -->
        <!--

<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
   <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/sales-list-vue') }}">Sales List</a></li>
  <li><a href>Print Invoice</a></li>
</ul> -->

        <style>
            #as123 {
                max-width: 80mm !important;
                height: auto !important;
                margin: 0 auto;
                font-size: 40px;

                background: #FFF;
                box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                /* border: 1px solid #ccc; */
                /* padding: 10px 11px; */

            }

        </style>
    </div>
</div>

<div id="as123">

    <center id="top" style="color: black !important;">
        <div class="info">
            <img src="{{ url($profiledata->company_logo) }}"><br><br>
            {{$profiledata->company_address}} <br>
            <strong>Phone:</strong>{{$profiledata->company_number}}

            <hr>
        </div>
        <!--End Info-->
        <h2>
            <p class="border border-dark">
                INVOICE</p>
        </h2>


    </center>
    <!--End InvoiceTop-->

    <div id="mid" style="color: black !important;">
        <div class="info">
            <div class="float-left"><strong>INVOICE #:</strong>&nbsp&nbsp{{$saledata->invoice_no}}</div>
            <div class="float-right"><strong>TABLE #:</strong>&nbsp&nbsp{{salestablename($saledata->table_definition)}}</div>
            <br>
            <div class="float-left"><strong>DATE:</strong>&nbsp&nbsp<b>{{formatDateToShow($saledata->date)}}</b></div>


            <br>


            <div class="float-left"><strong>START TIME:</strong>&nbsp&nbsp<b>{{salesformatTime($saledata->time)}}</b></div>
            <div class="float-right"><strong>END TIME:</strong>&nbsp&nbsp<b>{{salesformatTime($saledata->generated_at)}}</b></div>
            <br>

            <div class="float-left"><strong>KOTS:</strong>&nbsp @foreach($kots as $kot) {{$kot}}, @endforeach</div>

            <br>
            <br>


            <div class="float-left"><strong>CAPTAIN:</strong>&nbsp {{saleswaitername($saledata->waiter_definition)}}</div>

            <div class="float-right"><strong>COVERS:</strong>&nbsp&nbsp{{$saledata->covers}}</div>

            <br>
            <div class="float-left"><strong>RESTAURANT:</strong>&nbsp {{salesrestaurantname($saledata->restaurant_location)}}</div>
            <br>
            <br>
            <div class="float-left"><strong>NAME:</strong>&nbsp&nbsp @if($saledata->type==1 && $saledata->customer) {{$saledata->customer->customer_name}} ({{$saledata->customer_id}}) @elseif($saledata->type==3 && $saledata->employees) {{$saledata->employees->name}} ({{$saledata->customer_id}}) @elseif($saledata->type==0 && $saledata->member) {{$saledata->member->title}} {{$saledata->member->first_name}} {{$saledata->member->middle_name}} {{$saledata->member->applicant_name}} ({{$saledata->member->mem_no}}) @elseif($saledata->type==6 && $saledata->corporateMember) {{$saledata->corporateMember->title}} {{$saledata->corporateMember->first_name}} {{$saledata->corporateMember->middle_name}} {{$saledata->corporateMember->applicant_name}} ({{$saledata->corporateMember->mem_no}}) @else {{$saledata->name}} @endif</div>
            <br>
            @if(count($temp_name) > 0)
                <div class="float-left"><strong>PERSON NAME:</strong>&nbsp&nbsp {{$temp_name[0]}}</div>
                <br>
            @endif
            <div class="float-left"><strong>TYPE:</strong>&nbsp @if($saledata->type==1 && $saledata->customer && $saledata->customer->guest_type==1) Applied Member @elseif($saledata->type==1 && $saledata->customer && $saledata->customer->guest_type==2) Affiliated Member @elseif($saledata->type==0) Member @elseif($saledata->type==6) Corporate Member @elseif($saledata->type==3)Employee @else Guest @endif</div>


            @if($saledata->family && $saledata->type==0 && $saledata->member)
            <br>

            <div class="float-left"><strong>FAMILY:</strong>&nbsp&nbsp{{invoicesfamilyname($saledata->family)}}</div>

            @elseif($saledata->family && $saledata->type==6 && $saledata->corporateMember)
            <br>

            <div class="float-left"><strong>FAMILY:</strong>&nbsp&nbsp{{copinvoicesfamilyname($saledata->family)}}</div>
            @endif
            <br>
            <hr>
        </div>
    </div>
    <!--End Invoice Mid-->


    <div id="bot" style="color: black !important;">

        <div id="table">
            <table class="myFormat" width="100%">
                <tr class="mytrstyle">
                    <td style="border-bottom: 1px solid #000000;"><strong>S#</strong></td>
                    <td colspan="2" style="border-bottom: 1px solid #000000;"><strong>ITEMS</strong></td>
                    <td class="text-right" style="border-bottom: 1px solid #000000;"> <strong>QTY</strong></td>
                    <td class="text-right" style="border-bottom: 1px solid #000000;"><strong>RATE</strong></td>
                    <td class="text-right" style="border-bottom: 1px solid #000000;"><strong>AMT</strong></td>
                </tr>

                <tr>
                    @php $divide=1; @endphp
                    @foreach($salesubdata as $sub)

                <tr>
                    <td class="left">{{$divide}}</td>
                    <!-- <td colspan="2" style="font-size: 10px !important;" class=" left"><?php echo " " . wordwrap($sub->item_details, 30, '<br>') . '<br>';?></td> -->
                    <td colspan="2" style="font-size: 10px !important;" class=" left">{{$sub->item_details}}</td>
                    <td class="text-right">{{round($sub->qty,2)}}</td>
                    <td class="text-right">{{$sub->sale_price}}</td>
                    <td class="text-right">{{$sub->sub_total_price}}</td>
                </tr>
                @php $divide++; @endphp

                @endforeach
                </tr>

                <tr class="tabletitleborder tabletitle">


                    <td class="text-right" colspan="4" style="border-top: 1px solid #000000;"> <strong>GROSS :</strong></td>
                    <td></td>

                    <td class="text-right" colspan="2" style="border-top: 1px solid #000000;"> <strong>@if($saledata->gross)

                            {{ $saledata->gross }} @else 0
                            @endif</strong></td>
                </tr>


                @if($saledata->discount==!NULL)
                <tr class="tabletitle">

                    <td class="text-right" colspan="4"><strong>DISCOUNT :</strong>
                        @if($saledata->disc_pc==!NULL)({{$saledata->disc_pc}}%)@endif</td>

                    <td></td>

                    <td class="text-right" colspan="2"> {{ $saledata->discount }}</td>
                </tr>
                @endif

                @if($saledata->discount==!NULL)
                <tr class="tabletitle">

                    <td class="text-right" colspan="4"> <strong>SUB TOTAL :</strong></td>

                    <td></td>

                    <td class="text-right" colspan="2">@if($saledata->sub_total)
                        {{ $saledata->sub_total }} @else 0
                        @endif</td>
                </tr>
                @endif


                <tr class="tabletitle">

                    <td class="text-right" colspan="4"><strong>TAX</strong> @if($saledata->tax==!NULL)({{round(($saledata->tax/$saledata->sub_total)*100)}}%)@endif :</td>

                    <td></td>

                    <td class="text-right" colspan="2">@if($saledata->tax==!NULL){{ $saledata->tax }} @else 0 @endif</td>
                </tr>

                @if($saledata->service_charges==!NULL)
                <tr class="tabletitle">

                    <td class="text-right" colspan="4"><strong>SERVICE :</strong></td>

                    <td></td>

                    <td class="text-right" colspan="2">{{ $saledata->service_charges }}</td>
                </tr>
                @endif

                @if($saledata->service_charges_pct==!NULL)
                <tr class="tabletitle">

                    <td class="text-right" colspan="4"><strong>SERVICE :</strong></td>

                    <td></td>

                    <td class="text-right" colspan="2">{{ $saledata->service_charges_pct }}%</td>
                </tr>
                @endif

                <tr class="tabletitle">

                    <td class="text-right" colspan="4"><strong>GRAND TOTAL :</strong></td>


                    <!--  <td></td>

                 -->
                    <td class="text-right" colspan="3"><strong>
                            <p class="bordered border border-dark"> &nbsp @if($saledata->grand_total) @if($currencies){{salescurrency($currencies->currency)}} &nbsp @endif {{round($saledata->grand_total)}} @else 0 @endif&nbsp</p>
                        </strong></td>

                </tr>

            </table>
        </div>
        <!--End Table-->


        <br>

        <div>
            <strong>Thank you for your visit!</strong> <br> <br>
            <div class="float-right text-uppercase"><u>@if($saledata->created_by){{usernames($saledata->created_by)}}@endif</u><br><strong>Cashier:</strong></div>
            <br><br>
        </div>


    </div>
    <!--End InvoiceBot-->
</div>
<!--End Invoice-->






@endsection

@push('jscode')

<script type="text/javascript">
    $(document).ready(function() {

        if ('{{$defaultprinter[0]}}') {


            //console.log('{{$defaultprinter}}');
            //console.log('{{$defaultprintqty}}');
            $.get(('{{url('/printerip')}}'), (a) => {
                let printer = "http://" + a + "/upload";
                let p = '{{$defaultprinter[0]}}';
                let ip = '';
                if ('{{$defaultprintqty[0]}}') {
                    ip = '{{$defaultprintqty[0]}}';
                } else {
                    ip = '2';
                }
                for (i = 0; i < ip; i++) {
                    $.get(printer+'?printer='+p+'&file='+encodeURI('{{url('/fb/sales/salesinv/'.$saledata->invoice_no.'?ttoken='.auth()->user()->id)}}'), (a) => {
                        console.log(a)
                    })
                }

            })
        }
    });

</script>

@endpush
