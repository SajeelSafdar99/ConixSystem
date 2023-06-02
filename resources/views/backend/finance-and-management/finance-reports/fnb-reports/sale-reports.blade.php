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
    <h3 style="text-align: center; color: black;">SALE REPORTS</h3>
    </div>
   
        <div class="row row-sm mg-t-20">

@can('View Sales Summary')   
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/sales-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/food-and-beverage/sales.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES SUMMARY</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
          

       
  @can('View Closing Sales Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/closing-sales-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/closing sales report.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCLOSING SALES REPORT</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

       

@can('View Sales Summary With Items')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/items-sales-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/items summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES SUMMARY (WITH ITEMS)</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan



@can('View Sales KOT Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/sales-kot-report-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/kot report.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES KOT REPORT</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan
        
          
        </div><!-- row -->



     <div class="row row-sm mg-t-20">

@can('View Sales Errors')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/sales-errors-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/error.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES ERRORS</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan



     @can('View Monthly Employee Food Bills')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/food-bills-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/food bills.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMONTHLY EMPLOYEE FOOD BILLS</b></p></div>
            </div>
            </div>
          </div><!-- col-3 --></a></div> @endcan



     @can('View Total Monthly Employee Food Bills')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/total-food-bills-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/food bills.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspTOTAL MONTHLY EMPLOYEE FOOD BILLS</b></p></div>
            </div>
            </div>
          </div><!-- col-3 --></a></div> @endcan

         </div><!-- row -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection