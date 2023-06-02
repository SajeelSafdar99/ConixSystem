


<template>

    <div>

        <vue-snotify></vue-snotify>

        <div v-if="FinalEditOrder">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">RECEIVE PAYMENT:</h5>
                                    <button type="button" class="close" @click="FinalEditOrder=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-sm-12">  <div class="header"><b>ACCOUNT TYPES</b>
                                            <div class="float-right" style="margin-right:10px">
                         <span @click="AccTypeMargin/50<0?AccTypeMargin=AccTypeMargin+50:''">
                      <i class="fas fa-chevron-circle-left "  style="color:#fff"></i>
                      </span>
                                                <span @click="Math.abs(AccTypeMargin/50)+1<(parseInt(acctypes.length/3)+(acctypes.length%3>0?1:0))?AccTypeMargin=AccTypeMargin-50:''"><i class="fas fa-chevron-circle-right "  style="color:#fff"></i></span>
                                            </div></div>
                                        </div>
                                    </div>

                                    <div class="scrollclass">

                                        <div class="inner" :style="'margin-top:'+AccTypeMargin+'px'">


                                            <div class="scrollsub waiterdiv waiter" :style="'width:142px; text-align:center;padding: calc(142px - 121px - '+(acctype.name.length>18?21:10)+'px);'" v-if="acc_permission.indexOf(acctype.name+' '+acctype.mod_id)!=-1" v-for="acctype in acctypes" @click="sAccType=acctype.id" v-bind:class="{'active':sAccType==acctype.id}">
                                                <b>{{acctype.name}}</b>
                                            </div>
                                        </div>


                                    </div>

                                    <hr>
                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;">Grand Total:</b>  </label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                            <b style="font-size: 18px;">{{this.grand_total}}</b>
                                            <br>
                                            <span style="font-size: 16px; text-transform: uppercase;">({{toWords(this.grand_total)}})</span>
                                        </div> </div>

                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;"> Amount Received: </b></label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                            <input type="number" v-model="amount_received" class="form-control input-height" placeholder="Enter Amount">
                                        </div>
                                    </div>

                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;">  Return Value: </b> </label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">

                                                <template v-if="parseFloat(amount_received)>(grand_total)">
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="(grand_total)-parseFloat(amount_received)" id="return_value" autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="0" id="return_value" autocomplete="off">
                                                </template>

                                        </div>
                                    </div>

                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;"> Receipt Amount: </b> </label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">

                                                <template v-if="parseFloat(amount_received)>(grand_total)">
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="(grand_total)-parseFloat(amount_received)+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="0+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>

                                        </div>
                                    </div>

                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;">  Comment Box: </b> </label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                          <textarea class="form-control" v-model="remarks" placeholder="Give any details" rows="2" type="text" id="remarks"
                                                    name="remarks"></textarea>
                                        </div> </div>
                                </div>
                                <div class="modal-footer">
                                        <input @click="receive_payment(id);" :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Receive':'Save & Receive'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="col-xl-12 ">
            <div class="row">
                    <div class="col-sm-6">
                        <br>
                        <h6 class="box-title" style="color: black; text-align: center;">ORDER DETAILS</h6>

                        <div  class="row ">
                            <label class="col-sm-3 form-control-label">
                                Booking #:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input id="booking_no" class="form-control input-height" type="number" autocomplete="off" readonly="" v-model="booking_no" name="booking_no" style="background-color: #c1c1c1">

                            </div>
                        </div>
                        <!-- row -->
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Booking Date:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <template v-if="!this.id">
                                <input type="text" v-model="booking_date" value="" placeholder="dd/mm/yyyy" name="booking_date" id="booking_date" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                                </template>
                                <template v-else>
                                    <input type="text" :value="this.booking_date | moment('DD/MM/YYYY')" placeholder="dd/mm/yyyy" name="booking_date" id="booking_date" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                                </template>
                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Order Taker Name:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="order_taker" placeholder="Enter Name" name="order_taker" id="order_taker" class="form-control input-height" >

                            </div>
                        </div>


                        <div class="row mg-t-10">

                            <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input type="radio" name="type" v-model="type" value="0"><span class="pabs">Member</span></label>
                                <label class="rdiobox">
                                    <input type="radio" name="type" v-model="type" value="6"><span class="pabs">Corporate Member</span></label>
                                <label class="rdiobox">
                                    <input type="radio" name="type" v-model="type" value="1"><span class="pabs">Guest   <a href="/room-management/room-customer/room-customer-aeu" target="popup" onclick="window.open('/room-management/room-customer/room-customer-aeu','popup','width=450,height=550'); return false;"><i class="fa fa-plus"></i></a> <!--<a href="/room-management/room-customer/room-customer-aeu" target="_blank" class="btn btn-xsss btn-info"><i class="fa fa-plus"></i></a>--></span>
                                </label>
                                <label class="rdiobox">
                                    <input type="radio" name="type" v-model="type" value="3"><span class="pabs">Employee</span>
                                </label>
                            </div><!-- col-3 -->


                            <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                                    <template v-if="this.id">
                                    <input readonly style="background-color: #c1c1c1" v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" :placeholder="'Search '+(type==0?'Member':type==1?'Guest':type==6?'Corporate Member':'Employee')">
                                    </template>
                                    <template v-else>
                                    <input v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" :placeholder="'Search '+(type==0?'Member':type==1?'Guest':type==6?'Corporate Member':'Employee')">
                                    </template>

                                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                                            <a href="javascript:void(0)" v-html="c.name"></a>
                                        </li>

                                    </ul>
                                </div>

                                <br>
                                <template v-if="!this.id">
                                <input @click="clickaddguest()" :disabled="type==0?true:type==1?false:true" type="button" name="addguest" id="addguest" class="btn btn-sm btn-info" value="Save Guest">
                                <input type="hidden" v-model="hiddenforguest" name="hiddenforguest" id="hiddenforguest" value="">
                                </template>
                            </div>


                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Contact: <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                               <template v-if="this.id">
                                <input class="form-control input-height" readonly style="background-color: #c1c1c1" :placeholder="(type==0?'Member':type==1?'Guest':type==6?'Corporate Member':'Employee')+' Contact'" v-model="contact" name="contact" id="contact" type="text">
                               </template>
                                <template v-else>
                                <input class="form-control input-height" :placeholder="(type==0?'Member':type==1?'Guest':type==6?'Corporate Member':'Employee')+' Contact'" v-model="contact" name="contact" id="contact" type="text">
                                </template>
                            </div>
                        </div>


                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                ID:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input v-model="customer_id" class="form-control input-height"  name="customer_id" id="customer_id" type="text" :placeholder="(type==0?'Member':type==1?'Guest':type==6?'Corporate Member':'Employee')+' ID'" readonly style="background-color: #c1c1c1">
                                <input v-model="member_id" name="member_id" id="member_id" type="hidden">
                            </div>

                    </div>


                    <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                            Ledger Amount:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input class="form-control input-height" :placeholder="(type==0?'Member':type==1?'Guest':type==6?'Corporate Member':'Employee')+' Ledger Amount'" readonly style="background-color: #c1c1c1" v-model="ledger_amount" name="ledger_amount" id="ledger_amount" type="number"></div>
                    </div>


                    <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                            Family Member:
                        </label>
                        <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <select id="family" class="form-control input-height family" v-model="family">
                                <option label="Choose Family Member" value="0">  </option>
                                <option :value="fam.id" v-for="fam in families">
                                    {{fam.name}} - {{fam.relationship_name.desc}}
                                </option>
                            </select>

                        </div>
                    </div>


                        <br>
                        <h6 class="box-title" style="color: black; text-align: center;">CAKE DETAILS</h6>

                    <div class="row mg-t-10">
                        <label class="col-sm-3 form-control-label">
                         Cake Type:
                    <span class="tx-danger">
                                *
                            </span>
                    </label><div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                        <select @change="changeCakeType();" id="cake_type" v-model="cake_type" name="cake_type" class="form-control input-height select2" >
                            <option label="Choose Option" value="0"></option>
                            <option :value="cake_type.id" v-for="cake_type in cake_types">
                                {{ cake_type.item_details }}
                            </option>

                        </select>  </div>
                </div>
                    <div class="row mg-t-10">
                         <label class="col-sm-3 form-control-label">
                             Flavor/s:
                         <span class="tx-danger">
                                *
                            </span>
                    </label>
                    <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                          <input type="text" v-model="flavor" placeholder="Enter Name of Cake's Flavor" name="flavor" id="flavor" class="form-control input-height" >
                     </div>
                    </div>
                            <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Topping/s:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="topping" placeholder="Enter Topping Details" name="topping" id="topping" class="form-control input-height" >
                            </div>
                    </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Filling:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="filling" placeholder="Enter Filling Details" name="filling" id="filling" class="form-control input-height" >
                            </div>
                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Icing:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" placeholder="Enter Icing Details" v-model="icing" name="icing" id="icing" class="form-control input-height" >
                            </div>
                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Color/s:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="color" name="color" placeholder="Enter Cake's Color" id="color" class="form-control input-height" >
                            </div>
                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Weight:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-5 mg-t-10 mg-sm-t-0">
                                <input type="number" v-model="weight" name="weight" placeholder="Enter Cake's Weight" id="weight" class="form-control input-height" >
                            </div>
                            <div  class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <input type="text" readonly v-model="units" name="units" placeholder="Unit" id="units" class="form-control input-height" >
                            </div>
                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Written Message / Special Instructions:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <textarea type="text" class="form-control" id="instructions"  v-model="instructions" placeholder="Enter Details" autocomplete="off"></textarea>
                            </div>
                        </div>
                          <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Special Display:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="special_display" placeholder="Enter Display Details" name="special_display" id="special_display" class="form-control input-height" >
                            </div>
                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Picture / Sketch Attached: <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <select v-model="attachment"  class="form-control input-height">
                                    <option v-for="s in ['Yes','No']">{{s}}</option>
                                </select></div>
                        </div>
                        <div class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Attachments:
                            </label>

<!--
                                <div class="col-sm-4 mg-t-10 mg-sm-t-0">

                                        <img :src="this.images?this.images:'/'+'assets/images/nouser.png'" style="width: 200px; height: 100px;" />
                                        <input multiple="multiple" name="images[]" type="file" @change="onFileChange">

                                </div>
-->


                      <div v-if="this.id" class="col-sm-5 mg-t-10 mg-sm-t-0">

                                <template v-if="this.id && this.document ">
                                    <template v-for="doc in picturas">
                             <a @click="deletepic(doc.url);"><span style="background-color: rgb(219, 218, 218);
                             height:0px;
    width: 14px;
    padding: 0px;
    float: right;
    margin-left: 82px;
    position: absolute;"> &nbsp&nbsp<i class="fas fa-times fa-lg" style="color:red"></i></span></a>
                                        <a target="_blank" :href="'/'+doc.url"><img style="width: 100px;" :src="'/'+doc.url"></a> &nbsp
                                    </template>
                                </template>
                            </div>
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <vue-upload-multiple-image :showEdit="false" :showDelete="false" :primaryText="''" :dragText="'Attach Document'" :browseText="'(Browse)'"
                                                           @upload-success="uploadImageSuccess"
                                                           @edit-image="editImage"
                                                           :data-images="document"
                                ></vue-upload-multiple-image> </div>
<!--           @before-remove="beforeRemove"                         -->

                        </div>
                        <br><br><br>

                        <!--// BUTTONS-->
                                 <input @click="save_sales(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">
                        <input @click="save_print(id)" :disabled="disableds"  :class="id?'btn-warning':'btn-warning'" type="submit" name="save" class="btn" :value="id?'Update & Print':'Save & Print'">

                                <template v-if="(this.printedornot==2 && this.caneditsale) && this.shouldiappear==1">
                                    <input @click="save_sales_datatable(id)"  :class="'btn-primary'" type="submit" name="save" class="btn" :value="'Edit'">
                                </template>

                    <!--    <template v-if="!this.id">
                        <input @click="save_sales_datatable(id)"  :class="'btn-primary'" type="submit" name="save" class="btn" :value="'Save & Receive'">
                        </template>-->

                                <a href="/food-and-beverage/cake-booking-vue"><button class="btn btn-secondary">Cancel</button></a>

                        <!--// BUTTONS-->
                        <br>
                    </div>
                    <div class="col-sm-6">
                        <br>
                        <h6 class="box-title" style="color: black; text-align: center;">DELIVERY DETAILS</h6>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Delivery Date:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-4 mg-t-10 mg-sm-t-0">
                                <datepicker v-model="delivery_date" :clear-button="true" placeholder="dd/mm/yyyy" format="dd/MM/yyyy" input-class="form-control input-height" name="delivery_date" autocomplete="off"></datepicker>
                            </div>
                            <label class="col-sm-2 form-control-label">
                                Pick-up Time:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-3 mg-t-10 mg-sm-t-0">
                                <vue-timepicker v-model="pickup_time" name="pickup_time"  input-class="form-control input-height"  autocomplete="off" format="hh:mm A"></vue-timepicker>
                            </div>
                        </div>


                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Name of Person Receiving:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="text" v-model="receiver" placeholder="Enter Name" name="receiver" id="receiver" class="form-control input-height" >

                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                               Delivery Address:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <textarea type="text" class="form-control" id="delivery_address" v-model="delivery_address" placeholder="Enter Address" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Note:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <textarea type="text" class="form-control" id="note" v-model="note" placeholder="Enter Details" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <br>
                        <h6 class="box-title" style="color: black; text-align: center;">CHARGES DETAILS</h6>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Total Amount:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="number" readonly="" style="background-color: #c1c1c1" placeholder="Enter Amount" v-model="total_amount" name="total_amount" id="total_amount" class="form-control input-height" autocomplete="off">

                            </div>
                        </div>
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">Discount (If Any): </label>
                            <div class="col-sm-5 mg-t-10 mg-sm-t-0">
                                <input type="number" id="discount_amount" v-model="discount_amount" autocomplete="off" placeholder="Enter Amount" class="form-control input-height" value="" :disabled="discount_percentage!=0 || discount_percentage!=''">

                            </div>
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                                <input type="number" id="discount_percentage" class="form-control input-height" value="" v-model="discount_percentage" :disabled="discount_amount!=0 ||discount_amount!='' ">

                            </div>
                        </div>

                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">Tax (If Any): </label>
                            <div class="col-sm-5 mg-t-10 mg-sm-t-0">
                                <input type="number" id="tax_amount" v-model="tax_amount" autocomplete="off" placeholder="Enter Amount" class="form-control input-height" value="" :disabled="tax_percentage!=0 || tax_percentage!=''">

                            </div>
                            <div class="col-sm-4 mg-t-10 mg-sm-t-0 pc">
                                <input type="number" id="tax_percentage" class="form-control input-height" value="" v-model="tax_percentage" :disabled="tax_amount!=0 ||tax_amount!='' ">

                            </div>
                        </div>
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                             Amount Payable:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="number" readonly="" style="background-color: #c1c1c1" v-model="grand_total" placeholder="Enter Amount" name="grand_total" id="grand_total" class="form-control input-height" autocomplete="off">

                            </div>
                        </div>
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Advance Paid:
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="number" placeholder="Enter Amount" v-model="advance_paid" name="advance_paid" id="advance_paid" class="form-control input-height" autocomplete="off">

                            </div>
                        </div>
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Mode of Payment:<span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <select id="payment_method" v-model="payment_method" name="payment_method" class="form-control input-height select2" >
                                    <option label="Choose Option" value="0"></option>
                                    <option v-if="acc_permission.indexOf(type.name+' '+type.mod_id)!=-1" :value="type.id" v-for="type in acctypes">
                                        {{ type.name }}
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div  class="row mg-t-10">
                            <label class="col-sm-3 form-control-label">
                                Payable Balance:
                                <span class="tx-danger">
                                *
                            </span>
                            </label>
                            <div  class="col-sm-9 mg-t-10 mg-sm-t-0">
                                <input type="number" readonly="" style="background-color: #c1c1c1" v-model="balance_amount" placeholder="Enter Amount" name="balance_amount" id="balance_amount" class="form-control input-height" autocomplete="off">

                            </div>
                        </div>



                    </div>
        </div>
    </div>


</div>

</template>

<script>
    export default {
        name: "cakebooking",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              payment_method:'0',
              document:[],
              documents:[],
              booking_no:'',
              booking_date:'',
              order_taker:'',
              cake_type:'0',
              flavor:'',
              topping:'',
              filling:'',
              icing:'',
              color:'',
              weight:'',
              instructions:'',
              attachment:'Yes',
              special_display:'',
              delivery_date:'',
              pickup_time:'',
              receiver:'',
              delivery_address:'',
              note:'',
              total_amount:'0',
              discount_amount:'',
              discount_percentage:'',
              tax_amount:'',
              tax_percentage:'',
              grand_total:'0',
              advance_paid:'0',
              balance_amount:'0',
              discount:0,
              tax:0,
              contact:'',
              cake_types:[],
              fkey:-1,
              ffkey:0,
images:[],
              disableds:false,
              id:s,
              onLine: null,
              onlineSlot: 'online',
              offlineSlot: 'offline',
              subtotal:0,
              alternativeqty:'',
              AccTypeMargin:0,
              tableMargin:0,
              captainMargin:0,
              categoryMargin:0,
              SubcategoryMargin:0,
              kot:0,
              printing:false,
              printerip: 'localhost:5000',
              search:'',
              varserviced:'',
              varserviced_pct:'',
              vartaxedamt:'',
              vartaxedpct:'',
              taxandservice:'',
              amount_received:'',
              remarks:'',
              printer_name:'',
              printer_api:'',
              type:'0',
              aftercancel:'Void',
              covers:'',
              quantity:'',
              instruction:'',
              showModal: false,
              showCancellationModal: false,
            /* showModalPayment: this.datatableid?false:true,*/
              showModalPayment: true,
              FinalEditOrder: false,
              showModaltoMove:false,
              family:0,
              active_el:0,
              increment_number:'',
              val:'',
              customer:'',
              discountcard:'',
              disc:'',
              disc_pc:'',
              customers:[],
              searcheditemsdefs:[],
              discountcards:[],
              customer_id:'',
              ledger_amount:'',
              member_id:'',
              selected_items:[],
              sWaiter:'',
              sTable:'',
              sCategory:'',
              sSubCat:'',
              sMode:'',
              sType:'',
              sCancelledRemark:'',
              sResturant:'1',
              sResturantName:'',
              sAccHead:'',
              sAccType:'',
              sItemDef:'0',
              waiters:[],
              tables:[],
              mains:[],
              subcats:[],
              accheads:[],
              acctypes:[],
              acc_permission:'',
              itemdefs:[],
              resturants:[],
              cancelled_remarks:[],
              families:[],
              alreadySearched:false,
              alreadySearchedDisc:false,
              itemalreadySearched:false,
              currencies:[],
              sCurrencyName:'',
              orderType:[ "Dine-In",
                  "Take Away",
                  "Home Delivery"] ,
              paymentMode:[ " Cash",
                  " Credit Card",
                  "Other"],
              bookedTables:[],
               printedTables:[],
              xpprinter:'',
              printedornot:'',
              date:'',
              time:'',
              cancelpermit:'',
              caneditsale:'',
              cat_permission:'',
              shouldiappear:'',
              tempgrandtotal:0,
              shift:'',
              showEndShift:false,
              showStartShift:false,
              shiftAlert:false,
              shiftAlertEnd:false,
              refreshmyinterval:false,
              units:'',
              hiddenforguest:'',
              picturas:[],
              imageFiles: []
          }
        },
       /* computed: {
            searcheditemdefs() {

                return this.itemdefs.filter(item => {
                    return item.item_code.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },*/
        watch:{

            total_amount:function(){
                let da=this.total_amount;
                this.grand_total=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                this.balance_amount=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
            },
            discount_amount:function(){
                let da=this.discount_amount;
                if(this.discount_amount=='' || this.discount_amount==null){
                    da=0
                }

                this.discount=da;
                this.grand_total=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                this.balance_amount=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
            },
            discount_percentage:function(){
                let dp=this.discount_percentage;
                if(this.discount_percentage==''){
                    dp=0
                }
                this.discount=(parseInt(this.total_amount)*parseFloat(dp)/100);
                this.grand_total=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                this.balance_amount=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
            },
                tax_amount:function(){
                    let ta=this.tax_amount;
                    if(this.tax_amount=='' || this.tax_amount==null){
                        ta=0
                    }
                    this.tax=ta;
                    this.grand_total=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                    this.balance_amount=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                },
                tax_percentage:function(){
                    let tp=this.tax_percentage;
                    if(this.tax_percentage=='') {
                        tp = 0
                    }
                    this.tax=(parseInt(this.total_amount)*parseFloat(tp)/100);
                    this.grand_total=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                    this.balance_amount=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax);
                },
            advance_paid:function(){
                let da=this.advance_paid;
                this.balance_amount=parseInt(this.total_amount)-parseFloat(this.discount)+parseFloat(this.tax)-parseInt(this.advance_paid);
            },

            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                }
                if(this.customer.length>2 && !this.alreadySearched){
                this.customerdata();
                }
            },

        },

        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            encodeImage (input) {
                if (input) {
                    const reader = new FileReader()
                    reader.onload = (e) => {
                        this.base64Img = e.target.result
                    }
                    reader.readAsDataURL(input)
                }
            },
            createImage(file) {

                var imgURL = URL.createObjectURL(file);

                this.images = imgURL;

                console.log(this.images );
               /* var images = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.images = e.target.result;
                };
                reader.readAsDataURL(file);*/
            },
            removeImage: function (e) {
                this.images = '';
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




            },
            changeCakeType:function(){
                if(this.cake_type!='0'){
                    let self=this;
                    this.total_amount=this.cake_types.filter(function(a){return a.id==self.cake_type})[0].sale_price;
                    this.units=this.cake_types.filter(function(a){return a.id==self.cake_type})[0].unit;
                }else{
                    this.total_amount=0;
                    this.units='';
                }
            },
            uploadImageSuccess(formData) {

                this.imageFiles.push (
                    formData.get("file")
                );


            },
          /*  uploadImageSuccess(formData, index, fileList) {
                console.log('data', formData, index, fileList)
                // Upload image api
                // axios.post('http://your-url-upload', formData).then(response => {
                //   console.log(response)
                // })
                let url='/food-and-beverage/cake-booking/temporary_upload';
                    this.$http.post(url,formData).then(result=>{
                        this.documents.push(result.data);
                        console.log(this.documents);
                    });

            },*/
            beforeRemove (index,done, fileList) {
                console.log('index', index, fileList)
                var r = confirm("Are you sure ?")
                if (r == true) {
                    done()
                    let url='/food-and-beverage/cake-booking/temporary_remove';
                    this.$http.post(url,index).then(result=>{
                        this.documents.pop(result.data);
                        console.log(this.documents);
                    });
                } else {
                }
            },
            editImage (formData, index, fileList) {
                console.log('edit data', formData, index, fileList)
            },
            amIOnline(e) {
                this.onLine = e;
            },
            slideright: function () {
                $('.scrollclass').addClass('slideright');

            },
            validation: function (data, valid) {
                let self = this;
                let mm = 0;
                valid.forEach((a) => {
                    if (data[a] == '' || data[a] == null) {
                        self.$snotify.error(a + ' is required!');
                        mm++
                    }

                })
                return mm;
            },
            receive_payment: function (m) {
                let data = {
                    return_value: this.amount_received > this.grand_total ? parseFloat(this.grand_total) - parseInt(this.amount_received) : 0,
                    cash_receipt_amt: this.amount_received > this.grand_total ? parseFloat(this.grand_total)-parseInt(this.amount_received)+parseInt(this.amount_received): 0+parseInt(this.amount_received),
                    amount_received: this.amount_received ? this.amount_received : 0,
                    remarks: this.remarks,
                    sAccType: this.sAccType,
                    amount_in_words: this.toWords(this.grand_total),

                    booking_no:this.booking_no,
                    booking_date:this.booking_date,
                    order_taker:this.order_taker,
                    cake_type:this.cake_type,
                    flavor:this.flavor,
                    topping:this.topping,
                    filling:this.filling,
                    icing:this.icing,
                    color:this.color,
                    weight:this.weight+' '+this.units,
                    instructions:this.instructions,
                    attachment:this.attachment,
                    special_display:this.special_display,
                    delivery_date:this.delivery_date,
                    pickup_time:this.pickup_time,
                    receiver:this.receiver,
                    delivery_address:this.delivery_address,
                    note:this.note,
                    total_amount:this.total_amount,
                    discount:this.discount,
                    tax:this.tax,
                    grand_total:this.grand_total,
                    customer:this.customer,
                    type:this.type,
                    customer_id:this.customer_id,
                    ledger_amount:this.ledger_amount,
                    member_id:this.member_id,
                    family:this.family,
                    document:this.images,
                    payment_method:this.payment_method,
                };
                let url = '/food-and-beverage/cake-booking/saveandreceive';
                if (m) {
                    url = '/food-and-beverage/sales/sales-aeu/receive';
                    data.id = this.id;
                }
                if(this.validation(data,['sAccType','amount_received','booking_no','booking_date', 'order_taker','cake_type','flavor', 'topping', 'filling','icing', 'color', 'weight','customer' ,'customer_id','attachment', 'receiver', 'delivery_address', 'total_amount', 'grand_total', 'delivery_date','pickup_time', 'balance_amount', 'payment_method'])==0){

                    this.$http.post(url, data).then(result => {
                    this.init();
                        window.location.href = "/food-and-beverage/cake-booking-vue";
                });
                 }
            },
            clickaddguest: function () {
                let data = {
                    customer:this.customer,
                    contact:this.contact
                };
                let url = '/create/guestid';

                if(this.validation(data,['contact', 'customer'])==0){

                    this.$http.post(url, data).then(result => {
                        this.customer_id=result.data;
                        this.hiddenforguest=1;
                        $(':radio:not(:checked)').attr('disabled', true);
                        $('#name').attr('readonly','readonly');
                        $('#contact').attr('readonly','readonly');
                    });
                }
            },
            save_sales:function(m){

                this.refreshmyinterval=true;


                console.log(this.images);

                let data={
                    booking_no:this.booking_no,
                    booking_date:this.booking_date,
                    order_taker:this.order_taker,
                    cake_type:this.cake_type,
                    flavor:this.flavor,
                    topping:this.topping,
                    filling:this.filling,
                    icing:this.icing,
                    color:this.color,
                    weight:this.weight+' '+this.units,
                    instructions:this.instructions,
                    attachment:this.attachment,
                    special_display:this.special_display,
                    delivery_date:this.delivery_date,
                    pickup_time:this.pickup_time,
                    receiver:this.receiver,
                    delivery_address:this.delivery_address,
                    note:this.note,
                    total_amount:this.total_amount,
                    discount:this.discount,
                    tax:this.tax,
                    grand_total:this.grand_total,
                    advance_paid:this.advance_paid,
                    balance_amount:this.balance_amount,
                    customer:this.customer,
                    type:this.type,
                    customer_id:this.customer_id,
                    ledger_amount:this.ledger_amount,
                    member_id:this.member_id,
                    family:this.family,
                    document:this.images,
                    payment_method:this.payment_method,
                    contact:this.contact,
                    hiddenforguest:this.hiddenforguest,
                };

                let formData = new FormData();

                formData.append("booking_no", this.booking_no);
                formData.append("order_taker", this.order_taker);
                formData.append("booking_date", this.booking_date);
                formData.append("cake_type", this.cake_type);
                formData.append("flavor", this.flavor);
                formData.append("topping", this.topping);
                formData.append("filling", this.filling);
                formData.append("icing", this.icing);
                formData.append("color", this.color);
                formData.append("weight", this.weight+' '+this.units);
                formData.append("instructions", this.instructions);
                formData.append("special_display", this.special_display);
                if(m){
                    formData.append("delivery_date", new Date(this.delivery_date).toLocaleDateString('en-CA'));
                }else{
                    formData.append("delivery_date", this.delivery_date.toLocaleDateString('en-CA'));
                }
                formData.append("receiver", this.receiver);
                formData.append("pickup_time", this.pickup_time);
                formData.append("delivery_address", this.delivery_address);
                formData.append("note", this.note);
                formData.append("total_amount", this.total_amount);
                formData.append("discount", this.discount);
                formData.append("tax", this.tax);
                formData.append("grand_total", this.grand_total);
                formData.append("advance_paid", this.advance_paid);
                formData.append("balance_amount", this.balance_amount);
                formData.append("customer", this.customer);
                formData.append("type", this.type);
                formData.append("customer_id", this.customer_id);
                formData.append("ledger_amount", this.ledger_amount);
                formData.append("member_id", this.member_id);
                formData.append("family", this.family);
                formData.append("payment_method", this.payment_method);
                formData.append("contact", this.contact);
                formData.append("hiddenforguest", this.hiddenforguest);

                this.imageFiles.forEach(image =>
                {
                    formData.append("images[]", image);
                });

                let url='/food-and-beverage/cake-booking/cake-booking-aeu/save';
                if(m){
                    url='/food-and-beverage/cake-booking/cake-booking-aeu/update';
                    formData.append("id", this.id);
                }
if(this.validation(data,['booking_no','booking_date', 'order_taker','cake_type','flavor', 'topping', 'filling','icing', 'color', 'weight','customer' ,'customer_id', 'receiver', 'delivery_address', 'total_amount', 'grand_total', 'delivery_date','pickup_time', 'balance_amount', 'payment_method'])==0){
    this.disableds=true;
    this.$http.post(url,formData, {
        "Content-Type": "multipart/form-data"
    }).then(result=> {
        window.location.href = "/food-and-beverage/cake-booking-vue";
    });


}
else{
    this.disableds=false;

}
            },


            deletepic:function(urlme){
                if(confirm("Do you really want to Permanently Delete this Attachment ?")) {
                    let data = {
                        url: btoa(urlme),

                    };
                    let url = '/deleteimage/' + btoa(urlme);


                    this.$http.get(url, data).then(result => {
                        this.init(this.id);
                      /*  window.location.href = "/food-and-beverage/cake-booking/cake-booking-aeu-vue/" + this.id;*/
                    });
                }
            },

            save_print:function(m){

                this.refreshmyinterval=true;


                console.log(this.images);

                let data={
                    booking_no:this.booking_no,
                    booking_date:this.booking_date,
                    order_taker:this.order_taker,
                    cake_type:this.cake_type,
                    flavor:this.flavor,
                    topping:this.topping,
                    filling:this.filling,
                    icing:this.icing,
                    color:this.color,
                    weight:this.weight+' '+this.units,
                    instructions:this.instructions,
                    attachment:this.attachment,
                    special_display:this.special_display,
                    delivery_date:this.delivery_date,
                    pickup_time:this.pickup_time,
                    receiver:this.receiver,
                    delivery_address:this.delivery_address,
                    note:this.note,
                    total_amount:this.total_amount,
                    discount:this.discount,
                    tax:this.tax,
                    grand_total:this.grand_total,
                    advance_paid:this.advance_paid,
                    balance_amount:this.balance_amount,
                    customer:this.customer,
                    type:this.type,
                    customer_id:this.customer_id,
                    ledger_amount:this.ledger_amount,
                    member_id:this.member_id,
                    family:this.family,
                    document:this.images,
                    payment_method:this.payment_method,
                    contact:this.contact,
                    hiddenforguest:this.hiddenforguest,
                };

                let formData = new FormData();

                formData.append("booking_no", this.booking_no);
                formData.append("order_taker", this.order_taker);
                formData.append("booking_date", this.booking_date);
                formData.append("cake_type", this.cake_type);
                formData.append("flavor", this.flavor);
                formData.append("topping", this.topping);
                formData.append("filling", this.filling);
                formData.append("icing", this.icing);
                formData.append("color", this.color);
                formData.append("weight", this.weight+' '+this.units);
                formData.append("instructions", this.instructions);
                formData.append("special_display", this.special_display);
                if(m){
                    formData.append("delivery_date", new Date(this.delivery_date).toLocaleDateString('en-CA'));
                }else{
                    formData.append("delivery_date", this.delivery_date.toLocaleDateString('en-CA'));
                }
                formData.append("receiver", this.receiver);
                formData.append("pickup_time", this.pickup_time);
                formData.append("delivery_address", this.delivery_address);
                formData.append("note", this.note);
                formData.append("total_amount", this.total_amount);
                formData.append("discount", this.discount);
                formData.append("tax", this.tax);
                formData.append("grand_total", this.grand_total);
                formData.append("advance_paid", this.advance_paid);
                formData.append("balance_amount", this.balance_amount);
                formData.append("customer", this.customer);
                formData.append("type", this.type);
                formData.append("customer_id", this.customer_id);
                formData.append("ledger_amount", this.ledger_amount);
                formData.append("member_id", this.member_id);
                formData.append("family", this.family);
                formData.append("payment_method", this.payment_method);
                formData.append("contact", this.contact);
                formData.append("hiddenforguest", this.hiddenforguest);

                this.imageFiles.forEach(image =>
                {
                    formData.append("images[]", image);
                });

                let url='/food-and-beverage/cake-booking/cake-booking-aeu/save';
                if(m){
                    url='/food-and-beverage/cake-booking/cake-booking-aeu/update';
                    formData.append("id", this.id);
                }
                if(this.validation(data,['booking_no','booking_date', 'order_taker','cake_type','flavor', 'topping', 'filling','icing', 'color', 'weight','customer' ,'customer_id','attachment', 'receiver', 'delivery_address', 'total_amount', 'grand_total', 'delivery_date','pickup_time', 'balance_amount','payment_method'])==0){
                    this.disableds=true;
                    this.$http.post(url,formData, {
                        "Content-Type": "multipart/form-data"
                    }).then(result=> {
                       if(m){
                           window.open("/food-and-beverage/cake-booking/cake-booking-invoice/"+m, "_blank");
                          /* window.location.href = "/food-and-beverage/cake-booking/cake-booking-invoice/"+m;*/
                       }
                       else{
                           window.open("/food-and-beverage/cake-booking/cake-booking-invoice/"+result.data, "_blank");
                           /*window.location.href = "/food-and-beverage/cake-booking/cake-booking-invoice/"+result.data;*/
                       }
                    });


                }
                else{
                    this.disableds=false;

                }

            },
            save_sales_datatable:function(m) {
                this.FinalEditOrder = true;
            },

            generate_invoice:function(m){
                let data={
                    selected_items:this.selected_items
                };
                let url='/food-and-beverage/sales/generate_invoice';

                    data.id=this.id;

                this.$http.post(url,data).then(result=>{

                        if(m){
                            window.open("/food-and-beverage/sales/sales-invoice/"+m, "_blank");
                        }
                        this.init();
                /*    window.location = "//localhost:8000/food-and-beverage/sales/sales-aeu";*/

                    });

            },



            modalopen:function(){
                $(this).find($.attr('#instruction')).focus();
                if(this.selected_items[this.active_el].saved!=1) {
                    if (this.selected_items[this.active_el])
                        this.showModal = true;
                    else
                        this.showModal = false;
                }
            },
            modalpaymentopen:function(){

                    this.showModalPayment = true;

            },

            modalok:function(){
                this.instruction='';
                this.showModal=false;
            },

            scroll_left() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft -= 50;
            },
            scroll_right() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft += 50;
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
            init:function (m) {
                for (var i = 1; i < 9999; i++) {
                    window.clearInterval(i);
                }
                let r='';
                if(m){
                    r='?r='+m;
                }
                this.$http.get('/food-and-beverage/cake-booking/cake-booking-ini'+r).then(result=>{
                    let data =result.data;
                    this.refreshmyinterval=false;
                    if(m && this.datatableid==m) {
                        this.payment_method=data.payment_method;
                        this.picturas=data.documents;
                        console.log(this.picturas);
                        this.images=data.documents;
                        this.booking_no=data.booking_no;
                        this.booking_date=data.booking_date;
                        this.type=data.type;

                        this.customerdatavalue(data.customer_id,this.id);
                        this.tempgrandtotal =data.tempgrandtotal;
                        this.shouldiappear=1;
                        this.alreadySearched=true;
                        this.families=data.families;
                        this.printedornot=data.completedstatus;
                        this.selected_items=data.selected_items;
                        this.sWaiter=data.waiter_definition;
                       this.sType=data.order_type;
                        this.sAccHead=data.account_head;
                        this.sAccType=data.account_type;
                        this.sCategory=data.category;
                        this.sSubCat=data.sub_category;
                        this.sResturant=data.restaurant_location;
                        this.sTable=data.table_definition;

                        this.customer_id=data.customer_id;
                        this.ledger_amount=data.ledger_amount;
                        this.member_id=data.member_id;
                        this.family=data.family;
                        this.covers=data.covers;
                        this.remarks=data.remarks;
                        this.discountcard=data.discount_card_no;
                        this.disc=data.disc;
                        this.disc_pc=data.disc_pc;
                        this.amount_received='';

                        this.taxandservice=data.taxandservice;
                        //this.waiters=data.waiters;
                      //  this.tables=data.tables;
                        this.mains=data.mains;
                        //this.subcats=data.subcats;
                        //this.itemdefs=data.itemdefs;
                        this.resturants=data.restaurants;
                        this.cancelled_remarks=data.cancelled_remarks;
                        this.currencies=data.currencies;
                        this.accheads=data.accheads;
                        this.acctypes=data.acctypes;
                       this.date=data.date;
                        this.time=data.time;
                        this.ledger_amount=data.ledger_amount;
                        this.contact=data.contact;

                        this.id=data.id;


                        this.order_taker=data.order_taker;
                        this.cake_type=data.cake_type;
                        this.flavor=data.flavor;
                        this.topping=data.topping;
                        this.filling=data.filling;
                        this.icing=data.icing;
                        this.color=data.color;
                        this.weight=data.weight.substring(0, data.weight.indexOf(" "));
                        this.units=data.weight.substring(data.weight.indexOf(" ")+1);
                        this.instructions=data.instructions;
                        this.attachment=data.attachment;
                        this.delivery_date=data.delivery_date;
                        this.special_display=data.special_display;
                        this.pickup_time=data.pickup_time;
                        this.receiver=data.receiver;
                        this.delivery_address=data.delivery_address;
                        this.total_amount=data.total_amount;
                        this.note=data.note;

                        this.discount_amount=data.discount?data.discount:'';
                        this.tax_amount=data.tax?data.tax:'';

                        this.grand_total=data.grand_total;
                        this.advance_paid=data.advance_paid;
                        this.balance_amount=data.balance_amount;

                    }
                    else if(m && this.datatableid!=m) {
                        this.tempgrandtotal =data.tempgrandtotal;
                        this.shouldiappear=0;
                        this.alreadySearched=true;
                        this.families=data.families;
                        this.printedornot=data.completedstatus;
                        this.selected_items=data.selected_items;
                        this.sWaiter=data.waiter_definition;
                        this.sType=data.order_type;
                        this.sAccHead=data.account_head;
                        this.sAccType=data.account_type;
                        this.sCategory=data.category;
                        this.sSubCat=data.sub_category;
                        this.sResturant=data.restaurant_location;
                        this.sTable=data.table_definition;
                        this.type=data.type;
                        this.customer=data.name;
                        this.customer_id=data.customer_id;
                        this.ledger_amount=data.ledger_amount;
                        this.member_id=data.member_id;
                        this.family=data.family;
                        this.covers=data.covers;
                        this.remarks=data.remarks;
                        this.discountcard=data.discount_card_no;
                        this.discount_amount=data.discount;
                        this.tax_amount=data.tax;
                        this.amount_received='';

                        this.taxandservice=data.taxandservice;
                       // this.waiters=data.waiters;
                        //  this.tables=data.tables;
                        this.mains=data.mains;
                        //this.subcats=data.subcats;
                        //this.itemdefs=data.itemdefs;
                        this.resturants=data.restaurants;
                        this.cancelled_remarks=data.cancelled_remarks;
                        this.currencies=data.currencies;
                        this.accheads=data.accheads;
                        this.acctypes=data.acctypes;
                     this.date=data.date;
                        this.time=data.time;

                        this.id=data.id;

                    }
                    else{
                        this.booking_no=data.increment_number;
                        this.booking_date=moment().format('DD/MM/YYYY');

                        this.printedornot='',
                        this.shouldiappear=0;
                        this.id='';
                        this.taxandservice=data.taxandservice;
                       // this.waiters=data.waiters;
                       // this.tables=data.tables;
                        this.mains=data.mains;
                        //this.subcats=data.subcats;
                        this.resturants=data.restaurants;
                        this.currencies=data.currencies;
                        this.accheads=data.accheads;
                        this.acctypes=data.acctypes;

                        this.discountcard='';
                        this.type=0;
                        this.cancelled_remarks='';
                        this.amount_received='';
                        this.disc='';
                        this.disc_pc='';
                        this.itemdefs=[];
                        this.searcheditemsdefs=[];
                        this.covers='';
                        this.remarks='';
                        this.families='';
                        this.sWaiter='';
            /*            this.sResturant=1;*/
                        this.sType='';
                        this.sAccHead='';
                        this.sAccType='';
                        this.sCategory='';
                        this.sSubCat='';
                        this.selected_items=[];
                        this.customer='';
                        this.customer_id='';
                        this.ledger_amount=0;
                        this.member_id='';

                    }
                    this.cake_types=data.cake_types;
                    this.bookedTables=data.booked_tables;
                    this.cancelpermit=data.cancel_permit;
                    this.caneditsale=data.editsalepermit;
                    this.cat_permission=data.catspermit;
console.log(this.cat_permission);
                    this.printedTables=data.printed_tables;
                    this.kot=data.kot;
                    this.xpprinter=data.xpprinter;

                    this.showModalPayment=true;
                    this.shift=data.shift;
                    this.acc_permission=data.accpermit;
                    this.disableds=false;

                    console.log(data.shift);

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

                                a.name=fullname + ':' + a.mem_no + ' ' + '<span style="color: '+a.mem_status.color+'">(' + a.mem_status.desc + ')</span>'
                                a.color=a.mem_status.color
                            })
                        }
                   else if(v==6){
                        data.filter((a)=>{
                            let fname=a.first_name?a.first_name+' ':'';
                            let mname=a.middle_name?a.middle_name+' ':'';
                            let lname=a.applicant_name?a.applicant_name:'';
                            let fullname=fname+mname+lname;

                            a.name=fullname + ':' + a.mem_no + ' ' + '<span style="color: '+a.mem_status.color+'">(' + a.mem_status.desc + ')</span>'
                            a.color=a.mem_status.color
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
                            this.member_id = data.id;
                            this.contact = data.mob_a;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                        }
                       else if (v == 6) {
                            this.customer_id = data.id;
                            this.member_id = data.id;
                            this.contact = data.mob_a;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 1) {
                            this.contact = data.customer_contact;
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.customer_name;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 3) {
                            this.contact = data.mob_a;
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.name;
                            this.ledger_amount=data.balance;
                        }

this.alreadySearched=true;
                    }
                });
            },

        },

        mounted() {
            setInterval(()=>{
                this.$forceUpdate();
            },500)


        if(this.id){
            this.init(this.id);
            // this.init(id.id);

        }
        else{
            this.init();

        }

        let x=new URLSearchParams(window.location.search)
        if(x.get('t')){
            this.$http.get('/food-and-beverage/sales/restaurants/'+x.get('t')).then(result=>{
                let data=result.data;
                if(data){
                    this.sResturant=data[0];
                }
            })
            this.sTable=x.get('t');
            /*console.log(x.get('t'));*/
        }

        }
    }
</script>

<style scoped>

.active{
    /*background: green;*/
    background-color: #23BF08 !important;
    color: white !important;
}
.booked{
    background-color: red;
    color: white;
}
.printed{
    background-color: blue;
    color: white;
}
.ractive{
    border-radius: 25px;
    background-color: #23BF08;
    border: 2px solid #23BF08;
    color: white;
}
.ractive3{
    background-color: #23BF08;
   /* border: 2px solid #23BF08;*/
    color: white;
}
    td{border: 1px solid #f1f1f1;white-space: nowrap; }

th {

    background-color: #49a2fb;
    color: white;
    width: auto;
    border-right: 2px solid #fff;
    font-size: 13px;
    padding: 0px 2px;
    min-width: 33px;
}

    .cursor{cursor: pointer;}
.scrollclass {
    vertical-align: middle;
    overflow-x: scroll;
    overflow: hidden;/* new*/
    height:50px;/* new*/
}

.scrollclasscategory {
    vertical-align: middle;
    overflow-x: scroll;
    overflow: hidden;/* new*/
    height:100px;/* new*/
}
.scrollclasscategory .scrollsub{
    display: inline-block;
    vertical-align: middle;
    height: 50px;/*
    margin-right: -4px;*/
}
.scrollclasstable1{
    vertical-align: middle;
    overflow-x: scroll;
}
.scrollclasstable2{
    height: 229px;
    overflow-y: scroll;
    overflow-y: auto;
}
.slidedown{
    margin-top: -30px;
}

.scrollclassrests{
    vertical-align: middle;
    overflow-y: scroll;
    overflow-y: auto;
    overflow:hidden;
}
.scrollclassrests .scrollsubrests{
    display: inline-block;
    vertical-align: middle;
    text-align: center;
}

.scrollclassy {
    vertical-align: middle;
    overflow-y: scroll;
    overflow-y: auto;
}

.scrollclassy .scrollsuby2{
    display: inline-block;
    vertical-align: middle;
    margin-right: -4px;
}
.scrollclassy .scrollsuby{
    display: inline-block;
    vertical-align: middle;
    height: 50px;
    margin-right: -4px;
}
.scrollclass .scrollsub{
    display: inline-block;
    vertical-align: middle;
    height: 50px;/*
    margin-right: -4px;*/
}
.scrollclass .inner{
}

    .btnfont{
        font-size: 18px !important;
    }

tr > td:hover {
    cursor:pointer;
}

.activatedtr {
    background-color: steelblue;
}
.header
{background-color: cadetblue;}

.slideright{
    margin-left: -200px;
}
.hideShow{
    font-size: 20px;
    top: -33px;
    position: absolute;
    right: 14px;
    background: #7b1c1c;
    height: 30px;
    width: 30px;
    text-align: center;
    padding-top: 3px;
    border-radius: 50%;
    color: #fff;
}
.form-layout-4{
    padding: 8px;
}
.tabledefs {
    border: 2px solid #f1f1f1;
    padding: 12px;
    width: 47px;
    height: 30px;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
    padding: 3px;
}
.btn-xsss{
    padding: 0;
    font-size: 10px;
    padding: 3px 4px;
    /* float: right; */
    background: transparent;
    color: #000;
    border: 1px solid #ccc;
    border-radius: 0;
    border: none;
    float: right;
}
input.form-control,select.form-control{
    padding:3px
}

.form-group{
    margin-bottom:2px;
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
.finishbuttons input, .finishbuttons button {
    height: 30px;
    width: 88px;
    padding: 1px;
    margin-bottom: 6px;
    text-align: center;
}
.finishbuttons{
    text-align: center;
}
.catdiv {
    border: 2px solid #f1f1f1;
    width: 160px;
    height: 80px;
    cursor: pointer;
    font-size: 14px;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}
.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;

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
</style>
