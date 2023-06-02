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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Users</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25  border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
   <li><a href="{{ url('user-rights') }}">User Rights</a></li>
  <li><a href="{{ url('admin-settings/users') }}">Users List</a></li>
  <li><a href>Edit User</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25   border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('admin-settings') }}">Admin Settings</a></li>
  <li><a href="{{ url('user-rights') }}">User Rights</a></li>
  <li><a href="{{ url('admin-settings/users') }}">Users List</a></li>
  <li><a href>Add User</a></li>
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
      {{ Form::model($users_update, array('route' => array('users.update', $users_update->id), 'method' => 'PUT')) }}
     @else
    <form method="post" enctype="multipart/form-data">
    @endif
    @csrf

              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                <div class="row">
                  <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="name" type="text" class="form-control input-height" placeholder="Enter UserName" value="@if($init==0){{old('name')}}@else{{old('name',$users_update->name)}}@endif">
                  </div>
                </div>

                  <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Email: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="email" type="text" class="form-control input-height" placeholder="Enter User Email" value="@if($init==0){{old('email')}}@else{{old('email',$users_update->email)}}@endif">
                  </div>
                </div>

                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Password: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="password" type="password" class="form-control input-height" placeholder="Update Password" value="">
                      <span class="tx-info">empty if you dont want to update password</span>
                  </div>
                </div>


                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Confirm Password: </label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="password_confirmation" type="password" class="form-control input-height" placeholder="Update Password" value="">
                      <span class="tx-info">empty if you dont want to update password</span>
                  </div>
                </div>

<!-- <div class="row mg-t-10">
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
                      </div> -->

                          <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Category: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                   <select @if ($errors->has('category')) style="border-color:red;"
                                                                @endif id="category"
                                                                class="form-control select2"
                                                                name="category">
                    <option label="Choose Option"> </option>
                                        @foreach($categories as $cat)
                                                                @if($init==1)
                   <option  @if(old('category',$users_update->category)==$cat->id)  selected  @endif  value="{{ $cat->id }}">  {{ $cat->desc }}
                    </option>
                   @else
                   <option @if(old('category')==$cat->id) selected @endif value="{{ $cat->id }}">  {{ $cat->desc }}  </option>
                   @endif
                         @endforeach
                        </select>
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
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$users_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$users_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$users_update->status)=='0') selected @endif value="0">
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
                  <a href="{{ url('admin-settings/users') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('admin-settings/users') }}" class="btn btn-secondary">Cancel</a>

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
