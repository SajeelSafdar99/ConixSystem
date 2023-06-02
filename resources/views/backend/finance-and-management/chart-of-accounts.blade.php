@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management') }}">
        <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">CHART OF ACCOUNTS</h3>
    </div>
	 
        <div class="row row-sm mg-t-20">

<!-- 
    <div class="col-sm-3">
          <a href="{{ url('finance-and-management/chart-of-accounts/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div> </a></div> -->


<!-- 
            @can('View Chart of Accounts List')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/chart-of-accounts-list-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/chart of acc list.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS LIST</b></p></div>
               
            </div>
          </div>
          </div></a></div>
            @endcan -->


  @can('View COA')
           <div class="col-sm-3">
          <a href="{{ url('COA-new') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/coa.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS DETAILS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
              @endcan
           


  @can('View COA Listing')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/COA-listing') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/coa list.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS LISTING</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
              @endcan
           


               @can('View COA Ledgers')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/coa-ledgers-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/finance ledgers.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS LEDGERS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
              @endcan



  @can('View COA Trial Balance')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/coa-trial-balance-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/balance sheet.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS TRIAL BALANCE</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
              @endcan

      <!--   @can('View Accounts Cash Flow')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/accounts-cash-flow') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/acc cash flow.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspACCOUNTS CASH FLOW</b></p></div>
               
            </div>
          </div>
          </div></a></div>
            @endcan -->
          
          </div><!-- row -->
<!-- 
 <div class="row row-sm mg-t-20">



  @can('View COA Trial Balance')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/coa-trial-balance-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/balance sheet.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS TRIAL BALANCE</b></p></div>
               
            </div>
          </div>
          </div> </a></div>
              @endcan


   </div> -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection