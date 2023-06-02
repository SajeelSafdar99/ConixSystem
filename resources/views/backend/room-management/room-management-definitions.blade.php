@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('room-management') }}">
       <img style="float: left; margin-top: -12px;"  src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
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
       
         

  
@can('View Room Type')
       <div class="col-sm-3">
<a href="{{ url('room-management/room-type') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                
                  <img src="{{ url('assets/images/room-management/room type.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM TYPES</b></p></div>
                
            </div>
            </div> 
          </div><!-- col-3 --></a></div>@endcan
        


          @can('View Room Rate Categories')
          <div class="col-sm-3">
          <a href="{{ url('room-management/room-category') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/room-management/room rate.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM RATE CATEGORIES</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
        


  @can('View Room Charges Type')
           <div class="col-sm-3">
           <a href="{{ url('room-management/room-charges-type') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/room-management/charges.png') }}">
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b  class="icontexts">&nbsp&nbsp&nbsp&nbspROOM CHARGES TYPE</b></p></div>
                  

            </div>
              </div>
          </div><!-- col-3 --></a> </div>@endcan


         
       
        
        </div><!-- row -->

        <div class="row row-sm mg-t-20">



 @can('View Rooms')
  <div class="col-sm-3">
 <a href="{{ url('room-management/room') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  <img src="{{ url('assets/images/room-management/room.png') }}">

                 <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">    <b class="icontexts">&nbsp&nbsp&nbsp&nbspROOMS</b></p></div>
                
            </div>
          </div>
            </div></a></div>@endcan



 @can('View Room Table Definition Mapping')
  <div class="col-sm-3">
 <a href="{{ url('room-management/room-table-mapping-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  <img src="{{ url('assets/images/room-management/room table.png') }}">

                 <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">    <b class="icontexts">&nbsp&nbsp&nbsp&nbspROOM TABLE DEFINITION MAPPING</b></p></div>
                
            </div>
          </div>
            </div></a></div>@endcan

        </div><!-- row -->

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection