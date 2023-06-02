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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Item Sub-Categories</h6>
              <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a> / <a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">FnB Definitions</a> / <a href="{{ url('store-management/definitions') }}">Store Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/item-sub-categories') }}">Item Sub-Categories List</a></li>
  <li><a href>Edit Item Sub-Category</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a> / <a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">FnB Definitions</a> / <a href="{{ url('store-management/definitions') }}">Store Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/item-sub-categories') }}">Item Sub-Categories List</a></li>
  <li><a href>Add Item Sub-Category</a></li>
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
          <form method="post" action="{{ url('food-and-beverage/item-sub-categories/update') }}/{{ $sub_category_update->id }}">
                 @else
                 <form method="post">
                   @endif
            @csrf
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                   <div class="row">
                  <label class="col-sm-4 form-control-label">Item Category: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="item_category" class="form-control">
                                <option label="Choose Option">
                                </option>
                                @foreach($mains as $main)
                                @if($init==1)
                                <option @if(old('item_category',$sub_category_update->item_category)==$main->id) selected @endif value="{{$main->id}}">
                                    {{$main->desc}}
                                </option>
                                @else
                                <option @if(old('item_category')==$main->id)  selected @endif value="{{ $main->id }}">
                                    {{$main->desc}}
                                </option>
                                @endif
                                @endforeach

                            </select>
                  </div>
                </div>

                <div class="row mg-t-10">
                <label class="col-sm-4 form-control-label">Sub Category: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('desc')) style="border-color:red;" @endif type="text" name="desc" class="form-control input-height" placeholder="Enter Sub-Category of Item" value="@if($init==0){{old('desc')}}@else{{old('desc',$sub_category_update->desc)}}@endif">
                  </div>
                </div>
                 <!--    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">Printer: </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                          <select @if ($errors->has('printer')) style="border-color:red;" @endif  id="printer" name="printer" class="form-control select2" ></select>

                        </div>
                    </div> -->

                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                   Status:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$sub_category_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$sub_category_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$sub_category_update->status)=='0') selected @endif value="0">
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
                  <a href="{{ url('food-and-beverage/item-sub-categories') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('food-and-beverage/item-sub-categories') }}" class="btn btn-secondary">Cancel</a>

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
<!-- 
   <script type="text/javascript">
$( document ).ready(function() {
                $.ajax({
                    type: 'get',

                    url: '//@php echo env('printer', 'localhost:5000') @endphp/',

					crossDomain:true,

                    success: function (data) {
                          var obj = JSON.parse(data);
        $('#printer').html('<option label="Choose Option">  </option>');
                        $.each(obj,function(x,y){

                          let s='<option value="'+y[2]+'">'+y[2]+'</option>';


                            $('#printer').append(s);
                        })
                    }
                });
           });

    </script> -->

@endpush
