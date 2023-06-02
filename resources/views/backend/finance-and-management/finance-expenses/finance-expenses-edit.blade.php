@extends('backend.layout.app')
@section('page-content')

<head>
   
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

    .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }

.areabox{cursor:pointer !important;}
.areabox_two{cursor:pointer !important;}

div.groove {border-style: groove !important; height: 140px !important;}
div.saveoptions { height: 390px !important; }

.padtheicon{
  padding-top: 15px;
  cursor: pointer;
}

 .btne {
  border: 2px solid #56bff9;
  color: white;
  background-color: #56bff9;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 15px;

}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
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

  </head> 
<div class="br-pagebody">
        <!-- <div class="br-section-wrapper"> -->
          <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Expenses</h6>
         <div style="text-align: right;">
          <!-- <a target="_blank" href="{{ url('room-management/room-invoice-download') }}/{{ Request::segment(3) }}">
          <img src="{{ url('assets/images/pdf.png') }}" title="Pdf" height="31" width="31" border="0/">
          </a> -->
          <a href="">
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-expenses-submodules') }}">Expenses</a></li>
  <li><a href="{{ url('finance-and-management/finance-expenses-vue') }}">Expenses List</a></li>
  <li><a href>Edit Expenses</a></li>
</ul>

@else 
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-expenses-submodules') }}">Expenses</a></li>
  <li><a href="{{ url('finance-and-management/finance-expenses-vue') }}">Expenses List</a></li>
  <li><a href>Add Expenses</a></li>
</ul>

@endif

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

    @if($init==1)
   <form method="post" enctype="multipart/form-data" action="{{ url('finance-and-management/finance-expenses/update') }}/{{ $expenses_update->id }}">
     @else
    <form method="post" enctype="multipart/form-data">
    @endif
    @csrf


                                        <div class="form-layout form-layout-4 ">

                  <div class="row">
               <div class="col-sm-10">



<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">Voucher #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('invoice_no')) style="border-color:red;" @endif type="text" class="form-control input-height" id="invoice_no" name="invoice_no" value="@if($init==0){{$increment_number}}@else{{old('invoice_no',$expenses_update->id)}}@endif" autocomplete="off" readonly style="background-color: #c1c1c1" style="background-color: #c1c1c1">
                        </div>
                              

                       <label class="col-sm-1 form-control-label">
                                                    Voucher Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <?php

                                          
$month = date('m');
$day = date('d');
$year = date('Y');

$today = $day.'/'.$month.'/'.$year;
?>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
          <input @if ($errors->has('invoice_date')) style="border-color:red;" @endif type="text" name="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="@if($init==0)<?php echo $today;?>@else{{old('invoice_date',formatDateToShow($expenses_update->invoice_date))}}@endif" readonly style="background-color: #c1c1c1">

                                                    </div>

             <label class="col-sm-1 form-control-label">    Ledger Amount:
<a class="showAfterSelection" style="display: none" href="{{ url('finance-and-management/finance-ledger-accounts') }}" data-href="{{ url('finance-and-management/finance-ledger-accounts') }}" target="_blank">

        <i class="fa fa-info-circle"></i> </a>
               </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
    <input @if ($errors->has('ledger_amount')) style="border-color:red;" @endif  type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('ledger_amount')}}@else{{old('ledger_amount',$expenses_update->ledger_amount)}}@endif">
                        </div>


                                                 </div>
                                                <!-- row -->


  <div class="row mg-t-10">
 <label class="col-sm-1 form-control-label">Name:<span class="tx-danger"> * </span>
               </label>
      <div class="col-sm-3 mg-t-10 mg-sm-t-0">
 <input @if($errors->has('person_name')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_name" name="person_name" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" autocomplete="off" class="typeahead" placeholder="Search By Name or ID" value="@if($init==0){{old('person_name')}}@else{{old('person_name',$expenses_update->person_name)}}@endif">

    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                                                 </div>
                                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                                                        <a href="{{ url('finance-and-management/finance_ledger_persons/finance_ledger_persons-aeu') }}"
                                                           target="_blank">
                                                            <input type="button" value=" + "
                                                                   class="btn btn-info">
                                                        </a>
                                                    </div>


<!-- 
                                                    <label class="col-sm-1 form-control-label">
                                              CNIC:   
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                         <input @if ($errors->has('person_cnic')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_cnic" name="person_cnic" autocomplete="off" value="@if($init==0){{old('person_cnic')}}@else{{old('person_cnic',$expenses_update->person_cnic)}}@endif" readonly style="background-color: #c1c1c1">
                                                    </div> -->




                                           <label class="col-sm-1 form-control-label"> Supplier #:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('person_id')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_id" name="person_id" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('person_id')}}@else{{old('person_id',$expenses_update->person_id)}}@endif">
                        </div>
                        <label class="col-sm-1 form-control-label">
                                             Contact:
                            <span class="tx-danger"> * </span>
                                                    </label>
                                                     <div class="col-sm-2 mg-t-10 mg-sm-t-0">
        <input @if ($errors->has('person_contact')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_contact" name="person_contact" autocomplete="off" value="@if($init==0){{old('person_contact')}}@else{{old('person_contact',$expenses_update->person_contact)}}@endif" readonly style="background-color: #c1c1c1">
                                                    </div>

                        </div>
 

 <!-- row -->
  <!-- <div class="row mg-t-10"> -->

<!-- 
           <label class="col-sm-1 form-control-label">
                                              Address:
                                   <span class="tx-danger">  * </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('person_address')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_address" name="person_address" autocomplete="off" readonly style="background-color: #c1c1c1" value="@if($init==0){{old('person_address')}}@else{{old('person_address',$expenses_update->person_address)}}@endif">
</div>
 -->

 <!--  <label class="col-sm-1 form-control-label">Email:<span class="tx-danger">  * </span>  </label>

                                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('person_email')) style="border-color:red;" @endif type="text" class="form-control input-height" id="person_email" name="person_email" autocomplete="off" value="@if($init==0){{old('person_email')}}@else{{old('person_email',$expenses_update->person_email)}}@endif" readonly style="background-color: #c1c1c1">

                                                    </div> -->

                                              <!--    </div> -->
                                                <!-- row -->



<br><br>
<div class="groove">
<br>
  <div class="row mg-t-10">

     <label class="col-sm-1 form-control-label">
                                       Expense Head:     
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-3 mg-t-10 mg-sm-t-0">

<select @if ($errors->has('expense_head')) style="border-color:red;" @endif  id="expense_head" class="form-control input-height select2" name="expense_head" onchange="expenseselect(this.id)">
    <option label="Choose Option"></option>
 @foreach($expense_heads as $head)
                                @if($init==1)
                                 <option @if(old('expense_head',$expenses_update->expense_head)==$head->id)  selected @endif  value="{{ $head->id }}">
                                  {{ $head->desc }}
                                </option>
                                @else
                                 <option @if(old('expense_head')==$head->id)  selected @endif value="{{ $head->id }}">
                                  {{ $head->desc }}
                                </option>
                                @endif
                                @endforeach

</select>
</div>

 <label class="col-sm-1 form-control-label">
                                       Expense Paid For:     
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-3 mg-t-10 mg-sm-t-0">

<select @if ($errors->has('expense_paid_for')) style="border-color:red;" @endif  id="expense_paid_for" class="form-control input-height select2" name="expense_paid_for">
    <option label="Choose Option"></option>
 @foreach($expense_payables as $payable)
 @can($payable->name.' '.$payable->mod_id)
                                @if($init==1)
                                 <option @if(old('expense_paid_for',$expenses_update->expense_paid_for)==$payable->id)  selected @endif  value="{{ $payable->id }}">
                                  {{ $payable->name }}
                                </option>
                                @else
                                 <option @if(old('expense_paid_for')==$payable->id)  selected @endif value="{{ $payable->id }}">
                                  {{ $payable->name }}
                                </option>
                                @endif
                            @endcan
                                @endforeach

</select>
</div>

 <label class="col-sm-1 form-control-label">
                                        Expense Details: 
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('expense_details')) style="border-color:red;" @endif type="text" id="expense_details" name="expense_details" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('expense_details')}}@else{{old('expense_details',$expenses_update->expense_details)}}@endif" placeholder="Enter Details">
</div>
</div>

<!--   <div class="row mg-t-10">
 <label class="col-sm-1 form-control-label">
                                    Account Head:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<select @if ($errors->has('account_head')) style="border-color:red;" @endif  id="account_head" name="account_head" class="form-control input-height select2" onchange="accountheadselect(this.id)">
    <option label="Choose Option"></option>
 @foreach($payment_methods as $methods)
                                @if($init==1)
                                 <option @if(old('account_head',$expenses_update->account_head)==$methods->id)  selected @endif  value="{{ $methods->id }}">
                                  {{ $methods->desc }}
                                </option>
                                @else
                                 <option @if(old('account_head')==$methods->id)  selected @endif value="{{ $methods->id }}">
                                  {{ $methods->desc }}
                                </option>
                                @endif
                                @endforeach

</select>
</div>
 <label class="col-sm-1 form-control-label">
                                          Account Type:
                         <span class="tx-danger">
                                *
                            </span>
                                                    </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<select @if ($errors->has('account_type')) style="border-color:red;" @endif  id="account_type" name="account_type" class="form-control input-height select2" >
    <option label="Choose Option"></option>
 @foreach($account_types as $methods)
                                @if($init==1)
                                 <option @if(old('account_type',$expenses_update->account_type)==$methods->id)  selected @endif  value="{{ $methods->id }}">
                                  {{ $methods->type }}
                                </option>
                                @else
                                 <option @if(old('account_type')==$methods->id)  selected @endif value="{{ $methods->id }}">
                                  {{ $methods->type }}
                                </option>
                                @endif
                                @endforeach

</select>
</div>
</div> -->


</div>
<br><br>

<!-- 
 <div class="row mg-t-10">
 
 <label class="col-sm-1 form-control-label"> A/C: <span class="tx-danger">  * </span>   </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
<select @if ($errors->has('account_type')) style="border-color:red;" @endif  id="account_type" name="account_type" class="form-control input-height select2" >
    <option label="Choose Option"></option>
 @foreach($account_types as $methods)
                                @if($init==1)
                                 <option @if(old('account_type',$expenses_update->account_type)==$methods->id)  selected @endif  value="{{ $methods->id }}">
                                  {{ $methods->type }} &nbsp ({{ accountheadname($methods->id) }})
                                </option>
                                @else
                                 <option @if(old('account_type')==$methods->id)  selected @endif value="{{ $methods->id }}">
                                  {{ $methods->type }} &nbsp ({{ accountheadname($methods->id) }})
                                </option>
                                @endif
                                @endforeach

</select>
</div>

<label class="col-sm-1 form-control-label">
                                   A/C Date:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>

   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
<input @if ($errors->has('account_date')) style="border-color:red;" @endif type="text" name="account_date" id="account_date" class="form-control input-height" autocomplete="off" value="@if($init==0) @else{{old('account_date',formatDateToShow($expenses_update->account_date))}}@endif">
</div>

 <label class="col-sm-1 form-control-label">
              A/C Details:
                </label>
 <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="AccDetails()"></i></div>
   <div class="col-sm-2 mg-t-10 mg-sm-t-0" id="acc_details_div">
    <textarea @if ($errors->has('payment_mode_details')) style="border-color:red;" @endif id="payment_mode_details" class="form-control" placeholder="Enter details" rows="2" type="text" autocomplete="off" name="payment_mode_details">@if($init==0){{old('payment_mode_details')}}@else{{old('payment_mode_details',$expenses_update->payment_mode_details)}}@endif</textarea>
</div>
</div>
 -->
  <div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                          Total Amount:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
         <input @if ($errors->has('total_amount')) style="border-color:red;" @endif type="number" id="total_amount" name="total_amount" class="form-control input-height" autocomplete="off" oninput="add_surcharge()" value="@if($init==0){{old('total_amount')}}@else{{old('total_amount',$expenses_update->total_amount)}}@endif">
</div>

        <label class="col-sm-1 form-control-label">Surcharge (If Any): </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
       <input @if ($errors->has('surcharge')) style="border-color:red;" @endif type="number" id="surcharge" name="surcharge" autocomplete="off" placeholder="Enter Amount" oninput="add_surcharge()" class="form-control input-height" value="@if($init==0){{old('surcharge')}}@else{{old('surcharge',$expenses_update->surcharge)}}@endif">

                                                    </div>



                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0 pc">
           <input type="number" @if ($errors->has('surcharge_percentage')) style="border-color:red;"
                                                               @endif id="surcharge_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('surcharge_percentage')}}@else{{old('surcharge_percentage',$expenses_update->surcharge_percentage)}}@endif" name="surcharge_percentage" oninput="s_percentage()">

                                                    </div>

                                             
                                                 </div>
                                                <!-- row -->

  <div class="row mg-t-10">
   <label class="col-sm-1 form-control-label">
                                       Total Paid Amount:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
               <input @if ($errors->has('total')) style="border-color:red;" @endif type="number" class="form-control input-height" id="total" name="total" autocomplete="off" readonly style="background-color: #c1c1c1"value="@if($init==0){{old('total')}}@else{{old('total',$expenses_update->total)}}@endif">
</div>



      <label class="col-sm-1 form-control-label"> Amt in Words:</label>
<span class="tx-danger"> * </span>
                                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0" >
  <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$expenses_update->amount_in_words)}}@endif">

                                                    </div>

</div>


<div class="row mg-t-10">

     <label class="col-sm-1 form-control-label">
                                      Remarks:
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
             <textarea @if ($errors->has('remarks')) style="border-color:red;" @endif type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Details" rows="4" autocomplete="off">@if($init==0){{old('remarks')}}@else{{old('remarks',$expenses_update->remarks)}}@endif</textarea>
</div>

<label class="col-sm-1 form-control-label">
                                      Documents: </label>
   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    @if($init==0)
                             <img id="picchose" style="width: 200px; height: 100px; " src="{{ url('assets/images/nouser.png') }}">

                             @else

            @foreach($expenses_update->ledgerperson->expensesDocs->pluck('url') as $image)
 <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="45" width="45" >
                    </a>
                    @endforeach
  

                             @endif
                             @if($init==0)
                            <input @if ($errors->has('documents')) style="border-color:red;" @endif type="file" name="documents[]" multiple="multiple" value="@if($init==0){{old('documents')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="documents[]" multiple="multiple">
</div>
                            <input type="hidden" name="existimg" value="{{old('documents',$expenses_update->documents)}}">
                            @endif

</div>

                              </div>
                                                <!-- row -->


  <div class="float-left">


 @if($init==1)
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
              
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/finance-expenses-vue') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

   @else
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Print">

                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/finance-expenses-vue') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>
  @endif
                                            </div><!-- form-layout -->
                                     </div>


<div class="col-sm-2">
 <div class="saveoptions"></div>

</div>

                                                </div>

<br><br>

                                        </div><!-- col-6 -->
                                    </form>
            </div>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->


@endsection



@push('jscode')
<script type="text/javascript">
        $('#person_contact').mask('00000000000');
        
      /*  $('#person_cnic').mask('00000-0000000-0');
        */
    </script>

<script type="text/javascript">
  function AccDetails() {
  var x = document.getElementById("acc_details_div");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<script>
$(document).ready(function(){
    $("#acc_details_div").hide();
});
</script>

<script type="text/javascript">

  function expenseselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('finance-and-management/expense/payable/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#expense_paid_for').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.name+'</option>';
 $('#expense_paid_for').append(s);
                })

  }
}
   });

  }

