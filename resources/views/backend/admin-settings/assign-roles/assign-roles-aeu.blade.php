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
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Assign Roles</h6>
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
  <li><a href="{{ url('admin-settings/assign-roles') }}">Users List</a></li>
  <li><a href>Assign Roles</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('user-rights') }}">User Rights</a></li>
  <li><a href="{{ url('admin-settings/assign-roles') }}">Users List</a></li>
  <li><a href>Assign Roles</a></li>
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
      {{ Form::model($users_update, array('route' => array('assign_roles_update', $users_update->id), 'method' => 'post')) }}
     @else
    <form method="post" enctype="multipart/form-data">
    @endif
    @csrf

              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                <div class="row">
                  <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="name" type="text" class="form-control input-height" placeholder="Enter UserName" value="@if($init==0){{old('name')}}@else{{old('name',$users_update->name)}}@endif" readonly style="background-color: #c1c1c1">
                  </div>
                </div>

                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Email: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="email" type="text" class="form-control input-height" placeholder="Enter User Email" value="@if($init==0){{old('email')}}@else{{old('email',$users_update->email)}}@endif" readonly style="background-color: #c1c1c1"> 
                  </div>
                </div>

<div class="row mg-t-10">
                 <label class="col-sm-4 form-control-label">Roles: <span class="tx-danger">*</span></label>
                 <div class="col-sm-8 mg-t-10 mg-sm-t-0 form-group aligningcheckboxes">
                  @foreach($roles as $role)
                  @if($init==0)
                  {{ Form::checkbox('roles[]', $role->id, false, ['class' => 'onetime']) }}
                  {{ Form::label($role->name, ucfirst($role->name)) }}<br>

                  @else
                  {{ Form::checkbox('roles[]', $role->id, $users_update->roles, ['class' => 'onetime']) }}
                  {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                  @endif

                  @endforeach

                        </div>
                      </div>

 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Assign</button>
                  &nbsp&nbsp
                  <a href="{{ url('admin-settings/assign-roles') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('admin-settings/assign-roles') }}" class="btn btn-secondary">Cancel</a>

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
      $('.onetime').on('change', function() {
        $('.onetime').not(this).prop('checked', false);
    });
    </script>

@endpush
