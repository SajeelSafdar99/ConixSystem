<template>
<div>
    <vue-snotify></vue-snotify>
<!--    <div class="hidden-print">
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

                                <span style="color: black;">Do you really want to Delete this Invoice ?</span>
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


       <!-- <div class="col-lg">

            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                <input  v-model="accsearch" name="accsearch" id="accsearch" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by COA...">


                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="searchedaccounts.length>0 && accsearch!=''" >

                    <li  :class="'fbb fba'+key"  @click="accountdatavalue(c.id)"  v-on:keyup.enter="accountdatavalue(c.id)" v-for="(c,key) in searchedaccounts.filter((a)=>{return a.cost_center==this.unitsearchid})">
                        <a href="javascript:void(0)">{{c.code}} - {{c.name}}</a>
                    </li>

                </ul>
            </div>

        </div>-->

        <div class="col-lg-3">
            <div class="row mb-2">
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input  type="radio"  name="mog" v-model="mog" value="6"><span class="pabs">All</span>
                    </label>
                </div> <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
                    <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
                </label>
            </div>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                    </label>
                </div>
                   <!-- <div v-for="gt in gts" class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label   class="rdiobox">
                            <input type="radio" name="type" v-model="mog" :value="'0'+gt.id"><span class="pabs">{{gt.desc}}</span>

                        </label>
                    </div>-->

                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Employee</span>
                    </label>
                </div>
            </div>
            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                    <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                        <a href="javascript:void(0)" v-html="c.name"></a>
                    </li>

                </ul>
            </div>

        </div>


        <div class="col-lg">
<p> &nbsp</p>
                <input value="" class="form-control"  size="20" type="number"
                       id="invoice_no" v-model="invoice_no"
                       name="invoice_no" placeholder="Search By Invoice No.">
        </div>
        <div class="col-lg">
            <div>
                <p> &nbsp</p>
                <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

            </div>
        </div>
        <div class="col-lg">
            <div>
                <p> &nbsp</p>
                <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>
        </div>

        <div class="col-lg">
            <p> &nbsp</p>
            <div class="form-group" v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">

                <input  v-model="unitsearch" name="unitsearch" id="unitsearch" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Unit...">

                <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="unitsearchid"     name="unitsearchid" placeholder="Search by Unit...">

                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="searchedunits.length>0 && unitsearch!=''" >

                    <li  :class="'fbb fba'+key"  @click="unitdatavalue(c.id)"  v-on:keyup.enter="unitdatavalue(c.id)" v-for="(c,key) in searchedunits">
                        <a href="javascript:void(0)">{{c.code}} - {{c.name}} (<template v-if="ccs.filter(function(a){return a.code==c.desc})[0]">{{ccs.filter(function(a){return a.code==c.desc})[0].name}}</template>)</a>
                    </li>

                </ul>
            </div>

        </div>


        <div class="col-lg">
            <div>
                <p> &nbsp</p>
                <select v-model="status"  class="form-control">
                    <option v-for="s in ['All','Advance','Paid','Unpaid']">{{s}}</option>
                </select>
            </div>
        </div>

        <div class="col-lg">
            <div>
                <p> &nbsp</p>
                <select v-model="approve"  class="form-control">
                    <option v-for="s in ['Unapproved','Approved','Both']">{{s}}</option>
                </select>
            </div>
        </div>


    </div>

    <div class="scrollclasstable1">
        <div>
            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">INVOICE #</th>
                    <th class="wd-10p">INVOICE DATE</th>
                    <th class="wd-15p">NAME</th>
                    <th class="wd-15p">TYPE</th>
                    <th class="wd-15p">UNIT</th>
           <!--         <th class="wd-5p">ACCOUNT</th>-->
   <!--                 <th class="wd-10p">STORE LOCATION</th>-->
                    <th class="wd-5p">GROSS</th>
                    <th class="wd-5p">DISC</th>
                    <th class="wd-5p">TAX</th>
                    <th class="wd-5p">GRAND TOTAL</th>
                   <th class="wd-5p">AMOUNT PAID</th>
                    <th class="wd-5p">BALANCE</th>
                    <th class="wd-10p">DETAILS</th>
                    <th class="wd-10p">STATUS</th>
                    <th class="wd-10p">APPROVE</th>
                    <th class="wd-10p">USER</th>
                    <th class="wd-5p hidden-print">DOC</th>
                    <th class="wd-5p hidden-print">INVOICE</th>
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
                    <td>{{tr.id}}</td>
                    <td>{{moment(tr.invoice_date).format('DD/MM/YYYY')}}</td>

                <!--    <td>{{tr.account}}</td>-->
                    <template v-if="tr.type==0">
                        <td>{{tr.tname}} {{tr.fname}} {{tr.mname}} {{tr.lname}}</td>
                    </template>
                    <template v-else-if="tr.type==1">
                        <td>{{tr.customer}}</td>
                    </template>
                    <template v-else-if="tr.type==3">
                        <td>{{tr.employee}}</td>
                    </template>  <template v-else-if="tr.type==2">
                        <td>{{tr.person_name}}</td>
                    </template>
                    <template v-else>
                        <td> </td>
                    </template>

                    <template v-if="tr.type==1">
                        <template v-if="tr.cgt">
                            <td>{{tr.guesttype}} ({{tr.customer_id}})</td>
                        </template>
                        <template v-else>
                            <td>Guest ({{tr.customer_id}})</td>
                        </template>
                       <!-- <template v-if="tr.cgt==1">
                            <td>Applied Member ({{tr.customer_id}})</td>
                        </template>
                        <template v-else-if="tr.cgt==2">
                            <td>Affiliated Member ({{tr.customer_id}})</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>-->
                    </template>
                    <template v-else-if="tr.type==3">
                        <td>Employee ({{tr.customer_id}})</td>
                    </template>    <template v-else-if="tr.type==2">
                        <td>Ledger ({{tr.person_id}})</td>
                    </template>
                    <template v-else-if="tr.type==0">
                        <td>Member ({{tr.mem_no}}) - {{tr.activity}}</td>
                    </template>
                    <template v-else>
                        <td></td>
                    </template>

                    <td>{{tr.unit}} ({{tr.company}})</td>

<!--                    <td>{{parseInt(tr.sgross)}}</td>-->

                    <td>{{parseInt(Math.round(tr.grand_total)) + parseInt(tr.discount) - parseInt(tr.tax)}}</td>
                    <td>{{parseInt(tr.discount)}}</td>
                    <td>{{parseInt(tr.tax)}}</td>
                    <td>{{Math.round(tr.grand_total)}}</td>
                  <td>{{tr.paid_amount?parseInt(tr.paid_amount):0}}</td>
                    <td>{{ (tr.grand_total?Math.round(tr.grand_total):0)-(tr.paid_amount?parseInt(tr.paid_amount):0)}}</td>

                    <td style="color:#0053a7;">{{tr.reciept_id}}</td>
                    <template v-if="(parseInt(tr.grand_total-tr.paid_amount))<0">
                            <td><button class=" btn btn-outline-warning active">Advance</button></td>
                    </template>
                    <template v-else-if="(parseInt(tr.grand_total-tr.paid_amount))>0">
                        <template v-if="tr.type==2">
                            <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'ledgerid=' + tr.customer_id">Unpaid</a></button></td>
                        </template> <template v-else-if="tr.type==1">
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
                        <td><button class=" btn btn-outline-success active">Paid</button></td>
                    </template>

                    <template v-if="tr.approved==0">
                        <td> <a style="color:white;" :href="'/store-management/store-sales/approve/' + tr.id"> <button type="button" class="btn btn-sm btn-outline-danger active">Unapproved</button></a></td>
                    </template>
                    <template v-else-if="tr.approved==1">
                        <td> <a style="color:white;" :href="'/store-management/store-sales/unapprove/' + tr.id"> <button type="button" class="btn btn-sm btn-outline-success active">Approved</button></a></td>
                    </template>
                    <template v-else>
                        <td></td>
                    </template>

                    <td>{{tr.cashiername}}</td>
                    <template v-if="tr.image">
                        <td class="hidden-print"><button class="buttoncolor" title="View Documents"><a style="color:#000000;" target="_blank" :href="'/store-management/store-sales/documents/' + tr.id"><i class="fas fa-eye"></i></a></button></td>
                    </template>
                    <template v-else>
                        <td></td>
                    </template>

                    <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/store-management/store-sales/store-sales-invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>

                    <template v-if="tr.approved==0">
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/store-management/store-sales/store-sales-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                    </template>
                    <template v-else>
                        <td></td>
                    </template>

                    <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.remarks);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                </tr>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6" class="text-right"><strong>TOTAL : </strong></td>
<!--                    <td><strong>{{(totals.tgross)}}</strong></td>-->
                    <td><strong>{{parseInt(totals.grand_total) + parseInt(totals.tdisc)  - parseInt(totals.ttax)}}</strong></td>
                    <td><strong>{{(totals.tdisc)}}</strong></td>
                    <td><strong>{{(totals.ttax)}}</strong></td>
                    <td><strong>{{(totals.grand_total)}}</strong></td>
                    <td><strong>{{(totals.paid_amount)}}</strong></td>
                    <td><strong>{{totals.grand_total-totals.paid_amount}}</strong></td>
                    <td colspan="8"></td>
                </tr>
               <!-- <tr>
                    <td colspan="6" class="text-right"></td>
                    <td><strong>{{toWords(totals.tgross)}}</strong></td>
                    <td><strong>{{toWords(totals.tdisc)}}</strong></td>
                    <td><strong>{{toWords(totals.ttax)}}</strong></td>
                    <td><strong>{{toWords(totals.grand_total)}}</strong></td>
                    <td><strong>{{toWords(totals.paid_amount)}}</strong></td>
                    <td><strong>{{toWords(totals.grand_total-totals.paid_amount)}}</strong></td>
                    <td colspan="5"></td>
                </tr>-->
                </tfoot>
            </table>

            <div class="hidden-print">
                    <ul class=" pagination">
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
        name: "storesalesdt",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                approve:'Unapproved',
                disabledDates: {
                    from: new Date(),
                },
                showApproveModal:false,
                status:'All',
                page:1,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                sales:[],
                salesR:[],
                salesM: [],
                invoice_no:'',
                start_date:'',
                end_date:'',
                customers:[],
                customer:'',
                searchId:null,
                mog:6,
                fkey:-1,
                ffkey:0,
                deletethisid:'',
                DeleteTheInvoice:false,
                remarks:'',

                ccs:[],
                searchedunits:[],
                searchedaccounts:[],
                unitalreadySearched:false,
                accountalreadySearched:false,
                unitsearch:'',
                accsearch:'',
                unitsearchid:'',
                gts:[],
            }
        },
        computed: {
            totals() {
                let  x=this.filterData(this.sales);

                let tgross=0;
                let tdisc=0;
                let ttax=0;
                let grand_total=0;
                let paid_amount=0;
                //console.log(1);
                 x.forEach(function (item) {

                        tgross=tgross + parseInt(item.gross?item.gross:0);
                     tdisc=tdisc + parseInt(item.discount?item.discount:0);
                     ttax=ttax + parseInt(item.tax?item.tax:0);
                        grand_total=grand_total + parseInt(item.grand_total?item.grand_total:0);
                        paid_amount=paid_amount + parseInt(item.paid_amount?item.paid_amount:0);
                        // grand_total:grand_total + parseInt(item.grand_total?item.grand_total:0),

                })
                return {
                    tgross:tgross,
                    tdisc:tdisc,
                    ttax:ttax,
                    grand_total:grand_total,
                    paid_amount:paid_amount,
                }
            }
        },
        methods:{
            unitsdata(){
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
                        this.unitsearch=data.name;
                        this.unitsearchid=data.code;

                    }
                });
            },
            accountdata(){
                this.$http.post('/search/coa/coaaccountdatalike',{searchid:this.accsearch}).then(result=>{
                    let data =result.data;
                    console.log(result.data);
                    data.filter((a)=>{a.accsearch=a.name})

                    if(data){

                        this.searchedaccounts=data;

                    }
                });
            },
            accountdatavalue(val,m){
                this.searchedaccounts=[];
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/coa/coaaccountdata?MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.accountalreadySearched=true;
                        this.accsearch=data.name;

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
            udf3(event){

                if(event==0){
                    if(this.fkey!=this.searchedunits.length){

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
                let url='/store-management/store-sales/delete/'+this.deletethisid;
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
                if(this.invoice_no){
                    x=x.filter((a)=>{return a.id==this.invoice_no});
                }

                if(this.start_date){
                    x=x.filter((a)=>{return moment(a.invoice_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

                }
                if(this.end_date){
                    x=x.filter((a)=>{return moment(a.invoice_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
                }

                if(this.status){
                    if(this.status=='Paid'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))==0});

                    }   else if(this.status=='Unpaid'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))>0});

                    }   else if(this.status=='Advance'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))<0});

                    }
                    else if(this.status=='Approved'){
                        x=x.filter((a)=>{return a.approved==1});

                    }
                    else if(this.status=='Unapproved'){
                        x=x.filter((a)=>{return a.approved==0});

                    }
                    else{
                        x=x;
                    }
                }

                if(this.approve){

                    if(this.approve=='Approved'){
                        x=x.filter((a)=>{return a.approved==1});

                    }
                    else if(this.approve=='Unapproved'){
                        x=x.filter((a)=>{return a.approved==0});

                    }
                    else{
                        x=x;
                    }
                }
                if (this.unitsearch){
                    x=x.filter((a)=>{return a.unitcode==this.unitsearchid});
                }
                if (this.accsearch){
                    x=x.filter((a)=>{return a.account==this.accsearch});
                }
              if (this.searchId){

                        x=x.filter((a)=>{return a.customer_id==this.searchId});

                }
                if(this.mog!=6) {

                    x=x.filter((a)=>{
                        if(this.mog==1)
                            return a.type==1
                        else if(this.mog==2)
                            return a.type==1
                        else if(this.mog==0)
                            return a.type==0
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
              return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                this.$http.get('/store-management/store-sales/sales_init_vue').then(result=>{
                    let data=result.data;
                    this.ccs=data.ccs;
                    this.sales=data.sales;
                    this.gts=data.gts;
                    this.salesR=data.sales;
                    this.leng=data.sales.length;
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
                let v = this.mog;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=0&MOC='+v+r,{customerid:val}).then(result=>{
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

                        else if (v == 3) {
                            this.employee_id = data.id;
                            this.customer = data.name;
                            this.guest_contact = data.mob_a;

                            this.invoices=data.invoices;

                        } else {
                            this.customer_id = data.id;
                            this.customer = data.customer_name;
                            this.guest_contact = data.customer_contact;

                            this.invoices=data.invoices;

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

