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
    <h3 style="text-align: center; color: black;">DASHBOARDS</h3>
    </div>
		

        <div class="row row-sm mg-t-20">

                 @can('View Revenue Dashboard')
<div class="col-sm-3">
<a href="{{ url('dashboards/revenue-dashboard-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/dash.png') }}">
<div class="divwidthset">
            <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspREVENUE DASHBOARD</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
 
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
 
     </div>
     


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection