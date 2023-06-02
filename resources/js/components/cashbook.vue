<template>
<div>
    <vue-snotify></vue-snotify>

        <div class="row hidden-print">

            <div class="col-lg">
                <div>
                    <datepicker placeholder="From (dd/mm/yyyy)" :disabledDates="disabledDates" v-model="start_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker placeholder="To (dd/mm/yyyy)" :disabledDates="disabledDates" v-model="end_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>
            <div class="col-xs">
                <div>
                    <button type="button" v-on:click="init" class="btn btn-success">Search</button>
                </div>
            </div>

        </div>

<br>
<template v-if="showTable">
<!--    <div class="hidden-print">
    <button type="button" @click="showTable=false; showFilters=true; " class="btn btn-warning">CHANGE SEARCH CRITERIA !</button>
    </div>-->

<!--    <div v-if="this.exported" class="hidden-print">
    <export-excel
        class   = "btn btn-primary"
        :data   = "json_data"
        worksheet = "My Worksheet"
        name    = "DishBreakdown.xls">
    </export-excel>
</div>-->


    <div style="text-align: center; color: black; letter-spacing: 0.2em !important;" >
        <h5 style="background-color: yellow;">AFOHS <br>DAILY CASH BOOK </h5>
    </div>
    <div style="text-align: center; color: black;" class="print-only">
        <p><strong>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}</strong></p>
    </div>
    <div style="text-align: center; color: black; " >
    <div class="row">
        <div class="col-sm-4">
            <p style="background-color: #08ed08; font-size: 16px;">Total Cash Inflows: {{icashgross | numFormat}}</p>
        </div>
        <div class="col-sm-4">
            <p style="background-color: #08ed08; font-size: 16px;">Total Cash Outflows: {{tcashgross | numFormat}}</p>
        </div>
        <div class="col-sm-4">
            <p style="background-color: #08ed08; font-size: 16px;">Total Cash Balance: {{ (parseInt(icashgross)-parseInt(tcashgross)) | numFormat}}</p>
        </div>
    </div>
    </div>


    <div class="blackcolor headingsetting ">
    <div class="scrollclasstable1">

        <div class="row">
<div class="col-sm-6">

    <table class="myFormat table-hover " style="width: 100%;">
        <tbody>
        <tr style=" text-align:center;" class="head" >
            <td COLSPAN="4"><STRONG>INCOME (INFLOWS)</STRONG></td>
        </tr>
        <tr>
            <td COLSPAN="4">&nbsp</td>
        </tr>
        <tr style="border-bottom: 2px solid black; background-color: #08ed08;  " class="head" >
            <td><STRONG>DETAILS</STRONG></td>
            <td><STRONG>CASH</STRONG></td>
            <td><STRONG>CREDIT CARD</STRONG></td>
            <td><STRONG>CHEQUE / ONLINE (BANK)</STRONG></td>
        </tr>

        <template v-for="(s,key) in  (
                     (()=>{
                      let  x=inflows;

                     return x;
                    })()
                    )">

            <tr v-if="(key==0) || inflows[key-1].cat!=s.cat">
                <td colspan="4" class="sub"><b style="text-transform: uppercase;">{{s.cat}}</b></td>
            </tr>


            <tr v-if="s.cashgross!=0 || s.creditgross!=0 || s.othergross!=0">
                <td style="border: 1px solid black;">{{s.detailname}}</td>
                <td style="border: 1px solid black;">{{s.cashgross.toLocaleString()}}</td>
                <td style="border: 1px solid black;">{{s.creditgross.toLocaleString()}}</td>
                <td style="border: 1px solid black;">{{s.othergross.toLocaleString()}}</td>
            </tr>

        </template>

        <tr style="border: 3px solid black;">
            <td><STRONG>TOTAL INCOME:</STRONG></td>
            <td><STRONG>{{icashgross.toLocaleString()}}</STRONG></td>
            <td><STRONG>{{icreditgross.toLocaleString()}}</STRONG></td>
            <td><STRONG>{{iothergross.toLocaleString()}}</STRONG></td>
        </tr>

        </tbody>

    </table>
</div>
            <div class="col-sm-6">

                <table class="myFormat table-hover " style="width: 100%;">
                    <tbody>
                    <tr style="text-align:center;" class="head" >
                        <td COLSPAN="4"><STRONG>EXPENSES (OUTFLOWS)</STRONG></td>
                    </tr>
                    <tr>
                        <td COLSPAN="4">&nbsp</td>
                    </tr>



                    <tr style="border-bottom: 2px solid black; background-color: #08ed08;  " class="head" >
                        <td><STRONG>DETAILS</STRONG></td>
                        <td><STRONG>CASH</STRONG></td>
                        <td><STRONG>CREDIT CARD</STRONG></td>
                        <td><STRONG>CHEQUE / ONLINE (BANK)</STRONG></td>
                    </tr>

                    <template v-for="(s,key) in  (
                     (()=>{
                      let  x=sales;

                     return x;
                    })()
                    )">

                        <tr v-if="(key==0) || sales[key-1].cat!=s.cat">
                            <td colspan="4" class="sub"><b style="text-transform: uppercase;">{{s.cat}}</b></td>
                        </tr>


                        <tr v-if="s.cashgross!=0 || s.creditgross!=0 || s.othergross!=0">
                            <td style="border: 1px solid black;">{{s.detailname}}</td>
                            <td style="border: 1px solid black;">{{s.cashgross.toLocaleString()}}</td>
                            <td style="border: 1px solid black;">{{s.creditgross.toLocaleString()}}</td>
                            <td style="border: 1px solid black;">{{s.othergross.toLocaleString()}}</td>
                        </tr>

                    </template>

                    <tr style="border: 3px solid black;">
                        <td><STRONG>TOTAL EXPENSES:</STRONG></td>
                        <td><STRONG>{{tcashgross.toLocaleString()}}</STRONG></td>
                        <td><STRONG>{{tcreditgross.toLocaleString()}}</STRONG></td>
                        <td><STRONG>{{tothergross.toLocaleString()}}</STRONG></td>
                    </tr>

                    </tbody>

                </table>
            </div>
           <div class="hidden-print">
                    <ul class="pagination">
                        <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                        <li>
                            <select  v-model="pagelength" class="">
                                <option value="30" >30</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="150" >150</option>
                                <option :value="parseInt(sales.length)+parseInt(inflows.length)" >ALL</option>
                            </select>
                        </li>  </ul>
            </div>
            <br>
        </div>
<!--        ROW-->
    </div>
    </div>

</template>

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
.print-only{
    display: none;
}@media print {
    .no-print {
        display: none;
    }

    .print-only{
        display: block;
    }
}

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
.cat{
    background: #ffff;
    font-weight: bold;
    padding: 9px 0 9px;
}
.sub{
  /*  border-top: 1px solid #000!important;*/
    text-align: center;
    font-weight: bold;
    padding: 0 0 20px;
    background-color: yellow;
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
        name: "cashbook",
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
                itemalreadySearched:false,
                searcheditemsdefs:[],
                status:'All',
                page:1,
                keysss:0,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',

                sales:[],
                salesR:[],
                salesM: [],

                inflows:[],
                inflowsR:[],
                inflowsM: [],
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
                waiter:[],
                cate:[],
                sub_cat:[],
                item:[],
                categories:[],
                subcategories:[],
                users:[],
                cashier:[],
                items:[],
                specific:0,
                getRe:true,
                showFilters:false,
                showTable:true,

                json_data: [],
                fkey:-1,
                ffkey:0,
                exported:'',
                icashgross:0,
                icreditgross:0,
                iothergross:0,

                tcashgross:0,
                tcreditgross:0,
                tothergross:0,
            }
        },
        computed: {

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

            itemsdata(){
                this.$http.post('/search/itemsdatalike',{searchid:this.booking_no}).then(result=>{
                    let data =result.data;

                    data.filter((a)=>{a.booking_no=a.item_code + ' ' + '-'+ ' ' + a.item_details})

                    if(data){

                        this.searcheditemsdefs=data;

                    }
                });
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
                        this.booking_no=data.item_code;

                    }
                });
            },
            amIOnline(e) {
                this.onLine = e;
            },
            init:function () {

                let x='';
              if(this.getRe){
                    x+='&r='+1;
                }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
                this.$http.get('/finance-and-management/reports/cash-book/cash_init_vue?start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&end_date='+(this.end_date?moment(this.end_date).format('YYYY-MM-DD'):'')).then(result=>{
                    let data=result.data;
                    if(!data.sales){
                        data.sales=[];
                    }
                    if(!data.inflows){
                        data.inflows=[];
                    }
                    if(this.getRe){
                        let aa=0;
                        let bb=0;
                        let cc=0;

                        let x=data.sales;

                        x.forEach(function (s,key) {

                            aa=aa+parseInt(s.cashgross);
                            bb=bb+parseInt(s.creditgross);
                            cc=cc+parseInt(s.othergross);


                        })
                        this.tcashgross=aa
                        this.tcreditgross=bb
                        this.tothergross=cc



                        let a=0;
                        let b=0;
                        let c=0;

                        let k=data.inflows;

                        k.forEach(function (d,key) {

                            a=a+parseInt(d.cashgross);
                            b=b+parseInt(d.creditgross);
                            c=c+parseInt(d.othergross);


                        })
                        this.icashgross=a
                        this.icreditgross=b
                        this.iothergross=c
                    }

                    this.inflows=data.inflows;
                    this.inflowsR=data.inflows;


                    this.sales=data.sales;
                    this.salesR=data.sales;
                    this.leng=parseInt(data.sales.length)+parseInt(data.inflows.length);
                    this.getRe=true;

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
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            let self=this;
                            this.invoices.forEach(function(i){
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

                            })
                        }
                        else if (v == 1) {
                            this.customer_id = data.id;
                            this.customer = data.customer_name;
                            this.guest_contact = data.customer_contact;
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            let self=this;
                            this.invoices.forEach(function(i){
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

                            })
                        }
                        else if (v == 3) {
                            this.employee_id = data.id;
                            this.customer = data.name;
                            this.guest_contact = data.mob_a;
                            this.ledger_amount=data.balance;
                            this.invoices=data.invoices;
                            let self=this;
                            this.invoices.forEach(function(i){
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

                            })
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
            booking_no:function(){
                if(this.booking_no.length==0){
                    this.itemalreadySearched=false;
                }
                if(this.booking_no.length>2 && !this.itemalreadySearched){
                    this.itemsdata();
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
              //  this.init(this.id);

                // this.init(id.id);

            }
            else{
                //this.init();

            }
            this.start_date=new Date();
            this.end_date=new Date();
            this.init();
        }
    }
</script>

