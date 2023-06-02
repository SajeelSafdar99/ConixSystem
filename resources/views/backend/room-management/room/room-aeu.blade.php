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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Rooms</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 @if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('room-management/room') }}">Rooms List</a></li>
  <li><a href>Edit Rooms</a></li>
</ul>
     @else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href="{{ url('room-management/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('room-management/room') }}">Rooms List</a></li>
  <li><a href>Add Rooms</a></li>
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
    <form method="post" action="{{ url('room-management/room/update') }}/{{ $room_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
                <!-- <div class="row ">
                  <label></label>
                  <label class="col-sm-4 form-control-label">Sr #: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input type="text" name="room_code" value="{{ $increment_number }}" class="form-control input-height" readonly style="background-color: #c1c1c1">
                  </div>
                </div> -->
                <div class="row">
                  <label class="col-sm-4 form-control-label">Room No.: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
              <input type="text" name="room_no" class="form-control input-height" placeholder="Enter Room Number" value="@if($init==0){{old('room_no')}}@else{{old('room_no',$room_update->room_no)}}@endif">
                  </div>
                </div>
                
                <div class="row mg-t-10">
                  <label class="col-sm-4 form-control-label">Room Type: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="room_type" class="form-control">
                                <option label="Select Room Type">
                                </option>
                               
                                @foreach($room_type as $roomtype)
                                @if($init==1)
                                <option @if(old('room_type',$room_update->room_type)==$roomtype->id) selected @endif value="{{$roomtype->id}}">
                                    {{$roomtype->desc}}
                                </option>
                                @else
                                <option @if(old('room_type')==$roomtype->id)  selected @endif value="{{ $roomtype->id }}">
                                    {{$roomtype->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  
<br/><br/><br/>
                <table width="70%">
           
                    <th width="25%" style="color: black;"><u><b>CATEGORY</b></u></th>
                    <th width="25%" style="color: black;"><u><b>CHARGES</b></u></th>
               
                  <tbody>
                   @if($init==1)
                   @php $i=0 @endphp
                     @foreach($roomswithcat as $roomcat)
                      <tr>
                      
                      <td width="50%" style="text-align: left;">
                        {{$roomswithcat[$i]['roomtypes']->desc}}
                        <input type="hidden" name="room_category_id[]" id="room_category_id[]" value="{{ $roomcat->id }}">
                      </td>

                      <td width="50%" style="text-align: left;">
                        <input type="text" name="charges[]" id="charges[]" value="{{$roomcat->charges}}">
                      </td>

                      <td width="50%" style="text-align: left;">
                        <!--<input type="text" name="charges[]" id="charges[]">-->
                        <input type="hidden" name="category_charges_id[]" id="category_charges_id[]" value="{{ $roomcat->id }}">
                      </td>
                    </tr>
                   
                   @php $i++; @endphp
                    
                   @endforeach
                  @foreach($roomscateg as $roomcate)
                 
                    <tr>
                     
                      <td width="50%" style="text-align: left;">
                        {{$roomcate->desc}}
                        <input type="hidden" name="newroom_category_id[]" id="newroom_category_id[]" value="{{ $roomcate->id }}">
                      </td>
                        
                        <td width="50%" style="text-align: left;">
                        <input type="text" name="newcharges[]" id="newcharges[]">
                      </td>
                      
                    </tr>
                      @endforeach
                
                    @else
                  @foreach($room_category as $roomcategory)
                    <tr>
                      
                      <td width="50%" style="text-align: left;">
                        {{$roomcategory->desc}}
                        <input type="hidden" name="room_category_id[]" id="room_category_id[]" value="{{ $roomcategory->id }}">
                      </td>
                        
                        <td width="50%" style="text-align: left;">
                        <input type="text" name="charges[]" id="charges[]">
                      </td>
                      
                    </tr>
                      @endforeach
                        @endif     
                        @csrf 
                   
                  </tbody>
                
                </table>
<br/><br/><br/>

                <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                       Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$room_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$room_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$room_update->status)=='0') selected @endif value="0">
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
                  <a href="{{ url('room-management/room') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('room-management/room') }}" class="btn btn-secondary">Cancel</a>
                 
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