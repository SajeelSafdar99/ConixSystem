<template>
<div>
    <vue-snotify></vue-snotify>



<template v-if="showTable">

    <div class="row hidden-print">

        <div class="col-sm-5">
            <multiselect track-by="name" label="name" placeholder="Choose Category" v-model="cate" :multiple="true" :options="(()=>{let x=[];
            categories.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
        </div>


        <div class="col-sm-5">
            <multiselect track-by="name" label="name" placeholder="Choose Status" v-model="status" :multiple="true" :options="(()=>{let x=[];
            stati.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
        </div>


            <div class="col-sm-2">
                <button type="button" @click="init();" class="btn btn-success">Search</button>
            </div>

    </div>

<br>

    <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
        <h5>AFOHS <br>MEMBER CARD DETAIL REPORT </h5>
    </div>
<!--
    <div style="text-align: center; color: black;">
        <p><strong>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Name = {{this.customer}}, Category = {{this.pluck(this.cate,'name')}}, Sub-Category = {{this.pluck(this.sub_cat,'name')}}, Item = {{this.pluck(this.item,'name')}}, Item Code = {{this.booking_no}}, Restaurant = {{this.pluck(this.restaurant,'name')}}, Table # = {{this.pluck(this.tabledef,'name')}}, Waiter = {{this.pluck(this.waiter,'name')}}, Cashier = {{this.pluck(this.cashier,'name')}}, Discounted/Taxed = <template v-if="this.specific==1">Discount</template><template v-else-if="this.specific==2">Tax</template><template v-else>All</template>, Status = {{this.status}}</strong></p>

    </div>
-->

    <div class="blackcolor headingsetting ">
    <div class="scrollclasstable1">

        <div>


            <table class="myFormat table-hover " style="width: 100%;">
                <tbody>
                <tr style="border-bottom: 2px solid black;" class="head" >
                    <td><STRONG>CATEGORY</STRONG></td>
                    <td><STRONG>TOTAL CARDS APPLIED</STRONG></td>
                    <td><STRONG>ISSUED PRIMARY MEMBERS</STRONG></td>
                    <td><STRONG>PRINTED PRIMARY MEMBERS</STRONG></td>
                    <td><STRONG>RE-PRINTED PRIMARY MEMBERS</STRONG></td>
                    <td><STRONG>PENDING CARDS</STRONG></td>
                    <!--                        DISCOUNT minus and ENT minus-->
                </tr>

                <template v-for="(s,key) in  sliceP(
                     (()=>{
                      let  x=sales;
                     return x;
                    })()
                    )">

                    <tr v-if="s.cat">
                        <td>{{s.cat}}</td>
                        <td>{{ (s.applied).toLocaleString()}}</td>
                        <td>{{ (s.issued).toLocaleString()}}</td>
                        <td>{{ (s.printed).toLocaleString()}}</td>
                        <td>{{ (s.reprinted).toLocaleString()}}</td>
                        <td>{{ (s.pending).toLocaleString()}}</td>
                    </tr>
                </template>

                <tr style="border: 2px solid black;">
                    <td><STRONG>GRAND TOTAL:</STRONG></td>
                    <td><STRONG>{{ (tapplied).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tissued).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tprinted).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (treprinted).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tpending).toLocaleString()}}</STRONG></td>
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
            <br>
        </div>
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
        name: "carddetail",
        components: {
            Datepicker
        },
        props: [],
        json_data: [],
        data(){
            return{
                itemalreadySearched:false,
                searcheditemsdefs:[],

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
                restaurant:[],
                table_defs:[],
                tabledef:[],
                waiter_defs:[],
                waiter:[],
                cate:[],
                sub_cat:[],
                item:[],
                categories:[],
                stati:[],
                status:[],
                subcategories:[],
                users:[],
                cashier:[],
                items:[],
                specific:0,
                getRe:true,
                showFilters:false,
                showTable:true,
                stsalePrice:0,
                stsales:0,
                stdics:0,
                ssubtt:0,
                json_data: [],
                fkey:-1,
                ffkey:0,
                exported:'',
                tapplied:0,
                tissued:0,
                tprinted:0,
                treprinted:0,
                tpending:0,
            }
        },
        computed: {
            totals() {
                let  x=(this.sales);



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

            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(sales){
                // console.log(123);
                this.salesM=sales;
                this.json_data=this.salesM;
              return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                let x='';
                if(this.cate){
                    x+='&category='+this.pluck(this.cate,'id').join(',');
                }
                if(this.status){
                    x+='&status='+this.pluck(this.status,'id').join(',');
                }
                if(this.getRe){
                    x+='&r='+1;
                }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
                this.$http.get('/finance-and-management/reports/member-card-detail/card_init_vue?1=1'+x).then(result=>{
                    let data=result.data;
                    if(!data.sales){
                        data.sales=[];
                    }
                    if(this.getRe){
                        let aa=0;
                        let bb=0;
                        let cc=0;
                        let dd=0;
                        let ee=0;
                        let x=data.sales;
                        x.forEach(function (s,key) {
                            aa=aa+parseInt(s.applied);
                            bb=bb+parseInt(s.issued);
                            cc=cc+parseInt(s.printed);
                            dd=dd+(parseInt(s.reprinted));
                            ee=ee+(parseInt(s.pending));
                        })
                        this.tapplied=aa
                        this.tissued=bb
                        this.tprinted=cc
                        this.treprinted=dd
                        this.tpending=ee
                    }

                    this.sales=data.sales;
                    this.salesR=data.sales;
                    this.leng=data.sales.length;
                    this.getRe=true;
                    this.categories=data.categories;
                    this.stati=data.stati;

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
            this.init();
        }
    }
</script>

