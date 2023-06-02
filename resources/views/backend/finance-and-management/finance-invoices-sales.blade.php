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
    <h3 style="text-align: center; color: black;">SALES</h3>
    </div>
	 
 <div class="row row-sm mg-t-20">

         
<div class="col-sm-3">
          <a href="{{ url('sales/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
              
@can('View Store Sales')
          <div class="col-sm-3">
          <a href="{{ url('store-management/store-sales-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/store-management/store sales.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspGENERAL SALES</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
    @endcan


<!-- 
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
          </div></a></div>@endcan -->


        @can('View Customer')
 <div class="col-sm-3">
<a href="{{ url('room-management/room-customer') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
              
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  <img src="{{ url('assets/images/room-management/customer.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspGUEST</b></p></div>
                
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan



  @can('View Finance Cash Receipt')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-cash-receipts-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
                  <img src="{{ url('assets/images/finance-and-management/debit credit.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspRECEIPTS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


 


        </div><!-- row -->





 <div class="row row-sm mg-t-20">

           @can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/sales/reports') }}">
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