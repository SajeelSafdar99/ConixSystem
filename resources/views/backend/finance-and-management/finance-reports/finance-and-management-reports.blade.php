@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
  <div class="br-pagebody mg-t-5 pd-x-30">
    <br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/finance-reports-submodules') }}">
          <img style="float: left;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">FINANCE MANAGEMENT REPORTS</h3>
    </div>
    <br/>
        <div class="row row-sm mg-t-20">
  
 

     <div class="col-sm-3">
 <a href="{{ url('finance-and-management/ledgers-and-trial-balances') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/ledgers trials.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEDGERS & TRIAL BALANCES</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>

 


 @can('View Sales Report')

     <div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-sales-report-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/sales report.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES REPORT</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>

@endcan



@can('View Cash Flow')
          <div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-cash-flow') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/cash flow.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCASH FLOW</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

 


            @can('View Accounts Balance')
           <div class="col-sm-3">
          <a href="{{ url('finance-and-management/accounts-balance-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/accounts balance.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspACCOUNTS BALANCE</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
            @endcan


       <!--    <div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-sales-report') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/sales report.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES REPORT</b></p></div>
              
            </div>
              </div>
          </div></a></div> -->
          
        
        </div><!-- row -->

       


 <div class="row row-sm mg-t-20">





@can('View Revenue Summary Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/revenue-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/revenue summary.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspREVENUE SUMMARY REPORT (SECTION-WISE)</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan
  

@can('View Member Revenue Summary Report')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/member-revenue-summary-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/member revenue.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER REVENUE SUMMARY REPORT (CATEGORY-WISE)</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan





@can('View Daily Finance Transaction Book')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/transaction-book-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/transaction book.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDAILY FINANCE TRANSACTION BOOK</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan
@can('View Daily Cash Book')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/cash-book-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/cash book.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDAILY CASH BOOK</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan

  </div><!-- row -->








 <div class="row row-sm mg-t-20">


@can('View Bank Ledger')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/reports/bank-ledger-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/banks.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspBANK LEDGER</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan



@can('View Chart of Accounts List')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/general-ledger-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
    
                  <img src="{{ url('assets/images/finance-and-management/chartofacc.png') }}">

                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspGENERAL LEDGER</b></p></div> 
            </div>
          </div>
          </div><!-- col-3 --></a></div>
  @endcan

</div>
 

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection