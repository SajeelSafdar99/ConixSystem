@extends('backend.layout.app')
@section('page-content')


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

.headingsetting{
  color: black !important;
}

.pc{
  display:inline-block;
  position: relative;
  }
.pc input{
  padding-left:15px;
  }
.pc:before {
  position: absolute;
    content:"%";
    left:17px;
  top:6px;
  }
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Discount Cards</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/discount-cards') }}">Discount Cards List</a></li>
  <li><a href>Edit Discount Card</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/discount-cards') }}">Discount Cards List</a></li>
  <li><a href>Add Discount Card</a></li>
</ul>
@endif


           <div class="col-xl-12 ">
@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    @if($init==1)
          <form method="post" action="{{ url('food-and-beverage/discount-cards/update') }}/{{ $discount_card_update->id }}">
                 @else
                 <form method="post">
                   @endif     
            @csrf
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">


                   <div class="row">
    <label class="col-sm-2 form-control-label headingsetting"> Type:
    </label>

 @if($init==1)   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox headingsetting">
    <input @if(old('type',$discount_card_update->type)=='0') checked="" @endif type="radio" name="type" value="0"><span class="pabs">Member</span>
              </label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox headingsetting">
    <input @if(old('type',$discount_card_update->type)=='1') checked="" @endif type="radio" name="type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->

            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox headingsetting">
    <input @if(old('type',$discount_card_update->type)=='3') checked="" @endif type="radio" name="type" value="3"><span class="pabs">Employee</span>
              </label>
            </div><!-- col-3 -->

                                @else

        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <label class="rdiobox headingsetting">
    <input @if(old('type')=='0') checked="" @endif type="radio" name="type" value="0"><span class="pabs">Member</span></label>
            </div><!-- col-3 -->
                                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox headingsetting">
    <input @if(old('type')=='1') checked="" @endif type="radio" name="type" value="1"><span class="pabs">Guest</span>
              </label>
            </div><!-- col-3 -->

             <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox headingsetting">
    <input @if(old('type')=='3') checked="" @endif type="radio" name="type" value="3"><span class="pabs">Employee</span>
              </label>
            </div><!-- col-3 -->
                             @endif
 </div><!-- row-->

           <div class="row mg-t-10">
    <label class="col-sm-3 form-control-label headingsetting">Name:
    </label>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
      <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" class="form-control input-height typeahead" placeholder="Enter to Search" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$discount_card_update->name)}}@endif" type="text" name="name" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

      <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>

                                                    </div>
                                                </div>   
   <div class="row mg-t-10">
    <label class="col-sm-3 form-control-label headingsetting">Customer #:
    </label>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
      <input @if($errors->has('customer_id')) style="border-color:red;"  @endif id="customer_id" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('customer_id')}}@else{{old('customer_id',$discount_card_update->customer_id)}}@endif" type="text" name="customer_id" readonly >

                                                    </div>
                                                </div>  

  <div class="row mg-t-10">
    <label class="col-sm-3 form-control-label headingsetting">Card #:
     <span class="tx-danger"> * </span>
    </label>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('card_number')) style="border-color:red;" @endif type="number" id="card_number" name="card_number" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('card_number')}}@else{{old('card_number',$discount_card_update->card_number)}}@endif" placeholder="Enter Number">

                                                    </div>
                                                </div> 
        <div class="row mg-t-10">
    <label class="col-sm-3 form-control-label headingsetting">Discount Amount:
     <span class="tx-danger"> * </span>
    </label>
      <div class="col-sm-4 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('discount_amount')) style="border-color:red;" @endif type="number" id="discount_amount" name="discount_amount" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$discount_card_update->discount_amount)}}@endif" placeholder="Enter Amount" onclick="alternativereadonly()">

                                                    </div>
                                                
    <label class="col-sm-2 form-control-label headingsetting">Discount Percentage:
     <span class="tx-danger"> * </span>
    </label>
      <div class="col-sm-3 mg-t-10 mg-sm-t-0 pc">
      <input type="number" @if ($errors->has('discount_percentage')) style="border-color:red;" @endif id="discount_percentage" class="form-control input-height" value="@if($init==0){{old('discount_percentage')}}@else{{old('surcharge_percentage',$discount_card_update->discount_percentage)}}@endif" name="discount_percentage" onclick="alternativereadonly2()">
 </div>
        </div>  
         <div class="row mg-t-10">
    <label class="col-sm-3 form-control-label headingsetting">Card Issue Date:
     <span class="tx-danger"> * </span>
    </label>
     <?php

                                                    $month = date('m');
                                                    $day = date('d');
                                                    $year = date('Y');

                                                    $today = $day . '/' . $month . '/' . $year;
                                                    ?>
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<input  @if ($errors->has('card_issue_date')) style="border-color:red;" @endif id="card_issue_date" class="form-control input-height" type="text" placeholder="dd/mm/yyyy" value="@if($init==0)<?php echo $today;?>@else{{old('card_issue_date',formatDateToShow($discount_card_update->card_issue_date))}}@endif" name="card_issue_date" >

                                                    </div>
                                                </div> 
      <div class="row mg-t-10">
    <label class="col-sm-3 form-control-label headingsetting">Card Expiry Date:
     <span class="tx-danger"> * </span>
    </label>
     
      <div class="col-sm-9 mg-t-10 mg-sm-t-0">
 <input @if ($errors->has('card_expiry_date')) style="border-color:red;" @endif id="card_expiry_date" class="form-control input-height" autocomplete="off" type="text" name="card_expiry_date" placeholder="dd/mm/yyyy" value="@if($init==0){{old('card_expiry_date')}}@else{{old('card_expiry_date',formatDateToShow($discount_card_update->card_expiry_date))}}@endif">
                                                    </div>
                                                </div>


  @if($init==1)
               <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('food-and-beverage/discount-cards') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>
   @else  
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">
                 
                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Add More">

                  &nbsp&nbsp
                  <a href="{{ url('food-and-beverage/discount-cards') }}" class="btn btn-secondary">Cancel</a>
                 
                </div><!-- form-layout-footer -->
            </div>
             @endif   
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </form>
            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection

@push('jscode')
<script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v = $('input[name="type"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    if (v == 1) {
                        
                      document.getElementById('name').value = obj.customer_name;
                      document.getElementById('customer_id').value = obj.id;
                        
                    }
                    else if (v == 3) {
                        
                      document.getElementById('name').value = obj.name;
                      document.getElementById('customer_id').value = obj.id;
                        
                    } 
                    else {
                         $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                      document.getElementById('name').value = $fname+$mname+$lname;
                      document.getElementById('customer_id').value = obj.mem_no;

                    }
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>

     <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v = $('input[name="type"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {
                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {
                       
                       if(v==1){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name} : ${val1.customer_no} <li>`);
   }
   else if(v==3){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.name} : ${val1.barcode} <li>`);
   }
   else{

                $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';
                let fullname=$fname+$mname+$lname;
    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${fullname} : ${val1.mem_no} (${val1.mem_status.desc}) <li>`);
                        }
                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>


    <script type="text/javascript">
        function alternativereadonly() {
          document.getElementById("discount_amount").readOnly = false;
           
                document.getElementById("discount_percentage").readOnly = true;
                document.getElementById("discount_percentage").value = '';
          
        }
    
        function alternativereadonly2() {
          document.getElementById("discount_percentage").readOnly = false;
          
                document.getElementById("discount_amount").readOnly = true;
                document.getElementById("discount_amount").value = '';
           
        }

    </script>

 
@if($init==1)
    <script type="text/javascript">
        $(document).ready(function () {
var discamt = document.getElementById("discount_amount").value;
var discpct = document.getElementById("discount_percentage").value;

if(discamt == ''){
  document.getElementById("discount_amount").readOnly = true;
}
if(discpct == ''){
  document.getElementById("discount_percentage").readOnly = true;
}
        });
       
    </script>
     @endif


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

<script>

     $( function() {
    $( "#card_issue_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );


     $( function() {
    $( "#card_expiry_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

  </script>
@endpush
