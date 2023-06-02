@extends('backend.layout.app')
@section('page-content')
<style type="text/css">
  
  .divwidthset {
width: 346px !important;
line-height: 6;
    height: 104px !important;
    text-align: center !important;
  }
</style>
<div class="br-mainpanel">

{{-- Main Nav Bar --}}
  <div class="br-pagebody mg-t-5 pd-x-30">
    <br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/finance-reports-submodules') }}">
        <img style="float: left; margin-top: -12px;"  src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">FOOD & BEVERAGE REPORTS</h3>
    </div>
    
      <div class="row row-sm mg-t-20">

<div class="col-sm-3" style="text-align: center !important;">
   <a href="{{ url('finance-and-management/food-and-beverage/reports/dish-breakdown-reports') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" style="text-align: center !important;" >
            <div class="flip-box-inner" style="text-align: center !important;">
            <div class="pd-25 d-flex align-items-center maindivbg " style="text-align: center !important;">
<div class="divwidthset">
                  <p > <b class="icontexts">DISH BREAKDOWN SUMMARIES</b></p></div>
            </div>
            </div>
          </div></a> </div>

          <div class="col-sm-3" style="text-align: center !important;">
   <a href="{{ url('finance-and-management/food-and-beverage/reports/daily-reports') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" style="text-align: center !important;" >

            <div class="flip-box-inner" style="text-align: center !important;">
            <div class="pd-25 d-flex align-items-center maindivbg " style="text-align: center !important;">
<div class="divwidthset">
                  <p > <b class="icontexts">DAILY REPORTS</b></p></div>
            </div>
            </div>
          </div></a> </div>



          <div class="col-sm-3" style="text-align: center !important;">
   <a href="{{ url('finance-and-management/food-and-beverage/reports/sale-reports') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" style="text-align: center !important;" >

            <div class="flip-box-inner" style="text-align: center !important;">
            <div class="pd-25 d-flex align-items-center maindivbg " style="text-align: center !important;">
<div class="divwidthset">
                  <p > <b class="icontexts">SALE REPORTS</b></p></div>
            </div>
            </div>
          </div></a> </div>
          

          <div class="col-sm-3" style="text-align: center !important;">
   <a href="{{ url('finance-and-management/food-and-beverage/reports/graphs-and-charts') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" style="text-align: center !important;" >

            <div class="flip-box-inner" style="text-align: center !important;">
            <div class="pd-25 d-flex align-items-center maindivbg " style="text-align: center !important;">
<div class="divwidthset">
                  <p > <b class="icontexts">GRAPHS & CHARTS</b></p></div>
            </div>
            </div>
          </div></a> </div>



      </div>



      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection