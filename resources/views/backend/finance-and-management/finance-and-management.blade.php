@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
     <div class="col-sm-12">
    <a href="{{ url('/') }}">
        <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">FINANCE MANAGEMENT</h3>
    </div>
	 
        <div class="row row-sm mg-t-20">
<!-- @can('View Payments Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-payments-submodules') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/finance-and-management/payments.png') }}">
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspRECEIPTS</b></p></div>
                  
            </div>
              </div>
          </div></a></div>@endcan -->


      <div class="col-sm-3">
          <a href="{{ url('finance-and-management/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
         <!--  
          @can('View Expenses Module Page')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-expenses-submodules') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/finance-and-management/expenses main page.png') }}">
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspEXPENSES</b></p></div>
                  
            </div>
              </div>
          </div><</a></div>@endcan -->

@can('View Invoices Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-invoices-submodules') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/invoices main page.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspINVOICES</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


@can('View Expenses')
 <div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-expenses-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/expenses.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspEXPENSES</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan
          



 @can('View Vouchers Module Page')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/finance-and-management/cash vouchers.png') }}">
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspVOUCHERS</b></p></div>
                  
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

          
       
          </div><!-- row -->



<div class="row row-sm mg-t-20">

     
          
          
@can('View Chart of Accounts')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/chart-of-accounts') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/chart of accounts.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHART OF ACCOUNTS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

@can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-reports-submodules') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/reports main page.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspREPORTS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

          
          </div><!-- row -->
        

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection