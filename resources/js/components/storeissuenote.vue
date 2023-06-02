<template>
    <div>
        <vue-snotify></vue-snotify>
        <div v-if="showCancellationModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">Item Cancellation Form:</h5>
                                    <button type="button" class="close" @click="showCancellationModal=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Item:</label>
                                        </div>
                                        <div class="col-md-6 text-uppercase">
                                            <strong>{{this.selected_items[active_el].item_details}}</strong>
                                        </div>
                                        <div class="col-md-3 text-uppercase">
                                            <strong>({{this.selected_items[active_el].qty}})</strong>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Qty:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" min="1" @input="alternativeqtyrestrict()" placeholder="Change the original Qty." v-model="alternativeqty" class="form-control input-height ">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Remark:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select v-model="sCancelledRemark" id="cancelledremarks" name="cancelledremarks" class="form-control">
                                                <option v-for="cancelled in cancelled_remarks" :value="cancelled.desc">
                                                    {{cancelled.desc}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="rdiobox">
                                                <input type="radio" name="aftercancel" v-model="aftercancel" value="Void"><span class="pabs">Void</span></label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="rdiobox">
                                                <input type="radio" name="aftercancel" v-model="aftercancel" value="Return"><span class="pabs">Return</span>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="rdiobox">
                                                <input type="radio" name="aftercancel" v-model="aftercancel" value="Complementary"><span class="pabs">Complementary</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" @click="canceldone();">Done</button>
                                    <button type="button" class="btn btn-secondary" @click="showCancellationModal=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="row">
            <div class="col-sm-11">



                <div class="row mg-t-10">

                    <label class="col-sm-1 form-control-label">Issue Note #:  <span class="tx-danger">  * </span>  </label>
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <input type="text" class="form-control input-height" id="invoice_no" v-model="invoice_no" value="1" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                    </div>


                    <label class="col-sm-1 form-control-label">
                        Issue Note Date:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <datepicker   v-model="invoice_date" :clear-button="true" placeholder="dd/mm/yyyy" format="dd/MM/yyyy" input-class="form-control" name="invoice_date"></datepicker>
                       <!-- <input type="text" v-model="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="14/04/2020" readonly="" style="background-color: #c1c1c1">-->

                    </div>




                </div>

                <div class="row mg-t-10">
                    <label class="col-sm-1 form-control-label"> Company: <span class="tx-danger">  *  </span> </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select id="company" v-model="company"  class="form-control  ">
                          <!--  <option label="Choose Company" value="0">  </option>-->
                            <option :value="com.code" v-for="com in companies">
                                {{com.name}}
                            </option>
                        </select>
                    </div>

                    <label class="col-sm-1 form-control-label"> Store: <span class="tx-danger">  *  </span> </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select id="store_location" v-model="store_location" class="form-control  ">
                            <option v-if="cat_permission.indexOf('Store'+' '+loc.desc+' '+loc.id)!=-1" :value="loc.id" v-for="loc in locations">
                                {{loc.desc}}
                            </option>
                        </select>
                    </div>

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select id="department" v-model="department" class="form-control ">
                            <option label="Choose Department" value="">  </option>
                            <option :value="dep.id" v-for="dep in departments.filter((a)=>{return a.location==this.store_location})">
                                {{dep.desc}}
                            </option>
                        </select>
                    </div>
                 <!--   <label class="col-sm-1 form-control-label"> Company: <span class="tx-danger">  *  </span> </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="unitsearch"     name="unitsearch" placeholder="Search Unit...">
                            <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="unitsearchid"     name="unitsearchid" placeholder="Search by Unit...">
                            <ul id="areabox4" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.unitsearch && searchedunits.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>
                    </div>-->



<!--                    <label class="col-sm-1 form-control-label"> Issued To: <span class="tx-danger">  *  </span> </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select id="store_location" v-model="selected_items[active_el].store_location"  class="form-control  ">
                            <option label="Choose Location" :value="undefined">  </option>
                            <option v-if="loc_permission.indexOf(loc.desc+' '+loc.id)!=-1" :value="loc.id" v-for="loc in locations.filter((a)=>{return a.unit==this.company})">
                                {{loc.desc}}
                            </option>
                        </select>
                    </div>

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select id="department" v-model="selected_items[active_el].department" class="form-control ">
                            <option label="Choose Department" :value="undefined">  </option>
                            <option :value="dep.id" v-for="dep in departments.filter((a)=>{return a.location==selected_items[active_el].store_location})">
                                {{dep.desc}}
                            </option>
                        </select>
                    </div>-->
                </div>

                <br>
<!--
                <div class="row mg-t-10">
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <select tabindex="6" id="sCategory" v-model="sCategory" class="form-control  ">
                        <option label="Choose Category" value="0">  </option>
                        <option v-if="cat_permission.indexOf('Store'+' '+cat.desc+' '+cat.id)!=-1" :value="cat.id" v-for="cat in mains">
                            {{cat.desc}}
                        </option>
                    </select>
                </div>
                    <template v-if="this.add_cat">  <a href="/food-and-beverage/item-categories/item-categories-aeu" target="popup" onclick="window.open('/food-and-beverage/item-categories/item-categories-aeu','popup','width=700,height=550'); return false;"><i class="fa fa-plus"></i></a> </template>

                    &nbsp&nbsp&nbsp&nbsp&nbsp

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <select tabindex="7" id="sSubCat" v-model="sSubCat" class="form-control  ">
                        <option label="Choose Sub-Category" value="0">  </option>
                        <option :value="sub.id" v-for="sub in subcats.filter((a)=>{return a.item_category==this.sCategory})">
                            {{sub.desc}}
                        </option>
                    </select>
                </div>
                    <template v-if="this.add_sub"> <a href="/food-and-beverage/item-sub-categories/item-sub-categories-aeu" target="popup" onclick="window.open('/food-and-beverage/item-sub-categories/item-sub-categories-aeu','popup','width=700,height=550'); return false;"><i class="fa fa-plus"></i></a> </template>

                    &nbsp&nbsp&nbsp&nbsp&nbsp

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <select tabindex="7" id="selecteditem" v-model="selecteditem" class="form-control " >
                        <option label="Choose Item" value="0">  </option>
                        <option :value="item" v-for="item in itemdefs">
                            {{item.item_code}} -
                            <span class="itemname"><b>{{item.item_details}}</b></span>
                            <br>
                            (Rs.  {{item.purchase_price}})
                        </option>
                    </select>
                </div>
                    <template v-if="this.add_item">  <a href="/food-and-beverage/item-definitions/item-definitions-aeu-vue" target="popup" onclick="window.open('/food-and-beverage/item-definitions/item-definitions-aeu-vue','popup','width=990,height=550'); return false;"><i class="fa fa-plus"></i></a> </template>

                </div>
-->

                <div class="row mg-t-10">
                    <label class="col-sm-3 form-control-label">Item:</label>
                    <label class="col-sm-1 form-control-label">Price:</label>
                    <label class="col-sm-1 form-control-label">Qty:</label>
                    <label class="col-sm-1 form-control-label">Unit:</label>
                    <label class="col-sm-3 form-control-label">Instructions:</label>
                    <label class="col-sm-1 form-control-label">Current Stock:</label>
                </div>
                <div class="row mg-t-10">
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="search"  v-on:keydown.up.enter.prevent="itemsdatavalueEnter(search)" tabindex="1" name="search" placeholder="Search by Item Name / Code...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searcheditemsdefs.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="itemsdatavalue(itd.id)" v-for="(itd,key) in searcheditemsdefs">
                                    <a href="javascript:void(0)"> {{itd.item_code}} - {{itd.item_details}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                     <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="selected_items[active_el].old_purchase_price"  v-on:keydown.up.enter.prevent="pprefres" @focus="$event.target.select()" name="old_purchase_price" id="old_purchase_price" tabindex="2" type="number" placeholder="Price">
                    </div>
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input @input="enterquantity(active_el)" class="form-control"  v-on:keyup.enter="refres" v-model="selected_items[active_el].qty" @focus="$event.target.select()" name="quantity" id="quantity" tabindex="3" type="number" placeholder="Qty.">
                    </div>
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%">
                        <select tabindex="4" id="unit" v-model="selected_items[active_el].unit" name="unit" class="form-control">
                            <option label="Choose Option" :value="undefined"></option>
                            <option :value="measurement_unit.id" v-for="measurement_unit in measurement_units">
                                {{ measurement_unit.code }}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="selected_items[active_el].instructions" name="instructions" id="instructions"  tabindex="5"   type="text" placeholder="Instructions">
                    </div>

                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <input type="text" v-model="current_stock" id="current_stock" class="form-control input-height"   readonly="" style="background-color: #c1c1c1">
                        <!-- <input type="text" v-model="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="14/04/2020" readonly="" style="background-color: #c1c1c1">-->

                    </div>
                   <!-- <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="selected_items[active_el].purchase_price" v-on:keyup.enter="refres" name="price" id="price" tabindex="4" type="number" placeholder="Price">
                    </div>-->
                   <!-- <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%">
                        <input class="form-control" type="text" readonly :value="(selected_items[active_el].qty*selected_items[active_el].purchase_price).toFixed(1)">
                    </div>-->
                </div>
<!--                <div class="row mg-t-10">
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input @input="enterquantity(active_el)" class="form-control" v-model="quantity" name="quantity" id="quantity" tabindex="1" type="number" placeholder="Qty.">
                    </div>
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="price" name="price" id="price" tabindex="2" type="number" placeholder="Price">
                    </div>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="instructions" name="instructions" id="instructions" tabindex="3" type="text" placeholder="Instructions">
                    </div>

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="search" tabindex="4" v-on:keyup.enter="itemsdatavalueEnter(search)"  name="search" placeholder="Search by Item Name / Code...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searcheditemsdefs.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="itemsdatavalue(itd.id)" v-for="(itd,key) in searcheditemsdefs">
                                    <a href="javascript:void(0)"> {{itd.item_code}} - {{itd.item_details}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                <!-- row -->



                <div class="clearfix"></div>
                <div class="form-layout form-layout-4 blackcolor">
                        <div>
                            <button v-if="!this.id" @click="removetr(active_el);" class="btn btnfont"><b>/</b></button>
                            <button @click="updatetrplus(active_el);" class="btn btnfont"><b>+</b></button>
                            <button @click="updatetrminus(active_el)" class="btn btnfont"><b>-</b></button>
                            <template v-if="this.cancelpermit && this.id">
                                <button @click="updatetrstatus(active_el)" class="btn btnfont"><i class="fa fa-times"></i></button>
                            </template>
                        </div>
                    <div class="scrollclasstable1" :class="{scrollclasstable2: this.selected_items.length>0 }">
                        <div>
                            <table>
                                <thead :style="'font-size:16px'">
                                <tr bgcolor="#5f9ea0">

                                    <th class="wd-5p">SR #</th>
                                    <th class="wd-5p">CODE</th>
                                    <th class="wd-20p">ITEM</th>
                                    <th class="wd-5p">UNIT</th>
                                  <!--  <th class="wd-5p">CURRENT STOCK</th>-->
                                    <th class="wd-5p">ISSUED STOCK</th>
                                    <th class="wd-5p">QTY</th>
                                    <th class="wd-10p">PRICE</th>
                                 <!--   <th class="wd-10p">PURCHASE PRICE</th>-->
                               <th class="wd-10p">SUB-TOTAL</th>
                                    <th class="wd-15p">INSTRUCTIONS</th>
<!--                                    <th class="wd-10p">LOCATION</th>
                                    <th class="wd-10p">DEPARTMENT</th>-->
                                    <th class="wd-5p">STATUS</th>
                                    <th class="wd-5p">REMARK</th>
                                    <th class="wd-5p">AFTER CANCELLATION</th>
                                </tr>
                                </thead>
                                <tbody :style="'font-size:15px'">
                                <tr  v-if="tr.item_code  && tr.qty!=0  && tr.hide==0" @click="activate(key)" :class="{ activatedtr : active_el == key }" v-for="(tr,key) in selected_items">
                                    <!--<td><i class="fa fa-trash"></i></td>-->
                                    <template v-if="id">
                                        <td>{{key+1}}</td>
                                    </template>
                                    <template v-else>
                                        <td>{{key}}</td>
                                    </template>
                                    <td>{{tr.item_code}}</td>
                                    <td><span style="display: block;
    width: 200px;
    text-overflow: ellipsis;
    overflow: hidden; " :title="tr.item_details">{{tr.item_details}}</span></td>
                                    <td>{{tr.unit!=0?measurement_units.filter(function(a){return a.id==tr.unit})[0].code:undefined}}</td>
                                 <!--   <td >{{tr.current_stock?tr.current_stock:0}}</td>-->
                                    <td >{{tr.opening_stock?tr.opening_stock:0}}</td>
                                    <td><!--<input style="background-color: transparent !important; color: black !important;" type="number" placeholder="Enter Amount" class="form-control input-height" v-model="tr.qty">-->
                                        {{tr.qty}} <input type="hidden" v-model="tr.hid">
                                    </td>

                                    <td >{{tr.old_purchase_price?tr.old_purchase_price:0}}</td>

                                   <!-- <td>{{tr.purchase_price}}&lt;!&ndash;<input style="background-color: transparent !important; color: black !important;" type="number" placeholder="Enter Amount" class="form-control input-height" v-model="tr.purchase_price">&ndash;&gt;</td>
                                   -->
                                  <td>{{tr.product=(tr.qty*tr.old_purchase_price).toFixed(1)}}</td>
                                    <td>{{tr.instructions}}<!--<input type="text" style="background-color: transparent !important; color: black !important;" placeholder="Type Here.." class="form-control input-height" v-model="tr.instructions">--></td>

                                    <!--                                    <td>{{tr.store_location?locations.filter(function(a){return a.id==tr.store_location})[0].desc:''}}</td>
                                    <td>{{tr.department?departments.filter(function(a){return a.id==tr.department})[0].desc:''}}</td>-->
                                    <td>{{tr.status}}</td>
                                    <td>{{tr.remark}}</td>
                                    <td>{{tr.aftercancel}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <br>


                <!--               <div class="row mg-t-10">


                                   <label class="col-sm-1 form-control-label">
                                       Gross:
                                       <span class="tx-danger">
                                               *
                                           </span>
                                   </label>
                                   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                       <input type="number" v-model="showinggross" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >

                                       <input type="hidden" v-model="gross" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >
                                   </div>

                                   <label class="col-sm-1 form-control-label">Discount: </label>

                                   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                       <input type="number" id="discount" v-model="discount" autocomplete="off" placeholder="Enter Amount" class="form-control input-height" value="" :disabled="discount_percentage!=0 || discount_percentage!=''">

                                   </div>



                                   <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">
                                       <input type="number" id="discount_percentage" class="form-control input-height" value="" v-model="discount_percentage" :disabled="discount!=0 ||discount!='' ">

                                   </div>


                               </div>
                               &lt;!&ndash; row &ndash;&gt;

                               <div class="row mg-t-10">
                                   <label class="col-sm-1 form-control-label">
                                       Grand Total:
                                       <span class="tx-danger">
                                               *
                                           </span>
                                   </label>
                                   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                       <input type="number" name="grand_total" class="form-control input-height" id="grand_total" autocomplete="off" readonly="" style="background-color: #c1c1c1" :value="Math.round(parseFloat(gross)-parseFloat(dis)+parseFloat(taxx)+parseFloat(adds))">
                                   </div>

                                   <label class="col-sm-1 form-control-label"> Tax: </label>

                                   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                       <input type="number" id="tax" v-model="tax" autocomplete="off" placeholder="Enter Amount" class="form-control input-height" value="" :disabled="tax_percentage!=0 || tax_percentage!=''">

                                   </div>



                                   <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">
                                       <input type="number" id="tax_percentage" class="form-control input-height" value="" v-model="tax_percentage" :disabled="tax!=0 ||tax!='' ">

                                   </div>


                               </div>


                               <div class="row mg-t-10">
                                   <label class="col-sm-1 form-control-label"> Amount in Words:
                                       <span class="tx-danger"> * </span>    </label>
                                   <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                       <input type="text" readonly="" style="background-color: #c1c1c1" id="amount_in_words" :value="toWords(parseFloat(gross)-parseFloat(dis)+parseFloat(taxx)+parseFloat(adds))" autocomplete="off" class="form-control input-height">
                                   </div>

                                   <label class="col-sm-1 form-control-label"> Additional Charges: </label>
                                   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                       <input type="number" id="additional_amt" v-model="additional_amt" autocomplete="off" placeholder="Enter Amount" class="form-control input-height" value="" :disabled="additional_per!=0 || additional_per!=''">

                                   </div>
                                   <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">
                                       <input type="number" id="additional_per" class="form-control input-height" value="" v-model="additional_per" :disabled="additional_amt!=0 ||additional_amt!='' ">

                                   </div>
                               </div>

               -->

                    <div class="row mg-t-10">
                        <label class="col-sm-1 form-control-label">
                            Gross:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                            <input type="number" v-model="showinggross" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >

                            <input type="hidden" v-model="gross" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >
                        </div>

                        <label class="col-sm-1 form-control-label">
                            Total Qty:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                            <input type="number" v-model="totalqty" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >
                         </div>

                        <label class="col-sm-1 form-control-label">
                            Remarks:
                        </label>
                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                            <textarea type="text" class="form-control" id="remarks" v-model="remarks" placeholder="Enter Details" autocomplete="off"></textarea>
                        </div>

                    </div>
                <!-- row -->




                <div class="float-left">
                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label"></label>

                        <div class="form-layout-footer mg-t-30">
                            <input @click="save_sales(id)"  :disabled="disabled" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn" value="Save"  :value="id?'Update':'Save'">


                            &nbsp;&nbsp;
                            <input @click="save_print(id)" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn"  :value="id?'Update &amp; Print':'Save &amp; Print'" value="">

                            &nbsp;&nbsp;
                            <a href="/store-management/store-issue-note-vue" class="btn btn-secondary">Cancel</a>

                        </div><!-- form-layout-footer -->
                    </div>
                </div><!-- form-layout -->
            </div>



        </div>
    </div>
</template>

<script>
export default {
    name: "storeissuenote",
    props: ['id','linking'],
    data(){

        return{
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            invoice_no:'',
            invoice_date:'',
            ledger_amount:'0',
            searcheditemsdefs:[],
            guest_name:'',
            family:0,
            families:[],
            search:'',
            locations:[],
            disabled:false,
            customer_id:'',
            gross:0,
            showinggross:0,
            totalqty:0,
            discount:'',
            discount_percentage:'',
            tax:'',
            tax_percentage:'',
            additional_amt:'',
            additional_per:'',
            grand_total:0,
            amount_in_words:'',
            remarks:'',
            customers:[],
            alreadySearched:false,
            customer:'',
            type:0,
            transChecked:[],
            dis:0,
            taxx:0,
            adds:0,
            cat_permission:'',
            loc_permission:'',
            itemalreadySearched:false,
            selected_items:[[]],
            tempo:[],
            quantity:'',
            price:'',
            instructions:'',
            active_el:0,
            sCategory:'0',
            sSubCat:'0',
            itemdefs:[],
            mains:[],
            subcats:[],
            selecteditem:'0',
           store_location:'1',
            department:'',
            idm:'',
            fkey:-1,
            ffkey:-1,
            departments:[],
         /*   store_location:'',
            department:'',*/
            add_cat:'',
            add_sub:'',
            add_item:'',
            cancelpermit:'',
            showCancellationModal: false,
            alternativeqty:'',
            cancelled_remarks:[],
            sCancelledRemark:'',
            aftercancel:'Void',
            measurement_units:[],
            unit:'',
            unitsearch:'',
            unitsearchid:'',
            searchedunits:[],
            ccs:[],
            company:'001-001',
            companies:[],
            current_stock:0,
        }
    },
    methods:{
        unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.unitsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.unitsearch=a.name})

                if(data){

                    this.searchedunits=data;

                }
            });
        },
        unitdatavalue(val,m){
            this.searchedunits=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/unitdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.unitalreadySearched=true;
                    this.unitsearch=data.name+' '+'('+this.ccs.filter(function(s){return s.code==data.desc})[0].name+')';
                    this.unitsearchid=data.code;

                }
            });
        },
        canceldone:function(){
            if(this.alternativeqty== this.selected_items[this.active_el].qty){
                if(this.alternativeqty!=''){
                    let save = (JSON.parse(JSON.stringify(this.selected_items[this.active_el])));
                    let myitem =this.selected_items[this.active_el];
                    let alter = this.selected_items[this.active_el].qty - this.alternativeqty;
                    myitem.hid=0;
                    myitem.status='Cancelled';
                    myitem.purchase_price=0;
                    myitem.qty=this.alternativeqty;
                    myitem.remark=this.sCancelledRemark;
                    myitem.aftercancel=this.aftercancel;
                    let clone = (JSON.parse(JSON.stringify(myitem)));
                    if(this.alternativeqty!=''){
                        if(alter!=0){
                            this.selected_items[this.active_el]= save;
                            this.selected_items[this.active_el].qty = alter;
                        }
                        else{
                            this.selected_items.splice(this.active_el,1);
                        }

                        this.selected_items.push(clone);
                    }
                    this.alternativeqty='';
                    this.sCancelledRemark=0;
                    this.aftercancel='Void';
                    this.showCancellationModal=false;
                }
            }
            else{
                if(this.alternativeqty!=''){
                    let save = (JSON.parse(JSON.stringify(this.selected_items[this.active_el])));
                    let myitem =this.selected_items[this.active_el];
                    let alter = this.selected_items[this.active_el].qty - this.alternativeqty;
                    myitem.hid=0;
                    myitem.status='Cancelled';
                    myitem.purchase_price=0;
                    myitem.qty=this.alternativeqty;
                    myitem.remark=this.sCancelledRemark;
                    myitem.aftercancel=this.aftercancel;
                    let clone = (JSON.parse(JSON.stringify(myitem)));
                    if(this.alternativeqty!=''){
                        //this.selected_items[this.active_el].qty=this.alternativeqty;
                        if(alter!=0){
                            // clone.qty=alter;
                            this.selected_items[this.active_el]= save;
                            this.selected_items[this.active_el].qty = alter;
                        }
                        else{
                            this.selected_items.splice(this.active_el,1);
                        }
                        this.selected_items.push(clone);

                    }
                    this.alternativeqty='';
                    this.sCancelledRemark=0;
                    this.aftercancel='Void';
                    this.showCancellationModal=false;
                }
            }
        },
        refres:function(){

         /*   this.selected_items.push(this.tempo[0]);
            this.active_el=this.selected_items.length-1;
*/

            this.selected_items[this.active_el].hide=0;

            this.search='';
            $('input[name="search"]').focus();
            this.active_el=this.selected_items.length-1;

        },
        pprefres:function(){
            this.timeout = setTimeout(() => {
                $('input[name="quantity"]').focus();
            }, 500);
        },
        fup(){

        },fdown(){
            console.log(1)

        },udf(event){

            if(event==0){
                if(this.fkey!=this.customers.length){

                    this.fkey=this.fkey+1
                }
                $('.fba'+this.fkey +' a').focus();

                // $('.fba'+this.fkey).focus();
                // event.preventDefault()
            }if(event==1){

                if(this.fkey!=-1){

                    this.fkey=this.fkey-1
                }
                $('.fba'+this.fkey+' a').focus();

                // event.preventDefault()
            }




        },udf2(event){

            if(event==0){
                if(this.ffkey!=this.searcheditemsdefs.length-1){

                    this.ffkey=this.ffkey+1
                }
                $('.ccs'+this.ffkey +' a').focus();

                // $('.fba'+this.ffkey).focus();
                // event.preventDefault()
            }if(event==1){

                if(this.ffkey!=0){

                    this.ffkey=this.ffkey-1
                }
                $('.ccs'+this.ffkey+' a').focus();

                // event.preventDefault()
            }




        },
        amIOnline(e) {
            this.onLine = e;
        },
        init:function (m) {
            let r='';
            if(m){
                r='?r='+m;
            }
            // console.log(m);
            this.$http.get(this.linking+'/store-management/store-issue-note/store-issue-note-aeu/init'+r).then(result=>{
                let data=result.data;
                // console.log(data);
                if(m){
                    this.company=data.invoice_no.unit;
                    this.selected_items=data.invoice_no.selected_items;
                    this.remarks=data.invoice_no.remarks;
                    this.store_location=data.invoice_no.store_location;
                    this.department=data.invoice_no.department;
                    this.discount=data.invoice_no.discount;
                    this.additional_amt=data.invoice_no.additional_charges;
                    this.tax=data.invoice_no.tax;
                    this.family=data.invoice_no.family;
                    this.type=data.invoice_no.type;
                    this.invoice_no=parseInt(data.invoice_no.id);
                    this.invoice_date=data.invoice_no.invoice_date;
                  /*  this.invoice_date=moment(data.invoice_no.invoice_date).format('DD/MM/YYYY');*/
                    let b=data.invoice_no.customer_id;
            /*        this.customerdatavalue(b,this.id);*/

                  /*  let a=data.invoice_no.unit;
                    this.unitdatavalue(a,this.id);*/
                }
                else{
                    this.invoice_no=data.invoice_no.id?parseInt(data.invoice_no.id)+1:1;

                    this.invoice_date=new Date();
                    /*this.invoice_date=moment().format('DD/MM/YYYY');*/
                    this.add_cat=data.invoice_no.add_cat;
                    this.add_sub=data.invoice_no.add_sub;
                    this.add_item=data.invoice_no.add_item;
                    this.predefined=data.invoice_no.predefined;
                    // console.log(data.invoice_no.predefined.store_location);
                     this.store_location=this.predefined.store_location?this.predefined.store_location:'1';
                    this.department=this.predefined.department?this.predefined.department:'';

                }
                // console.log(data);
                this.companies=data.invoice_no.companies;
                this.ccs=data.invoice_no.ccs;
                this.cat_permission=data.invoice_no.catspermit;
                this.loc_permission=data.invoice_no.locspermit;
                // console.log(this.cat_permission);
                this.locations=data.invoice_no.locations;
                this.departments=data.invoice_no.departments;
                this.mains=data.invoice_no.mains;
                this.cancelpermit=data.invoice_no.cancel_permit;
                this.cancelled_remarks=data.invoice_no.cancelled_remarks;
                this.measurement_units=data.invoice_no.measurement_units;
            })
        },
        save_to_selected:function(){
            if(this.quantity==''){
                this.quantity=1;
            }
            if(this.price==''){
                this.price=0;
            }
            if(this.quantity>0){
                let clone = (JSON.parse(JSON.stringify(this.selecteditem)));

                 if(this.store_location=='' || this.department=='') {alert('Please select Location & Department first !'); return 0}


             /*   if(this.selected_items[this.active_el].store_location==undefined || this.selected_items[this.active_el].department==undefined)
                {alert('Please select Location & Department to which the Item is being Issued !'); return 0}*/

                    else if(this.company==0)
                    {alert('Please select Company !'); return 0}
                    else{
                        clone.qty=this.quantity;
                        //  clone.purchase_price=this.price;
                        clone.instructions=this.instructions;
                        clone.store_location=this.selected_items[this.active_el].store_location;
                        clone.department=this.selected_items[this.active_el].department;
                        this.selected_items.push(clone);
                  //   this.active_el=this.selected_items.length-1;
                    }


               /* }*/

                this.quantity='';
                this.price='';
                this.instructions='';

            }
        },
        removetr:function(el){
            this.selected_items[this.active_el].qty=0;
            /*if(this.selected_items[this.active_el].saved!=1){
                this.selected_items.splice(this.active_el,1);
            }*/

        },
        updatetrplus:function(el){
            if(this.selected_items[this.active_el].saved!=1){
                this.selected_items[this.active_el].qty=this.selected_items[this.active_el].qty-2+3;
                /* this.selected_items[this.active_el].item_discount=parseFloat(this.selected_items[this.active_el].item_discount)+parseFloat(this.selected_items[this.active_el].item_discount);
                   */

            }
        },
        updatetrminus:function(el){
            if(this.selected_items[this.active_el].saved!=1){
                this.selected_items[this.active_el].qty=this.selected_items[this.active_el].qty-1;

                if(this.selected_items[this.active_el].qty==0)
                {
                    this.selected_items.splice(this.active_el,1);
                }

            }

        },
        alternativeqtyrestrict(){
            if(this.alternativeqty>this.selected_items[this.active_el].qty) this.alternativeqty=this.selected_items[this.active_el].qty;
        },
        updatetrstatus:function(el){
            this.showCancellationModal = true;
        },
        activate:function(el){
            this.active_el = el;
        },
        itemsdatavalue(val,m){
            this.searcheditemsdefs=[];
            let r='';
            this.ffkey=-1
            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/storeitemsdata?inv=1&MOC='+r,{theid:val, thedate:this.invoice_date, theunit:this.company, thestore: this.selected_items[this.active_el].store_location}).then(result=>{
                let data =result.data;
                if(data){
                    this.itemalreadySearched=true;
                    if(this.quantity==''){
                        this.quantity=1;
                    }
                    if(this.price==''){
                        this.price=0;
                    }
                    if(this.quantity>0){
                        let clone = (JSON.parse(JSON.stringify(data)));

                       if(this.store_location=='' || this.department=='') {alert('Please select Location & Department first !'); return 0}


                         /*   if(this.selected_items[this.active_el].store_location==undefined || this.selected_items[this.active_el].department==undefined)
                            {alert('Please select Location & Department to which the Item is being Issued !'); return 0}*/

                               else if(this.company==0)
                                {alert('Please select Company !'); return 0}
                                else {
                                    clone.qty = this.quantity;
                                    //   clone.purchase_price=this.price;
                                    clone.instructions = this.instructions;
                                    clone.store_location = this.selected_items[this.active_el].store_location;
                                    clone.department = this.selected_items[this.active_el].department;
                                    clone.hide=1;
                        //   this.tempo.push(clone);
                                     this.selected_items.push(clone);
                         this.active_el=this.selected_items.length-1;
                                }

                       /* }*/

                        this.quantity='';
                        this.price='';
                        this.instructions='';
                      this.search=clone.item_details;
                        $('input[name="old_purchase_price"]').focus();
                    //    $('#old_purchase_price').focus();
                    }

                }
            });

            this.$http.post('/search/storeissueitemsdatacs?inv=1&MOC='+r,{theid:val, thedate:this.invoice_date, theunit:this.company, thestore: this.selected_items[this.active_el].store_location}).then(result=>{
                let data =result.data;
                if(data){

                   this.current_stock = data.current_stock?data.current_stock:0;
                    if(this.current_stock==0 || this.current_stock<0){
                        alert('Current Stock is 0. Item cannot be selected !');

                        this.axios.post('/search/storeitemsdata?inv=1&MOC=' + r, {
                            theid: val,
                            thedate: this.invoice_date,
                            theunit: this.company,
                            thestore: this.selected_items[this.active_el].store_location
                        }).then(result => {
                            this.selected_items.splice(this.active_el,1);
                            this.search='';
                            $('input[name="search"]').focus();
                            this.active_el=this.selected_items.length-1;
                        });
                    }

                }
            });
            if(this.current_stock!=0 || this.current_stock>0) {
                this.axios.post('/search/storeitemsdata?inv=1&MOC=' + r, {
                    theid: val,
                    thedate: this.invoice_date,
                    theunit: this.company,
                    thestore: this.selected_items[this.active_el].store_location
                }).then(result => {
                    $('#old_purchase_price').focus();
                });
            }

        },
        itemsdatavalueEnter(val,m){
            this.searcheditemsdefs=[];
            let r='';
            this.ffkey=-1
            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/storeitemsdata?inv=1&MOC='+r,{theid:val, thedate:this.invoice_date}).then(result=>{
                let data =result.data;
                if(data){
                    this.itemalreadySearched=true;
                    if(this.quantity==''){
                        this.quantity=1;
                    }
                    if(this.price==''){
                        this.price=0;
                    }
                    if(this.quantity>0){
                        let clone = (JSON.parse(JSON.stringify(data)));
                        if(this.store_location=='' || this.department=='') {alert('Please select Location & Department first !'); return 0}

                         /*   if(this.selected_items[this.active_el].store_location==undefined || this.selected_items[this.active_el].department==undefined)
                            {alert('Please select Location & Department to which the Item is being Issued !'); return 0}*/

                                else if(this.company==0)
                                {alert('Please select Company !'); return 0}
                                else {
                                    clone.qty = this.quantity;
                                    //   clone.purchase_price=this.price;
                                    clone.instructions = this.instructions;
                                    clone.store_location = this.selected_items[this.active_el].store_location;
                                    clone.department = this.selected_items[this.active_el].department;
                            clone.hide=1;
                        //    this.tempo.push(clone);
                                 this.selected_items.push(clone);
                            this.active_el=this.selected_items.length-1;



                                }

                       /* }*/
                        this.quantity='';
                        this.price='';
                        this.instructions='';
                        this.search=clone.item_details;
                        $('input[name="old_purchase_price"]').focus();
                    }
                }
            });

            this.$http.post('/search/storeissueitemsdatacs?inv=1&MOC='+r,{theid:val, thedate:this.invoice_date, theunit:this.company, thestore: this.selected_items[this.active_el].store_location}).then(result=>{
                let data =result.data;
                if(data){

                    this.current_stock = data.current_stock?data.current_stock:0;

                    if(this.current_stock==0 || this.current_stock<0){
                        alert('Current Stock is 0. Item cannot be selected !');

                        this.axios.post('/search/storeitemsdata?inv=1&MOC=' + r, {
                            theid: val,
                            thedate: this.invoice_date,
                            theunit: this.company,
                            thestore: this.selected_items[this.active_el].store_location
                        }).then(result => {
                            this.selected_items.splice(this.active_el,1);
                            this.search='';
                            $('input[name="search"]').focus();
                            this.active_el=this.selected_items.length-1;
                        });
                    }

                }
            });
            if(this.current_stock!=0 || this.current_stock>0) {
                this.$http.axios('/search/storeitemsdata?inv=1&MOC=' + r, {
                    theid: val,
                    thedate: this.invoice_date
                }).then(result => {
                    $('#old_purchase_price').focus();
                });
            }

        },
        itemsdata(){
            this.$http.post('/search/storeitemsdatalike',{searchid:this.search}).then(result=>{
                let data =result.data;
                data.filter((a)=>{a.search=a.item_code + ' ' + '-'+ ' ' + a.item_details})

                if(data){

                    this.searcheditemsdefs=data;

                }
            });
        },
        enterquantity:function(el){

            // if(this.quantity<1 && this.quantity!='') alert('Please Enter a valid Quantity !');

            /* this.selected_items[this.active_el].qty=this.quantity;*/
        },
        getItemDefs:function(){
            this.$http.get('/store-management/store-issue-note/items/'+this.sSubCat).then(result=>{
                let data=result.data;
                if(data){
                    this.itemdefs=data;
                }
            })
        },
        getSubCats:function(){
            this.$http.get('/food-and-beverage/sales/subcategory/0').then(result=>{
                let data=result.data;
                if(data){
                    this.subcats=data;
                }
            })
        },
        customerdata(){
            let v = this.type;
            this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                let data =result.data;
                if(v==0){
                    data.filter((a)=>{
                        let fname=a.first_name?a.first_name+' ':'';
                        let mname=a.middle_name?a.middle_name+' ':'';
                        let lname=a.applicant_name?a.applicant_name:'';
                        let fullname=fname+mname+lname;

                        if(a.active==1){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Active' + ')'
                        }
                        else if(a.active==2){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Expired' + ')'
                        }
                        else if(a.active==3){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Suspended' + ')'
                        }
                        else if(a.active==4){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Terminated' + ')'
                        }
                        else if(a.active==5){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Absent' + ')'
                        }
                        else if(a.active==6){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Cancelled' + ')'
                        }
                        else if(a.active==7){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Not Assigned' + ')'
                        }
                    })
                }
                else if(v==1){
                    data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                }
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})
                }
                if(data){

                    this.customers=data;

                }
            });
        },
        customerdatavalue(val,m){
            this.fkey=-1;
            this.customers=[];
            let v = this.type;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/salescustomerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;
                if(data){

                    if (v == 0) {
                        this.customer_id = data.id;
                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.families=data.family;
                        this.ledger_amount=data.balance;
                    }
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.ledger_amount=data.balance;
                    }
                    else if (v == 3) {
                        this.customer_id = data.id;
                        this.customer = data.name;
                        this.ledger_amount=data.balance;
                    }

                    this.alreadySearched=true;
                }
            });
        },
        pluck: function (objs, name) {
            var sol = [];
            for(var i in objs){
                if(objs[i].hasOwnProperty(name)){
                    // console.log(objs[i][name]);
                    sol.push(objs[i][name]);
                }
            }
            return sol;
        },
        sum:  function (input){

            if (toString.call(input) !== "[object Array]")
                return false;

            var total =  0;
            for(var i=0;i<input.length;i++)
            {
                if(isNaN(input[i])){
                    continue;
                }
                total += Number(input[i]);
            }
            return total;
        },
        amountChange:function(k,e){
            if(parseInt(e.target.value)>parseInt(e.target.max)){
                this.invoices[k].p=e.target.max;
            }
        }
        ,
        validation:function(data,valid){
            let self=this;
            let  mm=0;
            valid.forEach((a)=> {
                if(data[a]=='' || data[a]==null){
                    self.$snotify.error(a+' is required!');
                    mm++
                }

            })
            return mm;
        },
        save_sales:function(m){
            let data={
              //  unitsearchid:this.unitsearchid,
                company:this.company,
                selected_items: this.selected_items.filter((a)=>{return a.item_code!=null  &&  a.qty!=0  && a.hide==0}),
               store_location:this.store_location,
                department:this.department,
                gross:this.gross,
                grand_total:parseFloat(this.gross)-parseFloat(this.dis)+parseFloat(this.taxx)+parseFloat(this.adds),
                dis:this.dis,
                taxx:this.taxx,
                adds:this.adds,
                remarks:this.remarks,
                invoice_date:this.invoice_date,
                invoice_no:this.invoice_no,
                amount_in_words:this.toWords(Math.round(parseFloat(this.gross)-parseFloat(this.dis)+parseFloat(this.taxx)+parseFloat(this.adds))),
            };
            let url='/store-management/store-issue-note/store-issue-note-aeu/save';
            if(m){
                url='/store-management/store-issue-note/store-issue-note-aeu/update';
                data.id=this.id;
            }

            if(this.validation(data,['invoice_no','invoice_date', 'selected_items', 'company', 'gross', 'store_location', 'department'])==0) {
                this.disabled=true;
                this.$http.post(url, data).then(result => {
                    window.location.href= "/store-management/store-issue-note-vue";
                });
            }

        },
        save_print:function(m){
            let data={
                company:this.company,
                selected_items: this.selected_items.filter((a)=>{return a.item_code!=null  &&  a.qty!=0  && a.hide==0}),
                store_location:this.store_location,
                department:this.department,
                gross:this.gross,
                grand_total:parseFloat(this.gross)-parseFloat(this.dis)+parseFloat(this.taxx)+parseFloat(this.adds),
                dis:this.dis,
                taxx:this.taxx,
                adds:this.adds,
                remarks:this.remarks,
                invoice_date:this.invoice_date,
                invoice_no:this.invoice_no,
                amount_in_words:this.toWords(Math.round(parseFloat(this.gross)-parseFloat(this.dis)+parseFloat(this.taxx)+parseFloat(this.adds))),
            };
            let url='/store-management/store-issue-note/store-issue-note-aeu/save';
            if(m){
                url='/store-management/store-issue-note/store-issue-note-aeu/update';
                data.id=this.id;
            }

            if(this.validation(data,['invoice_no','invoice_date', 'selected_items', 'company', 'gross', 'store_location', 'department'])==0) {
                this.disabled=true;
                this.$http.post(url, data).then(result => {
                    location.reload();
                    if(m){
                        window.open("/store-management/store-issue-note/store-issue-note-print/"+m, "_blank");
                    }
                    else{
                        window.open("/store-management/store-issue-note/store-issue-note-print/"+result.data, "_blank");
                    }

                });
            }

        }
    },
    watch:{
       /* store_location:function(){
            let me=this.store_location;
            if(me!=''){
                this.issued_to_location='';
            }
        },
        issued_to_location:function(){
            let me=this.issued_to_location;
            if(me!=''){
                this.store_location='';
            }
        },
        department:function(){
            let me=this.department;
            if(me!=''){
                this.issued_to_department='';
            }
        },
        issued_to_department:function(){
            let me=this.issued_to_department;
            if(me!=''){
                this.department='';
            }
        },
*/
        unitsearch:function(){
            if(this.unitsearch.length==0){
                this.unitalreadySearched=false;
            }
            if(!this.unitalreadySearched){
                this.unitsdata();
            }
        },
        discount:function(){
            let disc=this.discount;
            if(this.discount==''){
                disc=0
            }
            this.dis=disc;
        },
        discount_percentage:function(){
            let disc=this.discount_percentage;
            if(this.discount_percentage==''){
                disc=0
            }

            this.dis=(parseFloat(this.gross)*parseFloat(disc)/100);
        },
        tax:function(){
            let tx=this.tax;
            if(this.tax==''){
                tx=0
            }
            this.taxx=tx;
        },
        tax_percentage:function(){
            let tx=this.tax_percentage;
            if(this.tax_percentage==''){
                tx=0
            }
            this.taxx=(parseFloat(this.gross)*parseFloat(tx)/100);
        },

        additional_amt:function(){
            let ad=this.additional_amt;
            if(this.additional_amt==''){
                ad=0
            }
            this.adds=ad;
        },
        additional_per:function(){
            let ad=this.additional_per;
            if(this.additional_per==''){
                ad=0
            }
            this.adds=(parseFloat(this.gross)*parseFloat(ad)/100);
        },

        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
            }

            if(!this.alreadySearched){
                this.customerdata();
            }
        },
        search:function(){
            this.ffkey=-1
            if(this.search.length==0){
                this.itemalreadySearched=false;
            }
            if(this.search.length>2 && !this.itemalreadySearched){
                this.itemsdata();
            }
        },
        sCategory:function(){
            this.getSubCats();
        },
        selecteditem:function(){
            this.save_to_selected();
        },
        sSubCat:function(){
            if(this.sSubCat!=''){
                this.getItemDefs();
            }

        },
    },
    mounted() {
        if(this.id){
            this.init(this.id);

            // this.init(id.id);

        }
        else{
            this.init();

        }

        let x=new URLSearchParams(window.location.search)
        if(x.get('accid')){

            this.customers=[];
            let v = 2;
            let r='';
            let m=this.id;
            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:x.get('memid')}).then(result=>{
                let data =result.data;
                if(data) {

                    this.alreadySearched=true;
                    this.customer_id = data.id;
                    this.customer = data.person_name;
                    this.ledger_amount=data.balance;



                }
            });


            console.log(x.get('memid'));
        }
        let self=this;
        setInterval(function(){
            self.gross=self.sum(self.pluck(self.selected_items.filter((a)=>{return a.item_code!=null  &&  a.qty!=0  && a.hide==0}),'product'))
            self.showinggross=Math.round(self.sum(self.pluck(self.selected_items.filter((a)=>{return a.item_code!=null  &&  a.qty!=0  && a.hide==0}),'product')))
            self.totalqty=Math.round(self.sum(self.pluck(self.selected_items.filter((a)=>{return a.item_code!=null  &&  a.qty!=0  && a.hide==0}),'qty')))
        },200)
    }
}
</script>

<style scoped>
.groove{
    overflow: auto;
    height: 300px !important;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}
td[data-v-9f820652] {
    border: 1px solid #f1f1f1;
    white-space: nowrap;
}
.form-layout-4{
    padding: 8px;
}
.activatedtr {
    background-color: steelblue;
}
.btnfont{
    font-size: 16px!important;
    padding: 0;
    height: 25px;
    width: 25px;
    border-radius: 50%;
    text-align: center;
    padding: 0px;
    color: #fff;
    background: #5a5a5a;
    margin-bottom: 4px;
    margin-left: 4px;
}

.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;
    text-decoration: none;
    display: block;
    color: #000;
}
.fbb a:focus{
    opacity: 1;
    background:#49a2fb;
    color: #fff;
    font-weight:bold;
}
.areabox{
    padding:0!important
}
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}
.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

</style>
