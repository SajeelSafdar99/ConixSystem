<!--
@if($init==1)

  <div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                          Total Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input type="number"
                                                               @if ($errors->has('final_total')) style="border-color:red;"
                                                               @endif id="final_total"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('final_total')}}@else{{old('final_total',$invoice_update->total)}}@endif"
                                                               name="final_total">
</div>

        <label class="col-sm-1 form-control-label">Discount Amount: </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
            <input type="number"
                                                               @if ($errors->has('discount_amount')) style="border-color:red;"
                                                               @endif id="discount_amount"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$invoice_update->discount_amount)}}@endif" name="discount_amount" oninput="subtract_discount()">

                                                    </div>



                                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number"
                                                               @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('discount_percentage')}}@else{{old('discount_percentage',$invoice_update->discount_percentage)}}@endif" name="discount_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                   <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="discountDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="discount_div">
                                                <textarea
                                                            @if ($errors->has('discount_details')) style="border-color:red;"
                                                            @endif id="discount_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="discount_details">@if($init==0){{old('discount_details')}}@else{{old('discount_details',$invoice_update->discount_details)}}@endif</textarea>
</div>







                                                 </div>


  <div class="row mg-t-10">
   <label class="col-sm-1 form-control-label">
                                        Grand Total:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                                 <input type="number"
                                                               @if ($errors->has('grand_total')) style="border-color:red;"
                                                               @endif id="grand_total" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$invoice_update->grand_total)}}@endif"
                                                               name="grand_total">
</div>



      <label class="col-sm-1 form-control-label"> Overdue Charges:</label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" >
            <input type="number" @if ($errors->has('extra_charges')) style="border-color:red;"
                                                               @endif id="extra_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('extra_charges')}}@else{{old('extra_charges',$invoice_update->extra_charges)}}@endif" name="extra_charges" oninput="subtract_discount()">

                                                    </div>


                                                   <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number"
                                                               @if ($errors->has('extra_percentage')) style="border-color:red;"
                                                               @endif id="extra_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('extra_percentage')}}@else{{old('extra_percentage',$invoice_update->extra_percentage)}}@endif" name="extra_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="ExtraDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="extra_div">
                                           <textarea
                                                            @if ($errors->has('extra_details')) style="border-color:red;"
                                                            @endif id="extra_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="extra_details">@if($init==0){{old('extra_details')}}@else{{old('extra_details',$invoice_update->extra_details)}}@endif</textarea>
</div>
</div>


  <div class="row mg-t-10">


<label class="col-sm-1 form-control-label">
                                        Amt in Words:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                     <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$invoice_update->amount_in_words)}}@endif">
</div>



  <label class="col-sm-1 form-control-label"> Tax Charges: </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" >
           <input type="number" @if ($errors->has('tax_charges')) style="border-color:red;"
                                                               @endif id="tax_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('tax_charges')}}@else{{old('tax_charges',$invoice_update->tax_charges)}}@endif" name="tax_charges" oninput="subtract_discount()">

                                                    </div>

           <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number" @if ($errors->has('tax_percentage')) style="border-color:red;"
                                                               @endif id="tax_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('tax_percentage')}}@else{{old('tax_percentage',$invoice_update->tax_percentage)}}@endif" name="tax_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="TaxDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="tax_div">
                                             <textarea
                                                            @if ($errors->has('tax_details')) style="border-color:red;"
                                                            @endif id="tax_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="tax_details">@if($init==0){{old('tax_details')}}@else{{old('tax_details',$invoice_update->tax_details)}}@endif</textarea>
</div>




                                                 </div>

@endif
 -->




 ADD FORM :-


 <!--
@if($init==1)

  <div class="row mg-t-10">



              <label class="col-sm-1 form-control-label">
                                          Total Charges:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                            <input type="number"
                                                               @if ($errors->has('final_total')) style="border-color:red;"
                                                               @endif id="final_total"
                                                               class="form-control input-height" readonly
                                                               style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('final_total')}}@else{{old('final_total',$invoice_update->total)}}@endif"
                                                               name="final_total">
</div>

        <label class="col-sm-1 form-control-label">Discount Amount: </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
            <input type="number"
                                                               @if ($errors->has('discount_amount')) style="border-color:red;"
                                                               @endif id="discount_amount"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('discount_amount')}}@else{{old('discount_amount',$invoice_update->discount_amount)}}@endif" name="discount_amount" oninput="subtract_discount()">

                                                    </div>



                                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number"
                                                               @if ($errors->has('discount_percentage')) style="border-color:red;"
                                                               @endif id="discount_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('discount_percentage')}}@else{{old('discount_percentage',$invoice_update->discount_percentage)}}@endif" name="discount_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                   <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="discountDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="discount_div">
                                                <textarea
                                                            @if ($errors->has('discount_details')) style="border-color:red;"
                                                            @endif id="discount_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="discount_details">@if($init==0){{old('discount_details')}}@else{{old('discount_details',$invoice_update->discount_details)}}@endif</textarea>
</div>







                                                 </div>


  <div class="row mg-t-10">
   <label class="col-sm-1 form-control-label">
                                        Grand Total:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                                 <input type="number"
                                                               @if ($errors->has('grand_total')) style="border-color:red;"
                                                               @endif id="grand_total" class="form-control input-height"
                                                               readonly style="background-color: #c1c1c1"
                                                               value="@if($init==0){{old('grand_total')}}@else{{old('grand_total',$invoice_update->grand_total)}}@endif"
                                                               name="grand_total">
</div>



      <label class="col-sm-1 form-control-label"> Overdue Charges:</label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" >
            <input type="number" @if ($errors->has('extra_charges')) style="border-color:red;"
                                                               @endif id="extra_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('extra_charges')}}@else{{old('extra_charges',$invoice_update->extra_charges)}}@endif" name="extra_charges" oninput="subtract_discount()">

                                                    </div>


                                                   <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number"
                                                               @if ($errors->has('extra_percentage')) style="border-color:red;"
                                                               @endif id="extra_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('extra_percentage')}}@else{{old('extra_percentage',$invoice_update->extra_percentage)}}@endif" name="extra_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="ExtraDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="extra_div">
                                           <textarea
                                                            @if ($errors->has('extra_details')) style="border-color:red;"
                                                            @endif id="extra_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="extra_details">@if($init==0){{old('extra_details')}}@else{{old('extra_details',$invoice_update->extra_details)}}@endif</textarea>
</div>
</div>


  <div class="row mg-t-10">


<label class="col-sm-1 form-control-label">
                                        Amt in Words:
                                                        <span class="tx-danger">
                                *
                            </span>
                                                    </label>
                                                     <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                     <input @if ($errors->has('amount_in_words')) style="border-color:red;" @endif type="text" readonly style="background-color: #c1c1c1" id="amount_in_words" name="amount_in_words" autocomplete="off" class="form-control input-height" value="@if($init==0){{old('amount_in_words')}}@else{{old('amount_in_words',$invoice_update->amount_in_words)}}@endif">
</div>



  <label class="col-sm-1 form-control-label"> Tax Charges: </label>

                                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" >
           <input type="number" @if ($errors->has('tax_charges')) style="border-color:red;"
                                                               @endif id="tax_charges"
                                                               class="form-control input-height"
                                                               placeholder="Enter Amount"
                                                               value="@if($init==0){{old('tax_charges')}}@else{{old('tax_charges',$invoice_update->tax_charges)}}@endif" name="tax_charges" oninput="subtract_discount()">

                                                    </div>

           <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">

            <input type="number" @if ($errors->has('tax_percentage')) style="border-color:red;"
                                                               @endif id="tax_percentage"
                                                               class="form-control input-height"
                                                               value="@if($init==0){{old('tax_percentage')}}@else{{old('tax_percentage',$invoice_update->tax_percentage)}}@endif" name="tax_percentage" oninput="d_percentage()">

                                                    </div>

                                                    <label class="col-sm-1 form-control-label">
                                          Details:

                                                    </label>
                                                    <div class="padtheicon"><i style="size: 5px;" class="fas fa-info-circle" onclick="TaxDetails()"></i></div>
                                                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" id="tax_div">
                                             <textarea
                                                            @if ($errors->has('tax_details')) style="border-color:red;"
                                                            @endif id="tax_details" class="form-control"
                                                            placeholder="Give any details" rows="2" type="text"
                                                            name="tax_details">@if($init==0){{old('tax_details')}}@else{{old('tax_details',$invoice_update->tax_details)}}@endif</textarea>
</div>




                                                 </div>

@endif
 -->