</script>

  <script type="text/javascript">
  var val;
  function customerdatavalue(val){
    let v=2;

   $.ajax({
    type : 'POST',
    url : '{{ url('search/customerdata') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "customerid": val,
        'MOC':v
        },
  success: function(data){

console.log(data);
   var obj = JSON.parse(data);

  if(v==2){
  document.getElementById('person_name').value=obj.person_name;
  //document.getElementById('person_address').value=obj.person_address;
  document.getElementById('person_contact').value=obj.person_contact;
  //document.getElementById('person_cnic').value=obj.person_cnic;
  //document.getElementById('person_email').value=obj.person_email;
  document.getElementById('person_id').value=obj.id;
  document.getElementById('ledger_amount').value=obj.balance;
       let d='?customer='+obj.person_name+'&mog=1&mog_id=';
       let link=$('.showAfterSelection').data('href');
       $('.showAfterSelection').attr('href',link+d+obj.id);
       $('.showAfterSelection').show();
   }

  jQuery('#areabox').html('');

      }


      });
}
</script>

<script type="text/javascript">
  var val;

  function customerdata(val){
     let v=2;

   $.ajax({
    type : 'POST',
    url : '{{ url('search/customerdatalike') }}',
 data: {
        "_token": "{{ csrf_token() }}",
        "customerid": val,
        'MOC':v
        },
  success: function(data){
jQuery('#areabox').html('');
jQuery.each( JSON.parse(data), function( i, val1 ) {
  if(v==2){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.person_name} : ${val1.person_no} <li>`);
   }
});

    // $('#areabox').html(data);
$('#areabox').show();
      }
      });
}
</script>

<script type="text/javascript">
    var input = document.querySelector('input[type=file]');
input.onchange = function () {
  var file = input.files[0];
  displayAsImage(file);

};

function displayAsImage(file) {
  var imgURL = URL.createObjectURL(file);
  img=document.getElementById("picchose");
  img.src = imgURL;

}
</script>

<script type="text/javascript">
   function add_surcharge() {

                var first = parseFloat(document.getElementById("total_amount").value);
                var second = parseFloat(document.getElementById("surcharge").value);
                 if(Number.isNaN(first)){
                first=0;
              }
                if(Number.isNaN(second)){
                second=0;
              }
                var result = first + second;

                document.getElementById("total").value = result;

            }
</script>

<script type="text/javascript">

  function extrachargesselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('room-management/room-payment-receipts/calculateextracharges/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){
   var obj = JSON.parse(data);
  if(obj)
  {
    document.getElementById('charges_amount'+idd).value=obj;
  // $('#addressdata').html(data);
 // total+=parseInt(obj);
    //document.getElementById('total_room_charges').value=total;
   total=0;
    $('.charamt').each(function (index, element) {
        total +=parseFloat($(element).val());
    });

   document.getElementById('total_sub_amount').value=total;

calculate_total();

  }
}
   });





  }


function extrachargesselect2(){
    total=0;
    $('.charamt').each(function (index, element) {
        total +=parseFloat($(element).val());
    });

   document.getElementById('total_sub_amount').value=total;

  }



</script>
 
<!-- <script>
    $(function() {
        $('select[name=account_head]').change(function() {



            var url = '{{ url('finance-and-management/account_head/accounttypes') }}';
console.log(url);
            $.get(url, function(data) {
                var select = $('form select[name= account_type]');

                select.empty();

                $.each(data,function(key, value) {
                    select.append('<option value=' + value.id + '>' + value.type + '</option>');
                });
            });
        });
    });
</script>  -->
<!-- <script type="text/javascript">

  function accountheadselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('finance-and-management/account_head/accounttypes/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#account_type').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.type+'</option>';
 $('#account_type').append(s);
                })

  }
}
   });





  }
  
</script> -->



<script type="text/javascript">
 var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lac ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str + 'only';
}

document.getElementById('amount_in_words').onclick = function () {
document.getElementById('amount_in_words').value = inWords(document.getElementById('total').value);
};
</script>

     <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/> 

<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>
<!-- 
    <script>

        $(function () {
            $("#account_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        });

    </script> -->

    <script type="text/javascript">
       function s_percentage() {

                    var first = parseFloat(document.getElementById("total_amount").value);

                    var second = parseFloat(document.getElementById("surcharge_percentage").value);
                
                   if(Number.isNaN(second)){
                    second=0;
                  }

                   if (Number.isNaN(first)) {
                first = 0;
            }

    var surcharge = second / 100;
    var totalValue = first + (first * surcharge);

            document.getElementById("total").value = Math.round(totalValue);



                }
    </script>
@endpush

