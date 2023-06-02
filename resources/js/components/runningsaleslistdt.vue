<template>
    <div>
        <vue-snotify></vue-snotify>
        <!--        <div class="hidden-print">
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
                    <br>
                </div>-->
        <div v-if="DeleteTheInvoice">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title" style="color: black;">ARE YOU SURE ?</h5>
                                    <button type="button" class="close" @click="DeleteTheInvoice=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span style="color: black;">Do you really want to Delete this Sale ?</span>
                                    <br> <br>
                                    <input placeholder="Enter Remarks" class="form-control input-height" v-model="remarks" id="remarks">

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <button @click="afterdel();" class="btn btn-outline-warning active">Yes</button>
                                    <button type="button" class="btn btn-secondary" @click="DeleteTheInvoice=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div class="row hidden-print">

            <div class="col-lg-3">
                <div class="row mb-2">

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="2"><span class="pabs">All</span>
                        </label>
                    </div>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Mem</span>
                        </label>
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="6"><span class="pabs">Corporate Mem</span>
                        </label>
                    </div>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                     <label class="rdiobox">
                           <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                       </label>
                    </div>

                      <!--  <div   v-for="gt in gts" class="col-sm-3 mg-t-10 mg-sm-t-0">
                            <label class="rdiobox">
                                <input type="radio" name="type" v-model="mog" :value="'0'+gt.id"><span class="pabs">{{gt.desc}}</span>
                                <br><br>
                            </label>

                        </div>
-->

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Emp</span>
                        </label>
                    </div>
                </div>
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input style="margin-top: -3px;" v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)">   {{c.name}}</a>
                        </li>

                    </ul>
                </div>

            </div>



            <div class="col-lg">
                <p style="color: black;">Invoice No.</p>
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="booking_no" v-model="booking_no"
                       name="booking_no" placeholder="Search Id...">
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Begin Date:</p>
                    <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">End Date:</p>
                    <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <div>
                    <p style="color: black;">Discounted/Taxed:</p>
                    <select class="form-control" v-model="specific" name="specific" id="specific">

                        <option value="0">All</option>
                        <option  value="1">
                            Discount
                        </option>
                        <option  value="2">
                            Tax
                        </option>

                    </select>
                </div>
            </div>


            <div class="col-lg">
                <div>
                    <p style="color: black;">Status:</p>
                    <select v-model="status"  class="form-control">
                        <option v-for="s in ['All','Advance','Paid','Unpaid']">{{s}}</option>
                    </select>
                </div>
            </div>


        </div>

        <div class="row hidden-print">
            <div class="col-lg">
                <!--                <p style="color: black;">Restaurant:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Restaurants" v-model="restaurant" :multiple="true" :options="(()=>{let x=[];
            restaurant_locations.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                <!--  <select class="form-control " v-model="restaurant" name="restaurant[]" id="restaurant" multiple="multiple">
                      <option v-for="restaurant in restaurant_locations" :value="restaurant.id">
                          {{restaurant.desc}}
                      </option>
                  </select>-->

            </div>

            <div class="col-lg">
                <!--                <p style="color: black;">Table #:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Tables" v-model="tabledef" :multiple="true" :options="(()=>{let x=[];
            table_defs.filter((a)=>{return this.restaurant.filter((m)=>{
                        return a.restaurant_location==m.id;
                    }).length>0}).forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                <!-- <select class="form-control" v-model="tabledef" name="tabledef[]" id="tabledef" multiple="multiple">
                     <option v-for="table in table_defs" :value="table.id">
                         {{table.desc}}
                     </option>
                 </select>-->

            </div>

            <div class="col-lg">
                <!--                <p style="color: black;">Waiter:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Waiters" v-model="waiter" :multiple="true" :options="(()=>{let x=[];
            waiter_defs.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
                <!-- <select class="form-control" v-model="waiter" name="waiter[]" id="waiter" multiple="multiple">
                     <option v-for="wait in waiter_defs" :value="wait.id">
                         {{wait.name}}
                     </option>
                 </select>-->

            </div>

            <div class="col-lg">
                <!--                <p style="color: black;">Cashier:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Cashiers" v-model="cashier" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>
<!--            <div class="col-lg">
                <div>
                    <select v-model="ent"  class="form-control">
                        <option v-for="s in ['Include ENT','Exclude ENT','Only ENT']">{{s}}</option>
                    </select>
                </div>
            </div>-->
            <div v-if="this.exported" class="col-xs">
                <!--                <p>&nbsp</p>-->
                <export-excel
                    class   = "btn btn-primary"
                    :data   = "json_data"
                    worksheet = "My Worksheet"
                    name    = "RunningSales.xls">
                </export-excel>
                <!--    <button type="button" class=" btn btn-primary"><i class="fa fa-file"></i> Export</button>-->
            </div>

        </div>
        <br>
        <div class="scrollclasstable1">

            <div>


                <table class="table-striped table-bordered table-hover ">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">INVOICE #</th>
                        <th class="wd-10p">INVOICE DATE</th>
                        <th class="wd-20p">NAME</th>
                        <th class="wd-10p">CUSTOMER TYPE</th>
                        <th class="wd-10p">RESTAURANT</th>
                        <th class="wd-10p">TABLE #</th>
                        <th class="wd-10p">GROSS</th>
                        <th class="wd-10p">DISC</th>
                        <th class="wd-10p">SUB-TOTAL</th>
                        <th class="wd-10p">TAX</th>
                        <th class="wd-10p">GRAND TOTAL</th>
                        <!--   <th class="wd-10p">AMOUNT PAID</th>
                           <th class="wd-10p">BALANCE</th>
                           <th class="wd-10p">DETAILS</th>
                           <th class="wd-10p">STATUS</th>-->
                        <th class="wd-10p">CASHIER</th>
                        <th class="wd-5p">KOT</th>
                        <!--<th class="wd-5p hidden-print">INVOICE</th>-->
                        <th class="wd-5p hidden-print">EDIT</th>
                        <th class="wd-5p hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(sales);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{tr.invoice_no}}</td>
                        <td>{{moment(tr.date).format('DD/MM/YYYY')}}</td>

                        <template v-if="tr.type==0">
                            <td>{{tr.tname}} {{tr.fname}} {{tr.mname}} {{tr.lname}}</td>
                        </template>
                        <template v-else-if="tr.type==6">
                            <td>{{tr.ctname}} {{tr.cfname}} {{tr.cmname}} {{tr.clname}}</td>
                        </template>
                        <template v-else-if="tr.type==1">
                            <td>{{tr.customer}}</td>
                        </template>
                        <template v-else-if="tr.type==3">
                            <td>{{tr.employee}}</td>
                        </template>
                        <template v-else>
                            <td>{{tr.name}}</td>
                        </template>

                        <template v-if="tr.type==1">
                            <template v-if="tr.cgt">
                                <td>{{tr.guesttype}}</td>
                            </template>
                            <template v-else>
                                <td>Guest</td>
                            </template>
                            <!--<template v-if="tr.cgt==1">
                                <td>Applied Member ({{tr.customer_id}})</td>
                            </template>
                            <template v-else-if="tr.cgt==2">
                                <td>Affiliated Member ({{tr.customer_id}})</td>
                            </template>
                            <template v-else>
                                <td></td>
                            </template>-->
                        </template>
                        <template v-else-if="tr.type==6">
                            <td>Corporate Member ({{tr.co_mem_no}}) - {{tr.coactivity}}</td>
                        </template>
                        <template v-else-if="tr.type==3">
                            <td>Employee ({{tr.customer_id}})</td>
                        </template>
                        <template v-else-if="tr.type==0">
                            <td>Member ({{tr.mem_no}}) - {{tr.activity}}</td>
                        </template>
                        <template v-else>
                            <td>Guest</td>
                        </template>
                        <td>{{tr.restaurant}}</td>
                        <td>{{tr.tabledef}}</td>
                        <td>{{parseInt(tr.gross) | numFormat }}</td>
                        <td>{{parseInt(tr.discount) | numFormat }}</td>
                        <td>{{parseInt(tr.sub_total) | numFormat }}</td>
                        <td>{{parseInt(tr.tax) | numFormat }}</td>
                        <td>{{Math.round(tr.grand_total) | numFormat }}</td>
                        <!-- <td>{{ (tr.paid_amount?parseInt(tr.paid_amount):0) | numFormat }}</td>
                         <td>{{ (tr.grand_total?parseInt(tr.grand_total):0)-(tr.paid_amount?parseInt(tr.paid_amount):0) | numFormat }}</td>

                         <td style="color:#0053a7;">{{tr.reciept_id}}</td>
                         <template v-if="(parseInt(tr.grand_total-tr.paid_amount))<0">
                             <td><button class=" btn btn-sm btn-outline-warning active">Advance</button></td>
                         </template>
                         <template v-else-if="(parseInt(tr.grand_total-tr.paid_amount))>0">
                             <template v-if="tr.type==1">
                                 <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'guestid=' + tr.customer_id">Unpaid</a></button></td>
                             </template>
                             <template v-else-if="tr.type==0">
                                 <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'memid=' + tr.customer_id">Unpaid</a></button></td>
                             </template>
                             <template v-else-if="tr.type==3">
                                 <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'empid=' + tr.customer_id">Unpaid</a></button></td>
                             </template>
                             <template v-else><td></td></template>
                         </template>
                         <template v-else>
                             <td><button class=" btn btn-sm btn-outline-success active">Paid</button></td>
                         </template>-->
                        <!-- <td style="color:#0053a7;"><u>{{tr.kotnos}}</u></td>-->
                        <td>{{tr.cashiername}}</td>
                        <td><button class="buttoncolor" title="Show KOTs"><a style="color:#000000;" target="_blank" :href="'/food-and-beverage/running-sales-list-vue/kots/' + tr.id"><i class="fas fa-eye"></i></a></button></td>

                        <!--   <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/food-and-beverage/sales/sales-invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                           --><td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/food-and-beverage/sales/sales-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.delete_comments);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                    </tr>

                    </tbody>

                </table>
                <div class="hidden-print">
                    <ul class="pagination">
                        <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                        <li>
                            <select  v-model="pagelength" class="">
                                <option value="30" >30</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="150" >150</option>
                                <option :value="sales.length" >ALL</option>
                            </select>
                        </li>  </ul>
                </div>

            </div>
        </div>


    </div>
</template>
<style>
.vdp-datepicker__clear-button{

    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 20px;
    color: #000;

}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#bcd3e3;
}
.pagination li {
    padding: 5px 10px;
    border: 1px solid #0a4177;
    margin-right: 2px;
    /* border-radius: 50%; */
    /* height: 40px; */
    /* width: 40px; */
    text-align: center;

    cursor: pointer;
    transition: all 0.3s;
}
.pagination li.active{
    background: #49a2fb;
    color: #fff;
}
.pagination li:hover{
    background: #49a2fb;
    color: #fff;
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
/*table thead th{
    position: sticky;
    top: 80px;
    background: #000;
}*/
table th{
    background:#0c3661;
    height: 50px !important;
}
table tfoot{
    background:#0c91ed;
}
table tfoot td{
    color :black !important;
    height: 30px !important;

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
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "salesdt",
    components: {
        Datepicker
    },
    props: [],
    json_data: [],
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            gts:[],
            status:'All',
            ent:'Include ENT',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            sales:[],
            salesR:[],
            salesM: [],
            booking_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mog:2,
            searchId:null,
            restaurant_locations:[],
            restaurant:[],
            table_defs:[],
            tabledef:[],
            waiter_defs:[],
            users:[],
            waiter:[],
            cashier:[],
            specific:0,
            json_data: [],
            fkey:-1,
            ffkey:0,
            exported:'',
            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.sales);

            let tgross=0;
            let tdisc=0;
            let tsub=0;
            let ttax=0;
            let grand_total=0;
            let paid_amount=0;
            //console.log(1);
            x.forEach(function (item) {

                tgross=tgross + parseInt(item.gross?item.gross:0);
                tdisc=tdisc + parseInt(item.discount?item.discount:0);
                tsub=tsub + parseInt(item.sub_total?item.sub_total:0);
                ttax=ttax + parseInt(item.tax?item.tax:0);
                grand_total=grand_total + parseInt(Math.round(item.grand_total?item.grand_total:0));
                paid_amount=paid_amount + parseInt(item.paid_amount?item.paid_amount:0);
                // grand_total:grand_total + parseInt(item.grand_total?item.grand_total:0),

            })
            return {
                tgross:tgross,
                tdisc:tdisc,
                tsub:tsub,
                ttax:ttax,
                grand_total:grand_total,
                paid_amount:paid_amount,
            }
        }
    },
    methods:{
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
        afterdel:function(){
            let data={
                remarks:this.remarks
            };
            let url='/food-and-beverage/sales/delete/'+this.deletethisid;
            if(this.validation(data,['remarks'])==0){
                this.DeleteTheInvoice=false;
                this.$http.post(url,data).then(result=> {
                    this.init();
                });
            }
        },
        deleteme: function (k,com) {
            this.DeleteTheInvoice=true;
            this.deletethisid=k;
            this.remarks=com;
        },
        filterData(sales){
            let   x=sales;
            if(this.booking_no){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.invoice_no)).startsWith(self.booking_no)});
            }

            if(this.specific){
                if(this.specific==1){
                    x=x.filter((a)=>{return a.discount!=0 && a.discount!=null});

                }
                if(this.specific==2){
                    x=x.filter((a)=>{return a.tax!=0 && a.tax!=null});

                }

            }

            if(this.restaurant.length>0){
                x=x.filter((a)=>{return this.restaurant.filter((m)=>{
                    return a.restaurant_location==m.id;
                }).length>0});

            }

            /*if(this.tabledef.length>0){
                x=x.filter((a)=>{return this.tabledef.indexOf(parseInt(a.table_definition))!=-1});

            }*/

            if(this.tabledef.length>0){
                x=x.filter((a)=>{return this.tabledef.filter((m)=>{
                    return a.table_definition==m.id;
                }).length>0});

            }

            if(this.waiter.length>0){
                x=x.filter((a)=>{return this.waiter.filter((m)=>{
                    return a.waiter_definition==m.id;
                }).length>0});

            }

            if(this.cashier.length>0){
                x=x.filter((a)=>{return this.cashier.filter((m)=>{
                    return a.created_by==m.id;
                }).length>0});

            }

            if(this.start_date){
                x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

            }
            if(this.end_date){
                x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }  if(this.status){

                if(this.status=='Paid'){
                    x=x.filter((a)=>{return (parseInt(Math.round(a.grand_total)-a.paid_amount))==0});

                }   else if(this.status=='Unpaid'){
                    x=x.filter((a)=>{return (parseInt(Math.round(a.grand_total)-a.paid_amount))>0});

                }   else if(this.status=='Advance'){
                    x=x.filter((a)=>{return (parseInt(Math.round(a.grand_total)-a.paid_amount))<0});

                }
                else{
                    x=x;
                }
            }
            if(this.ent){
                if(this.ent=='Include ENT'){
                    x=x;
                }   else if(this.ent=='Exclude ENT'){
                    x=x.filter((a)=>{return a.ent==0});
                }   else if(this.ent=='Only ENT'){
                    x=x.filter((a)=>{return a.ent==1});
                }
                else{
                    x=x;
                }
            }
            if (this.searchId){

                x=x.filter((a)=>{return a.customer_id==this.searchId});

            }
            if(this.mog!=2) {

                x=x.filter((a)=>{
                    if(this.mog==1)
                        return a.type==1
                    else if(this.mog==0)
                        return a.type==0
                    else if(this.mog==6)
                        return a.type==6
                    else if(this.mog==3)
                        return a.type==3
                });
            }
            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(sales){
            // console.log(123);
            this.salesM=sales;
            /*  this.json_data=this.salesM;*/
            return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/food-and-beverage/sales/running_sales_init_vue').then(result=>{
                let data=result.data;
                this.gts=data.gts;
                this.restaurant_locations=data.restaurant_locations;
                this.table_defs=data.table_defs;
                this.waiter_defs=data.waiter_defs;
                this.users=data.users;
                this.sales=data.sales;
                this.salesR=data.sales;
                this.json_data=data.sales;
                this.leng=data.sales.length;
                this.exported=data.exported;
            })
        },

        customerdata(){
            let v = this.mog;
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
                else if(v==6){
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
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ (a.hrcompany?a.hrcompany.name:'') + ' '+ '-' + ' ' + a.designation +')'})
                }
                else{
                    data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                }
                if(data){

                    this.customers=data;

                }
            });

        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = this.mog;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;

                if(data){
                    this.searchId
                    this.families=[];
                    this.searchId=data.id;

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

                    }
                    else if (v == 6) {

                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.guest_contact = data.mob_a;
                        // console.log(data);
                        this.families=data.family;

                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;

                    }
                    else{
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;

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
    },
    watch:{
        salesM:function(){
            console.log(1);
        },
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.searchId=null;
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

    }
}
</script>
