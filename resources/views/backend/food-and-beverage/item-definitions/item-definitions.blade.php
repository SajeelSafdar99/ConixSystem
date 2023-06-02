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

/* #DataTables_Table_0_filter{
        display: none!important;
    }*/
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Item Definitions</h6>
        <div class="hidden-print" style="text-align: right; margin-top: -39px;">
            <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
            @can('Add Item Definition')
          <a href="{{ url('food-and-beverage/item-definitions/item-definitions-aeu-vue') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Item Definition" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Item Definitions')
          <a href="{{ url('food-and-beverage/item-definitions/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a> / <a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">FnB Definitions</a> / <a href="{{ url('store-management/definitions') }}">Store Definitions</a></li>
  <li><a href>Item Definitions List</a></li>
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
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="item_code">Item Code</label>
                            <input value="{{request('item_code')}}" type="text" class="form-control" id="item_code" name="item_code">
                        </div>
                    </div>

                    <!--  <div class="col-sm">
                        <div class="form-group">
                            <label for="item_details">Item Name</label>
                            <input value="{{request('item_details')}}" type="text" class="form-control" id="item_details" name="item_details">
                        </div>
                    </div> -->
                      <div class="col-sm">
                        <div class="form-group">
                            <label for="item_details">Item Name</label>
                            <input value="{{request('item_details')}}" type="text" class="form-control" id="item_details" name="item_details"   onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;

    list-style-type: none;color: black;"></ul>
                            <input type="hidden" id="idc" name="id">

                        </div>
                    </div>

  <div class="col-sm">
                    <div class="form-group">
                        <label for="cat">Category</label>
                        <select class="form-control" onchange="subcatselect(this.id)" name="cat" id="cat">
<option  value="0" selected="selected">Choose Option</option>
                            @foreach($cats as $catx)

                                <option  value="{{ $catx->id }}">
                                    {{ $catx->desc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
</div>

  <div class="col-sm">
                    <div class="form-group">
                        <label for="subcat">Sub-Category</label>
                        <select class="form-control" name="subcat" onchange="itemselect(this.id)" id="subcat">
<option  value="0" selected="selected">Choose Option</option>
                            @foreach($subcats as $subcatx)

                                <option  value="{{ $subcatx->id }}">
                                    {{ $subcatx->desc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                   <div class="col-sm">
                    <div class="form-group">
                        <label for="item">Items</label>
                        <select class="form-control" name="item" id="item">
<option  value="0" selected="selected">Choose Option</option>
                            @foreach($items as $item)

                                <option  value="{{ $item->id }}">
                                  {{ $item->item_code }} {{ $item->item_details }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                   <div class="col-sm">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
              <option  value="0" selected="selected">Choose Option</option>
                                <option  value="Active">
                                    Active
                                </option>
                                 <option  value="In-Active">
                                    In-Active
                                </option>
                          
                        </select>
                    </div>
                  </div>

                  <div class="col-sm">
                        <div class="form-group">
                            <button type="button" onclick="search()"   value="1" class="mg-t-30 btn btn-success"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                  </div>
         </form>


          <div class="table-wrapper">
            <table class="table display nowrap datatable">
              <thead>
                <tr>
                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-10p">Category</th>
                  <th class="wd-10p">Sub-Category</th>
                  <th class="wd-10p">Manufacturer</th>
                  <th class="wd-5p">Item Code</th>
                  <th class="wd-15p">Item Name</th>
                   <th class="wd-5p">Stock</th>
                    <th class="wd-5p">Price</th>
                  <th class="wd-10p">Classification</th>
                  <th class="wd-10p">Status</th>
                  @can('Edit Item Definition')
                  <th class="wd-5p">Edit</th>
                  @endcan
                   @can('Delete Item Definition')
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
<script type="text/javascript">
  $( document ).ready(function() {
    console.log( "ready!" );
});
  
</script>

<script>
   function customerdatavalue(val) {
      $.ajax({
          type: 'POST',
          url: '{{ url('search/itemsearchdata') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "theid": val
          },
          success: function (data) {


              var obj = JSON.parse(data);
             
                  document.getElementById('idc').value = obj.id;
                  

                  document.getElementById('item_details').value = obj.item_details;
              
              jQuery('#areabox').html('');
          }
                  })



              }

  function customerdata(val) {
      $.ajax({
          type: 'POST',
          url: '{{ url('search/itemsearchdatalike') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "theid": val
          },
          success: function (data) {

              jQuery('#areabox').html('');
              jQuery.each(JSON.parse(data), function (i, val1) {

                  let name = val1.item_details;
                  let code = val1.item_code;
                  
                  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${code} - ${name}<li>`);


              });
$('#areabox').show();
              // $('#areabox').html(data);

          }
      });
  }
</script>

<script type="text/javascript">
   var oTable = '';
// $(document).ready(function() {
  
        var oTable =   $('.datatable').DataTable({
          seaching: true,
           "pageLength": 50,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
           columnDefs: [
            { width: '20%', targets: 0 }
        ],
        fixedColumns: true,
          order: [[ 0, 'desc' ]],
          "ajax": {
          'url': '{{ route('items.datatable') }}',
          'type': 'POST',
              data:{
                  'item_code':function(){ return $('input[name="item_code"]').val()},
                  //'item_details':function(){ return $('input[name="item_details"]').val()},
                  'cat':function(){ return $('#cat').val()},
                  'subcat':function(){ return $('#subcat').val()},
                   'item':function(){ return $('#item').val()},
                  'status':function(){ return $('#status').val()},
                  'item_details':function(){  if($('#item_details').val()==''){
                      $('#idc').val(0)
                  } return $('input[name="id"]').val()}

                },
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex',width:30},
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'category', name: 'category', searchable: true},
            {data: 'sub_category', name: 'sub_category', searchable: true},
            {data: 'manufacturer', name: 'manufacturer', searchable: true},
            {data: 'item_code', name: 'item_code', searchable: true},
            {data: 'item_details', name: 'item_details', searchable: true},
            {data: 'opening_stock', name: 'opening_stock', searchable: false},
             {data: 'sale_price', name: 'sale_price', searchable: false},
            {data: 'product_classification', name: 'product_classification', searchable: true},
             {data: 'status', name: 'status', orderable:false},
             @can('Edit Item Definition')
            {data: 'editbutton', name: 'editbutton', orderable: false}, 
             @endcan 
            @can('Delete Item Definition')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},  
             @endcan           
        ]
      });
  function search() {
      oTable.ajax.reload();
  }
</script>
<script type="text/javascript">

  function subcatselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('food-and-beverage/sales/subcategory/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#subcat').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#subcat').append(s);
                })

  }
}
   });

  }

</script>

<script type="text/javascript">

  function itemselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('food-and-beverage/sales/itemselect/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){

  if(data)
  {

console.log(data);
$('#item').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.item_code+' '+y.item_details+'</option>';
 $('#item').append(s);
                })

  }
}
   });

  }

</script>
@endpush