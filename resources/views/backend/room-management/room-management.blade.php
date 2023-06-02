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
    <h3 style="text-align: center; color: black;">ROOMS MANAGEMENT</h3>
    </div>
		
 
        <div class="row row-sm mg-t-20 ">
         
<div class="col-sm-3">
          <a href="{{ url('room-management/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>

          


 @can('View Room Booking')
 <div class="col-sm-3">
 <a href="{{ url('room-management/room-booking-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  
                  <img src="{{ url('assets/images/room-management/room booking.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM BOOKING</b></p></div>
               
            </div>
          </div>
         <!-- col-3 -->
            </div> </a></div>@endcan
          
         

        
          @can('View Check In') <div class="col-sm-3">
          <a href="{{ url('room-management/room-check-in') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
           
           <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/room-management/checkin.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM CHECK-IN</b></p></div>
                  
                
            </div>
          </div><!-- col-3 -->
            </div></a> </div>@endcan
         

<!-- 
 @can('View Check Out')
 <div class="col-sm-3">
 <a href="{{ url('room-management/room-check-out') }}">
                <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
                 
           <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/room-management/checkout.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM CHECK-OUT</b></p></div>
                  
                
            </div>
          </div>
            </div></a> </div>@endcan -->
         
     @can('View Check Out')
 <div class="col-sm-3">
 <a href="{{ url('room-management/room-check-out-vue') }}">
                <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
                 
           <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/room-management/checkout.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM CHECK-OUT</b></p></div>
                  
                
            </div>
          </div><!-- col-3 -->
            </div></a> </div>@endcan
   
      
        
        </div><!-- row -->


  <div class="row row-sm mg-t-20 ">

             @can('View Unpaid Check Out')
 <div class="col-sm-3">
 <a href="{{ url('room-management/room-check-out-unpaid-vue') }}">
                <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
                 
           <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/room-management/unpaid.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM CHECK-OUT (UN-PAID)</b></p></div>
                  
                
            </div>
          </div><!-- col-3 -->
            </div></a> </div>@endcan
   

        @can('View Room Booking Calendar')
         <div class="col-sm-3">
        <a href="{{ url('room-management/calender') }}">
               <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
               
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                 
                  <img src="{{ url('assets/images/room-management/booking calendar.png') }}">
                 <div class="divwidthset">

                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM BOOKING CALENDAR</b></p></div>
              
            </div>
          </div><!-- col-3 -->
            </div></a></div>@endcan
          


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


             @can('View Room Reminders')
            <div class="col-sm-3">
            <a href="{{ url('#') }}">
              <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/room-management/room reminders.png') }}">
 <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM REMINDERS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

        


         <!--    @can('View Payment Receipt')
            <div class="col-sm-3">
            <a href="{{ url('room-management/room-payment-receipts') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
            
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  
                  <img src="{{ url('assets/images/finance-and-management/payment receipt.png') }}">

                 <div class="divwidthset">
                
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspCASH RECEIPTS</b></p></div>
               
            </div>
              </div>
          </div><</a> </div>@endcan -->
       


<!--  @can('View Ledger Accounts')
 <div class="col-sm-3">
 <a href="{{ url('room-management/room-ledger-accounts') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  <img src="{{ url('assets/images/finance-and-management/room ledgers.png') }}">
 <div class="divwidthset">
                  
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM LEDGER ACCOUNTS</b></p></div>
              
            </div>
              </div>
          </div> </a> </div>@endcan
       


@can('View Ledger Account Details')
<div class="col-sm-3">
<a href="{{ url('room-management/room-trial-balance') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/finance-and-management/rooms trial balance.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM TRIAL BALANCE</b></p></div>
              
            </div>
              </div>
          </div> </a></div>@endcan -->



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
          </div></a></div>@endcan





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
          
          </div><!-- row -->




  <div class="row row-sm mg-t-20 ">

          @can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/room-management/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/reports main page.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspREPORTS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan



            @can('View Room Booking Calendar')
         <div class="col-sm-3">
        <a href="{{ url('room-management/calender-vue') }}">
               <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
               
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                 
                  <img src="{{ url('assets/images/room-management/booking calendar.png') }}">
                 <div class="divwidthset">

                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM BOOKING CALENDAR (new)</b></p></div>
              
            </div>
          </div><!-- col-3 -->
            </div></a></div>@endcan
  
          </div><!-- row -->



      
      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection