@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management/chart-of-accounts/definitions') }}">
      <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">LEVELS OF ACCOUNTS</h3>
    </div>
 
 <div class="row row-sm mg-t-20">


  
@can('View Level One')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-level-one') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/1.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEVEL ONE</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


@can('View Level Two')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-level-two') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/2.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEVEL TWO</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


    @can('View Level Three')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-level-three') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/3.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEVEL THREE</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan


  @can('View Account Heads')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-account-heads') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/4.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEVEL FOUR</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
    </div><!-- row -->


 
 <div class="row row-sm mg-t-20">

 @can('View Account Types')
<div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-account-types') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 
                  <img src="{{ url('assets/images/finance-and-management/5.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEVEL FIVE</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan
        </div><!-- row -->



      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection