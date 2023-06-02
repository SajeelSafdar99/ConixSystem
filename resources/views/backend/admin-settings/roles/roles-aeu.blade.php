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

.aligningcheckboxes{
  text-align: left !important;
}

.checkboxspecial{
  width: 20%;
}

p{ color: black !important; }
</style>
 
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Roles</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
    <li><a href="{{ url('user-rights') }}">User Rights</a></li>
    <li><a href="{{ url('user-rights/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('admin-settings/roles') }}">Roles List</a></li>
  <li><a href>Edit Role</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('user-rights') }}">User Rights</a></li>
  <li><a href="{{ url('user-rights/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('admin-settings/roles') }}">Roles List</a></li>
  <li><a href>Add Role</a></li>
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
   <!--  <form method="post" action="{{ url('admin-settings/roles/update') }}/{{ $roles_update->id }}"> -->
    {{ Form::model($roles_update, array('route' => array('roles.update', $roles_update->id), 'method' => 'PUT')) }}
     @else
    <form method="post">
    @endif     
    @csrf   


            
              <div class="form-layout form-layout-4 ">
                 <div class="desktop-screen-design-mem">

                <div class="row">
                  <label class="col-sm-4 form-control-label">Role: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input @if ($errors->has('name')) style="border-color:red;" @endif name="name" type="text" class="form-control input-height" placeholder="Enter Role" value="@if($init==0){{old('name')}}@else{{old('name',$roles_update->name)}}@endif">
                  </div>
                </div>
</div>
<div class="row mg-t-10">
<label class="col-sm-4 form-control-label">Permissions: <span class="tx-danger">*</span></label>
</div>


<br><br>
  <div class="accordion" id="accordionExample">


@foreach($categories as $category)
  <div class="card">
    <div class="card-header" id="heading{{$category->id}}">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$category->id}}" aria-expanded="false" aria-controls="collapse{{$category->id}}">
        <strong class="text-uppercase"> {{$category->desc}} </strong>
        </button>
      </h2>
    </div>
    <div id="collapse{{$category->id}}" class="collapse" aria-labelledby="heading{{$category->id}}" data-parent="#accordionExample">
      <div class="card-body">
       <div class=" form-group aligningcheckboxes">
                 <div class="row">  
                  @foreach($permissions as $permission)
                  @if($permission->category==$category->id)
                  @if($init==0)
                 
                 <div class="checkboxspecial">  


                  <input name="permissions[]" type="checkbox" value="{{ $permission->id}}" id="{{$permission->name}}" >
                  <label for="{{$permission->name}}">{{$permission->name}}</label>
              
               </div>
                  @else

                   <div class="checkboxspecial">
                  {{ Form::checkbox('permissions[]', $permission->id, $roles_update->permissions, ['id'=> $permission->name]) }}
                  {{ Form::label($permission->name, ucfirst($permission->name)) }}
                </div>

                  @endif
                  @endif
                  
                  @endforeach
                   </div>
                         
                        </div>
      </div>
    </div>
  </div>
@endforeach

</div>

<br>
<br>

<div class="desktop-screen-design">
 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('admin-settings/roles') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('admin-settings/roles') }}" class="btn btn-secondary">Cancel</a>
                 
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
