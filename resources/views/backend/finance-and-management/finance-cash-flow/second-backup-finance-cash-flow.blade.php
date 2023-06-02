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
        <div>
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
    <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
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
                                <input value="{{$start_date}}" class="form-control tablikebutton" type="text" autocomplete="off" placeholder="dd/mm/yyyy" 
                                       id="start_date"
                                       name="start_date">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div>
                                <p style="color: black;">End Date:</p>
                                <input value="{{$end_date}}" class="form-control tablikebutton" type="text" autocomplete="off" placeholder="dd/mm/yyyy" 
                             id="end_date" name="end_date">
                            </div>
                        </div>

               
                        <div class="col-lg-2">
                            <button style="    margin-top: 34px;" type="submit" id="searchbtn" class="btn btn-info"><i
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

$qnt_one = 0;
$qnt_two = 0;
$qnt_invoice_one = 0;
$qnt_invoice_two = 0;
$qnt_bills = 0;
$qnt_ent = 0;
$qnt_invoice_sub_one = 0;

$debit_one = 0;
$debit_two = 0;
$invoice_db_one = 0;
$invoice_db_two = 0;
$invoice_db_sub_one = 0;

$credit_one = 0;
$credit_two = 0;
    @endphp

                        @foreach($data as $r)
                            @php

                           

                            $r=(object) $r;
$i++;




$qnt_one+= $r->qnt_one;
$qnt_two+= $r->qnt_two;
$qnt_invoice_one+= $r->qnt_invoice_one;
$qnt_invoice_two+= $r->qnt_invoice_two;
$qnt_invoice_sub_one+= $r->qnt_invoice_sub_one;
$qnt_bills+= $r->qnt_bills;
$qnt_ent+= $r->qnt_ent;

$debit_one+= $r->debit_one;
$debit_two+= $r->debit_two;
$invoice_db_one+= $r->invoice_db_one;
$invoice_db_two+= $r->invoice_db_two;
$invoice_db_sub_one+= $r->invoice_db_sub_one;

$credit_one+= $r->credit_one;
$credit_two+= $r->credit_two;
                            @endphp
                           

                             
                            
                          @endforeach
                           <tr>
                                <td>1</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
@php
$receivable = 0;
@endphp
                                 @foreach($receipt_one_b as $r)
                            @php
   $r=(object) $r;
$receivable= $r->receivable;
                            @endphp     

 
                          @endforeach 


 <td>{{paymentreceivedfor($receivable)}} Receipts</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($qnt_one);
                                @endphp">{{$qnt_one}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debit_one);
                                @endphp">{{$debit_one}}</td>
                                <td>0</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debit_one);
                                @endphp">{{$debit_one}}</td>
                
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
@php
$receivable = 0;
@endphp
                    @foreach($receipt_two_b as $r)
                            @php
   $r=(object) $r;
$receivable= $r->receivable;
                            @endphp     

 
                          @endforeach 
 <td>{{paymentreceivedfor($receivable)}} Receipts</td>

                            
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($qnt_two);
                                @endphp">{{$qnt_two}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debit_two);
                                @endphp">{{$debit_two}}</td>
                                <td>0</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum=$debit_one+$debit_two);
                                @endphp">{{$debitsum=$debit_one+$debit_two}}</td>
                                
                            </tr>
                           <!--   <tr>
                                <td>3</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
                                <td>Membership Invoices</td>
                                <td>{{$qnt_invoice_one}}</td>
                                 <td>{{$invoice_db_one}}</td>
                                <td>0</td>
                                <td>{{$debitsum+$invoice_db_one}}</td>
                
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
                                <td>Maintenance Invoices</td>
                                <td>{{$qnt_invoice_two}}</td>
                                 <td>{{$invoice_db_two}}</td>
                                <td>0</td>
                                <td>{{$debitsum+$invoice_db_one+$invoice_db_two}}</td>
                
                            </tr>
                             <tr>
                                <td>5</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
                                <td>Subscription Invoices</td>
                                <td>{{$qnt_invoice_sub_one}}</td>
                                 <td>{{$invoice_db_sub_one}}</td>
                                <td>0</td>
                                <td>{{$temp=$debitsum+$invoice_db_one+$invoice_db_two+$invoice_db_sub_one}}</td>
                
                            </tr> -->
<tr>
                                <td>3</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
@php
$payable = 0;
@endphp
                    @foreach($bills_expenses_b as $r)
                            @php
   $r=(object) $r;
$payable= $r->payable;
                            @endphp     

 
                          @endforeach 
 <td>{{expensepaidfor($payable)}} Expenses</td>

                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($qnt_bills);
                                @endphp">{{$qnt_bills}}</td>
                                 <td>0</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($credit_one);
                                @endphp">{{$credit_one}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum-$credit_one);
                                @endphp">{{$debitsum-$credit_one}}</td>                
                            </tr>
<tr>
                                <td>4</td>
                                <td>{{$start_date}}</td>
                                <td>{{$end_date}}</td>
@php
$payable = 0;
@endphp
                    @foreach($ent_expenses_b as $r)
                            @php
   $r=(object) $r;
$payable= $r->payable;
                            @endphp     

 
                          @endforeach 
 <td>{{expensepaidfor($payable)}} Expenses</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($qnt_ent);
                                @endphp">{{$qnt_ent}}</td>
                                 <td>0</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($credit_two);
                                @endphp">{{$credit_two}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum-$credit_one-$credit_two);
                                @endphp">{{$debitsum-$credit_one-$credit_two}}</td>
                            </tr>






 <tr style="background-color: #55bff9;">
    <td colspan="7" class="text-right">Total Balance:</td>
    <td colspan="1" id="mylabel"  class="text-left balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum-$credit_one-$credit_two);
                                @endphp">{{$debitsum-$credit_one-$credit_two}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>


<br><br>






     <div class="header"><b>PAYMENT MODE DETAILS</b></div>
            <div id="London2" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable2" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-10p">Type</th>
                            <th class="wd-10p">Cash</th>
                            <th class="wd-10p">Cheaque</th>
                            <th class="wd-10p">Credit Card</th>
                            <th class="wd-10p">Online Bank Transfer</th>
                            <th class="wd-10p">Total</th>
                        </tr>
                        </thead>
                        <tbody>


@php
$i=0;
$cashdebitsum = 0;
    @endphp
@foreach($cashdebit as $r)
                            @php
                            $r=(object) $r;
$i++;
$cashdebitsum+= $r->debit;
                            @endphp  
                          @endforeach  




@php
$i=0;
$cheaquedebitsum = 0;

    @endphp
 @foreach($cheaquedebit as $r)
                            @php
                            $r=(object) $r;
$i++;
$cheaquedebitsum+= $r->debit;
                            @endphp  
                          @endforeach 



@php
$i=0;
$carddebitsum = 0;

    @endphp
 @foreach($carddebit as $r)
                            @php
                            $r=(object) $r;
$i++;
$carddebitsum+= $r->debit;
                            @endphp  
                          @endforeach 



@php
$i=0;
$bankdebitsum = 0;

    @endphp
 @foreach($bankdebit as $r)
                            @php
                            $r=(object) $r;
$i++;
$bankdebitsum+= $r->debit;
                            @endphp  
                          @endforeach 


      @php
$i=0;
$debitsum = 0;
    @endphp

                        @foreach($data as $r)
                            @php
   $r=(object) $r;
$i++;
$debitsum+= $r->debit;
                            @endphp         
                          @endforeach



@php
$i=0;
$cashcreditsum = 0;

    @endphp
 @foreach($cashcredit as $r)
                            @php
                            $r=(object) $r;
$i++;
$cashcreditsum+= $r->credit;
                            @endphp  
                          @endforeach 

@php
$i=0;
$cardcreditsum = 0;

    @endphp
 @foreach($cardcredit as $r)
                            @php
                            $r=(object) $r;
$i++;
$cardcreditsum+= $r->credit;
                            @endphp  
                          @endforeach 



