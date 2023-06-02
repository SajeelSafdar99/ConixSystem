@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('sales') }}">
          <img style="float: left; margin-top: -12px;"  src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
    </div>
	 
      
         <div class="row row-sm mg-t-20">

 <!-- @can('View Store Location')
<div class="col-sm-3">
          <a href="{{ url('store-management/store-locations') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/store-management/store locations.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE LOCATIONS</b></p></div>
                
            </div>
          </div>
          </div> </a></div>
          @endcan -->
 @can('View Item Category')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/item-categories') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/item category kitchen.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM CATEGORIES</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

           @can('View Store Departments')
<div class="col-sm-3">
          <a href="{{ url('store-management/store-departments') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/store-management/store departments.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE DEPARTMENTS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

             @can('View Restaurant Section Definitions')
<div class="col-sm-3">
          <a href="{{ url('store-management/restaurant-section-definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/store-management/unit.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspRESTAURANT SECTION DEFINITIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

 
             @can('View Section Department Mapping')
<div class="col-sm-3">
          <a href="{{ url('store-management/section-department-mapping') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/store-management/combine.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspSECTION DEPARTMENT MAPPING</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
        

         </div>



 <div class="row row-sm mg-t-20">

   

     @can('View Item Sub-Category')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/item-sub-categories') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/sub category grocery.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM SUB-CATEGORIES</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

            @can('View Item Definition')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/item-definitions-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/item rice bowl.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM DEFINITIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


          @can('View Cancellation Remarks')
<div class="col-sm-3">
          <a href="{{ url('store-management/cancellation-remarks-vue') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/cancelled item.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCANCELLATION REMARKS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

           @can('View Sales Terms and Conditions')
<div class="col-sm-3">
          <a href="{{ url('sales/terms-and-conditions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                <img src="{{ url('assets/images/store-management/terms.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspTERMS & CONDITIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

 </div>


      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection