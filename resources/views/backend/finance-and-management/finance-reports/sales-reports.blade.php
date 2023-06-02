@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
  <div class="br-pagebody mg-t-5 pd-x-30">
    <br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/finance-reports-submodules') }}">
         <img style="float: left; margin-top: -12px;"  src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">SALES REPORTS</h3>
    </div>
 


    <div class="row row-sm mg-t-20">
                   @can('View Dish Breakdown Store Sale Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/dish-breakdown-store-sale-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/store sale.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN STORE SALE SUMMARY</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


              @can('View Closing Store Sales Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/closing-store-sales-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                 
                  <img src="{{ url('assets/images/finance-and-management/sell stock.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCLOSING STORE SALES REPORT</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Store Sales Summary With Items')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/items-store-sales-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/sell food.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE SALES SUMMARY (WITH ITEMS)</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Store Sales Errors')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/store-sales-errors-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/finance-and-management/error.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE SALES ERRORS</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

       </div><!-- row -->


 

<div class="row row-sm mg-t-20">
   @can('View Monthly Store Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/monthly-store-report-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/monthly stock.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMONTHLY STORE REPORT</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
 </div>

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection