@extends('backend.layout.app')
@section('page-content')
<div class="br-mainpanel">
     <!-- d-flex -->

{{-- Main Nav Bar --}}

      <div class="br-pagebody mg-t-5 pd-x-30">
        <div class="row row-sm mg-t-20">


@can('View Club Membership Management')
<div class="col-sm-3">
<a href="{{ url('club-hospitality') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg ">

                 <img src="{{ url('assets/images/club-membership-management/clubmembership.png') }}">
<div class="divwidthset">

                  <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">CLUB MEMBERSHIP MANAGEMENT</b></p></div>


            </div>
            </div>
          </div></a> </div>@endcan
          

@can('View Members Access Management')
<div class="col-sm-3">
<a href="{{ url('members-access') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
                 <img src="{{ url('assets/images/members-access-management/Search membership.png') }}">
                 <div class="divwidthset">
                 <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">MEMBERS ACCESS MANAGEMENT</b></p></div>

            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan



           @can('View Sports Subscription')
<div class="col-sm-3">
           <a href="{{ url('sports-subscription') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                <img src="{{ url('assets/images/sports-subscription/member.png') }}">
<div class="divwidthset">
                <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspMEMBER SUBSCRIPTIONS</b></p></div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan


          @can('View Food and Beverage')
          <div class="col-sm-3">
          <a href="{{ url('food-and-beverage') }}">
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
               
  <img src="{{ url('assets/images/food-and-beverage/Resturant.png') }}">
  <div class="divwidthset">
             <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspFOOD & BEVERAGE</b></p></div>

            </div>
          </div>
        </div><!-- col-3 --></a> </div>@endcan
        </div><!-- row -->

        <div class="row row-sm mg-t-20">
        
@can('View Rooms Management')
<div class="col-sm-3">
<a href="{{ url('room-management') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

             
                <img src="{{ url('assets/images/room-management/Rooms management.png') }}">

            <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below"><b class="icontexts">&nbsp&nbsp&nbsp&nbspROOMS MANAGEMENT</b></p></div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan



           @can('View Events Management')
           <div class="col-sm-3">
           <a href="{{ url('events-management') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer" >

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

                  <img src="{{ url('assets/images/events-management/Event Management.png') }}">
                  <div class="divwidthset">
                 <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspEVENTS MANAGEMENT</b></p></div>

            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan



          @can('View Maintenance Management')
          <div class="col-sm-3">
           <a href="{{ url('maintenance-management') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
              
                  <img src="{{ url('assets/images/maintenance-management/Maintenance Management.png') }}">
                  <div class="divwidthset">
                 <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspMAINTENANCE MANAGEMENT</b></p></div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan


          @can('View Finance and Management')
<div class="col-sm-3">
          <a href="{{ url('finance-and-management') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                 
                 <img src="{{ url('assets/images/finance-and-management/Finance.png') }}">
                 <div class="divwidthset">
               <p class=" mg-b-2 lh-1 icon-below"><b class="icontexts">&nbsp&nbsp&nbsp&nbspFINANCE MANAGEMENT</b></p></div>

            </div>
          </div><!-- col-3 -->
        </div></a> </div>@endcan
        </div><!-- row -->


        <div class="row row-sm mg-t-20">
 @can('View Sales and Marketing')
  <div class="col-sm-3">
 <a>
         <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

          <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">

                  <img src="{{ url('assets/images/sales-and-marketing/Sales and Marketing.png') }}">
                  <div class="divwidthset">
               <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES & MARKETING</b></p> </div>
                </div>

          </div>
          </div><!-- col-3 --></a> </div>@endcan
    


          @can('View CRM')
          <div class="col-sm-3">
<a href="{{ url('crm') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
             
                 <img src="{{ url('assets/images/crm/Customer Relationship.png') }}">
                 <div class="divwidthset">
             <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspCUSTOMER RELATIONSHIP & MANAGEMENT</b></p></div>

            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan
       


          @can('View Human Resource Management')
          <div class="col-sm-3">
          <a href="{{ url('human-resource') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                <img src="{{ url('assets/images/human-resource-management/Human Resource.png') }}">
                <div class="divwidthset">
                 <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">HUMAN RESOURCE MANAGEMENT</b></p></div>

              </div>
            </div>
          </div><!-- col-3 --></a> </div>@endcan
     


          @can('View Legal Management')
          <div class="col-sm-3">
          <a>
           <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                <img src="{{ url('assets/images/legal-management/legal_management.png') }}">
                <div class="divwidthset">
             <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspLEGAL MANAGEMENT</b></p></div>

            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan
      
        </div><!-- row -->


        <div class="row row-sm mg-t-20">
        
 @can('View Store Management')
   <div class="col-sm-3">
<a href="{{ url('store-management') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
             
                <img src="{{ url('assets/images/store-management/Store.png') }}">
                <div class="divwidthset">
       <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspSTORE MANAGEMENT</b></p></div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan



     @can('View General Sales')
  <div class="col-sm-3">
          <a href="{{ url('sales') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">
            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
                
                 <img src="{{ url('assets/images/finance-and-management/inventory.png') }}">

                <div class="divwidthset">
                   <p class=" mg-b-2 lh-1 icon-below">  <b class="icontexts">&nbsp&nbsp&nbsp&nbspSALES</b></p></div>
            </div>
          </div>
          </div><!-- col-3 --></a></div>
          @endcan


          @can('View Admin Settings')
          <div class="col-sm-3">
          <a href="{{ url('admin-settings') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
               <img src="{{ url('assets/images/admin-settings/Admin Setting.png') }}">
               <div class="divwidthset">
               <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspADMIN SETTINGS</b></p>
             </div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan


            @can('View Dashboards')
          <div class="col-sm-3">
          <a href="{{ url('dashboards') }}">
          <div class="col-sm-6 col-xl-12 flip-box cursorpointer">

            <div class="flip-box-inner">
            <div class="pd-25 d-flex align-items-center maindivbg">
        
               <img src="{{ url('assets/images/dashboards.png') }}">
               <div class="divwidthset">
               <p class=" mg-b-2 lh-1 icon-below"> <b class="icontexts">&nbsp&nbsp&nbsp&nbspDASHBOARDS</b></p>
             </div>


            </div>
          </div>
          </div><!-- col-3 --></a> </div>@endcan
       

        </div><!-- row -->



      </div><!-- br-pagebody -->

    </div><!-- br-mainpanel -->



@endsection
