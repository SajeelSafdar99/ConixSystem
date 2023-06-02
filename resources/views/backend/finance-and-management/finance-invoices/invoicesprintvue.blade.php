@extends('backend.layout.app')
@section('page-content')

<head>
    <meta charset="utf-8">

<style type="text/css">
*{
    color: black ;
    font-size: 12px ;
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

b{ color: black; font-size: 18px !important;}
/* heading */

.boldee{
  font: 150% sans-serif !important;
}



p {  color: black !important;  font: 100% sans-serif !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */




h1 { font: bold 130% sans-serif !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; color: black !important; padding-top: 27px !important; }

header { margin: 0 0 3em; }
span {float:left !important; }


th, td {
  padding: 10px !important;
  text-align: left !important;
  font: 130% sans-serif !important;
  height: 50px
}
th {
  padding: 10px !important;
  text-align: left !important;
  background-color: white !important;
  color: black !important;
  font: 30% sans-serif !important;
  height: 70px
}

strong{
font: bold 100% sans-serif !important;
}

.thheighty{
  height: 150px !important;
}

.goleft{
  float: left !important;
}

.goleftopp{
  float: right !important;
}
 .middiv{
  text-align: center !important;
  margin-top: 38px !important;
 }

@page {
  size: A4;
  margin: 0;

}
@media print {
  html, body {
    width: 250mm;
    height: 200mm;
  }
}

.container{
  min-width: 100% !important;
  } .card{
  min-width: 100% !important;
}

.widthclass{
  width: 520px !important;
}
.widthclass2{
  width: 200px !important;
}

 table.myFormat tr td { font-size: 12px !important; }
 table.myFormat tr th { font-size: 11px !important; }
</style>

  </head>
<div class="br-pagebody"> 
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print margara">Invoices</h6>
       <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
   <li><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a></li>
  <li><a href="{{ url('finance-and-management/finance-new-invoices-vue') }}">Invoices List</a></li>
  <li><a href>Print Invoice</a></li>
</ul>
  <!--  $invoicesubs=(object) $v['invoicesubs'];
        $subdata=(object) $v['subdata']; -->

@foreach (array_except($s,['profiledata','bookingsubdata']) as $v)
    @php

        $member= $v['member'];
        $receiptdata= $v['receiptdata'];
        $resultant=$v['resultant'];
        $amount_paid=$v['amount_paid'];
         $storage= $v['storage'];
        $profiledata= $s['profiledata'];
      $bookingsubdata= $s['bookingsubdata'];

        @endphp



<div id="app">
    
        <invoicesprint :member="{{$member}}" :receiptdata="{{$receiptdata}}" :resultant="{{$resultant}}" :amount_paid="{{$amount_paid}}" :storage="{{$storage}}" :profiledata="{{$profiledata}}" :bookingsubdata="{{$bookingsubdata}}"></invoicesprint>
 
</div>
    

@endforeach




</div>
</div>

@endsection



@push('jscode')


@endpush
