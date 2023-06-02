<template>
    <div>
        <vue-snotify></vue-snotify>


        <template v-if="showFilters">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="form-layout form-layout-4 blackcolor headingsetting hidden-print">
                        <!-- <h5 class="text-center"><STRONG>FILTERS</STRONG></h5>
                 -->
                        <div class="row">
                            <label class="col-sm-2 form-control-label">BEGIN DATE:</label>
                            <div class="col-sm-4">
                                <datepicker :disabledDates="disabledDates" v-model="start_date" placeholder="From (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                            </div>

                            <label class="col-sm-2 form-control-label">END DATE:</label>
                            <div class="col-sm-4">
                                <datepicker :disabledDates="disabledDates" v-model="end_date" placeholder="To (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-2">
                            <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">

                                </label>
                            </div>

                            <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input  type="radio"  name="mog" v-model="mog" value="2"><span class="pabs">All</span>
                                </label>
                            </div> <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                            <label class="rdiobox">
                                <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
                            </label>
                        </div>
                            <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                                </label>
                            </div>
                            <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                <label class="rdiobox">
                                    <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Employee</span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">NAME:</label>
                            <div class="col-sm-10">
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
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">CATEGORY:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="cate" :multiple="true" :options="(()=>{let x=[];
            categories.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">SUB-CATEGORY:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="sub_cat" :multiple="true" :options="(()=>{
            let x=[];
                subcategories.filter((a)=>{
                    if(cate.length>0){
                        return pluck(cate,'id').indexOf(parseInt(a.item_category))!=-1
                    } else{
                        return true;
                    } } ).forEach((a)=>{
                        x.push({name:a.desc,id:a.id})
                })
                return x;
            })()"></multiselect>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">ITEM:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="item" :multiple="true" :options="(()=>{
                let x=[];
                items.filter((a)=>{
                    let cond=true;
                    if(cate.length>0 && sub_cat.length==0){

                        return pluck(cate,'id').indexOf(parseInt(a.category))!=-1
                    }
                    else if(sub_cat.length>0){
                         return pluck(sub_cat,'id').indexOf(parseInt(a.sub_category))!=-1
                     }
                        else{
                        return true;
                    }
                    } ).forEach((a)=>{
                        x.push({name:a.item_details,id:a.id})
                })
                return x;
            })()"></multiselect>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">ITEM CODE / NAME:</label>
                            <div class="col-sm-10">
                                <input  type="text" class="form-control typeahead" autocomplete="off" v-model="booking_no" tabindex="2" name="booking_no" placeholder="Enter to Search...">
                                <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.booking_no && searcheditemsdefs.length>0">

                                    <li @click="itemsdatavalue(itd.id)" v-for="itd in searcheditemsdefs">
                                        {{itd.item_code}} - {{itd.item_details}}
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">STORE LOCATION:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="location" :multiple="true" :options="(()=>{let x=[];
            locations.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">DEPARTMENT:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="department" :multiple="true" :options="(()=>{let x=[];
            departments.filter((a)=>{return this.location.filter((m)=>{
                        return a.location==m.id;
                    }).length>0}).forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">INVOICE NO:</label>
                            <div class="col-sm-10">
                                <input value="" class="form-control tablikebutton"  size="20" type="number"
                                       id="booking_no" v-model="inv"
                                       name="booking_no" placeholder="Search Id...">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">CASHIER:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="cashier" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">DISCOUNTED / TAXED:</label>
                            <div class="col-sm-10">
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
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">STATUS:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="status" name="status" id="status">
                                    <option value="0">All</option>
                                    <option  value="1">
                                        Approved
                                    </option>
                                    <option  value="2">
                                        Unapproved
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label"></label>
                            <div class="col-sm-10">
                                <button type="button" @click="init(); showTable=true; showFilters=false; " class="btn btn-success">Search</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </template>



        <template v-if="showTable">
            <div class="hidden-print">
                <button type="button" @click="showTable=false; showFilters=true; " class="btn btn-warning">CHANGE SEARCH CRITERIA !</button>
            </div>
        <div v-if="this.exported" class="hidden-print">
            <export-excel
                class   = "btn btn-primary"
                :data   = "json_data"
                worksheet = "My Worksheet"
                name    = "ItemStoreSales.xls">
            </export-excel>
        </div>

            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>AFOHS <br>STORE SALES SUMMARY (WITH ITEMS) </h5>

            </div>
            <div style="text-align: center; color: black;">
                <p><strong>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Name = {{this.customer}},Category = {{this.pluck(this.cate,'name')}}, Sub-Category = {{this.pluck(this.sub_cat,'name')}}, Item = {{this.pluck(this.item,'name')}}, Item Code = {{this.booking_no}}, Location = {{this.pluck(this.location,'name')}}, Department = {{this.pluck(this.department,'name')}}, Cashier = {{this.pluck(this.cashier,'name')}}, Discounted/Taxed = <template v-if="this.specific==1">Discount</template><template v-else-if="this.specific==2">Tax</template><template v-else>All</template>, Status = <template v-if="this.status==1">Approved</template><template v-else-if="this.status==2">Unapproved</template><template v-else>All</template></strong></p>

            </div>

            <div class="blackcolor headingsetting ">
                <div class="scrollclasstable1">

                    <div>


                        <table class="myFormat table-hover " style="width: 100%;">
                            <tbody>

                            <template v-for="(s,key) in  sliceP(
                     (()=>{
                      let  x=sales;
                     return x;
                    })()
                    )">

                                <tr v-if="((key+((page-1)*pagelength))==0) || sales[(key+((page-1)*pagelength))-1].cat!=s.cat" style="font-size: 5px !important;">
                                    <td colspan="1" style="text-transform: uppercase;"><b>{{s.cat}}</b> </td>

                                    <td  colspan="2" style="text-transform: uppercase;"><b>Date:</b> {{moment(s.dda).format('DD MMM YY')}}
                                    &nbsp&nbsp&nbsp&nbsp <b>Customer:</b> <template v-if="s.type==0">{{s.member}}</template><template v-else-if="s.type==1">{{s.guest}}</template><template v-else-if="s.type==3">{{s.employee}}</template></td>

                                    <td colspan="2" style="text-transform: uppercase;"><b>Invoice Total:</b> <b>{{s.gtotal | numFormat}}</b>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  <b>Disc:</b> {{s.disc | numFormat}}
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  <b>Tax:</b> {{s.tax | numFormat}} </td>

                                </tr>

                                <tr style="border-bottom: 2px solid black;" class="head" v-if="((key+((page-1)*pagelength))==0) || sales[(key+((page-1)*pagelength))-1].cat!=s.cat">
                                    <td><STRONG>ITEM CODE</STRONG></td>
                                    <td><STRONG>ITEM NAME</STRONG></td>
                                    <td><STRONG>QTY</STRONG></td>
                                    <td><STRONG>SALE PRICE</STRONG></td>
                                    <td><STRONG>TOTAL SALE</STRONG></td>
                                </tr>

                                <tr>
                                    <td>{{s.item_code}}</td>
                                    <td>{{s.item_details}}</td>
                                    <td>{{(s.qty).toFixed(2)}}</td>
                                    <td>{{s.sale_price | numFormat }}</td>
                                    <td>{{s.sub_total_price | numFormat}}</td>
                                </tr>

                                <tr v-if="sales[(key+((page-1)*pagelength))+1]==undefined ||  sales[(key+((page-1)*pagelength))+1].cat!=s.cat">

                                    <td></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>TOTAL:</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{(s.tsales).toFixed(2)}}</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.tsalePrice | numFormat }}</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.subtt | numFormat }}</STRONG></td>

                                </tr>
                                <tr v-if="sales[(key+((page-1)*pagelength))+1]==undefined ||  sales[(key+((page-1)*pagelength))+1].cat!=s.cat">
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>

                                </tr>

                            </template>
                            <tr style="border: 2px solid black;">
                                <td></td>
                                <td><STRONG>GRAND TOTAL:</STRONG></td>
                                <td><STRONG>{{(stsales).toFixed(2)}}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{ssubtt | numFormat }}</STRONG></td>
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
    name: "itemstoresalesummary",
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
            status:'0',
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
            subcategories:[],
            users:[],
            cashier:[],
            items:[],
            specific:0,
            getRe:false,
            showFilters:true,
            showTable:false,
            stsalePrice:0,
            stsales:0,
            stdics:0,
            ssubtt:0,
            stax:0,
            inv:null,
            json_data: [],
            fkey:-1,
            ffkey:0,
            location:[],
            locations:[],
            department:[],
            departments:[],
            exported:'',
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
        init:function () {

            let x='';
          if(this.mem_id_){

                x+='&mem='+this.mem_id_;
            }
            if(this.mog){
                x+='&mog='+this.mog;
            }
          if(this.specific){

                x+='&discounted='+this.specific;
            }
            if(this.status){

                x+='&status='+this.status;
            }
            if(this.customer_id){
                if(this.customer){
                x+='&mem='+this.customer_id;
                }
            }
            if(this.cate){
                /*x+='&category='+this.cate;*/
                x+='&category='+this.pluck(this.cate,'id').join(',');
            }
            if(this.sub_cat){
                /* x+='&sub_category='+this.sub_cat;*/
                x+='&sub_category='+this.pluck(this.sub_cat,'id').join(',');
            }
            if(this.item){
                /*x+='&item='+this.item;*/
                x+='&item='+this.pluck(this.item,'id').join(',');
            }
            if(this.location){
                x+='&location='+this.pluck(this.location,'id').join(',');
            }
            if(this.department){
                x+='&department='+this.pluck(this.department,'id').join(',');
            }
            if(this.inv){
                x+='&inv='+this.inv;
            }

            if(this.booking_no){
                x+='&item_code='+this.booking_no;
            } if(this.cashier){
                x+='&cashier='+this.pluck(this.cashier,'id').join(',');
            }  if(this.start_date){
                x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }  if(this.end_date){
                x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
            }if(this.getRe){
                x+='&r='+1;
            }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
            this.$http.get('/finance-and-management/reports/items-store-sales-summary/itemsalesummary_init_vue?1=1'+x).then(result=>{
                let data=result.data;
                if(!data.sales){
                    data.sales=[];
                }
                let mxc=data.sales;

                if(this.getRe){
                    let a=0;
                    let b=0;
                    let c=0;
                    let d=0;
                    let aa=0;
                    let bb=0;
                    let cc=0;
                    let dd=0;
                    let ddd=0;
                    let aaa=0;
                    let bbb=0;
                    let ccc=0;
                    let dddd=0;
                    let x=mxc;

                    //console.log(1);
                    x.forEach(function (s,key) {
                        a=a+parseInt(s.sale_price);
                        b=b+parseFloat(s.qty);
                        c=c+parseFloat(s.discount);
                        d=d+(parseInt(s.sub_total_price));
                        aa=aa+parseInt(s.sale_price);
                        bb=bb+parseFloat(s.qty);
                        cc=cc+parseFloat(s.discount);
                        ddd=ddd+parseInt(s.tax);
                        dd=dd+(parseInt(s.sub_total_price));
                        bbb=bbb+parseFloat(s.qty);
                        ccc=ccc+parseFloat(s.discount);
                        dddd=dddd+(parseInt(s.sub_total_price));

                        if( x[key+1]==undefined ||  x[key+1].cat!=s.cat){
                            s.itsalePrice=aaa;
                            s.itsales=bbb;
                            s.itdics=ccc;
                            s.isubtt=dddd;
                            aaa=0;
                            bbb=0;
                            ccc=0;
                            dddd=0;
                            s.tsalePrice=a;
                            s.tsales=b;
                            s.tdics=c;
                            s.subtt=d;
                            a=0;
                            b=0;
                            c=0;
                            d=0;
                        }

                    })
                    this.stsalePrice=aa
                    this.stsales=bb
                    this.stdics=cc
                    this.ssubtt=dd
                    this.stax=ddd
                }

                    this.sales=mxc;
                    this.salesR=mxc;
                    this.leng=mxc.length;

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
        this.init();
    }
}
</script>

