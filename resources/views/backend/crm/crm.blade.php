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
    <h3 style="text-align: center; color: black;">CUSTOMER RELATIONSHIP & MANAGEMENT</h3>
    </div>
		

        <div class="row row-sm mg-t-20">

<div class="col-sm-3">
          <a href="{{ url('crm/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>

            @can('View CRM Dashboard')
<div class="col-sm-3">
<a href="{{ url('crm/dashboard-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/crm dashboard.png') }}">
<div class="divwidthset">
            <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCRM DASHBOARD</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

@can('View Leads')
   <div class="col-sm-3">
          <a href="{{ url('crm/leads-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/leads.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEADS</b></p></div>
               
            </div>
          </div>
          </div></a></div>
          @endcan


          @can('View Follow Ups')
   <div class="col-sm-3"> 
          <a href="{{ url('crm/follow-ups-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/follow up.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspFOLLOW UPS</b></p></div>
               
            </div>
          </div>
          </div></a></div>
          @endcan

 </div>

     <div class="row row-sm mg-t-20">
        
          @can('View Visits')
   <div class="col-sm-3">
          <a href="{{ url('crm/visits-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/visit.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspVISITS</b></p></div>
               
            </div>
          </div>
          </div></a></div>
          @endcan


                  @can('View Call Details')
   <div class="col-sm-3">
          <a href="{{ url('crm/call-details-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/phone call.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCALL DETAILS</b></p></div>
               
            </div>
          </div>
          </div></a></div>
          @endcan


        @can('View Member Recoveries')
   <div class="col-sm-3">
          <a href="{{ url('crm/visits-comment-sheet-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/recovery.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspVISITS COMMENT SHEET</b></p></div>
               
            </div>
          </div>
          </div></a></div>
          @endcan


               @can('View Complaints')
   <div class="col-sm-3">
          <a href="{{ url('crm/complaints-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/crm/complaints.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCOMPLAINTS</b></p></div>
               
            </div>
          </div>
          </div></a></div>
          @endcan


 </div>


<div class="row row-sm mg-t-20">

   @can('View Reports Module Page')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/crm/reports') }}">
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