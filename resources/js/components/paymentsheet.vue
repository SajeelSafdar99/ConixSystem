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

                                    <h5 class="modal-title">Cancellation Form:</h5>
                                    <button type="button" class="close" @click="showCancellationModal=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Remarks:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea v-model="remarks" name="remarks" class="form-control" rows="4"></textarea>
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
<!--
                    <label class="col-sm-1 form-control-label">Book:  <span class="tx-danger">  * </span>  </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select class="form-control" name="book" v-model="book" >
                            <option value="0">Choose Option</option>
                            <option v-for="b in books" :value="b.id">
                                {{b.desc}} <template v-if="b.debit_or_credit==0">(Debit)</template><template v-else>(Credit)</template>
                            </option>
                        </select>
                    </div>



                        <label class="col-sm-1 form-control-label">
                            Doc #:
                            <span class="tx-danger">
                                *
                            </span>
                        </label>
                        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                            <input type="number" v-model="doc_no" id="doc_no" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1">

                        </div>-->

                    <label class="col-sm-1 form-control-label">Invoice #:  <span class="tx-danger">  * </span>  </label>
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <input type="text" class="form-control input-height" id="invoice_no" v-model="invoice_no" value="1" autocomplete="off" readonly="" style="background-color: #c1c1c1">
                    </div>


                    <label class="col-sm-1 form-control-label">
                        Invoice Date:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>

                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <datepicker   v-model="invoice_date" :clear-button="true" placeholder="dd/mm/yyyy" format="dd/MM/yyyy" input-class="form-control" name="invoice_date"></datepicker>

                        <!-- <input type="text" v-model="invoice_date" id="invoice_date" class="form-control input-height" autocomplete="off" value="14/04/2020" readonly="" style="background-color: #c1c1c1">
     -->
                    </div>

                <!--    <label class="col-sm-1 form-control-label"> Company: <span class="tx-danger">  *  </span> </label>

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


                    <label class="col-sm-1 form-control-label"> Company: <span class="tx-danger">  *  </span> </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <select id="company" v-model="company"  class="form-control  ">
                            <!--   <option label="Choose Company" value="0">  </option>-->
                            <option :value="com.code" v-for="com in companies">
                                {{com.name}}
                            </option>
                        </select>
                    </div>
                    </div>
                <br>
                <div class="row mg-t-10">
                    <label class="col-sm-1 form-control-label">Supplier:  <span class="tx-danger"> * <template v-if="this.add_sup"><a href="/finance-and-management/suppliers/suppliers-aeu" target="popup" onclick="window.open('/finance-and-management/suppliers/suppliers-aeu','popup','width=700,height=550'); return false;"><i class="fa fa-plus"></i></a></template> </span>  </label>

                    <!--
                       <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                           <div class="form-group has-search"  v-on:keydown.up.prevent="udf4(1)" v-on:keydown.down.prevent="udf4(0)">
                               <input  type="text" class="form-control typeahead" autocomplete="off" v-model="accsearch"     name="accsearch" id="accsearch" placeholder="Search COA...">
                               <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="accsearchid"     name="accsearchid" id="accsearchid" placeholder="Search COA...">
                               <ul id="areabox5" class="areabox" style="color: #fff;background: aliceblue;
                       list-style-type: none;color: black;" v-if="this.accsearch && searchedaccounts.length>0">

                                   <li class="fbb" :class="'ccs'+key" @click="accountdatavalue(itd.id)" v-for="(itd,key) in searchedaccounts.filter((a)=>{return a.cost_center==this.unitsearchid})">
                                       <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                                   </li>
                               </ul>
                           </div>
                       </div>-->
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                            <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name or ID">


                            <ul id="areabox" class="areabox" style="color: #ffffff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                                <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                                    <a href="javascript:void(0)">   {{c.name}}</a>
                                </li>

                            </ul>
                        </div>
                    </div>



                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <input type="text" class="form-control input-height" placeholder="Supplier #" name="customer_id" id="customer_id" v-model="customer_id" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">
                    </div>



                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <input type="number" class="form-control input-height" placeholder="Ledger Amt" id="ledger_amount" name="ledger_amount" v-model="ledger_amount" autocomplete="off" readonly="" style="background-color: #c1c1c1" value="">
                    </div>

                </div>

                <br>
                <div class="row mg-t-10">
<!--                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="search"    tabindex="1" name="search" placeholder="Search by Unit...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                                </li>
                            </ul>
                        </div>
                    </div>-->

                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="accsearch"   tabindex="2" name="accsearch" id="accsearch" placeholder="Search COA...">
                            <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="accsearchid"     name="accsearchid" id="accsearchid" placeholder="Search COA...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.accsearch && searchedaccounts.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="accountdatavalue(itd.id)" v-for="(itd,key) in searchedaccounts">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                 <!--  .filter((a)=>{return a.cost_center==drows[active_el].unit})-->
                  <!--  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="childsearch"   tabindex="3" name="childsearch" id="childsearch" placeholder="Search by Child...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.childsearch && searchedchilds.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="childdatavalue(itd.id)" v-for="(itd,key) in searchedchilds.filter((a)=>{return a.cost_center==drows[active_el].unit})">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>-->
                   <!-- <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%">
                        <select tabindex="4" v-model="drows[active_el].payment_method" id="pmsearch" name="payment_method" class="form-control">
                            <option :value="pm.id" v-for="pm in payment_methods">
                                {{ pm.name }}
                            </option>
                        </select>
                    </div>-->
<!--                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="pmsearch"   tabindex="4" name="pmsearch" id="pmsearch" placeholder="Search by Payment Method...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.pmsearch && searchedpms.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="pmdatavalue(itd.id)" v-for="(itd,key) in searchedpms">
                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>-->
<!--
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="search"  v-on:keyup.enter="itemsdatavalueEnter(search)" tabindex="1" name="search" placeholder="Search by Item Name / Code...">
                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searchedunits.length>0">

                                <li class="fbb" :class="'ccs'+key" @click="itemsdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                                    <a href="javascript:void(0)"> {{itd.item_code}} - {{itd.item_details}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>-->
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="drows[active_el].amount"   name="amount" id="amount" tabindex="5" type="number" placeholder="Amount">
                    </div>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control" v-model="drows[active_el].description" name="description" id="description"  tabindex="6" v-on:keyup.enter="refres"   type="text" placeholder="Description">
                    </div>

                </div>



                <div class="clearfix"></div>
                <div class="form-layout form-layout-4 blackcolor">
                    <div>
                        <button v-if="!this.id" @click="removetr(active_el);" class="btn btnfont"><b>/</b></button>
<!--                        <button @click="updatetrplus(active_el);" class="btn btnfont"><b>+</b></button>
                        <button @click="updatetrminus(active_el)" class="btn btnfont"><b>-</b></button>-->

                        <template v-if="this.id">
                            <button @click="updatetrstatus(active_el)" class="btn btnfont"><i class="fa fa-times"></i></button>
                        </template>
                    </div>

                    <div class="scrollclasstable1" :class="{scrollclasstable2: this.drows.length>0 }">
                        <div>
                            <table>
                                <thead :style="'font-size:16px'">
                                <tr bgcolor="#5f9ea0">

                                    <th class="wd-5p">Sr #</th>
<!--                                     <th class="wd-15p">Unit</th>-->
                                    <th class="wd-20p">Account</th>
                                  <!--  <th class="wd-10p">Ledger Amount</th>
                                    <th class="wd-20p">Payment Method</th>-->
                                    <th class="wd-20p">Amount</th>
                                    <th class="wd-25p">Description</th>
                                    <th class="wd-5p">Status</th>
                                    <th class="wd-5p">Cancellation Remarks</th>
                                </tr>
                                </thead>
                                <tbody :style="'font-size:15px'">
                                <tr v-if="tr.code" @click="activate(key)" :class="{ activatedtr : active_el == key }" v-for="(tr,key) in drows">
                                    <!--<td><i class="fa fa-trash"></i></td>-->
                                    <td>{{(key+1)}}</td>
<!--
                                     <td>{{tr.unit}} - {{units.filter(function(a){return a.code==tr.unit})[0].name}} ({{units.filter(function(a){return a.code==units.filter(function(a){return a.code==tr.unit})[0].desc})[0].name}})</td>
-->

                                    <td>{{tr.code}}  {{tr.name}}<input type="hidden" v-model="tr.hid"></td>

                                   <!-- <td>{{tr.balance}}</td>
                                    <td><template v-if="tr.payment_method">{{payment_methods.filter(function(a){return a.id==tr.payment_method})[0].name}}</template> <input type="hidden" v-model="tr.hid"></td>
                                   -->
                                    <!--<td><input style="background-color: transparent !important; color: black !important;" type="number" placeholder="Enter Amount" class="form-control input-height" v-model="tr.purchase_price"></td>-->
                                    <td>{{tr.amount}}</td>
                                    <td>{{tr.description}}</td>

                                    <td>{{tr.status}}</td>
                                    <td>{{tr.remarks}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row mg-t-10">

                    <label class="col-sm-1 form-control-label">
                        Grand Total:
                        <span class="tx-danger">
                                *
                            </span>
                    </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <input type="number" v-model="grand_total" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >
                    </div>



                    <label class="col-sm-1 form-control-label">
                        Comments:
                    </label>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <textarea type="text" class="form-control" id="comments" v-model="comments" placeholder="Enter Details" autocomplete="off"></textarea>
                    </div>

                </div>
                <!-- row -->

                <div class="row mg-t-10">
                    <label class="col-sm-1 form-control-label">
                        Attachments:
                    </label>
                    <div v-if="this.id" class=" col-sm-1 mg-t-10 mg-sm-t-0">

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
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <vue-upload-multiple-image :showEdit="false" :showDelete="false" :primaryText="''" :dragText="'Attach Document'" :browseText="'(Browse)'"
                                                   @upload-success="uploadImageSuccess"
                                                   @edit-image="editImage"
                                                   :data-images="document"
                        ></vue-upload-multiple-image>
                        <!--           @before-remove="beforeRemove"                         -->
                    </div>
                </div>


                <div class="float-left">



                    <div class="row mg-t-10">
                        <label class="col-sm-4 form-control-label"></label>

                        <div class="form-layout-footer mg-t-30">
                            <input @click="save_payment(id)"  :disabled="disabled" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn" value="Save"  :value="id?'Update':'Save'">


<!--
                            &nbsp;&nbsp;
                            <input @click="save_print(id)" :class="id?'btn-success':'btn-info'" type="submit" name="save" class="btn"  :value="id?'Update &amp; Print':'Save &amp; Print'" value="">
-->

                            &nbsp;&nbsp;
                            <a href="/finance-and-management/finance-expenses-vue" class="btn btn-secondary">Cancel</a>

                        </div><!-- form-layout-footer -->
                    </div>
                </div><!-- form-layout -->
            </div>


        </div>
    </div>
</template>

<script>
export default {
    name: "paymentsheet",
    props: ['id','linking'],
    data(){

        return{
            company:'001-001',
            companies:[],
            document:[],
            documents:[],
            picturas:[],

            grand_total:0,
            books:[],
            book:0,
            comments:'',
            doc_no:'',
            dated:'',
            units:[],
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            invoice_no:'',
            invoice_date:'',
            ledger_amount:'',
            searchedunits:[],
            searchedaccounts:[],
            searchedchilds:[],
            searchedpms:[],
            guest_name:'',
            family:0,
            families:[],
            search:'',
            accsearch:'',
            childsearch:'',
            pmsearch:'',
            locations:[],
            departments:[],
            disabled:false,
            customer_id:'',
            gross:0,
            showinggross:0,
            discount:'',
            discount_percentage:'',
            tax:'',
            tax_percentage:'',
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
            unitalreadySearched:false,
            childalreadySearched:false,
            accountalreadySearched:false,
            pmalreadySearched:false,
            drows:[{
                unit:'',
                costCenter:'',
                description:'',
                amount:'',
            }],
            quantity:'',
            amount:'',
            description:'',
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
            ffkey:0,
            balance:0,
            add_cat:'',
            add_sub:'',
            add_item:'',
            additional_amt:'',
            additional_per:'',
            add_sup:'',

            showCancellationModal: false,
            alternativeqty:'',
            cancelled_remarks:[],
            sCancelledRemark:'',
            aftercancel:'Void',
            measurement_units:[],
            unit:'',
            ccs:[],
            payment_methods:[],
            unitsearch:'',
            unitsearchid:'',
            unitalreadySearched:false,
            ccs:[],
            accsearchid:'',
            imageFiles: []
        }
    },
    methods:{
        uploadImageSuccess(formData) {
            // console.log('data', formData, index, fileList);

            this.imageFiles.push (
              formData.get("file")
            );

            // Upload image api
            // axios.post('http://your-url-upload', formData).then(response => {
            //   console.log(response)
            // })
           // let url='/finance-and-management/finance-expenses/temporary_upload';
            //this.$http.post(url,formData).then(result=>{
            //    this.documents.push(result.data);
             //   console.log(this.documents);
            //});

        },
        beforeRemove (index,done, fileList) {
            console.log('index', index, fileList)
            var r = confirm("Are you sure ?")
            if (r == true) {
                done()
                let url='/finance-and-management/finance-expenses/temporary_remove';
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
        /*unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.unitsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.unitsearch=a.name })

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
        },*/
        canceldone:function(){
                    let myitem =this.drows[this.active_el];

                    myitem.status='Cancelled';
                    myitem.remarks=this.remarks;

                    let clone = (JSON.parse(JSON.stringify(myitem)));

                    this.remarks='';
                    this.showCancellationModal=false;

        },
        refres:function(){
            $('input[name="search"]').focus();
            this.active_el=this.drows.length-1;
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
        udf3(event){

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
            this.$http.get(this.linking+'/finance-and-management/finance-expenses/finance-expenses-aeu/init'+r).then(result=>{
                let data=result.data;
                // console.log(data);
                if(m){
                    this.picturas=data.documents;
                    console.log(this.picturas);
                    this.invoice_no=parseInt(data.expense_no);
                 //   this.invoice_date=moment(data.expense_date).format('DD/MM/YYYY');
                    this.invoice_date=data.expense_date;
                    this.drows=data.drows;
                    this.doc_no=data.doc_no;
                    this.book=data.book;

                    let b=data.supplier_id;
                    this.customerdatavalue(b,this.id);

                    this.comments=data.comments;
                }
                else{
                    this.invoice_no=data.expense_no?parseInt(data.expense_no)+1:1;

                    this.invoice_date=new Date();
                    /*  this.invoice_date=moment().format('DD/MM/YYYY')*/
                    this.dated=moment().format('DD/MM/YYYY');
                    this.drows=[{
                         unit:'',
                        costCenter:'',
                        description:'',
                        amount:'',
                    }];
                    this.doc_no='';
                    this.book=0;

                }
                // console.log(data);
                this.ccs=data.ccs;
                this.books=data.books;
                this.units=data.units;
                this.payment_methods=data.payment_methods;
                this.add_sup=data.add_sup;
                this.ccs=data.ccs;
                this.companies=data.companies;
            })
        },
        save_to_selected:function(){
            if(this.quantity==''){
                this.quantity=1;
            }
            if(this.amount==''){
                this.amount=0;
            }
            if(this.quantity>0){
                let clone = (JSON.parse(JSON.stringify(this.selecteditem)));

                if(this.drows[this.active_el].store_location=='') {alert('Please select Location first !'); return 0}

                else{
                    clone.qty=this.quantity;
                    clone.purchase_price=this.amount;
                    clone.description=this.description;
                    clone.store_location=this.drows[this.active_el].store_location;
                    clone.department=this.drows[this.active_el].department;
                    this.drows.unshift(clone);
                    this.active_el=0;
                }

                this.quantity='';
                this.amount='';
                this.description='';

            }

        },
        removetr:function(el){
            if(this.drows[this.active_el].saved!=1){
                this.drows.splice(this.active_el,1);
            }

        },
        updatetrplus:function(el){
            if(this.drows[this.active_el].saved!=1){
                this.drows[this.active_el].qty=this.drows[this.active_el].qty-2+3;
                /* this.drows[this.active_el].item_discount=parseFloat(this.drows[this.active_el].item_discount)+parseFloat(this.drows[this.active_el].item_discount);
                   */

            }
        },
        updatetrminus:function(el){
            if(this.drows[this.active_el].saved!=1){
                this.drows[this.active_el].qty=this.drows[this.active_el].qty-1;

                if(this.drows[this.active_el].qty==0)
                {
                    this.drows.splice(this.active_el,1);
                }

            }

        },
        alternativeqtyrestrict(){
            if(this.alternativeqty>this.drows[this.active_el].qty) this.alternativeqty=this.drows[this.active_el].qty;
        },
        updatetrstatus:function(el){
            this.showCancellationModal = true;
        },
        activate:function(el){
            this.active_el = el;
        },
         unitdatavalue(val,m){
            this.searchedunits=[];
            let r='';
             this.ffkey=0
            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/unitdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.unitalreadySearched=true;


                        let clone = (JSON.parse(JSON.stringify(data)));

clone.unit=clone.code;
      /*   clone.unitname=clone.name;*/

                            clone.amount=this.amount;
                            clone.description=this.description;
                            clone.payment_method=this.pmsearch;
                    clone.code='';
                    clone.name='';
                    clone.status='';
                            this.drows.unshift(clone);
                            this.active_el=0;


                      /*  this.quantity='';
                        this.amount='';
                        this.description='';
                         $('#description').focus(); */
                        this.search ='';
                    $('#accsearch').focus();


                }
            });
        },
        childdatavalue(val,m){
            this.searchedchilds=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/childdata?balance=1&MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.childalreadySearched=true;

                    let clone = (JSON.parse(JSON.stringify(data)));

                    this.drows[this.active_el].code=clone.code;
                    this.drows[this.active_el].name=clone.name;
                    this.drows[this.active_el].balance=clone.balance;

                    this.active_el=0;


                    this.childsearch ='';
                    $('#pmsearch').focus();



                }
            });
        },

        accountdatavalue(val,m){
            this.searchedaccounts=[];
            let r='';
            this.ffkey=0
            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/expaccountdata?balance=1&MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.accountalreadySearched=true;

                    let clone = (JSON.parse(JSON.stringify(data)));
                    clone.code = clone.code;
                    clone.name=clone.name;
                   /* this.drows[this.active_el].code = clone.code;
                    this.drows[this.active_el].name=clone.name;*/
                    this.drows.unshift(clone);
                    this.active_el=0;

                    this.accsearch ='';
                    $('#amount').focus();



/*
                    let clone = (JSON.parse(JSON.stringify(data)));

                    clone.unit=clone.code;

                    clone.amount=this.amount;
                    clone.description=this.description;
                    clone.payment_method=this.pmsearch;
                    clone.code='';
                    clone.name='';
                    clone.status='';
                    this.drows.unshift(clone);
                    this.active_el=0;*/






                }
            });
        },
        pmdatavalue(val,m){
            this.searchedpms=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/pmdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.pmalreadySearched=true;


                    let clone = (JSON.parse(JSON.stringify(data)));


                    /*  clone.qty=this.quantity;
                      clone.purchase_price=this.amount;
                      clone.description=this.description;
                      clone.store_location=this.drows[this.active_el].store_location;
                      clone.department=this.drows[this.active_el].department;*/
                    /* this.drows.unshift(clone);*/
                    this.drows[this.active_el].payment_method=clone.code;
                    this.active_el=0;


                    /* this.quantity='';
                     this.amount='';
                     this.description='';
                      $('#description').focus();*/
                    this.pmsearch ='';
                    $('#amount').focus();



                }
            });
        },
        itemsdatavalueEnter(val,m){
            this.searchedunits=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/storeitemsdataenter?inv=1&MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.unitalreadySearched=true;
                    if(this.quantity==''){
                        this.quantity=1;
                    }
                    if(this.amount==''){
                        this.amount=0;
                    }
                    if(this.quantity>0){
                        let clone = (JSON.parse(JSON.stringify(data)));

                        if(this.drows[this.active_el].store_location=='') {alert('Please select Location first !'); return 0}
                        else{
                            clone.qty=this.quantity;
                            clone.purchase_price=this.amount;
                            clone.description=this.description;
                            clone.store_location=this.drows[this.active_el].store_location;
                            clone.department=this.drows[this.active_el].department;
                            this.drows.unshift(clone);
                        }

                        this.quantity='';
                        this.amount='';
                        this.description='';
                        this.search ='';
                    }
                }
            });
        },
        unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.search}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.search=a.name})

                if(data){

                    this.searchedunits=data;

                }
            });
        },
        childdata(){
            this.$http.post('/search/coa/childdatalike',{searchid:this.childsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.childsearch=a.name})

                if(data){

                    this.searchedchilds=data;

                }
            });
        },
        accountdata(){
            this.$http.post('/search/coa/expaccountdatalike',{searchid:this.accsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.accsearch=a.name})

                if(data){

                    this.searchedaccounts=data;

                }
            });
        },
        pmdata(){
            this.$http.post('/search/coa/pmdatalike',{searchid:this.pmsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.pmsearch=a.name})

                if(data){

                    this.searchedpms=data;

                }
            });
        },
        enterquantity:function(el){

            // if(this.quantity<1 && this.quantity!='') alert('Please Enter a valid Quantity !');

            /* this.drows[this.active_el].qty=this.quantity;*/
        },
        getItemDefs:function(){
            this.$http.get('/store-management/store-purchases/items/'+this.sSubCat).then(result=>{
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
            let v = 22;
            this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                let data =result.data;

                data.filter((a)=>{a.name=a.person_name + ' ' + a.id})

                if(data){

                    this.customers=data;

                }
            });
        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = 22;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=1&paybalance=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;
                if(data){

                    this.customer_id = data.id;
                    this.customer = data.person_name;
                    this.ledger_amount=data.balance;
                    this.balance=data.balance;
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
        save_payment:function(m){
            console.log(this.invoice_date);

            let data = {
                drows: this.drows.filter((a)=>{return a.code!=null}),
                company:this.company,
                grand_total:this.grand_total,
                invoice_no:this.invoice_no,
                invoice_date:this.invoice_date,
                supplier_id:this.customer_id,
                comments:this.comments,
                document:this.documents,
            };


            let formData = new FormData();

            formData.append("supplier_id", this.customer_id);
            formData.append("invoice_no", this.invoice_no);
            formData.append("company", this.company);

            if(m){
                formData.append("invoice_date", new Date(this.invoice_date).toLocaleDateString('en-CA'));
            }else{
                formData.append("invoice_date", this.invoice_date.toLocaleDateString('en-CA'));
            }

            formData.append("grand_total", this.grand_total);
            formData.append("comments", this.comments);

            this.imageFiles.forEach(image =>
            {
                formData.append("images[]", image);
            });

            this.drows.filter((a)=>{return a.code!=null}).forEach((drow, index) =>
            {
                for (let prop in drow)
                {
                    formData.append(`drows[${index}][${prop}]`, drow[prop]);
                }

            })




            let url='/finance-and-management/finance-expenses/finance-expenses-aeu/save';
            if(m){
                url='/finance-and-management/finance-expenses/update';
                formData.append("id", this.id);
            }
           if(this.validation(data,['invoice_no', 'invoice_date','supplier_id' ,'drows', 'grand_total', 'company'])==0) {

                this.$http.post(url, formData, {
                    "Content-Type": "multipart/form-data"
                }).then(result => {
                 if(result.status==200) {
                     this.disableds=true;
                   window.location.href = "/finance-and-management/finance-expenses-vue";
                 }
                }).catch(error=> {
                    this.$snotify.error('Oops! Something went wrong. Try saving again.');
                });
             }

        },
        save_print:function(m){
            let data={
                drows: this.drows.filter((a)=>{return a.item_code!=null}),
                customer:this.customer,
                customer_id:this.customer_id,
                gross:this.gross,
                grand_total:parseFloat(this.gross)-parseFloat(this.dis)+parseFloat(this.taxx)+parseFloat(this.adds),
                dis:this.dis,
                taxx:this.taxx,
                adds:this.adds,
                remarks:this.remarks,
                invoice_date:this.invoice_date,
                invoice_no:this.invoice_no,
                amount_in_words:this.toWords(Math.round(parseFloat(this.gross)-parseFloat(this.dis)+parseFloat(this.taxx)+parseFloat(this.adds))),
                document:this.documents,
            };
            let url='/store-management/store-purchases/store-purchases-aeu/save';
            if(m){
                url='/store-management/store-purchases/store-purchases-aeu/update';
                data.id=this.id;
            }

            if(this.validation(data,['invoice_no','invoice_date', 'customer','customer_id','gross' ,'grand_total', 'amount_in_words', 'drows'])==0) {
                this.disabled=true;
                this.$http.post(url, data).then(result => {
                    location.reload();
                    if(m){
                        window.open("/store-management/store-purchases/store-purchases-invoice/"+m, "_blank");
                    }
                    else{
                        window.open("/store-management/store-purchases/store-purchases-invoice/"+result.data, "_blank");
                    }

                });
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
        book:function(){
            let self=this;
            if(self.book==0){
                this.doc_no='';
            }
            else{
                let data = {};
                let url = '/book/docdata/' + self.book;
                data.id =  self.book;

                this.$http.get(url, data).then(result => {
                    console.log(result.data);
                    this.doc_no=result.data;
                });


                // this.doc_no=this.books.filter(function(a){return a.id==self.book})[0].id +1;
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
            if(this.search.length==0){
                this.unitalreadySearched=false;
            }
            if(!this.unitalreadySearched){
                this.unitsdata();
            }
        },
        childsearch:function(){
            if(this.childsearch.length==0){
                this.childalreadySearched=false;
            }
            if( !this.childalreadySearched){
                this.childdata();
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
        pmsearch:function(){
            if(this.pmsearch.length==0){
                this.pmalreadySearched=false;
            }
            if(!this.pmalreadySearched){
                this.pmdata();
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
            self.grand_total=self.sum(self.pluck(self.drows,'amount'))
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
