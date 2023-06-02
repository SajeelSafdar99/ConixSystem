@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
     <div class="col-sm-12">
    <a href="{{ url('admin-settings') }}">
          <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">USER RIGHTS</h3>
    </div>
         <div class="row row-sm mg-t-20">


<div class="col-sm-3">
          <a href="{{ url('user-rights/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>

          @can('View Users')
          <div class="col-sm-3">
          <a href="{{ url('admin-settings/users') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/admin-settings/user.png') }}">
                  
                 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b  class="icontexts">USERS</b></p></div>
                  

            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan

              @can('Assign Roles')
          <div class="col-sm-3">
          <a href="{{ url('admin-settings/assign-roles') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/admin-settings/assign roles.png') }}">
                  
                 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b  class="icontexts">ASSIGN ROLES</b></p></div>
                
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
          
        
        </div><!-- row -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection