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
.areabox{cursor:pointer !important;}
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Membership Category</h6>
             <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('club-hospitality/member-category') }}">Membership Category List</a></li>
  <li><a href>Edit Membership Category</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('club-hospitality/member-category') }}">Membership Category List</a></li>
  <li><a href>Add Membership Category</a></li>
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
    <form method="post" action="{{ url('club-hospitality/member-category/update') }}/{{ $mem_category_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
          <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
                 <div class="row">
                  <label class="col-sm-4 form-control-label">Code: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('unique_code')) style="border-color:red;" @endif type="text" name="unique_code" class="form-control input-height" placeholder="Enter Specific Category Code" value="@if($init==0){{old('unique_code')}}@else{{old('unique_code',$mem_category_update->unique_code)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Category: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('desc')) style="border-color:red;" @endif type="text" name="desc" class="form-control input-height" placeholder="Enter Name of Member Category" value="@if($init==0){{old('desc')}}@else{{old('desc',$mem_category_update->desc)}}@endif">
                  </div>
                </div>

              <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">COA Account: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <input @if($errors->has('coa_code')) style="border-color:red;" @endif id="coa_code" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('coa_code')}}@else{{old('coa_code',$mem_category_update->name)}} - {{old('coa_code',$mem_category_update->account)}}@endif" type="text" name="coa_code" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                    <input @if($errors->has('account')) style="border-color:red;"  @endif id="account" autocomplete="off" value="@if($init==0){{old('account')}}@else{{old('account',$mem_category_update->account)}}@endif"
                                                               type="hidden" name="account">

                 <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$mem_category_update->name)}}@endif"
                                                               type="hidden" name="name"
                                                               >

 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                  </div>
                </div>


                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Fee: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                <input @if ($errors->has('fee')) style="border-color:red;" @endif type="number" name="fee" class="form-control input-height" placeholder="Enter Total Membership Fee for Category" value="@if($init==0){{old('fee')}}@else{{old('fee',$mem_category_update->fee)}}@endif">
                  </div>
                </div>
               <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Monthly Subscription Fee: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('monthly_sub_fee')) style="border-color:red;" @endif type="number" name="monthly_sub_fee" class="form-control input-height" placeholder="Enter Monthly Subscription Fee of Membership"  value="@if($init==0){{old('monthly_sub_fee')}}@else{{old('monthly_sub_fee',$mem_category_update->monthly_sub_fee)}}@endif">
                  </div>
                </div>
                  <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                   Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$mem_category_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$mem_category_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$mem_category_update->status)=='0') selected @endif value="0">
                                    In-Active
                                </option>
                                
                                @else

                              <option @if($init==0) selected="" @else @if(old('status')=='1') selected @endif @endif value="1">
                                   Active
                                </option>
                                <option @if(old('status')=='0') selected @endif value="0">
                                    In-Active
                                </option>

                                @endif


                            </select>
                        </div>
                    </div>
                    
                @if($init==1)     
  <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('club-hospitality/member-category') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('club-hospitality/member-category') }}" class="btn btn-secondary">Cancel</a>
                 
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

        function customerdata(val) {
            
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

                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.name} - ${val1.code}<li>`);

                    });
$('#areabox').show();
                 

                }
            });
        }

</script>

<script type="text/javascript">
        var val;

        function customerdatavalue(val) {
          
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