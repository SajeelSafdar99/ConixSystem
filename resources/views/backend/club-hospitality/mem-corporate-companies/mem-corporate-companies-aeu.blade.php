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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Corporate Companies</h6>
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
  <li><a href="{{ url('club-hospitality/corporate-companies') }}">Corporate Companies List</a></li>
  <li><a href>Edit Corporate Company</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('club-hospitality/corporate-companies') }}">Corporate Companies List</a></li>
  <li><a href>Add Corporate Company</a></li>
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
    <form method="post" enctype="multipart/form-data" action="{{ url('club-hospitality/corporate-companies/update') }}/{{ $mem_corporate_companies_update->id }}">
     @else
    <form method="post" enctype="multipart/form-data">
    @endif     
    @csrf   
          <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
                 <div class="row">
                  <label class="col-sm-4 form-control-label">Code: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('id')) style="border-color:red;" @endif type="text" name="id" class="form-control input-height" readonly="" style="background-color: #c1c1c1" placeholder="Enter Code" value="@if($init==0){{$increment_number}}@else{{old('id',$mem_corporate_companies_update->id)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Company Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('name')) style="border-color:red;" @endif type="text" name="name" class="form-control input-height" placeholder="Enter Name of Company" value="@if($init==0){{old('name')}}@else{{old('name',$mem_corporate_companies_update->name)}}@endif">
                  </div>
                </div>

                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Company Profile: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('profile')) style="border-color:red;" @endif type="text" name="profile" class="form-control input-height" placeholder="Enter Company's Profile" value="@if($init==0){{old('profile')}}@else{{old('profile',$mem_corporate_companies_update->profile)}}@endif">
                  </div>
                </div>

          <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('address')) style="border-color:red;" @endif name="address" id="address" type="text" class="form-control input-height" placeholder="Enter Company's Address" value="@if($init==0){{old('address')}}@else{{old('address',$mem_corporate_companies_update->address)}}@endif">
                  </div>
                </div>

                 <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">City: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('city')) style="border-color:red;" @endif name="city" id="city" type="text" class="form-control input-height" placeholder="Enter Company's City" value="@if($init==0){{old('city')}}@else{{old('city',$mem_corporate_companies_update->city)}}@endif">
                  </div>
                </div>
                
                  <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Official Contact: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('contact')) style="border-color:red;" @endif name="contact" id="contact" type="text" class="form-control input-height" placeholder="Enter Company's Contact Number" value="@if($init==0){{old('contact')}}@else{{old('contact',$mem_corporate_companies_update->contact)}}@endif">
                  </div>
                </div>

                    <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Official Email: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('email')) style="border-color:red;" @endif name="email" id="email" type="text" class="form-control input-height" placeholder="Enter Company's Email" value="@if($init==0){{old('email')}}@else{{old('email',$mem_corporate_companies_update->email)}}@endif">
                  </div>
                </div>

                   <div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Website: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('website')) style="border-color:red;" @endif name="website" id="website" type="text" class="form-control input-height" placeholder="Enter Company's Website Link" value="@if($init==0){{old('website')}}@else{{old('website',$mem_corporate_companies_update->website)}}@endif">
                  </div>
                </div>

                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            NTN: <span class="tx-danger">*</span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input @if ($errors->has('ntn')) style="border-color:red;" @endif id="ntn" class="form-control input-height" placeholder="Enter Company's National Tax Number" type="text" name="ntn" value="@if($init==0){{old('ntn')}}@else{{old('ntn',$mem_corporate_companies_update->ntn)}}@endif">

                        </div>
                    </div>


                      <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                            Company Logo:
                           
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                             <img id="picchose" style="width: 200px; height: 100px; margin-left: -135px;" src="@if($init==1) {{ url('') }}/{{old('company_logo',$mem_corporate_companies_update->company_logo)}}@else {{ url('assets/images/nouser.png') }} @endif">
                             @if($init==0)
                            <input @if ($errors->has('company_logo')) style="border-color:red;" @endif type="file" name="company_logo" value="@if($init==0){{old('company_logo')}}@endif">
                             @else
        &nbsp &nbsp  &nbsp
<div class="upload-btn-wrapper">
<button class="btne">Edit Picture</button>
<input type="file" name="company_logo" />
</div>
                            <input type="hidden" name="existimg" value="{{old('company_logo',$mem_corporate_companies_update->company_logo)}}">
                            @endif

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
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$mem_corporate_companies_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$mem_corporate_companies_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$mem_corporate_companies_update->status)=='0') selected @endif value="0">
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
                  <a href="{{ url('club-hospitality/corporate-companies') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('club-hospitality/corporate-companies') }}" class="btn btn-secondary">Cancel</a>
                 
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

    $('#contact').mask('00000000000');

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