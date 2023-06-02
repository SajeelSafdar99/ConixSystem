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

            <div class="col-lg">
                <div class="row mb-2">

                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
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
                </div><div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input type="radio" name="mog" v-model="mog" value="2"><span class="pabs">Ledger</span>
                    </label>
                </div>
                    <!-- <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                         <label class="rdiobox">
                             <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Employee</span>
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
                    <p style="color: black;">&nbsp</p>
                    <button type="button" class="btn btn-success" v-on:click="init">Search</button>

                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-sm-12">
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Credit: {{totals.credit | numFormat }}
                    </button>
                </div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Debit: {{totals.debit | numFormat }}
                    </button>
                </div>
                <div>
                    <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Balance: {{totals.debit -totals.credit | numFormat }}
                    </button>
                </div>
            </div>
        </div>

        <div class="scrollclasstable1">

            <div>


                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-15p">TYPE</th>
                        <th class="wd-10p">TOTAL INVOICES</th>
                        <th class="wd-20p">NAME</th>
                        <th class="wd-10p">M/G/E TYPE</th>
                        <th class="wd-15p">DETAILS</th>
                        <th class="wd-15p">DEBIT</th>
                        <th class="wd-15p">CREDIT</th>
                        <th class="wd-15p">BALANCE</th>

                    </tr>
                    </thead>
                    <thead>
                    <tr style="background-color: #55bff9 !important;">
                        <td colspan="8" class="text-right"><STRONG>OPENING BALANCE: </STRONG></td>

                        <td colspan="2"  class="text-left balance"><STRONG>{{opening | numFormat }}</STRONG></td>
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

                        <td>{{tr.type_name}}</td>

                            <td>{{tr.totalinvoices}}</td>

                        <td>{{tr.name}}</td>

                        <template v-if="tr.type==1">
                            <td><span class="">Guest</span></td>
                        </template>
                        <template v-else-if="tr.type==0">
                            <td><span class="">Member</span></td>
                        </template>    <template v-else-if="tr.type==3">
                        <td><span class="">Employee</span></td>
                    </template>
                        <template v-else>
                            <td></td>
                        </template>



                        <template v-if="tr.detail_night && tr.detail_night!=0">
                            <td>{{tr.detail_night}} (No. of Nights)</td>
                        </template>
                        <template v-else-if="tr.detail_cover && tr.detail_cover!=0">
                            <td>{{tr.detail_cover}} (Covers)</td>
                        </template>
                        <template v-else-if="tr.detail_guest && tr.detail_guest!=0">
                            <td>{{parseInt(tr.detail_guest?tr.detail_guest:0)+parseInt(tr.detail_ext_guest?tr.detail_ext_guest:0)}} (Guests)</td>
                        </template>
                        <template v-else-if="tr.detail_days && tr.detail_days!=0">
                            <td>{{tr.detail_days}} (Days)</td>
                        </template>
                        <template v-else-if="tr.detail_total && tr.detail_total!=0">
                            <td>{{tr.detail_total}} (Charges)</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>



                            <td class="text-success" style="font-weight: bold">{{tr.debit = parseInt(tr.debitamt) | numFormat }}</td>
                            <td class="text-danger" style="font-weight: bold">{{tr.credit = parseInt(tr.creditamt) | numFormat }}</td>

                        <td>{{key==0?tr.b=tr.debit-tr.credit+parseInt(opening):tr.b=(cm[key-1].b)+(tr.debit-tr.credit) | numFormat }}</td>


                    </tr>

                    </tbody>

                </table>

                <ul class="pagination hidden-print">
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


        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.ledgers);

            let credit=0;
            let debit=0;
            //console.log(1);
            x.forEach(function (item) {
                credit=credit+parseInt(item.creditamt?item.creditamt:0)
                debit=debit+parseInt(item.debitamt?item.debitamt:0)
            })
            return {
                credit:credit,
                debit:debit,
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


                this.$http.get('/finance-and-management/reports/member-activities/activities_init_vue?start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&end_date='+(this.end_date?moment(this.end_date).format('YYYY-MM-DD'):'')+'&filter='+this.filter+'&moc='+this.mog+'&mocid='+this.searchId).then(result=>{
                    let data=result.data;

                    this.filters=data.filters;
                    this.ledgers=data.ledgers;
                    this.opening=data.opening.opening?data.opening.opening:0;
                    this.ledgersR=data.ledgers;
                    this.leng=data.ledgers.length;
                    this.pagelength=this.leng
                })
            }
            else{
                this.$snotify.error('Please select a member|customer!')
            }
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
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;

                    }
                    else if (v == 2) {

                        this.customer = data.person_name;


                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;

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

    },
    mounted() {
        if(this.sdata){
            this.start_date=this.sdata.start_date
            this.end_date=this.sdata.end_date
            this.mog=this.sdata.mog
            this.searchId=this.sdata.searchId
            this.filter=this.sdata.filter
            this.init();

            // this.init(id.id);

        }
        else{
            //         this.init();

        }

    }
}
</script>

