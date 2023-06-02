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
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Item Sub-Categories</h6>
              <div class="hidden-print" style="text-align: right; margin-top: -39px;">
            @can('Add Item Sub-Category')
          <a href="{{ url('food-and-beverage/item-sub-categories/item-sub-categories-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Item Sub-Category" height="28" width="28" border="0/">
          </a>
          @endcan
          @can('View Deleted Item Sub-Categories')
          <a href="{{ url('food-and-beverage/item-sub-categories/deleted') }}">
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
  <li><a href>Item Sub-Categories List</a></li>
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
                        <label for="cat">Category</label>
                        <select class="form-control" name="cat" id="cat">
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
                        <select class="form-control" name="subcat" id="subcat">
<option  value="0" selected="selected">Choose Option</option>
                            @foreach($subcats as $subcatx)

                                <option  value="{{ $subcatx->desc }}">
                                    {{ $subcatx->desc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  </div>

            <!--        <div class="col-sm">
                    <div class="form-group">
                        <label for="printer">Printer</label>
                        <select class="form-control" name="printer" id="printer">

                        </select>
                    </div>
                  </div> -->

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
                  <th class="wd-20p">Category</th>
                  <th class="wd-20p">Sub-Category</th>
             <!--      <th class="wd-15p">Printer</th> -->
                  <th class="wd-15p">Status</th>
                  @can('Edit Item Sub-Category')
                  <th class="wd-5p">Edit</th>
                  @endcan
                   @can('Delete Item Sub-Category')
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

    </script>

<script type="text/javascript">
  var oTable = '';
// $(document).ready(function() {
  
        var oTable =   $('.datatable').DataTable({
          seaching: false,
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
          'url': '{{ route('sub_categories.datatable') }}',
          'type': 'POST',
              data:{
                  'cat':function(){ return $('#cat').val()},
                  'subcat':function(){ return $('#subcat').val()},
                  'printer':function(){ return $('#printer').val()},
                  'status':function(){ return $('#status').val()},
                },
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'category', name: 'category', searchable: true},
            {data: 'desc', name: 'desc', searchable: true},
      /*      {data: 'printer', name: 'printer', searchable: true},*/
            {data: 'status', name: 'status', orderable: false},
             @can('Edit Item Sub-Category')
            {data: 'editbutton', name: 'editbutton', orderable: false}, 
             @endcan 
            @can('Delete Item Sub-Category')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},  
             @endcan           
        ]
    });
function search() {
      oTable.ajax.reload();
  }
</script>
@endpush