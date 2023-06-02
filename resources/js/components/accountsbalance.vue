<template>
    <div>
        <vue-snotify></vue-snotify>
        <div class="hidden-print">
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

            <div v-if="showModal">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title">LEDGER ACCOUNTS:</h5>
                                        <button type="button" class="close" @click="showModal=false">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ledgersdt :sdata="ssdata" v-if="ssdata" :key="'am'+k"></ledgersdt>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" @click="showModal=false">CLOSE</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
            <br>
        </div>


        <template v-if="showFilters">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div class="form-layout form-layout-4 blackcolor headingsetting hidden-print">
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 1:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="one" name="one" id="one">
                                    <option value="0">All</option>
                                    <option v-for="one in ones" :value="one.id">
                                        {{one.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 2:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="two" name="two" id="two">
                                    <option value="0">All</option>
                                    <option v-for="two in twos.filter((a)=>{return a.level_one==this.one})" :value="two.id">
                                        {{two.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 3:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="three" name="three" id="three">
                                    <option value="0">All</option>
                                    <option v-for="three in threes.filter((a)=>{return a.level_two==this.two})" :value="three.id">
                                        {{three.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 4:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="four" name="four" id="four">
                                    <option value="0">All</option>
                                    <option v-for="four in fours.filter((a)=>{return a.level_three==this.three})"  :value="four.id">
                                        {{four.desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-2 form-control-label">LEVEL 5:</label>
                            <div class="col-sm-10">
                                <select class="form-control" v-model="filter" name="filter" id="filter">
                                    <option value="0">All</option>
                                    <option v-for="f in filters.filter((a)=>{return a.desc==this.four})" :value="f.id">
                                        {{f.type}}
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
            <button type="button" @click="showTable=false; showFilters=true; " class="btn btn-warning hidden-print">CHANGE SEARCH CRITERIA !</button>
            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>AFOHS <br>ACCOUNTS BALANCE </h5>
                <br>
            </div>
        <div class="scrollclasstable1">
            <div>


                <table class="table-striped  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-15p">SR #</th>
                        <th class="wd-20p">A/C CODE</th>
                        <th class="wd-40p">A/C TITLE</th>
                        <th class="wd-20p">DEBIT BALANCE</th>
                        <th class="wd-20p">CREDIT BALANCE</th>

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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

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
<style scoped>
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

</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "trialbalancedt",
    components: {
        Datepicker
    },
    data(){
        return{
            showModal: false,
            filters:[],
            filter:'0',
            ones:[],
            one:'0',
            twos:[],
            two:'0',
            threes:[],
            three:'0',
            fours:[],
            four:'0',
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
            showFilters:true,
            showTable:false,

        }
    },
    computed: {
        totals() {
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
        }
    },
    methods:{
        updatesdata(d){
            this.ssdata={
                start_date:this.start_date,
                end_date:this.end_date,
                mog:d.type,
                searchId:d.id,
                filter:this.filter,
            }
            this.k=this.k+1;
            this.showModal=true;
        },
        filterData(trials){
            let   x=trials;





            if (this.searchId){
                    x=x.filter((a)=>{return a.id==this.searchId});
            }if (this.sign!=0){
                    x=x.filter((a)=>{if(this.sign==1){
                       return a.debit-a.credit>0
                    }
                    else if(this.sign==2){
                            return a.debit-a.credit<0
                        }});
            }
            if(this.mog!=5) {

                x=x.filter((a)=>{

                   return  a.type==this.mog;
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
        sliceP(trials){
            // console.log(123);
            this.trialsM=trials;
            return  trials.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/finance-and-management/accounts-balance/acc_balance_init_vue?start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&end_date='+(this.end_date?moment(this.end_date).format('YYYY-MM-DD'):'')+'&filter='+this.filter).then(result=>{
                let data=result.data;

                this.filters=data.filters;
                this.ones=data.ones;
                this.twos=data.twos;
                this.threes=data.threes;
                this.fours=data.fours;
                this.trials=data.trials;
                this.trialsR=data.trials;
                this.leng=data.trials.length;
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

    },
    mounted() {
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

