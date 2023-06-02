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
.w3-black, .w3-hover-black:hover{
    color: #fff!important;
    background-color: white;
}

.w3-button:hover{
    color: #000!important;
    background-color: #ccc!important;
}

.w3-red{
    color: #fff!important;
    background-color: #56bff9!important;
}
.w3-red:hover {
    color: #fff!important;
    background-color: #17a2b8!important;
}

.w3-bar {
    width: 100%;
    height: 60px;
    overflow: hidden;
}
.w3-border {
    border: 1px solid #ccc!important;
}

.w3-bar .w3-bar-item {
    padding: 8px 16px;
    float: left;
   
    border: none;
   display: inline-block;
border-radius: 5px;
margin: 0;

margin-right: 8px;
    outline: 0;
    height: 45px;
}
.w3-bar .w3-button {
    white-space: normal;
}
.theactiveclass{
background-color: #17a2b8!important;
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

.profession{
  color: black !important;
  font-size: 16px !important;
}

</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Employment</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

 @if($init==1)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
  <li><a href>Employment Documents</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
  <li><a href>Employment Documents</a></li>
</ul>
@endif

<div class="w3-bar w3-black">
<a href="{{ url('human-resource/employment/employment-aeu') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button  w3-red">Employee</button>
</a>

  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('human-resource/employment/education-aeu/') }}/{{Request::segment(4)}}' ">Education</button>


  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('human-resource/employment/job-aeu/') }}/{{Request::segment(4)}}' ">Jobs</button>


  <button class="w3-bar-item w3-button  w3-red" onclick="location.href='{{ url('human-resource/employment/reference-aeu/') }}/{{Request::segment(4)}}' ">References</button>

@can('View Employment Documents')
<a href="{{ url('human-resource/employment/employment-docs-aeu') }}/{{Request::segment(4)}}">
  <button class="w3-bar-item w3-button  w3-red theactiveclass">Employment Documents</button>
</a>
@endcan
</div>

 
 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
 
             
    <form method="post" enctype="multipart/form-data">
      
    @csrf   
                <div class="col-xl-12 ">
 <div class="row mg-t-10">
     
                  <label class="col-sm-1 form-control-label profession"><u>Employee Name:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$employmentdata->name}}</b>
                  </div>
                </div><!-- row -->
         
             
            <div class="row mg-t-10">
      
                  <label class="col-sm-1 form-control-label profession"><u>Barcode #:</u> </label>
                  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                   <b class="profession">{{$employmentdata->barcode}}</b>
                  </div>
                </div><!-- row -->

               
          @can('Add Employment Documents')
            <div class="form-layout form-layout-4 ">
                   <div class="row mg-t-10">
                        <label class="col-sm-6 form-control-label"  style="color: black !important;">
                          Documents:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                        
                             <img id="picchose" style="width: 200px; height: 100px; margin-left: -135px;" src="{{ url('assets/images/nouser.png') }}">
                            <input @if ($errors->has('documents')) style="border-color:red;" @endif type="file" multiple="multiple" name="documents[]" value="@if($init==0){{old('documents')}}@endif">
                            

                        </div>
                    </div>
                       <div class="row">
            <div class="col-md-5"></div> 
            <div class="col-md-7">
            <div class="form-layout-footer mg-t-30">
               &nbsp&nbsp&nbsp&nbsp
             
               <input type="submit" name="save" class="btn btn-info" value="Save">
             
        &nbsp&nbsp
    <a href="{{ url('human-resource/employment-vue') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </div>
    </div>
     </div>
     @endcan
<br><br><br>
                    @foreach($images as $image)
                    <a href="{{url($image)}}" target="_blank">
                    <img src="{{ url($image) }}" height="250" width="300" >
                    </a>
                    &nbsp&nbsp&nbsp 
                  
                
                  @endforeach


           
           


                   <br>
       
          
           
            
    </form>
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