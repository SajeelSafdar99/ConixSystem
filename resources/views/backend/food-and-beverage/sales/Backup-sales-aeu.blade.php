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

.rcorners2 {
  border-radius: 25px;
  border: 2px solid #f1f1f1;
  padding: 15px; 
  width: 150px;
  height: 50px;  
  cursor: pointer;
}
.rcorners1 {
  border: 2px solid #f1f1f1;
  padding: 35px; 
  width: 150px;
  height: 110px;  
  cursor: pointer;
   font-size: 16px;
}

.waiterdiv {
  border: 2px solid #f1f1f1;
  padding: 25px; 
  width: 160px;
  height: 80px;  
  cursor: pointer;
   font-size: 16px;
}

.tabledefs {
  border: 2px solid #f1f1f1;
  padding: 15px; 
  width: 50px;
  height: 50px;  
  cursor: pointer;
   font-size: 16px;
}


.headingsettings {
            color: black!important;
            
        }
div.groove {border-style: groove !important; height: 160px !important;}

.itemname{text-transform: uppercase; }

.blackcolor{
 color: black; 
}

.bordered{
   border-radius: 25px;
  background-color: #23BF08;
  border: 2px solid #23BF08;
   color: white;
}

.bordered1{
  background-color: #23BF08;
  border: 2px solid #23BF08;
   color: white;
}
  .header {
  background-color: #f1f1f1;
  text-align: center;
  font-size: 18px;
  color:black;
  width: 100%;
}
</style>

<div class="br-pagebody">
        <div>
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Item Definitions</h6>
         <div style="text-align: right;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>

@if($init==1)
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/item-definitions') }}">Item Definitions List</a></li>
  <li><a href>Edit Item Definition</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 mg-lg-b-50 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('food-and-beverage') }}">Food & Beverage</a></li>
  <li><a href="{{ url('food-and-beverage/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('food-and-beverage/item-definitions') }}">Item Definitions List</a></li>
  <li><a href>Add Item Definition</a></li>
</ul>
@endif


           <div class="col-xl-12 ">
@if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
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
              
                   <div class="row">
               <div class="col-sm-4">
 <div class="form-layout form-layout-4 blackcolor">

 <div class="row">
   <div class="header"><b>TABLES</b></div>
   </div>

   <div class="row" id="table_definition">
    @if($tables)

  @php $divide=0; @endphp

   @foreach($tables as $table)
    @if($divide==-1) <div class="row">  @endif
    <div class="col-md-2 tabledefs">
                  {{$table->desc}}
                </div> 
    @if($divide==-1) </div>  @endif
    @php $divide++; @endphp
  @endforeach
@endif
</div>

<br>

   <div class="row">
   <div class="header"><b>CAPTAINS / ORDER TAKERS</b></div>
   </div>

   <div class="row">
    @if($waiters)

  @php $divide=0; @endphp

   @foreach($waiters as $waiter)
    @if($divide==-1) <div class="row">  @endif
    <div class="col-md-4 waiterdiv waiter">
                  {{$waiter->name}}
                </div> 
    @if($divide==-1) </div>  @endif
    @php $divide++; @endphp
  @endforeach
@endif
</div>

   <br>
  <br>  <br>  <br>  <br>

  <div class="row">
   <div class="header"><b>ORDER TYPE</b></div>
   </div>
   <div class="row">
   <div class="col-md-4 rcorners1 ordertype">
    Dine-In
   </div>
   <div class="col-md-4 rcorners1 ordertype">
   Take Away
   </div>
    <div class="col-md-4 rcorners1 ordertype">
    Home Delivery
   </div>
   </div>


 <br>


  <div class="row">
   <div class="header"><b>PAYMENT MODE</b></div>
   </div>
   <div class="row">
   <div class="col-md-4 rcorners1 paymentmode">
    Cash
   </div>
   <div class="col-md-4 rcorners1 paymentmode">
    Credit Card
   </div>
    <div class="col-md-4 rcorners1 paymentmode">
   Other
   </div>
   </div>


    </div>
              </div>


               <div class="col-sm-4">

                 <div class="form-layout form-layout-4 blackcolor">

                  <div class="row">
                  <label class="col-sm-2 form-control-label headingsettings">Restaurant:</label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('restaurant_location')) style="border-color:red;" @endif  id="restaurant_location" name="restaurant_location" class="form-control select2" onchange="restaurantselect(this.id)">
                                <option label="Choose Option">
                                </option>
                                @foreach($restaurants as $restaurant)
                                @if($init==1)
                                <option @if(old('restaurant_location',$sales_update->restaurant_location)==$restaurant->id) selected @endif value="{{$restaurant->id}}">
                                    {{$restaurant->desc}}
                                </option>
                                @else
                                <option @if(old('restaurant_location')==$restaurant->id)  selected @endif value="{{ $restaurant->id }}">
                                    {{$restaurant->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  
              </div>

              <br>

                <div class="form-layout form-layout-4 blackcolor">

                  <div class="row">
                  <label class="col-sm-2 form-control-label headingsettings">Category:</label>
                  <div class="col-sm-10 mg-t-10 mg-sm-t-0">
                    <select @if ($errors->has('category')) style="border-color:red;" @endif  id="category" name="category" class="form-control select2" onchange="itemcategoryselect(this.id)">
                                <option label="Choose Option">
                                </option>
                                @foreach($mains as $main)
                                @if($init==1)
                                <option @if(old('category',$sales_update->category)==$main->id) selected @endif value="{{$main->id}}">
                                    {{$main->desc}}
                                </option>
                                @else
                                <option @if(old('category')==$main->id)  selected @endif value="{{ $main->id }}">
                                    {{$main->desc}}
                                </option>
                                @endif
                                @endforeach
                               
                            </select>
                  </div>
                </div>  
<br>

<div class="row" id="sub_category">
  @if($subcats)

  @php $divide=0; @endphp
                 @foreach($subcats as $subcat)
    @if($divide==-1) <div class="row">  @endif
      <div class="trashitem">
                 <div class="rcorners2">
                  {{$subcat->desc}}
                  <input type="hidden" name="subcatinput" id="subcatinput" value="{{$subcat->id}}">
                </div> 
              </div>
    @if($divide==-1) </div>  @endif
    @php $divide++; @endphp
  @endforeach

  @else 
  No Sub-Categories Available !
  @endif
</div>
 

                 

                </div>
              </div>
               <div class="col-sm-4">
                 
                 <div class="form-layout form-layout-4" >
                   <div class="header"><b>ITEMS</b></div>
                   <div id="item_id">
                  @foreach($itemdefs as $itemdef)
                  <div class="form-layout form-layout-4 blackcolor">
                    {{$itemdef->item_code}}.
                    <span class="itemname"><b>{{$itemdef->item_details}}</b>
                    <br>
                    Rs. {{$itemdef->sale_price}}
                    </span>
                  </div>
                  @endforeach
                 </div>
               </div>
              </div> 
              </div>

           
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
    url : '{{ url('food-and-beverage/category/subcategory/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){
  if(data)
  {

console.log(data);

$('#sub_category').html('');
            $.each(data,function(x,y){

if(y.desc==''){
  let s='<div class="trashitem"><div class="rcorners2" id="sub_category">No Sub-Categories Available !</div></div>';
 $('#sub_category').append(s);
}
else{
  let s='<div class="trashitem"><div class="rcorners2" id="sub_category">'+y.desc+'</div></div>';
 $('#sub_category').append(s);
}
      


                })
  }
  
}
   });

  }
  
</script>


<script type="text/javascript">

  function restaurantselect(idd){

  var idval=document.getElementById(idd).value;

    $.ajax({
    type : 'GET',
    url : '{{ url('food-and-beverage/restaurant/tables/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){
  if(data)
  {

console.log(data);

$('#table_definition').html('');
            $.each(data,function(x,y){

  let s='<div class="col-md-2 tabledefs">'+y.desc+'</div>';
 $('#table_definition').append(s);
      


                })
  }
  
}
   });

  }
  
</script>

<script type="text/javascript">
window.onload = function (event) {

    var myitem = document.querySelectorAll(".trashitem");
    console.log(myitem);
    for(h=0; h<myitem.length; h++){
        myitem[h].onclick = function(e){

          var myitem = document.querySelectorAll(".trashitem");

            for(h=0; h<myitem.length; h++){
                myitem[h].classList.remove("bordered");
            }

            this.classList.add("bordered");


             
var idval=document.getElementById("subcatinput").value;


    $.ajax({
    type : 'GET',
    url : '{{ url('food-and-beverage/subcategory/items/') }}/'+idval,
  headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
  success: function(data){
  if(data)
  {

console.log(data);

$('#item_id').html('');
            $.each(data,function(x,y){
  let s='<div class="form-layout form-layout-4 blackcolor">'+y.item_code+'<span class="itemname"><b>'+y.item_details+'</b><br>Rs.'+y.sale_price+'</span></div>';
 $('#item_id').append(s);



                })
  }
  
}
   });
    



        };
    }
};
</script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    var myitem = document.querySelectorAll(".ordertype");
    for(h=0; h<myitem.length; h++){
        myitem[h].addEventListener("click",function(e){
            var myitem = document.querySelectorAll(".ordertype");

            for(h=0; h<myitem.length; h++){
                myitem[h].classList.remove("bordered1");
            }

            this.classList.add("bordered1");

        });
    }
});
</script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    var myitem = document.querySelectorAll(".paymentmode");
    for(h=0; h<myitem.length; h++){
        myitem[h].addEventListener("click",function(e){
            var myitem = document.querySelectorAll(".paymentmode");

            for(h=0; h<myitem.length; h++){
                myitem[h].classList.remove("bordered1");
            }

            this.classList.add("bordered1");

        });
    }
});
</script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    var myitem = document.querySelectorAll(".waiter");
    for(h=0; h<myitem.length; h++){
        myitem[h].addEventListener("click",function(e){
            var myitem = document.querySelectorAll(".waiter");

            for(h=0; h<myitem.length; h++){
                myitem[h].classList.remove("bordered1");
            }

            this.classList.add("bordered1");

        });
    }
});
</script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    var myitem = document.querySelectorAll(".tabledefs");
    for(h=0; h<myitem.length; h++){
        myitem[h].addEventListener("click",function(e){
            var myitem = document.querySelectorAll(".tabledefs");

            for(h=0; h<myitem.length; h++){
                myitem[h].classList.remove("bordered1");
            }

            this.classList.add("bordered1");

        });
    }
});
</script>

@endpush