@php
$i=0;
$bankcreditsum = 0;

    @endphp
 @foreach($bankcredit as $r)
                            @php
                            $r=(object) $r;
$i++;
$bankcreditsum+= $r->credit;
                            @endphp  
                          @endforeach 


 @php
$i=0;
$creditsum = 0;
    @endphp

                        @foreach($data as $r)
                            @php
   $r=(object) $r;
$i++;
$creditsum+= $r->credit;
                            @endphp         
                          @endforeach  
                           <tr>
                                <td>1</td>
                                <td>Payment Receipts</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($cashdebitsum);
                                @endphp">{{$cashdebitsum}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($cheaquedebitsum);
                                @endphp">{{$cheaquedebitsum}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($carddebitsum);
                                @endphp">{{$carddebitsum}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($bankdebitsum);
                                @endphp">{{$bankdebitsum}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum);
                                @endphp">{{$debitsum}}</td>  
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Expenses</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($cashcreditsum);
                                @endphp">{{$cashcreditsum}}</td>
                                 <td>0</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($cardcreditsum);
                                @endphp">{{$cardcreditsum}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($bankcreditsum);
                                @endphp">{{$bankcreditsum}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($creditsum);
                                @endphp">{{$creditsum}}</td>    
                            </tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>


<br><br>
@php
$receivable = 0;
@endphp
                                 @foreach($receipt_one_b as $r)
                            @php
   $r=(object) $r;
$receivable= $r->receivable;
                            @endphp     

 
                          @endforeach 

 <div class="header text-uppercase"><b>{{paymentreceivedfor($receivable)}} Receipt Details</b></div>

            <div id="London3" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable3" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>

                              <th class="wd-10p">Receipt #</th>
                            <th style="cursor: pointer;" class="wd-10p">Receipt Date</th>
                        
                             <th class="wd-10p">M/G</th>

                              <th class="wd-10p">M/G #</th>
                               <th class="wd-10p">Name</th>
                                <th class="wd-10p">Address</th>
                                 <th class="wd-10p">Contact</th>

                                  <th class="wd-10p">Type</th>
                                   <th class="wd-10p">Details</th>
                            
                            <th class="wd-5p">Debit</th>
                            <th class="wd-5p">Balance</th>
                            <th class="wd-5p">Invoice</th>
                         
                        </tr>
                        </thead>
                        <tbody>
                           

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;
    @endphp
                        @foreach($receipt_one as $r)
                            @php
                            $r=(object) $r;
$i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->ReceiptNo);
                                @endphp">{{$r->ReceiptNo}}</td>
                                <td>{{formatDateToShow($r->dateS)}}</td>

                                <td>@if($r->Type==1){{"Guest"
                }}
                @else {{"Member"
                }} @endif</td>    

                
                                 <td> @if($r->Type==1)
                {{$r->MorGnumber
                }}
                 @else
                  {{$r->member?$r->member['mem_no']:''}}
                
               
                 @endif</td>
                                  <td>{{$r->Name}}</td>
                                   <td>{{$r->Address}}</td>
                                    <td>{{$r->Contact}}</td>

                                <td>{{paymentreceivedfor($r->receivable)}}</td>
                                    <td>{{$r->Details}}</td>

                                     <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->debit_one);
                                @endphp">{{$r->debit_one}}</td>

                                <td class="balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($total-$r->credit+$r->debit_one);
                                @endphp">{{$total=$total-$r->credit+$r->debit_one}}</td>

                                <td><button class="buttoncolor" title="Print Invoice">
<a href="{{ url('room-management/room-payment-receipts/room-payment-receipts-invoice') }}/{{ $r->id }}" target="_blank">
                                    <i class="fa fa-print" aria-hidden="true"></i>
</a>
                                </button></td>
                
                            </tr>
                          @endforeach

 <tr style="background-color: #55bff9;">
    <td colspan="11" class="text-right">Total Balance:</td>
    <td colspan="2"  class="text-left balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum);
                                @endphp">{{$debitsum}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>
<br><br>





