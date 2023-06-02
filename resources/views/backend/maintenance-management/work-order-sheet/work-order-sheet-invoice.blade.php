@extends('backend.layout.app')
@section('page-content')

<head>
    <meta charset="utf-8"> 
    <title>Invoice</title>
  
<style type="text/css">
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
 
b{ color: black; font-size: 16px !important;}
/* heading */

h1 { font: bold 108% sans-serif !important; letter-spacing: 0.3em !important; text-align: center !important; text-transform: uppercase !important; color: black !important; height: 50px !important; padding-top: 10px !important; font-size: 19px !important;}

p { text-align: center !important; color: black !important; font-size: 15px !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */


input[type=text] {
    background: transparent;
    border: none;
    border-bottom: 1px solid #000000;
    width:100%;

}


input[type=string] {
    background: transparent;
    border: none;
   border-bottom: 1px solid #000000;
    width:100%;

}

input[type=date] {
    background: transparent;
    border: none;
    border-bottom: 1px solid #000000;
    width:100%;

}

input[type=number] {
    background: transparent;
    border: none;
    border-bottom: 1px solid #000000;
    width:100%;

}

input[readonly] {
  background-color: white;
}

input[disabled] {
  background-color: white;
  color: black;
}



textarea[disabled] {
   background-color: #e9ecef00 !important;
   background: transparent;
   font-size: inherit !important;
   border: none;
   border-bottom: 1px solid #000000 !important;
   width:100%;
   color: black;
}


select {
border-color: black;
    border-left: 0 none;
    border-right: 0 none;
    border-top: 0 none;
    min-height: 30px;
    padding-right: 5px;
    text-align: left;
   width:100%;
    word-break: break-word;
    white-space: normal;
}

</style>

  </head>
<div class="br-pagebody">
        <div>

    
 <body>

<div>
  <header>
    <address>
      <p> <img src="{{ url($profiledata->company_logo) }}" height="100" width="200"></p>
        <p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>
      </address>
      <h1><u>WORK ORDER SHEET</u></h1>
   
    </header>
   
   <div class="row">
   <div class="col-md-4"><b>Serial #<input type="text" style="font-weight: bold !important;" id="serial_no" name="serial_no" value="{{$receiptdata->serial_no}}" disabled></b></div>


  <div class="col-md-4"></div>

  <div class="col-md-4"><b>Issue Date<input type="text" id="issue_date" name="issue_date" value="{{formatDateToShow($receiptdata->issue_date)}}" disabled></b></div>


 
</div>
 <br>
<div class="row"> 
  <div class="col-md-8"><b>Department<input type="text" id="department" name="department" value="{{WorkOrderDepartment($receiptdata->department)}}" autocomplete="off" disabled></b></div>

  <div class="col-md-4"></div>
</div> 
   <br><br>
   <p style="text-align: left !important;">If you find any problem anywhere, you must fill out this form, get it signed and submit to administration department.</p>
   <br>
<div class="row">
  <div class="col-md-12">

<b style="color: black;">Description of Problems<textarea id="description" autocomplete="off" disabled class="form-control" placeholder="Enter Details" rows="9" type="text" name="description">{{$receiptdata->description}}</textarea></b>
</div>
</div>


<br>
 <br>
<p style="text-align: left !important;"><i>Problem Identified By:</i> ______________ </p>

  <br> <br> <br> 
 
 <p style="text-align: left !important;"><i>For Admin Use Only:</i></p>

 <br>

<div class="row">
   <div class="col-md-4"><p style="text-align: left !important;">Received By:</p><input type="string"     disabled></div>


  <div class="col-md-4"><p style="text-align: left !important;">Received On:</p><input type="string"     disabled></div>

  <div class="col-md-4"><p style="text-align: left !important;">Dairy No:</p><input type="string"  disabled></div>


 
</div>

 <br>

 
<div class="row">
   <div class="col-md-12"><p style="text-align: left !important;"> Admin Manager:</p><input type="string"    disabled></div>
</div>
 <br>
<div class="row">
  <div class="col-md-12"><p style="text-align: left !important;">Job Assigned To:</p><input type="string"     disabled></div>
</div>
 <br>
<div class="row">

  <div class="col-md-6"><p style="text-align: left !important;">Vendor Name:</p><input type="string"   disabled></div>

  <div class="col-md-6"><p style="text-align: left !important;">Mobile No:</p><input type="string"  disabled></div>
</div>

 
</div>

 
</div>

</body>
</div>

@endsection



@push('jscode')

<script type="text/javascript">
  $( document ).ready(function() {

 window.print();
});
</script>
@endpush
