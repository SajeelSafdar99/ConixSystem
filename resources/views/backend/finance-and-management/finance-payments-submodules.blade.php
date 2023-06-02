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
    <h3 style="text-align: center; color: black;">RECEIPTS</h3>
    </div>
 
        <div class="row row-sm mg-t-20">

       <!--    <div class="col-sm-3">
          <a href="{{ url('finance-and-management/finance-payments-submodules/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div></a></div> -->
 
<!-- @can('View Payment Receipt')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/payment-receipts') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/finance-and-management/payment receipt.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCASH RECEIPTS</b></p></div>
                
            </div>
            </div>
          </div></a></div>@endcan -->


       <!--    @can('View Finance Cash Receipt')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-cash-receipts') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/finance-and-management/debit credit.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCASH RECEIPTS</b></p></div>
                
            </div>
            </div>
          </div></a></div>@endcan -->

             @can('View Finance Cash Receipt')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-cash-receipts-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/finance-and-management/debit credit.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCASH RECEIPTS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan

 
 @can('View Finance Payment Receipt')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-payment-receipts-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/finance-and-management/payment credit card.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspPAYMENT RECEIPTS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan
          
          </div><!-- row -->

  
 


        
      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection