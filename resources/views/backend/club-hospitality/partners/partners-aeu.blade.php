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
.headingsetting{
  color: black !important;
}
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Partners / Affiliates</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


 @if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/partners') }}">Partners / Affiliates List</a></li>
  <li><a href>Edit Partner / Affiliate</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/partners') }}">Partners / Affiliates List</a></li>
  <li><a href>Add Partner / Affiliate</a></li>
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
    <form method="post" enctype="multipart/form-data" action="{{ url('club-hospitality/partners/update') }}/{{ $partners_update->id }}">
     @else
    <form method="post" enctype="multipart/form-data">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="row">
               <div class="col-sm-6">
                 <br>
                <h6 class="box-title" style="color: black; text-align: center;">PARTNER / AFFILIATE INFORMATION</h6>
                
                 <div class="row">
                        <label class="col-sm-3 form-control-label headingsetting">
                            Type:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('type')) style="border-color:red;" @endif class="form-control" name="type" id="type" value="@if($init==0){{old('type')}}@else{{old('type',$partners_update->type)}}@endif">
                                <option label="Choose Option">
                                </option>
                                 @if($init==1)
                                 <option @if(old('type',$partners_update->type)=='Club') selected @endif value="Club">
                                    Club
                                </option>
                                <option @if(old('type',$partners_update->type)=='Company') selected @endif value="Company">
                                    Company
                                </option>
                                <option @if(old('type',$partners_update->type)=='Other') selected @endif value="Other">
                                    Other
                                </option>
                                 @else

                                 <option @if(old('type')=='Club') selected @endif value="Club">
                                    Club
                                </option>
                                <option @if(old('type')=='Company') selected @endif value="Company">
                                    Company
                                </option>
                                <option @if(old('type')=='Other') selected @endif value="Other">
                                    Other
                                </option>

                                 @endif

                            </select>
                        </div>
                    </div>
 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Partner / Affiliate Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('partner_name')) style="border-color:red;" @endif name="partner_name" type="text" id="partner_name" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('partner_name')}}@else{{old('partner_name',$partners_update->partner_name)}}@endif">
                  </div>
                </div>

                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Facilitation / Discount:</label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('facilitation')) style="border-color:red;" @endif name="facilitation" id="facilitation" type="text" class="form-control input-height" placeholder="Enter Details" value="@if($init==0){{old('facilitation')}}@else{{old('facilitation',$partners_update->facilitation)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Address:<span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('address')) style="border-color:red;" @endif name="address" id="address" type="text" class="form-control input-height" placeholder="Enter Complete Address" value="@if($init==0){{old('address')}}@else{{old('address',$partners_update->address)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Telephone: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('partner_tel_a')) style="border-color:red;" @endif name="partner_tel_a" id="partner_tel_a" type="number" class="form-control input-height" placeholder="Enter Telephone Number" value="@if($init==0){{old('partner_tel_a')}}@else{{old('partner_tel_a',$partners_update->partner_tel_a)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Mobile (a): </label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('partner_mob_a')) style="border-color:red;" @endif name="partner_mob_a" id="partner_mob_a" type="number" class="form-control input-height" placeholder="Enter First Contact Number" value="@if($init==0){{old('partner_mob_a')}}@else{{old('partner_mob_a',$partners_update->partner_mob_a)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Mobile (b): </label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('partner_mob_b')) style="border-color:red;" @endif name="partner_mob_b" id="partner_mob_b" type="number" class="form-control input-height" placeholder="Enter Second Contact Number" value="@if($init==0){{old('partner_mob_b')}}@else{{old('partner_mob_b',$partners_update->partner_mob_b)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Email:<span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('partner_email')) style="border-color:red;" @endif name="partner_email" id="partner_email" type="text" class="form-control input-height" placeholder="Enter Email Address" value="@if($init==0){{old('partner_email')}}@else{{old('partner_email',$partners_update->partner_email)}}@endif">
                  </div>
                </div>
                <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Website:</label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('website')) style="border-color:red;" @endif name="website" id="website" type="text" class="form-control input-height" placeholder="Enter Website Link" value="@if($init==0){{old('website')}}@else{{old('website',$partners_update->website)}}@endif">
                  </div>
                </div>

</div>
 <div class="col-sm-6">
   <br>
    <h6 class="box-title" style="color: black; text-align: center;">FOCAL PERSON INFORMATION</h6>
      <div class="row">
                  <label class="col-sm-3 form-control-label headingsetting">Focal Person Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('focal_person_name')) style="border-color:red;" @endif name="focal_person_name" id="focal_person_name" type="text" class="form-control input-height" placeholder="Enter Full Name" value="@if($init==0){{old('focal_person_name')}}@else{{old('focal_person_name',$partners_update->focal_person_name)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Mobile (a): <span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('focal_mob_a')) style="border-color:red;" @endif name="focal_mob_a" id="focal_mob_a" type="number" class="form-control input-height" placeholder="Enter First Contact Number" value="@if($init==0){{old('focal_mob_a')}}@else{{old('focal_mob_a',$partners_update->focal_mob_a)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Mobile (b): </label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('focal_mob_b')) style="border-color:red;" @endif name="focal_mob_b" id="focal_mob_b" type="number" class="form-control input-height" placeholder="Enter Second Contact Number" value="@if($init==0){{old('focal_mob_b')}}@else{{old('focal_mob_b',$partners_update->focal_mob_b)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Telephone: </label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('focal_tel_a')) style="border-color:red;" @endif name="focal_tel_a" id="focal_tel_a" type="number" class="form-control input-height" placeholder="Enter Telephone Number" value="@if($init==0){{old('focal_tel_a')}}@else{{old('focal_tel_a',$partners_update->focal_tel_a)}}@endif">
                  </div>
                </div>
                 <div class="row mg-t-10">
                  <label class="col-sm-3 form-control-label headingsetting">Email:<span class="tx-danger">*</span></label>
                  <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('focal_email')) style="border-color:red;" @endif name="focal_email" id="focal_email" type="text" class="form-control input-height" placeholder="Enter Email Address" value="@if($init==0){{old('focal_email')}}@else{{old('focal_email',$partners_update->focal_email)}}@endif">
                  </div>
                </div>

               
                     <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label headingsetting">
                    Agreement / Documents:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                             @if($init==0)
                             <img id="picchose" style="width: 200px; height: 100px; " src="{{ url('assets/images/nouser.png') }}">

                             @else

                                    @foreach($partners_update->partnerDocs->pluck('url') as $image)
 <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="140" width="110" >
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
                            <input type="hidden" name="existimg" value="{{old('documents',$partners_update->documents)}}">
                            @endif

                        </div>
                    </div>

        <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label headingsetting">
                        Agreement Date:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('agreement_date')) style="border-color:red;" @endif id="agreement_date" class="form-control input-height" placeholder="dd/mm/yyyy" autocomplete="off" type="text" name="agreement_date" value="@if($init==0){{old('agreement_date')}}@else{{old('agreement_date',formatDateToShow($partners_update->agreement_date))}}@endif">

                        </div>
                    </div>
                 <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label headingsetting">
                   Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" id="status" value="@if($init==0){{old('status')}}@else{{old('status',$partners_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$partners_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$partners_update->status)=='0') selected @endif value="0">
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
                     <div class="row mg-t-10">
                     <label class="col-sm-3 form-control-label" style="color: black;">
                            Comment Box:
                        </label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
<textarea  @if ($errors->has('remarks')) style="border-color:red;" @endif class="form-control" placeholder="Enter Remarks" rows="2" name="remarks" id="remarks">@if($init==0){{old('remarks')}}@else{{old('remarks',$partners_update->remarks)}}@endif</textarea>
                        </div>

                </div>
</div>
</div>
               
                
<br>


 <div class="desktop-screen-design">

 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('club-hospitality/partners') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('club-hospitality/partners') }}" class="btn btn-secondary">Cancel</a>
                 
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

<script type="text/javascript">
$('#partner_mob_a').mask('00000000000');
$('#partner_mob_b').mask('00000000000');
$('#partner_tel_a').mask('00000000000');

$('#focal_mob_a').mask('00000000000');
$('#focal_mob_b').mask('00000000000');
$('#focal_tel_a').mask('00000000000');
</script>


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

<script>
    $( function() {
    $( "#agreement_date" ).datepicker({
       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
</script>

@endpush