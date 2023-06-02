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

  .headingsettings {
            color: black!important;
        }
.aligningcheckboxes{
  text-align: left !important;
}

.checkboxspecial{
  width:14%;
}
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Predefined Values</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('admin-settings/predefined-values') }}">Predefined Values List</a></li>
  <li><a href>Edit Predefined Value</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('admin-settings/predefined-values') }}">Predefined Values List</a></li>
  <li><a href>Add Predefined Value</a></li>
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
          <form method="post" action="{{ url('admin-settings/predefined-values/update') }}/{{ $values_update->id }}">
                 @else
                 <form method="post">
                   @endif
            @csrf
              <div class="form-layout form-layout-4 ">
                <div >
                <h6 class="box-title" style="color: black; text-align: center;">FOOD & BEVERAGE</h6>

                <div class="row headingsettings">
                <label class="col-sm-2 form-control-label">Max. Item Discount Amount:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('discount_amount')) style="border-color:red;" @endif type="number" id="discount_amount" name="discount_amount" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$values_update->discount_amount)}}@endif" placeholder="Enter Amount" onclick="alternativereadonly()">
                  </div>
                <label class="col-sm-2 form-control-label">Max. Item Discount Percentage:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                  <input type="number" @if ($errors->has('discount_percentage')) style="border-color:red;" @endif id="discount_percentage" class="form-control input-height" value="@if($init==0){{old('discount_percentage')}}@else{{old('surcharge_percentage',$values_update->discount_percentage)}}@endif" name="discount_percentage" onclick="alternativereadonly2()">
                  </div>
                </div>
                <div class="row mg-t-10 headingsettings">
                <label class="col-sm-2 form-control-label">Max. Dine-In Tax Amount: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('tax_amount')) style="border-color:red;" @endif type="number" id="tax_amount" name="tax_amount" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('tax_amount')}}@else{{old('tax_amount',$values_update->tax_amount)}}@endif" placeholder="Enter Amount" onclick="alternativereadonly3()">
                  </div>
                <label class="col-sm-2 form-control-label">Max. Dine-In Tax Percentage:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                  <input type="number" @if ($errors->has('tax_percentage')) style="border-color:red;" @endif id="tax_percentage" class="form-control input-height" value="@if($init==0){{old('tax_percentage')}}@else{{old('surcharge_percentage',$values_update->tax_percentage)}}@endif" name="tax_percentage" onclick="alternativereadonly4()">
                  </div>
                </div>

                <div class="row mg-t-10 headingsettings">
                <label class="col-sm-2 form-control-label">Max. Take Away Tax Amount: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('take_away_tax')) style="border-color:red;" @endif type="number" id="take_away_tax" name="take_away_tax" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('take_away_tax')}}@else{{old('take_away_tax',$values_update->take_away_tax)}}@endif" placeholder="Enter Amount" onclick="alternativereadonly7()">
                  </div>
                <label class="col-sm-2 form-control-label">Max. Take Away Tax Percentage:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                  <input type="number" @if ($errors->has('take_away_tax_pct')) style="border-color:red;" @endif id="take_away_tax_pct" class="form-control input-height" value="@if($init==0){{old('take_away_tax_pct')}}@else{{old('surcharge_percentage',$values_update->take_away_tax_pct)}}@endif" name="take_away_tax_pct" onclick="alternativereadonly8()">
                  </div>
                </div>
                <div class="row mg-t-10 headingsettings">
                <label class="col-sm-2 form-control-label">Max. Delivery Tax Amount: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('home_del_tax')) style="border-color:red;" @endif type="number" id="home_del_tax" name="home_del_tax" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('home_del_tax')}}@else{{old('home_del_tax',$values_update->home_del_tax)}}@endif" placeholder="Enter Amount" onclick="alternativereadonly9()">
                  </div>
                <label class="col-sm-2 form-control-label">Max. Delivery Tax Percentage:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                  <input type="number" @if ($errors->has('home_del_tax_pct')) style="border-color:red;" @endif id="home_del_tax_pct" class="form-control input-height" value="@if($init==0){{old('home_del_tax_pct')}}@else{{old('surcharge_percentage',$values_update->home_del_tax_pct)}}@endif" name="home_del_tax_pct" onclick="alternativereadonly10()">
                  </div>
                </div>

                <div class="row mg-t-10 headingsettings">
                <label class="col-sm-2 form-control-label">Max. Service Charges: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('service_amount')) style="border-color:red;" @endif type="number" id="service_amount" name="service_amount" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('service_amount')}}@else{{old('service_amount',$values_update->service_amount)}}@endif" placeholder="Enter Amount" onclick="alternativereadonly5()">
                  </div>
                <label class="col-sm-2 form-control-label">Max. Service Charges Percentage:</label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                  <input type="number" @if ($errors->has('service_percentage')) style="border-color:red;" @endif id="service_percentage" class="form-control input-height" value="@if($init==0){{old('service_percentage')}}@else{{old('surcharge_percentage',$values_update->service_percentage)}}@endif" name="service_percentage" onclick="alternativereadonly6()">
                  </div>
                </div>

 <div class="row mg-t-10 headingsettings">
          <label class="col-sm-2 form-control-label">Default Printer: </label>
           <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <select @if ($errors->has('printer')) style="border-color:red;" @endif  id="printer" name="printer" class="form-control select2" ><option value="{{$values_update->printer}}">{{$values_update->printer}}</option> </select>
                        </div>
                           <label class="col-sm-2 form-control-label">Print Quantity: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
               <input @if ($errors->has('print_limit')) style="border-color:red;" @endif type="number" id="print_limit" name="print_limit" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('print_limit')}}@else{{old('print_limit',$values_update->print_limit)}}@endif" placeholder="Enter Amount">
                          </div>
                        </div>
                         <div class="row mg-t-10 headingsettings">
                             <label class="col-sm-2 form-control-label">XP Rider Printer: </label>
           <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <select @if ($errors->has('xp_printer')) style="border-color:red;" @endif  id="xp_printer" name="xp_printer" class="form-control select2" >
                              <option value="{{$values_update->xp_printer}}">{{$values_update->xp_printer}}</option>
                          </select>
                        </div>


                             <label class="col-sm-2 form-control-label">XP Rider Printer (2): </label>
           <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <select @if ($errors->has('xp_printer_two')) style="border-color:red;" @endif  id="xp_printer_two" name="xp_printer_two" class="form-control select2" >
                              <option value="{{$values_update->xp_printer_two}}">{{$values_update->xp_printer_two}}</option>
                          </select>
                        </div>

                       
                        </div>
                         <div class="row mg-t-10 headingsettings">
                             <label class="col-sm-2 form-control-label">Due Date: </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <input @if ($errors->has('fnb_due')) style="border-color:red;" @endif id="fnb_due" autocomplete="off" type="text" name="fnb_due" class="form-control input-height" placeholder="dd/mm/yyyy" value="@if($init==0){{old('fnb_due')}}@else{{old('fnb_due',formatDateToShow(settings('fnb_due')))}}@endif">
                        </div>

                            <label class="col-sm-2 form-control-label">Currency: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                 <select @if ($errors->has('currency')) style="border-color:red;" @endif  id="currency" name="currency" class="form-control select2">
                                <option label="Choose Option">
                                </option>
                                @foreach($currencies as $currency)
                                @if($init==1)
                                <option @if(old('currency',$values_update->currency)==$currency->id) selected @endif value="{{$currency->id}}">
                                    {{$currency->code}}
                                </option>
                                @else
                                <option @if(old('currency')==$currency->id)  selected @endif value="{{ $currency->id }}">
                                    {{$currency->code}}
                                </option>
                                @endif
                                @endforeach

                            </select>
                          </div>

                          </div>
                        </div>

                          <br>  <br>
                <h6 class="box-title" style="color: black; text-align: center;">ROOMS MANAGEMENT</h6>
  <div class="row mg-t-10 headingsettings">
                             <label class="col-sm-2 form-control-label">Due Date: </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <input @if ($errors->has('rooms_due')) style="border-color:red;" @endif id="rooms_due" autocomplete="off" type="text" name="rooms_due" class="form-control input-height" placeholder="dd/mm/yyyy" value="@if($init==0){{old('rooms_due')}}@else{{old('rooms_due',formatDateToShow(settings('rooms_due')))}}@endif">
                        </div>

                          <label class="col-sm-2 form-control-label"></label>
                         <div class="col-sm-4 mg-t-10 mg-sm-t-0">

                          </div>
                        </div>

                  <br>  <br>
                <h6 class="box-title" style="color: black; text-align: center;">STORE MANAGEMENT</h6>

                   <div class="row mg-t-10 headingsettings">
                 <label class="col-sm-2 form-control-label">Store Location: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <select @if ($errors->has('store_location')) style="border-color:red;" @endif  id="store_location" name="store_location" class="form-control select2" onchange="storelocationselect(this.id)">
                                <option label="Choose Option">
                                </option>
                                @foreach($locations as $store_location)
                                @if($init==1)
                                <option @if(old('store_location',$values_update->store_location)==$store_location->id) selected @endif value="{{$store_location->id}}">
                                    {{$store_location->desc}}
                                </option>
                                @else
                                <option @if(old('store_location')==$store_location->id)  selected @endif value="{{ $store_location->id }}">
                                    {{$store_location->desc}}
                                </option>
                                @endif
                                @endforeach

                            </select>
                          </div>
                  <label class="col-sm-2 form-control-label">Store Department: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <select @if ($errors->has('department')) style="border-color:red;" @endif  id="department" name="department" class="form-control select2">
                                <option label="Choose Option">
                                </option>
                                @foreach($departments as $department)
                                @if($init==1)
                                <option @if(old('department',$values_update->department)==$department->id) selected @endif value="{{$department->id}}">
                                    {{$department->desc}}
                                </option>
                                @else
                                <option @if(old('department')==$department->id)  selected @endif value="{{ $department->id }}">
                                    {{$department->desc}}
                                </option>
                                @endif
                                @endforeach

                            </select>
                          </div>
                </div>
        <br>  <br>
                <h6 class="box-title" style="color: black; text-align: center;">HUMAN RESOURCE MANAGEMENT</h6>

                   <div class="row mg-t-10 headingsettings">
                 <label class="col-sm-2 form-control-label">Default Hours: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input type="number" @if ($errors->has('default_hours')) style="border-color:red;" @endif id="default_hours" class="form-control input-height" value="@if($init==0){{old('default_hours')}}@else{{old('default_hours',$values_update->default_hours)}}@endif" name="default_hours" placeholder="Enter No. of Hours">
                          </div>
                  <label class="col-sm-2 form-control-label">Default Off Days: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <input type="number" @if ($errors->has('default_offs')) style="border-color:red;" @endif id="default_offs" class="form-control input-height" placeholder="Enter No. of Days" value="@if($init==0){{old('default_offs')}}@else{{old('default_offs',$values_update->default_offs)}}@endif" name="default_offs">
                          </div>
                </div>
                 <div class="row mg-t-10 headingsettings">
                 <label class="col-sm-2 form-control-label">Include Overtime Hours: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
    <select @if ($errors->has('include_overtime')) style="border-color:red;" @endif class="form-control" name="include_overtime" value="@if($init==0){{old('include_overtime')}}@else{{old('include_overtime',$values_update->include_overtime)}}@endif">

                                 @if($init==1)
                                 <option @if($init==0) selected="" @else @if(old('include_overtime',$values_update->include_overtime)=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('include_overtime',$values_update->include_overtime)=='No') selected @endif value="No">
                                  No
                                </option>
                                 @else

                                 <option @if($init==0) selected="" @else @if(old('include_overtime')=='Yes') selected @endif @endif value="Yes">
                                    Yes
                                </option>
                                <option @if(old('include_overtime')=='No') selected @endif value="No">
                                    No
                                </option>

                                 @endif

                            </select>
                          </div>
                  <label class="col-sm-2 form-control-label"> </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                   </div>
                </div>

                        <br>  <br>
                <h6 class="box-title" style="color: black; text-align: center;">CASH RECEIPTS</h6>
              <div class="row mg-t-10 headingsettings">
                             <label class="col-sm-2 form-control-label">Due Date: </label>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                          <input @if ($errors->has('cashrec_due')) style="border-color:red;" @endif id="cashrec_due" autocomplete="off" type="text" name="cashrec_due" class="form-control input-height" placeholder="dd/mm/yyyy" value="@if($init==0){{old('cashrec_due')}}@else{{old('cashrec_due',formatDateToShow(settings('cashrec_due')))}}@endif">
                        </div>
                      </div>
                        <div class="row mg-t-10 headingsettings">

                          <label class="col-sm-2 form-control-label">Trans Types:</label>
                         <div class="col-sm-10 mg-t-10 mg-sm-t-0 form-group aligningcheckboxes">
             

               <div class="row">  
                   @foreach($trans_types as $tt)
              
                  @if($init==0)
                 
                 <div class="checkboxspecial">  


                  <input name="trans_type[]" type="checkbox" value="{{ $tt->id}}" id="{{$tt->name}}" >
                  <label for="{{$tt->name}}">{{$tt->name}}</label>
              
               </div>
                  @else

                   <div class="checkboxspecial">

                    <input @if(in_array($tt->id,$selected)) checked @endif name="trans_type[]" type="checkbox" value="{{ $tt->id}}" id="{{$tt->name}}" >
                  <label for="{{$tt->name}}">{{$tt->name}}</label>


                </div>

                  @endif
                  
                  @endforeach
                   </div>


<!-- 
<select multiple="multiple" name="trans_type[]" id="trans_type">

  @foreach($trans_types as $tt)

                             @if($init==1)
                             
                                <option
                                     @if(old('trans_type[]',$tt->trans_type)==$tt->id)  selected
                                                    @endif value="{{ $tt->id }}">
                                                           {{ $tt->name }}
                                                  </option>
                                              
                                                     @else
                            <option
                           @if(old('trans_type[]')==$tt->id)  selected  @endif value="{{ $tt->id }}">
                                      {{ $tt->name }}
                                            </option>
                                 @endif
                               
                                 @endforeach
</select> -->
                          </div>
                        </div>


                                    <br>  <br>
                <h6 class="box-title" style="color: black; text-align: center;">CHART OF ACCOUNTS</h6>
                   <div class="row mg-t-10 headingsettings">
                  <label class="col-sm-2 form-control-label">Cost Center: </label>
                  <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                     <select @if ($errors->has('cost_center')) style="border-color:red;" @endif  id="cost_center" name="cost_center" class="form-control select2">
                                <option label="Choose Option">
                                </option>
                                @foreach($cost_centers as $cost_center)
                                @if($init==1)
                                <option @if(old('cost_center',$values_update->cost_center)==$cost_center->code) selected @endif value="{{$cost_center->code}}">
                                    {{$cost_center->name}} ({{coaaccountname($cost_center->desc)}})
                                </option>
                                @else
                                <option @if(old('cost_center')==$cost_center->code)  selected @endif value="{{ $cost_center->code }}">
                                    {{$cost_center->name}} ({{coaaccountname($cost_center->desc)}})
                                </option>
                                @endif
                                @endforeach

                            </select>
                          </div>
                </div>

 <br> <br>



  @if($init==1)
               <div class="row mg-t-10">
               <label class="col-sm-5 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('admin-settings/predefined-values') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>
   @else
<div class="row mg-t-10">
               <label class="col-sm-5 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Add More">

                  &nbsp&nbsp
                  <a href="{{ url('admin-settings/predefined-values') }}" class="btn btn-secondary">Cancel</a>

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

  function storelocationselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('store-management/store-locations/department/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#department').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#department').append(s);
                })

  }
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

        function alternativereadonly3() {
          document.getElementById("tax_amount").readOnly = false;

                document.getElementById("tax_percentage").readOnly = true;
                document.getElementById("tax_percentage").value = '';

        }

        function alternativereadonly4() {
          document.getElementById("tax_percentage").readOnly = false;

                document.getElementById("tax_amount").readOnly = true;
                document.getElementById("tax_amount").value = '';

        }

         function alternativereadonly5() {
          document.getElementById("service_amount").readOnly = false;

                document.getElementById("service_percentage").readOnly = true;
                document.getElementById("service_percentage").value = '';

        }

        function alternativereadonly6() {
          document.getElementById("service_percentage").readOnly = false;

                document.getElementById("service_amount").readOnly = true;
                document.getElementById("service_amount").value = '';

        }

        function alternativereadonly7() {
          document.getElementById("take_away_tax").readOnly = false;

                document.getElementById("take_away_tax_pct").readOnly = true;
                document.getElementById("take_away_tax_pct").value = '';

        }

        function alternativereadonly8() {
          document.getElementById("take_away_tax_pct").readOnly = false;

                document.getElementById("take_away_tax").readOnly = true;
                document.getElementById("take_away_tax").value = '';

        }

        function alternativereadonly9() {
          document.getElementById("home_del_tax").readOnly = false;

                document.getElementById("home_del_tax_pct").readOnly = true;
                document.getElementById("home_del_tax_pct").value = '';

        }

        function alternativereadonly10() {
          document.getElementById("home_del_tax_pct").readOnly = false;

                document.getElementById("home_del_tax").readOnly = true;
                document.getElementById("home_del_tax").value = '';

        }

    </script>


@if($init==1)
    <script type="text/javascript">
        $(document).ready(function () {
var discamt = document.getElementById("discount_amount").value;
var discpct = document.getElementById("discount_percentage").value;
var taxamt = document.getElementById("tax_amount").value;
var taxpct = document.getElementById("tax_percentage").value;
var takeaway_taxamt = document.getElementById("take_away_tax").value;
var takeaway_taxpct = document.getElementById("take_away_tax_pct").value;
var delivery_taxamt = document.getElementById("home_del_tax").value;
var delivery_taxpct = document.getElementById("home_del_tax_pct").value;
var serviceamt = document.getElementById("service_amount").value;
var servicepct = document.getElementById("service_percentage").value;

if(discamt == ''){
  document.getElementById("discount_amount").readOnly = true;
}
if(discpct == ''){
  document.getElementById("discount_percentage").readOnly = true;
}
if(taxamt == ''){
  document.getElementById("tax_amount").readOnly = true;
}
if(taxpct == ''){
  document.getElementById("tax_percentage").readOnly = true;
}
if(takeaway_taxamt == ''){
  document.getElementById("take_away_tax").readOnly = true;
}
if(takeaway_taxpct == ''){
  document.getElementById("take_away_tax_pct").readOnly = true;
}
if(delivery_taxamt == ''){
  document.getElementById("home_del_tax").readOnly = true;
}
if(delivery_taxpct == ''){
  document.getElementById("home_del_tax_pct").readOnly = true;
}
if(serviceamt == ''){
  document.getElementById("service_amount").readOnly = true;
}
if(servicepct == ''){
  document.getElementById("service_percentage").readOnly = true;
}
        });

    </script>
     @endif

        <script type="text/javascript">
