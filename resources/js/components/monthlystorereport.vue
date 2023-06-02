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
            <div>
                <select v-model="unitsearchid"  class="form-control">
                    <option value="0">Choose Option</option>
                    <option :value="c.code" v-for="c in searchedunits">{{c.code}} - {{c.name}}  (<template v-if="ccs.filter(function(a){return a.code==c.desc})[0]">{{ccs.filter(function(a){return a.code==c.desc})[0].name}}</template>)</option>
                </select>
            </div>
        </div>

        <div class="col-sm">
            <button type="button" @click="init();  " class="btn btn-success">Search</button>

        </div>
    </div>



    <div style="text-align: center; color: black;" class="print-only">
        <br>
        <p><strong>( Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Company = {{this.unitsearchid}} )</strong></p>

    </div>
    <br>

    <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
        <h5>AFOHS <br>QUICK OVERVIEW </h5>
    </div>
    <table class="myFormat table-hover " style="width: 100%;">

        <tbody :style="'font-size:15px'">

        <tr style="border-bottom: 2px solid black;" class="head" >

            <td class="wd-10p"><STRONG>BEGIN DATE</STRONG></td>
            <td class="wd-10p"><STRONG>END DATE</STRONG></td>
            <td class="wd-15p"><STRONG>TYPE</STRONG></td>
            <td class="wd-10p"><STRONG>QUANTITY</STRONG></td>
            <td class="wd-10p"><STRONG>AMOUNT</STRONG></td>
            <td class="wd-10p"><STRONG>BALANCE</STRONG></td>

        </tr>
        <tr>
            <td>{{this.stdate?moment(this.stdate).format('DD/MM/YYYY'):''}}</td>
            <td>{{this.endate?moment(this.endate).format('DD/MM/YYYY'):''}}</td>
            <td>Total Sold Products</td>
            <td>{{ parseFloat(soldqty.toFixed(2)).toLocaleString() }}</td>
            <td>{{ parseFloat(soldamt.toFixed(2)).toLocaleString() }}</td>
            <td>{{ parseFloat(soldamt.toFixed(2)).toLocaleString() }}</td>

        </tr>

        <tr>
            <td>{{this.stdate?moment(this.stdate).format('DD/MM/YYYY'):''}}</td>
            <td>{{this.endate?moment(this.endate).format('DD/MM/YYYY'):''}}</td>

            <td>Total Purchased Products</td>
            <td>{{ parseFloat(purchaseqty.toFixed(2)).toLocaleString()}}</td>
            <td>{{ parseFloat(purchaseamt.toFixed(2)).toLocaleString()}}</td>
            <td>{{ parseFloat((parseFloat(soldamt)-parseFloat(purchaseamt)).toFixed(2)).toLocaleString()}}</td>
        </tr>



        <tr>
            <td>{{this.stdate?moment(this.stdate).format('DD/MM/YYYY'):''}}</td>
            <td>{{this.endate?moment(this.endate).format('DD/MM/YYYY'):''}}</td>
            <td>Total Expenses</td>
            <td>-</td>
            <td>{{ (expamt).toLocaleString()}}</td>
            <td>{{ parseFloat((parseFloat(soldamt)-parseFloat(purchaseamt)-parseInt(expamt)).toFixed(2)).toLocaleString()}}</td>
        </tr>

        <tr style="border: 2px solid black;">
            <td></td>
            <td></td>
            <td></td>
            <td><STRONG>TOTAL:</STRONG></td>
            <td><STRONG>{{ parseFloat((parseFloat(soldamt)-parseFloat(purchaseamt)-parseInt(expamt)).toFixed(2)).toLocaleString()}}</STRONG></td>
            <td></td>
        </tr>
        </tbody>

    </table>


    <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
        <h5><br>PURCHASED PRODUCTS </h5>
    </div>
<!--    <div style="text-align: center; color: black;">
        <p><strongAFOHS <br>>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Category = {{this.pluck(this.cate,'name')}}, Sub-Category = {{this.pluck(this.sub_cat,'name')}}, Item = {{this.pluck(this.item,'name')}}, Item Code = {{this.booking_no}}, Location = {{this.pluck(this.location,'name')}}, Department = {{this.pluck(this.department,'name')}}, Cashier = {{this.pluck(this.cashier,'name')}}, Discounted/Taxed = <template v-if="this.specific==1">Discount</template><template v-else-if="this.specific==2">Tax</template><template v-else>All</template>, Status = <template v-if="this.status==1">Approved</template><template v-else-if="this.status==2">Unapproved</template><template v-else>All</template></strong></p>
    </div>-->

    <div class="blackcolor headingsetting ">
    <div class="scrollclasstable1">

        <div>


            <table class="myFormat table-hover " style="width: 100%;">

                <tbody :style="'font-size:15px'">

                <tr style="border-bottom: 2px solid black;" class="head" >
                    <td class="wd-5p"><STRONG>SR #</STRONG></td>
                    <td class="wd-5p"><STRONG>PURCHASE ID</STRONG></td>
                    <td class="wd-10p"><STRONG>PURCHASE DATE</STRONG></td>
                    <td class="wd-10p"><STRONG>SUPPLIER</STRONG></td>
                    <td class="wd-15p"><STRONG>UNIT</STRONG></td>
<!--                    <td class="wd-15p"><STRONG>ACCOUNT</STRONG></td>-->
                    <td class="wd-10p"><STRONG>ITEM CODE</STRONG></td>
                    <td class="wd-20p"><STRONG>ITEM NAME</STRONG></td>
                    <td class="wd-10p"><STRONG>QUANTITY</STRONG></td>
                    <td class="wd-10p"><STRONG>COST PRICE</STRONG></td>
                </tr>
                <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=(purchases);

                   lengp=x.length;
                  if(parseInt(lengp/pagelength)+((lengp%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td>{{tr.purchase_id}}</td>
                    <td>{{tr.date}}</td>
                    <td>{{tr.supplier}} ({{tr.customer_id}})</td>
                    <td>{{tr.unit}}</td>
<!--                    <td>{{tr.account}}</td>-->
                    <td>{{tr.item_code}}</td>
                    <td>{{tr.item_details}}</td>
                    <td>{{ (tr.qty).toLocaleString()}}</td>
                    <td>{{ (tr.sub_total_price).toLocaleString()}}</td>

                </tr>


                <tr style="border: 2px solid black;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td><STRONG>TOTAL:</STRONG></td>
                    <td><strong>{{ parseFloat(purchaseqty.toFixed(2)).toLocaleString()}}</strong></td>
                    <td><strong>{{ parseFloat(purchaseamt.toFixed(2)).toLocaleString()}}</strong></td>
                </tr>
                </tbody>

            </table>




<!--            <div class="hidden-print">
                <ul class="pagination">
                    <li :class="page==n?'active':''"  v-for="n in (parseInt(lengp/pagelength)+((lengp%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                    <li>
                        <select  v-model="pagelength" class="">
                            <option value="30" >30</option>
                            <option value="50" >50</option>
                            <option value="100" >100</option>
                            <option value="150" >150</option>
                            <option :value="purchases.length" >ALL</option>
                        </select>
                    </li>  </ul>
            </div>-->


            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5><br>SOLD PRODUCTS </h5>
            </div>
            <table class="myFormat table-hover " style="width: 100%;">
                <tbody :style="'font-size:15px'">

            <tr style="border-bottom: 2px solid black;" class="head" >
                <td class="wd-5p"><STRONG>SR #</STRONG></td>
                <td class="wd-5p"><STRONG>SALE ID</STRONG></td>
                <td class="wd-10p"><STRONG>SALE DATE</STRONG></td>
                <td class="wd-10p"><STRONG>NAME</STRONG></td>
                <td class="wd-10p"><STRONG>TYPE</STRONG></td>
                <td class="wd-10p"><STRONG>UNIT</STRONG></td>
<!--                <td class="wd-10p"><STRONG>ACCOUNT</STRONG></td>-->
                <td class="wd-10p"><STRONG>ITEM CODE</STRONG></td>
                <td class="wd-20p"><STRONG>ITEM NAME</STRONG></td>
                <td class="wd-5p"><STRONG>QUANTITY</STRONG></td>
                <td class="wd-10p"><STRONG>UNIT COST PRICE</STRONG></td>
                <td class="wd-10p"><STRONG>UNIT SALE PRICE</STRONG></td>
                <td class="wd-10p"><STRONG>SALE AMOUNT</STRONG></td>

            </tr>
            <tr v-for="(tr,key) in

                sliceS(
                     (()=>{
                      let  x=(sales);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                <td>{{((page-1)*pagelength)+key+1}}</td>
                <td>{{tr.sale_id}}</td>
                <td>{{tr.date}}</td>

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

                <td>{{tr.unite}}</td>
<!--                <td>{{tr.account}}</td>-->
                <td>{{tr.item_code}}</td>
                <td>{{tr.item_details}}</td>
                <td>{{ (tr.qty).toLocaleString()}}</td>
                <td>{{ (parseFloat(tr.purchase_price)).toLocaleString()}}</td>
                <td>{{ (parseFloat(tr.sale_price)).toLocaleString()}}</td>
                <td>{{ (parseFloat(tr.sub_total_price)).toLocaleString()}}</td>


            </tr>


            <tr style="border: 2px solid black;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td><STRONG>TOTAL:</STRONG></td>
                <td><strong>{{ parseFloat(soldqty.toFixed(2)).toLocaleString()}}</strong></td>
                <td><strong>{{ parseFloat(soldpp.toFixed(2)).toLocaleString()}}</strong></td>
                <td><strong>{{ parseFloat(soldsp.toFixed(2)).toLocaleString()}}</strong></td>
                <td><strong>{{ parseFloat(soldamt.toFixed(2)).toLocaleString()}}</strong></td>


            </tr>
                </tbody>

            </table>







            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5><br>EXPENSES </h5>
            </div>
            <table class="myFormat table-hover " style="width: 100%;">

                <tbody :style="'font-size:15px'">

                <tr style="border-bottom: 2px solid black;" class="head" >
                    <td class="wd-5p"><STRONG>SR #</STRONG></td>
                    <td class="wd-5p"><STRONG>ID</STRONG></td>
                    <td class="wd-5p"><STRONG>EXPENSE NO</STRONG></td>
                    <td class="wd-10p"><STRONG>EXPENSE DATE</STRONG></td>
                    <td class="wd-10p"><STRONG>SUPPLIER</STRONG></td>
                    <td class="wd-15p"><STRONG>UNIT</STRONG></td>
                    <!--                    <td class="wd-15p"><STRONG>ACCOUNT</STRONG></td>-->
                    <td class="wd-10p"><STRONG>COA CODE</STRONG></td>
                    <td class="wd-20p"><STRONG>ACCOUNT NAME</STRONG></td>
                    <td class="wd-10p"><STRONG>AMOUNT</STRONG></td>
                </tr>
                <tr v-for="(tr,key) in

                sliceE(
                     (()=>{
                      let  x=(expenses);

                   lenge=x.length;
                  if(parseInt(lenge/pagelength)+((lenge%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td>{{tr.id}}</td>
                    <td>{{tr.expense_no}}</td>
                    <td>{{tr.expense_date}}</td>

                    <td>{{tr.supplier}} ({{tr.supplier_id}})</td>

                    <td>{{tr.unit}}</td>
                    <!--                    <td>{{tr.account}}</td>-->
                    <td>{{tr.code}}</td>
                    <td>{{tr.account}}</td>
                    <td>{{ (tr.amount).toLocaleString()}}</td>

                </tr>
                <tr style="border: 2px solid black;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><STRONG>TOTAL:</STRONG></td>
                    <td><strong>{{ (expamt).toLocaleString()}}</strong></td>

                </tr>



<tr><td>&nbsp</td>
    <td>&nbsp</td>
</tr>
                <tr style="border: 2px solid black;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td  ><STRONG>GRAND TOTAL:</STRONG></td>
                    <td>(Qty) &nbsp<strong>{{ parseFloat((parseFloat(soldqty)+parseFloat(purchaseqty)).toFixed(2)).toLocaleString() }}</strong></td>
                    <td>(Amt) &nbsp<strong>{{ parseFloat((parseFloat(soldamt)+parseFloat(purchaseamt)+parseInt(expamt)).toFixed(2)).toLocaleString()}}</strong></td>

                </tr>

                </tbody>


            </table>


<!--            <div class="hidden-print">
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
            </div>-->

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
        name: "monthlystorereport",
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
                status:0,
                page:1,
                keysss:0,
                pagelength:50,
                leng:0,
                lengp:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                sales:[],
                salesR:[],
                salesM: [],

                purchases:[],
                purchasesR:[],
                purchasesM: [],


                expenses:[],
                expensesR:[],
                expensesM: [],

                booking_no:'',
                start_date:'',
                end_date:'',
                stdate:'',
                endate:'',
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
                getRe:false,
                showFilters:true,
                showTable:false,

                purchaseqty:0,
                purchaseamt:0,
                soldqty:0,
                soldamt:0,
                expamt:0,
                soldpp:0,
                soldsp:0,



                unmapsub:0,
                mapsub:0,
                json_data: [],
                fkey:-1,
                ffkey:0,
                location:[],
                locations:[],
                department:[],
                departments:[],
                exported:'',
                unitsearch:'',
                unitsearchid:0,
                unitalreadySearched:false,
                ccs:[],
                searchedunits:[],
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
            sliceS(sales){
                // console.log(123);
                this.salesM=sales;
                this.json_data=this.salesM;
              return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            sliceP(purchases){
                // console.log(123);
                this.purchasesM=purchases;
                this.json_data=this.purchasesM;
                return  purchases.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },

            sliceE(expenses){
                // console.log(123);
                this.expensesM=expenses;
                this.json_data=this.expensesM;
                return  expenses.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                let x='';
                  if(this.start_date){

                    x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
                }  if(this.end_date){
                    x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
                }
                if(this.unitsearchid){
                    x+='&unitsearch='+this.unitsearchid;
                }
                if(this.getRe) {
                    x += '&r=' + 1;
                }


                  /*if(this.item){
                }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
                this.$http.get('/finance-and-management/reports/monthly-store-report/monthly_init_vue?1=1'+x).then(result=>{
                    let data=result.data;
                    if(!data.sales){
                        data.sales=[];
                    }
                    if(!data.purchases){
                        data.purchases=[];
                    }

                    if(!data.expenses){
                        data.expenses=[];
                    }

                    this.sales=data.sales;
                    this.salesR=data.sales;
                    this.leng=data.sales.length;

                    this.purchases=data.purchases;
                    this.purchasesR=data.purchases;
                    this.lengp=data.purchases.length;


                    this.expenses=data.expenses;
                    this.expensesR=data.expenses;
                    this.lenge=data.expenses.length;

                    this.overview=data.overview;
                    this.ccs=data.ccs;
                    this.searchedunits=data.searchedunits;


                        let a=0;
                        let b=0;
                        let c=0;
                        let d=0;
                        let e=0;
                    let f=0;
                    let g=0;

                        let x= this.purchases;
                        let l=this.sales;
                        let z=this.expenses;

                        x.forEach(function (s,key) {
                            a=a+parseFloat(s.qty);
                            b=b+parseFloat(s.sub_total_price);
                        })

                        l.forEach(function (s,key) {
                            c=c+parseFloat(s.qty);
                            f=f+parseFloat(s.purchase_price);
                            g=g+parseFloat(s.sale_price);
                            d=d+parseFloat(s.sub_total_price);
                        })

                    z.forEach(function (s,key) {

                        e=e+parseInt(s.amount);
                    })
                        this.purchaseqty=a
                        this.purchaseamt=b
                        this.soldqty=c
                        this.soldamt=d
                        this.expamt=e
                    this.soldpp=f
                    this.soldsp=g

                    this.stdate= this.start_date
                    this.endate= this.end_date


                    this.getRe=true;
                    this.categories=data.category;
                    this.subcategories=data.sub_category;
                    this.locations=data.locations;
                    this.departments=data.departments;
                    this.users=data.created_by;
                    this.items=data.items;
                    this.exported=data.exported;

                })
            },

            customerdata(){
                let v = 2;
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
                let v = 2;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=0&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){

                        this.customer_id = data.id;
                        this.customer = data.person_name;

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
            this.init();
        }
    }
</script>

