<template>
    <div>
        <vue-snotify></vue-snotify>


        <div class="row hidden-print">





            <div class="col-lg">
                <div>

                    <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

                </div>
            </div>
            <div class="col-lg">
                <div>

                    <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>

                </div>
            </div>
            <div class="col-lg">

                <multiselect track-by="name" label="name" placeholder="Choose Restaurants" v-model="restaurant" :multiple="true" :options="(()=>{let x=[];
            restaurant_locations.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>


            </div>

            <div class="col-xs">
                <div>

                    <button type="button" class="btn   btn-success" v-on:click="init">Search</button>

                </div>
            </div>

        </div>


        <br>
        <div style="background-color: black; padding: 5px;">
            <div class="row" style="width: 100%; height: 560px; overflow-y: scroll; overflow: auto;">
               <template  v-for="sale in sales">

                <div class="col-md-3">
                    <a onclick="return confirm('Are you sure ?')" :href="'/food-and-beverage/sales/sales-aeu/confirmorder/' + sale.id">
                        <div class="card border-success mb-3  text-success" style="max-width: 30rem; height: 34rem; overflow-y: scroll; overflow: auto; font-size: 19px; background-color: black; cursor: pointer;">
                            <div class="card-header text-center"><strong>INVOICE #: {{sale.invoice_no}} </strong></div>

                            <div class="card-header"><strong class="float-left">{{moment(sale.date).format('DD/MM/YYYY')}} </strong><strong class="float-right">{{sale.time}} </strong></div>
                            <div class="card-body text-success">
                                <h5 class="card-title text-success"><strong>TABLE #: {{sale.tabledef}}</strong></h5>

                                <template  v-for="(sub,key) in subs.filter((m)=>{
                    return sale.id==m.sales_id;
                })">

                                <div  class="card-text"><strong>
<template v-if="(key==0) ||  subs.filter((m)=>{
                    return sale.id==m.sales_id;
                })[key-1].kot_no!=sub.kot_no">
                                    ########## {{sub.kot_no}} ##########
                                    <br>
</template>

                                    {{sub.qty}}   &nbsp&nbsp&nbsp&nbsp ✕ &nbsp&nbsp&nbsp&nbsp  {{sub.item_code}} &nbsp&nbsp&nbsp&nbsp   {{sub.item_details}}
                                </strong></div>

                                </template>


                            </div>
                        </div>
                    </a>
                </div>

               </template>
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
    name: "runningorders",
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
            ent:'Include ENT & CTS',
            cts:'Include CTS',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            sales:[],
            subs:[],
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
            rcashier:[],
            specific:0,
            json_data: [],
            fkey:-1,
            ffkey:0,
            exported:'',
            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
            ent_details:[],
            ent_detail:[],
            acftype:0,
            accTypes:[],
            acc_permission:'',
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
           /* if(this.booking_no){
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

            /!*if(this.tabledef.length>0){
                x=x.filter((a)=>{return this.tabledef.indexOf(parseInt(a.table_definition))!=-1});

            }*!/

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

            if(this.rcashier.length>0){
                x=x.filter((a)=>{return this.rcashier.filter((m)=>{
                    return a.ruserid==m.id;
                }).length>0});

            }

            if(this.start_date){
                x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

            }
            if(this.end_date){
                x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            */
            if(this.status){

                if(this.status=='Paid'){
                    x=x.filter((a)=>{return (parseInt(Math.round(a.grand_total)-a.paid_amount))==0});

                }   else if(this.status=='Unpaid'){
                    x=x.filter((a)=>{return (parseInt(Math.round(a.grand_total)-a.paid_amount))>0});

                }   else if(this.status=='Advance'){
                    x=x.filter((a)=>{return (parseInt(Math.round(a.grand_total)-a.paid_amount))<0});

                }
               /* else{
                    x=x;
                }*/
            }
           /* if(this.ent){
                if(this.ent=='Include ENT & CTS'){
                    x=x;
                }   else if(this.ent=='Exclude ENT & CTS'){
                    x=x.filter((a)=>{return a.ent==0});
                }   else if(this.ent=='Only ENT'){
                    x=x.filter((a)=>{return a.ent==1});
                }
                else if(this.ent=='Only CTS'){
                    x=x.filter((a)=>{return a.ent==2});
                }
                else{
                    x=x;
                }
            }
            if(this.cts){
                if(this.cts=='Include CTS'){
                    x=x;
                }   else if(this.cts=='Exclude CTS'){
                    x=x.filter((a)=>{return a.ent==0  || a.ent==1});
                }   else if(this.cts=='Only CTS'){
                    x=x.filter((a)=>{return a.ent==2});
                }
                else{
                    x=x;
                }
            }
            if(this.ent_detail.length>0){
                x=x.filter((a)=>{return this.ent_detail.filter((m)=>{
                    return a.ent_detail==m.id;
                }).length>0});

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
                    else if(this.mog==3)
                        return a.type==3
                });
            }
            else{
                x=x;
            }*/
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(sales){
            // console.log(123);
            this.salesM=sales;
            // this.json_data=this.salesM;
            return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {
            let d=''
            if(this.start_date){
                d=d+'&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }if(this.end_date){
                d=d+'&end_date='+moment(this.end_date).format('YYYY-MM-DD');
            }
            if(this.restaurant.length>0){
                d=d+'&resturants='+this.pluck(this.restaurant,'id').join(',');
            }

            this.$http.get('/food-and-beverage/reports/running-kitchen-order/running_init_vue?1=1'+d).then(result=>{
                let data=result.data;

                this.restaurant_locations=data.restaurant_locations;
                this.subs=data.subs;
                this.sales=data.sales;

                this.json_data=data.sales;
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
                   // data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ (a.hrcompany?a.hrcompany.name:'') + ' '+ '-' + ' ' + a.designation +')'})
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
                      /*  this.ledger_amount=data.balance;
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

                        })*/
                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;
                      /*  this.ledger_amount=data.balance;
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

                        })*/
                    }
                    else{
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;


                    }
                    this.init();
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
        document.addEventListener('keydown', (event)=> {
            if (event.key === 'Enter') {
                if(this.searchId){
                    this.init();
                    event.preventDefault();
                }
                else if(this.tabledef.length>0 || this.waiter.length>0 || this.acftype!=0  || this.cashier.length>0 || this.rcashier.length>0 || this.ent!='Include ENT & CTS' || this.ent_detail.length>0 || this.start_date ||  this.end_date || this.booking_no || this.specific!=0  || this.restaurant.length>0){
                    this.init();
                    event.preventDefault();
                }
                else if(!this.customer && this.mog!=2){
                    this.init();
                    event.preventDefault();
                }
            }
        });
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
