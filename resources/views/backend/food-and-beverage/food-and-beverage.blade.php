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
    <h3 style="text-align: center; color: black;">FOOD & BEVERAGE</h3>
    </div>
	
        <div class="row row-sm mg-t-20">

<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>


             @can('Add Sales')   
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/sales/sales-aeu') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/food-and-beverage/add sales.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


@can('View Sales')   
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/sales-list-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/food-and-beverage/sales list.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES LIST</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


@can('View Running Sales List')   
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/running-sales-list-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/food-and-beverage/running sales list.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspRUNNING SALES LIST</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


  
 </div>

   <div class="row row-sm mg-t-20">


  @can('View Shifts')
 <div class="col-sm-3">
<a href="{{ url('food-and-beverage/shifts-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/food-and-beverage/shifts.png') }}">
                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspSHIFTS</b></p></div>
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan



  @can('View User Shifts')
 <div class="col-sm-3">
<a href="{{ url('food-and-beverage/user-shifts-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/food-and-beverage/user shift.png') }}">
                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspUSER SHIFTS</b></p></div>
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan


  @can('View Cake Bookings')
 <div class="col-sm-3">
<a href="{{ url('food-and-beverage/cake-booking-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/food-and-beverage/cake.png') }}">
                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspCAKE BOOKINGS</b></p></div>
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan



  @can('View Cancelled Cake Bookings')
 <div class="col-sm-3">
<a href="{{ url('food-and-beverage/cancelled-cake-booking-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  <img src="{{ url('assets/images/food-and-beverage/cancelled booking.png') }}">
                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspCANCELLED CAKE BOOKINGS</b></p></div>
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan


  
 </div>



    <div class="row row-sm mg-t-20">



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
          </div></a></div>@endcan


  @can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/food-and-beverage/reports') }}">
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
   <!--     
  <div class="row row-sm mg-t-20"> -->
<!-- 
@can('View Finance Trial Balance')
<div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-trial-balance') }}">
 <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                   
                  <img src="{{ url('assets/images/finance-and-management/balance sheet.png') }}">
                  
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b  class="icontexts">&nbsp&nbsp&nbsp&nbspFINANCE TRIAL BALANCE</b></p></div>
                  

            </div>
              </div>
          </div></a></div>@endcan -->

<!-- 
@can('View Finance Ledger Accounts')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-ledger-accounts') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/finance ledgers.png') }}">
 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspFINANCE LEDGER ACCOUNTS</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan -->
               
<!-- 
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
          </div></a></div>@endcan -->

  
        <!-- </div>
 -->

         

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection