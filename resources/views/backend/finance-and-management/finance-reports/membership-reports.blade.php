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
    <h3 style="text-align: center; color: black;">MEMBERSHIP REPORTS</h3>
    </div>
    
        <div class="row row-sm mg-t-20">



<!-- 
          @can('View Membership Fee Revenue')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/membership-fee-revenue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/finance-and-management/membership revenue.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBERSHIP FEE REVENUE</b></p></div>
                  
                
            </div>
          </div>
          </div></a></div>@endcan -->
 
    @can('View Member Activities')   
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/member-activities-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/club-membership-management/member activities.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER ACTIVITIES</b></p></div>
                
            </div>
            </div>
          </div></a></div>
          @endcan
        
            @can('View Member Card Detail Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/member-card-detail-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/card detail.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER CARD DETAIL REPPORT</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

            @can('View Supplementary Card Detail Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/supplementary-card-detail-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                 
                  <img src="{{ url('assets/images/club-membership-management/card summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUPPLEMENTARY CARD DETAIL REPPORT</b></p></div>
                  
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan



          @can('View Membership Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/membership-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/club-membership-management/summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBERSHIP SUMMARY</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

          
        </div><!-- row -->




  <div class="row row-sm mg-t-20">
    



          @can('View Category-Wise Membership Summary')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/category-membership-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/club-membership-management/category summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBERSHIP SUMMARY (CATEGORY-WISE)</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan



          @can('View Available Membership Numbers')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/available-membership-numbers-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
            
                  <img src="{{ url('assets/images/finance-and-management/numbers.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspAVAILABLE MEMBERSHIP NUMBERS</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


               </div><!-- row -->

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection