@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('human-resource') }}">
           <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
    </div>
	 
 <div class="row row-sm mg-t-20">
<!-- 
   @can('View Companies')
<div class="col-sm-3">
<a href="{{ url('human-resource/companies') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/human-resource-management/company.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCOMPANIES</b></p></div>
                
            </div>
            </div>
          </div></a></div>@endcan -->

         @can('View Departments')
<div class="col-sm-3">
<a href="{{ url('human-resource/departments') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/human-resource-management/departments.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEPARTMENTS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


            @can('View Sub-Departments')
<div class="col-sm-3">
<a href="{{ url('human-resource/sub-departments') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/human-resource-management/department.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSUB-DEPARTMENTS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan



             @can('View Salary Add-Ons')
<div class="col-sm-3">
<a href="{{ url('human-resource/salary-add-ons') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/human-resource-management/salary.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALARY ADD-ONS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


        </div><!-- row -->



         <div class="row row-sm mg-t-20">

             @can('View Salary Deductions')
<div class="col-sm-3">
<a href="{{ url('human-resource/salary-deductions') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/human-resource-management/minus.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALARY DEDUCTIONS</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan

             </div><!-- row -->



      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection