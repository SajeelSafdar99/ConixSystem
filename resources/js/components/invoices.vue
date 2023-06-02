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
    </v-offline>
    <br>-->
    <div class="row">
        <div class="col-sm-10">



            <div class="row mg-t-10">

                <label class="col-sm-1 form-control-label">Receipt #:  <span class="tx-danger">  * </span>  </label>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control input-height" id="invoice_no" v-model="invoice_no" value="1" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                </div>


                <label class="col-sm-1 form-control-label">
                    Receipt Date:
                    <span class="tx-danger">
                                *
                            </span>
                </label>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="text" v-model="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="14/04/2020" readonly="" style="background-color: #c1c1c1">

                </div>

                <label class="col-sm-1 form-control-label">    Ledger Amount:<span class="tx-danger">*</span>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
               </label>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <input type="number" class="form-control input-height" id="ledger_amount" name="ledger_amount" v-model="ledger_amount" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">
                </div>


            </div>
            <!-- row -->


            <div class="row mg-t-10">


                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input checked="" type="radio" name="receipt_type" v-model="receipt_type" value="0"><span class="pabs">Member</span></label>
                </div>

                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input checked="" type="radio" name="receipt_type" v-model="receipt_type" value="6"><span class="pabs">Corporate Member</span></label>
                </div>

                <div v-for="gt in gts" class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <label  class="rdiobox">
                        <input type="radio" name="receipt_type" v-model="receipt_type" :value="10+gt.id"><span class="pabs">{{gt.desc}}</span>
                    </label>
                </div>

                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input type="radio"  name="receipt_type" v-model="receipt_type" value="3"><span class="pabs">Employee</span>
                    </label>
                </div>
<!--                    <label class="rdiobox">
                        <input type="radio"  name="receipt_type" v-model="receipt_type" value="2"><span class="pabs">Ledger</span>
                    </label>-->

            </div>
            <!-- row -->

            <br>
            <div class="row">

                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">


                        <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" :placeholder="'Search '+(receipt_type==0?'Member':receipt_type==6?'Corporate Member':receipt_type==3?'Employee':'Guest')">


                        <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                            <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                                <a href="javascript:void(0)" v-html="c.name"></a>
                            </li>

                        </ul>


                    </div>

                </div>
                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <a  class="btn btn-info" href="/room-management/room-customer/room-customer-aeu" target="_blank">
                        Add Guest
                    </a>
                </div>




                <label class="col-sm-1 form-control-label">
                    Family Member:
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <select  id="family" class="form-control " v-model="family">
                        <option label="Choose Family Member" value="0">  </option>
                        <option :value="fam.id" v-for="fam in families">
                            {{fam.title}} {{fam.first_name}} {{fam.middle_name}} {{fam.name}} - ({{fam.relationship_name.desc}})
                        </option>
                    </select>
                </div>




                <label class="col-sm-1 form-control-label"> Membership #:  <span class="tx-danger">  * </span>  </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control input-height" name="mem_number" id="mem_number" v-model="mem_id" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">

                </div>


                <label class="col-sm-1 form-control-label"> Guest #:  <span class="tx-danger">  * </span>  </label>
                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control input-height" name="customer_id" id="customer_id" v-model="customer_id" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">                        </div>

            </div>

            <div class="row mg-t-10">

                <label class="col-sm-1 form-control-label"> Corporate #:  <span class="tx-danger">  * </span>  </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control input-height" name="cop_number" id="cop_number" v-model="cop_id" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">

                </div>

                <label class="col-sm-1 form-control-label"> Employee #:  <span class="tx-danger">  * </span>  </label>
                <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control input-height" name="employee_id" id="employee_id" v-model="employee_id" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">

            </div>

                <label class="col-sm-1 form-control-label">
                    Contact:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <input type="text" class="form-control input-height" id="guest_contact" v-model="guest_contact" autocomplete="off" value="" readonly="" style="background-color: #c1c1c1">
                </div>


                <label class="col-sm-1 form-control-label">Filter by type:<span class="tx-danger">  * </span>  </label>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                  <select class="form-control" v-model="type">
                      <option value="0">All</option>
                    <option v-if="cat_permission.indexOf(t.name+' '+t.mod_id)!=-1 || cat_permission.indexOf('Cash Receipt'+' '+t.id)!=-1" :value="t.id" v-for="t in types">
                        {{t.name}}
                    </option>
                  </select>

                </div>

<!--

                <label class="col-sm-1 form-control-label">Select All:  </label>
-->

                <input type="checkbox" v-model="selectall" @click="selectAll">

            </div>
            <div class="row mg-t-10">
                <div class="col-sm-2">
                    <div>

                        <select class="form-control" v-model="year">
                            <option value="0">Choose Year</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div>

                        <select class="form-control" v-model="month">
                            <option value="0">Choose Month</option>
                            <option v-for="n in 12">{{moment(n, 'M').format('MMMM')}}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <select id="company" v-model="company"  class="form-control  ">
                        <option label="Choose Company" value="0">  </option>
                        <option :value="com.code" v-for="com in companies">
                            {{com.name}}
                        </option>
                    </select>
                </div>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                 Total Balance: {{sum(pluck(invoices.filter((a)=>{return ((a.trans_amount)-(a.sum)>0)  && (this.company==0?true:(this.company==a.unit)) && (this.month==0?true:(this.month==moment(a.date).startOf('month').format('MMMM'))) && (this.year==0?true:(this.year==moment(a.date).startOf('year').format('YYYY'))) && (type==0?true:(type==parseInt(a.trans_type))) && (this.cat_permission.filter((c)=>{return c.replace(/[^A-Za-z]/ig,'')==this.types.filter((b)=>{return b.id==a.trans_type})[0].name.replace(/[^A-Za-z]/ig,'')})[0] || this.cat_permission.filter((c)=>{return c.replace(/\D/g,'')==a.trans_type})[0] )  }),'trans_amount'))-sum(pluck(invoices.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) && (this.company==0?true:(this.company==a.unit))   && (this.company==0?true:(this.company==a.unit)) && (this.month==0?true:(this.month==moment(a.date).startOf('month').format('MMMM'))) && (this.year==0?true:(this.year==moment(a.date).startOf('year').format('YYYY'))) && (type==0?true:(type==parseInt(a.trans_type))) && (this.cat_permission.filter((c)=>{return c.replace(/[^A-Za-z]/ig,'')==this.types.filter((b)=>{return b.id==a.trans_type})[0].name.replace(/[^A-Za-z]/ig,'')})[0] || this.cat_permission.filter((c)=>{return c.replace(/\D/g,'')==a.trans_type})[0] )  }),'sum'))}}

                </div>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    Total Advance: {{sum(pluck(advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-sum(pluck(advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum'))}}

                </div>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    Discount Voucher: {{sum(pluck(discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-sum(pluck(discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum'))}}

                </div>

            </div>
            <!-- row -->



            <br>
            <div class="groove">
            <table class="table" v-if="invoices.length>0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Unit</th>
                    <th>Account</th>
                    <th>Invoice#</th>
<!--                    <th>Details</th>-->
                    <th>Payable</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Select</th>
                    <th>Paid Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="(inv.trans_amount)-(inv.sum)>0 || id" v-for="(inv,key) in invoices.filter((a)=>{return (this.month==0?true:(this.month==moment(a.date).startOf('month').format('MMMM'))) && (this.company==0?true:(this.company==a.unit)) && (this.year==0?true:(this.year==moment(a.date).startOf('year').format('YYYY'))) && (type==0?true:(type==parseInt(a.trans_type))) && (cat_permission.filter((c)=>{return c.replace(/[^A-Za-z]/ig,'')==types.filter((b)=>{return b.id==a.trans_type})[0].name.replace(/[^A-Za-z]/ig,'')})[0] || cat_permission.filter((c)=>{return c.replace(/\D/g,'')==a.trans_type})[0] )   })">
                    <td>{{key+1}}</td>

                    <td>{{types.filter((a)=>{return a.id==inv.trans_type})[0].name}}</td>

                    <td>{{inv.date}}</td>
                    <td>{{inv.unit}} - <template v-if="inv.unit">{{units.filter(function(a){return a.code==inv.unit})[0].name}}</template></td>
                    <td>{{inv.account}} {{inv.account?coaaccounts.filter(function(a){return a.code==inv.account})[0].name:''}}</td>
<template v-if="types.filter((a)=>{return a.id==inv.trans_type})[0].name=='Food and Beverage'">
    <td><a :href="'/food-and-beverage/sales/sales-invoice/'+inv.trans_type_id" target="_blank">{{inv.trans_type_id}}</a></td>
</template>
  <template v-else-if="types.filter((a)=>{return a.id==inv.trans_type})[0].name=='Room Booking'">
      <td><a :href="'/room-management/room-invoice/'+inv.trans_type_id" target="_blank">{{inv.trans_type_id}}</a></td>
 </template>
 <template v-else-if="types.filter((a)=>{return a.id==inv.trans_type})[0].name=='Events Management'">
     <td><a :href="'/events-management/event-checkout/invoice/'+inv.trans_type_id" target="_blank">{{inv.trans_type_id}}</a></td>
  </template>
<template v-else>
    <td><a :href="'/finance-and-management/finance-new-invoices/invoice/'+inv.trans_type_id" target="_blank">{{inv.trans_type_id}}</a></td>
  </template>

                    <td>{{inv.trans_amount}}</td>
                    <td>{{inv.sum}}</td>

                    <template v-if="id">
                        <td>{{inv.trans_amount}}</td>
                    </template>
                    <template v-else>
                        <td>{{(inv.trans_amount)-(inv.sum)}}</td>
                    </template>

                    <template v-if="id">
                        <td><input type="checkbox" v-model="transChecked" @change="transChecked.indexOf(inv.id) === -1?inv.p=0:inv.p=(inv.trans_amount)" :value="inv.id" ></td>
                    </template>
                    <template v-else>
                        <td><input type="checkbox" v-model="transChecked" @change="transChecked.indexOf(inv.id) === -1?inv.p=0:inv.p=(inv.trans_amount)-(inv.sum)" :value="inv.id" ></td>
                    </template>

                    <template v-if="id">
                        <td><input :max="inv.trans_amount" type="number" v-model="inv.p" @change="amountChange(key,$event)" @keyup="m=m+1"></td>
                    </template>
                    <template v-else>
                        <td><input :max="(inv.trans_amount)-(inv.sum)" type="number" v-model="inv.p" @change="amountChange(key,$event)" @keyup="m=m+1"></td>
                    </template>

                        <!--:max="(inv.trans_amount)-(inv.sum)"-->
                </tr>
                </tbody>
            </table>

            </div>
            <br>

            <div class="row mg-t-10">
                <label class="col-sm-1 form-control-label">
                    Total Amount:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">

                    <input type="number" :key="m"  v-model="total_amount" class="form-control input-height" autocomplete="off"  >
                </div>

              <!--  <label class="col-sm-1 form-control-label">Surcharge (If Any): </label>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="number" id="surcharge" v-model="surcharge" autocomplete="off" placeholder="Enter Amount" class="form-control input-height" value="" :disabled="surcharge_percentage!=0 || surcharge_percentage!=''">

                </div>



                <div class="col-sm-2 mg-t-10 mg-sm-t-0 pc">
                    <input type="number" id="surcharge_percentage" class="form-control input-height" value="" v-model="surcharge_percentage" :disabled="surcharge!=0 ||surcharge!='' ">

                </div>-->




                <label class="col-sm-1 form-control-label">
                    Total Paid Amount:
                    <span class="tx-danger">
                                *
                            </span>
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="number" name="total" class="form-control input-height" id="total" autocomplete="off" readonly="" style="background-color: #c1c1c1" :value="parseFloat(sur)+parseInt(total_amount)">
                </div>

                <label class="col-sm-1 form-control-label"> Amt in Words:</label>
                <span class="tx-danger"> * </span>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <input type="text" readonly="" style="background-color: #c1c1c1" id="amount_in_words" :value="toWords(parseFloat(sur)+parseInt(total_amount))" autocomplete="off" class="form-control input-height">
                </div>

            </div>


            <div class="row mg-t-10">
                <template v-if="sum(pluck(advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-sum(pluck(advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum'))>0">
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="checkbox" name="advance" id="advance" v-model="advance" >
                    <label for="advance">Advance</label>
                </div>
                </template>
                <template v-if="sum(pluck(discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-sum(pluck(discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum'))>0">
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <input type="checkbox" name="discount" id="discount" v-model="discount" >
                    <label for="discount">Discount</label>
                </div>
                </template>


                <template v-if="this.advance==false && this.discount==false">
          <label class="col-sm-1 form-control-label">
                    Cash / Bank:  <span class="tx-danger">
                                *
                            </span>
                </label>

                <div class="col-sm-2 mg-t-10 mg-sm-t-0">

                    <select id="account" v-model="account" name="account" class="form-control " >
                        <option label="Choose Option" value="0"></option>
                        <option :value="co.code" v-for="co in accounts">
                            {{ co.name }}
                        </option>

                    </select>
                </div>
                <label class="col-sm-1 form-control-label">
                    Payment Method:  <span class="tx-danger">
                                *
                            </span>
                </label>
              <!--  <div class="col-sm-4 mg-t-10 mg-sm-t-0">

                    <select id="payment_method" v-model="payment_method" name="payment_method" class="form-control input-height select2" >
                        <option label="Choose Option" value="0"></option>
                        <option :value="type.id" v-for="type in account_types">
                            {{ type.account_head.desc }}  - ({{ type.type }})
                        </option>

                    </select>
                </div>-->
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">

                    <select id="payment_method" v-model="payment_method" name="payment_method" class="form-control " >
                        <option label="Choose Option" value="0"></option>
                        <option v-if="acc_permission.indexOf(type.name+' '+type.mod_id)!=-1" :value="type.id" v-for="type in account_types.filter((z)=>{return (this.account?this.accounts.filter((a)=>{return a.code==this.account})[0].cost_center:0)==(this.pms.filter((b)=>{return b.id==z.mod_id})[0].coa_trans_type)})">
                            {{ type.name }}
                        </option>
                    </select>
                </div>
                </template>

                <label class="col-sm-1 form-control-label">
                    ENT/CTS:
                </label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">

                    <select id="ent" v-model="ent" name="ent" class="form-control " >
                        <option label="No" :value="0"></option>
                        <option  :value="1">ENT</option>
                        <option  :value="2">CTS</option>
                    </select>
                </div>

            </div>
            <!-- row -->

            <div class="row mg-t-10">
                <label class="col-sm-1 form-control-label">
                    Cheque #:
                </label>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <input type="number" class="form-control" id="payment_mode_details" v-model="payment_mode_details" placeholder="Enter Cheque No." autocomplete="off">
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
                        <input @click="save_invoice(id)" :disabled="disabled" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn" value="Save"  :value="id?'Update':'Save'">


                        &nbsp;&nbsp;
                        <input @click="save_print(id)" :disabled="disabled"  :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn" value="Save &amp; Print">

                        &nbsp;&nbsp;
                        <a href="/finance-and-management/finance-cash-receipts-vue" class="btn btn-secondary">Cancel</a>

                    </div><!-- form-layout-footer -->
                </div>
            </div><!-- form-layout -->
        </div>








    </div>
</div>
</template>

<script>
    export default {
        name: "invoices",
        props: ['id','linking'],
        data(){
            return{
                company:this.id?0:'001-001',
                companies:[],
                advance:false,
                discount:false,
                year:0,
                month:0,
                selectall:'',
                gts:[],
                onLine: null,
                ent:0,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                invoice_no:'',
                invoice_date:'',
                ledger_amount:'',
                receipt_type:'0',

                guest_name:'',
                family:0,
                families:[],

                payment_method:0,
                account_types:[],
                accounts:[],
                account:0,
                disabled:false,
                mem_number:'',
                customer_id:'',
                employee_id:'',

                cop_number:'',
                cop_id:'',
                cop_id_:'',

                mem_id:'',
                mem_id_:'',
                guest_contact:'',
                guest_address:'',
                total_amount:0,
                surcharge:'',
                surcharge_percentage:'',
                total:0,
                amount_in_words:'',
                remarks:'',
                invoices:[],
                amounts:[],
                m:0,
                customers:[],
                alreadySearched:false,
                customer:'',
                types:[],
                type:0,
                transChecked:[],
                sur:0,
                cat_permission:'',
                acc_permission:'',
                // customer_id:'',
                payment_mode_details:'',
                fkey:-1,
                ffkey:0,
                pms:[],
                advances:[],
                discounts:[],
                units:[],
                thetotal:0,
                coaaccounts:[],
            }
        },

        methods:{
                selectAll: function() {
                    this.transChecked = [];

                        let self = this;
                   // console.log(moment('2021-07-15').startOf('year').format('YYYY'))
                        this.invoices.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) && (this.company==0?true:(this.company==a.unit)) && (this.month==0?true:(this.month==moment(a.date).startOf('month').format('MMMM'))) && (this.year==0?true:(this.year==moment(a.date).startOf('year').format('YYYY'))) && (this.type==0?true:(this.type==parseInt(a.trans_type))) && (this.cat_permission.filter((c)=>{return c.replace(/[^A-Za-z]/ig,'')==this.types.filter((b)=>{return b.id==a.trans_type})[0].name.replace(/[^A-Za-z]/ig,'')})[0] || this.cat_permission.filter((c)=>{return c.replace(/\D/g,'')==a.trans_type})[0] )  }).forEach(function(inv) {
                            if (!self.selectall) {
                            self.transChecked.push(inv.id.toString());

                        inv.p=(inv.trans_amount)-(inv.sum)
                            }
                            else{
                                inv.p=0;
                            }

                        });


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
            amIOnline(e) {
                this.onLine = e;
            },
            init:function (m) {
                let r='';
                if(m){
                    r='?r='+m;
                }
                // console.log(m);
                this.$http.get(this.linking+'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/init'+r).then(result=>{
                    let data=result.data;
                    // console.log(data);
                    if(m){
                        this.payment_mode_details=data.invoice_no.payment_mode_details;
                        this.ent=data.invoice_no.ent;
                        this.thetotal=data.invoice_no.total;
                        this.advance=data.invoice_no.advance;
                        this.discount=data.invoice_no.discount;
                        this.remarks=data.invoice_no.remarks;
                        this.family=data.invoice_no.family;
                         this.payment_method=data.invoice_no.account;
                        this.account=data.invoice_no.coa_trans_type;
                        this.surcharge=data.invoice_no.surcharge;
                        this.invoice_no=parseInt(data.invoice_no.id);
                        this.invoice_date=moment(data.invoice_no.invoice_date).format('DD/MM/YYYY');
                        this.receipt_type=data.invoice_no.mem_number?0:data.invoice_no.corporate_id?6:data.invoice_no.customer_id?1:3;
                        let b=this.receipt_type==3?data.invoice_no.employee_id:this.receipt_type==6?data.invoice_no.corporate_id:this.receipt_type==0?data.invoice_no.mem_number:this.receipt_type==1?data.invoice_no.customer_id:0
                        this.customerdatavalue(b,this.id);
                    }
                    else{
                        this.invoice_no=parseInt(data.invoice_no.id)+1;
                        this.invoice_date=moment().format('DD/MM/YYYY')
                    }
                    // console.log(data);
                    this.coaaccounts=data.invoice_no.coaaccounts;
                    this.gts=data.invoice_no.gts;
                    this.cat_permission=data.invoice_no.catspermit;
                 //   console.log(data.invoice_no.catspermit[0].replace(/[^A-Za-z]/ig,''));


                    this.acc_permission=data.invoice_no.accpermit;
                    this.types=data.invoice_no.filters;
                    this.account_types=data.invoice_no.account_types;
                    this.accounts=data.invoice_no.accounts;
                    this.pms=data.invoice_no.pms;
                    this.units=data.invoice_no.units;
                    this.companies=data.invoice_no.companies;
                })
            },


            customerdata(){
                let v = this.receipt_type;
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
                    else {
                        data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                    }
                    if(data){

                        this.customers=data;

                    }
                });
            },
            customerdatavalue(val,m){
                this.customers=[];
                //.toString();
                let v = this.receipt_type;
                let r='';

                if(m){
                    r='&r='+m;
                }
                console.log(val);
                this.$http.post('/search/customerdata?inv=1&balance=1&advance=1&discount=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.families=[];
                        if (v == 0) {
                            this.mem_id = data.mem_no;
                            this.mem_id_ = data.id;

                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.guest_contact = data.mob_a;
                            // console.log(data);
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            this.advances=data.advances;
                            this.discounts=data.discounts;

                            let self=this;

                            this.invoices.forEach(function(i){
                                i.sum=0;
                                i.sum2=0;

                                if(self.id){
                                    i.receipt_details2.forEach(function(x){
                                      /*  x.receipt_details2.forEach(function(d){*/
                                            i.sum=i.sum+x.trans_amount;
                                        /* })*/
                                    })
                                     i.p=(i.sum);
                                   /* i.p=self.thetotal;*/
                                    console.log(i.p)
                                    if(i.p>0){
                                        self.transChecked.push(i.id);

                                    }
                                }
                                else{
                                    i.receipts.forEach(function(x){
                                        console.log(x.receipt_details);
                                        x.receipt_details.forEach(function(d){

                                            if(d.trans_type==i.trans_type){
                                                i.sum=i.sum+d.trans_amount;
                                            }


                                        })
                                    })
                                }

                            })



                          /* this.invoices.forEach(function(i){
                                i.sum=0;
                                i.sum2=0;

                                self.receipts.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;

                                })

if(self.id){

    i.p=(i.sum);
    if(i.p>0){
        self.transChecked.push(i.id);

    }
}

                            })*/

                        /*    this.invoices.forEach(function(i){
                                i.sum=0;
                                i.sum2=0;

                                i.receipts.forEach(function(x){
                                    i.sum=i.sum+x.receipt_details.trans_amount;

                                })

                                if(self.id){
                                    i.receipts2.forEach(function(x){
                                        i.sum2=i.sum2+x.receipt_details.trans_amount;

                                    })
                                    i.p=(i.sum2);
                                    if(i.p>0){
                                        self.transChecked.push(i.id);

                                    }
                                }

                            })*/
                        }
                        else if (v == 6) {
                            this.cop_id = data.mem_no;
                            this.cop_id_ = data.id;

                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.guest_contact = data.mob_a;
                            // console.log(data);
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            this.advances=data.advances;
                            this.discounts=data.discounts;

                            let self=this;

                            this.invoices.forEach(function(i){
                                i.sum=0;
                                i.sum2=0;

                                if(self.id){
                                    i.receipt_details2.forEach(function(x){
                                        /*  x.receipt_details2.forEach(function(d){*/
                                        i.sum=i.sum+x.trans_amount;
                                        /* })*/
                                    })
                                    i.p=(i.sum);
                                    /* i.p=self.thetotal;*/
                                    console.log(i.p)
                                    if(i.p>0){
                                        self.transChecked.push(i.id);

                                    }
                                }
                                else{
                                    i.receipts.forEach(function(x){
                                        console.log(x.receipt_details);
                                        x.receipt_details.forEach(function(d){

                                            if(d.trans_type==i.trans_type){
                                                i.sum=i.sum+d.trans_amount;
                                            }


                                        })
                                    })
                                }

                            })


                        }
                        else if (v == 3) {
                            this.employee_id = data.id;
                            this.customer = data.name;
                            this.guest_contact = data.mob_a;
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            this.advances=data.advances;
                            this.discounts=data.discounts;

                            let self=this;
                            this.invoices.forEach(function(i){
                                i.sum=0;
                                i.sum2=0;


                                /*if(self.id){
                                    i.receipts2.forEach(function(x){
                                        x.receipt_details2.forEach(function(d){
                                            i.sum=i.sum+d.trans_amount;
                                        })

                                    })
                                    i.p=self.thetotal;
                                    console.log(i.p)
                                    if(i.p>0){
                                        self.transChecked.push(i.id);

                                    }
                                }*/
                                if(self.id){
                                    i.receipt_details2.forEach(function(x){
                                        /*  x.receipt_details2.forEach(function(d){*/
                                        i.sum=i.sum+x.trans_amount;
                                        /* })*/
                                    })
                                    i.p=(i.sum);
                                    /* i.p=self.thetotal;*/
                                    console.log(i.p)
                                    if(i.p>0){
                                        self.transChecked.push(i.id);

                                    }
                                }
                                else{
                                    i.receipts.forEach(function(x){
                                        console.log(x.receipt_details);

                                        x.receipt_details.forEach(function(d){

                                            if(d.trans_type==i.trans_type) {
                                                i.sum = i.sum + d.trans_amount;
                                            }
                                        })
                                    })
                                }

                            })
                        }
                        else {
                            this.receipt_type= 10+data.guest_type;
                           /* if(data.guest_type==1){
                                this.receipt_type='01';
                            }else if(data.guest_type==2){
                                this.receipt_type='02';
                            }*/
                            this.customer_id = data.id;
                            this.customer = data.customer_name;
                            this.guest_contact = data.customer_contact;
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            this.advances=data.advances;
                            this.discounts=data.discounts;

                            let self=this;
                            this.invoices.forEach(function(i){
                                i.sum=0;
                                i.sum2=0;


                                if(self.id){
                                    i.receipt_details2.forEach(function(x){
                                        /*  x.receipt_details2.forEach(function(d){*/
                                        i.sum=i.sum+x.trans_amount;
                                        /* })*/
                                    })
                                    i.p=(i.sum);
                                    /* i.p=self.thetotal;*/
                                    console.log(i.p)
                                    if(i.p>0){
                                        self.transChecked.push(i.id);

                                    }
                                }
                                else{
                                    i.receipts.forEach(function(x){
                                        console.log(x.receipt_details);
                                        x.receipt_details.forEach(function(d){

                                            if(d.trans_type==i.trans_type) {
                                                i.sum = i.sum + d.trans_amount;
                                            }
                                        })
                                    })
                                }

                            })
                        }
                        let self=this;
                        this.advances.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
                        this.discounts.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
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
            save_invoice:function(m){

               let data={
                   advance:this.advance==true?1:0,
                   discount:this.discount==true?1:0,
                   ent:this.ent,
                   customer:this.customer,
                    member_id:this.mem_id_,
                   corporate_id:this.cop_id_,
                    customer_id:this.customer_id,
                   employee_id:this.employee_id,
                    invoices:this.invoices,
                    total:this.total_amount,
                   transChecked:this.transChecked,
                   total_paid_amt:parseFloat(this.sur)+parseInt(this.total_amount),
                    sur:this.sur,
                   family:this.family,
                   payment_method:this.payment_method,
                   account:this.account,
                    remarks:this.remarks,
                   payment_mode_details:this.payment_mode_details,
                   invoice_date:this.invoice_date,
                   amount_in_words:this.toWords(parseFloat(this.sur)+parseInt(this.total_amount))

                };
                let url='/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/save';
                if(m){
                    url='/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/update';
                    data.id=this.id;
                }

                if(this.discount==true && this.total_amount>(this.sum(this.pluck(this.discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-this.sum(this.pluck(this.discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum')))){
                    alert('Total Amount cannot be greater than Total Discount !');
                    return false;
                }
                 if(this.advance==true && this.total_amount>(this.sum(this.pluck(this.advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-this.sum(this.pluck(this.advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum')))){
                    alert('Total Amount cannot be greater than Total Advance !');
                     return false;
                }
                if(this.transChecked.length==0)
                {
                    if((this.advance!=1 && !this.account) && (this.discount!=1 && !this.account)) {
                        alert('Cash / Bank is required !');
                    }
                    else if((this.advance!=1 && !this.payment_method) && (this.discount!=1 && !this.payment_method)) {
                        alert('Payment Method is required !');
                    }
                    else{
                        if(this.validation(data,['invoice_date', 'customer' ,'total_paid_amt', 'amount_in_words'])==0) {
                            this.disabled=true;
                            this.$http.post(url, data).then(result => {

                                window.location.href= "/finance-and-management/finance-cash-receipts-vue";
                            });
                        }
                    }
                }
               else
                {
                    if((this.advance!=1 && !this.account) && (this.discount!=1 && !this.account)) {
                        alert('Cash / Bank is required !');
                    }
                    else if((this.advance!=1 && !this.payment_method) && (this.discount!=1 && !this.payment_method)) {
                        alert('Payment Method is required !');
                    }
                    else {
                        if (this.validation(data, ['invoice_date', 'customer', 'amount_in_words']) == 0) {
                            this.disabled = true;
                            this.$http.post(url, data).then(result => {

                                window.location.href = "/finance-and-management/finance-cash-receipts-vue";
                            });
                        }
                    }
                }

            },
            save_print:function(m){

                let data={
                    advance:this.advance==true?1:0,
                    discount:this.discount==true?1:0,
                    customer:this.customer,
                    ent:this.ent,
                    member_id:this.mem_id_,
                    corporate_id:this.cop_id_,
                    customer_id:this.customer_id,
                    employee_id:this.employee_id,
                    invoices:this.invoices,
                    total:this.total_amount,
                    transChecked:this.transChecked,
                    total_paid_amt:parseFloat(this.sur)+parseInt(this.total_amount),
                    sur:this.sur,
                    family:this.family,
                    payment_method:this.payment_method,
                    account:this.account,
                    remarks:this.remarks,
                    payment_mode_details:this.payment_mode_details,
                    invoice_date:this.invoice_date,
                    amount_in_words:this.toWords(parseFloat(this.sur)+parseInt(this.total_amount))

                };
                let url='/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/save';
                if(m){
                    url='/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/update';
                    data.id=this.id;
                }

                if(this.discount==true && this.total_amount>(this.sum(this.pluck(this.discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-this.sum(this.pluck(this.discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum')))){
                    alert('Total Amount cannot be greater than Total Discount !');
                    return false;
                }
                if(this.advance==true && this.total_amount>(this.sum(this.pluck(this.advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-this.sum(this.pluck(this.advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum')))){
                    alert('Total Amount cannot be greater than Total Advance !');
                    return false;
                }
                if(this.transChecked.length==0)
                {
                    if((this.advance!=1 && !this.account) && (this.discount!=1 && !this.account)) {
                        alert('Cash / Bank is required !');
                    }
                    else if((this.advance!=1 && !this.payment_method) && (this.discount!=1 && !this.payment_method)) {
                        alert('Payment Method is required !');
                    }
                    else {
                        if (this.validation(data, ['invoice_date', 'customer', 'total_paid_amt', 'amount_in_words']) == 0) {
                            this.disabled = true;
                            this.$http.post(url, data).then(result => {

                                location.reload();
                                if (m) {
                                    window.open("/finance-and-management/finance-cash-receipts/finance-cash-receipts-invoice/" + m, "_blank");
                                } else {

                                    window.open("/finance-and-management/finance-cash-receipts/finance-cash-receipts-invoice/" + result.data, "_blank");
                                }

                            });
                        }
                    }
                }
                else
                {
                    if((this.advance!=1 && !this.account) && (this.discount!=1 && !this.account)) {
                        alert('Cash / Bank is required !');
                    }
                    else if((this.advance!=1 && !this.payment_method) && (this.discount!=1 && !this.payment_method)) {
                        alert('Payment Method is required !');
                    }
                    else {
                        if (this.validation(data, ['invoice_date', 'customer', 'amount_in_words']) == 0) {
                            this.disabled = true;
                            this.$http.post(url, data).then(result => {

                                location.reload();
                                if (m) {
                                    window.open("/finance-and-management/finance-cash-receipts/finance-cash-receipts-invoice/" + m, "_blank");
                                } else {

                                    window.open("/finance-and-management/finance-cash-receipts/finance-cash-receipts-invoice/" + result.data, "_blank");
                                }

                            });
                        }
                    }
                }

            }
        },
        watch:{
            /*total_amount:function(){
                if(this.advance==true && this.total_amount>sum(pluck(advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-sum(pluck(advances.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum'))){
alert('Total Amount cannot be greater than Total Advance !');
                    this.total_amount=0;
                }

                if(this.discount==true && this.total_amount>(this.sum(this.pluck(this.discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'trans_amount'))-this.sum(this.pluck(this.discounts.filter((a)=>{return ((a.trans_amount)-(a.sum)>0) }),'sum')))){
                    alert('Total Amount cannot be greater than Total Discount !');
                    this.total_amount=0;
                }
            },*/
            surcharge:function(){
                let sv=this.surcharge;
                if(this.surcharge=='' || this.surcharge==null){
                    sv=0
                }

                this.sur=sv;
            },
            surcharge_percentage:function(){
                let sv=this.surcharge_percentage;
                if(this.surcharge_percentage==''){
                    sv=0
                }

this.sur=(parseInt(this.total_amount)*parseFloat(sv)/100);
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
        mounted() {
            if(this.id){
                this.init(this.id);

                // this.init(id.id);

            }
            else{
                this.init();

            }

            let x=new URLSearchParams(window.location.search)
            if(x.get('memid')){
                this.receipt_type=0;
                this.customers=[];
                let v = this.receipt_type;
                let r='';
let m=this.id;
                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&balance=1&advance=1&discount=1&MOC='+v+r,{customerid:x.get('memid')}).then(result=>{
                    let data =result.data;
                    if(data) {
                        this.alreadySearched=true;
                        this.mem_id = data.mem_no;
                        this.mem_id_ = data.id;
                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                            this.families = data.family;
                            this.ledger_amount = data.balance;
                        this.guest_contact = data.mob_a;
                        this.invoices=data.invoices;
                        this.advances=data.advances;
                        this.discounts=data.discounts;

                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.receipt_details2.forEach(function(x){
                                    /*  x.receipt_details2.forEach(function(d){*/
                                    i.sum=i.sum+x.trans_amount;
                                    /* })*/
                                })
                                i.p=(i.sum);
                                /* i.p=self.thetotal;*/
                                console.log(i.p)
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }
                            else{
                                i.receipts.forEach(function(x){
                                    console.log(x.receipt_details);
                                    x.receipt_details.forEach(function(d){
                                        if(d.trans_type==i.trans_type) {
                                            i.sum = i.sum + d.trans_amount;
                                        }
                                    })
                                })
                            }

                        })
                        this.advances.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
                        this.discounts.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })

                    }
                });


               console.log(x.get('memid'));
            }
            if(x.get('corporateid')){
                this.receipt_type=6;
                this.customers=[];
                let v = this.receipt_type;
                let r='';
                let m=this.id;
                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&balance=1&advance=1&discount=1&MOC='+v+r,{customerid:x.get('corporateid')}).then(result=>{
                    let data =result.data;
                    if(data) {
                        this.alreadySearched=true;
                        this.cop_id = data.mem_no;
                        this.cop_id_ = data.id;
                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.families = data.family;
                        this.ledger_amount = data.balance;
                        this.guest_contact = data.mob_a;
                        this.invoices=data.invoices;
                        this.advances=data.advances;
                        this.discounts=data.discounts;

                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.receipt_details2.forEach(function(x){
                                    /*  x.receipt_details2.forEach(function(d){*/
                                    i.sum=i.sum+x.trans_amount;
                                    /* })*/
                                })
                                i.p=(i.sum);
                                /* i.p=self.thetotal;*/
                                console.log(i.p)
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }
                            else{
                                i.receipts.forEach(function(x){
                                    console.log(x.receipt_details);
                                    x.receipt_details.forEach(function(d){
                                        if(d.trans_type==i.trans_type) {
                                            i.sum = i.sum + d.trans_amount;
                                        }
                                    })
                                })
                            }

                        })
                        this.advances.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
                        this.discounts.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })

                    }
                });


                console.log(x.get('corporateid'));
            }
            else if(x.get('guestid')){
                this.receipt_type=1;
                this.customers=[];
                let v = this.receipt_type;
                let r='';
                let m=this.id;
                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&balance=1&advance=1&discount=1&MOC='+v+r,{customerid:x.get('guestid')}).then(result=>{
                    let data =result.data;
                    if(data) {
                        this.alreadySearched=true;
                        this.receipt_type= 10+data.guest_type;
/*
                        if(data.guest_type==1){
                            this.receipt_type='01';
                        }else if(data.guest_type==2){
                            this.receipt_type='02';
                        }*/

                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;
                        this.ledger_amount = data.balance;
                        this.invoices=data.invoices;
                        this.advances=data.advances;
                        this.discounts=data.discounts;

                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;

                            if(self.id){
                                i.receipt_details2.forEach(function(x){
                                    /*  x.receipt_details2.forEach(function(d){*/
                                    i.sum=i.sum+x.trans_amount;
                                    /* })*/
                                })
                                i.p=(i.sum);
                                /* i.p=self.thetotal;*/
                                console.log(i.p)
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }
                            else{
                                i.receipts.forEach(function(x){
                                    console.log(x.receipt_details);
                                    x.receipt_details.forEach(function(d){
                                        if(d.trans_type==i.trans_type) {
                                            i.sum = i.sum + d.trans_amount;
                                        }
                                    })
                                })
                            }

                        })
                        this.advances.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }

                        })
                        this.discounts.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
                    }
                });


                console.log(x.get('guestid'));
            }
            else if(x.get('empid')){
                this.receipt_type=3;
                this.customers=[];
                let v = this.receipt_type;
                let r='';
                let m=this.id;
                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&balance=1&advance=1&discount=1&MOC='+v+r,{customerid:x.get('empid')}).then(result=>{
                    let data =result.data;
                    if(data) {
                        this.alreadySearched=true;
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;
                        this.ledger_amount = data.balance;
                        this.invoices=data.invoices;
                        this.advances=data.advances;
                        this.discounts=data.discounts;

                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.receipt_details2.forEach(function(x){
                                    /*  x.receipt_details2.forEach(function(d){*/
                                    i.sum=i.sum+x.trans_amount;
                                    /* })*/
                                })
                                i.p=(i.sum);
                                /* i.p=self.thetotal;*/
                                console.log(i.p)
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }
                            else{
                                i.receipts.forEach(function(x){
                                    console.log(x.receipt_details);
                                    x.receipt_details.forEach(function(d){
                                        if(d.trans_type==i.trans_type) {
                                            i.sum = i.sum + d.trans_amount;
                                        }
                                    })
                                })
                            }

                        })
                        this.advances.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
                        this.discounts.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })

                    }
                });


                console.log(x.get('empid'));
            }  else if(x.get('ledgerid')){
                this.receipt_type=2;
                this.customers=[];
                let v = this.receipt_type;
                let r='';
                let m=this.id;
                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&balance=1&advance=1&discount=1&MOC='+v+r,{customerid:x.get('ledgerid')}).then(result=>{
                    let data =result.data;
                    if(data) {
                        this.alreadySearched=true;
                        this.employee_id = data.id;
                        this.customer = data.person_name;
                        // this.guest_contact = data.mob_a;
                        this.ledger_amount = data.balance;
                        this.invoices=data.invoices;
                        this.advances=data.advances;
                        this.discounts=data.discounts;

                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.receipt_details2.forEach(function(x){
                                    /*  x.receipt_details2.forEach(function(d){*/
                                    i.sum=i.sum+x.trans_amount;
                                    /* })*/
                                })
                                i.p=(i.sum);
                                /* i.p=self.thetotal;*/
                                console.log(i.p)
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }
                            else{
                                i.receipts.forEach(function(x){
                                    console.log(x.receipt_details);
                                    x.receipt_details.forEach(function(d){
                                        if(d.trans_type==i.trans_type) {
                                            i.sum = i.sum + d.trans_amount;
                                        }
                                    })
                                })
                            }

                        })

                        this.advances.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.advances2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })
                        this.discounts.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;


                            if(self.id){
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })
                            }
                            else{
                                i.discounts2.forEach(function(x){
                                    i.sum=i.sum+x.trans_amount;
                                })

                            }

                        })

                    }
                });


                console.log(x.get('ledgerid'));
            }

            let self=this;
            setInterval(function(){
                self.total_amount=self.sum(self.pluck(self.invoices,'p'))
            },200)
        }
    }
</script>

<style scoped>
.groove{
    overflow: auto;
    height: 220px !important;
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
</style>
