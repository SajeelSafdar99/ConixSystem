@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
     <div class="col-sm-12">
    <a href="{{ url('/') }}">
        <img style="float: left; margin-top: -12px;"  src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">STORE MANAGEMENT</h3>
    </div>
		
		 

        <div class="row row-sm mg-t-20">

<div class="col-sm-3">
          <a href="{{ url('store-management/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>

@can('View Store Purchases')
          <div class="col-sm-3">
          <a href="{{ url('store-management/store-purchases-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/store-management/purchases.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE PURCHASES</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

    
    @can('View Store Issue Note')
          <div class="col-sm-3">
          <a href="{{ url('store-management/store-issue-note-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/store-management/issue note.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE ISSUE NOTE</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
    @endcan



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


 </div>

    


  <div class="row row-sm mg-t-20">
        
 @can('View Finance Payment Receipt')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-payment-receipts-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/finance-and-management/payment credit card.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspPAYMENTS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan
          


      @can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/store-management/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/reports main page.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspREPORTS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

        </div>
      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection