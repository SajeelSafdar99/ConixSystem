@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/> <div class="col-sm-12">
    <a href="{{ url('finance-and-management') }}">
           <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">EXPENSES</h3>
    </div>
	
        <div class="row row-sm mg-t-20">

             <div class="col-sm-3">
          <a href="{{ url('finance-and-management/finance-expenses-submodules/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          
@can('View Expenses')
 <div class="col-sm-3">
<a href="{{ url('finance-and-management/finance-expenses-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                
                  <img src="{{ url('assets/images/finance-and-management/expenses.png') }}">
<div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspEXPENSES</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>@endcan



          
          </div><!-- row -->

         
      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection