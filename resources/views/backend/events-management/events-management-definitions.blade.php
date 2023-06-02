@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('events-management') }}">
         <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
    </div>
 
 <div class="row row-sm mg-t-20">

           @can('View Event Customer')
           <div class="col-sm-3">
<a href="{{ url('events-management/event-customer') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
               
                  <img src="{{ url('assets/images/room-management/customer.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspEVENT GUEST</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a>
        </div>
@endcan


 @can('View Menu Type')
 <div class="col-sm-3">
<a href="{{ url('events-management/menu-type') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                 
                  <img src="{{ url('assets/images/events-management/menu type.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMENU TYPE</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>
          @endcan


@can('View Menu Rate Category')
 <div class="col-sm-3">
<a href="{{ url('events-management/menu-category') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/events-management/menu rates.png') }}">
<div class="divwidthset">
                 
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMENU RATE CATEGORIES</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>
  @endcan


@can('View Event Charges Type')
 <div class="col-sm-3">
          <a href="{{ url('events-management/event-charges-type') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/events-management/event charges type.png') }}">
                  <div class="divwidthset">
                  
                   <p class=" mg-b-2 lh-1 icon-below">   <b  class="icontexts">&nbsp&nbsp&nbsp&nbspEVENT CHARGES TYPE</b></p></div>
                  

            </div>
              </div>
          </div><!-- col-3 --></a>
        </div>
  @endcan

        </div><!-- row -->


        <div class="row row-sm mg-t-20 ">

@can('View Venues')
 <div class="col-sm-3">
<a href="{{  url('events-management/event-venue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  <img src="{{ url('assets/images/events-management/venues.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">    <b class="icontexts">&nbsp&nbsp&nbsp&nbspVENUES</b></p></div>
                
            </div>
          </div><!-- col-3 -->
            </div></a></div>
  @endcan


@can('View Menus')
 <div class="col-sm-3">
  <a href="{{ url('events-management/menus') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/events-management/menu.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">    <b class="icontexts">&nbsp&nbsp&nbsp&nbspMENUS</b></p></div>
                
            </div>
          </div><!-- col-3 -->
            </div></a></div>
  @endcan


  @can('View Menu Add Ons')
 <div class="col-sm-3">
  <a href="{{ url('events-management/menu-add-ons') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/events-management/menu add on.png') }}">

                  <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">    <b class="icontexts">&nbsp&nbsp&nbsp&nbspMENU ADD-ONS</b></p></div>
                
            </div>
          </div><!-- col-3 -->
            </div></a></div>
  @endcan
        
        </div><!-- row -->

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection