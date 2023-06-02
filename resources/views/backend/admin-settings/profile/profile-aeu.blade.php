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
.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
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
</style>
 
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Company Profile</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('admin-settings/profile') }}">Company Profile</a></li>
  <li><a href>Edit Company Profile</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('admin-settings/profile') }}">Company Profile</a></li>
  <li><a href>Add Company Profile</a></li>
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
    <form method="post" enctype="multipart/form-data" action="{{ url('admin-settings/profile/update') }}/{{ $profile_update->id }}">
     @else
    <form method="post" enctype="multipart/form-data">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

              <div class="row mg-t-10 ">
                <label class="col-sm-4 form-control-label">Cost Center:  <span class="tx-danger">*</span></label>
                 <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                     <select @if ($errors->has('cost_center')) style="border-color:red;" @endif  id="cost_center" name="cost_center" class="form-control select2">
                                <option label="Choose Option">
                                </option>
                                @foreach($cost_centers as $cost_center)
                                @if($init==1)
                                <option @if(old('cost_center',$profile_update->cost_center)==$cost_center->code) selected @endif value="{{$cost_center->code}}">
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


             <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Organization Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
<input name="organization_name" id="organization_name" type="text" class="form-control input-height" placeholder="Enter Organization's Name" value="@if($init==0){{old('organization_name')}}@else{{old('organization_name',$profile_update->organization_name)}}@endif">
                  </div>
                </div>

              <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Company Name / Title: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="company_name" id="company_name" type="text" class="form-control input-height" placeholder="Enter Company's Name" value="@if($init==0){{old('company_name')}}@else{{old('company_name',$profile_update->company_name)}}@endif">
                  </div>
                </div>

                  <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="company_address" id="company_address" type="text" class="form-control input-height" placeholder="Enter Company's Address" value="@if($init==0){{old('company_address')}}@else{{old('company_address',$profile_update->company_address)}}@endif">
                  </div>
                </div>

                 <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="company_city" id="company_city" type="text" class="form-control input-height" placeholder="Enter Company's City" value="@if($init==0){{old('company_city')}}@else{{old('company_city',$profile_update->company_city)}}@endif">
                  </div>
                </div>
                
                  <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Contact: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="company_number" id="company_number" type="text" class="form-control input-height" placeholder="Enter Company's Contact Number" value="@if($init==0){{old('company_number')}}@else{{old('company_number',$profile_update->company_number)}}@endif">
                  </div>
                </div>

                    <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Email: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="company_email" id="company_email" type="text" class="form-control input-height" placeholder="Enter Company's Email" value="@if($init==0){{old('company_email')}}@else{{old('company_email',$profile_update->company_email)}}@endif">
                  </div>
                </div>

                   <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Website: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="company_website" id="company_website" type="text" class="form-control input-height" placeholder="Enter Company's Website Link" value="@if($init==0){{old('company_website')}}@else{{old('company_website',$profile_update->company_website)}}@endif">
                  </div>
                </div>

                 <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Company Logo:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                             <img id="picchose" style="width: 200px; height: 100px; margin-left: -135px;" src="@if($init==1) {{ url('') }}/{{old('company_logo',$profile_update->company_logo)}}@else {{ url('assets/images/nouser.png') }} @endif">
                             @if($init==0)
                            <input @if ($errors->has('company_logo')) style="border-color:red;" @endif type="file" name="company_logo" value="@if($init==0){{old('company_logo')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="company_logo" />
</div>
                            <input type="hidden" name="existimg" value="{{old('company_logo',$profile_update->company_logo)}}">
                            @endif

                        </div>
                    </div>
                

 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('admin-settings/profile') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>

   @else      
   <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">
                
                  &nbsp&nbsp
                  <a href="{{ url('admin-settings/profile') }}" class="btn btn-secondary">Cancel</a>
                 
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
@endpush