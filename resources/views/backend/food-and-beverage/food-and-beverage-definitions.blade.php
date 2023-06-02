@extends('backend.layout.app')
@section('page-content')

<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('food-and-beverage') }}">
            <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">DEFINITIONS</h3>
    </div>

        <div class="row row-sm mg-t-20">
 <!--          
@can('View Printers')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/printers') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/printers.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPRINTERS</b></p></div>
                
            </div>
          </div>
          </div></a></div>
          @endcan -->

@can('View POS Location')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/pos-locations') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/pos.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPOS LOCATIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan
    
          @can('View Restaurant Location')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/restaurant-locations') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/restaurant location.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspRESTAURANT LOCATIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

        @can('View Table Definition')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/table-definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/table.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspTABLE DEFINITIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

          @can('View Waiter Definition')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/waiter-definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/waiter.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspWAITER DEFINITIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

           
       
        </div><!-- row -->


        <div class="row row-sm mg-t-20">



         @can('View Delivery Rider')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/delivery-riders') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/rider.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDELIVERY RIDERS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

           @can('View Measurement Unit')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/measurement-units') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/measurement.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEASUREMENT UNITS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

          @can('View Item Manufacturer')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/item-manufacturers') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/manufacturer.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM MANUFACTURERS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


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
          

        </div><!-- row -->



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


           @can('View Product Classification')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/product-classifications') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/product coffee machine.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspPRODUCT CLASSIFICATIONS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

          @can('View Currency Definition')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/currency-definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/currency.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCURRENCY DEFINITIONS</b></p></div>
                
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
          </div></a></div>
          @endcan
  
       
         </div>


           <div class="row row-sm mg-t-20">
   



              
           <!--  @can('View Item Definition')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/item-definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/item rice bowl.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspITEM DEFINITIONS</b></p></div>
                
            </div>
          </div>
          </div></a></div>
          @endcan -->

           @can('View Discount Card')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/discount-cards') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/discount card.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspDISCOUNT CARDS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

            @can('View Cancelled Item Remark')
<div class="col-sm-3">
          <a href="{{ url('food-and-beverage/cancelled-item-remarks') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/cancelled item.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCANCELLED ITEM REMARKS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

          
            @can('View Cake Types')
      <div class="col-sm-3">
          <a href="{{ url('food-and-beverage/cake-types') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/cup cake.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspCAKE TYPES</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


          @can('View ENT Details')
      <div class="col-sm-3">
          <a href="{{ url('food-and-beverage/ent-details') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  
                  <img src="{{ url('assets/images/food-and-beverage/ent.png') }}">
<div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">   <b class="icontexts">&nbsp&nbsp&nbsp&nbspENT DETAILS</b></p></div>
                
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan

           </div>




      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection