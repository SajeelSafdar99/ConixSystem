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
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Voucher Types</h6>
           <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>
@if($init==1)
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a></li>
  <li><a href="{{ url('finance-and-management/finance-vouchers-submodules/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('finance-and-management/finance-voucher-types') }}">Voucher Types List</a></li>
  <li><a href>Edit Voucher Types</a></li>
</ul>
@else
<ul class="breadcrumbee mg-b-25 border-bottom-custom">
 <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
  <li><a href="{{ url('finance-and-management/finance-vouchers-submodules') }}">Vouchers</a></li>
  <li><a href="{{ url('finance-and-management/finance-vouchers-submodules/definitions') }}">Definitions</a></li>
  <li><a href="{{ url('finance-and-management/finance-voucher-types') }}">Voucher Types List</a></li>
  <li><a href>Add Voucher Types</a></li>
</ul>
@endif

<div class="col-xl-12">
    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif 
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif
    
    
    @if($init==1)
    <form method="post" action="{{ url('finance-and-management/finance-voucher-types/update') }}/{{ $voucher_type_update->id }}">
     @else
    <form method="post">
    @endif     
    @csrf   
            
              <div class="form-layout form-layout-4 ">
                <div class="desktop-screen-design">
              
                <div class="row">
                  <label class="col-sm-4 form-control-label">Type: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
   <input name="desc" type="text" class="form-control input-height" placeholder="Enter Type of Voucher" value="@if($init==0){{old('desc')}}@else{{old('desc',$voucher_type_update->desc)}}@endif">
                  </div>
                </div>


                <div class="row mg-t-10">
                    <label class="col-sm-4 form-control-label">Category: <span class="tx-danger">*</span></label>
                  <div class="col-sm-2 mg-t-10 mg-sm-t-0">         
   @if($init==1)
<input type="checkbox" name="debit" @if(old('debit',$voucher_type_update->debit)=='1') checked @endif value="1">
 <label for="debit">Debit</label>
   @else
<input type="checkbox" name="debit" @if(old('debit')=='1') checked @endif value="1">
 <label for="debit">Debit</label>
@endif
                  </div>

<div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    
  @if($init==1)
<input type="checkbox" name="credit" @if(old('credit',$voucher_type_update->credit)=='1') checked @endif value="1">
 <label for="credit">Credit</label>
   @else
<input type="checkbox" name="credit" @if(old('credit')=='1') checked @endif value="1">
 <label for="credit">Credit</label>
@endif
                  </div>


                </div>

<!-- 
    <div class="row mg-t-10">
                    <label class="col-sm-4 form-control-label">Category: <span class="tx-danger">*</span></label>
                  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                 
   @if($init==1)

   <input type="checkbox" class="category" name="category[]" @if(old('category[]',$voucher_type_update->category)=="Debit") checked @endif value="Debit">
      <label for="category">Debit</label>

   @else
   <input @if(old('category[]')=='Debit') checked @endif type="checkbox" class="category" name="category[]" value="Debit">
   <label for="category">Debit</label>
   @endif
                  </div>

<div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    
   @if($init==1)

   <input type="checkbox" class="category" name="category[]" @if(old('category[]',$voucher_type_update->category)=="Credit") checked @endif value="Credit">
<label for="category">Credit</label>
   @else
   <input @if(old('category[]')=='Credit') checked @endif type="checkbox" class="category" name="category[]" value="Credit">
<label for="category">Credit</label>
   @endif
                  </div>


                </div> -->

                

    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label">
                    Status: 
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <select @if ($errors->has('status')) style="border-color:red;" @endif class="form-control" name="status" value="@if($init==0){{old('status')}}@else{{old('status',$voucher_type_update->status)}}@endif">

                                @if($init==1)

                                <option @if($init==0) selected="" @else @if(old('status',$voucher_type_update->status)=='1') selected @endif @endif value="1">
                                    Active
                                </option>
                                <option @if(old('status',$voucher_type_update->status)=='0') selected @endif value="0">
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
                    </div>

 @if($init==1)
<div class="row mg-t-10">
             	 <label class="col-sm-4 form-control-label"></label>
             	 &nbsp&nbsp
                <div class="form-layout-footer mg-t-30">

                  <button type="input" name="save" class="btn btn-info">Update</button>
                  &nbsp&nbsp
                  <a href="{{ url('finance-and-management/finance-voucher-types') }}" class="btn btn-secondary">Cancel</a>
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
                  <a href="{{ url('finance-and-management/finance-voucher-types') }}" class="btn btn-secondary">Cancel</a>
                 
                </div><!-- form-layout-footer -->
            </div>   
  @endif          
              </div><!-- form-layout -->
            </div><!-- col-6 -->
          </form>
            </div>

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->


@endsection
