

<div class="bd rounded border-menu" id="myHeader">
  <ul class="nav nav-gray-600 flex-column flex-sm-row" role="tablist">

 @can('View Club Membership Management')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('club-hospitality') }}">Club Memberships</a></li>
    <div class="dropdown-content">
      @can('View Member Relations')
     <a href="{{ url('club-hospitality/member-relation') }}">Member Relations</a>
      @endcan
      @can('View Member Type')
     <a href="{{ url('club-hospitality/member-classification') }}">Member Type</a>
      @endcan
    @can('View Membership Category')
     <a href="{{ url('club-hospitality/member-category') }}">Membership Category</a>
      @endcan
      @can('View Membership')
    <a href="{{ url('club-hospitality/membership') }}">Membership</a>
    @endcan
     @can('View Club Facilities')
     <a href="{{ url('club-hospitality/club-facilities') }}">Club Facilities</a>
      @endcan
  </div>
</div>
@endcan

@can('View Members Access Management')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('members-access') }}">Members Access</a></li>
    <div class="dropdown-content">
      @can('View Search Members')
      <a href="{{ url('members-access/search-members') }}">Search Members</a>
      @endcan
  </div>
    </div>
@endcan

@can('View Sports Subscription')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('sports-subscription') }}" >Sports Subscription</a></li>
     <div class="dropdown-content">
      @can('View Subscription Types')
      <a href="{{ url('sports-subscription/sports') }}">Subscription Types</a>
      @endcan
  </div>
    </div>
    @endcan

@can('View Food and Beverage')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('') }}" >F & B</a></li>
     <div class="dropdown-content">
  </div>
    </div>
    @endcan

@can('View Rooms Management')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('room-management') }}">Rooms </a></li>
     <div class="dropdown-content">
      @can('View Customer')
      <a href="{{ url('room-management/room-customer') }}">Guest</a>
       @endcan
      @can('View Room Type')
      <a href="{{ url('room-management/room-type') }}">Room Types</a>
       @endcan
      @can('View Room Rate Categories')
      <a href="{{ url('room-management/room-category') }}">Room Rate Categories</a>
       @endcan
      @can('View Room Charges Type')
      <a href="{{ url('room-management/room-charges-type') }}">Room Charges Type</a>
       @endcan
      @can('View Rooms')
      <a href="{{ url('room-management/room') }}">Rooms</a>
       @endcan
      @can('View Room Booking')
      <a href="{{ url('room-management/room-booking') }}">Room Booking</a>
       @endcan
      @can('View Check In')
      <a href="{{ url('room-management/room-check-in') }}">Room Check In</a>
       @endcan
      @can('View Check Out')
      <a href="{{ url('room-management/room-check-out') }}">Room Check Out</a>
       @endcan
      @can('View Room Booking Calendar')
      <a href="{{ url('room-management/calender') }}">Room Booking Calendar</a>
       @endcan
      @can('View Payment Receipt')
      <a href="{{ url('room-management/room-payment-receipts') }}">Cash Receipts</a>
       @endcan
      @can('View Ledger Accounts')
      <a href="{{ url('room-management/room-ledger-accounts') }}">Room Ledger Accounts</a>
       @endcan
        @can('View Ledger Account Details')
      <a href="{{ url('room-management/room-trial-balance') }}">Room Trial Balance</a>
       @endcan
        @can('View Room Reminders')
      <a href="{{ url('') }}">Room Reminders</a>
       @endcan
        @can('View Reports')
         <li class="listingstyling"><a href="{{ url('room-management/room-reports') }}">Reports</a>
          <ul>
             @can('View Check Out Report')
         <a href="{{ url('room-management/room-reports/check-out-report') }}">Rooms Check-Out Report</a>
          @endcan
          <a href="#">Cash Report</a>
        </ul>
        </li>
       @endcan
  </div>
    </div>
    @endcan

@can('View Events Management')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('events-management') }}" >Events </a></li>
     <div class="dropdown-content">
      @can('View Customer')
      <a href="{{ url('events-management/event-customer') }}">Event Guest</a>
      @endcan
      @can('View Menu Type')
      <a href="{{ url('events-management/menu-type') }}">Menu Type</a>
      @endcan
      @can('View Menu Rate Category')
      <a href="{{ url('events-management/menu-category') }}">Menu Rate Categories</a>
      @endcan
      @can('View Event Charges Type')
      <a href="{{ url('events-management/event-charges-type') }}">Event Charges Type</a>
      @endcan
      @can('View Venues')
      <a href="{{ url('events-management/event-venue') }}">Venues</a>
      @endcan
       @can('View Menus')
      <a href="{{ url('events-management/menus') }}">Menus</a>
      @endcan
      @can('View Event Booking')
      <a href="{{ url('events-management/event-booking') }}">Event Booking</a>
      @endcan
      @can('View Event Check Out')
      <a href="{{ url('events-management/event-checkout') }}">Event Check Out</a>
      @endcan
      <a href="{{ url('/') }}">Event Booking Calendar</a>
      <a href="{{ url('/') }}">Cash Receipts</a>
      <a href="{{ url('/') }}">Ledger Accounts</a>
  </div>
    </div>
    @endcan

@can('View Maintenance Management')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('') }}">Maintenance Management</a></li>
     <div class="dropdown-content">
  </div>
    </div>
    @endcan

@can('View Finance and Management')
    <div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('finance-and-management') }}">Finance Management</a></li>
     <div class="dropdown-content">
    @can('View Payments Module Page')
         <li class="listingstyling"><a href="{{ url('finance-and-management/finance-payments-submodules') }}">Payments</a>
          <ul class="zindexadd">
             @can('View Payment Receivables')
         <a href="{{ url('finance-and-management/finance-payment-receivables') }}">Payment Receivables</a>
          @endcan
           @can('View Payment Methods')
         <a href="{{ url('finance-and-management/finance-payment-methods') }}">Payment Methods</a>
          @endcan
          @can('View Payment Receipt')
         <a href="{{ url('finance-and-management/payment-receipts') }}">Cash Receipts</a>
          @endcan
        </ul>
        </li>
       @endcan

@can('View Expenses Module Page')
         <li class="listingstyling"><a href="{{ url('finance-and-management/finance-expenses-submodules') }}">Expenses</a>
          <ul>
            @can('View Expenses')
          <a href="{{ url('finance-and-management/finance-expenses') }}">Expenses</a>
          @endcan
            @can('View Expense Payables')
         <a href="{{ url('finance-and-management/finance-expense-paid-for') }}">Expense Payables</a>
          @endcan
        </ul>
        </li>
       @endcan

       @can('View Invoices Module Page')
         <li class="listingstyling"><a href="{{ url('finance-and-management/finance-invoices-submodules') }}">Invoices</a>
          <ul>
          @can('View Finance Invoices')
          <a href="{{ url('finance-and-management/finance-invoices') }}">Invoices</a>
          @endcan
          @can('View Invoice Charges Types')
         <a href="{{ url('finance-and-management/invoice-charges-types') }}">Invoice Charges Types</a>
          @endcan
           @can('View Monthly Maintenance Fee Posting')
         <a href="{{ url('finance-and-management/maintenance-fee-posting/maintenance-fee-posting-aeu') }}">Monthly Maintenance Fee Posting</a>
          @endcan
        </ul>
        </li>
       @endcan

@can('View Reports Module Page')
    <li class="listingstyling"><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a>
          <ul>
         @can('View Finance Ledger Accounts')
          <a href="{{ url('finance-and-management/finance-ledger-accounts') }}">Finance Ledger Accounts</a>
          @endcan
         @can('View Finance Trial Balance')
         <a href="{{ url('finance-and-management/finance-trial-balance') }}">Finance Trial Balance</a>
          @endcan
           @can('View Reports')
         <li class="listingstyling"><a href="{{ url('finance-and-management/finance-reports') }}">Room Reports</a>
          <ul>
             @can('View Check Out Report')
         <a href="{{ url('finance-and-management/finance-reports/check-out-report') }}">Check-Out Report</a>
          @endcan
          <a href="#">Cash Report</a>
        </ul>
        </li>
       @endcan
        @can('View Cash Flow')
         <a href="{{ url('finance-and-management/finance-cash-flow') }}">Cash Flow</a>
          @endcan
           @can('View Maintenance Fee Revenue')
     <a href="{{ url('finance-and-management/reports/maintenance-fee-revenue') }}">Maintenance Fee Revenue</a>
      @endcan
        </ul>
        </li>
       @endcan

 @can('View Vouchers Module Page')
         <li class="listingstyling"><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a>
          <ul>
         @can('View Voucher Types')
          <a href="{{ url('finance-and-management/finance-voucher-types') }}">Voucher Types</a>
          @endcan
          @can('View General Voucher')
         <a href="{{ url('finance-and-management/finance-general-vouchers') }}">General Vouchers</a>
          @endcan
        </ul>
        </li>
       @endcan
       
        @can('View Chart of Accounts')
         <li class="listingstyling"><a href="{{ url('finance-and-management/chart-of-accounts') }}">Chart Of Accounts</a>
          <ul>
         @can('View Ledger Persons')
          <a href="{{ url('finance-and-management/finance_ledger_persons') }}">Ledger Persons</a>
          @endcan
          @can('View Account Heads')
         <a href="{{ url('finance-and-management/finance-account-heads') }}">Account Heads</a>
          @endcan
          @can('View Account Types')
         <a href="{{ url('finance-and-management/finance-account-types') }}">Account Types</a>
          @endcan
        </ul>
        </li>
       @endcan

  </div>
    </div>
    @endcan


@can('View Club Membership Management')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('') }}">Sales & Marketing</a></li>
     <div class="dropdown-content">
  </div>
    </div>
    @endcan

@can('View Sales and Marketing')
<div class="dropdown">
    <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('') }}" >CRM</a></li>
     <div class="dropdown-content">
  </div>
    </div>
    @endcan

@can('View Human Resource Management')
<div class="dropdown">
     <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('human-resource') }}" >HRM</a></li>
       <div class="dropdown-content">
         @can('View Departments')
      <a href="{{ url('human-resource/departments') }}">Departments</a>
      @endcan
      @can('View Employment')
      <a href="{{ url('human-resource/employment') }}">Employment</a>
      @endcan
      @can('Check In Employee')
      <a href="{{ url('human-resource/employment/checkin') }}">Check-In Employee</a>
      @endcan
       @can('Check Out Employee')
      <a href="{{ url('human-resource/employment/checkout') }}">Check-Out Employee</a>
      @endcan
      @can('View Employee Attendance')
      <a href="{{ url('human-resource/employment/attend') }}">Employee Attendance</a>
      @endcan
  </div>
    </div>
    @endcan

@can('View Legal Management')
<div class="dropdown">
      <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('') }}">Legal Management</a></li>
       <div class="dropdown-content">
  </div>
    </div>
    @endcan

@can('View Store Management')
<div class="dropdown">
      <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('') }}">Store Management</a></li>
       <div class="dropdown-content">
  </div>
    </div>
    @endcan

@can('View Admin Settings')
<div class="dropdown">
      <li class="nav-item"><a class="nav-link dropbtn" href="{{ url('admin-settings') }}">Admin Settings</a></li>
       <div class="dropdown-content">
        @can('View Company Profile')
        <li class="listingstyling"><a href="{{ url('admin-settings/profile') }}">Company Profile</a></li>
        @endcan
  @can('View File Manager')
  <li class="listingstyling"><a href="{{ url('admin-settings/file-manager') }}">File Manager</a></li>
  @endcan
  @can('Take Database Backup')
  <li class="listingstyling"><a href="//digitime.dyndns.org/backup/sqlexport.php" target="popup" onclick="window.open('//digitime.dyndns.org/backup/sqlexport.php','popup','width=500,height=400'); return false;">Backup Database</a></li>
  @endcan
        @can('View User Rights')
        <li class="listingstyling"><a href="{{ url('user-rights') }}">User Rights</a>
         <ul>
           @can('View Users')
       <a href="{{ url('admin-settings/users') }}">Users</a>
       @endcan
          @can('View Roles')
         <a href="{{ url('admin-settings/roles') }}">Roles</a>
         @endcan
        @can('View Permissions')
          <a href="{{ url('admin-settings/permissions') }}">Permissions</a>
          @endcan
        @can('View Permission Categories')
          <a href="{{ url('admin-settings/permission-categories') }}">Permission Categories</a>
        @endcan
        </ul>
        </li>
         @endcan

  </div>
    </div>
    @endcan

  </ul>
</div>



<style type="text/css">
 .dropbtn {
  background-color: white;
  color: white;
  padding: 16px;
  font-size: 14px;
  border: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;

  padding: 0;
  position: absolute; top: 100%;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
   float: none; 
   position: relative;

}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #ddd;}

.listingstyling ul { display: none; }
ul .listingstyling a {
color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;

}

ul .listingstyling a:hover {background-color: #ddd;}
.listingstyling:hover > ul {
  display: block;

   padding: 0;
  position: absolute; 
  top: 0;
  left: 100%;
  margin-top: -1px;
  border-top: 0;

}
.listingstyling:hover .listingstyling {float: none; 

  position: relative; }
.listingstyling:hover a {background-color: #f1f1f1; }
.listingstyling:hover .listingstyling a:hover {background-color: #ddd;  }

.main-navigation .listingstyling ul .listingstyling { border-top: 0; }

ul:before,
ul:after {
  content: " "; /* 1 */
  display: table; /* 2 */
}

ul:after { clear: both; }
ul ul ul {
  left: 100%;
  top: 0;
  position: absolute !important;
}
</style>