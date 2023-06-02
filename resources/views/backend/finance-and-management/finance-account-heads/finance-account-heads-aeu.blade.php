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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Level Four</h6>
       <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/chart-of-accounts') }}">Chart of Accounts</a></li>
   <li><a href="{{ url('finance-and-management/chart-of-accounts/definitions') }}">Definitions</a></li>
   <li><a href="{{ url('finance-and-management/chart-of-accounts/definitions/levels-of-accounts') }}">Levels of Accounts</a></li>
  <li><a href="{{ url('finance-and-management/finance-account-heads') }}">Level Four List</a></li>
  <li><a href>Edit Level Four</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/chart-of-accounts') }}">Chart of Accounts</a></li>
   <li><a href="{{ url('finance-and-management/chart-of-accounts/definitions') }}">Definitions</a></li>
   <li><a href="{{ url('finance-and-management/chart-of-accounts/definitions/levels-of-accounts') }}">Levels of Accounts</a></li>
  <li><a href="{{ url('finance-and-management/finance-account-heads') }}">Level Four List</a></li>
  <li><a href>Add Level Four</a></li>
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
    <form method="post" action="{{ url('finance-and-management/finance-account-heads/update') }}/{{ $acc_head_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
              
              <div class="row">
                  <label class="col-sm-4 form-control-label">Level One: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                     <select @if ($errors->has('level_one')) style="border-color:red;" @endif  id="level_one" name="level_one" class="form-control" onchange="levelonedependency(this.id)">
                                <option label="Choose Option">
                                </option>
                               
                                @foreach($ones as $one)
                                @if($init==1)
                                <option @if(old('level_one',$selected_one[0])==$one->id) selected @endif value="{{$one->id}}">
                                    {{$one->desc}}
                                </option>
                                @else
                                <option @if(old('level_one')==$one->id)  selected @endif value="{{ $one->id }}">
                                    {{$one->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  

                 <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Level Two: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('level_two')) style="border-color:red;" @endif  id="level_two" name="level_two" class="form-control" onchange="leveltwodependency(this.id)">
                                <option label="Choose Option">
                                </option>
                               
                                @foreach($seconds as $second)
                                @if($init==1)
                                <option @if(old('level_two',$selected_two[0])==$second->id) selected @endif value="{{$second->id}}">
                                    {{$second->desc}}
                                </option>
                                @else
                                <option @if(old('level_two')==$second->id)  selected @endif value="{{ $second->id }}">
                                    {{$second->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  

                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Level Three: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('level_three')) style="border-color:red;" @endif  id="level_three" name="level_three" class="form-control">
                                <option label="Choose Option">
                                </option>
                               
                                @foreach($thirds as $third)
                                @if($init==1)
                                <option @if(old('level_three',$acc_head_update->level_three)==$third->id) selected @endif value="{{$third->id}}">
                                    {{$third->desc}}
                                </option>
                                @else
                                <option @if(old('level_three')==$third->id)  selected @endif value="{{ $third->id }}">
                                    {{$third->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  

                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Desc: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="desc" type="text" class="form-control input-height" placeholder="Enter Name of Level" value="@if($init==0){{old('desc')}}@else{{old('desc',$acc_head_update->desc)}}@endif">
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
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$acc_head_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$acc_head_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$acc_head_update->status)=='0') selected @endif value="0">
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
                  <a href="{{ url('finance-and-management/finance-account-heads') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('finance-and-management/finance-account-heads') }}" class="btn btn-secondary">Cancel</a>
                 
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

  function levelonedependency(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('finance-and-management/levelone/leveltwo/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#level_two').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#level_two').append(s);
                })

  }
}
   });

  }

</script>

<script type="text/javascript">
  function leveltwodependency(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('finance-and-management/leveltwo/levelthree/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#level_three').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#level_three').append(s);
                })

  }
}
   });

  }

</script>
@endpush