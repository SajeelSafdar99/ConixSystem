@extends('backend.layout.app')
@section('page-content')
    <style type="text/css">
        .header {
  background-color: #f1f1f1;
  text-align: center;
  font-size: 18px;
  color:black;
}

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
        ul.breadcrumbee li + li:before {
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

        .floatydivs {
            float: left;
            margin-right: 149px;
            margin-left: 100px;
        }

        .desktop-screen-design {
            width: 100% !important;
            padding-bottom: 70px;
        }

        .block {
            display: block;
            width: 20%;
            line-height: 50px;
            float: left;
        }


        .w3-black, .w3-hover-black:hover {
            color: #fff !important;
            background-color: #dddddd !important;
        }

        .w3-button:hover {
            color: #000 !important;
            background-color: #ccc !important;
        }

        .w3-red {
            color: #fff !important;
            background-color: #616161 !important;
        }

        .w3-red:hover {
            color: #fff !important;
            background-color: #616161 !important;
        }


        .w3-bar {
            width: 100%;
            height: 60px;
            overflow: hidden;
        }

        .w3-border {
            border: 1px solid #ccc !important;
        }

        .w3-bar .w3-bar-item {
            padding: 8px 16px;
            float: left;
            width: 20%;
            border: none;
            display: block;
            outline: 0;
            height: 60px;
        }

        .w3-bar .w3-button {
            white-space: normal;
        }

        th {
            color: #fff !important;
        }
        
        .headingsettings {
            font-size: 20px !important;
        }
        input:focus{
    outline: none !important;
}

input[readonly] {
    background: transparent !important;
    border: none;
    border-bottom: none;
    width:100%;
}
.cardcss{
    height: 200px !important;
  width: 50% !important;
  border-style: solid !important;
  border-width: thick !important;
  border-color: white !important;
}

.cardcsstwo{
    height: 200px !important;
  width: 100% !important;
  border-style: solid !important;
  border-width: thick !important;
  border-color: white !important;
}

.areabox{cursor:pointer !important;}

.select2-selection {
  height: 34px !important; 
  font-size: 13px;
  font-family: 'Open Sans', sans-serif;
  border-radius: 0 !important;
  border: solid 1px #c4c4c4 !important;
  padding-left: 4px;
}

.select2-selection--multiple {
  height: 100px !important;

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
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10  hidden-print margara">Membership Fee Revenue</h6>
            <div class="hidden-print" style="text-align: right; margin-top: -39px;">
                <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
                <a href="{{ url('finance-and-management/reports/membership-fee-revenue') }}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>
 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
    <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
    <li><a href="{{ url('finance-and-management/club-membership-management/reports') }}">Club Membership Management Reports</a></li>
    <li><a href="{{ url('finance-and-management/reports/membership-fee-revenue') }}">Membership Fee Revenue List</a></li>
    </ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif

 
<div>
 
<!-- <div class="row">
 <div class="card bg-info text-white cardcsstwo">
    <div class="card-header text-uppercase"><h5>Total Maintenance Fee Revenue:</h5></div>
    <div class="card-body "><h4>@if($membershipdata) {{number_format($membershipdata)}} @else 0 @endif</h4></div>
    <div class="card-footer text-uppercase">@if($membershipdata)
          <input type="hidden" id="revenuetotal" name="revenuetotal" value="{{$membershipdata}}">
        <input type="text" id="revenue" name="revenue" value="{{old('revenue')}}" readonly>
                            @else "Zero"
                            @endif</div>
  </div>

 
</div>-->
  
<div class="hidden-print" style="color: black;">
    <form>
    
         <div class="row">

<div class="col-md-5">
@if($cati!=[])

                        <div class="form-group">
                            <label><b>CATEGORY:</b></label>
                           
                            <select class="form-control js-example-basic-multiple" name="categories[]" multiple="multiple">
                                 @foreach($categories as $c)

                                <option value="{{$c->id}}" @if(in_array($c->id,$cati)) selected="selected" @endif>{{$c->desc}}</option>

                                 @endforeach
                            </select>
           
                        </div>
                   
 @elseif($cati==[])
            
                        <div class="form-group">
                            <label><b>CATEGORY:</b></label>
                           
                            <select class="form-control js-example-basic-multiple" name="categories[]" multiple="multiple">
                                 @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->desc}}</option>
                                 @endforeach
                            </select>
           
                        </div>
                    
  @endif
</div>

<div class="col-md-5">
@if($stati!=[])
               
                        <div class="form-group">
                            <label><b>STATUS:</b></label>
                           
                            <select class="form-control js-example-basic-multiple" name="status[]" multiple="multiple">
                                 @foreach($status as $s)

                                <option value="{{$s->id}}" @if(in_array($s->id,$stati)) selected="selected" @endif>{{$s->desc}}</option>

                                 @endforeach
                            </select>
           
                        </div>
                   

                    @elseif($stati==[])
                   
                        <div class="form-group">
                            <label><b>STATUS:</b></label>
                           
                            <select class="form-control js-example-basic-multiple" name="status[]" multiple="multiple">
                                 @foreach($status as $s)
                                <option value="{{$s->id}}">{{$s->desc}}</option>
                                 @endforeach
                            </select>
           
                        </div>
                 
                    @endif
</div>

<div class="col-md-2">
                        <div class="form-group">
                           <button style="margin-top: 27px;" type="submit" id="searchbtn" class="btn btn-info"><i
                                class="fa fa-search"></i>Search
                        </button>

                        </div>
                    </div>
        </div>
    </form>
 
</div>


     <div class="header"><b>MEMBERSHIP FEE REVENUE DETAILS</b></div>
            <div id="London2" class="w3-container w3-border city">
               
                <div class="table-wrapper">
                    <table id="usersTable2" class="table display nowrap">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-5p">Members</th>
                            <th class="wd-10p">Category</th>
                            <th class="wd-10p"> Code</th>
                            <th class="wd-10p">Membership Fee</th>
                            <th class="wd-20p">Amount in Words</th>
                        </tr>
                        </thead>
                        <tbody>
@php
$i=0;
    @endphp
@foreach($subs as $sub)
@php
$i++; @endphp
                           <tr>
                                <td>{{$i}}</td>

                             <?php $number = 0; ?>
@foreach ($members as $member)
    @if ( $member->mem_category_id == $sub->id)
             <?php $number++ ?>    
    @endif
@endforeach
<td>{{ number_format($number) }}</td>
                                <td>{{$sub->desc}}</td>
                                 <td >{{$sub->unique_code}}</td>
                                 @php $sum = 0; @endphp
     @foreach($members as $member)
      @if(is_numeric($member->total) && $member->mem_category_id == $sub->id)

        @php $sum+= $member->total; @endphp
        @endif 
         
@endforeach
                                 <td >{{number_format($sum)}}</td>
                                 <td><!-- @{{inWords($sum)}} -->
<!-- @if($sum)
          <input type="hidden" id="sumtotal" name="sumtotal" value="{{$sum}}">
        <input type="text" id="sumsingle" name="sumsingle" value="{{old('sumsingle')}}" readonly>
                            @else Zero
                            @endif -->
                                 @if($sum)
     @php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum);
                                @endphp @else Zero
                            @endif </td>
                                 
                            </tr>
                            @endforeach
<tr style="background-color: #55bff9;">
    <td colspan="1" class="text-left">Total :</td>
    <td colspan="1" class="text-left">@if($memberscount) {{number_format($memberscount)}}@else 0 @endif</td>
    <td colspan="2" class="text-left"></td>
    <td colspan="1"  class="text-left" >@if($membershipdata) {{number_format($membershipdata)}} @else 0 @endif</td>
    <td colspan="1"  class="text-left" >@if($membershipdata)
          <input type="hidden" id="revenuetotal" name="revenuetotal" value="{{$membershipdata}}">
        <input type="text" id="revenue" name="revenue" value="{{old('revenue')}}" readonly>
                            @else Zero
                            @endif</td>
</tr>

                        </tbody>
                    </table>
                </div><!-- table-wrapper -->
            </div>

<!-- <div class="row">
     @php $divide=0; @endphp
@foreach($subs as $sub)
@if($divide==-1) <div class="row">  @endif
     <div class="card bg-info text-white cardcss">
    <div class="card-header text-uppercase"><h5>{{$sub->desc}} Maintenance Fee Revenue:</h5></div>
    <div class="card-body ">
@php $sum = 0; @endphp
     @foreach($members as $member)
      @if(is_numeric($member->total_maintenance) && $member->mem_category_id == $sub->id)

        @php $sum+= $member->total_maintenance; @endphp
        @endif 
         
@endforeach
<h4>{{number_format($sum)}}</h4></div>
    <div class="card-footer text-uppercase">@if($membershipdata)
     @php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum);
                                @endphp
                            @endif</div>
  </div>

@if($divide==-1) </div>  @endif
  @php $divide++; @endphp
@endforeach 
</div>
 -->
 


</div>

            
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

        function revenueselect(idd) {

            var idval = document.getElementById(idd).value;

            $.ajax({
                type: 'GET',
                url: '{{ url('club-hospitality/maintenance-fee-revenue/calculaterevenue/') }}/' + idval,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj) {

                        console.log(obj);
                        document.getElementById('hiddenid').value = obj;
                        
                    }
                }
            });


        }
    </script>

 <script type="text/javascript">
 var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

function inWords(num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lac ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str + 'only';
}
document.getElementById('revenue').value = inWords(document.getElementById('revenuetotal').value);
document.getElementById('sumsingle').value = inWords(document.getElementById('sumtotal').value);
</script>

@endpush
