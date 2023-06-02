<?php
use App\admin_company_profile;
use App\User;

$profiledata=admin_company_profile::get()->first();

$user = auth()->user();
?>
<style type="text/css">

@media (min-width: 992px){

.mg-b-25 {
    margin-bottom: 8px !important;
}
.form-layout-4, .form-layout-5 {
    padding: 7px !important;
}
.margara {
    margin-top: -12px !important;
}



  .dropdown:hover .dropdown-menu{
        display: block;
    }
    .dropdown:hover .submenu{
        display: none;
    }

  .dropdown-menu .dropdown-toggle:after{
    border-top: .3em solid transparent;
      border-right: 0;
      border-bottom: .3em solid transparent;
      border-left: .3em solid;

  }
  .dropdown-menu .dropdown-menu{
    margin-left:0; margin-right: 0;
  }
  .nav-link{
    color: white !important;
    font-size: 15px !important;
    padding-right: 1.5rem !important;
  }
  .dropdown-menu li{
    position: relative;
  }
  .nav-item .submenu{
    display: none;
    position: absolute;
    left:100%; top:-7px;
  }
  .nav-item .submenu-left{
    right:100%; left:auto;
    color: black !important;
  }
  .dropdown-menu > li:hover{ background-color: #f1f1f1;}
  .dropdown-menu > li:hover > .submenu{
    display: block;
  }

    .bd.rounded.border-menu {
    margin-top: 0px !important;
    background: #49a2fb !important;
  }

  .br-header {
    left: 1827px !important;
    height: 49px !important;
}

}
</style>
<body>

    <!-- ########## START: LEFT PANEL ########## -->
   <!--  <div class="br-logo remove-bg"><a href=""><a href="{{ url('/') }}">
      <img src="{{ url($profiledata->company_logo) }}" height="80" width="200">
    </a> </div> -->
    {{-- <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">
        <a href="index.html" class="br-menu-link active">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="mailbox.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
            <span class="menu-item-label">Mailbox</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="card-dashboard.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
            <span class="menu-item-label">Cards &amp; Widgets</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">UI Elements</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="accordion.html" class="nav-link">Accordion</a></li>
          <li class="nav-item"><a href="alerts.html" class="nav-link">Alerts</a></li>
          <li class="nav-item"><a href="buttons.html" class="nav-link">Buttons</a></li>
          <li class="nav-item"><a href="cards.html" class="nav-link">Cards</a></li>
          <li class="nav-item"><a href="icons.html" class="nav-link">Icons</a></li>
          <li class="nav-item"><a href="modal.html" class="nav-link">Modal</a></li>
          <li class="nav-item"><a href="pagination.html" class="nav-link">Pagination</a></li>
          <li class="nav-item"><a href="popups.html" class="nav-link">Tooltip &amp; Popover</a></li>
          <li class="nav-item"><a href="progress.html" class="nav-link">Progress</a></li>
          <li class="nav-item"><a href="spinners.html" class="nav-link">Spinners</a></li>
          <li class="nav-item"><a href="typography.html" class="nav-link">Typography</a></li>
        </ul>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Navigation</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="navigation.html" class="nav-link">Basic Nav</a></li>
          <li class="nav-item"><a href="navigation-layouts.html" class="nav-link">Nav Layouts</a></li>
        </ul>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
            <span class="menu-item-label">Charts</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="chart-morris.html" class="nav-link">Morris Charts</a></li>
          <li class="nav-item"><a href="chart-flot.html" class="nav-link">Flot Charts</a></li>
          <li class="nav-item"><a href="chart-chartjs.html" class="nav-link">Chart JS</a></li>
          <li class="nav-item"><a href="chart-rickshaw.html" class="nav-link">Rickshaw</a></li>
          <li class="nav-item"><a href="chart-chartist.html" class="nav-link">Chartist</a></li>
          <li class="nav-item"><a href="chart-sparkline.html" class="nav-link">Sparkline</a></li>
          <li class="nav-item"><a href="chart-peity.html" class="nav-link">Peity</a></li>
        </ul>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
            <span class="menu-item-label">Forms</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="form-elements.html" class="nav-link">Form Elements</a></li>
          <li class="nav-item"><a href="form-layouts.html" class="nav-link">Form Layouts</a></li>
          <li class="nav-item"><a href="form-validation.html" class="nav-link">Form Validation</a></li>
          <li class="nav-item"><a href="form-wizards.html" class="nav-link">Form Wizards</a></li>
          <li class="nav-item"><a href="form-editor-code.html" class="nav-link">Code Editor</a></li>
          <li class="nav-item"><a href="form-editor-text.html" class="nav-link">Text Editor</a></li>
        </ul>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
            <span class="menu-item-label">Tables</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="table-basic.html" class="nav-link">Basic Table</a></li>
          <li class="nav-item"><a href="table-datatable.html" class="nav-link">Data Table</a></li>
        </ul>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-navigate-outline tx-24"></i>
            <span class="menu-item-label">Maps</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="map-google.html" class="nav-link">Google Maps</a></li>
          <li class="nav-item"><a href="map-leaflet.html" class="nav-link">Leaflet Maps</a></li>
          <li class="nav-item"><a href="map-vector.html" class="nav-link">Vector Maps</a></li>
        </ul>
        <a href="#" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-briefcase-outline tx-22"></i>
            <span class="menu-item-label">Utilities</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="background.html" class="nav-link">Background</a></li>
          <li class="nav-item"><a href="border.html" class="nav-link">Border</a></li>
          <li class="nav-item"><a href="height.html" class="nav-link">Height</a></li>
          <li class="nav-item"><a href="margin.html" class="nav-link">Margin</a></li>
          <li class="nav-item"><a href="padding.html" class="nav-link">Padding</a></li>
          <li class="nav-item"><a href="position.html" class="nav-link">Position</a></li>
          <li class="nav-item"><a href="typography-util.html" class="nav-link">Typography</a></li>
          <li class="nav-item"><a href="width.html" class="nav-link">Width</a></li>
        </ul>
        <a href="pages.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
            <span class="menu-item-label">Apps &amp; Pages</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="layouts.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-book-outline tx-22"></i>
            <span class="menu-item-label">Layouts</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="sitemap.html" class="br-menu-link">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-list-outline tx-22"></i>
            <span class="menu-item-label">Sitemap</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
      </div><!-- br-sideleft-menu -->

      <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">Information Summary</label>

      <div class="info-list">
        <div class="d-flex align-items-center justify-content-between pd-x-15">
          <div>
            <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">Memory Usage</p>
            <h5 class="tx-lato tx-white tx-normal mg-b-0">32.3%</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#336490"], "height": 35, "width": 60 }'>8,6,5,9,8,4,9,3,5,9</span>
        </div><!-- d-flex -->

        <div class="d-flex align-items-center justify-content-between pd-x-15 mg-t-20">
          <div>
            <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">CPU Usage</p>
            <h5 class="tx-lato tx-white tx-normal mg-b-0">140.05</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#1C7973"], "height": 35, "width": 60 }'>4,3,5,7,12,10,4,5,11,7</span>
        </div><!-- d-flex -->

        <div class="d-flex align-items-center justify-content-between pd-x-15 mg-t-20">
          <div>
            <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">Disk Usage</p>
            <h5 class="tx-lato tx-white tx-normal mg-b-0">82.02%</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#8E4246"], "height": 35, "width": 60 }'>1,2,1,3,2,10,4,12,7</span>
        </div><!-- d-flex -->

        <div class="d-flex align-items-center justify-content-between pd-x-15 mg-t-20">
          <div>
            <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">Daily Traffic</p>
            <h5 class="tx-lato tx-white tx-normal mg-b-0">62,201</h5>
          </div>
          <span class="peity-bar" data-peity='{ "fill": ["#9C7846"], "height": 35, "width": 60 }'>3,12,7,9,2,3,4,5,2</span>
        </div><!-- d-flex -->
      </div><!-- info-lst -->

      <br>
    </div> --}}<!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
     {{-- Main Nav Bar --}}
<!--     <div class="br-header remove-bg">
      <div class="br-header-left">


      </div>
      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
              <i class="icon ion-ios-email-outline tx-24 newcolor"></i>
             
              <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span>
            
            </a>

          </div>
          <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
              <i class="icon ion-ios-bell-outline tx-24 newcolor"></i>
            
              <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
      
            </a>

          </div>
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down newcolor newtext">@if($user){{$user->name}}@endif</span>
              <img src="" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li class="linktopnav"><a href=""><i class="icon ion-ios-person iconcolor"></i> Edit Profile</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-gear iconcolor"></i> Settings</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-download iconcolor"></i> Downloads</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-star iconcolor"></i> Favorites</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-folder iconcolor"></i> Collections</a></li>
                <li class="linktopnav"><a href="{{ url('logout') }}"><i class="icon ion-power iconcolor"></i> Sign Out</a></li>
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div> -->
    {{-- Main Nav Bar --}}
    <br>
 <!-- <div class="bd rounded border-menu" id="myHeader">
  <ul class="nav nav-gray-600 flex-column flex-sm-row" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#" role="tab">Home</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#" role="tab">About</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#" role="tab">Features</a></li>

  </ul>
</div> -->
<div class="bd rounded border-menu" id="myHeader">

<nav class="navbar navbar-expand-lg navbar-dark">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="main_nav">

<ul class="navbar-nav">

<li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}" > Home </a>
</li>

@can('View Club Membership Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('club-hospitality') }}" >  Club Memberships </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('club-hospitality/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
   
        @can('View Member Relations')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/member-relation') }}"> Member Relations </a></li>
     @endcan
    @can('View Member Type')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/member-classification') }}"> Member Type </a></li>
     @endcan
    @can('View Membership Category')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/member-category') }}"> Member Category </a></li>
     @endcan
      @can('View Membership Status')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/membership-status') }}"> Membership Status</a></li>
     @endcan
      @can('View Member Occupation')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/member-occupations') }}"> Member Occupation</a></li>
     @endcan
     @can('View Member Title')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/member-title') }}"> Member Title</a></li>
     @endcan
         @can('View Guest Types')
    <li><a class="dropdown-item" href="{{ url('room-management/guest-types') }}"> Guest Types </a></li>
     @endcan
       @can('View Corporate Companies')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/corporate-companies') }}"> Corporate Companies </a></li>
     @endcan
     </ul>
    </li>

   @can('View Membership')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/membership-vue') }}"> Membership </a></li>
     @endcan
    @can('View Corporate Membership')
     <li><a class="dropdown-item" href="{{ url('club-hospitality/corporate-membership-vue') }}"> Corporate Membership </a></li>
     @endcan
   @can('View Family Memberships')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/family-membership-vue') }}"> Family Memberships </a></li>
   @endcan
  @can('View Partners')
    <li><a class="dropdown-item" href="{{ url('club-hospitality/partners') }}"> Partners / Affiliates</a></li>
     @endcan
  @can('View Finance Invoices')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-new-invoices-vue') }}"> Invoices </a></li>
        @endcan
         @can('View Finance Cash Receipt')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Receipts  </a></li>
     @endcan

        @can('View Customer')
    <li><a class="dropdown-item" href="{{ url('room-management/room-customer') }}"> Guest </a></li>
     @endcan

              @can('View Reports Module Page')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/club-membership-management/reports') }}"> Reports &raquo</a>
<ul class="submenu dropdown-menu">


  <li><a class="dropdown-item" href="{{ url('finance-and-management/club-membership-management/maintenance-reports') }}"> Maintenance Reports &raquo</a>
<ul class="submenu dropdown-menu">
  @can('View Maintenance Fee Revenue')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/maintenance-fee-revenue') }}">Maintenance Fee Revenue </a></li>
         @endcan
            @can('View Quarterly Maintenance Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/maintenance-report-vue') }}">Quarterly Maintenance Report </a></li>
         @endcan
       @can('View Quarterly Maintenance Revenue Report')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/maintenance-report-rev-vue') }}">Quarterly Maintenance Revenue Report </a></li>
         @endcan
     @can('View Pending Maintenance Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/pending-maintenance-report-vue') }}">Pending Maintenance Report </a></li>
         @endcan
       @can('View Category-Wise Pending Maintenance Report')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/category-pending-maintenance-report-vue') }}">Pending Maintenance Report (Category-Wise) </a></li>
         @endcan
         @can('View Subscriptions and Maintenance Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/subscriptions-maintenance-summary-vue') }}">Subscriptions & Maintenance Summary </a></li>
         @endcan
       @can('View Category-Wise Subscriptions and Maintenance Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/category-subscriptions-maintenance-summary-vue') }}">Subscriptions & Maintenance Summary (Category-Wise) </a></li>
         @endcan
</ul>
      </li> 

        <li><a class="dropdown-item" href="{{ url('finance-and-management/club-membership-management/membership-reports') }}"> Membership Reports &raquo</a>
<ul class="submenu dropdown-menu">
  <!--  @can('View Membership Fee Revenue')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/membership-fee-revenue') }}">Membership Fee Revenue </a></li>
         @endcan -->
       
         @can('View Member Activities')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/member-activities-vue') }}">Member Activities </a></li>
         @endcan

         @can('View Member Card Detail Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/member-card-detail-report-vue') }}">Member Card Detail Report </a></li>
         @endcan
       
         @can('View Supplementary Card Detail Report')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/supplementary-card-detail-report-vue') }}">Supplementary Card Detail Report </a></li>
         @endcan

           @can('View Membership Summary')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/membership-summary-vue') }}"> Membership Summary </a></li>
         @endcan

           @can('View Category-Wise Membership Summary')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/category-membership-summary-vue') }}"> Membership Summary (Category-Wise) </a></li>
         @endcan

           @can('View Available Membership Numbers')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/available-membership-numbers-vue') }}"> Available Membership Numbers </a></li>
         @endcan
</ul>
      </li> 
         
</ul>
      </li>
        @endcan
       
   
        <!--  @can('View Finance Ledger Accounts')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-ledger-accounts') }}"> Finance Ledger Accounts </a></li>
        @endcan
        @can('View Finance Trial Balance')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-trial-balance') }}"> Finance Trial Balance </a></li>
        @endcan

      @can('View Finance Cash Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts') }}"> Cash Receipts </a></li>
         @endcan

         @can('View Finance Invoices')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-invoices') }}"> Invoices </a></li>
        @endcan -->

    </ul>
</li>
@endcan

@can('View Members Access Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('members-access') }}"> Access  </a>
    <ul class="dropdown-menu">
      @can('View Search Members')
    <li><a class="dropdown-item" href="{{ url('members-access/search-members') }}"> Search Members </a></li>
     @endcan

      @can('View Membership Status Confirmation')
    <li><a class="dropdown-item" href="{{ url('members-access/confirm-membership-status') }}"> Membership Status Confirmation </a></li>
     @endcan
    </ul>
</li>
@endcan


@can('View Sports Subscription')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('sports-subscription') }}" > Subscriptions </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('sports-subscription/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
       @can('View Subscription Types')
    <li><a class="dropdown-item" href="{{ url('sports-subscription/sports') }}"> Subscription Types </a></li>
     @endcan
     @can('View Club Facilities')
    <li><a class="dropdown-item" href="{{ url('sports-subscription/club-facilities') }}"> Club Facilities </a></li>
     @endcan
     </ul>
    </li>

     @can('View Subscriptions Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/subscriptions-datatable-vue') }}"> Sports Subscriptions </a></li>
     @endcan
       @can('View Maintenance Fee Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/maintenance-fee-datatable-vue') }}"> Monthly Maintenance Fee </a></li>
     @endcan
      @can('View Corporate Maintenance Fee Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/corporate-maintenance-fee-datatable-vue') }}"> Corporate Monthly Maintenance Fee </a></li>
     @endcan
       @can('View Card Printing Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/card-printing-datatable-vue') }}"> Card Printing </a></li>
     @endcan
      @can('View Corporate Card Printing Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/corporate-card-printing-datatable-vue') }}"> Corporate Card Printing </a></li>
     @endcan
     @can('View Reinstating Fee Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/reinstating-fee-datatable-vue') }}"> Reinstating Fee </a></li>
     @endcan
     @can('View Corporate Reinstating Fee Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/corporate-reinstating-fee-datatable-vue') }}"> Corporate Reinstating Fee </a></li>
     @endcan

    </ul>
</li>
@endcan

@can('View Food and Beverage')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('food-and-beverage') }}" >  F & B  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('food-and-beverage/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
    <!--   @can('View Printers')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/printers') }}"> Printers </a></li>
     @endcan -->
       @can('View POS Location')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/pos-locations') }}"> POS Locations </a></li>
         @endcan
          @can('View Restaurant Location')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/restaurant-locations') }}"> Restaurant Locations </a></li>
         @endcan
         @can('View Table Definition')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/table-definitions') }}"> Table Definitions </a></li>
         @endcan
      @can('View Waiter Definition')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/waiter-definitions') }}"> Waiter Definitions </a></li>
         @endcan
           @can('View Delivery Rider')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/delivery-riders') }}"> Delivery Riders </a></li>
         @endcan
          @can('View Measurement Unit')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/measurement-units') }}"> Measurement Units </a></li>
         @endcan
          @can('View Item Manufacturer')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-manufacturers') }}"> Item Manufacturers </a></li>
         @endcan
          @can('View Item Category')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-categories') }}"> Item Categories </a></li>
         @endcan
         @can('View Item Sub-Category')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-sub-categories') }}"> Item Sub-Categories </a></li>
         @endcan
         @can('View Product Classification')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/product-classifications') }}"> Product Classifications </a></li>
         @endcan
         @can('View Currency Definition')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/currency-definitions') }}"> Currency Definitions </a></li>
         @endcan
         @can('View Item Definition')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-definitions-vue') }}"> Item Definitions </a></li>
         @endcan
         @can('View Discount Card')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/discount-cards') }}"> Discount Cards </a></li>
         @endcan
         @can('View Cancelled Item Remark')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/cancelled-item-remarks') }}"> Cancelled Item Remarks </a></li>
         @endcan
        @can('View Cake Types')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/cake-types') }}"> Cake Types </a></li>
         @endcan
         @can('View ENT Details')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/ent-details') }}"> ENT Details </a></li>
         @endcan
     </ul>
    </li>

 @can('Add Sales') 
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/sales/sales-aeu') }}"> Sales </a></li>
    @endcan

  @can('View Sales') 
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/sales-list-vue') }}"> Sales List</a></li>
    @endcan

    @can('View Running Sales List')
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/running-sales-list-vue') }}"> Running Sales List</a></li>
    @endcan

     @can('View Shifts') 
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/shifts-vue') }}"> Shifts </a></li>
    @endcan

    @can('View User Shifts') 
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/user-shifts-vue') }}"> User Shifts </a></li>
    @endcan

     @can('View Cake Bookings')
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/cake-booking-vue') }}"> Cake Bookings </a></li>
    @endcan

  @can('View Cancelled Cake Bookings')
  <li><a class="dropdown-item" href="{{ url('food-and-beverage/cancelled-cake-booking-vue') }}"> Cancelled Cake Bookings </a></li>
    @endcan

  @can('View Customer')
    <li><a class="dropdown-item" href="{{ url('room-management/room-customer') }}"> Guest </a></li>
     @endcan

      @can('View Finance Cash Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Receipts </a></li>
         @endcan

 @can('View Reports Module Page')
               <li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports') }}"> Reports &raquo </a>
        <ul class="submenu dropdown-menu">
 <li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/dish-breakdown-reports') }}">Dish Breakdown Summaries &raquo </a>
 <ul class="submenu dropdown-menu">
   @can('View Dish Breakdown Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Price) </a></li>
         @endcan
          @can('View Sold Quantity Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sold-quantity-report-vue') }}">Dish Breakdown Summary (Sold Quantity) </a></li>
         @endcan
           @can('View Dish Breakdown Summary Restaurant-wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/restaurant-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Restaurant-wise) </a></li>
         @endcan
        @can('View Dish Breakdown Summary Date-wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/date-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Date-wise) </a></li>
         @endcan
        @can('View Yearly Dish Breakdown Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/yearly-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Yearly) </a></li>
         @endcan
 </ul>
 </li>
<li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/daily-reports') }}">Daily Reports &raquo </a>
 <ul class="submenu dropdown-menu">
   @can('View Daily Dump Items List')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-dump-items-vue') }}">Daily Dump Items List </a></li>
         @endcan
   @can('View Daily Cashier Sales List')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-cashier-sales-list-vue') }}">Daily Sales List (Cashier-wise) </a></li>
         @endcan
<!--  @can('View Daily Restaurant Sales Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-restaurant-sales-summary-vue') }}">Daily Sales Summary (Restaurant-wise) </a></li>
         @endcan -->
          @can('View Running Kitchen Order')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/reports/running-kitchen-order-vue') }}">Running Kitchen Orders </a></li>
         @endcan
          @can('View Running Sales Order')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/reports/running-sales-order') }}">Running Sales Orders </a></li>
         @endcan
 </ul>
 </li>
<li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/sale-reports') }}"> Sale Reports &raquo </a>
 <ul class="submenu dropdown-menu">
    @can('View Sales Summary')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/sales-vue') }}"> Sales Summary </a></li>
         @endcan
          @can('View Closing Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-sales-report-vue') }}">Closing Sales Report</a></li>
         @endcan
           @can('View Sales Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-sales-summary-vue') }}"> Sales Summary (with Items) </a></li>
         @endcan
           @can('View Sales KOT Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-kot-report-vue') }}"> Sales KOT Report </a></li>
         @endcan
           @can('View Sales Errors')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-errors-vue') }}"> Sales Errors </a></li>
         @endcan
             @can('View Monthly Employee Food Bills')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/food-bills-vue') }}"> Monthly Employee Food Bills </a></li>
         @endcan
            @can('View Total Monthly Employee Food Bills')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/total-food-bills-vue') }}"> Total Monthly Employee Food Bills </a></li>
         @endcan
 </ul>
 </li>
<li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/graphs-and-charts') }}"> Graphs & Charts &raquo </a>
 <ul class="submenu dropdown-menu">
     @can('View Hourly Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/hourly-sales-vue') }}"> Hourly Sales Report </a></li>
         @endcan 
           @can('View Weekdays Graphical Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/weekdays-graphical-sales-vue') }}"> Weekdays Graphical Sales Report </a></li>
         @endcan 
          @can('View Restaurant-wise Graphical Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/restaurant-graphical-sales-vue') }}"> Restaurant-Wise Graphical Sales Report </a></li>
         @endcan 
          @can('View Subcategory-wise Graphical Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/subcategory-graphical-sales-vue') }}"> Subcategory-Wise Graphical Sales Report </a></li>
         @endcan 
            @can('View Sales Dashboard')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-dashboard-vue') }}"> Sales Dashboard </a></li>
         @endcan
 </ul>
 </li>
       
        </ul>
      </li>
      @endcan
     
<!--          @can('View Reports Module Page')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports') }}"> Reports &raquo </a>
        <ul class="submenu dropdown-menu">
           @can('View Closing Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-sales-report-vue') }}">Closing Sales Report</a></li>
         @endcan
          @can('View Dish Breakdown Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Price) </a></li>
         @endcan
          @can('View Sold Quantity Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sold-quantity-report-vue') }}">Dish Breakdown Summary (Sold Quantity) </a></li>
         @endcan
          @can('View Dish Breakdown Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/restaurant-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Restaurant-wise) </a></li>
         @endcan
          @can('View Daily Dump Items List')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-dump-items-vue') }}">Daily Dump Items List </a></li>
         @endcan
          @can('View Running Kitchen Order')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/reports/running-kitchen-order') }}">Running Kitchen Orders </a></li>
         @endcan
          @can('View Running Sales Order')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/reports/running-sales-order') }}">Running Sales Orders </a></li>
         @endcan
           @can('View Sales')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/sales-vue') }}"> Sales Summary </a></li>
         @endcan
           @can('View Sales Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-sales-summary-vue') }}"> Sales Summary (with Items) </a></li>
         @endcan
         @can('View Sales Dashboard')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-dashboard-vue') }}"> Sales Dashboard </a></li>
         @endcan
         @can('View Hourly Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/hourly-sales-vue') }}"> Hourly Sales Report </a></li>
         @endcan

        </ul>
      </li>
      @endcan  -->


       <!--   @can('View Finance Ledger Accounts')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-ledger-accounts') }}"> Finance Ledger Accounts </a></li>
        @endcan
        @can('View Finance Trial Balance')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-trial-balance') }}"> Finance Trial Balance </a></li>
        @endcan -->

 <!-- @can('View Running Kitchen Order')
      <li><a class="dropdown-item" href="{{ url('food-and-beverage/running-kitchen-order') }}"> Running Kitchen Orders </a></li>
         @endcan

@can('View Running Sales Order')
      <li><a class="dropdown-item" href="{{ url('food-and-beverage/running-sales-order') }}"> Running Sales Orders </a></li>
         @endcan -->

    </ul>
</li>
@endcan


@can('View Rooms Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('room-management') }}" >  Rooms  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('room-management/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
    
        @can('View Customer')
    <li><a class="dropdown-item" href="{{ url('room-management/room-customer') }}"> Guest </a></li>
     @endcan
    @can('View Room Type')
    <li><a class="dropdown-item" href="{{ url('room-management/room-type') }}"> Room Types </a></li>
     @endcan
    @can('View Room Rate Categories')
    <li><a class="dropdown-item" href="{{ url('room-management/room-category') }}"> Room Rate Categories </a></li>
     @endcan
    @can('View Room Charges Type')
    <li><a class="dropdown-item" href="{{ url('room-management/room-charges-type') }}"> Room Charges Type </a></li>
     @endcan
    @can('View Rooms')
    <li><a class="dropdown-item" href="{{ url('room-management/room') }}"> Rooms </a></li>
     @endcan
  @can('View Room Table Definition Mapping')
<li><a class="dropdown-item" href="{{ url('room-management/room-table-mapping-vue') }}"> Room Table Definition Mapping </a></li>
  @endcan
     </ul>
    </li>

   @can('View Room Booking')
    <li><a class="dropdown-item" href="{{ url('room-management/room-booking-vue') }}"> Room Booking </a></li>
     @endcan
    @can('View Check In')
    <li><a class="dropdown-item" href="{{ url('room-management/room-check-in') }}"> Room Check-In </a></li>
     @endcan
    @can('View Check Out')
    <li><a class="dropdown-item" href="{{ url('room-management/room-check-out-vue') }}"> Room Check-Out </a></li>
     @endcan
      @can('View Unpaid Check Out')
    <li><a class="dropdown-item" href="{{ url('room-management/room-check-out-unpaid-vue') }}"> Room Check-Out (Un-Paid) </a></li>
     @endcan
    @can('View Room Booking Calendar')
    <li><a class="dropdown-item" href="{{ url('room-management/calender') }}"> Room Booking Calendar </a></li>
     @endcan
    @can('View Finance Cash Receipt')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Receipts  </a></li>
     @endcan
  
    @can('View Room Reminders')
    <li><a class="dropdown-item" href="#"> Room Reminders  </a></li>
      @endcan

      @can('View Reports Module Page')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/room-management/reports') }}"> Reports &raquo </a>
        <ul class="submenu dropdown-menu">
          @can('View Reports')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-reports') }}"> Room Reports &raquo </a>
      <ul class="submenu dropdown-menu">
        @can('View Check Out Report')
          <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-reports/rooms-revenue-report') }}"> Rooms Revenue Report  </a></li>
        @endcan
          <li><a class="dropdown-item" href="#"> Cash Report </a></li>
      </ul>
        </li>
        @endcan
        </ul>
      </li>
      @endcan 

    <!--  @can('View Reports')
    <li><a class="dropdown-item" href="{{ url('room-management/room-reports') }}"> Reports &raquo </a>
     <ul class="submenu dropdown-menu">
       @can('View Check Out Report')
        <li><a class="dropdown-item" href="{{ url('room-management/room-reports/check-out-report') }}"> Rooms Check-Out Report </a></li>
         @endcan
        <li><a class="dropdown-item" href="#"> Cash Report </a></li>
     </ul>
    </li>
     @endcan -->

    </ul>
</li>
@endcan


@can('View Events Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('events-management') }}" >  Events  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('events-management/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
      @can('View Customer')
    <li><a class="dropdown-item" href="{{ url('events-management/event-customer') }}"> Event Guest </a></li>
     @endcan
    @can('View Menu Type')
    <li><a class="dropdown-item" href="{{ url('events-management/menu-type') }}"> Menu Types </a></li>
     @endcan
    @can('View Menu Rate Category')
    <li><a class="dropdown-item" href="{{ url('events-management/menu-category') }}"> Menu Rate Categories </a></li>
     @endcan
     @can('View Event Charges Type')
    <li><a class="dropdown-item" href="{{ url('events-management/event-charges-type') }}"> Event Charges Type </a></li>
     @endcan
    @can('View Venues')
    <li><a class="dropdown-item" href="{{ url('events-management/event-venue') }}"> Venues </a></li>
     @endcan
     @can('View Menus')
    <li><a class="dropdown-item" href="{{ url('events-management/menus') }}"> Menus </a></li>
     @endcan
      @can('View Menu Add Ons')
    <li><a class="dropdown-item" href="{{ url('events-management/menu-add-ons') }}"> Menus Add-Ons</a></li>
     @endcan
     </ul>
    </li>

 @can('View Event Booking')
    <li><a class="dropdown-item" href="{{ url('events-management/event-booking-vue') }}"> Event Booking </a></li>
     @endcan
    @can('View Event Check Out')
    <li><a class="dropdown-item" href="{{ url('events-management/event-checkout-vue') }}"> Event Completion </a></li>
     @endcan
      @can('View Cancelled Event Bookings')
    <li><a class="dropdown-item" href="{{ url('events-management/event-booking/cancelled-vue') }}"> Event Cancellation </a></li>
     @endcan
     @can('View Event Calendar')
    <li><a class="dropdown-item" href="{{ url('events-management/calendar') }}"> Event Calendar </a></li>
     @endcan
  
    </ul>
</li>
@endcan

 
@can('View Maintenance Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('maintenance-management') }}" >  Maintenance  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('maintenance-management/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
     @can('View Work Order Departments')
<li><a class="dropdown-item" href="{{ url('maintenance-management/work-order-departments') }}"> Work Order Departments </a></li>
     @endcan
     </ul>
    </li>
 @can('View Work Order Sheet')
    <li><a class="dropdown-item" href="{{ url('maintenance-management/work-order-sheet-vue') }}"> Work Order Sheet </a></li>
     @endcan
    </ul>
</li>
@endcan




@can('View Finance and Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('finance-and-management') }}"> Finance </a>
    <ul class="dropdown-menu">
  <!--   @can('View Payments Module Page')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-payments-submodules') }}"> Receipts &raquo </a>
     <ul class="submenu dropdown-menu">
        @can('View Finance Cash Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Cash Receipts </a></li>
         @endcan
          @can('View Finance Payment Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-payment-receipts-vue') }}"> Payment Receipts </a></li>
         @endcan
     </ul>
    </li>
     @endcan -->
    <li><a class="dropdown-item" href="{{ url('finance-and-management/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
        @can('View Books')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/books') }}"> Books </a></li>
        @endcan
         @can('View Ledger Persons')
<li><a class="dropdown-item" href="{{ url('finance-and-management/suppliers') }}"> Suppliers </a></li>
    @endcan
     @can('View Payment Methods')
<li><a class="dropdown-item" href="{{ url('finance-and-management/finance-payment-methods') }}"> Payment Methods </a></li>
    @endcan
 @can('View Accounts Linking')
<li><a class="dropdown-item" href="{{ url('finance-and-management/coa-linking') }}"> Trans Type & COA Linking </a></li>
    @endcan
     </ul>
    </li>
   <!--  @can('View Expenses Module Page')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expenses-submodules') }}"> Expenses &raquo </a>
     <ul class="submenu dropdown-menu">

       <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expenses-submodules/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
      @can('View Expense Heads')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expense-heads') }}"> Expense Heads </a></li>
      @endcan
      @can('View Expense Payables')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expense-paid-for') }}"> Expense Payables </a></li>
         @endcan
     </ul>
    </li>
      @can('View Expenses')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expenses-vue') }}"> Expenses </a></li>
         @endcan
     </ul>
    </li>
     @endcan -->

    @can('View Invoices Module Page')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-invoices-submodules') }}"> Invoices &raquo </a>
     <ul class="submenu dropdown-menu">

      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-invoices-submodules/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
    @can('View Invoice Charges Types')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/invoice-charges-types') }}"> Invoice Charges Types </a></li>
        @endcan
     </ul>
    </li>
     @can('View Finance Invoices')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-new-invoices-vue') }}"> Invoices </a></li>
        @endcan
         @can('View Finance Invoices')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cancelled-invoices-vue') }}"> Cancelled Invoices </a></li>
        @endcan
        @can('View Monthly Maintenance Fee Posting')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/maintenance-fee-posting/maintenance-fee-posting-aeu') }}"> Monthly Maintenance Fee Posting </a></li>
         @endcan

      <!--     <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-invoices-submodules/sales') }}"> Sales &raquo </a>
     <ul class="submenu dropdown-menu">
   @can('View Store Sales')
    <li><a class="dropdown-item" href="{{ url('store-management/store-sales-vue') }}"> General Sales </a></li>
     @endcan
      @can('View Expenses')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expenses-vue') }}"> Expenses </a></li>
      @endcan
        @can('View Customer')
    <li><a class="dropdown-item" href="{{ url('room-management/room-customer') }}"> Guest </a></li>
     @endcan
     @can('View Finance Cash Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Receipts </a></li>
         @endcan
     </ul>
    </li> -->
     </ul>
    </li>
     @endcan
  @can('View Expenses')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-expenses-vue') }}"> Expenses </a></li>
      @endcan
    

     @can('View Vouchers Module Page')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-vouchers-submodules') }}"> Vouchers &raquo </a>
     <ul class="submenu dropdown-menu">

       <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-vouchers-submodules/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
       @can('View Voucher Types')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-voucher-types') }}"> Voucher Types </a></li>
        @endcan
     </ul>
    </li>
     @can('View Finance Cash Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Receipts </a></li>
         @endcan
          @can('View Finance Payment Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-payment-receipts-vue') }}"> Payments </a></li>
         @endcan
        @can('View General Voucher')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-voucher') }}"> General Vouchers </a></li>
        @endcan
     </ul>
    </li>
     @endcan
    @can('View Chart of Accounts')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/chart-of-accounts') }}"> Chart of Accounts &raquo </a>
     <ul class="submenu dropdown-menu">

<!--       <li><a class="dropdown-item" href="{{ url('finance-and-management/chart-of-accounts/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
    @can('View Ledger Persons')
<li><a class="dropdown-item" href="{{ url('finance-and-management/suppliers') }}"> Suppliers </a></li>
    @endcan
     @can('View Payment Methods')
<li><a class="dropdown-item" href="{{ url('finance-and-management/finance-payment-methods') }}"> Payment Methods </a></li>
    @endcan
<li><a class="dropdown-item" href="{{ url('finance-and-management/chart-of-accounts/definitions/levels-of-accounts') }}"> Levels of Accounts &raquo </a>
  <ul class="submenu dropdown-menu">
    @can('View Level One')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-level-one') }}"> Level One </a></li>
     @endcan
     @can('View Level Two')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-level-two') }}"> Level Two </a></li>
     @endcan
     @can('View Level Three')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-level-three') }}"> Level Three </a></li>
     @endcan
     @can('View Account Heads')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-account-heads') }}"> Level Four </a></li>
      @endcan
    @can('View Account Types')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-account-types') }}"> Level Five </a></li>
      @endcan
  </ul>
</li>
 @can('View Accounts Linking')
<li><a class="dropdown-item" href="{{ url('finance-and-management/coa-linking') }}"> Trans Type & COA Linking </a></li>
    @endcan
</ul>
</li> -->
        @can('View COA')
        <li><a class="dropdown-item" href="{{ url('COA-new') }}"> Chart of Accounts Details </a></li>
        @endcan
        @can('View COA Listing')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/COA-listing') }}"> Chart of Accounts Listing </a></li>
        @endcan
           @can('View COA Ledgers')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/coa-ledgers-vue') }}"> Chart of Accounts Ledgers </a></li>
        @endcan
           @can('View COA Trial Balance')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/coa-trial-balance-vue') }}"> Chart of Accounts Trial Balance </a></li>
        @endcan

     </ul>
    </li>
 @endcan
    @can('View Reports Module Page')
    <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-reports-submodules') }}"> Reports &raquo </a>

     <ul class="submenu dropdown-menu">
           <li><a class="dropdown-item" href="{{ url('finance-and-management/club-membership-management/reports') }}"> Club Membership Management &raquo</a>
<ul class="submenu dropdown-menu">


  <li><a class="dropdown-item" href="{{ url('finance-and-management/club-membership-management/maintenance-reports') }}"> Maintenance Reports &raquo</a>
<ul class="submenu dropdown-menu">
  @can('View Maintenance Fee Revenue')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/maintenance-fee-revenue') }}">Maintenance Fee Revenue </a></li>
         @endcan
            @can('View Quarterly Maintenance Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/maintenance-report-vue') }}">Quarterly Maintenance Report </a></li>
         @endcan
       @can('View Quarterly Maintenance Revenue Report')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/maintenance-report-rev-vue') }}">Quarterly Maintenance Revenue Report </a></li>
         @endcan
     @can('View Pending Maintenance Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/pending-maintenance-report-vue') }}">Pending Maintenance Report </a></li>
         @endcan
       @can('View Category-Wise Pending Maintenance Report')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/category-pending-maintenance-report-vue') }}">Pending Maintenance Report (Category-Wise) </a></li>
         @endcan
        @can('View Subscriptions and Maintenance Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/subscriptions-maintenance-summary-vue') }}">Subscriptions & Maintenance Summary </a></li>
         @endcan
       @can('View Category-Wise Subscriptions and Maintenance Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/category-subscriptions-maintenance-summary-vue') }}">Subscriptions & Maintenance Summary (Category-Wise) </a></li>
         @endcan
</ul>
      </li> 
                <li><a class="dropdown-item" href="{{ url('finance-and-management/club-membership-management/membership-reports') }}"> Membership Reports &raquo</a>
<ul class="submenu dropdown-menu">
  <!--  @can('View Membership Fee Revenue')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/membership-fee-revenue') }}">Membership Fee Revenue </a></li>
         @endcan -->
       
         @can('View Member Activities')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/member-activities-vue') }}">Member Activities </a></li>
         @endcan

         @can('View Member Card Detail Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/member-card-detail-report-vue') }}">Member Card Detail Report </a></li>
         @endcan
       
         @can('View Supplementary Card Detail Report')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/supplementary-card-detail-report-vue') }}">Supplementary Card Detail Report </a></li>
         @endcan

           @can('View Membership Summary')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/membership-summary-vue') }}"> Membership Summary </a></li>
         @endcan

           @can('View Category-Wise Membership Summary')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/category-membership-summary-vue') }}"> Membership Summary (Category-Wise) </a></li>
         @endcan

           @can('View Available Membership Numbers')  
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/available-membership-numbers-vue') }}"> Available Membership Numbers </a></li>
         @endcan
</ul>
      </li> 
</ul>
      </li>
      

          <li><a class="dropdown-item" href="{{ url('finance-and-management/room-management/reports') }}"> Member Subscriptions &raquo </a>
        <ul class="submenu dropdown-menu">
         @can('View Subscriptions Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/subscriptions-datatable-vue') }}"> SportsSubscriptions </a></li>
     @endcan
       @can('View Maintenance Fee Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/maintenance-fee-datatable-vue') }}"> Monthly Maintenance Fee </a></li>
     @endcan
       @can('View Card Printing Datatable')
<li><a class="dropdown-item" href="{{ url('sports-subscription/card-printing-datatable-vue') }}"> Card Printing </a></li>
     @endcan
        </ul>
      </li>

   <!--    <li><a class="dropdown-item" href="{{ url('') }}"> Members Access Management</a></li>
       <li><a class="dropdown-item" href="{{ url('') }}"> Sports Subscription </a></li> -->
      <li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports') }}"> Food & Beverage &raquo </a>
        <ul class="submenu dropdown-menu">
 <li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/dish-breakdown-reports') }}">Dish Breakdown Summaries &raquo </a>
 <ul class="submenu dropdown-menu">
    @can('View Dish Breakdown Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Price) </a></li>
         @endcan
          @can('View Sold Quantity Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sold-quantity-report-vue') }}">Dish Breakdown Summary (Sold Quantity) </a></li>
         @endcan
           @can('View Dish Breakdown Summary Restaurant-wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/restaurant-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Restaurant-wise) </a></li>
         @endcan
        @can('View Dish Breakdown Summary Date-wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/date-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Date-wise) </a></li>
         @endcan
        @can('View Yearly Dish Breakdown Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/yearly-dish-breakdown-summary-vue') }}">Dish Breakdown Summary (Yearly) </a></li>
         @endcan
 </ul>
 </li>
<li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/daily-reports') }}">Daily Reports &raquo </a>
 <ul class="submenu dropdown-menu">
    @can('View Daily Dump Items List')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-dump-items-vue') }}">Daily Dump Items List </a></li>
         @endcan
   @can('View Daily Cashier Sales List')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-cashier-sales-list-vue') }}">Daily Sales List (Cashier-wise) </a></li>
         @endcan
<!--  @can('View Daily Restaurant Sales Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/daily-restaurant-sales-summary-vue') }}">Daily Sales Summary (Restaurant-wise) </a></li>
         @endcan -->
          @can('View Running Kitchen Order')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/reports/running-kitchen-order-vue') }}">Running Kitchen Orders </a></li>
         @endcan
          @can('View Running Sales Order')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/reports/running-sales-order') }}">Running Sales Orders </a></li>
         @endcan
 </ul>
 </li>
<li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/sale-reports') }}"> Sale Reports &raquo </a>
 <ul class="submenu dropdown-menu">
      @can('View Sales Summary')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/sales-vue') }}"> Sales Summary </a></li>
         @endcan
          @can('View Closing Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-sales-report-vue') }}">Closing Sales Report</a></li>
         @endcan
           @can('View Sales Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-sales-summary-vue') }}"> Sales Summary (with Items) </a></li>
         @endcan
           @can('View Sales KOT Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-kot-report-vue') }}"> Sales KOT Report </a></li>
         @endcan
          @can('View Sales Errors')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-errors-vue') }}"> Sales Errors </a></li>
         @endcan
           @can('View Monthly Employee Food Bills')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/food-bills-vue') }}"> Monthly Employee Food Bills </a></li>
         @endcan
            @can('View Total Monthly Employee Food Bills')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/total-food-bills-vue') }}"> Total Monthly Employee Food Bills </a></li>
         @endcan
 </ul>
 </li>
<li><a class="dropdown-item" href="{{ url('finance-and-management/food-and-beverage/reports/graphs-and-charts') }}"> Graphs & Charts &raquo </a>
 <ul class="submenu dropdown-menu">
     @can('View Hourly Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/hourly-sales-vue') }}"> Hourly Sales Report </a></li>
         @endcan 
           @can('View Weekdays Graphical Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/weekdays-graphical-sales-vue') }}"> Weekdays Graphical Sales Report </a></li>
         @endcan 
          @can('View Restaurant-wise Graphical Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/restaurant-graphical-sales-vue') }}"> Restaurant-Wise Graphical Sales Report </a></li>
         @endcan 
          @can('View Subcategory-wise Graphical Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/subcategory-graphical-sales-vue') }}"> Subcategory-Wise Graphical Sales Report </a></li>
         @endcan 
            @can('View Sales Dashboard')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/sales-dashboard-vue') }}"> Sales Dashboard </a></li>
         @endcan
 </ul>
 </li>
       
        </ul>
      </li>
      <li><a class="dropdown-item" href="{{ url('finance-and-management/room-management/reports') }}"> Rooms Management &raquo </a>
        <ul class="submenu dropdown-menu">
          @can('View Reports')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-reports') }}"> Room Reports &raquo </a>
      <ul class="submenu dropdown-menu">
        @can('View Check Out Report')
          <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-reports/rooms-revenue-report') }}"> Rooms Revenue Report  </a></li>
        @endcan
          <li><a class="dropdown-item" href="#"> Cash Report </a></li>
      </ul>
        </li>
        @endcan 
        </ul>
      </li>
     <!--  <li><a class="dropdown-item" href="{{ url('') }}"> Events Management</a></li>
      <li><a class="dropdown-item" href="{{ url('') }}"> Maintenance Management</a></li> -->
      <li><a class="dropdown-item" href="{{ url('finance-and-management/reports') }}"> Finance Management &raquo </a>
        <ul class="submenu dropdown-menu">
          <li><a class="dropdown-item" href="{{ url('finance-and-management/ledgers-and-trial-balances') }}"> Ledgers & Trial Balances &raquo </a>
 <ul class="submenu dropdown-menu">
      @can('View Finance Ledger Accounts')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/member-guest-ledgers-vue') }}"> Member / Guest Ledgers </a></li>
        @endcan
        @can('View Finance Trial Balance')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/member-guest-trial-balance-vue') }}"> Member / Guest Trial Balance </a></li>
        @endcan
          @can('View Supplier Ledger Accounts')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/supplier-ledgers-vue') }}"> Supplier Ledgers </a></li>
        @endcan
        @can('View Supplier Trial Balance')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/supplier-trial-balance-vue') }}"> Supplier Trial Balance </a></li>
        @endcan
         @can('View COA Ledgers')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/coa-ledgers-vue') }}"> COA Ledgers </a></li>
        @endcan
        @can('View COA Trial Balance')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/coa-trial-balance-vue') }}"> COA Trial Balance </a></li>
        @endcan
        @can('View Accounts Ledgers')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/accounts-ledgers-vue') }}"> Accounts Ledgers </a></li>
        @endcan
        @can('View Accounts Trial Balance')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/accounts-trial-balance-vue') }}"> Accounts Trial Balance </a></li>
        @endcan
 </ul>
 </li>
       @can('View Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-sales-report-vue') }}"> Sales Report </a></li>
        @endcan
           @can('View Cash Flow')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-flow') }}"> Cash Flow </a></li>
         @endcan 
         @can('View Accounts Balance')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/accounts-balance-vue') }}"> Accounts Balance </a></li>
        @endcan  
          @can('View Revenue Summary Report')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/revenue-summary-vue') }}"> Revenue Summary Report (Section-Wise) </a></li>
        @endcan
          @can('View Member Revenue Summary Report')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/member-revenue-summary-vue') }}"> Member Revenue Summary Report (Category-Wise) </a></li>
        @endcan
           @can('View Daily Finance Transaction Book')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/transaction-book-vue') }}"> Daily Finance Transaction Book </a></li>
        @endcan
          @can('View Daily Cash Book')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/cash-book-vue') }}"> Daily Cash Book </a></li>
        @endcan
     @can('View Bank Ledger')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/bank-ledger-vue') }}"> Bank Ledger </a></li>
      @endcan
     @can('View Chart of Accounts List')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/general-ledger-vue') }}"> General Ledger </a></li>
      @endcan
         <!--  @can('View Finance Ledger Accounts')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-ledger-accounts') }}"> Finance Ledger Accounts </a></li>
        @endcan
        @can('View Finance Trial Balance')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-trial-balance') }}"> Finance Trial Balance </a></li>
        @endcan
         @can('View Cash Flow')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-flow') }}"> Cash Flow </a></li>
         @endcan -->
      </ul>
        </li>



      <li><a class="dropdown-item" href="{{ url('finance-and-management/crm/reports') }}"> CRM &raquo</a>
<ul class="submenu dropdown-menu">
        @can('View BD Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/bd-report-vue') }}">BD Report </a></li>
         @endcan
          @can('View Lead Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/lead-report-vue') }}">Lead Report </a></li>
         @endcan
</ul>
      </li>

       <li><a class="dropdown-item" href="{{ url('finance-and-management/store-management/reports') }}"> Store Management &raquo</a>
<ul class="submenu dropdown-menu">
        @can('View Dish Breakdown Purchase Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-purchase-summary-vue') }}">Dish Breakdown Purchase Summary </a></li>
         @endcan
          @can('View Closing Purchases Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-purchases-report-vue') }}">Closing Purchases Report </a></li>
         @endcan
          @can('View Purchases Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-purchases-summary-vue') }}">Purchases Summary (With Items) </a></li>
         @endcan
        @can('View Purchases Errors')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/purchases-errors-vue') }}">Purchases Errors </a></li>
         @endcan
       @can('View Store Issue Note Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/issue-note-summary-vue') }}">Issue Note Summary </a></li>
         @endcan
       @can('View Item Issue Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-summary-vue') }}">Item Issue Summary </a></li>
         @endcan
       @can('View Issue Note Summary Detail')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/issue-note-summary-detail-vue') }}">Issue Note Summary Detail </a></li>
         @endcan
         @can('View Item Issue Detail')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-detail-vue') }}">Item Issue Detail </a></li>
         @endcan
        @can('View Item Closing Stock Sale Wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-sale-closing-stock-vue') }}">Item Closing Stock (Sale-Wise) </a></li>
         @endcan
         @can('View Item Closing Stock Issuance Wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-closing-stock-vue') }}">Item Closing Stock (Issuance-Wise) </a></li>
         @endcan
</ul>
      </li>


       <li><a class="dropdown-item" href="{{ url('finance-and-management/sales/reports') }}"> Sales &raquo</a>
<ul class="submenu dropdown-menu">
      
          @can('View Dish Breakdown Store Sale Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-store-sale-summary-vue') }}">Dish Breakdown Store Sale Summary </a></li>
         @endcan
        @can('View Closing Store Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-store-sales-report-vue') }}">Closing Store Sales Report </a></li>
         @endcan
        @can('View Store Sales Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-store-sales-summary-vue') }}">Store Sales Summary (With Items) </a></li>
         @endcan
        @can('View Store Sales Errors')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/store-sales-errors-vue') }}">Store Sales Errors </a></li>
         @endcan
        @can('View Monthly Store Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/monthly-store-report-vue') }}">Monthly Store Report </a></li>
         @endcan
</ul>
      </li>


       <!--  <li><a class="dropdown-item" href="{{ url('') }}"> Sales & Marketing</a></li>
      <li><a class="dropdown-item" href="{{ url('') }}"> Customer Relationship & Management</a></li>
      <li><a class="dropdown-item" href="{{ url('') }}"> Human Resource Management</a></li>
      <li><a class="dropdown-item" href="{{ url('') }}"> Legal Management</a></li>
      <li><a class="dropdown-item" href="{{ url('') }}"> Store Management</a></li>
      <li><a class="dropdown-item" href="{{ url('') }}"> Admin Settings</a></li> -->
        </ul>
      </li>   
      @endcan 
    </ul>
</li>
@endcan

@can('View Sales and Marketing')
<li class="nav-item"> <a class="nav-link" href="#"> Marketing </a> </li>
@endcan


@can('View CRM')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('crm') }}" >  CRM  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('crm/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
     
        @can('View Leads Status')
        <li><a class="dropdown-item" href="{{ url('crm/leads-status') }}"> Leads Status </a></li>
         @endcan
         @can('View Calls Status')
        <li><a class="dropdown-item" href="{{ url('crm/calls-status') }}"> Calls Status </a></li>
         @endcan
          @can('View Lead Sources')
        <li><a class="dropdown-item" href="{{ url('crm/lead-sources') }}"> Lead Sources </a></li>
         @endcan
         @can('View Reasons')
        <li><a class="dropdown-item" href="{{ url('crm/reasons') }}"> Reasons / Remarks </a></li>
         @endcan
       
     </ul>
    </li>
@can('View CRM Dashboard')
    <li><a class="dropdown-item" href="{{ url('crm/dashboard-vue') }}"> CRM Dashboard </a></li>
     @endcan
@can('View Leads')
    <li><a class="dropdown-item" href="{{ url('crm/leads-vue') }}"> Leads </a></li>
     @endcan
@can('View Follow Ups')
    <li><a class="dropdown-item" href="{{ url('crm/follow-ups-vue') }}"> Follow Ups </a></li>
     @endcan
@can('View Visits')
    <li><a class="dropdown-item" href="{{ url('crm/visits-vue') }}"> Visits </a></li>
     @endcan
@can('View Call Details')
    <li><a class="dropdown-item" href="{{ url('crm/call-details-vue') }}"> Call Details </a></li>
@endcan
@can('View Member Recoveries')
    <li><a class="dropdown-item" href="{{ url('crm/visits-comment-sheet-vue') }}"> Visits Comment Sheet </a></li>
@endcan
@can('View Complaints')
    <li><a class="dropdown-item" href="{{ url('crm/complaints-vue') }}"> Complaints </a></li>
@endcan
@can('View Reports Module Page')  
      <li><a class="dropdown-item" href="{{ url('finance-and-management/crm/reports') }}"> Reports &raquo</a>
<ul class="submenu dropdown-menu">
        @can('View BD Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/bd-report-vue') }}">BD Report </a></li>
         @endcan
          @can('View Lead Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/lead-report-vue') }}">Lead Report </a></li>
         @endcan
</ul>
      </li>
        @endcan

    </ul>
</li>
@endcan



@can('View Human Resource Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('human-resource') }}" >  HRM  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('human-resource/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
     <!--  @can('View Companies')
    <li><a class="dropdown-item" href="{{ url('human-resource/companies') }}"> Companies </a></li>
     @endcan -->
     @can('View Departments')
    <li><a class="dropdown-item" href="{{ url('human-resource/departments') }}"> Departments </a></li>
     @endcan
     @can('View Sub-Departments')
    <li><a class="dropdown-item" href="{{ url('human-resource/sub-departments') }}"> Sub-Departments </a></li>
     @endcan
      @can('View Salary Add-Ons')
    <li><a class="dropdown-item" href="{{ url('human-resource/salary-add-ons') }}"> Salary Add-Ons </a></li>
     @endcan
     @can('View Salary Deductions')
    <li><a class="dropdown-item" href="{{ url('human-resource/salary-deductions') }}"> Salary Deductions </a></li>
     @endcan
     </ul>
    </li>
@can('View Employment')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment-vue') }}"> Employment </a></li>
     @endcan
    @can('Check In Employee')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment/checkin') }}"> Check-In Employee </a></li>
     @endcan
    @can('Check Out Employee')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment/check_out') }}"> Check-Out Employee </a></li>
     @endcan
     @can('View Employee In and Out')
    <li><a class="dropdown-item" href="{{ url('human-resource/employee-in-out-vue') }}"> Employee In & Out </a></li>
     @endcan
     @can('View Daily Employee Attendance')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment/daily-attend-vue') }}"> Daily Employee Attendance </a></li>
     @endcan
     @can('View Employee Attendance')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment/attend-vue') }}"> Monthly Employee Attendance </a></li>
     @endcan
     @can('View Employee Payroll')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment/payroll-vue') }}"> Employee Payroll </a></li>
     @endcan
     @can('View Employee Salary Voucher')
    <li><a class="dropdown-item" href="{{ url('human-resource/employment/salary-vue') }}"> Employee Salary Voucher</a></li>
     @endcan

    </ul>
</li>
@endcan


@can('View Legal Management')
<li class="nav-item"> <a class="nav-link" href="#"> Legal </a> </li>
@endcan


@can('View Store Management')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('store-management') }}" >  Store  </a>
    <ul class="dropdown-menu">
    
    <li><a class="dropdown-item" href="{{ url('store-management/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
     
        @can('View Store Location')
        <li><a class="dropdown-item" href="{{ url('store-management/store-locations') }}"> Store Locations </a></li>
         @endcan
         @can('View Store Departments')
        <li><a class="dropdown-item" href="{{ url('store-management/store-departments') }}"> Store Departments </a></li>
         @endcan
          @can('View Restaurant Section Definitions')
        <li><a class="dropdown-item" href="{{ url('store-management/restaurant-section-definitions') }}"> Restaurant Section Definitions </a></li>
         @endcan
          @can('View Section Department Mapping')
        <li><a class="dropdown-item" href="{{ url('store-management/section-department-mapping') }}"> Section Department Mapping </a></li>
         @endcan
          @can('View Item Category')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-categories') }}"> Item Categories </a></li>
         @endcan
         @can('View Item Sub-Category')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-sub-categories') }}"> Item Sub-Categories </a></li>
         @endcan
         @can('View Item Definition')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-definitions-vue') }}"> Item Definitions </a></li>
         @endcan
         @can('View Cancellation Remarks')
        <li><a class="dropdown-item" href="{{ url('store-management/cancellation-remarks-vue') }}"> Cancellation Remarks </a></li>
         @endcan
       
     </ul>
    </li>
@can('View Store Purchases')
    <li><a class="dropdown-item" href="{{ url('store-management/store-purchases-vue') }}"> Store Purchases </a></li>
     @endcan
@can('View Store Issue Note')
    <li><a class="dropdown-item" href="{{ url('store-management/store-issue-note-vue') }}"> Store Issue Note </a></li>
     @endcan
     @can('View Ledger Persons')
<li><a class="dropdown-item" href="{{ url('finance-and-management/suppliers') }}"> Suppliers </a></li>
    @endcan
          @can('View Finance Payment Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-payment-receipts-vue') }}"> Payments </a></li>
         @endcan
@can('View Reports Module Page')  
      <li><a class="dropdown-item" href="{{ url('finance-and-management/store-management/reports') }}"> Reports &raquo</a>
<ul class="submenu dropdown-menu">
        @can('View Dish Breakdown Purchase Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-purchase-summary-vue') }}">Dish Breakdown Purchase Summary </a></li>
         @endcan
          @can('View Closing Purchases Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-purchases-report-vue') }}">Closing Purchases Report </a></li>
         @endcan
          @can('View Purchases Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-purchases-summary-vue') }}">Purchases Summary (With Items) </a></li>
         @endcan
        @can('View Purchases Errors')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/purchases-errors-vue') }}">Purchases Errors </a></li>
         @endcan
       @can('View Store Issue Note Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/issue-note-summary-vue') }}">Issue Note Summary </a></li>
         @endcan
       @can('View Item Issue Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-summary-vue') }}">Item Issue Summary </a></li>
         @endcan
       @can('View Issue Note Summary Detail')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/issue-note-summary-detail-vue') }}">Issue Note Summary Detail </a></li>
         @endcan
         @can('View Item Issue Detail')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-detail-vue') }}">Item Issue Detail </a></li>
         @endcan
         @can('View Item Closing Stock Sale Wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-sale-closing-stock-vue') }}">Item Closing Stock (Sale-Wise) </a></li>
         @endcan
  @can('View Item Closing Stock Details Sale Wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-sale-closing-stock-details-vue') }}">Item Closing Stock Details (Sale-Wise) </a></li>
         @endcan
         @can('View Item Closing Stock Issuance Wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-closing-stock-vue') }}">Item Closing Stock (Issuance-Wise) </a></li>
         @endcan
         @can('View Item Closing Stock Details Issuance Wise')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/item-issue-closing-stock-details-vue') }}">Item Closing Stock Details (Issuance-Wise) </a></li>
         @endcan
</ul>
      </li>
        @endcan

    </ul>
</li>
@endcan


@can('View General Sales')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('sales') }}" >  Sales  </a>
    <ul class="dropdown-menu">

          <li><a class="dropdown-item" href="{{ url('sales/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
     
        @can('View Store Location')
        <li><a class="dropdown-item" href="{{ url('store-management/store-locations') }}"> Store Locations </a></li>
         @endcan
         @can('View Store Departments')
        <li><a class="dropdown-item" href="{{ url('store-management/store-departments') }}"> Store Departments </a></li>
         @endcan
          @can('View Restaurant Section Definitions')
        <li><a class="dropdown-item" href="{{ url('store-management/restaurant-section-definitions') }}"> Restaurant Section Definitions </a></li>
         @endcan
          @can('View Section Department Mapping')
        <li><a class="dropdown-item" href="{{ url('store-management/section-department-mapping') }}"> Section Department Mapping </a></li>
         @endcan
          @can('View Item Category')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-categories') }}"> Item Categories </a></li>
         @endcan
         @can('View Item Sub-Category')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-sub-categories') }}"> Item Sub-Categories </a></li>
         @endcan
         @can('View Item Definition')
        <li><a class="dropdown-item" href="{{ url('food-and-beverage/item-definitions-vue') }}"> Item Definitions </a></li>
         @endcan
         @can('View Cancellation Remarks')
        <li><a class="dropdown-item" href="{{ url('store-management/cancellation-remarks-vue') }}"> Cancellation Remarks </a></li>
         @endcan
      @can('View Sales Terms and Conditions')
        <li><a class="dropdown-item" href="{{ url('sales/terms-and-conditions') }}"> Terms & Conditions </a></li>
         @endcan
       
     </ul>
    </li>


     @can('View Store Sales')
    <li><a class="dropdown-item" href="{{ url('store-management/store-sales-vue') }}"> General Sales </a></li>
     @endcan
        @can('View Customer')
    <li><a class="dropdown-item" href="{{ url('room-management/room-customer') }}"> Guest </a></li>
     @endcan
     @can('View Finance Cash Receipt')
      <li><a class="dropdown-item" href="{{ url('finance-and-management/finance-cash-receipts-vue') }}"> Receipts </a></li>
         @endcan
@can('View Reports Module Page')  
      <li><a class="dropdown-item" href="{{ url('finance-and-management/sales/reports') }}"> Reports &raquo</a>
<ul class="submenu dropdown-menu">
         @can('View Dish Breakdown Store Sale Summary')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/dish-breakdown-store-sale-summary-vue') }}">Dish Breakdown Store Sale Summary </a></li>
         @endcan
        @can('View Closing Store Sales Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/closing-store-sales-report-vue') }}">Closing Store Sales Report </a></li>
         @endcan
        @can('View Store Sales Summary With Items')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/items-store-sales-summary-vue') }}">Store Sales Summary (With Items) </a></li>
         @endcan
        @can('View Store Sales Errors')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/store-sales-errors-vue') }}">Store Sales Errors </a></li>
         @endcan
        @can('View Monthly Store Report')
        <li><a class="dropdown-item" href="{{ url('finance-and-management/reports/monthly-store-report-vue') }}">Monthly Store Report </a></li>
         @endcan
</ul>
      </li>
        @endcan
    </ul>
</li>
@endcan





@can('View Admin Settings')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('admin-settings') }}">  Admin  </a>
    <ul class="dropdown-menu">
    @can('View Company Profile')
    <li><a class="dropdown-item" href="{{ url('admin-settings/profile') }}"> Company Profile </a></li>
     @endcan
    @can('View File Manager')
    <li><a class="dropdown-item" href="{{ url('admin-settings/file-manager') }}"> File Manager </a></li>
     @endcan
    @can('Take Database Backup')
    <li><a class="dropdown-item" href="//digitime.dyndns.org/backup/sqlexport.php" target="popup" onclick="window.open('//digitime.dyndns.org/backup/sqlexport.php','popup','width=500,height=400'); return false;"> Backup Database </a></li>
     @endcan
     @can('View User Rights')
    <li><a class="dropdown-item" href="{{ url('user-rights') }}"> User Rights &raquo </a>
     <ul class="submenu dropdown-menu">
       <li><a class="dropdown-item" href="{{ url('user-rights/definitions') }}"> Definitions &raquo </a>
     <ul class="submenu dropdown-menu">
    @can('View Roles')
        <li><a class="dropdown-item" href="{{ url('admin-settings/roles') }}"> Roles </a></li>
        @endcan
      @can('View Permissions')
        <li><a class="dropdown-item" href="{{ url('admin-settings/permissions') }}"> Permissions </a></li>
        @endcan
      @can('View Permission Categories')
        <li><a class="dropdown-item" href="{{ url('admin-settings/permission-categories') }}"> Permission Categories </a></li>
        @endcan
     </ul>
    </li>
      @can('View Users')
        <li><a class="dropdown-item" href="{{ url('admin-settings/users') }}"> Users </a></li>
        @endcan
      @can('Assign Roles')
        <li><a class="dropdown-item" href="{{ url('admin-settings/assign-roles') }}"> Assign Roles </a></li>
      @endcan
     </ul>
    </li>
     @endcan
      @can('View Predefined Values')
        <li><a class="dropdown-item" href="{{ url('admin-settings/predefined-values') }}"> Predefined Values </a></li>
         @endcan
          @can('View Permission Categories')
        <li><a class="dropdown-item" href="{{ url('admin-settings/permission-categories') }}"> Permission Categories </a></li>
        @endcan
    </ul>
</li>
@endcan

 @can('View Dashboards')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ url('dashboards') }}">  Dashboards  </a>
    <ul class="dropdown-menu">
        @can('View Revenue Dashboard')
    <li><a class="dropdown-item" href="{{ url('dashboards/revenue-dashboard-vue') }}"> Revenue Dashboard </a></li>
     @endcan
        @can('View CRM Dashboard')
    <li><a class="dropdown-item" href="{{ url('crm/dashboard-vue') }}"> CRM Dashboard </a></li>
     @endcan
   
    </ul>
</li>
@endcan



<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="" > @if($user){{$user->name}}@endif </a>
    <ul class="dropdown-menu">
     <li><a class="dropdown-item" href="{{ url('logout') }}"><i class="icon ion-power iconcolor"></i> &nbsp Sign Out </a></li>
    </ul>
</li>



<!--    <div class="br-header remove-bg">
      <div class="br-header-left">
      </div>
   <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down newcolor newtext">@if($user){{$user->name}}@endif</span>
              <img src="" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li class="linktopnav"><a href=""><i class="icon ion-ios-person iconcolor"></i> Edit Profile</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-gear iconcolor"></i> Settings</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-download iconcolor"></i> Downloads</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-star iconcolor"></i> Favorites</a></li>
                <li class="linktopnav"><a href=""><i class="icon ion-ios-folder iconcolor"></i> Collections</a></li>
                <li class="linktopnav"><a href="{{ url('logout') }}"><i class="icon ion-power iconcolor"></i> Sign Out</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div> -->


</ul>

</div> <!-- navbar-collapse.// -->
</nav>
</div>
{{-- Main Nav Bar --}}
<script type="text/javascript">
  // Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
  $('.dropdown-menu a').click(function(e){
    e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
     $(this).find('.submenu').hide();
  })
  });
}
</script>

