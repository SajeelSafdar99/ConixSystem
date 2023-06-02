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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Item Definitions</h6>
             <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a> / <a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">FnB Definitions</a> / <a href="{{ url('store-management/definitions') }}">Store Definitions</a></li>
   <li><a href="{{ url('food-and-beverage/item-definitions-vue') }}">Item Definitions List</a></li>
   <li><a href>Deleted Item Definitions</a></li>
</ul>        
      @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
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
                  @can('Restore Item Definition')
                  <th class="wd-5p">Restore</th>
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
          order: [[ 1, 'asc' ]],
          "ajax": {
          'url': '{{ route('items_deleted.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
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
            @can('Restore Item Definition')
            {data: 'restorebutton', name: 'restorebutton', orderable: false},  
            @endcan        
        ]
    });

</script>
@endpush