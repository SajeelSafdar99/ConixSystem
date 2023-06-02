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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Table Definition Mapping</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('room-management/room-table-mapping-vue') }}">Room Table Definition Mapping List</a></li>
  <li><a href>Room Table Definition Mapping</a></li>
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
          <form method="post" action="{{ url('room-management/room-table-mapping/update') }}/{{ $room_update->id }}">
                 @else
                 <form method="post">
                   @endif     
            @csrf
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">

                   <div class="row">
                <label class="col-sm-4 form-control-label">Room No.: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input @if ($errors->has('room_no')) style="border-color:red;" @endif type="text" name="room_no" class="form-control input-height" placeholder="Enter Room Number"  readonly value="@if($init==0){{old('room_no')}}@else{{old('room_no',$room_update->room_no)}}@endif">
                  </div>
                </div>

                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                   Restaurant Location: 
                        
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
 <select name="restaurant" id="restaurant" class="form-control" onchange="dependency(this.id)">
                                <option label="Choose Option">
                                </option>
                                @foreach($restaurants as $rest)
                                @if($selected_rest)
                                <option @if(old('restaurant',$selected_rest)==$rest->id) selected @endif value="{{$rest->id}}">
                                    {{$rest->desc}}
                                </option>
                                @else
                               <option @if(old('restaurant',$room_update->restaurant)==$rest->id) selected @endif value="{{$rest->id}}">
                                    {{$rest->desc}}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                   Table Definition: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
 <select name="table_definition" id="table_definition" class="form-control">
                                <option label="Choose Option">
                                </option>
                                @foreach($table_defs as $table)
                                 @if($selected_rest)

                                 @if($selected_rest==$table->restaurant_location)
                                   <option @if(old('table_definition',$room_update->table_definition)==$table->id) selected @endif value="{{$table->id}}">
                                    {{$table->desc}}
                                </option>
                                @endif

                                 @else

                                <option @if(old('table_definition',$room_update->table_definition)==$table->id) selected @endif value="{{$table->id}}">
                                    {{$table->desc}}
                                </option>
                               
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
               

               <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Link</button>
                  &nbsp&nbsp
                  <a href="{{ url('room-management/room-table-mapping-vue') }}" class="btn btn-secondary">Cancel</a>
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

<script type="text/javascript">

  function dependency(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('food-and-beverage/sales/tables/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#table_definition').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#table_definition').append(s);
                })

  }
}
   });

  }

</script>





@endpush