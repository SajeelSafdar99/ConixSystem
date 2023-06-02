@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('club-hospitality') }}">
          <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
    </div>

        <div class="row row-sm mg-t-20">


@can('View Member Relations')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/member-relation') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/club-membership-management/mem relation.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER RELATIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
        


@can('View Member Type')
<div class="col-sm-3">
<a href="{{ url('club-hospitality/member-classification') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer " >
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
               
                  <img src="{{ url('assets/images/club-membership-management/mem classification.png') }}">

                 <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER TYPE</b></p></div>
             
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
       


@can('View Membership Category')
<div class="col-sm-3">
<a href="{{ url('club-hospitality/member-category') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/club-membership-management/mem category.png') }}">
                  
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBERSHIP CATEGORY</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan

            @can('View Membership Status')
<div class="col-sm-3">
<a href="{{ url('club-hospitality/membership-status') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/club-membership-management/status.png') }}">
                  
                  <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBERSHIP STATUS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>@endcan


       
        </div><!-- row -->


        <div class="row row-sm mg-t-20">

        

           @can('View Member Occupation')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/member-occupations') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/club-membership-management/occupation.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER OCCUPATION</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

           @can('View Member Title')
<div class="col-sm-3">
          <a href="{{ url('club-hospitality/member-title') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/club-membership-management/title.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER TITLE</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
          
              @can('View Guest Types')
 <div class="col-sm-3">
<a href="{{ url('room-management/guest-types') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
              
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  <img src="{{ url('assets/images/room-management/guest type.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspGUEST TYPES</b></p></div>
                
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan



              @can('View Corporate Companies')
 <div class="col-sm-3">
<a href="{{ url('club-hospitality/corporate-companies') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
              
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                <img src="{{ url('assets/images/club-membership-management/corporate.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b class="icontexts">&nbsp&nbsp&nbsp&nbspCORPORATE COMPANIES</b></p></div>
                
            </div>
            </div> 
          </div><!-- col-3 --></a>
           </div>@endcan


        </div><!-- row -->

      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection