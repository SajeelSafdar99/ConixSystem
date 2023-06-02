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
    #DataTables_Table_0_filter{
        display: none!important;
    }



.select2-selection {
  height: 34px !important; 
  font-size: 13px;
  font-family: 'Open Sans', sans-serif;
  border-radius: 0 !important;
  border: solid 1px #c4c4c4 !important;
  padding-left: 4px;
}

.select2-selection--multiple {
  height: 53px !important;

}

.select2-selection__choice {
  height: 40px;
  line-height: 40px !important;
  padding-right: 16px !important;
  padding-left: 16px !important;
  background-color: #CAF1FF !important;
  color: #333 !important;
  border: none !important;
  border-radius: 3px !important;
}


.select2-container--default .select2-selection--multiple .select2-selection__choice__remove 
 {
  float: right !important;
 
  font-size: 20px !important;
  color: black !important;
  position: relative !important;
  top: 0px !important;
}
.select2-search--inline .select2-search__field {
  line-height: 40px;
  color: #333;
  width: 100%!important;
}

.select2-container:hover,
.select2-container:focus,
.select2-container:active,
.select2-selection:hover,
.select2-selection:focus,
.select2-selection:active {
  outline-color: transparent;
  outline-style: none;
}

.select2-results__options li {
  display: block; 
}

.select2-selection__rendered {
  transform: translateY(2px);
}

.select2-selection__arrow {
  display: none;
}

.select2-results__option--highlighted {
  background-color: #CAF1FF !important;
  color: #333 !important;
}

.select2-dropdown {
  border-radius: 0 !important;
  box-shadow: 0px 3px 6px 0 rgba(0,0,0,0.15) !important;
  border: none !important;
  margin-top: 4px !important;
  width: 366px !important;
}

.select2-results__option {
  font-family: 'Open Sans', sans-serif;
  font-size: 13px;
  line-height: 24px !important;
  vertical-align: middle !important;
  padding-left: 8px !important;
}

.select2-results__option[aria-selected="true"] {
  background-color: #eee !important; 
}

.select2-search__field {
  font-family: 'Open Sans', sans-serif;
  color: #333;
  font-size: 13px;
  padding-left: 8px !important;
  border-color: #c4c4c4 !important;
}

.select2-selection__placeholder {
  color: #c4c4c4 !important; 
}
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Membership</h6>
          <div style="text-align: right;">
             @can('Add Membership')
          <a href="{{ url('club-hospitality/membership/membership-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Membership" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Memberships')
          <a href="{{ url('club-hospitality/membership/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href>Memberships List</a></li>
</ul>
 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

            <form method="get">
              <div class="row">
                <div class="col-md-4">
@if($cati!=[])

                        <div class="form-group">
                            <label>Category:</label>
                           
                            <select class="form-control js-example-basic-multiple" name="searchcat[]" id="searchcat" multiple="multiple">
                                 @foreach($cat as $c)
                                <option value="{{$c->id}}" @if(in_array($c->id,$cati)) selected="selected" @endif> {{ $c->desc }} - {{$c->unique_code}}</option>
                                 
                                 @endforeach
                            </select>
           
                        </div>
                   
 @elseif($cati==[])
            
                        <div class="form-group">
                            <label>Category:</label>
                           
                            <select class="form-control js-example-basic-multiple" name="searchcat[]" id="searchcat" multiple="multiple">
                                 @foreach($cat as $c)
                                <option value="{{$c->id}}"> {{ $c->desc }} - {{$c->unique_code}}</option>
                                 @endforeach
                            </select>
           
                        </div>
                    
  @endif
</div>
 
 <div class="col-md-4">
@if($stati!=[])

                        <div class="form-group">
                            <label>Status:</label>
                           
                            <select class="form-control js-example-basic-multiple" name="searchstatus[]" id="searchstatus" multiple="multiple">
                                    @foreach($status as $statxs)
                                <option value="{{$statxs->id}}" @if(in_array($statxs->id,$stati)) selected="selected" @endif> {{ $statxs->desc }}</option>
                                 
                                 @endforeach
                            </select>
           
                        </div>
                   
 @elseif($stati==[])
                        <div class="form-group">
                            <label>Status:</label>
                           
                            <select class="form-control js-example-basic-multiple" name="searchstatus[]" id="searchstatus" multiple="multiple">
                                  @foreach($status as $statxs)
                                <option value="{{$statxs->id}}"> {{ $statxs->desc }}</option>
                                 @endforeach
                            </select>
           
                        </div>
                    
  @endif
</div>

 <div class="col-md-4">
@if($cardstati!=[])

                        <div class="form-group">
                            <label>Card Status:</label>
                           
                            <select class="form-control js-example-basic-multiple" name="searchcard[]" id="searchcard" multiple="multiple">
                                  <option  value="In-Process" @if(in_array('In-Process',$cardstati)) selected="selected" @endif>
                                   In-Process
                                </option>
                                <option  value="Printed" @if(in_array('Printed',$cardstati)) selected="selected" @endif>
                                   Printed
                                </option>
                                <option  value="Received" @if(in_array('Received',$cardstati)) selected="selected" @endif>
                                   Received
                                </option>
                                <option  value="Issued" @if(in_array('Issued',$cardstati)) selected="selected" @endif>
                                   Issued
                                </option>
                                <option  value="Re-Printed" @if(in_array('Re-Printed',$cardstati)) selected="selected" @endif>
                                   Re-Printed
                                </option>
                            </select>
           
                        </div>
                   
 @elseif($cardstati==[])
            
                        <div class="form-group">
                            <label>Card Status:</label>
                           
                            <select class="form-control js-example-basic-multiple" name="searchcard[]" id="searchcard" multiple="multiple">
                                 <option  value="In-Process">
                                   In-Process
                                </option>
                                <option  value="Printed">
                                   Printed
                                </option>
                                <option  value="Received">
                                   Received
                                </option>
                                <option  value="Issued">
                                   Issued
                                </option>
                                <option  value="Re-Printed">
                                   Re-Printed
                                </option>
                            </select>
           
                        </div>
                    
  @endif
</div>

</div>

            
            


                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input value="{{request('barcode')}}" type="text" class="form-control" id="barcode" name="barcode">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="searchid">Member ID</label>
                            <input value="{{request('searchid')}}" type="text" class="form-control" id="searchid" name="searchid">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="member_id">Name</label>
                            <input value="{{request('member_id')}}" type="text" class="form-control" id="member_id" name="member_id"   onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>
                            <input type="hidden" id="idc" name="id">

                        </div>
                    </div>
                   
                     <div class="col-sm">
                        <div class="form-group">
                            <label for="cnic">CNIC</label>
                            <input value="{{request('cnic')}}" type="text" class="form-control" id="cnic" name="cnic">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="contact">Contact (Primary)</label>
                            <input value="{{request('contact')}}" type="text" class="form-control" id="contact" name="contact">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="car_number">Car Number</label>
                            <input value="{{request('car_number')}}" type="text" class="form-control" id="car_number" name="car_number">
                        </div>
                    </div>    
                    
                    <div class="col-sm">
                        <div class="form-group">

                            <button type="button" onclick="search()"   value="1" class="mg-t-30 btn btn-success"><i class="fa fa-search"></i> Search</button>
                            @can('Export Membership Columns')
                            <button type="button" data-toggle="modal" data-target="#modal" class="mg-t-30 btn btn-primary"><i class="fa fa-file"></i> Export</button>
                            @endcan

                        </div>
                    </div>
                </div>
            </form>
            <div id="modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" action="{{route('member.export')}}">
                            {{csrf_field()}}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">SELECT COLUMNS TO EXPORT</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                   @php sort($columns) @endphp
                                    @foreach($columns as $col)
                                        <div class="col-sm-3"><label><input type="checkbox" name="columns[]" value="{{$col}}"> {{ucwords(str_replace('_',' ',$col))}}</label></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default""><i class="fa fa-download"></i> Export</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
          <div class="table-wrapper">
            <table class="table display nowrap datatable">

              <thead>
                <tr>
             <th class="wd-10p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-10p">Membership No.</th>
                  <th class="wd-25p">Member Name</th>
                  <th class="wd-10p">Name Comment</th>
                   <th class="wd-10p">Category</th>
                  <th class="wd-15p">CNIC</th>
                   <th class="wd-15p">Contact</th>
                  <th class="wd-15p">Membership Date</th>
                  <th class="wd-15p">Member Type</th>
                   <th class="wd-10p">Family Members</th>
                    <th class="wd-5p">Card Status</th>
                  <th class="wd-10p">Picture</th>
                  <th class="wd-10p">Status</th>
                  @can('View Member')
                  <th class="wd-5p">View</th>
                  @endcan
                   @can('Edit Membership')
                  <th class="wd-5p">Edit</th>
                  @endcan
                   @can('Delete Membership')
                  <th class="wd-5p">Delete</th>
                  @endcan
                </tr>
              </thead>

            </table>
          </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')

<script>
$(document).ready(function() {
  
  $(".js-example-basic-multiple").select2({
    placeholder: "Choose Option"
  }).on('change', function(e) {
    if($(this).val() && $(this).val().length) {
            $(this).next('.select2-container')
        .find('li.select2-search--inline input.select2-search__field').attr('placeholder', 'Choose Option');
    }
  });
});
</script>

<script type="text/javascript">
  $( document ).ready(function() {
    console.log( "ready!" );
});

</script>

<script type="text/javascript">

  var oTable = '';
  $.fn.DataTable.ext.pager.numbers_length = 100;
// $(document).ready(function() {

        var oTable =   $('.datatable').DataTable({
          seaching: false,
            "pageLength": 50,

          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
         /*  scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,*/

        columnDefs: [
            { width: '20%', targets: 0 }
        ],
        fixedColumns: true,
          order: [[ 0, 'desc' ]],
          "ajax": {
          'url': '{{ route('membership.datatable') }}',
          'type': 'POST',
              data:{
                  'barcode':function(){ return $('input[name="barcode"]').val()},
                 'searchid':function(){ return $('input[name="searchid"]').val()},
                  'member_id':function(){  if($('#member_id').val()==''){
                      $('#idc').val(0)
                  } return $('input[name="id"]').val()},

                  'cnic':function(){ return $('input[name="cnic"]').val()},
                  'contact':function(){ return $('input[name="contact"]').val()},
                  'car_number':function(){ return $('input[name="car_number"]').val()},
                  'status':function(){ return $('#status').val()},
                  'searchcat':function(){ return $('#searchcat').val()},
                  'searchstatus':function(){ return $('#searchstatus').val()},
                  'searchcard':function(){ return $('#searchcard').val()},
                  // 'search':function(){ return 1}
              },
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',

        }
        },
        columns: [
          // {
          //       // "className":      'details-control',
          //       "orderable":      false,
          //       "data":           null,
          //       "defaultContent": '',
          //       'searchable': false
          //   },
            // {data: 'id',name: 'id', orderable: false, searchable: false},

           // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            // {
            //     data: 'mem_no',
            //     type: 'num',
            //     render: {
            //         _: 'display',
            //         sort: 'id'
            //     }
            // },
             { data: 'DT_RowIndex', name: 'DT_RowIndex',width:30},
            {data: 'id', name: 'id', searchable: true},
            {data: 'mem_no', name: 'mem_no', searchable: true},
            {data: 'name', name: 'name', searchable: true},
             {data: 'name_comment', name: 'name_comment', searchable: false},
             {data: 'category', name: 'category', searchable: true},
            {data: 'cnic', name: 'cnic', searchable: true},
            {data: 'mob_a', name: 'mob_a', searchable: true},
             {data: 'membership_date', name: 'membership_date', searchable: true},
  {data: 'mem_classification_id', name: 'mem_classification_id', searchable: true},
            {data: 'family_count', name: 'family_count', searchable: false,orderable: true,render: function (dataField) { return '<a href="{{url('club-hospitality/membership/familymember-aeu')}}/' + dataField.id + '">'+dataField.name+'</a>'}},
             {data: 'card_status', name: 'card_status', searchable: true},
  {data: 'mem_picture', name: 'mem_picture', searchable: false,orderable: false},
            {data: 'active', name: 'active',render: function (dataField) { if(dataField.datamy=="Active" || dataField.datamy=="active" || dataField.datamy=="ACTIVE")  { return '<button class="btnwidth btn btn-outline-success active btn-block mg-b-10" title="Status">'+dataField.datamy+'</button>'}
            else{
              return '<button class="btnwidth btn btn-outline-danger active btn-block mg-b-10" title="Status">'+dataField.datamy+'</button>'
            } }},
            @can('View Member')
            {data: 'viewbutton', name: 'viewbutton'},
            @endcan
             @can('Edit Membership')
            {data: 'editbutton', name: 'editbutton'},
            @endcan
             @can('Delete Membership')
            {data: 'deletebutton', name: 'deletebutton'},
           @endcan
        ]
    });
  function search() {
      oTable.ajax.reload();
  }
  function customerdatavalue(val) {
      let v =0;
      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdata') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "customerid": val,
              'MOC': v
          },
          success: function (data) {


              var obj = JSON.parse(data);
              if (v == 1) {

              } else {
                  document.getElementById('idc').value = obj.id;
                  
                  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                  document.getElementById('member_id').value =  $fname+$mname+$lname;
              }
              jQuery('#areabox').html('');
          }
                  })



              }

  function customerdata(val) {
      let v = 0;
      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdatalike') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "customerid": val,
              'MOC': v
          },
          success: function (data) {

              jQuery('#areabox').html('');
              jQuery.each(JSON.parse(data), function (i, val1) {

                $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                  let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                  let code = v == 1 ? val1.customer_no : val1.mem_no;

  let status = val1.mem_status.desc;
                  
                  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code} (${status})<li>`);


              });
$('#areabox').show();
              // $('#areabox').html(data);

          }
      });
  }
</script>


<script type="text/javascript">
$('#cnic').mask('00000-0000000-0');

</script>
@endpush
