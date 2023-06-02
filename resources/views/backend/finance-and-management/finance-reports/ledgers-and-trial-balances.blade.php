@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
  <div class="br-pagebody mg-t-5 pd-x-30">
    <br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/reports') }}">
          <img style="float: left;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">LEDGERS & TRIAL BALANCES</h3>
    </div>
    <br/>
        <div class="row row-sm mg-t-20">
   



   @can('View Finance Ledger Accounts')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/member-guest-ledgers-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/bank.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER / GUEST LEDGERS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

@can('View Finance Trial Balance')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/member-guest-trial-balance-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/accounts trial.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER / GUEST TRIAL BALANCE</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
            @endcan

 

         @can('View Supplier Ledger Accounts')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/supplier-ledgers-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/supplier.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUPPLIER LEDGERS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

          @can('View Supplier Trial Balance')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/supplier-trial-balance-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/supplier dc.png') }}">

              <div class="divwidthset">
                <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUPPLIER TRIAL BALANCE</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>
            @endcan



          
        
        </div><!-- row -->

       <div class="row row-sm mg-t-20">



 
     @can('View COA Ledgers')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/coa-ledgers-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/finance ledgers.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCOA LEDGERS</b></p></div>
              
            </div>
              </div>
          </div> </a></div>@endcan




@can('View COA Trial Balance')
<div class="col-sm-3">
 <a href="{{ url('finance-and-management/coa-trial-balance-vue') }}">
 <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                   
                  <img src="{{ url('assets/images/finance-and-management/balance sheet.png') }}">
                  
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspCOA TRIAL BALANCE</b></p></div>
                  

            </div>
              </div>
          </div> </a></div>@endcan 



 
          @can('View Accounts Ledgers')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/accounts-ledgers-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/cash and bank.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspACCOUNTS LEDGERS</b></p></div>
              
            </div>
              </div>
          </div> </a></div>@endcan




@can('View Accounts Trial Balance')
<div class="col-sm-3">
 <a href="{{ url('finance-and-management/accounts-trial-balance-vue') }}">
 <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                   
                  <img src="{{ url('assets/images/finance-and-management/money circulation.png') }}">
                  
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspACCOUNTS TRIAL BALANCE</b></p></div>
                  

            </div>
              </div>
          </div> </a></div>@endcan 




  </div><!-- row -->




      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection