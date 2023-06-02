<template>
    <div>
        <vue-snotify></vue-snotify>

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title">COA LEDGERS:
                                      <a target="_blank" :href="'/finance-and-management/coa-ledgers-vue'+'?'+'start_date=' + this.ssdata.start_date+'?'+'end_date=' + this.ssdata.end_date+'?'+'accsearchid=' + this.ssdata.code+'?'+'accsearch=' + this.ssdata.name">  <button type="button" title="Print"
                                                class="btn btn-danger btn-sm hidden-print"><i class="fa fa-print"></i></button></a>
                                    </h5>


                                    <button type="button" class="close" @click="showModal=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <coaledgersdt :sdata="ssdata" v-if="ssdata" :key="'am'+k"></coaledgersdt>
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
            <div class="col-lg">

                <div class="form-group" v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">

                    <input  v-model="unitsearch" name="unitsearch" id="unitsearch" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Unit...">

                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="unitsearchid"     name="unitsearchid" placeholder="Search by Unit...">

                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="searchedunits.length>0 && unitsearch!=''" >

                        <li  :class="'fbb fba'+key"  @click="unitdatavalue(c.id)"  v-on:keyup.enter="unitdatavalue(c.id)" v-for="(c,key) in searchedunits">
                            <a href="javascript:void(0)">{{c.code}} - {{c.name}} (<template v-if="ccs.filter(function(a){return a.code==c.desc})[0]">{{ccs.filter(function(a){return a.code==c.desc})[0].name}}</template>)</a>
                        </li>

                    </ul>
                </div>

            </div>

            <div class="col-lg">
                <div class="form-group has-search"  v-on:keydown.up.prevent="udf4(1)" v-on:keydown.down.prevent="udf4(0)">
                    <input  type="text" class="form-control typeahead" autocomplete="off" v-model="accsearch"     name="accsearch" id="accsearch" placeholder="Search COA...">
                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="accsearchid"     name="accsearchid" id="accsearchid" placeholder="Search COA...">
                    <ul id="areabox5" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.accsearch && searchedaccounts.length>0">

                        <li class="fbb" :class="'ccs'+key" @click="accountdatavalue(itd.id)" v-for="(itd,key) in searchedaccounts.filter((a)=>{return a.cost_center==this.unitsearchid})">
                            <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-lg">
                <div>

                    <datepicker  :disabledDates="disabledDates" v-model="start_date" placeholder="From (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                   <datepicker :disabledDates="disabledDates" v-model="end_date" placeholder="To (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>



        </div>


<!--        <div class="row">
            <div class="col-sm-12">
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total  Amount:
                </button>
            </div>

            </div>
        </div>-->


        <div class="row no-printme">
            <div class="col-sm-12">
                <div>
                    <button  v-on:click="sign=1" class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Advance Amount: {{totals.paid_amount | numFormat }}
                    </button>
                </div>
                <div>
                    <button v-on:click="sign=2"  class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Pending Amount: {{totals.total | numFormat }}
                    </button>
                </div>  <div>
                <button v-on:click="sign=0"  class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">All: {{ (totals.paid_amount -totals.total) | numFormat }}
                </button>
            </div>
            </div>
        </div>

        <div class="scrollclasstable1">
            <div>
                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-10p">SR #</th>
                        <th class="wd-25p">NAME</th>
                        <th class="wd-15p">CODE</th>
                        <th class="wd-20p">DEBIT</th>
                        <th class="wd-20p">CREDIT</th>
                        <th class="wd-20p">BALANCE</th>

                   <th class="wd-10p hidden-print">INFO</th>

                    </tr>
                    </thead>

                    <tbody :style="'font-size:15px'">


                    <tr v-for="(tr,key) in

              cm=sliceP(
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
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{tr.code}}</td>

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
    name: "coatrialbalancedt",
    components: {
        Datepicker
    },
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            types:[],
            type:'0',
            page:1,
            pagelength:50,
            leng:0,
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
            sign:0,
            fkey:-1,
            ffkey:0,
            k:0,
            showModal: false,

            ccs:[],
            searchedunits:[],
            searchedaccounts:[],
            unitalreadySearched:false,
            accountalreadySearched:false,
            unitsearch:'',
            accsearch:'',
            unitsearchid:'',
            accsearchid:'',

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
        fup(){

        },fdown(){
            console.log(1)

        },
        udf3(event){

            if(event==0){
                if(this.fkey!=this.searchedunits.length){

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




        },udf4(event){

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
        unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.unitsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.unitsearch=a.name })

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
                    this.unitsearch=data.name;
                    this.unitsearchid=data.code;

                }
            });
        },
        accountdata(){
            this.$http.post('/search/coa/coaaccountdatalike',{searchid:this.accsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.accsearch=a.name})

                if(data){

                    this.searchedaccounts=data;

                }
            });
        },
        accountdatavalue(val,m){
            this.searchedaccounts=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/coaaccountdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.accountalreadySearched=true;
                    this.accsearch=data.name;
                    this.accsearchid=data.code;

                }
            });
        },
        updatesdata(d){
            this.ssdata={
                start_date:this.start_date,
                end_date:this.end_date,
                code:d.code,
                name:d.name,
            }
            this.k=this.k+1;
            this.showModal=true;
        },
        filterData(trials){
            let   x=trials;

            if (this.unitsearch){
                x=x.filter((a)=>{return a.cost_center==this.unitsearchid});
            }
            if (this.accsearch){
                x=x.filter((a)=>{return a.code==this.accsearchid});
            }
            if (this.sign!=0){
                x=x.filter((a)=>{if(this.sign==1){
                    return a.debit-a.credit>0
                }
                else if(this.sign==2){
                    return a.debit-a.credit<0
                }});
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
            let filter='';
            if(this.start_date){
                filter+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }
            if(this.end_date){
                filter+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');

            }
            this.$http.get('/finance-and-management/coa-trial-balance/acc_init_vue?1=1'+filter).then(result=>{
                let data=result.data;

                this.ccs=data.ccs;
                this.types=data.types;
                this.trials=data.trials;
                this.trialsR=data.trials;
                this.leng=data.trials.length;
            })
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
        accsearch:function(){
            if(this.accsearch.length==0){
                this.accountalreadySearched=false;
            }
            if(!this.accountalreadySearched){
                this.accountdata();
            }
        },
        start_date:function(){
            this.init();
        },
            end_date:function(){
            this.init();
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