@php
$receivable = 0;
@endphp
                                 @foreach($receipt_two_b as $r)
                            @php
   $r=(object) $r;
$receivable= $r->receivable;
                            @endphp     

 
                          @endforeach 

 <div class="header text-uppercase"><b>{{paymentreceivedfor($receivable)}} Receipt Details</b></div>

            <div id="London4" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable4" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>

                              <th class="wd-10p">Receipt #</th>
                            <th style="cursor: pointer;" class="wd-10p">Receipt Date</th>
                        
                             <th class="wd-10p">M/G</th>

                              <th class="wd-10p">M/G #</th>
                               <th class="wd-10p">Name</th>
                                <th class="wd-10p">Address</th>
                                 <th class="wd-10p">Contact</th>

                                  <th class="wd-10p">Type</th>
                                   <th class="wd-10p">Details</th>
                            
                            <th class="wd-5p">Debit</th>
                            <th class="wd-5p">Balance</th>
                            <th class="wd-5p">Invoice</th>
                        </tr>
                        </thead>
                                     <tbody>
                           

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;
    @endphp
                        @foreach($receipt_two as $r)
                            @php
                            $r=(object) $r;
$i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->ReceiptNo);
                                @endphp">{{$r->ReceiptNo}}</td>
                                <td>{{formatDateToShow($r->dateS)}}</td>

                                <td>@if($r->Type==1){{"Guest" }}
                @else {{"Member"
                }} @endif</td>    

                
                                 <td>

                                  @if($r->Type==1)
                {{$r->MorGnumber}}
                @else 
                  {{$r->member?$r->member['mem_no']:''}}
                 @endif</td>
                                  <td>{{$r->Name}}</td>
                                   <td>{{$r->Address}}</td>
                                    <td>{{$r->Contact}}</td>
                                <td>{{paymentreceivedfor($r->receivable)}}</td>
                                    <td>{{$r->Details}}</td>
                                    <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->debit_two);
                                @endphp">{{$r->debit_two}}</td>

  <td class="balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($total-$r->credit+$r->debit_two);
                                @endphp">{{$total=$total-$r->credit+$r->debit_two}}</td>
                
                                <td><button class="buttoncolor" title="Print Invoice">
<a href="{{ url('room-management/room-payment-receipts/room-payment-receipts-invoice') }}/{{ $r->id }}" target="_blank">
                                    <i class="fa fa-print" aria-hidden="true"></i>
</a>
                                </button></td>
                              
                            </tr>
                          @endforeach

 <tr style="background-color: #55bff9;">
    <td colspan="11" class="text-right">Total Balance:</td>
    <td colspan="2"  class="text-left balance"  title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($debitsum);
                                @endphp">{{$debitsum}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>



<br><br>
@php
$payable = 0;
@endphp
                    @foreach($bills_expenses_b as $r)
                            @php
   $r=(object) $r;
$payable= $r->payable;
                            @endphp     

 
                          @endforeach 
<div class="header text-uppercase"><b>{{expensepaidfor($payable)}} Expense Details</b></div>
            <div id="London5" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable5" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-10p">Voucher #</th>
                            <th style="cursor: pointer;" class="wd-10p">Voucher Date</th>
                            <th class="wd-5p">Person #</th>
                              <th class="wd-10p">Name</th>
                                <th class="wd-10p">Address</th>
                                <th class="wd-10p">Contact</th>
                                <th class="wd-10p">Type</th>
                                 <th class="wd-10p">Details</th>
                            <th class="wd-5p">Credit</th>
                            <th class="wd-5p">Balance</th>
                             <th class="wd-5p">Voucher</th>
                        </tr>
                        </thead>
                        <tbody>
                           

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;
    @endphp
                        @foreach($bills_expenses as $r)
                            @php
                            $r=(object) $r;
