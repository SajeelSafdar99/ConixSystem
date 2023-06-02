<template>
<div>
    <vue-snotify></vue-snotify>


    <div class="row hidden-print">


            <div class="col-sm-3">
            <datepicker :disabledDates="disabledDates" v-model="start_date" placeholder="From (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
            </div>

            <div class="col-sm-3">
            <datepicker :disabledDates="disabledDates" v-model="end_date" placeholder="To (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>



            <div class="col-sm-4">
                <multiselect track-by="name" label="name" placeholder="Choose Restaurants" v-model="restaurant" :multiple="true" :options="(()=>{let x=[];
            restaurant_locations.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>


            <div class="col-sm-1">
                <button type="button" @click="init(); showTable=true; showFilters=false; " class="btn btn-success">Search</button>
            </div>

        <div class="col-sm-1">
            <button type="button" @click="refreshme(); showTable=true; showFilters=false; " class="btn btn-warning">Refresh</button>
        </div>



    </div>


    <br>
    <div style="text-align: center; color: black; letter-spacing: 0.2em !important; background-color: red !important;">
        <h5><br>AFOHS<br> SALES DASHBOARD</h5>
<br>
    </div>
   <br>

    <div style="text-align: center; color: black; letter-spacing: 0.2em !important; background-color: green !important;">
        <h5><br>PROCESSED</h5>
        <br>
    </div>

    <table class="myFormat" style="width: 100%;">
        <tbody>
        <template v-for="(tr,key) in sales">

            <tr v-if="sales[key+1]==undefined" class="head">
                <td  style="width: 5% !important;"><STRONG></STRONG></td>
                <td style="text-align: center;"><STRONG>NO. OF BILLS</STRONG></td>
                <td style="text-align: center;"><STRONG>COVERS</STRONG></td>
                <td style="text-align: center;"><STRONG>SALES</STRONG></td>
                <td style="text-align: center;"><STRONG>AVG/COVER</STRONG></td>
            </tr>

            <tr v-if="sales[key+1]==undefined">
                <td style="width: 5% !important;"><strong>Dine-In: </strong></td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.processed_dine_count | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.processed_dine_covers | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{ parseFloat(tr.processed_dine_sales.toFixed(1)).toLocaleString()}}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{(tr.processed_dine_sales/tr.processed_dine_covers) | numFormat }}</td>
            </tr>
            <tr v-if="sales[key+1]==undefined">
                <td style="width: 5% !important;"><strong>Take Away: </strong></td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.processed_take_count | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.processed_take_covers | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{parseFloat(tr.processed_take_sales.toFixed(1)).toLocaleString() }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{(tr.processed_take_sales/tr.processed_take_covers) | numFormat }}</td>
            </tr>
            <tr v-if="sales[key+1]==undefined">
                <td style="width: 5% !important;"><strong>Home Delivery: </strong></td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.processed_home_count | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.processed_home_covers | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{ parseFloat(tr.processed_home_sales.toFixed(1)).toLocaleString() }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{(tr.processed_home_sales/tr.processed_home_covers) | numFormat }}</td>
            </tr>

          <tr>
              <td style="width: 5% !important;"><strong>TOTAL: </strong></td>
                <td style="background-color: #0042ff; color: black; font-size: 21px !important;"  class="border border-dark">{{totals.pn | numFormat }}</td>
                <td style="background-color: #0042ff; color: black;  font-size: 21px !important;"  class="border border-dark">{{totals.pc | numFormat }}</td>
                <td style="background-color: #0042ff; color: black;  font-size: 21px !important;"  class="border border-dark">{{ parseFloat(totals.ps.toFixed(1)).toLocaleString() }}</td>
                <td style="background-color: #0042ff;  color: black; font-size: 21px !important;"  class="border border-dark">{{ (totals.ps/totals.pc) | numFormat }}</td>
            </tr>

        </template>
        </tbody>

    </table>


    <div style="text-align: center; color: black; letter-spacing: 0.2em !important; background-color: yellow !important;">
        <h5><br>IN-PROCESS</h5>
        <br>
    </div>
    <table class="myFormat" style="width: 100%;">
        <tbody>
        <template v-for="(tr,key) in sales">



            <tr>
                <td style="width: 5% !important;"><strong>Dine-In: </strong></td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.inprocess_dine_count | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.inprocess_dine_covers | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{parseFloat(tr.inprocess_dine_sales.toFixed(1)).toLocaleString() }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{(tr.inprocess_dine_sales/tr.inprocess_dine_covers) | numFormat }}</td>
            </tr>
            <tr >
                <td style="width: 5% !important;"><strong>Take Away: </strong></td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.inprocess_take_count | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.inprocess_take_covers | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{parseFloat(tr.inprocess_take_sales.toFixed(1)).toLocaleString() }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{(tr.inprocess_take_sales/tr.inprocess_take_covers) | numFormat }}</td>
            </tr>
            <tr>
                <td style="width: 5% !important;"><strong>Home Delivery: </strong></td>
                <td style="  font-size: 21px !important;" class="border border-dark">{{tr.inprocess_home_count | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{tr.inprocess_home_covers | numFormat }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{parseFloat(tr.inprocess_home_sales.toFixed(1)).toLocaleString() }}</td>
                <td style="  font-size: 21px !important;"  class="border border-dark">{{(tr.inprocess_home_sales/tr.inprocess_home_covers) | numFormat }}</td>
            </tr>

            <tr>
                <td style="width: 5% !important;"><strong>TOTAL: </strong></td>
                <td style="background-color: #0042ff; color: black;  font-size: 21px !important;"  class="border border-dark">{{totals.inn | numFormat }}</td>
                <td style="background-color: #0042ff; color: black;  font-size: 21px !important;"  class="border border-dark">{{totals.ic | numFormat }}</td>
                <td style="background-color: #0042ff; color: black;  font-size: 21px !important;"  class="border border-dark">{{parseFloat(totals.iss.toFixed(1)).toLocaleString() }}</td>
                <td style="background-color: #0042ff; color: black;  font-size: 21px !important;"  class="border border-dark">{{ (totals.iss/totals.ic) | numFormat }}</td>
            </tr>



        </template>
        </tbody>

    </table>



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
.border {
    border: 26px solid white !important;
    background-color: black;
    color: yellow;
    padding: 15px;
    text-align: center;
    font-weight: 900;
}
table.myFormat tr td {
    font-size: 17px !important;
    width: 22%;
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
        data(){
            return{
                disabledDates: {
                    from: new Date(),
                },
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
                booking_no:'',
                start_date:'',
                end_date:'',
                customers:[],
                customer:'',
                mog:2,
                searchId:null,
                restaurant_locations:[],
                processed:[],
                inprocess:[],
                restaurant:[],
                table_defs:[],
                tabledef:[],
                waiter_defs:[],
                waiter:[],
                cate:0,
                sub_cat:0,
                categories:[],
                subcategories:[],
                users:[],
                cashier:[],
                items:[],
                item:0,
                specific:0,
                getRe:false,
                showFilters:true,
                showTable:false,
                stsalePrice:0,
                stsales:0,
                stdics:0,
                ssubtt:0,
            }
        },
        computed: {
            totals() {
                let x=this.sales;

                let ps=0;
                let pc=0;
                let pn=0;

                let iss=0;
                let ic=0;
                let inn=0;

                x.forEach(function (item) {

                    ps=ps + parseFloat(item.processed_dine_sales?item.processed_dine_sales:0)+ parseFloat(item.processed_take_sales?item.processed_take_sales:0)+ parseFloat(item.processed_home_sales?item.processed_home_sales:0);
                    pc=pc + parseInt(item.processed_dine_covers?item.processed_dine_covers:0)+ parseInt(item.processed_take_covers?item.processed_take_covers:0)+ parseInt(item.processed_home_covers?item.processed_home_covers:0);
                    pn=pn + parseInt(item.processed_dine_count?item.processed_dine_count:0)+ parseInt(item.processed_take_count?item.processed_take_count:0)+ parseInt(item.processed_home_count?item.processed_home_count:0);


                    iss=iss + parseFloat(item.inprocess_dine_sales?item.inprocess_dine_sales:0)+ parseFloat(item.inprocess_take_sales?item.inprocess_take_sales:0)+ parseFloat(item.inprocess_home_sales?item.inprocess_home_sales:0);
                    ic=ic + parseInt(item.inprocess_dine_covers?item.inprocess_dine_covers:0)+ parseInt(item.inprocess_take_covers?item.inprocess_take_covers:0)+ parseInt(item.inprocess_home_covers?item.inprocess_home_covers:0);
                    inn=inn + parseInt(item.inprocess_dine_count?item.inprocess_dine_count:0)+ parseInt(item.inprocess_take_count?item.inprocess_take_count:0)+ parseInt(item.inprocess_home_count?item.inprocess_home_count:0);

                })
                return {
                    ps:ps,
                    pc:pc,
                    pn:pn,

                    iss:iss,
                    ic:ic,
                    inn:inn,
                }
            }
        },
        methods:{
            refreshme:function () {
                let self=this;
                self.init();
            },
            filterData(sales){
             let   x=sales;
                if(this.booking_no){
                    x=x.filter((a)=>{return a.invoice_no==this.booking_no});

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

                if(this.start_date){
                    x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

                }
                if(this.end_date){
                    x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
                }  if(this.status){

                    if(this.status=='Paid'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))==0});

                    }   else if(this.status=='Unpaid'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))>0});

                    }   else if(this.status=='Advance'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))<0});

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

                let x='';


                if(this.restaurant){
                    x+='&resturants='+this.pluck(this.restaurant,'id').join(',');
                }
                if(this.tabledef){
                    x+='&tables='+this.pluck(this.tabledef,'id').join(',');
                }
                if(this.waiter){
                    x+='&waiter='+this.pluck(this.waiter,'id').join(',');
                } if(this.mem_id_){

                    x+='&mem='+this.mem_id_;
                } if(this.mog){

                    x+='&mog='+this.mog;
                } if(this.specific){

                    x+='&discounted='+this.specific;
                } if(this.customer_id){
                    if(this.customer) {
                        x += '&mem=' + this.customer_id;
                    }
                }
                if(this.cate){
                    x+='&category='+this.cate;
                }
                if(this.sub_cat){
                    x+='&sub_category='+this.sub_cat;
                }
                if(this.item){
                    x+='&item='+this.item;
                }


                /*if(this.cate){
                    x+='&category='+this.pluck(this.cate,'id').join(',');
                } */
                /*if(this.sub_cat){
                    x+='&sub_category='+this.pluck(this.sub_cat,'id').join(',');
                } */
                if(this.booking_no){
                    x+='&item_code='+this.booking_no;
                } if(this.cashier){
                    x+='&cashier='+this.pluck(this.cashier,'id').join(',');
                }

                if(this.start_date){
                    x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
                }  if(this.end_date){
                    x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
                }
                if(this.getRe){
                    x+='&r='+1;
                }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/


                this.$http.get('/finance-and-management/reports/sales-dashboard/salesdashboard_init_vue?1=1'+x).then(result=>{
                    let data=result.data;
                    if(!data.sales){
                        data.sales=[];
                    }
                    this.restaurant_locations=data.restaurant_locations;
                    this.processed=data.processed;
                    this.inprocess=data.inprocess;
                    this.table_defs=data.table_defs;
                    this.waiter_defs=data.waiter_defs;






                     /*   let a=0;
                        let b=0;
                        let x=data.processed;
                        //console.log(1);
                        x.forEach(function (s,key) {
                            a=a+parseInt(s.covers);
                            b=b+parseInt(s.grand_total);
                            if( x[key+1]==undefined ||  x[key+1].sub!=s.sub){
                                s.tcovers=a;
                                s.tsales=b;
                                a=0;
                                b=0;

                            }
                        })*/


                    this.sales=data.sales;
                    this.salesR=data.sales;
                    this.leng=data.sales.length;
                    this.getRe=true;
                    this.categories=data.category;
                    this.subcategories=data.sub_category;
                    this.users=data.created_by;
                    this.items=data.items;



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
                let self=this;
                self.init();
           /* setInterval(function(){
                self.init();
            },3000)*/

        }
    }
</script>

