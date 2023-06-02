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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Sales</h6>
          <div style="text-align: right;" class="hidden-print">
            @can('Add Sales')
          <a href="{{ url('food-and-beverage/sales/sales-aeu') }}">
          <img src="{{ url('assets/images/addnew.png') }}" title="Add New Sale" height="28" width="28" border="0/">
          </a>
          @endcan 
          @can('View Deleted Sales')
          <a href="{{ url('food-and-beverage/sales/deleted') }}">
          <img src="{{ url('assets/images/delete bin.png') }}" title="View All Deleted Records" height="31" width="31" border="0/">
          </a>
          @endcan
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
 
<ul class="breadcrumbee border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href>Sales List</a></li>
</ul>            

@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
             <form method="get" >
              <div class="row">
                <div class="col-md-4">
@if($resti!=[])
                        <div class="form-group">
                          <p style="color: black;">Restaurant:</p>
                           
                            <select class="form-control js-example-basic-multiple" name="restaurant[]" id="restaurant" multiple="multiple">
                               @foreach($restaurant_locations as $restaurant)
                                  <option  value="{{ $restaurant->id}}" @if(in_array($restaurant->id,$resti)) selected="selected" @endif>
                                           {{ $restaurant->desc}}
                                        </option>
                                         @endforeach

                            </select>
           
                        </div>
                   
 @elseif($resti==[])
            
                        <div class="form-group">
                            <p style="color: black;">Restaurant:</p>
                           
                            <select class="form-control js-example-basic-multiple" name="restaurant[]" id="restaurant" multiple="multiple">
                               @foreach($restaurant_locations as $restaurant)
                                        <option  value="{{ $restaurant->id}}">
                                           {{ $restaurant->desc}}
                                        </option>
                                         @endforeach
                            </select>
           
                        </div>
                    
  @endif
</div>

  <div class="col-md-4">
@if($tabi!=[])
                        <div class="form-group">
                            <p style="color: black;">Table #:</p>
                           
                            <select class="form-control js-example-basic-multiple" name="table[]" id="table" multiple="multiple">
                               @foreach($table_defs as $tabledef)
                                  <option  value="{{ $tabledef->id}}" @if(in_array($tabledef->id,$tabi)) selected="selected" @endif>
                                           {{ $tabledef->desc}}
                                        </option>
                                         @endforeach
                            </select>
                        </div>               
 @elseif($tabi==[])
                        <div class="form-group">
                            <p style="color: black;">Table #:</p>
                           
                            <select class="form-control js-example-basic-multiple" name="table[]" id="table" multiple="multiple">
                                @foreach($table_defs as $tabledef)
                                        <option  value="{{ $tabledef->id}}">
                                           {{ $tabledef->desc}}
                                        </option>
                                         @endforeach
                            </select>
                        </div>  
  @endif
</div>


 <div class="col-md-4">
@if($wati!=[])
                        <div class="form-group">
                           <p style="color: black;">Waiter:</p>
                           
                            <select class="form-control js-example-basic-multiple" name="waiter[]" id="waiter" multiple="multiple">
                             @foreach($waiterdefs as $waiterdef)
                                  <option  value="{{ $waiterdef->id}}" @if(in_array($waiterdef->id,$wati)) selected="selected" @endif>
                                           {{ $waiterdef->name}}
                                        </option>
                                         @endforeach
                            </select>
                        </div>               
 @elseif($wati==[])
                        <div class="form-group">
                            <p style="color: black;">Waiter:</p>
                           
                            <select class="form-control js-example-basic-multiple" name="waiter[]" id="waiter" multiple="multiple">
                                  @foreach($waiterdefs as $waiterdef)
                                        <option  value="{{ $waiterdef->id}}">
                                           {{ $waiterdef->name}}
                                        </option>
                                         @endforeach
                            </select>
                        </div>  
  @endif
</div>
              </div>
<br>
                <div class="row">

                    <div class="col-lg">
                         <div class="row">
                           
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input  type="radio"  name="mog" value="0"><span class="pabs">Mem</span>
                                </label>
                            </div>
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input type="radio" name="mog" value="1"><span class="pabs">Guest</span>
                                </label>
                            </div>
                             <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input  type="radio"  name="mog" value="3"><span class="pabs">Emp</span>
                                </label>
                            </div>
                        </div>
                       
                      
                            <input style="    margin-top: 13px;" @if($errors->has('customer')) style="border-color:red;"
                                   @endif id="customer_search" class="form-control typeahead tablikebutton"
                                   placeholder="Search by Name..." type="text" value="" name="customer"
                                   onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)" autocomplete="off">
<input type="hidden" name="mog_id" value="">
                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                      
                    </div>

                    <div class="col-lg">
                        <div>
                            <p style="color: black;">Begin Date:</p>
                            <input value="" class=" form-control tablikebutton" type="text" autocomplete="off"
                                   id="start_date"
                                   name="start_date">
                        </div>
                    </div>
                    <div class="col-lg">
                        <div>
                            <p style="color: black;">End Date:</p>
                            <input value="" class="form-control tablikebutton" type="text" autocomplete="off"
                                   id="end_date" name="end_date">
                        </div>
                    </div>

                        <div class="col-lg">
                        <div>
                            <p style="color: black;">Invoice No.</p>
                            <input value="" class=" form-control tablikebutton" size="20" type="number"
                                   id="receipt_search"
                                   name="booking" placeholder="Search by Id...">
                        </div>
                    </div>


                     <div class="col-lg">
                        <div>
                            <p style="color: black;">Discounted/Taxed:</p>
                            <select class="form-control" name="specific" id="specific">

                               <option value="0">All</option>
                                        <option  value="1">
                                          Discount
                                        </option>
                                        <option  value="2">
                                          Tax
                                        </option>
                                         
            </select>
                        </div>
                    </div>


                       <div class="col-lg">
                        <div>
                            <p style="color: black;">Status:</p>
                            <select class="form-control" name="status" id="status">

                               <option value="0">All</option>
                                        <option  value="1">
                                           Paid
                                        </option>
                                         <option  value="2">
                                           UnPaid
                                        </option>
            </select>
                        </div>
                    </div>

  <div class="col-lg">
                        <button  type="button" style="    margin-top: 32px;" onclick="search()" class="btn btn-info"><i
                                class="fa fa-search"></i>Search
                        </button>

                        <button type="button" onclick="window.print();" title="print" style="    margin-top: 32px;"
                                class="btn btn-danger"><i
                                class="fa fa-print"></i>
                        </button>

                    </div>

                </div>


                <br><br>

            </form>
          <div class="table-wrapper">
            <table class="table display nowrap datatable">
              <thead>
                <tr>
                  <th class="wd-5p">Sr #</th>
                  <th class="wd-10p">Invoice #</th>
                  <th class="wd-10p">Invoice Date</th>
                   <th class="wd-20p">Name</th>
                  <th class="wd-10p">Customer Type</th>
                  <th class="wd-15p">Customer #</th>
                  <th class="wd-15p">Restaurant</th>
                  <th class="wd-10p">Table #</th>
                   <th class="wd-10p">Gross</th>
                   <th class="wd-10p">Disc</th>
                    <th class="wd-10p">Sub-Total</th>
                     <th class="wd-10p">Tax</th>
                  <th class="wd-10p">Grand Total</th>
                  <th class="wd-10p">Amount Paid</th>
                  <th class="wd-10p">Balance</th>
                    <th class="wd-15p">Details</th>
                  <th class="wd-10p">Status</th>
                  @can('Print Sales Invoice')
                  <th class="wd-5p">Invoice</th>
                  @endcan
                  @can('Edit Sales')
                  <th class="wd-5p">Edit</th>
                  @endcan 
                   @can('Delete Sales')
                  <th class="wd-5p">Delete</th>
                  @endcan
                </tr>
              </thead>
               <tfoot>
                <tr>
                    <td colspan="12">Total :</td>
                    <td class="GrandTotal"></td>
                    <td class="AmountPaid"></td>
                    <td class="Balance"></td>
                    <td></td>
                   <td></td>
                     @can('Print Sales Invoice')
                    <td></td>
                    @endcan
                    @can('Edit Sales')
                    <td ></td>
                    @endcan
                    @can('Delete Sales')
                    <td ></td>
  @endcan
                </tr>
                </tfoot>
             
            </table>
          </div><!-- table-wrapper -->

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
@endsection

@push('jscode')

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
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
<style>
    .remove{
        display:none;
    }
</style>

<script type="text/javascript">
  var oTable = '';
// $(document).ready(function() {
 
  $(".datatable").on('xhr', function(e, settings, json, xhr){
      // TODO: Insert your code
      // console.log(json);return;
      if(json.data.length>0){
          $('.totalC').html('Total Receipts: '+json.data[0].ctotal+ ' <br>Total Amount: '+json.data[0].dtotal)
      }
  });
        var oTable =   $('.datatable').DataTable({
          seaching: false,
            "fnDrawCallback": function(c,b,a){
                console.log(c.aoData.length);
                if(c.aoData.length>0){
                  
                    $('.GrandTotal').html(c.aoData[0]._aData.dtotal.GrandTotal);
                     $('.AmountPaid').html(c.aoData[0]._aData.dtotal.AmountPaid);
                      $('.Balance').html(c.aoData[0]._aData.dtotal.Balance);
                    $('.type').html($('input[name="mog"] :checked').val()==0?'Selected Member:':'Selected Guest:');
                    $('.name123').html($('input[name="customer"]').val());
                    $('.start_date').html($('input[name="start_date"]').val()!=''?' From: '+$('input[name="start_date"]').val():'');
                    $('.end_date').html($('input[name="end_date"]').val()!=''?' to: '+$('input[name="end_date"]').val():'');
                    $('.booking_no').html($('input[name="booking"]').val()!=''?' where Invoice #: '+$('input[name="booking"]').val():'');

                    // $('.totalC').html('Total Bookings: '+c.aoData[0]._aData.ctotal+ ' <br>Total Amount: '+c.aoData[0]._aData.dtotal)
                }
                else{
                    $('.totalC').html('')

                }



            },
            searching: false,
          oLanguage: {
        sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
        },
          processing: true,
          serverSide: true,
          order: [[ 1, 'desc' ]],
          "ajax": {
          'url': '{{ route('fnb_sales.datatable') }}',
          'type': 'POST',
           data:{
                  'start_date':function(){ return $('input[name="start_date"]').val()},
                  'end_date':function(){ return $('input[name="end_date"]').val()},
                  'customer':function(){ return $('input[name="mog_id"]').val()},
                  'receipt':function(){ return $('input[name="booking"]').val()},
                  'mog':function(){ return $('input[name="mog"]:checked').val()},
                  'status':function(){ return $('#status').val()},
                  'restaurant':function(){ return $('#restaurant').val()},
                  'table':function(){ return $('#table').val()},
                  'waiter':function(){ return $('#waiter').val()},
                  'specific':function(){ return $('#specific').val()},
              },
          'headers': {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        },
        "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": ""
            } ],
        columns: [   
         
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'invoice_no', name: 'invoice_no', searchable: true},
             {data: 'date', name: 'date', searchable: true},
              {data: 'name', name: 'name', searchable: true},
             {data: 'type', name: 'type', searchable: true},
            {data: 'customer_id', name: 'customer_id', searchable: true},
            {data: 'restaurant_location', name: 'restaurant_location', searchable: true},
            {data: 'table_definition', name: 'table_definition', searchable: true},
            {data: 'gross', name: 'gross', searchable: false},
             {data: 'discount', name: 'discount', searchable: false},
             {data: 'sub_total', name: 'sub_total', searchable: false},
             {data: 'tax', name: 'tax', searchable: false},
            {data: 'grand_total', name: 'grand_total', searchable: false},
             {data: 'amountpaid', name: 'amountpaid', searchable: false},
             {data: 'finalbalance', name: 'finalbalance', searchable: false},
             {data: 'details_d', name: 'details_d', searchable: true},
             {data: 'balancestatus', name: 'balancestatus', orderable: false},
            @can('Print Sales Invoice')
            {data: 'invoice', name: 'invoice', orderable: false}, 
            @endcan 
            @can('Edit Sales')
            {data: 'editbutton', name: 'editbutton', orderable: false}, 
            @endcan 
            @can('Delete Sales')
            {data: 'deletebutton', name: 'deletebutton', orderable: false},  
            @endcan           
        ],
        /* rowCallback: function( row, data, index ) {
              if($('#status').val()=='1'){
                  if(data.finalbalance!=0){
                      console.log(data);
                      $(row).addClass('remove');
                  }
                  else{
                      $(row).removeClass('remove');

                  }
              }
              else if($('#status').val()=='2'){
                  if(data.finalbalance==0){
                      console.log(data);

                      $(row).addClass('remove');
                  }
                  else{
                      $(row).removeClass('remove');

                  }
              }
              else{

              }
            } */
    });
function search() {
        oTable.ajax.reload();
    }
function customerdata(val) {
      let v=$('input[name="mog"]:checked').val();
if(val==''){
          $('input[name="mog_id"]').val('');
      }
      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdatalike') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "customerid": val,
              'MOC':v
          },
          success: function (data) {

              jQuery('#areabox').html('');
              jQuery.each(JSON.parse(data), function (i, val1) {
               if(v==1){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name} : ${val1.customer_no} <li>`);
   }
   else if(v==3){
  $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.name} : ${val1.barcode} <li>`);
   }
   else if(v==0){
    $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';
                let fullname=$fname+$mname+$lname;

    $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${fullname} : ${val1.mem_no} <li>`);
                        }

              });
$('#areabox').show();
              // $('#areabox').html(data);

          }
      });
  }
  function customerdatavalue(val) {
      let v=$('input[name="mog"]:checked').val();

      $.ajax({
          type: 'POST',
          url: '{{ url('search/customerdata') }}',
          data: {
              "_token": "{{ csrf_token() }}",
              "customerid": val,
              'MOC':v
          },
          success: function (data) {

              console.log(data);
              var obj = JSON.parse(data);
              if(v==1){
                  document.getElementById('customer_search').value = obj.customer_name;
                  $('input[name="mog_id"]').val( obj.id);
              }

              else if(v==0){
                  $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                  document.getElementById('customer_search').value = $fname+$mname+$lname;
                  $('input[name="mog_id"]').val( obj.id);

              }

               else if(v==3){
                  document.getElementById('customer_search').value = obj.name;
                  $('input[name="mog_id"]').val( obj.id);

              }

              jQuery('#areabox').html('');

          }


      });
  }
</script>


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>

  <script>
    $( function() {
    $( "#start_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );

      $( function() {
    $( "#end_date" ).datepicker({

       format: 'dd/mm/yyyy',
       todayHighlight: true
     })
  } );
  </script>
@endpush