$i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                 <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->VoucherNo);
                                @endphp">{{$r->VoucherNo}}</td>
                                <td>{{formatDateToShow($r->dateS)}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->PersonNo);
                                @endphp">{{$r->PersonNo}}</td>
                                 <td>{{$r->PersonName}}</td>
                                  <td>{{$r->PersonAddress}}</td>
                                   <td>{{$r->PersonContact}}</td>
                                    <td>{{expensepaidfor($r->payable)}}</td>
                                    <td>{{$r->ExpenseDetails}}</td>
                                     <td class="credit" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->credit_one);
                                @endphp">{{$r->credit_one}}</td>
                         <td class="balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($total-$r->credit_one+$r->debit);
                                @endphp">{{$total=$total-$r->credit_one+$r->debit}}</td>
                                <td><button class="buttoncolor" title="Print Invoice">
<a href="{{ url('finance-and-management/finance-expenses/finance-expenses-invoice') }}/{{ $r->id }}" target="_blank">
                                    <i class="fa fa-print" aria-hidden="true"></i>
</a>
                                </button></td>
                               
                            </tr>
                          @endforeach

 <tr style="background-color: #55bff9;">
    <td colspan="10" class="text-right">Total Balance:</td>
    <td colspan="2"  class="text-left balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format(-$creditsum);
                                @endphp">-{{$creditsum}}</td>
</tr>
                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>
  <br><br>

@php
$payable = 0;
@endphp
                    @foreach($ent_expenses_b as $r)
                            @php
   $r=(object) $r;
$payable= $r->payable;
                            @endphp     

 
                          @endforeach 
<div class="header text-uppercase"><b>{{expensepaidfor($payable)}} Expense Details</b></div>

            <div id="London6" class="w3-container w3-border city">
                <br>
                <div class="table-wrapper">
                    <table id="usersTable6" class="table display nowrap">

                        <thead>
                        <tr>
                             <th class="wd-5p">Sr #</th>
                            <th class="wd-10p">Voucher #</th>
                            <th style="cursor: pointer;" class="wd-10p">Voucher Date</th>
                           
                            <th class="wd-5p">Person #</th>
                              <th class="wd-10p">Name</th>
                                <th class="wd-10p">Address</th>
                                <th class="wd-10p">Contact</th>
                                <th class="wd-10p">Type</th>
                                 <th class="wd-10p">Details</th>
                            <th class="wd-5p">Credit</th>
                            <th class="wd-5p">Balance</th>
                             <th class="wd-5p">Voucher</th>
                        </tr>
                        </thead>
                        <tbody>
                           

@php
    $total=isset($openingBalance)?$openingBalance:0;
$i=0;
    @endphp
                        @foreach($ent_expenses as $r)
                            @php
                            $r=(object) $r;
$i++;
                            @endphp
                             <tr>
                                <td>{{$i}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->VoucherNo);
                                @endphp">{{$r->VoucherNo}}</td>
                                <td>{{formatDateToShow($r->dateS)}}</td>
                                <td title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($r->PersonNo);
                                @endphp">{{$r->PersonNo}}</td>
                                 <td>{{$r->PersonName}}</td>
                                  <td>{{$r->PersonAddress}}</td>
                                   <td>{{$r->PersonContact}}</td>
                                    <td>{{expensepaidfor($r->payable)}}</td>
                                    <td>{{$r->ExpenseDetails}}</td>
                                <td class="credit" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($credit_two);
                                @endphp">{{($r->credit_two)}}</td>
                                 <td class="balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($total-$r->credit_two+$r->debit);
                                @endphp">{{$total=$total-$r->credit_two+$r->debit}}</td>
                                <td><button class="buttoncolor" title="Print Invoice">
<a href="{{ url('finance-and-management/finance-expenses/finance-expenses-invoice') }}/{{ $r->id }}" target="_blank">
                                    <i class="fa fa-print" aria-hidden="true"></i>
</a>
                                </button></td>
                            </tr>
                          @endforeach

 <tr style="background-color: #55bff9;">
    <td colspan="10" class="text-right">Total Balance:</td>
    <td colspan="2"  class="text-left balance" title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format(-$creditsum);
                                @endphp">-{{$creditsum}}</td>
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
                    {width: '2%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '10%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '5%'},
                    {width: '2%'},
                    {width: '5%'},
                   
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
