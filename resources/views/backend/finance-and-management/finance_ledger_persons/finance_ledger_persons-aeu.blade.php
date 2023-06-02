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
</style>
 
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Suppliers</h6>
          <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
    <li><a href="{{ url('finance-and-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('finance-and-management/suppliers') }}">Suppliers List</a></li>
  <li><a href>Edit Supplier</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
    <li><a href="{{ url('finance-and-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('finance-and-management/suppliers') }}">Suppliers List</a></li>
  <li><a href>Add Supplier</a></li>
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
    <form method="post" action="{{ url('finance-and-management/suppliers/update') }}/{{ $person_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
            
                   <div class="row">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Ledger A/c No.: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
  <input id="person_no" name="person_no" type="text" class="form-control input-height" readonly style="background-color:#c1c1c1" value="@if($init==0){{$increment_number}}@else{{old('person_no',$person_update->person_no)}}@endif">
                  </div>
                </div><!-- row -->
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="person_name" name="person_name" type="text" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('person_name')}}@else{{old('person_name',$person_update->person_name)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="person_address" name="person_address" type="text" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('person_address')}}@else{{old('person_address',$person_update->person_address)}}@endif">
                  </div>
                </div>
                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> Contact (a): <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="person_contact" name="person_contact" type="text" class="form-control input-height" placeholder="Enter Mobile Number" value="@if($init==0){{old('person_contact')}}@else{{old('person_contact',$person_update->person_contact)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> Contact (b): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="contact_b" name="contact_b" type="text" class="form-control input-height" placeholder="Enter Mobile Number" value="@if($init==0){{old('contact_b')}}@else{{old('contact_b',$person_update->contact_b)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> Contact (c): </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="contact_c" name="contact_c" type="text" class="form-control input-height" placeholder="Enter Mobile Number" value="@if($init==0){{old('contact_c')}}@else{{old('contact_c',$person_update->contact_c)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> CNIC:  </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="person_cnic" name="person_cnic" type="text" class="form-control input-height" placeholder="Enter CNIC Number (13 digits) " value="@if($init==0){{old('person_cnic')}}@else{{old('person_cnic',$person_update->person_cnic)}}@endif">
                  </div>
                </div>
              
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> Email:  </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="person_email" name="person_email" type="text" class="form-control input-height" placeholder="Enter Email" value="@if($init==0){{old('person_email')}}@else{{old('person_email',$person_update->person_email)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label"> NTN:  </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="ntn" name="ntn" type="text" class="form-control input-height" placeholder="Enter National Tax Number" value="@if($init==0){{old('ntn')}}@else{{old('ntn',$person_update->ntn)}}@endif">
                  </div>
                </div>
                        <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">COA Account:  </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if($errors->has('coa_code')) style="border-color:red;" @endif id="coa_code" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('coa_code')}}@else{{old('coa_code',coaname($person_update->account))}} - {{old('coa_code',$person_update->account)}}@endif" type="text" name="coa_code" onkeyup="coadata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                    <input @if($errors->has('account')) style="border-color:red;"  @endif id="account" autocomplete="off" value="@if($init==0){{old('account')}}@else{{old('account',$person_update->account)}}@endif"
                                                               type="hidden" name="account">

                 <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$person_update->name)}}@endif"
                                                               type="hidden" name="name"
                                                               >

 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                  </div>
                </div>
<br>
                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Bank Account Title: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="acc_title" name="acc_title" type="text" class="form-control input-height" placeholder="Enter Account Title" value="@if($init==0){{old('acc_title')}}@else{{old('acc_title',$person_update->acc_title)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Bank Account Number: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="acc_no" name="acc_no" type="text" class="form-control input-height" placeholder="Enter Account Number" value="@if($init==0){{old('acc_no')}}@else{{old('acc_no',$person_update->acc_no)}}@endif">
                  </div>
                </div>
                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Branch Code: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="branch_code" name="branch_code" type="text" class="form-control input-height" placeholder="Enter Branch Code" value="@if($init==0){{old('branch_code')}}@else{{old('branch_code',$person_update->branch_code)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Branch Address: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input id="branch_address" name="branch_address" type="text" class="form-control input-height" placeholder="Enter Address" value="@if($init==0){{old('branch_address')}}@else{{old('branch_address',$person_update->branch_address)}}@endif">
                  </div>
                </div>


 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/suppliers') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('finance-and-management/suppliers') }}" class="btn btn-secondary">Cancel</a>
                 
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

$('#person_cnic').mask('00000-0000000-0');
$('#person_contact').mask('00000000000');
$('#contact_b').mask('00000000000');
$('#contact_c').mask('00000000000');

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