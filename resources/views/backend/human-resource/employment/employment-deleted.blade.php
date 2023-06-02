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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Employment</h6>
          <div style="text-align: right;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
  <ul class="breadcrumbee border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('human-resource') }}">Human Resource Management</a></li>
   <li><a href="{{ url('human-resource/employment-vue') }}">Employments List</a></li>
   <li><a href>Deleted Employments</a></li>
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
                  <th class="wd-5p">ID</th>
                  <th class="wd-15p">Name</th>
                  <th class="wd-15p">Father Name</th>
                  <th class="wd-10p">CNIC #</th>
                  <th class="wd-10p">Contact</th>
                  <th class="wd-10p">Email</th>
                  <th class="wd-15p">Address</th>
                  <th class="wd-10p">Designation</th>
                  <th class="wd-10p">Barcode #</th>
                  <th class="wd-15p">Picture</th>
                         <th class="wd-10p">Deleted At</th>
              <th class="wd-15p">Remarks</th>
                  @can('Restore Employment')
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
          order: [[ 0, 'desc' ]],
          "ajax": {
          'url': '{{ route('employment_deleted.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
         
            {data: 'id', name: 'id', searchable: true},
            {data: 'name', name: 'name', searchable: true},
            {data: 'father_name', name: 'father_name', searchable: true},
            {data: 'cnic', name: 'cnic', searchable: true},
            {data: 'mob_a', name: 'mob_a', searchable: true},
            {data: 'email', name: 'email', searchable: true},
            {data: 'cur_address', name: 'cur_address', searchable: true},
            {data: 'designation', name: 'designation', searchable: true},
            {data: 'barcode', name: 'barcode', searchable: true},
            {data: 'picture', name: 'picture', searchable: false},

                 { data: 'deleted_at', name: 'deleted_at', searchable: true},
               { data: 'remarks', name: 'remarks', searchable: false},

            @can('Restore Employment')
            {data: 'restorebutton', name: 'restorebutton'},  
            @endcan        
        ]
    });

</script>
@endpush