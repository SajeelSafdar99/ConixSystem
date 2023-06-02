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
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
    </div>
  
 <div class="row row-sm mg-t-20">
       
      @can('View Books')
          <div class="col-sm-3">
<a href="{{ url('finance-and-management/books') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/finance-and-management/books.png') }}">
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspBOOKS</b></p></div>
                  
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


@can('View Ledger Persons')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/suppliers') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/reports.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUPPLIERS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan



@can('View Payment Methods')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-payment-methods') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">               
                  <img src="{{ url('assets/images/finance-and-management/payment method.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPAYMENT METHODS</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

<!-- 
  <div class="col-sm-3">
<a href="{{ url('finance-and-management/chart-of-accounts/definitions/levels-of-accounts') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/levels of accounts.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEVELS OF ACCOUNTS</b></p></div>
              
            </div>
              </div>
          </div> </a></div> -->


@can('View Accounts Linking')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/coa-linking') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/linking.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspTRANS TYPE & COA LINKING</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>
@endcan



        </div><!-- row -->



 <div class="row row-sm mg-t-20">

</div><!-- row -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection