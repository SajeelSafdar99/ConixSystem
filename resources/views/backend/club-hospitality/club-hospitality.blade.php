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
    <h3 style="text-align: center; color: black;">CLUB MEMBERSHIP MANAGEMENT</h3>
    </div>
		
		

        <div class="row row-sm mg-t-20">

<div class="col-sm-3">
          <a href="{{ url('club-hospitality/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
        

        @can('View Membership')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/membership-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/club-membership-management/membership card.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBERSHIP</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

             @can('View Corporate Membership')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/corporate-membership-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/club-membership-management/corporate mem card.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCORPORATE MEMBERSHIP</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


 @can('View Family Memberships')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/family-membership-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/club-membership-management/membership.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspFAMILY MEMBERSHIPS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


          


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

        </div><!-- row -->


        <div class="row row-sm mg-t-20"> 
  

  @can('View Finance Invoices')
   <div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-new-invoices-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/invoice.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspINVOICES</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

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

    
    @can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/club-membership-management/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/reports main page.png') }}">
<div class="divwidthset">
                 
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspREPORTS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
     
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
          </div></a></div>@endcan
 -->

              <!--    

           @can('View Finance Invoices')
   <div class="col-sm-3">
 <a href="{{ url('finance-and-management/finance-invoices') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/invoice.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspINVOICES</b></p></div>
              
            </div>
              </div>
          </div></a></div>@endcan -->

        </div>


         <div class="row row-sm mg-t-20"> 
 @can('View Partners')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/partners') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/club-membership-management/partners.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspPARTNERS / AFFILIATES</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
</div>

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection