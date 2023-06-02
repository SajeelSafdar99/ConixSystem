


<template>

    <div>
      <!--  <div class="row">
            <template v-if="this.shift==''">
            <button @click="start_shift()" class=" btn btn-outline-success ">START SHIFT</button> &nbsp&nbsp <span style="margin-top: 10px;" class="text-danger">PLEASE START SHIFT TO SAVE ORDER !</span>
            </template>
            <template v-else>
                <button @click="end_shift()" class=" btn btn-outline-danger ">END SHIFT &nbsp&nbsp <span style="margin-top: 10px;" class="text-success">({{this.shift | moment("DD/MM/YYYY")}})</span></button>
            </template>
        </div>-->

        <vue-snotify></vue-snotify>
        <v-offline
            online-class="online"
            offline-class="offline"
            @detected-condition="amIOnline">
            <template v-slot:[onlineSlot] :slot-name="onlineSlot">
                ( Online: {{ onLine }} )
            </template>
            <template v-slot:[offlineSlot] :slot-name="offlineSlot">
                ( Online: {{ onLine }} )
            </template>
        </v-offline>

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">ENTER INSTRUCTIONS:</h5>
                                    <button type="button" class="close" @click="showModal=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input placeholder="Type Here..." @input="enterinsts(active_el)" class="form-control input-height" v-model="instruction">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" @click="modalok()">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
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
                                           <input type="number" min="1" @input="alternativeqtyrestrict()" placeholder="Change the original Qty." v-model="alternativeqty" class="form-control input-height">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Remark:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select v-model="sCancelledRemark" id="cancelledremarks" name="cancelledremarks" class="form-control input-height select2">
                                                <option v-for="cancelled in cancelled_remarks" :value="cancelled.desc">
                                                    {{cancelled.desc}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-3">
                                        <label>Instructions:</label>
                                        </div>
                                        <div class="col-md-9">
                                        <input placeholder="Type Here..." @input="enterinsts(active_el)" class="form-control input-height" v-model="instruction">
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
                                    <button type="button" class="btn btn-info" @click="canceldone()">Done</button>
                                    <button type="button" class="btn btn-secondary" @click="showCancellationModal=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
      <!--  <div v-if="(showModalPayment && this.id && this.printedornot==1) || (this.datatableid==this.id && showModalPayment)">-->

        <div v-if="showModalPayment && this.id && this.printedornot==1">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">RECEIVE PAYMENT:</h5>
                                    <button type="button" class="close" @click="showModalPayment=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!--<h6>Account Heads:</h6>
                                    <div class="row" id="account_head">

                                        <div class="trashitem" v-for="acchead in accheads" @click="sAccHead=acchead.id" v-bind:class="{'ractive':sAccHead==acchead.id}">
                                            <div class="rcorners2">
                                                {{acchead.desc}}
                                            </div>
                                        </div>
                                    </div>-->


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
                                            <b style="font-size: 18px;"><template v-if="this.shouldiappear==1">{{this.grandtotal}}</template><template v-else>{{this.tempgrandtotal}}</template></b>
                                            <br>
                                            <span style="font-size: 16px; text-transform: uppercase;"><template v-if="this.shouldiappear==1">({{toWords(this.grandtotal)}})</template><template v-else>({{toWords(this.tempgrandtotal)}})</template></span>
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
                                        <template v-if="this.shouldiappear==1">
                                                <template v-if="parseFloat(amount_received)>(grandtotal)">
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="(grandtotal)-parseFloat(amount_received)" id="return_value" autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="0" id="return_value" autocomplete="off">
                                                </template>
                                        </template>
                                        <template v-else>
                                                <template v-if="parseFloat(amount_received)>(tempgrandtotal)">
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="(tempgrandtotal)-parseFloat(amount_received)" id="return_value" autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="0" id="return_value" autocomplete="off">
                                                </template>
                                        </template>
                                        </div>
                                    </div>
                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;"> Receipt Amount: </b> </label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                            <template v-if="this.shouldiappear==1">
                                                <template v-if="parseFloat(amount_received)>(grandtotal)">
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="(grandtotal)-parseFloat(amount_received)+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="0+parseFloat(amount_received)"  autocomplete="off" readonly>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <template v-if="parseFloat(amount_received)>(tempgrandtotal)">
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="(tempgrandtotal)-parseFloat(amount_received)+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="0+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
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
<template v-if="this.printedornot==2 && this.shouldiappear==1">
    <input @click="receive_payment_datatable(id); this.$forceUpdate();" :class="'btn-info'" type="submit" name="save" class="btn" :value="'Edit & Receive'">
</template>
                                    <template v-else>
                                        <input @click="receive_payment(id); this.$forceUpdate();" :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Receive':'Receive'">
                                        <!--<input @click="unpay_payment(id)" :class="id?'btn-danger':'btn-danger'" type="submit" name="save" class="btn" :value="id?'Unpaid':'Unpaid'">-->
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>


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
                                    <!--<h6>Account Heads:</h6>
                                    <div class="row" id="account_head">

                                        <div class="trashitem" v-for="acchead in accheads" @click="sAccHead=acchead.id" v-bind:class="{'ractive':sAccHead==acchead.id}">
                                            <div class="rcorners2">
                                                {{acchead.desc}}
                                            </div>
                                        </div>
                                    </div>-->


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
                                            <b style="font-size: 18px;"><template v-if="this.shouldiappear==1">{{this.grandtotal}}</template><template v-else>{{this.tempgrandtotal}}</template></b>
                                            <br>
                                            <span style="font-size: 16px; text-transform: uppercase;"><template v-if="this.shouldiappear==1">({{toWords(this.grandtotal)}})</template><template v-else>({{toWords(this.tempgrandtotal)}})</template></span>
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
                                            <template v-if="this.shouldiappear==1">
                                                <template v-if="parseFloat(amount_received)>(grandtotal)">
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="(grandtotal)-parseFloat(amount_received)" id="return_value" autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="0" id="return_value" autocomplete="off">
                                                </template>
                                            </template>
                                            <template v-else>
                                                <template v-if="parseFloat(amount_received)>(tempgrandtotal)">
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="(tempgrandtotal)-parseFloat(amount_received)" id="return_value" autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="return_value" class="form-control input-height" placeholder="Balance" :value="0" id="return_value" autocomplete="off">
                                                </template>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><b style="font-size: 16px;"> Receipt Amount: </b> </label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                            <template v-if="this.shouldiappear==1">
                                                <template v-if="parseFloat(amount_received)>(grandtotal)">
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="(grandtotal)-parseFloat(amount_received)+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="0+parseFloat(amount_received)"  autocomplete="off" readonly>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <template v-if="parseFloat(amount_received)>(tempgrandtotal)">
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="(tempgrandtotal)-parseFloat(amount_received)+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
                                                <template v-else>
                                                    <input type="number" name="cash_receipt_amt" class="form-control input-height" placeholder="Receipt Amount" :value="0+parseFloat(amount_received)" readonly autocomplete="off">
                                                </template>
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
                                    <template v-if="this.printedornot==2 && this.shouldiappear==1">
                                        <input @click="receive_payment_datatable(id); this.$forceUpdate();" :class="'btn-info'" type="submit" name="save" class="btn" :value="'Edit & Receive'">
                                    </template>
                                    <template v-else>
                                        <input @click="receive_payment(id); this.$forceUpdate();" :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Receive':'Receive'">
                                        <!--<input @click="unpay_payment(id)" :class="id?'btn-danger':'btn-danger'" type="submit" name="save" class="btn" :value="id?'Unpaid':'Unpaid'">-->
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div v-if="shiftAlertEnd">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>ARE YOU SURE ?</strong></h5>
                                    <button type="button" class="close" @click="shiftAlertEnd=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span>You are about to End the Shift of the Date {{this.shift | moment("DD/MM/YYYY")}} !</span>

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <input @click="end_shift(); showStartShift=false; shiftAlertEnd=false;"  :class="' btn btn-success'" type="button" :value="'YES'">
                                    <button type="button" class="btn btn-danger" @click="shiftAlertEnd=false">NO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div v-if="shiftAlert">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>ARE YOU SURE ?</strong></h5>
                                    <button type="button" class="close" @click="shiftAlert=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span>You are about to Start a New Shift of the Date {{new Date | moment("DD/MM/YYYY")}} !</span>

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <input @click="start_shift(); showEndShift=false; shiftAlert=false;"  :class="' btn btn-success'" type="button" :value="'YES'">
                                    <button type="button" class="btn btn-danger" @click="shiftAlert=false">NO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <template v-if="this.shift==''">
            <div v-if="showStartShift">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title"><strong>SHIFT DETAILS:</strong></h5>
                                        <button type="button" class="close" @click="showStartShift=false">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                            <span>Please Start a Shift to Continue taking Orders !</span>

                                        <br>

                                    </div>
                                    <div class="modal-footer">
                                        <input @click="shiftAlert=true; showStartShift=false;"  :class="' btn btn-success'" type="button" :value="'START SHIFT'">
                                        <button type="button" class="btn btn-secondary" @click="showStartShift=false">CANCEL</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </template>
        <template v-else>
            <div v-if="showEndShift">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>SHIFT DETAILS:</strong></h5>
                                    <button type="button" class="close" @click="showEndShift=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                        <span>The Current Shift is of the Date {{this.shift | moment("DD/MM/YYYY")}}.<br>Press "End Shift" if you do not want to continue this Shift !</span>

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <input @click="shiftAlertEnd=true; showEndShift=false;" :class="'btn btn-danger'" type="button" :value="'END SHIFT'">
                                    <button type="button" class="btn btn-info" @click="showEndShift=false">CONTINUE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            </div>
        </template>


        <div v-if="showModaltoMove">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">MOVE TABLE:</h5>
                                    <button type="button" class="close" @click="showModaltoMove=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <label class="col-sm-4 form-control-label">Table #:</label> <div class="col-sm-8 mg-t-10 mg-sm-t-0"><b>{{tables.filter((a)=>{return a.id==this.sTable}).length>0?tables.filter((a)=>{return a.id==this.sTable})[0].desc:''}}</b></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-4 form-control-label">Restaurant Tables:</label>
                                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                            <select v-model="sResturant" id="restaurant_location" name="restaurant_location" class="form-control select2">
                                              <!--  <option label="Choose Option" value="0"></option>-->

                                                <option v-for="rest in resturants" :value="rest.id">
                                                    {{rest.desc}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 arrowsResturant" v-if="tables.length>18">
                                            <span @click="tableMargin/60<0?tableMargin=tableMargin+60:''"><i class="fas fa-chevron-circle-left fa-3x" style="color:cadetblue"></i></span>
                                            <span @click="Math.abs(tableMargin/60)+1<(parseInt(tables.length/18)+(tables.length%18>0?1:0))?tableMargin=tableMargin-60:''"><i class="fas fa-chevron-circle-right fa-3x" style="color:cadetblue"></i></span>


                                        </div>

                                    </div>
                                    <hr>
                                    <div id="table_definition" class="scrollclassrests">

                                        <div :style="'height:61px'"  id="content" ref="content">
                                            <div :style="'    position: relative;\n'+
'    float: left;\n'+
'    height: 61px;margin-top:'+tableMargin+'px'">
                                                <div class="scrollsubrests" v-for="table in tables" >

                                                    <template v-if="bookedTables.length>0 && bookedTables.indexOf(String(table.id))!=-1">

                                                    </template>
                                                    <template v-else-if="printedTables.length>0 && printedTables.indexOf(String(table.id))!=-1">

                                                    </template>
                                                    <template v-else>
                                                        <div class="tabledefs" @click="sTable=table.id;"
                                                             v-bind:class="{'active':sTable==table.id}">

                                                            {{table.desc}}
                                                        </div>
                                                    </template>

                                                </div>
                                            </div>
                                        </div>

                                    </div> <hr>
<br>
                                </div>
                                <div class="modal-footer">

                                    <input @click="update_movetable(id)" :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Move':'Move'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    <div class="row">
        <div class="hideShow" @click="hideHeader=!hideHeader" >

            <template v-if="!hideHeader">
                <svg class="bi bi-eye-slash-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="//www.w3.org/2000/svg">
                    <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
                    <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                </svg>      </template>
            <template v-else>
                <svg class="bi bi-eye-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="//www.w3.org/2000/svg">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                </svg>            </template>



        </div>
        <div class="col-sm-5">
            <div class="form-layout form-layout-4 blackcolor">
                <div class="row">
                    <label class="col-sm-4 form-control-label">Restaurant Tables:</label>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <select v-model="sResturant" id="restaurant_location" name="restaurant_location" class="form-control select2">

                            <option v-for="rest in resturants" :value="rest.id">
                                {{rest.desc}}
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-4 arrowsResturant" v-if="tables.length>12">
                        <span @click="tableMargin/60<0?tableMargin=tableMargin+60:''"><i class="fas fa-chevron-circle-left fa-3x" style="color:cadetblue"></i></span>
                        <span @click="Math.abs(tableMargin/60)+1<(parseInt(tables.length/12)+(tables.length%18>0?1:0))?tableMargin=tableMargin-60:''"><i class="fas fa-chevron-circle-right fa-3x" style="color:cadetblue"></i></span>


                    </div>

                </div>
                <hr style="margin: 4px 0px;">
                <div id="table_definition" class="scrollclassrests">

                        <div :style="'height:61px'"  id="content" ref="content">
<div :style="'    position: relative;\n'+
'    float: left;\n'+
'    height: 61px;margin-top:'+tableMargin+'px'">
                        <div class="scrollsubrests" v-for="table in tables" >

                            <template v-if="bookedTables.length>0 && bookedTables.indexOf(String(table.id))!=-1">
                                <div class="tabledefs booked" @click="booked_open(table.id); sTable=table.id;"
                                     v-bind:class="{'active':sTable==table.id}">

                                    {{table.desc}}
                                </div>
                            </template>
                            <template v-else-if="printedTables.length>0 && printedTables.indexOf(String(table.id))!=-1">
                                <div class="tabledefs printed" @click="printed_open(table.id); sTable=table.id;"
                                     v-bind:class="{'active':sTable==table.id}">

                                    {{table.desc}}
                                </div>
                            </template>
                            <template v-else>
                                <div class="tabledefs" @click="table_open(table.id); sTable=table.id;"
                                     v-bind:class="{'active':sTable==table.id}">

                                    {{table.desc}}
                                </div>
                            </template>

                        </div>
</div>
                    </div>

                </div>
            </div>
            <br>

            <div class="form-layout form-layout-4 blackcolor">
                <div class="row">
                    <div class="col-md-3">
                        <label class="rdiobox">
                            <input type="radio" name="type" v-model="type" value="0"><span class="pabs">Member</span></label>
                        <label class="rdiobox">
                            <input type="radio" name="type" v-model="type" value="1"><span class="pabs">Guest   <a href="/room-management/room-customer/room-customer-aeu" target="popup" onclick="window.open('/room-management/room-customer/room-customer-aeu','popup','width=450,height=550'); return false;"><i class="fa fa-plus"></i></a> <!--<a href="/room-management/room-customer/room-customer-aeu" target="_blank" class="btn btn-xsss btn-info"><i class="fa fa-plus"></i></a>--></span>
                        </label>
                        <label class="rdiobox">
                            <input type="radio" name="type" v-model="type" value="3"><span class="pabs">Employee</span>
                        </label>


                    </div>

                    <div class="col-md-9">
                        <div class="form-group">

                            <input v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" :placeholder="'Search '+(type==0?'Member':type==1?'Guest':'Employee')">


                            <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0">

                                <li @click="customerdatavalue(c.id)" v-for="c in customers">
                                    {{c.name}}
                                </li>
                            </ul>


                        </div>
                        <div class="form-group float-left"  style="width:49%">
                            <input v-model="customer_id" class="form-control"  name="customer_id" id="customer_id" type="text" :placeholder="(type==0?'Member':type==1?'Guest':'Employee')+' ID'" readonly>
                            <input v-model="member_id" name="member_id" id="member_id" type="hidden"></div>

                    <div class="form-group float-right" style="width:49%">
                        <input class="form-control" :placeholder="(type==0?'Member':type==1?'Guest':'Employee')+' Ledger Amount'" readonly v-model="ledger_amount" name="ledger_amount" id="ledger_amount" type="number"></div>
                        <div class="form-group">
                    <select  id="family" class="form-control family" v-model="family">
                        <option label="Choose Family Member" value="0">  </option>
                        <option :value="fam.id" v-for="fam in families">
                            {{fam.name}} - {{fam.relationship_name.desc}}
                        </option>
                    </select>
                </div>





            </div>
            </div>





               <hr style="margin: 5px 0px">

                <div class="row">
                  <div class="col-sm-12">  <div class="header"><b>CAPTAINS / ORDER TAKERS</b>
                     <div class="float-right" style="margin-right:10px">
                         <span @click="captainMargin/50<0?captainMargin=captainMargin+50:''">
                      <i class="fas fa-chevron-circle-left "  style="color:#fff"></i>
                      </span>
                          <span @click="Math.abs(captainMargin/50)+1<(parseInt(waiters.length/3)+(waiters.length%3>0?1:0))?captainMargin=captainMargin-50:''"><i class="fas fa-chevron-circle-right "  style="color:#fff"></i></span>
                  </div></div>
                  </div>
                </div>

                <div class="scrollclass">

                    <div class="inner" :style="'margin-top:'+captainMargin+'px'">


                    <div class="scrollsub waiterdiv waiter" :style="'width:142px; text-align:center;padding: calc(142px - 121px - '+(waiter.name.length>18?21:10)+'px);'" v-for="waiter in waiters"  @click="sWaiter=waiter.id" v-bind:class="{'active':sWaiter==waiter.id}">
                        <b>{{waiter.name}}</b>
                    </div>
                    </div>


                </div>


                <hr style="margin: 5px 0px">

                <div class="">
                    <div style="display: inline-block;
    width: 142px;
    text-align: center;padding: 0px;

    height: 27px;" class="rcorners1 ordertype" v-for="type in orderType"   @click="sType=type" v-bind:class="{'active':sType==type}">
                        <b>{{type}}</b>
                    </div>

                </div>

                <hr style="margin: 5px 0px">


                    <div class="col-sm-12">
                        <div class="float-right">
                            <button @click="removetr(active_el);" class="btn btnfont"><b>/</b></button>
                        <button @click="updatetrplus(active_el);" class="btn btnfont"><b>+</b></button>
                        <button @click="updatetrminus(active_el)" class="btn btnfont"><b>-</b></button>
                        <button class="btn btnfont" id="show-modal" @click="modalopen()"><b>i</b></button>

                        <template v-if="this.cancelpermit">
                            <button @click="updatetrstatus(active_el)" class="btn btnfont"><i class="fa fa-times"></i></button>
                        </template>
                    </div>
                    </div>
                <div class="clearfix"></div>
                    <div class="scrollclasstable1" :class="{scrollclasstable2: this.selected_items.length>0 }">
                        <div>
                        <table>
                            <thead :style="'font-size:16px'">
                            <tr bgcolor="#5f9ea0">

                                <th class="wd-10p">SR #</th>
                                <th class="wd-10p">CODE</th>
                                <th class="wd-5p">QTY</th>
                                <th class="wd-20p">ITEM</th>
                                <th class="wd-10p">PRICE</th>
                                <th class="wd-10p">SUB-TOTAL</th>
                                <th class="wd-10p">DISC</th>
                                <th class="wd-10p">TOTAL</th>
                                <th class="wd-20p">INSTRUCTIONS</th>
                                <th class="wd-10p">KOT #</th>
                                <th class="wd-5p">STATUS</th>
                                <th class="wd-5p">REMARK</th>
                                <th class="wd-5p">AFTER CANCELLATION</th>
                            </tr>
                            </thead>
                            <tbody :style="'font-size:15px'">
                            <tr  @click="activate(key)" :class="{ activatedtr : active_el == key }" v-for="(tr,key) in selected_items">
                                <!--<td><i class="fa fa-trash"></i></td>-->
                                <td>{{selected_items.length-key}}</td>
                                <td>{{tr.item_code}}</td>
                                <td >{{tr.qty}}</td>
                                <td><span style="display: block;
    width: 200px;
    text-overflow: ellipsis;
    overflow: hidden; " :title="tr.item_details">{{tr.item_details}}</span></td>
                                <td>{{Math.round(tr.sale_price)}}</td>
                                <td>{{tr.product=Math.round(tr.qty*tr.sale_price)}}</td>
                                <td>{{tr.varDisc= (Math.round((tr.item_discount) * 100) / 100).toFixed(1)}}</td>
                                <td>{{tr.totalamt = (Math.round((tr.product-tr.varDisc) * 100) / 100).toFixed(1)}}</td>
                               <!-- <td><span v-if="tr.taxable==1"><span v-if="taxandservice.tax_amount">{{tr.varTax=Math.round(taxandservice.tax_amount)}}</span> <span v-if="taxandservice.tax_percentage">{{tr.varTax=Math.round((taxandservice.tax_percentage/100)*tr.totalamt)}}</span></span> <span v-else> 0</span>  </td>
                                --><td>{{tr.instruction}}</td>
                                <td>{{!tr.kot_no?tr.kot=kot+1:tr.kot=tr.kot_no}}</td>

                                <td>{{tr.status}}</td>
                                <td>{{tr.remark}}</td>
                                <td>{{tr.aftercancel}}</td>

                            </tr>

                            </tbody>
                        </table>
                        </div>
                    </div>



            </div>





        </div>
        <div class="col-sm-4">

            <div class="form-layout form-layout-4 blackcolor">

                <div class="float-left"><h5>Invoice #: {{increment_number}}</h5></div><div class="float-right"><h5>Table #: {{tables.filter((a)=>{return a.id==this.sTable}).length>0?tables.filter((a)=>{return a.id==this.sTable})[0].desc:''}}</h5></div> <br> <br>
                <template v-if="!this.id">
                    <div class="float-left"><b>Date:</b> <template v-if="this.shift!=''">{{this.shift | moment("DD/MM/YYYY")}}</template></div>  <div class="float-right"><b>Time:</b> {{ this.time= moment().format("hh:mm:ss A")}}</div> <br>
                </template>
                <template v-else>
                    <div class="float-left"><b>Date:</b> {{this.date | moment("DD/MM/YYYY")}}</div>  <div class="float-right"><b>Time:</b> {{this.time}}</div> <br>
                </template>

                <div class="float-left"><b>Restaurant:</b> {{sResturantName}}</div>

                <div class="float-right"><b>Captain:</b> {{waiters.filter((a)=>{return a.id==this.sWaiter}).length>0?waiters.filter((a)=>{return a.id==this.sWaiter})[0].name:''}}</div>
                <br>


                <div class="float-left">
                    <b>Gross:</b> {{varGross =selected_items.length>0?sum(pluck(selected_items,'product')):0}}
                </div>
                <div class="float-right">
                    <b>Tax:</b><!-- {{vartaxed = selected_items.length>0?sum(pluck(selected_items,'varTax')):0}}-->
                    <template v-if="this.sType=='Dine-In'">
                    <span v-if="taxandservice.tax_amount">{{vartaxedamt=taxandservice.tax_amount}}</span> <span v-if="taxandservice.tax_percentage">{{vartaxedpct=taxandservice.tax_percentage}}% ({{vartaxedamt=Math.round(parseFloat((vartaxedpct/100)*((subtotal))) )}})</span>
                    </template>
                    <template v-else-if="this.sType=='Take Away'">
                        <span v-if="taxandservice.take_away_tax">{{vartaxedamt=taxandservice.take_away_tax}}</span> <span v-if="taxandservice.take_away_tax_pct">{{vartaxedpct=taxandservice.take_away_tax_pct}}% ({{vartaxedamt=Math.round(parseFloat((vartaxedpct/100)*((subtotal))) )}})</span>
                    </template>
                    <template v-else-if="this.sType=='Home Delivery'">
                    <span v-if="taxandservice.home_del_tax">{{vartaxedamt=taxandservice.home_del_tax}}</span> <span v-if="taxandservice.home_del_tax_pct">{{vartaxedpct=taxandservice.home_del_tax_pct}}% ({{vartaxedamt=Math.round(parseFloat((vartaxedpct/100)*((subtotal))) )}})</span>
                    </template>
                    <template v-else>
                    {{vartaxedamt=vartaxedpct=0}}
                    </template>

                </div>

<br>
                <div class="float-left">
                    <b>Disc:</b>  {{vardiscounted = Math.round(selected_items.length>0?sum(pluck(selected_items,'varDisc')):0)}}
                </div>
                <div class="float-right">
                    <b>Service Charges:</b>
                    <template v-if="taxandservice.service_amount">{{varserviced=taxandservice.service_amount}}</template>
                    <template v-else-if="taxandservice.service_percentage">{{varserviced_pct=taxandservice.service_percentage}}%</template>
                    <template v-else>
                        {{varserviced=varserviced_pct=0}}
                    </template>
                </div>

                <br>
                <div class="float-left">
                    <b>Sub Total:</b> {{subtotal = Math.round(varGross - vardiscounted)}}
                </div>
                <br>

                <div class="float-left">
                    <h5>Grand Total:
                        <template v-if="!vartaxedpct==''">
                            <template v-if="!varserviced==''">{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat(vartaxedamt) + parseFloat(varserviced))}}</template>
                            <template v-else-if="!varserviced_pct==''">{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat(vartaxedamt) + parseFloat((varserviced_pct/100)*subtotal))}}</template>
                            <template v-else>{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat((vartaxedpct/100)*subtotal) )}}</template>
                        </template>
                        <template v-else-if="vartaxedamt==''">
                            <template v-if="!varserviced==''">{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat(vartaxedamt) + parseFloat(varserviced))}}</template>
                            <template v-else-if="!varserviced_pct==''">{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat(vartaxedamt) + parseFloat((varserviced_pct/100)*subtotal))}}</template>
                            <template v-else>{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat(vartaxedamt) )}}</template>
                        </template>
                        <template v-else>
                            <template v-if="!varserviced==''">{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat(varserviced))}}</template>
                            <template v-else-if="!varserviced_pct==''">{{grandtotal = Math.round(parseFloat(subtotal) + parseFloat((varserviced_pct/100)*subtotal))}}</template>
                            <template v-else>{{grandtotal = Math.round(parseFloat(subtotal) )}}</template>
                        </template>
                    </h5>
                </div>
<br>


            </div>

            <br>


            <div class="form-layout form-layout-4 blackcolor">
                <div class="form-group"> <div class="form-group float-left"  style="width:25%"><input @input="enterquantity(active_el)" class="form-control" v-model="quantity" name="quantity" id="quantity" type="number" tabindex="1" placeholder="Qty."></div><div class="form-group float-left"  style="width:1%"></div> <div class="form-group float-left"  style="width:25%"><input v-model="covers" name="covers" class="form-control" id="covers" type="number" placeholder="Covers"></div>
                    <div class="form-group float-left"  style="width:1%"></div><div class="form-group float-right"  style="width:48%"><input v-model="discountcard" name="discountcard" id="discountcard" value="" class="form-control typeahead" autocomplete="off" type="text" placeholder="Search Card #">
                        <ul id="areabox2" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="discountcards.length>0">

                            <li @click="discountcardvalue(dc.id)" v-for="dc in discountcards">
                                {{dc.discountcard}}
                            </li>
                        </ul></div> </div>

                <div class="form-group"> <div class="form-group float-left"  style="width:51%">
                    <input @input="discountcardamt()" autocomplete="off" class="form-control" v-model="disc" name="disc" id="disc" placeholder="Disc. Amt" type="text">

                </div>
                    <div class="form-group float-left"  style="width:1%"></div><div class="form-group float-left"  style="width:48%"><div class="pc" ><input @input="discountcardpc(active_el)" autocomplete="off" class="form-control" v-model="disc_pc" placeholder="Disc." name="disc_pc" id="disc_pc" type="text">
                   </div></div>

                </div>
                <div class="row"></div><hr style="margin: 5px 0px">
                <!--   <div class="row">
                       <label class="col-sm-3 form-control-label headingsettings">Category:</label>
                       <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                           <select v-model="sCategory"  id="category" name="category" class="form-control select2" >
                               <option label="Choose Option" value="0">
                               </option>
                               <option v-for="cat in mains" :value="cat.id">
                                   {{cat.desc}}
                               </option>

                           </select>
                       </div>
                   </div>-->

                <div class="row">
                    <div class="col-sm-12">  <div class="header"><b>CATEGORIES</b>


                        <div class="float-right" style="margin-right:10px" v-if="mains.length>6">
                         <span @click="categoryMargin/50<0?categoryMargin=categoryMargin+50:''">
                      <i class="fas fa-chevron-circle-left "  style="color:#fff"></i>
                      </span>
                            <span @click="Math.abs(categoryMargin/50)+1<(parseInt(mains.length/6)+(mains.length%6>0?1:0))?categoryMargin=categoryMargin-50:''"><i class="fas fa-chevron-circle-right "  style="color:#fff"></i></span>
                        </div></div>
                    </div>
                </div>
                <div class="scrollclasscategory">

                    <div class="inner" :style="'margin-top:'+categoryMargin+'px'">


                        <div  v-if="cat_permission.indexOf(cat.desc+' '+cat.id)!=-1" class="scrollsub catdiv waiter" :style="'width:110px; text-align:center;padding: calc(110px - 96px - '+(cat.desc.length>18?21:10)+'px);'"  v-for="cat in mains" @click="sCategory=cat.id" v-bind:class="{'active':sCategory==cat.id}">
                            <template>
                            <b>{{cat.desc}}</b>
                            </template>
                        </div>


                    </div>


                </div>

                <hr style="margin: 5px 0px">

                <div class="row">
                    <div class="col-sm-12">  <div class="header"><b>SUB-CATEGORIES</b>
                        <div class="float-right" style="margin-right:10px" v-if="subcats.length>6">
                         <span @click="SubcategoryMargin/50<0?SubcategoryMargin=SubcategoryMargin+50:''">
                      <i class="fas fa-chevron-circle-left "  style="color:#fff"></i>
                      </span>
                            <span @click="Math.abs(SubcategoryMargin/50)+1<(parseInt(subcats.length/6)+(subcats.length%6>0?1:0))?SubcategoryMargin=SubcategoryMargin-50:''"><i class="fas fa-chevron-circle-right "  style="color:#fff"></i></span>
                        </div></div>
                    </div>
                </div>
                <div class="scrollclasscategory">

                    <div class="inner" :style="'margin-top:'+SubcategoryMargin+'px'">


                        <div class="scrollsub catdiv waiter" :style="'width:110px; text-align:center;padding: calc(110px - 96px - '+(sub.desc.length>18?21:10)+'px);'"  v-for="sub in subcats.filter((a)=>{return a.item_category==this.sCategory})" @click="sSubCat=sub.id" v-bind:class="{'active':sSubCat==sub.id}">
                            <b>{{sub.desc}}</b>
                        </div>
                    </div>


                </div>
               <!-- <div class="scrollclassy" id="sub_category">
                    <div class="inner" :style="'height: 150px'">
                <div class="trashitem scrollsuby" v-for="sub in subcats.filter((a)=>{return a.item_category==this.sCategory})" @click="sSubCat=sub.id" v-bind:class="{'ractive3':sSubCat==sub.id}">
                    <div class="rcornersNew">
                        {{sub.desc}}
                    </div>
                </div>
                    </div>
                </div>-->


            </div>
            <div class="form-layout form-layout-4">
                <div class="row finishbuttons">
                    <div class="col-sm-12">
                        <template v-if="(this.printedornot!=2) && this.caneditsale">
                            <input @click="save_sales(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Edit Order':'Save Order'">

                        </template>

                        <template v-if="(this.printedornot==2 && this.caneditsale) && this.shouldiappear==1">
                            <input @click="save_sales_datatable(id)"  :class="'btn-primary'" type="submit" name="save" class="btn" :value="'Edit Order'">

                        </template>
                        <template v-if="(this.id && this.printedornot==0) || (this.id && this.caneditsale)">
                            <button @click="move_table(id)" class="btn btn-warning">Move Table</button>

                        </template>
                        <template v-if="(this.id && this.printedornot==0) || (this.id && this.caneditsale)">
                            <button @click="generate_invoice(id)" class="btn btn-secondary">Generate Bill</button>

                        </template>
                        <template v-if="(this.id && this.printedornot==1)">
                            <button class="btn btn-secondary" @click="modalpaymentopen()">Receive Payment</button>

                        </template>




                        <a href="/food-and-beverage/sales/sales-aeu"><button class="btn btn-secondary">Refresh</button></a>

                        <template v-if="this.id">
                            <button v-if="this.id" @click="reprintkot(id)"   class="btn btn-secondary">Re-Issue KOT</button>

                        </template>
                        <a href="/food-and-beverage/sales-list-vue" target="_blank"><button class="btn btn-secondary">Re-Issue Bill</button></a>

                       <!-- <a href="/food-and-beverage"><button class="btn btn-secondary">Exit</button></a>-->

                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm-3">

            <div class="form-layout form-layout-4" >

                <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input  type="text" class="form-control typeahead" autocomplete="off" v-model="search" tabindex="2" v-on:keyup.enter="itemsdatavalueEnter(search)" name="search" placeholder="Enter to Search...">
                    <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searcheditemsdefs.length>0">

                        <li @click="itemsdatavalue(itd.id)" v-for="itd in searcheditemsdefs">
                            {{itd.item_code}} - {{itd.item_details}}
                        </li>
                    </ul>
                </div>
    <br>
                <div class="header"><b>ITEMS</b></div>
                <div id="item_id" class="scrollclassy">
                    <div class="inner" :style="'height: 553px'">
                    <div class="form-layout form-layout-4 cursor blackcolor scrollsub" @click="save_to_selected(item);" v-for="item in itemdefs" style="background-color: powderblue;">
                        {{item.item_code}} -
                        <span class="itemname"><b>{{item.item_details}}</b></span><!--&nbsp&nbsp (Disc:<span v-if="item.discountable==1"> <span v-if="item.discount_amount">{{item.discount_amount}})</span> <span v-if="item.discount_percentage">{{item.discount_percentage}}%)</span></span> <span v-else> 0)</span>-->
                        <br>
                      RS.  {{item.sale_price}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div v-if="printing" class="overlay" style="    position: fixed;
    top: 0;
    height: 100%;
    width: 100%;
    background: #00000080;
    left: 0;
    font-size: 200px;
    text-align: center;
    padding-top: 34vh;z-index:99999">
            <i class="fa fa-print"></i>

        </div>
    </div>
</template>

<script>
    export default {
        name: "sales",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;

          return  {
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
              hideHeader:false,
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
            sResturant:function(){
                let self=this;
               /* this.sResturantName=this.resturants.filter(function(a){return a.id==self.sResturant})[0].desc;*/
                this.getTables();
            },
            sCategory:function(){
              //  this.getSubCats();
            },
           /* sAccHead:function(){
                this.getAccountTyes();
            },*/
            sSubCat:function(){
                if(this.sSubCat!=''){
                    this.getItemDefs();
                }

            },
            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                }
                if(this.customer.length>2 && !this.alreadySearched){
                this.customerdata();
                }
            },
            discountcard:function(){
                if(this.discountcard==0){
                    this.alreadySearchedDisc=false;
                }
                if(!this.alreadySearchedDisc && this.discountcard>0 ) {
                    this.discountdata();
                }
            },
            search:function(){
                if(this.search.length==0){
                    this.itemalreadySearched=false;
                }
                if(this.search.length>2 && !this.itemalreadySearched){
                    this.itemsdata();
                }
            },
            hideHeader:function(){

                    $('.breadcrumbee,.border-menu,.br-header,.br-logo,img[title="Reload Page"]').toggle();
                    $('.br-pagebody').css({'padding':'0px','margin':'0px'})

            }
        },

        methods: {
            amIOnline(e) {
                this.onLine = e;
            },
            slideright: function () {
                $('.scrollclass').addClass('slideright');

            },
            table_open: function (tableid) {
                this.init();
                /*
window.location.href='/food-and-beverage/sales/sales-aeu?t='+tableid;*/
            },
            booked_open: function (tableid) {
                let data = {};
                let url = '/food-and-beverage/sales/sales-aeu/booked/' + tableid;
                data.id = tableid;

                this.$http.get(url, data).then(result => {
                    this.init(result.data);
                    /* window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
                });

            },
            printed_open: function (tableid) {
                let data = {};
                let url = '/food-and-beverage/sales/sales-aeu/printed/' + tableid;
                data.id = tableid;

                this.$http.get(url, data).then(result => {
                    this.init(result.data);
                    /*window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
                });

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
                    return_value: this.amount_received > this.tempgrandtotal ? parseFloat(this.tempgrandtotal) - parseInt(this.amount_received) : 0,
                    cash_receipt_amt: this.amount_received > this.tempgrandtotal ? parseFloat(this.tempgrandtotal)-parseInt(this.amount_received)+parseInt(this.amount_received): 0+parseInt(this.amount_received),
                    customer: this.customer,
                    date: m?this.date:this.shift[0],
                    type: this.type,
                    customer_id: this.customer_id,
                    ledger_amount: this.ledger_amount,
                    member_id: this.member_id,
                    family: this.family,
                    amount_received: this.amount_received ? this.amount_received : 0,
                    remarks: this.remarks,
                    sAccHead: this.acctypes.filter((a) => {
                        return a.id == this.sAccType
                    }).length > 0 ? this.acctypes.filter((a) => {
                        return a.id == this.sAccType
                    })[0].desc : '',
                    sAccType: this.sAccType,
                    amount_in_words: this.toWords(this.grandtotal)

                };
                let url = '/food-and-beverage/sales/sales-aeu/receive';
                if (m) {
                    url = '/food-and-beverage/sales/sales-aeu/receive';
                    data.id = this.id;
                }
                if(this.validation(data,['sAccType'])==0){
                this.$http.post(url, data).then(result => {
                    this.init();
                    /* window.location.href = "/food-and-beverage/sales/sales-aeu";*/
                });
                 }
            },
            receive_payment_datatable: function (m) {
            let data = {
                return_value: this.amount_received > this.grandtotal ? parseFloat(this.grandtotal) - parseInt(this.amount_received) : 0,
                cash_receipt_amt: this.amount_received > this.tempgrandtotal ? parseFloat(this.tempgrandtotal)-parseInt(this.amount_received)+parseInt(this.amount_received): 0+parseInt(this.amount_received),
                amount_received: this.amount_received ? this.amount_received : 0,
                remarks: this.remarks,
                sAccHead: this.acctypes.filter((a) => {
                    return a.id == this.sAccType
                }).length > 0 ? this.acctypes.filter((a) => {
                    return a.id == this.sAccType
                })[0].desc : '',
                sAccType: this.sAccType,
                amount_in_words: this.toWords(this.grandtotal),

                selected_items: this.selected_items,
                date: m?this.date:this.shift[0],
                time: m?this.time:moment().format("h:mm:ss A"),
                customer: this.customer,
                type: this.type,
                customer_id: this.customer_id,
                ledger_amount: this.ledger_amount,
                member_id: this.member_id,
                family: this.family,
                covers: this.covers,
                discountcard: this.discountcard,
                disc: this.disc,
                disc_pc: this.disc_pc,
                sResturant: this.sResturant,
                sTable: this.sTable,
                sWaiter: this.sWaiter,
                sCategory: this.sCategory,
                sSubCat: this.sSubCat,
                sType: this.sType,
                gross: this.selected_items.length > 0 ? this.sum(this.pluck(this.selected_items, 'product')) : 0,
                discount: this.selected_items.length > 0 ? this.sum(this.pluck(this.selected_items, 'varDisc')) : 0,
                subtotal: this.varGross - this.vardiscounted,
                tax: this.vartaxedamt,
                service: this.varserviced,
                service_pct: this.varserviced_pct,
                grandtotal: this.grandtotal,
            };

                let url = '/food-and-beverage/sales/sales-aeu/updateandreceive';
                data.id = this.id;

            if(this.validation(data, ['customer', 'customer_id', 'sTable', 'sType', 'selected_items','sAccType']) == 0)
    {
        this.$http.post(url, data).then(result => {

            /* if(m){
                 window.open("/food-and-beverage/sales/sales-kot/"+m, "_blank");
             }
             else{
                 window.open("/food-and-beverage/sales/sales-kot/"+result.data, "_blank");
             }*/


            /*this.$http.post('localhost:5000/upload',{headers:{
                    'Access-Control-Allow-Origin': '*'
                },data:{printer:this.subcats.filter((a)=>{return a.id==this.sSubcat}).length>0?this.subcats.filter((a)=>{return a.id==this.sSubCat})[0].printer:'',file:"fb/sales/saleskot/"+m}}).then(result=>{
     });*/

            /*
                    window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
            /*this.printing=true;*/
            if (m) {
                let sub_cats = this.pluck(this.selected_items, 'sub_category').filter((a, b, c) => {
                    return c.indexOf(a) === b
                })
                let printer = "//" + this.printerip + "/upload";
                let file = window.location.protocol+'//'+window.location.host+'/fb/sales/edittedsaleskot/';
                sub_cats.forEach((x, y) => {


                    let redirect = false;
                    if (y == sub_cats.length - 1) {
                        redirect = true
                    }

                    let p = this.subcats.filter((a) => {
                        return a.id == x
                    })[0].printer;
                    let kot = this.selected_items.filter((a) => {
                        return a.sub_category == x
                    })[0].kot
                    $.ajax({
                        type: 'get',
                        url: printer + '?printer=' + p + '&file=' + file + kot + '/' + x,
                        crossDomain: true,


                        success: function (data) {

                        }
                    });
                })
            } else {
                let sub_cats = this.pluck(this.selected_items, 'sub_category').filter((a, b, c) => {
                    return c.indexOf(a) === b
                })
                let printer = "//" + this.printerip + "/upload";
                let file = window.location.protocol+'//'+window.location.host+'/fb/sales/saleskot/';
                sub_cats.forEach((x, y) => {

                    let redirect = false;
                    if (y == sub_cats.length - 1) {
                        redirect = true
                    }
                    let p = this.subcats.filter((a) => {
                        return a.id == x
                    })[0].printer;
                    let kot = this.selected_items.filter((a) => {
                        return a.sub_category == x
                    })[0].kot
                    $.ajax({
                        type: 'get',
                        url: printer + '?printer=' + p + '&file=' + file + kot + '/' + x,

                        crossDomain: true,

                        success: function (data) {

                        }
                    });
                })
            }

            this.init();
            this.$snotify.async('Printing is in process !', 'Printing...', () => new Promise((resolve, reject) => {
                setTimeout(() => resolve({
                    title: 'Success!!!',
                    body: 'Printing successfully done !',
                    config: {
                        closeOnClick: true,
                        timeout: 2000
                    }
                }), 2000);
            }));
            // window.location.href = "/food-and-beverage/sales/sales-aeu";

            /* window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
        });


    }
    },
            unpay_payment:function(m){
                let data={
                    remarks:this.remarks,
                    sAccHead:this.sAccHead,
                    sAccType:this.sAccType

                };
                let url='/food-and-beverage/sales/sales-aeu/unpay';
                if(m){
                    url='/food-and-beverage/sales/sales-aeu/unpay';
                    data.id=this.id;
                }
                if(this.validation(data,['remarks'])==0){
                    this.$http.post(url,data).then(result=>{
                        location.reload();
                    });
                }

            },
            update_movetable:function(m){
                let data={

                    sResturant:this.sResturant,
                    sTable:this.sTable,

                };

                    let url='/food-and-beverage/sales/sales-aeu/move';
                    data.id=this.id;

                if(this.validation(data,['sTable'])==0){
                    this.$http.post(url,data).then(result=>{

                    });
                }

                this.init(m);
                this.showModaltoMove = false;
            /*    window.location.href = "/food-and-beverage/sales/sales-aeu/"+m;*/

            },
            save_sales:function(m){
                this.disableds=true;

                let data={
                    selected_items:this.selected_items,
                    date:m?this.date:this.shift[0],
                    shift:this.shift,
                    time:m?this.time:moment().format("h:mm:ss A"),
                    customer:this.customer,
                    type:this.type,
                    customer_id:this.customer_id,
                    ledger_amount:this.ledger_amount,
                    member_id:this.member_id,
                    family:this.family,
                    covers:this.covers,
                    discountcard:this.discountcard,
                    disc:this.disc,
                    disc_pc:this.disc_pc,
                    sResturant:this.sResturant,
                    sTable:this.sTable,
                    sWaiter:this.sWaiter,
                    sCategory:this.sCategory,
                    sSubCat:this.sSubCat,
                    sAccHead:this.sAccHead,
                    sAccType:this.sAccType,
                    sType:this.sType,
                    gross:this.selected_items.length>0?this.sum(this.pluck(this.selected_items,'product')):0,
                    discount:this.selected_items.length>0?this.sum(this.pluck(this.selected_items,'varDisc')):0,
                    subtotal:this.varGross-this.vardiscounted,
                    tax:this.vartaxedamt,
                    service:this.varserviced,
                    service_pct:this.varserviced_pct,
                    grandtotal:this.grandtotal,
                };
                let url='/food-and-beverage/sales/sales-aeu/save';
                if(m){
                    url='/food-and-beverage/sales/sales-aeu/update';
                    data.id=this.id;
                }
if(this.validation(data,['date', 'time','shift','customer' ,'customer_id','sTable','sType','selected_items'])==0){
    this.$http.post(url,data).then(result=>{

       /* if(m){
            window.open("/food-and-beverage/sales/sales-kot/"+m, "_blank");
        }
        else{
            window.open("/food-and-beverage/sales/sales-kot/"+result.data, "_blank");
        }*/


        /*this.$http.post('localhost:5000/upload',{headers:{
                'Access-Control-Allow-Origin': '*'
            },data:{printer:this.subcats.filter((a)=>{return a.id==this.sSubcat}).length>0?this.subcats.filter((a)=>{return a.id==this.sSubCat})[0].printer:'',file:"fb/sales/saleskot/"+m}}).then(result=>{
 });*/

/*
        window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
        /*this.printing=true;*/
if(m){
    let sub_cats=this.pluck(this.selected_items,'sub_category').filter((a,b,c)=>{return c.indexOf(a)===b})
    let printer="http://"+this.printerip+"/upload";
    let file =window.location.protocol+'//'+window.location.host+'/fb/sales/edittedsaleskot/';
    sub_cats.forEach((x,y)=>{


        let redirect=false;
        if(y==sub_cats.length-1){
            redirect=true
        }

        let p=this.subcats.filter((a)=>{return a.id==x})[0].printer;
        let inikot=this.selected_items.filter((a)=>{return a.sub_category==x})[0].kot;
        let checkedkot= result.data;


        console.log(checkedkot);

            $.ajax({
                type: 'get',
                url: printer+'?printer='+p+'&file='+file+checkedkot+'/'+x,
                crossDomain:true,


                success: function (data) {

                }
            });

    })
}
else{
    let sub_cats=this.pluck(this.selected_items,'sub_category').filter((a,b,c)=>{return c.indexOf(a)===b})
    let printer="http://"+this.printerip+"/upload";
    let file =window.location.protocol+'//'+window.location.host+'/fb/sales/saleskot/';
    sub_cats.forEach((x,y)=>{

        let redirect=false;
        if(y==sub_cats.length-1){
            redirect=true
        }
        let p=this.subcats.filter((a)=>{return a.id==x})[0].printer;
        let kot=this.selected_items.filter((a)=>{return a.sub_category==x})[0].kot;
        let checkedkot = result.data;
        $.ajax({
            type: 'get',
            url: printer+'?printer='+p+'&file='+file+checkedkot+'/'+x,

            crossDomain:true,

            success: function (data) {

            }
        });
    })
}


    this.init();
    this.sTable='';

        this.$snotify.async('Printing is in process !', 'Printing...', () => new Promise((resolve, reject) => {
            setTimeout(() => resolve({
                title: 'Success!!!',
                body: 'Printing successfully done !',
                config: {
                    closeOnClick: true,
                    timeout: 2000
                }
            }), 2000);
        }));
       // window.location.href = "/food-and-beverage/sales/sales-aeu";

             /* window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
    });


}
else{
    this.disableds=false;

}

            },
            save_sales_datatable:function(m) {
                this.FinalEditOrder = true;
            },
            reprintkot:function(m){
                let kot=this.selected_items[this.active_el].kot;
                    if(m){
                        window.open("/fb/sales/duplicatesaleskot/"+m+"/"+kot, "_blank");
                    }
                    this.init();

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
            start_shift:function(){
                let data={
                    date: moment().format("DD/MM/YYYY")
                };
                let url='/food-and-beverage/sales/start_shift';

                data.id=this.id;

                this.$http.post(url,data).then(result=>{
                    this.init();

                });

            },
            end_shift:function(){
                let data={
                    date:''
                };
                let url='/food-and-beverage/sales/end_shift';

                data.id=this.id;

                this.$http.post(url,data).then(result=>{

                    this.init();

                });

            },
            discountcardamt:function(){
                let pc_var = parseFloat((this.disc)/(this.varGross)*100);
                //console.log(pc_var);

                this.disc_pc=(Math.round((pc_var) * 100) / 100).toFixed(1);
                this.discountcardpc();

            },
            discountcardpc:function(){

                if(Math.round(this.disc_pc>50)) alert('More than 50% Discount is not allowed !');
                if(Math.round(this.disc_pc>50)) this.disc_pc=0;
                this.selected_items.forEach((x,y)=>{
                   /* console.log(this.selected_items[y].item_code);*/
                    this.$http.get('/food-and-beverage/sales/gettheitems/'+this.selected_items[y].item_code).then(result=>{
                        let edata=result.data;
                        if(edata){
                            this.selected_items[y].discountable=edata[0].discountable;
                            this.selected_items[y].discount_amount=edata[0].discount_amount;
                            this.selected_items[y].discount_percentage=edata[0].discount_percentage;

                            if(this.selected_items[y].discountable==1 && this.selected_items[y].discount_amount && parseFloat(((this.disc_pc/100)*this.selected_items[y].product))>=this.selected_items[y].discount_amount)
                                this.selected_items[y].item_discount =this.selected_items[y].discount_amount;
                            else if(this.selected_items[y].discountable==1 && this.selected_items[y].discount_amount && parseFloat(((this.disc_pc/100)*this.selected_items[y].product))<=this.selected_items[y].discount_amount)
                                this.selected_items[y].item_discount =parseFloat((this.disc_pc/100)*this.selected_items[y].product);
                            else if(this.selected_items[y].discountable==1 && this.selected_items[y].discount_percentage && parseFloat(((this.disc_pc/100)*this.selected_items[y].product))>=((this.selected_items[y].discount_percentage/100)*this.selected_items[y].product))
                                this.selected_items[y].item_discount =(this.selected_items[y].discount_percentage/100)*this.selected_items[y].product;
                            else if(this.selected_items[y].discountable==1 && this.selected_items[y].discount_percentage && parseFloat(((this.disc_pc/100)*this.selected_items[y].product))<=((this.selected_items[y].discount_percentage/100)*this.selected_items[y].product))
                                this.selected_items[y].item_discount = parseFloat((this.disc_pc/100)*this.selected_items[y].product);
                            else 0;
                        }
                    })

                })
            },
            modalopen:function(){
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
            move_table:function(){
                this.showModaltoMove = true;
            },
            modalok:function(){
                this.instruction='';
                this.showModal=false;
            },
            canceldone:function(){
                if(this.alternativeqty== this.selected_items[this.active_el].qty){
                    if(this.alternativeqty!=''){
                        let save = (JSON.parse(JSON.stringify(this.selected_items[this.active_el])));
                        let myitem =this.selected_items[this.active_el];
                        let alter = this.selected_items[this.active_el].qty - this.alternativeqty;
                        // let clone = (JSON.parse(JSON.stringify(myitem)));
                        myitem.status='Cancelled';
                        myitem.sale_price=0;
                        myitem.kot=null
                        myitem.qty=this.alternativeqty;
                        myitem.item_discount=0;
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

                            clone.subcategory=this.sSubCat;
                            this.selected_items.unshift(clone);



                        }
                        this.alternativeqty='';
                        this.instruction='';
                        this.sCancelledRemark=0;
                        this.aftercancel='Void';
                        this.showCancellationModal=false;
                        let self=this
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();



                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                            }

                        },100)
                    }
                }
                else{
                    if(this.alternativeqty!=''){
                        let save = (JSON.parse(JSON.stringify(this.selected_items[this.active_el])));
                        let myitem =this.selected_items[this.active_el];
                        let alter = this.selected_items[this.active_el].qty - this.alternativeqty;
                        // let clone = (JSON.parse(JSON.stringify(myitem)));
                        myitem.status='Cancelled';
                        myitem.sale_price=0;
                        myitem.kot_no=null
                        myitem.qty=this.alternativeqty;
                        myitem.item_discount=0;
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

                            clone.subcategory=this.sSubCat;
                            this.selected_items.unshift(clone);



                        }
                        this.alternativeqty='';
                        this.instruction='';
                        this.sCancelledRemark=0;
                        this.aftercancel='Void';
                        this.showCancellationModal=false;
                        let self=this
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();



                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                            }

                        },100)
                    }
                }
            },
            enterinsts:function(el){
                this.selected_items[this.active_el].instruction=this.instruction;
            },
            enterquantity:function(el){

                if(this.quantity<1 && this.quantity!='') alert('Please Enter a valid Quantity !');

               /* this.selected_items[this.active_el].qty=this.quantity;*/
            },
            activate:function(el){
                this.active_el = el;
            },
            updatetrstatus:function(el){
                if(this.selected_items[this.active_el].saved==1){
                    if (this.selected_items[this.active_el])
                        this.showCancellationModal = true;
                    else
                        this.showCancellationModal = false;
                }
                /*if(this.selected_items[this.active_el].saved==1){
                this.selected_items[this.active_el].status='Cancelled';
                this.selected_items[this.active_el].sale_price=0;
                this.selected_items[this.active_el].item_discount=0;
                    if (this.selected_items[this.active_el])
                        this.showModal = true;
                    else
                        this.showModal = false;
                }*/
            },
            updatetrplus:function(el){
                if(this.selected_items[this.active_el].saved!=1){
        this.selected_items[this.active_el].qty=this.selected_items[this.active_el].qty-2+3;
       /* this.selected_items[this.active_el].item_discount=parseFloat(this.selected_items[this.active_el].item_discount)+parseFloat(this.selected_items[this.active_el].item_discount);
          */

                        let self=this;
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();



                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                            }
                        },100)

                }
        },
            updatetrminus:function(el){
               if(this.selected_items[this.active_el].saved!=1){
                   this.selected_items[this.active_el].qty=this.selected_items[this.active_el].qty-1;

                   let self=this;
                   setTimeout(function(){
                       if(self.disc_pc!=''){
                           self.discountcardpc();



                       }
                       else if(self.disc!=''){
                           self.discountcardamt();

                       }
                   },100)

                   if(this.selected_items[this.active_el].qty==0)
                   {
                       this.selected_items.splice(this.active_el,1);
                   }

               }

            },
            callme:function(){
                this.sType = 'Home Delivery';
            },
            removetr:function(el){
                if(this.selected_items[this.active_el].saved!=1){
                    this.selected_items.splice(this.active_el,1);
                }

            },
            save_to_selected:function(item){
                if(this.quantity==''){
                    this.quantity=1;
                }
                if(this.quantity>0){
                    let clone = (JSON.parse(JSON.stringify(item)));
                    if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                    else{
                        /*clone.tttttt=1;*/

                        clone.qty=this.quantity;
                        clone.subcategory=this.sSubCat;
                        this.selected_items.unshift(clone);
                    }

                    this.quantity='';
                    let self=this;
                    setTimeout(function(){
                        if(self.disc_pc!=''){
                            self.discountcardpc();



                        }
                        else if(self.disc!=''){
                            self.discountcardamt();

                        }
                    },100)

                }

            },
            alternativeqtyrestrict(){
                if(this.alternativeqty>this.selected_items[this.active_el].qty || this.alternativeqty<1 && this.alternativeqty!='') alert('You have entered an unexpected value !');
                if(this.alternativeqty>this.selected_items[this.active_el].qty || this.alternativeqty<1 && this.alternativeqty!='') this.alternativeqty=this.selected_items[this.active_el].qty;
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
                let r='';
                if(m){
                    r='?r='+m;
                }
                this.$http.get('/food-and-beverage/sales/sales-ini'+r).then(result=>{
                    let data =result.data;
                    if(m && this.datatableid==m) {
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
                        this.type=data.type;
                        this.customer=data.name;
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
                        this.waiters=data.waiters;
                      //  this.tables=data.tables;
                        this.mains=data.mains;
                        //this.subcats=data.subcats;
                        //this.itemdefs=data.itemdefs;
                        this.resturants=data.restaurants;
                        this.cancelled_remarks=data.cancelled_remarks;
                        this.currencies=data.currencies;
                        this.accheads=data.accheads;
                        this.acctypes=data.acctypes;
                        this.increment_number=data.increment_number;
                        this.date=data.date;
                        this.time=data.time;

                        this.id=data.id;

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
                        this.disc=data.disc;
                        this.disc_pc=data.disc_pc;
                        this.amount_received='';

                        this.taxandservice=data.taxandservice;
                        this.waiters=data.waiters;
                        //  this.tables=data.tables;
                        this.mains=data.mains;
                        //this.subcats=data.subcats;
                        //this.itemdefs=data.itemdefs;
                        this.resturants=data.restaurants;
                        this.cancelled_remarks=data.cancelled_remarks;
                        this.currencies=data.currencies;
                        this.accheads=data.accheads;
                        this.acctypes=data.acctypes;
                        this.increment_number=data.increment_number;
                        this.date=data.date;
                        this.time=data.time;

                        this.id=data.id;

                    }
                    else{
                        this.printedornot='',
                        this.shouldiappear=0;
                        this.id='';
                        this.taxandservice=data.taxandservice;
                        this.waiters=data.waiters;
                       // this.tables=data.tables;
                        this.mains=data.mains;
                        //this.subcats=data.subcats;
                        this.resturants=data.restaurants;
                        this.currencies=data.currencies;
                        this.accheads=data.accheads;
                        this.acctypes=data.acctypes;
                        this.increment_number=data.increment_number;

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
                    this.getTables();
                    this.bookedTables=data.booked_tables;
                    this.cancelpermit=data.cancel_permit;
                    this.caneditsale=data.editsalepermit;
                    this.cat_permission=data.catspermit;
console.log(this.cat_permission);
                    this.printedTables=data.printed_tables;
                    this.kot=data.kot;
                    this.showModalPayment=true;
                    this.shift=data.shift;
                    this.acc_permission=data.accpermit;
                    this.disableds=false;

                    console.log(data.shift);
                    $('.breadcrumbee,.border-menu,.br-header,.br-logo,img[title="Reload Page"]').hide();
                    $('.br-pagebody').css({'padding':'0px','margin':'0px'})
                })

            },
            itemsdatavalue(val,m){
                this.searcheditemsdefs=[];
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/itemsdata?inv=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.quantity>0){
                            let clone = (JSON.parse(JSON.stringify(data, data.qty=this.quantity)));
                            if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                            else{
                                clone.subcategory=this.sSubCat;
                                this.selected_items.unshift(clone);
                            }

                            this.quantity='';

                            this.search ='';
                        }

                       /* let clone = (JSON.parse(JSON.stringify(data)));
                        if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                        else  this.selected_items.push(clone);*/

                        let self=this;
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();

                                console.log(123);

                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                                console.log(123);
                            }
                        },100)

                    }
                });
            },
            itemsdatavalueEnter(val,m){
                this.searcheditemsdefs=[];
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/itemsdataenter?inv=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.quantity>0){
                            let clone = (JSON.parse(JSON.stringify(data, data.qty=this.quantity)));
                            if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                            else clone.subcategory=this.sSubCat;
                            this.selected_items.unshift(clone);

                            this.quantity='';

                            this.search ='';


                        }

                        /* let clone = (JSON.parse(JSON.stringify(data)));
                         if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                         else  this.selected_items.push(clone);*/
                        let self=this;
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();

                                console.log(123);

                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                                console.log(123);
                            }
                        },100)

                    }
                });
            },
            itemsdata(){
                this.$http.post('/search/itemsdatalike',{searchid:this.search}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{a.search=a.item_code + ' ' + '-'+ ' ' + a.item_details})

                    if(data){

                        this.searcheditemsdefs=data;

                    }
                });
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
            discountdata(){

                this.$http.post('/search/discountdatalike',{customerid:this.customer_id,customer:this.customer}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{a.discountcard=a.card_number})

                    if(data) {
                        if(this.customer=='') alert('Please select Customer first !');

                        else

                        this.discountcards=data;

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
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){

                        if (v == 0) {
                            this.customer_id = data.id;
                            this.member_id = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 1) {
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.customer_name;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 3) {
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.name;
                            this.ledger_amount=data.balance;
                        }

this.alreadySearched=true;
                    }
                });
            },
            discountcardvalue(val){
                this.discountcards=[];

                this.$http.post('/search/discountdata',{discountid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.alreadySearchedDisc=true;
                            this.discountcard = data.card_number;

                            if(data.discount_amount){
                                this.disc = data.discount_amount;
                                this.disc_pc = 0;
                            }
                            else{
                                this.disc_pc = data.discount_percentage;
                                this.disc = 0;
                            }


                    }
                });
            },
            getTables:function(){
                    this.$http.get('/food-and-beverage/sales/tables/'+this.sResturant).then(result=>{
                        let data=result.data;
                        if(data){
                            this.tables=data;
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
           /* getAccountTyes:function(){
                this.$http.get('/food-and-beverage/sales/accounttypes/'+this.sAccHead).then(result=>{
                    let data=result.data;
                    if(data){
                        this.acctypes=data;
                    }
                })
            },*/
            getItemDefs:function(){
                this.$http.get('/food-and-beverage/sales/items/'+this.sSubCat).then(result=>{
                    let data=result.data;
                    if(data){
                        this.itemdefs=data;
                    }
                })
            },
            getItemDefs2:function(){
                this.$http.get('/food-and-beverage/sales/items').then(result=>{
                    let data=result.data;
                    if(data){
                        this.itemdefs=data;
                    }
                })
            },
        },

        mounted() {
            setInterval(()=>{
                this.$forceUpdate();
            },500)
            this.$http.get('/printerip').then((a)=>{
                this.printerip=a.data;

            });

            this.getSubCats();
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
    background-color: #23BF08;
    color: white;
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
select.family{
    height: 22px!important;
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
</style>
