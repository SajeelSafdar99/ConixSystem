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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Sub-Departments</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('human-resource/sub-departments') }}">Sub-Departments List</a></li>
  <li><a href>Edit Sub-Department</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
  <li><a href="{{ url('human-resource/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('human-resource/sub-departments') }}">Sub-Departments List</a></li>
  <li><a href>Add Sub-Department</a></li>
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
    <form method="post" action="{{ url('human-resource/sub-departments/update') }}/{{ $sub_departments_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                    <div class="row">
                  <label class="col-sm-4 form-control-label">Company: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                     <select @if ($errors->has('company')) style="border-color:red;" @endif  id="company" name="company" class="form-control" onchange="levelonedependency(this.id)">
                                <option label="Choose Option">
                                </option>
                               
                                @foreach($companies as $company)
                                @if($init==1)
                                <option @if(old('company',$selected_one[0])==$company->code) selected @endif value="{{$company->code}}">
                                    {{$company->name}}
                                </option>
                                @else
                                <option @if(old('company')==$company->code)  selected @endif value="{{ $company->code }}">
                                    {{$company->name}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  

             <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Department: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select id="department" name="department" class="form-control">
                                <option label="Choose Option">
                                </option>
                                @foreach($deps as $dep)
                                @if($init==1)
                                <option @if(old('department',$sub_departments_update->department)==$dep->id) selected @endif value="{{$dep->id}}">
                                    {{$dep->desc}}
                                </option>
                                @else
                                <option @if(old('department')==$dep->id)  selected @endif value="{{ $dep->id }}">
                                    {{$dep->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  

                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Sub-Department: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="desc" type="text" class="form-control input-height" placeholder="Enter Name of Sub-Department" value="@if($init==0){{old('desc')}}@else{{old('desc', $sub_departments_update->desc)}}@endif">
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
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$sub_departments_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$sub_departments_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$sub_departments_update->status)=='0') selected @endif value="0">
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
                  <a href="{{ url('human-resource/sub-departments') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('human-resource/sub-departments') }}" class="btn btn-secondary">Cancel</a>
                 
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
  // When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("myHeader");

// Get the offset position of the navbar
var sticky = header.offsetTop-70;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {

  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>

<script type="text/javascript">
  function levelonedependency(idd){
  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('human-resource/company/department/') }}/'+idval,
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

@endpush