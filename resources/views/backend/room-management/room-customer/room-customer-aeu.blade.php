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


.areabox {
            cursor: pointer !important;
        }

</style>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Guest</h6>
        <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1 && $eventstatus==0)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('room-management/room-customer') }}">Guest List</a></li>
  <li><a href>Edit Guest</a></li>
</ul>

@elseif($init==1 && $eventstatus==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
 <li><a href="{{ url('events-management') }}">Events Management</a></li>
 <li><a href="{{ url('events-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('events-management/event-customer') }}">Guest List</a></li>
  <li><a href>Edit Guest</a></li>
</ul>

@elseif($init==0 && $eventstatus==0)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('room-management/room-customer') }}">Guest List</a></li>
  <li><a href>Add Guest</a></li>
</ul>

@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('events-management/event-customer') }}">Guest List</a></li>
  <li><a href>Add Guest</a></li>
</ul>

@endif

     
<div class="col-xl-12">

    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    
    
    @if($init==1)
    <form method="post" action="{{ url('room-management/room-customer/update') }}/{{ $room_customer_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
               
                <div class="row">
                  <label></label>
                  <label class="col-sm-4 form-control-label">#: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
  <input @if ($errors->has('customer_no')) style="border-color:red;" @endif id="customer_no" name="customer_no" type="text" class="form-control input-height" readonly style="background-color:#c1c1c1" value="@if($init==0){{$increment_number}}@else{{old('customer_no', $room_customer_update->customer_no)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('customer_name')) style="border-color:red;" @endif id="customer_name" name="customer_name" type="text" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('customer_name')}}@else{{old('customer_name', $room_customer_update->customer_name)}}@endif">
                  </div>
                </div>
                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Contact: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('customer_contact')) style="border-color:red;" @endif id="customer_contact" name="customer_contact" type="text" class="form-control input-height" placeholder="Enter Mobile Number" value="@if($init==0){{old('customer_contact')}}@else{{old('customer_contact', $room_customer_update->customer_contact)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Address: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('customer_address')) style="border-color:red;" @endif id="customer_address" name="customer_address" type="text" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('customer_address')}}@else{{old('customer_address', $room_customer_update->customer_address)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> CNIC: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                <input @if ($errors->has('customer_cnic')) style="border-color:red;" @endif id="customer_cnic" name="customer_cnic" type="text" class="form-control input-height" placeholder="Enter CNIC Number (13 digits) " value="@if($init==0){{old('customer_cnic')}}@else{{old('customer_cnic', $room_customer_update->customer_cnic)}}@endif">
                  </div>
                </div>
              
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Email:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input @if ($errors->has('customer_email')) style="border-color:red;" @endif id="customer_email" name="customer_email" type="text" class="form-control input-height" placeholder="Enter Email" value="@if($init==0){{old('customer_email')}}@else{{old('customer_email', $room_customer_update->customer_email)}}@endif">
                  </div>
                </div>
           
                   <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                       Guest Type:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('guest_type')) style="border-color:red;" @endif id="guest_type" class="form-control" name="guest_type">

                                <option label="Choose Option">
                                </option>
                                @foreach($gts as $gt)
                                @if($init==1)
                                 <option @if(old('guest_type',$room_customer_update->guest_type)==$gt->id)  selected @endif  value="{{ $gt->id }}">
                                    {{ $gt->desc }}
                                </option>
                                @else
                                 <option @if(old('guest_type')==$gt->id)  selected @endif  value="{{ $gt->id }}">
                                    {{ $gt->desc }}
                                </option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">COA Account: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if($errors->has('coa_code')) style="border-color:red;" @endif id="coa_code" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('coa_code')}}@else{{old('coa_code',coaname($room_customer_update->account))}} - {{old('coa_code',$room_customer_update->account)}}@endif" type="text" name="coa_code" onkeyup="coadata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                    <input @if($errors->has('account')) style="border-color:red;"  @endif id="account" autocomplete="off" value="@if($init==0){{old('account')}}@else{{old('account',$room_customer_update->account)}}@endif"
                                                               type="hidden" name="account">

                 <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$room_customer_update->name)}}@endif"
                                                               type="hidden" name="name"
                                                               >

 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                  </div>
                </div>

                  <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                       Partner / Affiliate:
                           
                        </label>

                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('affiliate')) style="border-color:red;" @endif id="affiliate" class="form-control" name="affiliate">

                                <option label="Choose Option">
                                </option>
                                @foreach($affs as $aff)
                                @if($init==1)
                                 <option @if(old('affiliate',$room_customer_update->affiliate)==$aff->id)  selected @endif  value="{{ $aff->id }}">
                                    {{ $aff->partner_name }}
                                </option>
                                @else
                                 <option @if(old('affiliate')==$aff->id)  selected @endif  value="{{ $aff->id }}">
                                    {{ $aff->partner_name }}
                                </option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>

                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Member Reference:</label>
                 <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('member_name')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('member_name')}}@else{{old('member_name',$room_customer_update->member_name)}}@endif" name="member_name" id="member_name" autocomplete="off" class="form-control input-height" placeholder="Enter to Search"  onkeyup="customerdata(this.value)">
                     <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>
                  </div>
                   </div>
                    <div class="row mg-t-10">
            <label class="col-sm-4 form-control-label">Membership No.:</label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('mem_no')) style="border-color:red;" @endif type="text" value="@if($init==0){{old('mem_no')}}@else{{old('mem_no',$room_customer_update->mem_no)}}@endif" name="mem_no" id="mem_no" class="form-control input-height" placeholder="Enter Membership Number">
                  </div>
                </div>
 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-customer') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('room-management/room-customer') }}" class="btn btn-secondary">Cancel</a>
                 
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

//$('#customer_name').attr('maxlength', 100);
//$('#customer_address').attr('maxlength', 600);
$('#customer_cnic').mask('00000-0000000-0');
$('#customer_contact').mask('00000000000');
//$('#customer_email').attr('maxlength', 300); 


</script>

      <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v = 0;
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
                        document.getElementById('member_name').value = obj.applicant_name;
                        document.getElementById('mem_no').value = obj.mem_no;
          
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>
     <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v = 0;
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
                        let name = v == 1 ? val1.customer_name : val1.applicant_name;
                        let code = v == 1 ? val1.customer_no : val1.mem_no;
                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code}<li>`);


                    });

                    // $('#areabox').html(data);

                }
            });
        }
    </script>


     <script type="text/javascript">

            var val;

        function coadata(val) {
            
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "searchid": val,
                    
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                        $("#areabox").append(`<li onclick="coadatavalue('${val1.id}')">${val1.name} - ${val1.code}<li>`);

                    });
$('#areabox').show();
                 

                }
            });
        }

</script>

<script type="text/javascript">
        var val;

        function coadatavalue(val) {
          
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "theid": val,
                 
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    console.log(obj);
                  
                          $fname=obj.name?obj.name+' ':'';
                     
                          $lname=obj.code?obj.code:'';

                        document.getElementById('coa_code').value = $fname+'-'+' '+$lname;
 
                        document.getElementById('account').value = obj.code;
                        document.getElementById('name').value = obj.name;

                        $("#coa_code").prop("readonly", true);
                     
                      
                    jQuery('#areabox').html('');

                }


            });
        }
</script>

@endpush