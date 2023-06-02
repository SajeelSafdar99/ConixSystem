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
  color: black;
}

</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Section Department Mapping</h6>
         <div style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('store-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('store-management/section-department-mapping') }}">Section Department Mapping List</a></li>
  <li><a href>Section Department Mapping</a></li>
</ul>



           <div class="col-xl-12 ">
@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    @if($init==1)
          <form method="post" action="{{ url('store-management/section-department-mapping/update') }}/{{ $section_update->id }}">
                 @else
                 <form method="post">
                   @endif     
            @csrf
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                   <div class="row">
                <label class="col-sm-4 form-control-label">Section: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('desc')) style="border-color:red;" @endif type="text" name="desc" class="form-control input-height" placeholder="Enter Name of Section"  readonly value="@if($init==0){{old('desc')}}@else{{old('desc',$section_update->desc)}}@endif">
                  </div>
                </div>

                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                   Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0 aligningcheckboxes">
                                       @foreach($departments as $dep)
              
                @if($dep->section == $section_update->id)
                   <div class="checkboxspecial">
                  {{ Form::checkbox('departments[]', $dep->id, $dep->section, ['id'=> $dep->desc]) }}
                  {{ Form::label($dep->desc, ucfirst($dep->desc)) }}
                </div>
@else

  <div class="checkboxspecial">
                  {{ Form::checkbox('departments[]', $dep->id, 0 ,['id'=> $dep->desc]) }}
                  {{ Form::label($dep->desc, ucfirst($dep->desc)) }}
                </div>
                @endif

                  @endforeach
                        </div>
                    </div>
               

               <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Link</button>
                  &nbsp&nbsp
                  <a href="{{ url('store-management/section-department-mapping') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>
  
              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </form>
            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection

@push('jscode')

@endpush