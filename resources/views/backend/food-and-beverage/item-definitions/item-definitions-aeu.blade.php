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
div.groove {border-style: groove !important; height: 160px !important;}


.pc{
  display:inline-block;
  position: relative;
  }
.pc input{
  padding-left:15px;
  }
.pc:before {
  position: absolute;
    content:"%";
    left:17px;
  top:6px;
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

@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a> / <a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">FnB Definitions</a> / <a href="{{ url('store-management/definitions') }}">Store Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/item-definitions-vue') }}">Item Definitions List</a></li>
  <li><a href>Edit Item Definition</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a> / <a href="{{ url('store-management') }}">Store Management</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">FnB Definitions</a> / <a href="{{ url('store-management/definitions') }}">Store Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/item-definitions-vue') }}">Item Definitions List</a></li>
  <li><a href>Add Item Definition</a></li>
</ul>
@endif


           <div class="col-xl-12 ">
@if($errors->any())
<div id="error_msg" class="alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    @if($init==1)
          <form method="post" action="{{ url('food-and-beverage/item-definitions/update') }}/{{ $item_def_update->id }}">
                 @else
                 <form method="post">
                   @endif
            @csrf
              <div class="form-layout form-layout-4 ">

                   <div class="row">
               <div class="col-sm-10">


<div class="row mg-t-10">
               <div class="col-sm-2 mg-t-10 mg-sm-t-0">             
  @if($init==1)
<input type="checkbox" name="salable" id="salable" @if(old('salable',$item_def_update->salable)=='1') checked @endif value="1">
 <label for="salable">Salable</label>
   @else
<input type="checkbox" name="salable" id="salable" @if(old('salable')=='1') checked @endif value="1">
 <label for="salable">Salable</label>
@endif
                  </div>


<div class="col-sm-2 mg-t-10 mg-sm-t-0">             
  @if($init==1)
<input type="checkbox" name="purchasable" id="purchasable" @if(old('purchasable',$item_def_update->purchasable)=='1') checked @endif value="1">
 <label for="purchasable">Purchasable</label>
   @else
<input type="checkbox" name="purchasable" id="purchasable" @if(old('purchasable')=='1') checked @endif value="1">
 <label for="purchasable">Purchasable</label>
@endif
                  </div>


                  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
  @if($init==1)
<input type="checkbox" name="returnable" id="returnable" @if(old('returnable',$item_def_update->returnable)=='1') checked @endif value="1">
 <label for="returnable">Returnable</label>
   @else
<input type="checkbox" name="returnable" id="returnable" @if(old('returnable')=='1') checked @endif value="1">
 <label for="returnable">Returnable</label>
@endif
                  </div>
</div>

<br>
<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">Item Category:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
    <select @if ($errors->has('category')) style="border-color:red;" @endif  id="category" name="category" class="form-control input-height select2" onchange="itemcategoryselect(this.id)">
    <option label="Choose Option"></option>
 @foreach($mains as $main)
                                @if($init==1)
                                 <option @if(old('category',$item_def_update->category)==$main->id)  selected @endif  value="{{ $main->id }}">
                                  {{ $main->desc }}
                                </option>
                                @else
                                 <option @if(old('category')==$main->id)  selected @endif value="{{ $main->id }}">
                                  {{ $main->desc }}
                                </option>
                                @endif
                                @endforeach

</select>
                        </div>




             <label class="col-sm-1 form-control-label">Item Sub-Category:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
    <select @if ($errors->has('sub_category')) style="border-color:red;" @endif  id="sub_category" name="sub_category" class="form-control input-height select2" >
    <option label="Choose Option"></option>
 @foreach($subcats as $subcat)
                                @if($init==1)
                                 <option @if(old('sub_category',$item_def_update->sub_category)==$subcat->id)  selected @endif  value="{{ $subcat->id }}">
                                  {{ $subcat->desc }}
                                </option>
                                @else
                                 <option @if(old('sub_category')==$subcat->id)  selected @endif value="{{ $subcat->id }}">
                                  {{ $subcat->desc }}
                                </option>
                                @endif
                                @endforeach

</select>
                        </div>
                  <label class="col-sm-1 form-control-label">
                               Manufacturer:
                                                  
                                                    </label>
   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
         <select @if ($errors->has('manufacturer')) style="border-color:red;" @endif  id="manufacturer" name="manufacturer" class="form-control input-height select2" >
    <option label="Choose Option"></option>
 @foreach($manufacturers as $manfacturer)
                                @if($init==1)
                                 <option @if(old('manufacturer',$item_def_update->manufacturer)==$manfacturer->id)  selected @endif  value="{{ $manfacturer->id }}">
                                  {{ $manfacturer->desc }}
                                </option>
                                @else
                                 <option @if(old('manufacturer')==$manfacturer->id)  selected @endif value="{{ $manfacturer->id }}">
                                  {{ $manfacturer->desc }}
                                </option>
                                @endif
                                @endforeach

</select>

                                                    </div>

                                                 </div>
                                                <!-- row -->
  <div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">Item Code:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
    <input @if ($errors->has('item_code')) style="border-color:red;" @endif type="text" id="item_code" name="item_code" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('item_code')}}@else{{old('item_code',$item_def_update->item_code)}}@endif" placeholder="Enter Code">
                        </div>




             <label class="col-sm-1 form-control-label">Item Name:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-4 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('item_details')) style="border-color:red;" @endif type="text" id="item_details" name="item_details" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('item_details')}}@else{{old('item_details',$item_def_update->item_details)}}@endif" placeholder="Enter Name">
                        </div>
                  <label class="col-sm-1 form-control-label">
                             Opening Stock:
                                                    </label>
   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
         <input @if ($errors->has('opening_stock')) style="border-color:red;" @endif type="number" id="opening_stock" name="opening_stock" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('opening_stock')}}@else{{old('opening_stock',$item_def_update->opening_stock)}}@endif" placeholder="Enter Amount">
  </div>

                                                 </div>
                                                <!-- row -->

                                                <br>
<div class="groove">
  <BR>
 &nbsp&nbsp RECIPE:
</div>
<br>
<div class="row mg-t-10">

        <label class="col-sm-1 form-control-label">Purchase Price:   </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
    <input @if ($errors->has('purchase_price')) style="border-color:red;" @endif type="number" id="purchase_price" name="purchase_price" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('purchase_price')}}@else{{old('purchase_price',$item_def_update->purchase_price)}}@endif" placeholder="Enter Amount">
     </div>




             <label class="col-sm-1 form-control-label">Sale Price:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
     <input @if ($errors->has('sale_price')) style="border-color:red;" @endif type="number" id="sale_price" name="sale_price" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('sale_price')}}@else{{old('sale_price',$item_def_update->sale_price)}}@endif" placeholder="Enter Amount">
                        </div>
                  <label class="col-sm-1 form-control-label">
                             Unit of Measurement: <span class="tx-danger"> * </span>
                                                    </label>
   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
         <select @if ($errors->has('unit')) style="border-color:red;" @endif  id="unit" name="unit" class="form-control input-height select2" >
    <option label="Choose Option"></option>
 @foreach($measurement_units as $measurement_unit)
                                @if($init==1)
                                 <option @if(old('unit',$item_def_update->unit)==$measurement_unit->id)  selected @endif  value="{{ $measurement_unit->id }}">
                                  {{ $measurement_unit->code }}
                                </option>
                                @else
                                 <option @if(old('unit')==$measurement_unit->id)  selected @endif value="{{ $measurement_unit->id }}">
                                  {{ $measurement_unit->code }}
                                </option>
                                @endif
                                @endforeach

</select>
  </div>

                                                 </div>
                                                <!-- row -->
<div class="row mg-t-10">
     
                  <div class="col-sm-2 mg-t-10 mg-sm-t-0">         
   @if($init==1)
<input type="checkbox" name="discountable" id="discountable" @if(old('discountable',$item_def_update->discountable)=='1') checked value="1" @else value="" @endif >
 <label for="discountable">Discountable</label>
   @else
<input type="checkbox" name="discountable" id="discountable" @if(old('discountable')=='1') checked @endif value="1" >
 <label for="discountable">Discountable</label>
@endif
                  </div>

<div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    
  @if($init==1)
<input type="checkbox" name="taxable" id="taxable" @if(old('taxable',$item_def_update->taxable)=='1') checked @endif value="1">
 <label for="taxable">Taxable</label>
   @else
<input type="checkbox" name="taxable" id="taxable" @if(old('taxable')=='1') checked @endif value="1">
 <label for="taxable">Taxable</label>
@endif
                  </div>


                        <label class="col-sm-1 form-control-label">
                            Maximum Item Discount: </label>
                            <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <input @if ($errors->has('discount_amount')) style="border-color:red;" @endif type="number" id="discount_amount" name="discount_amount" class="form-control input-height" autocomplete="off" value="@if($init==0){{old('discount_amount',$predefined->discount_amount)}}@else{{old('discount_amount',$item_def_update->discount_amount)}}@endif" placeholder="Enter Amount" @if($init==1 && $item_def_update->discount_amount=='') disabled @endif>
</div>

<div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">
      <input type="number" @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('discount_amount',$predefined->discount_percentage)}}@else{{old('surcharge_percentage',$item_def_update->discount_percentage)}}@endif" name="discount_percentage" @if($init==1 && $item_def_update->discount_percentage=='') disabled @endif>
  </div>
                                                 </div>
                                                <!-- row -->

<div class="row mg-t-10">
    <label class="col-sm-1 form-control-label">Product Classification:  <span class="tx-danger">  * </span>  </label>
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
     <select @if ($errors->has('product_classification')) style="border-color:red;" @endif  id="product_classification" name="product_classification" class="form-control input-height select2" >
    <option label="Choose Option"></option>
 @foreach($products as $product)
                                @if($init==1)
                                 <option @if(old('product_classification',$item_def_update->product_classification)==$product->id)  selected @endif  value="{{ $product->id }}">
                                  {{ $product->desc }}
                                </option>
                                @else
                                 <option @if(old('product_classification')==$product->id)  selected @endif value="{{ $product->id }}">
                                  {{ $product->desc }}
                                </option>
                                @endif
                                @endforeach

</select>
                        </div>
                           
                        <label class="col-sm-1 form-control-label">
                   Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control  input-height select2" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$item_def_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$item_def_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$item_def_update->status)=='0') selected @endif value="0">
                                    In-Active
                                </option>
                                
                                @else

                              <option @if($init==0) selected="" @else @if(old('status')=='1') selected @endif @endif value="1">
                                   Active
                                </option>
                                <option @if(old('status')=='0') selected @endif value="0">
                                    In-Active
                                </option>

                                @endif


                            </select>
                        </div>
                    
  <label class="col-sm-1 form-control-label">
                            Remarks:
                                                    </label>
   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
      <textarea @if ($errors->has('remarks')) style="border-color:red;" @endif type="text" id="remarks" class="form-control" placeholder="Enter Details" name="remarks" autocomplete="off">@if($init==0){{old('remarks')}}@else{{old('remarks',$item_def_update->remarks)}}@endif</textarea>
  </div>

                                                 </div>
                                                <!-- row -->

           <div class="float-left">

  @if($init==1)
               <div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('food-and-beverage/item-definitions-vue') }}" class="btn btn-secondary">Cancel</a>
                </div><!-- form-layout-footer -->
            </div>
   @else
<div class="row mg-t-10">
               <label class="col-sm-4 form-control-label"></label>
               &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">
                  <input type="submit" name="save" class="btn btn-info" value="Save">

                  &nbsp&nbsp
                   <input type="submit" name="addmore" class="btn btn-info" value="Save & Add More">

                  &nbsp&nbsp
                  <a href="{{ url('food-and-beverage/item-definitions-vue') }}" class="btn btn-secondary">Cancel</a>

                </div><!-- form-layout-footer -->
            </div>
             @endif
              </div><!-- form-layout -->
              </div>
              </div>

            </div><!-- col-6 -->
            </form>
            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->

@endsection

@push('jscode')
<script type="text/javascript">

  function itemcategoryselect(idd){

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
$('#sub_category').html('<option label="Choose Option">  </option>');
            $.each(data,function(x,y){
               let s='<option value="'+y.id+'">'+y.desc+'</option>';
 $('#sub_category').append(s);
                })

  }
}
   });

  }

</script>

    <script type="text/javascript">   
        // Checkbox checked and input disbaled when page loads
        @if($init==0)
        $(document).ready(function() {
$('#discountable').prop('checked', true);
document.getElementById("discountable").value = 1;
if(document.getElementById("discount_amount").value==''){
                document.getElementById("discount_amount").disabled = true;
              }
              else
              {
                document.getElementById("discount_amount").disabled = false;
              }
              

              if(document.getElementById("discount_percentage").value==''){
                document.getElementById("discount_percentage").disabled = true;
              }
              else
              {
                document.getElementById("discount_percentage").disabled = false;
              }
})

        $('#discountable').on('change', function() {

  var ae = document.getElementById("discountable").value;
            
            if (ae == '1') {

                document.getElementById("discount_amount").disabled = true;
                document.getElementById("discount_percentage").disabled = true;
                document.getElementById("discountable").value = '';

            

            }
            if (ae == '') {

                if(document.getElementById("discount_amount").value==''){
                document.getElementById("discount_amount").disabled = true;
              }
              else
              {
                document.getElementById("discount_amount").disabled = false;
              }
              

              if(document.getElementById("discount_percentage").value==''){
                document.getElementById("discount_percentage").disabled = true;
              }
              else
              {
                document.getElementById("discount_percentage").disabled = false;
              }
                
                document.getElementById("discountable").value = 1;
               
            }

});
@endif

 @if($init==1)
        $(document).ready(function() {

          $('#discountable').on('change', function() {

  var ae = document.getElementById("discountable").value;
            
            if (ae == '1') {

               
             document.getElementById("discount_amount").disabled = true;
        document.getElementById("discount_percentage").disabled = true;      
                
                document.getElementById("discountable").value = '';



            }
            if (ae == '') {

        
                document.getElementById("discount_amount").disabled = false;
              
            
                document.getElementById("discount_percentage").disabled = false;
                   document.getElementById("discountable").value = 1;
              
               
            }

});
})
@endif

// Enable-Disable text input when checkbox is checked or unchecked

    </script>


     <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/> 

@endpush
