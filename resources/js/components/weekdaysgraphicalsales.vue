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
                    <div class="row">
                        <label class="col-sm-2 form-control-label">WEEK DAY:</label>
                        <div class="col-sm-10">
                            <select v-model="day"  class="form-control">
                                <option label="All" value="-1"></option>
                                <option :value="s-1" v-for="s in 7">{{moment().weekday(s-1).format('dddd')}}</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-sm-2 form-control-label">CHART TYPE:</label>
                        <div class="col-sm-10">
                            <select v-model="ctype"  class="form-control">
                                <option value="column">Bar</option>
                                <option value="line">Line</option>
                                <option value="area">Area</option>
                                <option value="pie">pie</option>
                            </select>
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
                    <!-- <div class="row">
                         <label class="col-sm-2 form-control-label">CATEGORY:</label>
                         <div class="col-sm-10">
                             <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="cate" :multiple="true" :options="(()=>{let x=[];
                         categories.forEach((a)=>{
                             x.push({name:a.desc,id:a.id})
                         })
                         return x;
                         })()"></multiselect>
                         </div>
                     </div>-->
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
                    <!-- <div class="row">
                         <label class="col-sm-2 form-control-label">SUB-CATEGORY:</label>
                         <div class="col-sm-10">
                             <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="sub_cat" :multiple="true" :options="(()=>{let x=[];
                         subcategories.forEach((a)=>{
                             x.push({name:a.desc,id:a.id})
                         })
                         return x;
                         })()"></multiselect>
                         </div>
                     </div>-->
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
                    <!-- <div class="row">
                         <label class="col-sm-2 form-control-label">ITEM:</label>
                         <div class="col-sm-10">
                             <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="item" :multiple="true" :options="(()=>{let x=[];
                         items.forEach((a)=>{
                             x.push({name:a.item_details,id:a.id})
                         })
                         return x;
                         })()"></multiselect>
                         </div>
                     </div>-->
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
                        <label class="col-sm-2 form-control-label">RESTAURANT:</label>
                        <div class="col-sm-10">
                            <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="restaurant" :multiple="true" :options="(()=>{let x=[];
            restaurant_locations.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-sm-2 form-control-label">TABLE #:</label>
                        <div class="col-sm-10">
                            <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="tabledef" :multiple="true" :options="(()=>{let x=[];
            table_defs.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-sm-2 form-control-label">WAITER:</label>
                        <div class="col-sm-10">
                            <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="waiter" :multiple="true" :options="(()=>{let x=[];
            waiter_defs.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
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
                            <select v-model="status"  class="form-control">
                                <option v-for="s in ['All','Advance','Paid','Unpaid']">{{s}}</option>
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
    <button type="button" @click="showTable=false; showFilters=true; " class="btn btn-warning hidden-print">CHANGE SEARCH CRITERIA !</button>

    <div style="text-align: center; color: black; letter-spacing: 0.2em !important; background-color: white !important;">
        <h5>AFOHS</h5>
        <div style="text-align: center; color: black;">
            <p><strong>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Name = {{this.customer}}, Category = {{this.pluck(this.cate,'name')}}, Sub-Category = {{this.pluck(this.sub_cat,'name')}}, Item = {{this.pluck(this.item,'name')}}, Item Code = {{this.booking_no}}, Restaurant = {{this.pluck(this.restaurant,'name')}}, Table # = {{this.pluck(this.tabledef,'name')}}, Waiter = {{this.pluck(this.waiter,'name')}}, Cashier = {{this.pluck(this.cashier,'name')}}, Discounted/Taxed = <template v-if="this.specific==1">Discount</template><template v-else-if="this.specific==2">Tax</template><template v-else>All</template>, Status = {{this.status}}</strong></p>

        </div>

        <Highcharts :options="chartOptions" />


<div class="row">

                <table style="width: 60%;" class="table-bordered table-hover table-striped">
                    <thead :style="'font-size:16px'">
                    <tr>
                        <th style="text-align: center;" class="wd-20p">TIME</th>
                        <th style="text-align: center;" class="wd-20p">TOTAL SALE</th>
                        <th style="text-align: center;" class="wd-20p">SALES QTY</th>
                        <th style="text-align: center;" class="wd-20p">Customers</th>

                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in sales">

                        <td>{{moment(tr.t).format('dddd')}}  {{moment(tr.t).format('DD/MM/YYYY')}}</td>
                        <td>{{ parseFloat((tr.grand).toFixed(1)).toLocaleString() }}</td>
                        <td>{{ parseFloat((tr.c).toFixed(2)).toLocaleString() }}</td>
                        <td>{{tr.i | numFormat }}</td>

                    </tr>

                    </tbody>
                    <tfoot>
                    <td class="text-right"><strong>SUMMARY : </strong></td>
                    <td><strong>{{parseFloat((totals.tgrand).toFixed(1)).toLocaleString() }}</strong></td>
                    <td><strong>{{parseFloat((totals.tcount).toFixed(2)).toLocaleString() }}</strong></td>
                    <td><strong>{{(totals.ticount) | numFormat }}</strong></td>
                    </tfoot>
                </table>
<table style="width: 10%;"></table>
            <table  style="width: 30%;" class="table-bordered">
                <thead :style="'font-size:16px'">
                <tr>
                    <th style="text-align: center;" class="wd-20p">PERCENTAGE OF TOTAL SALES</th>

                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <tr v-for="(tr,key) in sales">
                    <td :style="'background: -webkit-gradient(linear, left top, right top, color-stop('+((parseFloat(tr.grand)/parseFloat(totals.tgrand))*100)+'%,#7cb5ec), color-stop(0%,#fff)); background: -moz-linear-gradient(left center, #7cb5ec '+((parseFloat(tr.grand)/parseFloat(totals.tgrand))*100)+'%, #fff 0%); background: -o-linear-gradient(left, #7cb5ec '+((parseFloat(tr.grand)/parseFloat(totals.tgrand))*100)+'%, #fff 0%); background: linear-gradient(to right, #7cb5ec '+((parseFloat(tr.grand)/parseFloat(totals.tgrand))*100)+'%, #fff 0%);'">{{((parseFloat(tr.grand)/parseFloat(totals.tgrand))*100).toFixed(1)}}</td>
                </tr>

                </tbody>
                <tfoot>
                <td><strong>{{totals.tper?Math.round(totals.tper):0}}</strong></td>
                </tfoot>
            </table>
</div>
    </div>
   <br>



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
table td{
    color :black !important;
   font-size :18px;

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
                fkey:-1,
                ffkey:0,
                itemalreadySearched:false,
                searcheditemsdefs:[],
                salesR:[],
                salesM: [],
                booking_no:'',
                end_date:'',
                customers:[],
                customer:'',
                mog:2,
                searchId:null,
                table_defs:[],
                tabledef:[],
                waiter_defs:[],
                waiter:[],
                day:-1,
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

                sales:[],
                restaurant_locations:[],
                restaurant:[],
                status:'All',
                page:1,
                keysss:0,
                pagelength:50,
                leng:0,
                start_date:'',
                ctype:'line',
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                lang:{
                    numericSymbols:null
                },
                chartOptions:{

                    chart: {
                        type: 'area'
                    },
                    title: {
                        text: 'WEEKDAYS SALES ANALYSIS'
                    },
                    /*subtitle: {
                        text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
                    },*/
                    xAxis: {

                        type: 'datetime',
                        showLastLabel:true,
                        labels: {
                            rotation: -45,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            },
                            formatter: function() {
                             let d=moment(this.value);
                              return d.format('DD/MM/YYYY')
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Sales (thousands)'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        formatter: function() {
                            return ' <b>' + moment(this.x).format('DD/MM/YYYY') + '</b><br><b>' + this.y + '</b>';
                        },
                        shared: true
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Sale amount',
                    data:[], pointWidth: 10,
                        dataLabels: {
                            enabled: false,
                            rotation: 0,
                            color: '#FFFFFF',
                            align: 'right',
                            format: '{point.y:.1f}', // one decimal
                            y: 10, // 10 pixels down from the top
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    }]
                }
            }
        },
        computed: {
            totals() {
                let  x=this.sales;

                let tgrand=0;
                let tcount=0;
                let ticount=0;
                let tper=0;

                x.forEach(function (item) {

                    tgrand=tgrand + parseFloat(item.grand?item.grand:0);
                    tcount=tcount + parseFloat(item.c?item.c:0);
                    ticount=ticount + parseFloat(item.i?item.i:0);
                    tper =tper+parseFloat(item.grand?item.grand:0);
                })
                return {
                    tgrand:tgrand,
                    tcount:tcount,
                    ticount:ticount,
                    tper:((tper)/tgrand)*100,
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
            amIOnline(e) {
                this.onLine = e;
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
                }  if(this.start_date){
                    x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
                }  if(this.end_date){
                    x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
                }if(this.getRe){
                    x+='&r='+1;
                }
                    x+='&day='+this.day;
                /*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
                this.$http.get('/finance-and-management/reports/weekdays-graphical-sales/weekdayssales_init_vue?1=1'+x).then(result=>{
                    let data=result.data;
                    this.restaurant_locations=data.restaurant_locations;
                    this.table_defs=data.table_defs;
                    this.waiter_defs=data.waiter_defs;
                    this.chartOptions.series[0].data=data.salesChart;
                    this.chartOptions.chart.type=this.ctype;
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
            // this.init();
        }
    }
</script>

