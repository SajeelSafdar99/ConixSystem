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
.w3-black, .w3-hover-black:hover{
    color: #fff!important;
    background-color: white;
}

.w3-button:hover{
    color: #000!important;
    background-color: #ccc!important;
}

.w3-red{
    color: #fff!important;
    background-color: #56bff9!important;
}
.w3-red:hover {
    color: #fff!important;
    background-color: #17a2b8!important;
}

.w3-bar {
    width: 100%;
    height: 60px;
    overflow: hidden;
}
.w3-border {
    border: 1px solid #ccc!important;
}

.w3-bar .w3-bar-item {
    padding: 8px 16px;
    float: left;

    border: none;
   display: inline-block;
border-radius: 5px;
margin: 0;

margin-right: 8px;
    outline: 0;
    height: 60px;
}
.w3-bar .w3-button {
    white-space: normal;
}
.theactiveclass{
background-color: #17a2b8!important;
}

.btne {
  border: 2px solid #56bff9;
  color: white;
  background-color: #56bff9;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 15px;

}
.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}

.profession{
  color: black !important;
  font-size: 16px !important;
}

</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Membership</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('club-hospitality') }}">Club Membership Management</a></li>
  <li><a href="{{ url('club-hospitality/membership-vue') }}">Memberships List</a></li>
   <li><a href="{{ url('club-hospitality/membership/cars-aeu') }}/{{Request::segment(4)}}">Cars List</a></li>
  <li><a href>Deleted Cars</a></li>
</ul>



@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

  <div class="col-xl-12 ">
  
          
            <div class="form-layout form-layout-4 inner-content-address">
                 <div class="row" style="float: right;">
  
                    
                </div>

                <div class="col-md-12" class="table-wrapper">

            <table  class="table display nowrap datatable">
              <thead>
                <tr>

                  <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-15p">Owner Name</th>
                   <th class="wd-10p">Owner CNIC</th>
                   <th class="wd-15p">Driver Name</th>
                   <th class="wd-10p">Driver CNIC</th>
                  <th class="wd-10p">Car Model</th>
                  <th class="wd-10p">Color</th>
                   <th class="wd-10p">Registration #</th>

                   @can('Restore Cars')
                  <th class="wd-15p">Restore</th>
                 @endcan
                </tr>
              </thead>
            </table>
</div>

              </div><!-- form-layout -->
            </div><!-- col-6 -->
            </section>

            </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


@endsection
@push('jscode')

<script type="text/javascript">
  var oTable = '';
// $(document).ready(function() {

        var oTable =   $('.datatable').DataTable({
          seaching: true,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'asc' ]],
          "ajax": {
          'url': '{{ route('cars_deleted.datatable',$membershipdata->id) }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [
        
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'id',name: 'id', orderable: false, searchable: true},
            {data: 'owner_name', name: 'owner_name', searchable: true},
            {data: 'owner_cnic', name: 'owner_cnic', searchable: true},
             {data: 'driver_name', name: 'driver_name', searchable: true},
            {data: 'driver_cnic', name: 'driver_cnic', searchable: true},
            {data: 'car_model', name: 'car_model', searchable: true},
            {data: 'car_color', name: 'car_color', searchable: true},
            {data: 'car_no', name: 'car_no', searchable: true},
          
            @can('Restore Cars')
            {data: 'restorebutton', name: 'restorebutton', orderable: false},  
            @endcan
        ]
    });

</script>

@endpush
