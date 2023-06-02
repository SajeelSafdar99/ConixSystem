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
    <h3 style="text-align: center; color: black;">STORE MANAGEMENT REPORTS</h3>
    </div>
    
        <div class="row row-sm mg-t-20">

    @can('View Dish Breakdown Purchase Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/dish-breakdown-purchase-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/purchase report.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISH BREAKDOWN PURCHASE SUMMARY</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Closing Purchases Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/closing-purchases-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/procurement.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCLOSING PURCHASES REPORT</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Purchases Summary With Items')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/items-purchases-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/items purchased.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPURCHASES SUMMARY (WITH ITEMS)</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

 
            @can('View Purchases Errors')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/purchases-errors-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/finance-and-management/error.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPURCHASES ERRORS</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


               </div><!-- row -->




 
 <div class="row row-sm mg-t-20">
   @can('View Store Issue Note Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/issue-note-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/issue note summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspISSUE NOTE SUMMARY</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Item Issue Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/item-issue-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/issue.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM ISSUE SUMMARY</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Issue Note Summary Detail')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/issue-note-summary-detail-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/multicast.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspISSUE NOTE SUMMARY DETAIL</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


 
  @can('View Item Issue Detail')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/item-issue-detail-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/details.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM ISSUE DETAIL</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


               </div><!-- row -->
 



  <div class="row row-sm mg-t-20">
  @can('View Item Closing Stock Sale Wise')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/item-sale-closing-stock-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/selling stock.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM CLOSING STOCK (SALE-WISE)</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

           @can('View Item Closing Stock Details Sale Wise')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/item-sale-closing-stock-details-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/info.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM CLOSING STOCK DETAILS (SALE-WISE)</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan



            @can('View Item Closing Stock Issuance Wise')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/item-issue-closing-stock-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/issue stock.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM CLOSING STOCK (ISSUANCE-WISE)</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Item Closing Stock Details Issuance Wise')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/item-issue-closing-stock-details-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/info.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM CLOSING STOCK DETAILS (ISSUANCE-WISE)</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div> 
          @endcan

  </div><!-- row -->


 </div>

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection