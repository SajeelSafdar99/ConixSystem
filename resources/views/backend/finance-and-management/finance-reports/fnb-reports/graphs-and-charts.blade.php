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
    <h3 style="text-align: center; color: black;">GRAPHS & CHARTS</h3>
    </div>
    

        <div class="row row-sm mg-t-20">

        
@can('View Hourly Sales Report')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/hourly-sales-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/bar chart.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspHOURLY SALES REPORT</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan




@can('View Weekdays Graphical Sales Report')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/weekdays-graphical-sales-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/weekdays.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspWEEKDAYS GRAPHICAL SALES REPORT</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


@can('View Restaurant-wise Graphical Sales Report')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/restaurant-graphical-sales-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/pie chart.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspRESTAURANT-WISE GRAPHICAL SALES REPORT</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan




@can('View Subcategory-wise Graphical Sales Report')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/subcategory-graphical-sales-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/graph.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUBCATEGORY-WISE GRAPHICAL SALES REPORT</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

          
        </div><!-- row -->



    <div class="row row-sm mg-t-20">
      
          @can('View Sales Dashboard')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/sales-dashboard-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/sales dashboard.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES DASHBOARD</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan
          </div><!-- row -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection