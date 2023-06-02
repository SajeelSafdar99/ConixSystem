@extends('backend.layout.app')
@section('page-content')
<?php
use App\User;

$user = auth()->user();
?>
<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

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

.rcorners2 {
  border-radius: 25px;
  border: 2px solid #f1f1f1;
  padding: 15px;
  width: 150px;
  height: 50px;
  cursor: pointer;
}
.rcornersSp {
  border-radius: 25px;
  border: 2px solid #f1f1f1;
  padding: 15px;
  width: 220px;
  height: 50px;
  cursor: pointer;
}

.rcorners3 {
  border: 2px solid #f1f1f1;
  padding: 15px;
  width: 150px;
  height: 50px;
  cursor: pointer;
}

.rcornersNew {
  border: 2px solid #f1f1f1;
  padding: 15px;
  width: 205px;
  height: 50px;
  cursor: pointer;
}

.rcorners1 {
  border: 2px solid #f1f1f1;
  padding: 10px;
  width: 120px;
  height: 50px;
  cursor: pointer;
   font-size: 16px;
}

.waiterdiv {
  border: 2px solid #f1f1f1;
  padding: 18px;
  width: 160px;
  height: 80px;
  cursor: pointer;
   font-size: 16px;
}

.tabledefs {
  border: 2px solid #f1f1f1;
  padding: 12px;
  width: 50px;
  height: 50px;
  cursor: pointer;
   font-size: 16px;
}

 .areabox {
            cursor: pointer !important;
        }
.headingsettings {
            color: black!important;

        }
div.groove {border-style: groove !important; height: 160px !important;}

.itemname{text-transform: uppercase; }

.blackcolor{
 color: black;
}

.bordered{
   border-radius: 25px;
  background-color: #23BF08;
  border: 2px solid #23BF08;
   color: white;
}

.bordered1{
  background-color: #23BF08;
  border: 2px solid #23BF08;
   color: white;
}
  .header {
  background-color: #f1f1f1;
  text-align: center;
  font-size: 18px;
  color:black;
  width: 100%;
}


.pc{
  display:inline-block;
  position: relative;
  }
.pc input{
  padding-left:20px !important;
  }
.pc:before {
  position: absolute;
    content:"%";
    left:6px;
  top:3px;
  }

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.has-search .form-control {
    padding-left: 2.375rem !important;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 1rem;
    height: 1rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
    margin-left: 6px;
    margin-top: 4px;
}

.form-layout-4, .form-layout-5 {
    color: black !important;
    text-align: center !important;
    font-size: 25px;
    border: solid 1px #000000;
}
</style>

	</head>
<div class="br-pagebody">
        <div>
   <h6 class="tx-gray-800 tx-bold tx-14 mg-b-10 hidden-print margara">SALE KOTs</h6>

       <div class="hidden-print" style="text-align: right; margin-top: -39px;">
    
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div> 

@if($running==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
   <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/sales-list-vue') }}">Sales List</a></li>
  <li><a href>Sale KOTs List</a></li>
</ul> 
@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
   <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/running-sales-list-vue') }}">Running Sales List</a></li>
  <li><a href>Sale KOTs List</a></li>
</ul>
@endif


<div class="row">
   <div class="col-sm-3"></div>
  <div class="col-sm-6">
 <div class="form-layout form-layout-4 ">

  @foreach($kots as $kot)

  <strong>{{$kot->kot_no}}</strong>  ({{usernames($kot->created_by)}}) &nbsp &nbsp &nbsp &nbsp &nbsp <a style="color:white;" target="_blank" href="{{ url('fb/sales/duplicatesaleskot') }}/{{ $invoice }}/{{ $kot->kot_no }}"><button style="cursor: pointer;" class=" btn btn-outline-primary active">PRINT</button></a> <br><br>

  @endforeach

 </div>
</div>
<div class="col-sm-3"></div>
</div>



</div>
</div>

 

@endsection

@push('jscode')


@endpush
