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
    <h3 style="text-align: center; color: black;">DISH BREAKDOWN SUMMARIES</h3>
    </div>
    

        <div class="row row-sm mg-t-20">

          @can('View Dish Breakdown Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/dish-breakdown-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/dish breakdown summary.png') }}">

      <div class="divwidthset">
   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN SUMMARY (PRICE)</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


              @can('View Sold Quantity Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/sold-quantity-report-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/food-and-beverage/sold report.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN SUMMARY (SOLD QUANTITY)</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan
 
        
   @can('View Dish Breakdown Summary Restaurant-wise')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/restaurant-dish-breakdown-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/restaurant.png') }}">

      <div class="divwidthset">
   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN SUMMARY (RESTAURANT-WISE)</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan



           @can('View Dish Breakdown Summary Date-wise')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/date-dish-breakdown-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/today.png') }}">

      <div class="divwidthset">
   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN SUMMARY (DATE-WISE)</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan
          
        </div><!-- row -->


 <div class="row row-sm mg-t-20">
 @can('View Yearly Dish Breakdown Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/yearly-dish-breakdown-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/year.png') }}">

      <div class="divwidthset">
   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN SUMMARY (YEARLY)</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan
         </div><!-- row -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection