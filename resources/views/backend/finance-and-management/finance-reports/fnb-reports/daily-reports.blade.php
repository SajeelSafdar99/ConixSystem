@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
  <div class="br-pagebody mg-t-5 pd-x-30">
    <br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/food-and-beverage/reports') }}">
       <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DAILY REPORTS</h3>
    </div>

        <div class="row row-sm mg-t-20">

           @can('View Daily Dump Items List')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/daily-dump-items-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/finance-and-management/daily dump items.png') }}">
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDAILY DUMP ITEMS LIST</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


@can('View Daily Cashier Sales List')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/daily-cashier-sales-list-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/cashier sales.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDAILY SALES LIST (CASHIER-WISE)</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

<!-- 
@can('View Daily Restaurant Sales Summary')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/daily-restaurant-sales-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/daily summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDAILY SALES SUMMARY (RESTAURANT-WISE)</b></p></div> 
            </div>
          </div>
          </div></a></div>@endcan -->


       

    @can('View Running Kitchen Order')
<div class="col-sm-3">
<a href="{{ url('food-and-beverage/reports/running-kitchen-order-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/food-and-beverage/kitchen order.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspRUNNING KITCHEN ORDERS</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan


          <!--  @can('View Running Kitchen Order')
<div class="col-sm-3">
<a href="{{ url('food-and-beverage/reports/running-kitchen-order') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/food-and-beverage/kitchen order.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspRUNNING KITCHEN ORDERS</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan -->

                  
      @can('View Running Sales Order')
<div class="col-sm-3">
<a href="{{ url('food-and-beverage/reports/running-sales-order') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/food-and-beverage/sales order.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspRUNNING SALES ORDERS</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan
        
 </div><!-- row -->



        
      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection