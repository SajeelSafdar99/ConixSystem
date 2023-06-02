<template>
    <div>
        <vue-snotify></vue-snotify>


        <!-- <div class="row hidden-print">
             <div class="col-lg">
             <p style="color: black;">Restaurant:</p>
                 <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="restaurant" :multiple="true" :options="(()=>{let x=[];
                 restaurant_locations.forEach((a)=>{
                     x.push({name:a.desc,id:a.id})
                 })
                 return x;
                 })()"></multiselect>
           &lt;!&ndash;  <select class="form-control " v-model="restaurant" name="restaurant[]" id="restaurant" multiple="multiple">
                 <option v-for="restaurant in restaurant_locations" :value="restaurant.id">
                     {{restaurant.desc}}
                 </option>
             </select>&ndash;&gt;

         </div>

             <div class="col-lg">
                 <p style="color: black;">Table #:</p>
                 <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="tabledef" :multiple="true" :options="(()=>{let x=[];
                 table_defs.forEach((a)=>{
                     x.push({name:a.desc,id:a.id})
                 })
                 return x;
                 })()"></multiselect>
                &lt;!&ndash; <select class="form-control" v-model="tabledef" name="tabledef[]" id="tabledef" multiple="multiple">
                     <option v-for="table in table_defs" :value="table.id">
                         {{table.desc}}
                     </option>
                 </select>&ndash;&gt;

             </div>

             <div class="col-lg">
                 <p style="color: black;">Waiter:</p>
                 <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="waiter" :multiple="true" :options="(()=>{let x=[];
                 waiter_defs.forEach((a)=>{
                     x.push({name:a.name,id:a.id})
                 })
                 return x;
                 })()"></multiselect>
                &lt;!&ndash; <select class="form-control" v-model="waiter" name="waiter[]" id="waiter" multiple="multiple">
                     <option v-for="wait in waiter_defs" :value="wait.id">
                         {{wait.name}}
                     </option>
                 </select>&ndash;&gt;

             </div>      <div class="col-lg">
                 <p style="color: black;">Category:</p>
                 <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="cate" :multiple="true" :options="(()=>{let x=[];
                 categories.forEach((a)=>{
                     x.push({name:a.desc,id:a.id})
                 })
                 return x;
                 })()"></multiselect>
                &lt;!&ndash; <select class="form-control" v-model="waiter" name="waiter[]" id="waiter" multiple="multiple">
                     <option v-for="wait in waiter_defs" :value="wait.id">
                         {{wait.name}}
                     </option>
                 </select>&ndash;&gt;

             </div>      <div class="col-lg">
                 <p style="color: black;">Sub Category:</p>
                 <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="sub_cat" :multiple="true" :options="(()=>{let x=[];
                 subcategories.forEach((a)=>{
                     x.push({name:a.desc,id:a.id})
                 })
                 return x;
                 })()"></multiselect>
                &lt;!&ndash; <select class="form-control" v-model="waiter" name="waiter[]" id="waiter" multiple="multiple">
                     <option v-for="wait in waiter_defs" :value="wait.id">
                         {{wait.name}}
                     </option>
                 </select>&ndash;&gt;

             </div>      <div class="col-lg">
                 <p style="color: black;">Cashier:</p>
                 <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="cashier" :multiple="true" :options="(()=>{let x=[];
                 users.forEach((a)=>{
                     x.push({name:a.name,id:a.id})
                 })
                 return x;
                 })()"></multiselect>
                &lt;!&ndash; <select class="form-control" v-model="waiter" name="waiter[]" id="waiter" multiple="multiple">
                     <option v-for="wait in waiter_defs" :value="wait.id">
                         {{wait.name}}
                     </option>
                 </select>&ndash;&gt;

             </div>
         </div>
     <br>
         <div class="row hidden-print">

             <div class="col-lg">
             <div class="row mb-2">

                 <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                     <label class="rdiobox">
                         <input  type="radio"  name="mog" v-model="mog" value="2"><span class="pabs">All</span>
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
                 <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                     <label class="rdiobox">
                         <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Employee</span>
                     </label>
                 </div>
             </div>
                 <input type="text" class="form-control" id="customer" v-model="customer" name="customer" autocomplete="off" placeholder="Search By Name..." value="">

                 <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                     list-style-type: none;color: black;" v-if="customers.length>0">

                     <li @click="customerdatavalue(c.id)" v-for="c in customers">
                         {{c.name}}
                     </li>
                 </ul>

             </div>



             <div class="col-lg">
                     <p style="color: black;">Item Code:</p>
                     <input value="" class="form-control tablikebutton"  size="20" type="number"
                            id="booking_no" v-model="booking_no"
                            name="booking_no" placeholder="Search Id...">
             </div>
             <div class="col-lg">
                 <div>
                     <p style="color: black;">Begin Date:</p>
                     <datepicker v-model="start_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

                 </div>
             </div>
             <div class="col-lg">
                 <div>
                     <p style="color: black;">End Date:</p>
                     <datepicker v-model="end_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
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
             <div class="col-lg">
                 <div>

                    <button type="button" @click="init" class="btn btn-success">Search</button>
                 </div>
             </div>


         </div>
         <br>
     -->
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
                                <datepicker  :disabledDates="disabledDates" v-model="end_date" placeholder="To (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
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
                            <label class="col-sm-2 form-control-label">ORDER TYPE:</label>
                            <div class="col-sm-10">
                                <multiselect track-by="name" label="name" placeholder="Choose Options" v-model="order_type" :multiple="true" :options="(()=>{let x=[];
            ['Dine-In','Take Away','Home Delivery'].forEach((a)=>{
                x.push({name:a})
            })
            return x;
            })()"></multiselect>
                            </div>
                        </div>

                       <!-- <div class="row">
                            <label class="col-sm-2 form-control-label">STATUS:</label>
                            <div class="col-sm-10">
                                <select v-model="status"  class="form-control">
                                    <option v-for="s in ['All','Advance','Paid','Unpaid']">{{s}}</option>
                                </select>
                            </div>
                        </div>-->
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
                name    = "DailyCashierSales.xls">
            </export-excel>
</div>
            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>AFOHS <br>DAILY SALES LIST (CASHIER-WISE) </h5>
            </div>
            <div style="text-align: center; color: black;">
                <p><strong>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Name = {{this.customer}}, Restaurant = {{this.pluck(this.restaurant,'name')}}, Table # = {{this.pluck(this.tabledef,'name')}}, Waiter = {{this.pluck(this.waiter,'name')}}, Cashier = {{this.pluck(this.cashier,'name')}}, Discounted/Taxed = <template v-if="this.specific==1">Discount</template><template v-else-if="this.specific==2">Tax</template><template v-else>All</template>, Order Type = {{this.pluck(this.order_type,'name')}}</strong></p>

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

                                <tr style="border-bottom: 2px solid black;" class="head" v-if="(key==0)">

                                    <td colspan="2"><STRONG>CASHIER NAME</STRONG></td>
                                    <td><STRONG>SALE</STRONG></td>
                                    <td><STRONG>DISC.</STRONG></td>
                                    <td><STRONG>S.TAX AMT</STRONG></td>
                                    <td><STRONG>Cash</STRONG></td>
                                    <td><STRONG>Credit</STRONG></td>

                                    <td><STRONG>Paid</STRONG></td>
                                    <td><STRONG>Unpaid</STRONG></td>
                                    <td><STRONG>TOTAL</STRONG></td>
                                </tr>
                                <tr v-if="(key==0)">
                                    <td colspan="2">&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                </tr>


                               <tr >
                                   <td colspan="2">{{s.name }}</td>
                                    <td>{{s.grosssale | numFormat }}</td>
                                    <td>{{ parseFloat((s.diss).toFixed(1)).toLocaleString() }}</td>
                                   <td>{{s.taxx | numFormat }}</td>
                                   <td>{{s.cashgross | numFormat }}</td>
                                   <td>{{s.creditgross | numFormat }}</td>
                                    <td><strong >{{ (s.paid_amount?s.paid_amount:0).toLocaleString() }}</strong></td>
                                   <td><strong >{{ parseFloat((s.grandd-s.paid_amount).toFixed(1)).toLocaleString() }}</strong></td>
                                   <td><strong >{{ parseFloat((s.grandd).toFixed(1)).toLocaleString() }}</strong></td>
                               </tr>

                                <tr v-if="sales[key+1]==undefined || sales[key+1].cat!=s.cat">
                                    <td colspan="2">&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                </tr>

                            </template>
                          <tr style="border-top: 2px solid black; border-bottom: 2px solid black;">
                                <td colspan="2"><STRONG>GRAND TOTAL:</STRONG></td>
                              <td><STRONG>{{aa | numFormat }}</STRONG></td>
                                <td><STRONG>{{parseFloat((bb).toFixed(1)).toLocaleString() }}</STRONG></td>
                                <td><STRONG>{{dd | numFormat }}</STRONG></td>
                              <td><STRONG>{{parseFloat((ii).toFixed(1)).toLocaleString() }}</STRONG></td>
                              <td><STRONG>{{parseFloat((jj).toFixed(1)).toLocaleString() }}</STRONG></td>
                              <td><STRONG>{{parseFloat((ff).toFixed(1)).toLocaleString() }}</STRONG></td>
                              <td><STRONG>{{parseFloat((gg).toFixed(1)).toLocaleString() }}</STRONG></td>
                              <td><STRONG>{{parseFloat((ee).toFixed(1)).toLocaleString() }}</STRONG></td>

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
            order_type:[],
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
            aa:0,
            bb:0,
            cc:0,
            dd:0,
            ee:0,
            ff:0,
            gg:0,
            hh:0,
            ii:0,
            jj:0,
            stdics:0,
            ssubtt:0,
            json_data: [],
            fkey:-1,
            ffkey:0,
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
        sliceP(sales){
            // console.log(123);
            this.salesM=sales;
            this.json_data=this.salesM;
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
            }
            if(this.order_type){
                x+='&order_type='+this.pluck(this.order_type, 'name').join(',');
            }
            if(this.mem_id_){

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
            }  if(this.start_date){
                x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }  if(this.end_date){
                x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
            }if(this.getRe){
                x+='&r='+1;
            }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
            this.$http.get('/finance-and-management/reports/daily-cashier-sales-list/cashiersales_init_vue?1=1'+x).then(result=>{
                let data=result.data;
                if(!data.sales){
                    data.sales=[];
                }
                this.restaurant_locations=data.restaurant_locations;
                this.table_defs=data.table_defs;
                this.waiter_defs=data.waiter_defs;

                if(this.getRe){

                    let aa=0;
                    let bb=0;
                    let dd=0;
                    let ee=0;
                    let ff=0;
                    let gg=0;
                    let ii=0;
                    let jj=0;

                    let x=data.sales;
                    //console.log(1);
                    x.forEach(function (s,key) {
                        ii=ii+parseInt(s.cashgross);
                        jj=jj+parseInt(s.creditgross);
                        aa=aa+parseInt(s.grosssale);
                        bb=bb+parseFloat(s.diss);
                        dd=dd+(parseInt(s.taxx));
                        ee=ee+(parseFloat(s.grandd));
                        ff=ff+(parseFloat(s.paid_amount));
                        gg=gg+(parseFloat(s.grandd)-parseFloat(s.paid_amount) );
                    })
                    this.aa=aa
                    this.bb=bb
                    this.dd=dd
                    this.ee=ee
                    this.ff=ff
                    this.gg=gg
                    this.ii=ii
                    this.jj=jj
                }
                this.sales=data.sales;
                this.salesR=data.sales;
                this.leng=data.sales.length;
                this.getRe=true;
                this.categories=data.category;
                this.subcategories=data.sub_category;
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

