@extends('backend.layout.app')
@section('page-content')
<style type="text/css">
  
  .divwidthset {
width: 346px !important;
line-height: 6;
    height: 104px !important;
    text-align: center !important;
  }
</style>
<div class="br-mainpanel">

{{-- Main Nav Bar --}}
	<div class="br-pagebody mg-t-5 pd-x-30">
		<br/>
    <div class="col-sm-12">
    <a href="{{ url('finance-and-management') }}">
        <img style="float: left; margin-top: -12px;" src="{{ url('assets/images/go back.png') }}" title="Go Back" height="50" width="50" border="0/">
          </a>
    <h3 style="text-align: center; color: black;">REPORTS</h3>
    </div>
	 
  
      <div class="row row-sm mg-t-20">



<div class="col-sm-3" style="text-align: center !important;">
   <a href="{{ url('finance-and-management/club-membership-management/reports') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" style="text-align: center !important;" >

            <div class="flip-box-inner" style="text-align: center !important;">
            <div class="pd-25 d-flex align-items-center maindivbg " style="text-align: center !important;">

               
<div class="divwidthset">

                  <p > <b class="icontexts">CLUB MEMBERSHIP MANAGEMENT</b></p></div>


            </div>
            </div>
          </div></a> </div>
          
 
<div class="col-sm-3">
<a href>
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                
                 <div class="divwidthset">
                 <p>  <b class="icontexts">MEMBERS ACCESS MANAGEMENT</b></p></div>

            </div>
          </div>
          </div></a> </div>



  <div class="col-sm-3">
          <a href="{{ url('sports-subscription') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
  
  <div class="divwidthset">
             <p>  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER SUBSCRIPTIONS</b></p></div>

            </div>
          </div>
        </div><!-- col-3 --></a> </div> 



          <div class="col-sm-3">
          <a href="{{ url('finance-and-management/food-and-beverage/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
  
  <div class="divwidthset">
             <p>  <b class="icontexts">&nbsp&nbsp&nbsp&nbspFOOD & BEVERAGE</b></p></div>

            </div>
          </div>
        </div><!-- col-3 --></a> </div>

       

        </div><!-- row -->

 
  
  <div class="row row-sm mg-t-20">

      <div class="col-sm-3">
<a href="{{ url('finance-and-management/room-management/reports') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

             
             
            <div class="divwidthset">
                   <p><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOMS MANAGEMENT</b></p></div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>
 
           <div class="col-sm-3">
           <a href>
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

                  <div class="divwidthset">
                 <p> <b class="icontexts">&nbsp&nbsp&nbsp&nbspEVENTS MANAGEMENT</b></p></div>

            </div>
          </div>
          </div></a> </div>
  


          <div class="col-sm-3">
          <a>
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                 <div class="divwidthset">
                 <p>  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMAINTENANCE MANAGEMENT</b></p></div>


            </div>
          </div>
          </div></a> </div>  


  
<div class="col-sm-3">
          <a href="{{ url('finance-and-management/reports') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                 
              <div class="divwidthset">
               <p ><b class="icontexts">&nbsp&nbsp&nbsp&nbspFINANCE MANAGEMENT</b></p></div>

            </div>
          </div> </div></a> </div>  
       

       </div>

   <div class="row row-sm mg-t-20">

  <div class="col-sm-3">
 <a>
         <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

          <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

                   <div class="divwidthset">
               <p> <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES & MARKETING</b></p> </div>
                </div>

          </div>
          </div></a> </div>
    

          <div class="col-sm-3">
          <a href="{{ url('finance-and-management/crm/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
  
  <div class="divwidthset">
             <p>  <b class="icontexts">&nbsp&nbsp&nbsp&nbspCRM</b></p></div>

            </div>
          </div>
        </div><!-- col-3 --></a> </div> 
       


          <div class="col-sm-3">
          <a href>
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
             <div class="divwidthset">
                 <p>  <b class="icontexts">HUMAN RESOURCE MANAGEMENT</b></p></div>

              </div>
            </div>
          </div></a> </div>
     


          <div class="col-sm-3">
          <a>
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
              <div class="divwidthset">
             <p> <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEGAL MANAGEMENT</b></p></div>

            </div>
          </div>
          </div></a> </div>
        </div>

        <div class="row row-sm mg-t-20">
        

            <div class="col-sm-3">
          <a href="{{ url('finance-and-management/store-management/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
  
  <div class="divwidthset">
             <p>  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE MANAGEMENT</b></p></div>

            </div>
          </div>
        </div><!-- col-3 --></a> </div>



          <div class="col-sm-3">
          <a href="{{ url('finance-and-management/sales/reports') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
  
  <div class="divwidthset">
             <p>  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES</b></p></div>

            </div>
          </div>
        </div><!-- col-3 --></a> </div>
    



        </div>
 
      </div><!-- br-pagebody -->
     
    </div><!-- br-mainpanel -->

@endsection