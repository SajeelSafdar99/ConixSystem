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


        <div class="row  hidden-print">

            <div class="col-lg-4">
                <div class="row">

                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                            <label class="rdiobox">
                                <input  type="radio"  name="mog" v-model="mog" value="2"><span class="pabs">All</span>
                            </label>
                        </div> <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
                        </label>
                    </div>

                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="6"><span class="pabs">Corporate Member</span>
                        </label>
                    </div>

                        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                            <label class="rdiobox">
                                <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
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
                <p style="color: black;">Invoice No.</p>
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="invoice_no" v-model="invoice_no"
                       name="invoice_no" placeholder="Search Id...">
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Begin Date:</p>
                    <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">End Date:</p>
                   <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Details:</p>
                    <select v-model="details"  class="form-control">
                        <option value="0">All</option>
                        <optgroup label="Main Charges">
                            <option v-for="main in mains" :value="main.id">{{ main.name }}</option>
                        </optgroup>
                        <optgroup label="Charges Types">
                            <option v-for="charge in charges" :value="charge.id">{{ charge.name }}</option>
                        </optgroup>
                        <optgroup label="Subscription Types">
                            <option v-for="subs in subscriptions" :value="subs.id">{{ subs.name }}</option>
                        </optgroup>
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




        <div class="scrollclasstable1">

            <div>


                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">INVOICE #</th>
                        <th class="wd-10p">INVOICE DATE</th>
                        <th class="wd-15p">NAME</th>
                        <th class="wd-10p">TYPE</th>
                        <th class="wd-20p">FAMILY MEMBER</th>
                        <th class="wd-5p">ID</th>
                        <th class="wd-20p">DETAILS</th>

                        <th class="wd-10p">DURATION</th>

                      <!--  <th class="wd-10p">FAMILY MEMBER</th>
                        <th class="wd-10p">INVOICE DETAILS</th>
                        <th class="wd-10p">DURATION</th>-->
                        <th class="wd-10p"> CHARGES</th>

                        <th class="wd-10p">GRAND TOTAL</th>
                        <th class="wd-10p">AMOUNT PAID</th>
                        <th class="wd-10p">BALANCE</th>
                        <th class="wd-10p">RECEIPT</th>
                        <th class="wd-10p">STATUS</th>
                        <th class="wd-10p">USER</th>
                        <th class="wd-5p  hidden-print">RESTORE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(invoices);

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
                        <td>{{moment(tr.invoice_date).format('DD/MM/YYYY')}}</td>

                        <template v-if="tr.invoice_type==0">
                            <td>{{tr.tname}} {{tr.fname}} {{tr.mname}} {{tr.lname}}</td>
                        </template>
                        <template v-else-if="tr.invoice_type==6">
                            <td>{{tr.ctname}} {{tr.cfname}} {{tr.cmname}} {{tr.clname}}</td>
                        </template>
                        <template v-else-if="tr.invoice_type==1">
                            <td>{{tr.name}}</td>
                        </template>
                        <template v-else>
                            <td>{{tr.name}}</td>
                        </template>

                        <template v-if="tr.invoice_type==1">
                            <td>Guest ({{tr.customer_id}})</td>
                        </template>
                        <template v-else-if="tr.invoice_type==0">
                            <td>Member ({{tr.mem_no}})</td>
                        </template>
                        <template v-else-if="tr.invoice_type==6">
                            <td>Corporate Member ({{tr.co_mem_no}})</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <template v-if="tr.invoice_type==0">
                            <td v-html="tr.familymember"></td>
                        </template>
                        <template v-else-if="tr.invoice_type==6">
                            <td v-html="tr.cop_familymember"></td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>


                        <td v-html="tr.multiid"></td>
                        <td v-html="tr.ttname"></td>

                      <!--  <td>{{tr.tfamily}} {{tr.ffamily}} {{tr.mfamily}} {{tr.lfamily}}</td>
                        <td>{{tr.type_name}}</td>
                        <td>{{moment(tr.start_date).format('DD/MM/YYYY')}} <br> {{moment(tr.end_date).format('DD/MM/YYYY')}}</td>
-->
                        <td v-html="tr.duration"></td>
                        <td>
                            <template v-for="b in tr.grandtotal.split('<br>')">
                                {{b.split('-')[0]}}<br>
                            </template>
                        </td>


                        <td>{{parseInt(tr.sumgrandtotal?tr.sumgrandtotal:0) | numFormat }}</td>

                        <td>{{parseInt(tr.paid_amount?tr.paid_amount:0) | numFormat }}</td>
                        <td>{{(parseInt(tr.sumgrandtotal)-parseInt(tr.paid_amount)) | numFormat }}</td>


                        <td style="color:#0053a7;">{{tr.reciept_id}}</td>
                        <template v-if="(parseInt(tr.sumgrandtotal)-parseInt(tr.paid_amount))<0">
                                <td><button class=" btn btn-outline-warning active">Advance</button></td>
                        </template>
                        <template v-else-if="(parseInt(tr.sumgrandtotal)-parseInt(tr.paid_amount))>0">
                            <template v-if="tr.invoice_type==1">
                                <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'guestid=' + tr.customer_id">Unpaid</a></button></td>
                            </template>
                            <template v-else-if="tr.invoice_type==0">
                                <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'memid=' + tr.member_id">Unpaid</a></button></td>
                            </template>
                            <template v-else-if="tr.invoice_type==6">
                                <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'corporateid=' + tr.corporate_id">Unpaid</a></button></td>
                            </template>
                            <template v-else><td></td></template>
                        </template>
                        <template v-else>
                            <td><button class=" btn btn-outline-success active">Paid</button></td>
                        </template>
                        <td>{{tr.cashiername}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="Restore"><a style="color:#000000;" :href="'/finance-and-management/finance-cancelled-invoices/restore/' + tr.invoice_no"><i class="fas fa-trash-restore" aria-hidden="true"></i></a></button></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="9" class="text-right"><strong>TOTAL : </strong></td>
                        <td><strong>{{(totals.total) | numFormat }}</strong></td>

                        <td><strong>{{(totals.sumgrandtotal) | numFormat }}</strong></td>
                        <td><strong>{{(totals.paid_amount) | numFormat }}</strong></td>
                        <td><strong>{{(totals.sumgrandtotal-totals.paid_amount) | numFormat }}</strong></td>
                        <td colspan="4"></td>
                    </tr>
                  <!--  <tr>
                        <td colspan="9" class="text-right"></td>
                        <td><strong>{{toWords(totals.total)}}</strong></td>

                        <td><strong>{{toWords(totals.sumgrandtotal)}}</strong></td>
                        <td><strong>{{toWords(totals.paid_amount)}}</strong></td>
                        <td><strong>{{toWords(totals.sumgrandtotal-totals.paid_amount)}}</strong></td>
                        <td colspan="5"></td>
                    </tr>-->
                    </tfoot>
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
                            <option :value="invoices.length" >ALL</option>
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
</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "cancelledinvoicesdt",
    components: {
        Datepicker
    },
    props: ['csrf'],
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            status:'All',
            page:1,            overdue:0,

            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            invoices:[],
            invoicesR:[],
            invoicesM: [],
            invoice_no:'',
            start_date:'',
            end_date:'',   start_date1:'',
            end_date1:'',
            customers:[],
            customer:'',
            mog:2,
            mains:[],
            charges:[],
            subscriptions:[],
            details:'0',
            invoicesYears:[],
            invoice_Date:'',
            searchId:null,
            ids:'',
            fkey:-1,
            ffkey:0,

        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.invoices);

            let total=0;
            let discount_amount=0;
            let extra_charges=0;
            let tax_charges=0;
            let sumgrandtotal=0;
            let paid_amount=0;
            //console.log(1);
            x.forEach(function (item) {
                total=total + parseInt(item.total?item.total:0);
                discount_amount=discount_amount + parseInt(item.discount_amount?item.discount_amount:0);
                extra_charges=extra_charges + parseInt(item.extra_charges?item.extra_charges:0);
                tax_charges=tax_charges + parseInt(item.tax_charges?item.tax_charges:0);
                sumgrandtotal=sumgrandtotal + parseInt(item.sumgrandtotal?item.sumgrandtotal:0);
                paid_amount=paid_amount + parseInt(item.paid_amount?item.paid_amount:0);

            })
            return {
                total:total,
                discount_amount:discount_amount,
                extra_charges:extra_charges,
                tax_charges:tax_charges,
                sumgrandtotal:sumgrandtotal,
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
        updateInvoices(){
            console.log(this.overdue);
            this.$http.post('/finance-and-management/finance-invoices-update',{overdue:this.overdue,ids:this.pluck(this.invoicesM,'multiid')}).then(result=>{
                window.location.reload();
            })
        },
        filterData(invoices){
            let   x=invoices;
            if(this.invoice_no){
                x=x.filter((a)=>{return a.invoice_no==this.invoice_no});
            }


            if(this.details){
                if(this.details!=0){
                    x=x.filter((a)=>{return a.charges_type==this.details});
                }
            else{
                    x=x;
                }
            }

            if(this.start_date){
                x=x.filter((a)=>{return moment(a.invoice_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.end_date){
                    x=x.filter((a)=>{return moment(a.invoice_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }  if(this.status){

                if(this.status=='Paid'){
                    x=x.filter((a)=>{return (parseInt(a.sumgrandtotal)-parseInt(a.paid_amount))==0});

                }   else if(this.status=='Unpaid'){
                    x=x.filter((a)=>{return (parseInt(a.sumgrandtotal)-parseInt(a.paid_amount))>0});

                }   else if(this.status=='Advance'){
                    x=x.filter((a)=>{return (parseInt(a.sumgrandtotal)-parseInt(a.paid_amount))<0});

                }
                else if(this.status=='Cancelled'){
                    x=x.filter((a)=>{return a.statuss?a.statuss.indexOf(this.status)!=-1:false});
                }
                else{
                    x=x;
                }
            }
            if (this.searchId){
                if(this.mog==0){
                    x=x.filter((a)=>{return a.member_id==this.searchId});

                }
                else if(this.mog==6){
                    x=x.filter((a)=>{return a.corporate_id==this.searchId});

                }
                else{
                    x=x.filter((a)=>{return a.customer_id==this.searchId});

                }
            }
            if(this.mog!=2) {

                x=x.filter((a)=>{
                    if(this.mog==1)
                        return a.member_id==null && a.corporate_id==null;
                    else if(this.mog==0) return a.customer_id==null && a.corporate_id==null;
                    else if(this.mog==6) return a.customer_id==null && a.member_id==null;
                    else return true});

            }
            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(invoices){
            // console.log(123);
            this.invoicesM=invoices;
            this.ids=this.pluck(invoices,'invoice_no').join()
            return  invoices.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {
let d=''
            if(this.start_date1){
              d=d+'&start_date='+moment(this.start_date1).format('YYYY-MM-DD');
            }if(this.end_date1){
                d=d+'&end_date='+moment(this.end_date1).format('YYYY-MM-DD');

            }
            this.$http.get('/finance-and-management/finance-cancelled-invoices-ini?1=1'+d).then(result=>{
                let data=result.data;
                data.invoices.forEach((A)=>{
                    let sm=0
                    A.grandtotal.split('<br>').forEach((c)=>{
                        sm=sm+parseInt(c.split('-')[0]);
                    })
                    A.sumgrandtotal=sm;
                })
                this.invoicesYears=data.invoicesYears;
                this.subscriptions=data.subscriptions;
                this.charges=data.charges;
                this.mains=data.mains;
                this.invoices=data.invoices;
                this.invoicesR=data.invoices;
                this.leng=data.invoices.length;
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
            let v = this.mog;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;
                if(data){
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
                        this.ledger_amount=data.balance;

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

                    }
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;
                        this.ledger_amount=data.balance;

                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;
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
    },
    watch:{
        invoicesM:function(){
            console.log(1);
        },
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.searchId=null
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

