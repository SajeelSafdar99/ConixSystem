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
    <h3 style="text-align: center; color: black;">HUMAN RESOURCE MANAGEMENT</h3>
    </div>
		
	 
        <div class="row row-sm mg-t-20">

<div class="col-sm-3">
          <a href="{{ url('human-resource/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>

@can('View Employment')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

            <img src="{{ url('assets/images/human-resource-management/employment.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspEMPLOYMENT</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan

          @can('Check In Employee')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/checkin') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/checkin.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHECK-IN EMPLOYEE</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


          @can('Check Out Employee')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/check_out') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/checkout.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCHECK-OUT EMPLOYEE</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan
        
        </div><!-- row -->


        <div class="row row-sm mg-t-20">
<!-- 
          @can('View Employee Attendance')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/attend') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/attendance.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspEMPLOYEE ATTENDANCE</b></p></div>
                
            </div>
            </div>
          </div></a></div>@endcan -->


   @can('View Employee In and Out')
<div class="col-sm-3">
<a href="{{ url('human-resource/employee-in-out-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/in and out.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspEMPLOYEE IN & OUT</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


           @can('View Daily Employee Attendance')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/daily-attend-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/daily attendance.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDAILY EMPLOYEE ATTENDANCE</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan
 
             @can('View Employee Attendance')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/attend-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/attendance.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMONTHLY EMPLOYEE ATTENDANCE</b></p></div>
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


              @can('View Employee Payroll')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/payroll-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/payroll.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspEMPLOYEE PAYROLL</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan


          
        </div>


       <div class="row row-sm mg-t-20">


          
           @can('View Employee Salary Voucher')
<div class="col-sm-3">
<a href="{{ url('human-resource/employment/salary-vue') }}">
             <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                  
                  <img src="{{ url('assets/images/human-resource-management/emp salary.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspEMPLOYEE SALARY VOUCHER</b></p></div>
                
            </div>
            </div>
          </div><!-- col-3 --></a></div>@endcan

          
        </div>


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection