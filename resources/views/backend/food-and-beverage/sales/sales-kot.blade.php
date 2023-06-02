@extends('backend.layout.app')
@section('page-content')

<head>
		<meta charset="utf-8">
<style type="text/css">
* {
    font-size: 14px !important;
    font-family: 'Times New Roman'!important;
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
   
     table.myFormat tr td { font-size: 14px !important; }
 table.myFormat tr td strong { font-size: 14px !important; }
  }

#invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5) !important;
  padding:2mm !important;
  margin: 0 auto !important;
  width: 65mm !important;
  background: #FFF !important;


::selection {background: #f31544 !important; color: #FFF !important;}
::moz-selection {background: #f31544 !important; color: #FFF !important;}
h1{
  font-size: 1.5em !important;
  color: #222 !important;
}
h2{font-size: .9em !important;}
h3{
  font-size: 1.2em !important;
  font-weight: 300 !important;
  line-height: 2em !important;
}
p{
  font-size: .7em !important;
  color: #666 !important;
  line-height: 1.2em !important;
}

#top, #mid,#bot{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE !important;
}

#top{min-height: 100px !important;}
#mid{min-height: 80px !important;}
#bot{ min-height: 50px !important;}

#top .logo{
  //float: left !important;
  height: 60px !important;
  width: 60px !important;
  background: url(//michaeltruong.ca/images/logo1.png) no-repeat !important;
  background-size: 60px 60px !important;
}
.clientlogo{
  float: left !important;
  height: 60px !important;
  width: 60px !important;
  background: url(//michaeltruong.ca/images/client.jpg) no-repeat !important;
  background-size: 60px 60px !important;
  border-radius: 50px !important;
}
.info{
  display: block !important;
  //float:left !important;
  margin-left: 0 !important;
}
.title{
  float: right !important;
}
.title p{text-align: right !important;}
table{
  width: 100% !important;
  border-collapse: collapse !important;
}
td{
  //padding: 5px 0 5px 15px !important;
  //border: 1px solid #EEE !important;
}
.tabletitle{
  //padding: 5px !important;
  /*font-size: .5em !important;
  background: #EEE !important;*/
}
.service{border-bottom: 1px solid #EEE !important;}
.item{width: 24mm !important;}
.itemtext{font-size: .5em !important;}

#legalcopy{
  margin-top: 5mm !important;
}



}

hr {
    display: block;
    height: 1px;
    background: transparent;
    width: 100%;
    border: none;
    border-top: solid 1px #aaa;
}

</style>

	</head>
<div class="br-pagebody">
        <div>

          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print">SALES KOT</h6>

         <div style="text-align: right;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
   <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/sales-list-vue') }}">Sales List</a></li>
  <li><a href>Print Sales KOT</a></li>
</ul>

<style>
    #as123{
       max-width: 80mm !important;
height:auto !important;
        margin: 0 auto;
        font-size: 35px;
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
      <div>
        <br> <br> 
         <!--
        <h2 class="text-uppercase">{{salesrestaurantname($saledata->restaurant_location)}}</h2>
 <br>
        <hr> -->
          </div><!--End Info-->
 <h4><u><b class="text-uppercase"> {{salesrestaurantname($saledata->restaurant_location)}} SLIP</b></u>
   <br> <br>
  <u><b class="text-uppercase"> {{$saledata->order_type}} </b></u>
</h4>

@if($running==1)<br>(RUNNING)
@elseif($duplicate==1)<br>(DUPLICATE)@endif

    </center><!--End InvoiceTop-->
    <br>
    <div id="mid" style="color: black !important;">
      <div class="info">

        <div class="float-left"><strong>DATE:</strong>&nbsp&nbsp{{formatDateToShow($saledata->date)}}</div>
       
       <!--  <div class="float-left"><strong>TIME:</strong>&nbsp&nbsp{{$saledata->time}}</div> -->
        <div class="float-right"><strong>TIME:</strong>&nbsp&nbsp{{salesformatTime($salesubdata[0]->created_at)}}</div> 
        <br>
         <div class="float-left"><strong>TABLE #:</strong>&nbsp&nbsp{{salestablename($saledata->table_definition)}}</div>
        <br>
       
         <div class="float-left"><strong>INVOICE #:</strong>&nbsp&nbsp{{$saledata->invoice_no}}</div>
         <div class="float-right"><strong>KOT:</strong>&nbsp&nbsp{{$salesubdata[0]->kot_no}}</div>
        
      </div>
    </div><!--End Invoice Mid-->
    <br><br>


    <div id="bot" style="color: black !important;">

          <div id="table" >
            <table width="100%" class="text-uppercase myFormat">
              <tr>
                <th width="10%"><strong>#</strong></th>
                <th width="50%"><strong>PRODUCT</strong></th>
                <th width="15%"><strong>QTY</strong></th>
                <th width="25%"><strong>REMARKS</strong></th>
              </tr>

              <tr>

                
      @php $divide=1; @endphp
  @foreach($salesubdata as $sub)
      @if(in_array($sub['item_code'],$itemCat))
<tr>
<td style="border-top: 1px solid #dee2e6;">{{$divide}}</td>
<td style="border-top: 1px solid #dee2e6;"><strong>@if($sub->status)<del>{{ $sub->item_details }}</del>@else {{ $sub->item_details }}@endif @if($sub->status)(@endif{{$sub->status}}@if($sub->status))@endif</strong></td>
  <td class="text-right" style="border-top: 1px solid #dee2e6;"><strong>{{$sub->qty}}</strong></td>
  <td style="border-top: 1px solid #dee2e6;">{{$sub->instruction}}</td>
</tr>
                    @endif
@php $divide++; @endphp
 @endforeach
</tr>

            </table>
          </div><!--End Table-->


<br>
          <div>

           <br><br><br>

           <hr>
           <br>
          </div>

        </div><!--End InvoiceBot-->
  </div><!--End Invoice-->






@endsection
