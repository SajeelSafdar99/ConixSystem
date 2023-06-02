<template>
    <div>
        <vue-snotify></vue-snotify>
<!--        <div  v-if="!sdata"  class="hidden-print">
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


        <div v-if="!sdata" class="row  hidden-print">

            <div class="col-lg-4">
                <div class="row mb-2">

                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
                    </label>
                </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="6"><span class="pabs">Corporate Mem</span>
                        </label>
                    </div>
                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                        </label>
                    </div><div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Employee</span>
                        </label>
                    </div>
                  <!--  <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="2"><span class="pabs">Supplier</span>
                        </label>
                    </div>-->

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
            <div class="col-lg">
                <div>
                    <p style="color: black;">ENT:</p>
                    <select v-model="ent"  class="form-control">
                        <option v-for="s in ['Include ENT and CTS','Exclude ENT and CTS','Only ENT','Only CTS', 'Include Discount and Advance']">{{s}}</option>
                    </select>
                </div>
            </div>
            
            <div class="col-xs">
                <div>
                    <p style="color: black;">&nbsp</p>
                    <button type="button" class="btn btn-success" v-on:click="init">Search</button>

                </div>
            </div>


        </div>
<!--        <div v-if="!sdata" class="row  hidden-print">
            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Company" v-model="company" :multiple="true" :options="(()=>{let x=[];
            companies.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>

            </div>

            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose Department" v-model="department" :multiple="true" :options="(()=>{
                let x=[];
                departments.filter((a)=>{
                    if(company.length>0){
                        return pluck(company,'id').indexOf(parseInt(a.company))!=-1
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

                        return pluck(company,'id').indexOf(parseInt(a.company))!=-1
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

                <input value="" autocomplete="off" class="form-control" type="text"
                       id="designation" v-model="designation"
                       name="designation" placeholder="Search by Designation">
            </div>
        </div>-->
<!--       <div v-if="!sdata"><br></div>

        <div class="row">
            <div class="col-sm-12">
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Debit: {{totals.credit | numFormat }}
                </button>
            </div>
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Credit: {{totals.debit | numFormat }}
                </button>
            </div>
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Balance: {{totals.credit -totals.debit | numFormat }}
                </button>
            </div>
            </div>

        </div>-->
        <br>
        <div style="color: black;" class="print-only"><strong>Name : {{this.customer}}</strong></div>

        <div style="color: black;" class="print-only">
            
            <strong v-if="this.mog == 0">Membership ID : {{this.mem_id}}</strong>
            <strong v-else-if="this.mog == 1">Customer ID : {{this.customer_id}}</strong>
            <strong v-else-if="this.mog == 2">Customer : {{this.customer}}</strong>
            <strong v-else-if="this.mog == 3">Employee ID : {{this.employee_id}}</strong>
            <strong v-else-if="this.mog == 6">Membership ID : {{this.mem_id}}</strong>
            
        </div>
        
        <div style="color: black;" class="print-only" v-show="this.start_date"><strong>Start Date : {{this.start_date | moment("DD/MM/YYYY")}}</strong></div>
        <div style="color: black;" class="print-only" v-show="this.end_date"><strong>End Date : {{this.end_date | moment("DD/MM/YYYY")}}</strong></div>
        <br>
        <!-- <div style="text-align: center; color: black;" class="print-only">
            <p><strong>(<span v-show="this.start_date"> Date = Between {{this.start_date | moment("DD/MM/YYYY")}}</span><span v-show="this.end_date"> To {{this.end_date | moment("DD/MM/YYYY")}},</span> <span v-show="this.filter"> Filter = {{this.filter}},</span> <span v-show="this.ent"> ENT = {{this.ent}} )</span></strong></p>

        </div> -->
        <div class="scrollclasstable1">

            <div>

                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">SR #</th>
                        <th class="wd-15p">DATE</th>
                        <!-- <th class="wd-15p">TYPE</th> -->
                        <th class="wd-10p">ID</th>
                        <!-- <th class="wd-20p">NAME</th> -->
                        <!-- <th class="wd-10p">M / G TYPE</th> -->
                        <!-- <th class="wd-20p">UNIT</th> -->
                        <th class="wd-20p">ACCOUNT</th>
                        <th class="wd-25p">DETAILS</th>
                        <th class="wd-10p">DEBIT</th>
                        <th class="wd-10p">CREDIT</th>
                        <th class="wd-10p">BALANCE</th>
                    </tr>
                    </thead>
                    <thead>
                    <tr style="background-color: #55bff9 !important;">
                        <td colspan="7" class="text-right"><STRONG>OPENING BALANCE: </STRONG></td>

                        <td colspan="1"  class="text-left balance"><STRONG>{{opening | numFormat }}</STRONG></td>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">


                    <tr v-for="(tr,key) in

               cm = sliceP(
                     (()=>{
                      let  x=filterData(ledgers);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{ ((page-1)*pagelength)+(key+1)}}</td>
                        <td>{{moment(tr.date).format('DD/MM/YYYY')}}</td>

                        <!-- <td>{{tr.type_name}}</td> -->

                       <!-- <template v-if="tr.debit_or_credit==1">
                            <td>{{tr.trans_type_id}}</td>
                        </template>
                        <template v-else-if="tr.debit_or_credit==0">-->
                            <td>{{tr.mainid}}</td>
                      <!--  </template>
                        <template v-else>
                            <td></td>
                        </template>-->

                        <!-- <template v-if="tr.type==1 || tr.type==0">
                           <td>{{tr.name}}</td>
                        </template>
                        <template  v-else-if="tr.type==3">
                                <td>{{tr.name}} ({{tr.company}} - {{tr.designation}})</td>
                            </template>
                        <template  v-else-if="tr.type==6">
                            <td>{{tr.cname}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template> -->

                        <!-- <template v-if="tr.type==1">
                            <td><span class="">(Guest)</span></td>
                        </template>
                        <template v-else-if="tr.type==0">
                            <td><span class="">(Member)</span></td>
                        </template>
                        <template v-else-if="tr.type==6">
                            <td><span class="">(Corporate Member)</span></td>
                        </template>
                        <template v-else-if="tr.type==3">
                            <td><span class="">(Employee)</span></td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <td>{{tr.unit}} - <template v-if="tr.unit">{{units.filter(function(a){return a.code==tr.unit})[0].name}}</template></td> -->
                        <td>{{tr.account}} {{tr.account?coaaccounts.filter(function(a){return a.code==tr.account})[0].name:''}}</td>

                        <td>{{tr.receipt_id?tr.receipt_id:tr.trans_type_id}} - {{tr.type_name}} - (<template v-if="tr.debit_or_credit==1">Invoice</template><template v-else-if="tr.debit_or_credit==0">Receipt</template><template v-else>None</template>)</td>

                        <template v-if="tr.debit_or_credit==1">
                            <td class="text-danger" style="font-weight: bold">{{tr.credit = parseInt(tr.trans_amount) | numFormat }}</td>
                            <td>{{tr.debit =0}}</td>

                        </template>
                        <template v-else-if="tr.debit_or_credit==0">
                            <td>{{tr.credit =0}}</td>
                            <td class="text-success" style="font-weight: bold">{{tr.debit = parseInt(tr.trans_amount) | numFormat }}</td>

                        </template>
                        <template v-else>
                            <td>{{tr.credit =0}}</td>
                            <td>{{tr.debit =0}}</td>

                        </template>

                        <td>{{key==0?tr.b=tr.debit-tr.credit+parseInt(opening):tr.b=(cm[key-1].b)+(tr.debit-tr.credit) | numFormat }}</td>


                       </tr>
                    <tr>
                        <td style="background-color: #1d91e2 !important" colspan="5" class="text-right"><strong>TOTAL : </strong></td>
                        <td style="background-color: #1d91e2 !important"><strong>{{(totals.debit) | numFormat }}</strong></td>
                        <td style="background-color: #1d91e2 !important"><strong>{{(totals.credit) | numFormat }}</strong></td>
                        <td style="background-color: #1d91e2 !important"><strong>{{(totals.credit - totals.debit) | numFormat }}</strong></td>
                    </tr>
                    </tbody>




                </table>
                <span class="no-print">
                <ul class="pagination">
                    <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                    <li>
                        <select  v-model="pagelength" class="">
                            <option value="30" >30</option>
                            <option value="50" >50</option>
                            <option value="100" >100</option>
                            <option value="150" >150</option>
                            <option :value="ledgers.length" >ALL</option>
                        </select>
                    </li>  </ul>
                </span>

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
    name: "ledgersdt",
    props: ['sdata'],
    components: {
        Datepicker
    },
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            filters:[],
            ent:'Include ENT and CTS',
            filter:'0',
            booking_no:'',
            receipt_no:'',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            ledgers:[],
            ledgersR:[],
            ledgersM: [],
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
            mog:0,
            opening:0,
            fkey:-1,
            ffkey:0,
            departments:[],
            companies:[],
            subdepartments:[],
            company:[],
            department:[],
            subdepartment:[],
            designation:'',
            units:[],
            coaaccounts:[],
        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.ledgers);

            let credit=0;
            let debit=0;
            //console.log(1);
            x.forEach(function (item) {

             if(item.debit_or_credit==1){
                 credit=credit+item.trans_amount
             }else{
                 debit=debit+item.trans_amount
             }

            })
            return {
                debit:credit,
                credit:debit,
            }
        }
    },
    methods:{
        fup(){

        },fdown(){
            // console.log(1)

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
        filterData(ledgers){
            let   x=ledgers;




            if (this.searchId){
                //    x=x.filter((a)=>{return a.trans_moc==this.searchId});
            }
            if(this.mog!=5) {

                x=x.filter((a)=>{

                    return  a.type==this.mog;
                });
            }

         /*   else{
                x=x;
            }*/
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(ledgers){
            // console.log(123);
            this.ledgersM=ledgers;
            return  ledgers.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {
            if(this.searchId){
                this.$http.get('/finance-and-management/member-guest-ledgers/legders_init_vue?start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&end_date='+(this.end_date?moment(this.end_date).format('YYYY-MM-DD'):'')+'&filter='+this.filter+'&moc='+this.mog+'&mocid='+this.searchId+'&ent='+this.ent).then(result=>{
                    let data=result.data;

                    this.filters=data.filters;
                    this.ledgers=data.ledgers;
                    this.opening=data.opening.opening?data.opening.opening:0;
                    this.ledgersR=data.ledgers;
                    this.leng=data.ledgers.length;
                    this.pagelength=this.leng;
                    this.companies=data.companies;
                    this.departments=data.departments;
                    this.subdepartments=data.subdepartments;
                    this.coaaccounts=data.coaaccounts;
                    this.units=data.units;
                })
            }
            else{
                this.$snotify.error('Please select a member | guest!')
            }
/*
            let x='';
          if(this.filter){

                x+='&filter='+this.filter;
            } if(this.mog){

                x+='&moc='+this.mog;
            } if(this.searchid){
                    x += '&mocid=' + this.searchid;
            }
            if(this.company){
                x+='&company='+this.pluck(this.company,'id').join(',');
            }
            if(this.department){
                x+='&department='+this.pluck(this.department,'id').join(',');
            }
            if(this.subdepartment){
                x+='&subdepartment='+this.pluck(this.subdepartment,'id').join(',');
            }


            if(this.start_date){
                x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }  if(this.end_date){
                x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
            }
            this.$http.get('/finance-and-management/member-guest-ledgers/legders_init_vue?1=1'+x).then(result=>{
                let data=result.data;

                this.filters=data.filters;
                this.ledgers=data.ledgers;
                this.opening=data.opening.opening?data.opening.opening:0;
                this.ledgersR=data.ledgers;
                this.leng=data.ledgers.length;
                this.pagelength=this.leng;
                this.companies=data.companies;
                this.departments=data.departments;
                this.subdepartments=data.subdepartments;

            })*/
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
                    data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ (a.hrcompany?a.hrcompany.name:'') + ' '+ '-' + ' ' + a.designation +')'})
                }
                else if(v==2){
                    data.filter((a)=>{a.name=a.person_name + ' ' + a.id})
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
                    else if (v == 6) {
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
                    else if (v == 2) {
                        this.customer = data.person_name;
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
                this.ledgers[k].p=e.target.max;
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
        ledgersM:function(){
            // console.log(1);
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
        document.addEventListener('keydown', (event)=> {
            if (event.key === 'Enter') {
                if(this.searchId){
                    this.init();
                    event.preventDefault();
                }

            }
        });
        if(this.sdata){
            this.start_date=this.sdata.start_date
            this.end_date=this.sdata.end_date
            this.mog=this.sdata.mog
            this.searchId=this.sdata.searchId
            this.filter=this.sdata.filter
            this.ent=this.sdata.ent
            this.init();

            // this.init(id.id);

        }
        else{
   //         this.init();

        }


        if(window.location.search){
            window.print();
        }
        let uri = window.location.search.split("?");
        //  let params = new URLSearchParams(uri);
        /*console.log(uri);*/

        let partone = uri[1].split("=");
        let parttwo = uri[2].split("=");
        let partthree = uri[3].split("=");
        let partfour = uri[4].split("=");
        let partfive = uri[5].split("=");
        let partsix = uri[6].split("=");
        /*console.log(partone);*/

        if(partone[1]){
            this.start_date=partone[1];
        }

        if(parttwo[1]){
            this.end_date=parttwo[1];
        }

        if(partthree[1]){
            this.mog=partthree[1];
        }

        if(partfour[1]){
            this.searchId=partfour[1];
        }

        if(partfive[1]){
            this.filter=partfive[1];
        }

        if(partsix[1]){
             if(partsix[1]=='Include%20ENT%20and%20CTS'){
                 partsix[1]='Include ENT and CTS'
             }
            if(partsix[1]=='Exclude%20ENT%20and%20CTS'){
                partsix[1]='Exclude ENT and CTS'
            }
            if(partsix[1]=='Only%20ENT'){
                partsix[1]='Only ENT'
            }
            if(partsix[1]=='Only%20CTS'){
                partsix[1]='Only CTS'
            }
            if(partsix[1]=='Include%20Discount%20and%20Advance'){
                partsix[1]='Include Discount and Advance'
            }

            this.ent=partsix[1]
        }
        this.init();
 }

}
</script>

