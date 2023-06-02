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
    <h3 style="text-align: center; color: black;">ADMIN SETTINGS</h3>
    </div>
		 
        <div class="row row-sm mg-t-20">

@can('View Company Profile')
<div class="col-sm-3">
<a href="{{ url('admin-settings/profile') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/admin-settings/company profile.png') }}">
<div class="divwidthset">
       <p class=" mg-b-2 lh-1 icon-below">   
      <b class="icontexts">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCOMPANY PROFILE</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan



@can('View File Manager')
<div class="col-sm-3">
<a href="{{ url('admin-settings/file-manager') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/admin-settings/file manager.png') }}">
                  <div class="divwidthset">
                 
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b  class="icontexts">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFILE MANAGER</b></p></div>
                  

            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


@can('Take Database Backup')
<div class="col-sm-3">
  <a href="//digitime.dyndns.org/backup/sqlexport.php" target="popup" onclick="window.open('//digitime.dyndns.org/backup/sqlexport.php','popup','width=500,height=400'); return false;">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/admin-settings/database backup.png') }}">
                  <div class="divwidthset">
                 
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b  class="icontexts">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBACKUP DATABASE</b></p></div>
                  

            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan




@can('View User Rights')
<div class="col-sm-3">
<a href="{{ url('user-rights') }}">
            <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                  
                  <img src="{{ url('assets/images/admin-settings/user rights.png') }}">
                  <div class="divwidthset">
                 
                   <p class=" mg-b-2 lh-1 icon-below">   <br/><b  class="icontexts">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspUSER RIGHTS</b></p></div>
                  

            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


        </div><!-- row -->


        <div class="row row-sm mg-t-20">
 @can('View Predefined Values')
<div class="col-sm-3">
          <a href="{{ url('admin-settings/predefined-values') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/predefined values tax.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPREDEFINED VALUES</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
           </div><!-- row -->


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection