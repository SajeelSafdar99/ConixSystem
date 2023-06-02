<template>
<div>
    <vue-snotify></vue-snotify>
<!--    <v-offline
        online-class="online"
        offline-class="offline"
        @detected-condition="amIOnline">
        <template v-slot:[onlineSlot] :slot-name="onlineSlot">
            ( Online: {{ onLine }} )
        </template>
        <template v-slot:[offlineSlot] :slot-name="offlineSlot">
            ( Online: {{ onLine }} )
        </template>
    </v-offline>-->

    <div v-if="showModalPayment">
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


                                    <div class="row">
                                        <div class="col-sm-12 mg-t-10 mg-sm-t-0">

                                            <select id="account" v-model="account" name="account" class="form-control " >
                                                <option label="Choose Option" value="0"></option>
                                                <option :value="co.code" v-for="co in accounts">
                                                    {{ co.name }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12 mg-t-10 mg-sm-t-0">

                                            <select id="account_type" v-model="account_type" name="account_type" class="form-control " >
                                                <option label="Choose Option" value="0"></option>
                                                <option v-if="acc_permission.indexOf(acctype.name+' '+acctype.mod_id)!=-1"  :value="acctype.id" v-for="acctype in acctypes.filter((z)=>{return (this.account?this.accounts.filter((a)=>{return a.code==this.account})[0].cost_center:0)==(this.pms.filter((b)=>{return b.id==z.mod_id})[0].coa_trans_type)})">
                                                    {{ acctype.name }}
                                                </option>

                                            </select>
                                        </div>

                                    </div>



                                <hr>

                                <div class="row  mg-t-10">
                                    <label class="col-sm-4 form-control-label"><b style="font-size: 16px;">Grand Total:</b>  </label>
                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                        <input type="number" :value="Math.round(this.grand_total)" class="form-control input-height" placeholder="Enter Amount" readonly>
                                    </div> </div>



                                <div class="row  mg-t-10">
                                    <label class="col-sm-4 form-control-label"><b style="font-size: 16px;"> Amount Received: </b></label>
                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">

                                            <input type="number" :value="Math.round(this.grand_total)" class="form-control input-height" placeholder="Enter Amount" readonly>

                                    </div>
                                </div>

                                <div class="row  mg-t-10">
                                    <label class="col-sm-4 form-control-label"><b style="font-size: 16px;">  Return Value: </b> </label>
                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                        <input type="number" :value="0" class="form-control input-height" placeholder="Enter Amount" readonly>
                                    </div>
                                </div>

                                <div class="row  mg-t-10">
                                    <label class="col-sm-4 form-control-label"><b style="font-size: 16px;">  Comment Box: </b> </label>
                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                          <textarea class="form-control" v-model="comments" placeholder="Enter details" rows="2" type="text" id="comments"
                                                    name="comments"></textarea>
                                    </div> </div>


                            </div>
                            <div class="modal-footer">

                                    <input @click="receive_payment(id);"  :disabled="disabled" :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" value="RECEIVE & PRINT">

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

                <label class="col-sm-1 form-control-label">Invoice #:  <span class="tx-danger">  * </span>  </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control input-height" id="invoice_no" v-model="invoice_no" value="1" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                </div>


                <label class="col-sm-1 form-control-label">
                    Invoice Date:
                    <span class="tx-danger">
                                *
                            </span>
                </label>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <datepicker   v-model="invoice_date" :clear-button="true" placeholder="dd/mm/yyyy" format="dd/MM/yyyy" input-class="form-control" name="invoice_date"></datepicker>

                    <!--  <input type="text" v-model="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="14/04/2020" readonly="" style="background-color: #c1c1c1">
  -->
                </div>

                <label class="col-sm-1 form-control-label">
                    Ledger Amount:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <input type="number" class="form-control input-height"   id="ledger_amount" name="ledger_amount" v-model="ledger_amount" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">
                </div>





            </div>

            <br>
            <div class="row">
                <div class="col-sm-1">
                    <label class="rdiobox">
                        <input type="radio" name="type" v-model="invoice_type" value="0"><span class="pabs">Member</span></label>
                </div>
                <div class="col-sm-1">
                    <label class="rdiobox">
                        <input type="radio" name="type" v-model="invoice_type" value="6"><span class="pabs">Corporate Member</span></label>
                </div>
                    <div  v-for="gt in gts" class="col-sm-1">
                    <label class="rdiobox">
                        <input type="radio" name="type" v-model="invoice_type" :value="10+gt.id"><span class="pabs">{{gt.desc}}  <!--<template v-if="this.add_guest"> <a href="/room-management/room-customer/room-customer-aeu" target="popup" onclick="window.open('/room-management/room-customer/room-customer-aeu','popup','width=700,height=550'); return false;"><i class="fa fa-plus"></i></a>--> <!--<a href="/room-management/room-customer/room-customer-aeu" target="_blank" class="btn btn-xsss btn-info"><i class="fa fa-plus"></i></a> </template>--></span>
                    </label>

                    </div>
                <label class="rdiobox">
                    <a href="/room-management/room-customer/room-customer-aeu" target="popup" onclick="window.open('/room-management/room-customer/room-customer-aeu','popup','width=450,height=550'); return false;"><i class="fa fa-plus"></i></a>
                </label>
<!--                <div class="col-md-1">
                    <label class="rdiobox">
                        <input type="radio" name="type" v-model="type" value="3"><span class="pabs">Employee</span>
                    </label>
                </div>-->

                <div class=" col-md-3 form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">


                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control"  v-on:keyup.enter.prevent="pero()" autocomplete="off" type="text" :placeholder="'Search '+(invoice_type==0?'Member':invoice_type==6?'Corporate Member':'Guest')">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)" v-html="c.name"></a>
                        </li>

                    </ul>


                </div>




            </div>

            <div class="row">
            <label class="col-sm-1 form-control-label">
                Contact:
                <span class="tx-danger">
                                *
                            </span>
            </label>
            <div class="col-sm-1 form-group">
                <input v-model="contact" class="form-control"  name="contact" id="contact" type="text" :placeholder="(invoice_type==0?'Member':invoice_type==6?'Corporate Member':invoice_type==3?'Employee':'Guest')+' Contact'">
                <input type="hidden" name="hiddenforguest" id="hiddenforguest" v-model="hiddenforguest">
            </div>

            <div class="col-sm-1 form-group">
                <input v-model="member_id" class="form-control"  name="member_id" id="member_id" type="text" placeholder="Member ID" readonly>
            </div>

                <div class="col-sm-1 form-group">
                    <input v-model="corporate_id" class="form-control"  name="corporate_id" id="corporate_id" type="text" placeholder="Corporate ID" readonly>
                </div>


            <div class="col-sm-1 form-group">
                <input v-model="customer_id" class="form-control"  name="customer_id" id="customer_id" type="text" placeholder="Guest ID" readonly>
            </div>

            </div>

            <div class="row mg-t-10">

                <label class="col-sm-1 form-control-label">
                    Address:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-3 form-group">
                    <input v-model="address" class="form-control"  name="address" id="address" type="text" :placeholder="(invoice_type==0?'Member':invoice_type==6?'Corporate Member':invoice_type==3?'Employee':'Guest')+' Address'" readonly>
                </div>

                <label class="col-sm-1 form-control-label">
                    Email:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-2 form-group">
                    <input v-model="email" class="form-control" name="email" id="email" type="text" :placeholder="(invoice_type==0?'Member':invoice_type==6?'Corporate Member':invoice_type==3?'Employee':'Guest')+' Email'" readonly>
                </div>


                <label class="col-sm-1 form-control-label">
                    CNIC:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-2 form-group">
                    <input v-model="cnic" class="form-control" name="cnic" id="cnic" type="text" :placeholder="(invoice_type==0?'Member':invoice_type==6?'Corporate Member':invoice_type==3?'Employee':'Guest')+' CNIC'" readonly>
                </div>



            </div>
<br>




            <div class="clearfix"></div>

            <template v-if="this.selected==1">
            <div class="form-layout form-layout-4 blackcolor">



            <div class="scrollclasstable1" >
                <div>
                    <table>
                        <thead :style="'font-size:16px'">
                        <tr bgcolor="#5f9ea0">

                            <th class="wd-15p">TYPE</th>
                            <th class="wd-5p">AMOUNT</th>
                            <th class="wd-5p">PER DAY AMOUNT</th>
                            <th class="wd-5p">START DATE</th>
                            <th class="wd-5p">END DATE</th>
                            <th class="wd-5p">DAYS</th>
                            <th class="wd-5p">QTY</th>
                            <th class="wd-10p">SUBTOTAL</th>
                            <th class="wd-5p">DISC</th>
                            <th class="wd-5p">DISC %</th>
                            <th class="wd-5p">OVERDUE %</th>
                            <th class="wd-5p">TAX %</th>
                            <th class="wd-10p">TOTAL</th>
                            <th class="wd-10p">FAMILY MEMBER</th>
                            <th class="wd-5p"></th>

                        </tr>
                        </thead>
                        <tbody :style="'font-size:15px'">
                        <tr v-if="tr.deleted_at==null" v-for="(tr,key) in selected_items">

                            <td><select @change="extrachargesselect(key)" id="charges_type"
                                        class="form-control  "
                                        name="charges_type" v-model="tr.charges_type">
                                <option :value="0">Choose Option</option>
                                <optgroup label="Main Charges" >
                                    <option v-if="invoice_permissions.indexOf('Invoice'+' '+main.id)!=-1" v-for="main in main_types" :value="main.id"> {{ main.name }} </option>
                                </optgroup>
                                <optgroup label="Charges Types"  >

                                    <option v-for="chargestypes in finance_invoice_charges_type" v-if="invoice_permissions.indexOf('Invoice'+' '+chargestypes.name+' '+chargestypes.mod_id)!=-1" :value="chargestypes.id"> {{ chargestypes.name }} </option>

                                </optgroup>

                                <optgroup label="Subscription Types"  >

                                    <option v-for="subscription in subscription_type" v-if="invoice_permissions.indexOf('Invoice'+' '+subscription.name+' '+subscription.mod_id)!=-1" :value="subscription.id" :data-price="subscription.charges"> {{ subscription.name }} </option>

                                </optgroup>

                            </select></td>
                            <td>  <input @input="multiplyqty(key,2)" id="charges_amount" class="form-control input-height" type="text" name="charges_amount" v-model="tr.charges_amount"></td>
                            <td>  <input @input="multiplyqty(key)" id="per_day_amount" class="form-control input-height" type="text" name="per_day_amount" v-model="tr.per_day_amount"></td>


                          <td> <datepicker :typeable="true" @input="datecheckx(key)" v-model="tr.start_date" :clear-button="true" placeholder="dd/mm/yyyy" inputFormat="DD/MM/YYYY"  lang="fr" format="DD/MM/YYYY" locale="date-fns/locale/fr"  input-class="form-control" name="start_date"></datepicker></td>
                           <td> <datepicker :typeable="true" @input="datecheckx(key)"  v-model="tr.end_date" :clear-button="true" placeholder="dd/mm/yyyy" inputFormat="DD/MM/YYYY"  lang="fr" format="DD/MM/YYYY" locale="date-fns/locale/fr"  input-class="form-control" name="end_date"></datepicker></td>
                            <td>  <input id="days"  class="form-control input-height" type="number" readonly name="days" v-model="tr.days"></td>
                            <td>  <input @input="multiplyqty(key)" id="qty" class="form-control input-height" type="number" min="1" name="qty" v-model="tr.qty"></td>
                            <td>  <input id="sub_total" class="form-control input-height" type="number" readonly name="sub_total" v-model="tr.sub_total"></td>
                            <td>  <input @input="d_percentage(key)" id="discount_amount" class="form-control input-height" type="number" name="discount_amount" v-model="tr.discount_amount"></td>
                            <td>  <input  @input="d_percentage(key)" id="discount_percentage" class="form-control input-height" type="number" name="discount_percentage" v-model="tr.discount_percentage"></td>
                            <td>  <input  @input="d_percentage(key)" id="extra_percentage" class="form-control input-height" type="number" name="extra_percentage" v-model="tr.extra_percentage">
                                  <input  id="extra_charges" class="form-control input-height" type="hidden" name="extra_charges" v-model="tr.extra_charges">
                            </td>

                            <td>  <input  @input="d_percentage(key)" id="tax_percentage" class="form-control input-height" type="number" name="tax_percentage" v-model="tr.tax_percentage"></td>
                            <td>  <input   class="form-control input-height" type="number" readonly name="grand_total" v-model="tr.grand_total"></td>
                            <td> <select id="family"
                                         class="form-control  "
                                         name="family" v-model="tr.family">
                                <option :value="0">Choose Option</option>
                                <option :value="fam.id" v-for="fam in families">
                                    {{fam.title}} {{fam.first_name}} {{fam.middle_name}} {{fam.name}} - ({{fam.relationship_name.desc}})
                                </option>
                                <option value="01">  Guest
                                </option>
                                <option  value="02">  Self
                                </option>
                            </select> </td>
                            <td><input id="subid" class="form-control input-height"
                                       type="hidden" name="subid" v-model="tr.subid" >
                                <input id="deleted_at" class="form-control input-height"
                                          type="hidden" name="deleted_at" v-model="tr.deleted_at" >
                                <button type="button" class="btn btn-danger btn-xs" @click="removeme(key)"> Cancel </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>


               <template v-if="!this.id"> <br> <button @click="updatetrplus();" class="btn btn-primary"><b>ADD MORE</b></button></template>
            </div>
            </template>

            <br>



            <div class="row mg-t-10">
                <label class="col-sm-1 form-control-label">
                   Grand Total:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="number" v-model="grand_total" name="grand_total" class="form-control input-height" id="grand_total" autocomplete="off" readonly="" style="background-color: #c1c1c1" >
                </div>

                <label class="col-sm-1 form-control-label">
                    Remarks:
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <textarea type="text" class="form-control" id="remarks" v-model="remarks" placeholder="Enter Details" autocomplete="off"></textarea>
                </div>

            </div>



            <div class="float-left">
                <div class="row mg-t-10">
                    <label class="col-sm-4 form-control-label"></label>

                    <div class="form-layout-footer mg-t-30">
                        <input @click="save_sales(id)"  :disabled="disabled" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn" value="Save"  :value="id?'Update':'Save'">

                        <input @click="save_print(id)" :disabled="disabled"  v-if="!this.id" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn"  value="Save & Print" >

                      <input @click="save_receive()" :disabled="disabled"  v-if="!this.id" class="btn btn-success" type="submit" name="save" value="Save & Receive" >

                        <a href="/finance-and-management/new-invoices-vue" class="btn btn-secondary">Cancel</a>

                    </div><!-- form-layout-footer -->
                </div>
            </div><!-- form-layout -->
        </div>



    </div>
</div>
</template>

<script>
    export default {
        name: "financeinvoices",
        props: ['id','linking'],
        data(){

            return{
                searchedunits:[],
                searchedaccounts:[],

                accsearch:'',
                accsearchid:'',
                unitsearch:'',
                unitsearchid:'',
                unitalreadySearched:false,
                accountalreadySearched:false,
                ccs:[],
                gts:[],
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                invoice_no:'',
                invoice_date:'',
                ledger_amount:'',
                last_payment:'',
                searcheditemsdefs:[],
                guest_name:'',
                family:0,
                families:[],
                search:'',
                locations:[],
                disabled:false,
                customer_id:'',
                corporate_id:'',
                gross:0,
                showinggross:0,
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
                selected_items:[{
                    charges_type:0,
                    charges_amount:'',
                    per_day_amount:'',
                    start_date:'',
                    end_date:'',
                    days:'',
                    qty:'',
                    sub_total:'',
                    discount_amount:'',
                    discount_percentage:'',
                    extra_percentage:'',
                    extra_charges:'',
                    tax_percentage:'',
                    grand_total:'',
                    family:0,
                    deleted_at:null,
                    subid:null,
                }],
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
                balance:0,
                add_cat:'',
                add_sub:'',
                add_item:'',
                add_guest:'',
                cancelpermit:'',
                showCancellationModal: false,
                alternativeqty:'',
                cancelled_remarks:[],
                sCancelledRemark:'',
                aftercancel:'Void',
                measurement_units:[],
                unit:'',
                disc_pc:'',
                tax_pc:'',
                company:'001-001',
                companies:[],

                contact:'',
                address:'',
                email:'',
                cnic:'',
                finance_invoice_charges_type:[],
                main_types:[],
                subscription_type:[],
                selected:0,
                invoice_permissions:'',
                member_id:'',
                invoice_type:0,
                mem_no:'',

                hiddenforguest:0,
                showModalPayment:false,
                acctypes:[],
                accounts:[],
                pms:[],
                AccTypeMargin:0,
                account:0,
                account_type:0,
                acc_permission:'',
                sAccType:'',
                comments:''
            }
        },
        methods:{

            save_receive:function() {
                this.showModalPayment = true;
            },
            refres:function(){
                $('input[name="subtotal"]').focus();
               /* $('input[name="search"]').focus();
                this.active_el=this.selected_items.length-1;*/
            },
            pprefres:function(){
                this.timeout = setTimeout(() => {
                    $('input[name="quantity"]').focus();
                }, 600);
            },
            srefres:function(){
                let demo = $('input[name="subtotal"]').val();
                // console.log(parseInt(demo)/parseInt(this.selected_items[this.active_el].qty))
                this.selected_items[this.active_el].sale_price  = parseInt(demo)/parseInt(this.selected_items[this.active_el].qty);

                $('input[name="search"]').focus();
                this.active_el=this.selected_items.length-1;
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
            udf3(event){

                if(event==0){
                    if(this.ffkey!=this.searchedunits.length-1){

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
            udf4(event){

                if(event==0){
                    if(this.ffkey!=this.searchedaccounts.length-1){

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
                this.$http.get(this.linking+'/finance-and-management/finance-invoices/invoices-aeu/init'+r).then(result=>{
                    let data=result.data;
                    // console.log(data);
                    if(m){


                        this.selected_items=data.invoice_no.selected_items;
                        this.remarks=data.invoice_no.comments;

                        this.invoice_type=data.invoice_no.invoice_type;
                        this.invoice_no=parseInt(data.invoice_no.id);
                        this.invoice_date=data.invoice_no.invoice_date;

                        let b='';
                        if(data.invoice_no.invoice_type==1){
                              b=data.invoice_no.customer_id;
                        }
                        else if(data.invoice_no.invoice_type==6){
                            b=data.invoice_no.corporate_id;
                        }
                        else{
                            b=data.invoice_no.member_id;
                        }

                        this.customerdatavalue(b,this.id);
                    }
                    else{
                        this.selected_items=[{
                            charges_type:0,
                            charges_amount:'',
                            per_day_amount:'',
                            start_date:'',
                            end_date:'',
                            days:'',
                            qty:'',
                            sub_total:'',
                            discount_amount:'',
                            discount_percentage:'',
                            extra_percentage:'',
                            extra_charges:'',
                            tax_percentage:'',
                            grand_total:'',
                            family:0,
                            deleted_at:null,
                            subid:null,
                        }];
                        this.invoice_no=data.invoice_no.id?parseInt(data.invoice_no.id)+1:1;
                        this.invoice_date=new Date()
                        /*this.invoice_date=moment().format('DD/MM/YYYY')*/

                    }
                    // console.log(data);
                    this.gts=data.invoice_no.gts;
                    this.main_types=data.invoice_no.main_types;
                    this.subscription_type=data.invoice_no.subscription_type;
                    this.finance_invoice_charges_type=data.invoice_no.finance_invoice_charges_type;

                    this.invoice_permissions=data.invoice_no.invoice_permissions;
                    this.accounts=data.invoice_no.accounts;
                    this.pms=data.invoice_no.pms;
                    this.acctypes=data.invoice_no.acctypes;
                    this.ccs=data.invoice_no.ccs;

                    this.add_cat=data.invoice_no.add_cat;
                    this.add_sub=data.invoice_no.add_sub;
                    this.add_item=data.invoice_no.add_item;
                    this.add_guest=data.invoice_no.add_guest;

                    this.acc_permission=data.invoice_no.accpermit;

                    this.mains=data.invoice_no.mains;



                })
            },
            save_to_selected:function(){
                if(this.quantity==''){
                    this.quantity=1;
                }
                if(this.service_charges==''){
                    this.service_charges='';
                }
                if(this.discount==''){
                    this.discount=0;
                }
                if(this.tax==''){
                    this.tax=0;
                }
                if(this.price==''){
                    this.price=0;
                }
                if(this.quantity>0){
                    let clone = (JSON.parse(JSON.stringify(this.selecteditem)));

                    /*if(this.selected_items[this.active_el].store_location==undefined || this.selected_items[this.active_el].department==undefined)
                    {alert('Please select Location & Department first !'); return 0}

                    else{*/
                        clone.qty=this.quantity;
                   //     clone.sale_price=this.price;
                        clone.service_charges='';
                       clone.discount=0;
                       clone.tax=0;
                        clone.instructions=this.instructions;
                        clone.store_location=this.selected_items[this.active_el].store_location;
                        clone.department=this.selected_items[this.active_el].department;
                        this.selected_items.push(clone);
                    this.active_el=this.selected_items.length-1;
                   /* }*/

                    this.quantity='';
                    this.price='';
                    this.instructions='';

                }

            },
            removetr:function(el){
                if(this.selected_items[this.active_el].saved!=1){
                    this.selected_items.splice(this.active_el,1);
                }

            },
            updatetrplus:function(){

                let arrrayy={
                    charges_type:0,
                    charges_amount:'',
                    per_day_amount:'',
                    start_date:'',
                    end_date:'',
                    days:'',
                    qty:'',
                    sub_total:'',
                    discount_amount:'',
                    discount_percentage:'',
                    extra_percentage:'',
                    extra_charges:'',
                    tax_percentage:'',
                    grand_total:'',
                    family:0,
                    deleted_at:null,
                    subid:null
                };
                let clone = (JSON.parse(JSON.stringify(arrrayy)));

                this.selected_items.push(clone);

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
                this.$http.post('/search/storesalesitemsdata?inv=1&MOC='+r,{theid:val, theunit:this.company}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.service_charges==''){
                            this.service_charges='';
                        }
                        if(this.discount==''){
                            this.discount=0;
                        }
                        if(this.tax==''){
                            this.tax=0;
                        }
                        if(this.price==''){
                            this.price=0;
                        }
                        if(this.quantity>0){

                            if(data.sale_price.split('.')[1]==0){
                                data.sale_price=Math.round(data.sale_price);
                            }
                            if(data.old_sale_price.split('.')[1]==0){
                                data.old_sale_price=Math.round(data.old_sale_price);
                            }
                            let clone = (JSON.parse(JSON.stringify(data)));


                            /*if(this.selected_items[this.active_el].store_location==undefined || this.selected_items[this.active_el].department==undefined)
                            {alert('Please select Location & Department first !'); return 0}
                            else{*/
                                clone.qty=this.quantity;
                                clone.service_charges='';
                                clone.discount=0;
                                clone.tax=0;
                             //   clone.sale_price=this.price;
                                clone.instructions=this.instructions;
                                clone.store_location=this.selected_items[this.active_el].store_location;
                                clone.department=this.selected_items[this.active_el].department;
                                this.selected_items.push(clone);
                            this.active_el=this.selected_items.length-1;

                            /*}*/

                            this.quantity='';
                            this.price='';
                            this.instructions='';
                            this.search ='';

                        }


                    }
                });

                this.axios.post('/search/storesalesitemsdata?inv=1&MOC='+r,{theid:val, theunit:this.company}).then(result=>{
                    $('#price').focus();
                });
            },
            itemsdatavalueEnter(val,m){
                this.searcheditemsdefs=[];
                let r='';
                this.ffkey=-1
                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/storesalesitemsdata?inv=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.service_charges==''){
                            this.service_charges='';
                        }
                        if(this.discount==''){
                            this.discount=0;
                        }
                        if(this.tax==''){
                            this.tax=0;
                        }
                        if(this.price==''){
                            this.price=0;
                        }
                        if(this.quantity>0){
                            if(data.sale_price.split('.')[1]==0){
                                data.sale_price=Math.round(data.sale_price);
                            }
                            if(data.old_sale_price.split('.')[1]==0){
                                data.old_sale_price=Math.round(data.old_sale_price);
                            }
                            let clone = (JSON.parse(JSON.stringify(data)));

                            /* if(this.selected_items[this.active_el].store_location==undefined || this.selected_items[this.active_el].department==undefined)
                             {alert('Please select Location & Department first !'); return 0}
                             else{*/
                                clone.qty=this.quantity;
                                clone.service_charges='';
                            clone.discount=0;
                            clone.tax=0;
                            //    clone.sale_price=this.price;
                                clone.instructions=this.instructions;
                                clone.store_location=this.selected_items[this.active_el].store_location;
                                clone.department=this.selected_items[this.active_el].department;
                                this.selected_items.push(clone);
                            this.active_el=this.selected_items.length-1;
/*
                            }*/

                            this.quantity='';
                            this.price='';
                            this.instructions='';
                            this.search ='';
                        }
                    }
                });

                this.axios.post('/search/storesalesitemsdata?inv=1&MOC='+r,{theid:val}).then(result=>{
                    $('#price').focus();
                });
            },
            itemsdata(){
                this.$http.post('/search/storesalesitemsdatalike',{searchid:this.search}).then(result=>{
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
                this.$http.get('/store-management/store-sales/items/'+this.sSubCat).then(result=>{
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
                let v = this.invoice_type;
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
                    else if(v==3){
                        data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})
                    }
                    else  {
                        data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                    }
                    if(data){

                        this.customers=data;

                    }
                });
            },
            customerdatavalue(val,m){
                this.fkey=-1;
                this.customers=[];
                let v = this.invoice_type;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/salescustomerdata?inv=1&balance=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){

                     if (v == 0) {
                            this.member_id = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                         this.last_payment=data.lastpayment;
                         this.address=data.cur_address;
                         this.email=data.personal_email;
                         this.cnic=data.cnic;
                         this.contact=data.mob_a;
                         this.mem_no=data.mem_no;

                        }
                        else if (v == 6) {
                            this.corporate_id = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                            this.last_payment=data.lastpayment;
                            this.address=data.cur_address;
                            this.email=data.personal_email;
                            this.cnic=data.cnic;
                            this.contact=data.mob_a;
                          //  this.mem_no=data.mem_no;

                        }

                        else if (v == 3) {
                            this.customer_id = data.id;
                            this.customer = data.name;
                            this.ledger_amount=data.balance;
                         this.last_payment=data.lastpayment;
                        }
                        else{
                        /* if(data.guest_type==1){
                             this.invoice_type='01';
                         }else if(data.guest_type==2){
                             this.invoice_type='02';
                         }*/
                         this.invoice_type= 10+data.guest_type;
                             this.customer_id = data.id;
                             this.customer = data.customer_name;
                             this.ledger_amount=data.balance;
                         this.last_payment=data.lastpayment;
                         this.address=data.customer_address;
                         this.email=data.customer_email;
                         this.cnic=data.customer_cnic;
                         this.contact=data.customer_contact;
                        }

                        this.balance=data.balance;
                        this.alreadySearched=true;
                        this.selected=1;
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
            pero:function(){
                let data={
                    customer:this.customer,

                };
                let url='/create/guestid';

                if(this.customer && this.invoice_type>10){

                        this.$http.post(url, data).then(result => {
                            this.selected=1;
                            this.customer_id= result.data;
                        });

                }else{
                    alert('Guest can not be created. Retry !');
                }


            },
            extrachargesselect:function(e){
                console.log(e);
                let idval=this.selected_items[e].charges_type;
                let memid =0;
                if(this.member_id){
                      memid = this.member_id;
                }
                else{
                      memid = 0;
                }
                let url='/finance-and-management/finance-invoices/calculatesportscharges/' + memid +'/' + idval;

                    this.$http.get(url).then(result => {
                        let data = result.data;
                        this.selected_items[e].charges_amount = data;
                        this.selected_items[e].per_day_amount = Math.round((data/30)*100)/100;
                        this.selected_items[e].sub_total = Math.round(data);
                        this.selected_items[e].grand_total = Math.round(data);
                        this.selected_items[e].qty=1;


                    });
                this.d_percentage(e);
            },
            d_percentage:function(e){

                let first = parseFloat(this.selected_items[e].sub_total);
                let second = parseFloat(this.selected_items[e].discount_amount);
                let psecond = parseFloat(this.selected_items[e].discount_percentage);
                let third = parseFloat(this.selected_items[e].extra_percentage);
                let fourth = parseFloat(this.selected_items[e].tax_percentage);

                if(!first){
                    first=0;
                }
                if(!second){
                    second=0;
                }
                if(!psecond){
                    psecond=0;
                }
                if(!third){
                    third=0;
                }
                if(!fourth){
                    fourth=0;
                }



                let extra = third / 100;
                let totalValue1 =  (first * extra);

                this.selected_items[e].extra_charges= totalValue1;

                let totalValuesss ='';
                if(second){
                      totalValuesss = second;
                }else{
                    let ppp = psecond / 100;
                      totalValuesss = (first * ppp);
                }

                let totalValues = first + totalValue1 - totalValuesss;

                let tax = fourth / 100;
                let totalValuetax = (first * tax);


                let totalValue2 = totalValues + totalValuetax;

                this.selected_items[e].grand_total= Math.round(totalValue2);

            },
            multiplyqty:function(e,wes){

                if(wes==2){
                    this.selected_items[e].per_day_amount= Math.round((parseFloat(this.selected_items[e].charges_amount/30))*100)/100;
                }


                let days = parseFloat(this.selected_items[e].days);
                let total =0;
                if(days){
                      total = parseFloat(this.selected_items[e].per_day_amount);
                }
                else{
                      total = parseFloat(this.selected_items[e].charges_amount);
                }


                let qty = parseFloat(this.selected_items[e].qty);
                if (!total) {
                    total = 0;
                }

                if (!qty) {
                    qty = 1;
                }

                let result = total * qty;

                this.selected_items[e].sub_total = Math.round(result);
                this.selected_items[e].grand_total = Math.round(result);

                this.datecheckx(e);


            },
            datecheckx:function(e){

                    let pday = 1000 * 60 * 60 * 24;
                let st = this.selected_items[e].start_date;
                let ed = this.selected_items[e].end_date;


if( st && ed){
    let utc1 = Date.UTC(st.getFullYear(), st.getMonth(), st.getDate());
    let utc2 = Date.UTC(ed.getFullYear(), ed.getMonth(), ed.getDate());
    console.log(utc2);
    let nodays = Math.floor((utc2 - utc1) / pday);
if(nodays==0){
    this.selected_items[e].days=1;
}

    let amme=0;
    if((st.getMonth()==1 && st.getDate()==1) && (ed.getDate()>27)){
         amme = 2;
    }

    nodays=nodays+1+amme;
    nodays=nodays>30?nodays%30<7?nodays-nodays%30:nodays:nodays;

    this.selected_items[e].days=nodays;
}

this.totalcals(e);
            },
            totalcals:function(e){


                let days = parseFloat(this.selected_items[e].days);
                let total =0;
                if(days){
                    total = parseFloat(this.selected_items[e].per_day_amount);
                }
                else{
                    total = parseFloat(this.selected_items[e].charges_amount);
                }


                let qty = parseFloat(this.selected_items[e].qty);
                if (!total) {
                    total = 0;
                }

                if (!days) {
                    days = 1;
                }

                if (!qty) {
                    qty = 1;
                }

                let result = total * qty * days;

                this.selected_items[e].sub_total = Math.round(result);
                this.selected_items[e].grand_total = Math.round(result);

                this.d_percentage(e);

            },
            removeme:function(e){

                this.selected_items[e].deleted_at=1


            },
            save_sales:function(m){
               let data={
                   invoice_date:this.invoice_date,
                   invoice_no:this.invoice_no,
                   invoice_type:this.invoice_type,
                   customer:this.customer,
                   customer_id:this.customer_id,
                   member_id:this.member_id,
                   corporate_id:this.corporate_id,
                   selected_items: this.selected_items,
                   mem_no:this.mem_no,
                   grand_total:this.grand_total,
                    remarks:this.remarks,
                };
                let url='/finance-and-management/finance-invoices/invoices-aeu/save';
                if(m){
                    url='/finance-and-management/invoices/update';
                    data.id=this.id;
                }
if(this.customer_id || this.member_id || this.corporate_id){
    if(this.validation(data,['customer', 'invoice_no','invoice_date', 'selected_items'])==0) {
        this.disabled=true;
        this.$http.post(url, data).then(result => {
            if(m){
                window.location.href = "/finance-and-management/finance-invoices/invoices-aeu/"+m;
            }else{
                window.location.href= "/finance-and-management/finance-invoices/invoices-aeu";
            }
        });
    }
}else{
    alert('Member / Corporate Member / Guest ID is missing !');
}


            },
            receive_payment:function(m){
                let data={
                    invoice_date:this.invoice_date,
                    invoice_no:this.invoice_no,
                    invoice_type:this.invoice_type,
                    customer:this.customer,
                    customer_id:this.customer_id,
                    member_id:this.member_id,
                    corporate_id:this.corporate_id,
                    selected_items: this.selected_items,
                    mem_no:this.mem_no,
                    grand_total:this.grand_total,
                    remarks:this.remarks,

                    account:this.account,
                    account_type:this.account_type,
                    comments:this.comments,
                    amount_received:this.grand_total,
                    return_value:0,
                    receive:1,

                };
                let url='/finance-and-management/finance-invoices/invoices-aeu/save';
               /* if(m){
                    url='/finance-and-management/invoices/update';
                    data.id=this.id;
                }*/
                if(this.customer_id || this.member_id || this.corporate_id){
                    if(this.validation(data,['customer', 'invoice_no','invoice_date', 'grand_total', 'selected_items', 'account', 'account_type', 'amount_received'])==0) {
                        this.disabled=true;
                        this.$http.post(url, data).then(result => {
                            window.location.href = "/finance-and-management/finance-new-invoices/invoice/"+result.data;
                        });
                    }
                }else{
                    alert('Member / Corporate Member / Guest ID is missing !');
                }


            },
            save_print:function(m){
                let data={
                    invoice_date:this.invoice_date,
                    invoice_no:this.invoice_no,
                    invoice_type:this.invoice_type,
                    customer:this.customer,
                    customer_id:this.customer_id,
                    member_id:this.member_id,
                    corporate_id:this.corporate_id,
                    selected_items: this.selected_items,
                    mem_no:this.mem_no,
                    grand_total:this.grand_total,
                    remarks:this.remarks,
                };
                let url='/finance-and-management/finance-invoices/invoices-aeu/save';
                if(m){
                    url='/finance-and-management/invoices/update';
                    data.id=this.id;
                }
                if(this.customer_id || this.member_id || this.corporate_id){
                    if(this.validation(data,['customer', 'invoice_no','invoice_date', 'grand_total', 'selected_items'])==0) {
                        this.disabled=true;
                        this.$http.post(url, data).then(result => {

                            window.location.href = "/finance-and-management/finance-new-invoices/invoice/"+result.data;



                        });
                    }
                }else{
                    alert('Member / Corporate Member / Guest ID is missing !');
                }


            }
        },
        watch:{
            unitsearch:function(){
                if(this.unitsearch.length==0){
                    this.unitalreadySearched=false;
                }
                if(!this.unitalreadySearched){
                    this.unitsdata();
                }
            },
            accsearch:function(){
                if(this.accsearch.length==0){
                    this.accountalreadySearched=false;
                }
                if( !this.accountalreadySearched){
                    this.accountdata();
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
                        this.balance=data.balance;



                    }
                });


               console.log(x.get('memid'));
            }
            let self=this;
            setInterval(function(){

                self.grand_total=Math.round(self.sum(self.pluck(self.selected_items.filter(function(a){return a.deleted_at==null}),'grand_total')))
            },200)
        }
    }
</script>

<style scoped>

.btnfont{
    font-size: 18px !important;
}

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
