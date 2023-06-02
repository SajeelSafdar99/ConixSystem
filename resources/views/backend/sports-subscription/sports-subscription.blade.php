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
    <h3 style="text-align: center; color: black;">MEMBER SUBSCRIPTIONS</h3>
    </div>
    
        <div class="row row-sm mg-t-20">

<div class="col-sm-3">
          <a href="{{ url('sports-subscription/definitions') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                  <img src="{{ url('assets/images/definition.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspDEFINITIONS</b></p></div>
               
            </div>
          </div>
          </div><!-- col-3 --></a></div>


          @can('View Subscriptions Datatable')
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/subscriptions-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/gym.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSPORTS SUBSCRIPTIONS</b></p></div>
              
            </div>
              </div>
          </div><!-- col-3 --></a></div>
          @endcan


 @can('View Maintenance Fee Datatable')
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/maintenance-fee-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/maintenance fee.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMONTHLY MAINTENANCE FEE</b></p></div> 
            </div>
              </div>
          </div><!-- col-3 --></a></div>
           @endcan
         

          @can('View Corporate Maintenance Fee Datatable')
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/corporate-maintenance-fee-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/corporate maintenance.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCORPORATE MONTHLY MAINTENANCE FEE</b></p></div> 
            </div>
              </div>
          </div><!-- col-3 --></a></div>
           @endcan


        </div><!-- row -->



  <div class="row row-sm mg-t-20">


         
   @can('View Card Printing Datatable')       
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/card-printing-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/card printing.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCARD PRINTING</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>
           @endcan



         
   @can('View Corporate Card Printing Datatable')       
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/corporate-card-printing-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/corporate card.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCORPORATE CARD PRINTING</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>
           @endcan
    


         @can('View Reinstating Fee Datatable')       
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/reinstating-fee-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/reinstating fee.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspREINSTATING FEE</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>
           @endcan



           @can('View Corporate Reinstating Fee Datatable')       
   <div class="col-sm-3">
   <a href="{{ url('sports-subscription/corporate-reinstating-fee-datatable-vue') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >
           
             <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
            <img src="{{ url('assets/images/sports-subscription/corporate reinstating.png') }}">
     <div class="divwidthset">
                  <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCORPORATE REINSTATING FEE</b></p></div>
            </div>
              </div>
          </div><!-- col-3 --></a></div>
           @endcan
 </div><!-- row -->



      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection