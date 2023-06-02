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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Trans Type & COA Linking</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
       
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

<ul class="breadcrumbee border-bottom-custom">
<li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/definitions') }}">Definitions</a></li>
  <li><a href>Trans Type & COA Linking</a></li>
</ul>

       <button id="btnadd" style="float: right;
    background-color: #49a2fb;
    cursor: pointer;
    margin-top: -21px;
  color: #fff;
    border-radius: 15px;"  data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#modaldemo1">Edit <i class="fas fa-edit"></i></button> 
    

       <div class="table-wrapper"> 
            <table  class="table display nowrap datatable">

              <thead>
                <tr>
                 <th class="wd-5p">Sr #</th>
                  <th class="wd-5p">ID</th>
                  <th class="wd-10p">Trans Type</th>
                <th class="wd-10p">COA</th>
                  <th class="wd-10p">Linkage</th>
              
                </tr>
              </thead>
            </table>
          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


{{-- LINKING MODAL--}}
<form method="post" action="{{ url('finance-and-management/coa-linking/link/') }}/{{ $update->id }}">
    @csrf
<div id="modaldemo1" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document" style="width: 1000px;">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">TRANS TYPE & COA LINKING</h6>
                </div>


@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  
                 <div class="modal-body pd-25">
                  <div class="row">
                      <div class="col-md-12">
 <p style="color: black;">Please choose a COA to continue..</p>
 <br>
 <div class="row mg-t-10" style="color: black;">
                        <label class="col-sm-2 form-control-label" >
                         COA:
                        </label>
                        <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                     <input @if($errors->has('coa_code')) style="border-color:red;" @endif id="coa_code" class="form-control input-height typeahead" placeholder="Enter to Search..." autocomplete="off" value="@if($init==0){{old('coa_code')}}@else{{old('coa_code',coaname($update->account))}} - {{old('coa_code',$update->account)}}@endif" type="text" name="coa_code" onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">

                    <input @if($errors->has('account')) style="border-color:red;"  @endif id="account" autocomplete="off" value="@if($init==0){{old('account')}}@else{{old('account',$update->account)}}@endif"
                                                               type="hidden" name="account">

                 <input @if($errors->has('name')) style="border-color:red;"  @endif id="name" autocomplete="off" value="@if($init==0){{old('name')}}@else{{old('name',$update->name)}}@endif"
                                                               type="hidden" name="name"
                                                                >

 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue; list-style-type: none;color: black;"></ul>
                    </div>
                      </div>

 <div class="row mg-t-10">
                               @if($init==1)   <div class="col-sm-4 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('debit_or_credit',$update->debit_or_credit)=='0') checked="" @endif @endif type="radio" name="debit_or_credit" value="0" ><span class="pabs">Debit</span>
              </label>

          
                <label class="rdiobox">
    <input @if(old('debit_or_credit',$update->debit_or_credit)=='1') checked="" @endif type="radio" name="debit_or_credit" value="1" ><span class="pabs">Credit</span>
              </label>
             
            </div><!-- col-3 -->

                                @else

        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
      <label class="rdiobox">
    <input @if($init==0) checked="" @else @if(old('debit_or_credit')=='0') checked="" @endif @endif type="radio" name="debit_or_credit" value="0" ><span class="pabs">Debit</span></label>
 
                <label class="rdiobox">
    <input @if(old('debit_or_credit')=='1') checked="" @endif type="radio" name="debit_or_credit" value="1" ><span class="pabs">Credit</span>
              </label>
            
            </div><!-- col-3 -->
                             @endif
                           </div>

              </div>

                </div>
                  </div>
                
                 <div class="modal-footer">
                     <button type="input" name="save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Link</button>
                  <a href="{{ url('finance-and-management/coa-linking') }}" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Cancel</a>
               
              </div>
              </div>
               
            </div><!-- modal-dialog -->
          </div><!-- modal -->
      </form>

{{-- LINKING MODAL --}}

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
          'url': '{{ route('accounts_linking.datatable') }}',
          'type': 'POST',
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        columns: [   
        
          { data: 'DT_RowIndex', name: 'DT_RowIndex' },
             {data: 'id',name: 'id', orderable: true, searchable: true},
            {data: 'name', name: 'name', searchable: true},
             {data: 'narration', name: 'narration', orderable: false},
            {data: 'status', name: 'status', orderable: false},
                 
        ]
    });

</script>

<script type="text/javascript">

            var val;

        function customerdata(val) {
            
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "searchid": val,
                    
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.name} - ${val1.code}<li>`);

                    });
$('#areabox').show();
                 

                }
            });
        }

</script>

<script type="text/javascript">
        var val;

        function customerdatavalue(val) {
          
            $.ajax({
                type: 'POST',
                url: '{{ url('search/coa/coaaccountdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "theid": val,
                 
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    console.log(obj);
                  
                          $fname=obj.name?obj.name+' ':'';
                     
                          $lname=obj.code?obj.code:'';

                        document.getElementById('coa_code').value = $fname+'-'+' '+$lname;
 
                        document.getElementById('account').value = obj.code;
                        document.getElementById('name').value = obj.name;

                        $("#coa_code").prop("readonly", true);
                     
                      
                    jQuery('#areabox').html('');

                }


            });
        }
</script>


<script type="text/javascript">
     $(document).ready(function(){

    $("#btnadd").hide();

    document.getElementById("btnadd").click();

    });
</script>



@if($errors->any())
<script type="text/javascript">
    document.getElementById("btnadd").click();
</script>
@endif

@endpush
