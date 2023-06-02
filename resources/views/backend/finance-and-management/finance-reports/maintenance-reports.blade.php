@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
  <div class="br-pagebody mg-t-5 pd-x-30">
    <br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/club-membership-management/reports') }}">
       <img style="float: left; margin-top: -12px;"  src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">MAINTENANCE REPORTS</h3>
    </div>
    
        <div class="row row-sm mg-t-20">




     @can('View Maintenance Fee Revenue')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/maintenance-fee-revenue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/revenue.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMAINTENANCE FEE REVENUE</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


          


 @can('View Quarterly Maintenance Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/maintenance-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/quarters.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspQUARTERLY MAINTENANCE REPORT</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

            @can('View Quarterly Maintenance Revenue Report')   
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/maintenance-report-rev-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/club-membership-management/maintenance revenue.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspQUARTERLY MAINTENANCE REVENUE REPORT</b></p></div>
                
            </div>
            </div>
          </div></a></div>
          @endcan
        



 @can('View Pending Maintenance Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/pending-maintenance-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/pending.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPENDING MAINTENANCE REPORT</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

        </div><!-- row -->




  <div class="row row-sm mg-t-20">
     
 @can('View Category-Wise Pending Maintenance Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/category-pending-maintenance-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/pending category.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPENDING MAINTENANCE REPORT (CATEGORY-WISE)</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


 @can('View Subscriptions and Maintenance Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/subscriptions-maintenance-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/subs summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUBSCRIPTIONS & MAINTENANCE SUMMARY</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


 @can('View Category-Wise Subscriptions and Maintenance Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/category-subscriptions-maintenance-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/category subs.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUBSCRIPTIONS & MAINTENANCE SUMMARY (CATEGORY-WISE)</b></p></div>
                  
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan





 <!-- @can('View Pending Maintenance Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/new-pending-maintenance-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/pending.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPENDING MAINTENANCE REPORT (new)</b></p></div>
                  
                
            </div>
          </div>
          </div></a></div>@endcan -->
               </div><!-- row -->





  <!-- <div class="row row-sm mg-t-20">
     
 @can('View Category-Wise Pending Maintenance Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/new-category-pending-maintenance-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/pending category.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPENDING MAINTENANCE REPORT (CATEGORY-WISE) (new)</b></p></div>
                  
                
            </div>
          </div>
          </div></a></div>@endcan
</div> -->

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection