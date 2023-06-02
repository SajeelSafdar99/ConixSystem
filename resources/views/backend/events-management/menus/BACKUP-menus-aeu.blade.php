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

 .headingsettings {
            color: black!important;
            text-align: center!important;
            font-size: 15px !important;

        }
        </style>
<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Menus</h6>
         <div style="text-align: right;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 @if($init==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/menus') }}">Menus List</a></li>
  <li><a href>Edit Menus</a></li>
</ul>
     @else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('events-management') }}">Events Management</a></li>
  <li><a href="{{ url('events-management/menus') }}">Menus List</a></li>
  <li><a href>Add Menus</a></li>
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
    <form method="post" action="{{ url('events-management/menus/update') }}/{{ $menus_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
               
                <div class="row">
                  <label class="col-sm-2 form-control-label headingsettings">Menu Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
              <input @if ($errors->has('menu_name')) style="border-color:red;" @endif type="text" id="menu_name" name="menu_name" class="form-control input-height" placeholder="Enter Name" value="@if($init==0){{old('menu_name')}}@else{{old('menu_name',$menus_update->menu_name)}}@endif">
                  </div>
                </div>


                                     <div class="row mg-t-10">
                                                    <label class="col-sm-2 form-control-label headingsettings">
                                                    Menu Type:
                                                        <span class="tx-danger"> *  </span>
                                                    </label>

                                                    <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                                                        <select @if ($errors->has('menu_type')) style="border-color:red;"
                                                                @endif id="menu_type" class="form-control input-height select2"
                                                                name="menu_type">
                                                            <option label="Select Menu Type">
                                                            </option>
                                                            @foreach($menutypes as $menutype)
                                                                @if($init==1)
                                                                    <option
                                                                        @if(old('menu_type',$menus_update->menu_type)==$menutype->id)  selected
                                                                        @endif  value="{{ $menutype->id }}">
                                                                        {{ $menutype->desc }}
                                                                    </option>
                                                                @else
                                                                    <option
                                                                        @if(old('menu_type')==$menutype->id)  selected
                                                                        @endif value="{{ $menutype->id }}">
                                                                        {{ $menutype->desc }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                 <br><br>
               <h6 class="box-title headingsettings"><b>MENU ITEMS</b></h6>

                <br>

        <table id="menutable" align="center" border="0" width="100%">
              <tbody>
           <tr>
            <td width="15%" align="left">&nbsp</td>
                                                        <td width="50%" align="left">Item Name<span class="tx-danger">*</span></td>
                                                        <td width="30%" align="left">Charges<span class="tx-danger">*</span></td>
                                                       
                                                    </tr>
                                                    <tbody>
                 <tbody id="addmoreid">

                 @if($init==1)
                  @foreach($eventsubdata as $sub)
                          <tr>

                             <td>
                        <i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect2(this.id);"></i>
                            </td>

                            <td>
                              <select id="{{ $sub->id }}" class="form-control input-height select2" name="item_name[]">
                                <option label="Select Menu Category"></option>
                                                                        @foreach($menu_category as $menucategory)

                                                                            @if($init==1)
                                                                                <option
                                                                                    @if(old('item_name[]',$sub->item_name)==$menucategory->id)  selected
                                                                                    @endif value="{{ $menucategory->id }}">
                                                                                    {{ $menucategory->desc }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    @if(old('item_name[]')==$menucategory->id)  selected
                                                                                    @endif value="{{ $menucategory->id }}">
                                                                                    {{ $menucategory->desc }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                   </td>
                                              <td>
                             <input id="item_charges{{ $sub->id }}" onkeyup="extrachargesselect2(this.id)"
                                                                           class="form-control input-height event_item"
                                                                           type="number" name="item_charges[]"
                                                                           value="@if($init==0){{old('item_charges[]')}}@else{{old('item_charges[]',$sub->item_charges)}}@endif">
                                                                </td>
                                                      
                                                            </tr>
                                                        @endforeach

                                                    @else


                                                        <tr>
                                                           <td>&nbsp</td>
                                      <td>
                                        <select id="1" class="form-control input-height select2" name="item_name[]">
                                                                    <option label="Select Menu Category"></option>
                                                                    @foreach($menu_category as $menucategory)


                                                                <option
                                                               @if(old('item_name[]')==$menucategory->id)  selected
                                                                            @endif value="{{ $menucategory->id }}">
                                                                            {{ $menucategory->desc }}
                                                                        </option>

                                                                    @endforeach
                                                                </select>
                                                            </td>
                                       <td>
                                     <input id="item_charges1" onkeyup="extrachargesselect2(this.id)"
                                                                       class="form-control input-height event_item" type="number" name="item_charges[]"
                                                                       value="@if($init==0){{old('item_charges[]')}}@else{{old('item_charges[]',$sub->item_charges)}}@endif">
                                                            </td>
                                                            
                                                        </tr>


                                                    @endif


                                                    </tbody>
                                                </table>


                                                <div class="row mg-t-10">

                                     
                                                    <div class="col-sm-5 mg-t-10 mg-sm-t-0">
                                             &nbsp&nbsp&nbsp <input onclick="addmorefields()" type="button" value="Add More"
                                                               class="btn btn-info">

                                                    </div><!-- form-layout-footer -->
                                                </div>
                                                <br/> <br/>
<div class="row mg-t-10">
                  <label class="col-sm-2 form-control-label headingsettings">Total: <span class="tx-danger">*</span></label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
              <input @if ($errors->has('total')) style="border-color:red;" @endif type="number" id="total" name="total" class="form-control input-height" readonly style="background-color: #c1c1c1" placeholder="Enter Total of Menu Items" value="@if($init==0){{old('total')}}@else{{old('total',$menus_update->total)}}@endif">
                  </div>
                </div>
 <div class="row mg-t-10">
                        <label class="col-sm-2 form-control-label headingsettings">
                       Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control input-height" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$menus_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$menus_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$menus_update->status)=='0') selected @endif value="0">
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

                
               
<br/><br/><br/>
  

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

@push('jscode')

<script type="text/javascript">
    function extrachargesselect2(id) {

      if(!id){
        id=1;
      }
            total = 0;
            $('.event_item').each(function (index, element) {
                total += parseFloat($(element).val());
            });

            document.getElementById('total').value = total;
        }

        </script>

<script type="text/javascript">
        var i = 2;

        function addmorefields() {
            var html = '';

            html = `<tr>

            <td><i class="fa fa-trash" onclick="$(this).parents('tr').remove(); extrachargesselect2(${i});"></i></td>
            <td>
             <select id="${i}" class="form-control input-height select2" name="item_name[]" >
                    <option label="Select Menu Category"></option>
                     @foreach($menu_category as $menucategory)
            <option value="{{ $menucategory->id }}">
                                    {{ $menucategory->desc }}
            </option>
@endforeach
            </select>
                  </td>
                  <td>
                      <input id="item_charges${i}" onkeyup="extrachargesselect2(${i})" class="form-control input-height event_item" type="number" name="item_charges[]">
                  </td>
                     </tr>`;
            i++;
            $('#addmoreid').append(html);
            extrachargesselect2(i);
        }

    </script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    @endpush