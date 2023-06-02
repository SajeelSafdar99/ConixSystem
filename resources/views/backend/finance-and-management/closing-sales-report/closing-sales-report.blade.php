@extends('backend.layout.app')
@section('page-content')
    <style type="text/css">
        .header {
  background-color:     #B0B0B0;
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
@page {
  size: A4;
  margin: 0;

}
@media print {
  html, body {
    width: 250mm;
    height: 297mm;
  }
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
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10  hidden-print">Closing Sales Report</h6>
            <div style="text-align: right;">
                <button type="button" onclick="window.print()" title="Print"
                                        class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button>
                <a href="{{ url('finance-and-management/reports/closing-sales-report') }}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page" height="28" width="28"
                         border="0/">
                </a>
            </div>

 <ul class="breadcrumbee border-bottom-custom">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
     <li><a href="{{ url('finance-and-management/finance-reports-submodules') }}">Reports</a></li>
    <li><a href="{{ url('finance-and-management/food-and-beverage/reports') }}">Food & Beverage Reports</a></li>
    <li><a href="{{ url('finance-and-management/reports/closing-sales-report') }}">Closing Sales Report List</a></li>
    </ul>

 @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


<div>
 <form>

<div class="hidden-print">
     <div class="row">
<div class="col-md-6">
            @if($chosenrest!=[]) 
                            <p style="color: black;">Restaurant:</p>
                           <select class="form-control js-example-basic-multiple" id="restsearch" name="restsearch[]" multiple="multiple">
                             @foreach($restaurant_locations as $rest_loc)
                             
        <option value="{{$rest_loc->id}}" @if(in_array($rest_loc->id,$chosenrest)) selected="selected" @endif>{{$rest_loc->desc}}</option>
                            
                              @endforeach
                           </select>
                             
            @elseif($chosenrest==[])
                        
                            <p style="color: black;">Restaurant:</p>
                           <select class="form-control js-example-basic-multiple" id="restsearch" name="restsearch[]" multiple="multiple">
                              @foreach($restaurant_locations as $rest_loc)
                             <option value="{{$rest_loc->id}}">{{$rest_loc->desc}}</option>
                             @endforeach
                           </select>
                              
            @endif
</div>

<div class="col-md-6">
            @if($chosenorder!=[])
                               
                            <p style="color: black;">Order Type:</p>
                           <select class="form-control js-example-basic-multiple" id="ordersearch" name="ordersearch[]" multiple="multiple">
                            

          <option value="Dine-In" @if(in_array('Dine-In',$chosenorder)) selected="selected" @endif>Dine-In</option>
          <option value="Take Away" @if(in_array('Take Away',$chosenorder)) selected="selected" @endif>Take Away</option>
          <option value="Home Delivery" @if(in_array('Home Delivery',$chosenorder)) selected="selected" @endif>Home Delivery</option>
                          
                          
                           </select>
                             
            @elseif($chosenorder==[])
                        
                            <p style="color: black;">Order Type:</p>
                           <select class="form-control js-example-basic-multiple" id="ordersearch" name="ordersearch[]" multiple="multiple">
                             
                            <option value="Dine-In">Dine-In</option>
                            <option value="Take Away">Take Away</option>
                            <option value="Home Delivery">Home Delivery</option>
                         
                           </select>
                              
            @endif
</div>

</div>
<br>
<div class="row">
      <div class="col-lg">      <p style="color: black;">Begin Date:</p>
                            <input value="{{$start_date}}" class=" form-control tablikebutton" type="text" autocomplete="off" placeholder="From (dd/mm/yyyy)" 
                                   id="start_date"
                                   name="start_date">
                               </div>
                                    <div class="col-lg">
                        
                            <p style="color: black;">End Date:</p>
                            <input value="{{$end_date}}" class="form-control tablikebutton" type="text" autocomplete="off" placeholder="To (dd/mm/yyyy)" 
                                   id="end_date" name="end_date">
                               </div>



                         <div class="col-lg">

                        <button style="    margin-top: 32px;" type="submit" id="searchbtn" class="btn btn-info"><i
                                class="fa fa-search"></i>Search
                        </button>

                    </div>
                </div>
 <br>
</div>
</form>

<div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
  <h3>CLOSING SALES REPORT</h3>
<hr>
</div>

@if($start_date && $end_date)
<div style="text-align: center; color: black;">
  <h5>Date = From {{$start_date}} To {{$end_date}}</h5>
<hr>
</div>
@endif

@php
$i=0;
$grandsum=0;
$grandsum1=0;
$grandsum2=0;
$grandsum3=0;
$grandsum4=0;
$grandsum5=0;
$grandsum6=0;
$grandsum7=0;
$grandsum8=0;
    @endphp
@foreach($restaurants as $restaurant)

  @php $present = 0; @endphp
     @foreach($sales as $sale)
     @if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
      @if($sale->restaurant_location == $restaurant->id)

        @php $present=1; @endphp
        @endif 
          @endif  
@endforeach


@if($present==1)
@php
$i++; @endphp
     <div class="header" style="text-transform: uppercase; "><b>{{$restaurant->desc}}</b></div> 
            <div id="London2" class="w3-container w3-border city">
                <div class="table-wrapper">
                    <table id="usersTable2" class="table display nowrap datatable">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>
                            <th class="wd-5p">Gross Sale</th>
                            <th class="wd-5p">Disc.</th>
                            <th class="wd-5p">Net Sale</th>
                            <th class="wd-5p"> Tax</th>
                            <th class="wd-5p">Total Sale</th>
                            <th class="wd-5p">Cash Sale</th>
                            <th class="wd-5p">Credit Sale</th>
                            
                            <th class="wd-5p">Paid Sale</th>
                            <th class="wd-5p">Unpaid Sale</th>
                            
                        </tr>
                        </thead>
                        <tbody>

                           <tr>
                                <td>{{$i}}</td>
                                 @php $sum = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->gross) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum+= $sale->gross; @endphp
        @endif 
          @endif  
@endforeach <td title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum);
                                @endphp" class="wd-5p">{{number_format($sum)}}</td>

@php $grandsum= $grandsum+$sum; @endphp

                                  
                                  @php $sum1 = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->discount) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum1+= $sale->discount; @endphp
        @endif 
        @endif 
@endforeach <td  title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum1);
                                @endphp">{{number_format($sum1)}}</td>

@php $grandsum1= $grandsum1+$sum1; @endphp

                                 
                                  @php $sum2 = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->sub_total) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum2+= $sale->sub_total; @endphp
        @endif 
      @endif   
@endforeach <td  title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum2);
                                @endphp">{{number_format($sum2)}}</td>

@php $grandsum2= $grandsum2+$sum2; @endphp

                                  
                                  @php $sum3 = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->tax) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum3+= $sale->tax; @endphp
        @endif 
         @endif
@endforeach <td title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum3);
                                @endphp">{{number_format($sum3)}}</td>

@php $grandsum3= $grandsum3+$sum3; @endphp


    @php $sum8 = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum8+= $sale->grand_total; @endphp
        @endif 
       @endif  
@endforeach <td  title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum8);
                                @endphp">{{number_format($sum8)}}</td>

@php $grandsum8= $grandsum8+$sum8; @endphp
               

                        @php $sum4 = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total) && in_array($sale->account_type,$acccash) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum4+= $sale->grand_total; @endphp
        @endif 
         @endif
@endforeach <td title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum4);
                                @endphp">{{number_format($sum4)}}</td>

@php $grandsum4= $grandsum4+$sum4; @endphp

                                      
                                       @php $sum5 = 0; @endphp
     @foreach($sales as $sale) 
      @if(is_numeric($sale->grand_total) && in_array($sale->account_type,$acccredit) && $sale->restaurant_location == $restaurant->id)
@if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3)
        @php $sum5+= $sale->grand_total; @endphp
        @endif 
         @endif
@endforeach <td title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum5);
                                @endphp">{{number_format($sum5)}}</td>

@php $grandsum5= $grandsum5+$sum5; @endphp


                                    @php $sum6 = 0; @endphp
     @foreach($sales as $sale)
      @if(is_numeric($sale->grand_total) && $sale->completed==2 && $sale->restaurant_location == $restaurant->id)
<!-- @if($sale->completed==1 || $sale->completed==2 ||  $sale->completed==3) -->
        @php $sum6+= $sale->grand_total; @endphp
     <!--    @endif  -->
       @endif  
@endforeach <td title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum6);
                                @endphp">{{number_format($sum6)}}</td>

@php $grandsum6= $grandsum6+$sum6; @endphp



  <td title="@php $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($sum8-$sum6);
                                @endphp">{{number_format($sum7=$sum8-$sum6)}}</td>

@php $grandsum7 = $grandsum7+$sum7; @endphp

                
               

                            </tr>
                          

                        </tbody>

                    </table>
                </div><!-- table-wrapper -->
            </div>
<br> <br> 
@endif
@endforeach

<table class="table display nowrap datatable" >
     <thead>

                        <tr style="background-color:#1288ce;">
                            <th class="wd-5p">Total : </th>

                             <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum);
                                @endphp" class="wd-5p">{{number_format($grandsum)}}</th>

                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum1);
                                @endphp" class="wd-5p">{{number_format($grandsum1)}}</th>


                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum2);
                                @endphp" class="wd-5p">{{number_format($grandsum2)}}</th>

            
                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum3);
                                @endphp" class="wd-5p">{{number_format($grandsum3)}}</th>

                        
                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum8);
                                @endphp" class="wd-5p">{{number_format($grandsum8)}}</th>


                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum4);
                                @endphp" class="wd-5p">{{number_format($grandsum4)}}</th>
                            

                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum5);
                                @endphp" class="wd-5p">{{number_format($grandsum5)}}</th>


                            <th  title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum6);
                                @endphp" class="wd-5p">{{number_format($grandsum6)}}</th>


                            <th title="@php 
                                    $x=new NumberFormatter('en',NumberFormatter::SPELLOUT);
                                    echo $x->format($grandsum7);
                                @endphp" class="wd-5p">{{number_format($grandsum7)}}</th>

                        </tr>
                    
                        </thead>
</table>


</div>
     
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


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

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