$( document ).ready(function() {
                $.ajax({
                    type: 'get',

                    url: 'http://@php echo env('printer', '192.168.1.127:5000') @endphp/',
          crossDomain:true,

                    success: function (data) {
                          var obj = JSON.parse(data);

                                   let selected="{{$init==1?$values_update->printer:''}}";
        $('#printer').html('<option label="Choose Option">  </option>');
                        $.each(obj,function(x,y){

                          let s='<option value="'+y[2]+'">'+y[2]+'</option>';

                          console.log(selected==y[2]);
                          if(selected==y[2]){

                              s='<option value="'+y[2]+'" selected="selected">'+y[2]+'</option>';
                          }
   $('#printer').append(s);
                        })

 /*       $('#printer').html('<option label="Choose Option">  </option>');
                        $.each(obj,function(x,y){

                          let s='<option value="'+y[2]+'">'+y[2]+'</option>';


                            $('#printer').append(s);
                        })*/
                    }
                });
           });

    </script>
        <script type="text/javascript">
$( document ).ready(function() {
                $.ajax({
                    type: 'get',

                    url: 'http://@php echo env('printer', '192.168.1.127:5000') @endphp/',
          crossDomain:true,

                    success: function (data) {
                          var obj = JSON.parse(data);

                                   let selected="{{$init==1?$values_update->xp_printer:''}}";
        $('#xp_printer').html('<option label="Choose Option">  </option>');
                        $.each(obj,function(x,y){

                          let s='<option value="'+y[2]+'">'+y[2]+'</option>';

                          console.log(selected==y[2]);
                          if(selected==y[2]){

                              s='<option value="'+y[2]+'" selected="selected">'+y[2]+'</option>';
                          }
   $('#xp_printer').append(s);
                        })

                    }
                });
           });

    </script>


   <script type="text/javascript">
$( document ).ready(function() {
                $.ajax({
                    type: 'get',

                    url: 'http://@php echo env('printer', '192.168.1.127:5000') @endphp/',
          crossDomain:true,

                    success: function (data) {
                          var obj = JSON.parse(data);

                                   let selected="{{$init==1?$values_update->xp_printer_two:''}}";
        $('#xp_printer_two').html('<option label="Choose Option">  </option>');
                        $.each(obj,function(x,y){

                          let s='<option value="'+y[2]+'">'+y[2]+'</option>';

                          console.log(selected==y[2]);
                          if(selected==y[2]){

                              s='<option value="'+y[2]+'" selected="selected">'+y[2]+'</option>';
                          }
   $('#xp_printer_two').append(s);
                        })

                    }
                });
           });

    </script>




<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

  <script>
    $( function() {
    $( "#fnb_due" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );


     $( function() {
    $( "#rooms_due" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );


      $( function() {
    $( "#cashrec_due" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

  </script>

@endpush
