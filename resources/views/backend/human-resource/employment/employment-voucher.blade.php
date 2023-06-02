@extends('backend.layout.app')
@section('page-content')

<head>

<style type="text/css">
  
*{
    color: black ;
    font-size: 16px ;
  }

  ul.breadcrumbee {
  padding: 10px 2px;
  list-style: none;
}

/* Display list items side by side */
ul.breadcrumbee li {
  display: inline;
  font-family: "Roboto", "Helvetica Neue", Arial, sans-serif;
  font-size: 14px;
}

/* Add a slash symbol (/) before/behind each list item */
ul.breadcrumbee li+li:before {
  padding: 8px;
  color: black;
  content: ">>\00a0";
}

/* Add a color to all links inside the list */
ul.breadcrumbee li a {
  color: #17a2b8;
  text-decoration: none;
}

/* Add a color on mouse-over */
ul.breadcrumbee li a:hover {
  color: black;
}

b{ color: black; font-size: 18px !important;}
/* heading */

.boldee{
  font: 150% sans-serif !important;
}



p {  color: black !important;  font: 110% sans-serif !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */




h1 { font: bold 120% sans-serif !important; letter-spacing: 0.2em !important; text-transform: uppercase !important; color: black !important; padding-top: 11px !important; }

header { margin: 0 0 3em; }
span {float:left !important; }


th, td {
  padding: 10px !important;
  text-align: left !important; 
  font: 130% sans-serif !important; 
  height: 50px
}
th {
  padding: 10px !important;
  text-align: left !important;
  background-color: white !important;
  color: black !important; 
  font: 130% sans-serif !important; 
  height: 70px
}

strong{
font: bold 100% sans-serif !important; 
}

.thheighty{
  height: 150px !important;
}

.goleft{
  float: left !important;
}

.goleftopp{
  float: right !important;
}
 .middiv{
  text-align: center !important;
  margin-top: 38px !important;
 }

@page {
  size: A4;
  margin: 0;

}
@media print {
  html, body {
    width: 250mm;
    height: 297mm;
  }
}

.container{
  min-width: 100% !important;
  } .card{
  min-width: 100% !important;
}
.widthclass{
  width: 620px !important;
}
.widthclass2{
  width: 400px !important;
}
 table.myFormat tr td { font-size: 18px !important; }
 table.myFormat tr th { font-size: 17px !important; }
</style>
 

  </head>
  <body>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 hidden-print">Salary Voucher</h6>
         <div style="text-align: right;">
       <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/employment/salary-vue') }}">Employee Salary Vouchers List</a></li>
  <li><a href>Print Voucher</a></li>
</ul>


<div class="container">
  <div class="card">
<div class="card-header">
  <img class="float-left" src="{{ url($profiledata->company_logo) }}" height="90" width="125">
 
<span class=" widthclass2 hidden-print">&nbsp</span>

<span class="middiv widthclass"><strong>{{$profiledata->company_name}}</strong> <br>
  {{$profiledata->company_address}} <br> {{$profiledata->company_city}}</span>

  <span class="float-right"> <h1><br>SALARY<br>VOUCHER</h1></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h5 class="mb-3"><strong>BILL TO:</strong>
</h5>
<div>

</div>
<div><strong>Name:</strong>&nbsp&nbsp {{$receiptdata->employee->name}}</div>
<div><strong>Category:</strong>&nbsp&nbsp Employee</div>
<div><strong>No.:</strong>&nbsp&nbsp {{$receiptdata->employee_id}}</div>
<div><strong>CNIC #:</strong>&nbsp&nbsp {{$receiptdata->employee->cnic}}</div>
<div><strong>Contact #:</strong>&nbsp&nbsp{{$receiptdata->employee->mob_a}}</div>
<div><strong>Email:</strong>&nbsp&nbsp {{$receiptdata->employee->email}}</div>
<div><strong>Address:</strong>&nbsp&nbsp {{$receiptdata->employee->cur_address}}</div>
<div><strong>City:</strong>&nbsp&nbsp {{$receiptdata->employee->per_city}}</div>
</div>

<div class="col-sm-6">
<h5 class="mb-3"><strong>DETAILS:</strong>
</h5>
<div>

</div>
<div><strong>Voucher #:</strong> &nbsp&nbsp{{$receiptdata->id}}</div>
<div><strong>Voucher Date:</strong> &nbsp&nbsp{{ formatDateToShow($receiptdata->pay_date) }}</div>
</div>



</div>

<div class="table-responsive-sm">
<table class="table table-striped myFormat">
<thead>
<tr>


<th class="left">Current Salary</th>
<th class="left">Working Days</th>
<th class="left">Overtime Days</th>
<th class="left">Total Days</th>
<th class="left">Total Hours</th>
</tr>
</thead>

<tbody>
  
<tr>

<td class="left">{{$receiptdata->current_salary}}</td>
<td class="left">{{$receiptdata->working_days}}</td>
<td class="left">{{$receiptdata->overtime_days}}</td>
<td class="left">{{$receiptdata->working_days+$receiptdata->overtime_days}}</td>
<td class="left">{{$receiptdata->hours}}</td>
</tr>


</tbody>
</table>

</div>
<div class="row">
<div class="col-lg-6 col-sm-7">


</div>


<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear myFormat">
<tbody>
<tr>
<td class="left">
<strong>PAYABLE SALARY</strong>
</td>
<td class="text-left"><strong >{{$receiptdata->payable_salary }}</strong></td>
</tr>


</tr>
</tbody>
</table>

</div>

</div>

<br>
<br>

<div class="row">
  <div class="col-lg-12 col-sm-12">

  <p>APPROVED BY:&nbsp_____________&nbsp&nbsp&nbsp
  RECEIVED BY:&nbsp_____________&nbsp&nbsp&nbsp
  PAID BY:&nbsp_____________</p>
 </div>
</div>

</div>
</div>
</div>





</div>
</div>
</body>
@endsection



@push('jscode')


@endpush