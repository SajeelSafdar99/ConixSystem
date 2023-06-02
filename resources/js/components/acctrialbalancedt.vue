<template>
    <div>
        <vue-snotify></vue-snotify>

<!--        <v-offline
            online-class="online"
            offline-class="offline"
            @detected-condition="amIOnline">
            <template v-slot:[onlineSlot] :slot-name="onlineSlot">
                ( Online: {{ onLine }} )
            </template>
            <template v-slot:[offlineSlot] :slot-name="offlineSlot">
                ( Online: {{ onLine }} )
            </template>
        </v-offline>-->

            <div class="printme" v-if="showModal ">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title">ACCOUNTS LEDGER:
                                            <a target="_blank" :href="'/finance-and-management/accounts-ledgers-vue'+'?'+'start_date=' + this.ssdata.start_date+'?'+'end_date=' + this.ssdata.end_date+'?'+'mog=' + this.ssdata.mog+'?'+'searchId=' + this.ssdata.searchId+'?'+'filter=' + this.ssdata.filter+'?'+'pm=' + this.ssdata.pm+'?'+'unitsearch=' + this.ssdata.unitsearch+'?'+'account=' + this.ssdata.account+'?'+'ent=' + this.ssdata.ent">  <button type="button" title="Print"
                                                                                                                                                                                                                                                                                       class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button></a>
                                        </h5>


                                        <button type="button" class="close" @click="showModal=false">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <accledgerdt :sdata="ssdata" v-if="ssdata" :key="'am'+k"></accledgerdt>
                                    </div>
                                    <div class="modal-footer hidden-print">
                                        <button type="button" class="btn btn-secondary" @click="showModal=false">CLOSE</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>




        <div class="row  hidden-print">

            <div class="col-lg-4">
                <div class="row ">

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="5"><span class="pabs">All</span>
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
                    </div>   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Emp</span>
                        </label>
                    </div>
                   <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="2"><span class="pabs">Supplier</span>
                        </label>
                    </div>
                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="4"><span class="pabs">COA</span>
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
                <div>
                    <p style="color: black;">Begin Date:</p>
                    <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">End Date:</p>
                   <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>


            <div class="col-lg">
                <div>
                    <p style="color: black;">Filters:</p>
                    <select class="form-control" v-model="filter" name="filter" id="filter">
                        <option value="0">All</option>
                        <option v-for="f in filters" :value="f.id">
                            {{f.name}}
                        </option>
                    </select>

                </div>
            </div>



        </div>
        <div class="row hidden-print">
            <div class="col-lg">
                <div>
                    <p style="color: black;">Payment Methods:</p>
                    <select class="form-control" v-model="pm" name="pm" id="pm">
                        <option value="0">All</option>
                        <option v-for="f in pms" :value="f.id">
                            {{f.name}}
                        </option>
                    </select>

                </div>
            </div>

            <div class="col-lg">
                <p style="color: black;">Unit:</p>
                <div class="form-group has-search"  v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">
                    <input  type="text" class="form-control typeahead" autocomplete="off" v-model="unitsearch"     name="unitsearch" placeholder="Search Unit...">
                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="unitsearchid"     name="unitsearchid" placeholder="Search by Unit...">
                    <ul id="areabox4" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.unitsearch && searchedunits.length>0">

                        <li class="fbb" :class="'ccs'+key" @click="unitdatavalue(itd.id)" v-for="(itd,key) in searchedunits">
                            <a href="javascript:void(0)">{{itd.code}} - {{itd.name}} (<template v-if="ccs.filter(function(a){return a.code==itd.desc})[0]">{{ccs.filter(function(a){return a.code==itd.desc})[0].name}}</template>)</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg">
                <div>
                    <p style="color: black;">ENT:</p>
                    <select v-model="ent"  class="form-control">
                        <option v-for="s in ['Include ENT and CTS','Exclude ENT and CTS','Only ENT','Only CTS']">{{s}}</option>
                    </select>
                </div>
            </div>
            <div class="col-xs">
                <div>
                    <p style="color: black;">&nbsp</p>
                    <button type="button" v-on:click="init" class="btn btn-success">Search</button>

                </div>
            </div>
    </div>

        <div v-if="this.mog==3" class="row  hidden-print">
                    <div class="col-lg">
                        <multiselect track-by="name" label="name" placeholder="Choose Company" v-model="company" :multiple="true" :options="(()=>{let x=[];
                    companies.forEach((a)=>{
                        x.push({name:a.name,id:a.code})
                    })
                    return x;
                    })()"></multiselect>

                    </div>

                    <div class="col-lg">
                        <multiselect track-by="name" label="name" placeholder="Choose Department" v-model="department" :multiple="true" :options="(()=>{
                        let x=[];
                        departments.filter((a)=>{
                            if(company.length>0){
                                return pluck(company,'id').indexOf((a.company))!=-1
                            } else{
                                return true;
                            } } ).forEach((a)=>{
                                x.push({name:a.desc,id:a.id})
                        })
                        return x;
                    })()"></multiselect>


                    </div>

                    <div class="col-lg">
                        <multiselect track-by="name" label="name" placeholder="Choose Sub-Department" v-model="subdepartment" :multiple="true" :options="(()=>{
                        let x=[];
                        subdepartments.filter((a)=>{
                            let cond=true;
                            if(company.length>0 && department.length==0){

                                return pluck(company,'id').indexOf((a.company))!=-1
                            }
                            else if(department.length>0){
                                 return pluck(department,'id').indexOf(parseInt(a.department))!=-1
                             }
                                else{
                                return true;
                            }
                            } ).forEach((a)=>{
                                x.push({name:a.desc,id:a.id})
                        })
                        return x;
                    })()"></multiselect>

                    </div>

            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Employee" v-model="employee" :multiple="true" :options="(()=>{
                        let x=[];
                        employees.filter((a)=>{
                            let cond=true;
                            if(company.length>0 && department.length==0 && subdepartment.length==0){
                                return pluck(company,'id').indexOf((a.company))!=-1
                            }
                            else if(department.length>0 && subdepartment.length==0){
                                 return pluck(department,'id').indexOf(parseInt(a.department))!=-1
                             }
                            else if(subdepartment.length>0){
                                 return pluck(subdepartment,'id').indexOf(parseInt(a.subdepartment))!=-1
                             }
                                else{
                                return true;
                            }
                            } ).forEach((a)=>{
                                x.push({name:a.name,id:a.id})
                        })
                        return x;
                    })()"></multiselect>

            </div>

<!--            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                <input  v-model="employee" name="employee" id="employee" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search Employee...">
                <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="employees.length>0 && employee!=''" >
                    <li  :class="'fbb fba'+key"  @click="empdatavalue(c.id)"  v-on:keyup.enter="empdatavalue(c.id)" v-for="(c,key) in employees">
                        <a href="javascript:void(0)">   {{c.name}}</a>
                    </li>

                </ul>
            </div>-->

            <div class="col-lg">
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="designation" name="designation" id="designation" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Designation...">


                    <ul id="areabox2" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="designations.length>0 && designation!=''" >

                        <li  :class="'fbb fba'+key"  @click="designationdatavalue(c.id)"  v-on:keyup.enter="designationdatavalue(c.id)" v-for="(c,key) in designations">
                            <a href="javascript:void(0)">   {{c.designation}}</a>
                        </li>

                    </ul>
                </div>

            </div>

<!--                    <div class="col-lg">

                        <input value="" autocomplete="off" class="form-control" type="text"
                               id="designation" v-model="designation"
                               name="designation" placeholder="Search by Designation">
                    </div>-->

                </div>

        <div class="row no-printme">
            <div class="col-sm-12">
            <div>
                <button  v-on:click="sign=1" class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Debit: {{totals.credit | numFormat }}<!--Total Advance Amount: {{totals.paid_amount | numFormat }}-->
                </button>
            </div>
            <div>
                <button v-on:click="sign=2"  class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Credit: {{totals.debit | numFormat }}<!--Total Pending Amount: {{totals.total | numFormat }}-->
                </button>
            </div>  <div>
                <button v-on:click="sign=0"  class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Balance: {{totals.credit -totals.debit | numFormat }}<!--All: {{ (totals.paid_amount -totals.total) | numFormat }}-->
                </button>
            </div>
            </div>
        </div>

        <div class="scrollclasstable1 no-printme">

            <div>


                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-40p">NAME</th>
                      <!--
                        <th class="wd-10p">TYPE</th>

                        <th class="wd-10p">COMPANY DETAILS</th>

                        <th class="wd-10p">M / G NO.</th>
                       -->
                        <th class="wd-25p">DETAILS</th>
                        <th class="wd-10p">DEBIT</th>
                        <th class="wd-10p">CREDIT</th>
                        <th class="wd-15p">BALANCE</th>
                        <th class="wd-20p hidden-print">INFO</th>

                    </tr>
                    </thead>

                    <tbody :style="'font-size:15px'">


                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(trials);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{ ((page-1)*pagelength)+(key+1)}}</td>

                        <td>{{tr.accname}} ({{tr.acccode}})</td>

                     <!--   <template v-if="tr.type==1 || tr.type==0">
                            <td>{{tr.name}}</td>
                        </template>
                        <template  v-else-if="tr.type==3">
                            <td>{{tr.name}} ({{tr.designation}})</td>
                        </template>
                        <template  v-else-if="tr.type==2">
                            <td>{{tr.name}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <template v-if="tr.type==1">
                            <td><span class="text-success">(Guest)</span></td>
                        </template>
                        <template v-else-if="tr.type==0">
                            <td><span class="text-success">(Member)</span></td>
                        </template>
                        <template  v-else-if="tr.type==3">
                            <td>(Employee)</td>
                        </template>  <template  v-else-if="tr.type==2">
                            <td>(Supplier)</td>
                        </template>

                        <template v-if="tr.type==3">
                            <td>{{tr.company?companies.filter((a)=>{return a.id==tr.company})[0].desc:''}}<br>{{tr.department?departments.filter((a)=>{return a.id==tr.department})[0].desc:''}}<br>{{tr.subdepartment?subdepartments.filter((a)=>{return a.id==tr.subdepartment})[0].desc:''}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                            <td>{{tr.no_id}}</td>-->
                        <td>{{filters.filter((a)=>{return a.id==filter}).length>0?filters.filter((a)=>{return a.id==filter})[0].name:'All'}}</td>




                            <td>{{tr.debit | numFormat }}</td>
                            <td>{{tr.credit | numFormat }}</td>


                            <td>{{ (tr.debit-tr.credit) | numFormat }}</td>


                        <td class="hidden-print"><span v-on:click="updatesdata(tr)" style="color:white;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></td>
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
                            <option :value="trials.length" >ALL</option>
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
@media print {
   /* .no-printme  {
        display: none !important;
    }
    .printme  {
        display: block !important;
    }*/
}
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#bcd3e3;
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
.modal-dialog{
    overflow-y: initial !important;
    max-width: 975px !important;
}
.modal-content{
    width: 1065px !important;
}
.modal-body{
    height: 80vh;
    overflow-y: auto;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
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
import Datepicker from 'vuejs-datepicker'
export default {
    name: "acctrialbalancedt",
    components: {
        Datepicker
    },
    data(){
        return{
            ccs:[],
            searchedunits:[],
            unitsearch:'',
            unitalreadySearched:false,
            unitsearchid:'',
            disabledDates: {
                from: new Date(),
            },
            pm:'0',
            pms:[],
            showModal: false,
            ent:'Include ENT and CTS',
            filters:[],
            filter:'0',
            page:1,
            pagelength:50,
            leng:0,
            sign:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            trials:[],
            trialsR:[],
            trialsM: [],
            invoice_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mains:[],
            charges:[],
            subscriptions:[],
            details:'0',
            invoice_Date:'',
            searchId:null,
            mog:5,
            k:0,
            ssdata:false,
            fkey:-1,
            ffkey:0,
            departments:[],
            companies:[],
            subdepartments:[],
            company:[],
            department:[],
            subdepartment:[],
            designation:'',
            designations:[],
            desId:null,
            employee:'',
            employees:[],
            empId:null,

        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.trials);

            let credit=0;
            let debit=0;
            //console.log(1);
            x.forEach(function (item) {
                credit=credit + parseInt(item.credit?item.credit:0);
                debit=debit + parseInt(item.debit?item.debit:0);
             /*   if(item.debit_or_credit==1){
                    credit=credit+item.credit
                }else{
                    debit=debit+item.debit
                }*/

            })
            return {
                credit:debit,
                debit:credit,
            }
        }
       /* totals() {
            let  x=this.filterData(this.trials);

            let total=0;
            let paid_amount=0;
            //console.log(1);
            x.forEach(function (item) {
                let xm=item.debit-item.credit;
                if(xm<0){
                    total=total+xm
                }
                else{
                    paid_amount=paid_amount+xm
                }

            })
            return {
                total:total,
                paid_amount:paid_amount,
            }
        }*/
    },
    methods:{
        unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.unitsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.unitsearch=a.name})

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
                    this.unitsearch=data.name+' '+'('+this.ccs.filter(function(s){return s.code==data.desc})[0].name+')';
                    this.unitsearchid=data.code;

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




        },udf2(event){

            if(event==0){
                if(this.ffkey!=this.searcheditemsdefs.length-1){

                    this.ffkey=this.ffkey+1
                }
                $('.ccs'+this.ffkey +' a').focus();

                // $('.fba'+this.ffkey).focus();
                // event.preventDefault()
            }if(event==1){

                if(this.ffkey!=0){

                    this.ffkey=this.ffkey-1
                }
                $('.ccs'+this.ffkey+' a').focus();

                // event.preventDefault()
            }




        },
        udf3(event){

            if(event==0){
                if(this.ffkey!=this.searchedunits.length-1){

                    this.ffkey=this.ffkey+1
                }
                $('.ccs'+this.ffkey +' a').focus();

                // $('.fba'+this.ffkey).focus();
                // event.preventDefault()
            }if(event==1){

                if(this.ffkey!=0){

                    this.ffkey=this.ffkey-1
                }
                $('.ccs'+this.ffkey+' a').focus();

                // event.preventDefault()
            }




        },
        udf4(event){

            if(event==0){
                if(this.ffkey!=this.searchedaccounts.length-1){

                    this.ffkey=this.ffkey+1
                }
                $('.ccs'+this.ffkey +' a').focus();

                // $('.fba'+this.ffkey).focus();
                // event.preventDefault()
            }if(event==1){

                if(this.ffkey!=0){

                    this.ffkey=this.ffkey-1
                }
                $('.ccs'+this.ffkey+' a').focus();

                // event.preventDefault()
            }




        },
        printWindow: function () {
            window.print();
        },
        updatesdata(d){
            this.ssdata={
                start_date:this.start_date,
                end_date:this.end_date,
                mog:this.mog,
                searchId:this.searchId,
                filter:this.filter,
                pm:this.pm,
                unitsearch:this.unitsearchid,
                ent:this.ent,
                account:d.account,
            }
            this.k=this.k+1;
            this.showModal=true;
        },
        filterData(trials){
            let   x=trials;

            if(this.company.length>0){
                x=x.filter((a)=>{return this.company.filter((m)=>{
                    return a.company==m.id;
                }).length>0});
            }
            if(this.department.length>0){
                x=x.filter((a)=>{return this.department.filter((m)=>{
                    return a.department==m.id;
                }).length>0});
            }
            if(this.subdepartment.length>0){
                x=x.filter((a)=>{return this.subdepartment.filter((m)=>{
                    return a.subdepartment==m.id;
                }).length>0});
            }
            if(this.employee.length>0){
                x=x.filter((a)=>{return this.employee.filter((m)=>{
                    return a.id==m.id;
                }).length>0});
            }
            if (this.desId){
                x=x.filter((a)=>{return a.designation==this.desId});
            }

           /* if (this.searchId){
                    x=x.filter((a)=>{return a.trans_moc==this.searchId});
            }
            if (this.empId){
                x=x.filter((a)=>{return a.trans_moc==this.empId});
            }*/
            if (this.sign!=0){
                    x=x.filter((a)=>{if(this.sign==1){
                       return a.debit-a.credit>0
                    }
                    else if(this.sign==2){
                            return a.debit-a.credit<0
                        }});
            }
           /* if(this.mog!=5) {

                x=x.filter((a)=>{
                   return  a.trans_moc_type==this.mog;
                });

            }*/

            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(trials){
            // console.log(123);
            this.trialsM=trials;
            return  trials.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/finance-and-management/accounts-trial-balance/acc_trial_init_vue?start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&end_date='+(this.end_date?moment(this.end_date).format('YYYY-MM-DD'):'')+'&filter='+this.filter+'&pm='+this.pm+'&unitsearch='+this.unitsearchid+'&ent='+this.ent+'&moc='+this.mog+'&mocid='+this.searchId).then(result=>{
                let data=result.data;
                this.ccs=data.ccs;
                this.pms=data.pms;
                this.filters=data.filters;
                this.companies=data.companies;
                this.departments=data.departments;
                this.subdepartments=data.subdepartments;
                this.employees=data.employees;
                this.trials=data.trials;
                this.trialsR=data.trials;
                this.leng=data.trials.length;
            })
        },

        customerdata(){
            let v = this.mog==2?22:this.mog;
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
                else if(v==4){
                    data.filter((a)=>{a.name=a.desc + ' ' + a.code})
                }
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ (a.hrcompany?a.hrcompany.name:'') + ' '+ '-' + ' ' + a.designation +')'})
                }
                else if(v==22){
                    data.filter((a)=>{a.name=a.person_name + ' ' + a.id})
                }
                if(data){

                    this.customers=data;

                }
            });

        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = this.mog==2?22:this.mog;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;

                if(data){
                    this.searchId
                    this.searchId=data.id;

                    if (v == 0) {
                        this.mem_id = data.mem_no;
                        this.mem_id_ = data.id;
                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.guest_contact = data.mob_a;

                    }
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;

                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;

                    }
                    else if (v == 4) {
                        this.customer = data.desc;
                    }
                    else if (v == 22) {
                        this.customer = data.person_name;
                    }

                    this.alreadySearched=true;
                }
            });
        },
        empdata(){
            this.$http.post('/search/empdatalike',{empid:this.employee,company:this.pluck(this.company,'id'),department:this.pluck(this.department,'id'),subdepartment:this.pluck(this.subdepartment,'id')}).then(result=>{
                let data =result.data;
                    data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ (a.hrcompany?a.hrcompany.name:'') + ' '+ '-' + ' ' + a.designation +')'})

                if(data){

                    this.employees=data;

                }
            });

        },
        empdatavalue(val,m){
            this.employees=[];
            this.$http.post('/search/empdata',{empid:val}).then(result=>{
                let data =result.data;

                if(data){
                        this.empId = data.id;
                        this.employee = data.name;

                    this.alreadySearched3=true;
                }
            });
        },
        designationdata(){

            this.$http.post('/search/designationdatalike',{designationid:this.designation}).then(result=>{
                let data =result.data;
                data.filter((a)=>{a.designation=a.designation})

                if(data){

                    this.designations=data;

                }
            });

        },
        designationdatavalue(val,m){
            this.designations=[];

            this.$http.post('/search/designationdata',{designationid:val}).then(result=>{
                let data =result.data;

                if(data){

                    this.desId=data.designation;

                    this.designation = data.designation;

                    this.alreadySearched2=true;
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
                this.trials[k].p=e.target.max;
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
        trialsM:function(){
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
        employee:function(){
            if(this.employee.length==0){
                this.alreadySearched3=false;
                this.empId=null
            }
            if(this.company.length!=0 && this.department.length!=0  && this.subdepartment.length!=0 && !this.alreadySearched3){
                this.empdata();
            }
        },
        designation:function(){
            if(this.designation.length==0){
                this.alreadySearched2=false;
                this.desId=null;
            }

            if(!this.alreadySearched2){
                this.designationdata();
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

        this.init();

    }
}
</script>

